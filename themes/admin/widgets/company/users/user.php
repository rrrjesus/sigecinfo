<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <?php if (!$user): // MODO DE CRIAÇÃO ?>
                <form class="needs-validation" id="userForm" novalidate action="<?= url("/painel/usuarios/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create"/>
            <?php else: // MODO DE EDIÇÃO ?>
                <form class="needs-validation" id="userForm" novalidate action="<?= url("/painel/usuarios/editar/{$user->id}"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update"/>
            <?php endif; ?>
                    <?= csrf_input(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="user_name" class="form-label"><strong>Nome Completo</strong></label>
                            <input type="text" id="user_name" name="user_name" class="form-control" value="<?= $user->user_name ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $user->email ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label"><strong>Senha</strong> <?= (!$user ? '<small>(Obrigatória no registo)</small>' : '<small>(Deixe em branco para não alterar)</small>'); ?></label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                         <div class="col-md-6">
                            <label for="photo" class="form-label"><strong>Foto</strong> (Opcional)</label>
                             <input class="form-control" type="file" id="photo" name="photo">
                        </div>
                    </div>
                    
                    <hr/>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone_mobile" class="form-label"><strong>Telemóvel</strong></label>
                            <input type="text" id="phone_mobile" name="phone_mobile" class="form-control mask-cell-phone" value="<?= $user->phone_mobile ?? ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_landline" class="form-label"><strong>Telefone Fixo</strong> (Opcional)</label>
                            <input type="text" id="phone_landline" name="phone_landline" class="form-control mask-fixed-phone" value="<?= $user->phone_landline ?? ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="church_id" class="form-label"><strong>Igreja</strong></label>
                            <select id="church_id" name="church_id" class="form-select" required>
                                <option value="">Selecione uma igreja...</option>
                                <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                    <option value="<?= $church->id; ?>" <?= !empty($user) && $user->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                         <div class="col-md-4">
                            <label for="position_id" class="form-label"><strong>Cargo/Ministério</strong></label>
                            <select id="position_id" name="position_id" class="form-select" required>
                                <option value="">Selecione um cargo...</option>
                                 <?php if (!empty($positions)): foreach ($positions as $position): ?>
                                    <option value="<?= $position->id; ?>" <?= !empty($user) && $user->position_id == $position->id ? 'selected' : ''; ?>><?= $position->position_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="level_id" class="form-label"><strong>Nível de Acesso</strong></label>
                             <select id="level_id" name="level_id" class="form-select" required>
                                <option value="">Selecione um nível...</option>
                                 <?php if (!empty($levels)): foreach ($levels as $level): ?>
                                    <option value="<?= $level->id; ?>" <?= !empty($user) && $user->level_id == $level->id ? 'selected' : ''; ?>><?= $level->level_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <?php if ($user): ?>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="status" class="form-label"><strong>Status</strong></label>
                                <select name="status" id="status" class="form-select">
                                    <?= user_status_options($user->status); ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                         <div class="col-md-12">
                            <label for="observations" class="form-label"><strong>Observações</strong></label>
                            <textarea id="observations" name="observations" class="form-control" rows="3"><?= $user->observations ?? ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <?= button(["name" => ($user ? "Atualizar Utilizador" : "Registar Utilizador"), "icon" => "check-circle", "btncolor" => "success"]); ?>
                            <?= button(["href" => "/painel/usuarios", "name" => "Listar Todos", "icon" => "list", "btncolor" => "secondary"]); ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>