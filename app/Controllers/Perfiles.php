<?php

namespace App\Controllers;

use App\Models\PerfilesModel;
use App\Models\UsuariosModel;

class Perfiles extends BaseController
{
    private $session, $m_perfiles;

    public function __construct()
    {
        $this->session = session();
        $this->m_perfiles = new PerfilesModel();
    }

    public function index()
    {
        if (!isset($this->session->idUsuario)) {
            return redirect()->to(base_url());
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x9')) {
            echo view('header');
            $perfiles = $this->m_perfiles->findAll();
            echo view('Usuarios/perfiles', ['perfiles' => $perfiles]);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x9')) {
            $idEliminar = $this->request->getPost('idEliminar');
            $m_usuarios = new UsuariosModel();
            $verificar = $m_usuarios->where('idPerfil', $idEliminar)->findAll();
            if (count($verificar) > 0) {
                echo json_encode(['exito' => false]);
                exit;
            } else {
                $this->m_perfiles->delete($idEliminar);
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
        if (UsuariosModel::permiso($this->session->idUsuario, '0x9')) {
            $idPerfil = $this->request->getPost('idPerfil');
            $nombrePerfil = $this->request->getPost('nombrePerfil');
            if ($idPerfil == 0) {
                if (strlen(trim($nombrePerfil)) > 0) {
                    $this->m_perfiles->save([
                        'nombrePerfil' => $nombrePerfil
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del perfil']);
                    exit;
                }
            } else {
                if (strlen(trim($nombrePerfil)) > 0) {
                    $this->m_perfiles->update($idPerfil, [
                        'nombrePerfil' => $nombrePerfil
                    ]);
                    echo json_encode(['exito' => true]);
                    exit;
                } else {
                    echo json_encode(['exito' => false, 'msg' => 'Ingrese nombre del perfil']);
                    exit;
                }
            }
        } else {
            echo json_encode(['exito' => false, 'msg' => 'Sin permiso']);
            exit;
        }
    }

    public function permisos($idPerfil)
    {
        if (!isset($this->session->idUsuario)) {
            return view('login');
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x9')) {
            echo view('header');
            $perfil = $this->m_perfiles->where('idPerfil', $idPerfil)->first();
            $permisos = db_connect()->query("SELECT permisos.idPermiso,nombrePermiso,COALESCE(idPerfil,0) acceso FROM permisos
        LEFT JOIN perfiles_permisos ON perfiles_permisos.idPermiso=permisos.idPermiso AND idPerfil=$idPerfil")->getResultArray();
            echo view('Usuarios/permisos', ['perfil' => $perfil, 'permisos' => $permisos]);
            echo view('footer');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }

    public function guardarPermisos()
    {
        if (!isset($this->session->idUsuario)) {
            return view('login');
        }
        if (UsuariosModel::permiso($this->session->idUsuario, '0x9')) {
            $idPerfil = $this->request->getPost('idPerfil');
            db_connect()->query("DELETE FROM perfiles_permisos WHERE idPerfil=$idPerfil");

            $permisos = db_connect()->query("SELECT * FROM permisos")->getResultArray();
            foreach ($permisos as $row) {
                $grant = $this->request->getPost('per-' . $row['idPermiso']);
                if ($grant == 'S') {
                    db_connect()->query("INSERT INTO perfiles_permisos VALUES ($idPerfil," . $row['idPermiso'] . ")");
                }
            }
            return redirect()->to(base_url() . '/Perfiles');
        } else {
            echo view('header');
            echo view('sinPermiso');
            echo view('footer');
        }
    }
}
