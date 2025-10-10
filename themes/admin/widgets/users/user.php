<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$user): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="userCreate" novalidate action="<?= url("/painel/usuarios/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="userUpdate" novalidate action="<?= url("/painel/usuarios/editar/{$user->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <!-- User Info Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-person-circle me-1"></i> Informações do Usuário</div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-1 mb-md-0">
                                    <?php
                                    $fullImageLink = ($user && $user->photo())
                                        ? url(CONF_UPLOAD_DIR . "/" . $user->photo())
                                        : theme('/assets/images/avatar.jpg', CONF_VIEW_ADMIN);
                                    ?>
                                    <a href="<?= $fullImageLink; ?>" target="_blank" title="Ver imagem completa">
                                        <?= userPhoto($user->photo ?? null, 120, 120, 'avatar.jpg'); ?>
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-7 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="user_name"><strong>Nome Completo</strong></label>
                                            <input type="text" id="user_name" name="user_name" class="form-control form-control-sm" value="<?= $user->user_name ?? ''; ?>" required>
                                        </div>
                                        <div class="col-md-5 mb-1">
                                            <label for="photo" class="col-form-label col-form-label-sm"><strong><i class="bi bi-upload me-1"></i> Nova Foto</strong> (Opcional)</label>
                                            <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" id="photo" name="photo">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="col-form-label col-form-label-sm" for="email"><strong>E-mail</strong></label>
                                            <input type="email" id="email" name="email" class="form-control form-control-sm" value="<?= $user->email ?? ''; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Access and Security Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-shield-lock me-1"></i> Acesso e Segurança</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="level_id"><strong>Nível de Acesso</strong></label>
                                    <select id="level_id" name="level_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione um nível...</option>
                                        <?php if (!empty($levels)): foreach ($levels as $level): ?>
                                            <option value="<?= $level->id; ?>" <?= !empty($user) && $user->level_id == $level->id ? 'selected' : ''; ?>><?= $level->level_name; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="password"><strong>Senha</strong> <?= (!$user ? '<small>(Padrão)</small>' : '<small>(Preencha para alterar)</small>'); ?></label>
                                    <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password"
                                           data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark"
                                           data-bs-title="Padrão: Mudar123?!" value="<?= (!$user ? 'Mudar123?!' : ''); ?>">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="password_re"><strong>Repetir Senha</strong></label>
                                    <input type="password" id="password_re" name="password_re" class="form-control form-control-sm" autocomplete="new-password"
                                           data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark"
                                           data-bs-title="Repita a senha" value="<?= (!$user ? 'Mudar123?!' : ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-info-circle me-1"></i> Detalhes Adicionais</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="church_id"><strong>Igreja</strong></label>
                                    <select id="church_id" name="church_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione uma igreja...</option>
                                        <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                            <option value="<?= $church->id; ?>" <?= !empty($user) && $user->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="position_id"><strong>Cargo/Ministério</strong></label>
                                    <select id="position_id" name="position_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione um cargo...</option>
                                        <?php if (!empty($positions)): foreach ($positions as $position): ?>
                                            <option value="<?= $position->id; ?>" <?= !empty($user) && $user->position_id == $position->id ? 'selected' : ''; ?>><?= $position->position_name; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="phone_mobile"><strong>Celular</strong> (Opcional)</label>
                                    <input type="text" id="phone_mobile" name="phone_mobile" class="form-control form-control-sm mask-cell-phone" value="<?= $user->phone_mobile ?? ''; ?>">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="phone_landline"><strong>Telefone Fixo</strong> (Opcional)</label>
                                    <input type="text" id="phone_landline" name="phone_landline" class="form-control form-control-sm mask-fixed-phone" value="<?= $user->phone_landline ?? ''; ?>">
                                </div>
                                <?php if ($user): ?>
                                    <div class="col-md-4 mb-1">
                                        <label class="col-form-label col-form-label-sm" for="status"><strong>Status</strong></label>
                                        <select name="status" id="status" class="form-select form-select-sm">
                                            <?= user_status_options($user->status); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-12">
                                    <label for="observations" class="col-form-label col-form-label-sm"><strong>Observações</strong></label>
                                    <textarea id="observations" name="observations" class="form-control form-control-sm" rows="2"><?= $user->observations ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <?= button(["type" => "submit", "name" => ($user ? "Atualizar" : "Registrar"), "icon" => "check-circle", "btncolor" => ($user ? "primary" : "success")]); ?>
                            <?= button(["href" => "/painel/usuarios", "name" => "Listar", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
<script>
    $(document).ready(function() {
        // Script para preview da imagem
        $('body').on('change', 'input[data-image]', function (e) {
            var input = $(this);
            var target = $(input.data("image"));
            var file = e.target.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    target.css("background-image", "url(" + e.target.result + ")");
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
<?php $this->end(); ?>