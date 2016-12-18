<?php
require_once('../wp-config.php');
if (!isset($_GET['string'])) {
    http_response_code(422);
    die(error_response_string_missing());
}
$elem_per_page = 6;
$page = 1;
if (isset($GET['page']) && !empty(trim($GET['page'])) && is_numeric(trim($GET['page']))) {
    $page = trim($GET['page']);
}
$string = strtolower(trim($_GET['string']));
if (empty($string)) {
    http_response_code(422);
    die(error_response_string_missing());
}
global $wpdb;

$sql_count = "SELECT count(*) as cnt ";
$sql_select = "SELECT *";

$sql = " FROM xwy_custom_events as events
          LEFT JOIN xwy_custom_events_cities as cities ON events.city_id=cities.ID
          LEFT JOIN xwy_custom_events_countries as countries ON cities.country_id=countries.ID
          WHERE LOWER(events.titolo) like '%$string%' 
          OR LOWER(events.descrizione) like '%$string%' 
          OR LOWER(cities.city) like '%$string%' 
          OR LOWER(countries.country) like '%$string%' ";

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

function error_response_string_missing()
{
    http_response_code(422);
    return json_encode([
        'errors' => [
            'string' => 'is required'
        ]
    ]);
}