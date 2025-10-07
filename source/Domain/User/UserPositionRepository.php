<?php
namespace Source\Domain\User;

use Source\Domain\User\Models\UserPosition;

class UserPositionRepository
{
    private $model;
    public function __construct() { $this->model = new UserPosition(); }

    public function getStatusCounts(): object
    {
        return (object)[
            "actived" => $this->model->find("status = :s", "s=actived")->count(),
            "disabled" => $this->model->find("status = :s", "s=disabled")->count(),
            "total" => $this->model->find()->count()
        ];
    }
}