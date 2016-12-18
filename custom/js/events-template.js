var $j = jQuery;
// div
var filt_container = $j("#filters_container");
var ev_container = $j("#events_container");
var ev_content = $j("#events_content");
var det_container = $j("#details_container");
var det_content = $j("#details_content");
var loading_spinning = $j('.loading_events_spinning');
var events_pagination = $j('#events_pagination');
// elements
var country_selector = $j('#events_select_country');
var city_selector = $j('#events_select_city');
var date_from_selector = $j('#events_select_date_from');
var date_to_selector = $j('#events_select_date_to');
var date_elements = $j('.date_input');
// dom ready
$j(document).ready(function () {

    $j('#events_string_filter').keypress(function (e) {
        if (e.which == 13) {
            $j('#search_events_string').trigger('click');
        }
    });

    $j('#search_events_string').click(function (e) {

        var string = $j.trim($j('#events_string_filter').val());
        if (string == '') {
            console.log('inserisci una stringa');
            return false;
        }

        ev_container.attr("open", '');
        ev_content.html('');
        det_container.removeAttr("open");
        searchEventsByString(string);
        filt_container.removeAttr("open");
    });

    $j('#search_events_filters').click(function (e) {
        var country_id = $j.trim(country_selector.val());
        var city_id = $j.trim(city_selector.val());
        var date_from = $j.trim(date_from_selector.val());
        var date_to = $j.trim(date_to_selector.val());
        if (country_id == '' && city_id == '' && date_from == '' && date_to == '') { // no filters
            console.log('inserisci almeno un filtro');
            return false;
        }
        ev_container.attr("open", '');
        det_container.removeAttr("open");
        searchEventsByFilters(country_id, city_id, date_from, date_to);
        filt_container.removeAttr("open");
    });

    $j('.selected_events').click(function (e) {
        filt_container.removeAttr("open");
        ev_container.removeAttr("open");
        det_container.removeAttr("open");
        getEventDetail($j(this).attr('event_id'));
    });

    $j('#events_select_country').change(function () {
        getCities($j(this).val());
    });

    date_elements.datepicker({dateFormat: 'yy-mm-dd'});

    var request = getPastEvents();
    request.done(function (response) {

        $j('#carousel_events_container').html(''); 
        var firstElem = 'active';
        for (var x = 0; x < response.data.length; x++) {
            var elem = response.data[x];
            var html = '<div class="item ' + firstElem + '" >' +
                '<div class="col-lg-4 col-xs-12 col-md-12 col-sm-12 past_events_area" event_id="' + elem.ID + '" >' +
                '<div style=\'background-image: url("/custom/events_images/' + elem.immagine + '"); height: 150px;\'>' +
                '<h5 class="past_events" >' + elem.titolo +
                '</h5></div>' +
                '</div>' +
                '</div>';
            $j('#carousel_events_container').append(html);
            firstElem = '';
        }

        $j('#myCarousel').carousel({
            interval: 40000
        });

        $j('.carousel .item').each(function () {
            var next = $j(this).next();
            if (!next.length) {
                next = $j(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($j(this));

            if (next.next().length > 0) {
                next.next().children(':first-child').clone().appendTo($j(this)).addClass('rightest');
            }
            else {
                $j(this).siblings(':first').children(':first-child').clone().appendTo($j(this));
            }
        });
        $j('.past_events_area').click(function () {
            getEventDetail($j(this).attr('event_id'));
        });

        if (country_id == '' && city_id == '' && date_from == '' && date_to == '') {
            searchEventsByFilters('', '', '', '');
        } else {
            searchEventsByFilters(country_id, city_id, date_from, date_to);
        }
        loading_spinning.hide();
    });
    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });
});

