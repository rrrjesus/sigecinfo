<footer class="bd-footer py-4 py-md-5 bg-body-tertiary text-center">
    <div class="container-xl py-4 py-md-5 px-4 px-md-3 text-body-secondary">
        <div class="row">
            <div class="col-12 col-lg-8 mb-3">
                <a data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                   data-bs-title="Agenda de Ramais" class="d-inline-flex align-items-center mb-2 text-body-emphasis text-decoration-none" href="<?=url("/contatos")?>" aria-label=Contatos">
                    <img class="img-thumbnail fs-1 mb-3 me-2 " width="120" height="30" src="<?=theme("/assets/images/ccb_logo/logo-ccb-light.png")?>">
                    <span class="text-<?=color_month();?> fw-bold fs-6 text-uppercase"><?=CONF_SITE_NAME?></span>
                </a>
                <ul class="list-unstyled small">
                    <li class="mb-2">Desenvolvido com todo amor pela equipe de <strong>SIGECINFO - Sistema de Gerenciamento e Controle de Informações</strong>.</li>
                    <li class="mb-2">Código licenciado <a data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                                          data-bs-title="Liçenca de Software" class="text-decoration-none text-<?=color_month();?> fw-bold" href="https://github.com/rrrjesus/siegcinfo/blob/main/LICENSE" target="_blank" rel="license noopener">MIT</a></li>
                    <li class="mb-2">Versão Atual v2.0.2.</li>
                    <li class="mb-2">Código Fonte <a data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="GitHub do Desenvolvedor" class="text-decoration-none text-<?=color_month();?> fw-bold" href="https://github.com/rrrjesus/sigecinfo" target="_blank" rel="noopener"><i class="bi bi-github"></i> @rrrjesus/siegcinfo</a>.</li>
                </ul>
            </div>

            <div class="col-12 col-lg-4 mb-3">
                <h5>Contato:</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><p><b>Telefone:</b><br> +55 11 4934-3131</p></li>
                    <li class="mb-2"><p><b>E-mail:</b><br>
                            <a class="text-decoration-none text-<?=color_month();?> fw-bold" href="mailto:<?=CONF_SITE_EMAIL?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="E-mail de COTI - Suporte"><?=CONF_SITE_EMAIL?></a></p></li>
                    <li class="mb-2"><p><b>Endereço:</b><br><a class="text-decoration-none text-<?=color_month();?> fw-bold" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Endereço no Google Maps de SIGECINFO"  target="_blank" href="https://www.google.com/maps/place/Congrega%C3%A7%C3%A3o+Crist%C3%A3+no+Brasil+-+Central+de+ja%C3%A7an%C3%A3+(setor+ja%C3%A7an%C3%A3)/@-23.4649943,-46.5884842,17z/data=!3m1!4b1!4m6!3m5!1s0x94cef5da9cacc601:0x579abcba0914e749!8m2!3d-23.4649992!4d-46.5859093!16s%2Fg%2F1ts30dlx?entry=ttu&g_ep=EgoyMDI1MDkxMC4wIKXMDSoASAFQAw%3D%3D">
                                <i class="bi bi-pin-map-fill"></i> </a> Rua José Buono, 65 - Jaçanã  - São Paulo</p></li>
                </ul>
            </div>

            <p data-bs-toggle-tooltip="tooltip" data-bs-placement="left" title="Termos da <?=CONF_SITE_DESC?>" class="termos text-center p-3"> &copy; 2025, SIGECINFO todos os direitos reservados</p>
        </div>
    </div>
</footer>