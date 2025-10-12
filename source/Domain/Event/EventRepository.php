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
            "upcoming" => $this->model->find("status = 'scheduled' AND start_at >= NOW()")->count(),
            "past" => $this->model->find("status = 'done'")->count(),
            "total" => $this->model->find()->count()
        ];
    }

     // Métodos de busca aqui.
    public function findUpcomingEvents(int $limit = 5): ?array
    {
        return $this->model
            ->find("status = 'scheduled' AND start_at >= NOW()")
            ->order("start_at ASC")
            ->limit($limit)
            ->fetch(true);
    }
}