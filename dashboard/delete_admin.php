<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'superadmin' || !isset($_POST['admin_id'])) {
    exit('Unauthorized.');
}

$id = (int) $_POST['admin_id'];
$pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'admin'")->execute([$id]);
header("Location: manage_admins.php");
exit;
