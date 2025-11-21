<?php

namespace Source\Domain\User\Models;

use Source\Core\Model;
use Source\Core\Connect;

/**
 *
 */
class Level extends Model
{
    public function __construct()
    {
        parent::__construct("levels", ["id"], ["level_name"]);
    }

    /**
     * @return array
     */
    public function permissions(): array
    {
        $permissions = [];
        if (!$this->id) {
            return $permissions;
        }

        try {
            $stmt = Connect::getInstance()->prepare(
                "SELECT p.permission_name FROM permissions p
                 JOIN level_has_permissions lhp ON lhp.permission_id = p.id
                 WHERE lhp.level_id = :level_id"
            );
            $stmt->execute(['level_id' => $this->id]);

            if ($stmt->rowCount() > 0) {
                $permissions = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            }
        } catch (\PDOException $exception) {
            // You might want to log the exception here
        }

        return $permissions;
    }
}