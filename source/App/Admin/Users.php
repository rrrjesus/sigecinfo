<?php

namespace Source\App\Admin;

use Source\Models\Company\Church;
use Source\Models\Company\Level;
use Source\Models\Company\User;
use Source\Models\Company\UserPosition;
use Source\Support\Thumb;
use Source\Support\Upload;

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
     * Lista os usuários ativos
     */
    public function users(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render(CONF_SITE_NAME . " | Usuários", CONF_SITE_DESC, url("/painel"), null, false);
        $users = (new User())->find("status != :s", "s=disabled")->order("user_name ASC")->fetch(true);

        echo $this->view->render("widgets/company/users/list", [
            "head" => $head,
            "users" => $users,
            "registers" => (object)["disabled" => (new User())->find("status = :s", "s=disabled")->count()]
        ]);
    }

    /**
     * Lista os usuários desativados
     */
    public function disabledUsers(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render(CONF_SITE_NAME . " | Usuários Desativados", CONF_SITE_DESC, url("/painel"), null, false);
        $users = (new User())->find("status = :s", "s=disabled")->order("user_name ASC")->fetch(true);

        echo $this->view->render("widgets/company/users/disabledList", [
            "head" => $head,
            "users" => $users
        ]);
    }

    /**
     * Gerencia o perfil do próprio usuário logado
     * @param array|null $data
     */
    public function profile(?array $data): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        if (!empty($data["action"]) && $data["action"] == "profile") {
            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));
            $userProfile = (new User())->findById($this->user->id);

            $userProfile->user_name = $data["user_name"];
            $userProfile->email = $data["email"];
            $userProfile->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userProfile->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userProfile->login_updated = $this->user->id;

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar, informe e repita sua nova senha.")->render();
                    echo json_encode($json);
                    return;
                }
                $userProfile->password = $data["password"];
            } else {
                unset($userProfile->password);
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Upload();
                if ($userProfile->photo()) {
                    (new Thumb())->flush("storage/{$userProfile->photo}");
                    $upload->remove("storage/{$userProfile->photo}");
                }
                if (!$userProfile->photo = $upload->image($_FILES["photo"], "{$userProfile->user_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!$userProfile->save()) {
                $json["message"] = $userProfile->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Seu perfil foi atualizado com sucesso!")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $head = $this->seo->render(CONF_SITE_NAME . " | Perfil de {$this->user->user_name}", CONF_SITE_DESC, url("/painel"), null, false);
        echo $this->view->render("widgets/company/users/profile", [
            "head" => $head,
            "profile" => $this->user,
            "userposition" => (new UserPosition()),
            "church" => (new Church())
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));
            
            $userCreate = new User();
            $userCreate->user_name = $data["user_name"];
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userCreate->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userCreate->position_id = $data["position_id"];
            $userCreate->church_id = $data["church_id"];
            $userCreate->level_id = $data["level_id"];
            $userCreate->observations = $data["observations"];
            $userCreate->login_created = $this->user->id;

            if (!empty($_FILES["photo"])) {
                $upload = new Upload();
                $image = $upload->image($_FILES["photo"], $userCreate->user_name, 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário {$userCreate->user_name} cadastrado com sucesso!")->flash();
            $json["redirect"] = url("/painel/usuarios");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(CONF_SITE_NAME . " | Novo Usuário", CONF_SITE_DESC, url("/painel"), "", false);
        echo $this->view->render("widgets/company/users/user", [
            "head" => $head,
            "user" => null,
            "userposition" => (new UserPosition()),
            "church" => (new Church())
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $userEdit = (new User())->findById($data["user_id"]);
        if (!$userEdit) {
            $this->message->error("Você tentou editar um usuário que não existe.")->flash();
            redirect("/painel/usuarios");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));

            $userEdit->user_name = $data["user_name"];
            $userEdit->email = $data["email"];
            $userEdit->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userEdit->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userEdit->position_id = $data["position_id"];
            $userEdit->church_id = $data["church_id"];
            $userEdit->level_id = $data["level_id"];
            $userEdit->status = $data["status"];
            $userEdit->observations = $data["observations"];
            $userEdit->login_updated = $this->user->id;
            
            if (!empty($data["password"])) {
                $userEdit->password = $data["password"];
            } else {
                unset($userEdit->password);
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Upload();
                if ($userEdit->photo()) {
                    (new Thumb())->flush("storage/{$userEdit->photo}");
                    $upload->remove("storage/{$userEdit->photo}");
                }
                if (!$userEdit->photo = $upload->image($_FILES["photo"], "{$userEdit->user_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!$userEdit->save()) {
                $json["message"] = $userEdit->message()->render();
                echo json_encode($json);
                return;
            }
            
            $this->message->success("Usuário {$userEdit->user_name} atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/usuarios/editar/{$userEdit->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(CONF_SITE_NAME . " | Editar Usuário: {$userEdit->user_name}", CONF_SITE_DESC, url("/painel"), "", false);
        echo $this->view->render("widgets/company/users/user", [
            "head" => $head,
            "user" => $userEdit,
            "userposition" => (new UserPosition()),
            "church" => (new Church())
        ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);

        $userDelete = (new User())->findById($data["user_id"]);
        if (!$userDelete) {
            $this->message->error("O usuário que você tentou excluir não existe.")->flash();
            redirect("/painel/usuarios");
        }
        
        if ($userDelete->id === $this->user->id) {
            $this->message->warning("Você não pode excluir sua própria conta.")->flash();
            redirect("/painel/usuarios");
        }

        if ($userDelete->photo()) {
            (new Thumb())->flush("storage/{$userDelete->photo}");
            (new Upload())->remove("storage/{$userDelete->photo}");
        }
        $userDelete->destroy();

        $this->message->success("Usuário excluído com sucesso.")->flash();
        redirect("/painel/usuarios");
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
        $user = (new User())->findById($userId);

        if ($user) {
            $user->status = ($user->status == "actived" ? "disabled" : "actived");
            $user->login_updated = $this->user->id;
            $user->save();
        }

        redirect(url_back());
    }
}