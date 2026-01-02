<!-- Modal -->
<div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h1 class="modal-title fs-5" id="registerUserModalLabel">Cadastrar Novo Convocado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="ajax_form" action="<?= url("/app/eventos/{$event->id}/cadastrar"); ?>" method="post">
        <div class="modal-body">
            <div class="ajax_response"></div>
            <?= csrf_input(); ?>
            <input type="hidden" name="event_id" value="<?= $event->id; ?>">
            <div class="mb-3">
                <label for="user_name" class="col-form-label col-form-label-sm"><strong>Nome Completo:</strong></label>
                <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="col-form-label col-form-label-sm"><strong>E-mail:</strong></label>
                <input type="email" class="form-control form-control-sm" id="email" name="email">
            </div>
            <div class="mb-3">

                <label class="col-form-label col-form-label-sm" for="position"><strong>Cargo:</strong></label>
                <select id="position" name="position" class="form-select form-select-sm" required>
                  <option selected>Selecione um cargo...</option>
                  <?php $positions = (new \Source\Domain\User\Models\UserPosition())->find()->order("position_name ASC")->fetch(true)?>
                  <?php if (!empty($positions)): foreach ($positions as $position): ?>
                      <option value="<?= $position->id; ?>"><?= $position->position_name; ?></option>
                  <?php endforeach; endif; ?>
              </select>

            </div>

            <div class="mb-3">
                <label class="col-form-label col-form-label-sm" for="place"><strong>Local</strong></label>
                <select id="place" name="place" class="form-select form-select-sm" required>
                  <option selected>Selecione um local...</option>
                  <?php $places = (new \Source\Domain\Place\Models\Place())->find()->order("place_name ASC")->fetch(true)?>
                  <?php if (!empty($places)): foreach ($places as $place): ?>
                      <option value="<?= $place->id; ?>"><?= $place->place_name; ?></option>
                  <?php endforeach; endif; ?>
              </select>
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancelar</button>
          <button type="submit" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-check-circle me-1"></i> Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
