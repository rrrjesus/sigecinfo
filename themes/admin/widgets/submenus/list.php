<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-start"><i class="bi bi-list-nested me-2"></i>Submenus do Sistema</h6>
                    <div>
                        <?= button(["href" => "/painel/submenus/cadastrar", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="submenus" class="table table-bordered table-sm border-secondary table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th>Ícone</th>
                                    <th>Nome</th>
                                    <th>URL</th>
                                    <th>Menu Pai</th>
                                    <th>Submenu Pai</th>
                                    <th class="text-center">Ordem</th>
                                    <th class="text-center" style="width: 120px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($submenus)): ?>
                                    <?php foreach ($submenus as $submenu): ?>
                                        <tr>
                                            <td class="text-center"><?= $submenu->id; ?></td>
                                            <td><i class="<?= $submenu->icon; ?>"></i> (<?= $submenu->icon; ?>)</td>
                                            <td class="text-center"><?= $submenu->name; ?></td>
                                            <td><?= $submenu->url; ?></td>
                                            <td><?= $submenu->menu()->name ?? 'N/A'; ?></td>
                                            <td><?= $submenu->parent_id ? $submenu->findById($submenu->parent_id)->name : 'N/A'; ?></td>
                                            <td class="text-center"><?= $submenu->submenu_order; ?></td>
                                            <td class="text-center"><?= $submenu->id; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhum submenu cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
