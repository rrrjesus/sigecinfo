<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-<?=CONF_ADMIN_COLOR?> text-white">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Tipos de Evento</h6>
                    <div>
                        <?= button(["href" => "/painel/tipos-de-eventos", "title" => "Voltar aos tipos de evento", "custom" => "custom-tooltip-secondary","name" => "Voltar", "icon" => "arrow-left-circle me-1", "btncolor" => "light"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="disabledEventTypes" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th class="text-center">Nome do Tipo</th>
                                    <th>Descrição</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Editar</th>
                                    <th class="text-center">Ativar</th>
                                    <th class="text-center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php if (!empty($eventTypes)): foreach ($eventTypes as $type): ?>
                                    <tr class="fw-semibold">
                                        <td><?= $type->name; ?></td>
                                        <td class="text-start"><?= $type->description; ?></td>
                                        <td class="text-center"><?= statusBadge($type->status); ?></td>
                                        <td><?= $type->id; // Para o botão Editar ?></td>
                                        <td><?= $type->id; // Para o botão Ativar ?></td>
                                        <td><?= $type->id; // Para o botão Excluir ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
</div>