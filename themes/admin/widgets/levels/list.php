<?php $this->layout("_admin"); ?>

<!-- Breacrumb-->
<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="levels" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">NIVEL</th>
                        <th class="text-center">DESCRITIVO</th>
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