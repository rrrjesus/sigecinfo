<?= $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="container-fluid">

    <?php if (!$user): ?>

        <form class="row gy-2 gx-3 align-items-center needs-validation" id="user" novalidate action="<?= url("/painel/usuarios/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    
            <input type="hidden" name="action" value="create"/>

            <?=csrf_input();?>

            <div class="ajax_response"><?=flash();?></div>
                
            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center"><i class="bi bi-person-plus me-1"></i> Cadastrar Usuário</h5>

                        <div class="row mb-1">

                            <div class="col-1 app_formbox_photo mb-1">
                                <div class="rounded-circle j_profile_image thumb" style="background-image: url('<?=url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar.jpg');?>')"></div>
                            </div>

                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" class="radius" name="photo"/>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputLogin"><strong><i class="bi bi-person me-1"></i> Login</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o login - letra + 6 dígitos" class="form-control form-control-sm mask-login"
                                    name="login" placeholder="d123456">

                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> RF</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o RF - 7 dígitos" class="form-control form-control-sm mask-rf"
                                    name="rf" placeholder="1234567">

                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="user_name" placeholder="NOME">

                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Tel Fixo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" class="form-control form-control-sm mask-fixed-phone" name="fixed_phone" 
                                placeholder="(99)9999-9999">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o email" class="form-control form-control-sm" name="email">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do celular - DDD + 9 dígitos" class="form-control form-control-sm mask-cell-phone" name="cell_phone" 
                                placeholder="(99)99999-9999">
                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Cargo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Cargo" class="form-control form-control-sm position_id"
                                    name="position_id" placeholder="Cargo">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Regime</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Regime" class="form-control form-control-sm category_id"
                                name="category_id" placeholder="Regime">
                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unit</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Unit" class="form-control form-control-sm unit_id"
                                    name="unit_id" placeholder="Unidade">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-building ms-3 me-3"></i> Nivel</strong></label>
                                <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Selecione o nível de usuario" name="level_id">
                                    <option value="1" selected>Usuario</option>
                                    <option value="2">Usuario Editor</option>
                                    <option value="3">Editor</option>
                                    <option value="4">Editor Administrador</option>
                                    <option value="5">Administrador do Sistema</option>
                                </select>
                            </div> 

                        </div>

                        <div class="row">  

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm"><strong><i class="bi bi-lock me-1"></i>Senha</strong></label>
                                    <input type="password" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite a senha, Padrão : smsub12345" class="form-control form-control-sm"
                                        name="password" placeholder="********" value="smsub12345">
                                </div>  

                            </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title=Observações" rows="2" name="observations"></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "7", "g")?>
                                <?=buttonLink("/painel/usuarios", "top", "Clique para listar os usuarios", "secondary", "list", "Listar", "8", "l")?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        
        <?php else: ?>

        <form class="row gy-2 gx-3 align-items-center needs-validation" id="user" novalidate action="<?= url("/painel/usuarios/editar/{$user->id}"); ?>" method="post" enctype="multipart/form-data">
                        
            <input type="hidden" name="action" value="update"/>

            <div class="ajax_response"><?=flash();?></div>

            <?=csrf_input();?>
                                
            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center"><i class="bi bi-person me-1"></i> Editar Usuário</h5>

                        <div class="row mb-1">

                            <div class="col-1 mb-1">
                                <a href="<?php if (file_exists(CONF_UPLOAD_DIR .'/'.$user->photo)) {echo '../../../'.CONF_UPLOAD_DIR .'/'.$user->photo;} 
                                    else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar.jpg');}?>" target="_blank">
                                <img data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Foto" height="90" width="90" src="<?php if ($user->photo && file_exists(CONF_UPLOAD_DIR .'/'.$user->photo)) 
                                    {echo image($user->photo, 200, 200);}else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar.jpg');}?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                                </a>
                            </div>
                            <div class="col-5 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong> Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Clique para carregar o arquivo" class="form-control form-control-sm" name="photo" id="photo" value="<?=$user->photo?>" type="file">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputLogin"><strong><i class="bi bi-person me-1"></i> Login</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o login - letra + 6 dígitos" class="form-control form-control-sm mask-login"
                                    name="login" placeholder="d123456" value="<?=$user->login?>">

                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> RF</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o RF - 7 dígitos" class="form-control form-control-sm mask-rf"
                                    name="rf" placeholder="1234567" value="<?=$user->rf?>">

                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="user_name" placeholder="NOME" value="<?=$user->user_name?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Tel Fixo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" class="form-control form-control-sm mask-fixed-phone" name="fixed_phone" 
                                placeholder="(99)9999-9999" value="<?=$user->fixed_phone?>">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o email" class="form-control form-control-sm" name="email" value="<?=$user->email?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do celular - DDD + 9 dígitos" class="form-control form-control-sm mask-cell-phone" 
                                name="cell_phone" placeholder="(99)99999-9999" value="<?=$user->cell_phone?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Situação</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Situação" class="form-control form-control-sm status"
                                name="status" placeholder="Status" value="<?=$user->statusInput()?>">
                            </div>

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Cargo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Cargo" class="form-control form-control-sm position_id"
                                    name="position_id" placeholder="Cargo" value="<?=$user->userPosition()->id.' - '.$user->userPosition()->position_name?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Regime</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Regime" class="form-control form-control-sm category_id" name="category_id" placeholder="Regime"
                                value="<?=$user->userCategory()->id.' - '.$user->userCategory()->category_name?>">
                            </div>

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Unit" class="form-control form-control-sm unit_id" name="unit_id" placeholder="Unidade"
                                value="<?=$user->userUnit()->id.' - '.$user->userUnit()->unit_name?>">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-building ms-3 me-3"></i> Nivel</strong></label>
                                <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Selecione o nível de usuario" name="level_id">
                                    <option value="<?=$user->level_id?>" selected><?=$user->level()->level_nome?></option>
                                    <option value="1">Usuario</option>
                                    <option value="2">Usuario Editor</option>
                                    <option value="3">Editor</option>
                                    <option value="4">Editor Administrador</option>
                                    <option value="5">Administrador do Sistema</option>
                                </select>
                            </div>   

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSenha"><strong><i class="bi bi-lock me-1"></i>Senha</strong></label>
                                    <input type="password" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite a senha, Padrão : smsub12345" class="form-control form-control-sm"
                                        name="password" placeholder="********">
                            </div>

                        </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title=Observações" name="observations" rows="2"><?=$user->observations?></textarea>
                            </div>
                            
                        </div>

                    
                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "7", "g")?>
                                <?=buttonLink("/painel/usuarios", "top", "Clique para listar os usuarios", "secondary", "list", "Listar", "8", "l")?>    
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center"><i class="bi bi-binoculars me-1"></i> Patrimônio Vinculado ao Usuário</h5>

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link fw-semibold active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Atual</button>
                                <button class="nav-link fw-semibold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Histórico</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <?php $this->insert("widgets/company/users/patrimonyUserList"); ?>    
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <?php $this->insert("widgets/company/users/patrimonyHistoryUserList"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        
        <?= $this->insert("views/modalUser"); ?>

        <?php  endif; ?>
        <?php $this->start("scripts"); ?>
            <script>

                let status = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: ['1 - REGISTRADO', '2 - CONFIRMADO', '3 - INATIVO']
                    });
                status.initialize();
                $('.status').typeahead({hint: true, highlight: true, minLength: 1}, {source: status});

                let position_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$userposition->completePosition()?>
                });
                position_id.initialize();
                $('.position_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: position_id});

                let category_id = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: <?=$usercategory->completeCategory()?>
                });
                category_id.initialize();
                $('.category_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: category_id});

                let unit_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$unit->completeUnit()?>
                });
                unit_id.initialize();
                $('.unit_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: unit_id});

            </script>
        <?php $this->end(); ?>
