<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Eventos do Sistema</h6>
                    <div>
                        <?= button(["href" => "/app/eventos/cadastrar", "name" => "Cadastrar", "icon" => "calendar-plus"]); ?>
                        <?php if (!empty($registers->inativo)) : ?>
                            <?= button(["href" => "/app/eventos/desativados", "name" => "Desativados", "btncolor" => "secondary", "icon" => "arrow-return-left m-1", "disabled_count" => $registers->inativo]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="listEvents" class="table table-striped table-sm table-hover dt-responsive" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th><i class="bi bi-pencil-square me-2"></i>Detalhes</th>
                                    <th><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th><i class="bi bi-bookmark-star me-2"></i>Tipo</th>
                                    <th><i class="bi bi-geo-alt me-2"></i>Local</th>
                                    <th><i class="bi bi-trash me-2"></i>Ações</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
