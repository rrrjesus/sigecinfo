<?php $this->layout("_app"); ?>

<?= $this->insert("views/theme/breadcrumb"); ?>

<div class="ajax_response"><?= flash(); ?></div>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="<?= url("/app/eventos/editar/{$event->id}"); ?>" class="nav-link link-body-emphasis">Edição</a>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link link-body-emphasis active" id="pills-guests-tab" data-bs-toggle="pill" data-bs-target="#pills-guests" type="button" role="tab" aria-controls="pills-guests" aria-selected="true">Lista de Convidados</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link link-body-emphasis" id="pills-reports-tab" data-bs-toggle="pill" data-bs-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">Relatórios</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link link-body-emphasis" id="pills-attendance-tab" data-bs-toggle="pill" data-bs-target="#pills-attendance" type="button" role="tab" aria-controls="pills-attendance" aria-selected="false">Lista de Presença</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link link-body-emphasis" id="pills-matrix-report-tab" data-bs-toggle="pill" data-bs-target="#pills-matrix-report" type="button" role="tab" aria-controls="pills-matrix-report" aria-selected="false">Relatório por Congregação</button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-guests" role="tabpanel" aria-labelledby="pills-guests-tab">
        <?php if ($event && !empty($participants)): ?>
            <div class="card mb-2">
                <div class="card-header fw-bold"><i class="bi bi-list-check me-1"></i> Lista de Convocados (<?= count($participants); ?>)</div>
                <div class="card-body">
                    <table id="eventParticipants" class="table table-bordered table-sm border-secondary table-hover" style="width:100%">
                        <thead class="table-secondary">
                                <th class="text-center">Checkin</th>
                                <th class="text-center">Foto</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><i class="bi bi-pencil me-2"></i>Alterar</th>
                                <th class="text-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($participants as $participant): ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <?php if ($participant->status === 'presente'): ?>
                                            <?= button([
                                                        "href" => "/app/eventos/checkin/{$participant->id}",
                                                        "name" => "Assinado",
                                                        "icon" => "check-circle-fill me-1",
                                                        "btncolor" => "success",
                                                        "class" => "m-1 p-1"
                                                    ]); ?>
                                                 
                                        <?php else: ?>
                                                    <?= button([
                                                        "href" => "/app/eventos/checkin/{$participant->id}",
                                                        "name" => "Check-in",
                                                        "icon" => "check-circle-fill me-1",
                                                        "btncolor" => "primary",
                                                        "class" => "m-1 p-1"
                                                    ]); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php
                                            $photoPath = $participant->user()->photo;
                                            $defaultAvatar = 'avatar.jpg';
                                            $defaultImageUrl = theme("/assets/images/{$defaultAvatar}", CONF_VIEW_ADMIN);
                                            $thumbUrl = $defaultImageUrl;
                                            $largeImageUrl = $defaultImageUrl;

                                            if ($photoPath) {
                                                $absolutePath = CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$photoPath}";
                                                if (file_exists($absolutePath) && !is_dir($absolutePath)) {
                                                    $thumbUrl = image($photoPath, 30, 30);
                                                    $largeImageUrl = image($photoPath, 600, 600);
                                                }
                                            }
                                        ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal<?= $participant->id ?>">
                                            <img src="<?= $thumbUrl ?>" class="rounded-circle" height="30" width="30" alt="<?= $participant->user()->user_name ?>">
                                        </a>
                                        <?= \Source\Support\Modal::renderImage(
                                            "photoModal{$participant->id}",
                                            $participant->user()->user_name.' - '.$participant->user()->position()->position_name,
                                            $largeImageUrl,
                                            $participant->user()->user_name
                                        ) ?>
                                    </td>
                                    <td class="align-middle"><?= $participant->user()->user_name; ?></td>
                                    <td class="align-middle"><?= $participant->user()->position()->position_name ?? 'N/A'; ?></td>
                                    <td class="text-center">
                                        <?php if ($participant): ?>
                                            
                                            <?php if ($participant->status === 'convocado'): ?>
                                                    <h5><span class="badge text-bg-primary text-white m-1 p-2 fw-semibold">Convocado</span></h5>
                                            <?php elseif ($participant->status === 'confirmado'): ?>
                                                <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Confirmado</span></h5>
                                            <?php elseif ($participant->status === 'recusado'): ?>
                                                <h5><span class="badge text-bg-warning fw-semibold p-2">Falta Justificada</span></h5>
                                                <h6><small class="text-muted fst-italic"><strong>Motivo:</strong> <?= $participant->justification; ?></small></h6>
                                            <?php elseif ($participant->status === 'presente'): ?> 
                                                <h5><span class="badge text-bg-success text-white p-2 fw-semibold">Presente</span></h5>
                                                <?php else: ?>
                                                <h5>< class="badge text-bg-secondary text-white p-2 fw-semibold"><?= ucfirst($participant->status); ?></span></h5>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                     <td class="text-center">
                                            <?php if ($participant && $participant->status !== 'convocado'): ?>
                                                <form class="ajax_off" style="display: inline;" action="<?= url("/app/eventos/alterar-resposta"); ?>" method="post">
                                                    <?= csrf_input(); ?>
                                                    <input type="hidden" name="participant_id" value="<?= $participant->id; ?>">
                                                    <?= button([
                                                        "name" => "",
                                                        "icon" => "pencil",
                                                        "btncolor" => "warning",
                                                        "class" => "rounded-circle text-warning-emphasis",
                                                        "type" => "submit"
                                                    ]); ?>
                                                </form>
                                            <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle"><?= $participant->id; ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Nenhum participante convocado para este evento.</div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
        <?php
        if ($event && !empty($participants)):
            // --- NOVA LÓGICA DE AGRUPAMENTO E CONTAGEM ---
            
            // 1. Filtra e conta os participantes PRESENTES por cargo
            $presentByPosition = [];
            $totalPresent = 0;

            foreach ($participants as $participant) {
                // Apenas considera os participantes com status 'presente'
                if ($participant->status === 'presente') {
                    $positionName = $participant->user()->position()->position_name ?? 'Sem Cargo Definido';
                    
                    if (!isset($presentByPosition[$positionName])) {
                        $presentByPosition[$positionName] = 0;
                    }
                    $presentByPosition[$positionName]++;
                    $totalPresent++;
                }
            }
            ksort($presentByPosition); // Ordena os cargos por ordem alfabética

            ?>

            <div class="text-end mb-3">
                <button id="printReport" class="btn btn-sm btn-secondary"><i class="bi bi-printer me-1"></i> Imprimir Relatório</button>
            </div>

            <div id="reportContent" class="p-3 border bg-white">
                <h2 class="text-center h4" style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">RELATÓRIO GERAL DE COMPARECIMENTO</h2>
                <h3 class="text-center h5 mb-4"><?= mb_strtoupper($event->eventType()->name ?? 'Evento') . ' - ' . mb_strtoupper($event->title) ?></h3>
            
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr style="border-bottom: 2px solid #000;">
                            <th style="border-bottom: 2px solid #000;">Ministério / Encargos</th>
                            <th class="text-center" style="border-bottom: 2px solid #000;">Presentes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($presentByPosition)): ?>
                            <?php foreach ($presentByPosition as $position => $count): ?>
                                <tr>
                                    <td><?= $position; ?></td>
                                    <td class="text-center fw-bold"><?= $count; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">Nenhum participante com presença confirmada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr style="border-top: 2px solid #000;">
                            <td class="text-end text-uppercase">Total Geral</td>
                            <td class="text-center"><?= $totalPresent; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        <?php else: ?>
            <div class="alert alert-info">Nenhum relatório disponível. O evento pode não ter participantes.</div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="pills-attendance" role="tabpanel" aria-labelledby="pills-attendance-tab">
        <?php if ($event && !empty($participants)): ?>

            <div class="text-end mb-3">
                <button id="printAttendanceList" class="btn btn-sm btn-secondary"><i class="bi bi-printer me-1"></i> Imprimir Lista</button>
            </div>

            <div id="attendanceListContent">
                <h2 class="text-center h4" style="text-transform: uppercase;"><?= $event->title ?></h2>
                <h3 class="text-center h6 text-muted mb-4">Lista de Presença - <?= date_fmt($event->start_at, "d/m/Y") ?></h3>

                <div class="row table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Cargo/Ministério</th>
                            <th>Igreja</th>
                            <th style="width: 30%;">Assinatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $participant): ?>
                            <tr>
                                <td><?= $participant->user()->user_name; ?></td>
                                <td><?= $participant->user()->position()->position_name ?? 'N/A'; ?></td>
                                <td><?= $participant->user()->church()->church_name ?? 'N/A'; ?></td>
                                 <td>
                                    <?php if (!empty($participant->signature)): ?>
                                        <img src="<?= url(CONF_UPLOAD_DIR . "/" . $participant->signature) ?>" height="30" width="120">
                                    <?php endif; ?>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-info">Nenhuma lista de presença disponível.</div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="pills-matrix-report" role="tabpanel" aria-labelledby="pills-matrix-report-tab">
        <?php if ($event && !empty($attendanceReport)): ?>
            <div class="text-end mb-3">
                <button id="printMatrixReport" class="btn btn-sm btn-secondary"><i class="bi bi-printer me-1"></i> Imprimir Relatório</button>
            </div>

            <div id="matrixReportContent" class="p-3 border bg-white">
                <p class="text-end mb-0"><?= date_fmt(date("Y-m-d"), "d/m/Y"); ?></p>
                <h2 class="text-center h5" style="text-decoration: underline; font-weight: bold; text-transform: uppercase;">RELATÓRIO DE COMPARECIMENTO POR CASA DE ORAÇÃO</h2>
                <h3 class="text-center h6 mb-4"><?= mb_strtoupper($event->eventType()->name ?? 'Evento') . ' - ' . mb_strtoupper($event->title) ?></h3>

                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
                    <thead class="table-light text-center">
                        <tr>
                            <th rowspan="2" class="align-middle">Casa de Oração</th>
                            <th colspan="<?= count($attendanceReport->headerPositions); ?>">Ministério / Encargos</th>
                            <th rowspan="2" class="align-middle bg-secondary text-white">Total Por Comum</th>
                        </tr>
                        <tr>
                            <?php foreach ($attendanceReport->headerPositions as $position): ?>
                                <th><?= str_replace(' ', '<br>', $position); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendanceReport->matrixData as $churchName => $positions): ?>
                            <tr>
                                <td class="fw-bold"><?= $churchName; ?></td>
                                <?php foreach ($attendanceReport->headerPositions as $positionName): ?>
                                    <td class="text-center"><?= $positions[$positionName] ?? ''; ?></td>
                                <?php endforeach; ?>
                                <td class="text-center fw-bold bg-light"><?= $positions['_row_total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td class="text-end">Total Geral</td>
                            <?php foreach ($attendanceReport->headerPositions as $positionName): ?>
                                <td class="text-center"><?= $attendanceReport->columnTotals[$positionName] ?? 0; ?></td>
                            <?php endforeach; ?>
                            <td class="text-center bg-secondary text-white"><?= $attendanceReport->grandTotal; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Nenhum relatório disponível. Verifique se há participantes com presença confirmada.</div>
        <?php endif; ?>
    </div>
</div>

<?php $activeTab = $_SESSION['tab'] ?? 'guests'; unset($_SESSION['tab']); ?>

<?php $this->start("scripts"); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Captura o parâmetro da URL
        const params = new URLSearchParams(window.location.search);
        const tab = params.get("tab") || '<?= $activeTab ?>';

        if (tab) {
            const tabTrigger = document.querySelector(`#pills-${tab}-tab`);
            if (tabTrigger) {
            const tabInstance = new bootstrap.Tab(tabTrigger);
            tabInstance.show();
            }
        }

        const printButton = document.getElementById('printReport');
        if (printButton) {
            printButton.addEventListener('click', function() {
                const reportContent = document.getElementById('reportContent').innerHTML;
                const eventTitle = "<?= addslashes($event->title ?? 'Relatório de Evento') ?>";
                const printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write('<html><head><title>Relatório - ' + eventTitle + '</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
                printWindow.document.write('<style>body { padding: 20px; font-size: 12px; } .table { font-size: 11px; } h2, h3 { margin-bottom: 1rem; } </style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(reportContent);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();
                
                // Um pequeno atraso para garantir que o CSS é carregado antes de imprimir
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        }

        const printAttendanceButton = document.getElementById('printAttendanceList');
        if (printAttendanceButton) {
            printAttendanceButton.addEventListener('click', function() {
                const attendanceContent = document.getElementById('attendanceListContent').innerHTML;
                const eventTitle = "<?= addslashes($event->title ?? 'Lista de Presença') ?>";
                const printWindow = window.open('', '', 'height=800,width=1000');

                printWindow.document.write('<html><head><title>Lista de Presença - ' + eventTitle + '</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
                printWindow.document.write('<style>body { padding: 20px; font-size: 10pt; } .badge { font-size: 8pt; } </style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(attendanceContent);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();
                
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        }

        const printMatrixButton = document.getElementById('printMatrixReport');

        if (printMatrixButton) {
            printMatrixButton.addEventListener('click', function() {
                const attendanceContent = document.getElementById('matrixReportContent').innerHTML;
                const eventTitle = "<?= addslashes($event->title ?? 'Lista de Presença') ?>";
                const printWindow = window.open('', '', 'height=800,width=1000');

                printWindow.document.write('<html><head><title>Lista de Presença - ' + eventTitle + '</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
                printWindow.document.write('<style>body { padding: 20px; font-size: 10pt; } .badge { font-size: 8pt; } </style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(attendanceContent);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();
                
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        }
    });
</script>
<?php $this->end(); ?>