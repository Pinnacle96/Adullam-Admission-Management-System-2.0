<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    header("Location: index.php");
    exit;
}

$role = $_SESSION['role'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Applicants List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex min-h-screen">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-4 sm:p-6 w-full max-w-7xl mx-auto">
            <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-4 sm:mb-6">
                Applicants List (<?= ucfirst($role) ?> View)
            </h1>

            <!-- Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <input type="text" id="search" placeholder="Search by name or email"
                    class="px-4 py-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-purple-500">

                <select id="program"
                    class="px-4 py-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Filter by Program</option>
                    <option value="MA">MA</option>
                    <option value="PGDT">PGDT</option>
                    <option value="B.Div">B.Div</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Certificate">Certificate</option>
                </select>

                <select id="ma_focus"
                    class="px-4 py-2 border rounded w-full hidden focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Filter by MA Focus</option>
                    <option value="MA Christian Apologetics">MA Christian Apologetics</option>
                    <option value="MA Biblical Studies (OT/NT)">MA Biblical Studies (OT/NT)</option>
                </select>
            </div>

            <!-- Export -->
            <div class="flex justify-end gap-4 mb-4">
                <a id="exportExcel" href="#"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">⬇️ Export to Excel</a>
                <a id="exportPDF" href="#" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">📄
                    Export to PDF</a>
            </div>

            <!-- Table Results -->
            <div id="results">
                <!-- Fetched via AJAX -->
            </div>
        </main>
    </div>

    <script>
        function fetchApplicants() {
            const search = $('#search').val();
            const program = $('#program').val();
            const ma_focus = $('#ma_focus').val();

            $.get('ajax/fetch_applicants.php', {
                search: search,
                program: program,
                ma_focus: ma_focus
            }, function(data) {
                $('#results').html(data);
            });
        }

        function updateExportLinks() {
            const search = encodeURIComponent($('#search').val());
            const program = encodeURIComponent($('#program').val());
            const ma_focus = encodeURIComponent($('#ma_focus').val());

            const query = `?search=${search}&program=${program}&ma_focus=${ma_focus}`;
            $('#exportExcel').attr('href', 'export_excel.php' + query);
            $('#exportPDF').attr('href', 'export_pdf.php' + query);
        }

        $(document).ready(function() {
            // Fetch & bind
            fetchApplicants();
            updateExportLinks();

            $('#search, #program, #ma_focus').on('input change', function() {
                fetchApplicants();
                updateExportLinks();
            });

            $('#program').on('change', function() {
                if ($(this).val() === 'MA') {
                    $('#ma_focus').removeClass('hidden');
                } else {
                    $('#ma_focus').val('').addClass('hidden');
                }
            });
        });
    </script>
</body>

</html>