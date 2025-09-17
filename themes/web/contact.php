
<?= $this->layout("_theme", ["head" => $head]); ?>

  <!-- Navbar-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<div class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <p class="fs-2 fw-normal text-body-emphasis pb-0"><i class="bi bi-book-half text-<?=color_month()?>"></i> Agenda Inteligente SIGECINFO</p>
    <p class="fs-6 text-body-secondary pt-0">Na barra <strong>Pesquisar</strong> cada espaço aplicado interliga as palavras digitadas para a pesquisa inteligente</p>
</div>

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
        <td class="text-center fw-semibold" data-bs-togglee="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip-<?=color_month()?>"
            data-bs-title="O ramal <?=$lista->ramal." é de ".$lista->contact_name.' '.(!empty($lista->church()->unit_name) ? $lista->church()->unit_name : "NÃO CADASTRADO")?>"><?=(!empty($lista->contact_name) ? $lista->contact_name : "")?></td>
        <td class="text-center fw-semibold">
        <?php if(!empty($lista->church()->unit_name) && !empty($lista->church()->status == "actived")):
            echo (!empty($lista->church()->unit_name) ? $lista->church()->unit_name : "NÃO CADASTRADO");
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
