<?php

/**
 * Created by Rodolfo Romaioli Ribeiro de Jesus.
 * User: D788796
 * Date: 09/06/2017
 * Time: 08:39
 */

require __DIR__ . '/../../../source/Core/Connect.php';
require __DIR__ . '/../../../source/Boot/Config.php';

use Source\Core\Connect;

function retorna($nome) {

    $stmt = Connect::getInstance()->query("SELECT `users`.`id`, `users`.`user_name`, `churchs`.`id`, `churchs`.`unit_name` FROM users LEFT JOIN churchs ON users.unit_id = churchs.id WHERE CONCAT(`users`.`id`,' - ',`users`.`user_name`) = '{$nome}'");

    $arr = Array();
    if ($stmt->rowCount()) {
        while ($dados = $stmt->fetch()) {
            $arr['user_id'] = $dados->user_name;
            $arr['unit_id'] = $dados->id.' - '.$dados->unit_name;
        }
    }
    else {
        $arr['user_id'] = '';
        $arr['unit_id'] = '';
    }
    return json_encode($arr);

}

/* só se for enviado o parâmetro, que devolve os dados */
if (isset($_GET['user_id'])) {
    echo retorna($_GET['user_id']);
}