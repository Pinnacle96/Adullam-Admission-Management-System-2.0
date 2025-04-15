<?php
session_start();
require_once 'db.php';
require_once 'mailer.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    die("Unauthorized access.");
}

$userId = $_GET['id'] ?? null;
if (!$userId) die("No applicant ID provided.");

// Fetch applicant
$studentStmt = $pdo->prepare("SELECT CONCAT_WS(' ', first_name, last_name) AS full_name FROM users WHERE id = ?");
$studentStmt->execute([$userId]);
$studentName = $studentStmt->fetchColumn();
if (!$studentName) die("Applicant not found.");

// Fetch all referees
$refs = $pdo->prepare("SELECT id, referee_name, referee_email, token FROM application_recommendations WHERE user_id = ?");
$refs->execute([$userId]);
$referees = $refs->fetchAll();

$sentCount = 0;
foreach ($referees as $r) {
    $link = "https://adullam.ng/recommendation.php?token={$r['token']}";

    $subject = "Recommendation Request for $studentName – Adullam Seminary";

    $body = "
    <div style='font-family:Arial,sans-serif;padding:20px;border:1px solid #ccc;border-radius:10px;max-width:600px;margin:auto'>
        <h2 style='color:#6B21A8;'>Dear {$r['referee_name']},</h2>
        <p>You have been listed as a referee for an applicant to <strong>RCN Theological Seminary – Adullam</strong>.</p>
        <p>Please complete the online recommendation form using the link below:</p>
        <div style='margin:20px 0; text-align:center;'>
            <a href='$link' style='background:#6B21A8;color:#fff;padding:12px 20px;text-decoration:none;border-radius:6px;display:inline-block;'>📝 Submit Recommendation</a>
        </div>
        <p>If you have questions, kindly contact <a href='mailto:admissions@adullam.ng'>admissions@adullam.ng</a></p>
        <p>Thank you for your time and support.</p>
        <p style='margin-top:30px;'>Sincerely,<br><strong>Adullam Admissions Office</strong></p>
        <hr style='margin-top:30px;'><p style='font-size:13px;color:#999;text-align:center'>© " . date('Y') . " Adullam Seminary</p>
    </div>";

    if (sendMail($r['referee_email'], $r['referee_name'], $subject, $body)) {
        $sentCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recommendation Resent</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sent!',
            html: 'Resent recommendation email to <strong><?= $sentCount ?></strong> referee(s).',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'recommendation_list.php';
        });
    </script>
</body>

</html>