<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>


<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex justify-content-between align-items-center fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Meus Eventos
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <?php if (empty($events)): ?>
                            <div class="alert alert-primary text-center fw-semibold" role="alert">Você ainda não foi convocado para nenhum evento.</div>
                        <?php else: ?>
                        <table id="myCompletedEvents" class="table table-bordered table-hover align-middle text-center mb-0" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-person-check me-2"></i>Presença</th>
                                    <th class="text-center"><i class="bi bi-calendar-event me-2"></i>Data</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Evento</th>
                                    <th class="text-center"><i class="bi bi-card-text me-2"></i>Descrição</th>
                                    <th class="text-center"><i class="bi bi-tag me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-pin-map me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Comp</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
    
                                <?php if (empty($events)): ?>
                                    <div class="alert alert-info">Você ainda não participou de nenhum evento concluído.</div>
                                <?php else: ?>
                                    <?php foreach ($events as $event): 
                                        // Busca os dados da participação uma única vez
                                        $participant = (new \Source\Domain\Event\Models\EventParticipant())->find("event_id = :eid AND user_id = :uid", "eid={$event->id}&uid={$user->id}")->fetch();
                                    ?>
                                <tr>
                                    <td>
                                        
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

                                    </td>
                                    <td><?= date_fmt($event->start_at, "d/m/Y H:i"); ?></td>
                                    <td><?= $event->title; ?></td>
                                    <td><?= str_limit_chars($event->description, 150); ?></td>
                                    <td><?= $event->eventType()->name ?? 'Não informado'; ?></td>
                                    <td><?= $event->place()->place_name ?? 'Não informado'; ?></td>
                                    <td><?= $participant->justification; ?></td>
                                    <td><?= eventStatusBadge($event->status); ?></td>
                                </tr>
                                
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
    <?php endif; ?>
</div>