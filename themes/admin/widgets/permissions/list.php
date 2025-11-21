<?php $this->layout("_admin"); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h1>Listagem de Permissões</h1>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Permissão</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($permissions)): ?>
                        <?php foreach ($permissions as $permission): ?>
                            <tr>
                                <td><?= $permission->id; ?></td>
                                <td><?= $permission->name; ?></td>
                                <td><?= $permission->description; ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma permissão encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>