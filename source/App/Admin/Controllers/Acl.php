<?php

namespace Source\App\Admin\Controllers;

use Source\App\Admin\Admin;
use Source\Domain\User\Models\Level;
use Source\Domain\Shared\Models\Permission;
use Source\Domain\Shared\Models\LevelPermission;
use Source\Domain\Shared\Models\Module;

class Acl extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exibe a matriz de permissões de Níveis vs. Permissões.
     */
    public function index(): void
    {
        // Aqui usaremos a função Auth::check() que criamos
        if (!\Source\Domain\Shared\Models\Auth::check("acl_view")) {
            $this->message->error("Você não tem permissão para gerenciar o controle de acesso.")->flash();
            redirect("/painel");
            return;
        }

        $levels = (new Level())->find()->order("level_name ASC")->fetch(true);
        $modules = (new Module())->find()->order("name ASC")->fetch(true);
        $permissions = (new Permission())->find()->order("name ASC")->fetch(true);

        // Para facilitar a checagem na view, vamos criar um array simples
        $levelPermissions = (new LevelPermission())->find()->fetch(true);
        $currentPermissions = [];
        if ($levelPermissions) {
            foreach ($levelPermissions as $lp) {
                $currentPermissions[$lp->level_id][$lp->permission_id] = true;
            }
        }

        $head = $this->seo->render(CONF_SITE_NAME . " | Controle de Acesso", CONF_SITE_DESC, url("/painel"), null, false);

        $breadcrumb = [
            ["title" => "ACL", "link" => url("/painel/acl")],
            ["title" => "Editar"]
        ];
        

        echo $this->view->render("widgets/acl/matrix", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "levels" => $levels,
            "modules" => $modules,
            "permissions" => $permissions,
            "current_permissions" => $currentPermissions
        ]);
    }

    /**
     * Salva as permissões da matriz.
     * @param array $data
     */
    public function save(array $data): void
    {
        if (!\Source\Domain\Shared\Models\Auth::check("acl_edit")) {
            $json["message"] = $this->message->error("Você não tem permissão para editar o controle de acesso.")->render();
            echo json_encode($json);
            return;
        }

        $levelPermissionModel = new LevelPermission();

        // Limpa todas as permissões existentes
        $levelPermissionModel->deleteAll();

        // Insere as novas permissões enviadas pelo formulário
        if (!empty($data["permissions"])) {
            foreach ($data["permissions"] as $levelId => $permissionIds) {
                foreach ($permissionIds as $permissionId => $on) {
                    // Usa o método 'add' do modelo LevelPermission para inserir a permissão
                    $levelPermissionModel->add($levelId, $permissionId);
                }
            }
        }

        $this->message->success("Permissões atualizadas com sucesso!")->flash();
        $json["reload"] = true;
        echo json_encode($json);
    }
}
