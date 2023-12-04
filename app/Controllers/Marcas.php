<?php

namespace App\Controllers;

use App\Models\MarcasModel;
use App\Models\ProductosModel;
use App\Models\UsuariosModel;

class Marcas extends BaseController
{
    private $session, $m_marcas;

    public function __construct()
    {
        $this->session = session();
        $this->m_marcas = new MarcasModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x1')) {
            echo view('header');
            $marcas = $this->m_marcas->findAll();
            echo view('Marcas/index', ['marcas' => $marcas]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x1')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $m_productos = new ProductosModel();
            $verificar = $m_productos->where('idMarca', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_marcas->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x1')) {
            $idMarca = $this->request->getPost('idMarca');
            $nombreMarca = $this->request->getPost('nombreMarca');
            $activo = $this->request->getPost('activo') == 'S' ? 1 : 0;

            if ($idMarca == 0) {
                if (strlen(trim($nombreMarca)) > 0) {
                    $this->m_marcas->save([
                        'nombreMarca' => $nombreMarca,
                        'activo' => $activo
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de marca']);
                    exit;
                }
            } else {
                if (strlen(trim($nombreMarca)) > 0) {
                    $this->m_marcas->update($idMarca, [
                        'nombreMarca' => $nombreMarca,
                        'activo' => $activo
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre de marca']);
                    exit;
                }
            }
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Sin permiso']);
            exit;
        }
    }
}
