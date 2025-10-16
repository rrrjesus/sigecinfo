<?php $this->layout("_beta"); ?>

<!-- Breadcrumb -->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="ajax_response mb-3"><?= flash(); ?></div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-calendar-event me-2"></i>Eventos Finalizados
            </h5>
            
            <?= button([
                "href" => "/beta/eventos",
                "name" => "Voltar para Eventos",
                "icon" => "arrow-left",
                "btncolor" => "secondary"
            ]); ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="listEventsDisableds" class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th scope="col"><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                            <th scope="col"><i class="bi bi-calendar-check me-2"></i>Data de Fim</th>
                            <th scope="col"><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                            <th scope="col"><i class="bi bi-star me-2"></i>Tipo</th>
                            <th scope="col"><i class="bi bi-geo-alt me-2"></i>Local</th>
                            <th scope="col"><i class="bi bi-building me-2"></i>Dependências</th>
                            <th scope="col"><i class="bi bi-check-circle me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados serão inseridos via JS/DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
