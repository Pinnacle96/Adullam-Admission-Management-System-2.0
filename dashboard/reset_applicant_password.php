<?php
session_start();
require 'db.php';
require 'mailer.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    die("Unauthorized access.");
}

$search = $_GET['search'] ?? '';
$success = false;
$error = '';
$selectedUser = null;

// 🔎 Search Logic
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'student' AND (email LIKE ? OR first_name LIKE ? OR last_name LIKE ?)");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
    $results = $stmt->fetchAll();
} else {
    $results = [];
}

// 🔄 Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update DB
        $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hashed, $userId]);

        // Fetch user for email
        $userStmt = $pdo->prepare("SELECT email, first_name FROM users WHERE id = ?");
        $userStmt->execute([$userId]);
        $user = $userStmt->fetch();

        if ($user) {
            $email = $user['email'];
            $name = $user['first_name'];
            $subject = "🔐 Your Adullam Seminary Password Has Been Reset";

            // Encode subject to UTF-8 base64 for compatibility
            $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

            $logoUrl = "https://adullam.ng/assets/img/logo1.png"; // Use absolute path for email clients

            $body = "
<div style='font-family:Segoe UI, sans-serif; max-width:600px; margin:auto; padding:24px; background:#ffffff; border:1px solid #ddd; border-radius:10px;'>
  <div style='text-align:center; margin-bottom:20px;'>
    <img src='$logoUrl' alt='Adullam Seminary Logo' style='height:60px;'><br/>
    <h2 style='color:#6B21A8; margin-top:10px;'>Adullam Seminary Admissions</h2>
  </div>

  <p style='font-size:16px; color:#111;'>Dear <strong>$name</strong>,</p>

  <p style='font-size:15px; color:#333; line-height:1.6;'>
    🛡️ Your password for <strong>RCN Theological Seminary – Adullam</strong> was recently reset by a system administrator.
  </p>

  <p style='font-size:15px; color:#333; line-height:1.6;'>
    If this was authorized, you may now log in using your new credentials.
  </p>

  <p style='font-size:15px; color:#e63946; line-height:1.6;'>
    ❗ If you did not request this change, please contact us <strong>immediately</strong> to secure your account.
  </p>

  <div style='text-align:center; margin:24px 0;'>
    <a href='https://adullam.ng' style='background:#6B21A8; color:white; padding:12px 24px; border-radius:6px; text-decoration:none; font-weight:bold; font-size:15px;'>
      🔑 Visit Student Portal
    </a>
  </div>

  <p style='font-size:15px; color:#333; line-height:1.6;'>
    🎓 Thank you for being part of our academic family.
  </p>

  <p style='font-size:15px; color:#333; line-height:1.6; margin-bottom:30px;'>
    Warm regards,<br/>
    <strong>Adullam Admissions Team</strong><br/>
    ✉️ admissions@adullam.ng
  </p>

  <hr style='border:none; border-top:1px solid #ddd; margin:20px 0;' />

  <p style='font-size:13px; color:#888; text-align:center;'>
   &copy; " . date('Y') . " Adullam Seminary – All rights reserved.
  </p>
</div>
";


            sendMail($email, $name, $subject, $body);
        }

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Applicant Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-4">🔐 Reset Applicant Password</h1>

            <?php if ($success): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Reset',
                        text: 'The password was successfully updated and emailed.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                </script>
            <?php elseif ($error): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search by name or email" class="flex-1 p-2 border rounded" />
                <button class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">Search</button>
            </form>

            <?php if (!empty($results)): ?>
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-purple-700 mb-2">Search Results:</h2>
                    <?php foreach ($results as $r): ?>
                        <div class="border-b py-3">
                            <form method="POST" class="grid gap-2 md:grid-cols-2">
                                <input type="hidden" name="user_id" value="<?= $r['id'] ?>">
                                <div><strong><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></strong>
                                    (<?= $r['email'] ?>)</div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="password" name="password" placeholder="New Password" class="p-2 border rounded"
                                        required />
                                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                                        class="p-2 border rounded" required />
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <button type="submit"
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">💾
                                        Reset</button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($search): ?>
                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded">No applicants found for that query.</div>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>