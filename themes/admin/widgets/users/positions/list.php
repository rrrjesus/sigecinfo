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
                        <?= button(["href" => "/painel/cargos/cadastrar", "accesskey" => "c", "title" => "Clique para cadastrar novo cargo", "name" => "Cadastrar", "icon" => "building-add"]); ?>
               <?php 
                    if(!empty($registers->disabled)){ ?>
                        <?= button(["href" => "/painel/cargos/desativados", "accesskey" => "d", "title" => "Clique para listar cargos desativados", "name" => "Desativados", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
            <?php } ?>
                        </div>
                    </div>

                    <table id="userspositions" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">EDITAR</th>
                                <th class="text-center">MINISTÉRIO/CARGO</th>
                                <th class="text-center">TIPO</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">DESATIVAR</th>
                                <th class="text-center">EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($userspositions)){ ?>
                        <?php foreach ($userspositions as $lista): ?>
                        <tr>
                             <td class="text-center"><a href="cargos/editar/<?=$lista->id?>" data-bs-toggle-tooltip="tooltip" 
                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                            data-bs-title="Clique para editar <?=$lista->position_name?>" role="button" 
                            class="btn btn-outline-warning rounded-circle btn-sm text-center"><i class="bi bi-pencil text-secundary"></i></a></td>
                            <td class="text-center"><?=$lista->position_name;?></td>
                            <td class="text-center"><?=$lista->description;?></td>
                            <td class="text-center"><?=statusBadge($lista->status);?>
                            <td class="text-center"><?=$lista->id;?></td>
                            <td class="text-center"><?=$lista->id;?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
    </div>     
</div>