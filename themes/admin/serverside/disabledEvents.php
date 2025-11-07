<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, events.title, events.start_at, events.end_at,events.status
    FROM events
    WHERE events.status IN ('realizado', 'cancelado')
 ) temp
EOT;

$primaryKey = 'id';
$columns = [
    // CORREÇÃO: Usando a função helper photoList para consistência
    ['db' => 'id', 'dt' => 0, 'formatter' => function($d) {
     return htmlspecialchars($d);
    }],
    ['db' => 'title', 'dt' => 1, 'formatter' => function($d) {
     return  htmlspecialchars($d);
    }],
    ['db' => 'start_at', 'dt' => 2, 'formatter' => function($d) { return  htmlspecialchars(date_fmt($d, "d/m/Y H:i")); }],
    ['db' => 'end_at', 'dt' => 3, 'formatter' => function($d) { return  htmlspecialchars(date_fmt($d, "d/m/Y H:i")); }],
    ['db' => 'status', 'dt' => 4, 'formatter' => function($d) { return eventStatusBadge($d); }],
    ['db' => 'id', 'dt' => 5] // Ativar
];

$sql_details = ['user' => CONF_DB_USER, 'pass' => CONF_DB_PASS, 'db' => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'];

require_once('ssp.class.php');

echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns));