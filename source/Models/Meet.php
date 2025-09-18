<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\Company\Church;

/**
 * SIGECINFO | Class Meeting
 *
 * @author Rodolfo <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Meeting extends Model
{
    /**
     * Meeting constructor.
     */
    public function __construct()
    {
        parent::__construct("meetings", ["id"], ["church_id", "contact_name", "ramal", "status"]);
    }

    /**
     * @param string $ramal
     * @param string $columns
     * @return null|Meeting
     */
    public function findByRamal(string $ramal, string $columns = "*"): ?Meeting
    {
        $find = $this->find("ramal = :ramal", "ramal={$ramal}", $columns);
        return $find->fetch();
    }

    /**
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'):
            return '<span class="badge text-bg-success ms-2">ATIVO</span>';
        else:
            return '<span class="badge text-bg-danger ms-2">INATIVO</span>';
        endif;  
    }


    /**
     * @return null|Church
     */
    public function church(): ?Church
    {
        if($this->church_id) {
            return(new Church())->findById($this->church_id);
        }
        return null;
    }

    /**
     * @return null|UserPosition
     */
    static function completePosition($columns): ?UserPosition
    {
        $stm = (new UserPosition())->find("status= :s","s=confirmed", $columns);
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->position_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Meeting
     */
    static function completeRamal(): ?Meeting
    {
        $stm = (new Meeting())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->ramal;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|Church
     */
    static function completeChurch(): ?Church
    {
        $stm = (new Church())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->church_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

        /**
     * @return null|Church
     */
    static function completeSector(): ?Church
    {
        $stm = (new Church())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = substr($row->church_name, 0 ,-11);
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

        /** Meeting Update */
        if (!empty($this->id)) {
            $contactId = $this->id;

            if ($this->find("ramal = :ramal AND id != :i", "ramal={$this->ramal}&i={$contactId}", "id")->fetch()) {
                $this->message->warning("O ramal informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$contactId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Meeting Create */
        if (empty($this->id)) {
            if ($this->findByRamal($this->ramal, "id")) {
                $this->message->warning("O ramal informado já está cadastrado !!!");
                return false;
            }

            $contactId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($contactId))->data();
        return true;
    }
}