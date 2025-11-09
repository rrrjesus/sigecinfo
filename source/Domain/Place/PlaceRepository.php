<?php
namespace Source\Domain\Place;

use Source\Domain\Place\Models\Place;

class PlaceRepository
{
    private $model;
    public function __construct() { $this->model = new Place(); }

    public function getStatusCounts(): object
    {
        return (object)[
            "actived" => $this->model->find("status = :s", "s=actived")->count(),
            "disabled" => $this->model->find("status = :s", "s=disabled")->count(),
            "total" => $this->model->find()->count()
        ];
    }
}