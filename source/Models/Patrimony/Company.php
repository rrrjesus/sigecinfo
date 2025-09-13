<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;

/**
 * Rodolfo | Class Company
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Company extends Model
{
    /**
     * Company constructor.
     */
    public function __construct()
    {
        parent::__construct("companies", ["id"], ["company_name", "status"]);
    }

    /**
     * @param string $company_name
     * @param string $columns
     * @return null|Company
     */
    public function findByCompany(string $company_name, string $columns = "*"): ?Company
    {
        $find = $this->find("company_name = :company_name", "company_name={$company_name}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|Company
     */
    static function completeCompany(): ?Company
    {
        $stm = (new Company())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->company_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return string
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
        if($this->status == 'actived'):
            return '<span class="badge text-bg-success text-light ms-2">ATIVO</span>';
        else:
            return '<span class="badge text-bg-danger ms-2">INATIVO</span>';
        endif;  
    }

    /**
     * @return bool
     */
    public function save(): bool
    {

        /** Company Update */
        if (!empty($this->id)) {
            $companyId = $this->id;

            if ($this->find("company_name = :c AND id != :i", "c={$this->company_name}&i={$companyId}", "id")->fetch()) {
                $this->message->warning("A marca informada já está cadastrada");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$companyId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Company Create */
        if (empty($this->id)) {
            if ($this->findByCompany($this->company_name, "id")) {
                $this->message->warning("A marca informada já está cadastrada");
                return false;
            }

            $companyId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($companyId))->data();
        return true;
    }
}