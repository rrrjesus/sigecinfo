<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Event\Models\EventType;
use Source\App\Admin\Admin;

/**
 * Class EventTypes
 * @package Source\App\Admin
 */
class EventTypes extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista os tipos de evento ativos
     */
    public function list(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Tipos de Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/tipos-de-eventos")],
            ["title" => "Listar"]
        ];
        
        echo $this->view->render("widgets/events/types/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "eventTypes" => (new EventType())->find("status = 'actived'")->order("name ASC")->fetch(true),
            "registers" => (object)["disabled" => (new EventType())->find("status = 'disabled'")->count()]
        ]);
    }

    /**
     * Lista os tipos de evento desativados
     */
    public function disabledList(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Tipos de Evento Desativados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);

        $breadcrumb = [
            ["title" => "Tipo de Evento", "link" => url("/painel/tipos-de-eventos")],
            ["title" => "Criar"]
        ];
        
        echo $this->view->render("widgets/events/types/disabledList", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "eventTypes" => (new EventType())->find("status = 'disabled'")->order("name ASC")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = sanitize_array($data);

            $eventType = new EventType();
            $eventType->name = $data["name"];
            $eventType->description = $data["description"];
            $eventType->created_by = $this->user->id;

            if (!$eventType->save()) {
                header('Content-Type: application/json');
                $json["message"] = $eventType->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Tipo de evento registado com sucesso!")->flash();
            header('Content-Type: application/json');
            $json["redirect"] = url("/painel/tipos-de-eventos");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Tipo de Evento", "link" => url("/painel/tipos-de-eventos")],
            ["title" => "Criar"]
        ];

        $head = $this->seo->render("Registar Tipo de Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);
        echo $this->view->render("widgets/events/types/form", [ 
            "breadcrumb" => $breadcrumb,
            "head" => $head,
            "eventType" => null 
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $typeId = filter_var($data["type_id"], FILTER_VALIDATE_INT);
        $eventType = (new EventType())->findById($typeId);

        if (!$eventType) {
            $this->message->error("Você tentou editar um tipo de evento que não existe.")->flash();
            redirect("/painel/tipos-de-eventos");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = sanitize_array($data);
            
            $eventType->name = $data["name"];
            $eventType->description = $data["description"];
            $eventType->status = $data["status"];
            $eventType->updated_by = $this->user->id;

            if (!$eventType->save()) {
                header('Content-Type: application/json');
                $json["message"] = $eventType->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Tipo de evento atualizado com sucesso!")->flash();
            header('Content-Type: application/json');
            $json["redirect"] = url("/painel/tipos-de-eventos/editar/{$eventType->id}");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Tipo de Evento", "link" => url("/painel/tipos-de-eventos")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render("Editar Tipo de Evento: {$eventType->name}", CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);
        echo $this->view->render("widgets/events/types/form", [ "head" => $head, "breadcrumb" => $breadcrumb,"eventType" => $eventType ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);

        $typeId = filter_var($data["type_id"], FILTER_VALIDATE_INT);
        $eventType = (new EventType())->findById($typeId);

        if ($eventType) {
            $eventType->destroy();
        }

        $this->message->success("O tipo de evento foi excluído com sucesso.")->flash();
        redirect(url_back());
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $typeId = filter_var($data["type_id"], FILTER_VALIDATE_INT);
        $eventType = (new EventType())->findById($typeId);

        if ($eventType) {
            $eventType->status = ($eventType->status == "actived" ? "disabled" : "actived");
            $eventType->updated_by = $this->user->id;
            $eventType->save();
        }
        
        $actionText = ($eventType->status == "actived" ? "ativado" : "desativado");
        $this->message->success("O tipo de evento foi {$actionText} com sucesso!")->flash();
        redirect(url_back());
    }
}