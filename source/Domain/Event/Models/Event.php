<?php

namespace Source\Domain\Event\Models;

use Source\Core\Model;
use Source\Domain\Church\Models\Church;

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

        // Localização Exclusiva (ou igreja, ou texto, não ambos)
        if (!empty($this->church_id) && !empty($this->location_text)) {
            $this->message->info("Por favor, escolha uma igreja no campo de seleção ou digite um local, mas não ambos.");
            return false;
        }

        // Prevenção de Conflitos de Horário na mesma igreja
        if (!empty($this->church_id)) {
            // Define o fim do evento como 2h após o início, se não for especificado, para a verificação.
            $end_at = $this->end_at ?? date('Y-m-d H:i:s', strtotime($this->start_at . ' +2 hours'));

            $conflictCheck = $this->find(
                "church_id = :cid AND id != :id AND (start_at < :end AND end_at > :start)",
                "cid={$this->church_id}&id={$this->id}&start={$this->start_at}&end={$end_at}"
            );

            if ($conflictCheck->count()) {
                $this->message->error("Já existe outro evento agendado nesta igreja que conflita com este horário.");
                return false;
            }
        }

        // Se todas as regras passarem, chama o método save() da biblioteca.
        return parent::save();
    }
}