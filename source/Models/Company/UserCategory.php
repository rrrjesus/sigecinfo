<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 * Rodolfo | Class Unit Active Record Pattern
 *
 * @author Rodolfo Romaioli Ribeiro de Jesus <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class UserCategory extends Model
{
    /**
     * UserCategory constructor.
     */
    public function __construct()
    {
        parent::__construct("user_categories", ["id"], ["category_name"]);
    }

    /**
     * @param string $category_name
     * @param string $columns
     * @return null|UserCategory
     */
    public function findByCategory(string $category_name, string $columns = "*"): ?UserCategory
    {
        $find = $this->find("category_name = :category_name", "category_name={$category_name}", $columns);
        return $find->fetch();
    }

    /**
     * @return null|UserCategory
     */
    static function completeCategory(): ?UserCategory
    {
        $stm = (new UserCategory())->find("status= :s","s=actived");
        $array[] = array();

        if(!empty($stm)):
            foreach ($stm->fetch(true) as $row):
                    $array[] = $row->id.' - '.$row->category_name;
            endforeach;
            echo json_encode($array); //Return the JSON Array
        endif;
        return null;
    }

    /**
     * @return null|string
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
            $this->message->warning("O campo : Regime de Trabalho é obrigatório !!!")->icon();
            return false;
        }

        /** UserCategory Update */
        if (!empty($this->id)) {
            $categoryId = $this->id;

            if ($this->find("category_name = :c AND id != :i", "c={$this->category_name}&i={$categoryId}", "id")->fetch()) {
                $this->message->warning("O regime de trabalho informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$categoryId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** UserCategory Create */
        if (empty($this->id)) {
            if ($this->findByCategory($this->category_name, "id")) {
                $this->message->warning("O regime de trabalho informado já está cadastrado");
                return false;
            }

            $categoryId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($categoryId))->data();
        return true;
    }
}