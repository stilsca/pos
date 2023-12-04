<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cierre de caja </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-3">
                                    <label>Fecha apertura</label>
                                    <input type="text" value="<?= $apertura['fechaApertura']; ?>" class="form-control" readonly>
                                </div>
                                <div class="col-3">
                                    <label>Monto apertura</label>
                                    <input type="text" value="<?= $apertura['montoApertura']; ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-3">
                                    <label>Caja</label>
                                    <input type="text" value="<?= $apertura['nombreCaja']; ?>" class="form-control" readonly>
                                </div>
                                <div class="col-3">
                                    <label>Usuario</label>
                                    <input type="text" value="<?= $apertura['user']; ?>" class="form-control" readonly>
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
                                <div class="col-2">
                                    <label>Total ventas</label>
                                    <input type="text" value="<?= number_format($ventasTotal, 0, '', '.'); ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-2">
                                    <label>Total compras</label>
                                    <input type="text" value="<?= number_format($comprasTotal, 0, '', '.'); ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-2">
                                    <label>Ventas contado</label>
                                    <input type="text" value="<?= number_format($ventasContado, 0, '', '.'); ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-2">
                                    <label>Compras contado</label>
                                    <input type="text" value="<?= number_format($comprasContado, 0, '', '.'); ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-2">
                                    <label>Monto a rendir</label>
                                    <input type="text" value="<?= number_format($apertura['montoApertura'] + $ventasTotal - $comprasTotal, 0, '', '.'); ?>" class="form-control text-right" readonly>
                                </div>
                                <div class="col-2">
                                    <label>&nbsp;</label>
                                    <form method="post" action="<?= base_url(); ?>/Cajas/cerrarCaja">
                                        <input type="hidden" name="idApertura" value="<?= $apertura['idApertura']; ?>">
                                        <input type="hidden" name="montoCierre" value="<?= $apertura['montoApertura'] + $ventasTotal - $comprasTotal; ?>">
                                        <button type="submit" class="btn btn-warning form-control">Cerrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>