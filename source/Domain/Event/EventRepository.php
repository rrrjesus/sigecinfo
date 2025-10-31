<?php
namespace Source\Domain\Event;

use Source\Domain\Event\Models\Event;

class EventRepository
{
    private $model;
    public function __construct() { $this->model = new Event(); }

    /**
     * Retorna as contagens de eventos para a dashboard.
     * @return object
     */
    public function getDashboardCounts(): object
    {
        return (object)[
            "upcoming" => $this->model->find("status = 'agendado' AND start_at >= NOW()")->count(),
            "past" => $this->model->find("status = 'realizado'")->count(),
            "total" => $this->model->find()->count()
        ];
    }

     // Métodos de busca aqui.
    public function findUpcomingEvents(int $limit = 5): ?array
    {
        return $this->model
            ->find("status = 'agendado' AND start_at >= NOW()")
            ->order("start_at ASC")
            ->limit($limit)
            ->fetch(true);
    }

    /**
     * Busca todos os eventos para os quais um utilizador específico foi convocado.
     * @param int $userId
     * @return array|null
     */
    public function getEventsForUser(int $userId): ?array
    {
        $events = (new \Source\Domain\Event\Models\Event())->find(
            "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid AND status = 'convocado')",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }

    /**
     * Busca o próximo evento agendado para um utilizador específico.
     * @param int $userId
     * @return null|Event
     */
    public function findNextEventForUser(int $userId): ?\Source\Domain\Event\Models\Event
    {
        return (new \Source\Domain\Event\Models\Event())->find(
            "status = 'agendado' AND start_at >= NOW() AND id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)",
            "uid={$userId}"
        )->order("start_at ASC")->limit(1)->fetch();
    }

    /**
     * Retorna as contagens de eventos para a dashboard de um utilizador.
     * @param int $userId
     * @return object
     */
    public function getUserEventCounts(int $userId): object
    {
        $baseQuery = "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)";

        return (object)[
            "active" => (new \Source\Domain\Event\Models\Event())->find("status = 'agendado' AND {$baseQuery}", "uid={$userId}")->count(),
            "completed" => (new \Source\Domain\Event\Models\Event())->find("status = 'realizado' AND {$baseQuery}", "uid={$userId}")->count()
        ];
    }

    /**
     * Busca o histórico de eventos que um utilizador participou (status 'realizado' e 'presente').
     * @param int $userId
     * @return array|null
     */
    public function getCompletedEventsForUser(int $userId): ?array
    {
        $events = (new \Source\Domain\Event\Models\Event())->find(
            "status = 'realizado' AND id IN (SELECT event_id FROM event_participants WHERE user_id = :uid AND status = 'presente')",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }
}