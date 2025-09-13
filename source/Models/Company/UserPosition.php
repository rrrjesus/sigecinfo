<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * Rodolfo | Class Unit Active Record Pattern
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
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
     * @param string $position_name
     * @param string $columns
     * @return null|UserPosition
     */
    public function findByPosition(string $position_name, string $columns = "*"): ?UserPosition
    {
        $find = $this->find("position_name = :position_name", "position_name={$position_name}", $columns);
        return $find->fetch();
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
     * @return null|null
     */
    public function status(): ?string
    {
        if ($this->status == "actived") {
            return '<option value="actived" selected>Ativado</option><option value="disabled">Desativado</option>';
        } else {
            return '<option value="disabled" selected>Desativado</option><option value="actived">Ativado</option>';
        }
        return null; 
    }

    /**
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'){
            return '<span class="badge text-bg-success text-light ms-2">ATIVO</span>';
        } else {
            return '<span class="badge text-bg-danger ms-2">INATIVO</span>';
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("O campo : Cargo é obrigatório !!!")->icon();
            return false;
        }

        /** UserPosition Update */
        if (!empty($this->id)) {
            $positionId = $this->id;

            if ($this->find("position_name = :p AND id != :i", "p={$this->position_name}&i={$positionId}", "id")->fetch()) {
                $this->message->warning("O cargo informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$positionId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** UserPosition Create */
        if (empty($this->id)) {
            if ($this->findByPosition($this->position_name, "id")) {
                $this->message->warning("O cargo informado já está cadastrado");
                return false;
            }

            $positionId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($positionId))->data();
        return true;
    }
}