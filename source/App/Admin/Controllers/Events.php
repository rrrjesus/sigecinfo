<?php

namespace Source\App\Admin\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
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

            if (!empty($data["add_to_google_calendar"])) {
                $this->createGoogleCalendarEvent(array_merge($data, ["event_id" => $event->id]));
                return;
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
     * @param array $data
     * @return void
     */
    public function showCheckInPage(array $data): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        if (!$participant) {
            $this->message->error("Participante não encontrado.")->flash();
            redirect("/painel/eventos");
        }

        $head = $this->seo->render("Check-in: " . $participant->user()->user_name, CONF_SITE_DESC, url("/painel"), null, false);

        echo $this->view->render("widgets/events/checkin", [
            "head" => $head,
            "participant" => $participant
        ]);
    }

    /**
     * @param array $data
     * @return void
     */
    public function processCheckInFromPage(array $data): void
    {
        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        $signatureBase64 = $data['signature'] ?? null;

        if (!$participantId || !$signatureBase64) {
            $this->message->error("Por favor, forneça a assinatura para continuar.")->flash();
            redirect(url_back());
            return;
        }

        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);
        if (!$participant) {
            $this->message->error("Participante não encontrado.")->flash();
            redirect("/painel/eventos");
            return;
        }

        try {
            // Decode base64 and create a temporary file
            $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureBase64));
            if ($signatureData === false) {
                throw new \Exception("Falha ao decodificar a assinatura.");
            }

            $tempFile = tmpfile();
            fwrite($tempFile, $signatureData);
            $tempFilePath = stream_get_meta_data($tempFile)['uri'];

            // Use Upload and Thumb classes
            $upload = new \Source\Support\Upload();
            $thumb = new \Source\Support\Thumb();

            // Remove old signature if it exists
            if ($participant->signature) {
                $thumb->flush(CONF_UPLOAD_DIR . "/{$participant->signature}");
                $upload->remove(CONF_UPLOAD_DIR . "/{$participant->signature}");
            }

            // Upload the new signature
            $signatureName = "sig-{$participant->id}-" . time();
            $newSignature = $upload->image($tempFilePath, $signatureName, 600, 'signatures', true);

            // Close and delete the temporary file
            fclose($tempFile);

            if (!$newSignature) {
                throw new \Exception($upload->message()->getText());
            }

            // Update participant record
            $participant->status = "presente";
            $participant->checkin_at = (new DateTime())->format("Y-m-d H:i:s");
            $participant->signature = $newSignature;
            $participant->save();

            if ($participant->fail()) {
                throw new \Exception($participant->fail()->getMessage());
            }

            $this->message->success("Check-in de " . $participant->user()->user_name . " realizado com sucesso!")->flash();
            redirect("/painel/eventos/portaria/{$participant->event_id}");

        } catch (\Exception $e) {
            $this->message->error("Erro ao processar assinatura: " . $e->getMessage())->flash();
            redirect(url_back());
        }
    }

  /**
 * Confirma um participante de um evento com assinatura digital.
 * @param array $data
 */
