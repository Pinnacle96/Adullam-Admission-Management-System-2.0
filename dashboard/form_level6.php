<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Generate CSRF token
// if (!isset($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }
// $csrf_token = $_SESSION['csrf_token'];

// Fetch the user's program
$stmt = $pdo->prepare("SELECT program FROM application_details WHERE user_id = ?");
$stmt->execute([$user_id]);
$userProgram = trim($stmt->fetchColumn() ?: '');

// Check if no program was found
if ($userProgram === '') {
    error_log("No program found for user_id $user_id");
    $_SESSION['error'] = "Program information not found. Please contact support.";
    header("Location: form_level6.php");
    exit;
}

// Check if the program is exactly "MA" or "PGDT" (case-insensitive)
$isPGDTorMA = in_array(strtoupper($userProgram), ['MA', 'PGDT'], true);

// Handle file uploads
function saveFile($file, $field)
{
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxFileSize) {
        return ['success' => false, 'message' => "File size for $field exceeds 5MB limit."];
    }

    $targetDir = "uploads/documents/";
    if (!file_exists($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            error_log("Failed to create directory: $targetDir");
            return ['success' => false, 'message' => "Failed to create upload directory for $field."];
        }
    }

    $fileName = basename($file['name']);
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Set custom allowed formats
    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    if (!in_array($ext, $allowed)) {
        return ['success' => false, 'message' => "Invalid file type for $field. Allowed types: " . implode(', ', $allowed) . "."];
    }

    $newName = uniqid($field . "_") . "." . $ext;
    $targetFile = $targetDir . $newName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return ['success' => true, 'path' => $targetFile];
    }

    error_log("Failed to move uploaded file for $field to $targetFile");
    return ['success' => false, 'message' => "Failed to upload $field. Please try again."];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     $_SESSION['error'] = "CSRF token validation failed.";
    //     header("Location: form_level6.php");
    //     exit;
    // }

    $fields = [
        'passport',
        'ssce_cert',
        'birth_cert',
        'origin_cert',
        'recommendation',
        'payment_proof'
    ];

    if ($isPGDTorMA) {
        $fields[] = 'degree_cert';
        $fields[] = 'transcript';
    }

    $filePaths = [];
    $uploadErrors = [];
    foreach ($fields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $result = saveFile($_FILES[$field], $field);
            if ($result['success']) {
                $filePaths[$field] = $result['path'];
            } else {
                $uploadErrors[] = $result['message'];
            }
        } elseif (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadErrors[] = "Error uploading $field: " . $_FILES[$field]['error'];
        }
    }

    if (!empty($uploadErrors)) {
        $_SESSION['upload_errors'] = $uploadErrors;
    }

    if (!empty($filePaths)) {
        $columns = implode(", ", array_keys($filePaths));
        $placeholders = implode(", ", array_fill(0, count($filePaths), '?'));
        $updates = implode(", ", array_map(fn($f) => "$f = VALUES($f)", array_keys($filePaths)));

        $sql = "INSERT INTO application_documents (user_id, $columns) VALUES (?, $placeholders)
                ON DUPLICATE KEY UPDATE $updates";

        try {
            $stmt = $pdo->prepare($sql);
            if (!$stmt->execute(array_merge([$user_id], array_values($filePaths)))) {
                throw new Exception("Failed to save uploaded documents.");
            }
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            $_SESSION['error'] = "An error occurred while saving your documents. Please try again.";
            header("Location: form_level6.php");
            exit;
        }
    }

    if (isset($_POST['continue'])) {
        try {
            $stmt = $pdo->prepare("UPDATE applications SET current_level = 7 WHERE user_id = ?");
            if (!$stmt->execute([$user_id])) {
                throw new Exception("Failed to update application level.");
            }
            header("Location: preview_application.php");
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            $_SESSION['error'] = "An error occurred while proceeding to the next step. Please try again.";
            header("Location: form_level6.php");
        }
    } elseif (isset($_POST['save'])) {
        $_SESSION['success'] = "Your documents have been saved.";
        header("Location: form_level6.php");
    } elseif (isset($_POST['previous'])) {
        header("Location: form_level5.php");
    }
    exit;
}

// Display error or success messages
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$uploadErrors = $_SESSION['upload_errors'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['upload_errors']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-3xl">
        <h2 class="text-xl font-bold text-purple-800 text-center mb-4">Step 6: Upload Supporting Documents</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- <input type="hidden" name="csrf_token" value="<?//= htmlspecialchars($csrf_token) //?>"> -->

            <?php
            $inputs = [
                'passport' => 'Passport Photograph (JPG, PNG)',
                'ssce_cert' => 'SSCE Certificate (JPG, PNG, PDF)',
                'birth_cert' => 'Birth Certificate (JPG, PNG, PDF)',
                'origin_cert' => 'LGA/State/Nationality Certificate (JPG, PNG, PDF)',
                'recommendation' => 'Recommendation Letter (PDF, DOCX, DOC)',
                'payment_proof' => 'Proof of Payment (JPG, PNG, PDF)'
            ];

            if ($isPGDTorMA) {
                $inputs['degree_cert'] = 'Degree Certificate (JPG, PNG, PDF)';
                $inputs['transcript'] = 'Transcript (JPG, PNG, PDF) – Optional';
            }

            foreach ($inputs as $name => $label):
            ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><?= $label ?></label>
                <input type="file" name="<?= $name ?>" class="w-full border p-2 rounded-md"
                    <?= $name !== 'transcript' ? 'required' : '' ?> />
            </div>
            <?php endforeach; ?>

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
    // Display error messages
    <?php if ($error): ?>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '<?= htmlspecialchars($error) ?>',
        confirmButtonColor: '#6B21A8'
    });
    <?php endif; ?>

    // Display success messages
    <?php if ($success): ?>
    Swal.fire({
        icon: 'success',
        title: 'Saved!',
        text: '<?= htmlspecialchars($success) ?>',
        confirmButtonColor: '#6B21A8'
    });
    <?php endif; ?>

    // Display upload errors
    <?php if (!empty($uploadErrors)): ?>
    Swal.fire({
        icon: 'warning',
        title: 'Upload Issues',
        html: '<?= htmlspecialchars(implode("<br>", $uploadErrors)) ?>',
        confirmButtonColor: '#6B21A8'
    });
    <?php endif; ?>
    </script>
</body>

</html>