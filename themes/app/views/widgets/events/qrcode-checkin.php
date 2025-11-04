<?php $this->layout('_app'); ?>

<?php $this->start('modals'); ?>
<?php $this->end(); ?>

<?php $this->start('styles'); ?>
<style>
    .qrcode-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 30px;
    }
    .qrcode-container svg {
        width: 100%;
        max-width: 300px; /* Adjust as needed */
        height: auto;
    }
    .checkin-info {
        text-align: center;
        margin-top: 20px;
    }
    .checkin-info h2 {
        color: #343a40;
        margin-bottom: 10px;
    }
    .checkin-info p {
        color: #6c757d;
        font-size: 1.1em;
    }
</style>
<?php $this->end(); ?>

<?php $this->start('app_content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title mb-0">Check-in por QR Code</h1>
            </div>
            <div class="card-body">
                <div class="checkin-info">
                    <h2>Olá, <?= $participant->user()->user_name; ?>!</h2>
                    <p>Seu QR Code para o evento <strong><?= $participant->event()->title; ?></strong> está pronto.</p>
                    <p>Apresente este código na entrada para realizar seu check-in.</p>
                </div>
                <div class="qrcode-container">
                    <?= $qrCodeSvg; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= url("/app/eventos/meus-eventos"); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar para Meus Eventos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>

<?php $this->start('scripts'); ?>
<?php $this->end(); ?>