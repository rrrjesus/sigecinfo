<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\User\Models\Level;
use Source\App\Admin\Admin;

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

        $breadcrumb = [
            ["title" => "Nível", "link" => url("/painel/niveis")],
            ["title" => "Ativos"]
        ];
        
        echo $this->view->render("widgets/levels/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "levels" => $levels
        ]);
    }
}