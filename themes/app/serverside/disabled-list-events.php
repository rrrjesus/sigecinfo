<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, 
        events.title, 
        events.start_at, 
        events.end_at, 
        event_types.name as type_name, 
        churchs.church_name, 
        events.location_text, 
        events.status
    FROM events
    LEFT JOIN event_types ON events.type_id = event_types.id
    LEFT JOIN churchs ON events.church_id = churchs.id
    WHERE events.status IN ('realizado', 'cancelado')
 ) temp
EOT;

$primaryKey = 'id';
 
$columns = [
    ['db' => 'start_at', 'dt' => 0, 'formatter' => function($d) {
        return "<h6>" . date_fmt($d, "d/m/Y H:i") . "</h6>";
    }],
    ['db' => 'end_at', 'dt' => 1, 'formatter' => function($d) {
        return "<h6>" . date_fmt($d, "d/m/Y H:i") . "</h6>";
    }],
    ['db' => 'title', 'dt' => 2, 'formatter' => function($d) {
        return "<h6>" . htmlspecialchars($d) . "</h6>";
    }],
    ['db' => 'type_name', 'dt' => 3, 'formatter' => function($d) {
        return "<h6>" . htmlspecialchars($d) . "</h6>";
    }],
    ['db' => 'church_name', 'dt' => 4, 'formatter' => function($d) {
        return "<h6>" . htmlspecialchars($d) . "</h6>";
    }],
    ['db' => 'location_text', 'dt' => 5, 'formatter' => function($d) {
        return "<h6>" . htmlspecialchars($d) . "</h6>";
    }],
    ['db' => 'status', 'dt' => 6, 'formatter' => function($d) {
        return "<h6>" . eventStatusBadge($d) . "</h6>";
    }]
];


$sql_details = [
    'user' => CONF_DB_USER, 'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'
];
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);