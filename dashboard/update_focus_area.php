<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'superadmin') {
    $id = $_POST['id'] ?? null;
    $program_id = $_POST['program_id'] ?? null;
    $focus = trim($_POST['focus_area']);

    if ($id && $focus) {
        $stmt = $pdo->prepare("UPDATE ma_focus_areas SET focus_area = ? WHERE id = ?");
        $stmt->execute([$focus, $id]);
    }
    header("Location: manage_focus_areas.php?program_id=$program_id");
    exit;
}
