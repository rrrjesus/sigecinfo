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
            "registers" => (object)["disabled" => (new Event())->find("status IN (:s1, :s2)", "s1=cancelado&s2=realizado")->count()]
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

            $eventService = new EventService();

            // Convocação de participantes individualmente
            if (!empty($data["user_id_to_add"])) {
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            // Convocação de cargos/grupos
            if (!empty($data["positions"])) {
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
        $eventService = new EventService();

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
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            // Convocação de cargos/grupos
            if (!empty($data["positions"])) {
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
        $isLive = ($event->status == 'ao vivo');

        // O botão "Acessar" deve ser mostrado? (Somente se estiver ao vivo e dentro do horário)
        $canAccess = ($isLive && $now >= $start_at && (empty($end_at) || $now <= $end_at));

        // O botão "Iniciar" deve ser mostrado? (Agendado e até 15 min antes do início)
        $canStart = ($event->status == 'agendado' && $now >= (clone $start_at)->modify('-15 minutes'));

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

        $head = $this->seo->render("Editar Evento: {$event->title}", CONF_SITE_DESC, url("/painel/eventos"), null, false);

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "event" => $event,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true),
            "isLive" => $isLive,
            "canAccess" => $canAccess,
            "canStart" => $canStart,
            "modalFim" => $modalFim
        ]);
    }

     /**
     * @param array $data
     */
    public function report(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);
        $eventService = new EventService();

        if (!$event) {
            $this->message->error("Você tentou aceder a um evento que não existe.")->flash();
            redirect("/painel/eventos");
        }

        $participants = $eventService->getParticipants($event->id);

        if ($participants) {
            usort($participants, function($a, $b) {
                return strcmp($a->user()->user_name, $b->user()->user_name);
            });
        }
        
        // --- GERA OS DADOS PARA O NOVO RELATÓRIO ---
        $attendanceReport = $eventService->generateAttendanceMatrix($participants);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/painel/eventos")],
            ["title" => "Relatórios e Portaria"]
        ];

        $head = $this->seo->render("Relatórios e Portaria: {$event->title}", CONF_SITE_DESC, url("/painel/eventos"), null, false);

        echo $this->view->render("widgets/events/report", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "event" => $event,
            "attendanceReport" => $attendanceReport,
            "participants" => $participants
        ]);
    }


     /**
     * Inicia uma reunião mudando o status para 'ao vivo'.
     * @param array $data
     */
    public function start(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event && $event->status == "agendado") {
            $event->status = "ao vivo";
            $event->updated_by = $this->user->id;
            $event->save();
            $this->message->info("A reunião foi iniciada.")->flash();
        } else {
            $this->message->error("Não foi possível iniciar a reunião.")->flash();
        }
        
        redirect(url("/painel/eventos/editar/{$event->id}"));
    }

    /**
     * Finaliza uma reunião mudando o status para 'realizado'.
     * @param array $data
     */
    public function finish(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event && $event->status == "ao vivo") {
            $event->status = "realizado";
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
        
        redirect("painel/eventos/portaria/{$participant->event_id}");
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

        redirect("painel/eventos/portaria/{$participant->event_id}");
    }

    /**
     * Reseta a resposta de um participante, voltando o seu status para "convocado".
     * @param array $data
     */
    public function changeResponse(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        // Reseta o status e a justificação
        $participant->status = "convocado";
        $participant->justification = null;
        $participant->save();

        $this->message->info("A sua resposta foi redefinida. Por favor, escolha a sua nova opção.")->flash();
        redirect(url_back());
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
            // Lógica para alternar entre 'agendado' (agendado) e 'cancelado' (cancelado)
            $event->status = ($event->status == "agendado" ? "cancelado" : "agendado");
            $event->updated_by = $this->user->id;
            $event->save();
        }
        
        $actionText = ($event->status == "agendado" ? "reagendado" : "cancelado");
        $this->message->success("O evento foi {$actionText} com sucesso!")->flash();
        redirect(url_back());
    }
}