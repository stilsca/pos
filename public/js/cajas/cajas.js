$(document).ready(function () {
    $('#tablaCaja').DataTable({
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
        document.getElementById("tituloModalNuevo").innerHTML = 'Nueva caja';
        document.getElementById("idCaja").value = 0;
        document.getElementById("nombreCaja").value = '';
    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar caja';
        var id = button.data('id');
        document.getElementById("idCaja").value = id;
        document.getElementById("nombreCaja").value = button.data('nombre');
    }
})

$("#modalNuevo").on('shown.bs.modal', function () {
    document.getElementById("nombreCaja").focus();
});

$("#formGuardarCaja").submit(function (e) {
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

$("#formEliminarCaja").submit(function (e) {
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