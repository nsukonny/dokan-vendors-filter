jQuery(document).ready(function () {
    let $ = jQuery,
        body = $('body'),
        toggleSpeed = 300;

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

    let lastQueryNumber = 0;

    function loadVendors(reloadPages = true) {
        let itemsElement = $('.dvf-items');

        if (0 === itemsElement.length) {
            return false;
        }

        lastQueryNumber++;

        let data = {
                action: 'dokan_vendors_ajax_list',
                data: $('#dokan-vendors-filters-form').serialize() +
                    '&limit=' + $('input[name="dvf_per_page"]').val() +
                    '&page=' + $('input[name="dvf_page"]').val(),
            },
            waitQueryNumber = lastQueryNumber,
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

    if ($('#dvf-google-map').length) {

        let map,
            geoCoder,
            mapOptions = {
                zoom: 8,
                center: {lat: -34.397, lng: 150.644}
            };

        function initGoogleMaps() {
            geoCoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById('dvf-google-map'),
                mapOptions);

            dvfReinitGoogleMap();
        }

        body.on('change', '.dvf-filter-section input[type="checkbox"]', function () {
            dvfReinitGoogleMap();
        });

        function dvfReinitGoogleMap() {
            lastQueryNumber++;

            let data = {
                    action: 'dokan_vendors_ajax_map',
                    data: $('#dokan-vendors-filters-form').serialize(),
                },
                waitQueryNumber = lastQueryNumber;

            $('#dvf-google-map').addClass('dvf-wait-reload');
            dvfDeleteMarkers();

            $.post(DokanVendorsFilter.ajaxUrl, data, function (resp) {
                if (resp.success && waitQueryNumber === lastQueryNumber) {
                    let dataLength = resp.data.vendors.length;
                    if (0 < dataLength) {
                        for (let i = 0; i < dataLength; i++) {
                            dvfMakeMarker(map, geoCoder, resp.data.vendors[i]);
                        }
                    }
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initGoogleMaps);
    }
});

function collectPreview(dropdownList) {
    let title = '',
        i = 0,
        previewMaxLenght = parseInt(dropdownList.parent().width() / 9);

    dropdownList.find('input').each(function () {
        let that = jQuery(this);

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

function dvfMakeMarker(map, geoCoder, data) {
    geoCoder.geocode({'address': data['address']}, function (results, status) {
        if (status === 'OK') {
            dvfAddMarker(map, results[0].geometry.location, data);
        }
    });
}

let googleMarkers = [];

function dvfAddMarker(map, location, vendorData) {
    let marker = new google.maps.Marker({
        position: location,
        map: map
    });

    googleMarkers.push(marker);

    if (1 === googleMarkers.length) {
        map.setCenter(location);
        jQuery('#dvf-google-map').removeClass('dvf-wait-reload');
    }

    let markerContent = '<div class="dvf-marker-thumb">' +
        '   <a href="' + vendorData['store_url'] + '" target="_blank"><img src="' + vendorData['banner'] + '"></a>' +
        '</div>' +
        '<div class="dvf-marker-title">' +
        '   <a href="' + vendorData['store_url'] + '" target="_blank">' + vendorData['store_name'] + '</a>' +
        '</div>' +
        '<div class="dvf-marker-address">' + vendorData['address'] + '</div>';

    if (3 < vendorData['phone'].length) {
        markerContent += '<div class="dvf-marker-phone">' +
            '   <a href="tel:' + vendorData['phone'] + '">' + vendorData['phone'] + '</a>' +
            '</div>';
    }


    let markerDetail = new google.maps.InfoWindow({
        content: markerContent
    });

    google.maps.event.addListener(marker, 'click', function () {
        markerDetail.open(map, marker);
    });
}

function dvfDeleteMarkers() {
    for (let i = 0; i < googleMarkers.length; i++) {
        googleMarkers[i].setMap(null);
    }
    googleMarkers = [];
}