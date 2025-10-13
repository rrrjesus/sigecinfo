<?php $this->layout("_theme"); ?>

<div class="row g-5 p-4">
    <div class="col-12 text-center">
        <h2 class="pb-4 mb-4 border-bottom">
            Bem Vindo ao <?=CONF_SITE_NAME?>
        </h2>


             <img class="title_image" title="Bem Vindo" alt="Cadastro de Usuários"
                     src="<?=theme("/assets/images/optin-success.png"); ?>"/>

            <h3><?= $data->title; ?></h3>
            <p><?= $data->desc; ?></p>
            <?php if (!empty($data->link)): ?>
                <?= button(["href" => "/entrar", "name" => "$data->linkTitle", "title" => "$data->linkTitle","icon" => "person-lock", "btncolor" => "secondary"]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php if (!empty($track)): ?>
    <?php $this->start("scripts"); ?>
    <script>
        fbq('track', '<?= $track->fb;?>');
        gtag('event', 'conversion', {'send_to': '<?= $track->aw;?>'});
    </script>
    <?php $this->end(); ?>
<?php endif; ?>
