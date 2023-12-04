<?php

namespace App\Controllers;


use App\Models\ComprasDetModel;
use App\Models\ComprasModel;
use App\Models\ProductosModel;
use App\Models\ProveedoresModel;
use App\Models\UsuariosModel;

class Compras extends BaseController
{
    private $session, $m_compras, $m_comprasDet;

    public function __construct()
    {
        $this->session = session();
        $this->m_compras = new ComprasModel();
        $this->m_comprasDet = new ComprasDetModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return view('login');
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {
            if ($this->session->idApertura != 0) {
                echo view('header');

                $db = db_connect();

                $m_proveedores = new ProveedoresModel();
                $proveedores = $m_proveedores->findAll();

                $condiciones = $db->table('condicion')->get()->getResultArray();

                $m_productos = new ProductosModel();
                $productos = $m_productos->where('activo', 1)->findAll();

                echo view('Compras/index', ['proveedores' => $proveedores, 'condiciones' => $condiciones, 'productos' => $productos]);
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

    public function comprar()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false, 'msg' => 'Sesion expirada']);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {

            $idProveedor = $this->request->getPost('idProveedor');
            $idCondicion = $this->request->getPost('idCondicion');
            $timbrado = $this->request->getPost('timbrado');
            $comprobante = $this->request->getPost('comprobante');
            $productos = $this->request->getPost('productos');
            $idApci = $this->session->idApertura;
            $m_compras = new ComprasModel();
            $m_compras->save([
                'idCondicion' => $idCondicion,
                'idProveedor' => $idProveedor,
                'idApertura' => $idApci,
                'fecha' => date('Y-m-d'),
                'nroTimbrado' => $timbrado,
                'nroComprobante' => $comprobante
            ]);
            $idCompra = $m_compras->getInsertID();
            $m_compras_det = new ComprasDetModel();
            $m_productos = new ProductosModel();
            foreach ($productos as $row) {
                $pro = $m_productos->join('impuestos', 'impuestos.idImpuesto=productos.idImpuesto')->where('idProducto', $row['idProducto'])->first();
                $m_compras_det->save([
                    'idCompra' => $idCompra,
                    'idProducto' => $row['idProducto'],
                    'cantidad' => $row['cantidad'],
                    'costo' => $row['pUnitario'],
                    'impuesto' => $pro['porcentaje']
                ]);
            }

            echo json_encode(['exito' => true, 'idCompra' => $idCompra]);
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Usuario sin permiso']);
            exit;
        }
    }

    public function comprobante($idCompra)
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {
            echo view('header');
            echo view('verPdf', ['ruta' => base_url() . '/Compras/comprobantePDF/' . $idCompra]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function comprobantePDF($idCompra)
    {

        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {

            $db = db_connect();

            $compra = $db->query("SELECT DATE_FORMAT(fecha,'%d/%m/%Y') fech,nroComprobante,nroTimbrado,nombreCondicion,razonSocial,documento FROM compras c
        INNER JOIN condicion co ON co.idCondicion=c.idCondicion
        INNER JOIN proveedores pro ON pro.idProveedor=c.idProveedor
        WHERE idCompra=$idCompra")->getResultArray()[0];

            $pdf = new \FPDF('P', 'mm', 'A4');
            $pdf->SetMargins(10, 10);
            $pdf->AddPage();
            $pdf->SetTitle("Comprobante");
            $pdf->Image(base_url() . '/images/logo.png', 10, 5, 50, 40);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Text(130, 18, 'COMPROBANTE DE COMPRA');
            $pdf->Text(130, 23, mb_convert_encoding('Número: ' . $compra['nroComprobante'], 'ISO-8859-1', 'UTF-8'));

            $pdf->SetXY(10, 47);
            $pdf->Cell(15, 5, 'Fecha: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, $compra['fech'], 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 5, mb_convert_encoding('Condición: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($compra['nombreCondicion'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 5, 'Proveedor: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($compra['razonSocial'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(24, 5, 'Documento: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($compra['documento'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');



            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, mb_convert_encoding('Cantidad', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(70, 5, mb_convert_encoding('Producto', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('P. Unitario', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Exenta', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Gravada 5%', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Gravada 10%', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

            $det = $db->query("SELECT cantidad,nombreProducto,cd.costo,impuesto,cantidad*cd.costo sub FROM compras_det cd
        INNER JOIN productos pr ON pr.idProducto=cd.idProducto WHERE idCompra=$idCompra")->getResultArray();

            $sum0 = 0;
            $sum5 = 0;
            $sum10 = 0;
            $contador = 0;
            $pdf->SetFont('Arial', '', 8);
            foreach ($det as $row) {
                $pdf->Cell(20, 5, mb_convert_encoding($row['cantidad'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                $pdf->Cell(70, 5, mb_convert_encoding($row['nombreProducto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
                $pdf->Cell(25, 5, mb_convert_encoding(number_format($row['costo'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
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
            return view('login');
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {
            echo view('header');
            echo view('Compras/listado');
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
            echo json_encode(['compras' => null]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {
            $desde = $this->request->getPost('desde');
            $hasta = $this->request->getPost('hasta');
            $db = db_connect();
            $compras = $db->query("select c.idCompra,DATE_FORMAT(fecha,'%d/%m/%Y') fech,razonSocial,nroComprobante,SUM(cantidad*costo) total from compras c
        inner join compras_det cd on c.idCompra=cd.idCompra
        inner join proveedores pro on c.idProveedor=pro.idProveedor
        WHERE (fecha BETWEEN '$desde' AND '$hasta')
        group by 1,2,3,4")->getResultArray();
            echo json_encode(['compras' => $compras]);
        } else {
            echo json_encode(['compras' => null]);
            exit;
        }
    }

    public function anular()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x12')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $this->m_compras->delete($idEliminar);
            return redirect()->to(base_url() . '/Compras/listado');
        }
        echo view('header');
        echo view('sinPermiso');
        echo view('footer');
    }
}
