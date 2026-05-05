<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_subjects';
    protected $primaryKey       = 'SubjectID';
    protected $returnType       = 'array';

    public function getSubjectsByYear($year, $term = null)
    {
        $builder = $this->where('SubjectYear', $year);
        if ($term) {
            // Some systems store term in a specific way, 
            // checking if SubjectTerm exists or if it's encoded in another field.
            // For now, assume SubjectYear is enough or just filter by year.
        }
        return $builder->findAll();
    }

    public function getSubjectById($id)
    {
        return $this->find($id);
    }
}
