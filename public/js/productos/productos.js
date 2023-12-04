$(document).ready(function () {
    $('#tablaProductos').DataTable({
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
        document.getElementById("tituloModalNuevo").innerHTML = 'Nuevo producto';
        document.getElementById("idProducto").value = 0;
        document.getElementById("nombreProducto").value = '';
        document.getElementById("codigoBarra").value = '';
        document.getElementById("codigoBarra").value = '';
        const element = AutoNumeric.getAutoNumericElement('#precio');
        element.set(0);
        const activo = document.getElementById("activo");
        if (!activo.checked) {
            activo.click();
        }
    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar producto';
        var id = button.data('id');
        document.getElementById("idProducto").value = id;
        document.getElementById("nombreProducto").value = button.data('nombre');
        document.getElementById("codigoBarra").value = button.data('codigo');

        $('#idGrupo').val(button.data('grupo')).change();
        $('#idTipo').val(button.data('tipo')).change();
        $('#idImpuesto').val(button.data('impuesto')).change();

        const element = AutoNumeric.getAutoNumericElement('#precio');
        element.set(button.data('precio'));

        const activo = document.getElementById("activo");
        if (button.data('activo') == '1') {
            if (!activo.checked) {
                activo.click();
            }
        } else {
            if (activo.checked) {
                activo.click();
            }
        }
    }
})

$("#modalNuevo").on('shown.bs.modal', function () {
    document.getElementById("nombreProducto").focus();
});

$("#formGuardarProducto").submit(function (e) {
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

$("#formEliminarProducto").submit(function (e) {
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