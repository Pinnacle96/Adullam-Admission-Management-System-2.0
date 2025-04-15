<?php
//session_start();
require 'db.php';
require 'dashboard_logic.php'; // make sure this sets $user and role-checking logic

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$full_name = trim($user['first_name'] . ' ' . ($user['middle_name'] ?? '') . ' ' . $user['last_name']);
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';
$dob = $user['dob'] ?? '';
$age = '';

if ($dob) {
    $birth = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birth)->y;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'components/student_sidebar.php'; ?>
    <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-6">🏨 Hostel Registration Form</h1>

        <form action="hostel_submit.php" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-4 sm:p-6 rounded-lg shadow w-full">
            <h2 class="text-lg font-semibold text-purple-700">👤 Personal Information</h2>
            <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="text-sm font-semibold text-purple-700"> Personal Info</legend>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" name="full_name" value="<?= htmlspecialchars($full_name) ?>" readonly class="bg-gray-100 px-4 py-2 border rounded w-full" />
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly class="bg-gray-100 px-4 py-2 border rounded w-full" />
                <input type="text" name="contact" value="<?= htmlspecialchars($phone)?>" required class="px-4 py-2 border rounded w-full" />
                <input type="text" name="econtact" placeholder="Emergency Contact Number" required class="px-4 py-2 border rounded w-full" />
                <select name="gender" required class="px-4 py-2 border rounded w-full">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <input type="text" name="blood" placeholder="Blood Group" class="px-4 py-2 border rounded w-full" />
                <input type="text" name="genotype" placeholder="Genotype" class="px-4 py-2 border rounded w-full" />
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($dob) ?>" class="mt-1 px-4 py-2 border rounded w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="text"name="age" id="age" value="<?= $age ?>" readonly class="mt-1 bg-gray-100 px-4 py-2 border rounded w-full" placeholder="Age" />
                </div>
                <div>
<label class="block text-sm font-medium text-gray-700">Nationality<span class="text-red-500">*</span></label>
                <select name="nationality" required class="px-4 py-2 border rounded w-full">
                    <option value="">Nationality</option>
                    <option value="Local">Local</option>
                    <option value="International">International</option>
                </select></div>
                <div>
<label class="block text-sm font-medium text-gray-700">Marital Status<span class="text-red-500">*</span></label>
                <select name="marital" class="px-4 py-2 border rounded w-full">
                    <option value="">Marital Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                </select></div>
                <input type="text" name="sname" placeholder="Spouse Name (if married)" class="px-4 py-2 border rounded w-full" />
                <input type="text" name="scont" placeholder="Spouse Contact (if married)" class="px-4 py-2 border rounded w-full" />
            </div>
</fieldset>
                <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="text-sm font-semibold text-purple-700"> Program Info</legend>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Program <span class="text-red-500">*</span></label>
                    <select name="program" id="program" required class="mt-1 px-4 py-2 border rounded w-full">
                        <option value="">-- Select Program --</option>
                        <option value="Certificate">Certificate</option>
                        <option value="Diploma">Diploma</option>
                        <option value="B.Div">Bachelor of Divinity (B.Div)</option>
                        <option value="PGDT">PGDT</option>
                    </select>
                </div>
                <div id="yearWrapper" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Academic Year</label>
                    <select name="academic_year" class="mt-1 px-4 py-2 border rounded w-full">
                        <option value="">-- Select Year --</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Semester <span class="text-red-500">*</span></label>
                    <select name="semester" required class="mt-1 px-4 py-2 border rounded w-full">
                        <option value="">-- Select Semester --</option>
                        <option value="First Semester">First Semester</option>
                        <option value="Second Semester">Second Semester</option>
                    </select>
                </div>
