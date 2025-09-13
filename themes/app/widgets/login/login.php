<?php $this->layout("_login"); ?>

<div class="form-signin w-100 m-auto content">
    
    <form class="needs-validation" novalidate id="login" action="<?=url("/entrar")?>" method="post" enctype="multipart/form-data">
        
        <div class="ajax_response"><?=flash();?></div>
        <?=csrf_input();?>

        <h1 class="h3 mb-3 fw-normal">Fazer Login</h1>

        <div class="form-floating mb-3">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>" required>
            <label for="floatingInput">Informe seu e-mail:</label>
        </div>

        <label for="esqueciForm" class="form-label"><a class="text-center fw-bold" style="color: #011fcf;" title="Esqueceu a senha?" href="<?= url("/recuperar"); ?>">Esqueceu a senha?</a></label>
        <div class="form-floating">
            
            <input type="password" name="password" class="form-control" required>
            <label for="floatingInput">Digite sua senha:</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault" <?= (!empty($cookie) ? "checked" : ""); ?> name="save">
            <label class="form-check-label" for="flexCheckDefault">
                Lembrar dados?
            </label>
        </div>

        <button class="btn btn-outline-<?=color_month();?> w-100 py-2 fw-bold" type="submit">Entrar</button>
    
    </form>

</div>