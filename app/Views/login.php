<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LP3 - POS</title>

    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url(); ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url(); ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= base_url(); ?>/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url(); ?>/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="post" action="<?= base_url(); ?>/Usuarios/validar" autocomplete="off" id="formLogin">
                        <h1>Iniciar sesion</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Usuario" required name="usuario" autofocus />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" required name="password" />
                        </div>
                        <div class="alert alert-danger alert-dismissible d-none" role="alert" id="alertaLogin">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Error!</strong> Datos no validos.
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success" href="index.html">Ingresar</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">

                            <div class="clearfix"></div>
                            <br />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="<?= base_url(); ?>/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/js/login/login.js"></script>

    <script src="<?= base_url(); ?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url(); ?>/vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?= base_url(); ?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url(); ?>/vendors/iCheck/icheck.min.js"></script>
    <!-- PNotify -->
    <script src="<?= base_url(); ?>/vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?= base_url(); ?>/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?= base_url(); ?>/vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>/build/js/custom.min.js"></script>
</body>

</html>