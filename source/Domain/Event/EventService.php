<?php
namespace Source\Domain\Event;

use Source\Domain\Event\Models\Event;
use Source\Domain\Event\Models\EventParticipant;
use Source\Domain\User\Models\User;

/**
 * Class EventService
 * @package Source\Domain\Event
 */
class EventService
{
    /**
     * Convoca todos os utilizadores que possuem os cargos selecionados.
     * @param Event $event O evento para o qual convocar.
     * @param array $positionIds Array de IDs dos cargos a serem convocados.
     * @return int A quantidade de utilizadores únicos convocados.
     */
    public function convokeByPositions(Event $event, array $positionIds): int
    {
        if (empty($positionIds)) {
            return 0;
        }

        // Transforma o array de IDs numa string segura para a cláusula IN
        $placeholders = implode(',', array_fill(0, count($positionIds), '?'));

        // Busca todos os utilizadores que pertencem aos cargos selecionados
        $usersToConvoke = (new User())->find("position_id IN ({$placeholders})", $positionIds)->fetch(true);

        if (!$usersToConvoke) {
            return 0;
        }

        $convokedCount = 0;
        foreach ($usersToConvoke as $user) {
            // Verifica se o utilizador já não foi convocado para evitar duplicados
            $existingParticipant = (new EventParticipant())->find(
                "event_id = :eid AND user_id = :uid",
                "eid={$event->id}&uid={$user->id}"
            )->fetch();

            if (!$existingParticipant) {
                $participant = new EventParticipant();
                $participant->event_id = $event->id;
                $participant->user_id = $user->id;
                if ($participant->save()) {
                    $convokedCount++;
                }
                
                // Futuramente, a chamada para enviar o e-mail de convocação viria aqui.
                // $this->sendConvocationEmail($participant);
            }
        }

        return $convokedCount;
    }

    /**
     * Busca todos os participantes de um evento.
     * @param int $eventId O ID do evento.
     * @return array|null Uma lista de objetos EventParticipant.
     */
    public function getParticipants(int $eventId): ?array
    {
        $participants = (new EventParticipant())->find("event_id = :eid", "eid={$eventId}")->fetch(true);
        return $participants;
    }
}