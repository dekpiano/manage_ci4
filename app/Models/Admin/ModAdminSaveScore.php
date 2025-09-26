<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminSaveScore extends Model
{
    protected $table = 'tb_register_onoff'; // Assuming this is the primary table for this model's operations
    protected $primaryKey = 'onoff_id';

    protected $allowedFields = ['onoff_status']; // Fields that can be mass-assigned

    public function UpdateOnOffSaveScore($key, $value)
    {
        return $this->where('onoff_id', $key)->set(['onoff_status' => $value])->update();
    }
}

