<?php include 'dashboard_logic.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <?php include 'components/student_sidebar.php'; ?>
    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6 w-full max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col items-center mb-6 gap-4">
            <!-- Profile Picture -->
            <div>
                <img src="<?= $passport ?: 'https://ui-avatars.com/api/?name=' . urlencode($name) ?>" alt="Avatar"
                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-2 border-purple-600">
            </div>
            <!-- Welcome Text and Admission Number -->
            <div class="text-center">
                <h1 class="text-xl sm:text-2xl font-bold text-purple-800">Welcome, <?= htmlspecialchars($name) ?>
                </h1>
                <p class="text-sm sm:text-base mt-1 text-purple-600 font-medium bg-purple-100 px-3 py-1 rounded">
                    Admission No: <?= ucfirst($addmissionNo) ?>
                </p>
            </div>
        </div>
        <?php
        $banner = $pdo->query("SELECT value FROM settings WHERE `key` = 'notice_banner'")->fetchColumn();
        if ($banner):
        ?>
        <div class="bg-yellow-100 text-yellow-800 text-sm p-3 rounded mb-4 border border-yellow-300 shadow">
            <?= htmlspecialchars($banner) ?>
        </div>
        <?php endif; ?>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <div class="bg-white shadow p-4 sm:p-5 rounded-xl">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">📌 Application Status</p>
                <p class="text-base sm:text-lg font-bold text-purple-700">
                    <?= ucfirst($appData['status'] ?? 'Not Started') ?></p>
            </div>

            <?php if (in_array($program, ['MA', 'PGDT'])): ?>
            <div class="bg-white shadow p-4 sm:p-5 rounded-xl">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">📎 Transcript Uploaded</p>
                <p class="text-base sm:text-lg font-bold text-purple-700"><?= $transcriptUploaded ?></p>
            </div>
            <?php endif; ?>

            <div class="bg-white shadow p-4 sm:p-5 rounded-xl">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">📄 Program</p>
                <p class="text-base sm:text-lg font-bold text-purple-700"><?= ucfirst($program) ?></p>
            </div>
            <?php if (in_array($program, ['MA'])): ?>
            <div class="bg-white shadow p-4 sm:p-5 rounded-xl">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">📄 MA Focus</p>
                <p class="text-base sm:text-lg font-bold text-purple-700"><?= ucfirst($focus) ?></p>
            </div>
            <?php endif; ?>

            <div class="bg-white shadow p-4 sm:p-5 rounded-xl">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">📄 Study Mode</p>
                <p class="text-base sm:text-lg font-bold text-purple-700"><?= ucfirst($mode) ?></p>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow space-y-4">
            <h2 class="text-lg sm:text-xl font-bold text-purple-800 mb-2">🧾 Actions</h2>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <a href="preview_application.php"
                    class="inline-block bg-blue-600 text-white px-4 sm:px-5 py-2 rounded hover:bg-blue-700 text-sm sm:text-base text-center">📑
                    View Application</a>
                <a href="download_application.php"
                    class="inline-block bg-green-600 text-white px-4 sm:px-5 py-2 rounded hover:bg-green-700 text-sm sm:text-base text-center">⬇️
                    Download Application Form</a>
                <?php if ($isAdmitted && file_exists($admissionLetterPath)): ?>
                <a href="<?= $admissionLetterPath ?>" target="_blank"
                    class="inline-block bg-purple-700 text-white px-4 sm:px-5 py-2 rounded hover:bg-purple-800 text-sm sm:text-base text-center">🎓
                    Download Admission Letter</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
    </div>

    <script>
    // Sidebar toggle for mobile
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 1024 && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    </script>
    </body>

</html>