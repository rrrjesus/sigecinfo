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
            <a data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                data-bs-title="Clique para cadastrar novo colaborador" class="btn btn-outline-danger btn-sm me-3 fw-semibold" href="<?=url("/painel/usuarios")?>"
                role="button"><i class="bi bi-arrow-right-circle me-2 mt-1"></i>Sair</a>

        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="usersDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                <thead class="table-danger">
                <tr>
                <th class="text-center"><i class="bi bi-unlock me-1"></i><br>ID</th>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>FOTO</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>RF</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>CARGO</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>UNIDADE</th>
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
                        <td class="text-center"><?=$lista->photoListDisabled();?></td>
                        <td class="text-center"><?=$lista->rf;?></td>
                        <td class="text-center text-uppercase"><?=$lista->user_name;?></td>
                        <td class="text-center"><?=$lista->userPosition()->position_name;?></td>
                        <td class="text-center"><?=$lista->userUnit()->unit_name;?></td>
                        <td class="text-center"><?=$lista->email;?></td>
                        <td class="text-center"><?=$lista->statusSpan();?></td>
                        <td class="text-center text-uppercase"><?=$lista->level()->level_nome;?>
                        <td class="text-center"><?=$lista->id;?></td>
                    </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/painel/usuarios");} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
