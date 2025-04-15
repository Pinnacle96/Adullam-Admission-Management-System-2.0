<?php
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

function generateAdmissionLetter($userId, $pdo)
{
    $stmt = $pdo->prepare("SELECT u.first_name, u.last_name, d.program, d.ma_focus, d.mode_of_study, a.admission_no
                            FROM users u
                            JOIN application_details d ON u.id = d.user_id
                            JOIN applications a ON a.user_id = u.id
                            WHERE u.id = ?");
    $stmt->execute([$userId]);
    $data = $stmt->fetch();

    if (!$data) return false;

    $fullName = $data['first_name'] . ' ' . $data['last_name'];
    $programCode = strtoupper($data['program']);
    $maFocus = $data['ma_focus'];
    $modeOfStudy = ucfirst($data['mode_of_study'] ?? 'Online');
    $admissionNo = $data['admission_no'];

    // Program mappings
    $programMap = [
        'MA' => ['name' => 'Master of Arts', 'duration' => '24 months'],
        'PGDT' => ['name' => 'Postgraduate Diploma', 'duration' => '10 months'],
        'B.DIV' => ['name' => 'Bachelor of Divinity', 'duration' => '4 years'],
        'DIPLOMA' => ['name' => 'Diploma in Theology', 'duration' => '3 years'],
        'CERTIFICATE' => ['name' => 'Certificate in Theology', 'duration' => '1 year'],
    ];

    $programLabel = $programMap[$programCode]['name'] ?? $programCode;
    $programDuration = $programMap[$programCode]['duration'] ?? 'N/A';

    // Embedded logo
    $logoPath = realpath(__DIR__ . '/../../assets/img/logo1.png');
    $logoSrc = $logoPath && file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : 'https://adullam.ng/assets/img/logo1.png';

    // Registrar Signature
    $signPath = realpath(__DIR__ . '/../../assets/img/signature.png');
    $signSrc = $signPath && file_exists($signPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($signPath))
        : '';

    // Output location
    $outputDir = realpath(__DIR__ . '/../letters/admission_letters');
    if (!$outputDir) {
        $outputDir = __DIR__ . '/../letters/admission_letters';
        mkdir($outputDir, 0775, true);
    }

    $letterPath = $outputDir . "/{$userId}.pdf";

    $html = "
    <html>
    <head><meta charset='UTF-8'></head>
    <body style='font-family:Arial,sans-serif;font-size:13px;line-height:1.7;color:#333;padding:40px;'>
        <div style='text-align:center;margin-bottom:30px;'>
            <img src='$logoSrc' style='height:70px;'><br>
            <h2 style='color:#6B21A8;'>RCN Theological Seminary – Adullam</h2>
            <p style='font-size:14px;font-weight:bold;'>Admission Letter</p>
        </div>

        <p>Dear <strong>$fullName</strong>,</p>

        <p>
            We are pleased to inform you that the Admissions Committee of 
            <strong>Remnant Christian Network Theological Seminary - Adullam</strong> 
            has approved your application for provisional admission to the 
            <strong>$programLabel</strong>" .
        ($programCode === 'MA' ? " (<em>$maFocus</em>)" : "") .
        " program, commencing on <strong>23rd June, 2025</strong>.
        </p>

        <p>
            We congratulate you on your academic achievements and welcome you to our academic community.
        </p>

        <p><strong>Below are the details of your admission:</strong></p>
        <ul>
            <li><strong>Admission Number:</strong> $admissionNo</li>
            <li><strong>Program:</strong> $programLabel</li>" .
        ($programCode === 'MA' ? "<li><strong>Focus Area:</strong> $maFocus</li>" : "") . "
            <li><strong>Start Date:</strong> June 23rd, 2025</li>
            <li><strong>Learning Option:</strong> $modeOfStudy</li>
            <li><strong>Duration:</strong> $programDuration</li>
        </ul>

        <p>
            Please note that your admission is <strong>contingent upon</strong> your ability to provide documentation of your academic credentials and other required documents.
            A <strong>60% non-refundable deposit</strong> of the session fee must be paid before resumption.
        </p>

        <p>
            We have attached a comprehensive guide to help you prepare for your program. Please review it carefully and contact us if you have any questions.
        </p>

        <p>Once again, <strong>congratulations on your admission</strong>.</p>

        <div style='margin-top:50px;'>
            " . ($signSrc ? "<img src='$signSrc' style='height:50px;'><br>" : "") . "
            <strong>Olajide Bakare</strong><br>
            Registrar<br>
            RCNTS – Adullam
        </div>
    </body>
    </html>";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    file_put_contents($letterPath, $dompdf->output());

    return true;
}
