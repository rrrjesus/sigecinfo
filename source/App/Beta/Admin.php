<?php

namespace Source\App\Beta;

use Source\Core\Controller;
use Source\Domain\Shared\Models\Auth;
use Source\Core\Session;
use Source\Domain\Report\Models\Access;
use Source\Domain\Report\Models\Online;

/**
 * Class Admin
 * @package Source\App\Beta
 */
class Admin extends Controller
{
    /** @var \Source\Domain\User\Models\User|null */
    protected $user;

    /** @var Auth */
    protected Auth $auth;

    /**
     * Admin constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP);

        (new Access())->report();
        (new Online())->report();

        $this->auth = $auth;
        $this->user = Auth::user();

        if (!$this->user) {
            $this->message->warning("Efetue login para acessar!")->flash();
            redirect("/entrar");
        }

        if ($this->user->level_id < 3) {
            $this->message->error("Nível de usuário não permitido!")->flash();
            redirect("/entrar");
        }

        //UNCONFIRMED EMAIL
        if ($this->user->status != "actived") {
            $session = new Session();
            if (!$session->has("appconfirmed")) {
                $this->message->info("IMPORTANTE: Acesse seu e-mail para confirmar seu cadastro.")->flash();
                $session->set("appconfirmed", true);
                
                // AGORA USA A DEPENDÊNCIA INJETADA
                $this->auth->register($this->user);
            }
        }
    }
}