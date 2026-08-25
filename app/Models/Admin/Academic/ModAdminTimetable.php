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
        'preferred_time',
        'group_id',
        'room_name',
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
        $db_personnel = \Config\Database::connect('personnel');

        $builder = $db->table($this->table);
        $builder->select('tb_timetable_assignments.*, tb_timetable_subjects.tsub_code as SubjectCode, tb_timetable_subjects.tsub_name as SubjectName');
        $builder->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left');
        
        if ($term) $builder->where('tb_timetable_assignments.term', $term);
        if ($year) $builder->where('tb_timetable_assignments.year', $year);
        
        $results = $builder->get()->getResult();

        // Attach teacher info
        $teachers = $db_personnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
            ->get()->getResult();
        $teacherMap = [];
        foreach ($teachers as $t) {
            $teacherMap[$t->pers_id] = $t;
        }

        foreach ($results as $r) {
            $tids = explode(',', $r->teacher_id ?? '');
            $names = [];
            foreach ($tids as $tid) {
                $tid = trim($tid);
                if (isset($teacherMap[$tid])) {
                    $names[] = $teacherMap[$tid]->pers_prefix . $teacherMap[$tid]->pers_firstname . ' ' . $teacherMap[$tid]->pers_lastname;
                }
            }
            $r->teacher_name = !empty($names) ? implode(', ', $names) : '-';
        }

        return $results;
    }
}
