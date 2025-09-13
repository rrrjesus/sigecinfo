<?php $this->layout("_theme"); ?>

<div class="form-signin w-100 m-auto content">

    <form class="needs-validation" novalidate id="forget" action="<?=url("/recuperar")?>" method="post" enctype="multipart/form-data">

        <h1 class="h3 mb-3 fw-normal mt-5">Recuperar senha</h1>
        <p>Informe seu e-mail para receber um link de recuperação.</p>

        <div class="ajax_response"><?= flash(); ?></div>
        
        <?= csrf_input(); ?>

        <div class="form-floating mb-3">
            <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>" required>
            <label for="floatingInput">Informe seu e-mail:</label>
        </div>

        <label for="esqueciForm" class="form-label"><a class="text-center fw-bold" style="color: #011fcf;" title="Esqueceu a senha?" href="<?= url("/entrar"); ?>">Voltar e entrar !!!</a></label>

        <button class="btn btn-outline-<?=color_month();?> w-100 py-2 fw-bold mt-3" type="submit">Recuperar</button>
    </form>
    
</div>
