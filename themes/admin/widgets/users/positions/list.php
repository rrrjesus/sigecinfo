<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0"><i class="bi bi-briefcase me-2"></i>Cargos e Ministérios</h6>
                    <div>
                        <?= button(["href" => "/painel/cargos/cadastrar", "accesskey" => "c", "title" => "Clique para cadastrar novo cargo", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/cargos/desativados", "accesskey" => "d", "title" => "Clique para listar cargos desativados", "name" => "Desativados", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="userspositions" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th class="text-center">Editar</th>
                                    <th class="text-center">Ministério/Cargo</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Desativar</th>
                                    <th class="text-center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($userspositions)) : foreach ($userspositions as $lista) : ?>
                                    <tr class="text-center fw-semibold">
                                        <td><a href="cargos/editar/<?= $lista->id ?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" data-bs-title="Clique para editar <?= $lista->position_name ?>" role="button" class="btn btn-outline-warning rounded-circle btn-sm text-center"><i class="bi bi-pencil text-secondary"></i></a></td>
                                        <td><?= $lista->position_name; ?></td>
                                        <td><?= $lista->description; ?></td>
                                        <td><?= statusBadge($lista->status); ?></td>
                                        <td><?= $lista->id; ?></td>
                                        <td><?= $lista->id; ?></td>
                                    </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>