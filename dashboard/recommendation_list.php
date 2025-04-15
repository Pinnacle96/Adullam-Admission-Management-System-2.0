<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    header('Location: index.php');
    exit;
}

// Fetch applicants with referees
$sql = "
    SELECT 
        u.id AS user_id,
        CONCAT_WS(' ', u.first_name, u.last_name) AS full_name,
        ar.referee_name,
        ar.referee_email,
        ar.submitted
    FROM users u
    JOIN application_recommendations ar ON u.id = ar.user_id
    WHERE u.role = 'student'
    ORDER BY ar.created_at DESC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

// Group by user
$recommendations = [];
foreach ($rows as $row) {
    $uid = $row['user_id'];
    if (!isset($recommendations[$uid])) {
        $recommendations[$uid] = [
            'full_name' => $row['full_name'],
            'refs' => []
        ];
    }
    $recommendations[$uid]['refs'][] = [
        'name' => $row['referee_name'],
        'email' => $row['referee_email'],
        'submitted' => $row['submitted']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recommendation List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">📄 Recommendation Submissions</h1>

            <div class="overflow-x-auto bg-white shadow-md rounded-xl">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-purple-800 text-white text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Applicant</th>
                            <th class="px-4 py-3">Referees</th>
                            <th class="px-4 py-3">Submitted</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recommendations as $userId => $applicant): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium"><?= htmlspecialchars($applicant['full_name']) ?></td>

                                <td class="px-4 py-3">
                                    <?php foreach ($applicant['refs'] as $r): ?>
                                        <?= htmlspecialchars($r['name']) ?><br>
                                        <span class="text-xs text-gray-500"><?= htmlspecialchars($r['email']) ?></span><br><br>
                                    <?php endforeach; ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?php foreach ($applicant['refs'] as $r): ?>
                                        <?= $r['submitted'] ? "✅ Submitted" : "❌ Not yet" ?><br><br>
                                    <?php endforeach; ?>
                                </td>

                                <td class="px-4 py-3">
                                    <a href="resend_recommendation.php?id=<?= $userId ?>"
                                        class="text-purple-700 hover:underline text-sm">
                                        🔁 Resend Link
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recommendations)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">No recommendation records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>