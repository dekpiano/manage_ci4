<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModCompetition extends Model
{
    protected $DBGroup          = 'default'; // skjacth_academic
    protected $table            = 'tb_competitions';
    protected $primaryKey       = 'comp_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'comp_name',
        'comp_activity',
        'comp_level',
        'comp_date',
        'comp_location',
        'comp_organizer',
        'comp_academic_year',
        'comp_term',
        'comp_awards',
        'comp_student_ids',
        'comp_teacher_ids',
        'comp_certificate_files',
        'comp_images',
        'comp_status',
        'comp_feedback',
        'comp_usersend'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * ดึงข้อมูลนักเรียนจาก skjacth_academic.tb_students ตามรายการ ID
     */
    public function getStudentsByIds($studentIdsJson)
    {
        if (empty($studentIdsJson)) return [];
        $ids = json_decode($studentIdsJson, true);
        if (empty($ids) || !is_array($ids)) return [];

        $dbDefault = \Config\Database::connect('default');
        return $dbDefault->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber')
            ->whereIn('StudentID', $ids)
            ->get()
            ->getResult();
    }

    /**
     * ดึงข้อมูลบุคลากรครูจาก skjacth_personnel.tb_personnel ตามรายการ ID
     */
    public function getTeachersByIds($teacherIdsJson)
    {
        if (empty($teacherIdsJson)) return [];
        $ids = json_decode($teacherIdsJson, true);
        if (empty($ids) || !is_array($ids)) return [];

        $dbPersonnel = \Config\Database::connect('personnel');
        return $dbPersonnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_img')
            ->whereIn('pers_id', $ids)
            ->get()
            ->getResult();
    }

    /**
     * ดึงข้อมูลนักเรียนทั้งหมดในระบบแบบย่อ เพื่อใช้ในการพิมพ์ค้นหา (Select2)
     */
    public function searchStudents($keyword)
    {
        $dbDefault = \Config\Database::connect('default');
        return $dbDefault->table('tb_students')
            ->select('StudentID as id, CONCAT(StudentCode, " - ", StudentPrefix, StudentFirstName, " ", StudentLastName, " ชั้น ", StudentClass) as text')
            ->like('StudentFirstName', $keyword)
            ->orLike('StudentLastName', $keyword)
            ->orLike('StudentCode', $keyword)
            ->limit(20)
            ->get()
            ->getResult();
    }

    /**
     * ดึงข้อมูลครูทั้งหมดในระบบแบบย่อ เพื่อใช้ในการพิมพ์ค้นหา (Select2)
     */
    public function searchTeachers($keyword)
    {
        $dbPersonnel = \Config\Database::connect('personnel');
        return $dbPersonnel->table('tb_personnel')
            ->select('pers_id as id, CONCAT(pers_prefix, pers_firstname, " ", pers_lastname) as text')
            ->like('pers_firstname', $keyword)
            ->orLike('pers_lastname', $keyword)
            ->limit(20)
            ->get()
            ->getResult();
    }
}
