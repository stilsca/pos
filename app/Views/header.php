<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url(); ?>/images/TAJY.ico" type="image/ico" />
    <script src="<?= base_url(); ?>/vendors/jquery/dist/jquery.min.js"></script>

    <title>LP3 - POS</title>

    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url(); ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url(); ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url(); ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?= base_url(); ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= base_url(); ?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url(); ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Switchery -->
    <link href="<?= base_url(); ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url(); ?>/build/css/custom.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/css/estilos.css" rel="stylesheet">

    <!-- jQuery 
    <script src="<?= base_url(); ?>/vendors/jquery/dist/jquery.min.js"></script>-->

    <link href="<?= base_url(); ?>/css/select2.min.css" rel="stylesheet" />
    <script src="<?= base_url(); ?>/vendors/select2/select2.min.js"></script>
    <script src="<?= base_url(); ?>/vendors/autonumeric/autonumeric.js"></script>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= base_url(); ?>" class="site_title"><span>POS</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <!--<div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>-->
                        <div class="profile_info">
                            <span>Bienvenido,</span>
                            <h2><?= session()->usuario; ?></h2>
                        </div>
                    </div>
                    <br />
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">

                                <li><a><i class="fa fa-money"></i> Favoritos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url();?>/Ventas">Vender</a></li>
                                        <li><a href="<?=base_url();?>/Compras">Comprar</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-desktop"></i> Ficheros <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url();?>/Productos">Productos</a></li>
                                        <li><a href="<?=base_url();?>/Marcas">Marcas</a></li>
                                        <li><a href="<?=base_url();?>/Grupos">Grupos</a></li>
                                        <li><a href="<?=base_url();?>/Clientes">Clientes</a></li>
                                        <li><a href="<?=base_url();?>/Proveedores">Proveedores</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> Finanzas <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url();?>/Cajas">Cajas</a></li>
                                        <li><a href="<?=base_url();?>/Timbrados">Timbrados</a></li>
                                        <li><a href="<?=base_url();?>/Cajas/arqueos">Arqueos</a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-user"></i>Gerencia <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url();?>/Usuarios">Usuarios</a></li>
                                        <li><a href="<?=base_url();?>/Perfiles">Perfiles</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-file-code-o"></i>Informes <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url();?>/Ventas/listado">Ventas</a></li>
                                        <li><a href="<?=base_url();?>/Compras/listado">Compras</a></li>
                                        <li><a href="<?=base_url();?>/Productos/inventario">Inventario</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" href="<?= base_url(); ?>/Usuarios/logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <!--<img src="images/img.jpg" alt="">--><i class="fa fa-circle <?= (session()->idApertura == 0 ? 'red' : 'green'); ?>"></i>&nbsp;<?= session()->usuario; ?>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <?php
                                    if (session()->idApertura == 0) {
                                        echo '<a class="dropdown-item" data-toggle="modal" data-target="#modalApertura" href="#">Apertura caja</a>';
                                    }
                                    ?>
                                    <a class="dropdown-item" href="<?= base_url(); ?>/Usuarios/logout"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->