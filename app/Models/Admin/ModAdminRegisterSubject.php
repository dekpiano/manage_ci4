<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminRegisterSubject extends Model
{
    protected $table = 'tb_subjects';
    protected $primaryKey = 'SubjectID';

    protected $allowedFields = [
        'SubjectCode',
        'SubjectName',
        'SubjectUnit',
        'SubjectHour',
        'SubjectType',
        'FirstGroup',
        'SecondGroup',
        'SubjectClass',
        'SubjectYear'
    ];

    public function ModSubjectEdit($id)
    {
        return $this->where('SubjectID', $id)->findAll();
    }

    public function ModSubjectUpdate($data, $key)
    {
        return $this->update($key, $data);
    }

    public function ModSubjectInsert($data)
    {
        return $this->insert($data);
    }

    public function ModSubjectDelete($id)
    {
        return $this->delete($id);
    }
}
