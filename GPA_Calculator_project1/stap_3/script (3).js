// عند الضغط على زر إضافة مادة
$("#addRow").click(function () {
    $("#table tbody").append(`
        <tr>
            <td>
                <input type="text" name="course[]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="credits[]" class="form-control" required>
            </td>
            <td>
                <select name="grade[]" class="form-control">
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>F</option>
                </select>
            </td>
        </tr>
    `);
});

// عند إرسال الفورم
$("#gpaForm").submit(function (e) {
    e.preventDefault(); // منع إعادة تحميل الصفحة

    $.ajax({
        url: "calculate.php",       // الملف الذي يحسب GPA
        type: "POST",
        data: $(this).serialize(),  // إرسال كل البيانات
        success: function (response) {
            // عرض النتيجة داخل الصفحة
            $("#result").html(response);
        }
    });
});