<?php
session_start();
require 'db.php';

// 🌍 Set timezone to match your server/database
date_default_timezone_set('Africa/Lagos');

function respond($status, $message)
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// 🔐 Get email from session
$email = $_SESSION['email'] ?? null;
$otp = strval(trim($_POST['otp'] ?? '')); // force string comparison

if (!$email || !$otp) {
    respond('error', 'Missing OTP or session expired. Please register again.');
}

// 🔎 Find user by email
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    respond('error', 'User not found.');
}

$user_id = $user['id'];

// 🔐 Check OTP is correct, not used, and not expired
$stmt = $pdo->prepare("SELECT * FROM email_verification_otp 
  WHERE user_id = ? AND otp = ? AND expires_at > CURRENT_TIMESTAMP AND verified = 0
  ORDER BY id DESC LIMIT 1");
$stmt->execute([$user_id, $otp]);
$record = $stmt->fetch();

if (!$record) {
    // Optional: uncomment below to debug OTP values
    // $debug = $pdo->prepare("SELECT * FROM email_verification_otp WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    // $debug->execute([$user_id]);
    // print_r($debug->fetch()); exit;

    respond('error', 'Invalid or expired OTP.');
}

// ✅ Mark user + OTP as verified
$pdo->prepare("UPDATE users SET verified = 1 WHERE id = ?")->execute([$user_id]);
$pdo->prepare("UPDATE email_verification_otp SET verified = 1 WHERE id = ?")->execute([$record['id']]);

respond('success', 'Email verified! You can now log in.');
