<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-calendar-event me-2"></i>Tipos de Evento</h6>
                    <div>
                        <?= button(["href" => "/painel/tipos-de-eventos/cadastrar", "title" => "Cadastrar novo tipo do evento", "custom" => "custom-tooltip-secondary","name" => "Cadastrar", "icon" => "plus-circle me-1", "btncolor" => "primary"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/tipos-de-eventos/desativados", "title" => "Tipos de eventos desativados", "custom" => "custom-tooltip-secondary", "name" => "Eventos Inativos", "icon" => "calendar-plus me-1", "btncolor" => "light", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="eventTypes" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Editar</th>
                                    <th class="text-center"><i class="bi bi-person-vcard me-2"></i>Nome</th>
                                    <th class="text-center"><i class="bi bi-card-text me-2"></i>Descrição</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-eye-slash me-2"></i>Desativar</th>
                                    <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php if (!empty($eventTypes)): foreach ($eventTypes as $type): ?>
                                    <tr>
                                        <td class="text-center fw-semibold"><?= $type->name; ?></td>
                                        <td><?= $type->description; ?></td>
                                        <td class="text-center"><?= statusBadge($type->status); ?></td>
                                        <td class="text-center"><?= $type->id; // Para o botão Editar ?></td>
                                        <td class="text-center"><?= $type->id; // Para o botão Desativar ?></td>
                                        <td class="text-center"><?= $type->id; // Para o botão Excluir ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
