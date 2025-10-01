<?php $this->layout("_admin"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 ajax_response">
            <?= flash(); ?>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 ml-auto text-center">
            <?= button(["href" => "/painel/eventos/cadastrar", "name" => "Registar Novo Evento", "icon" => "calendar-plus"]); ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-12">
            <table id="events" class="table table-bordered table-sm table-hover" style="width:100%">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">Capa</th>
                        <th class="text-center">Título do Evento</th>
                        <th class="text-center">Data de Início</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Local</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    </tbody>
            </table>
        </div>
    </div>
</div>