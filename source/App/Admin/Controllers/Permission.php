<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class Permission
 * @package Source\Domain\Shared\Models
 */
class Permission extends Model
{
    /**
     * Permission constructor.
     */
    public function __construct()
    {
        parent::__construct("permissions", ["id"], ["name", "description"]);
    }
}
