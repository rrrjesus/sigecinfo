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
                "icon" => "calendar-check me-1",
                "class" => "text-dark-emphasis",
                "btncolor" => "info",
                "title" => "Ver seus eventos agendados",
                "custom" => "custom-tooltip-secondary"
            ]); ?>
            <?= button([
                "href" => "/app/eventos/meus-eventos-finalizados",
                "name" => "Ver Histórico",
                "icon" => "clock-history me-1",
                "class" => "text-dark-emphasis",
                "btncolor" => "secondary",
                "title" => "Ver o histórico dos seus eventos",
                "custom" => "custom-tooltip-secondary"
            ]); ?>
        </div>
    </div>
</div>
