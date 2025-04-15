<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_program'])) {
    $name = trim($_POST['program_name']);
    $desc = trim($_POST['description']);

    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO programs (name, description, active) VALUES (?, ?, 1)");
        $stmt->execute([$name, $desc]);
        header("Location: manage_programs.php");
        exit;
    }
}

$programs = $pdo->query("SELECT * FROM programs ORDER BY name ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Programs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex flex-col lg:flex-row">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-4 sm:p-6 max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">🎓 Manage Academic Programs</h1>

            <!-- Add New Program -->
            <form method="POST" class="bg-white p-4 rounded-xl shadow mb-6 space-y-4">
                <h2 class="text-lg font-semibold text-purple-700">➕ Add New Program</h2>
                <input type="text" name="program_name" required
                    placeholder="Program Name (e.g.,Certificate, Diploma, B.Div, MA, PGDT)"
                    class="w-full border p-2 rounded">
                <textarea name="description" rows="3" placeholder="Program Description (optional)"
                    class="w-full border p-2 rounded"></textarea>
                <button type="submit" name="new_program"
                    class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">
                    Save Program
                </button>
            </form>

            <!-- Programs List -->
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4 text-purple-700">📋 Existing Programs</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-purple-800 text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Active</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($programs as $prog): ?>
                                <tr class="bg-white">
                                    <form method="POST" action="save_program.php" class="w-full">
                                        <input type="hidden" name="id" value="<?= $prog['id'] ?>">
                                        <td class="px-4 py-2">
                                            <input type="text" name="name" value="<?= htmlspecialchars($prog['name']) ?>"
                                                class="border p-1 rounded w-full">
                                        </td>
                                        <td class="px-4 py-2">
                                            <textarea name="description"
                                                class="border p-1 rounded w-full"><?= htmlspecialchars($prog['description']) ?></textarea>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <input type="checkbox" name="active" value="1"
                                                <?= isset($prog['active']) && $prog['active'] ? 'checked' : '' ?>>
                                        </td>
                                        <td class="px-4 py-2 space-y-2">
                                            <button type="submit" class="text-green-700 text-sm hover:underline mb-2">💾
                                                Save</button>
                                            <?php if (strtoupper($prog['name']) === 'MA'): ?>
                                                <a href="manage_focus_areas.php?program_id=<?= $prog['id'] ?>"
                                                    class="text-blue-700 text-sm hover:underline">📂 Focus Areas</a><br>
                                            <?php endif; ?>
                                    </form>
                                    <form action="delete_program.php" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this program?');">
                                        <input type="hidden" name="id" value="<?= $prog['id'] ?>">
                                        <button class="text-red-600 text-sm hover:underline mt-1">🗑 Delete</button>
                                    </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($programs)): ?>
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">No programs added yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>