<?php $this->layout("_theme"); ?>

<div class="form-signin w-100 m-auto mt-5 p-5">

    <div class="text-center mb-1">
        <img class="mb-2" src="<?= theme("/assets/images/logo/sigecinfo-logo-v2.png") ?>" alt="Logo SIGECINFO" width="150">
    </div>


    <form class="needs-validation" novalidate id="reset" action="<?=url("/recuperar/resetar")?>" method="post" enctype="multipart/form-data">

        <p class="text-center fw-bold text-danger">A senha deve ter 8 caracteres, conter número e caracter.</p>

        <div class="ajax_response"><?= flash(); ?></div>

        <input type="hidden" name="code" value="<?= $code; ?>"/>

        <?= csrf_input(); ?>

        <label for="password" class="form-label fw-semibold"><i class="bi bi-lock pe-2"></i>Nova Senha</label>
        <div class="form-floating mb-3 mt-1">
            <input type="password" name="password" id="password" class="form-control" placeholder="********"
                   data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Digite sua senha !!!" data-bs-custom-class="custom-tooltip-secondary" required>
                   <i class="bi bi-eye-slash toggle-password" id="togglePasswordIcon"></i>
        </div>

         <label for="password_re" class="form-label fw-semibold"><i class="bi bi-lock pe-2"></i>Repita a Nova Senha</label>
        <div class="form-floating mb-3 mt-1">
            <input type="password" name="password_re" id="password_re" class="form-control" placeholder="********"
                   data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Redigite sua senha !!!" data-bs-custom-class="custom-tooltip-secondary" required>
                   <i class="bi bi-eye-slash toggle-passwordRe" id="togglePasswordIconRe"></i>
        </div>

        <label for="esqueciForm" class="form-label"><a class="link-primary text-decoration-none fw-semibold text-primary" title="Esqueceu a senha?" href="<?= url("/entrar"); ?>">Voltar e entrar !!! </a><span class="badge rounded-pill text-bg-secondary ps-2 text-white" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Clique para se logar no sistema !!!" data-bs-custom-class="custom-tooltip-secondary">?</span></label>


        <button class="btn btn-secondary w-100 py-2 fw-bold mt-3" type="submit">Alterar senha</button>
    
    </form>

</div>

<?php $this->start("scripts"); ?>

<script>
    const togglePasswordCheckbox = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');
    const togglePasswordCheckboxRe = document.querySelector('#togglePasswordRe');
    const passwordFieldRe = document.querySelector('#password_re');
    

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

    if (togglePasswordCheckboxRe && passwordFieldRe) {
        togglePasswordCheckboxRe.addEventListener('change', function () {
            const type = passwordFieldRe.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordFieldRe.setAttribute('type', type);
        });
    }

     // --- NOVO SCRIPT PARA O ÍCONE DE OLHO ---
    const togglePasswordIconRe = document.querySelector('#togglePasswordIconRe');
    // A variável passwordField já foi declarada acima

    if (togglePasswordIconRe) {
        togglePasswordIconRe.addEventListener('click', function (e) {
            // Alterna o tipo do campo de senha
            const type = passwordFieldRe.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordFieldRe.setAttribute('type', type);
            
            // Alterna a classe do ícone entre 'olho aberto' e 'olho fechado'
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }
</script>

<?php $this->end(); ?> 
