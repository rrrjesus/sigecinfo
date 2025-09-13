<?php

namespace Source\App\Beta;

use Source\Models\Company\User;
use Source\Models\Contact;
use Source\Models\Company\Unit;

/**
 * Class Contacts
 * @package Source\App\Beta
 */
class Contacts extends Admin
{
    /**
     * Contacts constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * CONTATO LISTA
     */
    public function contacts(): void
    {
        $head = $this->seo->render(
            "Contatos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $contacts = (new Contact())->find("status = :s", "s=actived")->fetch(true);
        $contact = new Contact();

        echo $this->view->render("widgets/contacts/list", [
            "head" => $head,
            "contacts" => $contacts,
            "urls" => "contatos",
            "namepage" => "Contatos",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $contact->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledContacts(): void
    {
        $head = $this->seo->render(
            "Contatos Desativados - " . CONF_SITE_NAME ,
            "Lista de Contatos Desativados",
            url("/beta/contatos/desativados"),
            theme("/assets/images/favicon.ico")
        );

        $contact = (new Contact());
        $contacts = $contact->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/contacts/disabledList",
            [
                "head" => $head,
                "contacts" => $contacts,
                "urls" => "contatos",
                "namepage" => "Contatos",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function contact(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $contactCreate = new Contact();
            $contactCreate->unit_id = preg_replace("/[^0-9\s]/", "", $data["unit_id"]);
            $contactCreate->contact_name = $data["contact_name"];
            $contactCreate->ramal = $data["ramal"];
            $contactCreate->login_created = $user->login;
            $contactCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe o contato e setor para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$contactCreate->save()) {
                $json["message"] = $contactCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Contato {$contactCreate->contact_name} cadastrado com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/beta/contatos/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $contactUpdate = (new Contact())->findById($data["contact_id"]);

            if (!$contactUpdate) {
                $this->message->error("Você tentou gerenciar um contato que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/contatos")]);
                return;
            }

            $contactUpdate = (new Contact())->findById($data["contact_id"]);
            $contactUpdate->unit_id = preg_replace("/[^0-9\s]/", "", $data["unit_id"]);
            $contactUpdate->contact_name = $data["contact_name"];
            $contactUpdate->ramal = $data["ramal"];
            $contactUpdate->login_updated = $user->login;
            $contactUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe o contato, descrição e status para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$contactUpdate->save()) {
                $json["message"] = $contactUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Contato {$contactUpdate->contact_name} atualizado com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $contactActived = (new Contact())->findById($data["contact_id"]);

            if (!$contactActived) {
                $this->message->error("Você tentou gerenciar um contato que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/contatos")]);
                return;
            }

            $contactActived->status = "actived";
            $contactActived->login_updated = $user->login;

            if (!$contactActived->save()) {
                $json["message"] = $contactActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Contato {$contactActived->contact_name} reativado com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/contatos/desativados");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $contactDisabled = (new Contact())->findById($data["contact_id"]);

            if (!$contactDisabled) {
                $this->message->error("Você tentou gerenciar um contato que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/contatos")]);
                return;
            }

            $contactDisabled->status = "disabled";
            $contactDisabled->login_updated = $user->login;

            if (!$contactDisabled->save()) {
                $json["message"] = $contactDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Contato {$contactDisabled->contact_name} desativado com sucesso !!!")->icon("gift")->flash();
            redirect("/beta/contatos");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $contactDelete = (new Contact())->findById($data["contact_id"]);

            if (!$contactDelete) {
                $this->message->error("Você tentou deletar um contato que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/beta/contatos")]);
                return;
            }

            $contactDelete->destroy();

            $this->message->success("O contato {$contactDelete->contact_name} foi excluído com sucesso...")->icon("gift")->flash();
            redirect("/beta/contatos");
            return;
        }

        $contactEdit = null;
        if (!empty($data["contact_id"])) {
            $brandId = filter_var($data["contact_id"], FILTER_VALIDATE_INT);
            $contactEdit = (new Contact())->findById($brandId);
        }

        $unit = new Unit();

        $head = $this->seo->render(
            "Contatos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/contacts/contact", [
            "head" => $head,
            "contacts" => $contactEdit,
            "unit" => $unit,
            "urls" => "contatos",
            "namepage" => "Contatos",
            "name" => ($contactEdit ? "Editar" : "Cadastrar")
        ]);
    }
}