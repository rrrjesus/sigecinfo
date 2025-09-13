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

    $stmt = Connect::getInstance()->query("SELECT `id`, `first_name`, `last_name`, `email` FROM signatures WHERE CONCAT(first_name,' ',last_name) = '{$nome}'");

    $arr = Array();
    if ($stmt->rowCount()) {
        while ($dados = $stmt->fetch()) {
            $arr['nomeinp'] = $dados->first_name.' '.$dados->last_name;
            $arr['emailinp'] = substr($dados->email, 0, -27);
        }
    }
    else {
        $arr['nomeinp'] = '';
        $arr['emailinp'] = '';
    }
    return json_encode($arr);

}

/* só se for enviado o parâmetro, que devolve os dados */
if (isset($_GET['nomeinp'])) {
    echo retorna($_GET['nomeinp']);
}