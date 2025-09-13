<?php

include_once '../../../source/Boot/Config.php';
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See https://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - https://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = <<<EOT
 ( 
SELECT patrimonys_historys.id, patrimonys_historys.patrimony_id, patrimonys_historys.created_history, movements.movement_name, products.type_part_number, patrimonys_historys.part_number, brands.brand_name, 
products.product_name, users.user_name, users.login, users.cell_phone, users.rf, users.email, units.unit_name, patrimonys_historys.observations, patrimonys_historys.file_terms
FROM patrimonys_historys
LEFT JOIN products ON patrimonys_historys.product_id = products.id
LEFT JOIN brands ON products.brand_id = brands.id
LEFT JOIN units ON patrimonys_historys.unit_id = units.id
LEFT JOIN users ON patrimonys_historys.user_id = users.id
LEFT JOIN movements ON patrimonys_historys.movement_id = movements.id
WHERE (((patrimonys_historys.status) Like "actived")))temp
EOT;
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id', 'dt' => 0),
    array(
        'db'        => 'id', 'dt'        => 1,
        'formatter' => function($d) {
            return '<a href="../patrimonio/historico/editar/'.$d.'" accesskey="a" role="button" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-eye"></i></a>';
        }
    ),
    array('db' => 'created_history', 'dt' => 2,
        'formatter' => function( $d) {
            return date( 'd/m/Y', strtotime($d));
        }
    ),
    array( 'db' => 'movement_name', 'dt' => 3),
    array( 'db' => 'type_part_number', 'dt' => 4),
    array( 'db' => 'part_number', 'dt' => 5),
    array( 'db' => 'brand_name', 'dt' => 6),
    array( 'db' => 'product_name', 'dt' => 7),
    array( 'db' => 'user_name', 'dt' => 8),
    array( 'db' => 'login', 'dt' => 9),
    array( 'db' => 'cell_phone', 'dt' => 10,
        'formatter' => function($d) {
            if($d){
                return '('.substr($d, 0, 2).')'.substr($d, 2, 9);
            }
        }
    ),
    array( 'db' => 'rf', 'dt' => 11),
    array( 'db' => 'email', 'dt' => 12),
    array( 'db' => 'unit_name', 'dt' => 13),
    array( 'db' => 'observations', 'dt' => 14),
    array( 'db' => 'id', 'dt' => 15,
        'formatter' => function($d) {
            return '<a href="../patrimonio/historico/termo/'.$d.'" role="button" aria-disabled="true" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                        data-bs-title="Clique para visualizar" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle fw-bold me-2"><i class="bi bi-file-earmark-word"></i></a>';
                    }
    ),
    array( 'db' => 'file_terms', 'dt' => 16,
        'formatter' => function($d) {
            if($d && file_exists('../../../storage/'.$d)){
                return '<a href="../../storage/'.$d.'" role="button" class="btn btn-sm btn-outline-danger rounded-circle" target="_blank"><i class="bi bi-file-earmark-pdf"></a>';
            }else{
                return '<p class="fw-semibold" >Sem Termo</p>';
            }
        }
    )
);

// SQL server connection information
$sql_details = array(
    'user' => CONF_DB_USER,
    'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME,
    'host' => CONF_DB_HOST,
    'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);