<?= $this->layout("_theme", ["head" => $head]); ?>

<link rel="stylesheet" href="<?= theme("/assets/login/forget.css"); ?>"/>

<div class="form-signin w-100 m-auto mt-5 p-5">

    <form class="needs-validation" novalidate id="forget" action="<?=url("/recuperar")?>" method="post" enctype="multipart/form-data">
    
        <div class="text-center mb-1">
            <img class="mb-2" src="<?= theme("/assets/images/logo/sigecinfo-logo-v2.png") ?>" alt="Logo SIGECINFO" width="150">
        </div>

        <h1 class="h3 mb-3 fw-normal text-center">Recuperar senha</h1>

        <p class="text-center fw-semibold text-gray-700">Informe seu e-mail para receber um link de recuperação.</p>

        <div class="ajax_response"><?= flash(); ?></div>
        
        <?= csrf_input(); ?>

        <label for="email" class="form-label fw-semibold"><i class="bi bi-envelope-at pe-2"></i>Email de recuperação</label>
        
            <div class="form-floating mb-3 mt-1">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>"
                   placeholder="nome@smsub.prefeitura.sp.gov.br" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"
                   data-bs-title="Digite seu email !!!">
        </div>

        <label for="esqueciForm" class="form-label"><a class="link-primary text-decoration-none fw-semibold text-primary" title="Esqueceu a senha?" href="<?= url("/entrar"); ?>">Voltar e entrar !!! </a><span class="badge rounded-pill text-bg-secondary ps-2 text-white" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Clique para se logar no sistema !!!" data-bs-custom-class="custom-tooltip-secondary">?</span></label>

        <button class="btn btn-secondary w-100 py-2 fw-semibold mt-3" type="submit" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Clique para recuperar a sua senha !!!" data-bs-custom-class="custom-tooltip-secondary">Recuperar</button>
    </form>
    
</div>
