<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $active = isset($_POST['active']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE programs SET name = ?, description = ?, active = ? WHERE id = ?");
    $stmt->execute([$name, $desc, $active, $id]);

    header("Location: manage_programs.php");
    exit;
}
