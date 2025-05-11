document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('.datatable');

    tables.forEach(function (table) {
        if (!$.fn.DataTable.isDataTable(table)) {
            $(table).DataTable({
                responsive: true,
                processing: true,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                }
            });
        }
    });
});