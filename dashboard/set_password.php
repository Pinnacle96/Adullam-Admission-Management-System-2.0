<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    // Backend password validation
    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/\d/', $password) ||
        !preg_match('/[\W_]/', $password)
    ) {
        $error = "Password must be at least 8 characters and include uppercase, lowercase, number, and symbol.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashed, $_SESSION['email']]);

        session_destroy();
        echo "<script>
      localStorage.setItem('pwSet', '1');
      window.location.href = 'index.php';
    </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Set Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <style>
        .strength-meter {
            height: 6px;
            border-radius: 4px;
            margin-top: 6px;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-xl font-bold text-purple-800 text-center mb-4">Set Your Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">Secure your account to continue.</p>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600 pr-10">
                    <button type="button" id="togglePassword"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-sm text-purple-600 hover:underline">Show</button>
                </div>
                <div id="strengthText" class="text-xs mt-1 text-gray-600"></div>
                <div id="strengthBar" class="strength-meter bg-gray-200">
                    <div id="strengthFill" class="h-full bg-red-400 w-0 rounded"></div>
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" required
                    class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600">
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow">Set
                Password</button>
        </form>
    </div>

    <!-- SweetAlert on success redirect -->
    <script>
        if (localStorage.getItem('pwSet')) {
            Swal.fire({
                icon: 'success',
                title: 'Password Set!',
                text: 'You can now log in.',
                confirmButtonColor: '#6B21A8'
            });
            localStorage.removeItem('pwSet');
        }

        const passwordInput = document.getElementById('password');
        const strengthText = document.getElementById('strengthText');
        const strengthBar = document.getElementById('strengthFill');
        const toggleBtn = document.getElementById('togglePassword');

        const criteria = {
            length: val => val.length >= 8,
            lowercase: val => /[a-z]/.test(val),
            uppercase: val => /[A-Z]/.test(val),
            number: val => /\d/.test(val),
            symbol: val => /[!@#$%^&*(),.?":{}|<>]/.test(val),
        };

        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            let score = 0;

            for (const check of Object.values(criteria)) {
                if (check(val)) score++;
            }

            const percent = (score / Object.keys(criteria).length) * 100;
            strengthBar.style.width = percent + '%';
            strengthBar.style.backgroundColor =
                percent >= 80 ? '#16a34a' :
                percent >= 60 ? '#facc15' :
                '#ef4444';

            strengthText.textContent = score === 5 ?
                "✅ Strong password" :
                "Password must include uppercase, lowercase, number, symbol, and be at least 8 characters.";
        });

        toggleBtn.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            toggleBtn.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    </script>
</body>

</html>