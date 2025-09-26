<?php

namespace Source\Models\Company;

use Source\Core\Model;

/**
 *
 */
class Level extends Model
{
    public function __construct()
    {
        parent::__construct("levels", ["id"], ["level_name"]);
    }

}