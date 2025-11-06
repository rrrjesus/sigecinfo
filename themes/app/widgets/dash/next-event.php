<?php if ($nextEvent): ?>
    <h5 class="card-title"><?= $nextEvent->title; ?></h5>
    <p class="card-text mb-3">
        <strong>Data:</strong> <?= date_fmt($nextEvent->start_at, "d/m/Y \à\s H:i"); ?><br>
        <strong>Local:</strong> <?= $nextEvent->church()->church_name ?? $nextEvent->location_text ?? 'A definir'; ?><br>
        <?php if ($participant && $participant->status == 'justificado'): ?>
            <strong>Justificativa:</strong> <?= $participant->justification ?? ''; ?>
        <?php endif; ?>
    </p>

    <div class="mt-auto">
        <?php if ($participant && $participant->status == 'justificado'): ?>
            <?= button([
                "name" => "Editar Justificativa",
                "icon" => "pencil m-1",
                "btncolor" => "warning",
                "class" => "rounded-circle text-dark-emphasis",
                "data-bs-toggle" => "modal",
                "data-bs-target" => "#justifyModal{$participant->id}",
                "title" => "Editar Justificatica do Evento",
                "custom" => "custom-tooltip-secondary"
            ]); ?>

            <?php
                $formContent = <<<HTML
                    <p>Por favor, descreva o motivo da sua ausência no evento "{$nextEvent->title}".</p>
                    <input type="hidden" name="participant_id" value="{$participant->id}">
                    <textarea name="justification" class="form-control" rows="4" required></textarea>
                    HTML;

                echo \Source\Support\Modal::renderForm(
                    "justifyModal{$participant->id}",
                    "Justificar Falta",
                    url("/app/eventos/justificar"),
                    $formContent,
                    "Enviar Justificativa"
                );
            ?>

            <form class="ajax_off" style="display: inline;" action="<?= url("/app/eventos/confirmar"); ?>" method="post">
                <?= csrf_input(); ?>
                <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                <?= button([
                    "name" => "Confirmar Presença",
                    "icon" => "check-circle m-1",
                    "btncolor" => "success",
                    "class" => "m-1 p-1",
                    "title" => "Confirmar presença no evento",
                    "custom" => "custom-tooltip-secondary",
                    "type" => "submit"
                ]); ?>
            </form>
        <?php elseif ($participant && $participant->status == 'confirmado'): ?>
            <?= button([
                "name" => "Gerar QR Code",
                "icon" => "qr-code m-1",
                "btncolor" => "info",
                "class" => "text-dark-emphasis",
                "href" => "/app/eventos/qrcode-checkin/{$participant->id}",
                "title" => "Gerar QR Code para check-in",
                "custom" => "custom-tooltip-secondary"
            ]); ?>

            <?= button([
                    "name" => "Justificar Falta",
                    "icon" => "pencil m-1",
                    "btncolor" => "warning",
                    "class" => "rounded-circle text-dark-emphasis",
                    "data-bs-toggle" => "modal",
                    "data-bs-target" => "#justifyModal{$participant->id}",
                    "title" => "Editar Justificatica do Evento",
                    "custom" => "custom-tooltip-secondary"
                ]); ?>

                <?php
                    $formContent = <<<HTML
                        <p>Por favor, descreva o motivo da sua ausência no evento "{$nextEvent->title}".</p>
                        <input type="hidden" name="participant_id" value="{$participant->id}">
                        <textarea name="justification" class="form-control" rows="4" required></textarea>
                        HTML;

                    echo \Source\Support\Modal::renderForm(
                        "justifyModal{$participant->id}",
                        "Justificar Falta",
                        url("/app/eventos/justificar"),
                        $formContent,
                        "Enviar Justificativa"
                    );
                ?>
        <?php elseif ($participant && $participant->status == 'convocado'): ?>
            <form class="ajax_off" style="display: inline;" action="<?= url("/app/eventos/confirmar"); ?>" method="post">
                <?= csrf_input(); ?>
                <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                <?= button([
                    "name" => "Confirmar",
                    "icon" => "check-circle m-1",
                    "btncolor" => "success",
                    "class" => "m-1 p-1",
                    "title" => "Confirmar presença no evento",
                    "custom" => "custom-tooltip-secondary",
                    "type" => "submit"
                ]); ?>
            </form>

            <?= button([
                    "name" => "Justificar Falta",
                    "icon" => "pencil m-1",
                    "btncolor" => "warning",
                    "class" => "rounded-circle text-dark-emphasis",
                    "data-bs-toggle" => "modal",
                    "data-bs-target" => "#justifyModal{$participant->id}",
                    "title" => "Editar Justificatica do Evento",
                    "custom" => "custom-tooltip-secondary"
                ]); ?>

                <?php
                    $formContent = <<<HTML
                        <p>Por favor, descreva o motivo da sua ausência no evento "{$nextEvent->title}".</p>
                        <input type="hidden" name="participant_id" value="{$participant->id}">
                        <textarea name="justification" class="form-control" rows="4" required></textarea>
                        HTML;

                    echo \Source\Support\Modal::renderForm(
                        "justifyModal{$participant->id}",
                        "Justificar Falta",
                        url("/app/eventos/justificar"),
                        $formContent,
                        "Enviar Justificativa"
                    );
                ?>
        <?php elseif ($participant && $participant->status == 'presente'): ?>
            <?php 
                switch ($nextEvent->status) {
                    case 'agendado':
                        echo '<h5><span class="badge fw-semibold text-bg-primary p-2">Agendado</span></h5>';
                        break;
                    case 'realizado':
                        echo '<h5><span class="badge fw-semibold text-bg-success text-white p-2">Realizado</span></h5>';
                        break;
                    case 'ao vivo':
                        echo '<h5><span class="badge fw-semibold text-bg-danger p-2"><i class="bi bi-broadcast me-1"></i>Ao Vivo</span></h5>';
                        break;
                    case 'cancelado':
                        echo '<h5><span class="badge fw-semibold text-bg-danger p-2">Cancelado</span></h5>';
                        break;
                    default:
                        echo '<h5><span class="badge fw-semibold text-bg-dark p-2">Indefinido</span></h5>';
                        break;
                }
            ?>

            <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Presente</span></h5>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p class="card-text text-muted my-auto text-center">Você não tem nenhum evento agendado no momento.</p>
<?php endif; ?>