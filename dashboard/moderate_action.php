<?php
session_start();
require_once 'db.php';
require_once 'mailer.php';
require_once 'utils/generate_admission_letter.php';
require_once 'utils/send_admission_email.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    die("⛔ Unauthorized access.");
}

$userId = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$userId || !in_array($action, ['admit', 'reject'])) {
    die("⚠️ Invalid request.");
}

$newStatus = $action === 'admit' ? 'admitted' : 'rejected';

// Update application status
$pdo->prepare("UPDATE applications SET status = ?, reviewed_by = ?, reviewed_at = NOW() WHERE user_id = ?")
    ->execute([$newStatus, $_SESSION['name'], $userId]);

// Insert into audit log
$pdo->prepare("INSERT INTO audit_logs (user_id, action, actor_name, created_at)
               VALUES (?, ?, ?, NOW())")
    ->execute([$userId, $newStatus, $_SESSION['name']]);

// Generate admission letter + email if admitted
if ($newStatus === 'admitted') {
    generateAdmissionLetter($userId, $pdo);
    sendAdmissionEmail($userId, $pdo);
} else {
    // Send rejection email
    $stmt = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user) {
        $first = htmlspecialchars($user['first_name']);
        $email = $user['email'];
        $subject = "❌ Admission Status – Adullam Seminary";
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        $body = "
        <div style='font-family:Segoe UI, sans-serif; max-width:600px; margin:auto; background:#f9fafb; padding:24px; border:1px solid #eee; border-radius:10px;'>
            <div style='text-align:center;'>
                <img src='https://adullam.ng/assets/img/logo1.png' alt='Adullam Seminary' style='height:60px;' />
                <h2 style='color:#6B21A8; margin-top:10px;'>RCN Theological Seminary – Adullam</h2>
            </div>
            <p style='font-size:15px; color:#333;'>Dear <strong>$first</strong>,</p>
            <p style='font-size:15px; color:#333; line-height:1.6;'>
                We appreciate your interest and the time invested in your application to Adullam Seminary.
                After careful review, we regret to inform you that your application was not successful.
            </p>
            <p style='font-size:15px; color:#333; line-height:1.6;'>
                Please know that this decision was not made lightly, and we encourage you to consider reapplying in the future.
            </p>
            <p style='font-size:15px; color:#333;'>Thank you for choosing Adullam.</p>
            <p style='font-size:15px; color:#333; margin-bottom:20px;'>Warm regards,<br />
            <strong>Adullam Admissions Committee</strong></p>
            <hr style='margin:20px 0; border:none; border-top:1px solid #ddd;' />
            <p style='font-size:13px; color:#888; text-align:center;'>
                For questions, contact <a href='mailto:admissions@adullam.ng' style='color:#6B21A8;'>admissions@adullam.ng</a><br />
                © " . date('Y') . " Adullam Seminary – All rights reserved.
            </p>
        </div>";

        sendMail($email, $first, $subject, $body);
    }
}

// ✅ Done
header("Location: moderate_applications.php?success=1");
exit;
