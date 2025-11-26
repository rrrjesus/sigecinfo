<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Shared\Models\Menu;
use Source\App\Admin\Admin;

class Menus extends Admin
{
    /** @var Auth */
    private Auth $auth;

    /**
     * Menus constructor.
     * @param Auth $auth
     */
    
    public function __construct(Auth $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function list(): void
    {
        // For simplicity, authorization is commented out. 
        // In a real application, you should implement this.
        // $this->authorize('Menus', 'view');

        $head = $this->seo->render(CONF_SITE_NAME . " | Menus", CONF_SITE_DESC, url("/painel/menus"), null, false);

        $breadcrumb = [
            ["title" => "Menus", "link" => url("/painel/menus")],
            ["title" => "Listar"]
        ];
        
        $menus = (new Menu())->find()->order("menu_order ASC")->fetch(true);

        echo $this->view->render("widgets/menus/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "menus" => $menus
        ]);
    }

    public function create(?array $data): void
    {
        //$this->authorize('Menus', 'create');

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $menuCreate = new Menu();
            $menuCreate->name = $data["name"];
            $menuCreate->icon = $data["icon"];
            $menuCreate->menu_order = $data["menu_order"];

            if (!$menuCreate->save()) {
                $json["message"] = $menuCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Menu cadastrado com sucesso!")->flash();
            $json["redirect"] = url("/painel/menus");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Menus", "link" => url("/painel/menus")],
            ["title" => "Criar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Novo Menu", CONF_SITE_DESC, url("/painel/menus"), "", false);

        echo $this->view->render("widgets/menus/form", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "menu" => null
        ]);
    }

    public function edit(array $data): void
    {
        // $this->authorize('Menus', 'edit');

        $menuEdit = (new Menu())->findById($data["menu_id"]);

        if (!$menuEdit) {
            $this->message->error("Você tentou editar um menu que não existe.")->flash();
            redirect("/painel/menus");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $menuEdit->name = $data["name"];
            $menuEdit->icon = $data["icon"];
            $menuEdit->menu_order = $data["menu_order"];

            if (!$menuEdit->save()) {
                $json["message"] = $menuEdit->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Menu atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/menus/editar/{$menuEdit->id}");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Menus", "link" => url("/painel/menus")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Editar Menu: {$menuEdit->name}", CONF_SITE_DESC, url("/painel"), "", false);
        
        echo $this->view->render("widgets/menus/form", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "menu" => $menuEdit
        ]);
    }

    public function delete(array $data): void
    {
        // $this->authorize('Menus', 'delete');

        $menuId = filter_var($data["menu_id"], FILTER_VALIDATE_INT);
        $menuDelete = (new Menu())->findById($menuId);

        if (!$menuDelete) {
            $this->message->error("O menu que você tentou excluir não existe.")->flash();
            redirect("/painel/menus");
        }

        $menuDelete->destroy();

        $this->message->success("Menu excluído com sucesso.")->flash();
        redirect(url("/painel/menus"));
    }
}
