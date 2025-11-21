<?php

/**
 * ####################
 * ###   NÍVEIS DE ACESSO  ###
 * ####################
 */
define("USER_LEVEL_USER", 1);
define("USER_LEVEL_EDITOR_USER", 2);
define("USER_LEVEL_EDITOR", 3);
define("USER_LEVEL_ADMIN_EDITOR", 4);
define("USER_LEVEL_ADMIN", 5);

/**
 * @param int $userLevel
 * @return string
 */
function get_user_level_name(int $userLevel): string
{
    $levels = [
        USER_LEVEL_USER => "Usuário", // Acesso mínimo (Read Only)
        USER_LEVEL_EDITOR_USER => "Usuário Editor", // Visualização + Edição Limitada
        USER_LEVEL_EDITOR => "Editor", // Edição em Módulos Principais
        USER_LEVEL_ADMIN_EDITOR => "Editor Administrador", // Nível de Gestão (Criação/Edição)
        USER_LEVEL_ADMIN => "Administrador do Sistema", // Acesso Total (Super Admin)
    ];

    return $levels[$userLevel] ?? "Desconhecido";
}

/**
 * Verifica se o nível de usuário atual tem permissão para acessar um recurso
 * que requer um nível mínimo.
 *
 * @param int $requiredLevel O nível mínimo necessário.
 * @return bool True se o usuário tiver permissão, false caso contrário.
 */
function user_has_permission(int $requiredLevel): bool
{
    // Supondo que o nível do usuário logado está armazenado na sessão.
    // Adapte conforme a sua implementação de autenticação.
    $currentUserLevel = $_SESSION['user']['level'] ?? 0;

    return $currentUserLevel >= $requiredLevel;
}

/**
 * Adicione aqui outras funções auxiliares que seu sistema possa precisar.
 * Ex: url(), asset(), etc.
 */