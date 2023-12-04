<?php

namespace App\Controllers;

use App\Models\CajasApciModel;
use App\Models\CajasModel;
use App\Models\UsuariosModel;

class Cajas extends BaseController
{
    private $session, $m_cajas;

    public function __construct()
    {
        $this->session = session();
        $this->m_cajas = new CajasModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x7')) {
            echo view('header');
            $cajas = $this->m_cajas->findAll();
            echo view('Cajas/index', ['cajas' => $cajas]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x7')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $m_apertura = new CajasApciModel();
            $verificar = $m_apertura->where('idCaja', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_cajas->delete($idEliminar);
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
            echo json_encode(['exito' => false]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x7')) {
            $idCaja = $this->request->getPost('idCaja');
            $nombreCaja = $this->request->getPost('nombreCaja');

            if ($idCaja == 0) {
                if (strlen(trim($nombreCaja)) > 0) {
                    $this->m_cajas->save([
                        'nombreCaja' => $nombreCaja
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de caja']);
                    exit;
                }
            } else {
                if (strlen(trim($nombreCaja)) > 0) {
                    $this->m_cajas->update($idCaja, [
                        'nombreCaja' => $nombreCaja
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de caja']);
                    exit;
                }
            }
        } else {
            echo json_encode(['exito' => false]);
            exit;
        }
    }

    public function abrir()
    {
        if (!isset($this->session->idUsuario)) {
            echo json_encode(['exito' => false]);
            exit;
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x7')) {
            $idCaja = $this->request->getPost('idCaja');
            $montoApertura = $this->request->getPost('montoApertura');
            $m_apertura = new CajasApciModel();
            $m_apertura->save([
                'idUsuario' => $this->session->idUsuario,
                'idCaja' => $idCaja,
                'fechaApertura' => date('Y-m-d H:i:s'),
                'montoApertura' => $montoApertura
            ]);
            $idApci = $m_apertura->getInsertID();
            $this->session->set(['idApertura' => $idApci]);
            echo json_encode(['exito' => true]);
        } else {
            echo json_encode(['exito' => false]);
            exit;
        }
    }

    public function arqueos()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x10')) {
            echo view('header');
            $db = db_connect();
            $cajas = $db->query("select idApertura,date_format(fechaApertura,'%d/%m/%Y') fecAper,user,if(fechaCierre is null,'Abierta','Cerrada') estado from cajas_apci ap
        inner join usuarios us on us.idUsuario=ap.idUsuario order by fechaCierre is null desc,fechaCierre desc")->getResultArray();
            echo view('Cajas/arqueos', ['cajas' => $cajas]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function verInforme($idApertura)
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x10')) {
            echo view('header');
            echo view('verPdf', ['ruta' => base_url() . '/Cajas/verInformePdf/' . $idApertura]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function cerrar($idApertura)
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x10')) {
            echo view('header');
            $m_apertura = new CajasApciModel();
            $apertura = $m_apertura->select("idApertura,date_format(fechaApertura,'%d/%m/%Y %H:%i') fechaApertura,montoApertura,fechaCierre,montoCierre,usuarios.idUsuario,usuarios.user,cajas.nombreCaja")
                ->join('usuarios', 'usuarios.idUsuario=cajas_apci.idUsuario')
                ->join('cajas', 'cajas.idCaja=cajas_apci.idCaja')
                ->where('idApertura', $idApertura)->first();
            if ($apertura != null) {
                if ($apertura['fechaCierre']==null) {
                    $db = db_connect();
                    $ventasTotal = $db->query("SELECT COALESCE(SUM(precio*cantidad),0) suma FROM ventas v
                INNER JOIN ventas_det vd ON vd.idVenta=v.idVenta
                WHERE idApertura=$idApertura AND anulado=0")->getResultArray()[0]['suma'];
                    $ventasContado = $db->query("SELECT COALESCE(SUM(precio*cantidad),0) suma FROM ventas v
                 INNER JOIN ventas_det vd ON vd.idVenta=v.idVenta
                 WHERE idApertura=1 AND anulado=0 AND idCondicion=1")->getResultArray()[0]['suma'];
                    $comprasTotal = $db->query("SELECT COALESCE(SUM(costo*cantidad),0) costo FROM compras c
                INNER JOIN compras_det cd ON c.idCompra=cd.idCompra
                WHERE idApertura=$idApertura")->getResultArray()[0]['costo'];
                    $comprasContado = $db->query("SELECT COALESCE(SUM(costo*cantidad),0) costo FROM compras c
                INNER JOIN compras_det cd ON c.idCompra=cd.idCompra
                WHERE idApertura=$idApertura AND idCondicion=1")->getResultArray()[0]['costo'];
                    if ($this->session->idApertura == $idApertura) {
                        $this->session->set(['idApertura' => 0]);
                    }
                    echo view('Cajas/cerrar', ['apertura' => $apertura, 'ventasTotal' => $ventasTotal, 'ventasContado' => $ventasContado, 'comprasTotal' => $comprasTotal, 'comprasContado' => $comprasContado]);
                    echo view('footer');
                    exit;
                }
            }
            echo view('mensaje', ['tipo' => 'Error', 'msg' => 'La apertura no existe o ya fue cerrada']);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function cerrarCaja()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x10')) {
            $idApertura = $this->request->getPost('idApertura');
            $montoCierre = $this->request->getPost('montoCierre');

            $m_apertura = new CajasApciModel();
            $m_apertura->update($idApertura, [
                'fechaCierre' => date('Y-m-d H:i:s'),
                'montoCierre' => $montoCierre
            ]);
            return redirect()->to(base_url() . "/Cajas/verInforme/$idApertura");
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function verInformePdf($idApertura)
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x10')) {
            $db = db_connect();

            $apertura = $db->query("SELECT date_format(fechaApertura,'%d/%m/%Y %H:%i') fecAper,date_format(fechaCierre,'%d/%m/%Y %H:%i') fecCie,idApertura,user,nombreCaja,montoApertura,montoCierre FROM cajas_apci ca
        INNER JOIN cajas c ON ca.idCaja=c.idCaja
        INNER JOIN usuarios us ON us.idUsuario=ca.idCaja WHERE idApertura=$idApertura")->getResultArray()[0];

            $ventasTotal = $db->query("SELECT COALESCE(SUM(precio*cantidad),0) suma FROM ventas v
                INNER JOIN ventas_det vd ON vd.idVenta=v.idVenta
                WHERE idApertura=$idApertura AND anulado=0")->getResultArray()[0]['suma'];
            $ventasContado = $db->query("SELECT COALESCE(SUM(precio*cantidad),0) suma FROM ventas v
                 INNER JOIN ventas_det vd ON vd.idVenta=v.idVenta
                 WHERE idApertura=1 AND anulado=0 AND idCondicion=1")->getResultArray()[0]['suma'];
            $comprasTotal = $db->query("SELECT COALESCE(SUM(costo*cantidad),0) costo FROM compras c
                INNER JOIN compras_det cd ON c.idCompra=cd.idCompra
                WHERE idApertura=$idApertura")->getResultArray()[0]['costo'];
            $comprasContado = $db->query("SELECT COALESCE(SUM(costo*cantidad),0) costo FROM compras c
                INNER JOIN compras_det cd ON c.idCompra=cd.idCompra
                WHERE idApertura=$idApertura AND idCondicion=1")->getResultArray()[0]['costo'];

            $pdf = new \FPDF('P', 'mm', 'A4');
            $pdf->SetMargins(10, 10);
            $pdf->AddPage();
            $pdf->SetTitle("CierreCaja");
            $pdf->Image(base_url() . '/images/logo.png', 10, 5, 50, 40);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Text(130, 18, 'CIERRE DE CAJA');
            $pdf->Text(130, 23, mb_convert_encoding('Número: ' . $apertura['idApertura'], 'ISO-8859-1', 'UTF-8'));

            $pdf->SetXY(10, 47);
            $pdf->Cell(28, 5, 'Fecha apertura: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, $apertura['fecAper'], 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(24, 5, 'Fecha cierre: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, $apertura['fecCie'], 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 5, mb_convert_encoding('Usuario: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(58, 5, mb_convert_encoding($apertura['user'], 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(10, 5, 'Caja: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding($apertura['nombreCaja'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 5, mb_convert_encoding('Monto apertura: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(48, 5, mb_convert_encoding(number_format($apertura['montoApertura'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(25, 5, 'Monto cierre: ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding(number_format($apertura['montoCierre'], 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 5, mb_convert_encoding('Total ventas: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(48, 5, mb_convert_encoding(number_format($ventasTotal, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 5, mb_convert_encoding('Total compras: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding(number_format($comprasTotal, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(38, 5, mb_convert_encoding('Total ventas contado: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, mb_convert_encoding(number_format($ventasContado, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(43, 5, mb_convert_encoding('Total compras contado: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding(number_format($comprasContado, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 5, mb_convert_encoding('Monto a rendir: ', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(160, 5, mb_convert_encoding(number_format($apertura['montoApertura'] + $ventasContado - $comprasContado, 0, '', '.'), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf->Output("Informe.pdf", "I");
        }
    }
}
