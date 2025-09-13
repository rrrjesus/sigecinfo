<?php

namespace Source\App\Admin;

use Source\Models\Company\User;
use Source\Models\Company\UserPosition;
use Source\Models\Company\UserCategory;
use Source\Models\Company\Unit;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Models\Patrimony\Patrimony;
use Source\Models\Patrimony\PatrimonyHistory;

/**
 * Class Users
 * @package Source\App\Admin
 */
class Users extends Admin
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function users(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " Usuarios",
            "Lista de usuarios ativos",
            url("/usuarios"),
            theme("/assets/images/favicon.ico")
        );

        $user = (new User());
        $users = $user->find("status != :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/company/users/list",
            [
                "app" => "usuarios",
                "head" => $head,
                "users" => $users,
                "urls" => "usuarios",
                "namepage" => "Usuarios",
                "name" => "Listar",
                "registers" => (object)[
                    "actived" => $user->find("status != :s", "s=disabled")->count(),
                    "disabled" => $user->find("status = :s", "s=disabled")->count()
                ]
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    /** @return void */
    public function disabledUsers(): void
    {
        $head = $this->seo->render(
            "Usuarios Registrados - " . CONF_SITE_NAME ,
            "Painel para gerenciamento de usuarios registrados",
            url("/painel/usuarios/registrados"),
            theme("/assets/images/favicon.ico")
        );

        $user = (new User());
        $users = $user->find("status = :s", "s=disabled")->fetch(true);

        echo $this->view->render("widgets/company/users/disabledList",
            [
                "app" => "usuarios",
                "head" => $head,
                "users" => $users,
                "urls" => "usuarios",
                "namepage" => "Usuarios",
                "name" => "Desativados",
            ]);

    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {
        //update profile
        if (!empty($data["action"]) && $data["action"] == "profile") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userProfile = (new User())->findById($this->user->id);

            if (!$userProfile) {
                $this->message->error("Erro ao gerenciar seu perfil")->icon("person")->flash();
                echo json_encode(["redirect" => url("/painel/perfil")]);
                return;
            }

            $userProfile->login = $data["login"];
            $userProfile->rf = $data["rf"];
            $userProfile->user_name = $data["user_name"];
            $userProfile->email = $data["email"];
            $userProfile->cell_phone = preg_replace("/[^0-9]/", "", $data["cell_phone"]);
            $userProfile->fixed_phone = preg_replace("/[^0-9]/", "", $data["fixed_phone"]);
            $userProfile->position_id = preg_replace("/[^0-9\s]/", "", $data["position_id"]);
            $userProfile->category_id = preg_replace("/[^0-9\s]/", "", $data["category_id"]);
            $userProfile->unit_id = preg_replace("/[^0-9\s]/", "", $data["unit_id"]);
            $userProfile->password = (!empty($data["password"]) ? $data["password"] : $userProfile->password);
            $userProfile->level_id = $data["level_id"];
            $userProfile->status = (new User())->statusInputDecode($data["status"]);
            $userProfile->observations = $data["observations"];
            $userProfile->login_updated = $this->user->login;

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($userProfile->photo()) {
                    (new Thumb())->flush("storage/{$userProfile->photo}");
                    $upload->remove("storage/{$userProfile->photo}");
                }

                if (!$userProfile->photo = $upload->image($file, "{$userProfile->user_name}" . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$userProfile->user->user_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if($data["login"] == "" || $data["rf"] == "" || $data["category_id"] == "" || $data["unit_id"] == "" || $data["position_id"] == "" || $data["status"] == ""){
                $json['message'] = $this->message->warning("Preencha os campos obrigatórios para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userProfile->save()) {
                $json["message"] = $userProfile->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Seu perfil foi atualizado com sucesso !!!")->icon("person")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $profileEdit = null;
        $userposition = new UserPosition();
        $unit = new Unit();

        if (!empty($this->user->id)) {
            $profileId = filter_var($this->user->id, FILTER_VALIDATE_INT);
            $profileEdit = (new User())->findById($profileId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . "Perfil de {$profileEdit->user_name}",
            CONF_SITE_DESC,
            url("/painel/perfil"),
            url("/painel/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/company/users/profile", [
            "app" => "perfil",
            "head" => $head,
            "profile" => $profileEdit,
            "userposition" => $userposition,
            "unit" => $unit,
            "urls" => "perfil",
            "namepage" => "Perfil",
            "name" => "{$profileEdit->user_name}",
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
            theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN))
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function user(?array $data): void
    {
        $user = (new User())->findById($this->user->id);
        
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $userCreate = new User();
            $userCreate->login = $data["login"];
            $userCreate->rf = $data["rf"];
            $userCreate->user_name = $data["user_name"];
            $userCreate->email = $data["email"];
            $userCreate->cell_phone = preg_replace("/[^0-9]/", "", $data["cell_phone"]);
            $userCreate->fixed_phone = preg_replace("/[^0-9]/", "", $data["fixed_phone"]);
            $userCreate->position_id = preg_replace("/[^0-9\s]/", "", $data["position_id"]);
            $userCreate->category_id = preg_replace("/[^0-9\s]/", "", $data["category_id"]);
            $userCreate->unit_id = preg_replace("/[^0-9\s]/", "", $data["unit_id"]);
            $userCreate->password = $data["password"];
            $userCreate->level_id = $data["level_id"];
            $userCreate->observations = $data["observations"];
            $userCreate->created_at = date("Y-m-d h:m:s");
            $userCreate->login_created = $user->login;

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->user_name, 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if($data["login"] == "" || $data["rf"] == "" || $data["category_id"] == "" || $data["unit_id"] == "" || $data["position_id"] == ""){
                $json['message'] = $this->message->warning("Preencha os campos obrigatórios para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário {$userCreate->user_name} cadastrado com sucesso...")->icon("person")->flash();
            $json["redirect"] = url("/painel/usuarios/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->findById($data["user_id"]);

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->icon("person")->flash();
                echo json_encode(["redirect" => url("/painel/usuarios")]);
                return;
            }

            $userUpdate->login = $data["login"];
            $userUpdate->rf = $data["rf"];
            $userUpdate->user_name = $data["user_name"];
            $userUpdate->email = $data["email"];
            $userUpdate->cell_phone = preg_replace("/[^0-9]/", "", $data["cell_phone"]);
            $userUpdate->fixed_phone = preg_replace("/[^0-9]/", "", $data["fixed_phone"]);
            $userUpdate->position_id = preg_replace("/[^0-9\s]/", "", $data["position_id"]);
            $userUpdate->category_id = preg_replace("/[^0-9\s]/", "", $data["category_id"]);
            $userUpdate->unit_id = preg_replace("/[^0-9\s]/", "", $data["unit_id"]);
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->level_id = $data["level_id"];
            $userUpdate->status = (new User())->statusInputDecode($data["status"]);
            $userUpdate->observations = $data["observations"];
            $userUpdate->login_updated = $user->login;

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($userUpdate->photo()) {
                    (new Thumb())->flush("storage/{$userUpdate->photo}");
                    $upload->remove("storage/{$userUpdate->photo}");
                }

                if (!$userUpdate->photo = $upload->image($file, "{$userUpdate->user_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$userUpdate->user_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if($data["user_name"] == "" ||  $data["login"] == "" || $data["rf"] == "" || $data["category_id"] == "" || $data["unit_id"] == "" || $data["position_id"] == "" || $data["status"] == ""){
                $json['message'] = $this->message->warning("Preencha os campos obrigatórios para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário {$userUpdate->login} - {$userUpdate->user_name} atualizado com sucesso !!!")->icon("person")->flash();
            echo json_encode(["redirect" => url("/painel/usuarios")]);
            return;
        }

         //actived
         if (!empty($data["action"]) && $data["action"] == "actived") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userActived = (new User())->findById($data["user_id"]);

            if (!$userActived) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->icon("person")->flash();
                echo json_encode(["redirect" => url("/painel/usuarios")]);
                return;
            }

            $userActived->status = "registered";
            $userActived->login_updated = $user->login;

            if (!$userActived->save()) {
                $json["message"] = $userActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário {$userActived->login} - {$userActived->user_name} reativado com sucesso !!!")->icon("person")->flash();
            redirect("/painel/usuarios");
            return;
        }

        
         //disabled
         if (!empty($data["action"]) && $data["action"] == "disabled") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userActived = (new User())->findById($data["user_id"]);

            if (!$userActived) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->icon("person")->flash();
                echo json_encode(["redirect" => url("/painel/usuarios")]);
                return;
            }

            if($userActived->id == user()->id) {
                $this->message->error("Você não pode desativar seu próprio usuário ...")->icon("person")->flash();
                redirect("/painel/usuarios");
            }

            $userActived->status = "disabled";
            $userActived->login_updated = $user->login;

            if (!$userActived->save()) {
                $json["message"] = $userActived->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário {$userActived->login} - {$userActived->user_name} desativado com sucesso !!!")->icon("person")->flash();
            redirect("/painel/usuarios");
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userDelete = (new User())->findById($data["user_id"]);

            if (!$userDelete) {
                $this->message->error("Você tentou deletar um usuário que não existe")->icon()->icon("person")->flash();
                redirect("/painel/usuarios");
                return;
            }

            if($userDelete->id == user()->id) {
                $this->message->error("Operação invalida ...")->icon("person")->flash();
                redirect("/painel/usuarios");
            }

            if ($userDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}");
                (new Thumb())->flush($userDelete->photo);
            }

            $userDelete->destroy();

            $this->message->success("O usuário com RF {$userDelete->rf} - {$userDelete->user_name} foi excluído com sucesso...")->icon("person")->flash();
            redirect("/painel/usuarios");

            return;
        }

        $userposition = new UserPosition();
        $usercategory = new UserCategory();
        $unit = new Unit();

        $userEdit = null;
        $userPatrimony = null;
        $userHistory = null;

        if (!empty($data["user_id"])) {
            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById($userId);
            $userPatrimony = (new Patrimony())->find("user_id = :u", "u={$userId}")->fetch(true);
            $userHistory = (new PatrimonyHistory())->find("user_id = :u", "u={$userId}")->fetch(true);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($userEdit ? "Perfil de {$userEdit->user_name}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/painel"),
            url("/painel/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/company/users/user", [
            "app" => "usuarios",
            "head" => $head,
            "user" => $userEdit,
            "userpatrimony" => $userPatrimony,
            "userhistory" => $userHistory,
            "userposition" => $userposition,
            "usercategory" => $usercategory,
            "unit" => $unit,
            "urls" => ($userEdit ? "usuarios" : "usuarios"),
            "namepage" => "Usuários",
            "name" => ($userEdit ? "Editar" : "Cadastrar")
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
            echo $this->view->render("widgets/company/users/withdrawalTerm", [
                "head" => $head,
                "term" => $termPrint,
                "urls" => "patrimonio/termo/{$termPrint->id}",
                "namepage" => "Termo",
                "name" => "Imprimir"
            ]);
        } else {
            echo $this->view->render("widgets/company/users/returnTerm", [
                "head" => $head,
                "term" => $termPrint,
                "urls" => "patrimonio/termo/{$termPrint->id}",
                "namepage" => "Termo",
                "name" => "Imprimir"
            ]);
        }
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    public function termHistory(?array $data): void
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

        echo $this->view->render("widgets/company/users/term", [
            "head" => $head,
            "term" => $termPrint,
            "urls" => "patrimonio/historico/termo/{$termPrint->id}",
            "namepage" => "Termo",
            "name" => "Imprimir"
        ]);
    }
}