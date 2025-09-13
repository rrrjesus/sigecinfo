<?php

namespace Source\App\Admin;

use Source\Models\Company\UserCategory;
use Source\Models\Company\User;

/**
 * Class UsersCategories
 * @package Source\App\Beta
 */
class UsersCategories extends Admin
{
    /**
     * UsersCategories constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * unidade LISTA
     */
    public function userscategories(): void
    {
        $head = $this->seo->render(
            "Regimes - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $userscategories = (new UserCategory())->find("status = :s", "s=actived")->fetch(true);
        $usercategory = new UserCategory();

        echo $this->view->render("widgets/company/userscategories/list", [
            "head" => $head,
            "userscategories" => $userscategories,
            "urls" => "regimes",
            "namepage" => "Regimes",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $usercategory->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledUsersCategories(): void
    {
        $head = $this->seo->render(
            "Regimes Desativados - " . CONF_SITE_NAME ,
            "Lista de Regimes Desativados",
            url("/painel/regimes/desativados"),
            theme("/assets/images/favicon.ico")
        );

        $usercategory = (new UserCategory());
        $userscategories = $usercategory->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/company/userscategories/disabledList",
            [
                "admin" => "regimes",
                "head" => $head,
                "userscategories" => $userscategories,
                "urls" => "regimes",
                "namepage" => "Regimes",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function usercategory(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $usercategoryCreate = new UserCategory();
            $usercategoryCreate->category_name = $data["category_name"];
            $usercategoryCreate->login_created = $user->login;
            $usercategoryCreate->login_updated = $user->login;
            $usercategoryCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if($data["category_name"] == ""){
                $json['message'] = $this->message->info("Informe o regime para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$usercategoryCreate->save()) {
                $json["message"] = $usercategoryCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Regime {$usercategoryCreate->category_name} cadastrado com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/regimes/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $usercategoryUpdate = (new UserCategory())->findById($data["usercategory_id"]);

            if (!$usercategoryUpdate) {
                $this->message->error("Você tentou gerenciar um regime que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/regimes")]);
                return;
            }

            $usercategoryUpdate = (new UserCategory())->findById($data["usercategory_id"]);
            $usercategoryUpdate->category_name = $data["category_name"];
            $usercategoryUpdate->login_updated = $user->login;
            $usercategoryUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if($data["category_name"] == ""){
                $json['message'] = $this->message->info("Informe o regime para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$usercategoryUpdate->save()) {
                $json["message"] = $usercategoryUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Regime {$usercategoryUpdate->category_name} atualizado com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $usercategoryActived = (new UserCategory())->findById($data["usercategory_id"]);
            $usercategory = (new UserCategory())->find("status = :s","s=disabled")->count();

            if (!$usercategoryActived) {
                $this->message->error("Você tentou gerenciar um regime que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/regimes")]);
                return;
            }

            $usercategoryActived->status = "actived";
            $usercategoryActived->login_updated = $user->login;

            if (!$usercategoryActived->save()) {
                $json["message"] = $usercategoryActived->message()->render();
                echo json_encode($json);
                return;
            }


            if($usercategory > 1){
                $this->message->success("Regime {$usercategoryActived->category_name} reativado com sucesso !!!")->icon("gift")->flash();
                redirect("/painel/regimes/desativados");
                return;
            }else{
                $this->message->warning("A lixeira esta vazia")->icon("trash")->flash();
                redirect("/painel/regimes");
                return;
            }
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $usercategoryDisabled = (new UserCategory())->findById($data["usercategory_id"]);

            if (!$usercategoryDisabled) {
                $this->message->error("Você tentou gerenciar um regime que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/regimes")]);
                return;
            }

            $usercategoryDisabled->status = "disabled";
            $usercategoryDisabled->login_updated = $user->login;

            if (!$usercategoryDisabled->save()) {
                $json["message"] = $usercategoryDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Regime {$usercategoryDisabled->category_name} desativado com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/regimes");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $usercategoryDelete = (new UserCategory())->findById($data["usercategory_id"]);

            if (!$usercategoryDelete) {
                $this->message->error("Você tentou deletar um regime que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/regimes")]);
                return;
            }

            $usercategoryDelete->destroy();

            $this->message->success("A unidade {$usercategoryDelete->category_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/regimes");
            return;
        }

        $usercategoryEdit = null;
        if (!empty($data["usercategory_id"])) {
            $usercategoryId = filter_var($data["usercategory_id"], FILTER_VALIDATE_INT);
            $usercategoryEdit = (new UserCategory())->findById($usercategoryId);
        }

        $head = $this->seo->render(
            "Regimes - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/company/userscategories/usercategory", [
            "head" => $head,
            "usercategory" => $usercategoryEdit,
            "urls" => "regimes",
            "namepage" => "Regimes",
            "name" => ($usercategoryEdit ? "Editar" : "Cadastrar")
        ]);
    }
}