<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Compras</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-3">
                            <label>Desde</label>
                            <input type="date" id="desde" class="form-control" value="<?= date('Y-m-01'); ?>">
                        </div>
                        <div class="col-3">
                            <label>Hasta</label>
                            <input type="date" id="hasta" class="form-control" value="<?= date('Y-m-t'); ?>">
                        </div>
                        <div class="col-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success form-control" onclick="listar()">Listar</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaCompras" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Fecha</th>
                                            <th class="col-2">Comprobante</th>
                                            <th class="col-4">Proveedor</th>
                                            <th class="col-2">Monto</th>
                                            <th class="col-2">Operaciones</th>
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

<!--Modal Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmar anulacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Compras/anular" method="post">
                <input type="hidden" id="idEliminar" name="idEliminar">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Anular</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function listar() {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        if (desde.length > 2 & hasta.length > 2) {
            var tabla = $('#tablaCompras tbody');
            $.ajax({
                url: '<?= base_url(); ?>/Compras/listadoJSON',
                method: 'post',
                data: {
                    desde,
                    hasta
                },
                dataType: 'json',
                success: (res) => {
                    for (var i = 0; i < res.compras.length; i++) {
                        var btn = '<a target="_blank" href="<?= base_url(); ?>/Compras/comprobante/' + res.compras[i]['idCompra'] + '" class="btn btn-info" title="Ver comprobante"><i class="fa fa-search"></i></a><a href="#" class="btn btn-danger" title="Anular" data-toggle="modal" data-target="#modalEliminar" data-id="' + res.compras[i]['idCompra'] + '"><i class="fa fa-trash"></i></a>';
                        var insertar = '<tr><td>' + res.compras[i]['fech'] + '</td><td>' + res.compras[i]['nroComprobante'] + '</td><td>' + res.compras[i]['razonSocial'] + '</td><td class="text-right">' + new Intl.NumberFormat("de-DE").format(res.compras[i]['total']) + '</td><td>' + btn + '</td></tr>';
                        tabla.html(tabla.html() + insertar);
                    }
                }
            })
        } else {
            alert('Ingrese rango de fecha');
        }
    }

    $('#modalEliminar').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $('#idEliminar').val(id);
    })
</script>