<?php $this->layout("_theme"); ?>

<div class="container mt-4">
    <h2>Meus Eventos</h2>
    <hr>
    
    <?php if (empty($events)): ?>
        <div class="alert alert-info">Você ainda não foi convocado para nenhum evento.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($events as $event): ?>
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= $event->title; ?></h5>
                        <small><?= date_fmt($event->start_at, "d/m/Y H:i"); ?></small>
                    </div>
                    <p class="mb-1"><?= str_limit_chars($event->description, 150); ?></p>
                    
                    <?php
                        $participant = (new \Source\Domain\Event\Models\EventParticipant())->find("event_id = :eid AND user_id = :uid", "eid={$event->id}&uid={$user->id}")->fetch();
                    ?>

                    <?php if ($participant && $participant->status === 'convocado'): ?>
                        <div class="mt-2">
                            <form class="d-inline" action="<?= url("/beta/eventos/confirmar"); ?>" method="post">
                                <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                <button type="submit" class="btn btn-sm btn-success">Confirmar Presença</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#justifyModal<?= $participant->id; ?>">
                                Justificar Falta
                            </button>
                        </div>
                    <?php else: ?>
                        <span class="badge text-bg-secondary mt-2"><?= ucfirst($participant->status); ?></span>
                    <?php endif; ?>
                </div>

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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>