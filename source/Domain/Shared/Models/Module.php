<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class Module
 *
 * @package Source\Domain\Shared\Models
 */
class Module extends Model
{
    /**
     * Module constructor.
     */
    public function __construct()
    {
        //          table name, required fields, primary key, timestamps
        parent::__construct("modules", ["id"], ["name", "description"]);
    }
}
