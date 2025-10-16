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

    // ... (dentro da classe EventService)

    /**
     * Convoca um único utilizador para um evento.
     * @param Event $event O evento para o qual convocar.
     * @param int $userId O ID do utilizador a ser convocado.
     * @return bool True se o utilizador foi convocado, false caso contrário.
     */
    public function convokeUser(Event $event, int $userId): bool
    {
        // Verifica se o utilizador já não está no evento
        $existing = (new EventParticipant())->find(
            "event_id = :eid AND user_id = :uid",
            "eid={$event->id}&uid={$userId}"
        )->count();

        if ($existing > 0) {
            return false; // Utilizador já está convocado
        }

        $participant = new EventParticipant();
        $participant->event_id = $event->id;
        $participant->user_id = $userId;
        
        if($participant->save()){
            // Futuramente, envie o e-mail aqui
            return true;
        }

        return false;
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

    /**
     * Realiza o check-in de um participante num evento.
     * @param int $participantId
     * @return bool
     */
    public function checkInParticipant(int $participantId): bool
    {
        $participant = (new EventParticipant())->findById($participantId);
        if ($participant && $participant->status != 'presente') {
            $participant->status = 'presente';
            $participant->checkin_at = date("Y-m-d H:i:s");
            return $participant->save();
        }
        return false;
    }

    /**
     * Gera uma matriz de comparecimento por igreja e por cargo.
     * @param array|null $participants A lista de participantes do evento.
     * @return object|null Um objeto contendo a matriz de dados, listas de cabeçalhos e totais.
     */
    public function generateAttendanceMatrix(?array $participants): ?object
    {
        if (empty($participants)) {
            return null;
        }

        $matrix = [];
        $allPositions = [];
        $columnTotals = [];
        $grandTotal = 0;

        // 1. Processa apenas os participantes com status 'presente'
        foreach ($participants as $participant) {
            if ($participant->status === 'presente') {
                $churchName = $participant->user()->church()->church_name ?? 'Outra Localidade';
                $positionName = $participant->user()->position()->position_name ?? 'Sem Cargo';

                // Adiciona a posição à lista de cabeçalhos
                if (!in_array($positionName, $allPositions)) {
                    $allPositions[] = $positionName;
                    $columnTotals[$positionName] = 0;
                }

                // Inicializa a linha da igreja se for a primeira vez
                if (!isset($matrix[$churchName])) {
                    $matrix[$churchName] = ['_row_total' => 0];
                }
                
                // Inicializa e incrementa a contagem para a célula [igreja][cargo]
                if (!isset($matrix[$churchName][$positionName])) {
                    $matrix[$churchName][$positionName] = 0;
                }
                $matrix[$churchName][$positionName]++;
            }
        }

        if (empty($matrix)) return null;

        // 2. Ordena os cabeçalhos e calcula os totais
        sort($allPositions);
        foreach ($matrix as $churchName => &$positionsData) {
            $rowTotal = 0;
            foreach ($allPositions as $positionName) {
                if (isset($positionsData[$positionName])) {
                    $count = $positionsData[$positionName];
                    $rowTotal += $count;
                    $columnTotals[$positionName] += $count;
                }
            }
            $positionsData['_row_total'] = $rowTotal;
            $grandTotal += $rowTotal;
        }
        
        // Ordena a matriz pelo nome da igreja
        ksort($matrix);

        return (object)[
            'headerPositions' => $allPositions,
            'matrixData' => $matrix,
            'columnTotals' => $columnTotals,
            'grandTotal' => $grandTotal
        ];
    }
}