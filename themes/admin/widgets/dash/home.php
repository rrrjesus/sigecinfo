<?php $this->layout("_admin"); ?>

<div class="container-fluid">
    <div class="col-12 ml-auto mt-3">
        <nav aria-label="breadcrumb">
             <ol class="breadcrumb breadcrumb-chevron p-2 bg-body-tertiary rounded-3">
                <li class="breadcrumb-item fw-semibold active" aria-current="page"><i class="bi bi-house-door"></i> Monitoramento</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card mb-4 border-<?=CONF_ADMIN_COLOR?>">
                <div class="card-body">
                    <div class="fw-semibold text-uppercase mb-3 fs-5 text-center"><i class="bi bi-bar-chart-line-fill"></i> SECRETARIA</div>
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/igrejas'); ?>" class="link-dark">Igrejas</a></div>
                                            <div class="h6 mb-1">Ativas: <?= $churchs->actived; ?></div>
                                            <div class="h6 mb-1">Desativadas: <?= $churchs->disabled; ?></div>
                                            <div class="h6 mb-0">Total: <?= $churchs->total; ?></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-building fs-1 text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                 <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/cargos'); ?>" class="link-dark">Cargos</a></div>
                                            <div class="h6 mb-1">Ativos: <?= $userspositions->actived; ?></div>
                                            <div class="h6 mb-1">Desativados: <?= $userspositions->disabled; ?></div>
                                            <div class="h6 mb-0">Total: <?= $userspositions->total; ?></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-diagram-3 fs-1 text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/usuarios'); ?>" class="link-dark">Utilizadores</a></div>
                                            <div class="h6 mb-1">Utilizadores: <?= $users->users; ?></div>
                                            <div class="h6 mb-1">Admins: <?= $users->admins; ?></div>
                                            <div class="h6 mb-0">Total: <?= $users->total; ?></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-people fs-1 text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    

    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card mb-4 border-<?=CONF_ADMIN_COLOR?>">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="fw-semibold text-uppercase mb-3 fs-5"><i class="bi bi-bar-chart-line-fill"></i> Online agora : 
                            <span class="trafic_count"><?= $onlineCount; ?></span>
                        </div>
                        <div class="row">
                            <!-- Usuários Totais da Agenda --> 
                            <div class="col-xl-12 col-12 mb-12">
                                <div class="app_dash_home_trafic_list">
                                    <?php if (!$online): ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="bi bi-info-circle-fill p-2"></i>
                                                <strong>Não existem usuários online navegando no site neste momento. Quando tiver, você
                                                poderá monitoriar todos por aqui.</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php else: ?>
                                        <table id="online" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                                            <thead class="table-secondary">    
                                                <tr>
                                                    <th class="text-center"><i class="bi bi-emoji-grin me-1"></i><br>DATA/USUARIO</th>
                                                    <th class="text-center"><i class="bi bi-clipboard-check me-1"></i><br>QTD PÁGINAS</th>
                                                    <th class="text-center"><i class="bi bi-binoculars me-1"></i><br>ÚLTIMO ACESSO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($online as $onlineNow): ?>
                                                <tr>
                                                    <td class="text-center"><?= date_fmt($onlineNow->created_at, "H\hm"); ?> - <?= date_fmt($onlineNow->updated_at, "H\hm"); ?> 
                                                        <?= ($onlineNow->user ? $onlineNow->user()->user_name : "Usuário Convidado"); ?></td>
                                                    <td class="text-center"><?= $onlineNow->pages; ?> páginas vistas</td>
                                                    <td class="text-center"><a target="_blank" href="<?= url("/{$onlineNow->url}"); ?>"><b>
                                                        <?= strtolower(CONF_SITE_NAME); ?></b><?= $onlineNow->url; ?></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->start("scripts"); ?>
    <script>
        $(function () {
            // Inicializa a tabela 'online' como um objeto DataTable uma vez
            var onlineTable = $('#online').DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registo encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registos",
                    "sInfoFiltered": "(Filtrados de _MAX_ registos)",
                    "sLengthMenu": "_MENU_ Resultados por Página",
                    "sSearch": "Pesquisar",
                    "oPaginate": { "sNext": "Próximo", "sPrevious": "Anterior" }
                },
                "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
                "aaSorting": [2, 'desc'] // Ordenar pela coluna "ÚLTIMO ACESSO"
            });

            setInterval(function () {
                $.post('<?= url("/painel/controle/inicial");?>', {refresh: true}, function (response) {
                    // Atualiza a contagem
                    if (response.count) {
                        $(".trafic_count").text(response.count);
                    } else {
                        $(".trafic_count").text(0);
                    }

                    // --- LÓGICA DE ATUALIZAÇÃO DA TABELA CORRIGIDA ---

                    // 1. Limpa os dados existentes na tabela
                    onlineTable.clear();

                    // 2. Adiciona as novas linhas, se existirem
                    if (response.list && response.list.length > 0) {
                        var newRows = [];
                        $.each(response.list, function (item, data) {
                            var url = '<?= url();?>' + data.url;
                            var title = '<?= strtolower(CONF_SITE_NAME);?>';
                            var link = "<a target='_blank' href='" + url + "'><b>" + title + "</b>" + data.url + "</a>";
                            
                            newRows.push([
                                data.dates + " " + data.user,
                                data.pages + " páginas vistas",
                                link
                            ]);
                        });
                        onlineTable.rows.add(newRows);
                    }

                    // 3. Redesenha a tabela com os novos dados
                    onlineTable.draw();

                }, "json");
            }, 1000 * 10); // 10 segundos
        });
    </script>
<?php $this->end(); ?>