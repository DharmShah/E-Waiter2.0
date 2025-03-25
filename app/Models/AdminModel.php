<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admindetails';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'phonenumber', 'password'];
}
