<?php
session_start();
require 'db.php';
require 'mailer.php';

$error = '';
$success = '';

// ✅ Validate user session
if (!isset($_SESSION['reset_user_id'], $_SESSION['email'])) {
    header("Location: forget_password.php");
    exit;
}

$user_id = $_SESSION['reset_user_id'];
$email = $_SESSION['email'];

// ✅ Resend OTP logic
if (isset($_GET['resend'])) {
    $stmt = $pdo->prepare("SELECT first_name FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        $otp = random_int(100000, 999999);

        $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at)
                      VALUES (?, ?, NOW() + INTERVAL 15 MINUTE)
                      ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at), used = 0")
            ->execute([$user_id, $otp]);

        // Send mail
        $subject = "=?UTF-8?B?" . base64_encode("🔐 OTP – Adullam Seminary Password Reset") . "?=";
        $body = "
        <div style='font-family:Segoe UI,sans-serif;padding:20px;background:#f9fafb;border-radius:8px'>
            <h2 style='color:#6B21A8;'>Adullam Seminary Password Reset</h2>
            <p>Hello <strong>{$user['first_name']}</strong>,</p>
            <p>Your new OTP is:</p>
            <div style='background:#6B21A8;color:#fff;font-size:24px;padding:10px 20px;
                        border-radius:8px;text-align:center;'>$otp</div>
            <p>This code will expire in 15 minutes.</p>
        </div>";

        sendMail($email, "Adullam Admissions", $subject, $body);

        $_SESSION['otp_feedback'] = ['type' => 'success', 'message' => 'A new OTP has been sent to your email.'];
        header("Location: verify_reset_otp.php");
        exit;
    }
}

// ✅ Handle OTP form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');

    if (!$otp) {
        $_SESSION['otp_feedback'] = ['type' => 'error', 'message' => 'OTP is required.'];
        header("Location: verify_reset_otp.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM password_resets 
                           WHERE user_id = ? AND token = ? AND used = 0 AND expires_at >= NOW()");
    $stmt->execute([$user_id, $otp]);
    $row = $stmt->fetch();

    if ($row) {
        // ✅ Valid OTP
        $_SESSION['otp_verified'] = true;
        $_SESSION['active_token'] = $otp;

        header("Location: reset_password_otp.php?token=" . $_SESSION['active_token']);

        exit;
    } else {
        $_SESSION['otp_feedback'] = ['type' => 'error', 'message' => 'Invalid or expired OTP.'];
        header("Location: verify_reset_otp.php");
        exit;
    }
}

// ✅ Feedback from session
$feedback = $_SESSION['otp_feedback'] ?? null;
unset($_SESSION['otp_feedback']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Verify OTP - Adullam Seminary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-purple-800 text-center mb-4">🔐 Verify OTP</h2>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Enter the OTP sent to your email</label>
                <input type="text" name="otp" maxlength="6" pattern="\d{6}" required
                    class="w-full px-4 py-2 border rounded-md text-center text-lg tracking-widest"
                    placeholder="123456" />
            </div>

            <button type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded font-medium transition">
                ✅ Verify OTP
            </button>

            <div class="text-sm text-center mt-4 text-gray-700">
                Didn't receive the OTP? <a href="?resend=1" class="text-purple-700 underline">Resend OTP</a>
            </div>
        </form>

        <a href="forget_password.php" class="block text-center text-sm text-purple-600 mt-4">← Go back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($feedback): ?>
        <script>
            Swal.fire({
                icon: '<?= $feedback['type'] ?>',
                title: '<?= $feedback['type'] === 'success' ? 'Success!' : 'Oops!' ?>',
                text: '<?= addslashes($feedback['message']) ?>',
                confirmButtonColor: '#6B21A8'
            });
        </script>
    <?php endif; ?>

</body>

</html>