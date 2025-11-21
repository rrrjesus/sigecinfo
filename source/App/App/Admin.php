<?php

namespace Source\App\App;

use Source\Domain\Shared\Authorization;
use Source\Core\Controller;
use Source\Domain\Shared\Models\Auth;
use Source\Domain\User\Models\User;

/**
 * Class Admin
 * @package Source\App\App
 */
abstract class Admin extends Controller
{
    /** @var User */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }
    }

    /**
     * Verifica a permissão do usuário para um módulo e ação.
     * Redireciona para uma página de "acesso negado" se não tiver permissão.
     *
     * @param string $module O módulo a ser verificado (ex: 'Events').
     * @param string $action A ação a ser verificada (ex: 'view').
     */
    protected function authorize(string $module, string $action): void
    {
        // Constrói o nome da permissão (ex: 'Events_view')
        $permissionName = ucfirst(strtolower($module)) . '_' . strtolower($action);

        $authorization = new Authorization();
        if (!$authorization->hasPermission($permissionName)) {
            $this->message->error("Acesso negado! Você não tem permissão para executar esta ação.")->flash();
            redirect("/app/home");
        }
    }
}