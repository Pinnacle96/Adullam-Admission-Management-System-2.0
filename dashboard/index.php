<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adullam Seminary Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8">
        <!-- Logo + Title -->
        <div class="flex items-center space-x-3 mb-6">
            <img src="../assets/img/favicon.png" alt="Adullam Logo" class="h-12 w-12" />
            <div>
                <h1 class="text-2xl font-bold text-purple-800">RCN Theological Seminary</h1>
                <p class="text-sm text-gray-600">Adullam</p>
            </div>
        </div>
        <!-- <//?php
        $banner = $pdo->query("SELECT value FROM settings WHERE `key` = 'notice_banner'")->fetchColumn();
        if ($banner):
        ?>
            <div class="bg-yellow-100 text-yellow-800 text-sm p-3 rounded mb-4 border border-yellow-300 shadow">
                <//?= htmlspecialchars($banner) ?>
            </div>
        <//?php endif; ?> -->

        <!-- Tabs -->
        <div class="flex mb-4 border-b border-gray-200">
            <button id="tab-login"
                class="w-1/2 text-center py-2 font-semibold text-purple-700 border-b-2 border-purple-700">Login</button>
            <button id="tab-register"
                class="w-1/2 text-center py-2 font-semibold text-gray-500 hover:text-purple-700">Register</button>
        </div>

        <!-- Login Form -->
        <form id="form-login" class="space-y-4">
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
            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow">
                Login
            </button>
            <p class="text-xs text-center text-purple-700 mt-2">
                <a href="forgot_password.php" class="underline hover:text-purple-900">Forgot your password?</a>
            </p>
        </form>

        <!-- Register Form -->
        <form id="form-register" class="space-y-4 hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-700">First Name</label>
                    <input type="text" name="first_name" required
                        class="mt-1 w-full px-3 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name"
                        class="mt-1 w-full px-3 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm text-gray-700">Last Name</label>
                    <input type="text" name="last_name" required
                        class="mt-1 w-full px-3 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
            </div>
            <div>
                <label class="block text-sm text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
            </div>
            <div>
                <label class="block text-sm text-gray-700">Phone</label>
                <input type="tel" name="phone" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
            </div>
            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow">
                Register & Verify Email
            </button>
            <p class="text-xs text-center text-gray-600">
                📧 Check your inbox or spam for verification link.
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const tabRegister = document.getElementById('tab-register');
        const tabLogin = document.getElementById('tab-login');
        const formRegister = document.getElementById('form-register');
        const formLogin = document.getElementById('form-login');

        tabRegister.addEventListener('click', () => {
            tabRegister.classList.add('text-purple-700', 'border-purple-700');
            tabLogin.classList.remove('text-purple-700', 'border-purple-700');
            tabLogin.classList.add('text-gray-500');
            formRegister.classList.remove('hidden');
            formLogin.classList.add('hidden');
        });

        tabLogin.addEventListener('click', () => {
            tabLogin.classList.add('text-purple-700', 'border-purple-700');
            tabRegister.classList.remove('text-purple-700', 'border-purple-700');
            tabRegister.classList.add('text-gray-500');
            formLogin.classList.remove('hidden');
            formRegister.classList.add('hidden');
        });

        // ✅ Register Form Handler
        formRegister.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(formRegister);
            const res = await fetch('register.php', {
                method: 'POST',
                body: formData
            });
            const result = await res.json();
            Swal.fire({
                icon: result.status,
                title: result.status === 'success' ? 'Registered!' : 'Error',
                text: result.message,
                confirmButtonColor: '#6B21A8'
            }).then(() => {
                if (result.status === 'success') {
                    window.location.href = 'verify.php';
                }
            });
        });

        // ✅ Login Form Handler
        formLogin.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(formLogin);

            // Debug: Log the form data
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            const res = await fetch('login.php', {
                method: 'POST',
                body: formData
            });
            const result = await res.json();
            Swal.fire({
                icon: result.status,
                title: result.status === 'success' ? 'Welcome!' : 'Login Failed',
                text: result.message,
                confirmButtonColor: '#6B21A8'
            }).then(() => {
                if (result.status === 'success' && result.redirect) {
                    window.location.href = result.redirect;
                }
            });
        });

        if (localStorage.getItem('pwSet')) {
            Swal.fire({
                icon: 'success',
                title: 'Password Set!',
                text: 'You can now log in with your email and password.',
                confirmButtonColor: '#6B21A8'
            });
            localStorage.removeItem('pwSet');
        }
    </script>
</body>

</html>