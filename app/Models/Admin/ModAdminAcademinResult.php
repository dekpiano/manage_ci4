<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminAcademinResult extends Model
{
    protected $table = 'tb_register_onoff'; // Assuming this is the primary table for this model's operations
    protected $primaryKey = 'onoff_ID';

    protected $allowedFields = ['onoff_status']; // Fields that can be mass-assigned

    public function UpdateOnOff($check)
    {
        return $this->where('onoff_ID', 1)->set(['onoff_status' => $check])->update();
    }
}


