<?php
header('Content-Type: application/json');

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "gpa_db");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

if (isset($_POST['course'])) {
    $totalPoints = 0;
    $totalCredits = 0;

    foreach ($_POST['credits'] as $key => $credit) {
        $c = floatval($credit);
        $g = floatval($_POST['grade'][$key]);
        $totalPoints += ($c * $g);
        $totalCredits += $c;
    }

    $gpa = ($totalCredits > 0) ? round($totalPoints / $totalCredits, 2) : 0;
    
    // حفظ في قاعدة البيانات
    $name = htmlspecialchars($_POST['student_name']);
    $semester = htmlspecialchars($_POST['semester']);
    
    $stmt = $conn->prepare("INSERT INTO gpa_records (student_name, semester, gpa) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $semester, $gpa);
    $stmt->execute();

    // تحديد الدرجة الوصفية
    $status = ($gpa >= 3.7) ? "Distinction" : (($gpa >= 3.0) ? "Merit" : (($gpa >= 2.0) ? "Pass" : "Fail"));

    echo json_encode([
        'success' => true,
        'gpa' => $gpa,
        'message' => "Saved! Student: $name | GPA: $gpa ($status)"
    ]);
}
$conn->close();
?>