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
        places.place_name, 
        events.location_text, 
        events.status
    FROM events
    LEFT JOIN event_types ON events.type_id = event_types.id
    LEFT JOIN places ON events.place_id = places.id
    WHERE events.status IN ('realizado', 'cancelado')
 ) temp
EOT;

$primaryKey = 'id';
 
$columns = [
    ['db' => 'start_at', 'dt' => 0, 'formatter' => function($d) {
        return date_fmt($d, "d/m/Y H:i");
    }],
    ['db' => 'end_at', 'dt' => 1, 'formatter' => function($d) {
        return date_fmt($d, "d/m/Y H:i");
    }],
    ['db' => 'title', 'dt' => 2, 'formatter' => function($d) {
        return htmlspecialchars($d);
    }],
    ['db' => 'type_name', 'dt' => 3, 'formatter' => function($d) {
        return htmlspecialchars($d);
    }],
    ['db' => 'place_name', 'dt' => 4, 'formatter' => function($d) {
        return htmlspecialchars($d);
    }],
    ['db' => 'location_text', 'dt' => 5, 'formatter' => function($d) {
        return htmlspecialchars($d);
    }],
    ['db' => 'status', 'dt' => 6, 'formatter' => function($d) {
        return eventStatusBadge($d);
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