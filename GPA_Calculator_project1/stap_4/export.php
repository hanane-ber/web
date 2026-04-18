<?php
if (isset($_POST['course'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="GPA_Report.csv"');

    $output = fopen('php://output', 'w');
    // إضافة العناوين
    fputcsv($output, array('Course Name', 'Credits', 'Grade Points'));

    // إضافة المواد
    foreach ($_POST['course'] as $key => $val) {
        fputcsv($output, array($val, $_POST['credits'][$key], $_POST['grade'][$key]));
    }
    fclose($output);
    exit;
}
?>