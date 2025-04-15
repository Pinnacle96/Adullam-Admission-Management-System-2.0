<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Login – Adullam Seminary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">

        <!-- Logo + Title -->
        <div class="flex items-center space-x-3 mb-6">
            <img src="../assets/img/logo1.png" alt="Adullam Logo" class="h-12 w-12" />
            <div>
                <h1 class="text-2xl font-bold text-purple-800">Adullam Seminary</h1>
                <p class="text-sm text-gray-600">Administrator Portal</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-center">🔐 Administrator Login</h2>

        <!-- Admin Login Form -->
        <form id="formLogin" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">Email</label>
                <input type="email" name="login_email" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
            </div>
            <div>
                <label class="block text-sm text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
            </div>
            <button type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow transition">
                Login as Admin
            </button>
            <p class="text-xs text-center text-purple-700 mt-2">
                <a href="forgot_password.php" class="underline hover:text-purple-900">Forgot password?</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const formLogin = document.getElementById('formLogin');

        formLogin.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(formLogin);

            const res = await fetch('login.php', {
                method: 'POST',
                body: formData
            });

            const result = await res.json();

            console.log('Login Response:', result);

            Swal.fire({
                icon: result.status,
                title: result.status === 'success' ? 'Welcome Admin!' : 'Login Failed',
                text: result.message,
                confirmButtonColor: '#6B21A8'
            }).then(() => {
                if (result.status === 'success' && result.redirect) {
                    window.location.href = result.redirect;
                }
            });
        });
    </script>
</body>

</html>