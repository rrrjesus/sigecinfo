

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion bg-<?=CONF_APP_COLOR?>" id="sidenavAccordion">
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
                <?php if(\Source\Domain\Shared\Models\Auth::check('admin_access')): // Sugestão: usar uma permissão nomeada ?>
                    <a class="nav-link" href="<?=url("/painel")?>" data-bs-toggle-tooltip="tooltip" title="Acessar o painel de administração" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right"><div class="sb-nav-link-icon"><i class="bi bi-link-45deg"></i></div>Painel</a>
                <?php endif; ?>
                    <a class="nav-link" href="<?=url("/app/home")?>" data-bs-toggle-tooltip="tooltip" title="Voltar para a página inicial do aplicativo" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right"><div class="sb-nav-link-icon"><i class="bi bi-speedometer"></i></div>
                    Home
                </a>

                <div class="text-white border-bottom pt-3"></div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">GERENCIAMENTO</div>  

                <!-- Sidebar Eventos -->
                <?php if (\Source\Domain\Shared\Models\Auth::canAccessModule('events')): // Padronizando a verificação ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents" data-bs-toggle-tooltip="tooltip" title="Gerenciar eventos" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right">
                        <div class="sb-nav-link-icon"><i class="bi bi-calendar-event"></i></div>
                        Eventos
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-double-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEvents" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if (\Source\Domain\Shared\Models\Auth::check('events_create')): ?>
                                <a class="nav-link" href="<?=url("/app/eventos/cadastrar")?>" data-bs-toggle-tooltip="tooltip" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right" title="Cadastrar um novo evento"><i class="bi bi-plus-circle me-2"></i> Cadastrar</a>
                            <?php endif; ?>

                            <?php if (\Source\Domain\Shared\Models\Auth::check('events_view')): ?>
                                <a class="nav-link" href="<?=url("/app/eventos")?>" data-bs-toggle-tooltip="tooltip" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right" title="Listar todos os eventos"><i class="bi bi-list me-2"></i> Listar</a>
                            <?php endif; ?>
                            <a class="nav-link" href="<?=url("/app/eventos/meus-eventos-agendados")?>" data-bs-toggle-tooltip="tooltip" title="Ver os seus eventos agendados" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right"><i class="bi bi-list me-2"></i> Meus Eventos</a>
                            <a class="nav-link" href="<?=url("/app/eventos/meus-eventos-finalizados")?>" data-bs-toggle-tooltip="tooltip" title="Ver o seu histórico de eventos" data-bs-custom-class="custom-tooltip-secondary" data-bs-placement="right"><i class="bi bi-list me-2"></i> Histórico</a>
                        </nav>
                    </div>
                <?php endif; ?>

                <div class="text-white border-bottom pt-3"></div>

                <div class="sb-sidenav-menu-heading text-light fw-semibold fs-6">UTILIDADES</div>

                <a class="nav-link" href="#" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-secondary" 
                    data-bs-title="Clique para sair do sistema" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <div class="sb-nav-link-icon"><i class="bi bi-box-arrow-right"></i></div>
                    Sair
                </a>

                <div class="text-white border-bottom pt-3"></div>

                <?php
                    echo \Source\Support\Modal::render(
                        "modalSair",
                        CONF_SITE_NAME,
                        "Deseja realmente sair do sistema?",
                        url("/app/logoff"),
                        "Sim, Sair!",
                        "bg-" . CONF_APP_COLOR . " text-white"
                    );
                ?>

            </div>
        </div>
    </nav>
</div>
