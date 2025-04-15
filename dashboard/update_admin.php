<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    die("Unauthorized access.");
}

$id = $_GET['id'] ?? null;
if (!$id) die("Missing admin ID.");

// Fetch admin details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();

if (!$admin) {
    die("Admin not found.");
}

// ✅ Handle update and show SweetAlert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if ($password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, password = ? WHERE id = ?");
        $stmt->execute([$fname, $lname, $email, $phone, $hashed, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$fname, $lname, $email, $phone, $id]);
    }

    // ✅ Now output SweetAlert in valid HTML
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Updated</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated Successfully',
                text: 'Admin details saved.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'manage_admins.php';
            });

            // Safety fallback after 3s
            setTimeout(() => {
                window.location.href = 'manage_admins.php';
            }, 3000);
        </script>
    </body>
    </html>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-3xl mx-auto">
            <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-4">✏️ Edit Admin</h1>

            <form method="POST" class="bg-white shadow p-6 rounded-xl space-y-4">
                <div>
                    <label class="block font-semibold mb-1">First Name</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($admin['first_name'] ?? '') ?>"
                        class=" w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($admin['last_name'] ?? '') ?>"
                        class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($admin['email'] ?? '') ?>""
                        class=" w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($admin['phone'] ?? '') ?>"
                        class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">New Password <span class="text-sm text-gray-500">(Leave
                            blank to keep current)</span></label>
                    <input type="password" name="password" class="w-full border p-2 rounded">
                </div>
                <div class="pt-4">
                    <button type="submit" class="bg-purple-700 text-white px-6 py-2 rounded hover:bg-purple-800">
                        💾 Save Changes
                    </button>
                    <a href="manage_admins.php" class="ml-4 text-sm text-purple-600 hover:underline">← Back</a>
                </div>
            </form>
        </main>
    </div>
</body>

</html>