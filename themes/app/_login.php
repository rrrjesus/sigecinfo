<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="mit" content="2024-06-12T12:58:07-03:00+197772">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= theme("/assets/images/favicon/apple-touch-icon.png", CONF_VIEW_APP); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= theme("/assets/images/favicon/favicon-32x32.png", CONF_VIEW_APP); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= theme("/assets/images/favicon/favicon-16x16.png", CONF_VIEW_APP); ?>">
    <!-- <link rel="manifest" href="/site.webmanifest"> -->
    <link rel="mask-icon" href="<?= theme("/assets/images/favicon/safari-pinned-tab.svg", CONF_VIEW_APP); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="<?=theme("/assets/style.css", CONF_VIEW_APP)?>" rel="stylesheet" />

</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<header class="navbar navbar-expand-lg bd-navbar sticky-top">
  <!-- Navbar-->
  <?= $this->insert("views/theme/navbarLogin"); ?>
</header>

<!--CONTENT-->
<main class="container-sm">

<div class="col-12 ml-auto"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
    <?= $this->section("content"); ?>
</div>

</main>

<?php if ($this->section("optout")): ?>
    <?= $this->section("optout"); ?>
<?php else: ?>
    <div class="row justify-content-center text-center mt-5 mb-5">
        <div class="col-4">
            <i class="bi bi bi-ui-checks display-1 text-<?=color_month();?>"></i>
            <p class="fw-bolder fs-3">Comece a utilizar a agenda inteligente agora mesmo</p>
            <p class="fs-5">É rápida, simples e funcional!</p>
        </div>
    </div>
<?php endif; ?>

<!--FOOTER-->
<?= $this->insert("views/theme/footerLogin"); ?>

<!-- Javascript do Tema -->
<script src="<?= theme("assets/scripts.js")?>"></script>
<?= $this->section("scripts"); ?>

</body>
</html>
