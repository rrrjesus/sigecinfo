<?php

namespace Source\App\Admin;

use Source\Models\Company\Unit;
use Source\Models\Company\User;

/**
 * Class Units
 * @package Source\App\Beta
 */
class Units extends Admin
{
    /**
     * Units constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * unidade LISTA
     */
    public function units(): void
    {
        $head = $this->seo->render(
            "Unidades - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $units = (new Unit())->find("status = :s", "s=actived")->fetch(true);
        $unit = new Unit();

        echo $this->view->render("widgets/company/units/list", [
            "head" => $head,
            "units" => $units,
            "urls" => "unidades",
            "namepage" => "Unidades",
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
    public function disabledUnits(): void
    {
        $head = $this->seo->render(
            "Unidades Desativadas - " . CONF_SITE_NAME ,
            "Lista de Unidades Desativadas",
            url("/painel/unidades/desativadas"),
            theme("/assets/images/favicon.ico")
        );

        $unit = (new Unit());
        $units = $unit->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/company/units/disabledList",
            [
                "admin" => "unidades",
                "head" => $head,
                "units" => $units,
                "urls" => "unidades",
                "namepage" => "Unidades",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function unit(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $unitCreate = new Unit();
            $unitCreate->unit_name = $data["unit_name"];
            $unitCreate->description = $data["description"];
            $unitCreate->fixed_phone = $data["fixed_phone"];
            $unitCreate->email = $data["email"];
            $unitCreate->adress = $data["adress"];
            $unitCreate->zip = $data["zip"];
            $unitCreate->it_professional = $data["it_professional"];
            $unitCreate->cell_phone = $data["cell_phone"];
            $unitCreate->observations = $data["observations"];
            $unitCreate->login_created = $user->login;
            $unitCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if($data["unit_name"] == "" || $data["description"] == "" || $data["adress"] == "" || $data["zip"] == "" || $data["it_professional"] == ""){
                $json['message'] = $this->message->info("Informe a unidade, descrição, endereço, cep e responsável para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$unitCreate->save()) {
                $json["message"] = $unitCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Unidade {$unitCreate->unit_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/unidades/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitUpdate = (new Unit())->findById($data["unit_id"]);

            if (!$unitUpdate) {
                $this->message->error("Você tentou gerenciar uma unidade que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/unidades")]);
                return;
            }

            $unitUpdate = (new Unit())->findById($data["unit_id"]);
            $unitUpdate->unit_name = $data["unit_name"];
            $unitUpdate->description = $data["description"];
            $unitUpdate->fixed_phone = $data["fixed_phone"];
            $unitUpdate->email = $data["email"];
            $unitUpdate->adress = $data["adress"];
            $unitUpdate->zip = $data["zip"];
            $unitUpdate->it_professional = $data["it_professional"];
            $unitUpdate->cell_phone = $data["cell_phone"];
            $unitUpdate->observations = $data["observations"];
            $unitUpdate->login_updated = $user->login;
            $unitUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if($data["unit_name"] == "" || $data["description"] == "" || $data["adress"] == "" || $data["zip"] == "" || $data["it_professional"] == ""){
                $json['message'] = $this->message->info("Informe a unidade, descrição, endereço, cep e responsável para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$unitUpdate->save()) {
                $json["message"] = $unitUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Unidade {$unitUpdate->unit_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitActived = (new Unit())->findById($data["unit_id"]);

            if (!$unitActived) {
                $this->message->error("Você tentou gerenciar uma unidade que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/unidades")]);
                return;
            }

            $unitActived->status = "actived";
            $unitActived->login_updated = $user->login;

            if (!$unitActived->save()) {
                $json["message"] = $unitActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Unidade {$unitActived->unit_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/unidades/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitDisabled = (new Unit())->findById($data["unit_id"]);

            if (!$unitDisabled) {
                $this->message->error("Você tentou gerenciar uma unidade que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/unidades")]);
                return;
            }

            $unitDisabled->status = "disabled";
            $unitDisabled->login_updated = $user->login;

            if (!$unitDisabled->save()) {
                $json["message"] = $unitDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Unidade {$unitDisabled->unit_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/unidades");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $unitDelete = (new Unit())->findById($data["unit_id"]);

            if (!$unitDelete) {
                $this->message->error("Você tentou deletar uma unidade que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/unidades")]);
                return;
            }

            $unitDelete->destroy();

            $this->message->success("A unidade {$unitDelete->unit_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/unidades");
            return;
        }

        $unitEdit = null;
        if (!empty($data["unit_id"])) {
            $unitId = filter_var($data["unit_id"], FILTER_VALIDATE_INT);
            $unitEdit = (new Unit())->findById($unitId);
        }

        $head = $this->seo->render(
            "Unidades - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/company/units/unit", [
            "head" => $head,
            "unit" => $unitEdit,
            "urls" => "unidades",
            "namepage" => "Unidades",
            "name" => ($unitEdit ? "Editar" : "Cadastrar")
        ]);
    }
}