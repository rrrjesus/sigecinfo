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
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o Cargo do Servidor" class="form-control form-control-sm"
                                    name="position_name" placeholder="Cargo do Servidor">

                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?= button([ "name" => "Gravar", "icon" => "person", "btncolor" => "success", "custom" => "dark", "title" => "Clique para gravar", "accesskey" => "g"]); ?>
                                <?= button([ "name" => "Listar", "icon" => "person", "btncolor" => "secondary", "custom" => "dark", "title" => "Clique para listar os cargos", "accesskey" => "l", "href" => "/painel/cargos"]); ?>                                 
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

                                <label class="col-form-label col-form-label-sm" for="inputCargo"><strong><i class="bi bi-person ms-3 me-3"></i> Cargo</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Digite o Cargo do Servidor" class="form-control form-control-sm"
                                    name="position_name" placeholder="Cargo do Servidor" value="<?=$userposition->position_name?>">

                            </div>
                        </div>

                        <div class="row justify-content-center"> 
                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputDescription"><strong><i class="bi bi-building ms-3 me-3"></i> Tipo</strong></label>
                                <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                    data-bs-title="Selecione o ntipo de cargo" name="description">
                                    <option value="<?=$userposition->description?>" selected><?=$userposition->description?></option>
                                    <option value="1">Brigada</option>
                                    <option value="2">Administração</option>
                                    <option value="3">Ministério</option>
                                    <option value="4">Voluntário</option>
                                    <option value="5">Cargo</option>
                                </select>
                            </div>   

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <?= button([ "name" => "Gravar", "icon" => "person", "btncolor" => "success", "custom" => "dark", "title" => "Clique para gravar", "accesskey" => "g"]); ?>
                                <?= button([ "name" => "Listar", "icon" => "person", "btncolor" => "secondary", "custom" => "dark", "title" => "Clique para listar os cargos", "accesskey" => "l", "href" => "/painel/cargos"]); ?>                                 
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>

        <?php $this->start("scripts"); ?>
            <script>

                let type_position = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace, queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: ['Brigada', 'Administração', 'Ministério', 'Voluntário', 'Cargo', 'Outro']
                    });
                status.initialize();
                $('.type_position').typeahead({hint: true, highlight: true, minLength: 1}, {source: status});
            </script>
        <?php $this->end(); ?>
    </div>