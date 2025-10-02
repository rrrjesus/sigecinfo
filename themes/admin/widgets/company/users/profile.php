<?= $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if ($profile): ?>

        <div class="container-fluid">
            <div class="ajax_response"><?=flash();?></div>
                <form class="row gy-2 gx-3 align-items-center needs-validation" novalidate action="<?= url("/painel/perfil"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="profile"/>
                        <?=csrf_input();?>
                                
                        <div class="row mb-1 mt-3">

                            <div class="col-md-1 mb-1 app_formbox_photo">
                                <?php
                                // Lógica para o link <a> que abre a imagem completa
                                $fullImageLink = ($profile && $profile->photo())
                                    ? url(CONF_UPLOAD_DIR . "/" . $profile->photo())
                                    : theme('/assets/images/avatar.jpg', CONF_VIEW_ADMIN);
                                ?>
                                <a href="<?= $fullImageLink; ?>" target="_blank">
                                    <?= userPhoto($profile->photo ?? null, 100, 100, 'avatar.jpg'); ?>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <label for="photo" class="col-form-label col-form-label-md"> <strong> .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Clique para carregar o arquivo" class="form-control form-control-md" name="photo" id="photo" value="<?=$profile->photo?>" type="file">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o nome" class="form-control form-control-md"
                                    name="user_name" placeholder="NOME" value="<?=$profile->user_name?>">
                            </div>

                            <div class="col-md-3 mb-1">
                                <label class="col-form-label col-form-label-md" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Tel Fixo</strong></label>
                                <input type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" class="form-control form-control-md mask-fixed-phone" name="phone_landline" 
                                placeholder="49343000" value="<?=$profile->phone_landline?>">
                            </div>
                        </div>

                        <div class="row mb-1">

                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                                <input type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o email" class="form-control form-control-md" name="email" value="<?=$profile->email?>">
                            </div>

                            <div class="col-md-2 mb-1">
                                <label class="col-form-label col-form-label-md" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o numero do celular - DDD + 9 dígitos" class="form-control form-control-md mask-cell-phone" 
                                name="phone_mobile" placeholder="991065284" value="<?=$profile->phone_mobile?>">
                            </div>

                                <div class="col-md-2 mb-1">
                                    <label class="col-form-label col-form-label-md" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Situação</strong></label><select class="form-control form-control-md" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                        data-bs-title="Selecione o status de usuario" name="status"><?=user_status_options($profile->status); ?></select>
                                </div>

                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="church_id"><i class="bi bi-person-add me-1"></i><strong>Igreja</strong></label>
                                <select id="church_id" name="church_id" class="form-select form-select-md" required>
                                    <option value="">Selecione uma igreja...</option>
                                    <?php if (!empty($churches)): foreach ($churches as $church): ?>
                                        <option value="<?= $church->id; ?>" <?= !empty($profile) && $profile->church_id == $church->id ? 'selected' : ''; ?>><?= $church->church_name; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-1">

                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="position_id"><strong><i class="bi bi-person-add me-1"></i> Cargo/Ministério</strong></label>
                                <select id="position_id" name="position_id" class="form-select form-select-md" required>
                                    <option value="">Selecione um cargo...</option>
                                    <?php if (!empty($positions)): foreach ($positions as $position): ?>
                                        <option value="<?= $position->id; ?>" <?= !empty($profile) && $profile->position_id == $position->id ? 'selected' : ''; ?>><?= $position->position_name; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>               
                            
                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="level_id"><strong><i class="bi bi-building ms-3 me-1"></i> Nível de Acesso</strong></label>
                                <select id="level_id" name="level_id" class="form-select form-select-md" required>
                                    <option value="">Selecione um nível...</option>
                                    <?php if (!empty($levels)): foreach ($levels as $level): ?>
                                        <option value="<?= $level->id; ?>" <?= !empty($profile) && $profile->level_id == $level->id ? 'selected' : ''; ?>><?= $level->level_name; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label class="col-form-label col-form-label-md" for="inputSenha"><strong><i class="bi bi-lock me-1"></i>Senha</strong></label>
                                    <input type="password" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                        data-bs-title="Digite a senha, Padrão : smsub12345" class="form-control form-control-md"
                                        name="password" placeholder="********">
                            </div>

                        </div>

                        <div class="row mb-1">
                            
                            <div class="col-md-12 mb-1 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-md"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-md" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title=Observações" name="observations" rows="2"><?=$profile->observations?></textarea>
                            </div>
                            
                        </div>

                        <div class="row justify-content-center mt-4 mb-1">
                            <div class="col-auto">
                                <?= button([ "name" => "Atualizar", "icon" => "person", "btncolor" => "success", "custom" => "dark", "title" => "Clique para atualizar", "accesskey" => "a"]); ?>
                                <?= button([ "name" => "Sair", "icon" => "person", "btncolor" => "danger", "custom" => "dark", "title" => "Clique para sair", "accesskey" => "s", "href" => "/painel/usuarios"]); ?>
                        </div>
                    </div>

                        </form>
                    <?= $this->insert("views/modalUser"); ?>
                </div>
            </div>
        </div>

        <?php  endif; ?>

    </div>
</div>
