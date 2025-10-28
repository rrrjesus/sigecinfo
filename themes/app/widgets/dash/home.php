<?php $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>


<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="ajax_response"><?= flash(); ?></div>
            <h3>Olá, <?= $user->user_name; ?>!</h3>
            <p class="lead text-muted">Bem-vindo(a) à sua área pessoal no SIGECINFO.</p>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-calendar-event me-2"></i> O Seu Próximo Evento
                </div>
                <div class="card-body d-flex flex-column">
                    <?php if ($nextEvent): ?>
                        <h5 class="card-title"><?= $nextEvent->title; ?></h5>
                        <p class="card-text">
                            <strong>Data:</strong> <?= date_fmt($nextEvent->start_at, "d/m/Y \à\s H:i"); ?><br>
                            <strong>Local:</strong> <?= $nextEvent->church()->church_name ?? $nextEvent->location_text ?? 'A definir'; ?>
                        </p>
                        <a href="<?= url("/beta/eventos/meus-eventos"); ?>" class="btn btn-primary mt-auto">Ver detalhes e confirmar presença</a>
                    <?php else: ?>
                        <p class="card-text text-muted my-auto text-center">Você não tem nenhum evento agendado no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card h-100 shadow-sm">
                         <div class="card-header fw-bold">
                            <i class="bi bi-list-check me-2"></i> Os Seus Eventos
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Você tem <strong><?= $eventCounts->active; ?></strong> evento(s) agendado(s) e um histórico de 
                                <strong><?= $eventCounts->completed; ?></strong> evento(s) já realizado(s).
                            </p>
                             <a href="<?= url("/beta/eventos/meus-eventos"); ?>" class="btn btn-outline-secondary me-2">Ver Agendados</a>
                             <a href="<?= url("/beta/eventos/meus-eventos-finalizados"); ?>" class="btn btn-outline-secondary">Ver Histórico</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card h-100 shadow-sm">
                         <div class="card-header fw-bold">
                            <i class="bi bi-person-circle me-2"></i> O Seu Perfil
                        </div>
                        <div class="card-body">
                           <p class="card-text">Mantenha os seus dados de contacto e senha sempre atualizados.</p>
                           <a href="<?= url('/beta/perfil'); ?>" class="btn btn-outline-secondary">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>