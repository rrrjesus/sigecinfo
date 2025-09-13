<?php $this->layout("_beta"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

                <?php $this->start("scripts"); ?>
                    <style>
                        /* Datatables Pagination */
                        .page-link {color: var(--bs-danger)}
                        .pagination {--bs-link-hover-color: #a11010;}
                        .active>.page-link, .page-link.active {background-color: var(--bs-danger);border-color: var(--bs-danger);}
                    </style>
                <?php $this->end(); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="d-flex justify-content-center mb-3">
                <div class="col-12">

                    <div class="row justify-content-center mt-4 mb-3">
                        <div class="col-auto">
                    <?=buttonLink("/beta/patrimonios", "top", "Clique para sair", "danger", "arrow-right-circle", "Sair")?> 
                    </div>
                </div>
            
                <?=flash();?>

                <table id="disabledPatrimony" class="table table-hover table-bordered table-sm border-danger p-2" style="width:100%">
                    <thead class="table-danger">
                        <tr>
                            <th class="text-center">ENTRADA</th>
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">TIPO PN</th>
                            <th class="text-center">PARTNUMBER</th>
                            <th class="text-center">MARCA</th>
                            <th class="text-center">MODELO</th>
                            <th class="text-center">NOME</th>
                            <th class="text-center">LOGIN</th>
                            <th class="text-center">RF</th>
                            <th class="text-center">EMAIL</th>
                            <th class="text-center">UNIDADE</th>
                            <th class="text-center">OBSERVAÇÕES</th>
                            <th class="text-center">ATIVAR</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>   


