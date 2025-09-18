<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Contact;
use Source\Models\Category;
use Source\Models\Company\User;

/**
 * Iframe Controller
 * @package Source\App
 */
class Iframe extends Controller
{
    
    /**
     * Iframe constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_IFRAME);
    }

    /**
     * SITE BLOG
     * @param array|null $data
     * @return void
     */
    public function contact(?array $data): void
    {
        $head = $this->seo->render(
            "Agenda - " . CONF_SITE_NAME ,
            "Agenda de contatos SIGECINFO",
            url("/agenda"),
            theme("/assets/images/share.jpg", CONF_VIEW_IFRAME)
        );

        $contact = (new Contact())->find("status = :s", "s=actived")->fetch(true);

        echo $this->view->render("contact",
            [
                "head" => $head,
                "contact" => $contact,
                "urls" => "contatos",
                "icon" => "telephone",
                "iconpage" => "list",
                "page" => "Lista de Contatos"
            ]);
    }

        /**
     *  SITE ASSINATURA DE EMAIL
     */

    /**
     * @return void
     * @param null|array $data
     */
    public function creatorCard(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg", CONF_VIEW_IFRAME)
        );

        echo $this->view->render("email",
            [
                "head" => $head,
                "urls" => "email",
                "icon" => "envelope-at",
                "iconpage" => "credit-card-2-front",
                "page" => "Gerador de Assinatura de E-mail"
            ]);
    }

    /**
     * SITE NAV ERROR
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está diponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto:" . CONF_MAIL_SUPPORT;
                break;

            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;

            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo indispinível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url("/ops/{$error->code}"),
            theme("/assets/images/share.jpg", CONF_VIEW_IFRAME),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}