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

    /**
     * Ensure tb_timetable_excellence_blocks table exists
     */
    public function ensureExcellenceBlocksTable()
    {
        $db = \Config\Database::connect('timetable');
        $db->query("CREATE TABLE IF NOT EXISTS tb_timetable_excellence_blocks (
            block_id INT AUTO_INCREMENT PRIMARY KEY,
            block_name VARCHAR(150) NOT NULL,
            target_grades VARCHAR(100) NOT NULL,
            day VARCHAR(10) NOT NULL,
            start_period INT NOT NULL,
            period_count INT NOT NULL DEFAULT 1,
            teacher_ids TEXT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    /**
     * Get all excellence blocks for a given term and year
     */
    public function getExcellenceBlocks($term, $year)
    {
        $this->ensureExcellenceBlocksTable();
        $db = \Config\Database::connect('timetable');
        $db_personnel = \Config\Database::connect('personnel');

        $blocks = $db->table('tb_timetable_excellence_blocks')
            ->where('term', $term)
            ->where('year', $year)
            ->orderBy('day', 'ASC')
            ->orderBy('start_period', 'ASC')
            ->get()->getResult();

        if (empty($blocks)) {
            return [];
        }

        // Preload teacher names
        $teachers = $db_personnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
            ->get()->getResult();
        $teacherMap = [];
        foreach ($teachers as $t) {
            $teacherMap[$t->pers_id] = $t->pers_prefix . $t->pers_firstname . ' ' . $t->pers_lastname;
        }

        foreach ($blocks as $b) {
            $tids = !empty($b->teacher_ids) ? array_filter(array_map('trim', explode(',', $b->teacher_ids))) : [];
            $names = [];
            foreach ($tids as $tid) {
                if (isset($teacherMap[$tid])) {
                    $names[] = $teacherMap[$tid];
                }
            }
            $b->teacher_names = !empty($names) ? implode(', ', $names) : '-';
            $b->teacher_count = count($tids);
        }

        return $blocks;
    }

    /**
     * Get a specific excellence block by ID
     */
    public function getExcellenceBlockById($blockId)
    {
        $this->ensureExcellenceBlocksTable();
        $db = \Config\Database::connect('timetable');
        return $db->table('tb_timetable_excellence_blocks')->where('block_id', $blockId)->get()->getRow();
    }

    /**
     * Save (insert or update) an excellence block
     */
    public function saveExcellenceBlock($data)
    {
        $this->ensureExcellenceBlocksTable();
        $db = \Config\Database::connect('timetable');

        if (isset($data['block_id']) && !empty($data['block_id'])) {
            $blockId = $data['block_id'];
            unset($data['block_id']);
            return $db->table('tb_timetable_excellence_blocks')->where('block_id', $blockId)->update($data);
        } else {
            return $db->table('tb_timetable_excellence_blocks')->insert($data);
        }
    }

    /**
     * Delete an excellence block
     */
    public function deleteExcellenceBlock($blockId)
    {
        $this->ensureExcellenceBlocksTable();
        $db = \Config\Database::connect('timetable');
        return $db->table('tb_timetable_excellence_blocks')->where('block_id', $blockId)->delete();
    }
}
