<?= $this->layout("_beta"); ?>


          <!-- Breacrumb-->
          <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">

    <?php if (!$patrimonys): ?>

        <form class="row align-items-center needs-validation" id="patrimony" novalidate action="<?= url("/beta/patrimonio/cadastrar"); ?>" method="post" enctype="multipart/form-data">
        
            <input type="hidden" name="action" value="create"/>

            <?=csrf_input();?>

            <div class="ajax_response"><?=flash();?></div>

    
            <div class="row ms-1 mb-3">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center text-success"><i class="bi bi-clipboard-plus me-1"></i> Cadastrar Patrimônio</h5>

                        <div class="row mb-1">
                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i> Anexar PDF </strong></label>
                                <input class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                data-bs-title="Anexar arquivo apenas no formato .pdf" type="file" class="radius" name="file_terms"/>
                            </div>
                        </div>

                        <div class="row mb-1">

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNs"><i class="bi bi-person-add me-1"></i><strong>Número de Registro</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o numero de registro da peça" tabindex="1" class="form-control form-control-sm"
                                    name="part_number" autofocus placeholder="NÚMERO DA PEÇA">
                            </div>

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputProduto"><i class="bi bi-person-add me-1"></i><strong>Produto</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o nome do produto - Ex : 1 - Tablet" tabindex="2" class="form-control form-control-sm product_id"
                                    name="product_id" placeholder="PRODUTO">
                            </div>

                            <div class="col-3 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputMovimentacao"><i class="bi bi-person-add me-1"></i><strong>Estado</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o estado do patrimonio - Ex : 1- Estoque, 2 - Retirado, 3 - Reservado ... " tabindex="3" class="form-control form-control-sm movement_id"
                                    name="movement_id" placeholder="Estado">
                            </div>

                        </div>

                        <div class="row mb-1">

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Usuario</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o usuário - Ex : 1 - João Bento Badaró" tabindex="4" class="form-control form-control-sm user_id"
                                    name="user_id" id="user_id" placeholder="USUÁRIO">
                            </div>

                            <div class="col-7 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                data-bs-title="Digite a unidade - Ex : 22 - SIGECINFO/COTI" tabindex="8" class="form-control form-control-sm unit_id"
                                    name="unit_id" id="unit_id" placeholder="UNIDADE">
                            </div>

                        </div>

                        <div class="row">   
                            
                            <div class="col-12 mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" tabindex="5" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                data-bs-title=Observações" rows="2" name="observations"></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/beta/patrimonios", "top", "Clique para listar os patrimônios", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
        </form>

    <?php else: ?>

        <form class="row align-items-center needs-validation" id="patrimony" novalidate action="<?= url("/beta/patrimonio/detalhe/{$patrimonys->id}"); ?>" method="post" enctype="multipart/form-data">
                
            <input type="hidden" name="action" value="update"/>

            <div class="ajax_response"><?=flash();?></div>

            <?=csrf_input();?>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">
                            <h5 class="card-title text-center text-success pb-2"><i class="bi bi-binoculars me-1"></i>  Detalhes do Patrimônio</h5>
                        <div class="row ms-1">
                            <div class="col-2">
                                <img src="<?=image($patrimonys->product()->photo, 130, 130)?>" class="img-thumbnail rounded float-start" alt="<?=$patrimonys->product()->photo?>">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title"><?=$patrimonys->product()->brand()->brand_name.' '.$patrimonys->product()->product_name.' - '.$patrimonys->product()->type_part_number.' : '.$patrimonys->part_number?></h5>
                                <p class="card-text"><?=$patrimonys->product()->acessories?></p>
                                <p class="card-text"><b><?=$patrimonys->movement()->movement_name?></b> em <?=date_fmt($patrimonys->updated_at)?> - <b>Usuario : </b>
                                    <?=(!empty($patrimonys->user()->user_name) ? $patrimonys->user()->user_name : 'Não Cadastrado')?> - <b>Unidade : </b>
                                    <?=$patrimonys->unit()->unit_name.buttonLink("/beta/patrimonio/termo/{$patrimonys->id}", "top", "Clique para imprimir o termo", "primary ms-3", "file-earmark-word", "Termo", "9", "t", "_blank")?>
                                    <?=$patrimonys->fileTerm()?>
                                </p>
                        
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center text-success"><i class="bi bi-clipboard-plus me-1"></i> Lançar Nova Movimentação</h5>
                    
                        <div class="row mb-1">

                            <div class="col-1 mb-1">
                                <a href="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/adobe_cinza.jpg');?>" target="_blank">
                                <img data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Clique para abrir termo" height="70" width="70" src="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/adobe_cinza.jpg');?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                                </a>
                            </div>

                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Anexar Termo PDF </strong></label>
                                <input autofocus tabindex="1" class="form-control form-control-sm" type="file" class="radius" name="file_terms"/>
                            </div>

                        </div>

                        <div class="row mb-1">

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputMovimentacao"><i class="bi bi-person-add me-1"></i><strong>Estado</strong></label>
                                <input tabindex="2" type="text" data-bs-togglee="tooltip" autofocus data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o estado do patrimonio - Ex : 1- ESTOQUE, 2 - RETIRADO ... " class="form-control form-control-sm movement_id"
                                    name="movement_id" placeholder="ESTADO">
                            </div>

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Usuario</strong></label>
                                <input  tabindex="3" type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o usuário - Ex : 1 - João Bento Badaró" class="form-control form-control-sm user_id"
                                    name="user_id_edit" id="user_id_edit" placeholder="USUÁRIO">
                            </div>

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                <input tabindex="6" type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite a unidade - Ex : 22 - SIGECINFO/COTI" class="form-control form-control-sm unit_id"
                                    name="unit_id_edit" id="unit_id_edit" placeholder="UNIDADE">
                            </div>

                        </div>

                        <div class="row mb-3 mb-1">   
                            <div class="col-12 mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea tabindex="4" class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                data-bs-title=Observações" rows="2" name="observations"></textarea>
                            </div>

                        </div>         

                        <div class="row justify-content-center mt-3 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "5", "g")?>
                            <?=buttonLink("/beta/patrimonios", "top", "Clique para listar os patrimônios", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">

                        <h5 class="card-title text-center text-success"><i class="bi bi-journal-text me-1"></i> Histórico do Patrimônio</h5>
                            <?php $this->insert("widgets/patrimonys/historyList"); ?>  
                    </div>
                </div>
            </div>


        </form>

    <?php  endif; ?>
</div>

    <?php $this->start("scripts"); ?>
        <script>

            let movement_id = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: <?=$patrimonyscreates->completeMovement()?>
            });
            movement_id.initialize();
            $('.movement_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: movement_id});
            
            let product_id = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: <?=$patrimonyscreates->completeProduct()?>
            });
            product_id.initialize();
            $('.product_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: product_id});
            
            let user_id = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: <?=$patrimonyscreates->completeUser()?>
            });
            user_id.initialize();
            $('.user_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: user_id});

            let unit_id = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: <?=$patrimonyscreates->completeUnit()?>
            });
            unit_id.initialize();
            $('.unit_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: unit_id});

        </script>
    <?php $this->end(); ?>