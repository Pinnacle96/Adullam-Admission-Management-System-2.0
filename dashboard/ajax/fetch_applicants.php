<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    http_response_code(403);
    exit('Access denied');
}

$search = $_GET['search'] ?? '';
$program = $_GET['program'] ?? '';
$ma_focus = $_GET['ma_focus'] ?? '';
$moderate = isset($_GET['moderate']) && $_GET['moderate'] === 'true';

$params = [];
$where = ["u.role = 'student'"];

if (!empty($search)) {
    $where[] = "(u.first_name LIKE :first OR u.last_name LIKE :last OR LOWER(u.email) LIKE LOWER(:email))";
    $params[':first'] = "%$search%";
    $params[':last'] = "%$search%";
    $params[':email'] = "%$search%";
}

if (!empty($program)) {
    $where[] = "ad.program = :program";
    $params[':program'] = $program;
}

if (!empty($ma_focus) && $program === 'MA') {
    $where[] = "ad.ma_focus = :ma_focus";
    $params[':ma_focus'] = $ma_focus;
}

// ✅ Filter only submitted applications when moderating
// ✅ Filter only submitted applications when moderating
if ($moderate) {
    $where[] = "(a.status = 'submitted' OR (a.status IS NULL AND a.submitted = 1))";
}


$sql = "SELECT u.id,
               CONCAT_WS(' ', u.first_name, u.middle_name, u.last_name) AS full_name,
               u.email,
               a.status,
               a.submitted_at,
               ad.program,
               ad.ma_focus,
               ad.mode_of_study
        FROM users u
        LEFT JOIN applications a ON u.id = a.user_id
        LEFT JOIN application_details ad ON u.id = ad.user_id";

if (count($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= " ORDER BY a.submitted_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$showMAFocus = !empty(array_filter($applicants, fn($a) => $a['program'] === 'MA'));
?>

<div class="overflow-x-auto bg-white shadow-md rounded-xl">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-600">
        <thead class="bg-purple-800 text-white text-xs uppercase tracking-wider">
            <tr>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Name</th>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Email</th>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Program</th>
                <?php if ($showMAFocus): ?>
                    <th class="px-4 sm:px-6 py-3 whitespace-nowrap">MA Focus</th>
                <?php endif; ?>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Status</th>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Mode of Study</th>
                <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($applicants)): ?>
                <?php foreach ($applicants as $a): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 sm:px-6 py-4 text-gray-900 whitespace-nowrap">
                            <?= htmlspecialchars($a['full_name']) ?>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($a['email']) ?></td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($a['program'] ?? '-') ?></td>
                        <?php if ($showMAFocus): ?>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <?= $a['program'] === 'MA' ? htmlspecialchars($a['ma_focus'] ?? '-') : '-' ?>
                            </td>
                        <?php endif; ?>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <?php
                            $status = $a['status'] ?? 'Not Started';
                            $badgeColor = match ($status) {
                                'admitted' => 'green',
                                'rejected' => 'red',
                                'submitted' => 'blue',
                                default => 'gray'
                            };
                            ?>
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-<?= $badgeColor ?>-100 text-<?= $badgeColor ?>-800">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap"><?= $a['mode_of_study'] ?? '-' ?></td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <a href="applicant_view.php?id=<?= $a['id'] ?>" class="text-purple-700 hover:underline text-sm">🔍
                                View</a>
                            <a href="generate_review_sheet.php?id=<?= $a['id'] ?>" target="_blank"
                                class="text-indigo-700 hover:underline text-sm">🧾 Review Sheet</a>
                                <a href="javascript:void(0);"
   onclick="confirmDelete(<?= $a['id'] ?>)"
   class="text-red-600 hover:underline text-sm">
   🗑️ Delete
</a>



                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if ($moderate && empty($applicants)): ?>
                    <tr>
                        <td colspan="<?= $showMAFocus ? '7' : '6' ?>" class="px-6 py-4 text-center">
                            <div class="text-yellow-800 bg-yellow-100 p-3 rounded text-sm">
                                ⚠ No applications awaiting moderation (status = 'submitted').
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $showMAFocus ? '7' : '6' ?>" class="px-6 py-4 text-center text-gray-500">
                            No matching applicants found.
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_application.php?id=' + id;
        }
    })
}
</script>
