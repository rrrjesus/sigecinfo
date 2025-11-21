<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Domain\Shared\Authorization;
use Source\Domain\Shared\Models\Auth;
use Source\Domain\Report\Models\Access;
use Source\Domain\Report\Models\Online;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Admin extends Controller
{
    /** @var \Source\Domain\User\Models\User|null */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        (new Access())->report();
        (new Online())->report();
        
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN);

        $this->user = Auth::user();

        if (!$this->user) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/painel/login");
            exit;
        }

        // Apenas Níveis 4 e 5 (Admin e Editor Admin) acessam o painel administrativo
        if ($this->user->level_id < 4) {
            $this->message->warning("Acesso negado. Você não tem permissão para acessar o painel.")->flash();
            redirect("/");
            exit;
        }
    }

    /**
     * Verifica a permissão do usuário para um módulo e ação.
     * Redireciona para uma página de "acesso negado" se não tiver permissão.
     *
     * @param string $module O módulo a ser verificado (ex: 'Users').
     * @param string $action A ação a ser verificada (ex: 'view', 'create').
     */
    protected function authorize(string $module, string $action): void
    {
        // Constrói o nome da permissão (ex: 'users_view')
        $permissionName = strtolower($module) . '_' . strtolower($action);

        if (!Auth::check($permissionName)) {
            $this->message->warning("Acesso negado! Você não tem permissão para executar esta ação.")->flash();
            redirect("/painel/controle/inicial");
            exit;
        }
    }
}