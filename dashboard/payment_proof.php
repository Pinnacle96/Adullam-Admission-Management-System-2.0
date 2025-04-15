<?php
//session_start();
require 'db.php';
require 'dashboard_logic.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Only allow admitted students
$statusStmt = $pdo->prepare("SELECT status FROM applications WHERE user_id = ?");
$statusStmt->execute([$user_id]);
$appStatus = $statusStmt->fetchColumn();

if ($appStatus !== 'admitted') {
    $_SESSION['error'] = "Only admitted students can upload tuition payments.";
    header("Location: dashboard.php");
    exit;
}

// Handle upload
$uploadSuccess = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = trim($_POST['amount'] ?? '');
    $reference = trim($_POST['reference'] ?? '');

    if (!$amount || !$reference || !is_numeric($amount)) {
        $error = "Amount and reference are required and must be valid.";
    } elseif (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
        $error = "Payment proof is required.";
    } else {
        $file = $_FILES['payment_proof'];
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $error = "Invalid file type. Only PDF, JPG, JPEG, PNG allowed.";
        } elseif ($file['size'] > 5 * 1024 * 1024) {
            $error = "File size exceeds 5MB limit.";
        } else {
            $uploadDir = 'uploads/tuition/';
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0775, true);
            $filePath = $uploadDir . uniqid('tuition_') . "." . $ext;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $stmt = $pdo->prepare("INSERT INTO tuition_payment (user_id, file_path, amount, reference) VALUES (?, ?, ?, ?)");
                $stmt->execute([$user_id, $filePath, $amount, $reference]);
                $uploadSuccess = true;
            } else {
                $error = "File upload failed.";
            }
        }
    }
}

// Fetch previous uploads
$payments = $pdo->prepare("SELECT * FROM tuition_payment WHERE user_id = ? ORDER BY uploaded_at DESC");
$payments->execute([$user_id]);
$history = $payments->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Tuition Payment</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>
<body class="bg-gray-100 min-h-screen">
  <?php include 'components/student_sidebar.php'; ?>
  <main class="flex-1 p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-purple-800 mb-6">💳 Upload Tuition Payment Proof</h1>

    <?php if ($uploadSuccess): ?>
      <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded mb-4">Upload successful!</div>
    <?php elseif ($error): ?>
      <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Amount (₦)</label>
        <input type="number" name="amount" required step="0.01" min="0" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Reference</label>
        <input type="text" name="reference" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Payment Proof (PDF/JPG/PNG, max 5MB)</label>
        <input type="file" name="payment_proof" required class="w-full border p-2 rounded">
      </div>
      <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-2 rounded shadow">📤 Submit Payment</button>
    </form>

    <div class="mt-10">
      <h2 class="text-lg font-bold text-purple-700 mb-4">📜 Payment History</h2>
      <?php if (empty($history)): ?>
        <p class="text-sm text-gray-600">No tuition payments uploaded yet.</p>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full text-sm table-auto border">
            <thead>
              <tr class="bg-gray-200">
                <th class="px-3 py-2 text-left">Amount (₦)</th>
                <th class="px-3 py-2 text-left">Reference</th>
                <th class="px-3 py-2 text-left">Date</th>
                <th class="px-3 py-2 text-left">Status</th>
                <th class="px-3 py-2">File</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($history as $pay): ?>
                <tr class="border-t">
                  <td class="px-3 py-2"><?= number_format($pay['amount'], 2) ?></td>
                  <td class="px-3 py-2"><?= htmlspecialchars($pay['reference']) ?></td>
                  <td class="px-3 py-2"><?= date('d M Y, h:ia', strtotime($pay['uploaded_at'])) ?></td>
                  <td class="px-3 py-2 capitalize <?= $pay['status'] === 'rejected' ? 'text-red-600' : ($pay['status'] === 'approved' ? 'text-green-600' : 'text-yellow-600') ?>">
                    <?= $pay['status'] ?>
                  </td>
                  <td class="px-3 py-2 text-center">
                    <a href="<?= $pay['file_path'] ?>" target="_blank" class="text-purple-700 underline">View</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>
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
