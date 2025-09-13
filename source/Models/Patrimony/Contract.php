<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;
use Source\Models\Company\User;

/**
 * Rodolfo | Class Contract
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */

class Contract extends Model
{
    /**
     * Contract constructor.
     */
    public function __construct()
    {
        parent::__construct("contracts", ["id"], ["sei_process", "manager_id", "inspector_id", "deputy_inspector_id", "status"]);
    }

    /**
     * @param string $sei_process
     * @param string $columns
     * @return null|Contract
     */
    public function findBySei(string $sei_process, string $columns = "*"): ?Contract
    {
        $find = $this->find("sei_process = :sei_process", "sei_process={$sei_process}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|User
     */
    public function userManager(): ?User
    {
        if($this->manager_id) {
            return(new User())->findById($this->manager_id);
        }
        return null;
    }

    /**
     * @return null|User
     */
    public function userInspector(): ?User
    {
        if($this->inspector_id) {
            return(new User())->findById($this->inspector_id);
        }
        return null;
    }

    /**
     * @return null|User
     */
    public function userDeputyInspector(): ?User
    {
        if($this->deputy_inspector_id) {
            return(new User())->findById($this->deputy_inspector_id);
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function statusSelect(): ?string
    {
        if ($this->status == "actived") {
            return '<option value="actived" selected>Ativo</option><option value="disabled">Inativo</option>';
        } else {
            return '<option value="disabled" selected>Inativo</option><option value="actived">Ativo</option>';
        }
        return null; 
    }

    /**
     * @return string
     */
    public function statusBadge(): string
    {
        if($this->status == 'actived'){
            return '<span class="badge text-bg-success ms-2">Ativo</span>';
        } else {
            return '<span class="badge text-bg-danger ms-2">Inativo</span>';
        }  
    }

    /**
     * @return null|Contract
     */
    static function completeContract(): ?Contract
    {
        $stm = (new Contract())->find("status = :s","s=actived");
        $array = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                $array[] = $row->id.' - '.$row->sei_process.' - '.$row->contract_name;
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

        /** Contract Update */
        if (!empty($this->id)) {
            $contractId = $this->id;

            if ($this->find("sei_process = :s AND id != :i", "s={$this->sei_process}&i={$contractId}", "id")->fetch()) {
                $this->message->warning("O contrato informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$contractId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Contract Create */
        if (empty($this->id)) {
            if ($this->findBySei($this->sei_process, "id")) {
                $this->message->warning("O contrato informado já está cadastrado");
                return false;
            }

            $contractId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($contractId))->data();
        return true;
    }
}