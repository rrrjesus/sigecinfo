<?php

namespace Source\App\Admin;

use Source\Models\Company\Church;
use Source\Models\Company\User;

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
     * igreja LISTA
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
        $unit = new Church();

        echo $this->view->render("widgets/company/churchs/list", [
            "head" => $head,
            "churchs" => $churchs,
            "urls" => "igrejas",
            "namepage" => "Igrejas",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $unit->find("status = :s", "s=disabled")->count()
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
            "Lista de Igrejas Desativadas",
            url("/painel/igrejas/desativadas"),
            theme("/assets/images/favicon.ico")
        );

        $unit = (new Church());
        $churchs = $unit->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/company/churchs/disabledList",
            [
                "admin" => "igrejas",
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

            $unitCreate = new Church();
            $unitCreate->church_name = $data["church_name"];
            $unitCreate->description = $data["description"];
            $unitCreate->phone_landline = $data["phone_landline"];
            $unitCreate->email = $data["email"];
            $unitCreate->adress = $data["adress"];
            $unitCreate->zip = $data["zip"];
            $unitCreate->it_professional = $data["it_professional"];
            $unitCreate->phone_mobile = $data["phone_mobile"];
            $unitCreate->observations = $data["observations"];
            $unitCreate->login_created = $user->login;
            $unitCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if($data["church_name"] == "" || $data["description"] == "" || $data["adress"] == "" || $data["zip"] == "" || $data["it_professional"] == ""){
                $json['message'] = $this->message->info("Informe a igreja, descrição, endereço, cep e responsável para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$unitCreate->save()) {
                $json["message"] = $unitCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$unitCreate->church_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/igrejas/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitUpdate = (new Church())->findById($data["church_id"]);

            if (!$unitUpdate) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/igrejas")]);
                return;
            }

            $unitUpdate = (new Church())->findById($data["church_id"]);
            $unitUpdate->church_name = $data["church_name"];
            $unitUpdate->description = $data["description"];
            $unitUpdate->phone_landline = $data["phone_landline"];
            $unitUpdate->email = $data["email"];
            $unitUpdate->adress = $data["adress"];
            $unitUpdate->zip = $data["zip"];
            $unitUpdate->it_professional = $data["it_professional"];
            $unitUpdate->phone_mobile = $data["phone_mobile"];
            $unitUpdate->observations = $data["observations"];
            $unitUpdate->login_updated = $user->login;
            $unitUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if($data["church_name"] == "" || $data["description"] == "" || $data["adress"] == "" || $data["zip"] == "" || $data["it_professional"] == ""){
                $json['message'] = $this->message->info("Informe a igreja, descrição, endereço, cep e responsável para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$unitUpdate->save()) {
                $json["message"] = $unitUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Igreja {$unitUpdate->church_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitActived = (new Church())->findById($data["church_id"]);

            if (!$unitActived) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/igrejas")]);
                return;
            }

            $unitActived->status = "actived";
            $unitActived->login_updated = $user->login;

            if (!$unitActived->save()) {
                $json["message"] = $unitActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$unitActived->church_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/igrejas/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitDisabled = (new Church())->findById($data["church_id"]);

            if (!$unitDisabled) {
                $this->message->error("Você tentou gerenciar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/igrejas")]);
                return;
            }

            $unitDisabled->status = "disabled";
            $unitDisabled->login_updated = $user->login;

            if (!$unitDisabled->save()) {
                $json["message"] = $unitDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja {$unitDisabled->church_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/igrejas");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitDelete = (new Church())->findById($data["church_id"]);

            if (!$unitDelete) {
                $this->message->error("Você tentou deletar uma igreja que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/igrejas")]);
                return;
            }

            $unitDelete->destroy();

            $this->message->success("A igreja {$unitDelete->church_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/igrejas");
            return;
        }

        $unitEdit = null;
        if (!empty($data["church_id"])) {
            $unitId = filter_var($data["church_id"], FILTER_VALIDATE_INT);
            $unitEdit = (new Church())->findById($unitId);
        }

        $head = $this->seo->render(
            "Igrejas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/company/churchs/church", [
            "head" => $head,
            "church" => $unitEdit,
            "urls" => "igrejas",
            "namepage" => "Igrejas",
            "name" => ($unitEdit ? "Editar" : "Cadastrar")
        ]);
    }
}