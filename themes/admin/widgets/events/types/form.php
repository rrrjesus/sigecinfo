<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$eventType): // MODO DE CRIAÇÃO ?>
                <form id="eventTypeForm" novalidate action="<?= url("/painel/tipos-de-eventos/cadastrar"); ?>" method="post">
                    <input type="hidden" name="action" value="create"/>
                    <?= csrf_input(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label"><strong>Nome do Tipo de Evento</strong></label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label"><strong>Descrição</strong></label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <?= button(["name" => "Registar Tipo", "icon" => "check-circle", "btncolor" => "success"]); ?>
                            <?= button(["href" => "/painel/tipos-de-eventos", "name" => "Listar Todos", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
            <?php else: // MODO DE EDIÇÃO ?>
                <form id="eventTypeForm" novalidate action="<?= url("/painel/tipos-de-eventos/editar/{$eventType->id}"); ?>" method="post">
                    <input type="hidden" name="action" value="update"/>
                    <?= csrf_input(); ?>

                    <div class="row mb-3">
                        <div class="col-md-9">
                            <label for="name" class="form-label"><strong>Nome do Tipo de Evento</strong></label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= $eventType->name; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label"><strong>Status</strong></label>
                            <select name="status" id="status" class="form-select">
                                <option value="actived" <?= ($eventType->status == 'actived' ? "selected" : ""); ?>>Ativo</option>
                                <option value="disabled" <?= ($eventType->status == 'disabled' ? "selected" : ""); ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label"><strong>Descrição</strong></label>
                            <textarea id="description" name="description" class="form-control" rows="3"><?= $eventType->description; ?></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <?= button(["name" => "Atualizar Dados", "icon" => "check-circle", "btncolor" => "primary"]); ?>
                            <?= button(["href" => "/painel/tipos-de-eventos", "name" => "Listar Todos", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>