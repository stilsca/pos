<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Productos &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="true" class="btn btn-success" title="Nuevo"><i class="fa fa-plus"></i></a></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaProductos" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Codigo barra</th>
                                            <th class="col-4">Nombre producto</th>
                                            <th class="col-2">Precio</th>
                                            <th class="col-2">Estado</th>
                                            <th class="col-2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($productos as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['codigoBarra'] . '</td>';
                                            echo '<td>' . $row['nombreProducto'] . '</td>';
                                            echo '<td class="text-right">' . number_format($row['precio'],0,'','.') . '</td>';
                                            echo '<td>' . ($row['activo'] == 1 ? 'Activo' : 'Inactivo') . '</td>';
                                            echo '<td><a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="false" data-id="' . $row['idProducto'] . '" data-nombre="' . $row['nombreProducto'] . '" data-activo="' . $row['activo'] . '" data-marca="' . $row['idMarca'] . '" data-grupo="' . $row['idGrupo'] . '" data-precio="' . $row['precio'] . '" data-codigo="' . $row['codigoBarra'] . '" data-tipo="' . $row['idTipo'] . '" data-impuesto="' . $row['idImpuesto'] . '" title="Editar" class="btn btn-warning"><i class="fa fa-pencil"></i></a><a href="#" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="' . $row['idProducto'] . '" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
                                            echo '</tr>';
                                        }
                                        ?>
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
                <h4 class="modal-title">Confirmar eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Productos/eliminar" method="post" id="formEliminarProducto">
                <input type="hidden" id="idEliminar" name="idEliminar">

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible mt-3 d-none" role="alert" id="alertaEliminar">
                        Producto en uso. No es posible eliminar
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Nuevo -->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModalNuevo">Nuevo producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Productos/guardar" method="post" id="formGuardarProducto">
                <div class="modal-body">
                    <label>Codigo producto</label>
                    <input type="text" name="codigoBarra" id="codigoBarra" class="form-control">
                    <input type="hidden" id="idProducto" name="idProducto" value="0">
                    <label class="mt-2">Nombre producto</label>
                    <input type="text" name="nombreProducto" required id="nombreProducto" class="form-control">
                    <label class="mt-2">Precio</label>
                    <input type="text" name="precio" required id="precio" class="form-control miles">
                    <label class="mt-2">Tipo producto</label>
                    <select class="form-control" name="idTipo" id="idTipo" required>
                        <?php
                        foreach ($tipos as $row) {
                            echo '<option value="' . $row['idTipo'] . '">' . $row['nombreTipo'] . '</option>';
                        }
                        ?>
                    </select>
                    <label class="mt-2">Marca</label>
                    <select class="form-control" name="idMarca" id="idMarca" required>
                        <?php
                        foreach ($marcas as $row) {
                            echo '<option value="' . $row['idMarca'] . '">' . $row['nombreMarca'] . '</option>';
                        }
                        ?>
                    </select>
                    <label class="mt-2">Grupo</label>
                    <select class="form-control" name="idGrupo" id="idGrupo" required>
                        <?php
                        foreach ($grupos as $row) {
                            echo '<option value="' . $row['idGrupo'] . '">' . $row['nombreGrupo'] . '</option>';
                        }
                        ?>
                    </select>
                    <label class="mt-2">Impuesto</label>
                    <select class="form-control" name="idImpuesto" id="idImpuesto" required>
                        <?php
                        foreach ($impuestos as $row) {
                            echo '<option value="' . $row['idImpuesto'] . '">' . $row['nombreImpuesto'] . '</option>';
                        }
                        ?>
                    </select>
                    <div class="mt-4">
                        <label>
                            <input type="checkbox" name="activo" value="S" id="activo" class="js-switch" checked /> Activo
                        </label>
                    </div>
                    <div class="alert alert-danger alert-dismissible mt-3 d-none" role="alert" id="alertaGuardar">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>/js/productos/productos.js"></script>