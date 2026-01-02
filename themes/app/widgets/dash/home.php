<?php 

use Source\Domain\Shared\Models\Auth;

$this->layout("_app"); ?>

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
                <div class="card-body p-1">
                    <iframe 
                        src="https://calendar.google.com/calendar/embed?src=<?=CONF_GOOGLE_CALENDAR_ID?>&ctz=America%2FSao_Paulo"
                        style="border:0;" 
                        frameborder="0" 
                        scrolling="no">
                    </iframe>

                   <div class="container">
                        <div class="row align-items-start">
                            <div class="col">

                                <?php if (Auth::check('events_create')): ?>

                                    <?= button([
                                        "href" => url("/app/eventos/cadastrar"),
                                        "name" => "Adicionar Evento",
                                        "icon" => "plus-circle me-1",
                                        "btncolor" => "success mt-1 mb-1",
                                        "title" => "Cadastrar um novo evento",
                                        "custom" => "custom-tooltip-secondary"
                                    ]); ?>

                                <?php endif; ?>

                            </div>

                            <div class="col">

                                <?php if (Auth::check('events_view')): ?>

                                <?= button([
                                    "href" => url("/app/eventos"),
                                    "name" => "Listar Eventos",
                                    "icon" => "list me-1",
                                    "btncolor" => "primary mt-1 mb-1",
                                    "title" => "Listar eventos",
                                    "custom" => "custom-tooltip-secondary"
                                ]); ?>

                                <?php endif; ?>

                            </div>
                        </div>
                   </div>
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
                        <?= $this->insert("widgets/dash/next-event"); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-12 mb-3 mb-sm-4">
                <?= $this->insert("widgets/dash/your-events"); ?>
            </div>
            
            <div class="col-md-4 col-lg-12 mb-3 mb-sm-5">
                <?= $this->insert("widgets/dash/your-profile"); ?>
            </div>
        </div>
    </div>
</div>