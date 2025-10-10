<?php $this->layout("_admin"); ?>

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
                        <?= button(["href" => "/painel/eventos/cadastrar", "name" => "Registar Novo Evento", "icon" => "calendar-plus"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/eventos/desativados", "name" => "Desativados", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="events" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Editar</th>
                                    <th class="text-center"><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th class="text-center"><i class="bi bi-bookmark-star me-2"></i>Tipo</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Local</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-toggle-on me-2"></i>Desativar</th>
                                    <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
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
