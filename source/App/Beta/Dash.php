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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/beta/home");
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
            "head" => $head,
            "chartTablets" => (object) [
                "estoque" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=1&p=5&s=actived")->count(),
                "retirado" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=2&p=5&s=actived")->count(),
                "reservado" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=3&p=5&s=actived")->count(),
                "devolvido" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=4&p=5&s=actived")->count(),
                "assistencia" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=5&p=5&s=actived")->count(),
                "boletim" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=6&p=5&s=actived")->count(),
                "baixa" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=7&p=5&s=actived")->count(),
                "totals" => (new Patrimony())->find("product_id = :p AND status = :s", "p=5&s=actived")->count(),
            ],
            "chartPrinters" => (object) [
                "estoque" => (new Patrimony())->find("movement_id = :m AND product_id = :p4 AND status = :s OR movement_id = :m AND product_id = :p8 AND status = :s", "m=1&p4=4&p8=8&s=actived")->count(),
                "retirado" => (new Patrimony())->find("movement_id = :m AND product_id = :p4 AND status = :s OR movement_id = :m AND product_id = :p8 AND status = :s", "m=2&p4=4&p8=8&s=actived")->count(),
                "reservado" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=3&p=4&s=actived")->count(),
                "devolvido" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=4&p=4&s=actived")->count(),
                "assistencia" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=5&p=4&s=actived")->count(),
                "boletim" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=6&p=4&s=actived")->count(),
                "baixa" => (new Patrimony())->find("movement_id = :m AND product_id = :p4 AND status = :s OR movement_id = :m AND product_id = :p8 AND status = :s", "m=7&p4=4&p8=8&s=actived")->count(),
                "totals" => (new Patrimony())->find("product_id = :p4 OR product_id = :p8", "p4=4&p8=8")->count(),
            ],
            "chartChips" => (object) [
                "estoque" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=1&p=3&s=actived")->count(),
                "retirado" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=2&p=3&s=actived")->count(),
                "reservado" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=3&p=3&s=actived")->count(),
                "devolvido" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=4&p=3&s=actived")->count(),
                "assistencia" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=5&p=3&s=actived")->count(),
                "boletim" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=6&p=3&s=actived")->count(),
                "baixa" => (new Patrimony())->find("movement_id = :m AND product_id = :p AND status = :s", "m=7&p=3&s=actived")->count(),
                "totals" => (new Patrimony())->find("product_id = :p AND status = :s", "p=3&s=actived")->count(),
            ],
            "chartTablets2021" => (object) [
                "estoque" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=1&p1=1&p2=2&p3=6&p4=7")->count(),
                "retirado" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=2&p1=1&p2=2&p3=6&p4=7")->count(),
                "reservado" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=3&p1=1&p2=2&p3=6&p4=7")->count(),
                "devolvido" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=4&p1=1&p2=2&p3=6&p4=7")->count(),
                "assistencia" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=5&p1=1&p2=2&p3=6&p4=7")->count(),
                "boletim" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=6&p1=1&p2=2&p3=6&p4=7")->count(),
                "baixa" => (new Patrimony())->find("movement_id = :m AND product_id = :p1 OR movement_id = :m AND product_id = :p2 OR movement_id = :m AND product_id = :p3 OR movement_id = :m AND product_id = :p4", "m=7&p1=1&p2=2&p3=6&p4=7")->count(),
                "totals" => (new Patrimony())->find("product_id = :p1 OR product_id = :p2 OR product_id = :p3 OR product_id = :p4", "p1=1&p2=2&p3=6&p4=7")->count(),
            ]
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->user_name}.")->icon()->flash();

        Auth::logout();
        redirect("/entrar");
    }
}