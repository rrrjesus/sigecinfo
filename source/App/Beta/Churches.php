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
    public function disabledChurchs(): void
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

            $churchCreate = new Church();
            $churchCreate->church_name = $data["church_name"];
            $churchCreate->login_created = $user->login;
            $churchCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a igreja para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churchCreate->save()) {
                $json["message"] = $churchCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churchCreate->church_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/beta/igrejas/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churchUpdate = (new Church())->findById($data["church_id"]);

            if (!$churchUpdate) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churchUpdate = (new Church())->findById($data["church_id"]);
            $churchUpdate->church_name = $data["church_name"];
            $churchUpdate->login_updated = $user->login;
            $churchUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a igreja para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churchUpdate->save()) {
                $json["message"] = $churchUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Igreja {$churchUpdate->church_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churchActived = (new Church())->findById($data["church_id"]);

            if (!$churchActived) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churchActived->status = "actived";
            $churchActived->login_updated = $user->login;

            if (!$churchActived->save()) {
                $json["message"] = $churchActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churchActived->church_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/igrejas/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churchDisabled = (new Church())->findById($data["church_id"]);

            if (!$churchDisabled) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churchDisabled->status = "disabled";
            $churchDisabled->login_updated = $user->login;

            if (!$churchDisabled->save()) {
                $json["message"] = $churchDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$churchDisabled->church_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/igrejas");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $churchDelete = (new Church())->findById($data["church_id"]);

            if (!$churchDelete) {
                $this->message->error("Você tentou deletar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/igrejas")]);
                return;
            }

            $churchDelete->destroy();

            $this->message->success("A igreja {$churchDelete->church_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/beta/igrejas");
            return;
        }

        $churchEdit = null;
        if (!empty($data["church_id"])) {
            $brandId = filter_var($data["church_id"], FILTER_VALIDATE_INT);
            $churchEdit = (new Church())->findById($brandId);
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
            "churchs" => $churchEdit,
            "urls" => "igrejas",
            "namepage" => "Igrejas",
            "name" => ($churchEdit ? "Editar" : "Cadastrar")
        ]);
    }
}