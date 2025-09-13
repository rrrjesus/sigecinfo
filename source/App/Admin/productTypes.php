<?php

namespace Source\App\Admin;

use Source\Models\Patrimony\productType;
use Source\Models\Company\User;

/**
 * Class productTypes
 * @package Source\App\Beta
 */
class productTypes extends Admin
{
    /**
     * productTypes constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TIPO DE PRODUTO LISTA
     */
    public function productTypes(): void
    {
        $head = $this->seo->render(
            "Patrimônios / Tipos de Produto - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $productTypes = (new productType())->find("status = :s", "s=actived")->fetch(true);
        $productType = new productType();

        echo $this->view->render("widgets/patrimonys/productTypes/list", [
            "head" => $head,
            "productTypes" => $productTypes,
            "urls" => "patrimonio/tipos-de-produtos",
            "namepage" => "Tipos de Produto",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $productType->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledTypes(): void
    {
        $head = $this->seo->render(
            "Tipos de Produto Desabilitados - " . CONF_SITE_NAME ,
            "Lista de Tipos de Produto Desativados",
            url("/painel/patrimonio/tipos-de-produto/desativadas"),
            theme("/assets/images/favicon.ico")
        );

        $productType = (new productType());
        $productTypes = $productType->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/patrimonys/productTypes/disabledList",
            [
                "admin" => "tipos-de-produto",
                "head" => $head,
                "productTypes" => $productTypes,
                "urls" => "patrimonio/tipos-de-produto",
                "namepage" => "Tipos de Produto",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function productType(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $productTypeCreate = new productType();
            $productTypeCreate->productType_name = $data["productType_name"];
            $productTypeCreate->description = $data["description"];
            $productTypeCreate->login_created = $user->login;
            $productTypeCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a marca e descrição para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$productTypeCreate->save()) {
                $json["message"] = $productTypeCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$productTypeCreate->productType_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/patrimonio/tipos-de-produto/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productTypeUpdate = (new productType())->findById($data["productType_id"]);

            if (!$productTypeUpdate) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/tipos-de-produto")]);
                return;
            }

            $productTypeUpdate = (new productType())->findById($data["productType_id"]);
            $productTypeUpdate->productType_name = $data["productType_name"];
            $productTypeUpdate->description = $data["description"];
            $productTypeUpdate->login_updated = $user->login;
            $productTypeUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a marca, descrição e status para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$productTypeUpdate->save()) {
                $json["message"] = $productTypeUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Marca {$productTypeUpdate->productType_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productTypeActived = (new productType())->findById($data["productType_id"]);

            if (!$productTypeActived) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/tipos-de-produto")]);
                return;
            }

            $productTypeActived->status = "actived";
            $productTypeActived->login_updated = $user->login;

            if (!$productTypeActived->save()) {
                $json["message"] = $productTypeActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$productTypeActived->productType_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/tipos-de-produto/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productTypeDisabled = (new productType())->findById($data["productType_id"]);

            if (!$productTypeDisabled) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/tipos-de-produto")]);
                return;
            }

            $productTypeDisabled->status = "disabled";
            $productTypeDisabled->login_updated = $user->login;

            if (!$productTypeDisabled->save()) {
                $json["message"] = $productTypeDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$productTypeDisabled->productType_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/tipos-de-produto");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productTypeDelete = (new productType())->findById($data["productType_id"]);

            if (!$productTypeDelete) {
                $this->message->error("Você tentou deletar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/tipos-de-produto")]);
                return;
            }

            $productTypeDelete->destroy();

            $this->message->success("A marca {$productTypeDelete->productType_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/patrimonio/tipos-de-produto");
            return;
        }

        $productTypeEdit = null;
        if (!empty($data["productType_id"])) {
            $productTypeId = filter_var($data["productType_id"], FILTER_VALIDATE_INT);
            $productTypeEdit = (new productType())->findById($productTypeId);
        }

        $head = $this->seo->render(
            "Tipos de Produto - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonys/productTypes/productType", [
            "head" => $head,
            "tipos-de-produto" => $productTypeEdit,
            "urls" => "patrimonio/tipos-de-produto",
            "namepage" => "Tipos de Produto",
            "name" => ($productTypeEdit ? "Editar" : "Cadastrar")
        ]);
    }
}