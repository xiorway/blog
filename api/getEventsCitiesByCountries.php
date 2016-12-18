<?php
require_once ('../wp-config.php');
if (!isset($_GET['country_id'])){
    http_response_code(422);
    die(error_response_id_missing());
}
$id = $_GET['country_id'];
if (empty($id)){
    http_response_code(422);
    die(error_response_id_missing());
}
global $wpdb;

$sql = "SELECT * FROM xwy_custom_events_cities WHERE country_id=$id";

$results = $wpdb->get_results($sql, OBJECT);
echo json_encode($results);

function error_response_id_missing(){
    http_response_code(422);
    return json_encode([
        'errors'=>[
            'country_id'=>'is required'
        ]
    ]);
}