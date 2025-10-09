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
                        <?= button(["href" => "/painel/cargos", "name" => "Voltar", "icon" => "arrow-left", "btncolor" => "secondary"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="userspositionsDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th class="text-center">Cargo</th>
                                    <th class="text-center">Descrição</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Ativar</th>
                                    <th class="text-center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($userspositions)) : foreach ($userspositions as $lista) : ?>
                                    <tr>
                                        <td class="text-center fw-semibold"><?= $lista->position_name ?? ''; ?></td>
                                        <td class="text-center fw-semibold"><?= $lista->description ?? ''; ?></td>
                                        <td class="text-center fw-semibold"><?= statusBadge($lista->status); ?></td>
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