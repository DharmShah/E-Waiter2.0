<?php

namespace App\Models;

use CodeIgniter\Model;

class WaiterModel extends Model
{
    protected $table = 'waiterdetails'; // ✅ Correct table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['waitername', 'tablealloted', 'phonenumber', 'password'];
}
