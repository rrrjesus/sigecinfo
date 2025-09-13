<?php

namespace Source\Models;

use Source\Core\Model;

class Signature extends Model
{
    public function __construct()
    {
        parent::__construct("signatures", ["id"], ["first_name", "last_name", "email"]);
    }

    /**
     * @return null|Signature
     */
    static function completeName(): ?Signature
    {
        $stm = (new Signature())->find("","");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->first_name.' '.$row->last_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Signature
     */
    static function complete($columns): ?Signature
    {
        $stm = (new Signature())->find("","",$columns);
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = array(
                    'id' => $row->id,
                    'nomeinp' => $row->user_name,
                    'emailinp' => $row->email
                );
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }


}