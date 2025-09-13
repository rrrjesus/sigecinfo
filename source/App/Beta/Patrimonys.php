<?php

namespace Source\App\Beta;

use Source\Models\Company\User;
use Source\Support\Upload;
use Source\Support\Thumb;
use Source\Models\Patrimony\Patrimony;
use Source\Models\Patrimony\PatrimonyHistory;
use Source\Models\Patrimony\Product;

/**
 * Class Patrimonys
 * @package Source\App\Beta
 */
class Patrimonys extends Admin
{
    
    /**
     * Patrimonys constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * PATRIMONY LIST
     */
    public function patrimonys(): void
    {
        $head = $this->seo->render(
            "Patrimonios - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $patrimonys = (new Patrimony())->find("status = :s", "s=actived")->fetch(true);
        $patrimony = new Patrimony();

        echo $this->view->render("widgets/patrimonys/list", [
            "head" => $head,
            "patrimonys" => $patrimonys,
            "urls" => "patrimonios",
            "namepage" => "Patrimonios",
            "name" => "Lista",
            "registers" => (object)[
                "disabled" => $patrimony->find("status = :s", "s=disabled")->count()
            ]
        ]);
    }

    /**
     * @return void
     */
    public function disabledPatrimonys(): void
    {
        $head = $this->seo->render(
            "Patrimonios - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        $patrimonys = (new Patrimony())->find("status = :s", "s=disabled")->fetch(true);
        $patrimony = new Patrimony();

        echo $this->view->render("widgets/patrimonys/disabledList", [
            "head" => $head,
            "patrimonys" => $patrimonys,
            "urls" => "patrimonios",
            "namepage" => "Patrimonios Desabilitados",
            "name" => "Lista"
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function term(?array $data): void
    {
       //update term
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $termPrint = (new Patrimony())->findById($data["patrimonys_id"]);

        $head = $this->seo->render(
            CONF_SITE_NAME . " - Termo de - ".(!empty($termPrint->user()->rf) ? $termPrint->user()->rf : "Responsabilidade")." - "
            .(!empty($termPrint->user()->user_name) ? $termPrint->user()->user_name : "")." - ".$termPrint->product()->type_part_number.":".$termPrint->part_number ,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        if($termPrint->movement_id < 4){
            echo $this->view->render("widgets/patrimonys/withdrawalTerm", [
                "head" => $head,
                "term" => $termPrint,
                "urls" => "patrimonios",
                "namepage" => "Usuários",
                "name" => "Termo"
            ]);
        } else {
            echo $this->view->render("widgets/patrimonys/returnTerm", [
                "head" => $head,
                "term" => $termPrint,
                "urls" => "patrimonios",
                "namepage" => "Usuários",
                "name" => "Termo"
            ]);
        }
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function viewPatrimony(?array $data): void
    {
        $PatrimonysEdit = null;
        $historico = null;
        
        if (!empty($data["patrimonys_id"])) {
            $patrimonyId = filter_var($data["patrimonys_id"], FILTER_VALIDATE_INT);
            $PatrimonysEdit = (new Patrimony())->findById($patrimonyId);
            $historico = (new PatrimonyHistory())->find("patrimony_id = :p", "p={$patrimonyId}")->fetch(true);

            if(!$PatrimonysEdit){
                $this->message->error("Você tentou visualizar um patrimônio que não existe")->icon()->flash();
                redirect("/beta/patrimonios");
                return;
            }
        }
       
        $head = $this->seo->render(
            "Patrimonios - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonys/viewPatrimony", [
            "head" => $head,
            "patrimonys" => $PatrimonysEdit,
            "user" => $this->user,
            "historico" => $historico,
            "urls" => "patrimonios",
            "namepage" => "Patrimonios",
            "name" => "Visualizar"
        ]);
    }


    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function patrimony(?array $data): void
    {
       
        $user = (new User())->findById($this->user->id);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $movement_id = preg_replace("/[^0-9\s]/", "", $data["movement_id"]);
            $product_id_number = preg_replace("/[^0-9\s]/", "", $data["product_id"]);
            $product_id = substr($product_id_number, 0, 3);
            $part_number = $data["part_number"];
            $unit_id = $data["unit_id"];
            $user_id = preg_replace("/[^0-9\s]/", "", $data["user_id"]);
            $observations = $data["observations"];

            if($data["product_id"] != ''){

                $product = (new Product())->findById($product_id);

                if($product->type_part_number == 'IMEI'){
                    if(!is_imei($part_number)){
                        $json['message'] = $this->message->error("O IMEI : {$part_number} não é valido !, digite o IMEI com 15 números")->icon()->render();
                        echo json_encode($json);
                        return;
                    }
                }
    
                if($product->type_part_number == 'CHIP'){
                    if(!is_chip($part_number)){
                        $json['message'] = $this->message->error("O CHIP : {$part_number} não é valido !, digite o CHIP com 9 números")->icon()->render();
                        echo json_encode($json);
                        return;
                    }
                }
            }
            

            if($data["part_number"] == ""){
                $json['message'] = $this->message->warning("Informe o numero da peça para criar o patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["product_id"] == ""){
                $json['message'] = $this->message->warning("Informe um produto para criar o patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }
            
            if($data["movement_id"] == ""){
                $json['message'] = $this->message->warning("Informe um estado para criar o patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["user_id"] == ""){
                $json['message'] = $this->message->warning("Informe um usuário para criar o patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["unit_id"] == ""){
                $json['message'] = $this->message->warning("Informe uma unidade para criar o patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }

            $patrimonyCreate = new Patrimony();
            $patrimonyCreate->movement_id = $movement_id;
            $patrimonyCreate->product_id = $product_id;
            $patrimonyCreate->part_number = $part_number;
            $patrimonyCreate->unit_id = $unit_id;
            $patrimonyCreate->user_id = $user_id;
            $patrimonyCreate->observations = $observations;
            $patrimonyCreate->login_created = $user->login;
            $patrimonyCreate->created_at = date_fmt('', "Y-m-d h:m:s");

             //upload pdf
             if (!empty($_FILES["file_terms"])) {
                $files = $_FILES["file_terms"];
                $upload = new Upload();
                $file_terms = $upload->file($files, $patrimonyCreate->user_id.'_'.$patrimonyCreate->user()->user_name.'_'.$patrimonyCreate->product()->type_part_number.'_'.$patrimonyCreate->part_number);

                if (!$file_terms) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $patrimonyCreate->file_terms = $file_terms;
            }

            if (!$patrimonyCreate->save()) {
                $json["message"] = $patrimonyCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $patrimonyCreateHistory = new PatrimonyHistory();
            $patrimonyCreateHistory->patrimony_id = $patrimonyCreate->id;
            $patrimonyCreateHistory->movement_id = $movement_id;
            $patrimonyCreateHistory->product_id = $product_id;
            $patrimonyCreateHistory->unit_id = $unit_id;
            $patrimonyCreateHistory->user_id = $user_id;
            $patrimonyCreateHistory->part_number = $part_number;
            if (!empty($_FILES["file_terms"])) {
                $patrimonyCreateHistory->file_terms = $file_terms;
            }
            $patrimonyCreateHistory->observations = $observations;
            $patrimonyCreateHistory->login_created = $user->login;
            $patrimonyCreateHistory->created_history = date_fmt('', "Y-m-d h:m:s");
            $patrimonyCreateHistory->save();

            $this->message->success("Patrimônio {$patrimonyCreate->product()->type_part_number} {$patrimonyCreate->part_number} cadastrado com sucesso...")->icon("emoji-grin me-1")->flash();
            $json["redirect"] = url("/beta/patrimonio/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $patrimonys_id = $data["patrimonys_id"];
            $movement_id = preg_replace("/[^0-9\s]/", "", $data["movement_id"]);
            $unit_id_number = preg_replace("/[^0-9\s]/", "", $data["unit_id_edit"]);
            $unit_id = substr($unit_id_number, 0, 2);
            //$user_id = filter_var($data["user_id_edit"],FILTER_SANITIZE_NUMBER_INT);
            $user_id = preg_replace("/[^0-9\s]/", "", $data["user_id_edit"]);
            $observations = $data["observations"];

            $patrimonysUpdate = (new Patrimony())->findById($patrimonys_id);
            $patrimony = (new Patrimony());

            if (!$patrimonysUpdate) {
                $this->message->error("Você tentou gerenciar um patrimônio que não existe")->flash();
                echo json_encode(["redirect" => url("/beta/patrimonios")]);
                return;
            }

            if($data["movement_id"] == ""){
                $json['message'] = $this->message->warning("Informe um estado para lançar nova movimentação do patrimônio !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["user_id_edit"] == ""){
                $json['message'] = $this->message->warning("Informe um usuário para lançar nova movimentação do patrimônio !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($data["unit_id_edit"] == ""){
                $json['message'] = $this->message->warning("Informe uma unidade para lançar nova movimentação do patrimônio !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($patrimonysUpdate->movement_id == $movement_id) {
                $json['message'] = $this->message->warning("O patrimônio já está no estado : {$patrimonysUpdate->movement()->movement_name} !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($movement_id == "2") {
                if($patrimony->find("user_id = :u AND product_id = :p AND movement_id = :m AND id != :i","u={$user_id}&p={$patrimonysUpdate->product_id}&m=2&i={$patrimonysUpdate->id}")->fetch()) {
                    $json['message'] = $this->message->warning("Esse usuário já retirou {$patrimonysUpdate->product()->product_name} !!!")->icon()->render();
                    echo json_encode($json);
                    return;
                }
            }

            if($movement_id == "2" && $user_id == "1" || $movement_id == "2" && $user_id == "525"){
                $json['message'] = $this->message->warning("Esse usuário não retira patrimonio !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($patrimonysUpdate->movement_id == '2' && $movement_id == '3') {
                $json['message'] = $this->message->warning("O patrimônio foi retirado e não se encontra disponível para reserva !!!")->icon()->render();
                echo json_encode($json);
                return;
            }

            if($movement_id == '7'){
                $patrimonysUpdate->status = 'disabled';
            }
            $patrimonysUpdate->movement_id = $movement_id;
            $patrimonysUpdate->unit_id = $unit_id;
            $patrimonysUpdate->user_id = $user_id;
            $patrimonysUpdate->observations = $observations;
            $patrimonysUpdate->login_updated = $user->login;

             //upload pdf
             if (!empty($_FILES["file_terms"])) {
                $files = $_FILES["file_terms"];
                $upload = new Upload();
                
                $file_terms = $upload->file($files, $patrimonysUpdate->user_id.'_'.$patrimonysUpdate->user()->user_name.'_'.$patrimonysUpdate->product()->type_part_number.'_'.$patrimonysUpdate->part_number);

                if (!$file_terms) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $patrimonysUpdate->file_terms = $file_terms;
            } else {
                $patrimonysUpdate->file_terms = '';
            }

            if (!$patrimonysUpdate->save()) {
                $json["message"] = $patrimonysUpdate->message()->render();
                echo json_encode($json);
                return;
            }
            
            $patrimonysHistory = new PatrimonyHistory();
            $patrimonysHistory->patrimony_id = $patrimonys_id;
            $patrimonysHistory->movement_id = $movement_id;
            $patrimonysHistory->product_id = $patrimonysUpdate->product_id;
            $patrimonysHistory->unit_id = $unit_id;
            if (!empty($_FILES["file_terms"])) {
                $patrimonysHistory->file_terms = $file_terms;
            };
            $patrimonysHistory->user_id = $user_id;
            $patrimonysHistory->part_number = $patrimonysUpdate->part_number;
            $patrimonysHistory->observations = $observations;
            $patrimonysHistory->login_updated = $user->login;
            $patrimonysHistory->save();

            $this->message->success("Patrimonio {$patrimonysUpdate->part_number} atualizado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonio/detalhe/{$patrimonysUpdate->id}")]);
            return;
        }

         //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $patrimonyActived = (new Patrimony())->findById($data["patrimonys_id"]);

            if (!$patrimonyActived) {
                $this->message->error("Você tentou gerenciar um patrimônio que não existe")->icon()->flash();
                echo json_encode(["redirect" => url("/beta/patrimonios")]);
                return;
            }

            $patrimonyActived->status = "actived";
            $patrimonyActived->login_updated = $user->login;

            if (!$patrimonyActived->save()) {
                $json["message"] = $patrimonyActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Patrimônio {$patrimonyActived->product()->type_part_number} {$patrimonyActived->part_number} reativado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            redirect("/beta/patrimonios/desativados");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $patrimonyDisabled = (new Patrimony())->findById($data["patrimonys_id"]);

            if (!$patrimonyDisabled) {
                $this->message->error("Você tentou gerenciar um patrimônio que não existe")->icon()->flash();
                echo json_encode(["redirect" => url("/beta/patrimonios")]);
                return;
            }

            $patrimonyDisabled->status = "disabled";
            $patrimonyDisabled->login_updated = $user->login;

            if (!$patrimonyDisabled->save()) {
                $json["message"] = $patrimonyDisabled->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Patrimônio {$patrimonyDisabled->product()->type_part_number} - {$patrimonyDisabled->part_number} desativado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            redirect("/beta/patrimonios");
            return;
        }

          //writeoff
          if (!empty($data["action"]) && $data["action"] == "writeoff") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $patrimonyWriteoff = (new Patrimony())->findById($data["patrimonys_id"]);

            if (!$patrimonyWriteoff) {
                $this->message->error("Você tentou gerenciar um patrimônio que não existe")->icon()->flash();
                echo json_encode(["redirect" => url("/beta/patrimonios")]);
                return;
            }

            $patrimonyWriteoff->status = "writeoff";
            $patrimonyWriteoff->login_updated = $user->login;

            if (!$patrimonyWriteoff->save()) {
                $json["message"] = $patrimonyWriteoff->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Patrimônio {$patrimonyWriteoff->product()->type_part_number} - {$patrimonyWriteoff->type_number} dado como baixa com sucesso !!!")->icon("emoji-grin me-1")->flash();
            redirect("/beta/patrimonios");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $updateDelete = (new Patrimony())->findById($data["patrimonys_id"]);

            if (!$updateDelete) {
                $this->message->error("Você tentou deletar um patrimônio que não existe")->flash();
                echo json_encode(["redirect" => url("/beta/patrimonios")]);
                return;
            }

            if ($updateDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$updateDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$updateDelete->photo}");
                (new Thumb())->flush($updateDelete->photo);
            }

            if ($updateDelete->file && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$updateDelete->file}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$updateDelete->file}");
                (new Thumb())->flush($updateDelete->file);
            }

            $updateDelete->destroy();

            $this->message->success("O patrimônio {$updateDelete->product()->type_part_number} {$updateDelete->part_number} foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonios")]);

            return;
        }

        $PatrimonysEdit = null;
        $historico = null;
        
        if (!empty($data["patrimonys_id"])) {
            $patrimonyId = filter_var($data["patrimonys_id"], FILTER_VALIDATE_INT);
            $PatrimonysEdit = (new Patrimony())->findById($patrimonyId);
            $historico = (new PatrimonyHistory())->find("patrimony_id = :p", "p={$patrimonyId}")->fetch(true);
        }

        $patrimonysCreates = new Patrimony();
       
        $head = $this->seo->render(
            "Patrimonios - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonys/patrimony", [
            "head" => $head,
            "patrimonys" => $PatrimonysEdit,
            "patrimonyscreates" => $patrimonysCreates,
            "user" => $this->user,
            "historico" => $historico,
            "urls" => "patrimonios",
            "namepage" => "Patrimonios",
            "name" => ($PatrimonysEdit ? "Detalhar" : "Cadastrar")
        ]);
    }

}