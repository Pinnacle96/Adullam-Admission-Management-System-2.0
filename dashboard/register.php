<?php
session_start();
date_default_timezone_set('Africa/Lagos'); // ✅ fix timezone mismatch

// 🧠 Include your DB connection & PHPMailer mailer
require 'db.php';        // your PDO DB config
require 'mailer.php';    // PHPMailer setup

$regOpen = $pdo->query("SELECT value FROM settings WHERE `key` = 'registration_open'")->fetchColumn();
if ($regOpen != 1) {
    exit('🚫 Registration is currently closed by the Administrator.');
}

// 🛡️ Return JSON helper
function respond($status, $message)
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// 🧼 Get and clean inputs from form
$first = trim($_POST['first_name'] ?? '');
$middle = trim($_POST['middle_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// 🧪 Basic validation
if (!$first || !$last || !$email || !$phone) {
    respond('error', 'Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond('error', 'Invalid email address.');
}

// 🔍 Check if user already exists
$stmt = $pdo->prepare("SELECT id, verified FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && $user['verified']) {
    respond('error', 'Email is already registered and verified. Please log in.');
}

// ✅ Save user to database
if (!$user) {
    $stmt = $pdo->prepare("INSERT INTO users (first_name, middle_name, last_name, email, phone, verified) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->execute([$first, $middle, $last, $email, $phone]);
    $user_id = $pdo->lastInsertId();
} else {
    $user_id = $user['id']; // Unverified user re-attempting
}

// 🔐 Generate OTP
$otp = random_int(100000, 999999);
$expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// 💾 Save OTP
$stmt = $pdo->prepare("INSERT INTO email_verification_otp (user_id, otp, expires_at) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $otp, $expires_at]);

// 💌 Send OTP via email
$subject = "Your One-Time Passcode (OTP) for Adullam Seminary Verification";

$body = "
  <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ccc; border-radius: 10px;'>
    <h2 style='color: #673A8B;'>Dear $first,</h2>

    <p>Thank you for starting your journey with <strong>RCN Theological Seminary - Adullam</strong>.</p>

    <p>To proceed with your application, please verify your email address by entering the OTP below:</p>

    <div style='text-align: center; padding: 20px 0;'>
      <h1 style='font-size: 36px; color: #673A8B; letter-spacing: 5px;'>$otp</h1>
      <p style='color: #555;'>This code will expire in <strong>10 minutes</strong>.</p>
    </div>

    <p>If you did not initiate this registration, please disregard this message or contact our support team immediately.</p>

    <p>May God's grace guide your academic and spiritual journey.</p>

    <p style='margin-top: 30px;'>Sincerely,<br/>
    <strong>Adullam Seminary Admissions Team</strong><br/>
    📧 support@adullam.ng<br/>
    🌐 <a href='https://adullam.ng'>https://adullam.ng</a></p>
  </div>
";

if (!sendMail($email, "$first $last", $subject, $body)) {
    respond('error', 'Could not send email. Please try again.');
}

// ✅ Store email in session for verification step
$_SESSION['email'] = $email;

respond('success', 'OTP sent to your email. Please check and verify.');