function setFilteredEvents(response) {

    var n = 0;
    var html = '';
    for (var x = 0; x < response.data.length; x++) {
        n++;
        var msg = response.data[x];

        if (n % 2 > 0) {
            html += '<div class="row">';
        }
        html += '<div class="col-md-6" style="cursor:pointer;cursor: hand;">' +
            '<div class="selected_events" event_id="' + msg.ID + '" style=\'background-image: url("/custom/events_images/' + msg.immagine + '"); height: 200px;\'></div>' +
            '<h4 event_id="' + msg.id + '" class="selected_events"  style=" margin-top: 1%;">' + msg.titolo + '</h4>' +
            "</div>";
        if (n % 2 == 0) {
            html += '</div>';
        }

    }
    ev_content.append(html);

    events_pagination.html('');
    var html = '<li id="first_page"><a href="#"><<</a></li><li id="previous_page"><a href="#"><</a></li>';
    var li_class = ' active';
    for (var x = 1; x <= response.total_pages; x++) {
        html += '<li pages="' + x + '" class="pages_link ' + li_class + '"><a href="#">' + x + '</a></li>';
        li_class = '';
    }
    html += '<li id="next_page"><a href="#">></a></li><li id="last_page"><a href="#">>></a></li>';
    events_pagination.append(html);

    $j('.pages_link').click(function (e) {
        if (!$j(this).hasClass('active')) {
            searchEventsByPage($j(this).attr('pages'));
        }
    });
    $j('#first_page').click(function (e) {
        searchEventsByPage(1);
    });
    $j('#previous_page').click(function (e) {
        var page = events_pagination.find('.active').attr('pages');
        page = parseInt(page) - 1;
        searchEventsByPage(page);
    });
    $j('#next_page').click(function (e) {
        var page = events_pagination.find('.active').attr('pages');
        page = parseInt(page) + 1;
        searchEventsByPage(page);
    });
    $j('#last_page').click(function (e) {
        var page = events_pagination.find('.pages_link').last().attr('pages');
        page = parseInt(page);
        searchEventsByPage(page);
    });

    $j('.selected_events').click(function (e) {
        filt_container.removeAttr("open");
        ev_container.removeAttr("open");
        det_container.removeAttr("open");
        getEventDetail($j(this).attr('event_id'));
    });
}

function searchEventsByString(string) {

    loading_spinning.show();
    var request = $j.ajax({
        url: "/api/getEventsByString.php",
        method: "GET",
        data: {string: string},
        dataType: "json"
    });

    request.done(function (response) {
        ev_content.html('');
        clearDetails();
        setFilteredEvents(response);
    });

    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });

    request.always(function () {
        loading_spinning.hide();
    });
}

function searchEventsByFilters(country_id, city_id, date_from, date_to) {

    loading_spinning.show();
    var request = $j.ajax({
        url: "/api/getEventsByFilters.php",
        method: "GET",
        data: {
            country_id: country_id,
            city_id: city_id,
            date_from: date_from,
            date_to: date_to
        },
        dataType: "json"
    });

    request.done(function (response) {
        ev_content.html('');
        clearDetails();
        setFilteredEvents(response);
    });

    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });

    request.always(function () {
        loading_spinning.hide();
    });
}

function getPastEvents() {

    return $j.ajax({
        url: "/api/getPastEvents.php",
        method: "GET",
        dataType: "json"
    });
}

function searchEventsByPage(page) {

    loading_spinning.show();
    var request = $j.ajax({
        url: "/api/getEventsByFilters.php",
        method: "GET",
        data: {
            page: page
        },
        dataType: "json"
    });

    request.done(function (response) {
        ev_content.html('');
        clearDetails();
        setFilteredEvents(response);
    });

    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });

    request.always(function () {
        loading_spinning.hide();
    });
}

function getEventDetail(id) {

    loading_spinning.show();
    var request = $j.ajax({
        url: "/api/getEventDetail.php",
        method: "GET",
        data: {id: id},
        dataType: "json"
    });

    request.done(function (msg) {
        $j('#details_image').attr('src', '/custom/events_images/' + msg.immagine);
        $j('#details_title').html(msg.titolo);
        $j('#details_description').html(msg.descrizione);
        det_container.attr("open", '');
    });

    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });

    request.always(function () {
        loading_spinning.hide();
    });
}

function getCities(country_id) {

    loading_spinning.show();
    var request = $j.ajax({
        url: "/api/getEventsCitiesByCountries.php",
        method: "GET",
        data: {country_id: country_id},
        dataType: "json"
    });

    request.done(function (response) {
        $j('#events_select_city').html('');
        $j('#events_select_city').html('<option value="" disabled selected>Pick a city..</option>');

        for (var x = 0; x < response.length; x++) {
            var record = response[x];
            var html = "<option value='" + record.id + "'>" + record.city + "</option>";
            $j('#events_select_city').append(html);
        }
    });

    request.error(function (jqXHR, textStatus) {
        console.log(jqXHR, textStatus);
    });

    request.always(function () {
        loading_spinning.hide();
    });
}

function clearDetails() {
    $j('#details_image').attr('src', '');
    $j('#details_title').html('');
    $j('#details_description').html('');
}