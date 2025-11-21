<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

class Permission extends Model
{
    public function __construct()
    {
        parent::__construct("permissions", ["id"], ["module_id", "name", "description"]);
    }
}
