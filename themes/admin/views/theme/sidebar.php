<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>
                
                    <a class="nav-link" href="<?=url("/painel/controle")?>">
                        <div class="sb-nav-link-icon"><i class="bi bi-speedometer bi-2xx"></i></div>
                        Monitoramento
                    </a>
                
                <a class="nav-link" href="<?=url("/")?>" target="_blank">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Site
                </a>

                <a class="nav-link" href="<?=url("/app")?>" target="_blank">
                    <div class="sb-nav-link-icon"><i class="bi bi-link-45deg bi-2xx"></i></div>
                    Ver Aplicativo
                </a>

                <div class="text-white border-bottom pt-3"></div>
                
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>

                <?php
                    $authorization = new \Source\Domain\Shared\Authorization();
                ?>

                <?php if (\Source\Domain\Shared\Models\Auth::check('events')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                        <div class="sb-nav-link-icon"><i class="bi bi-calendar-event bi-2xx"></i></div>
                        Eventos
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEvents" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionEvents">
                            
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#typesSub" aria-expanded="false">
                                    Tipo de Eventos
                                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                                </a>
                                <div class="collapse" id="typesSub" data-bs-parent="#sidenavAccordionEvents">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <?php if ($authorization->hasPermission('Eventtypes_create')): ?>
                                            <a class="nav-link" href="<?=url("/painel/tipos-de-eventos/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                                        <?php endif; ?>

                                        <?php if ($authorization->hasPermission('Eventtypes_list')): ?>
                                        <a class="nav-link" href="<?=url("/painel/tipos-de-eventos")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (\Source\Domain\Shared\Models\Auth::check('places_list')): ?>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#placesSub" aria-expanded="false">
                                    Locais
                                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                                </a>
                                <div class="collapse" id="placesSub" data-bs-parent="#sidenavAccordionEvents">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <?php if (\Source\Domain\Shared\Models\Auth::check('places_create')): ?>
                                            <a class="nav-link" href="<?=url("/painel/locais/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                                        <?php endif; ?>
                                        <a class="nav-link" href="<?=url("/painel/locais")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                    </nav>
                                </div>
                            <?php endif; ?>

                        </nav>
                    </div>


                <?php if (\Source\Domain\Shared\Models\Auth::check('users')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                        <div class="sb-nav-link-icon"><i class="bi bi-shield-lock bi-2xx"></i></div>
                        Controle de Acesso
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUsers" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionUsers">
                            
                            <?php if (\Source\Domain\Shared\Models\Auth::check('users_list')): ?>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false">
                                    <div class="sb-nav-link-icon"><i class="bi bi-person"></i></div>&nbsp;Usuários
                                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseUser" data-bs-parent="#sidenavAccordionUsers">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <?php if (\Source\Domain\Shared\Models\Auth::check('users_create')): ?>
                                            <a class="nav-link" href="<?=url("/painel/usuarios/cadastrar")?>"><i class="bi bi-person-add me-2"></i> Cadastrar</a>
                                        <?php endif; ?>
                                        <a class="nav-link" href="<?=url("/painel/usuarios")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                    </nav>
                                </div>
                            <?php endif; ?>

                            <?php if (\Source\Domain\Shared\Models\Auth::check('levels_list')): ?>
                                <a class="nav-link" href="<?=url("/painel/niveis")?>">
                                    <div class="sb-nav-link-icon"><i class="bi bi-diagram-3"></i></div>&nbsp;Níveis
                                </a>
                            <?php endif; ?>

                            <?php if (\Source\Domain\Shared\Models\Auth::check('acl_view')): ?>
                                <a class="nav-link" href="<?=url("/painel/acl")?>">
                                    <div class="sb-nav-link-icon"><i class="bi bi-shield-check"></i></div>&nbsp;Matriz de Permissões
                                </a>
                            <?php endif; ?>

                            <?php if (\Source\Domain\Shared\Models\Auth::check('positions_list')): ?>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsersPositions" aria-expanded="false">
                                    <div class="sb-nav-link-icon"><i class="bi bi-briefcase"></i></div>&nbsp;Cargos
                                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseUsersPositions" data-bs-parent="#sidenavAccordionUsers">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <?php if (\Source\Domain\Shared\Models\Auth::check('positions_create')): ?>
                                            <a class="nav-link" href="<?=url("/painel/cargos/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                                        <?php endif; ?>
                                        <a class="nav-link" href="<?=url("/painel/cargos")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                    </nav>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (\Source\Domain\Shared\Models\Auth::check('permissions_list')): ?>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePermissions" aria-expanded="false">
                                    <div class="sb-nav-link-icon"><i class="bi bi-key"></i></div>&nbsp;Permissões
                                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                                </a>
                                <div class="collapse" id="collapsePermissions" data-bs-parent="#sidenavAccordionUsers">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="<?=url("/painel/permissoes")?>"><i class="bi bi-list me-2"></i> Gerir ACL</a>
                                    </nav>
                                </div>
                            <?php endif; ?>

                        </nav>
                    </div>
                <?php endif; ?>

                <div class="text-white border-bottom pt-3"></div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link" href="<?=url("/painel/logoff")?>" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-box-arrow-right bi-2xx"></i></div>
                    Sair
                </a>

                <div class="text-white border-bottom pt-3"></div>

            </div>
        </div>
    </nav>
</div>