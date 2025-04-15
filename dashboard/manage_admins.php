<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: index.php");
    exit;
}

// Add admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if ($fname && $email && $password) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role, verified) 
                VALUES (?, ?, ?, ?, ?, 'admin', 1)")
                ->execute([$fname, $lname, $email, $phone, $hashed]);
            $success = "Admin added.";
        }
    } else {
        $error = "Please fill all required fields.";
    }
}

$admins = $pdo->query("SELECT * FROM users WHERE role IN ('admin','superadmin')")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-4 sm:p-6 w-full max-w-6xl mx-auto">
            <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-4">👥 Manage Admins</h1>

            <?php if (!empty($success)): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $success ?></div>
            <?php elseif (!empty($error)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error ?></div>
            <?php endif; ?>

            <!-- Add Admin -->
            <div class="bg-white shadow p-6 rounded-xl mb-8">
                <h2 class="text-lg font-semibold mb-4">➕ Add New Admin</h2>
                <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input required type="text" name="first_name" placeholder="First Name" class="p-2 border rounded">
                    <input type="text" name="last_name" placeholder="Last Name" class="p-2 border rounded">
                    <input required type="email" name="email" placeholder="Email" class="p-2 border rounded">
                    <input required type="text" name="phone" placeholder="Phone" class="p-2 border rounded">
                    <input required type="password" name="password" placeholder="Password" class="p-2 border rounded">
                    <input type="hidden" name="add_admin" value="1">
                    <div class="md:col-span-3">
                        <button type="submit" class="bg-purple-700 text-white px-6 py-2 rounded hover:bg-purple-800">
                            ➕ Add Admin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Admin List -->
            <div class="bg-white shadow p-6 rounded-xl">
                <h2 class="text-lg font-semibold mb-4">📋 Admin List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-purple-800 text-white text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2"><?= $admin['first_name'] . ' ' . $admin['last_name'] ?></td>
                                    <td class="px-4 py-2"><?= $admin['email'] ?></td>
                                    <td class="px-4 py-2"><?= $admin['phone'] ?></td>
                                    <td class="px-4 py-2"><?= ucfirst($admin['role']) ?></td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="update_admin.php?id=<?= $admin['id'] ?>"
                                            class="text-blue-600 hover:underline text-sm">✏️ Edit</a>
                                        <?php if ($admin['role'] !== 'superadmin'): ?>
                                            <form method="POST" action="delete_admin.php"
                                                onsubmit="return confirm('Are you sure?')">
                                                <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                                                <button class="text-red-500 hover:underline text-sm">🗑 Remove</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>