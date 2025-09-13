<?php $this->layout("_admin"); ?>

<div class="col-12 ml-auto mt-3"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-chevron p-2 bg-body-tertiary rounded-3">
        <li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="<?=url("/dashboard")?>"><i class="bi bi-house-door"></i> Lista</a></li>
            <li class="breadcrumb-item fw-semibold active" aria-current="page"><i class="bi bi-person"></i> Grupos</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="card mb-4 border-secondary">
            <div class="card-body">
                <div class="container-fluid">

                    <div class="row justify-content-center">
                        <div class="col-12 ajax_response">
                            <?=flash();?>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-4">
                        <div class="col-12 ml-auto text-center">
                            <a data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                               data-bs-title="Clique para cadastrar novo colaborador" class="btn btn-outline-danger btn-sm me-3 fw-semibold" href="<?=url("/grupos")?>"
                               role="button"><i class="bi bi-arrow-right-circle me-2 mt-1"></i>Sair</a>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="col-12">
                            <table id="groupsDisabled" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                                <thead class="table-secondary">
                                <tr>
                                <th class="text-center"><i class="bi bi-lock me-3"></i>ID</th>
                                <th class="text-center"><i class="bi bi-people me-3"></i>GRUPO</th>
                                <th class="text-center"><i class="bi bi-people me-3"></i>DESCRIÇÃO</th>
                                <th class="text-center"><i class="bi bi-person-check me-3"></i>ATIVAR</th>
                                <th class="text-center"><i class="bi bi-trash me-3"></i>EXCLUIR</th>
                                </tr>
                                </thead>
                                <tbody>
                    <?php if(!empty($registers->disabled)){ ?>
                    <?php foreach ($groups as $lista): ?>
                        <tr>
                            <td class="text-center"><?=$lista->id?></td>
                            <td class="text-center"><?=$lista->group_name?></td>
                            <td class="text-center"><?=$lista->description?></td>
                            <td class="text-center"><?=$lista->id?></td>
                            <td class="text-center"><?=$lista->id?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>