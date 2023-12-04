<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idUsuario';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idUsuario', 'user', 'password', 'idPerfil'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public static function permiso($idUsuario, $codigo): bool
    {
        $db = db_connect();
        $res = $db->query("SELECT pp.idPermiso FROM usuarios us
        inner join perfiles_permisos pp on us.idPerfil=pp.idPerfil
        inner join permisos per on per.idPermiso=pp.idPermiso
        where idUsuario=$idUsuario and codigoPermiso='$codigo'")->getResultArray();
        return count($res) > 0;
    }
}
