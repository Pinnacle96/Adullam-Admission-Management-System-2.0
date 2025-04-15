<?php
session_start();
require_once 'db.php';
require_once 'mailer.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['superadmin', 'admin'])) {
    die("Unauthorized access.");
}

// 🔄 Fetch sender info from settings
$getSetting = fn($key) => $pdo->query("SELECT value FROM settings WHERE `key` = '$key'")->fetchColumn();
$senderName = $getSetting('sender_name') ?? 'Adullam Seminary';
$senderEmail = $getSetting('sender_email') ?? 'support@adullam.ng';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject']);
    $body = trim($_POST['message']);
    $target = $_POST['audience'];

    if (!$subject || !$body || !$target) {
        $error = "Please fill all fields.";
    } else {
        // 🔎 Get recipients
        $query = "SELECT first_name, last_name, email FROM users WHERE role = 'student'";
        if ($target === 'admitted') {
            $query .= " AND id IN (SELECT user_id FROM applications WHERE status = 'admitted')";
        } elseif ($target === 'submitted') {
            $query .= " AND id IN (SELECT user_id FROM applications WHERE submitted = 1 AND (status IS NULL OR status != 'admitted'))";
        } elseif ($target === 'rejected') {
            $query .= " AND id IN (SELECT user_id FROM applications WHERE status = 'rejected')";
        }

        $stmt = $pdo->query($query);
        $recipients = $stmt->fetchAll();
        $logo = 'https://adullam.ng/assets/img/logo1.png'; // 🖼️ Hosted logo URL

        $wrappedBody = nl2br(htmlspecialchars($body)); // 🛡️ Secure & line-break-friendly

        $formattedBody = "
<div style='font-family:Segoe UI, sans-serif; padding: 20px; max-width: 600px; margin:auto; background:#ffffff; border:1px solid #e0e0e0; border-radius:8px;'>
  <div style='text-align:center; margin-bottom: 20px;'>
    <img src='$logo' alt='Adullam Logo' style='height: 60px; margin-bottom: 10px;'>
    <h2 style='color:#6B21A8;'>Broadcast from $senderName</h2>
  </div>

  <div style='background:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #ddd; font-size:15px; color:#333; line-height:1.6;'>
    $wrappedBody
  </div>

  <p style='font-size:15px; color:#333; line-height:1.6; margin-top: 20px;'>
    Thank you for choosing Adullam.
  </p>

  <p style='font-size:15px; color:#333; line-height:1.6; margin-bottom:30px;'>
    Warm regards,<br />
    <strong>Adullam Admissions Committee</strong>
  </p>

  <hr style='margin:20px 0; border:none; border-top:1px solid #ddd;' />

  <p style='font-size:13px; color:#888; text-align:center;'>
    For questions, contact <a href='mailto:admissions@adullam.ng' style='color:#6B21A8;'>admissions@adullam.ng</a><br />
    &copy; " . date('Y') . " Adullam Seminary – All rights reserved.
  </p>
</div>
";


        $sent = 0;
        foreach ($recipients as $r) {
            $toName = $r['first_name'] . ' ' . $r['last_name'];
            if (sendMail($r['email'], $toName, $subject, $formattedBody, $senderEmail, $senderName)) {
                $sent++;
            }
        }

        echo "
        <html><head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <meta http-equiv='refresh' content='3;url=broadcast_email.php' />
        </head><body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Emails Sent!',
                    text: 'Broadcast sent to $sent recipients.',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        </body></html>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Broadcast Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include 'components/navbar.php'; ?>
    <div class="flex">
        <?php include 'components/sidebar.php'; ?>

        <main class="flex-1 p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-purple-800 mb-6">📧 Broadcast Email</h1>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="bg-white shadow p-6 rounded-xl space-y-6">
                <!-- Audience -->
                <div>
                    <label class="block mb-1 font-semibold">Target Audience</label>
                    <select name="audience" required class="w-full p-2 border rounded">
                        <option value="">-- Select Audience --</option>
                        <option value="all">All Applicants</option>
                        <option value="admitted">Only Admitted</option>
                        <option value="submitted">Submitted (Not Admitted)</option>
                        <option value="rejected">Rejected Applicants</option>
                    </select>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block mb-1 font-semibold">Subject</label>
                    <input type="text" name="subject" class="w-full p-2 border rounded" required>
                </div>

                <!-- Message -->
                <div>
                    <label class="block mb-1 font-semibold">Message</label>
                    <textarea name="message" rows="8" class="w-full p-2 border rounded"
                        placeholder="Dear Applicant, orientation starts on Monday..." required></textarea>
                    <p class="text-sm text-gray-500 mt-1">You can type normally. We’ll format it into a beautiful email.
                    </p>
                </div>

                <div>
                    <button type="submit" class="bg-purple-700 text-white px-6 py-2 rounded hover:bg-purple-800">
                        🚀 Send Broadcast
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>