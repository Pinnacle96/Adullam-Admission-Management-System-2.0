<?php
session_start();

// 🔐 Only logged-in students allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

// Get app state
$hasApp = $_SESSION['has_application'] ?? false;
$currentLevel = $_SESSION['current_level'] ?? 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adullam Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white rounded-lg shadow-lg p-6 sm:p-10 max-w-xl w-full text-center">
        <h1 class="text-2xl sm:text-3xl font-bold text-purple-800 mb-4">Welcome,
            <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
        <p class="text-gray-600 text-sm sm:text-base">Redirecting you to your application form...</p>
    </div>

    <?php if (!$hasApp): ?>
        <!-- Show modal if application not started -->
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: '📘 Application Requirements',
                    width: window.innerWidth < 600 ? '90%' : '800px',
                    html: `
        <div class="text-left text-sm text-gray-800 max-h-96 overflow-y-auto px-2">
          <h3 class="font-semibold text-purple-700 mb-1">🎓 Undergraduate Programmes</h3>
          <ul class="list-disc ml-5 space-y-1">
            <li>A recent passport photograph</li>
            <li>💵 $10 non-refundable application fee proof of payment (<a href="account_details.pdf" target="_blank" class="text-purple-600 underline">Download account details</a>)</li>
            <li><strong>Academic Credentials</strong>
              <ul class="list-disc ml-5 mt-1">
                <li><strong>Certificate</strong> – SSCE or equivalent</li>
                <li><strong>Diploma</strong> – SSCE with 3 credits including English</li>
                <li><strong>B.Div</strong> – SSCE with 5 credits including English</li>
              </ul>
            </li>
            <li>📱 Phone numbers and email of two referees</li>
            <li>📜 One recommendation letter from a clergy (<a href="clergy_template.pdf" target="_blank" class="text-purple-600 underline">Download Template</a>)</li>
            <li>🌍 International students must secure a resident permit from the Nigerian Embassy</li>
          </ul>

          <h3 class="font-semibold text-purple-700 mt-4 mb-1">🎓 Postgraduate Programmes</h3>
          <ul class="list-disc ml-5 space-y-1">
            <li>A recent passport photograph</li>
            <li>💵 $20 non-refundable application fee proof of payment (<a href="account_details.pdf" target="_blank" class="text-purple-600 underline">Download account details</a>)</li>
            <li><strong>Academic Credentials</strong>
              <ul class="list-disc ml-5 mt-1">
                <li><strong>PGDT</strong> – Bachelor’s degree or HND in any field</li>
                <li><strong>MA</strong> – PGDT Certificate or Seminary Bachelor's + official transcript</li>
              </ul>
            </li>
            <li>📱 Phone numbers and email of two referees</li>
            <li>📜 One recommendation letter from a clergy (<a href="clergy_template.pdf" target="_blank" class="text-purple-600 underline">Download Template</a>)</li>
            <li>🌍 International students must secure a resident permit from the Nigerian Embassy</li>
          </ul>
        </div>
      `,
                    confirmButtonText: 'Begin Application',
                    confirmButtonColor: '#6B21A8'
                }).then(() => {
                    window.location.href = 'form_level1.php';
                });
            });
        </script>
    <?php else: ?>
        <!-- Auto resume if already started -->
        <script>
            window.location.href = "form_level<?= intval($currentLevel) ?>.php";
        </script>
    <?php endif; ?>

</body>

</html>