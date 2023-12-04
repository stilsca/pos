<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprasDetModel extends Model
{
    protected $table      = 'compras_det';
    protected $primaryKey = 'idCompraDet';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idCompraDet','idCompra', 'idProducto', 'costo', 'cantidad', 'impuesto'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
