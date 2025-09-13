<?= $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                
                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row mb-1">
                            <div class="col-3 mb-1">
                                <img src="<?=image($patrimonys->photo, 200, 200)?>" class="img-thumbnail">
                        
                            </div>
                        </div>
                            
                        <div class="row mb-1">

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNs"><i class="bi bi-person-add me-1"></i><strong>Número de Registro</strong></label>
                                <input type="text" class="form-control form-control-sm" disabled name="part_number_eye" value="<?=$patrimonys->part_number?>">
                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputProduto"><i class="bi bi-person-add me-1"></i><strong>Produto</strong></label>
                                <input type="text" data-bs-togglee="tooltip" tabindex="2" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Digite o nome do produto - Ex : 1 - Tablet" class="form-control form-control-sm product_id"
                                    name="product_id" placeholder="PRODUTO" value="<?php if($patrimonys->product_id){echo $patrimonys->product()->id.' - '.$patrimonys->product()->product_name.' - '.$patrimonys->product()->contract()->contract_name.' - (Nº de Registro '.$patrimonys->product()->type_part_number.')';}else{echo '';}?>">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputMovimentacao"><i class="bi bi-person-add me-1"></i><strong>Estado</strong></label>
                                <input type="text" data-bs-togglee="tooltip" autofocus data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o estado do patrimonio - Ex : 1- ESTOQUE, 2 - RETIRADO ... " tabindex="3" class="form-control form-control-sm movement_id"
                                    name="movement_id" placeholder="ESTADO">
                            </div>

                            <input name="type_part_number" type="hidden" value="<?=(!empty($patrimonys->product_id) ? $patrimonys->product()->type_part_number : "")?>">

                        </div>

                            <div class="row mb-1">

                                <div class="col-5 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Usuario</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" tabindex="4" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o usuário - Ex : 1 - João Bento Badaró" class="form-control form-control-sm user_id"
                                        name="user_id_edit" id="user_id_edit" placeholder="USUÁRIO">
                                </div>

                                <div class="col-7 mb-1">
                                    <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" tabindex="8" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite a unidade - Ex : 22 - SIGECINFO/COTI" class="form-control form-control-sm unit_id"
                                        name="unit_id_edit" id="unit_id_edit" placeholder="UNIDADE">
                                </div>

                            </div>

                            <div class="row">   

                                <div class="mb-3 mb-1">
                                    <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                    <textarea class="form-control form-control-sm" tabindex="5" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title=Observações" rows="2" name="observations"></textarea>
                                </div>

                            </div>         

                            <div class="row justify-content-center mt-3 mb-3">
                                <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                                <?=buttonLink("/beta/patrimonios", "top", "Clique para listar os patrimônios", "secondary", "list", "Listar", "7", "l")?>    
                                <?=buttonLink("/beta/patrimonio/termo/{$patrimonys->id}", "top", "Clique para listar os patrimônios", "primary", "file-earmark-word", "Termo", "9", "t")?>                                   
                                </div>
                            </div>

                            <div class="row mb-2 mt-2">
                                <div class="col-12 mb-1">
                                    <div class="card border-<?=CONF_APP_COLOR?> mb-3">
                                        <div class="card-header bg-transparent border-<?=CONF_APP_COLOR?>">
                                            <h5 class="card-title text-<?=CONF_APP_COLOR?> text-center"> HISTÓRICO DO PATRIMÔNIO </h5>
                                        </div>
                                        <div class="card-body text-<?=CONF_APP_COLOR?>">
                                        <?php $this->insert("widgets/patrimonys/historyList"); ?>  
                                        </div>
                                    </div>
                                </div>
                            </div>


                </div>
            </div>
        </div>
    </div>
</div>
