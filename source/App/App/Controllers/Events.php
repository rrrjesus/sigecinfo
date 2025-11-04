<?php

namespace Source\App\App\Controllers;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Event\Models\Event;
use Source\Domain\Event\EventRepository;
use Source\Domain\Event\Models\EventParticipant;
use Source\App\App\Admin;
use Source\Domain\Event\Models\EventType;
use Source\Domain\Church\Models\Church;
use Source\Domain\Event\EventService;
use Source\Support\Upload;
use Source\Support\Thumb;
use Source\Support\Modal;
use DateTime;

class Events extends Admin
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    public function list(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => $this->user,
            "registers" => (object)["disabled" => (new Event())->find("status IN (:s1, :s2)", "s1=cancelado&s2=realizado")->count()]
        ]);
    }

    public function disabledEvents(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos Desativados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos/desabilitados")],
            ["title" => "Listar Desabilitados"]
        ];

        echo $this->view->render("widgets/events/disabledList", [
            "head" => $head,
            "breadcrumb" => $breadcrumb ,
            "user" => $this->user
        ]);
    }

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

            $this->message->success("Evento registrado com sucesso!")->flash();

            $eventService = new EventService();

            if (!empty($data["user_id_to_add"])) {
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            if (!empty($data["positions"])) {
                $eventService->convokeByPositions($event, $data["positions"]);
            }

            try {
                $googleCalendar = new \Source\Support\GoogleCalendar();
                $endTime = $event->end_at ? $event->end_at : $event->start_at;

                $googleEvent = $googleCalendar->createEvent([
                    'summary' => $event->title,
                    'description' => $event->description,
                    'start' => [
                        'dateTime' => (new DateTime($event->start_at))->format(DateTime::RFC3339),
                        'timeZone' => 'America/Sao_Paulo',
                    ],
                    'end' => [
                        'dateTime' => (new DateTime($endTime))->format(DateTime::RFC3339),
                        'timeZone' => 'America/Sao_Paulo',
                    ],
                ]);

                $event->google_calendar_event_id = $googleEvent->getId();
                $event->save();

                $this->message->success("Evento registado com sucesso e sincronizado com o Google Calendar!")->flash();
            } catch (\Exception $e) {
                $this->message->error("Evento salvo, mas falha ao sincronizar com Google Calendar: " . $e->getMessage())->flash();
            }

            $json["redirect"] = url("/app/eventos/editar/{$event->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Registar Evento - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos"), null, false);

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos/cadastrar")],
            ["title" => "Criar"]
        ];

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => $this->user,
            "event" => null,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true)
        ]);
    }

    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);
        $eventService = new EventService();

        if (!$event) {
            $this->message->error("Você tentou editar um evento que não existe.")->flash();
            redirect("/app/eventos");
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

            if (!empty($data["user_id_to_add"])) {
                $eventService->convokeUser($event, $data["user_id_to_add"]);
            }

            if (!empty($data["positions"])) {
                $eventService->convokeByPositions($event, $data["positions"]);
            }

            try {
                $googleCalendar = new \Source\Support\GoogleCalendar();
                $endTime = $event->end_at ? $event->end_at : $event->start_at;

                $eventData = [
                    'summary' => $event->title,
                    'description' => $event->description,
                    'start' => [
                        'dateTime' => (new DateTime($event->start_at))->format(DateTime::RFC3339),
                        'timeZone' => 'America/Sao_Paulo',
                    ],
                    'end' => [
                        'dateTime' => (new DateTime($endTime))->format(DateTime::RFC3339),
                        'timeZone' => 'America/Sao_Paulo',
                    ],
                ];

                if ($event->google_calendar_event_id) {
                    $googleCalendar->updateEvent($event->google_calendar_event_id, $eventData);
                } else {
                    $googleEvent = $googleCalendar->createEvent($eventData);
                    $event->google_calendar_event_id = $googleEvent->getId();
                    $event->save();
                }

                $this->message->success("Evento atualizado com sucesso e sincronizado com o Google Calendar!")->flash();
            } catch (\Exception $e) {
                $this->message->error("Evento atualizado, mas falha ao sincronizar com Google Calendar: " . $e->getMessage())->flash();
            }
            $json["redirect"] = url("/app/eventos/editar/{$event->id}");
            echo json_encode($json);
            return;
        }

        $now = new DateTime();
        $start_at = new DateTime($event->start_at);
        $end_at = !empty($event->end_at) ? new DateTime($event->end_at) : null;
        
        $isLive = ($event->status == 'ao vivo');
        $canAccess = ($isLive && $now >= $start_at && (empty($end_at) || $now <= $end_at));
        $canStart = ($event->status == 'agendado' && $now >= (clone $start_at)->modify('-15 minutes'));

       $modalFim = Modal::render(
                        'confirmFinishModal',
                        'Finalizar Reunião',
                        'Tem certeza que deseja finalizar esta reunião?',
                        url("/app/eventos/finalizar/{$event->id}"),
                        'Sim, finalizar');
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render("Editar Evento: {$event->title}", CONF_SITE_DESC, url("/app/eventos"), null, false);

        echo $this->view->render("widgets/events/event", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => $this->user,
            "event" => $event,
            "eventTypes" => (new EventType())->find("status = :s", "s=actived")->order("name ASC")->fetch(true),
            "churches" => (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true),
            "isLive" => $isLive,
            "canAccess" => $canAccess,
            "canStart" => $canStart,
            "modalFim" => $modalFim
        ]);
    }

    public function report(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);
        $eventService = new EventService();

        if (!$event) {
            $this->message->error("Você tentou aceder a um evento que não existe.")->flash();
            redirect("/app/eventos");
        }

        $participants = $eventService->getParticipants($event->id);

        if ($participants) {
            usort($participants, function($a, $b) {
                return strcmp($a->user()->user_name, $b->user()->user_name);
            });
        }
        
        $attendanceReport = $eventService->generateAttendanceMatrix($participants);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos")],
            ["title" => "Relatórios e Portaria"]
        ];

        $head = $this->seo->render("Relatórios e Portaria: {$event->title}", CONF_SITE_DESC, url("/app/eventos"), null, false);

        echo $this->view->render("widgets/events/report", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "event" => $event,
            "user" => $this->user,
            "attendanceReport" => $attendanceReport,
            "participants" => $participants
        ]);
    }

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
        
        redirect(url("/app/eventos/editar/{$event->id}"));
    }

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

        redirect(url("/app/eventos/editar/{$event->id}"));
    }

    public function showCheckInPage(array $data): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        if (!$participant) {
            $this->message->error("Participante não encontrado.")->flash();
            redirect("/app/eventos");
        }

        $head = $this->seo->render("Check-in: " . $participant->user()->user_name, CONF_SITE_DESC, url("/app"), null, false);

        echo $this->view->render("widgets/events/checkin", [
            "head" => $head,
            "participant" => $participant,
            "user" => $this->user
        ]);
    }

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
            redirect("/app/eventos");
            return;
        }

        try {
            $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureBase64));
            if ($signatureData === false) {
                throw new \Exception("Falha ao decodificar a assinatura.");
            }

            $tempFile = tmpfile();
            fwrite($tempFile, $signatureData);
            $tempFilePath = stream_get_meta_data($tempFile)['uri'];

            $upload = new \Source\Support\Upload();
            $thumb = new \Source\Support\Thumb();

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
            $participant->save();

            if ($participant->fail()) {
                throw new \Exception($participant->fail()->getMessage());
            }

            $this->message->success("Check-in de " . $participant->user()->user_name . " realizado com sucesso!")->flash();
            redirect(url("/app/eventos/portaria/{$participant->event_id}"));

        } catch (\Exception $e) {
            $this->message->error("Erro ao processar assinatura: " . $e->getMessage())->flash();
            redirect(url_back());
        }
    }

    public function checkIn(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new EventParticipant())->findById($participantId);

        if ($participant && $participant->status != 'presente') {
            $participant->status = 'presente';
            $participant->checkin_at = date("Y-m-d H:i:s");

            if (!empty($data["signature_base64"])) {
                try {
                    $signatureBase64 = $data["signature_base64"];
                    $signatureBase64 = str_replace('data:image/png;base64,', '', $signatureBase64);
                    $signatureBase64 = str_replace(' ', '+', $signatureBase64);
                    $decoded = base64_decode($signatureBase64);

                    if ($decoded === false) {
                        throw new \Exception("Não foi possível decodificar a assinatura enviada.");
                    }

                    $tmpFile = __DIR__ . "/../../shared/tmp_signature_" . uniqid() . ".png";
                    file_put_contents($tmpFile, $decoded);

                    $upload = new Upload();

                    if ($participant->signature) {
                        (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$participant->signature}");
                        $upload->remove(CONF_UPLOAD_DIR . "/{$participant->signature}");
                    }

                    $signatureName = "signature-" . $participant->user_name . "-" . time();
                    $newSignature = $upload->image($tmpFile, $signatureName, 360, "signatures", true);

                    @unlink($tmpFile);

                    if (!$newSignature) {
                        $json["message"] = $upload->message()->render();
                        echo json_encode($json);
                        return;
                    }

                    $participant->signature = $newSignature;
                } catch (\Exception $e) {
                    $this->message->error("Erro ao processar a assinatura: " . $e->getMessage())->flash();
                    redirect(url("/app/eventos/portaria/{$participant->event_id}"));
                    return;
                }
            }
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

            $participant->save();
            $this->message->success("Participante {$participant->user()->user_name} confirmado com sucesso!")->flash();
        } else {
            $this->message->error("Não foi possível encontrar a participação para confirmar.")->flash();
        }

        redirect(url("/app/eventos/portaria/{$participant->event_id}"));
    }

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

        redirect(url("/app/eventos/portaria/{$participant->event_id}"));
    }

    public function changeResponse(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        $participant->status = "convocado";
        $participant->justification = null;
        $participant->save();

        $this->message->info("A sua resposta foi redefinida. Por favor, escolha a sua nova opção.")->flash();
        redirect(url_back());
    }

    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);

        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event) {
            try {
                if ($event->google_calendar_event_id) {
                    $googleCalendar = new \Source\Support\GoogleCalendar();
                    $googleCalendar->deleteEvent($event->google_calendar_event_id);
                }
            } catch (\Exception $e) {
                $this->message->error("Falha ao remover evento do Google Calendar: " . $e->getMessage())->flash();
            }

            if ($event->cover && file_exists(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}")) {
                unlink(CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$event->cover}");
                (new Thumb())->flush(CONF_UPLOAD_DIR . "/{$event->cover}");
            }
            $event->destroy();
        }

        $this->message->success("O evento foi excluído com sucesso.")->flash();
        redirect(url_back());
    }

    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $eventId = filter_var($data["event_id"], FILTER_VALIDATE_INT);
        $event = (new Event())->findById($eventId);

        if ($event) {
            $event->status = ($event->status == "agendado" ? "cancelado" : "agendado");
            $event->updated_by = $this->user->id;
            $event->save();
        }
        
        $actionText = ($event->status == "agendado" ? "reagendado" : "cancelado");
        $this->message->success("O evento foi {$actionText} com sucesso!")->flash();
        redirect(url_back());
    }

    public function getParticipantDetails(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $eventParticipant = (new EventParticipant())->findById($participantId);
        $user = $eventParticipant->user();

        if (!$eventParticipant) {
            $this->message->error("Você tentou editar um participante que não existe.")->flash();
            redirect("/app/eventos/portaria");
        }

        $head = $this->seo->render("Checar Participante: {$eventParticipant->user()->user_name}", CONF_SITE_DESC, url("/app/eventos/portaria/{$eventParticipant->event_id}"), null, false);

        echo $this->view->render("widgets/events/checkin", [
            "head" => $head,
            "eventParticipant" => $eventParticipant,
            "user" => $user
        ]);
    }

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

    public function qrCodeCheckIn(array $data): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        if (!$participant) {
            $this->message->error("Participante não encontrado.")->flash();
            redirect("/app/eventos");
            return;
        }

        // Generate a secure token for the QR code. This token should be stored and validated on scan.
        // For simplicity, let's use a hash of participant ID and a secret key for now.
        // In a real application, this should be a more robust, time-limited token stored in the database.
        $secureToken = md5($participant->id . CONF_SITE_SALT . $participant->event_id);

        // The URL that the QR code will encode. This URL will be used by the scanner.
        $qrCodeUrl = url("/app/eventos/checkin-qr-scan/{$participant->id}/{$participant->event_id}/{$secureToken}");

        $qrCode = new \Source\Support\QrCode();
        $qrCodeSvg = $qrCode->svg($qrCodeUrl);

        $head = $this->seo->render("QR Code Check-in: " . $participant->user()->user_name, CONF_SITE_DESC, url("/app"), null, false);

        echo $this->view->render("widgets/events/qrcode-checkin", [
            "head" => $head,
            "participant" => $participant,
            "qrCodeSvg" => $qrCodeSvg,
            "user" => $this->user
        ]);
    }

    public function checkinQrScan(array $data): void
    {
        $participantId = filter_var($data['participant_id'], FILTER_VALIDATE_INT);
        $eventId = filter_var($data['event_id'], FILTER_VALIDATE_INT);
        $secureToken = filter_var($data['secure_token'], FILTER_SANITIZE_STRING);

        if (!$participantId || !$eventId || !$secureToken) {
            $this->message->error("Dados de QR Code inválidos.")->flash();
            redirect("/app/eventos");
            return;
        }

        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        if (!$participant || $participant->event_id != $eventId) {
            $this->message->error("Participante ou evento não encontrado.")->flash();
            redirect("/app/eventos");
            return;
        }

        // Validate the secure token
        $expectedToken = md5($participant->id . CONF_SITE_SALT . $participant->event_id);
        if ($secureToken !== $expectedToken) {
            $this->message->error("Token de segurança inválido.")->flash();
            redirect("/app/eventos");
            return;
        }

        if ($participant->status == "presente") {
            $this->message->info("Participante {$participant->user()->user_name} já realizou o check-in.")->flash();
            redirect(url("/app/eventos/portaria/{$participant->event_id}"));
            return;
        }

        try {
            $participant->status = "presente";
            $participant->checkin_at = (new \DateTime())->format("Y-m-d H:i:s");
            
            if (!$participant->save()) {
                throw new \Exception($participant->fail()->getMessage());
            }

            $this->message->success("Check-in de " . $participant->user()->user_name . " realizado com sucesso via QR Code!")->flash();
            redirect(url("/app/eventos/portaria/{$participant->event_id}"));

        } catch (\Exception $e) {
            $this->message->error("Erro ao realizar check-in via QR Code: " . $e->getMessage())->flash();
            redirect(url("/app/eventos/portaria/{$participant->event_id}"));
        }
    }

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

    public function listEvents(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/list-events", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "user" => $this->user,
            "registers" => (object)["disabled" => (new Event())->find("status IN (:s1, :s2)", "s1=cancelado&s2=realizado")->count()]
        ]);
    }

    public function listEventsDisableds(): void
    {
        $this->authorize(['Editor', 'Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Eventos Finalizados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos/finalizados"), null, false);
        
        $breadcrumb = [
            ["title" => "Eventos Finalizados", "link" => url("/app/eventos/finalizados")],
            ["title" => "Listar"]
        ];

        echo $this->view->render("widgets/events/disabled-list-events", [
            "head" => $head,
            "user" => $this->user,
            "breadcrumb" => $breadcrumb
        ]);
    }

    public function listMyEvents(): void
    {
        $head = $this->seo->render("Eventos Agendados - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/meus-eventos"), null, false);
        
        $eventRepo = new EventRepository();
        $myParticipants = (new \Source\Domain\Event\Models\EventParticipant())->find("user_id = :uid", "uid={$this->user->id}")->order("checkin_at DESC, created_at DESC")->fetch(true) ?? [];

        $breadcrumb = [
            ["title" => "Eventos", "link" => url("/app/eventos/eventos")],
            ["title" => "Eventos Agendados"]
        ];

        echo $this->view->render("widgets/events/my-events", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "participants" => $myParticipants,
            "user" => $this->user
        ]);
    }

    public function confirm(array $data): void
    {
        $participantId = filter_var($data["participant_id"], FILTER_VALIDATE_INT);
        $participant = (new EventParticipant())->findById($participantId);

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

    public function justify(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $participantId = filter_var($data["participant_id"] ?? null, FILTER_VALIDATE_INT);
        $justification = isset($data["justification"]) ? trim($data["justification"]) : null;

        if (!$participantId) {
            $this->message->error("Participante inválido.")->flash();
            http_response_code(400);
            echo json_encode(["status" => "error"]);
            return;
        }

        $participant = (new \Source\Domain\Event\Models\EventParticipant())->findById($participantId);

        if (!$participant || $participant->user_id != $this->user->id) {
            $this->message->error("Você não tem permissão para justificar esta participação.")->flash();
            http_response_code(403);
            echo json_encode(["status" => "error"]);
            return;
        }

        if (empty($justification)) {
            $this->message->warning("Por favor, escreva o motivo da sua ausência.")->flash();
            http_response_code(422);
            echo json_encode(["status" => "warning"]);
            return;
        }

        $participant->status = "recusado";
        $participant->justification = htmlspecialchars($justification, ENT_QUOTES, 'UTF-8');

        if ($participant->save()) {
            $this->message->success("Justificativa de falta enviada com sucesso.")->flash();
            echo json_encode(["status" => "success", "close_modal" => true, "reload" => true]);
        } else {
            http_response_code(500);
            $this->message->error("Ocorreu um erro ao salvar. Tente novamente.")->flash();
            echo json_encode(["status" => "error"]);
        }
    }

    public function getEventsForUser(int $userId): ?array
    {
        $events = (new \Source\Domain\Event\Models\Event())->find(
            "id IN (SELECT event_id FROM event_participants WHERE user_id = :uid)",
            "uid={$userId}"
        )->order("start_at DESC")->fetch(true);

        return $events;
    }

    public function completedEvents(): void
    {
        $head = $this->seo->render("Meu Histórico de Eventos - " . CONF_SITE_NAME, CONF_SITE_DESC, url("/app/eventos/meus-eventos-finalizados"), null, false);
        
        $eventRepo = new EventRepository();
        $completedEvents = $eventRepo->getCompletedEventsForUser($this->user->id);

        echo $this->view->render("widgets/events/my-completed-events", [
            "head" => $head,
            "events" => $completedEvents,
            "user" => $this->user
        ]);
    }
}