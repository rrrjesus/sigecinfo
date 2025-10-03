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
                            <?= button(["href" => "/painel/cargos", "accesskey" => "s" , "btncolor" => "danger", "title" => "Clique para sair", "custom" => "trash", "name" => "Sair", "icon" => "trash"]); ?>
                        </div>
                    </div>

                    <table id="userspositionsDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                        <thead class="table-danger">
                            <tr>
                                <th class="text-center">CARGO</th>
                                <th class="text-center">DESCRIÇÃO</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">ATIVAR</th>
                                <th class="text-center">EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($userspositions)){ ?>
                        <?php foreach ($userspositions as $lista): ?>
                        <tr>
                            <td class="text-center fw-semibold"><?=(!empty($lista->position_name) ? $lista->position_name : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->description) ? $lista->description : "")?></td>
                            <td class="text-center fw-semibold"><?=statusBadge($lista->status)?></td>
                            <td class="text-center"><?=$lista->id;?></td>
                            <td class="text-center"><?=$lista->id;?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
    </div>     
</div>