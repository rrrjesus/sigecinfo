<?php

namespace Source\App\Beta;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Core\Session;

/**
 * Class Admin
 * @package Source\App\Beta
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
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");

        $this->user = Auth::user();

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar !.")->icon('emoji-wink fs-3 me-1')->icon()->flash();
            redirect("/entrar");
        }

        if (!$this->user || $this->user->level_id < 3) {
            $this->message->error("Nível de usuário não permitido !")->icon()->flash();
            redirect("/entrar");
        }

        //UNCONFIRMED EMAIL
        if ($this->user->status != "confirmed") {
            $session = new Session();
            if (!$session->has("appconfirmed")) {
                $this->message->info("IMPORTANTE: Acesse seu e-mail para confirmar seu cadastro e ativar todos os recursos.")->icon()->flash();
                $session->set("appconfirmed", true);
                (new Auth())->register($this->user);
            }
        }
    }
}