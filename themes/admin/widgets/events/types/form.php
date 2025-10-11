<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$eventType): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="eventTypeCreate" novalidate action="<?= url("/painel/tipos-de-eventos/cadastrar"); ?>" method="post">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="eventTypeUpdate" novalidate action="<?= url("/painel/tipos-de-eventos/editar/{$eventType->id}"); ?>" method="post">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="card">
                        <div class="card-header fw-bold">
                            <i class="bi bi-tags me-1"></i> <?= ($eventType ? "Editar Tipo de Evento" : "Novo Tipo de Evento"); ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-<?= ($eventType ? "9" : "12"); ?> mb-3">
                                    <label for="name" class="col-form-label col-form-label-sm"><strong>Nome do Tipo de Evento</strong></label>
                                    <input type="text" id="name" name="name" class="form-control form-control-sm" value="<?= $eventType->name ?? ''; ?>" required>
                                </div>
                                <?php if ($eventType): ?>
                                <div class="col-md-3 mb-3">
                                    <label for="status" class="col-form-label col-form-label-sm"><strong>Status</strong></label>
                                    <select name="status" id="status" class="form-select form-select-sm">
                                        <option value="actived" <?= ($eventType->status == 'actived' ? "selected" : ""); ?>>Ativo</option>
                                        <option value="disabled" <?= ($eventType->status == 'disabled' ? "selected" : ""); ?>>Inativo</option>
                                    </select>
                                </div>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <label for="description" class="col-form-label col-form-label-sm"><strong>Descrição</strong> (Opcional)</label>
                                    <textarea id="description" name="description" class="form-control form-control-sm" rows="3"><?= $eventType->description ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <?= button(["type" => "submit", "name" => ($eventType ? "Atualizar" : "Registrar"), "icon" => "check-circle", "btncolor" => ($eventType ? "primary" : "success")]); ?>
                            <?= button(["href" => "/painel/tipos-de-eventos", "name" => "Listar", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>