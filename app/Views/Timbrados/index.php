<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Timbrados &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="true" class="btn btn-success" title="Nuevo"><i class="fa fa-plus"></i></a></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaTimbrados" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Nro timbrado</th>
                                            <th class="col-2">Regimen</th>
                                            <th class="col-2">Inicio</th>
                                            <th class="col-2">Fin</th>
                                            <th class="col-2">Estado</th>
                                            <th class="col-2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($timbrados as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['nroTimbrado'] . '</td>';
                                            echo '<td>' . $row['regimen'] . '</td>';
                                            echo '<td class="text-right">' . date("d/m/Y",strtotime($row['vigenciaInicio'])) . '</td>';
                                            echo '<td class="text-right">' . date("d/m/Y",strtotime($row['vigenciaFin'])) . '</td>';
                                            echo '<td>' . ($row['activo'] == 1 ? 'Activo' : 'Inactivo') . '</td>';
                                            echo '<td><a href="#" data-toggle="modal" data-target="#modalNuevo" data-nuevo="false" data-id="' . $row['idTimbrado'] . '" data-timbrado="' . $row['nroTimbrado'] . '" data-activo="' . $row['activo'] . '" data-regimen="' . $row['regimen'] . '" data-vigenciainicio="' . $row['vigenciaInicio'] . '" data-vigenciafin="' . $row['vigenciaFin'] . '" data-inicio="' . $row['inicio'] . '" data-fin="' . $row['fin'] . '" title="Editar" class="btn btn-warning"><i class="fa fa-pencil"></i></a><a href="#" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="' . $row['idTimbrado'] . '" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
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
            <form action="<?php echo base_url(); ?>/Timbrados/eliminar" method="post" id="formEliminarTimbrado">
                <input type="hidden" id="idEliminar" name="idEliminar">

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible mt-3 d-none" role="alert" id="alertaEliminar">
                        Timbrado en uso. No es posible eliminar
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
                <h4 class="modal-title" id="tituloModalNuevo">Nuevo timbrado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Timbrados/guardar" method="post" id="formGuardarTimbrado">
                <div class="modal-body">
                    <label>Nro timbrado</label>
                    <input type="number" required name="nroTimbrado" id="nroTimbrado" class="form-control">
                    <input type="hidden" id="idTimbrado" name="idTimbrado" value="0">
                    <label class="mt-2">Régimen</label>
                    <input type="text" name="regimen" required id="regimen" class="form-control">
                    <label class="mt-2">Vigencia inicio</label>
                    <input type="date" name="vigenciaInicio" required id="vigenciaInicio" class="form-control">
                    <label class="mt-2">Vigencia fin</label>
                    <input type="date" name="vigenciaFin" required id="vigenciaFin" class="form-control">
                    <label class="mt-2">Inicio numeración</label>
                    <input type="number" name="inicio" min="1" required id="inicio" class="form-control">
                    <label class="mt-2">Fin numeración</label>
                    <input type="number" name="fin" min="1" required id="fin" class="form-control">
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

<script src="<?= base_url(); ?>/js/timbrados/timbrados.js"></script>