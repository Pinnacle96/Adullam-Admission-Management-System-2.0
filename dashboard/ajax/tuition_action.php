<?php
session_start();
require '../db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$action = $data['action'] ?? '';
$note = trim($data['remarks'] ?? '');

if (!$id || !in_array($action, ['approve', 'reject'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$status = $action === 'approve' ? 'approved' : 'rejected';

$stmt = $pdo->prepare("UPDATE tuition_payment SET status = ?, remarks = ?, updated_at = NOW() WHERE id = ?");
$updated = $stmt->execute([$status, $note, $id]);

if ($updated) {
    echo json_encode(['status' => 'success', 'message' => "Payment {$status} successfully."]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update payment.']);
}
