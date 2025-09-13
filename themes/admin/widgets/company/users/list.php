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
                data-bs-title="Clique para cadastrar novo colaborador" class="btn btn-outline-success btn-sm me-3 fw-semibold" href="<?=url("/painel/usuarios/cadastrar")?>"
                role="button"><i class="bi bi-telephone-plus me-2 mt-1"></i>Cadastrar</a>
            <?php if(!empty($registers->disabled)){ ?>
                <a role="button" href="<?=url("/painel/usuarios/desativados")?>" data-bs-togglee="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                    data-bs-title="Clique para acessar usuarios desativados" class="btn btn-outline-secondary btn-sm position-relative fw-semibold"><i class="bi bi-telephone-x text-danger me-2 mt-1">
                    </i> Desativados<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?=$registers->disabled?></span></a>
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
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>RF</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>CEL</th>
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
                        <td class="text-center"><a href="usuarios/editar/<?=$lista->id?>" data-bs-togglee="tooltip" 
                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>" 
                            data-bs-title="Clique para editar <?=$lista->user_name?>" role="button" 
                            class="btn btn-outline-secondary rounded-circle btn-sm text-center">
                            <i class="bi bi-person-gear text-dark"></i></a></td>
                        <td class="text-center"><?=$lista->photoList();?></td>
                        <td class="text-center"><?=$lista->rf;?></td>
                        <td class="text-center text-uppercase"><?=$lista->user_name;?></td>
                        <td class="text-center text-uppercase"><?=(!empty($lista->cell_phone) ? '('.substr($lista->cell_phone,0,2).')'.substr($lista->cell_phone,2,9) : "") ;?></td>
                        <td class="text-center"><?=$lista->userPosition()->position_name;?></td>
                        <td class="text-center"><?=$lista->userUnit()->unit_name;?></td>
                        <td class="text-center"><?=$lista->email;?></td>
                        <td class="text-center"><?=$lista->statusSpan();?></td>
                        <td class="text-center text-uppercase"><?=$lista->level()->level_nome;?>
                        <td class="text-center"><?=$lista->id;?></td>
                    </tr>
                <?php endforeach; ?>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
