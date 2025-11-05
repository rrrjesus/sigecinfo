<?php $this->layout("_app"); ?>

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-qr-code me-2"></i>QR Code para Check-in</h5>
            </div>
            <div class="card-body text-center">
                <?php if (!empty($qrCodeSvg)): ?>
                    <?= $qrCodeSvg; ?>
                    <p class="mt-3">Escaneie este QR Code para realizar o check-in no evento.</p>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Não foi possível gerar o QR Code para este participante.
                    </div>
                <?php endif; ?>
                <a href="<?= url("/app/eventos/meus-eventos-agendados"); ?>" class="btn btn-primary mt-3">Voltar para Meus Eventos</a>
            </div>
        </div>
    </div>
</div>