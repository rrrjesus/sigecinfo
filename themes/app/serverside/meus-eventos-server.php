<?php

require_once '../../../source/Boot/Config.php';
require_once '../../../source/Boot/Helpers.php';

use Source\Domain\Event\Models\EventParticipant;
use Source\Domain\Event\Models\Event;

session_start();
$user = $_SESSION['user'] ?? null;

if (!$user) {
    echo json_encode([
        "draw" => 0,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => []
    ]);
    exit;
}

$table = <<<EOT
(
    SELECT 
        event_participants.id as participant_id,
        event_participants.status as participation_status,
        event_participants.justification,
        events.id as event_id,
        events.title,
        events.description,
        events.start_at,
        events.status as event_status,
        event_types.name as type_name,
        churchs.church_name,
        events.location_text
    FROM event_participants
    JOIN events ON event_participants.event_id = events.id
    LEFT JOIN event_types ON events.type_id = event_types.id
    LEFT JOIN churchs ON events.church_id = churchs.id
    WHERE event_participants.user_id = {$user->id}
) temp
EOT;

$primaryKey = 'participant_id';

$columns = [
    [
        'db' => 'participation_status', 'dt' => 0, 'formatter' => function ($d, $row) {
            $participantId = $row['participant_id'];
            $justification = $row['justification'] ?? '';
            $output = '';

            if ($d === 'convocado') {
                $output .= <<<HTML
<form class="ajax_off" style="display:inline;" action="/beta/eventos/confirmar" method="post">
    <input type="hidden" name="participant_id" value="{$participantId}">
    <button class="btn btn-success btn-sm m-1 p-1"><i class="bi bi-check-circle"></i></button>
</form>
<button class="btn btn-warning btn-sm p-1" data-bs-toggle="modal" data-bs-target="#justifyModal{$participantId}">
    <i class="bi bi-x-circle"></i>
</button>
HTML;
            } elseif ($d === 'confirmado') {
                $output = '<span class="badge text-bg-success p-2">Confirmado</span>';
            } elseif ($d === 'presente') {
                $output = '<span class="badge text-bg-success p-2">Presente</span>';
            } elseif ($d === 'recusado') {
                $output = '<span class="badge text-bg-warning p-2">Falta Justificada</span>';
                if ($justification) {
                    $output .= "<br><small><i><b>Motivo:</b> " . htmlspecialchars($justification) . "</i></small>";
                }
            } else {
                $output = '<span class="badge text-bg-danger p-2">' . ucfirst($d) . '</span>';
            }

            return $output;
        }
    ],
    [
        'db' => 'start_at', 'dt' => 1, 'formatter' => function ($d) {
            return '<h6>' . htmlspecialchars(date_fmt($d, "d/m/Y H:i")) . '</h6>';
        }
    ],
    [
        'db' => 'title', 'dt' => 2, 'formatter' => fn($d) => '<h6>' . htmlspecialchars($d) . '</h6>'
    ],
    [
        'db' => 'description', 'dt' => 3, 'formatter' => fn($d) => '<h6>' . htmlspecialchars(str_limit_chars($d, 150)) . '</h6>'
    ],
    [
        'db' => 'type_name', 'dt' => 4, 'formatter' => fn($d) => '<h6>' . htmlspecialchars($d ?? 'Não informado') . '</h6>'
    ],
    [
        'db' => 'church_name', 'dt' => 5, 'formatter' => fn($d) => '<h6>' . htmlspecialchars($d ?? 'Não informado') . '</h6>'
    ],
    [
        'db' => 'title', 'dt' => 6, 'formatter' => fn($d) => '<h6>' . htmlspecialchars($d) . '</h6>' // comp
    ],
    [
        'db' => 'event_status', 'dt' => 7, 'formatter' => function($d) {
            return eventStatusBadge($d);
        }
    ],
    [
        'db' => 'participation_status', 'dt' => 8, 'formatter' => function ($d, $row) {
            if ($d !== 'convocado') {
                $participantId = $row['participant_id'];
                return <<<HTML
<form class="ajax_off" style="display: inline;" action="/beta/eventos/alterar-resposta" method="post">
    <input type="hidden" name="participant_id" value="{$participantId}">
    <button class="btn btn-warning btn-sm rounded-circle"><i class="bi bi-pencil"></i></button>
</form>
HTML;
            }
            return '';
        }
    ],
];

$sql_details = [
    'user' => CONF_DB_USER,
    'pass' => CONF_DB_PASS,
    'db'   => CONF_DB_NAME,
    'host' => CONF_DB_HOST,
    'charset' => 'utf8'
];

require('ssp.class.php');

echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
);
