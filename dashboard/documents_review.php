<?php
session_start();
require_once 'db.php';

// Check for required components
if (!file_exists('components/navbar.php') || !file_exists('components/sidebar.php')) {
    die("Required components (navbar.php or sidebar.php) are missing.");
}

// Session and role check
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    header("Location: index.php");
    exit;
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Validate CSRF token for pagination
if (isset($_GET['page']) && (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token'])) {
    die("CSRF token validation failed.");
}

// Pagination
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

try {
    // Count total applicants
    $totalStmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'");
    $totalApplicants = $totalStmt->fetchColumn();
    $totalPages = ceil($totalApplicants / $limit);

    // Fetch paginated applicant documents
    $stmt = $pdo->prepare("
        SELECT u.id,
               CONCAT_WS(' ', u.first_name, u.middle_name, u.last_name) AS full_name,
               ad.program,
               d.passport, d.ssce_cert, d.birth_cert, d.origin_cert, d.recommendation,
               d.payment_proof, d.degree_cert, d.transcript
        FROM users u
        LEFT JOIN application_documents d ON u.id = d.user_id
        LEFT JOIN application_details ad ON u.id = ad.user_id
        WHERE u.role = 'student'
        ORDER BY u.id DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->execute(['limit' => $limit, 'offset' => $offset]);
    $docs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    die("An error occurred while fetching data. Please try again later.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📂 Documents Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <style>
        /* Ensure table headers and cells wrap on small screens */
        @media (max-width: 640px) {

            th,
            td {
                font-size: 0.75rem;
                /* Smaller font on mobile */
                padding: 0.5rem;
                /* Reduced padding on mobile */
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex flex-col md:flex-row">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-4 sm:p-6">
            <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-4">📂 Documents Review</h1>

            <div class="overflow-x-auto bg-white rounded-xl shadow">
                <table class="w-full text-sm text-left text-gray-700 divide-y divide-gray-200">
                    <thead class="bg-purple-800 text-white text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Program</th>
                            <th class="px-4 py-3">Passport</th>
                            <th class="px-4 py-3">SSCE</th>
                            <th class="px-4 py-3">Birth Cert</th>
                            <th class="px-4 py-3">Origin Cert</th>
                            <th class="px-4 py-3">Recommendation</th>
                            <th class="px-4 py-3">Payment</th>
                            <th class="px-4 py-3">Degree</th>
                            <th class="px-4 py-3">Transcript</th>
                            <th class="px-4 py-3">View Applicant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($docs as $u): ?>
                            <?php
                            $isMAorPGDT = in_array($u['program'], ['MA', 'PGDT']);
                            $documents = [
                                'passport',
                                'ssce_cert',
                                'birth_cert',
                                'origin_cert',
                                'recommendation',
                                'payment_proof',
                                'degree_cert' => $isMAorPGDT,
                                'transcript' => $isMAorPGDT,
                            ];
                            ?>
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-900 font-medium">
                                    <?= htmlspecialchars($u['full_name'] ?? 'N/A') ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?= htmlspecialchars($u['program'] ?? 'N/A') ?>
                                </td>

                                <?php
                                foreach (['passport', 'ssce_cert', 'birth_cert', 'origin_cert', 'recommendation', 'payment_proof', 'degree_cert', 'transcript'] as $doc) {
                                    $isRequired = !in_array($doc, ['degree_cert', 'transcript']) || $isMAorPGDT;
                                    echo "<td class='px-4 py-2 text-center'>";
                                    if ($isRequired) {
                                        if (!empty($u[$doc])) {
                                            echo "<a href='{$u[$doc]}' target='_blank' class='text-green-600 hover:underline'>✅</a>";
                                        } else {
                                            echo "<span class='text-red-600'>❌</span>";
                                        }
                                    } else {
                                        echo "<span class='text-gray-400'>N/A</span>";
                                    }
                                    echo "</td>";
                                }
                                ?>
                                <td class="px-4 py-2 text-center">
                                    <a href="applicant_view.php?id=<?= $u['id'] ?>"
                                        class="text-sm text-blue-700 hover:underline">🔍 View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                        <?php if (empty($docs)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-gray-500">No applicants found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex flex-wrap justify-center mt-6 space-x-2 text-sm">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&csrf_token=<?= $csrf_token ?>"
                            class="px-3 py-1 border rounded bg-white text-purple-700">
                            Previous
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&csrf_token=<?= $csrf_token ?>"
                            class="px-3 py-1 border rounded <?= $i == $page ? 'bg-purple-700 text-white' : 'bg-white text-purple-700' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&csrf_token=<?= $csrf_token ?>"
                            class="px-3 py-1 border rounded bg-white text-purple-700">
                            Next
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>