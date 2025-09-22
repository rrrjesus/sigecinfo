<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\Auth;

/**
 * Class Login
 * @package Source\App\Admin
 */
class Login extends Controller
{
    /** @var Auth */
    private Auth $auth;

    /**
     * Login constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN);
        $this->auth = $auth;
    }

    /**
     * Admin access redirect
     */
    public function root(): void
    {
        $user = Auth::user();

        if ($user && $user->level_id >= 3) {
            redirect("/painel/controle");
        } else {
            redirect("/painel/login");
        }
    }

    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        $user = Auth::user();
        if ($user && $user->level_id >= 3) {
            redirect("/painel/controle");
        }

        if (!empty($data["email"]) && !empty($data["password"])) {
            if (request_limit("loginLogin", 3, 5 * 60)) {
                $json["message"] = $this->message->error("ACESSO NEGADO: Aguarde por 5 minutos para tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            $login = $this->auth->login($data["email"], $data["password"], true, 3);

            if ($login) {
                $json["redirect"] = url("/painel/controle");
            } else {
                $json["message"] = $this->auth->message()->render();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Admin",
            CONF_SITE_DESC,
            url("/painel"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/login/login", [
            "head" => $head
        ]);
    }
}