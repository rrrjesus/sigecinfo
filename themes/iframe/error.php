<?= $this->layout("_theme", ["head" => $head, "error" => $error]); ?>

<div class="px-4 py-5 my-5 text-center content">
    <i class="bi bi-ui-checks display-4"></i><h1>Siegcinfo</h1>
    <p class="display-4 fw-bold text-body-emphasis">&bull;<?= $error->code; ?>&bull;</p>
    <div class="col-lg-6 mx-auto">
        <p class="mb-2 fs-3 fw-bold"><?= $error->title; ?></p>
        <p class="mb-4 fs-5">Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <?php if ($error->link): ?>
                <a class="btn btn-<?=color_month();?> btn-lg px-4 gap-3 text-light" role="button"
                   data-bs-toggle-tooltip="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                   data-bs-title="Clique para enviar um email ao suporte" href="<?=$error->link; ?>"><?= $error->linkTitle; ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>