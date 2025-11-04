<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Eventos Finalizados</h6>
                    <div>
                        <?= button(["href" => "/app/eventos/eventos", "name" => "Voltar", "icon" => "calendar-plus", "btncolor" => "danger"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="listEventsDisableds" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Fim</th>
                                    <th class="text-center"><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Dependências</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
