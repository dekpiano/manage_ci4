<?php

namespace App\Models\Student;

use CodeIgniter\Model;

class ModStudentExtraSubject extends Model
{
    protected $table = 'tb_extra_register'; // Primary table for this model
    protected $primaryKey = 'regis_ex_id';

    protected $allowedFields = [
        'regis_ex_datecreated',
        'regis_ex_active',
        'fk_extr-id',
        'fk_std_id',
    ]; // Fields that can be mass-assigned

    public function ExtraSubject_Add($data)
    {
        return $this->insert($data);
    }
}
