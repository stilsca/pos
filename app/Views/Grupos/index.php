<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Grupos &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="true" class="btn btn-success" title="Nuevo"><i class="fa fa-plus"></i></a></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaGrupos" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-8">Nombre grupo</th>
                                            <th class="col-2">Estado</th>
                                            <th class="col-2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($grupos as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['nombreGrupo'] . '</td>';
                                            echo '<td>' . ($row['activo'] == 1 ? 'Activo' : 'Inactivo') . '</td>';
                                            echo '<td><a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="false" data-id="' . $row['idGrupo'] . '" data-nombre="' . $row['nombreGrupo'] . '" data-activo="' . $row['activo'] . '" title="Editar" class="btn btn-warning"><i class="fa fa-pencil"></i></a><a href="#" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="' . $row['idGrupo'] . '" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
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
            <form action="<?php echo base_url(); ?>/Grupos/eliminar" method="post" id="formEliminarGrupo">
                <input type="hidden" id="idEliminar" name="idEliminar">

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible mt-3 d-none" role="alert" id="alertaEliminar">
                        Grupo en uso. No es posible eliminar
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModalNuevo">Nuevo grupo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Grupos/guardar" method="post" id="formGuardarGrupo">
                <div class="modal-body">
                    <label>Nombre grupo</label>
                    <input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control" required>
                    <input type="hidden" id="idGrupo" name="idGrupo" value="0">
                    <div class="mt-2">
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

<script src="<?= base_url(); ?>/js/Grupos/grupos.js"></script>