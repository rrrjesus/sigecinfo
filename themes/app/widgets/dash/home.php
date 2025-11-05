<?php $this->layout("_app"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <style>
    iframe {
        width: 100%;
        min-height: 500px;
        border: none;
        border-radius: 6px;
    }
    
  </style>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="ajax_response"><?= flash(); ?></div>
            <h3>Olá, <?= $user->user_name; ?>!</h3>
            <p class="lead text-muted">Bem-vindo(a) à sua área pessoal no SIGECINFO.</p>
            <hr>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-7 col-lg-8 mb-3 mb-sm-0">
            <div class="card h-auto ">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex align-items-start fw-semibold">
                    <i class="bi bi-calendar-week me-2"></i> Agenda
                </div>
                <div class="card-body">
                   
                        <iframe 
                            src="https://calendar.google.com/calendar/embed?src=<?=CONF_GOOGLE_CALENDAR_ID?>&ctz=America%2FSao_Paulo"
                            style="border:0;" 
                            frameborder="0" 
                            scrolling="no">
                        </iframe>
                    

                    <?php if (in_array($user->level_id, [4, 5])): ?>
                        <?= button([
                            "href" => "/app/eventos/cadastrar",
                            "name" => "Adicionar Evento",
                            "icon" => "plus-circle me-1",
                            "btncolor" => "success mt-3",
                            "title" => "Cadastrar um novo evento",
                            "custom" => "custom-tooltip-secondary"
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div class="col-md-4 col-lg-12 mb-3 mb-sm-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex align-items-start fw-semibold">
                        <i class="bi bi-calendar-week me-2"></i> Próximo Evento
                    </div>
                
                    <div class="card-body d-flex flex-column">
                        <?php if ($nextEvent): ?>
                                    <h5 class="card-title"><?= $nextEvent->title; ?></h5>
                                    <p class="card-text">
                                        <strong>Data:</strong> <?= date_fmt($nextEvent->start_at, "d/m/Y \à\s H:i"); ?><br>
                                        <strong>Local:</strong> <?= $nextEvent->church()->church_name ?? $nextEvent->location_text ?? 'A definir'; ?>
                                    </p>
                                    <?= button([
                                        "href" => "/app/eventos/meus-eventos-agendados",
                                        "name" => "Ver detalhes",
                                        "icon" => "eye me-1", // Corrigido para um ícone válido
                                        "btncolor" => "primary", // Corrigido para uma cor válida do Bootstrap
                                        "title" => "Ver detalhes do próximo evento",
                                        "custom" => "custom-tooltip-secondary"
                                    ]); ?>
                        <?php else: ?>
                            <p class="card-text text-muted my-auto text-center">Você não tem nenhum evento agendado no momento.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-12 mb-3 mb-sm-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex align-items-start fw-semibold">
                        <i class="bi bi-list-check me-2"></i> Os Seus Eventos
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text">
                            Você tem <strong><?= $eventCounts->active; ?></strong> evento(s) agendado(s) e um histórico de 
                            <strong><?= $eventCounts->completed; ?></strong> evento(s) já realizado(s).
                        </p>
                        <div class="mt-auto">
                            <?= button([
                                "href" => "/app/eventos/meus-eventos-agendados",
                                "name" => "Ver Agendados",
                                "icon" => "calendar-check me-1", // Corrigido para um ícone válido
                                "btncolor" => "info",
                                "title" => "Ver seus eventos agendados",
                                "custom" => "custom-tooltip-secondary"
                            ]); ?>
                            <?= button([
                                "href" => "/app/eventos/meus-eventos-finalizados",
                                "name" => "Ver Histórico",
                                "icon" => "clock-history me-1", // Corrigido para um ícone válido
                                "btncolor" => "dark",
                                "title" => "Ver o histórico dos seus eventos",
                                "custom" => "custom-tooltip-secondary"
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-12 mb-3 mb-sm-5">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-<?=CONF_APP_COLOR?> text-white d-flex align-items-start fw-semibold">
                    <i class="bi bi-person-circle me-2"></i> O Seu Perfil
                    </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text">Mantenha os seus dados de contacto e senha sempre atualizados.</p>
                    <div class="mt-auto">
                        <?= button([
                            "href" => "/app/perfil",
                            "name" => "Editar Perfil",
                            "icon" => "pencil-square me-1", // Corrigido para um ícone válido
                            "btncolor" => "warning",
                            "title" => "Acessar e editar seu perfil",
                            "custom" => "custom-tooltip-secondary"
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
