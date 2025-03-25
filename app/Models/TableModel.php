<?php

namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    protected $table = 'tables'; // Your database table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['table_number'];
}
