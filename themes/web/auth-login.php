<?= $this->layout("_theme", ["head" => $head]); ?>

<style>
    .bi-eye {
    position: absolute;
    top: 15px;
    right: 30px;
    cursor: pointer;
    }
    .bi-eye-slash {
        position: absolute;
        top: 15px;
        right: 30px;
        cursor: pointer;
    }
</style>

        <div class="form-signin w-100 m-auto content">
            <form class="needs-validation" novalidate id="login" action="<?=url("/entrar")?>" method="post" enctype="multipart/form-data">
                <div class="ajax_response"><?=flash();?></div>
                <?=csrf_input();?>

                <h1 class="h3 mb-3 fw-normal mt-5">Fazer Login</h1>

                <div class="form-floating mb-3">
                    <input class="form-control" type="email" name="email" id="email" value="<?=($cookie ?? null)?>" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                        data-bs-title="Digite seu e-mail : ">
                    <label for="floatingInput">Digite seu e-mail : </label>
                </div>

                <label for="esqueciForm" class="form-label">
                    <a class="text-<?=color_month()?> text-center fw-bold" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                    data-bs-title="Clique para recuperar sua senha" href="<?= url("/recuperar"); ?>">Esqueceu a senha?</a>
                </label>
                <div class="form-floating">
                    
                    <input type="password" name="password" class="form-control mt-2" id="password" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                        data-bs-title="Digite sua senha : ">
                    <label for="floatingInput">Digite sua senha : </label>
                    <!-- <span class="bi bi-eye-slash" id="bi-eye-slash"></span> -->

                </div>

                <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault" <?= (!empty($cookie) ? "checked" : ""); ?> name="save">
                    <label class="form-check-label fw-semibold" for="flexCheckDefault">
                        Lembrar dados?
                    </label>
                </div>
                <button class="btn btn-outline-<?=color_month();?> w-100 py-2 fw-bold" type="submit">Entrar</button>
            </form>
        </div>