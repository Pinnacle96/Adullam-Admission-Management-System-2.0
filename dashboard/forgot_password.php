<?php
session_start();
require 'db.php';
require 'mailer.php';

// ✅ Simple audit logger
function logAudit($pdo, $user_id, $action, $details = '')
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $stmt = $pdo->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address, user_agent)
        VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $action, $details, $ip, $agent]);
}

$feedbackType = '';
$feedbackMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!$email) {
        $feedbackType = 'error';
        $feedbackMessage = 'Please enter your email address.';
    } else {
        $stmt = $pdo->prepare("SELECT id, first_name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $feedbackType = 'error';
            $feedbackMessage = 'No account found with that email.';
        } else {
            // 🔁 Rate limit: check if >3 OTPs last hour
            $rate = $pdo->prepare("SELECT COUNT(*) FROM password_resets WHERE user_id = ? AND created_at >= NOW() - INTERVAL 1 HOUR");
            $rate->execute([$user['id']]);
            if ($rate->fetchColumn() >= 5) {
                $feedbackType = 'error';
                $feedbackMessage = 'Too many OTP requests. Please try again in an hour.';
                logAudit($pdo, $user['id'], 'OTP Throttled', 'Exceeded hourly reset limit');
            } else {
                // 🔐 Generate OTP
                $otp = random_int(100000, 999999);
                $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) 
                    VALUES (?, ?, NOW() + INTERVAL 15 MINUTE)
                    ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at), used = 0")
                    ->execute([$user['id'], $otp]);

                // ✉️ Send email
                $subject = "🔐 Password Reset OTP – Adullam Seminary";
                $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
                $body = "
                <div style='font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;
                    max-width:600px;margin:auto;padding:20px;background-color:#f9fafb;
                    border-radius:8px;border:1px solid #eee;'>
                    <div style='text-align:center;margin-bottom:30px;'>
                        <img src='https://adullam.ng/assets/img/logo1.png' alt='Adullam Seminary' style='height:60px;' />
                        <h2 style='color:#6B21A8;margin-top:10px;'>Adullam Seminary Password Reset</h2>
                    </div>
                    <p style='font-size:16px;color:#111;'>Hello <strong>{$user['first_name']}</strong>,</p>
                    <p style='font-size:15px;color:#333;line-height:1.6;'>
                        We received a request to reset your password. Use the OTP below. It is valid for 15 minutes.
                    </p>
                    <div style='text-align:center;margin:30px 0;'>
                        <div style='display:inline-block;padding:15px 25px;background:#6B21A8;
                            color:white;font-size:24px;letter-spacing:2px;border-radius:8px;font-weight:bold;'>
                            $otp
                        </div>
                    </div>
                    <p style='font-size:14px;color:#555;line-height:1.6;'>If you did not request this, ignore this email.</p>
                    <hr style='margin:30px 0;'>
                    <div style='font-size:13px;color:#888;text-align:center;'>
                        © " . date('Y') . " Adullam Seminary • admissions@adullam.ng • 
                        <a href='https://adullam.ng' style='color:#6B21A8;'>www.adullam.ng</a>
                    </div>
                </div>";

                sendMail($email, "Adullam Admissions", $subject, $body);
                logAudit($pdo, $user['id'], 'OTP Sent', 'Password reset OTP issued');

                $_SESSION['reset_user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['active_token'] = $otp; // ✅ Store OTP for later redirect

                $feedbackType = 'success';
                $feedbackMessage = 'OTP sent to your email. You will be redirected shortly.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Forgot Password – Adullam Seminary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../assets/img/favicon.png" />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">
        <!-- Logo + Title -->
        <div class="flex items-center space-x-3 mb-6">
            <img src="../assets/img/logo1.png" alt="Adullam Logo" class="h-12 w-12" />
            <div>
                <h1 class="text-2xl font-bold text-purple-800">Adullam Seminary</h1>
                <p class="text-sm text-gray-600">Forgot Password</p>
            </div>
        </div>

        <!-- Feedback Message -->
        <?php if (!empty($feedbackMessage)): ?>
            <div
                class="p-3 mb-4 rounded text-sm border 
        <?= $feedbackType === 'error' ? 'bg-red-100 text-red-700 border-red-300' : 'bg-green-100 text-green-700 border-green-300' ?>">
                <?= htmlspecialchars($feedbackMessage) ?>
            </div>
            <?php if ($feedbackType === 'success'): ?>
                <script>
                    setTimeout(() => {
                        window.location.href = 'verify_reset_otp.php';
                    }, 2000);
                </script>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Reset Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">Enter your registered email</label>
                <input type="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
            </div>
            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow">
                Send OTP
            </button>
        </form>

        <p class="text-xs text-center text-purple-700 mt-4">
            <a href="index.php" class="underline hover:text-purple-900">← Back to Login</a>
        </p>
    </div>
</body>

</html>