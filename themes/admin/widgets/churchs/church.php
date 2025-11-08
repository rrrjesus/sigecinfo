<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$church): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="churchCreate" novalidate action="<?= url("/painel/igrejas/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="churchUpdate" novalidate action="<?= url("/painel/igrejas/editar/{$church->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <!-- Church Info Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold bg-<?=CONF_APP_COLOR?> text-white"><i class="bi bi-house-door me-1"></i> Informações da Igreja</div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-1 mb-md-0">
                                    <?php
                                    $fullImageLink = ($church && $church->photo())
                                        ? url(CONF_UPLOAD_DIR . "/" . $user->photo())
                                        : theme('/assets/images/avatar-ccb.jpg', CONF_VIEW_ADMIN);
                                    ?>
                                    <a href="<?= $fullImageLink; ?>" target="_blank" title="Ver imagem completa">
                                        <?= userPhoto($church->photo ?? null, 120, 120, 'avatar-ccb.jpg'); ?>
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-7 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="church_name"><strong>Nome da Igreja ou Local</strong></label>
                                            <input type="text" id="church_name" name="church_name" class="form-control form-control-sm" value="<?= $church->church_name ?? ''; ?>" required>
                                        </div>
                                        <div class="col-md-5 mb-1">
                                            <label for="photo" class="col-form-label col-form-label-sm"><strong><i class="bi bi-upload me-1"></i> Nova Foto</strong> (Opcional)</label>
                                            <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" id="photo" name="photo">
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="country_id"><strong>País</strong></label>
                                            <input type="text" id="country_id" name="country_id" class="form-control form-control-sm mask-country" value="<?= $church->country_id ?? 'BR'; ?>">
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="code_id"><strong>Código</strong></label>
                                            <input type="text" id="code_id" name="code_id" class="form-control form-control-sm mask-code" value="<?= $church->code_id ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address and Contact Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-geo-alt me-1"></i> Endereço e Contato</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="zip_code"><strong>CEP</strong></label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control form-control-sm mask-zip-code" value="<?= $church->zip_code ?? ''; ?>">
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="address"><strong>Endereço</strong></label>
                                    <input type="text" id="address" name="address" class="form-control form-control-sm" value="<?= $church->address ?? ''; ?>">
                                </div>
                                <div class="col-md-2 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="address_number"><strong>Número</strong></label>
                                    <input type="text" id="address_number" name="address_number" class="form-control form-control-sm" value="<?= $church->address_number ?? ''; ?>">
                                </div>
                                <div class="col-md-5 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="city"><strong>Cidade</strong></label>
                                    <input type="text" id="city" name="city" class="form-control form-control-sm" value="<?= $church->city ?? 'São Paulo'; ?>">
                                </div>
                                <div class="col-md-2 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="state"><strong>Estado</strong></label>
                                    <input type="text" id="state" name="state" class="form-control form-control-sm mask-state" value="<?= $church->state ?? 'SP'; ?>">
                                </div>
                                <div class="col-md-5 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="phone"><strong>Celular</strong></label>
                                    <input type="text" id="phone" name="phone" class="form-control form-control-sm mask-phone" value="<?= $church->phone ?? ''; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="observations" class="col-form-label col-form-label-sm"><strong>Observações</strong></label>
                                    <textarea id="observations" name="observations" class="form-control form-control-sm" rows="2"><?= $church->observations ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center mb-3">
                                <?= button(["type" => "submit", "title" => ($church ? "Atualizar dados da Igreja" : "Registrar uma nova igreja"), "custom" => "custom-tooltip-secondary", "name" => ($church ? "Atualizar" : "Registrar"), "icon" => "check-circle me-1", "btncolor" => ($church ? "primary" : "success")]); ?>
                                <?= button(["href" => "/painel/igrejas", "title" => "Listar uma nova igreja", "custom" => "custom-tooltip-secondary", "name" => "Listar", "icon" => "list me-1", "btncolor" => "secondary"]); ?>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
<script>
    $(document).ready(function() {
        // Script for image preview
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
