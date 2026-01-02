<?php $this->layout("_app"); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Formulário Principal para Check-in -->
        <form class="needs-validation ajax_off" id="checkin-form" action="<?= url("/app/eventos/checkin-page") ?>" method="POST">
            <div class="ajax_response"><?= flash(); ?></div>
            <?= csrf_input(); ?>
            <input type="hidden" id="participant_id" name="participant_id" value="<?= $participant->id; ?>">
            <input type="hidden" id="signature" name="signature">

            <!-- Card de Informações do Participante -->
            <div class="card m-3">
                <div class="card-header bg-<?=CONF_APP_COLOR?> text-white fw-semibold">
                    <i class="bi bi-calendar-event me-2"></i><?= $participant->event()->title; ?>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="<?=($participant->user()->photo) ? url(CONF_UPLOAD_DIR . "/" . $participant->user()->photo) : theme('/assets/images/avatar.jpg', CONF_VIEW_APP); ?>" class="img-fluid rounded-circle shadow-sm mb-2" alt="Foto do Participante" style="max-width: 120px;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="card-title"><?= $participant->user()->user_name.' - '.$participant->user()->position()->position_name; ?></h5>
                            <dl class="row">
                                <dt class="col-sm-3"><i class="bi bi-geo-alt me-2"></i>Comum:</dt>
                                <dd class="col-sm-9"><?= !empty($participant->user()->place()->place_name) ? $participant->user()->place()->place_name : ''; ?></dd>
                                <dt class="col-sm-3"><i class="bi bi-envelope me-2"></i>Email:</dt>
                                <dd class="col-sm-9"><?= $participant->user()->email; ?></dd>
                                <dt class="col-sm-3"><i class="bi bi-telephone me-2"></i>Telefone:</dt>
                                <dd class="col-sm-9"><?= implode(" / ", array_filter([$participant->user()->phone1, $participant->user()->phone2])) ?: 'Não informado'; ?></dd>

                                <?php
                                $status = $participant->status;
                                $statusClass = 'secondary'; // Default
                                if ($status == 'convocado') {
                                    $statusClass = 'primary';
                                } elseif ($status == 'presente') {
                                    $statusClass = 'success';
                                } elseif ($status == 'justificado') {
                                    $statusClass = 'warning';
                                } elseif ($status == 'ausente') {
                                    $statusClass = 'danger';
                                }
                                ?>
                                <dt class="col-sm-3"><i class="bi bi-person-check me-2"></i>Situação:</dt>
                                <dd class="col-sm-9 fw-bold text-<?= $statusClass; ?>"><?= ucfirst($status); ?></dd>
                            </dl>
                        </div>
                    </div>

                    <?php if ($participant->status == 'presente' && $participant->signature): ?>
                        <div class="row align-items-center mt-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Assinatura registrada:</label>
                                <div class="border rounded bg-light text-center p-2">
                                    <img src="<?= url(CONF_UPLOAD_DIR . "/" . $participant->signature) ?>" alt="Assinatura" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Seletor de Status dinâmico -->
                        <div class="m-3">
                            <label class="form-label fw-bold">Alterar Situação do Participante:</label>

                            <?php if ($participant->status == 'justificado'): ?>
                                <p class="mb-2 text-muted">O participante já possui uma justificativa. Caso ele tenha comparecido, você pode registrar a presença.</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_presente" value="presente" checked>
                                    <label class="form-check-label" for="action_presente">Presente (Confirmar Check-in)</label>
                                </div>
                                <div class="form-check" style="display: none;">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_justificado" value="justificado">
                                </div>


                            <?php elseif ($participant->status == 'ausente'): ?>
                                <p class="mb-2 text-muted">O participante está registrado como ausente. Você pode alterar o status.</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_presente" value="presente" checked>
                                    <label class="form-check-label" for="action_presente">Presente (Confirmar Check-in)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_justificado" value="justificado">
                                    <label class="form-check-label" for="action_justificado">Justificar Ausência</label>
                                </div>
                                <div class="form-check" style="display: none;">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_ausente" value="ausente">
                                </div>
                           
                            <?php else: // Para 'convocado' ou 'presente' sem assinatura ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_presente" value="presente" checked>
                                    <label class="form-check-label" for="action_presente">Presente (Confirmar Check-in)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_justificado" value="justificado">
                                    <label class="form-check-label" for="action_justificado">Justificar Ausência</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_action" id="action_ausente" value="ausente">
                                    <label class="form-check-label" for="action_ausente">Declarar Ausência</label>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Área da Assinatura (inicialmente visível) -->
                        <div id="signature-block">
                            <div class="row align-items-center px-3">
                                <div class="col-md-12">
                                    <label class="form-label">Por favor, assine no campo abaixo:</label>
                                    <div class="canvas-container border rounded bg-light">
                                        <canvas id="signature-canvas" style="width: 100%; height: 200px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($participant->status == 'presente' && $participant->signature): ?>
                    <div class="card-footer text-center d-flex justify-content-center">
                        <div class="row">
                            <div class="d-flex">
                                <div class="alert alert-success d-inline-block me-3" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Check-in confirmado em <?= (new DateTime($participant->checkin_at))->format("d/m/Y H:i"); ?>
                                </div>
                                <div>
                                <?= button([
                                    "href" => url("/app/eventos/portaria/{$participant->event()->id}"),
                                    "name" => "Voltar",
                                    "icon" => "arrow-left-circle",
                                    "btncolor" => "secondary",
                                    "title" => "Voltar",
                                    "class" => "me-2"
                                ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Rodapé com Botões Dinâmicos -->
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>
                            <?= button([
                                "href" => url("/app/eventos/portaria/{$participant->event()->id}"),
                                "name" => "Listar",
                                "icon" => "list",
                                "btncolor" => "primary",
                                "title" => "Listar"
                            ]); ?>
                        </div>
                        <div class="d-flex">
                            <!-- Botões para status 'presente' -->
                            <div id="presente-actions">
                                <?= button([
                                    "type" => "button",
                                    "id" => "clear-signature",
                                    "name" => "Limpar",
                                    "icon" => "eraser me-1",
                                    "btncolor" => "secondary",
                                    "title" => "Limpar a área de assinatura",
                                    "class" => "me-2"
                                ]); ?>
                                <?= button([
                                    "type" => "submit",
                                    "id" => "confirm-checkin",
                                    "name" => "Confirmar Check-in",
                                    "icon" => "check-lg me-1",
                                    "btncolor" => "success",
                                    "title" => "Confirmar o check-in do participante"
                                ]); ?>
                            </div>

                            <!-- Botão para status 'justificado' -->
                            <div id="justificado-actions" style="display: none;">
                                <?= button([
                                    "id" => "justify-absence",
                                    "name" => "Justificar Ausência",
                                    "icon" => "x-circle me-1",
                                    "btncolor" => "warning",
                                    "class" => "text-dark-emphasis",
                                    "title" => "Justificar ausência no evento",
                                    "data-bs-toggle" => "modal",
                                    "data-bs-target" => "#justifyModal"
                                ]); ?>
                            </div>

                             <!-- Botão para status 'ausente' -->
                             <div id="ausente-actions" style="display: none;">
                                <?= button([
                                    "type" => "submit",
                                    "form" => "absence-form",
                                    "id" => "confirm-absence",
                                    "name" => "Confirmar Ausência",
                                    "icon" => "slash-circle me-1",
                                    "btncolor" => "danger",
                                    "title" => "Confirmar ausência sem justificativa"
                                ]); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </form>

        <!-- Formulário para Marcar Ausência (fica fora do card) -->
        <form id="absence-form" class="ajax_form" action="<?= url("/app/eventos/marcar-ausencia") ?>" method="POST" style="display: none;">
            <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
        </form>
    </div>
</div>

<!-- Modal de Justificativa -->
<?php
$formContent = <<<HTML
    <p>Por favor, descreva o motivo da sua ausência no evento "{$participant->event()->title}".</p>
    <input type="hidden" name="participant_id" value="{$participant->id}">
    <textarea name="justification" class="form-control" rows="4" required></textarea>
HTML;

echo \Source\Support\Modal::renderForm(
    "justifyModal",
    "Justificar Ausência",
    url("/app/eventos/justificar"),
    $formContent,
    "Enviar Justificativa"
);
?>

<?php if (!($participant->status == 'presente' && $participant->signature)): ?>
    <?php $this->start("scripts"); ?>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicialização do Signature Pad
            var canvas = document.getElementById('signature-canvas');
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)'
            });

            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            $('#clear-signature').on('click', function() {
                signaturePad.clear();
            });

            // Lógica unificada de submissão do formulário para check-in
            function handleCheckinSubmit(e) {
                // A validação da assinatura só se aplica se a ação for 'presente'
                if ($('input[name="status_action"]:checked').val() === 'presente') {
                    if (signaturePad.isEmpty()) {
                        e.preventDefault(); // Impede a submissão se a assinatura estiver vazia
                        var message = "<div class='alert alert-danger text-center fw-semibold'><i class='bi bi-exclamation-octagon me-2'></i> Por favor, forneça a assinatura para continuar.</div>";
                        $('.ajax_response').html(message).show();
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        return;
                    }
                    // Se a assinatura estiver preenchida, adiciona ao formulário
                    $('#signature').val(signaturePad.toDataURL('image/png'));
                }
                // Para outras ações, o formulário principal não deve fazer nada,
                // pois elas são tratadas por outros formulários ou modais.
            }

            // Lógica para alternar a UI baseada no status selecionado
            $('input[name="status_action"]').on('change', function() {
                var selectedStatus = $(this).val();

                // Oculta todos os elementos de ação e a assinatura por padrão
                $('#signature-block').hide();
                $('#presente-actions').hide();
                $('#justificado-actions').hide();
                $('#ausente-actions').hide();

                // Desvincula o handler de submissão para evitar comportamento inesperado
                $('#checkin-form').off('submit', handleCheckinSubmit);

                if (selectedStatus === 'presente') {
                    // Mostra a assinatura e as ações de 'presente'
                    $('#signature-block').show();
                    $('#presente-actions').show();
                    // Vincula o handler de submissão APENAS para o caso 'presente'
                    $('#checkin-form').on('submit', handleCheckinSubmit);
                } else if (selectedStatus === 'justificado') {
                    // Mostra apenas as ações de 'justificado'
                    $('#justificado-actions').show();
                } else if (selectedStatus === 'ausente') {
                    // Mostra apenas as ações de 'ausente'
                    $('#ausente-actions').show();
                }
            });
            
            // Dispara o evento change no carregamento para definir o estado inicial correto
            $('input[name="status_action"]:checked').trigger('change');
        });
    </script>
    <?php $this->end(); ?>
<?php endif; ?>
