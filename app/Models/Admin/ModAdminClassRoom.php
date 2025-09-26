<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminClassRoom extends Model
{
    protected $table = 'tb_regclass'; // Assuming this is the primary table for this model's operations
    protected $primaryKey = 'regclass_id'; // Based on the delete method

    protected $allowedFields = ['Reg_Year', 'Reg_Class', 'class_teacher']; // Fields that can be mass-assigned

    public function ClassRoom_Add($data)
    {
        return $this->insert($data);
    }

    public function ClassRoom_Delete($id)
    {
        return $this->where('regclass_id', $id)->delete();
    }
}


