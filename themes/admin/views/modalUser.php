<!-- Modal -->
<div class="modal fade" id="trashModal<?=$user->id?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h1 class="modal-title fs-5" id="modalLabel"><?=CONF_SITE_TITLE?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fw-semibold">
        Deseja ativar o usuário : <?=$user->user_name?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Não</button>
        <a href="<?=url("/painel/usuarios/excluir/{$user->id}/delete")?>" class="btn btn-sm btn-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-check-circle me-1" role="button" ></i> Sim</a>
      </div>
    </div>
  </div>
</div>