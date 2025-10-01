<?php

require_once '../../../source/Boot/Config.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, 
        events.cover, 
        events.title, 
        events.start_at, 
        event_types.name as type_name, 
        churchs.church_name, 
        events.location_text, 
        events.status
    FROM events
    LEFT JOIN event_types ON events.type_id = event_types.id
    LEFT JOIN churchs ON events.church_id = churchs.id
 ) temp
EOT;

$primaryKey = 'id';
 
$columns = array(
    array('db' => 'cover', 'dt' => 0, 'formatter' => function($d) {
        return photoList($d, 'event_cover_default.jpg'); // Usando a função única e correta
    }),
    array('db' => 'title', 'dt' => 1),
    array('db' => 'start_at', 'dt' => 2, 'formatter' => function($d) {
        return date_fmt($d, "d/m/Y H:i");
    }),
    array('db' => 'type_name', 'dt' => 3),
    array('db' => 'church_name', 'dt' => 4, 'formatter' => function($d, $row) {
        return $d ?? $row['location_text'] ?? 'N/A';
    }),
    array('db' => 'status', 'dt' => 5, 'formatter' => function($d) {
        return statusBadge($d);
    }),
    // Colunas para os IDs das ações
    array('db' => 'id', 'dt' => 6), // Editar
    array('db' => 'id', 'dt' => 7), // Status
    array('db' => 'id', 'dt' => 8)  // Excluir
);

$sql_details = array(
    'user' => CONF_DB_USER, 'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'
);
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);