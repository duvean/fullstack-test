$(function () {
    var form = $('#comment-form');
    var notice = $('#notice');

    function clearErrors() {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
    }

    function showErrors(errors) {
        clearErrors();
        $.each(errors, function (field, message) {
            var input = form.find('[name="' + field + '"]');
            input.addClass('is-invalid').siblings('.invalid-feedback').text(message);
        });
    }

    function showNotice(message, type) {
        notice.removeClass('d-none alert-success alert-danger').addClass('alert-' + type).text(message);
    }

    form.on('submit', function (event) {
        event.preventDefault();
        clearErrors();
        var email = $('#name');
        if (!email[0].checkValidity()) {
            showErrors({ name: 'Введите корректный e-mail.' });
            email.trigger('focus');
            return;
        }
        if (!$('#date').val()) {
            showErrors({ date: 'Выберите дату комментария.' });
            return;
        }
        if (!$.trim($('#text').val())) {
            showErrors({ text: 'Напишите текст комментария.' });
            return;
        }

        var button = $('#submit-comment').prop('disabled', true).text('Публикуем…');
        $.ajax({ url: form.attr('action'), method: 'POST', data: form.serialize() })
            .done(function (response) {
                showNotice(response.message, 'success');
                window.setTimeout(function () { window.location.reload(); }, 450);
            })
            .fail(function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showErrors(xhr.responseJSON.errors);
                } else {
                    showNotice('Не удалось отправить комментарий. Попробуйте ещё раз.', 'danger');
                }
            })
            .always(function () { button.prop('disabled', false).html('Опубликовать комментарий <span aria-hidden="true">→</span>'); });
    });

    $(document).on('click', '.delete-comment', function () {
        var button = $(this);
        if (!window.confirm('Удалить этот комментарий?')) return;
        button.prop('disabled', true).text('Удаляем…');
        $.ajax({ url: window.commentsUrl + '/' + button.data('id'), method: 'DELETE' })
            .done(function (response) { showNotice(response.message, 'success'); window.setTimeout(function () { window.location.reload(); }, 350); })
            .fail(function () { showNotice('Не удалось удалить комментарий.', 'danger'); button.prop('disabled', false).text('Удалить'); });
    });
});
