<?php

namespace Source\App\Admin;

use Source\Models\Company\Level;

/**
 * Class Levels
 * @package Source\App\Admin
 */
class Levels extends Admin
{
    /**
     * Levels constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista níveis ativas
     */
    public function levels(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Níveis - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        $levels = (new Level())->find()->order("level_name DESC")->fetch(true);
        
        echo $this->view->render("widgets/company/levels/list", [
            "head" => $head,
            "urls" => "niveis",
            "namepage" => "Níveis",
            "name" => "Lista",
            "levels" => $levels
        ]);
    }
}