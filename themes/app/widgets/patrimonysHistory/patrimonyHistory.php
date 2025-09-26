
<?= $this->layout("_beta"); ?>

        <!-- Breacrumb-->
        <?= $this->insert("views/theme/breadcrumb"); ?>

    <div class="container-fluid">

        <form class="row gy-2 gx-3 align-items-center needs-validation" id="patrimony" novalidate action="<?= url("/beta/patrimonio/historico/editar/{$patrimonys->id}"); ?>" method="post" enctype="multipart/form-data">
                        
            <input type="hidden" name="action" value="update"/>

            <div class="ajax_response"><?=flash();?></div>

            <?=csrf_input();?>

            <style>
                .box {
                    background:linear-gradient(rgb(25 135 84),rgb(25 135 84)) left/10px 100% no-repeat;
                    }
            </style>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">
                        <div class="row ms-1">
                            <div class="col-2">
                                <img src="<?=image($patrimonys->product()->photo, 130, 130)?>" class="img-thumbnail rounded float-start" alt="<?=$patrimonys->product()->photo?>">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title"><?=$patrimonys->product()->brand()->brand_name.' '.$patrimonys->product()->product_name.' - '.$patrimonys->product()->type_part_number.' : '.$patrimonys->part_number?></h5>
                                <p class="card-text"><?=$patrimonys->product()->acessories?></p>
                                <p class="card-text"><b><?=$patrimonys->movement()->movement_name?></b> em <?=date_fmt($patrimonys->updated_at)?> - <b>Usuario : </b><?=(!empty($patrimonys->user()->user_name) ? $patrimonys->user()->user_name : 'Não Cadastrado')?> - <b>Igreja : </b><?=$patrimonys->church()->church_name.buttonLink("/beta/patrimonio/historico/termo/{$patrimonys->id}", "top", "Clique para imprimir o termo", "primary ms-3", "file-earmark-word", "Termo", "9", "t", "_blank")?><?=$patrimonys->fileTerm()?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-3 ms-1">
                <div class="card box">
                    <div class="card-body">
                        <h5 class="card-title text-center text-success">Editar Histórico de Movimentação</h5>

                        <div class="row mb-1">

                            <div class="col-1 mb-1">
                                <a href="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/adobe_cinza.jpg');?>" target="_blank">
                                <img data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Clique para abrir termo" height="70" width="70" src="<?=url('themes/'.CONF_VIEW_APP.'/assets/images/adobe_cinza.jpg');?>" class="img-thumbnail rounded-circle float-left" id="foto-cliente">
                                </a>
                            </div>

                            <div class="col-4 mb-1">
                                <label for="formFileSm" class="col-form-label col-form-label-sm"> <strong><i class="bi bi-upload me-1"></i>  Anexar Termo PDF </strong></label>
                                <input autofocus tabindex="1" class="form-control form-control-sm" type="file" class="radius" name="file_terms"/>
                            </div>
                        </div>
                                
                        <input name="patrimony_id" type="hidden" value="<?=(!empty($patrimonys->patrimony_id) ? $patrimonys->patrimony_id : "")?>">

                        <div class="row mb-1">

                            <div class="col-2 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputMovimentacao"><i class="bi bi-person-add me-1"></i><strong>Estado</strong></label>
                                <input type="text" tabindex="2" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o estado do patrimonio - Ex : 1- ESTOQUE, 2 - RETIRADO ... " class="form-control form-control-sm movement_id"
                                    name="movement_id" placeholder="ESTADO" value="<?=(!empty($patrimonys->movement_id) ? $patrimonys->movement()->id.' - '.$patrimonys->movement()->movement_name : "")?>">
                            </div>

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Usuario</strong></label>
                                <input tabindex="3" type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o usuário - Ex : 1 - João Bento Badaró" class="form-control form-control-sm user_id"
                                    name="user_id_history_edit" id="user_id_history_edit" placeholder="USUÁRIO" value="<?=(!empty($patrimonys->user_id) ? $patrimonys->user()->id.' - '.$patrimonys->user()->user_name : "")?>">
                            </div>

                            <div class="col-5 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Igreja</strong></label>
                                <input tabindex="6" type="text" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite a igreja - Ex : 22 - SIGECINFO/COTI" class="form-control form-control-sm church_id"
                                    name="church_id_history_edit" id="church_id_history_edit" placeholder="IGREJA" value="<?=(!empty($patrimonys->church_id) ? $patrimonys->church()->id.' - '.$patrimonys->church()->church_name : "")?>">
                            </div>

                        </div>

                        <div class="row">   

                            <div class="mb-3 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea tabindex="4" class="form-control form-control-sm" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title=Observações" rows="2" name="observations"><?=$patrimonys->observations?></textarea>
                            </div>

                        </div>         

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "5", "g")?>
                            <?=buttonLink("/beta/patrimonios", "top", "Clique para listar os patrimônios", "secondary", "list", "Listar", "7", "l")?>                                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </form>

        </div>

        <?php $this->start("scripts"); ?>
            <script>

                let movement_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$patrimonyscreates->completeMovement()?>
                });
                movement_id.initialize();
                $('.movement_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: movement_id});
                
                let user_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$patrimonyscreates->completeUser()?>
                });
                user_id.initialize();
                $('.user_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: user_id});

                let church_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$patrimonyscreates->completeChurch()?>
                });
                church_id.initialize();
                $('.church_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: church_id});

            </script>
        <?php $this->end(); ?>