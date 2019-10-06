jQuery(document).ready(function ($) {
    $('body').on('click', '.dvf-show-multiply-list', function () {
        let listElement = $(this).parent().find('.dvf-multiply-list'),
            arrowIconElement = $(this).find('.arrow-icon');

        listElement.toggleClass('open');
        arrowIconElement.toggleClass('open');

        return false;
    });

    $('body').on('change', '.dvf-multiply-list input[type="checkbox"]', function () {
        prepareTitles($(this).closest('tr'));
    });
});

function changeToMultiplyPicker(key, target, title) {
    let target_line = $('input[name="' + target + '"]').closest('tr');

    if (target_line.length) {
        loadMultiplyPicker(target_line, key, target, title);
    }
}

function loadMultiplyPicker(line, key, target, title) {
    let data = {
        action: 'dvf_multiple_list',
        data: 'key=' + key + '&user_id=' + $('#user_id').val(),
    };

    $.post(DokanVendorsAdmin.ajaxUrl, data, function (resp) {
        if (resp.success) {
            line.hide();

            line.after(resp.data);

            let newLineElement = line.next();

            newLineElement.data('target', target);
            newLineElement.find('th').text(title);

            newLineElement.find('form.dvf-new-element-form').submit(function (e) {
                let formElement = $(this),
                    newElement = formElement.find('input[name="dvf_new_element"]'),
                    submitButton = formElement.find('input[type="submit"]'),
                    data = {
                        action: 'dvf_add_multiply_element',
                        data: 'key=' + key
                            + '&user_id=' + $('#user_id').val()
                            + '&dvf_new_element=' + newElement.val(),
                    };

                $('.dvf-error-text').remove();

                if (0 === newElement.val().length) {
                    formElement.append('<span class="dvf-error-text">Please, set new element name</span>');
                    return false;
                }

                if (newLineElement.find('input[value="' + newElement.val() + '"]').length) {
                    formElement.append('<span class="dvf-error-text">Element exist</span>');
                    return false;
                }

                submitButton.prop('disabled', true);
                $.post(DokanVendorsAdmin.ajaxUrl, data, function (resp) {
                    if (resp.success) {
                        formElement.before(resp.data);
                        newElement.val('');
                        prepareTitles(newLineElement);
                    } else {
                        formElement.append('<span class="dvf-error-text">' + resp.data + '</span>');
                    }

                    submitButton.prop('disabled', false);
                });

                return false;
            });

            prepareTitles(newLineElement);
        }
    });
}

function prepareTitles(line) {
    let title = '',
        key = line.data('key'),
        checkedInputs = line.find('input[name="dvf_' + key + '[]"]:checked'),
        i = 0;

    checkedInputs.each(function () {
        if (0 < i) {
            title += ', ';
        }

        if (0 === i) {
            setFirstToDokanDefault(line, $(this).val());
        }

        title += $(this).val();

        if (36 < title.length) {
            title = title.substr(0, 38) + ' ... (' + checkedInputs.length + ')';
            return false;
        }

        i++;
    });

    if (0 === i) {
        title = 'Nothing';
        setFirstToDokanDefault(line, '');
    }

    line.find('.dvf-multiply-title').html(title);
}

function setFirstToDokanDefault(line, value) {
    let target = line.data('target');

    $('input[name="' + target + '"]').val(value);
}