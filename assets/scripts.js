jQuery(document).ready(function () {
    var toggleSpeed = 350,
        $ = jQuery;

    $('body').on('click', '.dvf-filter-button a', function () {
        var filterSection = $('.dvf-filter-section');

        filterSection.toggle(toggleSpeed);

        return false;
    });

    $('body').on('click', '.dvf-dropdown-preview', function (e) {
        e.stopPropagation();

        var list = $(this).next(),
            needOpen = !list.is(':visible');

        $('.dvf-dropdown-list').each(function () {
            var childThat = $(this);
            if (childThat.is(':visible')) {
                childThat.toggle(toggleSpeed);
                childThat.parent().find('.arrow').removeClass('up').addClass('down');
            }
        });

        if (needOpen) {
            list.toggle(toggleSpeed);
            list.parent().find('.arrow').removeClass('down').addClass('up');
        }
    });

    $('body').on('change', '.dvf-filter-section input', function (e) {
        var that = $(this);

        if (that.val() == 'all') {
            that.parent().find('input').each(function () {
                if ($(this).is(':checked') && $(this).val() != 'all') {
                    $(this).prop('checked', false);
                }
            });
        } else {
            that.parent().find('input').first().prop('checked', false);
        }

        if (that.parent().find('input:checked').length === 0) {
            that.parent().find('input').first().prop('checked', true);
        }

        collectPreview(that.closest('.dvf-dropdown-list'));
    });

    $('body').click(function (e) {
        var stopPropagination = ['LABEL', 'INPUT'];

        if (!stopPropagination.includes(e.target.tagName)) {
            $('.dvf-dropdown-list').each(function () {
                if ($(this).is(':visible')) {
                    $(this).toggle(toggleSpeed);
                }
            });
        }
    });

    $('body').on('change', '.dvf-filter-section input[type="checkbox"]', function () {
        var data = {
            action: 'dokan_vendors_ajax_list',
            data: $('#dokan-vendors-filters-form').serialize() +
                '&limit=' + $('input[name="dokan_vendors_limit"]').val() +
                '&page=' + $('input[name="dokan_vendors_page"]').val(),
        };

        var items = $('.dvf-items');
        if ($('.dokan-vendors-filter-preloader').length === 0) {
            items.prepend('<div class="dokan-vendors-filter-preloader"><img src="' + DokanVendorsFilter.pluginUrl + 'assets/img/preloader.svg" ></div>');
            $('.dvf-pagination').prepend('<div class="dokan-vendors-filter-preloader"><img src="' + DokanVendorsFilter.pluginUrl + 'assets/img/preloader.svg" ></div>');
        }

        $.post(DokanVendorsFilter.ajaxUrl, data, function (resp) {
            if (resp.success) {
                items.html(resp.data.items);
                $('.dvf-pagination').html(resp.data.paginations);
                $('.dokan-vendors-filter-preloader').remove();
            }
        });
    });

    $('body').on('click', '.dvf-pages li a', function () {
        $('input[name="dokan_vendors_page"]').val($(this).data('page'));
        return false;
    });

    $('body').on('click', '.dvf-pagination li a', function () {
        $('input[name="dokan_vendors_page"]').val($(this).data('page'));
        return false;
    });
});

function collectPreview(dropdownList) {
    var title = '',
        i = 0,
        previewMaxLenght = parseInt(dropdownList.parent().width() / 9);

    dropdownList.find('input').each(function () {
        var that = jQuery(this);

        if (that.is(':checked')) {
            if (i > 0) {
                title += ', ';
            }

            title += that.next().html();
            i++;
        }
    });

    if (title.length > previewMaxLenght) {
        title = title.substring(0, previewMaxLenght - 5);
        title += '... (' + i + ')';
    }

    title += '<i class="arrow up"></i>';

    dropdownList.parent().find('.dvf-dropdown-preview').html(title);
}