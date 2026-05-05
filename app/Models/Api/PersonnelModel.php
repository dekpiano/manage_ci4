<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class PersonnelModel extends Model
{
    protected $DBGroup          = 'personnel';
    protected $table            = 'tb_personnel';
    protected $primaryKey       = 'pers_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = []; // We only use it for reading for now

    public function getAllPersonnel($limit = 100, $offset = 0)
    {
        return $this->where('pers_status', 'กำลังใช้งาน')
                    ->orderBy('pers_id', 'ASC')
                    ->findAll($limit, $offset);
    }

    public function getPersonnelById($id)
    {
        return $this->find($id);
    }
}
