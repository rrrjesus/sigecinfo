<?php

namespace Source\App\App\Controllers;

use Source\Core\Controller;
use Source\Domain\Shared\Models\Auth;
use Source\Domain\Event\Models\Event;
use Source\Domain\Event\Models\EventParticipant;
use Source\App\App\Admin;

/**
 * Class Dash
 * @package Source\App\App\Controllers
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
     * App home
     */
    public function home(): void
    {
        $user = user();

        // Proteção da rota: verifica se o usuário está logado.
        if (!$user) {
             $this->message->info("Sua sessão expirou. Por favor, faça login novamente.")->flash();
            redirect("/entrar");
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/app/home"),
            theme("/assets/images/share.png", CONF_VIEW_APP)
        );

        $nextEvent = (new Event())->find("status = 'agendado' AND start_at >= NOW()")->order("start_at")->fetch();

        $participant = null;
        if ($nextEvent) {
            $participant = (new EventParticipant())->find(
                "event_id = :eid AND user_id = :uid",
                "eid={$nextEvent->id}&uid={$user->id}"
            )->fetch();
        }

        $eventCounts = (object)[
            "active" => (new EventParticipant())->find("user_id = :uid AND status IN ('confirmado', 'convocado')", "uid={$user->id}")->count(),
            "completed" => (new EventParticipant())->find("user_id = :uid AND status = 'presente'", "uid={$user->id}")->count(),
        ];



        echo $this->view->render("widgets/dash/home", [
            "head" => $head,
            "user" => $user,
            "nextEvent" => $nextEvent,
            "participant" => $participant,
            "eventCounts" => $eventCounts
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