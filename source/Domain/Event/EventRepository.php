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
            "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }
}