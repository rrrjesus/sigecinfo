<?php $this->layout("_beta"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Meus Eventos</h6>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <?php if (empty($events)): ?>
                            <div class="alert alert-primary text-center fw-semibold" role="alert">Você ainda não foi convocado para nenhum evento.</div>
                        <?php else: ?>
                        <table id="myEventsFinish" class="table table-bordered table-hover align-middle text-center mb-0" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th class="text-center"><i class="bi bi-person-check me-2"></i>Presença</th>
                                    <th class="text-center"><i class="bi bi-calendar-event me-2"></i>Data</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Evento</th>
                                    <th class="text-center"><i class="bi bi-card-text me-2"></i>Descrição</th>
                                    <th class="text-center"><i class="bi bi-tag me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-pin-map me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Comp</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-pencil me-2"></i>Alterar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($events as $event): 
                                // Busca os dados da participação uma única vez
                                $participant = (new \Source\Domain\Event\Models\EventParticipant())->find("event_id = :eid AND user_id = :uid", "eid={$event->id}&uid={$user->id}")->fetch();
                            ?>
                                <tr>
                                    <td class="text-center">
                                    <?php if ($participant && $participant->status === 'convocado'): ?>
                                        <form class="ajax_off" style="display: inline;" action="<?= url("/beta/eventos/confirmar"); ?>" method="post">
                                            <?= csrf_input(); ?>
                                            <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                            <?= button([
                                                "name" => "Confirmar",
                                                "icon" => "check-circle",
                                                "btncolor" => "success",
                                                "class" => "m-1 p-1",
                                                "type" => "submit"
                                            ]); ?>
                                        </form>
                                        <?= button([
                                            "name" => "Justificar",
                                            "icon" => "x-circle",
                                            "btncolor" => "warning",
                                            "data-bs-toggle" => "modal",
                                            "data-bs-target" => "#justifyModal{$participant->id}",
                                            "class" => "p-1"
                                        ]); ?>

                                        <?php elseif ($participant): ?>

                                            <div class="d-flex justify-content-between align-items-center">
                                                    <?php 
                                                        if ($participant->status === 'confirmado'): ?>
                                                        <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Confirmado</span></h5>
                                                    <?php elseif ($participant->status === 'convocado'): ?>
                                                        <h5><span class="badge text-bg-primary text-white p-2 fw-semibold">Convocado</span></h5>
                                                    <?php elseif ($participant->status === 'presente'): ?>
                                                        <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Presente</span></h5>
                                                    <?php elseif ($participant->status === 'recusado'): ?>
                                                        <h5><span class="badge text-bg-warning fw-semibold p-2">Falta Justificada</span></h5>
                                                        <h6><small class="text-muted fst-italic"><strong>Motivo:</strong> <?= $participant->justification; ?></small></h6>
                                                    <?php else: ?>
                                                        <h5><span class="badge text-bg-danger text-white p-2 fw-semibold"><?=ucfirst($participant->status); ?></span></h5>
                                                    <?php endif; ?>
                                            </div>

                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><h6><?= date_fmt($event->start_at, "d/m/Y H:i"); ?></h6></td>
                                    <td class="text-center"><h6><?= $event->title; ?></h6></td>
                                    <td class="text-center"><h6><?= str_limit_chars($event->description, 150); ?></h6></td>
                                    <td class="text-center"><h6><?= $event->eventType()->name ?? 'Não informado'; ?></h6></td>
                                    <td class="text-center"><h6><?= $event->church()->church_name ?? 'Não informado'; ?></h6></td>
                                    <td class="text-center"><h6><?= $event->title; ?></h6></td>
                                    <td class="text-center"><?= eventStatusBadge($event->status); ?></td>
                                    <td class="text-center">
                                            <?php if ($participant && $participant->status !== 'convocado'): ?>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <form class="ajax_off" style="display: inline;" action="<?= url("/beta/eventos/alterar-resposta"); ?>" method="post">
                                                        <?= csrf_input(); ?>
                                                        <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                        <?= button([
                                                            "name" => "",
                                                            "icon" => "pencil",
                                                            "btncolor" => "warning",
                                                            "class" => "rounded-circle text-warning-emphasis",
                                                            "type" => "submit"
                                                        ]); ?>
                                                    </form>
                                                </div>
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
                                    url("/beta/eventos/justificar"),
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