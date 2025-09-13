<?php

namespace Source\App\Admin;

use Source\Models\Patrimony\Contract;
use Source\Models\Patrimony\Brand;
use Source\Models\Patrimony\Product;
use Source\Models\Company\User;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class Products
 * @package Source\App\Beta
 */
class Products extends Admin
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * MARCA LISTA
     */
    public function products(): void
    {
        $head = $this->seo->render(
            "Patrimônios / Produtos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $products = (new Product())->find("status = :s", "s=actived")->fetch(true);
        $product = new Product();

        echo $this->view->render("widgets/patrimonys/products/list", [
            "head" => $head,
            "products" => $products,
            "urls" => "patrimonio/produtos",
            "namepage" => "Produtos",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $product->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledProducts(): void
    {
        $head = $this->seo->render(
            "Produtos Desabilitados - " . CONF_SITE_NAME ,
            "Lista de Produtos Desativados",
            url("/painel/patrimonio/produtos/desativados"),
            theme("/assets/images/favicon.ico")
        );

        $product = (new Product());
        $products = $product->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/patrimonys/products/disabledList",
            [
                "admin" => "produtos",
                "head" => $head,
                "products" => $products,
                "urls" => "patrimonio/produtos",
                "namepage" => "Produtos",
                "name" => "Lista"
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function product(?array $data): void
    {
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $productCreate = new Product();
            $productCreate->contract_id = preg_replace("/[^0-9\s]/", "", $data["contract_id"]);
            $productCreate->brand_id = preg_replace("/[^0-9\s]/", "", $data["brand_id"]);
            $productCreate->product_name = $data["product_name"];
            $productCreate->type_part_number = $data["type_part_number"];
            $productCreate->acessories = $data["acessories"];
            $productCreate->login_created = $user->login;
            $productCreate->created_at = date_fmt('', "Y-m-d h:m:s");

             //upload photo
             if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $productCreate->product_name, 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $productCreate->photo = $image;
            }

            if(in_array("", $data)){
                $json['message'] = $this->message->info("Insira a imagem, o contrato, a marca, o produto, o tipo de partnumber e a descrição para cadastrar o produto !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$productCreate->save()) {
                $json["message"] = $productCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Producto {$productCreate->product_name} cadastrado com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/painel/patrimonio/produtos/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productUpdate = (new Product())->findById($data["product_id"]);

            if (!$productUpdate) {
                $this->message->error("Você tentou gerenciar um produto que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/produtos")]);
                return;
            }

            $productUpdate = (new Product())->findById($data["product_id"]);
            $productUpdate->contract_id = preg_replace("/[^0-9\s]/", "", $data["contract_id"]);
            $productUpdate->brand_id = preg_replace("/[^0-9\s]/", "", $data["brand_id"]);
            $productUpdate->product_name = $data["product_name"];
            $productUpdate->type_part_number = $data["type_part_number"];
            $productUpdate->acessories = $data["acessories"];
            $productUpdate->login_updated = $user->login;

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($productUpdate->photo()) {
                    (new Thumb())->flush("storage/{$productUpdate->photo}");
                    $upload->remove("storage/{$productUpdate->photo}");
                }

                if (!$productUpdate->photo = $upload->image($file, "{$productUpdate->product_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$productUpdate->product_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if($data["contract_id"] == ""){
                $json['message'] = $this->message->warning("Informe um contrato para atualizar o produto !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["brand_id"] == ""){
                $json['message'] = $this->message->warning("Informe uma marco para atualizar o produto !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["product_name"] == ""){
                $json['message'] = $this->message->warning("Informe um produto para atualizar o produto !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["type_part_number"] == ""){
                $json['message'] = $this->message->warning("Informe um produto para atualizar o produto !")->icon()->render();
                echo json_encode($json);
                return;
            }            

            if (!$productUpdate->save()) {
                $json["message"] = $productUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Producto {$productUpdate->product_name} atualizado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

          //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productActived = (new Product())->findById($data["product_id"]);

            if (!$productActived) {
                $this->message->error("Você tentou gerenciar um produto que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/produtos")]);
                return;
            }

            $productActived->status = "actived";
            $productActived->login_updated = $user->login;

            if (!$productActived->save()) {
                $json["message"] = $productActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Producto {$productActived->product_name} reativado com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/produtos/desativados");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productDisabled = (new Product())->findById($data["product_id"]);

            if (!$productDisabled) {
                $this->message->error("Você tentou gerenciar um produto que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/produtos")]);
                return;
            }

            $productDisabled->status = "disabled";
            $productDisabled->login_updated = $user->login;

            if (!$productDisabled->save()) {
                $json["message"] = $productDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Producto {$productDisabled->product_name} desativado com sucesso !!!")->icon("gift")->flash();
            redirect("/painel/patrimonio/produtos");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productDelete = (new Product())->findById($data["product_id"]);

            if (!$productDelete) {
                $this->message->error("Você tentou deletar um produto que não existe")->icon("gift")->flash();
                echo json_encode(["redirect" => url("/painel/patrimonio/produtos")]);
                return;
            }

            $productDelete->destroy();

            $this->message->success("A marca {$productDelete->product_name} foi excluída com sucesso...")->icon("gift")->flash();
            redirect("/painel/patrimonio/produtos");
            return;
        }

       $contracts = new Contract();
       $brands = new Brand();
       $products = new Product();

        $productEdit = null;
        if (!empty($data["product_id"])) {
            $productId = filter_var($data["product_id"], FILTER_VALIDATE_INT);
            $productEdit = (new Product())->findById($productId);
        }

        $head = $this->seo->render(
            "Produtos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonys/products/product", [
            "head" => $head,
            "produtos" => $productEdit,
            "products" => $products,
            "contracts" => $contracts,
            "brands" => $brands,
            "urls" => "patrimonio/produtos",
            "namepage" => "Produtos",
            "name" => ($productEdit ? "Editar" : "Cadastrar")
        ]);
    }
}