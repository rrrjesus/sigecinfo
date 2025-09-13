<?= $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if (!$contacts): ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="user" novalidate action="<?= url("/beta/contatos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    
                        <input type="hidden" name="action" value="create"/>

                        <?=csrf_input();?>

                        <div class="ajax_response"><?=flash();?></div>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Unit" class="form-control form-control-sm unit_id"
                                    name="unit_id" placeholder="UNIDADE">
                            </div>

                        </div>

                        <div class="row justify-content-center">
                        
                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="contact_name" placeholder="NOME">

                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Ramal</strong></label>

                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">4934-</span>
                                    <input type="text" class="form-control" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" name="ramal" placeholder="49343000" aria-label="49343000">
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar")?>
                            <?=buttonLink("/beta/contatos", "top", "Clique para listar os usuarios", "dark", "list", "Listar")?>                                  
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
                <form class="row gy-2 gx-3 align-items-center needs-validation" id="user" novalidate action="<?= url("/beta/contatos/editar/{$contacts->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>
                                
                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><i class="bi bi-person-add me-1"></i><strong>Unidade</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Unit" class="form-control form-control-sm unit_id"
                                    name="unit_id" placeholder="UNIDADE" value="<?=$contacts->unit()->id.' - '.$contacts->unit()->unit_name?>">
                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o nome" class="form-control form-control-sm"
                                    name="contact_name" placeholder="NOME" value="<?=$contacts->contact_name?>">

                            </div>
                        </div>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCelular"><strong><i class="bi bi-phone me-1"></i> Ramal</strong></label>

                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">4934-</span>
                                    <input type="text" class="form-control" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite o numero do fixo - DDD + 8 dígitos" name="ramal" placeholder="49343000" aria-label="49343000" 
                                    value="<?=$contacts->ramal?>">
                                </div>
                            </div>

                        </div>


                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar")?>
                                <?=buttonLink("/beta/contatos", "top", "Clique para listar os usuarios", "dark", "list", "Listar")?>                                  
                            </div>
                        </div>

                        </form>
                </div>
            </div>
        </div>

        <?php  endif; ?>
        <?php $this->start("scripts"); ?>
            <script>

                let unit_id = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: <?=$unit->completeUnit()?>
                });
                unit_id.initialize();
                $('.unit_id').typeahead({hint: true, highlight: true, minLength: 1}, {source: unit_id});

            </script>
        <?php $this->end(); ?>

    </div>
</div>
