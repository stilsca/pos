<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilesModel extends Model
{
    protected $table      = 'perfiles';
    protected $primaryKey = 'idPerfil';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idPerfil', 'nombrePerfil'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
