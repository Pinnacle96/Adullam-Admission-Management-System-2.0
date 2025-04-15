<?php
if (!isset($_SESSION)) session_start();
$role = $_SESSION['role'] ?? '';
$isSuper = $role === 'superadmin';
?>

<aside id="sidebar"
    class="fixed lg:static left-0 top-0 w-64 bg-purple-900 text-white min-h-screen p-6 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <h2 class="text-xl font-bold mb-6">📂 Menu</h2>
    <nav class="space-y-3">
        <a href="<?= $isSuper ? 'superadmin_dashboard.php' : 'admin_dashboard.php' ?>"
            class="block px-4 py-2 rounded hover:bg-purple-800">🏠 Dashboard</a>
        <a href="applicants_list.php" class="block px-4 py-2 rounded hover:bg-purple-800">📄 Applicants</a>
        <a href="#hostel_registrations.php" class="block px-4 py-2 rounded hover:bg-purple-800">🏨 Hostel Reg.</a>
        <a href="manage_tuition_payments.php" class="block px-4 py-2 rounded hover:bg-purple-800">📑 Manage Tuitions.</a> 
        <?php if ($isSuper): ?>
            <a href="manage_admins.php" class="block px-4 py-2 rounded hover:bg-purple-800">👤 Manage Admins</a>
            <a href="manage_programs.php" class="block px-4 py-2 rounded hover:bg-purple-800">🎓 Programs & Focus</a>
            <a href="recommendation_list.php" class="block px-4 py-2 rounded hover:bg-purple-800">📬 Recommendations</a>
            <a href="broadcast_email.php" class="block px-4 py-2 rounded hover:bg-purple-800">📢 Broadcast Email</a>
            <a href="reset_applicant_password.php" class="block px-4 py-2 rounded hover:bg-purple-800">🔐 Reset Password</a>
            <a href="documents_review.php" class="block px-4 py-2 rounded hover:bg-purple-800">📑 Review Docs</a>
            <a href="moderate_applications.php" class="block px-4 py-2 rounded hover:bg-purple-800">⚖️ Moderate
                Applications</a>
            <a href="analytics.php" class="block px-4 py-2 rounded hover:bg-purple-800">📊 Analytics</a>
            <a href="reports_export.php" class="block px-4 py-2 rounded hover:bg-purple-800">📁 Export Reports</a>
            <a href="system_settings.php" class="block px-4 py-2 rounded hover:bg-purple-800">⚙️ Settings</a>
        <?php else: ?>
             <a href="hostel_registrations.php" class="block px-4 py-2 rounded hover:bg-purple-800">🏨 Hostel Reg.</a>
            <a href="documents_review.php" class="block px-4 py-2 rounded hover:bg-purple-800">📑 Review Docs</a>
            <a href="broadcast_email.php" class="block px-4 py-2 rounded hover:bg-purple-800">📢 Broadcast Email</a>
            <a href="moderate_applications.php" class="block px-4 py-2 rounded hover:bg-purple-800">⚖️ Moderate
                Applications</a>
            <!-- <a href="resend_recommendation.php" class="block px-4 py-2 rounded hover:bg-purple-800">🔁 Resend
            Recommendation</a> -->
            <a href="analytics.php" class="block px-4 py-2 rounded hover:bg-purple-800">📊 Analytics</a>
            <a href="reports_export.php" class="block px-4 py-2 rounded hover:bg-purple-800">📁 Export Data</a>
        <?php endif; ?>

        <a href="admin_logout.php" class="block px-4 py-2 text-red-300 hover:text-white hover:bg-purple-800">🚪
            Logout</a>
    </nav>
</aside>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('mobileSidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>