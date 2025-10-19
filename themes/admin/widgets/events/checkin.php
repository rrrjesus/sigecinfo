 <?php $this->layout("_admin"); ?>

<div class="ajax_response"><?= flash(); ?></div><!-- Inclua onde for apropriado no checkin.php -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
 
 <style>
    #signatureCanvas {
      border: 2px dashed #6c757d;
      border-radius: 8px;
      width: 100%;
      height: 200px;
      cursor: crosshair;
      background-color: #f8f9fa;
    }
    #signatureCanvas.is-empty {
      border-color: #dc3545;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Confirmação de Dados e Assinatura</h5>
          </div>
          <div class="card-body">
            
        <form class="needs-validation ajax_off" id="checkin-user" novalidate action="<?= url("/painel/eventos/check-in"); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="participant_id" value="<?= $eventParticipant->id; ?>">
            <input type="hidden" name="event_id" value="<?= $eventParticipant->event_id; ?>">
              
              <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?=$user->user_name?>" readonly>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" value="<?=$user->email?>" readonly>
              </div>

              <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" value="<?= $eventParticipant->id; ?>" readonly>
              </div>

              <div class="mb-3" id="signature-wrapper" style="border:1px solid #ccc;padding:8px;border-radius:6px;max-width:420px;">
                    <p>Assine abaixo (toque/caneta/mouse):</p>
                    <canvas id="signature-pad" style="width:100%;height:200px;background:#fff;"></canvas>
                    <input type="hidden" name="signature" id="signatureInput">
                    <div style="margin-top:6px;">
                        <!-- <button type="button" id="clear-signature">Limpar</button>
                        <button type="button" id="save-signature">Confirmar Dados</button> -->
                        <span id="sig-status" style="margin-left:12px"></span>
                    </div>
                </div>

                 <div class="card-footer text-center">

                    <?= button([
                        "id" => "save-signature",
                        "name" => "Check-in",
                        "icon" => "check-circle-fill me-1",
                        "btncolor" => "success",
                        "class" => "m-1 p-1",
                        "title" => "Checar usuário",
                        "type" => "submit"
                    ]); ?>
                    <?= button([
                        "id" => "clear-signature",
                        "name" => "Limpar",
                        "icon" => "check-circle-fill me-1",
                        "btncolor" => "secondary",
                        "class" => "m-1 p-1",
                        "title" => "Limpar assinatura",
                        "type" => "button"
                    ]); ?>
                    <?= button(["id" => "exit", "href" => "/painel/eventos/portaria/{$eventParticipant->event_id}", "title" => "Voltar","name" => "Sair", "icon" => "list", "btncolor" => "danger"]); ?>

                </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

<?php $this->start("scripts"); ?>

<!-- SignaturePad -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.4/signature_pad.umd.min.js"></script>

<script>
const canvas = document.getElementById('signature-pad');
const signaturePad = new SignaturePad(canvas);

// Ajustar tamanho do canvas
function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear();
}
window.onresize = resizeCanvas;
resizeCanvas();

// Limpar
document.getElementById('clear').addEventListener('click', () => {
    signaturePad.clear();
    document.getElementById('signature-error').style.display = 'none';
});

// Sair
document.getElementById('exit').addEventListener('click', () => {
    window.location.href = '<?= url("/beta/eventos"); ?>';
});

// Check-in
document.getElementById('checkin').addEventListener('click', async () => {
    if (signaturePad.isEmpty()) {
        alert("Por favor, assine antes de continuar.");
        return;
    }

    const dataURL = signaturePad.toDataURL('image/png');
    const fd = new FormData();
    fd.append('participant_id', document.getElementById('participant_id').value);
    fd.append('event_id', document.getElementById('event_id').value);
    fd.append('signature_base64', dataURL);

    try {
        const response = await fetch('<?= url("/eventos/checkin"); ?>', {
            method: 'POST',
            body: fd
        });

        const result = await response.json();
        if (result.success) {
            alert('Check-in realizado com sucesso!');
            window.location.reload();
        } else {
            alert('Erro: ' + result.message);
        }
    } catch (err) {
        console.error(err);
        document.getElementById('signature-error').style.display = 'block';
    }
});

</script>
<?php $this->end(); ?>