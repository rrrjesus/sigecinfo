<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">
            <div class="ajax_response"><?= flash(); ?></div>
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="bi bi-briefcase me-1"></i> <?= ($userposition ? "Editar Cargo" : "Cadastrar Cargo"); ?>
                </div>
                <form class="needs-validation" id="userposition" novalidate action="<?= url($userposition ? "/painel/cargos/editar/{$userposition->id}" : "/painel/cargos/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="action" value="<?= ($userposition ? "update" : "create"); ?>" />
                        <?= csrf_input(); ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <label class="col-form-label col-form-label-sm" for="position_name"><strong>Nome do Cargo</strong></label>
                                <input type="text" id="position_name" class="form-control form-control-sm" name="position_name" placeholder="Ex: Diácono, Músico, etc." value="<?= $userposition->position_name ?? ''; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="col-form-label col-form-label-sm" for="description"><strong>Tipo</strong> (Opcional)</label>
                                <select id="description" class="form-select form-select-sm" name="description">
                                    <?php
                                    $types = ["Brigada", "Administração", "Ministério", "Voluntário", "Cargo"];
                                    $currentType = $userposition->description ?? null;
                                    
                                    // Garante que o valor atual esteja na lista para ser selecionado
                                    if ($currentType && !in_array($currentType, $types)) {
                                        echo "<option value=\"{$currentType}\" selected>{$currentType}</option>";
                                    }
                                    
                                    echo '<option value="">Selecione um tipo...</option>';
                                    
                                    foreach ($types as $type) {
                                        $selected = ($currentType === $type) ? 'selected' : '';
                                        echo "<option value=\"{$type}\" {$selected}>{$type}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <?= button(["type" => "submit", "name" => ($userposition ? "Atualizar" : "Cadastrar"), "icon" => ($userposition ? "check-circle" : "plus-circle"), "btncolor" => ($userposition ? "primary" : "success")]); ?>
                        <?= button(["href" => url()."/painel/cargos", "name" => "Listar", "icon" => "list", "btncolor" => "secondary"]); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>