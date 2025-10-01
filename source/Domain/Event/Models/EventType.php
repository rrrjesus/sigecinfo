<?php

namespace Source\Domain\Event\Models;

use Source\Core\Model;

/**
 * Class EventType
 * @package Source\Models
 */
class EventType extends Model
{
    /**
     * EventType constructor.
     */
    public function __construct()
    {
        parent::__construct("event_types", ["id"], ["name"]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        // Regra 1: Validação de campo obrigatório
        if (empty($this->name)) {
            $this->message->warning("O nome do tipo de evento é obrigatório.");
            return false;
        }

        // Regra 2: Validação de duplicidade
        $checkByName = $this->find("name = :name AND id != :id", "name={$this->name}&id={$this->id}");
        if ($checkByName->count()) {
            $this->message->warning("Este tipo de evento já está registado.");
            return false;
        }

        return parent::save();
    }
}