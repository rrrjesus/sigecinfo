<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * SIGECINFO | Class Church
 *
 * @author Rodolfo <rodolfo.romaioli@gmail.com>
 * @package Source\Models
 */
class Church extends Model
{
    /**
     * Church constructor.
     */
    public function __construct()
    {
        parent::__construct("churchs", ["id"], ["churche_name", "status"]);
    }

    /**
     * @param string $columns
     * @return null|Church
     */
    public function findByChurche(string $name_churche, string $columns = "*"): ?Church
    {
        $find = $this->find("name_churche = :name_churche", "name_churche={$name_churche}", $columns);
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
     * @return bool
     */
    public function save(): bool
    {

        /** Church Update */
        if (!empty($this->id)) {
            $churcheId = $this->id;

            if ($this->find("churche_name = :churche_name AND id != :i", "churche_name={$this->churche_name}&i={$churcheId}", "id")->fetch()) {
                $this->message->warning("A igreja informada já está cadastrada");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$churcheId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Church Create */
        if (empty($this->id)) {
            if ($this->findByChurche($this->name_churche, "id")) {
                $this->message->warning("A igreja informada já está cadastrada !!!");
                return false;
            }

            $churcheId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($churcheId))->data();
        return true;
    }
}