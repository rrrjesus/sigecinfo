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

    // Verifica se o valor representa um status ativo, mesmo que venha com HTML
    function isActiveStatus(value) {
        if (!value) return false;

        // Remove qualquer HTML e extrai apenas o texto puro
        const text = $('<div>').html(value).text().toLowerCase().trim();

        // Verifica status válidos como "ativo", "ativado" ou "registrado"
        return ["ativo", "registered", "ativado", "registrado"].includes(text);
    }

    function createActionButton(config) {
        const modalId = `${config.action}Modal${config.id}`;
        const icon = config.icon || (config.action === 'delete' ? 'bi-trash' : 'bi-person-dash');
        return `
            <button type="button" 
                    data-bs-toggle-tooltip="tooltip" 
                    data-bs-placement="top" 
                    data-bs-custom-class="custom-tooltip" 
                    data-bs-title="${config.tooltip}" 
                    class="btn btn-outline-${config.btn_class} btn-sm rounded-circle" 
                    data-bs-toggle="modal" 
                    data-bs-target="#${modalId}">
                <i class="bi ${icon} text-secondary"></i>
            </button>`;
    }

    function createEditButton(config) {
        return `
            <a href="${config.url}" 
               role="button" 
               class="btn btn-sm btn-outline-primary rounded-circle" 
               data-bs-toggle-tooltip="tooltip" 
               data-bs-placement="top" 
               data-bs-custom-class="custom-tooltip" 
               data-bs-title="${config.tooltip}">
                <i class="bi bi-pencil"></i>
            </a>`;
    }

   function appendActionModal(config) {
        const modalId = `${config.action}Modal${config.id}`;
        if ($('#' + modalId).length > 0) return;

        const icon = config.icon || (config.action === 'delete' ? 'bi-trash' : 'bi-person-dash');
        const modalHeaderClass = config.header_class || (config.action === 'delete' ? 'bg-danger text-dark' : 'bg-warning text-dark');
        const title = config.title || (config.action === 'delete' ? 'EXCLUIR' : 'ALTERAR STATUS');

        const actionButton = (config.method === 'POST')
            ? `<form action="${config.url}" method="POST" class="ajax_off" style="display: inline;">
                   <input type="hidden" name="${config.id_field}" value="${config.id}">
                   <button type="submit" class="btn btn-sm btn-outline-success fw-semibold rounded-pill"><i class="bi bi-check-circle"></i> Sim</button>
               </form>`
            : `<a href="${config.url}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill"><i class="bi bi-check-circle"></i> Sim</a>`;

        const modalHtml = `
            <div class="modal fade action-modal" id="${modalId}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
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
    
    // Função que cria um renderizador de botão de status para `aoColumnDefs`
    function createStatusButtonRenderer(idCol, statusCol, nameCol, isForDisabledTable = false) {
        return function(data, type, full) {
            const isActived = isActiveStatus(full[statusCol]);
            const action = isActived ? 'inativo' : 'ativo';
            const text = isActived ? 'ATIVO' : 'INATIVO';
            const btnClass = isActived ? 'success' : 'danger';
            const modalId = `${action}Modal${full[idCol]}`;
            const title = isForDisabledTable ? `Ativar ${full[nameCol]}` : `${isActived ? 'Desativar' : 'Ativar'} ${full[nameCol]}`;

            return `
                <button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                        data-bs-title="${title}" class="btn btn-sm fw-semibold btn-${btnClass}" data-bs-toggle="modal" data-bs-target="#${modalId}">
                    ${text}
                </button>`;
        };
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
                    var isActived = isActiveStatus(rowData[statusConfig.status_col]);
                    var action = isActived ? 'inativo' : 'ativo'; // Ação dinâmica
    
                    appendActionModal({
                        action: action, // Ação específica
                        id: rowData[statusConfig.id_col],
                        name: rowData[statusConfig.name_col],
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
                        action: 'delete',
                        id: rowData[deleteConfig.id_col],
                        name: rowData[deleteConfig.name_col],
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
    
    // Table Cargos
    $('#userspositions').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Cargos", false), {
        modalConfig: {
            toggleStatus: { id_col: 4, status_col: 3, name_col: 1, base_url: '/painel/cargos/status/', item_name: 'o cargo' },
            delete: { id_col: 5, name_col: 1, base_url: '/painel/cargos/excluir', id_field: 'userposition_id', item_name: 'o cargo'}
        },
       "aoColumnDefs": [
            { "aTargets": [4], "mRender": createStatusButtonRenderer(4, 3, 1) },
            { "aTargets": [5], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[5], tooltip: 'Excluir ' + full[1],
                    btn_class: 'danger'
                });
            }}
        ]
    }));
        
    // Cargos Desativados
    $('#userspositionsDisabled').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Cargos Desativados", false), {
        modalConfig: {
            toggleStatus: { id_col: 3, status_col: 2, name_col: 0, base_url: '/painel/cargos/status/', item_name: 'o cargo' },
            delete: { id_col: 4, name_col: 0, base_url: '/painel/cargos/excluir', id_field: 'userposition_id', item_name: 'o cargo'}
        },
       "aoColumnDefs": [
            { "aTargets": [3], "mRender": createStatusButtonRenderer(3, 2, 0, true) },
            { "aTargets": [4], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[4], tooltip: 'Excluir ' + full[0],
                    btn_class: 'danger'
                });
            }}
        ]
    }));

    // Lista de Usuarios
    var users = $('#users').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Usuarios"), {
        ajax: '../themes/admin/serverside/users.php',
        modalConfig: {
            toggleStatus: { id_col: 9, status_col: 8, name_col: 2, base_url: '/painel/usuarios/status/', item_name: 'o usuário' },
            delete: { id_col: 9, name_col: 2, base_url: '/painel/usuarios/excluir', id_field: 'user_id', item_name: 'o usuário' }
        },
        "aoColumnDefs": [
            { "aTargets": [0], "mRender": function(data, type, full) {
                return createEditButton({
                    url: SITE_URL + '/painel/usuarios/editar/' + full[0],
                    tooltip: 'Editar ' + full[2]
                });
            }},
            { "aTargets": [8], "mRender": createStatusButtonRenderer(9, 8, 2) },
            { "aTargets": [9], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[9],
                    tooltip: 'Excluir ' + full[2], btn_class: 'danger'
                });
            }}
        ]
    }));

    $('div.dt-search input', users.table().container()).focus();

    // Usuarios desabilitados
    $('#usersDisabled').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Usuários Desabilitados", false), {
        modalConfig: {
            toggleStatus: { id_col: 8, status_col: 7, name_col: 1, base_url: '/painel/usuarios/status/', item_name: 'o usuário' },
            delete: { id_col: 8, name_col: 1, base_url: '/painel/usuarios/desativados/excluir', id_field: 'user_id', item_name: 'o usuário' }
        },
       "aoColumnDefs": [
            { "aTargets": [7], "mRender": createStatusButtonRenderer(8, 7, 1, true) },
            { "aTargets": [8], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[8], tooltip: 'Excluir ' + full[1],
                    btn_class: 'danger'
                });
            }}
        ]
    }));

    //Lista de Locais
    $('#places').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Locais", false), {
        modalConfig: {
            toggleStatus: { id_col: 11, status_col: 10, name_col: 4, base_url: '/painel/locais/status/', item_name: 'a locai' },
            delete: { id_col: 12, name_col: 4, base_url: '/painel/locais/excluir', id_field: 'place_id', item_name: 'a locai' }
        },
        "aoColumnDefs": [
             { "aTargets": [11], "mRender": createStatusButtonRenderer(11, 10, 4) },
            { "aTargets": [12], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[12],
                    tooltip: 'Excluir ' + full[4], btn_class: 'danger'
                });
            }}
        ]
    }));

    //Lista de Locais Desativados
    $('#placesDisabled').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Locais Desativados", false), {
        modalConfig: {
            toggleStatus: { id_col: 10, status_col: 9, name_col: 3, base_url: '/painel/locais/status/', item_name: 'a locai' },
            delete: { id_col: 11, name_col: 3, base_url: '/painel/locais/excluir', id_field: 'place_id', item_name: 'a locai' }
        },
        "aoColumnDefs": [
            { "aTargets": [10], "mRender": createStatusButtonRenderer(10, 9, 3, true) },
            { "aTargets": [11], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[11], tooltip: 'Excluir ' + full[3],
                    btn_class: 'danger'
                });
            }}
        ]
    }));

    // Níveis de Acesso
    $('#levels').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Níveis de Acesso", false), {
        "lengthMenu": [[5, -1], [5, "Todos"]],
        "aaSorting": [0, 'desc']
    }));

    // Tabela de Eventos
    $('#events').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Eventos"), {
        ajax: '../themes/admin/serverside/events.php',
        modalConfig: {
            delete: { id_col: 6, name_col: 1, base_url: '/painel/eventos/excluir', id_field: 'event_id', item_name: 'o evento' }
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
                    return '<a href="' + SITE_URL + '/painel/eventos/editar/' + data + '" role="button" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-eye"></i></a>';
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
    $('#disabledEvents').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Eventos Desativados"), {
        ajax: '../../themes/admin/serverside/disabledEvents.php',
        modalConfig: {
            delete: { id_col: 5, name_col: 1, base_url: '/painel/eventos/excluir', id_field: 'event_id', item_name: 'o evento' }
        },
        responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (data[1] || '') + ' ' + (data[4] || '');
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({})
                }
            },
        "aoColumnDefs": [
            {
                "aTargets": [0], // Coluna Editar
                "mRender": function(data, type, full) {
                    return '<a href="' + SITE_URL + '/painel/eventos/editar/' + data + '" role="button" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-eye"></i></a>';
                }
            },
            {
                "aTargets": [5], // Coluna Excluir
                "mRender": function(data, type, full) {
                    return createActionButton({
                        action: 'delete', id: data,
                        tooltip: 'Excluir ' + full[1],
                        btn_class: 'danger'
                    });
                }
            }
        ]
    }));

    // Tabela de Tipos de Evento
    $('#eventTypes').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Tipos de Evento", false), {
        modalConfig: {
            toggleStatus: { id_col: 4, status_col: 2, name_col: 0, base_url: '/painel/tipos-de-eventos/status/', item_name: 'o tipo de evento' },
            delete: { id_col: 5, name_col: 0, base_url: '/painel/tipos-de-eventos/excluir', id_field: 'type_id', item_name: 'o tipo de evento' }
        },
        "aoColumnDefs": [
            { "aTargets": [3], "mRender": function (data, type, full) {
                return '<a href="' + SITE_URL + '/painel/tipos-de-eventos/editar/' + data + '" role="button" class="btn btn-sm btn-outline-warning rounded-circle" data-bs-toggle-tooltip="tooltip" title="Editar"><i class="bi bi-pencil"></i></a>';
            }},
            { "aTargets": [4], "mRender": createStatusButtonRenderer(4, 2, 0) },
            { "aTargets": [5], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: data,
                    tooltip: 'Excluir ' + full[0], btn_class: 'danger'
                });
            }}
        ]
    }));

    // Tabela de Tipos de Evento Desativados
    $('#disabledEventTypes').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Tipos de Evento Desativados", false), {
        modalConfig: {
            toggleStatus: { id_col: 4, status_col: 2, name_col: 0, base_url: '/painel/tipos-de-eventos/status/', item_name: 'o tipo de evento' },
            delete: { id_col: 5, name_col: 0, base_url: '/painel/tipos-de-eventos/excluir', id_field: 'type_id', item_name: 'o tipo de evento' }
        },
        "aoColumnDefs": [
            { "aTargets": [3], "mRender": function(data, type, full) {
                return '<a href="' + SITE_URL + '/painel/tipos-de-eventos/editar/' + data + '" role="button" class="btn btn-sm btn-outline-warning rounded-circle" data-bs-toggle-tooltip="tooltip" title="Editar"><i class="bi bi-pencil"></i></a>';
            }},
            { "aTargets": [4], "mRender": createStatusButtonRenderer(4, 2, 0, true) },
            { "aTargets": [5], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: data, tooltip: 'Excluir ' + full[0],
                    btn_class: 'danger'
                });
            }}
        ]
    }));

     // Tabela de Participantes de Evento
    $('#eventParticipants').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Participantes de Evento", false), {
        modalConfig: {
            delete: { id_col: 6, name_col: 2, base_url: '/painel/eventos/remover-participante', id_field: 'participant_id', item_name: 'o participante de evento' }
        },
        "aoColumnDefs": [
            { "aTargets": [6], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: data,
                    tooltip: 'Excluir ' + full[2], btn_class: 'danger'
                });
            }}
        ]
    }));

    // Tabela de Menus
    $('#menus').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Menus", false), {
        modalConfig: {
            delete: { id_col: 4, name_col: 1, base_url: '/painel/menus/excluir', id_field: 'menu_id', item_name: 'o menu' }
        },
        "aoColumnDefs": [
            { "aTargets": [4], "mRender": function (data, type, full) {
                var editButton = createEditButton({
                    url: SITE_URL + '/painel/menus/editar/' + data,
                    tooltip: 'Editar ' + full[1]
                });
                var deleteButton = createActionButton({
                    action: 'delete', id: data,
                    tooltip: 'Excluir ' + full[1], btn_class: 'danger'
                });
                return editButton + ' ' + deleteButton;
            }}
        ],
        "aaSorting": [0, 'asc'] // Ordenar pela coluna 'Ordem'
    }));

    // Tabela de Menus
    $('#submenus').DataTable($.extend(true, {}, getDefaultDataTablesConfig("Menus", false), {
        modalConfig: {
            delete: { id_col: 7, name_col: 2, base_url: '/painel/submenus/excluir', id_field: 'menu_id', item_name: 'o menu' }
        },
        "aoColumnDefs": [
            { "aTargets": [7], "mRender": function (data, type, full) {
                var editButton = createEditButton({
                    url: SITE_URL + '/painel/submenus/editar/' + data,
                    tooltip: 'Editar ' + full[2]
                });
                var deleteButton = createActionButton({
                    action: 'delete', id: data,
                    tooltip: 'Excluir ' + full[2], btn_class: 'danger'
                });
                return editButton + ' ' + deleteButton;
            }}
        ],
        "aaSorting": [6, 'asc'] // Ordenar pela coluna 'Ordem'
    }));

});
