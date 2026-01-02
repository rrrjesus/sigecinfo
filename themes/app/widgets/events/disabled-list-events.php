<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex justify-content-between align-items-center fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Eventos Finalizados</h6>
                    <div>
                        <?= button(["href" => url("/app/eventos"), "name" => "Voltar", "icon" => "arrow-return-left m-1", "btncolor" => "light", "title" => "Voltar para a lista de eventos", "custom" => "custom-tooltip-secondary"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                         <?php if (empty($events)): ?>
                            <div class="alert alert-primary text-center fw-semibold" role="alert">Você ainda não tem nenhum evento finalizado.</div>
                        <?php else: ?>
                        <table id="listEventsDisableds" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr class="text-center">
                                    <th><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th><i class="bi bi-calendar-check me-2"></i>Data de Fim</th>
                                    <th><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th><i class="bi bi-bookmark-star me-2"></i>Tipo</th>
                                    <th><i class="bi bi-bookmark-star me-2"></i>Local</th>
                                    <th><i class="bi bi-geo-alt me-2"></i>Dependências</th>
                                    <th><i class="bi bi-check-circle me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