public function checkIn(array $data): void
{
    $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
    $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
    $participant = (new EventParticipant())->findById($participantId);

    if ($participant && $participant->status != 'presente') {
        $participant->status = 'presente';
        $participant->checkin_at = date("Y-m-d H:i:s");

        // 🔹 Verifica se veio assinatura via base64
        if (!empty($data["signature_base64"])) {
            try {
                $signatureBase64 = $data["signature_base64"];
                $signatureBase64 = str_replace('data:image/png;base64,', '', $signatureBase64);
                $signatureBase64 = str_replace(' ', '+', $signatureBase64);
                $decoded = base64_decode($signatureBase64);

                if ($decoded === false) {
                    throw new \Exception("Não foi possível decodificar a assinatura enviada.");
                }

                // Cria imagem temporária
                $tmpFile = __DIR__ . "/../../shared/tmp_signature_" . uniqid() . ".png";
                file_put_contents($tmpFile, $decoded);

                $upload = new Upload();

                // Remove assinatura anterior se existir
                if ($participant->signature) {
                    (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$participant->signature}");
                    $upload->remove(CONF_UPLOAD_DIR . "/{$participant->signature}");
                }

                // Faz upload usando a classe padrão
                $signatureName = "signature-" . $participant->user_name . "-" . time();
                $newSignature = $upload->image($tmpFile, $signatureName, 360, "signatures", true);

                // Remove arquivo temporário
                @unlink($tmpFile);

                if (!$newSignature) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $participant->signature = $newSignature;
            } catch (\Exception $e) {
                $this->message->error("Erro ao processar a assinatura: " . $e->getMessage())->flash();
                redirect("painel/eventos/portaria/{$participant->event_id}");
                return;
            }
        }

        // 🔹 Caso tenha upload tradicional via $_FILES (fallback)
        elseif (!empty($_FILES["signature"])) {
            $upload = new Upload();
            if ($participant->signature) {
                (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$participant->signature}");
                $upload->remove(CONF_UPLOAD_DIR . "/{$participant->signature}");
            }

            if (!$participant->signature = $upload->image($_FILES["signature"], "signature-{$participant->user_name}-" . time(), 360, "signatures", true)) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }
        }

        // 🔹 Salva no banco
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
    public function createGoogleCalendarEvent(array $data): void
    {
        $_SESSION['google_calendar_event_id'] = $data['event_id'];

        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../../../client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
        $client->setRedirectUri(url("/painel/eventos/google-calendar-callback"));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit();
    }

    public function googleCalendarCallback(array $data): void
    {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../../../client_secret.json');
        $client->setRedirectUri(url("/painel/eventos/google-calendar-callback"));

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            // Store the access token in the session
            $_SESSION['google_calendar_access_token'] = $token;

            // Save the token to the database for future use
            if ($this->user) {
                $googleToken = (new \Source\Domain\Shared\Models\GoogleToken())->findByUserId($this->user->id);
                if (!$googleToken) {
                    $googleToken = new \Source\Domain\Shared\Models\GoogleToken();
                    $googleToken->user_id = $this->user->id;
                }

                $googleToken->access_token = json_encode($token);
                if (!empty($token['refresh_token'])) {
                    $googleToken->refresh_token = $token['refresh_token'];
                }
                $googleToken->expires_in = $token['expires_in'];

                if (!$googleToken->save()) {
                    (new \Source\Support\Log("google_token"))->error($googleToken->message()->getText());
                }
            }

            $event = (new Event())->findById($_SESSION['google_calendar_event_id']);

            $googleCalendar = new \Source\Support\GoogleCalendar();
            $googleCalendar->setAccessToken($token);

            $googleEvent = $googleCalendar->createEvent('primary', [
                'summary' => $event->title,
                'description' => $event->description,
                'start' => [
                    'dateTime' => (new DateTime($event->start_at))->format(DateTime::RFC3339),
                    'timeZone' => 'America/Sao_Paulo',
                ],
                'end' => [
                    'dateTime' => (new DateTime($event->end_at))->format(DateTime::RFC3339),
                    'timeZone' => 'America/Sao_Paulo',
                ],
            ]);

            $event->google_calendar_event_id = $googleEvent->getId();
            $event->save();

            unset($_SESSION['google_calendar_event_id']);

            $this->message->success("Evento registado com sucesso no Google Calendar!")->flash();
            redirect("/painel/eventos");
        }
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
    
        public function googleCalendarSync(array $data): void
        {
            $eventId = filter_var($data['event_id'], FILTER_VALIDATE_INT);
            $event = (new Event())->findById($eventId);
    
            if (!$event) {
                $this->message->error("Evento não encontrado para sincronizar.")->flash();
                redirect("/painel/eventos");
                return;
            }
    
            $_SESSION['google_calendar_event_id'] = $event->id;
    
            $client = new Google_Client();
            $client->setAuthConfig(__DIR__ . '/../../../../client_secret.json');
            $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
            $client->setRedirectUri(url("/painel/eventos/google-calendar-callback"));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
    
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit();
        }
    
        /**
         * @param array $data
         */
        public function getParticipantDetails(array $data): void
        {
            $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
            
            $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
            $eventParticipant = (new EventParticipant())->findById($participantId);
            $user = $eventParticipant->user();
    
            if (!$eventParticipant) {
                $this->message->error("Você tentou editar um participante que não existe.")->flash();
            redirect("/painel/eventos/portaria");
        }

        $head = $this->seo->render("Checar Participante: {$eventParticipant->user()->user_name}", CONF_SITE_DESC, url("/painel/eventos/portaria/{$eventParticipant->event_id}"), null, false);

        echo $this->view->render("widgets/events/checkin", [
            "head" => $head,
            "eventParticipant" => $eventParticipant,
            "user" => $user
        ]);
    }

    /**
     * @param array $data
     * @return void
     */
    public function getParticipantDetail(array $data): void
    {
        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        if (!$participantId) {
            echo json_encode(["error" => "ID do participante inválido."]);
            return;
        }

        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);
        if (!$participant) {
            echo json_encode(["error" => "Participante não encontrado."]);
            return;
        }

        $user = $participant->user();
        if (!$user) {
            echo json_encode(["error" => "Usuário do participante não encontrado."]);
            return;
        }

        $userData = [
            'name' => $user->user_name,
            'photo' => $user->photo(),
            'email' => $user->email,
            'phone1' => $user->phone1,
            'phone2' => $user->phone2
        ];

        header('Content-Type: application/json');
        echo json_encode($userData);
    }

    /**
     * @param array $data
     * @return void
     */
    public function processCheckIn(array $data): void
    {
        try {
            $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
            $signatureBase64 = $data['signature'] ?? null;

            if (!$participantId || !$signatureBase64) {
                throw new \Exception("Dados inválidos para o check-in.");
            }

            $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);
            if (!$participant) {
                throw new \Exception("Participante não encontrado.");
            }

            $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureBase64));
            if ($signatureData === false) {
                throw new \Exception("Falha ao decodificar a assinatura.");
            }

            $tempFile = tmpfile();
            fwrite($tempFile, $signatureData);
            $tempFilePath = stream_get_meta_data($tempFile)['uri'];

            $upload = new Upload();
            $thumb = new Thumb();

            if ($participant->signature) {
                $thumb->flush(CONF_UPLOAD_DIR . "/{$participant->signature}");
                $upload->remove(CONF_UPLOAD_DIR . "/{$participant->signature}");
            }

            $signatureName = "sig-{$participant->id}-" . time();
            $newSignature = $upload->image($tempFilePath, $signatureName, 600, 'signatures', true);

            fclose($tempFile);

            if (!$newSignature) {
                throw new \Exception($upload->message()->getText());
            }

            $participant->status = "presente";
            $participant->checkin_at = (new DateTime())->format("Y-m-d H:i:s");
            $participant->signature = $newSignature;
            
            if (!$participant->save()) {
                throw new \Exception($participant->fail()->getMessage());
            }

            $this->message->success("Check-in de " . $participant->user()->user_name . " realizado com sucesso!")->flash();
            echo json_encode(["reload" => true]);

        } catch (\Exception $e) {
            $this->message->error("Erro ao processar assinatura: " . $e->getMessage())->flash();
            echo json_encode(["reload" => true]);
        }
    }
}