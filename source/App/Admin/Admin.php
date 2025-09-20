<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\Auth;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Admin extends Controller
{
    /**
     * @var \Source\Models\Company\User|null
     */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN);

        $this->user = Auth::user();

        if (!$this->user || $this->user->level_id < 5) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/painel/login");
        }
    }

    /**
     * Verifica se o usuário logado tem um dos níveis permitidos.
     * @param array $allowedLevels - Um array com os NOMES dos níveis permitidos.
     */
    protected function authorize(array $allowedLevels): void
    {
        $session = new \Source\Core\Session();
        $userLevelName = $session->user_level_name ?? null;

        if (!in_array($userLevelName, $allowedLevels)) {
            $session->set("flash", $this->message->error("Acesso negado! Você não tem permissão para esta ação.")->render());
            redirect("/painel"); // Ou para uma página de "acesso negado"
            exit;
        }
    }
}