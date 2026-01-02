<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex justify-content-between align-items-center fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Eventos Agendados
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <?php if (empty($events)): ?>
                            <div class="alert alert-primary text-center fw-semibold" role="alert">Você ainda não foi convocado para nenhum evento.</div>
                        <?php else: ?>
                        <table id="myEvents" class="table table-bordered table-hover align-middle text-center mb-0" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th><i class="bi bi-person-check me-2"></i>Presença</th>
                                    <th><i class="bi bi-calendar-event me-2"></i>Data</th>
                                    <th><i class="bi bi-bookmark-star me-2"></i>Evento</th>
                                    <th><i class="bi bi-card-text me-2"></i>Descrição</th>
                                    <th><i class="bi bi-tag me-2"></i>Tipo</th>
                                    <th><i class="bi bi-pin-map me-2"></i>Local</th>
                                    <th><i class="bi bi-geo-alt me-2"></i>Comp</th>
                                    <th><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th><i class="bi bi-qr-code me-2"></i>QR Code</th>
                                    <th><i class="bi bi-pencil me-2"></i>Alterar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php foreach ($events as $event): 
                                // Busca os dados da participação uma única vez
                                $participant = (new \Source\Domain\Event\Models\EventParticipant())->find("event_id = :eid AND user_id = :uid", "eid={$event->id}&uid={$user->id}")->fetch();
                            ?>
                                <tr>
                                    <td>
                                    <?php if ($participant && $participant->status === 'convocado'): ?>
                                        <form class="ajax_off" style="display: inline;" action="<?= url("/app/eventos/confirmar"); ?>" method="post">
                                            <?= csrf_input(); ?>
                                            <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                            <?= button([
                                                "name" => "Confirmar",
                                                "icon" => "check-circle m-1",
                                                "btncolor" => "success",
                                                "class" => "m-1 p-1",
                                                "title" => "Confirmar presença no evento",
                                                "custom" => "custom-tooltip-secondary",
                                                "type" => "submit"
                                            ]); ?>
                                        </form>
                                        <?= button([
                                            "name" => "Justificar",
                                            "icon" => "x-circle m-1",
                                            "btncolor" => "warning",
                                            "data-bs-toggle" => "modal",
                                            "data-bs-target" => "#justifyModal{$participant->id}",
                                            "title" => "Justificar ausência no evento",
                                            "custom" => "custom-tooltip-secondary",
                                            "class" => "text-dark-emphasis"
                                        ]); ?>

                                        <?php elseif ($participant): ?>
                                            
                                            <?php if ($participant->status === 'confirmado'): ?>
                                                <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Confirmado</span></h5>
                                            <?php elseif ($participant->status === 'justificado'): ?>
                                                <h5><span class="badge text-bg-warning fw-semibold p-2">Falta Justificada</span></h5>
                                                <small class="text-muted fst-italic"><strong>Motivo:</strong> <?= $participant->justification; ?></small>
                                            <?php elseif ($participant->status === 'convocado'): ?>
                                                <h5><span class="badge text-bg-primary fw-semibold p-2">Convocado</span></h5>
                                            <?php elseif ($participant->status === 'presente'): ?>
                                                <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Presente</span></h5>
                                            <?php else: ?>
                                                <p class="mb-0"><strong>Status:</strong> <span class="badge text-bg-secondary"><?= ucfirst($participant->status); ?></span></p>
                                            <?php endif; ?>
                                            
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date_fmt($event->start_at, "d/m/Y H:i"); ?></td>
                                    <td><?= $event->title; ?></td>
                                    <td><?= str_limit_chars($event->description, 150); ?></td>
                                    <td><?= $event->eventType()->name ?? 'Não informado'; ?></td>
                                    <td><?= $event->place()->place_name ?? 'Não informado'; ?></td>
                                    <td><?= $event->title; ?></td>
                                    <td><?= eventStatusBadge($event->status); ?></td>
                                    <td>
                                        <?php if ($participant): ?>
                                            <?= button([
                                                "name" => "QR Code",
                                                "icon" => "qr-code me-1",
                                                "btncolor" => "info",
                                                "class" => "rounded-circle text-info-emphasis",
                                                "href" => url("/app/eventos/qrcode-checkin/{$participant->id}"),
                                                "title" => "Gerar QR Code para check-in",
                                                "custom" => "custom-tooltip-secondary"
                                            ]); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($participant->status !== 'presente'): ?>
                                            <?php if ($participant && $participant->status !== 'convocado'): ?>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <form class="ajax_off" style="display: inline;" action="<?= url("/app/eventos/alterar-resposta"); ?>" method="post">
                                                        <?= csrf_input(); ?>
                                                        <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                        <?= button([
                                                            "name" => "",
                                                            "icon" => "pencil",
                                                            "btncolor" => "warning",
                                                            "class" => "rounded-circle text-warning-emphasis",
                                                            "title" => "Alterar sua resposta de presença",
                                                            "custom" => "custom-tooltip-secondary",
                                                            "type" => "submit"
                                                        ]); ?>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php
                                $formContent = <<<HTML
                                    <p>Por favor, descreva o motivo da sua ausência no evento "{$event->title}".</p>
                                    <input type="hidden" name="participant_id" value="{$participant->id}">
                                    <textarea name="justification" class="form-control" rows="4" required></textarea>
                                    HTML;

                                echo \Source\Support\Modal::renderForm(
                                    "justifyModal{$participant->id}",
                                    "Justificar Falta",
                                    url("/app/eventos/justificar"),
                                    $formContent,
                                    "Enviar Justificativa"
                                );
                                ?>
                                
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>