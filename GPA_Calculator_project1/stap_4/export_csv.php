<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="student_report.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Course Name', 'Credits', 'Grade Points']);

// استقبال البيانات المرسلة من النموذج عبر الـ Session أو POST
if(isset($_POST['course'])){
    for ($i = 0; $i < count($_POST['course']); $i++) {
        fputcsv($output, [$_POST['course'][$i], $_POST['credits'][$i], $_POST['grade'][$i]]);
    }
}
fclose($output);
?>
