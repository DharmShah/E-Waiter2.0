<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'tableorder'; // Database table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['itemname', 'quantity', 'tableno', 'served', 'notes'];

    public function getOrdersWithPrice($tableno)
    {
        return $this->db->table('tableorder')
            ->select('tableorder.id, tableorder.tableno, tableorder.itemname, tableorder.quantity, tableorder.served, tableorder.notes, dishrate.itemprice')
            ->join('dishrate', 'tableorder.itemname = dishrate.itemname', 'left')
            ->where('tableorder.tableno', $tableno)
            ->get()
            ->getResultArray();
    }
}