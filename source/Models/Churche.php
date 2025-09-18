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
        parent::__construct("churchs", ["id"], ["church_name", "status"]);
    }

    /**
     * @param string $columns
     * @return null|Church
     */
    public function findByChurch(string $name_church, string $columns = "*"): ?Church
    {
        $find = $this->find("name_church = :name_church", "name_church={$name_church}", $columns);
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
            $churchId = $this->id;

            if ($this->find("church_name = :church_name AND id != :i", "church_name={$this->church_name}&i={$churchId}", "id")->fetch()) {
                $this->message->warning("A igreja informada já está cadastrada");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$churchId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Church Create */
        if (empty($this->id)) {
            if ($this->findByChurch($this->name_church, "id")) {
                $this->message->warning("A igreja informada já está cadastrada !!!");
                return false;
            }

            $churchId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($churchId))->data();
        return true;
    }
}