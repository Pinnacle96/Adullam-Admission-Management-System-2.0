<?php
require_once '../db.php';

$months = [];
$data = [];

for ($i = 11; $i >= 0; $i--) {
    $label = date('M Y', strtotime("-$i months"));
    $monthKey = date('Y-m', strtotime("-$i months"));

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM applications WHERE DATE_FORMAT(submitted_at, '%Y-%m') = ?");
    $stmt->execute([$monthKey]);
    $count = $stmt->fetchColumn();

    $months[] = $label;
    $data[] = (int) $count;
}

echo json_encode([
    'labels' => $months,
    'data' => $data
]);
