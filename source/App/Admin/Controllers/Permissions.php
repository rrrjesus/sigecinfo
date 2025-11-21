<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Shared\Models\Permission;
use Source\Core\Controller;
use Source\Core\View;

/**
 * Class Permissions
 * @package Source\App\Admin\Controllers
 */
class Permissions extends Controller
{
    /**
     * Permissions constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../../themes/" . CONF_VIEW_ADMIN . "/");
    }

    /**
     * Lista todas as permissões
     * @return void
     */
    public function list(): void
    {
        $permissions = (new Permission())->find()->order("name")->fetch(true);

        $head = $this->seo->render(
            "Permissões - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/painel/permissoes"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/permissions/list", [
            "head" => $head,
            "permissions" => $permissions
        ]);
    }
}