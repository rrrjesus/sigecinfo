<?= $this->layout("_admin"); ?>

<div class="col-12 ml-auto mt-3"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-chevron p-2 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="<?=url("/painel")?>"><i class="bi bi-house-heart"></i> Painel</a></li>
            <li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="<?=url("/grupos")?>"><i class="bi bi-people"></i> Grupos</a></li>
            <li class="breadcrumb-item fw-semibold active" aria-current="page"><i class="bi bi-list"></i> <?php

 if(!empty($group->id)): echo "Editar ".$group->group_name; else : echo "Cadastrar"; endif;?></li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <?php if (!$group): ?>
        <div class="card mb-4">
        <div class="card-header text-center fw-bold fs-6 pt-1 pb-1"><i class="bi bi-qr-code pe-3"></i>   SISTEMA JAÇANA CONTROLE - 2024</div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center">
                            <div class="col-12">
                                <form class="row gy-2 gx-3 align-items-center needs-validation" novalidate id="group-register" action="<?=url("/painel/grupos/adicionar")?>" method="post" enctype="multipart/form-data">

                                    <!-- ACTION SPOOFING-->
                                    <input type="hidden" name="action" value="create"/>

                                    <div class="row justify-content-center mb-3 mt-3">
                                        <div class="ajax_response col-xl-12 col-12">
                                            <?=flash();?>
                                        </div>
                                    </div>

                                    <?=csrf_input();?>

                                    <div class="row justify-content-center">
                                        <div class="col-3 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-people ms-3 me-3"></i> Grupo</strong></label>
                                            <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                                data-bs-title="Digite o nome do grupo" class="form-control form-control-sm" name="group_name" placeholder="Grupo">
                                        </div>

                                        <div class="col-6 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-people ms-3 me-3"></i> Descrição do Grupo</strong></label>
                                            <input type="text" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                                data-bs-title="Digite a descrição do grupo" class="form-control form-control-sm" name="description" placeholder="Descrição">
                                        </div>

                                        <div class="col-3 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputStatus"><strong><i class="bi bi-check2-square ms-3 me-3"></i> Status</strong></label>
                                            <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                            data-bs-title="Digite o status" name="status" id="status">
                                                <option value="actived" selected>Ativo</option>
                                                <option value="disabled">Inativo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center mt-4 mb-3">
                                        <div class="col-auto">
                                            <button data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                                    data-bs-title="Clique para gravar" class="btn btn-sm btn-outline-success fw-bold me-3"><i class="bi bi-disc-fill me-1"></i> GRAVAR</button>
                                            <a href="<?=url("/grupos")?>" data-bs-togglee="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                               data-bs-title="Clique para listar as pessoas" class="btn btn-sm btn-outline-info fw-bold"><i class="bi bi-list-columns me-2"></i>LISTAR</a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card mb-4">
            <div class="card-header text-center fw-bold fs-6 pt-1 pb-1"><i class="bi bi-qr-code pe-3"></i>   SISTEMA JAÇANA CONTROLE - 2024</div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-center">
                        <div class="col-12">
                            <form class="row gy-2 gx-3 align-items-center needs-validation" novalidate id="collaborator-edit" action="<?=url("/painel/grupos/editar/{$group->id}")?>" method="post" enctype="multipart/form-data">

                                <!-- ACTION SPOOFING-->
                                <input type="hidden" name="action" value="update"/>

                                <div class="row justify-content-center mb-3 mt-3">
                                    <div class="ajax_response col-xl-12 col-12">
                                        <?=flash();?>
                                    </div>
                                </div>

                                <?=csrf_input();?>

                                    <div class="row justify-content-center">

                                        <div class="col-3 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-people ms-3 me-3"></i> Grupo</strong></label>
                                            <input type="text" value="<?=$group->group_name?>" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                                data-bs-title="Digite o nome do grupo" class="form-control form-control-sm" name="group_name" placeholder="grupo">
                                        </div>

                                        <div class="col-6 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputSetor"><strong><i class="bi bi-people ms-3 me-3"></i> Descrição do Grupo</strong></label>
                                            <input type="text" value="<?=$group->description?>" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                                data-bs-title="Digite a descrição do grupo" class="form-control form-control-sm" name="description" placeholder="descrição">
                                        </div>

                                        <div class="col-3 mb-1">
                                            <label class="col-form-label col-form-label-sm" for="inputStatus"><strong><i class="bi bi-check2-square ms-3 me-3"></i> Status</strong></label>
                                            <select class="form-control form-control-sm" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                                            data-bs-title="Digite o status" name="status" id="status">
                                                <option value="disabled"<?php if ($group->status == "disabled") {echo 'selected';}?>>Inativo</option>
                                                <option value="actived"<?php if ($group->status == "actived") {echo 'selected';}?>>Ativo</option>
                                            </select>
                                        </div>
                        
                                    </div>

                                <div class="row justify-content-center mt-4 mb-3">
                                    <div class="col-auto">
                                        <button data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                            data-bs-title="Clique para atualizar a pessoa" class="btn btn-sm btn-outline-success fw-bold me-3"><i class="bi bi-disc-fill me-1"></i> ATUALIZAR</button>
                                        <a href="<?=url("/grupos")?>" data-bs-togglee="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                                           data-bs-title="Clique para listar as pessoas" class="btn btn-sm btn-outline-info fw-bold"><i class="bi bi-list-columns me-2"></i>LISTAR</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php  endif; ?>
    </div>
</div>
