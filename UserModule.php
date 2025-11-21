<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class UserModule
 *
 * @package Source\Domain\Shared\Models
 */
class UserModule extends Model
{
    public function __construct()
    {
        parent::__construct("user_modules", ["id"], ["user_id", "module"]);
    }
}
