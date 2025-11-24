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

                <?php if (Auth::check('events')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                        <div class="sb-nav-link-icon"><i class="bi bi-calendar-event bi-2xx"></i></div>
                        Eventos
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEvents" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionEvents">
                            <?php render_collapsible_submenu('eventsSub', '#sidenavAccordionEvents', 'Agenda', 'eventos', 'events_view', 'events_create'); ?>
                            <?php render_collapsible_submenu('typesSub', '#sidenavAccordionEvents', 'Tipo de Eventos', 'tipos-de-eventos', 'event_types_view', 'event_types_create'); ?>
                            <?php render_collapsible_submenu('placesSub', '#sidenavAccordionEvents', 'Locais', 'locais', 'places_view', 'places_create'); ?>
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
                            <?php render_collapsible_submenu('collapseUser', '#sidenavAccordionUsers', 'Usuários', 'usuarios', 'users_view', 'users_create', 'bi-person'); ?>

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

                            <?php render_collapsible_submenu('collapseUsersPositions', '#sidenavAccordionUsers', 'Cargos', 'cargos', 'positions_view', 'positions_create', 'bi-briefcase'); ?>

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