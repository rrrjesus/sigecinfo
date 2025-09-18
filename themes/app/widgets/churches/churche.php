<?= $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if (!$churchs): ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="church" novalidate action="<?= url("/beta/igrejas/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    
                        <input type="hidden" name="action" value="create"/>

                        <?=csrf_input();?>

                        <div class="ajax_response"><?=flash();?></div>

                        <div class="row justify-content-center">
                        
                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputChurch"><strong><i class="bi bi-person me-1"></i> Igreja</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite a igreja" class="form-control form-control-sm"
                                    name="church_name" placeholder="IGREJA">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar")?>
                            <?=buttonLink("/beta/igrejas", "top", "Clique para listar as igrejas", "dark", "list", "Listar")?>                                  
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
                <form class="row gy-2 gx-3 align-items-center needs-validation" id="church" novalidate action="<?= url("/beta/igrejas/editar/{$churchs->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputIgreja"><strong><i class="bi bi-person me-1"></i> Igreja</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-success" 
                                    data-bs-title="Digite a igreja" class="form-control form-control-sm"
                                    name="church_name" placeholder="IGREJA" value="<?=$churchs->church_name?>">

                            </div>
                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar")?>
                                <?=buttonLink("/beta/igrejas", "top", "Clique para listar as igrejas", "dark", "list", "Listar")?>                                  
                            </div>
                        </div>

                        </form>
                </div>
            </div>
        </div>

        <?php  endif; ?>
        <?php $this->start("scripts"); ?>
        <?php $this->end(); ?>

    </div>
</div>
