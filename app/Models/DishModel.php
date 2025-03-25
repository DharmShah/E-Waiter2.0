<?php

namespace App\Models;

use CodeIgniter\Model;

class DishModel extends Model
{
    protected $table = 'dishrate';
    protected $primaryKey = 'id';
    protected $allowedFields = ['imgurl', 'itemname', 'itemprice', 'itemcategory'];

    public function getDishes()
    {
        return $this->findAll();
    }
}
