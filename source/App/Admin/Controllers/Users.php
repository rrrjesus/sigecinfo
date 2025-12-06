<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Place\Models\Place;
use Source\Domain\User\Models\Level;
use Source\Domain\User\Models\User;
use Source\Domain\User\Models\UserPosition;
use Source\Domain\Shared\Models\Module;
use Source\Domain\Shared\Models\UserModule;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\App\Admin\Admin;

/**
 * Class Users
 * @package Source\App\Admin
 */
class Users extends Admin
{
    /** @var Auth */
    private Auth $auth;

    /**
     * Users constructor.
     * @param Auth $auth
     */
    
    public function __construct(Auth $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    /**
     * Lista os usuários ativos
     */
    public function users(): void
    {
        $this->authorize('Users', 'view');

        $head = $this->seo->render(CONF_SITE_NAME . " | Usuários", CONF_SITE_DESC, url("/painel"), null, false);

        $breadcrumb = [
            ["title" => "Utilizadores", "link" => url("/painel/usuarios")],
            ["title" => "Ativos"]
        ];

        echo $this->view->render("widgets/users/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "registers" => (object)["inativo" => (new User())->find("status = :s", "s=inativo")->count()]
        ]);
    }

    /**
     * Lista os usuários desativados
     */
    public function disabledUsers(): void
    {
        $this->authorize('Users', 'view');

        $head = $this->seo->render(CONF_SITE_NAME . " | Usuários Desativados", CONF_SITE_DESC, url("/painel"), null, false);
        $users = (new User())->find("status = :s", "s=inativo")->order("user_name ASC")->fetch(true);

         $breadcrumb = [
            ["title" => "Utilizadores Desativados", "link" => url("/painel/usuarios/desativados")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/users/disabledList", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "users" => $users
        ]);
    }

