<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    die("Unauthorized access.");
}

$program_id = $_GET['program_id'] ?? null;
if (!$program_id) die("Missing Program ID");

// Get program name
$stmt = $pdo->prepare("SELECT name FROM programs WHERE id = ?");
$stmt->execute([$program_id]);
$program = $stmt->fetch();
if (!$program) die("Program not found");

// Add new focus area
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['focus_area'])) {
    $focus = trim($_POST['focus_area']);
    if ($focus) {
        $stmt = $pdo->prepare("INSERT INTO ma_focus_areas (program_id, focus_area) VALUES (?, ?)");
        $stmt->execute([$program_id, $focus]);
    }
    header("Location: manage_focus_areas.php?program_id=$program_id");
    exit;
}

// Fetch all focus areas
$stmt = $pdo->prepare("SELECT * FROM ma_focus_areas WHERE program_id = ?");
$stmt->execute([$program_id]);
$focusAreas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage MA Focus Areas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex flex-col lg:flex-row">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-4 sm:p-6 max-w-3xl mx-auto w-full">
            <div class="bg-white p-6 rounded-xl shadow">
                <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-6">
                    🎓 MA Focus Areas for <?= htmlspecialchars($program['name']) ?>
                </h1>

                <!-- Add focus area form -->
                <form method="POST" class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                    <input type="text" name="focus_area" required placeholder="New focus area"
                        class="col-span-2 px-3 py-2 border rounded w-full">
                    <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">➕
                        Add</button>
                </form>

                <!-- Focus area list -->
                <ul class="space-y-3">
                    <?php foreach ($focusAreas as $fa): ?>
                        <li
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gray-50 px-4 py-3 rounded border">
                            <form method="POST" action="update_focus_area.php"
                                class="flex flex-col sm:flex-row gap-2 w-full">
                                <input type="hidden" name="id" value="<?= $fa['id'] ?>">
                                <input type="hidden" name="program_id" value="<?= $program_id ?>">
                                <input type="text" name="focus_area" value="<?= htmlspecialchars($fa['focus_area']) ?>"
                                    class="flex-1 border rounded p-2 text-sm">
                                <button type="submit" class="text-green-700 text-sm hover:underline whitespace-nowrap">💾
                                    Save</button>
                            </form>

                            <form method="POST" action="delete_focus_area.php" onsubmit="return confirm('Are you sure?')"
                                class="text-right">
                                <input type="hidden" name="id" value="<?= $fa['id'] ?>">
                                <input type="hidden" name="program_id" value="<?= $program_id ?>">
                                <button class="text-red-600 hover:underline text-sm whitespace-nowrap">🗑 Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <a href="manage_programs.php" class="inline-block mt-6 text-purple-600 hover:underline text-sm">⬅ Back
                    to Programs</a>
            </div>
        </main>
    </div>
</body>

</html>