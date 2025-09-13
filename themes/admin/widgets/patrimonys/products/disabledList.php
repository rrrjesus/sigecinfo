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
                data-bs-title="Clique para sair" class="btn btn-outline-danger btn-sm me-3 fw-semibold" href="<?=url("/painel/patrimonio/produtos")?>"
                role="button"><i class="bi bi-arrow-right-circle me-2 mt-1"></i>Sair</a>

        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="productsDisabled" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">EDITAR</th>
                        <th class="text-center">MARCA</th>
                        <th class="text-center">PRODUTO</th>
                        <th class="text-center">TIPO NS</th>
                        <th class="text-center">ACESSORIOS</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">ATIVAR</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($products)){ ?>
                <?php foreach ($products as $lista): ?>
                <tr>
                    <td class="text-center fw-semibold"><a href="<?= url("/painel/patrimonio/produtos/editar/{$lista->id}"); ?>" role="button" aria-disabled="true" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                    data-bs-title="Clique para editar" class="btn btn-sm btn-outline-warning rounded-circle fw-bold me-2"><i class="bi bi-pencil text-secondary"></i></a></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->brand_id) ? $lista->Brand()->brand_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->product_name) ? $lista->product_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->type_part_number) ? $lista->type_part_number : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->acessories) ? $lista->acessories : "")?></td>
                    <td class="text-center fw-semibold"><?=$lista->statusBadge()?></td>
                    <td class="text-center fw-semibold"><?=$lista->id?></td>
                </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/painel/patrimonio/produtos");} ?>
            </tbody>
        </table>
    </div>     
</div>