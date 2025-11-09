<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\App\Admin\Admin;
use Source\Domain\Report\Models\Online;
use Source\Domain\Place\PlaceRepository;
use Source\Domain\Event\EventRepository;
use Source\Domain\User\UserRepository;
use Source\Domain\User\UserPositionRepository;

/**
 * Class Dash
 * @package Source\App\Admin
 */
class Dash extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/painel/controle/inicial");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        //real time access
        if (!empty($data["refresh"])) {
            $list = null;
            $items = (new Online())->findByActive();
            if ($items) {
                foreach ($items as $item) {
                    $list[] = [
                        "dates" => date_fmt($item->created_at, "H\hi") . " - " . date_fmt($item->updated_at, "H\hi"),
                        "user" => ($item->user ? $item->user()->user_name : "Visitante"),
                        "pages" => $item->pages,
                        "url" => $item->url
                    ];
                }
            }

            echo json_encode([
                "count" => (new Online())->findByActive(true),
                "list" => $list
            ]);
            return;
        }
        $breadcrumb = [
            ["title" => "Painel de Controle", "link" => url("/painel/controle/inicial")],
            ["title" => "Monitoramento"]
        ];

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/painel"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

         // Instancia os Repositories
        $placeRepo = new PlaceRepository();
        $userRepo = new UserRepository();
        $userPositionRepo = new UserPositionRepository();
        $eventRepo = new EventRepository(); // <-- Instancia o novo Repository

        echo $this->view->render("widgets/dash/home", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "places" => $placeRepo->getStatusCounts(),
            "users" => $userRepo->getLevelCounts(),
            "userspositions" => $userPositionRepo->getStatusCounts(),
            "events" => $eventRepo->getDashboardCounts(), 
            
            "online" => (new Online())->findByActive(),
            "onlineCount" => (new Online())->findByActive(true)
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->user_name}.")->flash();

        Auth::logout();
        redirect("/painel/login");
    }
}