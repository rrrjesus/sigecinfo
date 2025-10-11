<?php

namespace Source\Domain\Event\Models;

use Source\Core\Model;
use Source\Domain\Event\Models\Event;
use Source\Domain\User\Models\User;

/**
 * Class EventParticipant
 * @package Source\Domain\Event\Models
 */
class EventParticipant extends Model
{
    /**
     * EventParticipant constructor.
     */
    public function __construct()
    {
        // Define a tabela e os campos obrigatórios
        parent::__construct("event_participants", ["id"], ["event_id", "user_id"]);
    }

    /**
     * Retorna o objeto do Evento relacionado a esta participação.
     * @return null|Event
     */
    public function event(): ?Event
    {
        if ($this->event_id) {
            return (new Event())->findById($this->event_id);
        }
        return null;
    }

    /**
     * Retorna o objeto do Utilizador (participante) relacionado a esta participação.
     * @return null|User
     */
    public function user(): ?User
    {
        if ($this->user_id) {
            return (new User())->findById($this->user_id);
        }
        return null;
    }
    
    /**
     * @return bool
     */
    public function save(): bool
    {
        // Regras de negócio antes de salvar
        if (empty($this->event_id) || empty($this->user_id)) {
            $this->message->warning("É necessário associar um evento e um utilizador.");
            return false;
        }

        return parent::save();
    }
}