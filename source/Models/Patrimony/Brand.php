<?php

namespace Source\Models\Patrimony;

use Source\Core\Model;

/**
 * Rodolfo | Class Brand
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Brand extends Model
{
    /**
     * Brand constructor.
     */
    public function __construct()
    {
        parent::__construct("brands", ["id"], ["brand_name", "status"]);
    }

    /**
     * @param string $brand_name
     * @param string $columns
     * @return null|Brand
     */
    public function findByBrand(string $brand_name, string $columns = "*"): ?Brand
    {
        $find = $this->find("brand_name = :brand_name", "brand_name={$brand_name}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|Brand
     */
    static function completeBrand(): ?Brand
    {
        $stm = (new Brand())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->brand_name;
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

        /** Brand Update */
        if (!empty($this->id)) {
            $brandId = $this->id;

            if ($this->find("brand_name = :c AND id != :i", "c={$this->brand_name}&i={$brandId}", "id")->fetch()) {
                $this->message->warning("A marca informada já está cadastrada");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$brandId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Brand Create */
        if (empty($this->id)) {
            if ($this->findByBrand($this->brand_name, "id")) {
                $this->message->warning("A marca informada já está cadastrada");
                return false;
            }

            $brandId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($brandId))->data();
        return true;
    }
}