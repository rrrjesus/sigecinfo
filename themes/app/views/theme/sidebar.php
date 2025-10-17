
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-<?=CONF_APP_COLOR?>" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/beta/home")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer bi-2xx"></i></div>
                    Monitoramento
                </a>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Site
                </a>
                
                <?php if(user()->level_id > 4){
                    echo '<a class="nav-link text-light fw-semibold fs-6" href="'.url("/painel").'">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>Painel</a>';
                }?>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">CADASTROS</div>

                <!-- Sidebar de usuários -->
                <a class="nav-link text-light collapsed fw-semibold fs-6" href="" data-bs-toggle="collapse" data-bs-target="#collapseEvent" aria-expanded="false" aria-controls="collapseEvent">
                    <div class="sb-nav-link-icon"><i class="bi bi-person bi-2xx"></i></div>
                    Eventos
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseEvent" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionEvent">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/beta/eventos/meus-eventos")?>"><i class="bi bi-list bi-2xx me-2"></i> Eventos Ativos</a>
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/beta/eventos/meus-eventos-finalizados")?>"><i class="bi bi-list bi-2xx me-2"></i> Eventos Finalizados</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/beta/logoff")?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-secondary" 
                    data-bs-title="Clique para sair do sistema" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Sair
                </a>

                <?= $this->insert("views/modals/modalSystem"); ?>


            </div>
        </div>
        <div class="sb-sidenav-footer text-light fw-semibold fs-6">
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Hostname: <?=gethostbyaddr($_SERVER['REMOTE_ADDR']);?></div>
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Logado como: <?=getenv("USERNAME");?></div>
        </div>
    </nav>
</div>