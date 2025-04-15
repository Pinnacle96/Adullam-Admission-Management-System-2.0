<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Export Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">📁 Export Reports</h1>

            <form method="GET" action="" class="bg-white shadow p-6 rounded-xl space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select name="program" class="border p-2 rounded w-full">
                        <option value="">All Programs</option>
                        <option value="MA">MA</option>
                        <option value="PGDT">PGDT</option>
                        <option value="B.Div">B.Div</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Certificate">Certificate</option>
                    </select>

                    <select name="status" class="border p-2 rounded w-full">
                        <option value="">All Status</option>
                        <option value="draft">inprogress</option>
                        <option value="submitted">Submitted</option>
                        <option value="admitted">Admitted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="flex justify-start gap-4 pt-4">
                    <button formaction="export_excel.php"
                        class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                        📄 Export as CSV
                    </button>
                    <button formaction="export_pdf.php"
                        class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700">
                        📄 Export as PDF
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>