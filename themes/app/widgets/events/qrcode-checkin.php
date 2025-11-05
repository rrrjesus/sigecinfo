<?php $this->layout("_app"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="ajax_response"><?= flash(); ?></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-qr-code me-2"></i>QR Code para Check-in
                    </h4>
                    
                    <!-- Informações do evento -->
                    <div class="mb-4 text-start bg-light p-3 rounded-3">
                        <p class="mb-1"><strong>Evento:</strong> <?= $event->title; ?></p>
                        <p class="mb-1"><strong>Descrição:</strong> <?= $event->description; ?></p>
                        <p class="mb-1"><strong>Data / Início:</strong> <?= date_fmt($event->date_event, "d/m/Y H:i"); ?></p>
                        <p class="mb-0"><strong>Local:</strong> <?= $event->church()->church_name;?> - <?=$event->location_text; ?></p>
                    </div>

                    <!-- QR Code -->
                    <div class="p-3 bg-light rounded-4 shadow-sm mb-4">
                        <?php if (!empty($qrCodeSvg)): ?>
                            
                                <?= $qrCodeSvg; ?>
                            
                                <p class="text-muted m-3">Escaneie este código para realizar o check-in no evento.</p>
                    
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                Não foi possível gerar o QR Code para este participante.
                            </div>
                        <?php endif; ?>
                    </div>

                    <?= button([
                        "href" => "/app/eventos/meus-eventos-agendados",
                        "name" => " Voltar para Meus Eventos",
                        "icon" => "arrow-left",
                        "btncolor" => "secondary"
                    ]); ?>

                </div>
            </div>

        </div>
    </div>
</div>
