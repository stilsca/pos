$(document).ready(function () {
    $('#tablaMarcas').DataTable({
        "dom": '<"top"f>rt<"bottom"ip><"clear">',
        "lengthMenu": [
            [50],
            [50]
        ]
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
        document.getElementById("tituloModalNuevo").innerHTML = 'Nueva marca';
        document.getElementById("idMarca").value = 0;
        document.getElementById("nombreMarca").value = '';
        const activo = document.getElementById("activo");
        if (!activo.checked) {
            activo.click();
        }
    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar marca';
        var id = button.data('id');
        document.getElementById("idMarca").value = id;
        document.getElementById("nombreMarca").value = button.data('nombre');

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
    document.getElementById("nombreMarca").focus();
});

$("#formGuardarMarca").submit(function (e) {
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

$("#formEliminarMarca").submit(function (e) {
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