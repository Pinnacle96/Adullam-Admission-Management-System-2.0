<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    http_response_code(403);
    exit('Access denied');
}

$applicantId = $_GET['id'] ?? null;

if (!$applicantId) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: applicants_list.php");
    exit;
}

$stmt = $pdo->prepare("SELECT CONCAT_WS(' ', first_name, middle_name, last_name) AS full_name FROM users WHERE id = ?");
$stmt->execute([$applicantId]);
$applicant = $stmt->fetch();

if (!$applicant) {
    $_SESSION['error'] = "Applicant not found.";
    header("Location: applicants_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Confirm Delete</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

<div class="bg-white p-6 sm:p-8 rounded-xl shadow-xl max-w-md w-full text-center">
    <div class="mb-4 text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 mx-auto" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m2-4h.01M12 9v2m0 4v2m0 4v2m0-20a9 9 0 110 18 9 9 0 010-18z"/>
        </svg>
    </div>

    <h1 class="text-xl font-bold text-gray-800 mb-2">Are you sure?</h1>

    <p class="text-gray-600 mb-3">You are about to permanently delete the application of:</p>

    <p class="font-semibold text-lg text-gray-800 mb-4"><?= htmlspecialchars($applicant['full_name']) ?></p>

    <p class="text-sm text-red-500 mb-6">This action cannot be undone!</p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="applicants_list.php"
           class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg shadow">
            Cancel
        </a>

        <form method="POST" action="delete_application_action.php" class="w-full sm:w-auto">
            <input type="hidden" name="id" value="<?= $applicantId ?>">
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg w-full sm:w-auto shadow">
                Yes, Delete
            </button>
        </form>
    </div>
</div>

</body>

</html>
