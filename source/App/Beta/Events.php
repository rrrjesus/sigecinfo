<?php
namespace Source\App\Beta;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Event\EventRepository; // Usaremos um repositório para as buscas

class Events extends Admin
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     * Lista os eventos para os quais o utilizador foi convocado.
     */
    public function list(): void
    {
        $head = $this->seo->render("Meus Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/meus-eventos"), null, false);
        
        $eventRepo = new EventRepository();
        $myEvents = $eventRepo->getEventsForUser($this->user->id);

        echo $this->view->render("widgets/events/my-events", [
            "head" => $head,
            "events" => $myEvents
        ]);
    }

    /**
     * Busca todos os eventos para os quais um utilizador específico foi convocado.
     * @param int $userId
     * @return array|null
     */
    public function getEventsForUser(int $userId): ?array
    {
        $events = (new \Source\Domain\Event\Models\Event())->find(
            "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }
}