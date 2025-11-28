<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-house-door me-2"></i>Locais Ativos</h6>
                    <div>
                        <?= button(["href" => "/painel/locais/cadastrar", "title" => "Cadastrar um novo local", "custom" => "custom-tooltip-dark", "btncolor" => "primary", "name" => "Cadastrar", "icon" => "plus-circle"]); ?>
                        <?php if (!empty($registers->disabled)) : ?>
                            <?= button(["href" => "/painel/locais/desativados", "title" => "Locais Desativados", "custom" => "custom-tooltip-dark", "name" => "Desativados", "btncolor" => "light", "disabled_count" => $registers->disabled]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="places" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center"><i class="bi bi-pencil-square me-2"></i>Editar</th>
                                    <th class="text-center"><i class="bi bi-person-bounding-box me-2"></i>Foto</th>
                                    <th class="text-center"><i class="bi bi-flag me-2"></i>País</th>
                                    <th class="text-center"><i class="bi bi-hash me-2"></i>Código</th>
                                    <th class="text-center"><i class="bi bi-house-door me-2"></i>Local</th>
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
                            <tbody class="text-center">
                                <?php if(!empty($places)){ ?>
                                <?php foreach ($places as $lista): ?>
                                    <tr class="fw-semibold">
                                        <td><a href="<?= url("/painel/locais/editar/{$lista->id}") ?>" data-bs-toggle-tooltip="tooltip" 
                                            data-bs-placement="top" data-bs-custom-class="custom-tooltip-dark" 
                                            data-bs-title="Clique para editar <?=$lista->place_name?>" role="button" 
                                            class="btn btn-outline-warning rounded-circle btn-sm">
                                            <i class="bi bi-pencil text-secondary"></i></a></td>
                                        <td><?=photoList($lista->photo, 'avatar-ccb.jpg');?></td>
                                        <td><?=$lista->country_id;?></td>
                                        <td><?=$lista->code_id;?></td>
                                        <td class="text-uppercase"><?= $lista->place_name; ?></td>
                                        <td><?=$lista->phone;?></td>
                                        <td class="text-uppercase"><?= $lista->address; ?></td>
                                        <td><?=$lista->zip_code;?></td>
                                        <td class="text-uppercase"><?= $lista->city; ?></td>
                                        <td><?=$lista->state;?></td>
                                        <td><?=statusBadge($lista->status);?></td>
                                        <td><?=$lista->id;?></td>
                                        <td><?=$lista->id;?></td>
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