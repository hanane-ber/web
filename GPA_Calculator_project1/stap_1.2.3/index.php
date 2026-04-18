<?php
$result = "";
$tableHtml = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courses = $_POST['course'] ?? [];
    $credits = $_POST['credits'] ?? [];
    $grades  = $_POST['grade'] ?? [];

    $totalPoints = 0;
    $totalCredits = 0;

    $tableHtml = "<table class='table table-bordered'>";
    $tableHtml .= "<tr>
        <th>Course</th>
        <th>Credits</th>
        <th>Grade</th>
        <th>Grade Points</th>
    </tr>";

    for ($i = 0; $i < count($courses); $i++) {
        $course = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $g = floatval($grades[$i]);

        if ($cr <= 0) continue;

        $pts = $cr * $g;
        $totalPoints += $pts;
        $totalCredits += $cr;

        $tableHtml .= "<tr>
            <td>$course</td>
            <td>$cr</td>
            <td>$g</td>
            <td>$pts</td>
        </tr>";
    }

    $tableHtml .= "</table>";

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        if ($gpa >= 3.7) {
            $interpretation = "Distinction";
        } elseif ($gpa >= 3.0) {
            $interpretation = "Merit";
        } elseif ($gpa >= 2.0) {
            $interpretation = "Pass";
        } else {
            $interpretation = "Fail";
        }
        $result = "Your GPA is " . number_format($gpa, 2) . " ($interpretation).";
    } else {
        $result = "No valid courses entered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPA Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-primary mb-4">GPA Calculator</h2>

            <?php if ($result != ""): ?>
                <?= $tableHtml ?>
                <p><strong><?= $result ?></strong></p>
            <?php endif; ?>

            <form action="" method="POST">
                <div id="course-list">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="course[]" class="form-control" placeholder="Course name" required>
                        </div>
                        <div class="col">
                            <input type="number" name="credits[]" class="form-control" placeholder="Credits" min="1" required>
                        </div>
                        <div class="col">
                            <select name="grade[]" class="form-select">
                                <option value="4.0">A (4.0)</option>
                                <option value="3.0">B (3.0)</option>
                                <option value="2.0">C (2.0)</option>
                                <option value="1.0">D (1.0)</option>
                                <option value="0.0">F (0.0)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Calculate GPA</button>
            </form>
        </div>
    </div>
</body>
</html>
