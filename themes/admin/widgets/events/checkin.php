<?php $this->layout("_admin"); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header fw-bold">
                    <i class="bi bi-check-circle me-2"></i>Check-in do Evento: <?= $participant->event()->title; ?>
                </div>
                <div class="card-body">
                    <form class="needs-validation ajax_off" id="checkin-form" action="<?= url("/painel/eventos/checkin-page") ?>" method="POST">
                        <?= csrf_input(); ?>
                        <input type="hidden" id="participant_id" name="participant_id" value="<?= $participant->id; ?>">
                        <input type="hidden" id="signature" name="signature">

                        <div class="row align-items-center mb-4">
                            <div class="col-md-4 text-center">
                                <img src="<?= $participant->user()->photo() ?? url("/storage/images/avatar.jpg"); ?>" class="img-fluid rounded-circle shadow-sm" alt="Foto do Participante" style="max-width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <h4 class="card-title"><?= $participant->user()->user_name; ?></h4>
                                <p class="card-text mb-1"><i class="bi bi-envelope me-2"></i><?= $participant->user()->email; ?></p>
                                <p class="card-text"><i class="bi bi-telephone me-2"></i><?= implode(" / ", array_filter([$participant->user()->phone1, $participant->user()->phone2])); ?></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Por favor, assine abaixo:</label>
                            <div class="canvas-container border rounded bg-light">
                                <canvas id="signature-canvas" style="width: 100%; height: 200px;"></canvas>
                            </div>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-signature">Limpar Assinatura</button>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-check-all me-2"></i>Confirmar Check-in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
<!-- Signature Pad JS -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    $(document).ready(function() {
        var canvas = document.getElementById('signature-canvas');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(248, 249, 250)' // bg-light
        });

        function resizeCanvas() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // Clear signature after resize
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
            // Pass the signature data to the hidden input field
            $('#signature').val(signaturePad.toDataURL('image/png'));
        });
    });
</script>
<?php $this->end(); ?>