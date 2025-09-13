<!-- Modal -->
<div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="modalLabelSair" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h1 class="modal-title fs-5" id="modalLabelSair"><?=CONF_SITE_TITLE?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fw-semibold">
        Deseja sair do sistema ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm fw-semibold" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>
        <a href="<?=url("/painel/logoff")?>" class="btn btn-outline-success btn-sm fw-semibold"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>
      </div>
    </div>
  </div>
</div>

