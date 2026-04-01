<?php

namespace Source\Domain\Patrimony\Models;

use Source\Core\Model;

/**
 * SMSUB | Class ProductType
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Domain\Patrimony\Models
 */
class ProductType extends Model
{
    /**
     * ProductType constructor.
     */
    public function __construct()
    {
        parent::__construct("product_types", ["id"], ["type_name", "status"]);
    }

    /**
     * @param string $type_name
     * @param string $columns
     * @return null|ProductType
     */
    public function findByProductType(string $type_name, string $columns = "*"): ?ProductType
    {
        $find = $this->find("type_name = :type_name", "type_name={$type_name}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|ProductType
     */
    static function completeProductType(): ?ProductType
    {
        $stm = (new ProductType())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->type_name;
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

        /** ProductType Update */
        if (!empty($this->id)) {
            $typeId = $this->id;

            if ($this->find("type_name = :c AND id != :i", "c={$this->type_name}&i={$typeId}", "id")->fetch()) {
                $this->message->warning("O tipo informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$typeId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** ProductType Create */
        if (empty($this->id)) {
            if ($this->findByProductType($this->type_name, "id")) {
                $this->message->warning("O tipo informado já está cadastrado");
                return false;
            }

            $typeId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($typeId))->data();
        return true;
    }
}