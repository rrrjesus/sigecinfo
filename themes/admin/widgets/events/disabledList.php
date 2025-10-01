<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?= button(["href" => "/painel/eventos", "name" => "Voltar para Eventos", "icon" => "calendar", "btncolor" => "secondary"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="disabledEvents" class="table table-bordered table-sm table-hover" style="width:100%">
                <thead class="table-danger">
                    <tr>
                        <th class="text-center">Capa</th>
                        <th class="text-center">Título do Evento</th>
                        <th class="text-center">Data de Início</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ativar</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
    </div>
</div>