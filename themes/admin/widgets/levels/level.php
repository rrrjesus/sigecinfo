<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$level): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="levelCreate" novalidate action="<?= url("/painel/niveis/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="levelUpdate" novalidate action="<?= url("/painel/niveis/editar/{$level->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <!-- Level Info Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-bar-chart-steps me-1"></i> Informações do Nível de Acesso</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="level_name"><strong>Nome do Nível</strong></label>
                                    <input type="text" id="level_name" name="level_name" class="form-control form-control-sm" value="<?= $level->level_name ?? ''; ?>" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="col-form-label col-form-label-sm"><strong>Descrição</strong></label>
                                    <textarea id="description" name="description" class="form-control form-control-sm" rows="3"><?= $level->description ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save me-2"></i>Salvar</button>
                            <a href="<?= url("/painel/niveis"); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg me-2"></i>Cancelar</a>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
