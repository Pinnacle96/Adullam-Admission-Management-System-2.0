<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    die("🚫 Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // ✅ Optional: Check if program exists
    $check = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
    $check->execute([$id]);
    $program = $check->fetch();

    if (!$program) {
        $_SESSION['error'] = "Program not found.";
        header("Location: manage_programs.php");
        exit;
    }

    // ✅ Delete program and any related MA focus areas (if foreign key is not set)
    $pdo->prepare("DELETE FROM ma_focus_areas WHERE program_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM programs WHERE id = ?")->execute([$id]);

    $_SESSION['success'] = "Program deleted successfully.";
    header("Location: manage_programs.php");
    exit;
}

$_SESSION['error'] = "Invalid request.";
header("Location: manage_programs.php");
exit;
