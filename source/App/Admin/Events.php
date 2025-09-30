<?php

namespace Source\App\Admin;

use Source\Models\Event;
use Source\Models\EventType;
use Source\Models\Company\Church;
use Source\Support\Upload;
use Source\Support\Thumb;

/**
 * Class Events
 * @package Source\App\Admin
 */
class Events extends Admin
{
    /**
     * Events constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista os eventos
     */
    public function list(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/eventos"), null, false);
        $events = (new Event())->find()->order("start_at DESC")->fetch(true);
        
        echo $this->view->render("widgets/events/list", [
            "head" => $head,
            "events" => $events
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

            $event = new Event();
            $event->title = $data["title"];
            $event->description = $data["description"];
            $event->start_at = $data["start_at"];
            $event->end_at = !empty($data["end_at"]) ? $data["end_at"] : null;
            $event->church_id = !empty($data["church_id"]) ? $data["church_id"] : null;
            $event->type_id = $data["type_id"];
            $event->location_text = $data["location_text"];
            $event->created_by = $this->user->id;

            if (!empty($_FILES["cover"])) {
                $upload = new Upload();
                $image = $upload->image($_FILES["cover"], str_slug($event->title), 800);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $event->cover = $image;
            }

            if (!$event->save()) {
                $json["message"] = $event->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Evento registado com sucesso!")->flash();
            $json["redirect"] = url("/painel/eventos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Registar Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/eventos"), null, false);
        echo $this->view->render("widgets/events/form", [
            "head" => $head,
            "event" => null,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true)
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if (!$event) {
            $this->message->error("Você tentou editar um evento que não existe.")->flash();
            redirect("/painel/eventos");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = sanitize_array($data);
            
            $event->title = $data["title"];
            $event->description = $data["description"];
            $event->start_at = $data["start_at"];
            $event->end_at = !empty($data["end_at"]) ? $data["end_at"] : null;
            $event->church_id = !empty($data["church_id"]) ? $data["church_id"] : null;
            $event->type_id = $data["type_id"];
            $event->location_text = $data["location_text"];
            $event->status = $data["status"];
            $event->updated_by = $this->user->id;

            if (!empty($_FILES["cover"])) {
                $upload = new Upload();
                if ($event->cover && file_exists(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}")) {
                    (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$event->cover}");
                    unlink(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}");
                }
                $image = $upload->image($_FILES["cover"], str_slug($event->title), 800);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $event->cover = $image;
            }

            if (!$event->save()) {
                $json["message"] = $event->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Evento atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/eventos/editar/{$event->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Editar Evento: {$event->title}", CONF_SITE_DESC, url("/painel/eventos"), null, false);
        echo $this->view->render("widgets/events/form", [
            "head" => $head,
            "event" => $event,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true)
        ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);

        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event) {
            if ($event->cover && file_exists(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}")) {
                unlink(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}");
                (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$event->cover}");
            }
            $event->destroy();
        }

        $this->message->success("O evento foi excluído com sucesso.")->flash();
        echo json_encode(["reload" => true]);
        return;
    }
}