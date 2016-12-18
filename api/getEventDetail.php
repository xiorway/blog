<?php
require_once ('../wp-config.php');
if (!isset($_GET['id'])){
    http_response_code(422);
    die(error_response_id_missing());
}
$id = $_GET['id'];
if (empty($id)){
    http_response_code(422);
    die(error_response_id_missing());
}
global $wpdb;

$sql = "
          SELECT * FROM xwy_custom_events as events
          LEFT JOIN xwy_custom_events_cities as cities ON events.city_id=cities.ID
          LEFT JOIN xwy_custom_events_countries as countries ON cities.country_id=countries.ID
          WHERE events.ID=$id";

$results = $wpdb->get_results($sql, OBJECT);
echo json_encode($results[0]);

function error_response_id_missing(){
    http_response_code(422);
    return json_encode([
        'errors'=>[
            'id'=>'is required'
        ]
    ]);
}