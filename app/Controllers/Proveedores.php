<?php

namespace App\Controllers;

use App\Models\ComprasModel;
use App\Models\ProveedoresModel;
use App\Models\UsuariosModel;

class Proveedores extends BaseController
{
    private $session, $m_proveedores;

    public function __construct()
    {
        $this->session = session();
        $this->m_proveedores = new ProveedoresModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x6')) {
            echo view('header');
            $proveedores = $this->m_proveedores->findAll();

            echo view('Proveedores/index', ['proveedores' => $proveedores]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x6')) {
            $idEliminar = $this->request->getPost('idEliminar');

            $m_compras = new ComprasModel();

            $verificar = $m_compras->where('idProveedor', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_proveedores->delete($idEliminar);
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
            $idProveedor = $this->request->getPost('idProveedor');
            $razonSocial = $this->request->getPost('razonSocial');
            $direccion = $this->request->getPost('direccion');
            $telefono = $this->request->getPost('telefono');
            $documento = $this->request->getPost('documento');

            if ($idProveedor == 0) {
                if (!strlen(trim($razonSocial)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del proveedor']);
                    exit;
                }
                $this->m_proveedores->save([
                    'documento' => $documento,
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'telefono' => $telefono
                ]);
                echo json_encode(['exito' => true]);
                exit;
            } else {
                if (!strlen(trim($razonSocial)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del producto']);
                    exit;
                }
                $this->m_proveedores->update($idProveedor, [
                    'documento' => $documento,
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'telefono' => $telefono
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
