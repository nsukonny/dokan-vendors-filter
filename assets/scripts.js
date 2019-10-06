jQuery(document).ready(function () {
    let $ = jQuery,
        body = $('body');

    body.on('click', '.dvf-filter-button a', function () {
        let filterSection = $('.dvf-filter-section');

        filterSection.toggleClass('active');

        return false;
    });

    body.on('click', '.dvf-dropdown-preview', function (e) {
        e.stopPropagation();

        let list = $(this).next(),
            needOpen = !list.is(':visible');

        $('.dvf-dropdown-list').each(function () {
            let childThat = $(this);
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

    body.on('change', '.dvf-filter-section input', function (e) {
        let that = $(this);

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

    body.click(function (e) {
        let stopPropagination = ['LABEL', 'INPUT'];

        if (!stopPropagination.includes(e.target.tagName)) {
            $('.dvf-dropdown-list').each(function () {
                if ($(this).is(':visible')) {
                    $(this).toggle(toggleSpeed);
                }
            });
        }
    });

    body.on('change', '.dvf-filter-section input[type="checkbox"]', function () {
        $('input[name="dvf_page"]').val(1);

        loadVendors();
    });

    body.on('click', '.dvf-pages li a', function () {
        $('input[name="dvf_per_page"]').val($(this).data('per_page'));
        $('input[name="dvf_page"]').val(1);

        loadVendors();

        return false;
    });

    body.on('click', '.dvf-pagination li a', function () {
        $('input[name="dvf_page"]').val($(this).data('page'));

        loadVendors(false);

        return false;
    });

    var lastQueryNumber = 0;

    function loadVendors(reloadPages = true) {
        lastQueryNumber++;

        let data = {
                action: 'dokan_vendors_ajax_list',
                data: $('#dokan-vendors-filters-form').serialize() +
                    '&limit=' + $('input[name="dvf_per_page"]').val() +
                    '&page=' + $('input[name="dvf_page"]').val(),
            },
            waitQueryNumber = lastQueryNumber,
            itemsElement = $('.dvf-items'),
            paginationElement = $('.dvf-pagination'),
            pagesElement = $('.dvf-pages');

        itemsElement.addClass('dvf-wait-reload');
        paginationElement.addClass('dvf-wait-reload');
        if (reloadPages) {
            pagesElement.addClass('dvf-wait-reload');
        }

        $.post(DokanVendorsFilter.ajaxUrl, data, function (resp) {
            if (resp.success && waitQueryNumber === lastQueryNumber) {
                itemsElement.html(resp.data.items);
                itemsElement.removeClass('dvf-wait-reload');
                paginationElement.html(resp.data.paginations);
                paginationElement.removeClass('dvf-wait-reload');
                pagesElement.html(resp.data.pages);
                pagesElement.removeClass('dvf-wait-reload');
            }
        });
    }
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