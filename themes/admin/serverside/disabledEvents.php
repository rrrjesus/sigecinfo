<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, events.title, events.start_at, events.status
    FROM events
    WHERE events.status IN ('realizado', 'cancelado')
 ) temp
EOT;

$primaryKey = 'id';
$columns = [
    // CORREÇÃO: Usando a função helper photoList para consistência
    ['db' => 'title', 'dt' => 0],
    ['db' => 'start_at', 'dt' => 1, 'formatter' => function($d) { return date_fmt($d, "d/m/Y H:i"); }],
    ['db' => 'status', 'dt' => 2, 'formatter' => function($d) { return eventStatusBadge($d); }],
    ['db' => 'id', 'dt' => 3], // Ativar
    ['db' => 'id', 'dt' => 4]  // Excluir
];

$sql_details = ['user' => CONF_DB_USER, 'pass' => CONF_DB_PASS, 'db' => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'];

require_once('ssp.class.php');

echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns));