<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminTimetable extends Model
{
    protected $DBGroup          = 'timetable';
    protected $table            = 'tb_timetable_assignments';
    protected $primaryKey       = 'assign_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'teacher_id',
        'subject_id',
        'class_name',
        'hours_per_week',
        'period_split',
        'term',
        'year'
    ];

    // Dates
    protected $useTimestamps = false;

    /**
     * Get all assignments with teacher and subject details
     */
    public function getAssignmentsWithDetails($term, $year)
    {
        $db = \Config\Database::connect('timetable');
        $db_academic = \Config\Database::connect('default');
        $db_personnel = \Config\Database::connect('personnel');

        $builder = $db->table($this->table);
        $builder->select('tb_timetable_assignments.*, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectName, skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_firstname, skjacth_personnel.tb_personnel.pers_lastname');
        $builder->join('skjacth_academic.tb_subjects', 'skjacth_academic.tb_subjects.SubjectID = tb_timetable_assignments.subject_id', 'left');
        $builder->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_timetable_assignments.teacher_id', 'left');
        
        if ($term) $builder->where('term', $term);
        if ($year) $builder->where('year', $year);
        
        return $builder->get()->getResult();
    }
}
