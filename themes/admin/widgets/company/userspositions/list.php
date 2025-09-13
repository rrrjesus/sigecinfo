<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-12">

                    <div class="row justify-content-center">
                        <div class="col-12 ajax_response">
                            <?=flash();?>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4 mb-3">
                        <div class="col-auto">
                        <?=buttonLink("/painel/cargos/cadastrar", "top", "Clique para cadastrar cargo", "success", "building-add", "Cadastrar", "1", "c")?> 
                        <?php if(!empty($registers->disabled)){ ?>
                            <?=buttonLinkDisabled("/painel/cargos/desativados", "top", "Clique para listar os cargos desativados", "secondary", "building-add", "Desativados", "2", "D", $registers->disabled)?> 
                        <?php } ?>
                        </div>
                    </div>

                    <table id="userspositions" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">EDITAR</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">CARGO</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">DESATIVAR</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($userspositions)){ ?>
                        <?php foreach ($userspositions as $lista): ?>
                        <tr>
                            <td class="text-center fw-semibold"><a href="<?= url("/painel/cargos/editar/{$lista->id}"); ?>" 
                            role="button" aria-disabled="true" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                            data-bs-title="Clique para editar" class="btn btn-sm btn-outline-warning rounded-circle fw-bold me-2"><i class="bi bi-pencil text-secondary"></i></a></td>
                            <td class="text-center fw-semibold"><?=$lista->id?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->position_name) ? $lista->position_name : "")?></td>
                            <td class="text-center fw-semibold"><?=$lista->statusBadge()?></td>
                            <td class="text-center"><button type="button" data-bs-togglee="modal" data-bs-toggle="modal" data-bs-target="#disabled-<?=$lista->id;?>" 
                                class="btn btn-outline-warning rounded-circle btn-sm text-center"><i class="bi bi-person"></i></b></td>
                                <!-- Modal -->
                            <div class="modal fade" id="disabled-<?=$lista->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-person-x text-dark me-2"></i> DESATIVAR </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body fs-5 text-center">
                                            Deseja desativar o Cargo <?=$lista->position_name?> ?
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3" data-bs-dismiss="modal"><i class="bi bi-trash me-2"></i>Não</button>
                                            <a href="cargos/desativar/<?=$lista->id?>/disabled" role="button" class="btn btn-sm btn-outline-success fw-semibold"><i class="bi bi-check2-circle me-2"></i>Sim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
    </div>     
</div>