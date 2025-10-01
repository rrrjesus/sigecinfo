<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

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
    WHERE events.status = 'scheduled'
 ) temp
EOT;

$primaryKey = 'id';
 
$columns = [
    ['db' => 'cover', 'dt' => 0,
        'formatter' => function($d) {
            if ($d) {
                return '<img src="'.CONF_URL_BASE.'/storage/'.$d.'" alt="Foto do usuário" class="img-fluid rounded-circle" style="width:40px; height:40px; object-fit:cover;">';
            } else {
                return '<img src="'.CONF_URL_BASE.'/storage/images/avatar.jpg" alt="Foto do usuário" class="img-fluid rounded-circle" style="width:40px; height:40px; object-fit:cover;">';
            }
        }
    ],
    ['db' => 'title', 'dt' => 1],
    ['db' => 'start_at', 'dt' => 2, 'formatter' => function($d) {
        return date_fmt($d, "d/m/Y H:i");
    }],
    ['db' => 'type_name', 'dt' => 3],
    ['db' => 'church_name', 'dt' => 4, 'formatter' => function($d, $row) {
        return $d ?? $row['location_text'] ?? 'N/A';
    }],
    ['db' => 'status', 'dt' => 5, 'formatter' => function($d) {
        return eventStatusBadge($d);
    }],
    // Colunas para os IDs das ações
    ['db' => 'id', 'dt' => 6], // Editar
    ['db' => 'id', 'dt' => 7], // Status
    ['db' => 'id', 'dt' => 8]  // Excluir
];

$sql_details = [
    'user' => CONF_DB_USER, 'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'
];
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);