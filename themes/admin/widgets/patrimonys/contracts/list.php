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
                data-bs-title="Clique para cadastrar novo contrato" class="btn btn-outline-success btn-sm me-3 fw-semibold" href="<?=url("/painel/patrimonio/contratos/cadastrar")?>"
                role="button"><i class="bi bi-telephone-plus me-2 mt-1"></i>Cadastrar</a>
                <?php if(!empty($registers->disabled)){ ?>
                <a role="button" href="<?=url("/painel/patrimonio/contratos/desativados")?>" data-bs-togglee="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                    data-bs-title="Clique para acessar contratos desativados" class="btn btn-outline-secondary btn-sm position-relative fw-semibold"><i class="bi bi-telephone-x text-danger me-2 mt-1">
                    </i> Desativados<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?=$registers->disabled?></span></a>
            <?php } ?>
        </div>
       
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="contracts" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">EDITAR</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">PROCESSO SEI</th>
                        <th class="text-center">CONTRATO</th>
                        <th class="text-center">RESPONSÁVEL</th>
                        <th class="text-center">FISCAL</th>
                        <th class="text-center">SUPLENTE</th>
                        <th class="text-center">DESCRICAO</th>
                        <th class="text-center">OBSERVAÇÃO</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">DESATIVAR</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($contracts)){ ?>
                <?php foreach ($contracts as $lista): ?>
                <tr>
                    <td class="text-center fw-semibold"><a href="<?= url("/painel/patrimonio/contratos/editar/{$lista->id}"); ?>" role="button" aria-disabled="true" data-bs-togglee="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
                    data-bs-title="Clique para editar" class="btn btn-sm btn-outline-warning rounded-circle fw-bold me-2"><i class="bi bi-pencil text-secondary"></i></a></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->id) ? $lista->id : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->sei_process) ? $lista->sei_process : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->contract_name) ? $lista->contract_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->manager_id) ? $lista->userManager()->user_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->inspector_id) ? $lista->userInspector()->user_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->deputy_inspector_id) ? $lista->userDeputyInspector()->user_name : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->description) ? $lista->description : "")?></td>
                    <td class="text-center fw-semibold"><?=(!empty($lista->observations) ? $lista->observations : "")?></td>
                    <td class="text-center fw-semibold"><?=$lista->statusBadge()?></td>
                    <td class="text-center fw-semibold"><?=$lista->id?></td>
                </tr>
                <?php endforeach; ?>
                <?php }else{redirect("/painel/patrimonio/contratos");} ?>
            </tbody>
        </table>
    </div>     
</div>