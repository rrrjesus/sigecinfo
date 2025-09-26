<?php

namespace Source\App\Beta;

use Source\Models\Auth;
use Source\Models\Contact;
use Source\Models\Patrimony\Brand;
use Source\Models\Patrimony\Patrimony;
use Source\Models\Patrimony\Product;

/**
 * Class Dash
 * @package Source\App\Beta
 */
class Dash extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/beta/perfil");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Aplicativo",
            CONF_SITE_DESC,
            url("/beta"),
            theme("/assets/images/image.jpg", CONF_VIEW_APP),
            false
        );
        

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->user_name}.")->flash();

        Auth::logout();
        redirect("/entrar");
    }
}