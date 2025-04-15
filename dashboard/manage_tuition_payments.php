<?php
session_start();
require 'db.php';
require 'mailer.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    header("Location: index.php");
    exit;
}

$role = $_SESSION['role'];
$name = $_SESSION['name'] ?? 'Admin';

// Fetch tuition payment records
$stmt = $pdo->query("SELECT tp.*, u.first_name, u.last_name, d.program, d.mode_of_study, d.ma_focus
                     FROM tuition_payment tp
                     JOIN users u ON tp.user_id = u.id
                     JOIN application_details d ON tp.user_id = d.user_id
                     ORDER BY tp.updated_at DESC");
$payments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tuition Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">
<?php include 'components/navbar.php'; ?>
    <div class="flex flex-col md:flex-row">
        <?php include 'components/sidebar.php'; ?>
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-full">
            <h1 class="text-xl sm:text-2xl font-bold text-purple-800 mb-6">🎓 Tuition Payment Management</h1>

            <div class="flex flex-col gap-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <input id="searchInput" type="text" placeholder="Search by name, program, mode, or status"
                           class="w-full sm:w-64 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600">
                    
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <select id="filterProgram" class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow-sm">
                            <option value="">All Programs</option>
                            <option value="MA">MA</option>
                            <option value="PGDT">PGDT</option>
                            <option value="B.Div">B.Div</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Certificate">Certificate</option>
                        </select>
                        <select id="filterMode" class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow-sm">
                            <option value="">All Modes</option>
                            <option value="onsite">Onsite</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[640px]" id="paymentTable">
                        <thead class="text-gray-700 border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Program</th>
                                <th class="py-3 px-4">Focus (MA)</th>
                                <th class="py-3 px-4">Mode</th>
                                <th class="py-3 px-4">Amount</th>
                                <th class="py-3 px-4">Proof</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($payments as $p): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap"> <?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?> </td>
                                <td class="py-3 px-4"> <?= htmlspecialchars(strtoupper($p['program'])) ?> </td>
                                <td class="py-3 px-4"> <?= $p['program'] === 'MA' ? htmlspecialchars($p['ma_focus']) : '-' ?> </td>
                                <td class="py-3 px-4"> <?= htmlspecialchars(ucfirst($p['mode_of_study'])) ?> </td>
                                <td class="py-3 px-4 whitespace-nowrap">₦<?= number_format($p['amount']) ?></td>
                                <td class="py-3 px-4">
                                    <?php if (!empty($p['file_path'])): ?>
                                        <a href="<?= htmlspecialchars($p['file_path']) ?>" target="_blank" class="text-blue-600 underline">View</a>
                                    <?php else: ?>
                                        <span class="text-gray-400">None</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded text-white text-xs <?=
                                        $p['status'] === 'approved' ? 'bg-green-600' :
                                        ($p['status'] === 'rejected' ? 'bg-red-600' : 'bg-yellow-500') ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if ($p['status'] === 'pending'): ?>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <button onclick="handleAction('approve', <?= $p['id'] ?>)"
                                                    class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">Approve</button>
                                            <button onclick="handleAction('reject', <?= $p['id'] ?>)"
                                                    class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">Reject</button>
                                        </div>
                                    <?php else: ?>
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Processed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const programFilter = document.getElementById('filterProgram');
        const modeFilter = document.getElementById('filterMode');
        const tableRows = document.querySelectorAll('#paymentTable tbody tr');

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const program = programFilter.value.toLowerCase();
            const mode = modeFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = [...cells].map(td => td.textContent.toLowerCase()).join(' ');
                const matchSearch = rowText.includes(search);
                const matchProgram = !program || rowText.includes(program);
                const matchMode = !mode || rowText.includes(mode);
                row.style.display = matchSearch && matchProgram && matchMode ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        programFilter.addEventListener('change', filterTable);
        modeFilter.addEventListener('change', filterTable);

        function handleAction(type, id) {
            let title = type === 'approve' ? 'Approve Payment' : 'Reject Payment';
            let inputLabel = type === 'approve' ? 'Optional approval note:' : 'Reason for rejection:';
            let isRequired = type === 'reject';

            Swal.fire({
                title,
                input: 'textarea',
                inputLabel,
                inputPlaceholder: 'Write your message here... (optional)',
                inputAttributes: { required: isRequired },
                showCancelButton: true,
                confirmButtonText: type === 'approve' ? 'Approve' : 'Reject',
                confirmButtonColor: type === 'approve' ? '#16a34a' : '#dc2626',
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('ajax/tuition_action.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            id,
                            action: type,
                            note: result.value || ''
                        })
                    }).then(res => res.json()).then(data => {
                        Swal.fire({
                            icon: data.status,
                            title: data.status === 'success' ? 'Done!' : 'Error',
                            text: data.message,
                            confirmButtonColor: '#6B21A8'
                        }).then(() => window.location.reload());
                    });
                }
            });
        }
    </script>
</body>
</html>