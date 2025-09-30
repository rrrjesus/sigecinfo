<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\Company\Church;

/**
 * Class Event
 * @package Source\Models
 */
class Event extends Model
{
    /**
     * Event constructor.
     */
    public function __construct()
    {
        parent::__construct("events", ["id"], ["title", "start_at", "type_id"]);
    }

    /**
     * @return null|Church
     */
    public function church(): ?Church
    {
        if ($this->church_id) {
            return (new Church())->findById($this->church_id);
        }
        return null;
    }

    /**
     * @return null|EventType
     */
    public function eventType(): ?EventType
    {
        if ($this->type_id) {
            return (new EventType())->findById($this->type_id);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        // Validação de campos obrigatórios
        if (empty($this->title) || empty($this->start_at) || empty($this->type_id)) {
            $this->message->warning("Título, data de início e tipo de evento são obrigatórios.");
            return false;
        }
        
        // Regra de negócio: data final não pode ser anterior à data inicial
        if (!empty($this->end_at) && $this->start_at > $this->end_at) {
            $this->message->warning("A data de término não pode ser anterior à data de início.");
            return false;
        }

        return parent::save();
    }
}