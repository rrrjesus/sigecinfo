<?= $this->layout("_theme", ["head" => $head]); ?>

<div class="form-signin w-100 m-auto mt-5 p-3 p-md-5">

<!--    <div class="text-center mb-1">
        <img class="mb-2" src="<?= theme("/assets/images/logo/sigecinfo-logo-v2.png") ?>" alt="Logo SIGECINFO" width="150">
    </div>
-->

    <form class="needs-validation" novalidate id="login" action="<?= url("/entrar") ?>" method="post" >

        <div class="ajax_response"><?= flash(); ?></div>

        <?= csrf_input(); ?>

        <label for="inputPassword" class="form-label fw-semibold"><i class="bi bi-envelope-at pe-2"></i>Email</label>

            <div class="form-floating mb-3 mt-1">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>"
                   placeholder="nome@smsub.prefeitura.sp.gov.br" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"
                   data-bs-title="Digite seu email !!!" data-bs-custom-class="custom-tooltip-secondary">
        </div>

        <label for="password" class="form-label fw-semibold"><i class="bi bi-lock pe-2"></i>Senha</label>
        <div class="form-floating mb-3 mt-1 password-wrapper">
            <input type="password" name="password" id="password" class="form-control" placeholder="********"
                data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Digite sua senha !!!" data-bs-custom-class="custom-tooltip-secondary">
            <i class="bi bi-eye-slash toggle-password" id="togglePasswordIcon"></i>
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
            <button class="btn btn-primary fw-semibold mt-3" type="submit" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-secondary" data-bs-title="Clique para fazer o login"><i class="bi bi-box-arrow-in-right me-1"></i>Entrar</button>
        </div>

        <div class="divider d-flex align-items-center my-1"></div>

        <div class="d-grid">
            <a class="btn btn-danger fw-semibold mt-1" href="<?= url("/auth/google"); ?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-danger" data-bs-title="Clique para fazer o login com o Google">
                <i class="bi bi-google me-1"></i> Entrar com Google
            </a>
        </div>
    </form>
</div>

<?php $this->start("scripts"); ?>

<script>
    const togglePasswordCheckbox = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');

    if (togglePasswordCheckbox && passwordField) {
        togglePasswordCheckbox.addEventListener('change', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    }

    // --- NOVO SCRIPT PARA O ÍCONE DE OLHO ---
    const togglePasswordIcon = document.querySelector('#togglePasswordIcon');
    // A variável passwordField já foi declarada acima

    if (togglePasswordIcon) {
        togglePasswordIcon.addEventListener('click', function (e) {
            // Alterna o tipo do campo de senha
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Alterna a classe do ícone entre 'olho aberto' e 'olho fechado'
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }
</script>

<?php $this->end(); ?> 