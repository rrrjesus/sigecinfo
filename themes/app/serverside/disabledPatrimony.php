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
SELECT patrimonys.id, patrimonys.updated_at, movements.movement_name, products.type_part_number, patrimonys.part_number, brands.brand_name, 
products.product_name, users.user_name, users.login, users.rf, users.email, units.unit_name, patrimonys.observations, patrimonys.file_terms
FROM patrimonys
LEFT JOIN products ON patrimonys.product_id = products.id
LEFT JOIN brands ON products.brand_id = brands.id
LEFT JOIN units ON patrimonys.unit_id = units.id
LEFT JOIN users ON patrimonys.user_id = users.id
LEFT JOIN movements ON patrimonys.movement_id = movements.id
WHERE (((patrimonys.status) Like "disabled")))temp
EOT;
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db'        => 'updated_at', 'dt'        => 0,
        'formatter' => function( $d) {
            return date( 'd/m/Y', strtotime($d));
        }
    ),
    array( 'db' => 'movement_name', 'dt' => 1),
    array( 'db' => 'type_part_number', 'dt' => 2),
    array( 'db' => 'part_number', 'dt' => 3),
    array( 'db' => 'brand_name', 'dt' => 4),
    array( 'db' => 'product_name', 'dt' => 5),
    array( 'db' => 'user_name', 'dt' => 6),
    array( 'db' => 'login', 'dt' => 7),
    array( 'db' => 'rf', 'dt' => 8),
    array( 'db' => 'email', 'dt' => 9),
    array( 'db' => 'unit_name', 'dt' => 10),
    array( 'db' => 'observations', 'dt' => 11),
    array( 'db' => 'id', 'dt' => 12)
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