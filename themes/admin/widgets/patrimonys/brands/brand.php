<?php $this->layout("_admin"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

  <div class="row justify-content-center">
    <div class="col-xl-12">

        <?php if (!$marcas): ?>

        <!-- Cadastro de marcas -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="brand" novalidate action="<?= url("/painel/patrimonio/marcas/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="action" value="create"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Nome" class="form-control form-control-sm"
                                    name="brand_name" placeholder="NOME">

                            </div>

                        </div>

                        <div class="row justify-content-center">  

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descrição</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Descrição" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO" id="description">
                            </div>

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <button data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                    data-bs-title="Clique para criar o registro" class="btn btn-sm btn-outline-success fw-bold me-2"><i class="bi bi-disc-fill me-2"></i>GRAVAR</button>
                                <a href="<?=url("/painel/patrimonio/marcas")?>" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                data-bs-title="Clique para listar os usuarios" class="btn btn-sm btn-outline-dark fw-bold">
                                <i class="bi bi-list-columns me-2"></i>LISTAR</a>
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
                    <form class="row gy-2 gx-3 align-items-center needs-validation" id="brand" novalidate action="<?= url("/painel/patrimonio/marcas/editar/{$marcas->id}"); ?>" method="post" enctype="multipart/form-data">
                        
                    <input type="hidden" name="action" value="update"/>

                        <div class="ajax_response"><?=flash();?></div>

                        <?=csrf_input();?>

                        <div class="row justify-content-center">  

                            <div class="col-6 mb-1">

                                <label class="col-form-label col-form-label-sm" for="inputNome"><strong><i class="bi bi-person me-1"></i> Nome</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Nome" class="form-control form-control-sm"
                                    name="brand_name" placeholder="NOME" value="<?=$marcas->brand_name?>">

                            </div>

                        </div>

                        <div class="row justify-content-center">  

                            <div class="col-6 mb-1">
                                <label class="col-form-label col-form-label-sm" for="inputSobreNome"><strong><i class="bi bi-person-add me-1"></i> Descrição</strong></label>
                                <input type="text" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                    data-bs-title="Descrição" class="form-control form-control-sm"
                                    name="description" placeholder="DESCRIÇÃO" id="description" value="<?=$marcas->description?>" >
                            </div> 

                        </div>

                        <div class="row justify-content-center mt-4 mb-3">
                            <div class="col-auto">
                                <button data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                    data-bs-title="Clique para atualizar a marca" class="btn btn-sm btn-outline-success fw-bold me-2"><i class="bi bi-disc-fill me-2"></i>GRAVAR</button>
                                <a href="<?=url("/painel/patrimonio/marcas")?>" role="button" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                data-bs-title="Clique para listar as marcas" class="btn btn-sm btn-outline-smsub fw-bold me-2"><i class="bi bi-list me-2"></i>LISTAR</a>
                                <a href="<?= url("/painel/patrimonio/marcas/excluir/{$marcas->id}/delete"); ?>" class="btn btn-sm btn-outline-danger fw-bold me-2"><i class="bi bi-trash me-2"></i>EXCLUIR</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>