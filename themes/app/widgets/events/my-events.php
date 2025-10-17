<?php $this->layout("_beta"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Meus Eventos</h6>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="myEvents" class="table table-bordered table-hover align-middle text-center mb-0" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-person-check me-2"></i>Presença</th>
                                    <th class="text-center"><i class="bi bi-calendar-event me-2"></i>Data</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Evento</th>
                                    <th class="text-center"><i class="bi bi-card-text me-2"></i>Descrição</th>
                                    <th class="text-center"><i class="bi bi-tag me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-pin-map me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Comp</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-pencil me-2"></i>Alterar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php $this->start("scripts"); ?>
<?php // A inicialização do DataTable foi removida daqui para evitar conflitos. ?>
<?php $this->end(); ?>