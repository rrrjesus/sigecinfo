<?php $this->layout("_beta"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" id="form-profile" action="<?= url("app/profile"); ?>" method="post"
                          enctype="multipart/form-data" data-id="<?= $user->id ?>">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
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
                            </div>
                            <div class="col-12 col-sm-6 col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                   value="<?= $user->user_name ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                   value="<?= $user->last_name ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?= $user->email ?>" disabled>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Nova Senha</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="Nova senha">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_re" class="form-label">Repita a Nova Senha</label>
                                            <input type="password" class="form-control" id="password_re"
                                                   name="password_re" placeholder="Repita a nova senha">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Atualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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