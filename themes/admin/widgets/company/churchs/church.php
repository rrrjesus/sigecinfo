<?= $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if (!$church): ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="church" novalidate action="<?= url("/painel/igrejas/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    
                        <input type="hidden" name="action" value="create"/>

                        <?=csrf_input();?>

                        <div class="ajax_response"><?=flash();?></div>
                            
                        <div class="row mb-1">

                            <div class="col-1 app_formbox_photo mb-1">
                                <div class="rounded-circle j_profile_image thumb" style="background-image: url('<?=url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar-ccb.jpg');?>')"></div>
                            </div>

                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" class="radius" name="photo"/>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputChurchName"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o nome da igreja" class="form-control form-control-sm"
                                    name="church_name" placeholder="Jaçanã">

                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCountry"><strong><i class="bi bi-person-add me-1"></i> País</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o País da Igreja" class="form-control form-control-sm mask-country"
                                    name="country_id" placeholder="BR">
                            </div>  

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCode"><strong><i class="bi bi-person-add me-1"></i> Código</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o código da igreja" class="form-control form-control-sm mask-code"
                                    name="code_id" placeholder="21-0765 ">
                            </div>
                            
                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputPhoneMobile"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o numero : DDD + dígitos" class="form-control form-control-sm mask-phone" name="phone" placeholder="(11)99106-5284">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputAddress"><strong><i class="bi bi-person-add me-1"></i> Endereço</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o endereço da igreja" class="form-control form-control-sm"
                                    name="address" placeholder="Rua José Buono, 65">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputZipeCode"><strong><i class="bi bi-person-add me-1"></i> Cep</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o CEP da Igreja" class="form-control form-control-sm mask-zip-code"
                                name="zip_code  " placeholder="02298-098">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCity"><i class="bi bi-person-add me-1"></i><strong>Cidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite a Cidade da Igreja" class="form-control form-control-sm"
                                    name="city" placeholder="São Paulo">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputState"><strong><i class="bi bi-person-add me-1"></i> Estado</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o estado" class="form-control form-control-sm mask-state"
                                    name="state" placeholder="SP">
                            </div>  

                        </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite as observações" rows="2" name="observations"></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "7", "g")?>
                                <?=buttonLink("/painel/igrejas", "top", "Clique para listar as igrejas", "secondary", "list", "Listar", "8", "l")?>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php else: ?>

        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                <form class="row gy-2 gx-3 align-items-center needs-validation" id="church" novalidate action="<?= url("/painel/igrejas/editar/{$church->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                    <div class="ajax_response"><?=flash();?></div>

                            <?=csrf_input();?>
                                
                    <div class="row mb-1">

                        <div class="col-1 mb-1">
                            <a href="<?php if ($church->photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/'.$church->photo)) {echo '../../../themes/'.CONF_VIEW_ADMIN.'/assets/images/'.$church->photo;} 
                                else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar-ccb.jpg');}?>" target="_blank">
                            <img data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Foto" height="90" width="90" src="<?php if ($church->photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/'.$church->photo)) 
                                {echo '../../../themes/'.CONF_VIEW_ADMIN.'/assets/images/'.$church->photo;}else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar-ccb.jpg');}?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                            </a>
                        </div>
                        <div class="col-5 mb-1">
                            <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong> Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                            <input data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Clique para carregar o arquivo" class="form-control form-control-sm" name="photo" id="photo" value="<?=$church->photo?>" type="file">
                        </div>

                    </div>

                    <div class="row">

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputChurchName"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o nome da igreja" class="form-control form-control-sm"
                                    name="church_name" placeholder="Jaçanã" value="<?=$church->church_name?>">

                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCountry"><strong><i class="bi bi-person-add me-1"></i> País</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o País da Igreja" class="form-control form-control-sm mask-country"
                                    name="country_id" placeholder="BR" value="<?=$church->country_id?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCode"><strong><i class="bi bi-person-add me-1"></i> Código</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o Código da Igreja" class="form-control form-control-sm mask-code"
                                    name="code_id" placeholder="24-3658" value="<?=$church->code_id?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputPhoneMobile"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o numero do telefone - DDD + dígitos" class="form-control form-control-sm mask-phone" 
                                name="phone" placeholder="(11)99106-5284" value="<?=$church->phone?>">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Endereço</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark"     
                                    data-bs-title="Digite o endereço da Igreja" class="form-control form-control-sm"
                                    name="address" placeholder="Rua José Buono, 65" value="<?=$church->address?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Cep</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite o CEP da Igreja" class="form-control form-control-sm mask-zip-code"
                                name="zip_code" placeholder="02244-35" value="<?=$church->zip_code?>">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCity"><i class="bi bi-person-add me-1"></i><strong>Cidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite a cidade" class="form-control form-control-sm mask-city"
                                    name="city" placeholder="São Paulo" value="<?=$church->city?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputState"><i class="bi bi-person-add me-1"></i><strong>Estado</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o Estado" class="form-control form-control-sm mask-state"
                                    name="state" placeholder="SP" value="<?=$church->state?>">
                            </div>
                        </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                data-bs-title="Digite as observações" rows="2" name="observations"><?=$church->observations?></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para atualizar a igreja", "success", "disc-fill", "Gravar", "7", "g")?>
                                <?=buttonLink("/painel/igrejas", "top", "Clique para listar as igrejas", "secondary", "list", "Listar", "8", "l")?>
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
