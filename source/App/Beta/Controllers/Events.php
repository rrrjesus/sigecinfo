<?php
namespace Source\App\Beta\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Event\Models\Event;
use Source\Domain\Event\EventRepository;
use Source\Domain\Event\Models\EventParticipant;
use Source\App\Beta\Admin;

class Events extends Admin
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     * Formulário para criar um novo evento.
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        // POST
        if (!empty($data) && !empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $this->message->error("Erro ao enviar, favor use o formulário")->flash();
                redirect("/beta/eventos/novo");
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $event = new Event();
            $event->title = $data["title"];
            $event->description = $data["description"];
            $event->start_at = str_replace("T", " ", $data["start_at"]);
            $event->end_at = str_replace("T", " ", $data["end_at"]);
            $event->created_by = $this->user->id;
            $event->status = "agendado";

            if (!$event->save()) {
                $json["message"] = $event->message()->render();
                echo json_encode($json);
                return;
            }

            // TODO: Google Calendar Integration
            // 1. Check for Google Auth Token for this user
            // 2. If no token, redirect to Google Auth flow, saving event id in session
            // 3. If token, create Google Calendar event and save the google_calendar_event_id

            $this->message->success("Evento criado com sucesso!")->flash();
                $json["redirect"] = url("/beta/eventos/eventos");
                echo json_encode($json);
            return;
        }

        // GET
        $head = $this->seo->render("Novo Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/eventos/novo"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/beta/eventos/eventos")],
            ["title" => "Novo Evento"]
        ];

        echo $this->view->render("widgets/events/create", [
            "head" => $head,
            "breadcrumb" => $breadcrumb
        ]);
    }

    /**
     * Lista os eventos
     */
    public function listEvents(): void
    {

        $head = $this->seo->render("Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/eventos"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/beta/eventos")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/list-events", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "registers" => (object)["disabled" => (new Event())->find("status IN (:s1, :s2)", "s1=cancelado&s2=realizado")->count()]
        ]);
    }

    /**
     * Lista os eventos
     */
    public function listEventsDisableds(): void
    {

        $head = $this->seo->render("Eventos Finalizados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/eventos/finalizados"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos Finalizados", "link" => url("/beta/eventos/finalizados")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/disabled-list-events", [
            "head" => $head,
            "breadcrumb" => $breadcrumb
        ]);
    }

    /**
     * Lista os eventos para os quais o utilizador foi convocado.
     */
    public function listMyEvents(): void
    {
        $head = $this->seo->render("Eventos Agendados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/meus-eventos"), null, false);
        
        $eventRepo = new EventRepository();
        $myEvents = $eventRepo->getEventsForUser($this->user->id);

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/beta/eventos/eventos")],
            ["title" => "Eventos Agendados"]
        ];

        echo $this->view->render("widgets/events/my-events", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "events" => $myEvents,
            "user" => $this->user
        ]);
    }

    
    /**
     * Lista os eventos para os quais o utilizador foi convocado.
     */
    public function disabledEvents(): void
    {
        $head = $this->seo->render("Eventos Finalizados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/eventos-finalizados"), null, false);
        
        $eventRepo = new EventRepository();
        $myEvents = $eventRepo->getEventsForUser($this->user->id);

        echo $this->view->render("widgets/events/disabled", [
            "head" => $head,
            "events" => $myEvents,
            "user" => $this->user
        ]);
    }

    /**
     * Confirma a presença de um utilizador num evento.
     * @param array $data
     */
    public function confirm(array $data): void
    {
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new EventParticipant())->findById($participantId);

        // Verificação de segurança: o utilizador só pode confirmar a sua própria participação.
        if (!$participant || $participant->user_id != $this->user->id) {
            $this->message->error("Ocorreu um erro ao processar a sua confirmação.")->flash();
            redirect(url_back());
            return;
        }

        $participant->status = "confirmado";
        $participant->save();

        $this->message->success("Presença confirmada com sucesso!")->flash();
        redirect(url_back());
    }

    /**
     * Reseta a resposta de um participante, voltando o seu status para "convocado".
     * @param array $data
     */
    public function changeResponse(array $data): void
    {
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        // Verificação de segurança: o utilizador só pode alterar a sua própria participação.
        if (!$participant || $participant->user_id != $this->user->id) {
            $this->message->error("Ocorreu um erro ao processar a sua alteração.")->flash();
            redirect(url_back());
            return;
        }

        // Reseta o status e a justificação
        $participant->status = "convocado";
        $participant->justification = null;
        $participant->save();

        $this->message->info("A sua resposta foi redefinida. Por favor, escolha a sua nova opção.")->flash();
        redirect(url_back());
    }

    /**
     * Regista a justificação de falta de um utilizador.
     * @param array $data
     */
   // file: Events.php (coloque dentro da sua classe Events)
    public function justify(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');

        // Validações básicas
        $participantId = filter_var($data["participant_id"] ?? null, FILTER_VALIDATE_INT);
        $justification = isset($data["justification"]) ? trim($data["justification"]) : null;

        if (!$participantId) {
            $this->message->error("Participante inválido.")->flash();
            http_response_code(400);
            echo json_encode([
                "status" => "error"
            ]);
            return;
        }

        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        // Verificação de segurança: o utilizador só pode justificar a sua própria participação.
        if (!$participant || $participant->user_id != $this->user->id) {
            $this->message->error("Você não tem permissão para justificar esta participação.")->flash();
            http_response_code(403);
            echo json_encode([
                "status" => "error"
            ]);
            return;
        }

        if (empty($justification)) {
            $this->message->warning("Por favor, escreva o motivo da sua ausência.")->flash();
            http_response_code(422);
            echo json_encode([
                "status" => "warning"
            ]);
            return;
        }

        // Salvar justificativa
        $participant->status = "recusado";
        $participant->justification = htmlspecialchars($justification, ENT_QUOTES, 'UTF-8');

        if ($participant->save()) {
            $this->message->success("Justificativa de falta enviada com sucesso.")->flash();
            echo json_encode([
                "status" => "success",
                "close_modal" => true,
                "reload" => true
            ]);
        } else {
            http_response_code(500);
            $this->message->error("Ocorreu um erro ao salvar. Tente novamente.")->flash();
            echo json_encode([
                "status" => "error"
            ]);
        }
    }

    /**
     * Busca todos os eventos para os quais um utilizador específico foi convocado.
     * @param int $userId
     * @return array|null
     */
    public function getEventsForUser(int $userId): ?array
    {
        $events = (new \Source\Domain\Event\Models\Event())->find(
            "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }

    /**
     * Lista o histórico de eventos realizados que o utilizador participou.
     */
    public function completedEvents(): void
    {
        $head = $this->seo->render("Meu Histórico de Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/beta/eventos/meus-eventos-finalizados"), null, false);
        
        $eventRepo = new EventRepository();
        $completedEvents = $eventRepo->getCompletedEventsForUser($this->user->id);

        echo $this->view->render("widgets/events/my-completed-events", [
            "head" => $head,
            "events" => $completedEvents,
            "user" => $this->user
        ]);
    }
}