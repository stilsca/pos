<?php

namespace App\Controllers;

use App\Models\GruposModel;
use App\Models\ProductosModel;
use App\Models\UsuariosModel;

class Grupos extends BaseController
{
    private $session, $m_grupos;

    public function __construct()
    {
        $this->session = session();
        $this->m_grupos = new GruposModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x2')) {
            echo view('header');
            $grupos = $this->m_grupos->findAll();
            echo view('Grupos/index', ['grupos' => $grupos]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x2')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $m_productos = new ProductosModel();
            $verificar = $m_productos->where('idGrupo', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_grupos->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x2')) {
            $idGrupo = $this->request->getPost('idGrupo');
            $nombreGrupo = $this->request->getPost('nombreGrupo');
            $activo = $this->request->getPost('activo') == 'S' ? 1 : 0;

            if ($idGrupo == 0) {
                if (strlen(trim($nombreGrupo)) > 0) {
                    $this->m_grupos->save([
                        'nombreGrupo' => $nombreGrupo,
                        'activo' => $activo
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de grupo']);
                    exit;
                }
            } else {
                if (strlen(trim($nombreGrupo)) > 0) {
                    $this->m_grupos->update($idGrupo, [
                        'nombreGrupo' => $nombreGrupo,
                        'activo' => $activo
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de grupo']);
                    exit;
                }
            }
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Sin permiso']);
            exit;
        }
    }
}
