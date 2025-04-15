<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// ✅ Respond Helper
function respond($status, $message, $data = [])
{
    echo json_encode([
        'status' => $status,
        'message' => $message,
        ...$data
    ]);
    exit;
}

// ✅ Debug (remove in production)
file_put_contents('debug.txt', print_r($_POST, true));

// ✅ Clean Input
$email = trim($_POST['login_email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {
    respond('error', 'Email and password are required.');
}

// ✅ Check User Exists
$stmt = $pdo->prepare("SELECT id, first_name, email, role, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    respond('error', 'Invalid email or password.');
}

// 🔐 Password Check
if (!password_verify($password, $user['password'])) {
    respond('error', 'Invalid email or password.');
}

// ✅ Check Email Verification
$verifyStmt = $pdo->prepare("SELECT verified FROM email_verification_otp WHERE user_id = ?");
$verifyStmt->execute([$user['id']]);
$verify = $verifyStmt->fetch();

if (!$verify || !$verify['verified']) {
    respond('error', 'Email not verified. Please verify your email first.');
}

// ✅ Set Session
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
$_SESSION['name'] = $user['first_name'];
$_SESSION['role'] = $user['role'] ?? 'student';

switch ($user['role']) {
    case 'admin':
        $redirect = 'admin_dashboard.php';
        break;

    case 'superadmin':
        $redirect = 'superadmin_dashboard.php';
        break;

    case 'student':
    default:
        $appStmt = $pdo->prepare("SELECT current_level, submitted FROM applications WHERE user_id = ?");
        $appStmt->execute([$user['id']]);
        $application = $appStmt->fetch();

        $_SESSION['has_application'] = $application ? true : false;
        $_SESSION['current_level'] = $application['current_level'] ?? 1;

        $submitted = $application['submitted'] ?? 0;
        $level = $application['current_level'] ?? 1;

        // ✅ Route based on state
        if ($submitted) {
            $redirect = 'dashboard.php';
        } elseif ($level == 1) {
            // First-timer should go to student_dashboard to read application info
            $redirect = 'student_dashboard.php';
        } else {
            // Continue at current form level
            $maxFormLevel = 6;
            $redirect = "form_level" . min($level, $maxFormLevel) . ".php";
        }
        break;
}

respond('success', 'Login successful. Redirecting...', ['redirect' => $redirect]);
