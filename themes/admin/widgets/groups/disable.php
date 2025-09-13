<?= $this->layout("_panel"); ?>

<div class="col-12 ml-auto mt-3"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-chevron p-2 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none text-secondary" href="<?=url("")?>"><i class="bi bi-house-door"></i> Painel</a></li>
            <li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none text-secondary" href="<?=url("/painel/agenda/ramais/ativados")?>"><i class="bi bi-telephone"></i> Ramais</a></li>
            <li class="breadcrumb-item fw-semibold active" aria-current="page"><i class="bi bi-list"></i> Ramais Desativados <span class="badge bg-secondary rounded-pill"><?=$lixeira?></span></li>
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
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                               data-bs-title="Clique para listar ramais" class="btn btn-outline-danger btn-sm fw-semibold" href="<?=url("/painel/agenda/ramais/ativados")?>"
                               role="button"><i class="bi bi-arrow-right-circle me-2"></i>Sair</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="col-12">
                            <table id="pessoasDisabled" class="table table-sm table-bordered border-secondary table-striped" style="width:100%">
                                <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">SETOR</th>
                                    <th class="text-center">NOME</th>
                                    <th class="text-center">RAMAL</th>
                                    <th class="text-center">EXCLUIDO EM:</th>
                                    <th class="text-center">ATIVAR</th>
                                    <th class="text-center">EXCLUIR</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(!empty($contacts)):
                                        foreach ($contacts as $list):
                                ?>
                                    <tr>
                                        <?php if(!empty($list->sector) && $list->sector()->status == "actived"):
                                            echo '<td class="text-center">'.$list->sector()->sector_name;
                                        else:
                                            echo '<td class="text-center text-danger"><del>'.$list->sector()->sector_name.'<del>';
                                        endif;
                                        ?></td>
                                        <td class="text-center"><?=$list->collaborator?></td>
                                        <td class="text-center"><span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill fs-6"><?=$list->ramal?></span></td>
                                        <td class="text-center"><?php if(empty($list->deleted_at)) {echo '';} else {date('d/m/Y H\hi', strtotime($list->deleted_at));}?></td>
                                        <td class="text-center"><?=$list->id?></td>
                                        <td class="text-center"><?=$list->id?></td>
                                    </tr>
                                <?php
                                        endforeach;
                                            else:
                                                echo '<div class="alert alert-danger fw-semibold text-center" role="alert"><i class="bi bi-telephone fs-5 me-2"></i> Não existem ramais desativados !!!</div>';
                                            endif;
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

