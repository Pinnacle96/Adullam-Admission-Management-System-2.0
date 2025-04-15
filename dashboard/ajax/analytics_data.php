<?php
require '../db.php';

// 📅 Trend: last 6 months
$trend = $pdo->query("
  SELECT DATE_FORMAT(submitted_at, '%Y-%m') AS month, COUNT(*) AS count
  FROM applications WHERE submitted = 1
  GROUP BY month ORDER BY month DESC LIMIT 6
")->fetchAll(PDO::FETCH_ASSOC);

$data['trend'] = [
    'labels' => array_reverse(array_column($trend, 'month')),
    'data' => array_reverse(array_column($trend, 'count'))
];

// 📌 Status breakdown
$status = $pdo->query("
  SELECT status, COUNT(*) AS count FROM applications GROUP BY status
")->fetchAll(PDO::FETCH_KEY_PAIR);

$data['status'] = [
    'labels' => array_keys($status),
    'data' => array_values($status)
];

// 🚻 Gender breakdown
$gender = $pdo->query("
  SELECT gender, COUNT(*) AS count FROM application_details GROUP BY gender
")->fetchAll(PDO::FETCH_KEY_PAIR);

$data['gender'] = [
    'labels' => array_keys($gender),
    'data' => array_values($gender)
];

// 🎓 Programs
$programs = $pdo->query("
  SELECT program, COUNT(*) AS count FROM application_details GROUP BY program
")->fetchAll(PDO::FETCH_KEY_PAIR);

$data['program'] = [
    'labels' => array_keys($programs),
    'data' => array_values($programs)
];

header('Content-Type: application/json');
echo json_encode($data);
