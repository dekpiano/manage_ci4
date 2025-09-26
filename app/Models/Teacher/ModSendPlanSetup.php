<?php

namespace App\Models\Teacher;

use CodeIgniter\Model;

class ModSendPlanSetup extends Model
{
    protected $table = 'tb_send_plan_setup'; // Primary table for this model's operations
    protected $primaryKey = 'seplanset_id';

    protected $allowedFields = [
        'seplanset_startdate',
        'seplanset_enddate',
        'seplanset_usersetup',
        'seplanset_year',
        'seplanset_term',
        'seplanset_status',
    ]; // Fields that can be mass-assigned

    public function plan_setting($data, $seplanset_id)
    {
        return $this->where('seplanset_id', $seplanset_id)->update($data);
    }
}