</fieldset>


            <h2 class="text-lg font-semibold text-purple-700 mt-4">📍 Address Info</h2>
            <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="text-sm font-semibold text-purple-700">🏠 Residential Address</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="res_address" id="res_address" placeholder="Address Line" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="res_city" id="res_city" placeholder="City" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="res_state" id="res_state" placeholder="State" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="res_country" id="res_country" placeholder="Country" required class="px-4 py-2 border rounded w-full" />
                </div>
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" id="copyAddress" class="mr-2"> Same as Permanent Address
                </label>
            </fieldset>

            <fieldset class="border border-gray-300 p-4 rounded">
                <legend class="text-sm font-semibold text-purple-700">🏡 Permanent Address</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="perm_address" id="perm_address" placeholder="Address Line" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="perm_city" id="perm_city" placeholder="City" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="perm_state" id="perm_state" placeholder="State" required class="px-4 py-2 border rounded w-full" />
                    <input type="text" name="perm_country" id="perm_country" placeholder="Country" required class="px-4 py-2 border rounded w-full" />
                </div>
            </fieldset>

            <h2 class="text-lg font-semibold text-purple-700 mt-4">👨‍👩‍👧‍👦 Guardian Info</h2>
            <fieldset class="border border-gray-300 p-4 rounded">
            <legend class="text-sm font-semibold text-purple-700">👨‍👩‍👧‍👦 Guardian Information</legend>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <input type="text" name="gname" placeholder="Guardian Name" required class="px-4 py-2 border rounded w-full" />
                <input type="text" name="grelation" placeholder="Relation" required class="px-4 py-2 border rounded w-full" />
                <input type="text" name="gcontact" placeholder="Guardian Contact" required class="px-4 py-2 border rounded w-full" />
            </div>
</fieldset>
            <h2 class="text-lg font-semibold text-purple-700 mt-4">🧾 Uploads</h2>
            <fieldset class="border border-gray-300 p-4 rounded">
            <legend class="text-sm font-semibold text-purple-700">🧾 Document Uploads</legend>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600">Passport Photo (JPEG/PNG/PDF, max 900KB)</label>
                    <input type="file" name="passport" accept=".jpg,.jpeg,.png,.pdf" required class="w-full border rounded px-4 py-2 mt-1" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Proof of Hostel Fee Payment</label>
                    <input type="file" name="fees" accept=".jpg,.jpeg,.png,.pdf" required class="w-full border rounded px-4 py-2 mt-1" />
                </div>
                <input type="text" name="fee" placeholder="Amount Paid" required class="px-4 py-2 border rounded w-full" />
            </div>
</fieldset>
            <button type="submit" name="submit" class="mt-6 w-full bg-purple-700 text-white py-3 rounded shadow hover:bg-purple-800">📨 Submit Hostel Registration</button>
        </form>
    </main>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const programSelect = document.getElementById('program');
    const yearWrapper = document.getElementById('yearWrapper');
    const dobInput = document.getElementById('dob');
    const ageField = document.getElementById('age');
    const copyCheck = document.getElementById('copyAddress');

    function toggleYearField() {
        const program = programSelect.value;
        yearWrapper.classList.toggle('hidden', !(program === 'Diploma' || program === 'B.Div'));
    }

    function calculateAge() {
        const dob = new Date(dobInput.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        ageField.value = age || '';
    }

    programSelect.addEventListener('change', toggleYearField);
    dobInput.addEventListener('change', calculateAge);

    copyCheck.addEventListener('change', () => {
        if (copyCheck.checked) {
            document.getElementById('perm_address').value = document.getElementById('res_address').value;
            document.getElementById('perm_city').value = document.getElementById('res_city').value;
            document.getElementById('perm_state').value = document.getElementById('res_state').value;
            document.getElementById('perm_country').value = document.getElementById('res_country').value;
        }
    });

    toggleYearField();

    // Sidebar toggle logic
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    if (toggleSidebar && sidebar) {
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 640 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }

    // ✅ Success alert after submission
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Your hostel registration has been submitted.',
        confirmButtonColor: '#6B21A8'
    });
    <?php endif; ?>
});
</script>

    
</body>
</html>