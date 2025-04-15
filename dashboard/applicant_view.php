<?php
session_start();
require_once 'db.php';
require_once 'mailer.php';
require_once 'utils/generate_admission_letter.php';
require_once 'utils/send_admission_email.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    header("Location: ../index.php");
    exit;
}

$adminId = $_SESSION['user_id'];
$adminName = $_SESSION['name'];
$role = $_SESSION['role'];
$applicantId = $_GET['id'] ?? null;

if (!$applicantId) {
    echo "<p class='text-center mt-10 text-red-600 font-bold'>No applicant ID provided.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $newStatus = $_POST['action'] === 'admit' ? 'admitted' : 'rejected';
    $comment = $_POST['comment'] ?? '';

    $update = $pdo->prepare("UPDATE applications SET status = ? WHERE user_id = ?");
    $update->execute([$newStatus, $applicantId]);

    $log = $pdo->prepare("INSERT INTO reviews_audit (reviewer_id, reviewer_name, applicant_id, decision, comment)
                          VALUES (?, ?, ?, ?, ?)");
    $log->execute([$adminId, $adminName, $applicantId, $newStatus, $comment]);

    if ($newStatus === 'admitted') {
        generateAdmissionLetter($applicantId, $pdo);
        sendAdmissionEmail($applicantId, $pdo);
    } else {
        // Send rejection email
        $getUser = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ?");
        $getUser->execute([$applicantId]);
        $user = $getUser->fetch();

        if ($user) {
            $first = htmlspecialchars($user['first_name']);
            $email = $user['email'];

            $subject = "Application Decision - Adullam Seminary";
            $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

            $body = "
            <div style='font-family:Segoe UI,sans-serif;max-width:600px;margin:auto;padding:24px;background:#f9fafb;border-radius:10px;border:1px solid #e0e0e0;'>
              <div style='text-align:center;'>
                <img src='https://adullam.ng/assets/logo.png' alt='Adullam Seminary' style='height:70px;margin-bottom:10px;' />
                <h2 style='color:#6B21A8;'>Adullam Seminary Admissions</h2>
              </div>
              <p style='font-size:16px;color:#111;'>Dear <strong>$first</strong>,</p>
              <p style='font-size:15px;color:#333;line-height:1.6;'>
                We regret to inform you that your application has not been successful at this time.
              </p>
              <p style='font-size:15px;color:#333;line-height:1.6;'>
                You may reach out to us for further clarification or consider applying again in the future.
              </p>
              <hr style='margin:30px 0;'>
              <p style='font-size:13px;color:#888;text-align:center;'>
                For questions, contact <a href='mailto:admissions@adullam.ng' style='color:#6B21A8;'>admissions@adullam.ng</a><br/>
                &copy; " . date('Y') . " Adullam Seminary. All rights reserved.
              </p>
            </div>
            ";

            sendMail($email, $first, $subject, $body);
        }
    }

    header("Location: applicant_view.php?id=$applicantId&status_updated=1");
    exit;
}

// The rest of the original file content (fetching details, rendering the page) remains unchanged..
function fetchData($pdo, $table, $userId)
{
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

$statusStmt = $pdo->prepare("SELECT status FROM applications WHERE user_id = ?");
$statusStmt->execute([$applicantId]);
$appStatus = $statusStmt->fetchColumn() ?: 'in_progress';

$appDetails   = fetchData($pdo, 'application_details', $applicantId);
$personalInfo = fetchData($pdo, 'application_personal', $applicantId);
$churchInfo   = fetchData($pdo, 'application_church', $applicantId);
$autoInfo     = fetchData($pdo, 'application_autobiography', $applicantId);
$reference    = fetchData($pdo, 'application_references', $applicantId);
$docs         = fetchData($pdo, 'application_documents', $applicantId);

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

function renderTable($title, $data)
{
    echo "<div class='mt-8'>
        <h3 class='text-lg font-bold text-purple-700 mb-2'>$title</h3>
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
    <meta charset="UTF-8">
    <title>View Applicant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-50 text-gray-800">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-4 text-center">📋 Applicant Review Panel</h1>

            <?php if (isset($_GET['status_updated'])): ?>
                <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4 text-center">
                    Application status updated and email sent.
                </div>
            <?php endif; ?>

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
                        <h2 class="text-xl font-semibold">
                            <?= htmlspecialchars($appDetails['full_name'] ?? 'Applicant') ?></h2>
                        <p class="text-sm text-gray-600">Status:
                            <span class="uppercase text-purple-700 font-semibold"><?= $appStatus ?></span>
                        </p>
                    </div>
                </div>

                <?php
                if ($appDetails) renderTable('Program Details', $appDetails);
                if ($personalInfo) renderTable('Personal Information', $personalInfo);
                if ($churchInfo) renderTable('Church Information', $churchInfo);
                if ($autoInfo) renderTable('Autobiography', $autoInfo);
                if ($reference) renderTable('References', $reference);
                ?>

                <div class="mt-8">
                    <h3 class="text-lg font-bold text-purple-700 mb-2">📎 Uploaded Documents</h3>
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

                <?php if ($appStatus === 'submitted'): ?>
                    <form method="POST" class="mt-10 space-y-4">
                        <div>
                            <label for="comment" class="text-sm font-medium text-gray-700">📜 Review Comments</label>
                            <textarea name="comment" id="comment" rows="4" class="w-full border rounded p-3 mt-1"
                                placeholder="Write any notes or comments..."></textarea>
                        </div>
                        <div class="flex gap-4 justify-center">
                            <button name="action" value="admit"
                                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                ✅ Admit Applicant
                            </button>
                            <button name="action" value="reject"
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                                ❌ Reject Applicant
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

                <div class="mt-10 text-center">
                    <a href="applicants_list.php"
                        class="inline-block bg-purple-700 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-800">
                        ⬅ Back to Applicants List
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>