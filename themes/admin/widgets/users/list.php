<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Usuários do Sistema</h6>
                    <div>
                        <?= button(["href" => "/painel/usuarios/cadastrar", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/usuarios/desativados", "name" => "Desativados", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="users" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Editar</th>
                                    <th class="text-center"><i class="bi bi-person-bounding-box me-2"></i>Foto</th>
                                    <th class="text-center"><i class="bi bi-person-vcard me-2"></i>Nome</th>
                                    <th class="text-center"><i class="bi bi-phone me-2"></i>Celular</th>
                                    <th class="text-center"><i class="bi bi-person-badge me-2"></i>Cargo</th>
                                    <th class="text-center"><i class="bi bi-bank me-2"></i>Igreja</th>
                                    <th class="text-center"><i class="bi bi-envelope-at me-2"></i>Email</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-diagram-3 me-2"></i>Nível</th>
                                    <th class="text-center"><i class="bi bi-person-x me-2"></i>Desativar</th>
                                    <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- O conteúdo da tabela será preenchido pelo DataTables via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
