<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-<?=CONF_APP_COLOR?>" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>
                <?php if(user()->level_id > 4){
                    echo '<a class="nav-link text-light fw-semibold fs-6" href="'.url("/painel").'">
                        <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>Painel</a>';
                    }?>
                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/app/home")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer bi-2xx"></i></div>
                    Home
                </a>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>  

                <!-- Sidebar Eventos -->
                <a class="nav-link text-light collapsed fw-semibold fs-6" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                    <div class="sb-nav-link-icon"><i class="bi bi-calendar-event bi-2xx"></i></div>
                    Eventos
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseEvents" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php if (in_array(user()->level()->level_name, ["Administrador do Sistema", "Editor Administrador", "Editor"])): ?>
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/app/eventos/cadastrar")?>"><i class="bi bi-plus-circle bi-2xx me-2"></i> Cadastrar</a>
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/app/eventos")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                        <?php endif; ?>
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/app/eventos/meus-eventos-agendados")?>"><i class="bi bi-list bi-2xx me-2"></i> Meus Eventos</a>
                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/app/eventos/meus-eventos-finalizados")?>"><i class="bi bi-list bi-2xx me-2"></i> Histórico</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link text-light fw-semibold fs-6" href="#" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-dark" 
                    data-bs-title="Clique para sair do sistema" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Sair
                </a>

                <?= $this->insert("views/modals/modalSystem"); ?>


            </div>
        </div>
        <div class="sb-sidenav-footer text-light fw-semibold fs-6">
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Logado como: <?=$user->user_name?></div>
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Hostname : <?=gethostname();?></div>
        </div>
    </nav>
</div>