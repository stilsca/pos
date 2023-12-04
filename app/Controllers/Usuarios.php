<?php

namespace App\Controllers;

use App\Models\CajasApciModel;
use App\Models\PerfilesModel;
use App\Models\UsuariosModel;

class Usuarios extends BaseController
{
    private $session, $m_usuario, $reglasLogin;


    public function __construct()
    {
        $this->session = session();
        $this->m_usuario = new UsuariosModel();
        $this->reglasLogin = [
            'usuario' => [
                'label' => 'Usuario',
                'rules' => 'required|min_length[1]|trim',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'min_length' => 'El campo {field} debe tener al menos 1 caracteres'
                ]
            ],
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[1]|trim',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'min_length' => 'El campo {field} debe tener al menos 1 caracteres'
                ]
            ]
        ];
    }

    public function validar()
    {
        if ($this->validate($this->reglasLogin)) {
            $user = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');

            $usuario = $this->m_usuario->where('user', $user)->first();
            if ($usuario != null) {
                if (password_verify($password, $usuario['password'])) {
                    $m_apertura = new CajasApciModel();
                    $caja = $m_apertura->where('idUsuario', $usuario['idUsuario'])->where('fechaCierre IS NULL')->first();
                    $idApertura = 0;
                    if ($caja != null) {
                        $idApertura = $caja['idApertura'];
                    }
                    $datosSession = [
                        'idUsuario' => $usuario['idUsuario'],
                        'usuario' => $usuario['user'],
                        'idPerfil' => $usuario['idPerfil'],
                        'idApertura' => $idApertura
                    ];
                    $this->session->set($datosSession);
                    echo json_encode(['exito' => true]);
                    return;
                }
            }
            echo json_encode(['exito' => false, 'msg' => $this->validator->listErrors()]);
            return;
        } else {
            echo json_encode(['exito' => false, 'msg' => $this->validator->listErrors()]);
            return;
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }


    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x8')) {
            echo view('header');
            $usuarios = $this->m_usuario->join('perfiles', 'perfiles.idPerfil=usuarios.idPerfil')->findAll();

            $m_perfiles = new PerfilesModel();
            $perfiles = $m_perfiles->findAll();

            echo view('Usuarios/index', ['usuarios' => $usuarios, 'perfiles' => $perfiles]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x8')) {
            $idEliminar = $this->request->getPost('idEliminar');

            $m_apertura = new CajasApciModel();

            $verificar = $m_apertura->where('idUsuario', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_usuario->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x8')) {
            $idUsuario = $this->request->getPost('idUsuario');
            $user = $this->request->getPost('user');
            $pass = $this->request->getPost('pass');
            $pass2 = $this->request->getPost('pass2');
            $idPerfil = $this->request->getPost('idPerfil');

            if ($idUsuario == 0) {
                if (!strlen(trim($user)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese usuario']);
                    exit;
                }
                if (!strlen(trim($pass)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese contraseña']);
                    exit;
                }
                if ($pass != $pass2) {
                    echo json_encode(['exito' => false, 'msg' => 'Las contraseñas no coinciden']);
                    exit;
                }
                $us = $this->m_usuario->where('user', $user)->first();
                if ($us != null) {
                    echo json_encode(['exito' => false, 'msg' => 'Ya existe un usuario con ese nombre']);
                    exit;
                }
                $this->m_usuario->save([
                    'user' => $user,
                    'password' => password_hash($pass . '', PASSWORD_DEFAULT),
                    'idPerfil' => $idPerfil
                ]);
                echo json_encode(['exito' => true]);
                exit;
            } else {
                if (!strlen(trim($pass)) > 0) {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese contraseña']);
                    exit;
                }
                if ($pass != $pass2) {
                    echo json_encode(['exito' => false, 'msg' => 'Las contraseñas no coinciden']);
                    exit;
                }
                $this->m_usuario->update($idUsuario, [
                    'password' => password_hash($pass . '', PASSWORD_DEFAULT),
                    'idPerfil' => $idPerfil
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
