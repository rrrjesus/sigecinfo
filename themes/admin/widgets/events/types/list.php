<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 ajax_response">
            <?= flash(); ?>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?= button(["href" => "/painel/tipos-de-eventos/cadastrar", "name" => "Registar Novo Tipo", "icon" => "plus-circle"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="eventTypes" class="table table-bordered table-sm table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">Nome do Tipo</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($eventTypes)): ?>
                        <?php foreach ($eventTypes as $type): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $type->name; ?></td>
                                <td><?= $type->description; ?></td>
                                <td class="text-center">
                                    <a href="<?= url("/painel/tipos-de-eventos/editar/{$type->id}"); ?>" class="btn btn-sm btn-outline-warning rounded-circle" data-bs-toggle-tooltip="tooltip" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form class="d-inline" action="<?= url("/painel/tipos-de-eventos/excluir"); ?>" method="post">
                                        <input type="hidden" name="type_id" value="<?= $type->id; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" data-bs-toggle-tooltip="tooltip" title="Excluir" onclick="return confirm('Tem a certeza de que deseja excluir este tipo de evento?');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>