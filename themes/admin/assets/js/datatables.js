$(document).ready(function() {

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
            ? `<form action="${config.url}" method="POST" style="display: inline;">
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
                    var isActived = (String(rowData[statusConfig.status_col]).toLowerCase().includes("ativo") || String(rowData[statusConfig.status_col]).toLowerCase().includes("confirmado") || String(rowData[statusConfig.status_col]).toLowerCase().includes("registrado"));
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

    // Table Online
    $('#online').DataTable( {
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [

        ]
    });

   // Table Cargos
   $('#userspositions').DataTable({
        destroy: true,
        drawCallback: drawCallbackWithModals,
        processing: true,
        serverSide: true,
        ajax: '../themes/admin/serverside/users.php',
        modalConfig: {
            toggleStatus: { id_col: 9, status_col: 7, name_col: 2, base_url: '/painel/cargos/status/', item_name: 'o cargo' },
            delete: { id_col: 10, name_col: 2, base_url: '/painel/cargos/excluir', id_field: 'userposition_id', item_name: 'o cargo' }
        },
        "aoColumnDefs": [
            { "aTargets": [9], "mRender": function(data, type, full) {
                var isActived = (String(full[7]).toLowerCase().includes("ativo") || String(full[7]).toLowerCase().includes("confirmado") || String(full[7]).toLowerCase().includes("registrado"));
                return createActionButton({
                    action: 'toggleStatus', id: full[9],
                    tooltip: (isActived ? 'Desativar ' : 'Ativar ') + full[2],
                    btn_class: (isActived ? 'warning' : 'success'),
                    icon: (isActived ? 'bi-person-dash' : 'bi-person-check')
                });
            }},
            { "aTargets": [10], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[10],
                    tooltip: 'Excluir ' + full[2], btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Cargos',header: 'Cargos',filename:'Cargos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Cargos',header: 'Cargos',filename:'Cargos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Cargos',header: 'Cargos',filename:'Cargos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
                "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
                "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
                "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
        {details:
            {display: DataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return data[0] + ' ' + data[1];
            },
            update: true
        }),
        renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });

    // Cargos Desativados
    $('#userspositionsDisabled').DataTable({
        destroy: true,
        drawCallback: drawCallbackWithModals,
        modalConfig: {
            toggleStatus: { id_col: 4, status_col: 3, name_col: 1, base_url: '/painel/cargos/status/', item_name: 'o cargo' },
            delete: { id_col: 5, name_col: 1, base_url: '/painel/cargos/excluir', id_field: 'userposition_id', item_name: 'o cargo' }
        },
        "aoColumnDefs": [
            { "aTargets": [4], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'toggleStatus', id: full[3], tooltip: 'Ativar ' + full[4],
                    btn_class: 'success', icon: 'bi-check-circle'
                });
            }},
            { "aTargets": [11], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[5], 
                    tooltip: 'Excluir ' + full[1],
                    btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Cargos',header: 'Cargos',filename:'Cargos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Cargos',header: 'Cargos',filename:'Cargos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Cargos',header: 'Cargos',filename:'Cargos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
        {details:
            {display: DataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return data[0] + ' ' + data[1];
            },
            update: true
        }),
        renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc'] /* 'desc' Carregar table decrescente e asc crescente*/
    });

    // Lista de Usuarios
    var users = $('#users').DataTable({
        destroy: true,
        drawCallback: drawCallbackWithModals,
        processing: true,
        serverSide: true,
        ajax: '../themes/admin/serverside/users.php',
        modalConfig: {
            toggleStatus: { id_col: 9, status_col: 7, name_col: 2, base_url: '/painel/usuarios/status/', item_name: 'o usuário' },
            delete: { id_col: 10, name_col: 2, base_url: '/painel/usuarios/excluir', id_field: 'user_id', item_name: 'o usuário' }
        },
        "aoColumnDefs": [
            { "aTargets": [9], "mRender": function(data, type, full) {
                var isActived = (String(full[7]).toLowerCase().includes("ativo") || String(full[7]).toLowerCase().includes("confirmado") || String(full[7]).toLowerCase().includes("registrado"));
                return createActionButton({
                    action: 'toggleStatus', id: full[9],
                    tooltip: (isActived ? 'Desativar ' : 'Ativar ') + full[2],
                    btn_class: (isActived ? 'warning' : 'success'),
                    icon: (isActived ? 'bi-person-dash' : 'bi-person-check')
                });
            }},
            { "aTargets": [10], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[10],
                    tooltip: 'Excluir ' + full[2], btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Usuario',header: 'Usuario',filename:'Usuario',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            // {extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Usuario',header: 'Usuario',filename:'Usuario',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Usuario',header: 'Usuario',filename:'Usuario',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
             "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:
                {display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return data[0] + ' ' + data[3];
                },
                update: true
            }),
            renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc'] /* 'desc' Carregar table decrescente e asc crescente*/
    });

    $('div.dt-search input', users.table().container()).focus();

    // Usuarios desabilitados
    $('#usersDisabled').DataTable( {
        destroy: true,
        drawCallback: drawCallbackWithModals,
        modalConfig: {
            toggleStatus: { id_col: 8, status_col: 6, name_col: 1, base_url: '/painel/usuarios/status/', item_name: 'o usuário' },
            delete: { id_col: 9, name_col: 1, base_url: '/painel/usuarios/excluir', id_field: 'user_id', item_name: 'o usuário' }
        },
       "aoColumnDefs": [
            { "aTargets": [8], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'toggleStatus', id: full[8], tooltip: 'Ativar ' + full[1],
                    btn_class: 'success', icon: 'bi-person-check'
                });
            }},
            { "aTargets": [9], "mRender": function(data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[9], tooltip: 'Excluir ' + full[1],
                    btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Usuario',header: 'Usuario',filename:'Usuario',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            // {extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Usuario',header: 'Usuario',filename:'Usuario',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Usuario',header: 'Usuario',filename:'Usuario',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:
                {display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return data[0] + ' ' + data[1];
                },
                update: true
            }),
            renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });

  //Lista de Igrejas
    $('#churchs').DataTable( {
         destroy: true,
        drawCallback: drawCallbackWithModals,
        modalConfig: {
            toggleStatus: { id_col: 11, status_col: 10, name_col: 4, base_url: '/painel/igrejas/status/', item_name: 'a igreja' },
            delete: { id_col: 12, name_col: 4, base_url: '/painel/igrejas/excluir', id_field: 'church_id', item_name: 'a igreja' }
        },
        "aoColumnDefs": [
             { "aTargets": [11], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'toggleStatus', id: full[11],
                    tooltip: 'Desativar ' + full[4], btn_class: 'warning'
                });
            }},
            { "aTargets": [12], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[12],
                    tooltip: 'Excluir ' + full[4], btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Igrejas',header: 'Igrejas',filename:'Igrejas',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            {extend:'print', exportOptions: {columns: ':visible'},title:'Igrejas',header: 'Igrejas',filename:'Igrejas',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
        "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:
                {display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return data[2] + ' ' + data[3] + ' - ' + data[4];
                },
                update: true
            }),
            renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });

      //Lista de Igrejas
      $('#churchsDisabled').DataTable( {
        destroy: true,
        drawCallback: drawCallbackWithModals,
        modalConfig: {
            toggleStatus: { id_col: 10, status_col: 9, name_col: 3, base_url: '/painel/igrejas/status/', item_name: 'a igreja' },
            delete: { id_col: 11, name_col: 3, base_url: '/painel/igrejas/excluir', id_field: 'church_id', item_name: 'a igreja' }
        },
        "aoColumnDefs": [
            { "aTargets": [10], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'toggleStatus', id: full[10], tooltip: 'Ativar ' + full[3],
                    btn_class: 'success', icon: 'bi-check-circle'
                });
            }},
            { "aTargets": [11], "mRender": function (data, type, full) {
                return createActionButton({
                    action: 'delete', id: full[11], tooltip: 'Excluir ' + full[3],
                    btn_class: 'danger'
                });
            }}
        ],
        buttons: [
            {extend:'excel',title:'Igrejas Desativadas',header: 'Igrejas Desativadas',filename:'Igrejas Desativadas',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            // {extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Igrejas Desativadas',header: 'Igrejas Desativadas',filename:'Igrejas Desativadas',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Igrejas Desativadas',header: 'Igrejas Desativadas',filename:'Igrejas Desativadas',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-info btn-sm mb-2',text:'<i class="bi bi-list"></i>'}],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:   
                {display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return data[1] + ' ' + data[2] + ' - ' + data[3];
                },
                update: true
            }),
            renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        // dom: "lBftipr",
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });

    $('#levels').DataTable({
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },
        "lengthMenu": [[5, -1], [5, "Todos"]],
        "aaSorting": [0, 'desc'],
    });

    $('#historyPatrimonyUser').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Patrimonio',header: 'Patrimonio',filename:'Patrimonio',className: 'btn btn-outline-success mb-2 mt-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdf',exportOptions: {columns: ':visible'},title:'Patrimonio SIGECINFO',header: 'Patrimonio SIGECINFO',filename:'Patrimonio SIGECINFO',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger mb-2 mt-2',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Patrimonio SIGECINFO',header: 'Patrimonio',filename:'Patrimonio',orientation: 'portrait',className: 'btn btn-outline-secondary mb-2 mt-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-smsub mb-2 mt-2',text:'<i class="bi bi-list"></i>'},],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:
                    {display: DataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return data[0] + ' - ' + data[1] + ' - ' + data[2];
                            },
                            update: true
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },

        "lengthMenu": [[7, 25, 50, -1], [7, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });

    $('#patrimonyUser').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Patrimonio',header: 'Patrimonio',filename:'Patrimonio',className: 'btn btn-outline-success mb-2 mt-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdf',exportOptions: {columns: ':visible'},title:'Patrimonio SIGECINFO',header: 'Patrimonio SIGECINFO',filename:'Patrimonio SIGECINFO',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger mb-2 mt-2',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Patrimonio SIGECINFO',header: 'Patrimonio',filename:'Patrimonio',orientation: 'portrait',className: 'btn btn-outline-secondary mb-2 mt-2',text:'<i class="bi bi-printer"></i>'},
            {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-smsub mb-2 mt-2',text:'<i class="bi bi-list"></i>'},],
            "dom": "<'row mt-2 justify-content-between'<'col-lg-5 col-sm-5 col-md-5 numporpag'l><'col-lg-2 col-sm-2 col-md-2 text-center'B><'col-lg-5 col-sm-5 col-md-5 searchbar'f>>" +
            "<'row mt-2 justify-content-between dt-layout-table'<'col-sm-12'tr>>" +
            "<'row mt-2 justify-content-between'<'d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto'i><'d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto'p>>",
        responsive:
            {details:
                    {display: DataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return data[0] + ' - ' + data[1] + ' - ' + data[2];
                            },
                            update: true
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({})}},
        "language": {
            "sEmptyTable": "Nenhum registro encontrado","sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado","sSearch": "Pesquisar",
            "oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
            "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"}
        },

        "lengthMenu": [[7, 25, 50, -1], [7, 25, 50, "Todos"]],
        "aaSorting": [0, 'asc']
    });
});