<?php $this->layout("_admin"); ?>
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row justify-content-center"><div class="col-12 ajax_response"><?= flash(); ?></div></div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?= button(["href" => "/painel/tipos-de-eventos", "name" => "Voltar", "icon" => "arrow-left-circle", "btncolor" => "secondary"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center"><div class="col-12">
        <table id="disabledEventTypes" class="table table-bordered table-sm table-hover" style="width:100%">
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
            <tbody>
                 <?php if (!empty($eventTypes)): foreach ($eventTypes as $type): ?>
                    <tr>
                        <td class="text-center fw-semibold"><?= $type->name; ?></td>
                        <td><?= $type->description; ?></td>
                        <td class="text-center"><?= statusBadge($type->status); ?></td>
                        <td><?= $type->id; // Para o botão Editar ?></td>
                        <td><?= $type->id; // Para o botão Ativar ?></td>
                        <td><?= $type->id; // Para o botão Excluir ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div></div>
</div>