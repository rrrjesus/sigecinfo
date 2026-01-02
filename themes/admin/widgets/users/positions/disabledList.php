<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0"><i class="bi bi-archive me-2"></i>Cargos e Ministérios Desativados</h6>
                    <div>
                        <?= button(["href" => url()."/painel/cargos", "name" => "Voltar", "icon" => "arrow-left", "btncolor" => "secondary"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="userspositionsDisabled" class="table table-striped table-sm table-hover dt-responsive" style="width:100%">
                            <thead class="table-danger">
                                <tr class="text-center">
                                    <th>Cargo</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th>Ativar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-center">
                                <?php if (!empty($userspositions)) : foreach ($userspositions as $lista) : ?>
                                    <tr>
                                        <td><?= $lista->position_name ?? ''; ?></td>
                                        <td><?= $lista->description ?? ''; ?></td>
                                        <td><?= statusBadge($lista->status); ?></td>
                                        <td class="text-center"><?= $lista->id; ?></td>
                                        <td class="text-center"><?= $lista->id; ?></td>
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