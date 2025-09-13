<?php

namespace Source\App\Beta;

use Source\Models\Company\User;
use Source\Support\Upload;
use Source\Models\Patrimony\Patrimony;
use Source\Models\Patrimony\PatrimonyHistory;

/**
 * Class PatrimonyHistory
 * @package Source\App\Beta
 */
class PatrimonysHistory extends Admin
{
    
/**
 * PatrimonyHistory constructor.
 */
public function __construct()
{
    parent::__construct();
}

/**
     * PATRIMONY LIST
     */
    public function patrimonysHistory(): void
    {
        $head = $this->seo->render(
            "Patrimonios - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/patrimonysHistory/list", [
            "head" => $head,
            "urls" => "patrimonios/historico",
            "namepage" => "Histórico de Patrimonios",
            "name" => "Lista"
        ]);
    }


/**
 * @param array|null $data
 * @throws \Exception
 */
public function patrimonyHistory(?array $data): void
{
    
    $user = (new User())->findById($this->user->id);

    //update
    if (!empty($data["action"]) && $data["action"] == "update") {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $patrimonys_id = $data["patrimonys_id"];
        $movement_id = preg_replace("/[^0-9\s]/", "", $data["movement_id"]);
        $unit_id_number = preg_replace("/[^0-9\s]/", "", $data["unit_id_history_edit"]);
        $unit_id = substr($unit_id_number, 0, 2);  // 12
        $user_id = preg_replace("/[^0-9\s]/", "", $data["user_id_history_edit"]);
        $observations = $data["observations"];

        $patrimonysHistoryUpdate = (new PatrimonyHistory())->findById($patrimonys_id);
        $patrimonysUpdate = (new Patrimony())->findById($patrimonysHistoryUpdate->patrimony_id);
        $patrimony = (new Patrimony());

        if (!$patrimonysHistoryUpdate) {
            $this->message->error("Você tentou gerenciar um patrimônio que não existe")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonios")]);
            return;
        }

        $patrimony_history_count = (new PatrimonyHistory())->find("patrimony_id = :patrimony",
                                    "patrimony={$patrimonysHistoryUpdate->patrimony_id}")->count();

        if($data["movement_id"] == ""){
            $json['message'] = $this->message->warning("Informe um estado para lançar nova movimentação do patrimônio !")->icon()->render();
            echo json_encode($json);
            return;
        }

        if($data["user_id_history_edit"] == ""){
            $json['message'] = $this->message->warning("Informe um usuário para lançar nova movimentação do patrimônio !!!")->icon()->render();
            echo json_encode($json);
            return;
        }

        if($data["unit_id_history_edit"] == ""){
            $json['message'] = $this->message->warning("Informe uma unidade para lançar nova movimentação do patrimônio !!!")->icon()->render();
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
            
        if($patrimony_history_count == '1') {

            // Update do Objeto Patrimony
            if($movement_id == '7'){
                $patrimonysUpdate->status = 'disabled';
            }

            $patrimonysUpdate->movement_id = $movement_id;
            $patrimonysUpdate->user_id = $user_id;
            $patrimonysUpdate->unit_id = $unit_id;
            $patrimonysUpdate->observations = $observations;
            $patrimonysUpdate->login_updated = $user->login;

            // Update do objeto History Patrimony
            $patrimonysHistoryUpdate->patrimony_id = $patrimonysHistoryUpdate->patrimony_id;
            $patrimonysHistoryUpdate->movement_id = $movement_id;
            $patrimonysHistoryUpdate->user_id = $user_id;
            $patrimonysHistoryUpdate->unit_id = $unit_id;
            $patrimonysHistoryUpdate->observations = $observations;
            $patrimonysHistoryUpdate->login_updated = $user->login;

            //upload pdf
            if (!empty($_FILES["file_terms"])) {

                if ($patrimonysUpdate->file_terms && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysUpdate->file_terms}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysUpdate->file_terms}");
                    (new Upload())->remove($patrimonysUpdate->file_terms);
                }

                $files = $_FILES["file_terms"];
                $upload = new Upload();
                        
                    $file_terms = $upload->file($files, $patrimonysUpdate->user_id.'_'.$patrimonysUpdate->user()->user_name.'_'.$patrimonysUpdate->product()->type_part_number.'_'.$patrimonysUpdate->part_number);

                    if (!$file_terms) {
                        $json["message"] = $upload->message()->render();
                        echo json_encode($json);
                        return;
                    }

                $patrimonysUpdate->file_terms = $file_terms;
                $patrimonysHistoryUpdate->file_terms = $file_terms;
            }

            if (!$patrimonysUpdate->save()) {
                $json["message"] = $patrimonysUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            if (!$patrimonysHistoryUpdate->save()) {
                $json["message"] = $patrimonysHistoryUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Patrimônio {$patrimonysHistoryUpdate->part_number} atualizado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonio/detalhe/{$patrimonysHistoryUpdate->patrimony_id}")]);
            return;
            
        } elseif ($patrimonysUpdate->updated_at == $patrimonysHistoryUpdate->updated_at){
            
            // Update do Objeto Patrimony
            if($movement_id == '7'){
                $patrimonysUpdate->status = 'disabled';
            }

            $patrimonysUpdate->movement_id = $movement_id;
            $patrimonysUpdate->user_id = $user_id;
            $patrimonysUpdate->unit_id = $unit_id;
            $patrimonysUpdate->observations = $observations;
            $patrimonysUpdate->login_updated = $user->login;

            // Update do objeto History Patrimony
            $patrimonysHistoryUpdate->patrimony_id = $patrimonysHistoryUpdate->patrimony_id;
            $patrimonysHistoryUpdate->movement_id = $movement_id;
            $patrimonysHistoryUpdate->user_id = $user_id;
            $patrimonysHistoryUpdate->unit_id = $unit_id;
            $patrimonysHistoryUpdate->observations = $observations;
            $patrimonysHistoryUpdate->login_updated = $user->login;

            //upload pdf
            if (!empty($_FILES["file_terms"])) {

                if ($patrimonysUpdate->file_terms && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysUpdate->file_terms}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysUpdate->file_terms}");
                    (new Upload())->remove($patrimonysUpdate->file_terms);
                }

                $files = $_FILES["file_terms"];
                $upload = new Upload();
                        
                    $file_terms = $upload->file($files, $patrimonysUpdate->user_id.'_'.$patrimonysUpdate->user()->user_name.'_'.$patrimonysUpdate->product()->type_part_number.'_'.$patrimonysUpdate->part_number);

                    if (!$file_terms) {
                        $json["message"] = $upload->message()->render();
                        echo json_encode($json);
                        return;
                    }

                $patrimonysUpdate->file_terms = $file_terms;
                $patrimonysHistoryUpdate->file_terms = $file_terms;
            }

            if (!$patrimonysUpdate->save()) {
                $json["message"] = $patrimonysUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            if (!$patrimonysHistoryUpdate->save()) {
                $json["message"] = $patrimonysHistoryUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Patrimônio {$patrimonysHistoryUpdate->part_number} atualizado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonio/detalhe/{$patrimonysHistoryUpdate->patrimony_id}")]);
            return;
        }
        else {

            if($movement_id == '7'){
                $patrimonysUpdate->status = 'disabled';
            }

            // Upload do Objeto Patrimony
            $patrimonysHistoryUpdate->patrimony_id = $patrimonysUpdate->id;
            $patrimonysHistoryUpdate->movement_id = $movement_id;
            $patrimonysHistoryUpdate->user_id = $user_id;
            $patrimonysHistoryUpdate->unit_id = $unit_id;
            $patrimonysHistoryUpdate->observations = $observations;
            $patrimonysHistoryUpdate->login_updated = $user->login;

            //Upload file pdf
            if (!empty($_FILES["file_terms"])) {

                if ($patrimonysHistoryUpdate->file_terms && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysHistoryUpdate->file_terms}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonysHistoryUpdate->file_terms}");
                    (new Upload())->remove($patrimonysHistoryUpdate->file_terms);
                }

                $files = $_FILES["file_terms"];
                $upload = new Upload();
                
                $file_terms = $upload->file($files, $patrimonysHistoryUpdate->user_id.'_'.$patrimonysHistoryUpdate->user()->user_name.'_'.$patrimonysHistoryUpdate->product()->type_part_number.'_'.$patrimonysHistoryUpdate->part_number);

                if (!$file_terms) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $patrimonysHistoryUpdate->file_terms = $file_terms;
            }

            if (!$patrimonysUpdate->save()) {
                $json["message"] = $patrimonysUpdate->message()->render();
                echo json_encode($json);
                return;
            }
            
            if (!$patrimonysHistoryUpdate->save()) {
                $json["message"] = $patrimonysHistoryUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Histórico do Patrimonio {$patrimonysHistoryUpdate->product()->type_part_number} : {$patrimonysHistoryUpdate->part_number} com {$patrimonysHistoryUpdate->user()->user_name} atualizado com sucesso !!!")->icon("emoji-grin me-1")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonio/detalhe/{$patrimonysHistoryUpdate->patrimony_id}")]);
            return;
        }
        
    }

    //actived
    if (!empty($data["action"]) && $data["action"] == "actived") {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $patrimonyActived = (new PatrimonyHistory())->findById($data["patrimonys_id"]);

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
        $patrimonyDisabled = (new PatrimonyHistory())->findById($data["patrimonys_id"]);

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

    //delete
    if (!empty($data["action"]) && $data["action"] == "delete") {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $patrimonyHistoryDelete = (new PatrimonyHistory())->findById($data["patrimonys_id"]);
        $patrimonyDelete = (new Patrimony())->findById($patrimonyHistoryDelete->patrimony_id);
        $countHystory = (new PatrimonyHistory())->find("patrimony_id = :p", "p={$patrimonyHistoryDelete->patrimony_id}")->order("id DESC");

        if (!$patrimonyHistoryDelete) {
            $this->message->error("Você tentou deletar um patrimônio que não existe")->flash();
            echo json_encode(["redirect" => url("/beta/patrimonio/detalhe/{$patrimonyHistoryDelete->id}")]);
            return;
        }

        if($patrimonyDelete->updated_at == $patrimonyHistoryDelete->updated_at){
            $this->message->warning("Não é possível excluir o registro atual, crie um novo histórico antes ...")->icon()->flash();
            redirect("/beta/patrimonio/detalhe/{$patrimonyHistoryDelete->patrimony_id}");
            return;
        }

        if($countHystory->count() < 2 ){
            $this->message->warning("Erro ")->icon()->flash();
        redirect("/beta/patrimonio/detalhe/{$patrimonyHistoryDelete->patrimony_id}");
        return;
        }

        if ($patrimonyHistoryDelete->file_terms && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonyHistoryDelete->file_terms}")) {
            unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$patrimonyHistoryDelete->file_terms}");
            (new Upload())->remove($patrimonyHistoryDelete->file_terms);
        }

        $patrimonyHistoryDelete->destroy();

        $this->message->success("O {$countHystory->count()} histórico de patrimônio id: {$patrimonyHistoryDelete->id} - {$patrimonyHistoryDelete->product()->type_part_number} {$patrimonyHistoryDelete->part_number} foi excluído com sucesso...")->flash();
        redirect("/beta/patrimonio/detalhe/{$patrimonyHistoryDelete->patrimony_id}");
        return;
    }

    $PatrimonysEdit = null;
    
    if (!empty($data["patrimonys_id"])) {
        $patrimonyId = filter_var($data["patrimonys_id"], FILTER_VALIDATE_INT);
        $PatrimonysEdit = (new PatrimonyHistory())->findById($patrimonyId);
    }

    $patrimonysCreates = new PatrimonyHistory();

    $head = $this->seo->render(
        "Patrimonios - " . CONF_SITE_NAME,
        CONF_SITE_DESC,
        url(),
        theme("/assets/images/favicon.ico"),
        false
    );

    echo $this->view->render("widgets/patrimonysHistory/patrimonyHistory", [
        "head" => $head,
        "patrimonys" => $PatrimonysEdit,
        "patrimonyscreates" => $patrimonysCreates,
        "urls" => "patrimonios",
        "namepage" => "Histórico de Patrimonios",
        "name" => "Editar"
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
    $termPrint = (new PatrimonyHistory())->findById($data["patrimonys_id"]);

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
            "urls" => "patrimonio/historico/termo/{$termPrint->id}",
            "namepage" => "Termo",
            "name" => "Imprimir"
        ]);
    } else {
        echo $this->view->render("widgets/patrimonys/returnTerm", [
            "head" => $head,
            "term" => $termPrint,
            "urls" => "patrimonio/historico/termo/{$termPrint->id}",
            "namepage" => "Termo",
            "name" => "Imprimir"
        ]);
    }
}

}