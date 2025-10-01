<?php

namespace Source\App\Admin\Controllers;
use Source\Domain\User\Models\User;
use Source\Domain\User\Models\UserPosition;
use Source\App\Admin\Admin;


/**
 * Class UsersPositions
 * @package Source\App\Admin
 */
class UsersPositions extends Admin
{
    /**
     * UsersPositions constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista os cargos ativos
     */
    public function userspositions(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Cargos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/cargos"), null, false);
        $positions = (new UserPosition())->find("status = :s", "s=actived")->order("position_name ASC")->fetch(true);

        $breadcrumb = [
            ["title" => "Cargos", "link" => url("/painel/cargos")],
            ["title" => "Listar"]
        ];
        
        echo $this->view->render("widgets/company/userspositions/list", [
            "head" => $head,
            "userspositions" => $positions,
            "breadcrumb" => $breadcrumb,
            "registers" => (object)["disabled" => (new UserPosition())->find("status = :s", "s=disabled")->count()]
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledUsersPositions(): void
    {
        $head = $this->seo->render(
            "Cargos Desativados - " . CONF_SITE_NAME ,
            "Lista de Cargos Desativados",
            url("/painel/cargos/desativados"),
            theme("/assets/images/favicon.ico")
        );

        $userposition = (new UserPosition());
        $userspositions = $userposition->find("status = :s", "s=disabled")->fetch(true);

        $breadcrumb = [
            ["title" => "Cargos Desativados", "link" => url("/painel/cargos/desabilitados")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/company/userspositions/disabledList",
            [
                "admin" => "cargos",
                "head" => $head,
                "userspositions" => $userspositions
            ]);

    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = sanitize_array($data);

            $positionCreate = new UserPosition();
            $positionCreate->position_name = $data["position_name"];
            $positionCreate->login_created = $this->user->id;

            if (!$positionCreate->save()) {
                $json["message"] = $positionCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cargo cadastrado com sucesso!")->flash();
            $json["redirect"] = url("/painel/cargos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Cadastrar Cargo - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/cargos"), null, false);
        echo $this->view->render("widgets/company/userspositions/userposition", [
            "head" => $head,
            "userposition" => null
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $positionId = filter_var($data["userposition_id"], FILTER_VALIDATE_INT);
        $positionUpdate = (new UserPosition())->findById($positionId);

        if (!$positionUpdate) {
            $this->message->error("Você tentou editar um cargo que não existe.")->flash();
            redirect("/painel/cargos");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = sanitize_array($data);
            
            $positionUpdate->position_name = $data["position_name"];
            $positionUpdate->login_updated = $this->user->id;

            if (!$positionUpdate->save()) {
                $json["message"] = $positionUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cargo atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/cargos/editar/{$positionUpdate->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Editar Cargo: {$positionUpdate->position_name}", CONF_SITE_DESC, url("/painel/cargos"), null, false);
        echo $this->view->render("widgets/company/userspositions/userposition", [
            "head" => $head,
            "userposition" => $positionUpdate
        ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);

        $positionId = filter_var($data["userposition_id"], FILTER_VALIDATE_INT);
        $positionDelete = (new UserPosition())->findById($positionId);

        if ($positionDelete) {
            $positionDelete->destroy();
        }

        $this->message->success("O cargo foi excluído com sucesso.")->flash();
        redirect(url_back());
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $positionId = filter_var($data["userposition_id"], FILTER_VALIDATE_INT);
        $position = (new UserPosition())->findById($positionId);

        if ($position) {
            $position->status = ($position->status == "actived" ? "disabled" : "actived");
            $position->login_updated = $this->user->id;
            $position->save();
        }
        
        $actionText = ($position->status == "actived" ? "ativado" : "desativado");
        $this->message->success("O cargo foi {$actionText} com sucesso!")->flash();
        redirect(url_back());
    }
}