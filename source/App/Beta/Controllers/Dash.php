<?php

namespace Source\App\Beta\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\App\Beta\Admin;

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
    // public function dash(): void
    // {
    //     redirect("/beta/home");
    // }

    public function home(?array $data): void
    {
        $head = $this->seo->render(
            "Dashboard - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/beta/home"),
            null,
            false
        );
        
        // Busca os dados para a dashboard do utilizador
        $eventRepo = new \Source\Domain\Event\EventRepository();
        $nextEvent = $eventRepo->findNextEventForUser($this->user->id);
        $eventCounts = $eventRepo->getUserEventCounts($this->user->id);

        echo $this->view->render("widgets/dash/home", [
            "head" => $head,
            "user" => $this->user,
            "nextEvent" => $nextEvent,
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