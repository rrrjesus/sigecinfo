<?php $this->layout("_beta"); ?>

<!-- Breadcrumb -->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-calendar-plus me-2"></i> Novo Evento</h5>
                </div>
                <div class="card-body">
                    <form class="ajax_form" action="<?= url("/app/eventos/novo"); ?>" method="post">
                        <div class="ajax_response"><?= flash(); ?></div>
                        <?= csrf_input(); ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">Título do Evento</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_at" class="form-label">Início do Evento</label>
                                <input type="datetime-local" class="form-control" id="start_at" name="start_at" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_at" class="form-label">Fim do Evento</label>
                                <input type="datetime-local" class="form-control" id="end_at" name="end_at" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Evento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
