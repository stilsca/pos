<?php

namespace App\Models;

use CodeIgniter\Model;

class CajasApciModel extends Model
{
    protected $table      = 'cajas_apci';
    protected $primaryKey = 'idApertura';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idApertura', 'idUsuario', 'idCaja', 'fechaApertura', 'fechaCierre', 'montoApertura', 'montoCierre'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}
