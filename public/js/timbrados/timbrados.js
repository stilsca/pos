$(document).ready(function () {
    $('#tablaTimbrados').DataTable({
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
        document.getElementById("tituloModalNuevo").innerHTML = 'Nuevo timbrado';
        document.getElementById("idTimbrado").value = 0;
        document.getElementById("nroTimbrado").value = '';
        document.getElementById("regimen").value = '';
        document.getElementById("vigenciaInicio").value = '';
        document.getElementById("vigenciaFin").value = '';
        document.getElementById("inicio").value = '';
        document.getElementById("fin").value = '';
        const activo = document.getElementById("activo");
        if (!activo.checked) {
            activo.click();
        }
    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar timbrado';
        var id = button.data('id');
        document.getElementById("idTimbrado").value = id;
        document.getElementById("nroTimbrado").value = button.data('timbrado');
        document.getElementById("regimen").value = button.data('regimen');
        document.getElementById("vigenciaInicio").value = button.data('vigenciainicio');
        document.getElementById("vigenciaFin").value = button.data('vigenciafin');
        document.getElementById("inicio").value = button.data('inicio');
        document.getElementById("fin").value = button.data('fin');

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
    document.getElementById("nroTimbrado").focus();
});

$("#formGuardarTimbrado").submit(function (e) {
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

$("#formEliminarTimbrado").submit(function (e) {
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