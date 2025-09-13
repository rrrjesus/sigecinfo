<?php $this->layout("_theme"); ?>

<div class="form-signin w-100 m-auto content">

    <form class="needs-validation" novalidate id="reset" action="<?=url("/recuperar/resetar")?>" method="post" enctype="multipart/form-data">

        <h1 class="h3 mb-3 fw-normal mt-5">Criar nova senha</h1>
        <p class="fw-normal">Informe e repita uma nova senha para recuperar seu acesso.</p>
        <p class="fw-normal text-danger">Aviso : A senha deve ter no mínimo 8 caracteres e conter pelo menos um número e um caracter.</p>

        <div class="ajax_response"><?= flash(); ?></div>

        <input type="hidden" name="code" value="<?= $code; ?>"/>
        <?= csrf_input(); ?>

        <div class="form-floating mb-3">
            <input class="form-control" type="password" name="password" required>
            <label for="floatingInput">Nova senha : </label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="password" name="password_re" required>
            <label for="floatingInput">Repita a nova senha:</label>
        </div>

        <label for="esqueciForm" class="form-label"><a class="text-center fw-bold" style="color: #011fcf;" title="Esqueceu a senha?" href="<?= url("/entrar"); ?>">Voltar e entrar !!!</a></label>

        <button class="btn btn-outline-<?=color_month();?> w-100 py-2 fw-bold mt-3" type="submit">Alterar senha</button>
    
    </form>

</div>
