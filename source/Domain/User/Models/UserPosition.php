<?php

namespace Source\Domain\User\Models;

use Source\Core\Model;

/**
 * Class UserPosition
 * @package Source\Models\User
 */
class UserPosition extends Model
{
    /**
     * UserPosition constructor.
     */
    public function __construct()
    {
        parent::__construct("user_positions", ["id"], ["position_name"]);
    }

    /**
     * @return null|UserPosition
     */
    static function completePosition(): ?UserPosition
    {
        $stm = (new UserPosition())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->position_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        // 1. Validação de campos obrigatórios
        if (empty($this->position_name)) {
            $this->message->warning("O nome do cargo é obrigatório.");
            return false;
        }

        // 2. Validação de duplicidade
        $checkByName = $this->find("position_name = :name AND id != :id", "name={$this->position_name}&id={$this->id}");
        if ($checkByName->count()) {
            $this->message->warning("Este cargo já está cadastrado no sistema.");
            return false;
        }

        // 3. Se passar nas validações, salva os dados.
        return parent::save();
    }
}