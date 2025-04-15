<?php
// session_start();
require 'db.php';
include 'dashboard_logic.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$statusStmt = $pdo->prepare("SELECT status FROM applications WHERE user_id = ?");
$statusStmt->execute([$user_id]);
$appStatus = $statusStmt->fetchColumn() ?: 'in_progress';
$isLocked = in_array($appStatus, ['submitted', 'admitted', 'rejected']);

// Get all form data
$details = $pdo->prepare("SELECT * FROM application_details WHERE user_id = ?");
$details->execute([$user_id]);
$appDetails = $details->fetch();

$personal = $pdo->prepare("SELECT * FROM application_personal WHERE user_id = ?");
$personal->execute([$user_id]);
$personalInfo = $personal->fetch();

$church = $pdo->prepare("SELECT * FROM application_church WHERE user_id = ?");
$church->execute([$user_id]);
$churchInfo = $church->fetch();

$auto = $pdo->prepare("SELECT * FROM application_autobiography WHERE user_id = ?");
$auto->execute([$user_id]);
$autoInfo = $auto->fetch();

$refs = $pdo->prepare("SELECT * FROM application_references WHERE user_id = ?");
$refs->execute([$user_id]);
$reference = $refs->fetch();

$doc = $pdo->prepare("SELECT * FROM application_documents WHERE user_id = ?");
$doc->execute([$user_id]);
$docs = $doc->fetch();

$passportUrl = $docs['passport'] ?? '';
$otherDocs = [
    'SSCE Certificate' => $docs['ssce_cert'] ?? '',
    'Birth Certificate' => $docs['birth_cert'] ?? '',
    'Origin Certificate' => $docs['origin_cert'] ?? '',
    'Recommendation Letter' => $docs['recommendation'] ?? '',
    'Payment Proof' => $docs['payment_proof'] ?? '',
    'Degree Certificate' => $docs['degree_cert'] ?? '',
    'Transcript' => $docs['transcript'] ?? ''
];

// Function to display form sections
function renderTable($title, $data, $editLink, $isLocked)
{
    echo "<div class='mt-8'>
        <div class='flex justify-between items-center mb-2'>
            <h3 class='text-lg font-bold text-purple-700'>$title</h3>";
    if (!$isLocked) {
        echo "<a href='$editLink' class='text-sm text-purple-600 underline hover:text-purple-800'>✏️ Edit</a>";
    }
    echo "</div>
        <div class='grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 bg-gray-50 p-4 rounded-lg shadow'>";
    foreach ($data as $key => $value) {
        if (in_array($key, ['id', 'user_id'])) continue;
        echo "<div>
                <p class='text-xs text-gray-500 mb-1'>" . ucwords(str_replace('_', ' ', $key)) . "</p>
                <p class='text-sm font-medium text-gray-800 bg-white border px-3 py-1 rounded'>" . nl2br(htmlspecialchars($value)) . "</p>
              </div>";
    }
    echo "</div></div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Preview Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-50 text-gray-800">
    <?php include 'components/student_sidebar.php'; ?>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-purple-800 mb-4 text-center">📋 Preview Your Application</h1>

        <div class="bg-white shadow p-6 rounded-xl">
            <div class="flex flex-col sm:flex-row gap-6 items-center">
                <div class="w-40 h-40 overflow-hidden rounded-full border border-gray-300">
                    <?php if ($passportUrl): ?>
                        <img src="<?= $passportUrl ?>" alt="Passport Photo" class="object-cover w-full h-full">
                    <?php else: ?>
                        <div class="text-sm text-gray-400 flex items-center justify-center h-full">No Photo</div>
                    <?php endif; ?>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
                    <p class="text-sm text-gray-600">Please carefully review all provided information and uploaded files/documents. 

Verify that all details are accurate and complete or make any necessary edits at this stage. Note that once you have made your final submission, you will no longer be able to make changes to your application</p>
                    <p class="text-sm mt-2"><strong>Status:</strong> <span
                            class="text-purple-700 font-semibold uppercase"><?= $appStatus ?></span></p>
                </div>
            </div>

            <?php
            if ($appDetails) renderTable('Program Details', $appDetails, 'form_level1.php', $isLocked);
            if ($personalInfo) renderTable('Personal Information', $personalInfo, 'form_level2.php', $isLocked);
            if ($churchInfo) renderTable('Church Information', $churchInfo, 'form_level3.php', $isLocked);
            if ($autoInfo) renderTable('Autobiography', $autoInfo, 'form_level4.php', $isLocked);
            if ($reference) renderTable('References', $reference, 'form_level5.php', $isLocked);
            ?>

            <div class="mt-8">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-bold text-purple-700">📎 Uploaded Documents</h3>
                    <?php if (!$isLocked): ?>
                        <a href="form_level6.php" class="text-sm text-purple-600 underline hover:text-purple-800">✏️
                            Edit</a>
                    <?php endif; ?>
                </div>
                <ul class="space-y-2">
                    <?php foreach ($otherDocs as $label => $path): ?>
                        <?php if ($path): ?>
                            <li class="flex justify-between items-center border-b py-2">
                                <span><?= $label ?></span>
                                <a href="<?= $path ?>" download
                                    class="bg-purple-700 text-white px-3 py-1 text-sm rounded hover:bg-purple-800">Download</a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <form method="POST" action="<?= $isLocked ? 'dashboard.php' : 'submit_application.php' ?>" class="mt-10">
                <?php if (!$isLocked): ?>
                    <div class="bg-gray-100 p-4 rounded-md">
                        <label class="inline-flex items-start gap-3">
                            <input type="checkbox" name="agree" required class="mt-1">
                            <span class="text-sm">
                                I confirm that all information provided is accurate and truthful. I agree to the admission
                                terms.
                            </span>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="mt-6 flex justify-between items-center">
                    <?php if (!$isLocked): ?>
                        <a href="form_level6.php" class="text-purple-700 hover:underline">⬅ Back to Uploads</a>
                        <button type="submit"
                            class="bg-purple-700 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-800">Submit
                            Application</button>
                    <?php else: ?>
                        <div class="w-full text-center">
                            <a href="dashboard.php"
                                class="inline-block bg-purple-700 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-800">🏠
                                Return to Dashboard</a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

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

        if (localStorage.getItem('profile_updated')) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Your profile has been updated successfully.',
                confirmButtonColor: '#6B21A8'
            });
            localStorage.removeItem('profile_updated');
        }
    </script>
</body>

</html>