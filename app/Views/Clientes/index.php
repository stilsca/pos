<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Clientes &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="true" class="btn btn-success" title="Nuevo"><i class="fa fa-plus"></i></a></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaClientes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Documento</th>
                                            <th class="col-8">Razon social</th>
                                            <th class="col-2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($clientes as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['documento'] . '</td>';
                                            echo '<td>' . $row['razonSocial'] . '</td>';
                                            echo '<td><a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="false" data-id="' . $row['idCliente'] . '" data-nombre="' . $row['razonSocial'] . '" data-documento="' . $row['documento'] . '" data-direccion="' . $row['direccion'] . '" data-celular="' . $row['celular'] . '" data-email="' . $row['email'] . '" data-memo="' . $row['memo'] . '" title="Editar" class="btn btn-warning"><i class="fa fa-pencil"></i></a><a href="#" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="' . $row['idCliente'] . '" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
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
            <form action="<?php echo base_url(); ?>/Clientes/eliminar" method="post" id="formEliminarCliente">
                <input type="hidden" id="idEliminar" name="idEliminar">

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible mt-3 d-none" role="alert" id="alertaEliminar">
                        Cliente en uso. No es posible eliminar
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
                <h4 class="modal-title" id="tituloModalNuevo">Nuevo cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Clientes/guardar" method="post" id="formGuardarCliente">
                <div class="modal-body">
                    <label>Documento</label>
                    <input type="text" name="documento" id="documento" class="form-control">
                    <input type="hidden" id="idCliente" name="idCliente" value="0">
                    <label class="mt-2">Razon social</label>
                    <input type="text" name="razonSocial" required id="razonSocial" class="form-control">
                    <label class="mt-2">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control">
                    <label class="mt-2">Celular</label>
                    <input type="tel" name="celular" id="celular" class="form-control">
                    <label class="mt-2">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                    <label class="mt-2">Memo</label>
                    <input type="text" name="memo" id="memo" class="form-control">
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

<script src="<?= base_url(); ?>/js/clientes/clientes.js"></script>