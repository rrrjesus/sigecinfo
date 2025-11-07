<?php $this->layout("_app"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex justify-content-between align-items-center fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Eventos do Sistema</h6>
                    <div>
                        <?= button(
                            ["href" => "/app/eventos/cadastrar", "title" => "Cadastrar Eventos", "custom" => "custom-tooltip-secondary", "name" => "Cadastrar Eventos", "icon" => "calendar-plus me-2", "class" => "","btncolor" => "light"]); ?>
                        <?php if (!empty($registers->disabled)) : ?> 
                            <?= button(["href" => "/app/eventos/desativados", "name" => "Eventos Inativos", "icon" => "calendar-plus", "btncolor" => "secondary", "disabled_count" => $registers->disabled, "title" => "Ver eventos desativados", "custom" => "custom-tooltip-secondary"]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="listEvents" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                                    <th><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                                    <th><i class="bi bi-bookmark-star me-2"></i>Tipo</th>
                                    <th><i class="bi bi-geo-alt me-2"></i>Local</th>
                                    <th><i class="bi bi-pencil-square me-2"></i>Detalhes</th>
                                    <th><i class="bi bi-trash me-2"></i>Ações</th>
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
