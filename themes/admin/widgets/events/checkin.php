<?php $this->layout("_admin"); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form class="needs-validation ajax_off" id="checkin-form" action="<?= url("/painel/eventos/checkin-page") ?>" method="POST">
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
                            <img src="<?=($participant->user()->photo) ? url(CONF_UPLOAD_DIR . "/" . $participant->user()->photo) : theme('/assets/images/avatar.jpg', CONF_VIEW_ADMIN); ?>" class="img-fluid rounded-circle shadow-sm mb-2" alt="Foto do Participante" style="max-width: 120px;">

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

                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <label class="form-label">Por favor, assine no campo abaixo:</label>
                            <div class="canvas-container border rounded bg-light">
                                <canvas id="signature-canvas" style="width: 100%; height: 200px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
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
            </div>
        </form>
    </div>
</div>

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
                alert("Por favor, forneça a assinatura para continuar.");
                e.preventDefault();
                return;
            }
            // Passa os dados da assinatura para o input hidden
            $('#signature').val(signaturePad.toDataURL('image/png'));
        });
    });
</script>
<?php $this->end(); ?>