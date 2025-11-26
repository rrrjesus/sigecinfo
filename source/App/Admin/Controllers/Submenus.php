<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Shared\Models\Menu;
use Source\Domain\Shared\Models\Submenu;
use Source\App\Admin\Admin;

/**
 * Class Sub
 * @package Source\App\Admin
 */
class Submenus extends Admin
{
     /** @var Auth */
    private Auth $auth;
    
    public function __construct(Auth $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function list(): void
    {
        // $this->authorize('Submenus', 'view');

        $head = $this->seo->render(CONF_SITE_NAME . " | Submenus", CONF_SITE_DESC, url("/painel/submenus"), null, false);

        $breadcrumb = [
            ["title" => "Submenus", "link" => url("/painel/submenus")],
            ["title" => "Listar"]
        ];
        
        $submenus = (new Submenu())->find()->order("submenu_order ASC")->fetch(true);

        echo $this->view->render("widgets/submenus/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "submenus" => $submenus
        ]);
    }

    public function create(?array $data): void
    {
        // $this->authorize('Submenus', 'create');

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $submenuCreate = new Submenu();
            $submenuCreate->name = $data["name"];
            $submenuCreate->menu_id = $data["menu_id"];
            $submenuCreate->parent_id = !empty($data["parent_id"]) ? $data["parent_id"] : null;
            $submenuCreate->url = $data["url"];
            $submenuCreate->icon = $data["icon"];
            $submenuCreate->submenu_order = $data["submenu_order"];

            if (!$submenuCreate->save()) {
                $json["message"] = $submenuCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Submenu cadastrado com sucesso!")->flash();
            $json["redirect"] = url("/painel/submenus");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Submenus", "link" => url("/painel/submenus")],
            ["title" => "Criar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Novo Submenu", CONF_SITE_DESC, url("/painel/submenus"), "", false);

        echo $this->view->render("widgets/submenus/form", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "submenu" => null,
            "menus" => (new Menu())->find()->order("name ASC")->fetch(true),
            "submenus" => (new Submenu())->find()->order("name ASC")->fetch(true)
        ]);
    }

    public function edit(array $data): void
    {
        // $this->authorize('Submenus', 'edit');

        $submenuEdit = (new Submenu())->findById($data["submenu_id"]);

        if (!$submenuEdit) {
            $this->message->error("Você tentou editar um submenu que não existe.")->flash();
            redirect("/painel/submenus");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $submenuEdit->name = $data["name"];
            $submenuEdit->menu_id = $data["menu_id"];
            $submenuEdit->parent_id = !empty($data["parent_id"]) ? $data["parent_id"] : null;
            $submenuEdit->url = $data["url"];
            $submenuEdit->icon = $data["icon"];
            $submenuEdit->submenu_order = $data["submenu_order"];

            if (!$submenuEdit->save()) {
                $json["message"] = $submenuEdit->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Submenu atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/submenus/editar/{$submenuEdit->id}");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Submenus", "link" => url("/painel/submenus")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Editar Submenu: {$submenuEdit->name}", CONF_SITE_DESC, url("/painel"), "", false);
        
        echo $this->view->render("widgets/submenus/form", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "submenu" => $submenuEdit,
            "menus" => (new Menu())->find()->order("name ASC")->fetch(true),
            "submenus" => (new Submenu())->find("id != :sid", "sid={$submenuEdit->id}")->order("name ASC")->fetch(true)
        ]);
    }

    public function delete(array $data): void
    {
        // $this->authorize('Submenus', 'delete');

        $submenuId = filter_var($data["submenu_id"], FILTER_VALIDATE_INT);
        $submenuDelete = (new Submenu())->findById($submenuId);

        if (!$submenuDelete) {
            $this->message->error("O submenu que você tentou excluir não existe.")->flash();
            redirect("/painel/submenus");
        }

        $submenuDelete->destroy();

        $this->message->success("Submenu excluído com sucesso.")->flash();
        redirect(url("/painel/submenus"));
    }
}
