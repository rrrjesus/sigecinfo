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
            <?= button(["href" => "/painel/usuarios", "btncolor" => "danger", "accesskey" => "s" ,"title" => "Clique para sair", "custom" => "trash", "name" => "Sair", "icon" => "trash"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="usersDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                <thead class="table-danger">
                <tr>
                    <th class="text-center"><i class="bi bi-person-circle me-1"></i><br>FOTO</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NOME</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>CEL</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>MINISTERIO/CARGO</th>
                    <th class="text-center"><i class="bi bi-building me-1"></i><br>IGREJA</th>
                    <th class="text-center"><i class="bi bi-envelope-at me-1"></i><br>EMAIL</th>
                    <th class="text-center"><i class="bi bi-envelope-at me-1"></i><br>STATUS</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>NIVEL</th>
                    <th class="text-center"><i class="bi bi-person me-1"></i><br>ATIVAR</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($users)){ ?>
                <?php foreach ($users as $lista): ?>
                    <tr>
                        <td class="text-center"><?=photoList($lista->photo, 'avatar.jpg');?></td>
                        <td class="text-center text-uppercase"><?=$lista->user_name;?></td>
                        <td class="text-center text-uppercase"><?=(!empty($lista->phone_mobile) ? '('.substr($lista->phone_mobile,0,2).')'.substr($lista->phone_mobile,2,9) : "") ;?></td>
                        <td class="text-center"><?=(!empty($lista->position_id) ? $lista->position()->position_name : "");?></td>
                        <td class="text-center"><?=(!empty($lista->church_id) ? $lista->church()->church_name : "");?></td>
                        <td class="text-center"><?=$lista->email;?></td>
                        <td class="text-center"><?=statusSpan($lista->status);?></td>
                        <td class="text-center text-uppercase"><?=$lista->level()->level_name;?></td>
                        <td class="text-center"><?=$lista->id;?></td>
                    </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/painel/usuarios");} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
