<?= $this->layout("_theme", ["head" => $head]); ?>

<div class="form-signin w-100 m-auto mt-5 p-5">

    <form class="needs-validation" novalidate id="login" action="<?= url("/entrar") ?>" method="post">

        <div class="text-center mb-1">
            <img class="mb-2" src="<?= theme("/assets/images/logo/sigecinfo-logo-v2.png") ?>" alt="Logo SIGECINFO" width="150">
        </div>

        <h1 class="h3 mb-3 fw-normal text-center">Fazer login</h1>

        <div class="ajax_response"><?= flash(); ?></div>

        <?= csrf_input(); ?>

        <label for="inputPassword" class="form-label fw-semibold"><i class="bi bi-envelope-at pe-2"></i>Email</label>

            <div class="form-floating mb-3 mt-1">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>"
                   placeholder="nome@smsub.prefeitura.sp.gov.br" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"
                   data-bs-title="Digite seu email !!!">
        </div>

        <label for="inputPassword" class="form-label fw-semibold"><i class="bi bi-lock pe-2"></i>Senha</label>
        <div class="form-floating mb-3 mt-1">
            <input type="password" name="password" id="password" class="form-control" placeholder="********"
                   data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Digite sua senha !!!">
        </div>

        <div class="form-check text-start my-2">
            <input class="form-check-input" type="checkbox" id="togglePassword">
            <label class="form-check-label text-secondary" for="togglePassword">
                Mostrar a Senha <span class="badge rounded-pill text-bg-secondary ps-2 text-white" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Selecione caso queira ver a senha" data-bs-custom-class="custom-tooltip-secondary">?</span>
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="save" id="save" <?= (!empty($cookie) ? "checked" : ""); ?>>
                <label class="form-check-label text-secondary" for="save" >Lembrar Senha <span class="badge rounded-pill text-bg-secondary ps-2 text-white" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Selecione caso queira lembrar a senha" data-bs-custom-class="custom-tooltip-secondary">?</span></label>
            </div>
            <div>
                 <a class="link-danger text-decoration-none fw-semibold text-danger" href="<?= url("/recuperar"); ?>">Esqueceu senha <span class="badge rounded-pill text-bg-danger ps-2 text-white" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Click para solicitar nova senha !!!" data-bs-custom-class="custom-tooltip-danger">?</span></a>
            </div>
        </div>

        <div class="d-grid">
            <button class="btn btn-secondary fw-semibold mt-3" type="submit" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-secondary" data-bs-title="Clique para fazer o login">Entrar</button>
        </div>
    </form>
</div>

<!-- <?php $this->start("scripts"); ?>
    <script src="<?= theme("/assets/login/login.js", CONF_VIEW_WEB); ?>"></script>
<?php $this->end(); ?> -->