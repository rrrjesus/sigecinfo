$(document).ready(function() {

    /**
     * ===================================================================
     * FUNÇÃO HELPER PARA CONFIGURAÇÃO PADRÃO DO DATATABLES
     * ===================================================================
     */
    function getDefaultDataTablesConfig(tableName, isServerSide = true) {
        let config = {
            destroy: true,
            drawCallback: drawCallbackWithModals, // Callback padrão para os modais
            buttons: [
                { extend: 'excel', title: tableName, header: tableName, filename: tableName, className: 'btn btn-outline-success btn-sm mb-2', text: '<i class="bi bi-file-earmark-excel"></i>' },
                { extend: 'print', exportOptions: { columns: ':visible' }, title: tableName, header: tableName, filename: tableName, orientation: 'portrait', className: 'btn btn-outline-secondary btn-sm mb-2', text: '<i class="bi bi-printer"></i>' },
                { extend: 'colvis', titleAttr: 'Select Colunas', className: 'btn btn-outline-info btn-sm mb-2', text: '<i class="bi bi-list"></i>' }
            ],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
                   "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
                   "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (data[0] || '') + ' - ' + (data[1] || '') + ' - ' + (data[2] || '');
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({})
                }
            },
             "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
            },
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "aaSorting": [0, 'asc']
        };

        // Adiciona as opções de server-side apenas se for necessário
        if (isServerSide) {
            config.processing = true;
            config.serverSide = true;
        }

        return config;
    }

    /**
     * ===================================================================
     * FUNÇÕES GLOBAIS DE AJUDA (HELPERS) PARA DATATABLES
     * ===================================================================
     */

    function createActionButton(config) {
        var modalId = config.action + 'Modal' + config.id;
        var icon = config.icon || (config.action === 'delete' ? 'bi-trash' : 'bi-person-dash');
        return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" ' +
            'data-bs-title="' + config.tooltip + '" class="btn btn-outline-' + config.btn_class + ' btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#' + modalId + '">' +
            '<i class="bi ' + icon + ' text-secondary"></i></button>';
    }

   function appendActionModal(config) {
        var modalId = config.action + 'Modal' + config.id;
        if ($('#' + modalId).length > 0) return;

        var icon = config.icon || (config.action === 'delete' ? 'bi-trash' : 'bi-person-dash');
        var modalHeaderClass = config.header_class || (config.action === 'delete' ? 'bg-danger text-dark' : 'bg-warning text-dark');
        var title = config.title || (config.action === 'delete' ? 'EXCLUIR' : 'ALTERAR STATUS');

        var actionButton = (config.method === 'POST')
            ? `<form action="${config.url}" method="POST" class="ajax_off" style="display: inline;">
                   <input type="hidden" name="${config.id_field}" value="${config.id}">
                   <button type="submit" class="btn btn-sm btn-outline-success fw-semibold rounded-pill"><i class="bi bi-check-circle"></i> Sim</button>
               </form>`
            : `<a href="${config.url}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill"><i class="bi bi-check-circle"></i> Sim</a>`;

        var modalHtml =
            `<div class="modal fade action-modal" id="${modalId}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                       <div class="modal-header ${modalHeaderClass}">
                           <h6 class="modal-title text-center"><i class="bi ${icon} me-2"></i> ${title} - ${config.name}</h6>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <div class="modal-body fw-semibold">${config.question}</div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-sm btn-outline-danger fw-semibold rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Não</button>
                           ${actionButton}
                       </div>
                   </div>
               </div>
            </div>`;
        $('body').append(modalHtml);
    }
    
    var customTooltipCallback = function() {
        $('[data-bs-toggle-tooltip="tooltip"]').tooltip();
    };

    var drawCallbackWithModals = function(settings) {
        var api = this.api();
        var data = api.rows({ page: 'current' }).data();
        var config = settings.oInit.modalConfig;

        if (config) {
            $.each(data, function(index, rowData) {
                if (config.toggleStatus) {
                    var statusConfig = config.toggleStatus;
                    var isActived = (String(rowData[statusConfig.status_col]).toLowerCase().includes("ativado") || String(rowData[statusConfig.status_col]).toLowerCase().includes("registrado"));
                    appendActionModal({
                        action: 'toggleStatus', id: rowData[statusConfig.id_col], name: rowData[statusConfig.name_col],
                        method: 'GET',
                        question: `Deseja ${isActived ? 'desativar' : 'ativar'} ${statusConfig.item_name}: ${rowData[statusConfig.name_col]}?`,
                        url: SITE_URL + statusConfig.base_url + rowData[statusConfig.id_col],
                        icon: (isActived ? 'bi-dash-circle' : 'bi-check-circle'),
                        title: (isActived ? 'DESATIVAR' : 'ATIVAR'),
                        header_class: (isActived ? 'bg-warning text-dark' : 'bg-success text-dark'),
                    });
                }
                if (config.delete) {
                    var deleteConfig = config.delete;
                    appendActionModal({
                        action: 'delete', id: rowData[deleteConfig.id_col], name: rowData[deleteConfig.name_col],
                        method: 'POST',
                        question: `Deseja excluir ${deleteConfig.item_name}: ${rowData[deleteConfig.name_col]}?`,
                        url: SITE_URL + deleteConfig.base_url,
                        id_field: deleteConfig.id_field
                    });
                }
            });
        }
        customTooltipCallback();
    };

    /**
     * ===================================================================
     * TABELAS
     * ===================================================================
     */
    
    
    // Tabela de Participantes de Evento
    $('#myEvents').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Eventos", false), {
            responsive: {
            details: {
                display: DataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return (data[1] || '') + ' ' + (data[2] || '');
                    }
                }),
                renderer: DataTable.Responsive.renderer.tableAll({})
            }
        }
    }));
    
        // Tabela de Eventos
    $('#listEvents').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Eventos"), {
        ajax: '../themes/app/serverside/list-events.php',
        modalConfig: {
            delete: { id_col: 6, name_col: 1, base_url: '/app/eventos/excluir', id_field: 'event_id', item_name: 'o evento' }
        },
        responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (data[2] || '') + ' - ' + (data[1] || '');
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({})
                }
            },
        "aaSorting": [0, 'asc'],
        "aoColumnDefs": [
            {
                "aTargets": [5], // Coluna Editar
                "mRender": function(data, type, full) {
                    return '<a href="' + SITE_URL + '/app/eventos/editar/' + data + '" role="button" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-eye"></i></a>';
                }
            },
            {
                "aTargets": [6], // Coluna Excluir
                "mRender": function(data, type, full) {
                    return createActionButton({
                        action: 'delete', id: data,
                        tooltip: 'Excluir ' + full[1], btn_class: 'danger'
                    });
                }
            }
        ]
    }));

    // Tabela de Eventos Desativados
    $('#listEventsDisableds').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Eventos Finalizados"), {
        ajax: '../../themes/app/serverside/disabled-list-events.php',
        responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (data[0] || '') + ' ' + (data[1] || '') + ' - ' + (data[2] || '');
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({})
                }
        }
    }));
    
});