<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, 
        events.title, 
        events.start_at, 
        event_types.name as type_name, 
        churchs.church_name, 
        events.location_text, 
        events.status
    FROM events
    LEFT JOIN event_types ON events.type_id = event_types.id
    LEFT JOIN churchs ON events.church_id = churchs.id
    WHERE events.status IN ('scheduled', 'in_progress')
 ) temp
EOT;

$primaryKey = 'id';
 
$columns = [
    ['db' => 'title', 'dt' => 0],
    ['db' => 'start_at', 'dt' => 1, 'formatter' => function($d) {
        return date_fmt($d, "d/m/Y H:i");
    }],
    ['db' => 'type_name', 'dt' => 2],
    ['db' => 'church_name', 'dt' => 3, 'formatter' => function($d, $row) {
        return $d ?? $row['location_text'] ?? 'N/A';
    }],
    ['db' => 'status', 'dt' => 4, 'formatter' => function($d) {
        return eventStatusBadge($d);
    }],
    // Colunas para os IDs das ações
    ['db' => 'id', 'dt' => 5], // Editar
    ['db' => 'id', 'dt' => 6], // Status
    ['db' => 'id', 'dt' => 7]  // Excluir
];

$sql_details = [
    'user' => CONF_DB_USER, 'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'
];
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);