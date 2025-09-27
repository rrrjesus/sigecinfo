<?php

include_once '../../../source/Boot/Config.php';
 
/*
 * DataTables example server-side processing script.
 */
 
// DB table to use
$table = <<<EOT
 ( 
SELECT users.id, users.photo, users.user_name, users.phone_mobile, user_positions.position_name, churchs.church_name, users.email, users.status, levels.level_name
FROM users
LEFT JOIN user_positions ON users.position_id = user_positions.id
LEFT JOIN churchs ON users.church_id = churchs.id
LEFT JOIN levels ON users.level_id = levels.id
WHERE (((users.status) Like "actived")))temp
EOT;

// Table's primary key
$primaryKey = 'id';
 
// Array of database columns
$columns = array(
    array(
        'db' => 'id', 'dt' => 0,
        'formatter' => function($d) {
            return '<a href="usuarios/editar/'.$d.'" role="button" class="btn btn-sm btn-outline-warning rounded-circle"><i class="bi bi-pencil"></i></a>';
        }
    ),
    array('db' => 'photo', 'dt' => 1,
        'formatter' => function($d) {
            if ($d) {
                return '<img src="'.CONF_URL_BASE.'/storage/'.$d.'" alt="Foto do usuário" class="img-fluid rounded-circle" style="width:40px; height:40px; object-fit:cover;">';
            } else {
                return '<img src="'.CONF_URL_BASE.'/storage/images/avatar.jpg" alt="Foto do usuário" class="img-fluid rounded-circle" style="width:40px; height:40px; object-fit:cover;">';
            }
        }
    ),
    array('db' => 'user_name', 'dt' => 2),
    array('db' => 'phone_mobile', 'dt' => 3,
        'formatter' => function($d) {
            if (empty($d)) {
                return '';
            }
            return '('.substr($d,0,2).')'.substr($d,2,9);
        }
    ),
    array('db' => 'position_name', 'dt' => 4),
    array('db' => 'church_name', 'dt' => 5),
    array('db' => 'email', 'dt' => 6),
    array('db' => 'status', 'dt' => 7,
        'formatter' => function($d) {
            if ($d == 'actived') {
                return '<span class="badge bg-success">ATIVO</span>';
            } else {
                return '';
            }
        }
    ),
    array('db' => 'level_name', 'dt' => 8),
    array('db' => 'id', 'dt' => 9),
    array('db' => 'id', 'dt' => 10)
);

// SQL server connection information
$sql_details = array(
    'user' => CONF_DB_USER,
    'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME,
    'host' => CONF_DB_HOST,
    'charset' => 'utf8'
);
 
require('ssp.class.php');
 
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);