<?php $this->layout("_app"); ?>

<?php $this->start('modals'); ?>
<?php $this->end(); ?>

<?php $this->start('styles'); ?>
<?php $this->end(); ?>

<?php $this->start('app_content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Meus Eventos Agendados</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($participants)): ?>
                    <div class="list-group">
                        <?php foreach ($participants as $participant): ?>
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?= $participant->event()->title; ?></h5>
                                    <small><?= (new DateTime($participant->event()->start_at))->format("d/m/Y H:i"); ?></small>
                                </div>
                                <p class="mb-1"><?= $participant->event()->description; ?></p>
                                <small>Local: <?= $participant->event()->location_text; ?></small>
                                <div class="mt-2">
                                    <a href="<?= url("/app/eventos/qrcode/{$participant->id}"); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-qrcode"></i> Gerar QR Code para Check-in
                                    </a>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">Você não possui eventos agendados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>

<?php $this->start('scripts'); ?>
<?php $this->end(); ?>