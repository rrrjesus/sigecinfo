<?php $this->layout("_admin"); ?>

    <!-- Breadcrumb -->
    <?= $this->insert("views/theme/breadcrumb"); ?>

    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="container-fluid">
                <div class="ajax_response"><?= flash(); ?></div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i>Cadastrar Nova Permissão</h6>
                    </div>
                    <div class="card-body">
                        <p>O formulário para cadastro de permissões será implementado aqui.</p>
                        <!-- O formulário virá aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>