<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student GPA Calculator_project1 - Step 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f8f9fa; padding-top: 50px; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Student GPA Calculator</h2>
    
    <form id="gpaForm">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="student_name" class="form-control" placeholder="Student Name" required>
            </div>
            <div class="col">
                <input type="text" name="semester" class="form-control" placeholder="Semester (e.g., S3)" required>
            </div>
        </div>

        <div id="courses">
            <div class="course-row form-row mb-2">
                <div class="col"><input type="text" name="course[]" class="form-control" placeholder="Course name" required></div>
                <div class="col-2"><input type="number" name="credits[]" class="form-control" placeholder="Credits" min="1" required></div>
                <div class="col-2">
                    <select name="grade[]" class="form-control">
                        <option value="4.0">A</option>
                        <option value="3.0">B</option>
                        <option value="2.0">C</option>
                        <option value="1.0">D</option>
                        <option value="0.0">F</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="button" id="addCourse" class="btn btn-secondary mt-2">+ Add Student Course</button>
        <button type="submit" class="btn btn-primary mt-2">Calculate & Save</button>
        <a href="export_csv.php" class="btn btn-outline-success mt-2">Export to CSV</a>
    </form>

    <div id="result" class="mt-4"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // إضافة صف جديد للمواد
    $('#addCourse').click(function () {
        var row = $('.course-row').first().clone();
        row.find('input').val('');
        row.append('<div class="col-auto"><button type="button" class="btn btn-danger remove-row">X</button></div>');
        $('#courses').append(row);
    });

    // حذف الصف
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.course-row').remove();
    });

    // إرسال البيانات عبر AJAX
    $('#gpaForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'calculate_ajax.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#result').html('<div class="alert alert-success">Result Saved Successfully!</div>' + response.progressHtml);
                }
            }
        });
    });
});
</script>
</body>
</html>
