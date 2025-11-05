<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event-fill me-2"></i>Eventos Desativados</h6>
                    <div>
                        <?= button(["href" => "/app/eventos", "name" => "Voltar para Eventos", "icon" => "calendar", "btncolor" => "secondary"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="disabledEvents" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th class="text-center"><i class="bi bi-card-heading me-2"></i>Ver</th>
                                    <th class="text-center"><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Término</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>