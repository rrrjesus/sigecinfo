

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
                        <div class="text-center p-3 border-bottom">
                <?= avatar(
                    user()->photo,
                    70,
                    70,
                    CONF_VIEW_APP,
                    [
                        'class' => 'rounded-circle border border-2 border-light mx-auto d-block'
                    ]
                ); ?>
                <h5 class="mt-2 mb-0 text-light"><?= user()->user_name; ?></h5>
                <p class="text-light small"><?= user()->level()->level_name; ?></p>
                <!-- <p class="text-light small fst-italic">(<?= gethostname(); ?>)</p> -->
            </div>
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>

                <a class="nav-link" href="<?=url("/painel/controle")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer bi-2xx"></i></div>
                    Monitoramento
                </a>

                <a class="nav-link" href="<?=url("/")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Site
                </a>
                    
                <a class="nav-link" href="<?=url("/app")?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Aplicativo
                </a>

                <div class="text-white border-bottom pt-3"></div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>  

                <!-- Sidebar Eventos -->
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                    <div class="sb-nav-link-icon"><i class="bi bi-journal-text bi-2xx"></i></div>
                    Eventos
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseEvents" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de Locais -->
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#patrimonyCollapsePlaces" aria-expanded="false" aria-controls="pagesCollapsePlaces">
                            Locais
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="patrimonyCollapsePlaces" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPlaces">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=url("/painel/locais/cadastrar")?>"><i class="bi bi-journal-plus bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link" href="<?=url("/painel/locais")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                            </nav>
                        </div>

                    </nav>
                </div>

                 <div class="collapse" id="collapseEvents" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de Empresas -->
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#patrimonyCollapseTypes" aria-expanded="false" aria-controls="pagesCollapseTypes">
                            Tipo de Eventos
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="patrimonyCollapseTypes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionTypes">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=url("/painel/tipos-de-eventos/cadastrar")?>"><i class="bi bi-journal-plus bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link" href="<?=url("/painel/tipos-de-eventos")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                            </nav>
                        </div>
                        

                    </nav>
                </div>

                <!-- Sidebar Usuários -->
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="bi bi-journal-text bi-2xx"></i></div>
                    Usuários
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                        <!-- Sidebar de usuários -->
                        <a class="nav-link" href="" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                            <div class="sb-nav-link-icon"><i class="bi bi-person bi-2xx"></i></div>
                            Usuários
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUser" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionUser">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=url("/painel/usuarios/cadastrar")?>"><i class="bi bi-person-add bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link" href="<?=url("/painel/usuarios")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                                <a class="nav-link" href="<?=url("/painel/usuarios/desativados")?>"><i class="bi bi-list bi-2xx me-2"></i> Desativados</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="<?=url("/painel/niveis")?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="top"  data-bs-custom-class="custom-tooltip-dark" data-bs-title="Listar Níveis de Usuários">
                            <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                            Níveis
                        </a>

                        <!-- Sidebar de cargos de usuários -->
                        <a class="nav-link" href="" data-bs-toggle="collapse" data-bs-target="#collapseUsersPositions" aria-expanded="false" aria-controls="collapseUsersPositions">
                            <div class="sb-nav-link-icon"><i class="bi bi-building bi-2xx"></i></div>
                            Cargos
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsersPositions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionUserPosition">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=url("/painel/cargos/cadastrar")?>"><i class="bi bi-building-add bi-2xx me-2"></i> Cadastrar</a>
                                <a class="nav-link" href="<?=url("/painel/cargos")?>"><i class="bi bi-list bi-2xx me-2"></i> Listar</a>
                                <a class="nav-link" href="<?=url("/painel/cargos/desativados")?>"><i class="bi bi-list bi-2xx me-2"></i> Desativados</a>
                            </nav>
                        </div>
                        
                    </nav>
                </div>

                <div class="text-white border-bottom pt-3"></div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link" href="<?=url("/painel/logoff")?>" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-dark" 
                    data-bs-title="Clique para sair do sistema" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Sair
                </a>

                <div class="text-white border-bottom pt-3"></div>


            </div>
        </div>
    </nav>
</div>