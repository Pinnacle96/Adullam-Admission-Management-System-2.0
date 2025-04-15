<?php
session_start();
require_once 'db.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid applicant ID.");
}

$id = (int) $_GET['id'];

// Fetch applicant full data
$stmt = $pdo->prepare("SELECT u.*, a.*, ad.*, ap.*, ac.*, ar.*
    FROM users u
    LEFT JOIN applications a ON u.id = a.user_id
    LEFT JOIN application_details ad ON u.id = ad.user_id
    LEFT JOIN application_personal ap ON u.id = ap.user_id
    LEFT JOIN application_church ac ON u.id = ac.user_id
    LEFT JOIN application_references ar ON u.id = ar.user_id
    WHERE u.id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Applicant not found.");
}

// Fetch recommendation texts
$recs = $pdo->prepare("SELECT referee_name, recommendation FROM application_recommendations WHERE user_id = ? AND submitted = 1");
$recs->execute([$id]);
$recommendations = $recs->fetchAll(PDO::FETCH_ASSOC);

// Load logo
$logoPath = realpath(__DIR__ . '/../assets/img/logo1.png');
$logoData = base64_encode(file_get_contents($logoPath));
$logoMime = mime_content_type($logoPath);
$logoSrc = "data:$logoMime;base64,$logoData";

// Render HTML
ob_start();
?>
<html>

<head>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
    }

    h1,
    h2,
    h3 {
        color: #4B0082;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    td,
    th {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .section-title {
        background: #eee;
        padding: 6px;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 20px">
        <img src="<?= $logoSrc ?>" style="height: 60px;">
        <h2>Adullam Seminary – Application Review Sheet</h2>
    </div>

    <h3>📌 Applicant Info</h3>
    <table>
        <tr>
            <th>Full Name</th>
            <td><?= htmlspecialchars($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']) ?>
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($data['email']) ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?= htmlspecialchars($data['phone']) ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?= htmlspecialchars($data['gender']) ?></td>
        </tr>
        <tr>
            <th>DOB</th>
            <td><?= htmlspecialchars($data['dob']) ?></td>
        </tr>
        <tr>
            <th>Program</th>
            <td><?= htmlspecialchars($data['program']) ?></td>
        </tr>
        <?php if ($data['program'] === 'MA'): ?>
        <tr>
            <th>MA Focus</th>
            <td><?= htmlspecialchars($data['ma_focus']) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th>Mode of Study</th>
            <td><?= htmlspecialchars($data['mode_of_study']) ?></td>
        </tr>
    </table>

    <h3>🏛 Church Info</h3>
    <table>
        <tr>
            <th>Church Name</th>
            <td><?= htmlspecialchars($data['church_name']) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($data['caddress']) ?></td>
        </tr>
    </table>

    <h3>🧬 Personal/Character Info</h3>
    <table>
        <tr>
            <th>Marital Status</th>
            <td><?= $data['maritalstatus'] ?></td>
        </tr>
        <tr>
            <th>Children</th>
            <td><?= $data['children'] ?></td>
        </tr>
        <tr>
            <th>Medical Disclosure</th>
            <td><?= $data['dhealth'] ?></td>
        </tr>
        <tr>
            <th>Disciplinary History</th>
            <td><?= $data['disciplinary'] ?></td>
        </tr>
        <tr>
            <th>Other Issues</th>
            <td>Bank: <?= $data['fbank'] ?> | Drug: <?= $data['drug'] ?> | Felony: <?= $data['felony'] ?></td>
        </tr>
    </table>

    <h3>🧾 Referees</h3>
    <table>
        <tr>
            <th>Referee 1</th>
            <td><?= $data['ref1Name'] ?> (<?= $data['ref1Phone'] ?> | <?= $data['ref1Email'] ?>)</td>

        </tr>
        <tr>
            <th>Referee 2</th>
            <td><?= $data['ref2Name'] ?> (<?= $data['ref2Phone'] ?> | <?= $data['ref2Email'] ?>)</td>

        </tr>
    </table>

    <?php if (count($recommendations)): ?>
    <h3>📢 Submitted Recommendations</h3>
    <?php foreach ($recommendations as $r): ?>
    <p><strong><?= $r['referee_name'] ?>:</strong><br><?= nl2br(htmlspecialchars($r['recommendation'])) ?></p>
    <?php endforeach; ?>
    <?php endif; ?>

    <h3>🖋 Signature</h3>
    <p style="margin-top: 40px;">__________________________<br>Reviewer Signature</p>
</body>

</html>
<?php
$html = ob_get_clean();

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("application_review_sheet_{$id}.pdf", ["Attachment" => false]);
exit; ?>