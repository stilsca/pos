<?php

namespace App\Controllers;

use App\Models\ComprasDetModel;
use App\Models\GruposModel;
use App\Models\MarcasModel;
use App\Models\ProductosModel;
use App\Models\VentasDetModel;
use App\Models\UsuariosModel;

class Productos extends BaseController
{
    private $session, $m_productos;

    public function __construct()
    {
        $this->session = session();
        $this->m_productos = new ProductosModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x3')) {
            echo view('header');
            $productos = $this->m_productos->findAll();

            $m_marcas = new MarcasModel();
            $marcas = $m_marcas->where('activo', 1)->findAll();

            $m_grupos = new GruposModel();
            $grupos = $m_grupos->where('activo', 1)->findAll();

            $tipos = db_connect()->table('productos_tipos')->get()->getResultArray();
            $impuestos = db_connect()->table('impuestos')->get()->getResultArray();

            echo view('Productos/index', ['productos' => $productos, 'marcas' => $marcas, 'grupos' => $grupos, 'tipos' => $tipos, 'impuestos' => $impuestos]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function eliminar()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x3')) {
            $idEliminar = $this->request->getPost('idEliminar');

            $m_comprasDet = new ComprasDetModel();
            $m_ventasDet = new VentasDetModel();

            $verificar = $m_comprasDet->where('idProducto', $idEliminar)->findAll();
            $verificar2 = $m_ventasDet->where('idProducto', $idEliminar)->findAll();
            if (count($verificar) > 0 | count($verificar2) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_productos->delete($idEliminar);
                echo json_encode(['exito' => true]);
                exit;
            }
        } else {
            echo json_encode(['exito' => false]);
            exit;
        }
    }

    public function guardar()
    {

        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false, 'msg' => 'Sesion expirada']);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x3')) {
            $idMarca = $this->request->getPost('idMarca');
            $idProducto = $this->request->getPost('idProducto');
            $idImpuesto = $this->request->getPost('idImpuesto');
            $idGrupo = $this->request->getPost('idGrupo');
            $idTipo = $this->request->getPost('idTipo');
            $precio = intval(str_replace(".", "", $this->request->getPost('precio')));
            $codigoBarra = $this->request->getPost('codigoBarra');
            $nombreProducto = $this->request->getPost('nombreProducto');
            $activo = $this->request->getPost('activo') == 'S' ? 1 : 0;

            if ($idProducto == 0) {
                if (!strlen(trim($nombreProducto)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del producto']);
                    exit;
                }
                if ($precio < 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Precio no puede ser negativo']);
                    exit;
                }
                $this->m_productos->save([
                    'nombreProducto' => $nombreProducto,
                    'precio' => $precio,
                    'codigoBarra' => $codigoBarra,
                    'idTipo' => $idTipo,
                    'idGrupo' => $idGrupo,
                    'idImpuesto' => $idImpuesto,
                    'idMarca' => $idMarca,
                    'activo' => $activo
                ]);
                echo json_encode(['exito' => true]);
                exit;
            } else {
                if (!strlen(trim($nombreProducto)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del producto']);
                    exit;
                }
                if ($precio < 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Precio no puede ser negativo']);
                    exit;
                }
                $this->m_productos->update($idProducto, [
                    'nombreProducto' => $nombreProducto,
                    'precio' => $precio,
                    'codigoBarra' => $codigoBarra,
                    'idTipo' => $idTipo,
                    'idGrupo' => $idGrupo,
                    'idImpuesto' => $idImpuesto,
                    'idMarca' => $idMarca,
                    'activo' => $activo
                ]);
                echo json_encode(['exito' => true]);
                exit;
            }
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Sin permiso']);
            exit;
        }
    }

    public function inventario()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x15')) {
            echo view('header');
            echo view('verPdf', ['ruta' => base_url() . '/Productos/inventarioPdf']);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function inventarioPdf()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x15')) {
            $db = db_connect();

            $pdf = new \FPDF('P', 'mm', 'A4');
            $pdf->SetMargins(10, 10);
            $pdf->AddPage();
            $pdf->SetTitle("Comprobante");
            $pdf->Image(base_url() . '/images/logo.png', 10, 5, 50, 40);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Text(130, 18, 'INVENTARIO');

            $pdf->SetXY(10, 47);
            $pdf->Cell(15, 5, 'Fecha: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, date('d/m/Y'), 0, 0, 'L');

            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, mb_convert_encoding('Id', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(20, 5, mb_convert_encoding('Codigo', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(70, 5, mb_convert_encoding('Producto', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Comprado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Vendido', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Saldo', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

            $m_productos = new ProductosModel();
            $productos = $m_productos->where('idTipo', 1)->orderBy('nombreProducto')->findAll();

            $db = db_connect();
            $pdf->SetFont('Arial', '', 8);
            foreach ($productos as $row) {
                $pdf->Cell(20, 5, mb_convert_encoding($row['idProducto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                $pdf->Cell(20, 5, mb_convert_encoding($row['codigoBarra'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
                $pdf->Cell(70, 5, mb_convert_encoding($row['nombreProducto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');

                $comprado = $db->query("SELECT COALESCE(SUM(cantidad),0) comprado FROM compras_det WHERE idProducto=" . $row['idProducto'])->getResultArray()[0]['comprado'];

                $vendido = $db->query("SELECT COALESCE(SUM(cantidad),0) vendido FROM ventas v
            INNER JOIN ventas_det vd ON v.idVenta=vd.idVenta
            WHERE idProducto=" . $row['idProducto'] . " AND anulado=0")->getResultArray()[0]['vendido'];

                $pdf->Cell(25, 5, mb_convert_encoding(number_format($comprado, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');
                $pdf->Cell(25, 5, mb_convert_encoding(number_format($vendido, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 0, 'R');

                $pdf->Cell(25, 5, mb_convert_encoding(number_format($comprado - $vendido, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 1, 1, 'R');
            }

            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf->Output("Informe.pdf", "I");
        }
    }
}
