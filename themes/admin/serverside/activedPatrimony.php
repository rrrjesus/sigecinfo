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
SELECT patrimonys.id, patrimonys.created_at, products.type_part_number, patrimonys.part_number, brands.brand_name, 
products.product_name, users.user_name, users.login, users.rf, users.email, units.unit_name, units.it_professional, 
units.fixed_phone, patrimonys.observations, patrimonys.file_terms
FROM patrimonys
LEFT JOIN products ON patrimonys.product_id = products.id
LEFT JOIN brands ON products.brand_id = brands.id
LEFT JOIN units ON patrimonys.unit_id = units.id
LEFT JOIN users ON patrimonys.user_id = users.id
WHERE (((patrimonys.status) Like "actived")))temp
EOT;
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        'db'        => 'id', 'dt'        => 0,
        'formatter' => function($d) {
            return '<a href="../beta/patrimonio/detalhe/'.$d.'" role="button" class="btn btn-sm btn-outline-warning rounded-circle"><i class="bi bi-pencil"></i></a>';
        }
    ),
    array('db'        => 'created_at', 'dt'        => 1,
        'formatter' => function( $d) {
            return date( 'd/m/Y', strtotime($d));
        }
    ),
    array( 'db' => 'type_part_number', 'dt' => 2),
    array( 'db' => 'part_number', 'dt' => 3),
    array( 'db' => 'brand_name', 'dt' => 4),
    array( 'db' => 'product_name', 'dt' => 5),
    array( 'db' => 'user_name', 'dt' => 6),
    array( 'db' => 'login', 'dt' => 7),
    array( 'db' => 'rf', 'dt' => 8),
    array( 'db' => 'email', 'dt' => 9),
    array( 'db' => 'unit_name', 'dt' => 10),
    array( 'db' => 'it_professional', 'dt' => 11),
    array( 'db' => 'fixed_phone', 'dt' => 12),
    array( 'db' => 'observations', 'dt' => 13),
    array( 'db' => 'id', 'dt' => 14,
        'formatter' => function($d) {
            return '<a href="../beta/patrimonio/termo/'.$d.'" role="button" aria-disabled="true" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                        data-bs-title="Clique para editar" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle fw-bold me-2"><i class="bi bi-file-earmark-word"></i></a>';
                    }
    ),
    array( 'db' => 'file_terms', 'dt' => 15,
        'formatter' => function($d) {
            if($d && file_exists('../../../storage/'.$d)){
                return '<a href="../storage/'.$d.'" role="button" class="btn btn-sm btn-outline-danger rounded-circle" target="_blank"><i class="bi bi-file-earmark-pdf"></a>';
            }else{
                return '<p class="fw-semibold" >Sem Termo</p>';
            }
        }
    ),
    array( 'db' => 'id', 'dt' => 16)
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