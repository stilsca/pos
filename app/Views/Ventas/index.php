<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Venta</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Fecha</label>
                                    <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control" readonly>
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Timbrado</label>
                                    <select class="form-control" id="idTimbrado" name="idTimbrado">
                                        <?php
                                        foreach ($timbrados as $row) {
                                            echo '<option value="' . $row['idTimbrado'] . '">' . $row['nroTimbrado'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Condición venta</label>
                                    <select class="form-control" id="idCondicion" name="idCondicion">
                                        <?php
                                        foreach ($condiciones as $row) {
                                            echo '<option value="' . $row['idCondicion'] . '">' . $row['nombreCondicion'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label>Cliente</label>
                                    <select class="form-control" id="idCliente" name="idCliente">
                                        <?php
                                        foreach ($clientes as $row) {
                                            echo '<option value="' . $row['idCliente'] . '">' . $row['documento'] . ' - ' . $row['razonSocial'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Codigo</label>
                                    <input type="text" class="form-control" autofocus id="txtCodigo">
                                </div>
                                <div class="col-12 col-md-4 mt-3">
                                    <label>Producto</label>
                                    <select class="form-control" id="idProducto" name="idProducto">
                                        <option value="0">Seleccionar producto</option>
                                        <?php
                                        foreach ($productos as $row) {
                                            echo '<option value="' . $row['idProducto'] . '">' . $row['nombreProducto'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad">
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Precio unitario</label>
                                    <input type="text" class="form-control miles" id="precio" <?= ($descuento ? '' : 'readonly'); ?>>
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-info form-control" onclick="agregar()">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-10">
                            <h3>Total: <span id="txtTotal"></span> Gs.</h3>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success form-control" onclick="vender()">Vender</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaProductos" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Cantidad</th>
                                            <th class="col-4">Producto</th>
                                            <th class="col-3">Precio unitario</th>
                                            <th class="col-3">Sub total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>/js/ventas/ventas.js"></script>
<script>
    $('#txtCodigo').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            buscarProductoPorCodigo($('#txtCodigo').val());
        }
    });

    $('#cantidad').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            agregar();
        }
    });

    var total = 0;
    var contador = 0;

    function agregar() {
        var tabla = $('#tablaProductos tbody');
        var idProducto = document.getElementById("idProducto").value;
        var cantidad = document.getElementById("cantidad").value;
        var precioUni = document.getElementById("precio").value.replaceAll(".", "");
        if (idProducto > 0 & cantidad > 0) {
            var selectElement = document.getElementById('idProducto');
            var nombreProducto = selectElement.options[selectElement.selectedIndex].text;
            var sub = (precioUni * cantidad);
            total += sub;
            contador++;
            var insertar = '<tr><td> <button title="Eliminar item" class="btn btn-light" onclick="borrar(this)">X</button> ' + cantidad + '<input type="hidden" value="' + cantidad + '"></td><td><input type="hidden" value="' + idProducto + '">' + nombreProducto + '</td><td class="text-end">' + precioUni + '<input type="hidden" value="' + precioUni + '"></td><td class="text-end">' + sub + '</td></tr>';
            tabla.html(tabla.html() + insertar);
            $('#idProducto').val(0).change();
            $('#cantidad').val(1);
            $('#txtCodigo').val('');
            $('#txtCodigo').focus();
            const element = AutoNumeric.getAutoNumericElement('#precio');
            element.set(0);
            $('#txtTotal').html(new Intl.NumberFormat("de-DE").format(total));
        } else {
            alert('Datos no validos');
        }
    }

    function borrar(btn) {
        var row = btn.parentNode.parentNode;
        var sub = row.getElementsByTagName('td')[3];
        sub = sub.innerHTML;
        total -= parseFloat(sub);
        contador--;
        $('#txtTotal').html(new Intl.NumberFormat("de-DE").format(total));
        row.parentNode.removeChild(row);
    }

    function buscarProductoPorCodigo(codigo) {
        $.ajax({
            url: '<?= base_url(); ?>/Ventas/buscarPorCodigo/' + codigo,
            dataType: 'json',
            success: (res) => {
                if (res.exito) {
                    $('#idProducto').val(res.producto.idProducto);
                    $('#idProducto').change();
                    const element = AutoNumeric.getAutoNumericElement('#precio');
                    element.set(res.producto.precio);
                    document.getElementById("cantidad").value = 1;
                    document.getElementById("cantidad").focus();
                    document.getElementById("cantidad").select();
                } else {
                    alert('No existe');
                }
            }
        })
    }

    $("#idProducto").change(function() {
        if ($("#idProducto").val() != 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>/Ventas/buscarProductoPorId/' + $('#idProducto').val(),
                dataType: 'json',
                success: function(resultado) {
                    if (resultado.producto != 'null') {
                        document.getElementById("txtCodigo").value = resultado.producto.codigoBarra;
                        const element = AutoNumeric.getAutoNumericElement('#precio')
                        element.set(resultado.producto.precio);
                        document.getElementById("cantidad").value = 1;
                        document.getElementById("cantidad").focus();
                        document.getElementById("cantidad").select();
                    }
                }
            });
        }
    });

    function vender() {

        if (contador <= 0) {
            alert('No hay items en la venta');
            return;
        }
        var tabla = document.getElementById("tablaProductos");
        var filas = tabla.getElementsByTagName("tr");
        let productos = [];
        for (var i = 0; i < filas.length; i++) {
            if (i != 0) {
                var cantidad = filas[i].getElementsByTagName('input')[0].value;
                var idProducto = filas[i].getElementsByTagName('input')[1].value;
                var pUnitario = filas[i].getElementsByTagName('input')[2].value;
                var pro = {
                    cantidad,
                    idProducto,
                    pUnitario
                };
                productos.push(pro);
            }
        }
        let datos = {
            idCliente: $('#idCliente').val(),
            idCondicion: $('#idCondicion').val(),
            idTimbrado: $('#idTimbrado').val(),
            productos,
        }

        $.ajax({
            url: '<?= base_url(); ?>/Ventas/vender',
            method: 'post',
            data: datos,
            dataType: 'json',
            success: (res) => {
                if (res.exito) {
                    location.href = "<?= base_url(); ?>/Ventas/comprobante/" + res.idVenta;
                } else {
                    alert('Error al procesar venta');
                }
            }
        });
    }
</script>