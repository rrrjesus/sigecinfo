<?php

namespace Source\App\Admin;

use Source\Models\Patrimony\Brand;
use Source\Models\Company\User;

/**
 * Class Brands
 * @package Source\App\Beta
 */
class Brands extends Admin
{
    /**
     * Brands constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * MARCA LISTA
     */
    public function brands(): void
    {
        $head = $this->seo->render(
            "Patrimônios / Marcas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $brands = (new Brand())->find("status = :s", "s=actived")->fetch(true);
        $brand = new Brand();

        echo $this->view->render("widgets/patrimonys/brands/list", [
            "head" => $head,
            "brands" => $brands,
            "urls" => "patrimonio/marcas",
            "namepage" => "Marcas",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $brand->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledBrands(): void
    {
        $head = $this->seo->render(
            "Marcas Desabilitadas - " . CONF_SITE_NAME ,
            "Lista de Marcas Desativadas",
            url("/painel/patrimonio/marcas/desativadas"),
            theme("/assets/images/favicon.ico")
        );

        $brand = (new Brand());
        $brands = $brand->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/patrimonys/brands/disabledList",
            [
                "admin" => "marcas",
                "head" => $head,
                "brands" => $brands,
                "urls" => "patrimonio/marcas",
                "namepage" => "Marcas",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function brand(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $brandCreate = new Brand();
            $brandCreate->brand_name = $data["brand_name"];
            $brandCreate->description = $data["description"];
            $brandCreate->login_created = $user->login;
            $brandCreate->created_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a marca e descrição para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$brandCreate->save()) {
                $json["message"] = $brandCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$brandCreate->brand_name} cadastrada com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/patrimonio/marcas/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $brandUpdate = (new Brand())->findById($data["brand_id"]);

            if (!$brandUpdate) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/marcas")]);
                return;
            }

            $brandUpdate = (new Brand())->findById($data["brand_id"]);
            $brandUpdate->brand_name = $data["brand_name"];
            $brandUpdate->description = $data["description"];
            $brandUpdate->login_updated = $user->login;
            $brandUpdate->updated_at = date_fmt('', "Y-m-d h:m:s");

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Informe a marca, descrição e status para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$brandUpdate->save()) {
                $json["message"] = $brandUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Marca {$brandUpdate->brand_name} atualizada com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $brandActived = (new Brand())->findById($data["brand_id"]);

            if (!$brandActived) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/marcas")]);
                return;
            }

            $brandActived->status = "actived";
            $brandActived->login_updated = $user->login;

            if (!$brandActived->save()) {
                $json["message"] = $brandActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$brandActived->brand_name} reativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/marcas/desativadas");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $brandDisabled = (new Brand())->findById($data["brand_id"]);

            if (!$brandDisabled) {
                $this->message->error("Você tentou gerenciar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/marcas")]);
                return;
            }

            $brandDisabled->status = "disabled";
            $brandDisabled->login_updated = $user->login;

            if (!$brandDisabled->save()) {
                $json["message"] = $brandDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Marca {$brandDisabled->brand_name} desativada com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/marcas");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $brandDelete = (new Brand())->findById($data["brand_id"]);

            if (!$brandDelete) {
                $this->message->error("Você tentou deletar uma marca que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/marcas")]);
                return;
            }

            $brandDelete->destroy();

            $this->message->success("A marca {$brandDelete->brand_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/patrimonio/marcas");
            return;
        }

        $brandEdit = null;
        if (!empty($data["brand_id"])) {
            $brandId = filter_var($data["brand_id"], FILTER_VALIDATE_INT);
            $brandEdit = (new Brand())->findById($brandId);
        }

        $head = $this->seo->render(
            "Marcas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonys/brands/brand", [
            "head" => $head,
            "marcas" => $brandEdit,
            "urls" => "patrimonio/marcas",
            "namepage" => "Marcas",
            "name" => ($brandEdit ? "Editar" : "Cadastrar")
        ]);
    }
}