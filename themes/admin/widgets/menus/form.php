<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$menu): // CREATE MODE ?>
                <form class="needs-validation" id="menuCreate" novalidate action="<?= url("/painel/menus/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // EDIT MODE ?>
                <form class="needs-validation" id="menuUpdate" novalidate action="<?= url("/painel/menus/editar/{$menu->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-list me-1"></i> Informações do Menu</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="name"><strong>Nome do Menu</strong></label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?= $menu->name ?? ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="menu_order"><strong>Ordem</strong></label>
                                    <input type="number" id="menu_order" name="menu_order" class="form-control" value="<?= $menu->menu_order ?? '0'; ?>" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="icon"><strong>Ícone</strong> (ex: <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>)</label>
                                    <input type="text" id="icon" name="icon" class="form-control" placeholder="bi bi-list" value="<?= $menu->icon ?? ''; ?>">
                                    <div class="form-text">Cole a classe completa do ícone. Ex: <code>bi bi-house-door</code></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <?= button(["type" => "submit", "name" => ($menu ? "Atualizar" : "Cadastrar"), "icon" => "check-circle", "btncolor" => ($menu ? "primary" : "success")]); ?>
                            <?= button(["href" => url()."/painel/menus", "name" => "Voltar", "icon" => "arrow-left", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
