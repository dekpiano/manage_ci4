<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_students';
    protected $primaryKey       = 'StudentID';
    protected $returnType       = 'array';

    public function getStudentsByClass($class, $limit = 100, $offset = 0)
    {
        return $this->where('StudentClass', $class)
                    ->where('StudentStatus', '1/ปกติ')
                    ->orderBy('StudentNumber', 'ASC')
                    ->findAll($limit, $offset);
    }

    public function getStudentById($id)
    {
        return $this->find($id);
    }
    
    public function getStudentStats()
    {
        return $this->db->table($this->table)
                    ->select('SUBSTRING(StudentClass, 1, 3) as level_name') // ม.1, ม.2 etc.
                    ->select('SUM(CASE WHEN StudentPrefix IN ("เด็กชาย", "นาย") THEN 1 ELSE 0 END) as male')
                    ->select('SUM(CASE WHEN StudentPrefix IN ("เด็กหญิง", "นางสาว") THEN 1 ELSE 0 END) as female')
                    ->select('COUNT(*) as total')
                    ->where('StudentStatus', '1/ปกติ')
                    ->groupBy('level_name')
                    ->orderBy('level_name', 'ASC')
                    ->get()
                    ->getResult();
    }

    public function getGraduationStats()
    {
        return $this->db->table($this->table)
                    ->select('YearFinish as year')
                    ->select('SUM(CASE WHEN StudentPrefix IN ("เด็กชาย", "นาย") THEN 1 ELSE 0 END) as male_count')
                    ->select('SUM(CASE WHEN StudentPrefix IN ("เด็กหญิง", "นางสาว") THEN 1 ELSE 0 END) as female_count')
                    ->select('COUNT(*) as total_count')
                    ->where('YearFinish !=', '')
                    ->where('YearFinish IS NOT NULL')
                    ->groupBy('YearFinish')
                    ->orderBy('YearFinish', 'DESC')
                    ->get()
                    ->getResult();
    }
    
    public function searchStudents($query, $limit = 50)
    {
        return $this->groupStart()
                        ->like('StudentFirstName', $query)
                        ->orLike('StudentLastName', $query)
                        ->orLike('StudentCode', $query)
                    ->groupEnd()
                    ->where('StudentStatus', '1/ปกติ')
                    ->findAll($limit);
    }
}
