<?php $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="row justify-content-center mt-5">

    <div class="col-xl-12">

        <?php if (!$usercategory): ?>

        <!-- Cadastro de Regime -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="usercategory" novalidate action="<?= url("/painel/regimes/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="action" value="create"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCargo"><strong><i class="bi bi-person me-1"></i> Regime</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o Regime do Servidor" class="form-control form-control-sm"
                                    name="category_name" placeholder="Regime do Servidor">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/regimes", "top", "Clique para listar os regimes", "secondary", "list", "Listar", "7", "l")?>                                  
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
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="usercategory" novalidate action="<?= url("/painel/regimes/editar/{$usercategory->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">  

                            <div class="col-6 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputCargo"><strong><i class="bi bi-person me-1"></i> Regime</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o Regime do Servidor" class="form-control form-control-sm"
                                    name="category_name" placeholder="Regime do Servidor" value="<?=$usercategory->category_name?>">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/regimes", "top", "Clique para listar os regimes", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>