<?php

namespace App\Models;

use CodeIgniter\Model;

class TimbradosModel extends Model
{
    protected $table      = 'timbrados';
    protected $primaryKey = 'idTimbrado';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idTimbrado', 'nroTimbrado', 'regimen', 'vigenciaInicio', 'vigenciaFin', 'inicio', 'fin', 'activo'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
