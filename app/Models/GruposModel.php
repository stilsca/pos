<?php

namespace App\Models;

use CodeIgniter\Model;

class GruposModel extends Model
{
    protected $table      = 'productos_grupos';
    protected $primaryKey = 'idGrupo';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idGrupo', 'nombreGrupo', 'activo'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
