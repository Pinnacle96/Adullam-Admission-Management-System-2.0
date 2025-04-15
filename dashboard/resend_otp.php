<?php
session_start();
date_default_timezone_set('Africa/Lagos'); // ✅ fix timezone mismatch
require 'db.php';
require 'mailer.php';

function respond($status, $message)
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

$email = $_SESSION['email'] ?? null;

if (!$email) {
    respond('error', 'Session expired. Please register again.');
}

// Get user
$stmt = $pdo->prepare("SELECT id, first_name, last_name FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    respond('error', 'User not found.');
}

$user_id = $user['id'];
$first = $user['first_name'];
$last = $user['last_name'];

// Generate new OTP
$otp = random_int(100000, 999999);
$expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

$stmt = $pdo->prepare("INSERT INTO email_verification_otp (user_id, otp, expires_at) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $otp, $expires]);

// Send email again
$subject = "Your One-Time Passcode (OTP) – RCN Theological Seminary - Adullam Verification";

$body = "
  <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
    <h2 style='color: #673A8B;'>Dear $first,</h2>

    <p style='font-size: 16px; color: #333;'>
      Thank you for choosing <strong>RCN Theological Seminary - Adullam</strong>.
    </p>

    <p style='font-size: 15px; color: #444;'>
      Your new One-Time Passcode (OTP) for email verification is:
    </p>

    <div style='text-align: center; padding: 20px 0;'>
      <h1 style='font-size: 38px; letter-spacing: 6px; color: #673A8B;'>$otp</h1>
      <p style='color: #888;'>This code is valid for <strong>10 minutes</strong>.</p>
    </div>

    <p style='font-size: 15px; color: #555;'>
      If you didn’t request this, you can safely ignore this message.
    </p>

    <p style='margin-top: 30px; font-size: 14px;'>
      May God's wisdom and grace guide your journey.<br/>
      <strong>Adullam Seminary Admissions</strong><br/>
      📧 support@adullam.ng<br/>
      🌐 <a href='https://adullam.ng'>https://adullam.ng</a>
    </p>
  </div>
";


$sent = sendMail($email, "$first $last", $subject, $body);

if (!$sent) {
    respond('error', 'Failed to resend OTP. Try again.');
}

respond('success', 'A new OTP has been sent to your email.');
