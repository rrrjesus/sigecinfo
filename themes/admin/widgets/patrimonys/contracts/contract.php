<?php $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="row justify-content-center">
    <div class="col-xl-12">

        <?php if (!$contracts): ?>

        <!-- Cadastro de contratos -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="contract" novalidate action="<?= url("/painel/patrimonio/contratos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="action" value="create"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row">

                            <div class="col-3 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputSei"><strong><i class="bi bi-person me-1"></i> Processo SEI</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o Número de Processo SEI - Ex : 6012.2019/0005605-6" class="form-control form-control-sm mask-sei"
                                        name="sei_process" placeholder="6012.2019/0005605-6">

                            </div>

                            <div class="col-6 mb-1">
                            <label class="col-form-label col-form-label-sm" for="inputProcess"><strong><i class="bi bi-person me-1"></i> Nome do Contrato</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome do Contrato - Ex : Simpress Tabets/Impressoras 2021" class="form-control form-control-sm"
                                    name="contract_name" placeholder="Simpress Tabets/Impressoras 2021">

                            </div>

                            
                            <div class="col-3 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputStatus"><strong><i class="bi bi-check2-square ms-3 me-3"></i> Status</strong></label>
                                <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Selecione o status" name="status" id="status">
                                    <option value="actived" selected>Ativo</option>
                                    <option value="disabled">Inativo</option>
                                </select>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 mb-1">
                            <label class="col-form-label col-form-label-sm" for="inputManager"><strong><i class="bi bi-person me-1"></i> Nome do Responsável</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome do Responsável pelo Contrato" class="form-control form-control-sm user_manager"
                                    name="manager_id" placeholder="Responsável pelo Contrato">

                            </div>

                            <div class="col-4 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputInspector"><strong><i class="bi bi-person me-1"></i> Nome do Fiscal</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o nome do Fiscal do Contrato" class="form-control form-control-sm user_inspector"
                                        name="inspector_id" placeholder="Fiscal do Contrato">

                                </div>

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputDeputyInspector"><strong><i class="bi bi-person me-1"></i> Nome do Suplente</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o nome do Suplente do Contrato" class="form-control form-control-sm user_deputy_inspector"
                                        name="deputy_inspector_id" placeholder="Suplente do Contrato">

                                </div>

                        </div>

                        <div class="row">  

                            <div class="col-12 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descrição</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Descrição" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO" id="description">
                            </div>

                        </div>

                        <div class="row">  

                            <div class="md-12 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title=Observações" name="observations" rows="2"></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/patrimonio/contratos", "top", "Clique para listar os contratos", "secondary", "list", "Listar", "7", "l")?>                                  
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
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="brand" novalidate action="<?= url("/painel/patrimonio/contratos/editar/{$contracts->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row">

                            <div class="col-3 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputSei"><strong><i class="bi bi-person me-1"></i> Processo SEI</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o Número de Processo SEI - Ex : 6012.2019/0005605-6" class="form-control form-control-sm"
                                        name="sei_process" placeholder="6012.2019/0005605-6" value="<?=$contracts->sei_process?>">

                            </div>

                            <div class="col-6 mb-1">
                            <label class="col-form-label col-form-label-sm" for="inputProcess"><strong><i class="bi bi-person me-1"></i> Nome do Contrato</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome do Contrato - Ex : Simpress Tabets/Impressoras 2021" class="form-control form-control-sm"
                                    name="contract_name" placeholder="Simpress Tabets/Impressoras 2021" value="<?=$contracts->contract_name?>">

                            </div>

                            
                            <div class="col-3 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputStatus"><strong><i class="bi bi-check2-square ms-3 me-3"></i> Status</strong></label>
                                <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title="Selecione o status" name="status" id="status">
                                    <?=$contracts->statusSelect()?>
                                </select>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 mb-1">
                            <label class="col-form-label col-form-label-sm" for="inputManager"><strong><i class="bi bi-person me-1"></i> Nome do Responsável</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o nome do Responsável pelo Contrato" class="form-control form-control-sm user_manager"
                                    name="manager_id" placeholder="Responsável pelo Contrato" value="<?=(!empty($contracts->userManager()->id) ? $contracts->userManager()->id.' - '.$contracts->userManager()->user_name : "")?>">

                            </div>

                            <div class="col-4 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputInspector"><strong><i class="bi bi-person me-1"></i> Nome do Fiscal</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o nome do Fiscal do Contrato" class="form-control form-control-sm user_inspector"
                                        name="inspector_id" placeholder="Fiscal do Contrato" value="<?=(!empty($contracts->userInspector()->id) ? $contracts->userInspector()->id.' - '.$contracts->userInspector()->user_name : "")?>">

                                </div>

                            <div class="col-4 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputDeputyInspector"><strong><i class="bi bi-person me-1"></i> Nome do Suplente</strong></label>
                                    <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                        data-bs-title="Digite o nome do Suplente do Contrato" class="form-control form-control-sm user_deputy_inspector"
                                        name="deputy_inspector_id" placeholder="Suplente do Contrato" value="<?=(!empty($contracts->userDeputyInspector()->id) ? $contracts->userDeputyInspector()->id.' - '.$contracts->userDeputyInspector()->user_name : "")?>">

                                </div>

                        </div>

                        <div class="row">  

                            <div class="col-12 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descrição</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Descrição" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO" id="description" value="<?=$contracts->description?>">
                            </div>

                        </div>

                        <div class="row">  

                            <div class="md-12 mb-1">
                                <label for="textareaObservacoes" class="col-form-label col-form-label-sm"><i class="bi bi-exclamation-diamond me-1"></i><strong>Observações</strong></label>
                                <textarea class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                data-bs-title=Observações" name="observations" rows="2"><?=$contracts->observations?></textarea>
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/patrimonio/contratos", "top", "Clique para listar os contratos", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>

        <?php $this->start("scripts"); ?>
            <script>

                let user_manager = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$users->completeUser()?>
                });
                user_manager.initialize();
                $('.user_manager').typeahead({hint: true, highlight: true, minLength: 1}, {source: user_manager});

                let user_inspector = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$users->completeUser()?>
                });
                user_inspector.initialize();
                $('.user_inspector').typeahead({hint: true, highlight: true, minLength: 1}, {source: user_inspector});

                let user_deputy_inspector = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$users->completeUser()?>
                });
                user_deputy_inspector.initialize();
                $('.user_deputy_inspector').typeahead({hint: true, highlight: true, minLength: 1}, {source: user_deputy_inspector});
            </script>
        <?php $this->end(); ?>
    </div>