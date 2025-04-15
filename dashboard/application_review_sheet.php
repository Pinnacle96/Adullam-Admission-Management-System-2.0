<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    die("Unauthorized access.");
}

$user_id = $_GET['id'] ?? null;
if (!$user_id) die("Missing applicant ID");

// Fetch applicant
$stmt = $pdo->prepare("SELECT u.*, 
    CONCAT_WS(' ', u.first_name, u.middle_name, u.last_name) AS full_name,
    ad.*, a.admission_no, a.status, a.submitted_at 
    FROM users u
    LEFT JOIN application_details ad ON u.id = ad.user_id
    LEFT JOIN applications a ON u.id = a.user_id
    WHERE u.id = ?");
$stmt->execute([$user_id]);
$applicant = $stmt->fetch();

if (!$applicant) die("Applicant not found");

// Fetch supporting sections
$docs = $pdo->query("SELECT * FROM application_documents WHERE user_id = $user_id")->fetch();
$church = $pdo->query("SELECT * FROM application_church WHERE user_id = $user_id")->fetch();
$auto = $pdo->query("SELECT * FROM application_autobiography WHERE user_id = $user_id")->fetch();
$personal = $pdo->query("SELECT * FROM application_personal WHERE user_id = $user_id")->fetch();
$references = $pdo->query("SELECT * FROM application_references WHERE user_id = $user_id")->fetch();
$recs = $pdo->query("SELECT * FROM application_recommendations WHERE user_id = $user_id")->fetchAll();

// Load logo as base64
$logoPath = __DIR__ . "/../assets/img/logo1.png";
$logoData = base64_encode(file_get_contents($logoPath));
$logoMime = mime_content_type($logoPath);
$logoSrc = "data:$logoMime;base64,$logoData";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Application Review Sheet</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            margin: 30px;
            color: #333;
        }

        h1,
        h2 {
            color: #6B21A8;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .row {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            width: 180px;
            display: inline-block;
        }

        .value {
            display: inline-block;
        }

        .recommendation {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 5px;
        }

        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="<?= $logoSrc ?>" style="height: 80px;"><br>
        <h1>Adullam RCN Theological Seminary</h1>
        <p><strong>Application Review Sheet</strong></p>
    </div>

    <div class="section">
        <h2>🧑 Personal Info</h2>
        <div class="row"><span class="label">Full Name:</span> <span class="value"><?= $applicant['full_name'] ?></span>
        </div>
        <div class="row"><span class="label">Email:</span> <span class="value"><?= $applicant['email'] ?></span></div>
        <div class="row"><span class="label">Phone:</span> <span class="value"><?= $applicant['phone'] ?></span></div>
        <div class="row"><span class="label">Gender / DOB:</span> <span class="value"><?= $applicant['gender'] ?> /
                <?= $applicant['dob'] ?></span></div>
        <div class="row"><span class="label">Program:</span> <span class="value"><?= $applicant['program'] ?></span>
        </div>
        <?php if ($applicant['program'] === 'MA'): ?>
            <div class="row"><span class="label">MA Focus:</span> <span class="value"><?= $applicant['ma_focus'] ?></span>
            </div>
        <?php endif; ?>
        <div class="row"><span class="label">Mode of Study:</span> <span
                class="value"><?= ucfirst($applicant['mode_of_study']) ?></span></div>
        <div class="row"><span class="label">Status:</span> <span
                class="value"><?= ucfirst($applicant['status']) ?></span></div>
    </div>

    <div class="section">
        <h2>📖 Autobiography</h2>
        <div class="row"><span class="label">Gospel Experience:</span> <span
                class="value"><?= $auto['qgospel'] ?? '-' ?></span></div>
        <div class="row"><span class="label">Spiritual Growth:</span> <span
                class="value"><?= $auto['sgrowth'] ?? '-' ?></span></div>
        <div class="row"><span class="label">Call to Ministry:</span> <span
                class="value"><?= $auto['callto'] ?? '-' ?></span></div>
    </div>

    <div class="section">
        <h2>🏠 Address</h2>
        <div class="row"><span class="label">Residential:</span> <span class="value"><?= $applicant['res_address'] ?>,
                <?= $applicant['res_city'] ?>, <?= $applicant['res_state'] ?>, <?= $applicant['res_country'] ?></span>
        </div>
        <div class="row"><span class="label">Permanent:</span> <span class="value"><?= $applicant['perm_address'] ?>,
                <?= $applicant['perm_city'] ?>, <?= $applicant['perm_state'] ?>,
                <?= $applicant['perm_country'] ?></span></div>
    </div>

    <div class="section">
        <h2>⛪ Church Info</h2>
        <div class="row"><span class="label">Name:</span> <span
                class="value"><?= $church['church_name'] ?? '-' ?></span></div>
        <div class="row"><span class="label">Address:</span> <span
                class="value"><?= $church['caddress'] ?? '-' ?></span></div>
    </div>

    <div class="section">
        <h2>👥 Referees</h2>
        <?php if ($references): ?>
            <div class="row"><span class="label">Referee 1:</span> <span class="value"><?= $references['ref1Name'] ?>
                    (<?= $references['ref1Email'] ?>)</span></div>
            <div class="row"><span class="label">Referee 2:</span> <span class="value"><?= $references['ref2Name'] ?>
                    (<?= $references['ref2Email'] ?>)</span></div>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>📄 Recommendations</h2>
        <?php foreach ($recs as $rec): ?>
            <div class="recommendation">
                <strong><?= $rec['referee_name'] ?></strong> (<?= $rec['referee_email'] ?>)<br>
                <?= $rec['submitted'] ? "<p>" . nl2br(htmlspecialchars($rec['recommendation'])) . "</p>" : "<em>Not yet submitted</em>" ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="noprint" style="text-align:center; margin-top: 40px;">
        <button onclick="window.print()"
            style="padding:10px 20px; background:#6B21A8; color:#fff; border:none; border-radius:6px;">🖨️ Print
            Sheet</button>
    </div>
</body>

</html>