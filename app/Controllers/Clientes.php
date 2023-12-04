<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use App\Models\UsuariosModel;
use App\Models\VentasModel;

class Clientes extends BaseController
{
    private $session, $m_clientes;

    public function __construct()
    {
        $this->session = session();
        $this->m_clientes = new ClientesModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x5')) {
            echo view('header');
            $clientes = $this->m_clientes->findAll();

            echo view('Clientes/index', ['clientes' => $clientes]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x5')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $m_ventas = new VentasModel();
            $verificar = $m_ventas->where('idCliente', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_clientes->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x5')) {
            $idCliente = $this->request->getPost('idCliente');
            $razonSocial = $this->request->getPost('razonSocial');
            $direccion = $this->request->getPost('direccion');
            $celular = $this->request->getPost('celular');
            $email = $this->request->getPost('email');
            $memo = $this->request->getPost('memo');
            $documento = $this->request->getPost('documento');

            if ($idCliente == 0) {
                if (!strlen(trim($razonSocial)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del cliente']);
                    exit;
                }
                $this->m_clientes->save([
                    'documento' => $documento,
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'celular' => $celular,
                    'email' => $email,
                    'memo' => $memo
                ]);
                echo json_encode(['exito' => true]);
                exit;
            } else {
                if (!strlen(trim($razonSocial)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del cliente']);
                    exit;
                }
                $this->m_clientes->update($idCliente, [
                    'documento' => $documento,
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'celular' => $celular,
                    'email' => $email,
                    'memo' => $memo
                ]);
                echo json_encode(['exito' => true]);
                exit;
            }
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Usuario sin permiso']);
            exit;
        }
    }
}
