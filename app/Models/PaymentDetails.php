<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymentDetails extends Model  // ✅ Make sure the class name matches the file name!
{
    protected $table = 'dailytransaction';  // ✅ Fix table name
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'total',
        'datetime',
        'paymentmode',
    ];

    public $timestamps = false;
}
