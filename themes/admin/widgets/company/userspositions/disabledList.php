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

                    <div class="row justify-content-center mb-4">
                        <div class="col-12 ml-auto text-center">
                            <?=buttonLink("/painel/cargos", "top", "Clique para sair", "danger", "arrow-right-circle me-2 mt-1", "Sair", "1", "c")?> 
                        </div>
                    </div>

                    <table id="userspositionsDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                        <thead class="table-danger">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">CARGO</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">ATIVAR</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($userspositions)){ ?>
                        <?php foreach ($userspositions as $lista): ?>
                        <tr>
                            <td class="text-center fw-semibold"><?=$lista->id?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->position_name) ? $lista->position_name : "")?></td>
                            <td class="text-center fw-semibold"><?=$lista->statusBadge()?></td>
                            <td class="text-center"><button type="button" data-bs-togglee="modal" data-bs-toggle="modal" data-bs-target="#actived-<?=$lista->id;?>" 
                                class="btn btn-outline-success rounded-circle btn-sm text-center"><i class="bi bi-person"></i></b></td>
                                <!-- Modal -->
                            <div class="modal fade" id="actived-<?=$lista->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a href="ativar/<?=$lista->id?>/actived" role="button" class="btn btn-sm btn-outline-success fw-semibold"><i class="bi bi-check2-circle me-2"></i>Sim</a>
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