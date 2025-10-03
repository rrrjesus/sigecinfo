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
            <?= button(["href" => "/painel/igrejas", "accesskey" => "s" , "btncolor" => "danger", "title" => "Clique para sair", "custom" => "trash", "name" => "Sair", "icon" => "trash"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="churchsDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                <thead class="table-danger">
                    <tr>
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
                        <th class="text-center">ATIVAR</th>
                        <th class="text-center">EXCLUIR</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($churchs)){ ?>
                <?php foreach ($churchs as $lista): ?>
                    <tr>
                        <td class="text-center"><?=photoList($lista->photo, 'avatar.jpg');?></td>
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
                <?php }else{} ?>
            </tbody>
        </table>
    </div>     
</div>