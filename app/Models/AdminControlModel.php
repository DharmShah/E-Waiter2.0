<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminControlModel extends Model {
    protected $table = 'admin_control';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'logo', 'address', 'email', 'phone', 'table_count', 'opening_hours', 'closing_hours', 'cuisine_type', 'gst_number'];

    public function getRestaurant($id = null) {
        return ($id) ? $this->where('id', $id)->first() : $this->findAll();
    }

    public function updateRestaurant($id, $data) {
        return $this->update($id, $data);
    }

    public function insertRestaurant($data) {
        return $this->insert($data);
    }
}
