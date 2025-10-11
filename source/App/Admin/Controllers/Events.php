<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Event\Models\Event;
use Source\Domain\Event\Models\EventType;
use Source\Domain\Church\Models\Church;
use Source\Domain\Event\EventService;
use Source\Support\Upload;
use Source\Support\Thumb;
use Source\Support\Modal;
use Source\App\Admin\Admin;
use DateTime;

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
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "registers" => (object)["disabled" => (new Event())->find("status IN (:s1, :s2)", "s1=canceled&s2=done")->count()
]

        ]);
    }

        /**
     * Lista os eventos desativados/cancelados
     */
    public function disabledEvents(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos Desativados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/eventos"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos/desabilitados")],
            ["title" => "Listar Desabilitados"]
        ];

        echo $this->view->render("widgets/events/disabledList", [
            "head" => $head,
            "breadcrumb" => $breadcrumb 
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

            if (!$event->save()) {
                $json["message"] = $event->message()->render();
                echo json_encode($json);
                return;
            }

            // --- CONVOCAÇÃO POR CARGOS APÓS SALVAR ---
            if (!empty($data["positions"])) {
                $eventService = new EventService();
                $eventService->convokeByPositions($event, $data["positions"]);
            }

            $this->message->success("Evento registado com sucesso!")->flash();
            $json["redirect"] = url("/painel/eventos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Registar Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/painel/eventos"), null, false);

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos/cadastrar")],
            ["title" => "Criar"]
        ];

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
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
            $event->meeting_url = $data["meeting_url"];
            $event->status = $data["status"];
            $event->updated_by = $this->user->id;

            if (!$event->save()) {
                $json["message"] = $event->message()->render();
                echo json_encode($json);
                return;
            }

            // --- CONVOCAÇÃO POR CARGOS APÓS ATUALIZAR ---
            if (!empty($data["positions"])) {
                $eventService = new EventService();
                $eventService->convokeByPositions($event, $data["positions"]);
            }

            $this->message->success("Evento atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/eventos/editar/{$event->id}");
            echo json_encode($json);
            return;
        }

         // --- LÓGICA DE STATUS DA REUNIÃO ---
        $now = new DateTime();
        $start_at = new DateTime($event->start_at);
        $end_at = !empty($event->end_at) ? new DateTime($event->end_at) : null;
        
        // A reunião está acontecendo agora?
        $isLive = ($event->status == 'in_progress');

        // O botão "Acessar" deve ser mostrado? (Somente se estiver ao vivo e dentro do horário)
        $canAccess = ($isLive && $now >= $start_at && (empty($end_at) || $now <= $end_at));

        // O botão "Iniciar" deve ser mostrado? (Agendado e até 15 min antes do início)
        $canStart = ($event->status == 'scheduled' && $now >= (clone $start_at)->modify('-15 minutes'));

       $modalFim = Modal::render(
                        'confirmFinishModal',
                        'Finalizar Reunião',
                        'Tem certeza que deseja finalizar esta reunião?',
                        url("/painel/eventos/finalizar/{$event->id}"),
                        'Sim, finalizar');
        
        // --- FIM DA LÓGICA ---

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render("Editar Evento: {$event->title}", CONF_SITE_DESC, url("/painel/eventos"), null, false);

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "event" => $event,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true),
            "isLive" => $isLive,         // Flag para o alerta "AO VIVO"
            "canAccess" => $canAccess,   // Flag para o botão "Acessar"
            "canStart" => $canStart,      // Flag para o botão "Iniciar"
            "modalFim" => $modalFim       // Modal de confirmação de finalização
        ]);
    }

     /**
     * Inicia uma reunião mudando o status para 'in_progress'.
     * @param array $data
     */
    public function start(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event && $event->status == "scheduled") {
            $event->status = "in_progress";
            $event->updated_by = $this->user->id;
            $event->save();
            $this->message->info("A reunião foi iniciada.")->flash();
        } else {
            $this->message->error("Não foi possível iniciar a reunião.")->flash();
        }
        
        redirect(url("/painel/eventos/editar/{$event->id}"));
    }

    /**
     * Finaliza uma reunião mudando o status para 'done'.
     * @param array $data
     */
    public function finish(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event && $event->status == "in_progress") {
            $event->status = "done";
            $event->updated_by = $this->user->id;
            $event->save();
            $this->message->success("A reunião foi finalizada com sucesso.")->flash();
        } else {
            $this->message->warning("Esta reunião não pôde ser finalizada.")->flash();
        }

        redirect(url("/painel/eventos/editar/{$event->id}"));
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
        redirect(url_back());
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event) {
            // Lógica para alternar entre 'scheduled' (agendado) e 'canceled' (cancelado)
            $event->status = ($event->status == "scheduled" ? "canceled" : "scheduled");
            $event->updated_by = $this->user->id;
            $event->save();
        }
        
        $actionText = ($event->status == "scheduled" ? "reagendado" : "cancelado");
        $this->message->success("O evento foi {$actionText} com sucesso!")->flash();
        redirect(url_back());
    }
}