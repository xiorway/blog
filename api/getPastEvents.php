<?php
require_once('../wp-config.php');
global $wpdb;

$sql = " SELECT * FROM xwy_custom_events as events
          LEFT JOIN xwy_custom_events_cities as cities ON events.city_id=cities.ID
          LEFT JOIN xwy_custom_events_countries as countries ON cities.country_id=countries.ID 
          WHERE data_inizio < '" . date('Y-m-d') . "'";

$first = $page - 1;
$start = $first * $elem_per_page;
$sql .= " ORDER BY data_inizio DESC LIMIT 0, 12 ";

$sql_select .= $sql;
$results = $wpdb->get_results($sql_select, OBJECT);
echo json_encode(array(
    'data' => $results
));