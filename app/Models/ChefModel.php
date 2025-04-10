<?php

namespace App\Models;


use CodeIgniter\Model;

class ChefModel extends Model
{
    protected $table = 'chefdetails'; // name of your table in database
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'password', 'phonenumber'];

    // Optionally enable timestamps if your table has 'created_at' and 'updated_at'
    protected $useTimestamps = false;

    // Choose return type
    protected $returnType = 'array'; // or 'object' if you prefer
}
