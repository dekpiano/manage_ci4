<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminClassSchedule extends Model
{
    protected $table = 'tb_class_schedule'; // Primary table for this model
    protected $primaryKey = 'schestu_id';

    protected $allowedFields = [
        'schestu_id',
        'schestu_name',
        'schestu_classname',
        'schestu_filename',
        'schestu_term',
        'schestu_year',
        'schestu_datetime',
        'schestu_user',
    ]; // Fields that can be mass-assigned

    public function class_schedule_insert($data)
    {
        return $this->insert($data);
    }

    public function class_schedule_update($data, $schestu_id)
    {
        return $this->where('schestu_id', $schestu_id)->update($data);
    }

    public function class_schedule_delete($id)
    {
        return $this->where('schestu_id', $id)->delete();
    }
}


