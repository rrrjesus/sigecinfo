<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class LevelPermission
 * @package Source\Domain\Shared\Models
 */
class LevelPermission extends Model
{
    /**
     * LevelPermission constructor.
     */
    public function __construct()
    {
        parent::__construct("level_permissions", ["id"], ["level_id", "permission_id"]);
    }

    /**
     * Encontra permissões por level_id.
     * @param int $levelId
     * @return array|null
     */
    public function findByLevel(int $levelId): ?array
    {
        $result = $this->find("level_id = :level_id", "level_id={$levelId}", "permission_id")->fetch(true, true);
        if (!$result) {
            return null;
        }
        return array_column($result, 'permission_id');
    }

    /**
     * Deleta todas as permissões de um nível.
     * @param int $levelId
     * @return bool
     */
    public function deleteByLevel(int $levelId): bool
    {
        return $this->delete("level_id = :level_id", "level_id={$levelId}");
    }

    /**
     * Adiciona uma nova permissão a um nível.
     * @param int $levelId
     * @param int $permissionId
     * @return int|null
     */
    public function add(int $levelId, int $permissionId): ?int
    {
        return $this->create([
            "level_id" => $levelId,
            "permission_id" => $permissionId
        ]);
    }

    /**
     * Deleta todas as permissões.
     * @return bool
     */
    public function deleteAll(): bool
    {
        return $this->delete("1", null);
    }
}
