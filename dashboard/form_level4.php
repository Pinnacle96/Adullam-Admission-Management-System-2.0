<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qgospel = trim($_POST['qgospel']);
    $sgrowth = trim($_POST['sgrowth']);
    $callto  = trim($_POST['callto']);

    $stmt = $pdo->prepare("INSERT INTO application_autobiography (
    user_id, qgospel, sgrowth, callto
  ) VALUES (?, ?, ?, ?)
  ON DUPLICATE KEY UPDATE 
    qgospel = VALUES(qgospel),
    sgrowth = VALUES(sgrowth),
    callto = VALUES(callto)");

    $stmt->execute([$user_id, $qgospel, $sgrowth, $callto]);

    if (isset($_POST['continue'])) {
        $pdo->prepare("UPDATE applications SET current_level = 5 WHERE user_id = ?")
            ->execute([$user_id]);
        echo "<script>window.location.href = 'form_level5.php';</script>";
    } elseif (isset($_POST['save'])) {
        echo "<script>
      localStorage.setItem('form4_saved', '1');
      window.location.href = 'form_level4.php';
    </script>";
    } elseif (isset($_POST['previous'])) {
        echo "<script>window.location.href = 'form_level3.php';</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Application - Step 4</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-4xl">
        <h2 class="text-xl font-bold text-purple-800 mb-2 text-center">Step 4: Autobiography</h2>
        <p class="text-sm text-center text-gray-600 mb-4">
            In your own words, briefly describe the following. Please do not copy/paste answers. Applications from 3rd
            parties are not permitted.
        </p>

        <form method="POST" class="space-y-6">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">How would you explain the gospel of Jesus
                    Christ?<span class="text-red-500">*</span></label>
                <textarea name="qgospel" required rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Your conversion and spiritual growth:<span
                        class="text-red-500">*</span></label>
                <textarea name="sgrowth" required rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Call to ministry and/or reason for
                    applying:<span class="text-red-500">*</span></label>
                <textarea name="callto" required rows="4"
                    class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                <button type="submit" name="previous"
                    class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg shadow">⬅
                    Previous</button>
                <button type="submit" name="save"
                    class="w-full sm:w-auto bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg shadow">💾
                    Save for Later</button>
                <button type="submit" name="continue"
                    class="w-full sm:w-auto bg-purple-700 hover:bg-purple-800 text-white px-6 py-2 rounded-lg shadow">Next
                    ➡</button>
            </div>
        </form>
    </div>

    <script>
        if (localStorage.getItem('form4_saved')) {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Your responses were saved successfully.',
                confirmButtonColor: '#6B21A8'
            });
            localStorage.removeItem('form4_saved');
        }
    </script>
</body>

</html>