<?php $this->layout("_app"); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form class="needs-validation ajax_off" id="checkin-form" action="<?= url("/app/eventos/checkin-page") ?>" method="POST">
            <div class="ajax_response"><?= flash(); ?></div>
            <?= csrf_input(); ?>
            <input type="hidden" id="participant_id" name="participant_id" value="<?= $participant->id; ?>">
            <input type="hidden" id="signature" name="signature">

            <!-- Participant Info Card -->
            <div class="card m-3">
                <div class="card-header fw-bold">
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
                                <dt class="col-sm-3"><i class="bi bi-envelope me-2"></i>Email:</dt>
                                <dd class="col-sm-9"><?= $participant->user()->email; ?></dd>

                                <dt class="col-sm-3"><i class="bi bi-telephone me-2"></i>Telefone:</dt>
                                <dd class="col-sm-9"><?= implode(" / ", array_filter([$participant->user()->phone1, $participant->user()->phone2])) ?: 'Não informado'; ?></dd>
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
                        <div class="row align-items-center mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Por favor, assine no campo abaixo:</label>
                                <div class="canvas-container border rounded bg-light">
                                    <canvas id="signature-canvas" style="width: 100%; height: 200px;"></canvas>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($participant->status == 'presente' && $participant->signature): ?>
                    <div class="card-footer text-center">
                        <div class="alert alert-success mb-0" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Check-in confirmado em <?= (new DateTime($participant->checkin_at))->format("d/m/Y H:i"); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card-footer d-flex justify-content-between">
                        <?= button([
                            "type" => "button",
                            "id" => "clear-signature",
                            "name" => "Limpar",
                            "icon" => "eraser",
                            "btncolor" => "secondary"
                        ]); ?>
                        <?= button([
                            "type" => "submit",
                            "name" => "Confirmar Check-in",
                            "icon" => "check-lg",
                            "btncolor" => "success"
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php if (!($participant->status == 'presente' && $participant->signature)): ?>
    <?php $this->start("scripts"); ?>
    <!-- Signature Pad JS -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            var canvas = document.getElementById('signature-canvas');
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)' // Cor de fundo do canvas
            });

            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Limpa a assinatura ao redimensionar
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            $('#clear-signature').on('click', function() {
                signaturePad.clear();
            });

            $('#checkin-form').on('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    var message = "<div class='bd-callout bd-callout-danger fade show text-center fw-semibold'><i class='bi bi-exclamation-octagon me-2'></i> Por favor, forneça a assinatura para continuar.</div>";
                    $('.ajax_response').html(message);
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    return;
                }
                $('.ajax_response').html('');
                // Passa os dados da assinatura para o input hidden
                $('#signature').val(signaturePad.toDataURL('image/png'));
            });
        });
    </script>
    <?php $this->end(); ?>
<?php endif; ?>
