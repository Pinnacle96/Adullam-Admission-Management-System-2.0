<?php
session_start();
require 'db.php';
require 'mailer.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Prevent duplicate final submission
$check = $pdo->prepare("SELECT admission_no FROM applications WHERE user_id = ? AND submitted = 1");
$check->execute([$user_id]);
if ($check->fetchColumn()) {
    header("Location: dashboard.php");
    exit;
}

// 🎯 Generate custom admission number format ADM/JN/2025/XXXX
$last = $pdo->query("SELECT COUNT(*) FROM applications WHERE admission_no IS NOT NULL")->fetchColumn();
$nextSerial = str_pad((int)$last + 1, 4, '0', STR_PAD_LEFT);
$admissionNo = "ADM/JUN/2025/" . $nextSerial;

// ✅ Mark as submitted and assign admission number
$pdo->prepare("UPDATE applications SET submitted = 1, status = 'submitted', admission_no = ?, submitted_at = NOW() WHERE user_id = ?")
    ->execute([$admissionNo, $user_id]);

// 📧 Fetch user email + program
$stmt = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$progStmt = $pdo->prepare("SELECT program, ma_focus FROM application_details WHERE user_id = ?");
$progStmt->execute([$user_id]);
$progData = $progStmt->fetch();
$program = $progData['program'];
$ma_focus = $progData['ma_focus'] ?? '';


// 📬 Build email
$subject = "✅ Application Submission Confirmation - RCN Theological Seminary";
$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

$first = htmlspecialchars($user['first_name']);
$admissionNo = htmlspecialchars($admissionNo); // Sanitize admission number
$program = htmlspecialchars($program); // Sanitize program
$portalLink = '<a href="https://adullam.ng" style="color:#6B21A8;text-decoration:underline;">https://adullam.ng</a>';

$body = "
<div style=\"max-width:600px;margin:auto;padding:20px;background-color:#f9fafb;
     font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;border-radius:8px;
     border:1px solid #eee;\">

  <div style=\"text-align:center;margin-bottom:20px;\">
    <img src=\"https://adullam.ng/assets/logo.png\" alt=\"Adullam Seminary\" style=\"height:80px;margin-bottom:10px;\" />
    <h2 style=\"color:#6B21A8;margin:0;\">RCN Theological Seminary - Adullam</h2>
  </div>

  <hr style=\"margin:20px 0;border:none;border-top:1px solid #ddd;\" />

  <p style=\"font-size:16px;color:#111;margin-bottom:15px;\">
    Dear <strong>$first</strong>,
  </p>

  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    We are pleased to confirm that your application has been successfully submitted to
    <strong>RCN Theological Seminary - Adullam</strong>.
  </p>

  <p style=\"font-size:15px;color:#333;\">
    <strong>Your Admission Number:</strong> $admissionNo
  </p>
  
<p style=\"font-size:15px;color:#333;\">
    <strong>Program:</strong> $program" .
    ($program === 'MA' ? " ($ma_focus)" : "") . "
</p>


  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    The admissions committee will carefully review your application within the next
    <strong>14 days</strong>.
  </p>";

if ($program === 'MA' || $program === 'PGDT') {
    $body .= "
  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    Please ensure that your <strong>official transcript</strong> is sent to our admissions email by your alma mater.
  </p>";
}

$body .= "
  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    To stay updated on your application status, kindly log in to our portal: $portalLink
  </p>

  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    Upon receiving your admission notice, you will be expected to pay at least
    <strong>60% of your tuition</strong> before resumption on <strong>June 23rd, 2025</strong>.
  </p>

  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    We trust God will provide all your needs as you embark on this academic journey.
  </p>

  <p style=\"font-size:15px;color:#333;line-height:1.6;\">
    Thank you for choosing Adullam.
  </p>

  <p style=\"font-size:15px;color:#333;line-height:1.6;margin-bottom:30px;\">
    Warm regards,<br />
    <strong>Adullam Admissions Committee</strong>
  </p>

  <hr style=\"margin:20px 0;border:none;border-top:1px solid #ddd;\" />

  <p style=\"font-size:13px;color:#888;text-align:center;\">
    For questions, contact <a href=\"mailto:admissions@adullam.ng\" style=\"color:#6B21A8;\">admissions@adullam.ng</a><br />
    © " . date('Y') . " Adullam Seminary – All rights reserved.
  </p>

</div>
";

// Debug: Log the email body
file_put_contents('email_body.txt', $body);

// 📬 Send email
sendMail($user['email'], $user['first_name'], $subject, $body);

// Debug: Log after sending
file_put_contents('email_sent.txt', 'Email sent to ' . $user['email']);

// ✅ Redirect to dashboard
header("Location: dashboard.php?submitted=1");
exit;
