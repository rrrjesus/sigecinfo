<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">

            <div class="ajax_response"><?= flash(); ?></div>

             <?php // NOVO: Bloco de Alerta para Reunião Ao Vivo
            if (!empty($isLive)): ?>
                <div class="alert alert-danger text-center fw-bold fs-5 shadow-sm" role="alert">
                    <span class="spinner-grow spinner-grow-sm me-2" role="status" aria-hidden="true"></span>
                    REUNIÃO AO VIVO
                    <span class="spinner-grow spinner-grow-sm ms-2" role="status" aria-hidden="true"></span>
                    
                    <?php // Botão de acesso (só aparece se o acesso for permitido pelo horário)
                    if ($canAccess && !empty($event->meeting_url)): ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-2">
                             <a href="<?= $event->meeting_url; ?>" target="_blank" class="btn btn-dark fw-semibold"><i class="bi bi-box-arrow-up-right me-2"></i> ACESSAR REUNIÃO</a>
                        </div>
                    <?php elseif ($canAccess): ?>
                        <p class="small fw-normal mt-2 mb-0">URL da reunião não definida.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!$event): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="eventCreate" novalidate action="<?= url("/painel/eventos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="eventUpdate" novalidate action="<?= url("/painel/eventos/editar/{$event->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>

                    <?= csrf_input(); ?>

                    <!-- Event Info Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-calendar-event me-1"></i> Informações do Evento</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="title"><strong>Título do Evento</strong></label>
                                    <input type="text" id="title" name="title" class="form-control form-control-sm" value="<?= $event->title ?? ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="type_id"><strong>Tipo de Evento</strong></label>
                                    <select id="type_id" name="type_id" class="form-select form-select-sm" required>
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($eventTypes)): foreach ($eventTypes as $type): ?>
                                            <option value="<?= $type->id; ?>" <?= !empty($event) && $event->type_id == $type->id ? 'selected' : ''; ?>><?= $type->name; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="col-form-label col-form-label-sm"><strong>Descrição</strong></label>
                                    <textarea id="description" name="description" class="form-control form-control-sm" rows="3"><?= $event->description ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date and Location Card -->
                    <div class="card mb-2">
                        <div class="card-header fw-bold"><i class="bi bi-geo-alt me-1"></i> Data e Local</div>
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="start_at"><strong>Data e Hora de Início</strong></label>
                                    <input type="datetime-local" id="start_at" name="start_at" class="form-control form-control-sm" value="<?= !empty($event->start_at) ? (new DateTime($event->start_at))->format('Y-m-d\TH:i') : ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="end_at"><strong>Data e Hora de Término</strong> (Opcional)</label>
                                    <input type="datetime-local" id="end_at" name="end_at" class="form-control form-control-sm" value="<?= !empty($event->end_at) ? (new DateTime($event->end_at))->format('Y-m-d\TH:i') : ''; ?>">
                                </div>
                                <?php if ($event): ?>
                                    <div class="col-md-4 mb-1">
                                        <label class="col-form-label col-form-label-sm" for="status"><strong>Status</strong></label>
                                        <select id="status" name="status" class="form-select form-select-sm">
                                            <option value="scheduled" <?= $event->status == 'scheduled' ? 'selected' : ''; ?>>Agendado</option>
                                            <option value="done" <?= $event->status == 'done' ? 'selected' : ''; ?>>Realizado</option>
                                            <option value="canceled" <?= $event->status == 'canceled' ? 'selected' : ''; ?>>Cancelado</option>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-6 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="church_id"><strong>Local (Igreja)</strong> (Opcional)</label>
                                    <select id="church_id" name="church_id" class="form-select form-select-sm">
                                        <option value="">Selecione uma igreja...</option>
                                        <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                            <option value="<?= $church->id; ?>" <?= !empty($event) && $event->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="location_text"><strong>Ou digite um local</strong> (Ex: Salão de Festas)</label>
                                    <input type="text" id="location_text" name="location_text" class="form-control form-control-sm" value="<?= $event->location_text ?? ''; ?>">
                                </div>

                                <div class="col-md-12 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="meeting_url"><strong>URL da Reunião</strong> (Opcional)</label>
                                    <input type="url" id="meeting_url" name="meeting_url" class="form-control form-control-sm" placeholder="https://meet.google.com/..." value="<?= $event->meeting_url ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-center">
                            <?php if (!empty($canStart)): ?>
                                <?= button(["href" => "/painel/eventos/iniciar/{$event->id}", "name" => "Iniciar", "icon" => "play-circle", "btncolor" => "success"]); ?>
                            <?php endif; ?>
                            
                            <?php if (!empty($isLive)): ?>
                                <?=$modalFim?>
                                <?= button(["name" => "Finalizar Reunião", "icon" => "stop-circle", "btncolor" => "danger", "type" => "button", "data-bs-toggle" => "modal", "data-bs-target" => "#confirmFinishModal"]); ?>
                            <?php endif; ?>

                            <?= button(["type" => "submit", "name" => ($event ? "Atualizar" : "Registrar"), "icon" => "check-circle", "btncolor" => ($event ? "primary" : "success")]); ?>
                            <?= button(["href" => "/painel/eventos", "name" => "Listar", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
