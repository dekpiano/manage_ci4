<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminExamSchedule extends Model
{
    protected $table = 'tb_exam_schedule'; // Primary table for this model
    protected $primaryKey = 'exam_id';

    protected $allowedFields = [
        'exam_id',
        'exam_type',
        'exam_term',
        'exam_year',
        'exam_filename',
        'exam_create',
        'exam_user',
    ]; // Fields that can be mass-assigned

    public function exam_schedule_insert($data)
    {
        return $this->insert($data);
    }

    public function exam_schedule_delete($id)
    {
        return $this->where('exam_id', $id)->delete();
    }
}

