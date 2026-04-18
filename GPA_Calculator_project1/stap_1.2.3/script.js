$(document).ready(function () {
    $('#addCourse').click(function () {
        var row = $('.course-row').first().clone();
        row.find('input').val('');
        row.find('.col:last').append('<button type="button" class="btn btn-danger remove-row ml-2">X</button>');
        $('#courses').append(row);
    });

    $(document).on('click', '.remove-row', function () {
        $(this).closest('.course-row').remove();
    });

    $('#gpaForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'calculate.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#result').html('<div class="alert alert-info">' + response.message + '</div>' + response.tableHtml);
                } else {
                    $('#result').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            }
        });
    });
});
