<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

///HOME
$routes->get('/', 'Home::index');

///MARCAS
$routes->get('Marcas', 'Marcas::index');
$routes->post('Marcas/eliminar', 'Marcas::eliminar');
$routes->post('Marcas/guardar', 'Marcas::guardar');

///GRUPOS
$routes->get('Grupos', 'Grupos::index');
$routes->post('Grupos/eliminar', 'Grupos::eliminar');
$routes->post('Grupos/guardar', 'Grupos::guardar');

///CAJAS
$routes->get('Cajas', 'Cajas::index');
$routes->get('Cajas/arqueos', 'Cajas::arqueos');
$routes->get('Cajas/cerrar/(:any)', 'Cajas::cerrar/$1');
$routes->get('Cajas/verInforme/(:any)', 'Cajas::verInforme/$1');
$routes->get('Cajas/verInformePdf/(:any)', 'Cajas::verInformePdf/$1');
$routes->post('Cajas/eliminar', 'Cajas::eliminar');
$routes->post('Cajas/guardar', 'Cajas::guardar');
$routes->post('Cajas/cerrarCaja', 'Cajas::cerrarCaja');
$routes->post('Cajas/abrir', 'Cajas::abrir');

///PRODUCTOS
$routes->get('Productos', 'Productos::index');
$routes->post('Productos/eliminar', 'Productos::eliminar');
$routes->post('Productos/guardar', 'Productos::guardar');
$routes->get('Productos/inventarioPdf', 'Productos::inventarioPdf');
$routes->get('Productos/inventario', 'Productos::inventario');

///TIMBRADOS
$routes->get('Timbrados', 'Timbrados::index');
$routes->post('Timbrados/eliminar', 'Timbrados::eliminar');
$routes->post('Timbrados/guardar', 'Timbrados::guardar');

///CLIENTES
$routes->get('Clientes', 'Clientes::index');
$routes->post('Clientes/eliminar', 'Clientes::eliminar');
$routes->post('Clientes/guardar', 'Clientes::guardar');

///PROVEEDORES
$routes->get('Proveedores', 'Proveedores::index');
$routes->post('Proveedores/eliminar', 'Proveedores::eliminar');
$routes->post('Proveedores/guardar', 'Proveedores::guardar');

///USUARIOS
$routes->post('Usuarios/validar', 'Usuarios::validar');
$routes->get('Usuarios/logout', 'Usuarios::logout');
$routes->get('Usuarios', 'Usuarios::index');
$routes->post('Usuarios/eliminar', 'Usuarios::eliminar');
$routes->post('Usuarios/guardar', 'Usuarios::guardar');

///PERFILES
$routes->get('Perfiles', 'Perfiles::index');
$routes->post('Perfiles/eliminar', 'Perfiles::eliminar');
$routes->post('Perfiles/guardar', 'Perfiles::guardar');
$routes->post('Perfiles/guardarPermisos', 'Perfiles::guardarPermisos');
$routes->get('Perfiles/permisos/(:any)', 'Perfiles::permisos/$1');

///VENTAS
$routes->get('Ventas', 'Ventas::index');
$routes->post('Ventas/vender', 'Ventas::vender');
$routes->post('Ventas/anular', 'Ventas::anular');
$routes->get('Ventas/buscarPorCodigo/(:any)', 'Ventas::buscarPorCodigo/$1');
$routes->get('Ventas/buscarProductoPorId/(:any)', 'Ventas::buscarProductoPorId/$1');
$routes->get('Ventas/comprobante/(:any)', 'Ventas::comprobante/$1');
$routes->get('Ventas/comprobantePDF/(:any)', 'Ventas::comprobantePDF/$1');
$routes->get('Ventas/listado', 'Ventas::listado');
$routes->post('Ventas/listadoJSON', 'Ventas::listadoJSON');

///COMPRAS
$routes->get('Compras', 'Compras::index');
$routes->post('Compras/comprar', 'Compras::comprar');
$routes->get('Compras/comprobante/(:any)', 'Compras::comprobante/$1');
$routes->get('Compras/comprobantePDF/(:any)', 'Compras::comprobantePDF/$1');
$routes->post('Compras/anular', 'Compras::anular');
$routes->get('Compras/listado', 'Compras::listado');
$routes->post('Compras/listadoJSON', 'Compras::listadoJSON');

