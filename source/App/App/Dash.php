<?php

namespace Source\App\App;

use Source\Core\Controller;
use Source\Domain\Event\Models\Event;
use Source\Domain\Event\Models\EventParticipant;

/**
 * Class Dash
 * @package Source\App\App
 */
class Dash extends Controller
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");
    }

    /**
     * App home
     */
    public function home(): void
    {
        $user = user();

        $nextEvent = (new Event())->find("status = 'agendado' AND start_at >= NOW()")->order("start_at")->fetch();

        $eventCounts = (object)[
            "active" => (new EventParticipant())->find("user_id = :uid AND status IN ('confirmado', 'convocado')", "uid={$user->id}")->count(),
            "completed" => (new EventParticipant())->find("user_id = :uid AND status = 'presente'", "uid={$user->id}")->count(),
        ];

        echo $this->view->render("widgets/dash/home", [
            "user" => $user,
            "nextEvent" => $nextEvent,
            "eventCounts" => $eventCounts
        ]);
    }
}