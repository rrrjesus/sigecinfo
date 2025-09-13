<?php $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="row justify-content-center">
    <div class="col-xl-12">

        <?php if (!$produtos): ?>

        <!-- Cadastro de produtos -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="product" novalidate action="<?= url("/painel/patrimonio/produtos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="action" value="create"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">

                            <div class="col-2 app_formbox_photo mb-1">
                                <div class="rounded-circle j_profile_image thumb" style="background-image: url('<?=url('themes/'.CONF_VIEW_ADMIN.'/assets/images/avatar_product.png');?>')"></div>
                            </div>

                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" class="radius" name="photo"/>
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputContract"><strong><i class="bi bi-person me-1"></i> Contrato</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o número de processo SEI" class="form-control form-control-sm contract_id"
                                    name="contract_id" placeholder="Número de Processo SEI : Ex : 6012.2023/0008425-1">
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Marca</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome da marca" class="form-control form-control-sm brand_id"
                                    name="brand_id" placeholder="NOME">
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Produto</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Nome" class="form-control form-control-sm"
                                    name="product_name" placeholder="NOME">

                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Tipo de Partnumber</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o tipo de partnumber - Ex : IMEI, NS, CHIP ..." class="form-control form-control-sm type_part_number"
                                    name="type_part_number" placeholder="Tipo de PartNumber">

                            </div>

                        </div>

                        <div class="row justify-content-center">  

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Acessórios</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Descrição" class="form-control form-control-sm"
                                    name="acessories" placeholder="DESCRIÇÃO" id="acessories">
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                                <?=buttonLink("/painel/patrimonio/produtos", "top", "Clique para listar os produtos", "secondary", "list", "Listar", "7", "l")?>                                  
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
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="product" novalidate action="<?= url("/painel/patrimonio/produtos/editar/{$produtos->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>


                        <div class="row justify-content-center">

                            <div class="col-2 app_formbox_photo mb-1">
                                <a href="<?php if (file_exists(CONF_UPLOAD_DIR .'/'.$produtos->photo)) {echo '../../../../'.CONF_UPLOAD_DIR .'/'.$produtos->photo;} 
                                else {echo url(CONF_UPLOAD_DIR.'/images/avatar_product.png');}?>" target="_blank">
                                <img data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Foto" height="60" width="60" src="<?php if ($produtos->photo && file_exists(CONF_UPLOAD_DIR .'/'.$produtos->photo)) 
                                    {echo image($produtos->photo, 90, 90);}else {echo url(CONF_UPLOAD_DIR.'/images/avatar_product.png');}?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                                </a>
                            </div>

                            <div class="col-6 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Extensões aceitas : .bmp ,.png, .svg, .jpeg e .jpg </strong></label>
                                <input class="form-control form-control-sm" data-image=".j_profile_image" type="file" class="radius" name="photo"/>
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputContract"><strong><i class="bi bi-person me-1"></i> Contrato</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o número de processo SEI" class="form-control form-control-sm contract_id"
                                    name="contract_id" placeholder="Número de Processo SEI : Ex : 6012.2023/0008425-1" value="<?=$produtos->contract()->id.' - '.$produtos->contract()->contract_name?>">
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Marca</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome da marca" class="form-control form-control-sm brand_id"
                                    name="brand_id" placeholder="NOME" value="<?=$produtos->brand()->id.' - '.$produtos->brand()->brand_name?>">
                            </div>

                        </div>

                        <div class="row justify-content-center">  

                            <div class="col-8 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Nome" class="form-control form-control-sm"
                                    name="product_name" placeholder="NOME" value="<?=$produtos->product_name?>">

                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Tipo de Partnumber</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o tipo de partnumber - Ex : IMEI, NS, CHIP ..." class="form-control form-control-sm type_part_number"
                                    name="type_part_number" placeholder="Tipo de PartNumber" value="<?=$produtos->type_part_number?>">

                            </div>

                        </div>
                        
                        <div class="row justify-content-center">

                            <div class="col-8 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong> Acessórios</strong></label>
                                <textarea class="form-control form-control-sm" tabindex="5" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Acessórios" id="acessories" rows="2" name="acessories"><?=$produtos->acessories?></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                                <?=buttonLink("/painel/patrimonio/produtos", "top", "Clique para listar os produtos", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>

        <?php $this->start("scripts"); ?>
            <script>

                let type_part_number = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$products->completeTypePartNumber()?>
                });
                type_part_number.initialize();
                $('.type_part_number').typeahead({hint: true, highlight: true, minLength: 1}, {source: type_part_number});
                
                let contract_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$contracts->completeContract()?>
                });
                contract_id.initialize();
                $('.contract_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: contract_id});

                let brand_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$brands->completeBrand()?>
                });
                brand_id.initialize();
                $('.brand_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: brand_id});

            </script>
        <?php $this->end(); ?>
    </div>