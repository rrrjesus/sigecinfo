<?php

namespace Source\App\Beta;

use Source\Core\Controller;
use Source\Models\Auth;

/**
 * Class Login
 * @package Source\App\Beta
 */
class Login extends Controller
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");
    }

    /**
     * App access redirect
     */
    public function root(): void
    {
        $user = Auth::user();

        if ($user && $user->level_id >= 3) {
            redirect("/beta/home");
        } else {
            redirect("/entrar");
        }
    }

    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        $user = Auth::user();

        if ($user && $user->level_id >= 3) {
            redirect("/beta/home");
        }

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email']) || empty($data['password'])) {
                $json['message'] = $this->message->warning("Informe seu email e senha para entrar")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!empty($data["email"]) && !empty($data["password"])) {
                if (request_limit("loginLogin", 3, 5 * 60)) {
                    $json["message"] = $this->message->error("ACESSO NEGADO: Aguarde por 5 minutos para tentar novamente.")->render();
                    echo json_encode($json);
                    return;
                }

                $auth = new Auth();
                $login = $auth->login($data["email"], $data["password"], true, 5);

                if ($login) {
                    $this->message->success("Seja bem-vindo(a) de volta " . Auth::user()->user_name . "!")->icon()->flash();
                    $json["redirect"] = url("/beta/home");
                } else {
                    $json['message'] = $auth->message()->before("Ooops! ")->icon()->render();
                }

                echo json_encode($json);
                return;
            }
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | App",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_APP),
            false
        );

        echo $this->view->render("widgets/login/login", [
            "head" => $head
        ]);
    }
}