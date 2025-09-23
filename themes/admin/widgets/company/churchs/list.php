<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 ajax_response">
            <?=flash();?>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?=buttonLink("/painel/igrejas/cadastrar", "top", "Clique para cadastrar nova Igreja", "success", "building-add", "Cadastrar", "1", "c")?> 
               <?php 
                    if(!empty($registers->disabled)){ ?>
                        <?=buttonLinkDisabled("/painel/igrejas/desativadas", "top", "Clique para listar as Igrejas desativadas", "secondary", "building-add", "Desativadas", "2", "D", $registers->disabled)?> 
            <?php } ?>
        </div>
       
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="churchs" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">EDITAR</th>
                        <th class="text-center">FOTO</th>
                        <th class="text-center">PAÍS</th>
                        <th class="text-center">CÓDIGO</th>
                        <th class="text-center">IGREJA</th>
                        <th class="text-center">TELEFONE</th>
                        <th class="text-center">ENDEREÇO</th>
                        <th class="text-center">CEP</th>
                        <th class="text-center">CIDADE</th>
                        <th class="text-center">ESTADO</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">DESATIVAR</th>
                        <th class="text-center">EXCLUIR</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($churchs)){ ?>
                <?php foreach ($churchs as $lista): ?>
                    <tr>
                        <td class="text-center"><a href="igrejas/editar/<?=$lista->id?>" data-bs-togglee="tooltip" 
                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                            data-bs-title="Clique para editar <?=$lista->church_name?>" role="button" 
                            class="btn btn-outline-warning rounded-circle btn-sm text-center">
                            <i class="bi bi-pencil text-secundary"></i></a></td>
                        <td class="text-center"><?=photoList($lista->photo, 'avatar-ccb.jpg');?></td>
                        <td class="text-center"><?=$lista->country_id;?></td>
                        <td class="text-center"><?=$lista->code_id;?></td>
                        <td class="text-center text-uppercase"><?=$lista->church_name;?></td>
                        <td class="text-center"><?=$lista->phone;?></td>
                        <td class="text-center text-uppercase"><?=$lista->address;?></td>
                        <td class="text-center"><?=$lista->zip_code;?></td>
                        <td class="text-center text-uppercase"><?=$lista->city;?></td>
                        <td class="text-center"><?=$lista->state;?></td>
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