<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasDetModel extends Model
{
    protected $table      = 'ventas_det';
    protected $primaryKey = 'idVentaDet';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['idVentaDet','idVenta', 'idProducto', 'precio', 'cantidad', 'impuesto'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
