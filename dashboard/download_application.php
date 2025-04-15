<?php
require '../vendor/autoload.php';
require 'db.php';
session_start();

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    die('Unauthorized access');
}

$user_id = $_SESSION['user_id'];

// Fetch all needed application data
$queries = [
    'details' => "SELECT * FROM application_details WHERE user_id = ?",
    'personal' => "SELECT * FROM application_personal WHERE user_id = ?",
    'church' => "SELECT * FROM application_church WHERE user_id = ?",
    'auto' => "SELECT * FROM application_autobiography WHERE user_id = ?",
    'refs' => "SELECT * FROM application_references WHERE user_id = ?",
    'docs' => "SELECT * FROM application_documents WHERE user_id = ?",
    'user' => "SELECT * FROM users WHERE id = ?",
    'application' => "SELECT admission_no, status FROM applications WHERE user_id = ?"
];

$data = [];
foreach ($queries as $key => $sql) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $data[$key] = $stmt->fetch();
}

// Logo and Passport
$logoPath = realpath(__DIR__ . '/../assets/img/logo1.png');
$logoSrc = $logoPath ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';

$passportPath = $data['docs']['passport'] ?? '';
$passportSrc = file_exists($passportPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($passportPath)) : null;
$signPath = realpath(__DIR__ . '/../assets/img/signature.png');
$signatureSrc = $signPath ? 'data:image/png;base64,' . base64_encode(file_get_contents($signPath)) : '';

function formatRow($label, $value)
{
    return "<tr>
        <td style='padding:6px 10px;border-bottom:1px solid #eee;'><strong>" . htmlspecialchars($label) . "</strong></td>
        <td style='padding:6px 10px;border-bottom:1px solid #eee;'>" . nl2br(htmlspecialchars($value ?? '—')) . "</td>
    </tr>";
}

// Begin HTML
$html = "<html><head><meta charset='UTF-8'>
<style>
body { font-family: 'Segoe UI', sans-serif; font-size: 12px; color: #333; }
.section { margin-bottom: 30px; }
.title { font-size: 14px; font-weight: bold; color: #6B21A8; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 4px; }
table { width: 100%; border-collapse: collapse; }
.footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 11px; color: #777; }
.page-break { page-break-after: always; }

td { vertical-align: top; }
</style>
</head><body>

<!-- Header -->
<table width='100%' style='margin-bottom: 25px;'>
  <tr>
    <td colspan='2' align='center'>
      <img src='$logoSrc' style='height: 60px;'><br/>
      <h2 style='color:#6B21A8;margin:0;'>RCN Theological Seminary – Adullam</h2>
      <p style='margin:0;'>Application Form Summary</p>
    </td>
  </tr>
  <tr>
    <td>
      <strong>Admission No:</strong> " . htmlspecialchars($data['application']['admission_no'] ?? 'N/A') . "<br/>
      <strong>Status:</strong> " . ucfirst($data['application']['status'] ?? 'Draft') . "
    </td>
    <td align='right'>" .
    ($passportSrc ? "<img src='$passportSrc' style='width:100px;height:100px;border:1px solid #ccc;border-radius:6px;object-fit:cover;'>" : '') .
    "</td>
  </tr>
</table>

<!-- Basic Details -->
<div class='section'>
  <div class='title'>Program Details</div>
  <table>
    " . formatRow('Program', $data['details']['program'] ?? '') . "
    " . ($data['details']['program'] === 'MA' ? formatRow('Focus Area (if MA)', $data['details']['ma_focus'] ?? '-') : '') . "
    " . formatRow('Mode of Study', $data['details']['mode_of_study'] ?? '') . "
    " . formatRow('Permanent Address', $data['details']['perm_address'] ?? '') . "
    " . formatRow('Residential Address', $data['details']['res_address'] ?? '') . "
    " . formatRow('State of Residence', $data['details']['res_state'] ?? '') . "
    " . formatRow('Country of Residence', $data['details']['res_country'] ?? '') . "
  </table>
</div>

<!-- Personal Info -->
<div class='section'>
  <div class='title'>Personal Information</div>
  <table>
    " . formatRow('Full Name', $data['user']['first_name'] . ' ' . $data['user']['last_name']) . "
    " . formatRow('Email', $data['user']['email']) . "
    " . formatRow('Phone', $data['user']['phone']) . "
    " . formatRow('Gender', $data['details']['gender']) . "
    " . formatRow('Date of Birth', $data['details']['dob']) . "
    " . formatRow('Marital Status', $data['personal']['maritalstatus']) . "
    " . formatRow('Children', $data['personal']['children']) . "
    " . formatRow('Disability', $data['personal']['dhealth']) . "
    " . formatRow('Disciplinary Issues', $data['personal']['disciplinary']) . "
    " . formatRow('Mental Health', $data['personal']['mental_health']) . "
    " . formatRow('Bank Fraud', $data['personal']['fbank']) . "
    " . formatRow('Drug Abuse', $data['personal']['drug']) . "
    " . formatRow('Employment Issues', $data['personal']['employment']) . "
    " . formatRow('Felony', $data['personal']['felony']) . "
    " . formatRow('Sexual Misconduct', $data['personal']['smisconduct']) . "
    " . formatRow('Spiritual Offence', $data['personal']['soffence']) . "
    " . formatRow('Divorce', $data['personal']['divource']) . "
  </table>
</div>

<!-- Church Info -->
<div class='section'>
  <div class='title'>Church Information</div>
  <table>
    " . formatRow('Church Name', $data['church']['church_name']) . "
    " . formatRow('Church Address', $data['church']['caddress']) . "
  </table>
</div>

<!-- Autobiography -->
<div class='section'>
  <div class='title'>Spiritual Journey</div>
  <table>
    " . formatRow('Gospel Explanation', $data['auto']['qgospel']) . "
    " . formatRow('Spiritual Growth', $data['auto']['sgrowth']) . "
    " . formatRow('Call to Ministry', $data['auto']['callto']) . "
  </table>
</div>

<!-- References -->
<div class='section'>
  <div class='title'>References</div>
  <table>
    " . formatRow('Referee 1', "{$data['refs']['ref1Name']} | {$data['refs']['ref1Phone']} | {$data['refs']['ref1Email']}") . "
    " . formatRow('Referee 2', "{$data['refs']['ref2Name']} | {$data['refs']['ref2Phone']} | {$data['refs']['ref2Email']}") . "
  </table>
</div>
<div class='section'>
  <div class='title'>Uploaded Documents</div>
  <table>";

$docLabels = [
    'ssce_cert' => 'SSCE Certificate',
    'birth_cert' => 'Birth Certificate',
    'origin_cert' => 'Certificate of Origin',
    'recommendation' => 'Recommendation Letter',
    'payment_proof' => 'Proof of Payment',
    'degree_cert' => 'Degree Certificate',
    'transcript' => 'Academic Transcript'
];
foreach ($docLabels as $key => $label) {
    $filename = $data['docs'][$key] ? basename($data['docs'][$key]) : 'Not uploaded';
    $html .= formatRow($label, $filename);
}
$html .= "
  </table>

<<div class='section'>
  <div class='title'>Registrar's Signature</div>
  <img src='$signatureSrc' alt='Signature' style='height: 50px;'><br/>
  <p style='font-size:12px;color:#555;'>Adullam Seminary Registrar</p>
</div>

<div class='footer'>&copy; " . date('Y') . " Adullam Seminary – All rights reserved.</div>

</body></html>";

// Generate PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = "Adullam_Application_" . $data['user']['first_name'] . ".pdf";
$dompdf->stream($filename, ["Attachment" => false]);