    /**
     * Gerencia o perfil do próprio usuário logado
     * @param array|null $data
     */
    public function profile(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "profile") {
            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));
            $userProfile = (new User())->findById($this->user->id);

            $userProfile->user_name = mb_convert_case($data["user_name"], MB_CASE_TITLE, "UTF-8");
            $userProfile->email = $data["email"];
            $userProfile->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userProfile->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userProfile->login_updated = $this->user->id;

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] !== $data["password_re"]) {
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

        $breadcrumb = [
            ["title" => "Perfil", "link" => url("/painel/perfil")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Perfil de {$this->user->user_name}", CONF_SITE_DESC, url("/painel"), null, false);
        echo $this->view->render("widgets/users/profile", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "profile" => $this->user,
            "places" => (new \Source\Domain\Place\Models\Place())->find()->order("place_name ASC")->fetch(true),
            "positions" => (new \Source\Domain\User\Models\UserPosition())->find()->order("position_name ASC")->fetch(true),
            "levels" => (new \Source\Domain\User\Models\Level())->find()->order("id ASC")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize('Users', 'create');

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));
            
            $userCreate = new User();
            $userCreate->user_name = mb_convert_case($data["user_name"], MB_CASE_TITLE, "UTF-8");
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userCreate->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userCreate->position_id = $data["position_id"];
            $userCreate->place_id = $data["place_id"];
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

            if($data["user_name"] == "" || $data["email"] == "" || $data["position_id"] == "" || $data["place_id"] == "" || $data["level_id"] == ""){
                $json['message'] = $this->message->info("Informe o nome, e-mail, cargo, local, nivel e a senha para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            // Salva os módulos de acesso do usuário
            if (!empty($data["modules"])) {
                $userModuleModel = new UserModule();
                foreach ($data["modules"] as $moduleId) {
                    // Usa o método 'add' do modelo UserModule para inserir o módulo
                    $userModuleModel->add($userCreate->id, $moduleId);
                }
            }

            $this->message->success("Usuário {$userCreate->user_name} cadastrado com sucesso!")->flash();
            $json["redirect"] = url("/painel/usuarios");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Utilizadores", "link" => url("/painel/usuarios")],
            ["title" => "Criar"]
        ];

        $head = $this->seo->render(CONF_SITE_NAME . " | Novo Usuário", CONF_SITE_DESC, url("/painel"), "", false);

        echo $this->view->render("widgets/users/user", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => null,
            "places" => (new Place())->find()->order("place_name ASC")->fetch(true),
            "positions" => (new UserPosition())->find()->order("position_name ASC")->fetch(true),
            "levels" => (new Level())->find()->order("id ASC")->fetch(true),
            "all_modules" => (new Module())->find()->order("name ASC")->fetch(true),
            "user_modules" => []
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize('Users', 'edit');

        $userEdit = (new User())->findById($data["user_id"]);

        if (!$userEdit) {
            $this->message->error("Você tentou editar um usuário que não existe.")->flash();
            redirect("/painel/usuarios");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            // Extrai os módulos antes de limpar os outros dados
            $modules = $data['modules'] ?? [];
            unset($data['modules']);

            $data = array_map('trim', filter_var_array($data, FILTER_SANITIZE_STRIPPED));

            $userEdit->user_name = mb_convert_case($data["user_name"], MB_CASE_TITLE, "UTF-8");
            $userEdit->email = $data["email"];
            $userEdit->phone_mobile = preg_replace("/[^0-9]/", "", $data["phone_mobile"]);
            $userEdit->phone_landline = preg_replace("/[^0-9]/", "", $data["phone_landline"]);
            $userEdit->position_id = $data["position_id"];
            $userEdit->place_id = $data["place_id"];
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

            if($data["user_name"] == "" || $data["email"] == "" || $data["position_id"] == "" || $data["place_id"] == "" || $data["level_id"] == ""){
                $json['message'] = $this->message->info("Informe o nome, e-mail, cargo, local e o nivel para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if ($userEdit->id === $this->user->id) {
                $json['message'] = $this->message->warning("Para editar seu próprio usuário, acesse o perfil.")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$userEdit->save()) {
                $json["message"] = $userEdit->message()->render();
                echo json_encode($json);
                return;
            }

            // Limpa e salva os novos módulos de acesso
            $userModuleModel = new UserModule();
            $userModuleModel->deleteByUser($userEdit->id);
            if (!empty($modules)) {
                foreach ($modules as $moduleId) {
                    // Usa o método 'add' do modelo UserModule para inserir o módulo
                    $userModuleModel->add($userEdit->id, $moduleId);
                }
            }
            
            $this->message->success("Usuário {$userEdit->user_name} atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/usuarios/editar/{$userEdit->id}");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Usuários", "link" => url("/painel/usuarios/editar/{$userEdit->id}")],
            ["title" => "Editar"]
        ];

        // Busca os módulos do usuário
        $userModules = (new UserModule())->find("user_id = :uid", "uid={$userEdit->id}")->fetch(true);
        $userModuleIds = [];
        if ($userModules) {
            foreach ($userModules as $mod) {
                $userModuleIds[] = $mod->module_id;
            }
        }

        $head = $this->seo->render(CONF_SITE_NAME . " | Editar Usuário: {$userEdit->user_name}", CONF_SITE_DESC, url("/painel"), "", false);
        echo $this->view->render("widgets/users/user", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => $userEdit,
            "places" => (new Place())->find()->order("place_name ASC")->fetch(true),
            "positions" => (new UserPosition())->find()->order("position_name ASC")->fetch(true),
            "levels" => (new Level())->find()->order("id ASC")->fetch(true),
            "all_modules" => (new Module())->find()->order("name ASC")->fetch(true),
            "user_modules" => $userModuleIds
        ]);
    }

    // ... (dentro da classe Users)

    /**
     * Retorna uma lista de utilizadores em formato JSON para autocomplete.
     * @param array $data
     */
public function searchJson(array $data): void
{

    header('Content-Type: application/json; charset=utf-8');

    if (empty($data)) {
        $data = $_GET;
    }

    $searchTerm = filter_var($data['term'] ?? '', FILTER_SANITIZE_STRING);

    file_put_contents('debug.log', "Term: {$searchTerm}\n", FILE_APPEND);

    if (empty($searchTerm)) {
        echo json_encode([]);
        return;
    }

    $users = (new User())
        ->find("user_name LIKE :term", "term=%{$searchTerm}%")
        ->limit(10)
        ->fetch(true);

    $results = [];
    if ($users) {
        foreach ($users as $user) {
            $results[] = [
                "id" => $user->id,
                "label" => $user->user_name . " (" . $user->email . ")"
            ];
        }
    }

    echo json_encode($results);
}


/**
     * Retorna uma lista de utilizadores em formato JSON para o Typeahead.
     * @param array $data
     */
    public function searchJsonForTypeahead(array $data): void
    {
        // O Typeahead envia o termo de busca no parâmetro 'query'
        $searchTerm = filter_var($data['query'], FILTER_SANITIZE_STRING);

        $users = (new \Source\Domain\User\Models\User())
            ->find("status != 'disabled' AND user_name LIKE :term", "term=%{$searchTerm}%")
            ->limit(10)
            ->fetch(true);

        $results = [];
        if ($users) {
            foreach ($users as $user) {
                // O Typeahead espera um objeto com uma propriedade que será usada para a busca
                $results[] = [
                    "id" => $user->id,
                    "name" => $user->user_name
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($results);
        return;
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize('Users', 'delete');

        $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
        $userDelete = (new User())->findById($userId);

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

        $this->message->success("Usuário {$userDelete->user_name} excluído com sucesso.")->flash();
        redirect(url_back());
        
    }

  /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize('Users', 'edit'); // Ação de ativar/desativar é uma forma de edição

        $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
        $user = (new User())->findById($userId);

        if (!$user) {
            $this->message->error("O usuário que você tentou manipular não existe.")->flash();
            redirect(url_back());
            return;
        }

        if ($user->id === $this->user->id) {
            $this->message->warning("Você não pode desativar sua própria conta.")->flash();
            redirect(url_back());
            return;
        }

        // Lógica de status mais robusta
        $currentStatus = $user->status;
        $newStatus = (in_array($currentStatus, ["ativo"]) ? "inativo" : "ativo");
        $user->status = $newStatus;
        $user->login_updated = $this->user->id;

        // Verifica se o save() foi bem-sucedido antes de dar a mensagem
        if ($user->save()) {
            $actionText = ($newStatus == "inativo" ? "inativo" : "ativado");
            $this->message->success("O usuário {$user->user_name} foi {$actionText} com sucesso!")->flash();
        } else {
            // Se o save() falhar, exibe a mensagem de erro específica da Model
            $this->message->error($user->message()->getText())->flash();
        }

        redirect(url_back());
    }
    
}