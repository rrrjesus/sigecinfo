<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="mit" content="2024-06-12T12:58:07-03:00+197772">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_IFRAME); ?>"/>
    <link rel="stylesheet" href="<?=theme("/assets/style.css?v=", CONF_VIEW_IFRAME).color_month()."v1.8.0.7"; ?>"/>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<!--CONTENT-->
<main class="container-sm">

<div class="col-12 ml-auto"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
    <?= $this->section("content"); ?>
</div>

</main>

<!-- Javascript do Tema -->
<script src="<?= theme("assets/scripts.js?v=", CONF_VIEW_IFRAME).color_month()."v1.8.0.7";?>"></script>
<?= $this->section("scripts"); ?>

</body>
</html>