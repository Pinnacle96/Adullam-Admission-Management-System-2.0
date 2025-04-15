<?php
require '../db.php';

// Total per month (past 6 months)
$sql = "SELECT DATE_FORMAT(submitted_at, '%Y-%m') AS month, COUNT(*) AS count
        FROM applications
        WHERE submitted = 1
        GROUP BY month
        ORDER BY month DESC
        LIMIT 6";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = array_reverse(array_column($rows, 'month'));
$data = array_reverse(array_column($rows, 'count'));

echo json_encode(['labels' => $labels, 'data' => $data]);
