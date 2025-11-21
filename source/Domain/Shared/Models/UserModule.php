<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

/**
 * Class UserModule
 * @package Source\Domain\Shared\Models
 */
class UserModule extends Model
{
    /**
     * UserModule constructor.
     */
    public function __construct()
    {
        parent::__construct("user_modules", ["id"], ["user_id", "module_id"]);
    }

    /**
     * Encontra módulos por user_id.
     * @param int $userId
     * @return array|null
     */
    public function findByUser(int $userId): ?array
    {
        $result = $this->find("user_id = :user_id", "user_id={$userId}", "module_id")->fetch(true, true);
        if (!$result) {
            return null;
        }
        return array_column($result, 'module_id');
    }

    /**
     * Deleta todos os módulos de um usuário.
     * @param int $userId
     * @return bool
     */
    public function deleteByUser(int $userId): bool
    {
        return $this->delete("user_id = :user_id", "user_id={$userId}");
    }

    /**
     * Adiciona um novo acesso de módulo a um usuário.
     * @param int $userId
     * @param int $moduleId
     * @return int|null
     */
    public function add(int $userId, int $moduleId): ?int
    {
        return $this->create(["user_id" => $userId, "module_id" => $moduleId]);
    }
}
