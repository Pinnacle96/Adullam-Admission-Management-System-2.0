<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=applicants_export_" . date("Y-m-d") . ".xls");

require_once 'export_helpers.php';

echo "<table border='1'>";
echo "<tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th> <!-- ✅ Added -->
        <th>Program</th>
        <th>MA Focus</th>
         <th>Mode of Study</th>
        <th>Status</th>
       
      </tr>";

foreach ($applicants as $a) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($a['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($a['email']) . "</td>";
    echo "<td>" . htmlspecialchars($a['phone'] ?? '-') . "</td>"; // ✅ Added
    echo "<td>" . htmlspecialchars($a['program']) . "</td>";
    echo "<td>" . ($a['program'] === 'MA' ? htmlspecialchars($a['ma_focus']) : '-') . "</td>";
    echo "<td>" . htmlspecialchars($a['mode_of_study']) . "</td>";
    echo "<td>" . ucfirst($a['status']) . "</td>";
    echo "</tr>";
}

echo "</table>";
