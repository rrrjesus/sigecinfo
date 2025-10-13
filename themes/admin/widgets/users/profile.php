<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>
            <form class="needs-validation" id="profileUpdate" novalidate action="<?= url("/painel/perfil"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="profile" />
                <?= csrf_input(); ?>

                <!-- User Info Card -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-person-circle me-1"></i> Informações do Perfil
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <?php
                                $fullImageLink = ($profile && $profile->photo())
                                    ? url(CONF_UPLOAD_DIR . "/" . $profile->photo())
                                    : theme('/assets/images/avatar.jpg', CONF_VIEW_ADMIN);
                                ?>
                                <a href="<?= $fullImageLink; ?>" target="_blank" title="Ver imagem completa">
                                    <?= userPhoto($profile->photo ?? null, 120, 120, 'rounded-circle j_profile_image'); ?>
                                </a>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-7 mb-3">
                                        <label for="user_name" class="col-form-label col-form-label-sm"><strong>Nome Completo</strong></label>
                                        <input type="text" id="user_name" name="user_name" class="form-control form-control-sm" value="<?= $profile->user_name ?>" required>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label for="photo" class="col-form-label col-form-label-sm"><strong><i class="bi bi-upload me-1"></i> Nova Foto</strong> (Opcional)</label>
                                        <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" id="photo" name="photo">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="col-form-label col-form-label-sm"><strong>E-mail</strong></label>
                                        <input type="email" id="email" name="email" class="form-control form-control-sm" value="<?= $profile->email ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact and Password Card -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-telephone-plus me-1"></i> Contato & Segurança
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_mobile" class="col-form-label col-form-label-sm"><strong>Celular</strong></label>
                                <input type="text" id="phone_mobile" name="phone_mobile" class="form-control form-control-sm mask-cell-phone" placeholder="(00) 00000-0000" value="<?= $profile->phone_mobile ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone_landline" class="col-form-label col-form-label-sm"><strong>Telefone Fixo</strong></label>
                                <input type="text" id="phone_landline" name="phone_landline" class="form-control form-control-sm mask-fixed-phone" placeholder="(00) 0000-0000" value="<?= $profile->phone_landline ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="col-form-label col-form-label-sm"><strong>Nova Senha</strong> (Deixe em branco para não alterar)</label>
                                <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password" placeholder="********">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_re" class="col-form-label col-form-label-sm"><strong>Repetir Nova Senha</strong></label>
                                <input type="password" id="password_re" name="password_re" class="form-control form-control-sm" autocomplete="new-password" placeholder="********">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Card (Read-Only) -->
                <div class="card mb-4">
                    <div class="card-header fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Informações Adicionais (Apenas Leitura)
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label col-form-label-sm"><strong>Cargo/Ministério</strong></label>
                                <input type="text" class="form-control form-control-sm" value="<?= $profile->position()->position_name ?? 'Não definido'; ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label col-form-label-sm"><strong>Igreja</strong></label>
                                <input type="text" class="form-control form-control-sm" value="<?= $profile->church()->church_name ?? 'Não definida'; ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label col-form-label-sm"><strong>Nível de Acesso</strong></label>
                                <input type="text" class="form-control form-control-sm" value="<?= $profile->level()->level_name ?? 'Não definido'; ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label col-form-label-sm"><strong>Status</strong></label>
                                <input type="text" class="form-control form-control-sm" value="<?= status_name($profile->status); ?>" readonly>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="col-form-label col-form-label-sm"><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" rows="1" readonly><?= $profile->observations ?? 'Nenhuma observação.'; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <?= button(["type" => "submit", "name" => "Atualizar", "icon" => "check-circle", "btncolor" => "primary"]); ?>
                        <?= button(["href" => "/painel/controle", "name" => "Voltar", "icon" => "arrow-left", "btncolor" => "secondary"]); ?>
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

        $("#profileUpdate").validate({
            rules: {
                user_name: { required: true },
                email: { required: true, email: true },
                password: { valsenha: true },
                password_re: { equalTo: "#password" }
            },
            messages: {
                user_name: { required: "O nome é obrigatório." },
                email: { required: "O e-mail é obrigatório.", email: "Digite um e-mail válido." },
                password_re: { equalTo: "As senhas não correspondem." }
            }
        });
    });
</script>
<?php $this->end(); ?>
