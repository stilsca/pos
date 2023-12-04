<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Permisos del perfil - <?= $perfil['nombrePerfil']; ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="<?= base_url(); ?>/Perfiles/guardarPermisos" method="post">
                                <input type="hidden" value="<?= $perfil['idPerfil']; ?>" name="idPerfil">
                                <div class="card-box table-responsive">
                                    <table id="tablaUsuarios" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="col-5">Permiso</th>
                                                <th class="col-2">Acceso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($permisos as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['nombrePermiso'] . '</td>';
                                                echo '<td>
                                                <label>
                                                    <input type="checkbox" name="per-' . $row['idPermiso'] . '" value="S" id="activo" class="js-switch" ' . ($row['acceso'] > 0 ? 'checked' : '') . ' />
                                                </label>
                                            </td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row d-flex justify-content-center">
                                    <a href="<?=base_url();?>/Perfiles" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>