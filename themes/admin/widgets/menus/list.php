<?php $this->layout("_admin"); ?>

<!-- Breadcrumb -->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-start"><i class="bi bi-list me-2"></i>Menus do Sistema</h6>
                    <div>
                        <?= button(["href" => "/painel/menus/cadastrar", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="menus" class="table table-bordered table-sm border-secondary table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>Ícone</th>
                                    <th class="text-center">Ordem</th>
                                    <th class="text-center" style="width: 120px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($menus)): ?>
                                    <?php foreach ($menus as $menu): ?>
                                        <tr>
                                            <td class="text-center"><?= $menu->id; ?></td>
                                            <td><?= $menu->name; ?></td>
                                            <td><i class="<?= $menu->icon; ?>"></i> (<?= $menu->icon; ?>)</td>
                                            <td class="text-center"><?= $menu->menu_order; ?></td>
                                            <td class="text-center"><?= $menu->id; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum menu cadastrado.</td>
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
