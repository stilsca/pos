<?php

namespace App\Controllers;

use App\Models\TimbradosModel;
use App\Models\VentasModel;
use App\Models\UsuariosModel;

class Timbrados extends BaseController
{
    private $session, $m_timbrados;

    public function __construct()
    {
        $this->session = session();
        $this->m_timbrados = new TimbradosModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x4')) {
            echo view('header');
            $timbrados = $this->m_timbrados->findAll();

            echo view('Timbrados/index', ['timbrados' => $timbrados]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x4')) {
            $idEliminar = $this->request->getPost('idEliminar');

            $m_ventas = new VentasModel();

            $verificar = $m_ventas->where('idTimbrado', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_timbrados->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x4')) {
            $idTimbrado = $this->request->getPost('idTimbrado');
            $nroTimbrado = $this->request->getPost('nroTimbrado');
            $regimen = $this->request->getPost('regimen');
            $vigenciaInicio = $this->request->getPost('vigenciaInicio');
            $vigenciaFin = $this->request->getPost('vigenciaFin');
            $inicio = $this->request->getPost('inicio');
            $fin = $this->request->getPost('fin');
            $activo = $this->request->getPost('activo') == 'S' ? 1 : 0;

            if ($idTimbrado == 0) {
                if (!strlen(trim($nroTimbrado)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese número de timbrado']);
                    exit;
                }
                if (!strlen(trim($regimen)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese régimen']);
                    exit;
                }
                $this->m_timbrados->save([
                    'nroTimbrado' => $nroTimbrado,
                    'regimen' => $regimen,
                    'vigenciaInicio' => $vigenciaInicio,
                    'vigenciaFin' => $vigenciaFin,
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'activo' => $activo
                ]);
                echo json_encode(['exito' => true]);
                exit;
            } else {
                if (!strlen(trim($nroTimbrado)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese número de timbrado']);
                    exit;
                }
                if (!strlen(trim($regimen)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese régimen']);
                    exit;
                }
                $this->m_timbrados->update($idTimbrado, [
                    'nroTimbrado' => $nroTimbrado,
                    'regimen' => $regimen,
                    'vigenciaInicio' => $vigenciaInicio,
                    'vigenciaFin' => $vigenciaFin,
                    'inicio' => $inicio,
                    'fin' => $fin,
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
}
