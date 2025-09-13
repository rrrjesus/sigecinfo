<?php $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="row justify-content-center mt-5">

    <div class="col-xl-12">

        <?php if (!$userposition): ?>

        <!-- Cadastro de Cargo -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="userposition" novalidate action="<?= url("/painel/cargos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="action" value="create"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputCargo"><strong><i class="bi bi-person me-1"></i> Cargo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o Cargo do Servidor" class="form-control form-control-sm"
                                    name="position_name" placeholder="Cargo do Servidor">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/cargos", "top", "Clique para listar os cargos", "secondary", "list", "Listar", "7", "l")?>                                  
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
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="userposition" novalidate action="<?= url("/painel/cargos/editar/{$userposition->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">  

                            <div class="col-6 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputCargo"><strong><i class="bi bi-person me-1"></i> Cargo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Digite o Cargo do Servidor" class="form-control form-control-sm"
                                    name="position_name" placeholder="Cargo do Servidor" value="<?=$userposition->position_name?>">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                            <?=button("top", "Clique para gravar", "success", "disc-fill", "Gravar", "6", "g")?>
                            <?=buttonLink("/painel/cargos", "top", "Clique para listar os cargos", "secondary", "list", "Listar", "7", "l")?>                                  
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>