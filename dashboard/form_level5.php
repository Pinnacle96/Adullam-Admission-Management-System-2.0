<?php
session_start();
require 'db.php';
require_once 'mailer.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
// 🔍 Fetch applicant's full name
$stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$applicant = $stmt->fetch();
$fullName = trim($applicant['first_name'] . ' ' . $applicant['last_name']);


// Function to generate secure token
function generateToken($length = 40)
{
    return bin2hex(random_bytes($length / 2));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref1Name = trim($_POST['ref1Name']);
    $ref1Phone = trim($_POST['ref1Phone']);
    $ref1Email = trim($_POST['ref1Email']);
    $ref2Name = trim($_POST['ref2Name']);
    $ref2Phone = trim($_POST['ref2Phone']);
    $ref2Email = trim($_POST['ref2Email']);

    // ✅ Save reference info
    $stmt = $pdo->prepare("INSERT INTO application_references (
    user_id, ref1Name, ref1Phone, ref1Email, ref2Name, ref2Phone, ref2Email
  ) VALUES (?, ?, ?, ?, ?, ?, ?)
  ON DUPLICATE KEY UPDATE
    ref1Name = VALUES(ref1Name),
    ref1Phone = VALUES(ref1Phone),
    ref1Email = VALUES(ref1Email),
    ref2Name = VALUES(ref2Name),
    ref2Phone = VALUES(ref2Phone),
    ref2Email = VALUES(ref2Email)");

    $stmt->execute([$user_id, $ref1Name, $ref1Phone, $ref1Email, $ref2Name, $ref2Phone, $ref2Email]);

    // ✅ Prepare reference list
    $referees = [
        ['email' => $ref1Email, 'name' => $ref1Name],
        ['email' => $ref2Email, 'name' => $ref2Name],
    ];

    foreach ($referees as $ref) {
        $token = generateToken();

        // 🧠 Insert or update token for referee
        $pdo->prepare("INSERT INTO application_recommendations 
      (user_id, referee_email, referee_name, token) 
      VALUES (?, ?, ?, ?) 
      ON DUPLICATE KEY UPDATE token = VALUES(token)")
            ->execute([$user_id, $ref['email'], $ref['name'], $token]);

        $subject = "📩 Recommendation Request – Adullam Seminary";
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        $body = "
<div style='font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;max-width:600px;margin:auto;padding:20px;background-color:#f9fafb;border-radius:8px;border:1px solid #eee;'>
  <div style='text-align:center;margin-bottom:30px;'>
    <img src='127.0.0.1/adullam.ng/assets/img/logo.png' alt='Adullam Seminary' style='height:60px;' />
    <h2 style='color:#6B21A8;margin:10px 0 0;'>Adullam Seminary Admissions</h2>
  </div>

  <p style='font-size:16px;color:#111;'>Dear <strong>" . htmlspecialchars($ref['name']) . "</strong>,</p>

  <p style='font-size:15px;color:#333;line-height:1.6;'>
  You have been listed as a referee by <strong>$fullName</strong>, an applicant to <strong>Adullam Seminary</strong>.
  We kindly request your support in completing a recommendation form on their behalf.
</p>


  <p style='font-size:15px;color:#333;line-height:1.6;'>Please click the button below to securely submit your recommendation:</p>

  <div style='text-align:center;margin:30px 0;'>
    <a href='127.0.0.1/adullam.ng/dashboard/recommend.php?token=$token'
       style='background-color:#6B21A8;color:white;padding:12px 24px;
              text-decoration:none;border-radius:6px;font-weight:bold;
              display:inline-block;'>Submit Recommendation</a>
  </div>

  <p style='font-size:14px;color:#555;line-height:1.5;'>
    Or copy and paste this link into your browser:<br>
    <a href='127.0.0.1/adullam.ng/dashboard/recommend.php?token=$token' style='color:#6B21A8;word-break:break-all;'>
      127.0.0.1/adullam.ng/dashboard/recommend.php?token=$token
    </a>
  </p>

  <hr style='margin:30px 0;border:none;border-top:1px solid #ddd;' />

  <p style='font-size:13px;color:#666;text-align:center;line-height:1.5;'>
    Thank you for taking the time to support the academic journey of our applicants.<br>
    <strong>Adullam Admissions Team</strong><br>
    <a href='mailto:admissions@adullam.ng' style='color:#6B21A8;'>admissions@adullam.ng</a> | 
    <a href='https://adullam.ng' style='color:#6B21A8;'>www.adullam.ng</a>
  </p>
</div>
";

        // Debug: Log the email body
        file_put_contents('ref_email_body.txt', $body);

        // Send email with corrected arguments
        $result = sendMail($ref['email'], $ref['name'], $subject, $body);

        // Debug: Log the result
        file_put_contents('ref_email_result.txt', print_r($result, true));

        // Check if the email failed to send
        if ($result === false) {
            if ($result === false) {
                error_log("Failed to send email to {$ref['email']}: Unable to send email.");
            } else {
                error_log("Failed to send email to {$ref['email']}: " . (is_array($result) ? $result['message'] : 'Unknown error.'));
            }
        }
    }

    // 🔀 Navigation
    if (isset($_POST['continue'])) {
        $pdo->prepare("UPDATE applications SET current_level = 6 WHERE user_id = ?")->execute([$user_id]);
        echo "<script>window.location.href = 'form_level6.php';</script>";
    } elseif (isset($_POST['save'])) {
        echo "<script>
      localStorage.setItem('form5_saved', '1');
      window.location.href = 'form_level5.php';
    </script>";
    } elseif (isset($_POST['previous'])) {
        echo "<script>window.location.href = 'form_level4.php';</script>";
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application - Step 5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-4xl">
        <h2 class="text-xl font-bold text-purple-800 mb-2 text-center">Step 5: Reference Information</h2>

        <form method="POST" class="space-y-6">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 1 Name</label>
                    <input type="text" name="ref1Name" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 1 Phone</label>
                    <input type="text" name="ref1Phone" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 1 Email</label>
                    <input type="email" name="ref1Email" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 pt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 2 Name</label>
                    <input type="text" name="ref2Name" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 2 Phone</label>
                    <input type="text" name="ref2Phone" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference 2 Email</label>
                    <input type="email" name="ref2Email" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-purple-600 focus:border-purple-600" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6">
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
    if (localStorage.getItem('form5_saved')) {
        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: 'Your references have been saved.',
            confirmButtonColor: '#6B21A8'
        });
        localStorage.removeItem('form5_saved');
    }
    </script>
</body>

</html>