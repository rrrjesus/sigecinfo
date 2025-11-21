<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;
use Source\Domain\User\Models\User;
use Source\Domain\Shared\Models\LevelPermission;
use Source\Domain\Shared\Models\UserModule;
use Source\Domain\Shared\Models\Permission;
use Source\Domain\Shared\Models\Module;

class Auth extends Model
{
    public function __construct()
    {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    /**
     * @return null|User
     */
    public static function user(): ?User
    {
        $session = new \Source\Core\Session();
        if (!$session->has("authUser")) {
            return null;
        }

        return (new User())->findById($session->authUser);
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        $session = new \Source\Core\Session();
        $session->unset("authUser");
    }

    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $user = self::user();
        if (!$user || !$user->level()) {
            return false;
        }
        // Consistent with level ID 5 for Super Admin
        return $user->level_id == 5;
    }

    /**
     * @return bool
     */
    public static function isUser(): bool
    {
        $user = self::user();
        if (!$user || !$user->level()) {
            return false;
        }
        return $user->level()->level_name === 'Usuario';
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function login(User $user): bool
    {
        if (!$user->id) {
            $this->message->warning("Usuário não encontrado para login.");
            return false;
        }

        // Regenerate session ID for security
        (new \Source\Core\Session())->regenerate();
        (new \Source\Core\Session())->set("authUser", $user->id);
        return true;
    }

    /**
     * Verifica se o usuário específico tem acesso a um módulo (independente do nível).
     * Este método é um alias para verificar a associação direta na tabela user_modules.
     * @param string $moduleName Nome do módulo (ex: 'users', 'events').
     * @return bool
     */
    public static function canAccessModule(string $moduleName): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        // 1. Super Admin (level_id 1) pode tudo.
        if ($user->level_id == 5) {
            return true;
        }

        // Encontra o módulo pelo nome
        $module = (new Module())->find("name = :name", "name={$moduleName}")->fetch();
        if (!$module) {
            return false; // Módulo não existe
        }

        // Verifica na tabela user_modules se existe uma entrada para este usuário e módulo
        $access = (new UserModule())->find(
            "user_id = :uid AND module_id = :mid",
            "uid={$user->id}&mid={$module->id}"
        )->count();

        return $access > 0;
    }

    /**
     * Verifica se o usuário logado pode executar uma determinada ação.
     * Esta é a função central para controle de acesso.
     *
     * A lógica é:
     * 1. O usuário é Super Admin (level_id = 1)? -> Permite.
     * 2. O usuário tem acesso ao módulo da permissão? (via user_modules)
     * 3. O nível do usuário tem a permissão específica? (via level_permissions)
     *
     * As condições 2 e 3 devem ser verdadeiras.
     *
     * @param string $permissionName O nome da permissão (ex: 'users_create', 'events_view').
     * @return bool
     */
    public static function check(string $permissionName): bool
    {
        $user = self::user();
        if (!$user) {
            return false; // Nenhum usuário logado
        }

        // 1. Super Admin (level_id 1) pode tudo.
        if ($user->level_id == 5) {
            return true;
        }

        // Encontra a permissão e o módulo associado a ela
        $permission = (new Permission())->find("name = :name", "name={$permissionName}")->fetch();
        if (!$permission) {
            return false; // Permissão não existe no banco de dados
        }

        // 2. Verifica se o usuário tem acesso ao módulo
        $hasModuleAccess = (new UserModule())->find(
            "user_id = :uid AND module_id = :mid",
            "uid={$user->id}&mid={$permission->module_id}"
        )->count();

        if (!$hasModuleAccess) {
            return false; // Usuário não tem liberação para este módulo
        }

        // 3. Verifica se o nível do usuário tem a permissão
        $levelHasPermission = (new LevelPermission())->find(
            "level_id = :lid AND permission_id = :pid",
            "lid={$user->level_id}&pid={$permission->id}"
        )->count();

        return $levelHasPermission > 0;
    }
}