<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Event\Models\Event;
use Source\Domain\Event\Models\EventType;
use Source\Domain\Church\Models\Church;
use Source\Domain\Event\EventService;
use Source\Domain\Event\Models\EventParticipant;
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

            // Convocação de participantes individualmente
            if (!empty($data["user_id_to_add"])) {
                $eventService = new EventService();
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            // Convocação de cargos/grupos
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

            // Convocação de participantes individualmente
            if (!empty($data["user_id_to_add"])) {
                $eventService = new EventService();
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            // Convocação de cargos/grupos
            if (!empty($data["positions"])) {
                $eventService = new EventService();
                $eventService->convokeByPositions($event, $data["positions"]);
            }

            $this->message->success("Evento atualizado com sucesso!")->flash();
            $json["redirect"] = url("/painel/eventos/editar/{$event->id}");
            echo json_encode($json);
            return;
        }

         // Lógica para verificar o status da Reunião
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
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos")],
            ["title" => "Editar"]
        ];

        // Busca os participantes para exibir na view
        $eventService = new EventService();
        $participants = $eventService->getParticipants($event->id);

        $head = $this->seo->render("Editar Evento: {$event->title}", CONF_SITE_DESC, url("/painel/eventos"), null, false);

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "event" => $event,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true),
            "participants" => $participants, // <-- PASSA OS PARTICIPANTES PARA A VIEW
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
     * Confirma um participante de um evento.
     * @param array $data
     */
    public function checkIn(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);

        $participant = (new EventParticipant())->findById($participantId);
        if ($participant && $participant->status != 'presente') {
            $participant->status = 'presente';
            // $participant->login_updated = user()->id;
            $participant->checkin_at = date("Y-m-d H:i:s");
            $participant->save();
            $this->message->success("Participante {$participant->user()->user_name} confirmado com sucesso!")->flash();
        } else {
            $this->message->error("Não foi possível encontrar a participação para confirmar.")->flash();
        }
        
        redirect("painel/eventos/editar/{$participant->event_id}?tab=guests");
    }

    /**
     * Remove um participante de um evento.
     * @param array $data
     */
    public function removeParticipant(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);

        if ($participantId) {
            $participant = (new EventParticipant())->findById($participantId);
            if ($participant) {
                $participant->destroy();
                $this->message->success("Participante {$participant->user()->user_name} removido com sucesso!")->flash();
            } else {
                $this->message->error("Não foi possível encontrar a participação para remover.")->flash();
            }
        }

        redirect("painel/eventos/editar/{$participant->event_id}?tab=guests");
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