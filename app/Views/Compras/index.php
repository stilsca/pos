<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Compra</h2>
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
                                    <input type="text" id="timbrado" class="form-control">
                                </div>
                                <div class="col-12 col-md-2 mt-3">
                                    <label>Comprobante</label>
                                    <input type="text" id="comprobante" class="form-control">
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
                                    <label>Proveedor</label>
                                    <select class="form-control" id="idProveedor" name="idProveedor">
                                        <?php
                                        foreach ($proveedores as $row) {
                                            echo '<option value="' . $row['idProveedor'] . '">' . $row['documento'] . ' - ' . $row['razonSocial'] . '</option>';
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
                                    <label>Costo unitario</label>
                                    <input type="text" class="form-control miles" id="precio">
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
                            <button class="btn btn-success form-control" onclick="comprar()">Comprar</button>
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
                                            <th class="col-3">Costo unitario</th>
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


<script>
    $(document).ready(function() {
        $('#idProveedor').select2();
        $('#idProducto').select2();
    });

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
            $('#precio').focus();
        }
    });

    $('#precio').keypress(function(e) {
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
                        document.getElementById("cantidad").value = 1;
                        document.getElementById("cantidad").focus();
                        document.getElementById("cantidad").select();
                    }
                }
            });
        }
    });

    function comprar() {

        if (contador <= 0) {
            alert('No hay items en la compra');
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
            idProveedor: $('#idProveedor').val(),
            idCondicion: $('#idCondicion').val(),
            comprobante: $('#comprobante').val(),
            timbrado: $('#timbrado').val(),
            productos,
        }

        $.ajax({
            url: '<?= base_url(); ?>/Compras/comprar',
            method: 'post',
            data: datos,
            dataType: 'json',
            success: (res) => {
                if (res.exito) {
                    location.href = "<?= base_url(); ?>/Compras/comprobante/" + res.idCompra;
                } else {
                    alert('Error al procesar compra');
                }
            }
        });
    }
</script>