<?php

namespace App\Models\Teacher;

use CodeIgniter\Model;

class ModTeacherCourse extends Model
{
    protected $table = 'tb_send_plan'; // Primary table for this model's operations
    protected $primaryKey = 'seplan_ID';

    protected $allowedFields = [
        'seplan_namesubject',
        'seplan_coursecode',
        'seplan_typesubject',
        'seplan_year',
        'seplan_term',
        'seplan_usersend',
        'seplan_learning',
        'seplan_status1',
        'seplan_status2',
        'seplan_sendcomment',
        'seplan_gradelevel',
        'seplan_typeplan',
        'seplan_file',
        'seplan_createdate',
        'seplan_checkdate1',
        'seplan_inspector1',
        'seplan_comment1',
        'seplan_checkdate2',
        'seplan_inspector2',
        'seplan_comment2',
    ]; // Fields that can be mass-assigned

    public function plan_insert($data)
    {
        return $this->insert($data);
    }

    public function plan_update($data, $seplan_ID)
    {
        return $this->where('seplan_ID', $seplan_ID)->update($data);
    }

    public function plan_setting_update_teacher($data, $seplan_coursecode, $seplan_year, $seplan_term)
    {
        return $this->where('seplan_coursecode', $seplan_coursecode)
                    ->where('seplan_year', $seplan_year)
                    ->where('seplan_term', $seplan_term)
                    ->update($data);
    }

    public function plan_setting_delete_teacher($DelPlanCode, $DelPlanTerm, $DelPlanYear, $DelPlanName)
    {
        // Assuming DelPlanName is the seplan_namesubject
        return $this->where('seplan_coursecode', $DelPlanCode)
                    ->where('seplan_term', $DelPlanTerm)
                    ->where('seplan_year', $DelPlanYear)
                    ->where('seplan_namesubject', $DelPlanName)
                    ->delete();
    }

    public function plan_UpdateStatus1($data, $id)
    {
        return $this->where('seplan_ID', $id)->update($data);
    }

    public function plan_UpdateStatus2($data, $id)
    {
        return $this->where('seplan_ID', $id)->update($data);
    }
}
