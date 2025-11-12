<?php

namespace Source\Domain\Shared;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\User\Models\User;

/**
 * Class Authorization
 * @package Source\Domain\Shared
 */
class Authorization
{
    /** @var User|null */
    private ?User $user;

    /**
     * Mapeamento de Módulos e Ações para Níveis de Acesso
     *
     * Estrutura:
     * 'NomeDoModulo' => [
     *   'acao' => [níveis de usuário permitidos]
     * ]
     *
     * Níveis:
     * 1: Administrador do Sistema
     * 2: Editor Administrador
     * 3: Editor
     *
     * Ações Comuns: 'view', 'create', 'edit', 'delete'
     */
    private const PERMISSIONS = [
        'Users' => [
            'view'   => [1, 2], // Admin e Editor Admin podem ver a lista de usuários
            'create' => [1, 2], // Admin e Editor Admin podem criar usuários
            'edit'   => [1, 2], // Admin e Editor Admin podem editar usuários
            'delete' => [1],    // Apenas Admin do Sistema pode deletar
        ],
        'Events' => [
            'view'   => [1, 2, 3], // Todos podem ver eventos
            'create' => [1, 2],    // Admin e Editor Admin podem criar eventos
            'edit'   => [1, 2],    // Admin e Editor Admin podem editar eventos
            'delete' => [1],       // Apenas Admin do Sistema pode deletar
        ],
        // Futuramente, adicionaríamos outros módulos aqui
        // 'Reports' => [ ... ],
    ];

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Verifica se o usuário logado tem permissão para uma determinada ação em um módulo.
     *
     * @param string $module O nome do módulo (ex: 'Users', 'Events').
     * @param string $action A ação a ser verificada (ex: 'view', 'create', 'edit').
     * @return bool
     */
    public function hasPermission(string $module, string $action): bool
    {
        if (!$this->user || !$this->user->level_id) {
            return false;
        }

        $userLevel = $this->user->level_id;

        // Super Admin (Nível 1) tem acesso a tudo, por segurança.
        if ($userLevel === 1) {
            return true;
        }

        $allowedLevels = self::PERMISSIONS[$module][$action] ?? [];
        return in_array($userLevel, $allowedLevels);
    }
}
