$(document).ready(function () {
    $('#tablaProveedores').DataTable({
        "dom": '<"top"f>rt<"bottom"ip><"clear">',
        "lengthMenu": [
            [50],
            [50]
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ reg/pág",
            "zeroRecords": "No se encontraron registros",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        }
    });
});

$('#modalEliminar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $('#idEliminar').val(id);
})

$('#modalNuevo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nuevo = button.data('nuevo');
    if (nuevo) {
        document.getElementById("tituloModalNuevo").innerHTML = 'Nuevo proveedor';
        document.getElementById("idProveedor").value = 0;
        document.getElementById("razonSocial").value = '';
        document.getElementById("documento").value = '';
        document.getElementById("telefono").value = '';
        document.getElementById("direccion").value = '';

    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar proveedor';
        var id = button.data('id');
        document.getElementById("idProveedor").value = id;
        document.getElementById("razonSocial").value = button.data('nombre');
        document.getElementById("documento").value = button.data('documento');
        document.getElementById("telefono").value = button.data('telefono');
        document.getElementById("direccion").value = button.data('direccion');
    }
})

$("#modalNuevo").on('shown.bs.modal', function () {
    document.getElementById("documento").focus();
});

$("#formGuardarProveedor").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.exito) {
                location.reload();
            } else {
                document.getElementById('alertaGuardar').classList.remove('d-none');
                document.getElementById('alertaGuardar').innerHTML = response.msg;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR);
            console.error(textStatus);
            console.error(errorThrown);
        }
    });
});

$("#formEliminarProveedor").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.exito) {
                location.reload();
            } else {
                document.getElementById('alertaEliminar').classList.remove('d-none');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(jqXHR);
            console.error(textStatus);
            console.error(errorThrown);
        }
    });
});