$(document).ready(function () {
    // 1. إضافة صف جديد للمواد عند الضغط على الزر
    $('#addCourse').click(function () {
        // نأخذ نسخة من الصف الأول
        var row = $('.course-row').first().clone();
        // تصفير القيم في الصف الجديد
        row.find('input[type="text"]').val('');
        row.find('input[type="number"]').val('');
        // إضافة زر الحذف للصف الجديد
        row.append('<div class="col-auto"><button type="button" class="btn btn-danger remove-row">X</button></div>');
        $('#courses').append(row);
    });

    // 2. حذف الصف عند الضغط على زر X
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.course-row').remove();
    });

    // 3. معالجة إرسال البيانات (Form Submission) عبر AJAX
    $('#gpaForm').submit(function (e) {
        e.preventDefault(); // منع إعادة تحميل الصفحة

        $.ajax({
            url: 'calculate_ajax.php', // الملف الذي يعالج البيانات في الخلفية
            type: 'POST',
            data: $(this).serialize(), // تحويل بيانات النموذج إلى صيغة قابلة للإرسال
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // عرض النتيجة وشريط التقدم في منطقة النتيجة
                    $('#result').html('<div class="alert alert-success">تم الحفظ بنجاح!</div>' + response.progressHtml);
                } else {
                    $('#result').html('<div class="alert alert-danger">خطأ: ' + response.message + '</div>');
                }
            },
            error: function () {
                $('#result').html('<div class="alert alert-danger">حدث خطأ أثناء الاتصال بالسيرفر.</div>');
            }
        });
    });
});