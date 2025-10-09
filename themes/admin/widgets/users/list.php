<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-people me-2"></i>Usuários do Sistema</h6>
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
                                    <th class="text-center">Editar</th>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Celular</th>
                                    <th class="text-center">Cargo</th>
                                    <th class="text-center">Igreja</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Nível</th>
                                    <th class="text-center">Desativar</th>
                                    <th class="text-center">Excluir</th>
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
