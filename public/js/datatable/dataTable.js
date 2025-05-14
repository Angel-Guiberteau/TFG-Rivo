$(document).ready(function () {
    var table = $('#sentencesTable').DataTable({
        "pageLength": 10,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    });

    $('#sentencesTable thead tr:eq(1) th input').on('keyup change', function () {
        table.column($(this).parent().index()).search(this.value).draw();
    });

    $('#entries').on('change', function () {
        let value = $(this).val();
        if (value === 'todos') {
            table.page.len(-1).draw();
        } else {
            table.page.len(parseInt(value)).draw();
        }
    });
});