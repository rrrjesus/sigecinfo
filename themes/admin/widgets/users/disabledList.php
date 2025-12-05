<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="ajax_response"><?= flash(); ?></div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class=" fw-bold mb-0 text-start"><i class="bi bi-people me-2"></i>Usuários do Sistema Desativados</h6>
                        <div>
                            <?= button(["href" => "/painel/usuarios", "name" => "Voltar", "icon" => "arrow-return-left m-1", "btncolor" => "secondary", "title" => "Voltar para a lista de usuários", "custom" => "custom-tooltip-dark"]); ?>
                        </div>
                </div>
            <div class="card-body">
                <div class="dt-container dt-bootstrap5">
                    <table id="usersDisabled" class="table table-striped table-sm table-hover dt-responsive" style="width:100%">
                        <thead class="table-danger">
                            <tr>
                                <th class="text-center"><i class="bi bi-person-bounding-box me-2"></i> Foto</th>
                                <th class="text-center"><i class="bi bi-person-vcard me-2"></i> Nome</th>
                                <th class="text-center"><i class="bi bi-phone me-2"></i> Celular</th>
                                <th class="text-center"><i class="bi bi-person-badge me-2"></i>Cargo</th>
                                <th class="text-center"><i class="bi bi-bank me-2"></i>Local</th>
                                <th class="text-center"><i class="bi bi-envelope-at me-2"></i>Email</th>
                                <th class="text-center"><i class="bi bi-diagram-3 me-2"></i>Nível</th>
                                <th class="text-center"><i class="bi bi-person-x me-2"></i>Ativar</th>
                                <th class="text-center"><i class="bi bi-trash me-2"></i>Excluir</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-center">
                            <?php if(!empty($users)){ ?>
                                <?php foreach ($users as $lista): ?>
                                    <tr>
                                        <td class="text-center"><?=photoList($lista->photo, 'avatar.jpg');?></td>
                                        <td class="text-center"><?=$lista->user_name;?></td>
                                        <td class="text-center"><?=(!empty($lista->phone_mobile) ? '('.substr($lista->phone_mobile,0,2).')'.substr($lista->phone_mobile,2,9) : "") ;?></td>
                                        <td class="text-center"><?=(!empty($lista->position_id) ? $lista->position()->position_name : "");?></td>
                                        <td class="text-center"><?=(!empty($lista->place_id) ? $lista->place()->place_name : "");?></td>
                                        <td class="text-center"><?=$lista->email;?></td>
                                        <td class="text-center"><h5><span class="badge fw-semibold text-bg-danger text-light p-2 m-3">INATIVO</span></h5></td>
                                        <td class="text-center"><?=$lista->level()->level_name;?></td>
                                        <td class="text-center"><?=$lista->id;?></td>
                                        <td class="text-center"><?=$lista->id;?></td>
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