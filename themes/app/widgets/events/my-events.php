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
                        <?php else: foreach ($events as $event): 
                            // Busca os dados da participação uma única vez
                            $participant = (new \Source\Domain\Event\Models\EventParticipant())->find("event_id = :eid AND user_id = :uid", "eid={$event->id}&uid={$user->id}")->fetch();
                        ?>
                        <table id="myEvents" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Data</th>
                                    <th class="text-center"><i class="bi bi-person-bounding-box me-2"></i>Evento</th>
                                    <th class="text-center"><i class="bi bi-person-vcard me-2"></i>Descrição</th>
                                    <th class="text-center"><i class="bi bi-phone me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-person-badge me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-bank me-2"></i>Parte Local</th>
                                    <th class="text-center"><i class="bi bi-bank me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                 <tr>
                                    <td class="text-center text-uppercase"><small><?= date_fmt($event->start_at, "d/m/Y H:i"); ?></small></td>
                                    <td class="text-center text-uppercase"><?= $event->title; ?></td>
                                    <td class="text-center text-uppercase"><?= str_limit_chars($event->description, 150); ?></td>
                                    <td class="text-center text-uppercase"><?= $event->type_id; ?></td>
                                    <td class="text-center text-uppercase"><?= $event->church_id; ?></td>
                                    <td class="text-center text-uppercase"><?= $event->title; ?></td>
                                    <td class="text-center text-uppercase">
                                                                                <?php if ($participant && $participant->status === 'convocado'): ?>
                            
                                            <form class="ajax_off" style="display: inline;" action="<?= url("/beta/eventos/confirmar"); ?>" method="post">
                                                <?= csrf_input(); ?>
                                                <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                <button type="submit" class="btn btn-sm btn-success fw-semibold m-2"><i class="bi bi-check-circle me-1"></i> Confirmar Presença</button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#justifyModal<?= $participant->id; ?>">
                                                <i class="bi bi-x-circle me-1"></i> Justificar Falta
                                            </button>

                                        <?php elseif ($participant): ?>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <?php if ($participant->status === 'confirmado'): ?>
                                                        <p class="mb-0"><span class="badge text-bg-success p-2">Presença Confirmada</span></p>
                                                    <?php elseif ($participant->status === 'recusado'): ?>
                                                        <p class="mb-0"><span class="badge text-bg-warning p-2">Falta Justificada</span></p>
                                                        <small class="text-muted fst-italic">Motivo: <?= $participant->justification; ?></small>
                                                    <?php else: ?>
                                                        <p class="mb-0"><strong>Status:</strong> <span class="badge text-bg-secondary"><?= ucfirst($participant->status); ?></span></p>
                                                    <?php endif; ?>
                                                </div>
                                                <form class="ajax_off" style="display: inline;" action="<?= url("/beta/eventos/alterar-resposta"); ?>" method="post">
                                                    <?= csrf_input(); ?>
                                                    <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Alterar Resposta</button>
                                                </form>
                                            </div>

                                        <?php endif; ?>
                                    </td>

                                    <div class="modal fade" id="justifyModal<?= $participant->id; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="<?= url("/beta/eventos/justificar"); ?>" method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Justificar Falta</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Por favor, descreva o motivo da sua ausência no evento "<?= $event->title; ?>".</p>
                                                        <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                        <textarea name="justification" class="form-control" rows="4" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Enviar Justificativa</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>