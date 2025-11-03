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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div id="datepicker-container"></div>
                        </div>
                        <div class="col-md-5 d-flex flex-column">
                            <?php if ($nextEvent): ?>
                                <h5 class="card-title"><?= $nextEvent->title; ?></h5>
                                <p class="card-text">
                                    <strong>Data:</strong> <?= date_fmt($nextEvent->start_at, "d/m/Y \à\s H:i"); ?><br>
                                    <strong>Local:</strong> <?= $nextEvent->church()->church_name ?? $nextEvent->location_text ?? 'A definir'; ?>
                                </p>
                                <a href="<?= url("/beta/eventos/meus-eventos-agendados"); ?>" class="btn btn-primary mt-auto">Ver detalhes</a>
                            <?php else: ?>
                                <p class="card-text text-muted my-auto text-center">Você não tem nenhum evento agendado no momento.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div id="datepicker-container"></div>
                        </div>
                        <div class="col-md-5 d-flex flex-column">
                            <?php if ($nextEvent): ?>
                                <h5 class="card-title"><?= $nextEvent->title; ?></h5>
                                <p class="card-text">
                                    <strong>Data:</strong> <?= date_fmt($nextEvent->start_at, "d/m/Y \à\s H:i"); ?><br>
                                    <strong>Local:</strong> <?= $nextEvent->church()->church_name ?? $nextEvent->location_text ?? 'A definir'; ?>
                                </p>
                                <a href="<?= url("/beta/eventos/meus-eventos-agendados"); ?>" class="btn btn-primary mt-auto">Ver detalhes</a>
                            <?php else: ?>
                                <p class="card-text text-muted my-auto text-center">Você não tem nenhum evento agendado no momento.</p>
                            <?php endif; ?>
                        </div>
                    </div>
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
                             <a href="<?= url("/beta/eventos/meus-eventos-agendados"); ?>" class="btn btn-outline-secondary me-2">Ver Agendados</a>
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

<?php $this->start("scripts"); ?>
<script>
$(function () {
    $("#datepicker-container").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
});
</script>
<?php $this->end(); ?>

<style>
    /* Estilização para o datepicker se assemelhar ao Bootstrap */
    .ui-datepicker {
        width: 100%;
        padding: 0;
        border: none;
        background: transparent;
    }
    .ui-datepicker .ui-datepicker-header {
        background: #0d6efd; /* Cor primária do Bootstrap */
        color: #ffffff;
        border: none;
        border-radius: 0.25rem 0.25rem 0 0;
        padding: 0.5rem 0;
    }
    .ui-datepicker .ui-datepicker-title {
        margin: 0;
        font-weight: bold;
    }
    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        top: 0.5rem;
        color: #ffffff;
        border: none;
        background: transparent;
    }
     .ui-datepicker .ui-datepicker-prev:hover,
    .ui-datepicker .ui-datepicker-next:hover {
        background: #0b5ed7;
    }
    .ui-datepicker .ui-datepicker-prev span,
    .ui-datepicker .ui-datepicker-next span {
        display: block;
        margin: -0.5rem;
    }
    .ui-datepicker table {
        width: 100%;
        margin: 0;
    }
    .ui-datepicker th {
        padding: 0.5rem 0;
        text-align: center;
        font-weight: bold;
        color: #6c757d; /* Cor de texto secundária do Bootstrap */
    }
    .ui-datepicker td {
        padding: 0;
    }
    .ui-datepicker td a {
        padding: 0.5rem 0;
        text-align: center;
        display: block;
        text-decoration: none;
        color: #212529;
        border: 1px solid transparent;
    }
    .ui-datepicker td a:hover {
        background: #e9ecef; /* Cor de fundo suave do Bootstrap */
        border-radius: 0.25rem;
    }
    .ui-datepicker .ui-datepicker-current-day a {
        background: #0d6efd;
        color: #ffffff;
        border-radius: 0.25rem;
    }
</style>

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
                             <a href="<?= url("/beta/eventos/meus-eventos-agendados"); ?>" class="btn btn-outline-secondary me-2">Ver Agendados</a>
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

<?php $this->start("scripts"); ?>
<script>
$(function () {
    $("#datepicker-container").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
});
</script>
<?php $this->end(); ?>

<style>
    /* Estilização para o datepicker se assemelhar ao Bootstrap */
    .ui-datepicker {
        width: 100%;
        padding: 0;
        border: none;
        background: transparent;
    }
    .ui-datepicker .ui-datepicker-header {
        background: #0d6efd; /* Cor primária do Bootstrap */
        color: #ffffff;
        border: none;
        border-radius: 0.25rem 0.25rem 0 0;
        padding: 0.5rem 0;
    }
    .ui-datepicker .ui-datepicker-title {
        margin: 0;
        font-weight: bold;
    }
    .ui-datepicker .ui-datepicker-prev,
    .ui-datepicker .ui-datepicker-next {
        top: 0.5rem;
        color: #ffffff;
        border: none;
        background: transparent;
    }
     .ui-datepicker .ui-datepicker-prev:hover,
    .ui-datepicker .ui-datepicker-next:hover {
        background: #0b5ed7;
    }
    .ui-datepicker .ui-datepicker-prev span,
    .ui-datepicker .ui-datepicker-next span {
        display: block;
        margin: -0.5rem;
    }
    .ui-datepicker table {
        width: 100%;
        margin: 0;
    }
    .ui-datepicker th {
        padding: 0.5rem 0;
        text-align: center;
        font-weight: bold;
        color: #6c757d; /* Cor de texto secundária do Bootstrap */
    }
    .ui-datepicker td {
        padding: 0;
    }
    .ui-datepicker td a {
        padding: 0.5rem 0;
        text-align: center;
        display: block;
        text-decoration: none;
        color: #212529;
        border: 1px solid transparent;
    }
    .ui-datepicker td a:hover {
        background: #e9ecef; /* Cor de fundo suave do Bootstrap */
        border-radius: 0.25rem;
    }
    .ui-datepicker .ui-datepicker-current-day a {
        background: #0d6efd;
        color: #ffffff;
        border-radius: 0.25rem;
    }
</style>
