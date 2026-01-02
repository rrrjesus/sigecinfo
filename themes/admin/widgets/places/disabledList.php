<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white fw-semibold">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-house-door-fill me-2"></i>Locais Desativados</h6>
                    <div>
                        <?= button(["href" => url()."/painel/locais", "title" => "Voltar a Lista de Locais", "custom" => "custom-tooltip-secondary", "name" => "Voltar", "icon" => "arrow-left me-1", "btncolor" => "light"]); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-container dt-bootstrap5">
                        <table id="placesDisabled" class="table table-bordered table-sm border-danger table-hover" style="width:100%">
                            <thead class="table-danger">
                                <tr>
                                    <th><i class="bi bi-person-bounding-box me-2"></i>Foto</th>
                                    <th><i class="bi bi-flag me-2"></i>País</th>
                                    <th><i class="bi bi-hash me-2"></i>Código</th>
                                    <th><i class="bi bi-house-door me-2"></i>Local</th>
                                    <th><i class="bi bi-phone me-2"></i>Telefone</th>
                                    <th><i class="bi bi-geo-alt me-2"></i>Endereço</th>
                                    <th><i class="bi bi-mailbox2 me-2"></i>CEP</th>
                                    <th><i class="bi bi-map me-2"></i>Cidade</th>
                                    <th><i class="bi bi-pin-map me-2"></i>Estado</th>
                                    <th><i class="bi bi-check-circle me-2"></i>Status</th>
                                    <th><i class="bi bi-check-square me-2"></i>Ativar</th>
                                    <th><i class="bi bi-trash me-2"></i>Excluir</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php if(!empty($places)){ ?>
                            <?php foreach ($places as $lista): ?>
                                <tr class="fw-semibold">
                                    <td><?=photoList($lista->photo, 'avatar.jpg');?></td>
                                    <td><?=$lista->country_id;?></td>
                                    <td><?=$lista->code_id;?></td>
                                    <td class="text-uppercase"><?=$lista->place_name;?></td>
                                    <td><?=$lista->phone;?></td>
                                    <td class="text-uppercase"><?=$lista->address;?></td>
                                    <td><?=$lista->zip_code;?></td>
                                    <td class="text-uppercase"><?=$lista->city;?></td>
                                    <td><?=$lista->state;?></td>
                                    <td><?=statusBadge($lista->status);?>
                                    <td><?=$lista->id;?></td>
                                    <td><?=$lista->id;?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php }else{} ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>