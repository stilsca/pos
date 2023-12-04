<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use App\Models\ProductosModel;
use App\Models\TimbradosModel;
use App\Models\VentasDetModel;
use App\Models\VentasModel;
use App\Models\UsuariosModel;

class Ventas extends BaseController
{
    private $session, $m_ventas, $m_ventasDet;

    public function __construct()
    {
        $this->session = session();
        $this->m_ventas = new VentasModel();
        $this->m_ventasDet = new VentasDetModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {
            if ($this->session->idApertura != 0) {
                echo view('header');

                $db = db_connect();

                $m_timbrados = new TimbradosModel();
                $timbrados = $m_timbrados->where('activo', 1)->findAll();

                $m_clientes = new ClientesModel();
                $clientes = $m_clientes->findAll();

                $condiciones = $db->table('condicion')->get()->getResultArray();

                $descuento = UsuariosModel::permiso($this->session->idUsuario, '0x13');

                $m_productos = new ProductosModel();
                $productos = $m_productos->where('activo', 1)->findAll();

                echo view('Ventas/index', ['timbrados' => $timbrados, 'clientes' => $clientes, 'condiciones' => $condiciones, 'productos' => $productos, 'descuento' => $descuento]);
                echo view('footer');
            } else {
                echo view('header');
                echo view('mensaje', ['tipo' => 'Caja sin apertura', 'msg' => 'No hay caja abierta   <a href="#" data-toggle="modal" data-target="#modalAbrirCaja" class="btn btn-info">Abrir caja</a>']);
                echo view('footer');
            }
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }


    public function buscarPorCodigo($cod)
    {
        $m_producto = new ProductosModel();
        $producto = $m_producto->where("codigoBarra", $cod)->where('activo', 1)->first();
        if ($producto != null) {
            echo json_encode(['exito' => true, 'producto' => $producto]);
            exit;
        }
        echo json_encode(['exito' => false]);
        exit;
    }

    public function buscarProductoPorId($id)
    {
        $m_producto = new ProductosModel();
        $producto = $m_producto->where("idProducto", $id)->where('activo', 1)->first();
        if ($producto != null) {
            echo json_encode(['exito' => true, 'producto' => $producto]);
            exit;
        }
        echo json_encode(['exito' => false]);
        exit;
    }

    public function vender()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false, 'msg' => 'Sesion expirada']);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {

            $idCliente = $this->request->getPost('idCliente');
            $idCondicion = $this->request->getPost('idCondicion');
            $idTimbrado = $this->request->getPost('idTimbrado');
            $productos = $this->request->getPost('productos');
            $db = db_connect();

            $idApci = $this->session->idApertura;

            $num = $db->query("SELECT COALESCE(MAX(nroComprobante)+1,1) numero FROM ventas WHERE idTimbrado=$idTimbrado")->getResultArray()[0]['numero'];

            $m_ventas = new VentasModel();
            $m_ventas->save([
                'idTimbrado' => $idTimbrado,
                'idCondicion' => $idCondicion,
                'idCliente' => $idCliente,
                'fecha' => date('Y-m-d'),
                'idApertura' => $idApci,
                'nroComprobante' => $num
            ]);
            $idVenta = $m_ventas->getInsertID();
            $m_ventas_det = new VentasDetModel();
            $m_productos = new ProductosModel();
            foreach ($productos as $row) {
                $pro = $m_productos->join('impuestos', 'impuestos.idImpuesto=productos.idImpuesto')->where('idProducto', $row['idProducto'])->first();
                $m_ventas_det->save([
                    'idVenta' => $idVenta,
                    'idProducto' => $row['idProducto'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['pUnitario'],
                    'impuesto' => $pro['porcentaje']
                ]);
            }

            echo json_encode(['exito' => true, 'idVenta' => $idVenta]);
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Usuario sin permiso']);
            exit;
        }
    }

    public function comprobante($idVenta)
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {
            echo view('header');
            echo view('verPdf', ['ruta' => base_url() . '/Ventas/comprobantePDF/' . $idVenta]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function comprobantePDF($idVenta)
    {

        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {
            $db = db_connect();

            $venta = $db->query("SELECT DATE_FORMAT(fecha,'%d/%m/%Y') fech,nroComprobante,nroTimbrado,regimen,nombreCondicion,razonSocial,documento FROM ventas v
        INNER JOIN timbrados t ON t.idTimbrado=v.idTimbrado
        INNER JOIN condicion c ON c.idCondicion=v.idCondicion
        INNER JOIN clientes cl ON cl.idCliente=v.idCliente
        WHERE idVenta=$idVenta")->getResultArray()[0];

            $pdf = new \FPDF('P', 'mm', 'A4');
            $pdf->SetMargins(10, 10);
            $pdf->AddPage();
            $pdf->SetTitle("Comprobante");
            $pdf->Image(base_url() . '/images/logo.png', 10, 5, 50, 40);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Text(130, 18, 'COMPROBANTE DE VENTA');
            $pdf->Text(130, 23, mb_convert_encoding('Número: ' . $venta['nroComprobante'], 'ISO-8859-1', 'UTF-8'));

            $pdf->SetXY(10, 47);
            $pdf->Cell(15, 5, 'Fecha: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, $venta['fech'], 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 5, mb_convert_encoding('Condición: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($venta['nombreCondicion'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(15, 5, 'Cliente: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($venta['razonSocial'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(24, 5, 'Documento: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($venta['documento'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');



            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, mb_convert_encoding('Cantidad', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(70, 5, mb_convert_encoding('Producto', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('P. Unitario', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Exenta', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Gravada 5%', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Gravada 10%', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

            $det = $db->query("SELECT cantidad,nombreProducto,vd.precio,impuesto,cantidad*vd.precio sub FROM ventas_det vd
        INNER JOIN productos pr ON pr.idProducto=vd.idProducto WHERE idVenta=$idVenta")->getResultArray();

            $sum0 = 0;
            $sum5 = 0;
            $sum10 = 0;
            $contador = 0;
            $pdf->SetFont('Arial', '', 8);
            foreach ($det as $row) {
                $pdf->Cell(20, 5, mb_convert_encoding($row['cantidad'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                $pdf->Cell(70, 5, mb_convert_encoding($row['nombreProducto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
                $pdf->Cell(25, 5, mb_convert_encoding(number_format($row['precio'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                if ($row['impuesto'] == 0) {
                    $pdf->Cell(25, 5, mb_convert_encoding(number_format($row['sub'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 1, 'R');
                    $sum0 += $row['sub'];
                } else if ($row['impuesto'] == 5) {
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(number_format($row['sub'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 1, 'R');
                    $sum5 += $row['sub'];
                } else {
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(0, 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                    $pdf->Cell(25, 5, mb_convert_encoding(number_format($row['sub'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 1, 'R');
                    $sum10 += $row['sub'];
                }
                $contador++;
            }

            while ($contador < 10) {
                $pdf->Cell(20, 5, '', 1, 0, 'C');
                $pdf->Cell(70, 5, '', 1, 0, 'L');
                $pdf->Cell(25, 5, '', 1, 0, 'R');
                $pdf->Cell(25, 5, '', 1, 0, 'R');
                $pdf->Cell(25, 5, '', 1, 0, 'R');
                $pdf->Cell(25, 5, '', 1, 1, 'R');
                $contador++;
            }

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(115, 5, mb_convert_encoding('SUB TOTALES', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
            $pdf->Cell(25, 5, mb_convert_encoding(number_format($sum0, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
            $pdf->Cell(25, 5, mb_convert_encoding(number_format($sum5, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
            $pdf->Cell(25, 5, mb_convert_encoding(number_format($sum10, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 1, 'R');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(165, 7, mb_convert_encoding('TOTAL', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
            $pdf->Cell(25, 7, mb_convert_encoding(number_format($sum0 + $sum5 + $sum10, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');

            $pdf->ln();
            $pdf->SetFont('Arial', '', 7);

            $iva5 = round($sum5 / 21);
            $iva10 = round($sum10 / 11);

            $pdf->Cell(40, 7, mb_convert_encoding('IVA 5%: ' . number_format($iva5, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->Cell(40, 7, mb_convert_encoding('IVA 10%: ' . number_format($iva10, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->Cell(40, 7, mb_convert_encoding('TOTAL IVA: ' . number_format($iva10 + $iva5, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf->Output("Informe.pdf", "I");
        }
    }

    public function listado()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {
            echo view('header');
            echo view('Ventas/listado');
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function listadoJSON()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['ventas' => null]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x11')) {
            $desde = $this->request->getPost('desde');
            $hasta = $this->request->getPost('hasta');

            $db = db_connect();
            $ventas = $db->query("SELECT v.idVenta,DATE_FORMAT(fecha,'%d/%m/%Y') fech,razonSocial,nroTimbrado,regimen,nroComprobante,SUM(cantidad*precio) total FROM ventas v
        INNER JOIN ventas_det vd ON v.idVenta=vd.idVenta
        INNER JOIN clientes cl ON cl.idCliente=v.idCliente
        INNER JOIN timbrados tim ON tim.idTimbrado=v.idTimbrado
        WHERE (fecha BETWEEN '$desde' AND '$hasta') AND anulado=0
        GROUP BY 1,2,3,4,5,6")->getResultArray();
            echo json_encode(['ventas' => $ventas]);
        } else {
            echo json_encode(['ventas' => null]);
            exit;
        }
    }

    public function anular()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['ventas' => null]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x14')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $this->m_ventas->update($idEliminar, [
                'anulado' => 1
            ]);
            return redirect()->to(base_url() . '/Ventas/listado');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }
}
