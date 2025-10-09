<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-bar-chart-steps me-2"></i>Níveis de Acesso</h6>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="levels" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-hash me-2"></i>Id</th>
                                    <th class="text-center"><i class="bi bi-diagram-3 me-2"></i>Nível</th>
                                    <th class="text-center"><i class="bi bi-card-text me-2"></i>Descritivo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($levels)){ ?>
                            <?php foreach ($levels as $lista): ?>
                                <tr>
                                    <td class="text-center"><?=$lista->id;?></td>
                                    <td class="text-center"><?=$lista->level_name;?></td>
                                    <td class="text-center"><?=$lista->description;?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>