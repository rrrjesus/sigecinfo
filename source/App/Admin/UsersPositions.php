<?php

namespace Source\App\Admin;

use Source\Models\Company\UserPosition;
use Source\Models\Company\User;

/**
 * Class UsersPositions
 * @package Source\App\Beta
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
     * unidade LISTA
     */
    public function userspositions(): void
    {
        $head = $this->seo->render(
            "Cargos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $userspositions = (new UserPosition())->find("status = :s", "s=actived")->fetch(true);
        $userposition = new UserPosition();

        echo $this->view->render("widgets/company/userspositions/list", [
            "head" => $head,
            "userspositions" => $userspositions,
            "urls" => "cargos",
            "namepage" => "Cargos",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $userposition->find("status = :s", "s=disabled")->count()
            ]
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

        echo $this->view->render("widgets/company/userspositions/disabledList",
            [
                "admin" => "cargos",
                "head" => $head,
                "userspositions" => $userspositions,
                "urls" => "cargos",
                "namepage" => "Cargos",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function userposition(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $userpositionCreate = new UserPosition();
            $userpositionCreate->position_name = $data["position_name"];
            $userpositionCreate->login_created = $user->login;
            $userpositionCreate->login_updated = $user->login;
            $userpositionCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if($data["position_name"] == ""){
                $json['message'] = $this->message->info("Informe o cargo para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userpositionCreate->save()) {
                $json["message"] = $userpositionCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cargo {$userpositionCreate->position_name} cadastrado com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/cargos/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userpositionUpdate = (new UserPosition())->findById($data["userposition_id"]);

            if (!$userpositionUpdate) {
                $this->message->error("Você tentou gerenciar um cargo que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/cargos")]);
                return;
            }

            $userpositionUpdate = (new UserPosition())->findById($data["userposition_id"]);
            $userpositionUpdate->position_name = $data["position_name"];
            $userpositionUpdate->login_updated = $user->login;
            $userpositionUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if($data["position_name"] == ""){
                $json['message'] = $this->message->info("Informe o cargo para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userpositionUpdate->save()) {
                $json["message"] = $userpositionUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Cargo {$userpositionUpdate->position_name} atualizado com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userpositionActived = (new UserPosition())->findById($data["userposition_id"]);
            $userposition = (new UserPosition())->find("status = :s","s=disabled")->count();

            if (!$userpositionActived) {
                $this->message->error("Você tentou gerenciar um cargo que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/cargos")]);
                return;
            }

            $userpositionActived->status = "actived";
            $userpositionActived->login_updated = $user->login;

            if (!$userpositionActived->save()) {
                $json["message"] = $userpositionActived->message()->render();
                echo json_encode($json);
                return;
            }


            if($userposition > 1){
                $this->message->success("Cargo {$userpositionActived->position_name} reativado com sucesso !!!")->icon("gift")->flash();
                redirect("/painel/cargos/desativados");
                return;
            }else{
                $this->message->warning("A lixeira esta vazia")->icon("trash")->flash();
                redirect("/painel/cargos");
                return;
            }
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userpositionDisabled = (new UserPosition())->findById($data["userposition_id"]);

            if (!$userpositionDisabled) {
                $this->message->error("Você tentou gerenciar um cargo que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/cargos")]);
                return;
            }

            $userpositionDisabled->status = "disabled";
            $userpositionDisabled->login_updated = $user->login;

            if (!$userpositionDisabled->save()) {
                $json["message"] = $userpositionDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cargo {$userpositionDisabled->position_name} desativado com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/cargos");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userpositionDelete = (new UserPosition())->findById($data["userposition_id"]);

            if (!$userpositionDelete) {
                $this->message->error("Você tentou deletar um cargo que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/cargos")]);
                return;
            }

            $userpositionDelete->destroy();

            $this->message->success("A unidade {$userpositionDelete->position_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/cargos");
            return;
        }

        $userpositionEdit = null;
        if (!empty($data["userposition_id"])) {
            $userpositionId = filter_var($data["userposition_id"], FILTER_VALIDATE_INT);
            $userpositionEdit = (new UserPosition())->findById($userpositionId);
        }

        $head = $this->seo->render(
            "Cargos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/company/userspositions/userposition", [
            "head" => $head,
            "userposition" => $userpositionEdit,
            "urls" => "cargos",
            "namepage" => "Cargos",
            "name" => ($userpositionEdit ? "Editar" : "Cadastrar")
        ]);
    }
}