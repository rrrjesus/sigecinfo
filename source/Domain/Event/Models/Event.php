<?php

namespace Source\Domain\Event\Models;

use Source\Core\Model;
use Source\Domain\Place\Models\Place;

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
        parent::__construct("events", ["id"], ["title"]);
    }

    /**
     * @return null|Place
     */
    public function place(): ?Place
    {
        if ($this->place_id) {
            return (new Place())->findById($this->place_id);
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
        foreach ($this->required as $field) {
            if (empty($this->data->$field)) {
                $this->message->warning("Título, data de início e tipo de evento são obrigatórios.");
                return false;
            }
        }

        // Consistência das Datas
        if (!empty($this->end_at) && strtotime($this->end_at) < strtotime($this->start_at)) {
            $this->message->warning("A data de término não pode ser anterior à data de início.");
            return false;
        }

        // Localização Exclusiva (ou local, ou texto, não ambos)
        if (empty($this->place_id) && !empty($this->location_text)) {
            $this->message->info("Por favor, escolha um local no campo de seleção para digitar um local nas dependências.");
            return false;
        }

        // Prevenção de Conflitos de Horário na mesma local
        if (!empty($this->place_id)) {
            // Define o fim do evento como 2h após o início, se não for especificado, para a verificação.
            $end_at = $this->end_at ?? date('Y-m-d H:i:s', strtotime($this->start_at . ' +2 hours'));

            $conflictCheck = $this->find(
                "place_id = :cid AND id != :id AND (start_at < :end AND end_at > :start)",
                "cid={$this->place_id}&id={$this->id}&start={$this->start_at}&end={$end_at}"
            );

            if ($conflictCheck->count()) {
                $this->message->error("Já existe outro evento agendado neste local que conflita com este horário.");
                return false;
            }
        }

        // Se todas as regras passarem, chama o método save() da biblioteca.
        return parent::save();
    }
}