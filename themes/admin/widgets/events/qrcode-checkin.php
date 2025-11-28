<?php $this->layout("_admin"); ?>

<style>
@media print {
    .btn, .breadcrumb, .ajax_response {
        display: none;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="ajax_response"><?= flash(); ?></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="card shadow-lg rounded-4">
                    
                <div class="card-header text-center fw-semibold fs-5">
                    <i class="bi bi-qr-code me-2"></i>QR Code para Check-in
                </div>
                
                <div class="card-body p-5">
                    <!-- Informações do evento -->
                    <div class="mb-4 text-start p-3 rounded-3 bg-body text-body mx-auto">
                        <p class="mb-1"><strong>Evento:</strong> <?= $event->title; ?></p>
                        <p class="mb-1"><strong>Descrição:</strong> <?= $event->description; ?></p>
                        <p class="mb-1"><strong>Data / Início:</strong> <?= date_fmt($event->date_event, "d/m/Y H:i"); ?></p>
                        <p class="mb-0"><strong>Local:</strong> <?= $event->place()->place_name;?> - <?=$event->location_text; ?></p>
                    </div>

                    <!-- QR Code -->
                    <div class="mb-4 text-center p-3 rounded-3 bg-body text-body mx-auto">
                        <?php if (!empty($qrCodeSvg)): ?>
                            
                                <?= $qrCodeSvg; ?>
                            
                                <p class="text-muted m-3">Escaneie este código para realizar o check-in no evento.</p>
                    
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                Não foi possível gerar o QR Code para este participante.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer text-center bg-body-tertiary">

                    <?= button([
                        "href" => "/app/eventos/meus-eventos-agendados",
                        "name" => " Voltar para Meus Eventos",
                        "icon" => "arrow-left",
                        "btncolor" => "secondary",
                        "title" => "Voltar para a lista dos seus eventos",
                        "custom" => "custom-tooltip-secondary"
                    ]); ?>

                    <?= button([
                        "name" => "Imprimir QR Code",
                        "icon" => "printer me-1",
                        "btncolor" => "secondary",
                        "title" => "Imprimir QR Code",
                        "custom" => "custom-tooltip-secondary",
                        "onclick" => "window.print()"
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
