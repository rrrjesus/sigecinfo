<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

$table = <<<EOT
 ( 
    SELECT 
        events.id, events.cover, events.title, events.start_at, events.status
    FROM events
    WHERE events.status = 'canceled' OR events.status = 'done'
 ) temp
EOT;

$primaryKey = 'id';
$columns = [
    // CORREÇÃO: Usando a função helper photoList para consistência
    ['db' => 'cover', 'dt' => 0, 'formatter' => function($d) { 
        return photoList($d, 'avatar.jpg'); 
    }],
    ['db' => 'title', 'dt' => 1],
    ['db' => 'start_at', 'dt' => 2, 'formatter' => function($d) { return date_fmt($d, "d/m/Y H:i"); }],
    ['db' => 'status', 'dt' => 3, 'formatter' => function($d) { return eventStatusBadge($d); }],
    ['db' => 'id', 'dt' => 4], // Ativar
    ['db' => 'id', 'dt' => 5]  // Excluir
];

$sql_details = ['user' => CONF_DB_USER, 'pass' => CONF_DB_PASS, 'db' => CONF_DB_NAME, 'host' => CONF_DB_HOST, 'charset' => 'utf8'];

require_once('ssp.class.php');

echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns));