<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Arqueos y cierres</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="tablaCaja" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="col-3">Fecha</th>
                                            <th class="col-4">Usuario</th>
                                            <th class="col-3">Estado</th>
                                            <th class="col-2">Operaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($cajas as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['fecAper'] . '</td>';
                                            echo '<td>' . $row['user'] . '</td>';
                                            echo '<td>' . $row['estado'] . '</td>';
                                            $btn = '<a target="_blank" href="' . base_url() . '/Cajas/verInforme/' . $row['idApertura'] . '" title="Ver" class="btn btn-info"><i class="fa fa-search"></i></a>';
                                            if ($row['estado'] == 'Abierta') {
                                                $btn .= '<a href="' . base_url() . '/Cajas/cerrar/' . $row['idApertura'] . '" title="Cerrar caja" class="btn btn-warning"><i class="fa fa-lock"></i></a>';
                                            }
                                            echo '<td>' . $btn . '</td>';
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