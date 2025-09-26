
<?= $this->layout("_theme", ["head" => $head]); ?>

<style>
    .page-link {color: var(--bs-<?=color_month();?>);}
    .pagination {--bs-link-hover-color: var(--bs-<?=color_month();?>);}
    .page-item.active .page-link {color: #ffffff;background-color: var(--bs-<?=color_month();?>);border-color: var(--bs-<?=color_month();?>);}
</style>

<table id="contact" class="table table-hover table-bordered table-sm border-<?=color_month()?> p-2" style="width:100%">
    <thead class="table-<?=color_month()?>">
    <tr>
        <th class="text-center">NOME</th>
        <th class="text-center">SETOR</th>
        <th class="text-center">RAMAL</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($contact as $lista): ?>
    <tr>
        <td class="text-center fw-semibold" data-bs-toggle-tooltip="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
            data-bs-title="O ramal <?=$lista->ramal." é de ".$lista->contact_name.' '.(!empty($lista->church()->church_name) ? $lista->church()->church_name : "NÃO CADASTRADO")?>"><?=(!empty($lista->contact_name) ? $lista->contact_name : "")?></td>
        <td class="text-center fw-semibold">
        <?php if(!empty($lista->church()->church_name) && !empty($lista->church()->status == "actived")):
            echo (!empty($lista->church()->church_name) ? $lista->church()->church_name : "NÃO CADASTRADO");
        else:
            echo "EXCLUÍDO";
        endif;
            ?>
            </td>
            <td class="text-center fw-semibold"><?=(!empty($lista->ramal )? $lista->ramal : "")?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
