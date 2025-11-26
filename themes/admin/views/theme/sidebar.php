<?php

use Source\Domain\Shared\Models\Auth;
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            
            <div class="nav">
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div>
                
                <?php render_menu_item("/painel/controle", "bi-speedometer", "Monitoramento"); ?>
                <?php render_menu_item("/", "bi-link-45deg", "Ver Site", "_blank"); ?>
                <?php render_menu_item("/app", "bi-link-45deg", "Ver Aplicativo", "_blank"); ?>

                <div class="text-white border-bottom pt-3"></div>
                
                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>

                <?php if (Auth::canAccessModule('events')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                        <div class="sb-nav-link-icon"><i class="bi bi-calendar-event bi-2xx"></i></div>
                        Eventos
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEvents" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionEvents">
                            <?php // Agenda (Events) ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#eventsSub" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="bi bi-calendar-event"></i></div>&nbsp;Agenda
                                <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                            </a>
                            <div class="collapse" id="eventsSub" data-bs-parent="#sidenavAccordionEvents">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if (Auth::check('events_view')): ?><a class="nav-link" href="<?=url("/painel/eventos")?>"><i class="bi bi-list me-2"></i> Listar</a><?php endif; ?>
                                    <?php if (Auth::check('events_create')): ?><a class="nav-link" href="<?=url("/painel/eventos/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a><?php endif; ?>
                                </nav>
                            </div>

                            <?php // Tipo de Eventos (Event Types) ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#typesSub" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="bi bi-tags"></i></div>&nbsp;Tipo de Eventos
                                <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                            </a>
                            <div class="collapse" id="typesSub" data-bs-parent="#sidenavAccordionEvents">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if (Auth::check('event_types_view')): ?><a class="nav-link" href="<?=url("/painel/tipos-de-eventos")?>"><i class="bi bi-list me-2"></i> Listar</a><?php endif; ?>
                                    <?php if (Auth::check('event_types_create')): ?><a class="nav-link" href="<?=url("/painel/tipos-de-eventos/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a><?php endif; ?>
                                </nav>
                            </div>

                            <?php // Locais (Places) ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#placesSub" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="bi bi-geo-alt"></i></div>&nbsp;Locais
                                <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                            </a>
                            <div class="collapse" id="placesSub" data-bs-parent="#sidenavAccordionEvents">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if (Auth::check('places_view')): ?><a class="nav-link" href="<?=url("/painel/locais")?>"><i class="bi bi-list me-2"></i> Listar</a><?php endif; ?>
                                    <?php if (Auth::check('places_create')): ?><a class="nav-link" href="<?=url("/painel/locais/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a><?php endif; ?>
                                </nav>
                            </div>
                        </nav>
                    </div>
                <?php endif; ?>

                <?php if (Auth::check('users_view') || Auth::check('levels_view') || Auth::check('acl_view') || Auth::check('positions_view') || Auth::check('permissions_view')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                        <div class="sb-nav-link-icon"><i class="bi bi-shield-lock bi-2xx"></i></div>
                        Controle de Acesso
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUsers" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionUsers">
                            <?php // Usuários (Users) ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="bi bi-person"></i></div>&nbsp;Usuários
                                <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseUser" data-bs-parent="#sidenavAccordionUsers">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if (Auth::check('users_view')): ?><a class="nav-link" href="<?=url("/painel/usuarios")?>"><i class="bi bi-list me-2"></i> Listar</a><?php endif; ?>
                                    <?php if (Auth::check('users_create')): ?><a class="nav-link" href="<?=url("/painel/usuarios/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a><?php endif; ?>
                                </nav>
                            </div>

                            <?php if (Auth::check('levels_view')): ?>
                                <a class="nav-link" href="<?=url("/painel/niveis")?>">
                                    <div class="sb-nav-link-icon"><i class="bi bi-diagram-3"></i></div>&nbsp;Níveis
                                </a>
                            <?php endif; ?>

                            <?php if (Auth::check('acl_view')): ?>
                                <a class="nav-link" href="<?=url("/painel/acl")?>">
                                    <div class="sb-nav-link-icon"><i class="bi bi-shield-check"></i></div>&nbsp;Matriz de Permissões
                                </a>
                            <?php endif; ?>

                            <?php // Cargos (Positions) ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsersPositions" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="bi bi-briefcase"></i></div>&nbsp;Cargos
                                <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseUsersPositions" data-bs-parent="#sidenavAccordionUsers">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if (Auth::check('positions_view')): ?><a class="nav-link" href="<?=url("/painel/cargos")?>"><i class="bi bi-list me-2"></i> Listar</a><?php endif; ?>
                                    <?php if (Auth::check('positions_create')): ?><a class="nav-link" href="<?=url("/painel/cargos/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a><?php endif; ?>
                                </nav>
                            </div>

                            <?php if (Auth::check('permissions_view')): ?>
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

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">CONFIGURAÇÕES</div>

                <?php // In a real application, you should wrap this with an Auth check
                // if (Auth::check('menus_view') || Auth::check('submenus_view')): ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="bi bi-columns-gap bi-2xx"></i></div>
                    Menus e Navegação
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionLayouts">
                        
                        <?php // Menus ?>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMenus" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="bi bi-list"></i></div>&nbsp;Menus Principais
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseMenus" data-bs-parent="#sidenavAccordionLayouts">
                            <nav class="sb-sidenav-menu-nested nav">
                                <?php // if (Auth::check('menus_view')): ?>
                                <a class="nav-link" href="<?=url("/painel/menus")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                <?php // endif; ?>
                                <?php // if (Auth::check('menus_create')): ?>
                                <a class="nav-link" href="<?=url("/painel/menus/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                                <?php // endif; ?>
                            </nav>
                        </div>

                        <?php // Submenus ?>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSubmenus" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="bi bi-list-nested"></i></div>&nbsp;Submenus
                            <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseSubmenus" data-bs-parent="#sidenavAccordionLayouts">
                            <nav class="sb-sidenav-menu-nested nav">
                                <?php // if (Auth::check('submenus_view')): ?>
                                <a class="nav-link" href="<?=url("/painel/submenus")?>"><i class="bi bi-list me-2"></i> Listar</a>
                                <?php // endif; ?>
                                <?php // if (Auth::check('submenus_create')): ?>
                                <a class="nav-link" href="<?=url("/painel/submenus/cadastrar")?>"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                                <?php // endif; ?>
                            </nav>
                        </div>

                    </nav>
                </div>
                <?php // endif; ?>

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