<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyTransactionModel extends Model
{
    protected $table = 'dailytransaction';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'itemname',
        'itemquantitie',
        'total',
        'paymentmode',
        'tablenumber',   // ✅ Add this line
        'datetime'
    ];
    protected $useTimestamps = false;
}
