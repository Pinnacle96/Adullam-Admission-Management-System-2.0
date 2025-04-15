<?php
//session_start();
require 'db.php';
include 'dashboard_logic.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch student profile
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch academic details and admission_no
$details = $pdo->prepare("SELECT d.*, a.admission_no FROM application_details d
JOIN applications a ON d.user_id = a.user_id WHERE d.user_id = ?");
$details->execute([$user_id]);
$appDetails = $details->fetch();

// Fetch uploaded documents
$doc = $pdo->prepare("SELECT * FROM application_documents WHERE user_id = ?");
$doc->execute([$user_id]);
$docs = $doc->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $pdo->prepare("UPDATE users SET email = ?, phone = ? WHERE id = ?")
        ->execute([$email, $phone, $user_id]);

    echo "<script>
        localStorage.setItem('profile_updated', '1');
        window.location.href = 'profile.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - Adullam Seminary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <?php include 'components/student_sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 w-full max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-purple-800">👤 My Profile</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Info -->
            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden border">
                        <?php if (!empty($docs['passport'])): ?>
                            <img src="<?= htmlspecialchars($docs['passport']) ?>" alt="Profile Photo"
                                class="object-cover w-full h-full">
                        <?php else: ?>
                            <div class="bg-gray-200 w-full h-full flex items-center justify-center text-sm text-gray-500">
                                No Image</div>
                            n <?php endif; ?>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($user['first_name']) ?></h2>
                        <p class="text-sm text-gray-500">Admission No:
                            <strong><?= $appDetails['admission_no'] ?? 'N/A' ?></strong>
                        </p>
                    </div>
                </div>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">Phone</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <button type="submit" name="save"
                        class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800">💾 Save
                        Changes</button>
                </form>
            </div>

            <!-- Academic Info -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">📚 Academic Info</h3>
                <ul class="space-y-2 text-sm">
                    <li><strong>Program:</strong> <?= htmlspecialchars($appDetails['program'] ?? 'N/A') ?></li>
                    <?php if (($appDetails['program'] ?? '') === 'MA'): ?>
                        <li><strong>MA Focus:</strong> <?= htmlspecialchars($appDetails['ma_focus'] ?? 'N/A') ?></li>
                    <?php endif; ?>
                    <li><strong>Mode of Study:</strong>
                        <?= htmlspecialchars($appDetails['mode_of_study'] ?? 'N/A') ?></li>
                    <li><strong>Permanent Address:</strong>
                        <?= htmlspecialchars($appDetails['perm_address'] ?? 'N/A') ?></li>
                    <li><strong>Residential Address:</strong>
                        <?= htmlspecialchars($appDetails['res_address'] ?? 'N/A') ?></li>
                </ul>

                <hr class="my-4">
                <h3 class="text-md font-medium text-purple-700">📎 Documents</h3>
                <ul class="mt-2 space-y-1">
                    <?php
                    foreach ($docs as $docName => $path) {
                        if (in_array($docName, ['user_id', 'created_at', 'passport'])) continue;
                        if (!empty($path)) {
                            echo "<li class='flex justify-between items-center'>
                                        <span>" . ucwords(str_replace('_', ' ', $docName)) . "</span>
                                        <a href='" . htmlspecialchars($path) . "' download class='text-sm text-purple-700 underline'>Download</a>
                                      </li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>
    </div>

    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 640 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });

        if (localStorage.getItem('profile_updated')) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Your profile has been updated successfully.',
                confirmButtonColor: '#6B21A8'
            });
            localStorage.removeItem('profile_updated');
        }
    </script>
    </body>

</html>