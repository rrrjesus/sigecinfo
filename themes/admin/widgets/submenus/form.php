<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$submenu): // CREATE MODE ?>
                <form class="needs-validation" id="submenuCreate" novalidate action="<?= url("/painel/submenus/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // EDIT MODE ?>
                <form class="needs-validation" id="submenuUpdate" novalidate action="<?= url("/painel/submenus/editar/{$submenu->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-list-nested me-1"></i> Informações do Submenu</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="name"><strong>Nome do Submenu</strong></label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?= $submenu->name ?? ''; ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="menu_id"><strong>Menu Principal</strong></label>
                                    <select id="menu_id" name="menu_id" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($menus)): foreach ($menus as $menu): ?>
                                            <option value="<?= $menu->id; ?>" <?= !empty($submenu) && $submenu->menu_id == $menu->id ? 'selected' : ''; ?>>
                                                <?= $menu->name; ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="parent_id"><strong>Submenu Pai (Opcional)</strong></label>
                                    <select id="parent_id" name="parent_id" class="form-select">
                                        <option value="">Nenhum</option>
                                        <?php if (!empty($submenus)): foreach ($submenus as $parent): ?>
                                            <option value="<?= $parent->id; ?>" <?= !empty($submenu) && $submenu->parent_id == $parent->id ? 'selected' : ''; ?>>
                                                <?= $parent->name; ?>
                                            </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="url"><strong>URL</strong></label>
                                    <input type="text" id="url" name="url" class="form-control" placeholder="/painel/exemplo" value="<?= $submenu->url ?? ''; ?>" required>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="icon"><strong>Ícone</strong> (Opcional)</label>
                                    <input type="text" id="icon" name="icon" class="form-control" placeholder="bi bi-circle" value="<?= $submenu->icon ?? ''; ?>">
                                    <div class="form-text">Ex: <code>bi bi-circle</code>. Veja em <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.</div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="submenu_order"><strong>Ordem</strong></label>
                                    <input type="number" id="submenu_order" name="submenu_order" class="form-control" value="<?= $submenu->submenu_order ?? '0'; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <?= button(["type" => "submit", "name" => ($submenu ? "Atualizar" : "Cadastrar"), "icon" => "check-circle", "btncolor" => ($submenu ? "primary" : "success")]); ?>
                            <?= button(["href" => "/painel/submenus", "name" => "Voltar", "icon" => "arrow-left", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
