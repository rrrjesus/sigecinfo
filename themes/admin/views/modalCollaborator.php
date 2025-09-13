<!-- Modal -->
<div class="modal fade" id="disableModal<?=$collaborator->id?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark text-center">
        <h1 class="modal-title fs-5" id="modalLabel"><?=CONF_SITE_TITLE?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fw-semibold text-center">
        Deseja desativar o colaborador : <br>
        <?=$collaborator->user_name?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm fw-semibold" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>
        <a href="../desativar/<?=$collaborator->id?>" class="btn btn-outline-success btn-sm fw-semibold"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="trashModal<?=$collaborator->id?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h1 class="modal-title fs-5" id="modalLabel"><?=CONF_SITE_TITLE?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fw-semibold">
        Deseja ativar o colaborador : <?=$collaborator->user_name?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm fw-semibold" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>
        <a href="../excluir/<?=$collaborator->id?>/delete" class="btn btn-outline-success btn-sm fw-semibold"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>
      </div>
    </div>
  </div>
</div>