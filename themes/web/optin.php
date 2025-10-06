<?php $this->layout("_theme"); ?>

<div class="row g-5 p-4">
    <div class="col-8 text-center">
        <h2 class="pb-4 mb-4 border-bottom">
            Bem Vindo ao <?=CONF_SITE_NAME?>
        </h2>
    </div>
</div>


             <img class="title_image" title="Bem Vindo" alt="Cadastro de Usuários"
                     src="<?=theme("/assets/images/optin-success.png"); ?>"/>

            <h1><?= $data->title; ?></h1>
            <p><?= $data->desc; ?></p>
            <?php if (!empty($data->link)): ?>
                <a class="optin_page_btn gradient gradient-green gradient-hover radius"
                   href="<?= $data->link; ?>" title="<?= $data->linkTitle; ?>"><?= $data->linkTitle; ?></a>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php if (!empty($track)): ?>
    <?php $this->start("scripts"); ?>
    <script>
        fbq('track', '<?= $track->fb;?>');
        gtag('event', 'conversion', {'send_to': '<?= $track->aw;?>'});
    </script>
    <?php $this->end(); ?>
<?php endif; ?>
