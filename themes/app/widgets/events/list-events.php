<?php $this->layout("_beta"); ?>

<!-- Breadcrumb -->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="ajax_response mb-3"><?= flash(); ?></div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-calendar-event me-2"></i>Eventos
            </h5>


                <div>
                    <?= button(["href" => "/beta/eventos/meus-eventos-agendados", "name" => "Agendados", "icon" => "calendar-plus", "class" => "m-2"]); ?>
                    <?php if (!empty($registers->disabled)) : ?>
                        <?= button(["href" => "/beta/eventos/meus-eventos-finalizados", "name" => "Finalizados", "icon" => "calendar-plus", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
                    <?php endif; ?>
                </div>
        </div>

        <div class="card-body">
            <div class="dt-container dt-bootstrap5">
                        <table id="listEvents" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                            <th class="text-center"><i class="bi bi-card-heading me-2"></i>Título do Evento</th>
                            <th class="text-center"><i class="bi bi-calendar-check me-2"></i>Data de Início</th>
                            <th class="text-center"><i class="bi bi-star me-2"></i>Tipo</th>
                            <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Local</th>
                            <th class="text-center"><i class="bi bi-building me-2"></i>Dependências</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- Dados serão inseridos via JS/DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
