<?php
namespace Source\Domain\User;

use Source\Domain\User\Models\User;

class UserRepository
{
    private $model;
    public function __construct() { $this->model = new User(); }
    
    public function getLevelCounts(): object
    {
        return (object)[
            "users" => $this->model->find("level_id < 4")->count(),
            "admins" => $this->model->find("level_id >= 4")->count(),
            "total" => $this->model->find()->count()
        ];
    }
}