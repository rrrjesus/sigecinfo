<style>
    .sb-sidenav-menu a:hover {
        background: #424242;
        color: #ffffff;
    }
</style>


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/controle")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer bi-2xx"></i></div>
                    Monitoramento
                </a>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Site
                </a>
                    
                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/beta")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Aplicativo
                </a>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>  
                
                <!-- Sidebar Usuários -->
                <a class="nav-link text-light collapsed fw-semibold fs-6" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="bi bi-journal-text bi-2xx"></i></div>
                    Usuários
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de usuários -->
                        <a class="nav-link text-light collapsed fw-semibold fs-6" href="" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                            <div class="sb-nav-link-icon"><i class="bi bi-person bi-2xx"></i></div>
                            Usuários
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUser" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionUser">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/usuarios/cadastrar")?>"><i class="bi bi-person-add bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/usuarios")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/usuarios/desativados")?>"><i class="bi bi-list bi-2xx me-2"></i> Desativados</a>
                            </nav>
                        </div>

                        <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/niveis")?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="top"  data-bs-custom-class="custom-tooltip-dark" data-bs-title="Listar Níveis de Usuários">
                            <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                            Níveis
                        </a>

                        <!-- Sidebar de cargos de usuários -->
                        <a class="nav-link text-light collapsed fw-semibold fs-6" href="" data-bs-toggle="collapse" data-bs-target="#collapseUsersPositions" aria-expanded="false" aria-controls="collapseUsersPositions">
                            <div class="sb-nav-link-icon"><i class="bi bi-building bi-2xx"></i></div>
                            Cargos
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsersPositions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionUserPosition">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/cargos/cadastrar")?>"><i class="bi bi-building-add bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/cargos")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/cargos/desativados")?>"><i class="bi bi-list bi-2xx me-2"></i> Desativados</a>
                            </nav>
                        </div>
                        
                    </nav>
                </div>

                <!-- Sidebar Secretaria -->
                <a class="nav-link text-light collapsed fw-semibold fs-6" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInstitutions" aria-expanded="false" aria-controls="collapseInstitutions">
                    <div class="sb-nav-link-icon"><i class="bi bi-journal-text bi-2xx"></i></div>
                    Secretaria
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseInstitutions" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de igrejas -->
                        <a class="nav-link text-light collapsed fw-semibold fs-6" href="" data-bs-toggle="collapse" data-bs-target="#collapseChurchs" aria-expanded="false" aria-controls="collapseChurchs">
                            <div class="sb-nav-link-icon"><i class="bi bi-building bi-2xx"></i></div>
                            Igrejas
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseChurchs" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionChurch">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/igrejas/cadastrar")?>"><i class="bi bi-building-add bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/igrejas")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/igrejas/desativadas")?>"><i class="bi bi-list bi-2xx me-2"></i> Desativadas</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <!-- Sidebar Reuniões -->
                <a class="nav-link text-light collapsed fw-semibold fs-6" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMeetings" aria-expanded="false" aria-controls="collapseMeetings">
                    <div class="sb-nav-link-icon"><i class="bi bi-journal-text bi-2xx"></i></div>
                    Reuniões
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseMeetings" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de Empresas -->
                        <a class="nav-link text-light collapsed fw-semibold fs-6" href="#" data-bs-toggle="collapse" data-bs-target="#patrimonyCollapseCompanies" aria-expanded="false" aria-controls="pagesCollapseCompanies">
                            Empresas
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="patrimonyCollapseCompanies" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionCompanies">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/patrimonio/marcas/cadastrar")?>"><i class="bi bi-journal-plus bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/patrimonio/marcas")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                            </nav>
                        </div>

                       
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link text-light fw-semibold fs-6" href="<?=url("/painel/logoff")?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-dark" 
                    data-bs-title="Clique para sair do sistema" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Sair
                </a>

                <?= $this->insert("views/modalSystem"); ?>


            </div>
        </div>
        <div class="sb-sidenav-footer text-light fw-semibold fs-6">
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Logado como: <?=get_current_user();?></div>
            <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">Hostname : <?=gethostname();?></div>
        </div>
    </nav>
</div>