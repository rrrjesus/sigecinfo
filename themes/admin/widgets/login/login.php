<?php $this->layout("_login"); ?>


<link href="<?=theme("/assets/login/login_style.css", CONF_VIEW_ADMIN)?>" rel="stylesheet" />

<div class="form-signin w-100 m-auto mt-2">
    <form class="needs-validation" novalidate id="login" name="login" action="<?= url("/painel/login"); ?>" method="post" enctype="multipart/form-data">

        <?=csrf_input();?>

        <div class="row justify-content-center">
            <div class="form-floating mb-3 mt-1 text-center">
                <img width="110" height="50" src="<?=theme("/assets/images/logo/sigecinfo-logo-final-v3.png", CONF_VIEW_ADMIN)?>">
            </div>
        </div>
        
        <div class="ajax_response"><?=flash();?></div>

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
            <label class="form-check-label" for="togglePassword">
                Mostrar a Senha <span class="badge rounded-pill text-bg-dark ps-2" data-bs-toggle-tooltip="tooltip" data-bs-placement="right"  data-bs-title="Selecione caso queira ver a senha">?</span>
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="save" id="save" <?= (!empty($cookie) ? "checked" : ""); ?>>
                <label class="form-check-label" for="save">Lembrar</label>
            </div>
            <div>
                 <a class="link-body-emphasis text-decoration-none fw-semibold text-danger" href="<?= url("/recuperar"); ?>">Esqueceu a senha?</a>
            </div>
        </div>

        <div class="d-grid">
            <button class="btn btn-primary fw-semibold mt-3" type="submit" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-title="Clique para fazer o login">Entrar</button>
        </div>
    </form>

    <footer class="pt-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between pt-2 border-top text-white">
            <p>&copy; 2023 Todos os direitos reservados.</p>
        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-between text-white">
            <p>Desenvolvido por <strong>rrrjesus</strong></p>
            <ul class="list-unstyled d-flex">
                <li class="ms-3"><a class="link-body-emphasis text-decoration-none fw-medium text-white"
                                    target="_blank" href="https://api.whatsapp.com/send?phone=5511991091365&text=Olá, preciso de ajuda com o login.">
                        <i class="bi bi-whatsapp text-success"></i> 991091365</a></li>
            </ul>
        </div>
    </footer>

</div>


<?php $this->start("scripts"); ?>
<script src="<?= theme("/assets/login/login_validate.js", CONF_VIEW_ADMIN); ?>"></script>
<?php $this->end(); ?>