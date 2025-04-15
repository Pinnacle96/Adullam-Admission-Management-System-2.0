<?php
session_start();
require 'db.php';
require 'mailer.php';
require '../vendor/autoload.php'; // for dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $econtact = $_POST['econtact'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $blood = $_POST['blood'] ?? '';
    $genotype = $_POST['genotype'] ?? '';
    $dob = $_POST['dob'] ?? null;
    $age = $_POST['age'] ?? null;
    $nationality = $_POST['nationality'] ?? '';
    $marital = $_POST['marital'] ?? '';
    $sname = $_POST['sname'] ?? '';
    $scont = $_POST['scont'] ?? '';
    $program = $_POST['program'] ?? '';
    $year = $_POST['academic_year'] ?? null;
    $semester = $_POST['semester'] ?? '';

    $res_address = $_POST['res_address'] ?? '';
    $res_city = $_POST['res_city'] ?? '';
    $res_state = $_POST['res_state'] ?? '';
    $res_country = $_POST['res_country'] ?? '';
    $perm_address = $_POST['perm_address'] ?? '';
    $perm_city = $_POST['perm_city'] ?? '';
    $perm_state = $_POST['perm_state'] ?? '';
    $perm_country = $_POST['perm_country'] ?? '';

    $gname = $_POST['gname'] ?? '';
    $grelation = $_POST['grelation'] ?? '';
    $gcontact = $_POST['gcontact'] ?? '';

    $fee_amount = $_POST['fee'] ?? '';

    function uploadFile($file, $fieldName) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $maxSize = 900 * 1024;

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => "File upload error for $fieldName."];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            return ['success' => false, 'message' => "Invalid file type for $fieldName."];
        }

        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => "$fieldName exceeds size limit (900KB)."];
        }

        $dir = 'uploads/hostel/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filename = uniqid($fieldName . '_') . '.' . $ext;
        $targetPath = $dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => false, 'message' => "Failed to move uploaded file for $fieldName."];
        }

        return ['success' => true, 'path' => $targetPath];
    }

    $passportUpload = uploadFile($_FILES['passport'] ?? null, 'passport');
    $feesUpload = uploadFile($_FILES['fees'] ?? null, 'fees');

    if (!$passportUpload['success'] || !$feesUpload['success']) {
        $_SESSION['error'] = $passportUpload['message'] ?? $feesUpload['message'];
        header("Location: register_hostel.php");
        exit;
    }

    $logoPath = base64_encode(file_get_contents('../assets/img/logo1.png'));
    $passportPath = base64_encode(file_get_contents($passportUpload['path']));

    $html = "<html><head><meta charset='UTF-8'></head><body style='font-family:sans-serif;'>
        <div style='text-align:center;'>
            <img src='data:image/png;base64,$logoPath' style='width:100px;'><br>
            <h2>Hostel Registration Confirmation</h2>
        </div>
        <p><strong>Name:</strong> $full_name<br>
           <strong>Email:</strong> $email<br>
           <strong>Phone:</strong> $contact<br>
           <strong>Emergency Contact:</strong> $econtact<br>
           <strong>Gender:</strong> $gender<br>
           <strong>Date of Birth:</strong> $dob<br>
           <strong>Age:</strong> $age<br>
           <strong>Blood Group:</strong> $blood<br>
           <strong>Genotype:</strong> $genotype<br>
           <strong>Nationality:</strong> $nationality<br>
           <strong>Marital Status:</strong> $marital<br>
           <strong>Spouse:</strong> $sname ($scont)</p>
        <p><strong>Program:</strong> $program<br>
           <strong>Academic Year:</strong> $year<br>
           <strong>Semester:</strong> $semester</p>
        <p><strong>Residential Address:</strong> $res_address, $res_city, $res_state, $res_country<br>
           <strong>Permanent Address:</strong> $perm_address, $perm_city, $perm_state, $perm_country</p>
        <p><strong>Guardian:</strong> $gname ($grelation, $gcontact)</p>
        <p><strong>Amount Paid:</strong> ₦$fee_amount</p>
        <div><strong>Passport:</strong><br>
            <img src='data:image/jpeg;base64,$passportPath' style='width:100px;height:100px;border:1px solid #ccc;'>
        </div>
    </body></html>";

    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();

    $pdfDir = 'uploads/hostel_pdfs/';
    if (!is_dir($pdfDir)) mkdir($pdfDir, 0755, true);

    $pdfPath = $pdfDir . 'hostel_' . ($_SESSION['user_id'] ?? 'guest') . '.pdf';
    file_put_contents($pdfPath, $dompdf->output());

    $stmt = $pdo->prepare("INSERT INTO hostel_applications (
        user_id, full_name, email, contact, emergency_contact, gender, blood_group, genotype,
        dob, age, nationality, marital_status, spouse_name, spouse_contact,
        program, academic_year, semester,
        res_address, res_city, res_state, res_country,
        perm_address, perm_city, perm_state, perm_country,
        guardian_name, guardian_relation, guardian_contact,
        passport_file, fees_file, fee_amount, pdf_file, created_at
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW()
    )");

    $stmt->execute([
        $_SESSION['user_id'] ?? null,
        $full_name, $email, $contact, $econtact, $gender, $blood, $genotype,
        $dob, $age, $nationality, $marital, $sname, $scont,
        $program, $year, $semester,
        $res_address, $res_city, $res_state, $res_country,
        $perm_address, $perm_city, $perm_state, $perm_country,
        $gname, $grelation, $gcontact,
        $passportUpload['path'], $feesUpload['path'], $fee_amount, $pdfPath
    ]);

    $subject = "Hostel Registration Confirmation";
    $body = "<p style='font-family:sans-serif;'>Dear $full_name,</p>
            <p>Your hostel registration was received <strong>successfully</strong> 🎉</p>
            <p>Program: <strong>$program</strong><br>
               Semester: <strong>$semester</strong><br>
               Nationality: <strong>$nationality</strong></p>
            <p>You may download your confirmation PDF at any time.</p>
            <p style='margin-top:20px;'>With warm regards,<br><strong>Adullam Seminary</strong></p>";

    sendMail($email, 'Adullam Seminary', $subject, $body);

    $_SESSION['success'] = "Your hostel registration has been submitted.";
    echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <script>
        window.onload = function() {
            window.open('$pdfPath', '_blank');
            setTimeout(function() {
                window.location.href = 'register_hostel.php?success=1';
            }, 1000);
        }
    </script>
</head>
<body></body>
</html>";
exit;

}
?>
