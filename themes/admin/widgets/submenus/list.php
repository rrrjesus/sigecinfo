<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-start"><i class="bi bi-list-nested me-2"></i>Submenus do Sistema</h6>
                    <div>
                        <?= button(["href" => "/painel/submenus/cadastrar", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm border-secondary table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>URL</th>
                                    <th>Menu Pai</th>
                                    <th>Submenu Pai</th>
                                    <th class="text-center">Ordem</th>
                                    <th class="text-center" style="width: 120px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($submenus)): ?>
                                    <?php foreach ($submenus as $submenu): ?>
                                        <tr>
                                            <td class="text-center"><?= $submenu->id; ?></td>
                                            <td><i class="<?= $submenu->icon; ?>"></i> <?= $submenu->name; ?></td>
                                            <td><?= $submenu->url; ?></td>
                                            <td><?= $submenu->menu()->name ?? 'N/A'; ?></td>
                                            <td><?= $submenu->parent_id ? (new \Source\Domain\Shared\Models\Submenu())->findById($submenu->parent_id)->name : 'N/A'; ?></td>
                                            <td class="text-center"><?= $submenu->submenu_order; ?></td>
                                            <td class="text-center">
                                                <a href="<?= url("/painel/submenus/editar/{$submenu->id}"); ?>" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                                <a href="#" class="btn btn-sm btn-outline-danger" 
                                                   data-post="<?= url("/painel/submenus/excluir"); ?>"
                                                   data-action="delete"
                                                   data-confirm="Tem certeza que deseja excluir este submenu?"
                                                   data-submenu_id="<?= $submenu->id; ?>" title="Excluir">
                                                   <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhum submenu cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
