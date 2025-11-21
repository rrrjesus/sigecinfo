<?php $this->layout("_admin"); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><i class="bi bi-shield-check me-2"></i>Matriz de Controle de Acesso (ACL)</h4>
            </div>
            <div class="card-body">
                <div class="ajax_response"><?= flash(); ?></div>
                <p>Marque as caixas para conceder a um <strong>Nível de Usuário</strong> a <strong>Permissão</strong> para realizar uma ação. As alterações são salvas para todos os níveis de uma vez.</p>

                <form class="needs-validation" id="aclSave" novalidate action="<?= url("/painel/acl/salvar"); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_input(); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover small">
                            <thead>
                                <tr class="text-center">
                                    <th class="bg-light">Nível de Usuário</th>
                                    <?php foreach ($modules as $module): ?>
                                        <th colspan="<?= count(array_filter($permissions, fn($p) => $p->module_id == $module->id)); ?>" class="bg-light"><?= $module->name; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr class="text-center">
                                    <th class="bg-light"></th>
                                    <?php foreach ($modules as $module): ?>
                                        <?php foreach ($permissions as $permission): ?>
                                            <?php if ($permission->module_id == $module->id): ?>
                                                <th style="writing-mode: vertical-rl; text-orientation: mixed;"><?= $permission->description; ?></th>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($levels as $level): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $level->level_name; ?></td>
                                        <?php foreach ($modules as $module): ?>
                                            <?php foreach ($permissions as $permission): ?>
                                                <?php if ($permission->module_id == $module->id): ?>
                                                    <td class="text-center">
                                                        <?php // Super Admin (level 1) tem todas as permissões e não pode ser editado ?>
                                                        <?php if ($level->id == 5): ?>
                                                            <input class="form-check-input" type="checkbox" checked disabled>
                                                        <?php else: ?>
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="permissions[<?= $level->id; ?>][<?= $permission->id; ?>]"
                                                                   <?= !empty($current_permissions[$level->id][$permission->id]) ? 'checked' : ''; ?>>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Salvar Todas as Permissões</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
