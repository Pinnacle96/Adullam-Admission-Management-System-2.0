<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'superadmin') {
    $id = $_POST['id'] ?? null;
    $program_id = $_POST['program_id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM ma_focus_areas WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: manage_focus_areas.php?program_id=$program_id");
    exit;
}
