<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminStudents extends Model
{
    protected $table = 'tb_students'; // Primary table for this model
    protected $primaryKey = 'StudentID';

    protected $allowedFields = [
        'StudentNumber',
        'StudentClass',
        'StudentCode',
        'StudentPrefix',
        'StudentFirstName',
        'StudentLastName',
        'StudentIDNumber',
        'StudentDateBirth',
        'StudentStatus',
        'StudentBehavior',
        'StudentStudyLine',
        'StudentSchoolYear',
    ]; // Fields that can be mass-assigned

    public function Students_Inaert($data)
    {
        return $this->insert($data);
    }

    public function Students_Update($data, $studentCode)
    {
        return $this->where('StudentCode', $studentCode)->update($data);
    }

    public function Students_Delete($id)
    {
        return $this->where('StudentID', $id)->delete();
    }

    public function get_gender_count()
    {
        return $this->db->table('tb_students')
                        ->select('SUM(CASE WHEN StudentPrefix = "เด็กชาย" OR StudentPrefix = "นาย" THEN 1 ELSE 0 END) as male_students')
                        ->select('SUM(CASE WHEN StudentPrefix = "เด็กหญิง" OR StudentPrefix = "นางสาว" THEN 1 ELSE 0 END) as female_students')
                        ->where('StudentStatus', '1/ปกติ')
                        ->get()->getRow();
    }

    public function get_students_by_class()
    {
        return $this->db->table('tb_students')
                        ->select('SUBSTRING(StudentClass, LOCATE(".", StudentClass) + 1, 1) as class_level') // Extracts number after M.
                        ->select('SUM(CASE WHEN StudentPrefix = "เด็กชาย" OR StudentPrefix = "นาย" THEN 1 ELSE 0 END) as male_count')
                        ->select('SUM(CASE WHEN StudentPrefix = "เด็กหญิง" OR StudentPrefix = "นางสาว" THEN 1 ELSE 0 END) as female_count')
                        ->where('StudentStatus', '1/ปกติ')
                        ->groupBy('class_level')
                        ->orderBy('class_level', 'ASC')
                        ->get()->getResult();
    }

    public function get_recent_students($limit)
    {
        return $this->db->table('tb_students')
                        ->select('StudentID, StudentPrefix, StudentFirstName, StudentLastName, StudentClass')
                        ->where('StudentStatus', '1/ปกติ')
                        ->orderBy('StudentID', 'DESC') // Assuming StudentID indicates creation order
                        ->limit($limit)
                        ->get()->getResult();
    }

    public function get_student_by_id($student_id)
    {
        return $this->db->table('tb_students')
                        ->where('StudentID', $student_id)
                        ->get()->getRow();
    }

    // This method handles updates for tb_students, other table updates will be in the controller
    public function update_student_data($student_id, $data_main)
    {
        return $this->where('StudentID', $student_id)->update($data_main);
    }

}
