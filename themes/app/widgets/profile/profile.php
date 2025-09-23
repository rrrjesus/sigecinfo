<?php $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-center">
        <div class="col-12">
            <form class="row gy-2 gx-3 align-items-center needs-validation" id="profile" novalidate action="<?= url("/beta/perfil"); ?>" method="post" enctype="multipart/form-data">
                
            <input type="hidden" name="update" value="true"/>

                <div class="ajax_response"></div>

                <?=csrf_input();?>
                    
                <div class="row mb-1">

                    <div class="col-1 app_formbox_photo mb-1">
                        <div class="rounded-circle j_profile_image thumb" style="background-image: url('<?= $photo; ?>')"></div>
                    </div>

                    <div class="col-4 mb-1">
                        <label for="formFileSm" class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>"> <strong><i class="bi bi-upload me-1"></i>  Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                        <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" class="radius" name="photo"/>
                    </div>

                </div>

                <div class="row">

                    <div class="col-2 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputNome"><strong><i class="bi bi-person me-1"></i> Login</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Nome" class="form-control form-control-sm"
                            name="user_name" placeholder="NOME" value="<?=$user->login?>" disabled readonly>

                    </div>

                    <div class="col-6 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Nome" class="form-control form-control-sm"
                            name="user_name" placeholder="NOME" value="<?=$user->user_name?>" disabled readonly>

                    </div>

                    <div class="col-2 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputCelular"><strong><i class="bi bi-phone me-1"></i>Telefone Fixo</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                        data-bs-title="Digite o nome do celular" class="form-control form-control-sm mask-fixed-phone" name="phone_landline" value="<?=$user->phone_landline?>" placeholder="(11)49343000">
                    </div>

                    <div class="col-2 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputCelular"><strong><i class="bi bi-phone me-1"></i>Telefone Celular</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                        data-bs-title="Digite o nome do celular" class="form-control form-control-sm mask-cell-phone" name="phone_mobile" value="<?=$user->phone_mobile?>" placeholder="(11)991065284">
                    </div>

                </div>

                <div class="row">

                    <div class="col-4 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Cargo</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Cargo" class="form-control form-control-sm"
                            name="position" placeholder="Church" value="<?=$user->position()->position_name?>" disabled readonly>
                    </div>

                    <div class="col-3 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Church</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Church" class="form-control form-control-sm"
                            name="church" placeholder="Igreja" 
                            value="<?=(!empty($user->church_id) ? $user->church()->id.' - '.$user->church()->church_name : "") ;?>" disabled readonly>
                    </div>

                    <div class="col-3 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Email" class="form-control form-control-sm" name="email" value="<?=$user->email?>" disabled readonly>
                    </div>

                </div>

                <div class="row">

                <div class="col-2 mb-1">
                    <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Situação</strong></label>
                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                    data-bs-title="Categoria" class="form-control form-control-sm"
                    name="category" placeholder="Categoria" value="<?=status_name($user->status)?>" disabled readonly>
                </div>

                <div class="col-2 mb-1">
                    <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputSenha"><strong><i class="bi bi-calendar4-week me-1"></i>Cadastro</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Cadastro" class="form-control form-control-sm" value="<?=date_fmt($user->created_at, 'd/m/Y')?>" disabled readonly>
                </div>  

                <div class="col-2 mb-1">
                    <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>" for="inputSenha"><strong><i class="bi bi-calendar2-x me-1"></i>Bloqueio</strong></label>
                        <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Bloqueio" class="form-control form-control-sm" value="<?=date_fmt_null($user->blocked_at, 'd/m/Y')?>" disabled readonly>
                </div>

                <div class="col-3 mb-1">
                    <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>"><strong><i class="bi bi-lock me-1"></i>Senha</strong></label>
                        <input type="password" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                            data-bs-title="Digite a senha" class="form-control form-control-sm"
                            name="password" id="password" placeholder="********">
                    </div>  

                    <div class="col-3 mb-1">
                        <label class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>"><i class="bi bi-lock me-1"><strong></i>Repetir Senha</strong></label>
                            <input type="password" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                data-bs-title="Digite a senha" class="form-control form-control-sm"
                                name="password_re" id="password_re" placeholder="********">
                    </div>  

                </div>

                <div class="row">   
                    
                    <div class="mb-3 mb-1">
                        <label for="textareaObservacoes" class="col-form-label col-form-label-sm text-<?=CONF_APP_COLOR?>"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                        <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                        data-bs-title=Observações" rows="3" disabled readonly><?=$user->observations?></textarea>
                    </div>
                </div>


                <div class="row justify-content-center mt-4 mb-3">
                    <div class="col-auto">
                        <?= button(["name" => "Gravar", "title" => "Clique para atualizar o Perfil", "icon" => "disc-fill", "btncolor" => "success"]); ?>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>