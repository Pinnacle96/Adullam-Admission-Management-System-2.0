<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT first_name, middle_name, last_name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$full_name = trim($user['first_name'] . ' ' . ($user['middle_name'] ?? '') . ' ' . $user['last_name']);

$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ?");
$stmt->execute([$user_id]);
$existing = $stmt->fetch();

if (!$existing) {
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, current_level) VALUES (?, 1)");
    $stmt->execute([$user_id]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $program = trim($_POST['program']);
    $ma_focus = $_POST['ma_focus'] ?? null;
    $mode = trim($_POST['mode']);

    $res_address = trim($_POST['res_address']);
    $res_city = trim($_POST['res_city']);
    $res_state = trim($_POST['res_state']);
    $res_country = trim($_POST['res_country']);

    $perm_address = trim($_POST['perm_address']);
    $perm_city = trim($_POST['perm_city']);
    $perm_state = trim($_POST['perm_state']);
    $perm_country = trim($_POST['perm_country']);

    $stmt = $pdo->prepare("INSERT INTO application_details 
    (user_id, gender, dob, program, ma_focus, mode_of_study, res_address, res_city, res_state, res_country,
     perm_address, perm_city, perm_state, perm_country)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    gender = VALUES(gender), dob = VALUES(dob), program = VALUES(program), ma_focus = VALUES(ma_focus),
    mode_of_study = VALUES(mode_of_study), res_address = VALUES(res_address), res_city = VALUES(res_city),
    res_state = VALUES(res_state), res_country = VALUES(res_country),
    perm_address = VALUES(perm_address), perm_city = VALUES(perm_city),
    perm_state = VALUES(perm_state), perm_country = VALUES(perm_country)");

    $stmt->execute([
        $user_id,
        $gender,
        $dob,
        $program,
        $ma_focus,
        $mode,
        $res_address,
        $res_city,
        $res_state,
        $res_country,
        $perm_address,
        $perm_city,
        $perm_state,
        $perm_country
    ]);

    if (isset($_POST['continue'])) {
        $pdo->prepare("UPDATE applications SET current_level = 2 WHERE user_id = ?")
            ->execute([$user_id]);
        echo "<script>window.location.href = 'form_level2.php';</script>";
    } else {
        echo "<script>
      localStorage.setItem('form1_saved', '1');
      window.location.href = 'form_level1.php';
    </script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application - Step 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-3xl">
        <h2 class="text-xl font-bold text-purple-800 mb-6 text-center">Step 1: Personal Information</h2>

        <form method="POST" class="space-y-6">
            <fieldset class="border border-gray-200 p-4 rounded-md">
                <legend class="text-sm font-semibold text-purple-700 px-2">👤 Personal Info</legend>
                <div class="space-y-4">
                    <input type="text" value="<?= htmlspecialchars($full_name) ?>" readonly
                        class="w-full px-4 py-2 bg-gray-100 border rounded-md cursor-not-allowed" />

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-700">Gender<span class="text-red-500">*</span></label>
                            <select name="gender" required
                                class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600">
                                <option value="">-- Select --</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-700">Date of Birth<span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="dob" required
                                class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Program Applying For<span
                                class="text-red-500">*</span></label>
                        <select name="program" id="program" required
                            class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600">
                            <option value="">-- Select Program --</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Diploma">Diploma</option>
                            <option value="B.Div">Bachelor of Divinity (B.Div)</option>
                            <option value="PGDT">Postgraduate Diploma (PGDT)</option>
                            <option value="MA">Master of Arts (MA)</option>
                        </select>
                    </div>

                    <div id="maFocusWrapper" class="hidden">
                        <label class="text-sm text-gray-700">MA Focus</label>
                        <select name="ma_focus"
                            class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600">
                            <option value="">-- Select MA Focus --</option>
                            <option value="MA Christian Apologetics">MA Christian Apologetics</option>
                            <option value="MA Biblical Studies (OT/NT)">MA Biblical Studies (OT/NT)</option>
                        </select>
                        <!-- <p id="maWarning" class="mt-2 text-xs text-red-600 font-medium hidden">
                            NOTE: FOR MASTERS APPLICANT (BIBLICAL STUDIES: OLD TESTAMENT & NEW TESTAMENT IS ONLY
                            AVAILABLE FOR ONSITE APPLICANT)
                        </p> -->
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Mode of Study<span class="text-red-500">*</span></label>
                        <select name="mode" required
                            class="w-full mt-1 px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600">
                            <option value="">-- Select --</option>
                            <option value="online">Online</option>
                            <option value="onsite">Onsite</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-gray-200 p-4 rounded-md">
                <legend class="text-sm font-semibold text-purple-700 px-2">📍 Residential Address</legend>
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="res_address" required placeholder="Address Line"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="res_city" required placeholder="City"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="res_state" required placeholder="State"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="res_country" required placeholder="Country"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
            </fieldset>

            <fieldset class="border border-gray-200 p-4 rounded-md">
                <legend class="text-sm font-semibold text-purple-700 px-2">🏡 Permanent Address</legend>
                <label class="block text-sm mb-2">
                    <input type="checkbox" id="copyAddress" class="mr-2"> Same as Residential Address
                </label>
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="perm_address" placeholder="Address Line"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="perm_city" placeholder="City"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="perm_state" placeholder="State"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                    <input type="text" name="perm_country" placeholder="Country"
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
            </fieldset>

            <div class="flex justify-between">
                <button type="submit" name="save"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg shadow">💾 Save</button>
                <button type="submit" name="continue"
                    class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-2 rounded-lg shadow">Next ➡</button>
            </div>

            <script>
                const programSelect = document.getElementById('program');
                const maFocusWrapper = document.getElementById('maFocusWrapper');
                const maWarning = document.getElementById('maWarning');

                programSelect.addEventListener('change', function() {
                    maFocusWrapper.classList.toggle('hidden', this.value !== 'MA');
                });

                document.querySelector('select[name="ma_focus"]').addEventListener('change', function() {
                    const selectedFocus = this.value;
                    maWarning.classList.toggle('hidden', !selectedFocus.includes('Biblical Studies'));
                });

                document.getElementById('copyAddress').addEventListener('change', function() {
                    if (this.checked) {
                        document.querySelector('input[name="perm_address"]').value = document.querySelector(
                            'input[name="res_address"]').value;
                        document.querySelector('input[name="perm_city"]').value = document.querySelector(
                            'input[name="res_city"]').value;
                        document.querySelector('input[name="perm_state"]').value = document.querySelector(
                            'input[name="res_state"]').value;
                        document.querySelector('input[name="perm_country"]').value = document.querySelector(
                            'input[name="res_country"]').value;
                    } else {
                        document.querySelectorAll('input[name^="perm_"]').forEach(el => el.value = '');
                    }
                });

                if (localStorage.getItem('form1_done')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Step 1 Complete!',
                        text: 'You can now continue your application.',
                        confirmButtonColor: '#6B21A8'
                    });
                    localStorage.removeItem('form1_done');
                }
                if (localStorage.getItem('form1_saved')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Your information has been saved.',
                        confirmButtonColor: '#6B21A8'
                    });
                    localStorage.removeItem('form1_saved');
                }
            </script>
</body>

</html>