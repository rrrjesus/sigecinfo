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
            <?=buttonLink("/painel/usuarios/cadastrar", "top", "Clique para cadastrar novo usuário", "success", "building-add", "Cadastrar", "1", "c")?> 
               <?php 
                    if(!empty($registers->disabled)){ ?>
                        <?=buttonLinkDisabled("/painel/usuarios/desativados", "top", "Clique para listar os usuários desativados", "secondary", "building-add", "Desativados", "2", "D", $registers->disabled)?> 
            <?php } ?>
        </div>
    </div>
    

    <div class="dt-container dt-bootstrap5">
        <div class="col-12">
            <table id="users" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                <thead class="table-secondary">
                <tr>
                    <th class="text-center"><i class="bi bi-unlock me-1"></i><br>ID</th>
                    <th class="text-center"><i class="bi bi-person-gear me-1"></i><br>GERENCIAR</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>FOTO</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>CEL</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>MINISTERIO/CARGO</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>IGREJA</th>
                    <th class="text-center"><i class="bi bi-envelope-at me-1"></i><br>EMAIL</th>
                    <th class="text-center"><i class="bi bi-envelope-at me-1"></i><br>STATUS</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NIVEL</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>DESATIVAR</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($users)){ ?>
                <?php foreach ($users as $lista): ?>
                    <tr>
                        <td class="text-center"><?=$lista->id?></td>
                        <td class="text-center"><a href="usuarios/editar/<?=$lista->id?>" data-bs-toggle="tooltip" 
                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                            data-bs-title="Clique para editar <?=$lista->user_name?>" role="button" 
                            class="btn btn-outline-secondary rounded-circle btn-sm text-center">
                            <i class="bi bi-person-gear text-dark"></i></a></td>
                        <td class="text-center"><?=photoList($lista->photo);?></td>
                        <td class="text-center text-uppercase"><?=$lista->user_name;?></td>
                        <td class="text-center text-uppercase"><?=(!empty($lista->phone_mobile) ? '('.substr($lista->phone_mobile,0,2).')'.substr($lista->phone_mobile,2,9) : "") ;?></td>
                        <td class="text-center"><?=$lista->userPosition()->position_name;?></td>
                        <td class="text-center"><?=$lista->userChurch()->church_name;?></td>
                        <td class="text-center"><?=$lista->email;?></td>
                        <td class="text-center"><?=statusSpan($lista->status);?></td>
                        <td class="text-center text-uppercase"><?=$lista->level()->level_name;?></td>
                        <td class="text-center"><?=$lista->id;?></td>
                    </tr>
                <?php endforeach; ?>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
