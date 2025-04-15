<?php
session_start();
require_once 'db.php';

// Redirect if not logged in or not a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

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
    <title>Superadmin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">👋 Welcome, <?= htmlspecialchars($name) ?></h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="applicants_list.php">
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Total Applicants</p>
                    <h2 class="text-3xl font-bold text-purple-700"><?= $total ?></h2>
                </div>
</a>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="applicants_list.php"
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
            <div class="bg-white rounded-xl shadow p-6 mt-10">
                <h2 class="text-xl font-bold text-purple-800 mb-4">📊 Application Trends & Insights</h2>
                <canvas id="appTrendChart" height="150"></canvas>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Wait for DOM to load
        document.addEventListener('DOMContentLoaded', () => {
            // Function to create charts
            const createChart = (canvasId, config) => {
                const canvas = document.getElementById(canvasId);
                if (!canvas) {
                    console.error(`Canvas element with ID '${canvasId}' not found`);
                    return;
                }

                const ctx = canvas.getContext('2d');
                if (!ctx) {
                    console.error(`Failed to get 2D context for '${canvasId}'`);
                    return;
                }

                return new Chart(ctx, config);
            };

            // Submission Chart
            fetch('ajax/admin_chart_data.php')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (!data.labels || !data.data) {
                        throw new Error('Invalid data format from admin_chart_data.php');
                    }

                    createChart('submissionChart', {
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
                })
                .catch(error => {
                    console.error('Error loading submission chart:', error);
                });

            // Sidebar Toggle
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            if (toggleSidebar && sidebar) {
                toggleSidebar.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            } else {
                console.warn('Sidebar toggle elements not found');
            }

            // Application Trend Chart
            fetch('ajax/dashboard_metrics.php')
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(stats => {
                    if (!stats.labels || !stats.data) {
                        throw new Error('Invalid data format from dashboard_metrics.php');
                    }

                    createChart('appTrendChart', {
                        type: 'line',
                        data: {
                            labels: stats.labels,
                            datasets: [{
                                label: 'Applications Submitted',
                                data: stats.data,
                                borderColor: '#6B21A8',
                                backgroundColor: 'rgba(107, 33, 168, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                                x: {
                                    ticks: {
                                        maxRotation: 90,
                                        minRotation: 45
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading trend chart:', error);
                });
        });
    </script>
</body>

</html>