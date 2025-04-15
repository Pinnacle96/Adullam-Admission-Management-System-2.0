<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    header("Location: index.php");
    exit;
}

$role = $_SESSION['role'];
$name = $_SESSION['name'] ?? 'Admin';

// Fetch dashboard stats
$total = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$submitted = $pdo->query("SELECT COUNT(*) FROM applications WHERE submitted = 1")->fetchColumn();
$admitted = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'admitted'")->fetchColumn();
$pendingRec = $pdo->query("SELECT COUNT(*) FROM application_recommendations WHERE submitted = 0")->fetchColumn();
$notSubmitted = $pdo->query("SELECT COUNT(*) FROM applications WHERE submitted = 0 OR submitted IS NULL")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../assets/img/favicon.png" />
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">👋 Welcome, <?= htmlspecialchars($name) ?></h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Total Applicants</p>
                    <h2 class="text-3xl font-bold text-purple-700"><?= $total ?></h2>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Submitted Applications</p>
                    <h2 class="text-3xl font-bold text-purple-700"><?= $submitted ?></h2>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Admitted Applicants</p>
                    <h2 class="text-3xl font-bold text-green-600"><?= $admitted ?></h2>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Not Yet Submitted</p>
                    <h2 class="text-3xl font-bold text-red-600"><?= $notSubmitted ?></h2>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Pending Recommendations</p>
                    <h2 class="text-3xl font-bold text-red-600"><?= $pendingRec ?></h2>
                </div>
            </div>

            <!-- Quick Access Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="application_list.php"
                    class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-3 rounded-xl shadow text-center font-medium">
                    📋 Manage Applicants
                </a>
                <a href="recommendation_list.php"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-3 rounded-xl shadow text-center font-medium">
                    📨 View Recommendations
                </a>
                <a href="reports_export.php"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl shadow text-center font-medium">
                    📊 Export Reports
                </a>
            </div>
            <div class="bg-white p-4 rounded-xl shadow mt-8">
                <h2 class="text-lg font-semibold mb-4 text-purple-800">📈 Monthly Submissions Trend</h2>
                <canvas id="submissionChart" height="100"></canvas>
            </div>

        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch('ajax/admin_chart_data.php')
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('submissionChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Submitted Applications',
                            data: data.data,
                            borderColor: '#6B21A8',
                            backgroundColor: 'rgba(107, 33, 168, 0.1)',
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
    </script>

</body>

</html>