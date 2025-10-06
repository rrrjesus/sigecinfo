<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$user): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="user" novalidate action="<?= url("/painel/usuarios/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="user" novalidate action="<?= url("/painel/usuarios/editar/{$user->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="row mb-1 mt-3">

                        <div class="col-md-1 mb-1 app_formbox_photo">
                            <?php
                            // Lógica para o link <a> que abre a imagem completa
                            $fullImageLink = ($user && $user->photo())
                                ? url(CONF_UPLOAD_DIR . "/" . $user->photo())
                                : theme('/assets/images/avatar.jpg', CONF_VIEW_ADMIN);
                            ?>
                            <a href="<?= $fullImageLink; ?>" target="_blank">
                                <?= userPhoto($user->photo ?? null, 100, 100, 'avatar.jpg'); ?>
                            </a>
                        </div>

                         <div class="col-md-4 mb-1">
                            <label for="photo" class="col-form-label col-form-label-md"> <strong><i class="bi bi-upload me-1"></i>.bmp ,.png, .svg, .jpeg e .jpg</strong> (Opcional)</label>
                             <input class="form-control form-control-md" data-image=".j_profile_image" type="file" id="photo" class="radius" name="photo" data-bs-toggle-tooltip="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-dark" data-bs-title="Clique para carregar o arquivo">
                        </div>

                        <div class="col-md-4 mb-1">
                            <label class="col-form-label col-form-label-md" for="user_name"><strong><i class="bi bi-person me-1"></i> Nome Completo</strong></label>
                            <input type="text" id="user_name" name="user_name" class="form-control form-control-md" value="<?= $user->user_name ?? ''; ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label class="col-form-label col-form-label-md" for="email"><strong><i class="bi bi-envelope-at me-1"></i> Email</strong></label>
                            <input type="email" id="email" name="email" class="form-control form-control-md" value="<?= $user->email ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-md-3 mb-1">
                            <label class="col-form-label col-form-label-md" for="level_id"><strong><i class="bi bi-building ms-3 me-1"></i> Nível de Acesso</strong></label>
                             <select id="level_id" name="level_id" class="form-select form-select-md" required>
                                <option value="">Selecione um nível...</option>
                                 <?php if (!empty($levels)): foreach ($levels as $level): ?>
                                    <option value="<?= $level->id; ?>" <?= !empty($user) && $user->level_id == $level->id ? 'selected' : ''; ?>><?= $level->level_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="col-form-label col-form-label-md" for="password"><strong><i class="bi bi-lock me-1"></i> Senha</strong> <?= (!$user ? '<small>(Obrigatória no registo)</small>' : '<small>(Edite só para alteração)</small>'); ?></label>
                            <input type="password" id="password" name="password" value="Mudar12345?!" class="form-control form-control-md" autocomplete="new-password" data-bs-toggle-tooltip="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-dark" data-bs-title="Padrão : Mudar12345?!">
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="col-form-label col-form-label-md" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                            <input type="text" id="phone_mobile" name="phone_mobile" class="form-control form-control-md mask-cell-phone" value="<?= $user->phone_mobile ?? ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label col-form-label-md" for="phone_landline"><strong><i class="bi bi-phone me-1"></i> Telefone Fixo</strong> (Opcional)</label>
                            <input type="text" id="phone_landline" name="phone_landline" class="form-control form-control-md mask-fixed-phone" value="<?= $user->phone_landline ?? ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-md-4 mb-1">
                            <label class="col-form-label col-form-label-md" for="church_id"><i class="bi bi-person-add me-1"></i><strong>Igreja</strong></label>
                            <select id="church_id" name="church_id" class="form-select form-select-md" required>
                                <option value="">Selecione uma igreja...</option>
                                <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                    <option value="<?= $church->id; ?>" <?= !empty($user) && $user->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                         <div class="col-md-4 mb-1">
                            <label class="col-form-label col-form-label-md" for="position_id"><strong><i class="bi bi-person-add me-1"></i> Cargo/Ministério</strong></label>
                            <select id="position_id" name="position_id" class="form-select form-select-md" required>
                                <option value="">Selecione um cargo...</option>
                                 <?php if (!empty($positions)): foreach ($positions as $position): ?>
                                    <option value="<?= $position->id; ?>" <?= !empty($user) && $user->position_id == $position->id ? 'selected' : ''; ?>><?= $position->position_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <?php if ($user): ?>
                            <div class="col-md-4">
                                <label class="col-form-label col-form-label-md" for="status"><strong><i class="bi bi-person-add me-1"></i> Status</strong></label>
                                <select name="status" id="status" class="form-select form-select-md">
                                    <?= user_status_options($user->status); ?>
                                </select>
                            </div>
                        <?php endif; ?>

                    </div>



                    <div class="row mb-1">
                         <div class="col-md-12 mb-1">
                            <label for="textareaObservacoes" class="col-form-label col-form-label-md"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                            <textarea id="observations" name="observations" class="form-control form-control-md" rows="2"><?= $user->observations ?? ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center mt-4 mb-4">
                        <div class="col-auto">
                            <?= button(["name" => ($user ? "Gravar" : "Registar Utilizador"), "icon" => "check-circle", "btncolor" => "success"]); ?>
                            <?= button(["href" => "/painel/usuarios", "name" => "Listar", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>