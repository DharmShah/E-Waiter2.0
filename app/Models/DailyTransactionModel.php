<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyTransactionModel extends Model
{
    protected $table = 'dailytransaction'; // Table Name
    protected $primaryKey = 'id'; // Primary Key

    protected $allowedFields = [
        'itemname', 
        'itemquantitie', 
        'total', 
        'paymentmode', 
        'datetime'
    ];

    protected $useTimestamps = true; // Enables automatic timestamps (if created_at, updated_at exist)
    protected $createdField = 'order_date'; // Custom timestamp field
}
