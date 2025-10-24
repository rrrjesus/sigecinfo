<?php $this->layout("_admin"); ?>

<div class="container-fluid">
    <div class="col-12 ml-auto mt-3"> <!-- https://getbootstrap.com/docs/4.0/layout/grid/#mix-and-match -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-chevron p-2 bg-body-tertiary rounded-3">
                <li class="breadcrumb-item fw-semibold active" aria-current="page"><i class="bi bi-house-door"></i> Monitoramento</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <!-- Card de Estatísticas -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-tertiary"><i class="bi bi-bar-chart-line-fill"></i> Estatísticas da Secretaria</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-success text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/igrejas'); ?>" class="text-white text-decoration-none">Igrejas</a></div>
                                            <div class="h6 mb-1">Ativas: <span class="badge bg-light text-dark"><?= $churchs->actived; ?></span></div>
                                            <div class="h6 mb-1">Desativadas: <span class="badge bg-light text-dark"><?= $churchs->disabled; ?></span></div>
                                            <div class="h6 mb-0">Total: <span class="badge bg-light text-dark"><?= $churchs->total; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-bank2 fs-1 opacity-50"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-warning text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5">
                                                <a href="<?= url('/painel/cargos'); ?>" class="text-white text-decoration-none">Cargos</a>
                                            </div>
                                            <div class="h6 mb-1">Ativos: <span class="badge bg-light text-dark"><?= $userspositions->actived; ?></span></div>
                                            <div class="h6 mb-1">Desativados: <span class="badge bg-light text-dark"><?= $userspositions->disabled; ?></span></div>
                                            <div class="h6 mb-0">Total: <span class="badge bg-light text-dark"><?= $userspositions->total; ?></span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-briefcase-fill fs-1 opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-primary text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/usuarios'); ?>" class="text-white text-decoration-none">Utilizadores</a></div>
                                            <div class="h6 mb-1">Utilizadores: <span class="badge bg-light text-dark"><?= $users->users; ?></span></div>
                                            <div class="h6 mb-1">Admins: <span class="badge bg-light text-dark"><?= $users->admins; ?></span></div>
                                            <div class="h6 mb-0">Total: <span class="badge bg-light text-dark"><?= $users->total; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-people fs-1 opacity-50"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Events Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-info text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-semibold text-uppercase mb-1 fs-5"><a href="<?= url('/painel/eventos'); ?>" class="text-white text-decoration-none">Eventos</a></div>
                                            <div class="h6 mb-1">Próximos: <span class="badge bg-light text-dark"><?= $events->upcoming; ?></span></div>
                                            <div class="h6 mb-1">Realizados: <span class="badge bg-light text-dark"><?= $events->past; ?></span></div>
                                            <div class="h6 mb-0">Total: <span class="badge bg-light text-dark"><?= $events->total; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="bi bi-calendar-event fs-1 opacity-50"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Usuários Online -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-tertiary"><i class="bi bi-broadcast"></i> Online Agora</h6>
                    <span class="badge bg-primary rounded-pill trafic_count"><?= $onlineCount; ?></span>
                </div>
                <div class="card-body">
                    <div class="row table-responsive">
                        <table id="online" class="table table-bordered table-sm border-secondary table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center"><i class="bi bi-person-fill"></i> Usuário</th>
                                    <th class="text-center"><i class="bi bi-file-earmark-text-fill"></i> Páginas Vistas</th>
                                    <th class="text-center"><i class="bi bi-clock-history"></i> Último Acesso</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($online): ?>
                                <?php foreach ($online as $onlineNow): ?>
                                <tr>
                                    <td class="text-center"><?= ($onlineNow->user ? $onlineNow->user()->user_name : "Visitante"); ?></td>
                                    <td class="text-center"><?= $onlineNow->pages; ?></td>
                                    <td class="text-center"><a target="_blank" href="<?= url("/{$onlineNow->url}"); ?>"><b>
                                        <?= strtolower(CONF_SITE_NAME); ?></b><?= $onlineNow->url; ?></a>
                                        <br><small>(<?= date_fmt($onlineNow->updated_at, "H:i:s"); ?>)</small>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </div>

<?php $this->start("scripts"); ?>
    <script>
        $(function () {
            var onlineTable = $('#online').DataTable({
                "language": {
                    "sEmptyTable": "Nenhum usuário online no momento.",
                    "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sLengthMenu": "_MENU_ Resultados por Página",
                    "sSearch": "Pesquisar",
                    "oPaginate": { "sNext": "Próximo", "sPrevious": "Anterior" }
                },
                "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
                "order": [[ 2, 'desc' ]]
            });

            setInterval(function () {
                $.post('<?= url("/painel/controle/inicial");?>', {refresh: true}, function (response) {
                    // Atualiza a contagem
                    if (response.count) {
                        $(".trafic_count").text(response.count);
                    } else {
                        $(".trafic_count").text(0);
                    }

                    onlineTable.clear();

                    if (response.list && response.list.length > 0) {
                        var newRows = [];
                        $.each(response.list, function (item, data) {
                        var absoluteUrl = '<?= url();?>' + data.url;
                        var cleanUrl = data.url; // A URL já vem limpa do PHP
                        
                        var link = "<a target='_blank' href='" + absoluteUrl + "'><b><?= strtolower(CONF_SITE_NAME);?></b>" + cleanUrl + "</a>" +
                                    "<br><small>(" + data.time + ")</small>";
                            
                            newRows.push([
                                data.user,
                                data.pages + " páginas vistas",
                                link
                            ]);
                        });
                        onlineTable.rows.add(newRows);
                    }

                    onlineTable.draw(false);

                }, "json");
            }, 1000 * 10); // 10 segundos
        });
    </script>
<?php $this->end(); ?>