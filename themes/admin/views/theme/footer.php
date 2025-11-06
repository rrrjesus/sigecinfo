<footer class="py-2 mt-auto text-body-emphasis bg-<?=CONF_ADMIN_COLOR?>">
    <div class="container-fluid px-4">
        <div class="text-center">
            <div class="text-light">&copy; <?=CONF_SITE_NAME?> - <?= date('Y'); ?>. Todos os direitos reservados.</div>
            <div>
                <a href="<?= url("/privacidade"); ?>" class="link-light">Políticas de Privacidade</a>
                &middot;
                
                <a href="<?= url("/termos"); ?>" class="link-light">Termos &amp; Condições</a>
            </div>
        </div>
    </div>
</footer>