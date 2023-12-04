$(document).ready(function () {
    $('#tablaUsuarios').DataTable({
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
        document.getElementById("tituloModalNuevo").innerHTML = 'Nuevo usuario';
        document.getElementById("idUsuario").value = 0;
        document.getElementById("user").value = '';
        document.getElementById("pass").value = '';
        document.getElementById("pass2").value = '';

        var inputElement = document.getElementById('user');
        inputElement.readOnly = false;
    } else {
        document.getElementById("tituloModalNuevo").innerHTML = 'Editar usuario';
        var id = button.data('id');
        document.getElementById("idUsuario").value = id;
        document.getElementById("user").value = button.data('nombre');
        document.getElementById("pass").value = '';
        document.getElementById("pass2").value = '';
        $('#idPerfil').val(button.data('perfil')).change();

        var inputElement = document.getElementById('user');
        inputElement.readOnly = true;
    }
})

$("#modalNuevo").on('shown.bs.modal', function () {
    document.getElementById("user").focus();
});

$("#formGuardarUsuario").submit(function (e) {
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

$("#formEliminarUsuario").submit(function (e) {
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