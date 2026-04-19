<?php
require_once 'db_config.php';

if (isset($_POST['course'])) {
    $totalPoints = 0; $totalCredits = 0;
    // حساب الـ GPA
    for ($i = 0; $i < count($_POST['course']); $i++) {
        $cr = floatval($_POST['credits'][$i]);
        $g = floatval($_POST['grade'][$i]);
        $totalPoints += ($cr * $g);
        $totalCredits += $cr;
    }
    $gpa = ($totalCredits > 0) ? ($totalPoints / $totalCredits) : 0;

    // حفظ البيانات للطالب
    $sql = "INSERT INTO gpa_records (student_name, semester, computed_gpa) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['student_name'], $_POST['semester'], $gpa]);

    // تحديد ألوان الـ Progress Bar
    $color = ($gpa >= 3.7) ? 'bg-success' : (($gpa >= 3.0) ? 'bg-info' : (($gpa >= 2.0) ? 'bg-warning' : 'bg-danger'));
    $percent = ($gpa / 4.0) * 100;

    echo json_encode([
        'success' => true,
        'progressHtml' => "<div class='progress' style='height: 25px;'><div class='progress-bar $color' style='width: $percent%'>GPA: ".number_format($gpa, 2)."</div></div>"
    ]);
}
?>
