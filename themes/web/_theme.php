<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="mit" content="2024-06-12T12:58:07-03:00+197772">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png"); ?>"/>
    <link rel="stylesheet" href="<?=theme("/assets/style.css?v=").color_month()."v1.8.0.6"; ?>"/>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>


<header class="navbar navbar-expand-lg bd-navbar-<?=color_month()?> sticky-top">

<style>
/* Typeahead Color*/
span.twitter-typeahead .tt-suggestion:focus, .dropdown-item:hover, span.twitter-typeahead .tt-suggestion:hover {
    background-color: var(--bs-<?=color_month()?>);
}
.ajax_load_box_circle {
    border-top: 16px solid var(--bs-<?=color_month()?>);
}
</style>

  <!-- Navbar-->
  <?= $this->insert("views/theme/navbar"); ?>
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
            <p class="fw-bolder fs-3">Comece a utilizar o Siegcinfo agora mesmo</p>
            <p class="fs-5">É rápido, simples e funcional!</p>
        </div>
    </div>
<?php endif; ?>

<!--FOOTER-->
<?= $this->insert("views/theme/footer"); ?>

<!-- Javascript do Tema -->
<script src="<?= theme("assets/scripts.js?v=").color_month()."v1.8.0.6";?>"></script>

<?= $this->section("scripts"); ?>

</body>
</html>