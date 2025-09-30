<?php

namespace Source\App\Admin;

use Source\Models\EventType;

/**
 * Class EventTypes
 * @package Source\App\Admin
 */
class EventTypes extends Admin
{
    /**
     * EventTypes constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista os tipos de evento
     */
    public function list(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Tipos de Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);
        $eventTypes = (new EventType())->find()->order("name ASC")->fetch(true);
        
        echo $this->view->render("widgets/events/types/list", [
            "head" => $head,
            "eventTypes" => $eventTypes
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
                $json["message"] = $eventType->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Tipo de evento registado com sucesso!")->flash();
            $json["redirect"] = url("/painel/tipos-de-eventos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Registar Tipo de Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);
        echo $this->view->render("widgets/events/types/form", [
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
            $eventType->updated_by = $this->user->id;

            if (!$eventType->save()) {
                $json["message"] = $eventType->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Tipo de evento atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/tipos-de-eventos/editar/{$eventType->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Editar Tipo de Evento: {$eventType->name}", CONF_SITE_DESC, url("/painel/tipos-de-eventos"), null, false);
        echo $this->view->render("widgets/events/types/form", [
            "head" => $head,
            "eventType" => $eventType
        ]);
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
        echo json_encode(["reload" => true]);
        return;
    }
}