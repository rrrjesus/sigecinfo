<!-- Modal -->
<div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="modalLabelSair" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-<?=CONF_APP_COLOR?>">
        <h1 class="modal-title fs-5 text-center text-white" id="modalLabelSair"><?=CONF_SITE_NAME?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fw-semibold">
        Deseja sair do sistema ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>
        <a href="<?=url("/beta/logoff")?>" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>
      </div>
    </div>
  </div>
</div>

