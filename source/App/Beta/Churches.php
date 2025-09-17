<?php

namespace Source\App\Beta;

use Source\Models\Company\User;
use Source\Models\Church;

/**
 * Class Churchs
 * @package Source\App\Beta
 */
class Churchs extends Admin
{
    /**
     * Churchs constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * IGREJAS LISTA
     */
    public function churchs(): void
    {
        $head = $this->seo->render(
            "Igrejas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $churchs = (new Church())->find("status = :s", "s=actived")->fetch(true);
        $church = new Church();

        echo $this->view->render("widgets/churchs/list", [
            "head" => $head,
            "churchs" => $churchs,
            "urls" => "igrejas",
            "namepage" => "Igrejas",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $church->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledChurches(): void
    {
        $head = $this->seo->render(
            "Igrejas Desativadas - " . CONF_SITE_NAME ,
            "Lista de Igrejas Desativados",
            url("/beta/igrejas/desativadas"),
            theme("/assets/images/favicon.ico")
        );

        $church = (new Church());
        $churchs = $church->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/churchs/disabledList",
            [
                "head" => $head,
                "churchs" => $churchs,
                "urls" => "igrejas",
                "namepage" => "Igrejas",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function church(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $churcheCreate = new Church();
            $churcheCreate->churche_name = $data["churche_name"];
            $churcheCreate->login_created = $user->login;
            $churcheCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a igreja para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churcheCreate->save()) {
                $json["message"] = $churcheCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churcheCreate->churche_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/beta/igrejas/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churcheUpdate = (new Church())->findById($data["churche_id"]);

            if (!$churcheUpdate) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churcheUpdate = (new Church())->findById($data["churche_id"]);
            $churcheUpdate->churche_name = $data["churche_name"];
            $churcheUpdate->login_updated = $user->login;
            $churcheUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a igreja para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churcheUpdate->save()) {
                $json["message"] = $churcheUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Igreja {$churcheUpdate->churche_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churcheActived = (new Church())->findById($data["churche_id"]);

            if (!$churcheActived) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churcheActived->status = "actived";
            $churcheActived->login_updated = $user->login;

            if (!$churcheActived->save()) {
                $json["message"] = $churcheActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churcheActived->churche_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/igrejas/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churcheDisabled = (new Church())->findById($data["churche_id"]);

            if (!$churcheDisabled) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churcheDisabled->status = "disabled";
            $churcheDisabled->login_updated = $user->login;

            if (!$churcheDisabled->save()) {
                $json["message"] = $churcheDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churcheDisabled->churche_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/igrejas");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churcheDelete = (new Church())->findById($data["churche_id"]);

            if (!$churcheDelete) {
                $this->message->error("Você tentou deletar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churcheDelete->destroy();

            $this->message->success("A igreja {$churcheDelete->churche_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/beta/igrejas");
            return;
        }

        $churcheEdit = null;
        if (!empty($data["churche_id"])) {
            $brandId = filter_var($data["churche_id"], FILTER_VALIDATE_INT);
            $churcheEdit = (new Church())->findById($brandId);
        }

        $head = $this->seo->render(
            "Igrejas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/churchs/church", [
            "head" => $head,
            "churchs" => $churcheEdit,
            "urls" => "igrejas",
            "namepage" => "Igrejas",
            "name" => ($churcheEdit ? "Editar" : "Cadastrar")
        ]);
    }
}