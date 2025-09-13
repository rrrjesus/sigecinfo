<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= theme("/assets/images/favicon/apple-touch-icon.png", CONF_VIEW_ADMIN); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= theme("/assets/images/favicon/favicon-32x32.png", CONF_VIEW_ADMIN); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= theme("/assets/images/favicon/favicon-16x16.png", CONF_VIEW_ADMIN); ?>">
    <!-- <link rel="manifest" href="/site.webmanifest"> -->
    <link rel="mask-icon" href="<?= theme("/assets/images/favicon/safari-pinned-tab.svg", CONF_VIEW_ADMIN); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="<?=theme("/assets/style.css", CONF_VIEW_ADMIN)?>" rel="stylesheet" />
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<?= $this->section("content"); ?>

<script src="<?= theme("/assets/scripts.js"); ?>"></script>
<?= $this->section("scripts"); ?>

</body>
</html>