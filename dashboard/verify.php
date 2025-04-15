<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-xl w-full max-w-md p-8">
        <h2 class="text-xl font-bold text-purple-800 text-center mb-4">Verify Your Email</h2>
        <p class="text-sm text-gray-600 text-center mb-6">Enter the 6-digit OTP sent to your email.</p>

        <!-- OTP Verification Form -->
        <form id="otpForm" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">OTP Code</label>
                <input type="text" name="otp" required maxlength="6"
                    class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600 text-center tracking-widest text-lg">
            </div>
            <button type="submit"
                class="w-full bg-purple-700 hover:bg-purple-800 text-white py-2 rounded-lg shadow">Verify OTP</button>
        </form>

        <!-- Resend OTP Button -->
        <p class="text-sm text-center mt-4 text-gray-600">
            Didn't get it?
            <button id="resendBtn" class="text-purple-700 font-medium hover:underline">Resend OTP</button>
        </p>
    </div>

    <script>
        // ✅ Handle OTP form submit
        document.getElementById('otpForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = new FormData(this);
            const response = await fetch('verify_otp.php', {
                method: 'POST',
                body: form
            });
            const result = await response.json();

            Swal.fire({
                icon: result.status,
                title: result.status === 'success' ? 'Verified!' : 'Error',
                text: result.message,
                confirmButtonColor: '#6B21A8'
            }).then(() => {
                if (result.status === 'success') {
                    window.location.href = 'set_password.php';
                }
            });
        });

        // ✅ Handle Resend OTP click
        document.getElementById('resendBtn').addEventListener('click', async function() {
            const res = await fetch('resend_otp.php', {
                method: 'POST'
            });
            const result = await res.json();

            Swal.fire({
                icon: result.status,
                title: result.status === 'success' ? 'OTP Resent!' : 'Error',
                text: result.message,
                confirmButtonColor: '#6B21A8'
            });
        });
    </script>

</body>

</html>