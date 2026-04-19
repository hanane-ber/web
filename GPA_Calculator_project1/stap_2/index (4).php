<?php
$gpa = "";
$message = "";

if (isset($_POST['course'])) {
    $course  = $_POST['course'];
    $credits = $_POST['credits'];
    $grade   = $_POST['grade'];

    $total_points  = 0;
    $total_credits = 0;

    for ($i = 0; $i < count($course); $i++) {
        // تحويل الدرجة إلى نقاط
        switch ($grade[$i]) {
            case "A": $point = 4; break;
            case "B": $point = 3; break;
            case "C": $point = 2; break;
            case "D": $point = 1; break;
            default:  $point = 0;
        }

        $total_points  += $point * $credits[$i];
        $total_credits += $credits[$i];
    }

    // حساب المعدل
    if ($total_credits > 0) {
        $gpa = $total_points / $total_credits;
    }

    // تحديد النتيجة
    if ($gpa >= 3.7) {
        $message = "Distinction";
    } elseif ($gpa >= 3) {
        $message = "Merit";
    } elseif ($gpa >= 2) {
        $message = "Pass";
    } else {
        $message = "Fail";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GPA Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        table {
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border: 1px solid black;
        }
        h2, h3 {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<h2>GPA Calculator</h2>

<?php if ($gpa !== ""): ?>
    <h3>GPA = <?= round($gpa, 2); ?></h3>
    <h3>Result: <?= $message; ?></h3>
<?php endif; ?>

<form method="post">
    <table>
        <tr>
            <th>Course</th>
            <th>Credits</th>
            <th>Grade</th>
        </tr>
        <tr>
            <td><input type="text" name="course[]" required></td>
            <td><input type="number" name="credits[]" required></td>
            <td>
                <select name="grade[]">
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>F</option>
                </select>
            </td>
        </tr>
    </table>
    <br>
    <button type="submit">Calculate GPA</button>
</form>

</body>
</html>