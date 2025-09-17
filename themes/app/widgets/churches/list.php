
<?php $this->layout("_beta"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">

<?php if(user()->level_id > 3){;?>
    <div class="row justify-content-center">
        <div class="col-12 ajax_response">
            <?=flash();?>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?=buttonLink("/beta/contatos/cadastrar", "top", "Cadastrar contato", "success", "person", "Cadastrar")?>
            <?php 
                if(!empty($registers->disabled) && user()->level_id > 3){ ?>
                    <?=buttonLinkDisabled("/beta/contatos/desativados", "top", "Clique para acessar contatos desativados", "secondary", "telephone-x", "Desativados", "2", "D", $registers->disabled)?> 
            <?php } ?>

        </div>
    </div>
    

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="contacts" class="table table-hover table-bordered table-sm border-<?=CONF_APP_COLOR?>" style="width:100%">
                <thead class="table-<?=CONF_APP_COLOR?>">
                <tr>
                    <th class="text-center"><i class="bi bi-unlock me-1"></i><br>EDITARS</th>
                    <th class="text-center"><i class="bi bi-person-gear me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>RAMAL</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>SETOR</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>RESPONSAVEL</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>TEL RESP.</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>DESATIVAR</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($contacts)){ ?>
                <?php foreach ($contacts as $lista): ?>
                    <tr>
                        <td class="text-center"><a href="contatos/editar/<?=$lista->id?>" data-bs-togglee="tooltip" 
                            data-bs-placement="right" data-bs-custom-class="custom-tooltip-success" data-bs-title="Clique para editar <?=$lista->contact_name?>" role="button" 
                            class="btn btn-outline-warning rounded-circle btn-sm text-center <?php if(user()->level_id < 3){echo 'disabled';}?>"><i class="bi bi-pencil text-<?=CONF_APP_COLOR?>"></i></a></td>
                        <td class="text-center text-uppercase"><?=$lista->contact_name;?></td>
                        <td class="text-center">4934-<?=$lista->ramal;?></td>
                        <td class="text-center"><?=$lista->church()->unit_name;?></td>
                        <td class="text-center text-uppercase"><?=$lista->church()->it_professional;?></td>
                        <td class="text-center"><?=$lista->church()->fixed_phone;?></td>
                        <td class="text-center"><button type="button" data-bs-togglee="modal" data-bs-toggle="modal" data-bs-target="#disabled-<?=$lista->id;?>" 
                        class="btn btn-outline-danger rounded-circle btn-sm text-center"><i class="bi bi-telephone-x"></i></b></td>
                            <!-- Modal -->
                        <div class="modal fade" id="disabled-<?=$lista->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-telephone-x text-dark me-2"></i> DESATIVAR <?=$lista->ramal;?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body fs-5 text-center">
                                        Deseja desativar o Ramal <?=$lista->ramal?> ?
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-outline-danger fw-semibold me-3" data-bs-dismiss="modal"><i class="bi bi-trash me-2"></i>Não</button>
                                        <a href="contatos/desativar/<?=$lista->id?>/disabled" role="button" class="btn btn-outline-success fw-semibold"><i class="bi bi-check2-circle me-2"></i>Sim</a>
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
    <?php }else{;?>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="contacts" class="table table-bordered table-sm border-<?=CONF_APP_COLOR?> table-hover" style="width:100%">
                <thead class="table-<?=CONF_APP_COLOR?>">
                <tr>
                    <th class="text-center"><i class="bi bi-person-gear me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>SETOR</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>RAMAL</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>STATUS</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($contacts)){ ?>
                <?php foreach ($contacts as $lista): ?>
                    <tr>
                        <td class="text-center"><?=$lista->contact_name;?></td>
                        <td class="text-center"><?=$lista->church()->unit_name;?></td>
                        <td class="text-center"><?=$lista->ramal;?></td>
                        <td class="text-center"><?=$lista->statusBadge();?></td>
                    </tr>
                <?php endforeach; ?>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</div>



