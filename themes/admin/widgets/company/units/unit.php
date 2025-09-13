<?= $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if (!$unit): ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="unit" novalidate action="<?= url("/painel/unidades/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    
                        <input type="hidden" name="action" value="create"/>

                        <?=csrf_input();?>

                        <div class="ajax_response"><?=flash();?></div>
                            
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

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="unit_name" placeholder="NOME">

                            </div>

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descricão</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o sobrenome" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Tel Fixo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" class="form-control form-control-sm mask-fixed-phone" name="fixed_phone" placeholder="49343000" value="1149343000">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o email" class="form-control form-control-sm" name="email">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Endereço</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o endereço" class="form-control form-control-sm"
                                    name="adress" placeholder="ENDEREÇO">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Cep</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o CEP" class="form-control form-control-sm mask-cep"
                                name="zip" placeholder="CEP">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Responsavel</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o responsável" class="form-control form-control-sm unit_id"
                                    name="it_professional" placeholder="RESPONSÁVEL">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do celular - DDD + 9 dígitos" class="form-control form-control-sm mask-cell-phone" name="cell_phone" placeholder="991065284">
                            </div>

                        </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite as observações" rows="2" name="observations"></textarea>
                            </div>

                        </div>


                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <button data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                    data-bs-title="Clique para atualizar o colaborador" class="btn btn-sm btn-outline-success fw-bold me-3"><i class="bi bi-disc-fill me-2"></i>GRAVAR</button>
                                <a href="<?=url("/painel/unidades")?>" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                    data-bs-title="Clique para listar os unidades" class="btn btn-sm btn-outline-dark fw-bold">
                                    <i class="bi bi-list-columns me-2"></i>LISTAR</a>
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
                <form class="row gy-2 gx-3 align-items-center needs-validation" id="unit" novalidate action="<?= url("/painel/unidades/editar/{$unit->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                    <div class="ajax_response"><?=flash();?></div>

                            <?=csrf_input();?>
                                
                    <div class="row mb-1">

                        <div class="col-1 mb-1">
                            <a href="<?php if (file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$unit->photo)) {echo '../../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$unit->photo;} 
                                else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar.jpg');}?>" target="_blank">
                            <img data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Foto" height="90" width="90" src="<?php if ($unit->photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$unit->photo)) 
                                {echo '../../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$unit->photo;}else {echo url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar.jpg');}?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                            </a>
                        </div>
                        <div class="col-5 mb-1">
                            <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong> Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                            <input data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Clique para carregar o arquivo" class="form-control form-control-sm" name="photo" id="photo" value="<?=$unit->photo?>" type="file">
                        </div>

                    </div>

                    <div class="row">

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="unit_name" placeholder="NOME" value="<?=$unit->unit_name?>">

                            </div>

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descricão</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o sobrenome" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO" value="<?=$unit->description?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Tel Fixo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" class="form-control form-control-sm mask-fixed-phone" 
                                name="fixed_phone" placeholder="49343000" value="<?=$unit->fixed_phone?>">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputEmail"><strong><i class="bi bi-envelope-at me-1"></i> E-mail</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o email" class="form-control form-control-sm" name="email" value="<?=$unit->email?>">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Endereço</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o endereço" class="form-control form-control-sm"
                                    name="adress" placeholder="ENDEREÇO" value="<?=$unit->adress?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCategoria"><strong><i class="bi bi-person-add me-1"></i> Cep</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o CEP" class="form-control form-control-sm mask-cep"
                                name="zip" placeholder="CEP" value="<?=$unit->zip?>">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Responsavel</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o responsável" class="form-control form-control-sm unit_id"
                                    name="it_professional" placeholder="RESPONSÁVEL" value="<?=$unit->it_professional?>">
                            </div>

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Celular</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o numero do celular - DDD + 9 dígitos" class="form-control form-control-sm mask-cell-phone" 
                                name="cell_phone" placeholder="991065284" value="<?=$unit->cell_phone?>">
                            </div>

                        </div>

                        <div class="row">   
                            
                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite as observações" rows="2" name="observations"><?=$unit->observations?></textarea>
                            </div>

                        </div>

                    <div class="row justify-content-center mt-4 mb-3">
                        <div class="col-auto">
                            <button data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                data-bs-title="Clique para atualizar o colaborador" class="btn btn-sm btn-outline-success fw-bold me-3"><i class="bi bi-disc-fill me-2"></i>GRAVAR</button>
                            <a href="<?=url("/painel/unidades")?>" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                data-bs-title="Clique para listar os unidades" class="btn btn-sm btn-outline-dark fw-bold">
                                <i class="bi bi-list-columns me-2"></i>LISTAR</a>
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
