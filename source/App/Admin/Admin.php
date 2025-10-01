<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Domain\Shared\Models\Auth;

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
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN);

        $this->user = Auth::user();

        if (!$this->user) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/painel/login");
            exit;
        }

        if ($this->user->level_id < 3) {
            $this->message->error("Você não tem permissão para acessar esta área.")->flash();
            redirect("/");
            exit;
        }
    }

    /**
     * @param array $allowedLevels
     */
    protected function authorize(array $allowedLevels): void
    {
        $session = new Session();
        $userLevelName = $session->user_level_name ?? null;

        if (!in_array($userLevelName, $allowedLevels)) {
            $this->message->error("Acesso negado! Você não tem permissão para esta ação. !!!")->flash();
            redirect(url_back());
            exit;
        }
    }
}