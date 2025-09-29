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

    /**
     * PASSO 2: Função Helper para criar e ANEXAR o MODAL ao <body>.
     */
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

    /**
     * PASSO 3: Função de Callback para gerar os modais e ativar os tooltips.
     */
    var drawCallbackWithModals = function(settings) {
        var api = this.api();
        var data = api.rows({ page: 'current' }).data();
        var config = settings.oInit.modalConfig;

        if (config) {
            $.each(data, function(index, rowData) {
                if (config.toggleStatus) {
                    var statusConfig = config.toggleStatus;
                    var isActived = (String(rowData[statusConfig.status_col]).includes("ATIVO") || String(rowData[statusConfig.status_col]).includes("CONFIRMADO") || String(rowData[statusConfig.status_col]).includes("REGISTRADO"));
                    appendActionModal({
                        action: 'toggleStatus', id: rowData[statusConfig.id_col], name: rowData[statusConfig.name_col],
                        method: 'GET',
                        question: `Deseja ${isActived ? 'desativar' : 'ativar'} ${statusConfig.item_name}: ${rowData[statusConfig.name_col]}?`,
                        url: SITE_URL + statusConfig.base_url + rowData[statusConfig.id_col],
                        icon: (isActived ? 'bi-person-dash' : 'bi-person-check'),
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

        $('[data-bs-toggle-tooltip="tooltip"]').tooltip();
    };

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

   // Cargos
   $('#userspositions').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
    });

    // Cargos Desativados
    $('#userspositionsDisabled').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
    });

        // Regimes
    $('#userscategories').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Regimes',header: 'Regimes',filename:'Regimes',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Regimes',header: 'Regimes',filename:'Regimes',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Regimes',header: 'Regimes',filename:'Regimes',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
    });

    // Regimes Desativados
    $('#userscategoriesDisabled').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Regimes',header: 'Regimes',filename:'Regimes',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Regimes',header: 'Regimes',filename:'Regimes',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Regimes',header: 'Regimes',filename:'Regimes',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
    });

    // Marcas
    $('#brands').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Marcas',header: 'Marcas',filename:'Marcas',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Marcas',header: 'Marcas',filename:'Marcas',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Marcas',header: 'Marcas',filename:'Marcas',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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

      // Marcas
      $('#brandsDisabled').DataTable( {
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Marcas',header: 'Marcas',filename:'Marcas',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Marcas',header: 'Marcas',filename:'Marcas',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Marcas',header: 'Marcas',filename:'Marcas',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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

    // Contratos
    $('#contracts').DataTable({
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Contratos',header: 'Contratos',filename:'Contratos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Contratos',header: 'Contratos',filename:'Contratos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Contratos',header: 'Contratos',filename:'Contratos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [
            {
                "aTargets": [10], // o numero da coluna
                "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para desativar '+ full[1] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#activedModal'+ full[10]+'">' +
                        '<i class="bi bi-person-dash text-secondary"></i></button>' +
                        '<div class="modal fade" id="activedModal' + full[10] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-light">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-gift me-2"></i> Desativar ID: ' + full[10] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja desativar o contrato : ' + full[1] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="contratos/desativar/' + full[10] + '/disabled" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            }
        ]
    });

      // Contratos
      $('#contractsDisabled').DataTable( {
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Contratos',header: 'Contratos',filename:'Contratos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Contratos',header: 'Contratos',filename:'Contratos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Contratos',header: 'Contratos',filename:'Contratos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [
            {
                "aTargets": [10], // o numero da coluna
                "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para ativar '+ full[1] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAtivar'+ full[10] +'">' +
                        '<i class="bi bi-person-check"></i></button>' +
                        '<div class="modal fade" id="modalAtivar' + full[10] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-light">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> Ativar ID: ' + full[10] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja ativar o contrato : ' + full[2] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="ativar/' + full[10] + '/actived" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            }
        ]
    });

    // Produtos Desabilitados
    $('#products').DataTable( {
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Produtos',header: 'Produtos',filename:'Produtos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Produtos',header: 'Produtos',filename:'Produtos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Produtos',header: 'Produtos',filename:'Produtos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [
            {
                "aTargets": [7], // o numero da coluna
                "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para desativar '+ full[2] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#activedModal'+ full[7]+'">' +
                        '<i class="bi bi-person-dash text-secondary"></i></button>' +
                        '<div class="modal fade" id="activedModal' + full[7] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-light">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-gift me-2"></i> Desativar ID: ' + full[7] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja desativar o produto : ' + full[2] + ' - ' + full[3] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="produtos/desativar/' + full[7] + '/disabled" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            }
            // ,
            // {
            //     "aTargets": [7], // o numero da coluna
            //     "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
            //         return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
            //             'data-bs-title="Clique para excluir definitivamente '+ full[7] +'" class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#trashModalFim'+ full[7]+'">' +
            //             '<i class="bi bi-trash"></i></button>' +
            //             '<div class="modal fade" id="trashModalFim' + full[7] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
            //                 '<div class="modal-dialog modal-sm">\n' +
            //                     '<div class="modal-content">\n' +
            //                         '<div class="modal-header bg-danger text-light">\n' +
            //                         '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> Excluir ID: ' + full[7] + '</h6>\n' +
            //                         '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
            //                         '</div>\n' +
            //                         '<div class="modal-body fw-semibold">Deseja excluir o marca : ' + full[1] + ' ?</div>\n' +
            //                         '<div class="modal-footer">\n' +
            //                         '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
            //                         '<a href="produtos/excluir/' + full[7] + '/delete" data-action="delete" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
            //                         '</div>\n' +
            //                     '</div>\n' +
            //                 '</div>\n' +
            //             '</div>';
            //     }
            // }
        ]
    });

    // Produtos Desabilitados
    $('#productsDisabled').DataTable( {
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
        buttons: [
            {extend:'excel',title:'Produtos',header: 'Produtos',filename:'Produtos',className: 'btn btn-outline-success btn-sm mb-2',text:'<i class="bi bi-file-earmark-excel"></i>' },
            //{extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'Produtos',header: 'Produtos',filename:'Produtos',orientation: 'portrait',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'<i class="bi bi-file-earmark-pdf"></i>'},
            {extend:'print', exportOptions: {columns: ':visible'},title:'Produtos',header: 'Produtos',filename:'Produtos',orientation: 'portrait',className: 'btn btn-outline-secondary btn-sm mb-2',text:'<i class="bi bi-printer"></i>'},
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [
            {
                "aTargets": [6], // o numero da coluna
                "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para ativar '+ full[1] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modalAtivar'+ full[6]+'">' +
                        '<i class="bi bi-person-check"></i></button>' +
                        '<div class="modal fade" id="modalAtivar' + full[6] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-light">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> Ativar ID: ' + full[6] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja ativar o produto : ' + full[1] + ' - ' + full[2] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="ativar/' + full[6] + '/actived" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            }
        ]
    });

    // Lista de Usuarios
    var users = $('#users').DataTable({
        destroy: true,
        drawCallback: drawCallbackWithModals,
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        processing: true,
        serverside: true,
        ajax: '../themes/admin/serverside/users.php',
        modalConfig: {
        toggleStatus: { id_col: 9, status_col: 7, name_col: 2, base_url: '/painel/usuarios/status/', item_name: 'o usuário' },
        delete: { id_col: 10, name_col: 2, base_url: '/painel/usuarios/excluir', id_field: 'user_id', item_name: 'o usuário' }
        },
        "aoColumnDefs": [
            { "aTargets": [9], "mRender": function(data, type, full) {
                var isActived = (full[7].includes("ATIVO") || full[7].includes("CONFIRMADO") || full[7].includes("REGISTRADO"));
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
        ]
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
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
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
        "aaSorting": [0, 'asc'],
        "aoColumnDefs": [
            {
                "aTargets": [11], // Coluna de desativar
                "mRender": function (data, type, full) {
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para desativar '+ full[4] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#activedModal'+ full[11]+'">' +
                        '<i class="bi bi-person-dash text-secondary"></i></button>' +
                        '<div class="modal fade" id="activedModal' + full[11] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-dark">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-person-dash me-2"></i> DESATIVAR - ' + full[2] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja desativar a igreja : ' + full[4] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="igrejas/status/' + full[11] + '" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            },
            {
                "aTargets": [12], // Coluna de excluir
                "mRender": function (data, type, full) {
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para excluir '+ full[4] +'" class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#deleteModal'+ full[12]+'">' +
                        '<i class="bi bi-trash text-secondary"></i></button>' +
                        '<div class="modal fade" id="deleteModal' + full[12] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-danger text-dark">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> EXCLUIR - ' + full[2] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja excluir a igreja : ' + full[4] + ' ?</div>\n' +
                                   '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="igrejas/excluir/' + full[12] + '" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                
                }
            }
        ]
    });

      //Lista de Igrejas
      $('#churchsDisabled').DataTable( {
        drawCallback: function() {
            $('body').tooltip({
                selector: '[data-bs-toggle-tooltip="tooltip"]'
            });
        },
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
        "aaSorting": [0, 'asc'], /* 'desc' Carregar table decrescente e asc crescente*/
        "aoColumnDefs": [
            {
                "aTargets": [10], // o numero da coluna
                "mRender": function (data, type, full) { //aqui é uma funçãozinha para pegar os ids
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                        'data-bs-title="Clique para desativar '+ full[3] +'" class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#activedModal'+ full[10]+'">' +
                        '<i class="bi bi-person-dash text-secondary"></i></button>' +
                        '<div class="modal fade" id="activedModal' + full[10] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                            '<div class="modal-dialog modal-sm">\n' +
                                '<div class="modal-content">\n' +
                                    '<div class="modal-header bg-warning text-dark">\n' +
                                    '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-person-dash me-2"></i> ATIVAÇÃO - ' + full[1] + '</h6>\n' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                    '</div>\n' +
                                    '<div class="modal-body fw-semibold">Deseja ativar a igreja : ' + full[3] + ' ?</div>\n' +
                                    '<div class="modal-footer">\n' +
                                    '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                    '<a href="status/' + full[10] + '" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>';
                }
            },
            {
                "aTargets": [11], // Coluna de excluir
                "mRender": function (data, type, full) 
                {
                    return '<button type="button" data-bs-toggle-tooltip="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"\n' +
                    'data-bs-title="Clique para excluir '+ full[4] +'" class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#deleteModal'+ full[11]+'">' +
                    '<i class="bi bi-trash text-secondary"></i></button>' +
                    '<div class="modal fade" id="deleteModal' + full[11] + '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                        '<div class="modal-dialog modal-sm">\n' +
                            '<div class="modal-content">\n' +
                                '<div class="modal-header bg-danger text-dark">\n' +
                                '<h6 class="modal-title text-center" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> EXCLUIR - ' + full[4] + '</h6>\n' +
                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
                                '</div>\n' +
                                '<div class="modal-body fw-semibold">Deseja excluir a igreja : ' + full[4] + ' ?</div>\n' +
                                '<div class="modal-footer">\n' +
                                '<button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3 position-relative rounded-pill" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Não</button>\n' +
                                '<a href="../igrejas/excluir/' + full[11] + '" class="btn btn-sm btn-outline-success fw-semibold me-3 position-relative rounded-pill"><i class="bi bi-plus-circle" role="button" ></i> Sim</a>\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</div>\n' +
                    '</div>';
                
                }
            }
        ]
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