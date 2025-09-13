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
                data-bs-title="Clique para sair" class="btn btn-outline-danger btn-sm me-3 fw-semibold" href="<?=url("/beta/contatos")?>"
                role="button"><i class="bi bi-arrow-right-circle me-2 mt-1"></i>Sair</a>

        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="unitsDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                <thead class="table-danger">
                    <tr>
                        <th class="text-center">FOTO</th>
                        <th class="text-center">NOME</th>
                        <th class="text-center">DESCRIÇÃO</th>
                        <th class="text-center">TELEFONE</th>
                        <th class="text-center">E-MAIL</th>
                        <th class="text-center">ENDEREÇO</th>
                        <th class="text-center">CEP</th>
                        <th class="text-center">RESPONSAVEL</th>
                        <th class="text-center">TEL RESP</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">DESATIVAR</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($units)){ ?>
                <?php foreach ($units as $lista): ?>
                    <tr>
                        <td class="text-center"><?=$lista->photoListDisabled();?></td>
                        <td class="text-center text-uppercase"><?=$lista->unit_name;?></td>
                        <td class="text-center text-uppercase"><?=$lista->description;?></td>
                        <td class="text-center text-uppercase"><?=$lista->fixed_phone;?></td>
                        <td class="text-center"><?=$lista->email;?></td>
                        <td class="text-center text-uppercase"><?=$lista->adress;?></td>
                        <td class="text-center"><?=$lista->zip;?></td>
                        <td class="text-center text-uppercase"><?=$lista->it_professional;?></td>
                        <td class="text-center"><?=$lista->cell_phone;?></td>
                        <td class="text-center text-uppercase"><?=$lista->statusBadge();?>
                        <td class="text-center"><?=$lista->id;?></td>
                    </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/painel/unidades");} ?>
            </tbody>
        </table>
    </div>     
</div>