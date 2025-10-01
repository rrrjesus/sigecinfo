<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$event): // MODO DE CRIAÇÃO ?>
                <form id="eventForm" novalidate action="<?= url("/painel/eventos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form id="eventForm" novalidate action="<?= url("/painel/eventos/editar/{$event->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label"><strong>Título do Evento</strong></label>
                            <input type="text" id="title" name="title" class="form-control" value="<?= $event->title ?? ''; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="type_id" class="form-label"><strong>Tipo de Evento</strong></label>
                            <select id="type_id" name="type_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php if (!empty($eventTypes)): foreach ($eventTypes as $type): ?>
                                    <option value="<?= $type->id; ?>" <?= !empty($event) && $event->type_id == $type->id ? 'selected' : ''; ?>><?= $type->name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label"><strong>Descrição</strong></label>
                            <textarea id="description" name="description" class="form-control" rows="4"><?= $event->description ?? ''; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-end">
                        <div class="col-md-4">
                            <label for="start_at" class="form-label"><strong>Data e Hora de Início</strong></label>
                            <input type="datetime-local" id="start_at" name="start_at" class="form-control" value="<?= !empty($event->start_at) ? (new DateTime($event->start_at))->format('Y-m-d\TH:i') : ''; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_at" class="form-label"><strong>Data e Hora de Término</strong> (Opcional)</label>
                            <input type="datetime-local" id="end_at" name="end_at" class="form-control" value="<?= !empty($event->end_at) ? (new DateTime($event->end_at))->format('Y-m-d\TH:i') : ''; ?>">
                        </div>
                         <?php if ($event): ?>
                            <div class="col-md-4">
                                <label for="status" class="form-label"><strong>Status</strong></label>
                                <select id="status" name="status" class="form-select">
                                    <option value="scheduled" <?= $event->status == 'scheduled' ? 'selected' : ''; ?>>Agendado</option>
                                    <option value="done" <?= $event->status == 'done' ? 'selected' : ''; ?>>Realizado</option>
                                    <option value="canceled" <?= $event->status == 'canceled' ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="church_id" class="form-label"><strong>Local (Igreja)</strong> (Opcional)</label>
                            <select id="church_id" name="church_id" class="form-select">
                                <option value="">Selecione uma igreja...</option>
                                <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                    <option value="<?= $church->id; ?>" <?= !empty($event) && $event->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location_text" class="form-label"><strong>Ou digite um local</strong> (Ex: Salão de Festas)</label>
                            <input type="text" id="location_text" name="location_text" class="form-control" value="<?= $event->location_text ?? ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                             <label for="cover" class="form-label"><strong>Imagem de Capa</strong> (Opcional)</label>
                             <input class="form-control" type="file" id="cover" name="cover">
                        </div>
                        <?php if ($event && $event->cover): ?>
                            <div class="col-md-6">
                                <p class="mb-1">Imagem Atual:</p>
                                <img src="<?= image($event->cover, 200, 100); ?>" alt="Capa" class="img-thumbnail">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <?= button(["name" => ($event ? "Atualizar Evento" : "Registar Evento"), "icon" => "check-circle", "btncolor" => ($event ? "primary" : "success")]); ?>
                            <?= button(["href" => "/painel/eventos", "name" => "Listar Todos", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>