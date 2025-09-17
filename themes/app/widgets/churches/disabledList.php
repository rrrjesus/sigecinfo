<?php $this->layout("_beta"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<?php 
    if(user()->level_id < 3){
        redirect("/beta/usuarios");
    }
?>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 ajax_response">
            <?=flash();?>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <a data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                data-bs-title="Clique para sair" class="btn btn-outline-danger btn-sm me-3 fw-semibold" href="<?=url("/beta/contatos")?>"
                role="button"><i class="bi bi-arrow-right-circle me-2 mt-1"></i>Sair</a>

        </div>
    </div>
    

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="contacts" class="table table-bordered table-sm border-warning table-hover" style="width:100%">
                <thead class="table-warning">
                <tr>
                    <th class="text-center"><i class="bi bi-unlock me-1"></i><br>REATIVAR</th>
                    <th class="text-center"><i class="bi bi-person-gear me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>SETOR</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>RAMAL</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>ATIVAR</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($contacts) && user()->level_id > 3){ ?>
                <?php foreach ($contacts as $lista): ?>
                    <tr>
                        <td class="text-center"><a href="../contatos/ativar/<?=$lista->id?>/actived" data-bs-togglee="tooltip" 
                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" data-bs-title="Clique para reativar <?=$lista->contact_name?>" role="button" 
                            class="btn btn-outline-warning rounded-circle btn-sm text-center"><i class="bi bi-telephone-outbound text-secondary"></i></a></td>
                        <td class="text-center"><?=$lista->contact_name;?></td>
                        <td class="text-center"><?=$lista->unit()->unit_name;?></td>
                        <td class="text-center"><?=$lista->ramal;?></td>
                        <td class="text-center"><button type="button" data-bs-togglee="modal" data-bs-toggle="modal" data-bs-target="#disabled-<?=$lista->id;?>" 
                        class="btn btn-outline-success rounded-circle btn-sm text-center"><i class="bi bi-telephone-x"></i></b></td>
                            <!-- Modal -->
                        <div class="modal fade" id="disabled-<?=$lista->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header bg-success text-light">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-telephone-x me-2"></i> ATIVAR <?=$lista->ramal;?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body fs-5 text-center">
                                    Deseja ativar o Ramal <?=$lista->ramal?> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger fw-semibold" data-bs-dismiss="modal">Não</button>
                                    <a href="../contatos/ativar/<?=$lista->id?>/actived" role="button" class="btn btn-outline-success fw-semibold">Sim</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/beta/contatos");} ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



