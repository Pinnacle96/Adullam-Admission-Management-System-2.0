<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    http_response_code(403);
    exit('Access denied');
}

$applicantId = $_POST['id'] ?? null;

if (!$applicantId) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: applicants_list.php");
    exit;
}

try {
    // Delete from related tables first
    $tables = [
        'application_documents',
        'application_references',
        'application_autobiography',
        'application_church',
        'application_personal',
        'application_details',
        'applications',
        'hostel_applications',
    ];

    foreach ($tables as $table) {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE user_id = ?");
        $stmt->execute([$applicantId]);
    }

    // Finally delete from users table
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$applicantId]);

    $_SESSION['success'] = "Application deleted successfully.";
} catch (Exception $e) {
    error_log("Error deleting application for user_id $applicantId: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while deleting the application.";
}

header("Location: applicants_list.php");
exit;
?>
