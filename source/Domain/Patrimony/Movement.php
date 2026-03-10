<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;

/**
 * Rodolfo | Class Movement
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Movement extends Model
{
    /**
     * Movement constructor.
     */
    public function __construct()
    {
        parent::__construct("movements", ["id"], ["movement_name"]);
    }

    /**
     * @param string $movement_name
     * @param string $columns
     * @return null|Movement
     */
    public function findByMovement(string $movement_name, string $columns = "*"): ?Movement
    {
        $find = $this->find("movement_name = :movement_name", "movement_name={$movement_name}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|Movement
     */
    static function completeMovement(): ?Movement
    {
        $stm = (new Movement())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->movement_name;
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

        /** Movement Update */
        if (!empty($this->id)) {
            $movementId = $this->id;

            if ($this->find("movement_name = :c AND id != :i", "c={$this->movement_name}&i={$movementId}", "id")->fetch()) {
                $this->message->warning("O movimento informado já está cadastrada");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$movementId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Movement Create */
        if (empty($this->id)) {
            if ($this->findByMovement($this->movement_name, "id")) {
                $this->message->warning("O movimento informado já está cadastrada");
                return false;
            }

            $movementId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($movementId))->data();
        return true;
    }
}