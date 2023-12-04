<!-- footer content -->

<div class="modal fade" id="modalAbrirCaja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apertura de caja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>/Cajas/abrir" method="post" id="formAbrirCaja">
                <div class="modal-body">
                    <label>Caja</label>
                    <select class="form-control" name="idCaja" required>
                        <?php $cajas = db_connect()->table('cajas')->get()->getResultArray();
                        foreach ($cajas as $row) {
                            echo '<option value="' . $row['idCaja'] . '">' . $row['nombreCaja'] . '</option>';
                        }
                        ?>
                    </select>
                    <label class="mt-3">Monto apertura</label>
                    <input type="number" value="0" class="form-control" required name="montoApertura">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#formAbrirCaja").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.exito) {
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(jqXHR);
                console.error(textStatus);
                console.error(errorThrown);
            }
        });
    });
</script>
<footer>
    <div class="pull-right">
        <a href="https://tajysoftware.com">LP3 2023</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>


<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo base_url(); ?>/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="<?php echo base_url(); ?>/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo base_url(); ?>/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo base_url(); ?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="<?php echo base_url(); ?>/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="<?php echo base_url(); ?>/vendors/Flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>/vendors/Flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>/vendors/Flot/jquery.flot.time.js"></script>
<script src="<?php echo base_url(); ?>/vendors/Flot/jquery.flot.stack.js"></script>
<script src="<?php echo base_url(); ?>/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="<?php echo base_url(); ?>/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?php echo base_url(); ?>/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="<?php echo base_url(); ?>/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?php echo base_url(); ?>/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?php echo base_url(); ?>/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url(); ?>/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Switchery -->
<script src="<?php echo base_url(); ?>/vendors/switchery/dist/switchery.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo base_url(); ?>/build/js/custom.min.js"></script>

<!-- Datatables -->
<script src="<?php echo base_url(); ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/jszip/dist/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>/vendors/pdfmake/build/vfs_fonts.js"></script>

<script>
    const elementos = document.getElementsByClassName('miles');
    for (var i = 0; i < elementos.length; i++) {
        new AutoNumeric('#' + elementos[i].id, {
            decimalPlaces: 0,
            digitGroupSeparator: '.',
            decimalCharacter: ','
        });
    }
    const elementosComa = document.getElementsByClassName('milesConDecimal');
    for (var i = 0; i < elementosComa.length; i++) {
        new AutoNumeric('#' + elementosComa[i].id, {
            decimalPlaces: 4,
            digitGroupSeparator: '.',
            decimalCharacter: ','
        });
    }
</script>

</body>

</html>