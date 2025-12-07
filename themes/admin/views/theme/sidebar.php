<?php

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Shared\Models\Menu;
use Source\Domain\Shared\Models\Submenu;

// Função recursiva para renderizar submenus
function render_submenus($parentId, $accordionId)
{
    $submenus = (new Submenu())->find("parent_id = :parent_id", "parent_id={$parentId}")->order("submenu_order ASC")->fetch(true);

    if (!$submenus) {
        return;
    }

    foreach ($submenus as $submenu) {
        if (Auth::check($submenu->permission_slug)) {
            if ($submenu->hasChildren()) {
                $collapseId = "collapseSubmenu" . $submenu->id;
                echo "<a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#{$collapseId}' aria-expanded='false'>";
                echo "<div class='sb-nav-link-icon'><i class='{$submenu->icon}'></i></div>&nbsp;{$submenu->name}";
                echo "<div class='sb-sidenav-collapse-arrow'><i class='bi bi-chevron-double-down'></i></div>";
                echo "</a>";
                echo "<div class='collapse' id='{$collapseId}' data-bs-parent='#{$accordionId}'>";
                echo "<nav class='sb-sidenav-menu-nested nav accordion' id='sidenavAccordionSub{$submenu->id}'>";
                render_submenus($submenu->id, "sidenavAccordionSub{$submenu->id}");
                echo "</nav>";
                echo "</div>";
            } else {
                echo "<a class='nav-link' href='" . url($submenu->url) . "'><i class='{$submenu->icon} me-2'></i> {$submenu->name}</a>";
            }
        }
    }
}

?>

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
            </div>
            
            <div class="nav">
                <!-- <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">SISTEMA</div> -->
                
                <?php
                $menus = (new Menu())->find()->order("menu_order ASC")->fetch(true);

                foreach ($menus as $menu) {
                    if (Auth::canAccessModule($menu->slug)) {
                        if ($menu->hasSubmenus()) {
                            $collapseId = "collapse" . ucfirst($menu->slug);
                            echo "<a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#{$collapseId}' aria-expanded='false' aria-controls='{$collapseId}'>";
                            echo "<div class='sb-nav-link-icon'><i class='{$menu->icon}'></i></div>";
                            echo $menu->name;
                            echo "<div class='sb-sidenav-collapse-arrow'><i class='bi bi-chevron-double-down'></i></div>";
                            echo "</a>";
                            echo "<div class='collapse' id='{$collapseId}' data-bs-parent='#sidenavAccordion'>";
                            echo "<nav class='sb-sidenav-menu-nested nav accordion' id='sidenavAccordion-{$menu->slug}'>";
                            
                            $topLevelSubmenus = (new Submenu())->find("menu_id = :menu_id AND parent_id IS NULL", "menu_id={$menu->id}")->order("submenu_order ASC")->fetch(true);
                            if ($topLevelSubmenus) {
                                foreach ($topLevelSubmenus as $submenu) {
                                    if(Auth::check($submenu->permission_slug)) {
                                        if ($submenu->hasChildren()) {
                                            $subCollapseId = "collapseSub" . ucfirst($submenu->id);
                                            echo "<a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#{$subCollapseId}' aria-expanded='false'>";
                                            echo "<div class='sb-nav-link-icon'><i class='{$submenu->icon}'></i></div>&nbsp;{$submenu->name}";
                                            echo "<div class='sb-sidenav-collapse-arrow'><i class='bi bi-chevron-double-down'></i></div>";
                                            echo "</a>";
                                            echo "<div class='collapse' id='{$subCollapseId}' data-bs-parent='#sidenavAccordion-{$menu->slug}'>";
                                            echo "<nav class='sb-sidenav-menu-nested nav' id='sidenavAccordion-{$submenu->id}'>";
                                            render_submenus($submenu->id, "sidenavAccordion-{$submenu->id}");
                                            echo "</nav>";
                                            echo "</div>";
                                        } else {
                                            $target = (strpos($submenu->url, 'http') === 0 || strpos($submenu->url, '/') === 0) ? '' : '_blank';
                                            $url = (strpos($submenu->url, 'http') === 0) ? $submenu->url : url($submenu->url);
                                            echo "<a class='nav-link' href='{$url}' target='{$target}'>";
                                            echo "<div class='sb-nav-link-icon'><i class='{$submenu->icon}'></i></div>&nbsp;{$submenu->name}";
                                            echo "</a>";
                                        }
                                    }
                                }
                            }

                            echo "</nav>";
                            echo "</div>";
                        } else {
                            $target = (strpos($menu->url, 'http') === 0 || $menu->url === '/') ? '_blank' : '';
                             $url = ($menu->url === '/' || $menu->url === '/app') ? url($menu->url) : url($menu->url);
                             if ($menu->url === '/painel/logoff') {
                                echo "<a class='nav-link' href='".url("/painel/logoff")."' data-bs-toggle='modal' data-bs-target='#modalSair'>";
                             } else {
                                echo "<a class='nav-link' href='{$url}' target='{$target}'>";
                             }
                             echo "<div class='sb-nav-link-icon'><i class='{$menu->icon}'></i></div>";
                             echo $menu->name;
                             echo "</a>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </nav>
</div>