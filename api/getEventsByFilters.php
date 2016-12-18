<?php
require_once('../wp-config.php');
$filters = array();
$dates_filter = array();
if (isset($_GET['country_id']) && !empty(trim($_GET['country_id']))) {
    $filters['country_id'] = trim($_GET['country_id']);
}
if (isset($_GET['city_id']) && !empty(trim($_GET['city_id']))) {
    $filters['city_id'] = trim($_GET['city_id']);
}
if (isset($_GET['date_from']) && !empty(trim($_GET['date_from']))) {
    $dates_filter['data_from'] = trim($_GET['date_from']);
} else {
    $dates_filter['data_from'] = date('Y-m-d');
}
if (isset($_GET['date_to']) && !empty(trim($_GET['date_to']))) {
    $dates_filter['data_to'] = trim($_GET['date_to']);
}
if (empty($filters) && empty($dates_filter)) {
    http_response_code(422);
    echo json_encode([
        'errors' => [
            'filters' => 'at least one filter is required',
            'list_of_filters' => array(
                'country_id',
                'city_id',
                'date_from',
                'date_to'
            )
        ]
    ]);
    die();
}
$elem_per_page = 6;
$page = 1;
if (isset($GET['page']) && !empty(trim($GET['page'])) && is_numeric(trim($GET['page']))) {
    $page = trim($GET['page']);
    if ($page < 1) {
        $page = 1;
    }
}
global $wpdb;

$sql_count = "SELECT count(*) as cnt ";
$sql_select = "SELECT *";

$sql = " FROM xwy_custom_events as events
          LEFT JOIN xwy_custom_events_cities as cities ON events.city_id=cities.ID
          LEFT JOIN xwy_custom_events_countries as countries ON cities.country_id=countries.ID ";

$where = ' WHERE ';
foreach ($filters as $field => $value) {
    $sql .= $where . $field . '=' . $value;
    $where = ' AND ';
}
if (isset($dates_filter['data_from'])) {
    $field = 'data_inizio';
    $value = $dates_filter['data_from'];
    $sql .= $where . $field . '>=' . "'$value'";
    $where = ' AND ';
}
if (isset($dates_filter['data_to'])) {
    $field = 'data_inizio';
    $value = $dates_filter['data_to'];
    $sql .= $where . $field . '<=' . "'$value'";
    $where = ' AND ';
}



$sql_count .= $sql;
$count_result = $wpdb->get_results($sql_count, OBJECT);
$count = $count_result[0]->cnt;
$tot_pages = intval($count / $elem_per_page);
if (($count % $elem_per_page) > 0) {
    $tot_pages++;
}
if ($page > $tot_pages) {
    $page = $tot_pages;
}

$first = $page - 1;
$start = $first * $elem_per_page;
$sql .= " ORDER BY data_inizio LIMIT $start, $elem_per_page ";

$sql_select .= $sql;
$results = $wpdb->get_results($sql_select, OBJECT);
echo json_encode(array(
    'data' => $results,
    'count' => $count,
    'page' => $page,
    'total_pages' => $tot_pages
));