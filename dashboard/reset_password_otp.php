<?php
session_start();
require 'db.php';

// 🚫 Redirect if logged in
// ✅ Block access if logged in and not in OTP flow — redirect based on role
if (isset($_SESSION['user_id']) && !isset($_SESSION['otp_verified'])) {
    $role = $_SESSION['role'] ?? 'student'; // default to student just in case

    switch ($role) {
        case 'admin':
            header("Location: admin_dashboard.php");
            break;
        case 'superadmin':
            header("Location: superadmin_dashboard.php");
            break;
        case 'student':
        default:
            header("Location: dashboard.php");
            break;
    }
    exit;
}


$error = '';
$success = '';

// ⛔ OTP token check
$otp = trim($_GET['token'] ?? '');
if (!$otp) {
    $error = "Invalid or missing OTP.";
} else {
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND used = 0 AND expires_at >= NOW()");
    $stmt->execute([$otp]);
    $reset = $stmt->fetch();
    if (!$reset) {
        $error = "Invalid or expired OTP.";
    }
}

// ✅ Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($reset['user_id'])) {
    $newPass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($newPass !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $newPass)) {
        $error = "Password must meet all strength rules.";
    } else {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);

        // 🔐 Update password
        $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hashed, $reset['user_id']]);

        // 🔒 Mark OTP as used
        $pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?")->execute([$reset['id']]);

        // 🧠 Optional: clear all sessions (auto logout)
        $pdo->prepare("DELETE FROM user_sessions WHERE user_id = ?")->execute([$reset['user_id']]);

        // 🕵️‍♂️ Audit log
        $stmt = $pdo->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address, user_agent)
                               VALUES (?, 'Password Reset', 'Password successfully changed', ?, ?)");
        $stmt->execute([
            $reset['user_id'],
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);

        $success = "Password reset successful. You may now log in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - Adullam Seminary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-xl font-bold text-purple-700 mb-4 text-center">🔒 Reset Your Password</h2>

        <form method="POST" class="space-y-4" onsubmit="return validatePassword()">
            <div>
                <label class="block text-sm text-gray-700">New Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded focus:outline-purple-600" required>
            </div>
            <div>
                <label class="block text-sm text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="w-full px-4 py-2 border rounded focus:outline-purple-600" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="show" onclick="togglePass()" class="mr-2">
                <label for="show" class="text-sm text-gray-600">Show Password</label>
            </div>

            <ul id="strengthTips" class="text-sm text-gray-600 list-disc pl-5 space-y-1 hidden">
                <li id="length" class="text-gray-500">At least 8 characters</li>
                <li id="upper" class="text-gray-500">At least one uppercase letter</li>
                <li id="lower" class="text-gray-500">At least one lowercase letter</li>
                <li id="digit" class="text-gray-500">At least one number</li>
                <li id="symbol" class="text-gray-500">At least one special character</li>
            </ul>

            <button type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded shadow font-semibold">
                ✅ Reset Password
            </button>
        </form>
    </div>

    <script>
        function togglePass() {
            ['password', 'confirm_password'].forEach(id => {
                const input = document.getElementById(id);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        }

        function validatePassword() {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!regex.test(pass)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Weak Password',
                    text: 'Password must meet all strength requirements.',
                    confirmButtonColor: '#6B21A8'
                });
                return false;
            }

            if (pass !== confirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mismatch',
                    text: 'Passwords do not match.',
                    confirmButtonColor: '#6B21A8'
                });
                return false;
            }

            return true;
        }

        const passwordField = document.getElementById('password');
        const tips = {
            length: document.getElementById('length'),
            upper: document.getElementById('upper'),
            lower: document.getElementById('lower'),
            digit: document.getElementById('digit'),
            symbol: document.getElementById('symbol'),
        };

        passwordField.addEventListener('input', () => {
            const val = passwordField.value;
            document.getElementById('strengthTips').classList.remove('hidden');

            tips.length.classList.toggle('text-green-600', val.length >= 8);
            tips.upper.classList.toggle('text-green-600', /[A-Z]/.test(val));
            tips.lower.classList.toggle('text-green-600', /[a-z]/.test(val));
            tips.digit.classList.toggle('text-green-600', /\d/.test(val));
            tips.symbol.classList.toggle('text-green-600', /[\W_]/.test(val));
        });

        <?php if (!empty($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '<?= addslashes($error) ?>',
                confirmButtonColor: '#6B21A8'
            });
        <?php elseif (!empty($success)): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= addslashes($success) ?>',
                confirmButtonColor: '#6B21A8'
            }).then(() => {
                window.location.href = 'index.php';
            });
        <?php endif; ?>
    </script>
</body>

</html>