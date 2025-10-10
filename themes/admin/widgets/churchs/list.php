<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-house-door me-2"></i>Igrejas</h6>
                    <div>
                        <?= button(["href" => "/painel/igrejas/cadastrar", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/igrejas/desativadas", "name" => "Desativadas", "btncolor" => "secondary", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="churchs" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Editar</th>
                                    <th class="text-center"><i class="bi bi-person-bounding-box me-2"></i>Foto</th>
                                    <th class="text-center"><i class="bi bi-flag me-2"></i>País</th>
                                    <th class="text-center"><i class="bi bi-hash me-2"></i>Código</th>
                                    <th class="text-center"><i class="bi bi-house-door me-2"></i>Igreja</th>
                                    <th class="text-center"><i class="bi bi-phone me-2"></i>Telefone</th>
                                    <th class="text-center"><i class="bi bi-geo-alt me-2"></i>Endereço</th>
                                    <th class="text-center"><i class="bi bi-mailbox2 me-2"></i>CEP</th>
                                    <th class="text-center"><i class="bi bi-map me-2"></i>Cidade</th>
                                    <th class="text-center"><i class="bi bi-pin-map me-2"></i>Estado</th>
                                    <th class="text-center"><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-person-x me-2"></i>Desativar</th>
                                    <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($churchs)){ ?>
                            <?php foreach ($churchs as $lista): ?>
                                <tr>
                                    <td class="text-center"><a href="igrejas/editar/<?=$lista->id?>" data-bs-toggle-tooltip="tooltip" 
                                        data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                        data-bs-title="Clique para editar <?=$lista->church_name?>" role="button" 
                                        class="btn btn-outline-warning rounded-circle btn-sm text-center">
                                        <i class="bi bi-pencil text-secundary"></i></a></td>
                                    <td class="text-center"><?=photoList($lista->photo, 'avatar-ccb.jpg');?></td>
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
                            <?php } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>