<?php

namespace Source\App\App;

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
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");

        if (!$this->user = $auth->user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }
    }

    /**
     * @param array $roles
     */
    protected function authorize(array $roles): void
    {
        if (!in_array($this->user->level()->level_name, $roles)) {
            $this->message->error("Você não tem permissão para acessar esta área.")->flash();
            redirect("/app/home");
        }
    }
}