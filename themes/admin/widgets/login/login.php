<?php $this->layout("_login"); ?>

<link href="<?=theme("/assets/login/login.css", CONF_VIEW_ADMIN)?>" rel="stylesheet" />

<div class="form-signin w-100 m-auto m-auto mt-5 p-4">
    <form class="needs-validation" novalidate id="login" name="login" action="<?= url("/painel/login"); ?>" method="post" enctype="multipart/form-data">

        <?=csrf_input();?>

        <div class="row justify-content-center pb-2">
            <div class="form-floating text-center">
                <a class="link-golden text-decoration-none fw-medium text-golden"
                                    target="_blank" href="<?=url("/")?>"  data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Clique para acessar a Home" data-bs-custom-class="custom-tooltip-golden"><img src="<?=theme("/assets/images/logo/sigecinfo-logo-final-v3.png", CONF_VIEW_ADMIN)?>" width="150"></a>
            </div>
        </div>
        
        <div class="ajax_response"><?=flash();?></div>

        <label for="inputPassword" class="form-label fw-semibold text-golden"><i class="bi bi-envelope-at pe-2"></i>Email</label>
        <div class="form-floating mb-3 mt-1">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>"
                   placeholder="nome@smsub.prefeitura.sp.gov.br" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"
                   data-bs-title="Digite seu email !!!">
        </div>

        <label for="inputPassword" class="form-label fw-semibold text-golden"><i class="bi bi-lock pe-2"></i>Senha</label>
        <div class="form-floating mb-3 mt-1">
            <input type="password" name="password" id="password" class="form-control" placeholder="********"
                   data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Digite sua senha !!!">
        </div>

        <div class="form-check text-start my-2">
            <input class="form-check-input" type="checkbox" id="togglePassword">
            <label class="form-check-label text-golden" for="togglePassword">
                Mostrar a Senha <span class="badge rounded-pill text-bg-dark ps-2 text-golden" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Selecione caso queira ver a senha" data-bs-custom-class="custom-tooltip-golden">?</span>
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="save" id="save" <?= (!empty($cookie) ? "checked" : ""); ?>>
                <label class="form-check-label text-golden" for="save" >Lembrar a Senha<span class="badge rounded-pill text-bg-dark ps-2 text-golden" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Selecione caso queira lembrar a senha" data-bs-custom-class="custom-tooltip-golden">?</span></label>
            </div>
            <div>
                 <a class="link-danger text-decoration-none fw-semibold text-danger" href="<?= url("/recuperar"); ?>">Esqueceu a senha <span class="badge rounded-pill text-bg-dark ps-2 text-danger" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Click para solicitar nova senha !!!" data-bs-custom-class="custom-tooltip-danger">?</span></a>
            </div>
        </div>

        <div class="d-grid">
            <button class="btn btn-golden fw-semibold mt-3" type="submit" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Clique para fazer o login" data-bs-custom-class="custom-tooltip-golden">Entrar</button>
        </div>
    </form>

    <footer class="pt-3">
        <div class="d-flex flex-column flex-sm-row justify-content-center pt-2 text-golden">
            <p>&copy; 2025 Todos os direitos reservados.</p>
        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-center text-golden">
            <p></p> <a data-bs-toggle-tooltip="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-golden" data-bs-title="GitHub do Desenvolvedor" class="text-decoration-none text-golden fw-bold" href="https://github.com/rrrjesus/sigecinfo" target="_blank" rel="noopener"><i class="bi bi-github"></i> @rrrjesus/siegcinfo</a></p>
            <ul class="list-unstyled d-flex">
                <p class="ms-3"><a class="link-golden text-decoration-none fw-medium text-golden"
                                    target="_blank" href="https://api.whatsapp.com/send?phone=5511991091365&text=Olá, preciso de ajuda com o login."  data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Clique para contato via whatsapp" data-bs-custom-class="custom-tooltip-golden">
                        <i class="bi bi-whatsapp text-success"></i> 991091365</a></p>
            </ul>
        </div>
    </footer>

</div>


<?php $this->start("scripts"); ?>
<script src="<?= theme("/assets/login/login.js", CONF_VIEW_ADMIN); ?>"></script>
<?php $this->end(); ?>