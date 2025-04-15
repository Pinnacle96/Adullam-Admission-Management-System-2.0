<?php
require_once 'db.php';

$search = $_GET['search'] ?? '';
$program = $_GET['program'] ?? '';
$ma_focus = $_GET['ma_focus'] ?? '';

$params = [];
$where = ["u.role = 'student'"];

if (!empty($search)) {
    $where[] = "(u.first_name LIKE :first OR u.last_name LIKE :last OR u.email LIKE :email)";
    $params[':first'] = "%$search%";
    $params[':last'] = "%$search%";
    $params[':email'] = "%$search%";
}

if (!empty($program)) {
    $where[] = "ad.program = :program";
    $params[':program'] = $program;
}

if (!empty($ma_focus) && $program === 'MA') {
    $where[] = "ad.ma_focus = :ma_focus";
    $params[':ma_focus'] = $ma_focus;
}
$status = $_GET['status'] ?? '';

if (!empty($status)) {
    if ($status === 'submitted') {
        $where[] = "a.submitted = 1 AND a.status IS NULL";
    } else {
        $where[] = "a.status = :status";
        $params[':status'] = $status;
    }
}


$sql = "SELECT u.id,
               CONCAT_WS(' ', u.first_name, u.middle_name, u.last_name) AS full_name,
               u.email,
               u.phone,  -- ✅ NEW LINE
               a.status,
               ad.mode_of_study,
               ad.program,
               ad.ma_focus
        FROM users u
        LEFT JOIN applications a ON u.id = a.user_id
        LEFT JOIN application_details ad ON u.id = ad.user_id";

if (count($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY a.submitted_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
