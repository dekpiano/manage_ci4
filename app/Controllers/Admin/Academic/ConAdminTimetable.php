<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModAdminTimetable;
use App\Models\Admin\Academic\ModTimetableConfig;

class ConAdminTimetable extends BaseController
{
    protected $db;
    protected $db_timetable;
    protected $db_personnel;
    protected $modTimetable;
    protected $modConfig;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db_timetable = \Config\Database::connect('timetable');
        $this->db_personnel = \Config\Database::connect('personnel');
        $this->db_skj = \Config\Database::connect('skj');
        $this->modTimetable = new ModAdminTimetable();
        $this->modConfig = new ModTimetableConfig();

        if (empty(session()->get('fullname'))) {
            header('Location: ' . base_url('LogoutTeacher'));
            exit();
        }

        $this->ensureTablesExist();
    }

    private function checkTimetableCompletion()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // Calculate required vs scheduled
        $totalRequired = $this->db_timetable->table('tb_timetable_assignments')
            ->selectSum('hours_per_week')
            ->where(['term' => $term, 'year' => $year])
            ->get()->getRow()->hours_per_week ?? 0;

        $totalScheduled = $this->db_timetable->table('tb_timetable_data')
            ->where(['term' => $term, 'year' => $year])
            ->countAllResults();

        if ($totalRequired == 0) return true; // No data yet

        return ($totalScheduled >= $totalRequired);
    }

    public function getProgress()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // Get unique classes with progress
        $classes = $this->db_timetable->table('tb_timetable_assignments')
                        ->select('class_name, SUM(hours_per_week) as total_hours')
                        ->where('term', $term)
                        ->where('year', $year)
                        ->groupBy('class_name')
                        ->orderBy('class_name', 'ASC')
                        ->get()->getResult();

        $overall_total = 0;
        $overall_scheduled = 0;
        foreach($classes as $c) {
            $c->scheduled_hours = $this->db_timetable->table('tb_timetable_data')
                                    ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                                    ->where('tb_timetable_assignments.class_name', $c->class_name)
                                    ->where('tb_timetable_data.term', $term)
                                    ->where('tb_timetable_data.year', $year)
                                    ->countAllResults();
            $overall_total += $c->total_hours;
            $overall_scheduled += $c->scheduled_hours;
        }
        $progress = ($overall_total > 0) ? round(($overall_scheduled / $overall_total) * 100) : 0;

        return $this->response->setJSON([
            'overall_progress' => $progress,
            'classes' => $classes
        ]);
    }

    private function ensureTablesExist()
    {
        // Teacher busy constraints
        $this->db_timetable->query("CREATE TABLE IF NOT EXISTS tb_timetable_constraints (
            constraint_id INT AUTO_INCREMENT PRIMARY KEY,
            teacher_id VARCHAR(50) NOT NULL,
            day VARCHAR(10) NOT NULL,
            period INT NOT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Room busy constraints
        $this->db_timetable->query("CREATE TABLE IF NOT EXISTS tb_timetable_room_constraints (
            room_id INT AUTO_INCREMENT PRIMARY KEY,
            room_name VARCHAR(50) NOT NULL,
            day VARCHAR(10) NOT NULL,
            period INT NOT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Subject fixed locks
        $this->db_timetable->query("CREATE TABLE IF NOT EXISTS tb_timetable_subject_locks (
            lock_id INT AUTO_INCREMENT PRIMARY KEY,
            class_name VARCHAR(50) NOT NULL,
            subject_id INT NOT NULL,
            day VARCHAR(10) NOT NULL,
            period INT NOT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // 🚀 Ensure group_id is VARCHAR(50) (For Step 2)
        try {
            // First try to add it
            $this->db_timetable->query("ALTER TABLE tb_timetable_assignments ADD COLUMN group_id VARCHAR(50) DEFAULT NULL AFTER assign_id");
        } catch (\Exception $e) { 
            // If exists, ensure it is VARCHAR (Fix for 'Incorrect integer value' error)
            $this->db_timetable->query("ALTER TABLE tb_timetable_assignments MODIFY COLUMN group_id VARCHAR(50) DEFAULT NULL");
        }

        // 🚀 Table for Joint Groups (วิชาเรียนรวม)
        $this->db_timetable->query("CREATE TABLE IF NOT EXISTS tb_timetable_subject_groups (
            group_id INT AUTO_INCREMENT PRIMARY KEY,
            group_name VARCHAR(100) NOT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    private function invalidateTimetable()
    {
        $selectedYear = $this->getTimetableYear();
        if (!$selectedYear) return;
        
        list($term, $year) = explode('/', $selectedYear);
        
        // 🔄 เมื่อมีการเปลี่ยนเงื่อนไขพื้นฐาน ให้ล้างข้อมูลที่ AI จัดไว้ (เฉพาะตัวที่ไม่ได้ล็อค)
        // เพื่อป้องกันปัญหาข้อมูลเก่าค้างขัดแย้งกับเงื่อนไขใหม่ที่คุณครูแก้ครับ
        $this->db_timetable->table('tb_timetable_data')
            ->where('is_locked', 0)
            ->where('term', $term)
            ->where('year', $year)
            ->delete();
    }

    // --- TIMETABLE SUBJECTS MANAGEMENT ---
    public function subjects()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "จัดการรายวิชาสำหรับตารางสอน";
        $data['term'] = $term;
        $data['year'] = $year;

        // Get existing timetable subjects
        $data['timetable_subjects'] = $this->db_timetable->table('tb_timetable_subjects')
                                        ->where('term', $term)
                                        ->where('year', $year)
                                        ->orderBy('tsub_code', 'ASC')
                                        ->get()->getResult();

        // Get academic subjects (for import)
        $data['academic_subjects'] = $this->db->table('tb_subjects')
                                        ->where('SubjectYear', $selectedYear)
                                        ->orderBy('SubjectCode', 'ASC')
                                        ->get()->getResult();

        return view('admin/Academic/AdminTimetable/SubjectMain', $data);
    }

    public function saveTimetableSubject()
    {
        $data = [
            'tsub_code' => $this->request->getPost('tsub_code'),
            'tsub_name' => $this->request->getPost('tsub_name'),
            'term'      => $this->request->getPost('term'),
            'year'      => $this->request->getPost('year'),
        ];

        if ($this->db_timetable->table('tb_timetable_subjects')->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกวิชาสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }
    }

    public function importSubjects()
    {
        $subject_ids = $this->request->getPost('subject_ids');
        $term = $this->request->getPost('term');
        $year = $this->request->getPost('year');

        if (empty($subject_ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเลือกวิชาที่ต้องการนำเข้า']);
        }

        $academic_subjects = $this->db->table('tb_subjects')
                                ->whereIn('SubjectID', $subject_ids)
                                ->get()->getResult();

        $count = 0;
        foreach ($academic_subjects as $s) {
            // Check if already exists to avoid duplicates
            $exists = $this->db_timetable->table('tb_timetable_subjects')
                        ->where('tsub_code', $s->SubjectCode)
                        ->where('term', $term)
                        ->where('year', $year)
                        ->countAllResults();
            
            if ($exists == 0) {
                $this->db_timetable->table('tb_timetable_subjects')->insert([
                    'tsub_code' => $s->SubjectCode,
                    'tsub_name' => $s->SubjectName,
                    'term'      => $term,
                    'year'      => $year
                ]);
                $count++;
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => "นำเข้าวิชาสำเร็จ $count รายการ"]);
    }

    public function deleteTimetableSubject()
    {
        $id = $this->request->getPost('id');
        if ($this->db_timetable->table('tb_timetable_subjects')->delete(['tsub_id' => $id])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }
    }

    public function process()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ประมวลผลและจัดตารางสอน";
        $data['term'] = $term;
        $data['year'] = $year;
        $data['selectedYear'] = $selectedYear;

        // 📊 Query with Total Assigned Hours (Respecting Combined Groups)
        $subquery = $this->db_timetable->table('skjacth_timetable.tb_timetable_assignments')
                        ->select('COALESCE(group_id, CAST(assign_id AS CHAR)) as unique_key, MAX(hours_per_week) as hours, teacher_id')
                        ->where(['term' => $term, 'year' => $year])
                        ->groupBy('unique_key, teacher_id')
                        ->getCompiledSelect();

        $teachers = $this->db_personnel->table('tb_personnel')
            ->select('tb_personnel.pers_id, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_personnel.pers_img, tb_personnel.pers_learning')
            ->select('(SELECT SUM(hours) FROM (' . $subquery . ') as sub WHERE FIND_IN_SET(tb_personnel.pers_id, sub.teacher_id) > 0) as total_assigned_hours')
            ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
            ->where('pers_status', 'กำลังใช้งาน')
            ->orderBy('pers_learning', 'ASC')
            ->get()->getResult();

        // 📅 Get available years from database - Sorted by Year then Term DESC (Escape false to allow SQL functions)
        $data['available_years'] = $this->db->table('tb_subjects')
            ->select('SubjectYear as year')
            ->distinct()
            ->orderBy("SUBSTRING_INDEX(SubjectYear, '/', -1)", 'DESC', false)
            ->orderBy("SUBSTRING_INDEX(SubjectYear, '/', 1)", 'DESC', false)
            ->get()->getResult();

        // 📊 Step 1 & 3 Data
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        $data['master_slots'] = $this->modConfig->getMasterSlots($term, $year);

        // 📚 Subjects Management Data
        $data['timetable_subjects'] = $this->db_timetable->table('tb_timetable_subjects')
                                        ->where('term', $term)
                                        ->where('year', $year)
                                        ->orderBy('tsub_code', 'ASC')
                                        ->get()->getResult();

        $data['academic_subjects'] = $this->db->table('tb_subjects')
                                        ->where('SubjectYear', $selectedYear)
                                        ->orderBy('SubjectCode', 'ASC')
                                        ->get()->getResult();

        // 👨‍🏫 Teacher Map for Grouping
        $teachers = $this->db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                                ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                                ->where('pers_status', 'กำลังใช้งาน')
                                ->orderBy('pers_firstname', 'ASC')
                                ->get()->getResult();
        $teachers_map = array_reduce($teachers, function($carry, $item) {
            $carry[$item->pers_id] = $item->pers_prefix . $item->pers_firstname . ' ' . $item->pers_lastname;
            return $carry;
        }, []);
        $data['teachers'] = $teachers;
        $data['all_personnel'] = $teachers;
        $data['teachers_map'] = $teachers_map;

        // 📚 Step 2 Data: Grouped by subject and teachers
        $raw_assignments = $this->db_timetable->table('tb_timetable_assignments')
                                ->select('tb_timetable_assignments.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                                ->where('tb_timetable_assignments.term', $term)->where('tb_timetable_assignments.year', $year)
                                ->get()->getResult();
        
        $grouped = [];
        foreach($raw_assignments as $row) {
            // Grouping key: if group_id exists, use it as primary key, otherwise use assign_id
            $key = $row->group_id ? 'G_'.$row->group_id : 'A_'.$row->assign_id;
            
            if (!$row->tsub_name) {
                $row->tsub_name = "ไม่พบข้อมูลวิชา (ID: " . $row->subject_id . ")";
                $row->tsub_code = "???";
            }

            if(!isset($grouped[$key])) {
                $grouped[$key] = [
                    'data' => $row,
                    'subjects' => [], // New: Store all subjects in group
                    'teachers' => [],
                    'classes' => [],
                    'ids' => []
                ];
            }

            // Add subject to group if not already there
            $subjectKey = $row->tsub_code . ' ' . $row->tsub_name;
            if (!isset($grouped[$key]['subjects'][$subjectKey])) {
                $grouped[$key]['subjects'][$subjectKey] = [
                    'code' => $row->tsub_code,
                    'name' => $row->tsub_name
                ];
            }

            $tIds = explode(',', $row->teacher_id);
            foreach($tIds as $tid) {
                $tid = trim($tid);
                $tName = $teachers_map[$tid] ?? 'ไม่ทราบชื่อ (ID: '.$tid.')';
                if(!in_array($tName, array_column($grouped[$key]['teachers'], 'name'))) {
                    $grouped[$key]['teachers'][] = ['id' => $tid, 'name' => $tName];
                }
            }
            if(!in_array($row->class_name, $grouped[$key]['classes'])) {
                $grouped[$key]['classes'][] = $row->class_name;
            }
            $grouped[$key]['ids'][] = $row->assign_id;
        }
        $data['assignments'] = $grouped;
        
        $data['all_subjects'] = $this->db_timetable->table('tb_timetable_subjects')->where(['term' => $term, 'year' => $year])->orderBy('tsub_code', 'ASC')->get()->getResult();

        // 🏢 Room List (From Classroom Library)
        $classroom = new \App\Libraries\Classroom();
        $rooms = $classroom->ListRoom();
        $data['all_rooms'] = array_map(function($r) { return (object)['ClassName' => $r]; }, $rooms);

        // 👨‍🏫 Teacher Constraints (For Teacher Lock Tab)
        $teacher_locks = $this->db_timetable->table('tb_timetable_constraints')
                                ->where('term', $term)
                                ->where('year', $year)
                                ->get()->getResult();
        $data['teacher_lock_map'] = [];
        foreach($teacher_locks as $lock) {
            $data['teacher_lock_map'][$lock->teacher_id][] = $lock->day . '_' . $lock->period;
        }

        // Get unique classes with their total required periods and current progress
        $classes = $this->db_timetable->table('tb_timetable_assignments')
                        ->select('class_name, SUM(hours_per_week) as total_hours')
                        ->where('term', $term)
                        ->where('year', $year)
                        ->groupBy('class_name')
                        ->orderBy('class_name', 'ASC')
                        ->get()->getResult();

        $overall_total = 0;
        $overall_scheduled = 0;
        foreach($classes as $c) {
            $c->scheduled_hours = $this->db_timetable->table('tb_timetable_data')
                                    ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                                    ->where('tb_timetable_assignments.class_name', $c->class_name)
                                    ->where('tb_timetable_data.term', $term)
                                    ->where('tb_timetable_data.year', $year)
                                    ->countAllResults();
            $c->progress = ($c->total_hours > 0) ? round(($c->scheduled_hours / $c->total_hours) * 100) : 0;
            $overall_total += $c->total_hours;
            $overall_scheduled += $c->scheduled_hours;
        }
        $data['assigned_classes'] = $classes;
        $data['overall_progress'] = ($overall_total > 0) ? round(($overall_scheduled / $overall_total) * 100) : 0;

        return view('admin/Academic/AdminTimetable/ProcessMain', $data);
    }


    public function autoGenerate()
    {
        try {
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);
            $log = [];
            $log[] = "--- เริ่มต้นการประมวลผล ปีการศึกษา $selectedYear ---";

            // 1. Transactional Start
            $this->db_timetable->transStart();

            // 🧹 STEP 1: Clear current timetable data for this term/year
            // We clear everything and rebuild from locks + AI to ensure data integrity
            $this->db_timetable->table('tb_timetable_data')
                ->where('term', $term)
                ->where('year', $year)
                ->delete();
            $log[] = "ล้างข้อมูลตารางสอนเดิมเพื่อเตรียมประมวลผลใหม่เรียบร้อย";

            // 2. Sync Subject Constraints (Locks) to Timetable Data
            $subject_locks = $this->db_timetable->table('tb_timetable_subject_locks')
                ->where(['term' => $term, 'year' => $year])
                ->get()->getResult();
            $log[] = "พบเงื่อนไขการล็อควิชา " . count($subject_locks) . " รายการ กำลังทำการ Sync...";

            foreach ($subject_locks as $lock) {
                // Find the assignment for this lock
                $assign = $this->db_timetable->table('tb_timetable_assignments')
                    ->where(['class_name' => $lock->class_name, 'subject_id' => $lock->subject_id, 'term' => $term, 'year' => $year])
                    ->get()->getRow();
                
                if ($assign) {
                    // If this assignment is part of a group, we must lock ALL assignments in that group
                    $target_assign_ids = [$assign->assign_id];
                    if ($assign->group_id) {
                        $group_members = $this->db_timetable->table('tb_timetable_assignments')
                            ->select('assign_id')
                            ->where('group_id', $assign->group_id)
                            ->get()->getResult();
                        $target_assign_ids = array_column($group_members, 'assign_id');
                    }

                    foreach ($target_assign_ids as $aid) {
                        // Use ignore or check existence to prevent errors if multiple locks point to same group
                        $exists = $this->db_timetable->table('tb_timetable_data')
                            ->where(['assign_id' => $aid, 'day' => $lock->day, 'period' => $lock->period, 'term' => $term, 'year' => $year])
                            ->countAllResults();
                        
                        if ($exists == 0) {
                            $this->db_timetable->table('tb_timetable_data')->insert([
                                'assign_id' => $aid, 'day' => $lock->day, 'period' => $lock->period,
                                'term' => $term, 'year' => $year, 'is_locked' => 1 
                            ]);
                        }
                    }
                }
            }

            // 3. Prepare AI Data
            $assignments = $this->db_timetable->table('tb_timetable_assignments')
                ->select('tb_timetable_assignments.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                ->where(['tb_timetable_assignments.term' => $term, 'tb_timetable_assignments.year' => $year])
                ->get()->getResult();
            $log[] = "ดึงข้อมูลมอบหมายงานสอน " . count($assignments) . " รายการ";

            // Initialize Teacher Name Map for Logging/Reporting
            $all_teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_prefix, pers_firstname, pers_lastname')->get()->getResult();
            $teacher_name_map = [];
            foreach ($all_teachers as $t) {
                $teacher_name_map[$t->pers_id] = $t->pers_prefix . $t->pers_firstname . ' ' . $t->pers_lastname;
            }

            // Busy Maps Initialization
            $busy_teachers = []; $busy_classes = []; $room_busy = [];
            
            // Try to get locked slots, checking if room_name column exists in the joined table
            $locked_slots_query = $this->db_timetable->table('tb_timetable_data')
                ->select('tb_timetable_data.*, tb_timetable_assignments.class_name, tb_timetable_assignments.teacher_id')
                ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year]);

            // Add room_name if table has it
            if ($this->db_timetable->fieldExists('room_name', 'tb_timetable_assignments')) {
                $locked_slots_query->select('tb_timetable_assignments.room_name');
            }
            
            $locked_slots = $locked_slots_query->get()->getResult();

            foreach ($locked_slots as $slot) {
                $busy_classes[$slot->class_name][$slot->day][$slot->period] = true;
                $rName = $slot->room_name ?? null;
                if (!empty($rName)) $room_busy[$rName][$slot->day][$slot->period] = true;
                foreach (explode(',', $slot->teacher_id) as $tid) { if(!empty($tid)) $busy_teachers[trim($tid)][$slot->day][$slot->period] = true; }
            }

            // Load Teacher/Room Busy Constraints (Step 3)
            $t_constraints = $this->db_timetable->table('tb_timetable_constraints')->where(['term' => $term, 'year' => $year])->get()->getResult();
            foreach ($t_constraints as $tc) $busy_teachers[trim($tc->teacher_id)][$tc->day][$tc->period] = true;
            
            $r_constraints = $this->db_timetable->table('tb_timetable_room_constraints')->where(['term' => $term, 'year' => $year])->get()->getResult();
            foreach ($r_constraints as $rc) $room_busy[$rc->room_name][$rc->day][$rc->period] = true;

            $active_days_raw = $this->db_timetable->table('tb_timetable_config_days')->where('is_active', 1)->get()->getResult();
            $days = array_column($active_days_raw, 'day_key') ?: ['MON', 'TUE', 'WED', 'THU', 'FRI'];
            
            $all_periods = $this->db_timetable->table('tb_timetable_config_periods')->get()->getResult();
            $max_period = !empty($all_periods) ? max(array_column($all_periods, 'period_number')) : 10;
            $break_map = []; foreach($all_periods as $p) if($p->is_break) $break_map[$p->level_group][$p->period_number] = true;

            $master_slots = $this->db_timetable->table('tb_timetable_config_master_slots')->where(['term' => $term, 'year' => $year])->get()->getResult();
            $master_map = []; foreach($master_slots as $ms) $master_map[$ms->level_group][$ms->day][$ms->period] = true;

            // 🤖 AI Processing Loop
            $log[] = "--- เริ่มต้นการค้นหาช่องว่างด้วย AI ---";
            $success_count = 0; $fail_count = 0; $failed_list = [];
            
            $grouped = []; foreach($assignments as $a) { $k = $a->group_id ?: 'S_'.$a->assign_id; $grouped[$k]['assignments'][] = $a; }

            foreach ($grouped as $group) {
                $base = $group['assignments'][0];
                $class_names = array_column($group['assignments'], 'class_name');
                $teacher_ids = []; foreach($group['assignments'] as $a) $teacher_ids = array_merge($teacher_ids, explode(',', $a->teacher_id));
                $teacher_ids = array_unique(array_filter($teacher_ids));
                $room_name = $base->room_name ?? null;
                
                // 🍱 DETERMINING GROUP BREAKS & MASTER SLOTS (Support Mixed Levels)
                $group_blocked_periods = [];
                $group_blocked_master = [];
                $has_junior = false; $has_senior = false;
                foreach ($group['assignments'] as $asgn) {
                    if (preg_match('/ม\.[1-3]/', $asgn->class_name) || preg_match('/^[1-3]/', $asgn->class_name)) $has_junior = true;
                    if (preg_match('/ม\.[4-6]/', $asgn->class_name) || preg_match('/^[4-6]/', $asgn->class_name)) $has_senior = true;
                }

                if ($has_junior) $group_blocked_periods[4] = true;
                if ($has_senior) $group_blocked_periods[5] = true;

                if (!empty($all_periods)) {
                    foreach($all_periods as $p_conf) {
                        if($p_conf->is_break) {
                            if($p_conf->level_group == 'ALL') $group_blocked_periods[$p_conf->period_number] = true;
                            else if($p_conf->level_group == 'Junior' && $has_junior) $group_blocked_periods[$p_conf->period_number] = true;
                            else if($p_conf->level_group == 'Senior' && $has_senior) $group_blocked_periods[$p_conf->period_number] = true;
                        }
                    }
                }
                
                // Aggregate Master Slots for this specific group's levels
                foreach ($days as $d_key) {
                    for ($p_num = 1; $p_num <= $max_period; $p_num++) {
                        if (isset($master_map['ALL'][$d_key][$p_num])) $group_blocked_master[$d_key][$p_num] = true;
                        if ($has_junior && isset($master_map['Junior'][$d_key][$p_num])) $group_blocked_master[$d_key][$p_num] = true;
                        if ($has_senior && isset($master_map['Senior'][$d_key][$p_num])) $group_blocked_master[$d_key][$p_num] = true;
                    }
                }
                
                $lunch_p = $has_junior ? 4 : 5;

                $locked_c = $this->db_timetable->table('tb_timetable_data')->whereIn('assign_id', array_column($group['assignments'], 'assign_id'))->where('is_locked', 1)->groupBy('day, period')->countAllResults();
                $rem = $base->hours_per_week - $locked_c;
                if ($rem <= 0) continue;

                $splits = array_map('intval', explode(',', $base->period_split ?: '1'));
                $t_locked = $locked_c; $final_splits = [];
                foreach($splits as $s) { if($t_locked >= $s) $t_locked -= $s; else if($t_locked > 0) { $final_splits[] = $s - $t_locked; $t_locked = 0; } else $final_splits[] = $s; }
                rsort($final_splits);

                $days_used = [];
                $locked_d = $this->db_timetable->table('tb_timetable_data')->select('day')->whereIn('assign_id', array_column($group['assignments'], 'assign_id'))->where('is_locked', 1)->groupBy('day')->get()->getResult();
                foreach($locked_d as $ld) $days_used[] = $ld->day;

                foreach ($final_splits as $size) {
                    $placed = false; $av_days = array_values(array_diff($days, $days_used)); if(empty($av_days)) $av_days = $days; shuffle($av_days);
                    $conflict_reasons = [];
                    foreach ($av_days as $d) {
                        $p_starts = range(1, $max_period - $size + 1);
                        $pref_time = $base->preferred_time ?? null;
                        if($pref_time == 'MORNING') $p_starts = array_filter($p_starts, fn($p) => ($p+$size-1) < $lunch_p);
                        else if($pref_time == 'AFTERNOON') $p_starts = array_filter($p_starts, fn($p) => $p > $lunch_p);
                        shuffle($p_starts);

                        foreach ($p_starts as $ps) {
                            $pe = $ps + $size - 1; $free = true; $l_conf = [];
                            for ($p = $ps; $p <= $pe; $p++) {
                                if(isset($group_blocked_periods[$p])) { $free = false; $l_conf[] = "คาบ $p ติดพัก/กิจกรรมของสมาชิกในกลุ่ม"; break; }
                                if(isset($group_blocked_master[$d][$p])) { $free = false; $l_conf[] = "วัน$d คาบ $p ติดกิจกรรมของสมาชิกในกลุ่ม"; break; }
                                foreach($class_names as $cn) if(isset($busy_classes[$cn][$d][$p])) { $free = false; $l_conf[] = "ห้อง $cn ไม่ว่าง"; break; }
                                if(!$free) break;
                                foreach($teacher_ids as $tid) if(isset($busy_teachers[$tid][$d][$p])) { $free = false; $l_conf[] = "ครู ".($teacher_name_map[$tid]??$tid)." ติดสอน"; break; }
                                if(!$free) break;
                                if($room_name && isset($room_busy[$room_name][$d][$p])) { $free = false; $l_conf[] = "ห้องเรียน $room_name ไม่ว่าง"; break; }
                            }
                            if ($free) {
                                for ($p = $ps; $p <= $pe; $p++) {
                                    foreach($group['assignments'] as $asgn) {
                                        $this->db_timetable->table('tb_timetable_data')->insert(['assign_id'=>$asgn->assign_id, 'day'=>$d, 'period'=>$p, 'term'=>$term, 'year'=>$year, 'is_locked'=>0]);
                                        $busy_classes[$asgn->class_name][$d][$p] = true;
                                        if($room_name) $room_busy[$room_name][$d][$p] = true;
                                    }
                                }
                                $placed = true; $days_used[] = $d; $success_count += $size; break;
                            } else $conflict_reasons = array_unique(array_merge($conflict_reasons, $l_conf));
                        }
                        if ($placed) break;
                    }
                    if (!$placed) { $fail_count++; $failed_list[] = ['class_name'=>$base->class_name, 'subject_code'=>$base->tsub_code, 'subject_name'=>$base->tsub_name, 'teacher_name'=>implode(', ', array_map(fn($id) => $teacher_name_map[$id] ?? $id, $teacher_ids)), 'block_size'=>$size, 'reasons'=>array_slice($conflict_reasons,0,5)]; }
                }
            }

            if ($fail_count > 0) {
                $this->db_timetable->transRollback();
                $log[] = "🚨 ประมวลผลไม่สมบูรณ์: พบวิชาที่จัดลงไม่ได้ $fail_count รายการ";
                return $this->response->setJSON(['status'=>'error', 'message'=>"จัดไม่ได้ $fail_count รายการ", 'failed_list'=>$failed_list, 'processing_log'=>$log]);
            }

            $this->db_timetable->transComplete();
            $log[] = "✅ ประมวลผลสำเร็จ 100%!";
            return $this->response->setJSON([
                'status'=>'success', 
                'fail_count'=> 0,
                'debug' => ['total_assignments' => count($assignments), 'term' => $term, 'year' => $year],
                'processing_log'=>$log
            ]);

        } catch (\Throwable $e) {
            if(isset($this->db_timetable)) $this->db_timetable->transRollback();
            return $this->response->setJSON(['status'=>'error', 'message'=>$e->getMessage(), 'line'=>$e->getLine(), 'file'=>$e->getFile(), 'processing_log'=>$log??[]]);
        }
    }

    public function getClassTimetable()
    {
        $class_name = $this->request->getGet('class');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $timetable = $this->db_timetable->table('tb_timetable_data')
                        ->select('tb_timetable_data.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name, tb_timetable_assignments.teacher_id')
                        ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                        ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                        ->where('tb_timetable_assignments.class_name', $class_name)
                        ->where('tb_timetable_data.term', $term)
                        ->where('tb_timetable_data.year', $year)
                        ->get()->getResult();

        return $this->response->setJSON($timetable);
    }

    public function viewClassTimetable()
    {
        $className = $this->request->getGet('class');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['class_name'] = $className;
        $data['days'] = $this->modConfig->getDays();
        
        $isSenior = (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className));
        $level_group = $isSenior ? 'Senior' : 'Junior';
        $data['level_group'] = $level_group;
        $data['lunch_period'] = $isSenior ? 5 : 4;

        // ⏰ Fetch ALL unique periods for the header
        $data['periods'] = $this->db_timetable->table('tb_timetable_config_periods')
            ->select('period_number, MAX(is_break) as is_break') 
            ->groupBy('period_number')
            ->orderBy('period_number', 'ASC')
            ->get()->getResult();

        // If empty, fallback to 1-10
        if (empty($data['periods'])) {
            $data['periods'] = [];
            for($i=1; $i<=10; $i++) $data['periods'][] = (object)['period_number' => $i, 'is_break' => 0];
        }

        // 🍱 Fetch ALL period configs to check is_break specifically for this level group
        $level_periods = $this->db_timetable->table('tb_timetable_config_periods')
            ->groupStart()
                ->where('level_group', $level_group)
                ->orWhere('level_group', 'ALL')
            ->groupEnd()
            ->get()->getResult();
        
        // 🍱 Also fetch ALL periods globally to ensure time map is NEVER empty for any header
        $global_periods = $this->db_timetable->table('tb_timetable_config_periods')
            ->orderBy('period_number', 'ASC')
            ->get()->getResult();

        $data['break_map'] = [];
        $data['time_map'] = [];

        // 1. Fill time map with GLOBAL defaults first
        foreach($global_periods as $gp) {
            if (!isset($data['time_map'][$gp->period_number])) {
                $data['time_map'][$gp->period_number] = substr($gp->start_time, 0, 5).' - '.substr($gp->end_time, 0, 5);
            }
        }

        // 2. Override with LEVEL-SPECIFIC info (Breaks and Times)
        foreach($level_periods as $lp) {
            if($lp->is_break) $data['break_map'][$lp->period_number] = true;
            $data['time_map'][$lp->period_number] = substr($lp->start_time, 0, 5).' - '.substr($lp->end_time, 0, 5);
        }
        
        $data['level_periods'] = $level_periods; // Pass for time lookup in header
        
        // Master Slots
        $data['master_slots'] = $this->db_timetable->table('tb_timetable_config_master_slots')
            ->where(['term' => $term, 'year' => $year])
            ->groupStart()->where('level_group', $level_group)->orWhere('level_group', 'ALL')->groupEnd()
            ->get()->getResult();

        // Timetable Data
        $data['timetable_data'] = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name, tb_timetable_assignments.teacher_id')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
            ->where('tb_timetable_assignments.class_name', $className)
            ->where('tb_timetable_data.term', $term)
            ->where('tb_timetable_data.year', $year)
            ->get()->getResult();

        // Teachers for name mapping
        $teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_prefix, pers_firstname')->get()->getResult();
        $data['teacher_map'] = [];
        foreach($teachers as $t) $data['teacher_map'][$t->pers_id] = $t->pers_prefix.$t->pers_firstname;

        return view('admin/Academic/AdminTimetable/Partials/ViewClassTimetable', $data);
    }

    public function editor()
    {
        $class_name = $this->request->getGet('class');
        if (empty($class_name)) {
            return redirect()->to(base_url('admin/academic/timetable/process'));
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "จัดการตารางห้อง $class_name";
        $data['class_name'] = $class_name;
        $data['term'] = $term;
        $data['year'] = $year;

        // Get assignments for this specific class
        $data['class_assignments'] = $this->db_timetable->table('tb_timetable_assignments')
                                    ->select('tb_timetable_assignments.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                                    ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                                    ->where('class_name', $class_name)
                                    ->where('tb_timetable_assignments.term', $term)
                                    ->where('tb_timetable_assignments.year', $year)
                                    ->get()->getResult();

        // Get Teachers for lookup
        $data['teachers'] = $this->db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                                ->get()->getResult();

        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        $data['master_slots'] = $this->modConfig->getMasterSlots($term, $year);

        // 🚀 Fetch Constraints for all teachers in this class
        $class_teacher_ids = [];
        foreach($data['class_assignments'] as $ca) {
            $ids = explode(',', $ca->teacher_id);
            $class_teacher_ids = array_merge($class_teacher_ids, $ids);
        }
        $class_teacher_ids = array_unique(array_filter($class_teacher_ids));
        
        $data['teacher_constraints'] = [];
        if(!empty($class_teacher_ids)) {
            $data['teacher_constraints'] = $this->db_timetable->table('tb_timetable_constraints')
                ->whereIn('teacher_id', $class_teacher_ids)
                ->where(['term' => $term, 'year' => $year])
                ->get()->getResult();
        }

        return view('admin/Academic/AdminTimetable/EditorMain', $data);
    }

    public function saveSlot()
    {
        $this->invalidateTimetable();
        $assign_id = $this->request->getPost('assign_id');
        $day = $this->request->getPost('day');
        $start_period = (int)$this->request->getPost('period');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $assign = $this->modTimetable->find($assign_id);
        if (!$assign) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลการมอบหมาย']);

        // Determine Block Size based on Split Pattern
        $placed_count = $this->db_timetable->table('tb_timetable_data')
                        ->where('assign_id', $assign_id)
                        ->where('term', $term)->where('year', $year)
                        ->countAllResults();
        
        $splits = explode(',', $assign->period_split);
        $current_total = 0;
        $block_size = 1;
        foreach($splits as $s) {
            $s = (int)$s;
            if($placed_count >= $current_total && $placed_count < ($current_total + $s)) {
                $block_size = $s; break;
            }
            $current_total += $s;
        }

        $end_period = $start_period + $block_size - 1;
        $max_p = $this->db_timetable->table('tb_timetable_config_periods')->countAllResults();
        if ($end_period > $max_p) {
            return $this->response->setJSON(['status' => 'error', 'message' => "ไม่สามารถวางบล็อก $block_size คาบได้ (เกินเวลา)"]);
        }

        // 🚀 Same Day Constraint: check if this subject already exists on this day
        $sameDayCheck = $this->db_timetable->table('tb_timetable_data')
            ->where('assign_id', $assign_id)
            ->where('day', $day)
            ->where('term', $term)
            ->where('year', $year)
            ->countAllResults();
        if ($sameDayCheck > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'วิชานี้มีคาบสอนในวันนี้แล้ว ไม่สามารถวางซ้ำซ้อนได้ (ตามเงื่อนไขการหั่นคาบ)']);
        }

        $this->db_timetable->transStart();
        // 🚀 Group-Aware Constraint Check
        $group_members = (!empty($assign->group_id))
            ? $this->db_timetable->table('tb_timetable_assignments')->where('group_id', $assign->group_id)->get()->getResult()
            : [$assign];

        $has_junior = false; $has_senior = false;
        foreach ($group_members as $member) {
            if (preg_match('/ม\.[1-3]/', $member->class_name) || preg_match('/^[1-3]/', $member->class_name)) $has_junior = true;
            if (preg_match('/ม\.[4-6]/', $member->class_name) || preg_match('/^[4-6]/', $member->class_name)) $has_senior = true;
        }

        for ($p = $start_period; $p <= $end_period; $p++) {
            // Check Lunch Breaks
            if ($has_junior && $p == 4) {
                $this->db_timetable->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p เป็นเวลาพักของ ม.ต้น (ในกลุ่มมี ม.ต้น เรียนด้วย)"]);
            }
            if ($has_senior && $p == 5) {
                $this->db_timetable->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p เป็นเวลาพักของ ม.ปลาย (ในกลุ่มมี ม.ปลาย เรียนด้วย)"]);
            }

            // Check School Master Slots for all involved levels
            $levels = ['ALL'];
            if ($has_junior) $levels[] = 'Junior';
            if ($has_senior) $levels[] = 'Senior';

            $is_master = $this->db_timetable->table('tb_timetable_config_master_slots')
                            ->where(['day' => $day, 'period' => $p, 'term' => $term, 'year' => $year])
                            ->whereIn('level_group', $levels)
                            ->countAllResults();
            if ($is_master > 0) {
                $this->db_timetable->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p ติดกิจกรรมโรงเรียนของระดับชั้นในกลุ่ม"]);
            }

            // 2. Check Class Conflict (Room Busy)
            // Get all assign_ids for this specific room to avoid JOIN in WHERE
            $room_assign_ids = array_column(
                $this->db_timetable->table('tb_timetable_assignments')
                    ->select('assign_id')
                    ->where('class_name', $assign->class_name)
                    ->get()->getResultArray(), 
                'assign_id'
            );

            $classConflict = 0;
            if (!empty($room_assign_ids)) {
                $classConflict = $this->db_timetable->table('tb_timetable_data')
                    ->whereIn('assign_id', $room_assign_ids)
                    ->where([
                        'day' => $day, 
                        'period' => $p, 
                        'term' => $term, 
                        'year' => $year
                    ])
                    ->countAllResults();
            }
            if ($classConflict > 0) {
                $this->db_timetable->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p มีวิชาอื่นอยู่แล้ว!"]);
            }

            // 3. Check Teacher Conflict
            $teacher_ids = explode(',', $assign->teacher_id);
            foreach ($teacher_ids as $tid) {
                $tid = trim($tid);
                if (empty($tid)) continue;

                // Get all assign_ids for this teacher to avoid JOIN in WHERE
                $teacher_assign_ids = array_column(
                    $this->db_timetable->table('tb_timetable_assignments')
                        ->select('assign_id')
                        ->where("FIND_IN_SET('$tid', teacher_id) >", 0)
                        ->get()->getResultArray(),
                    'assign_id'
                );

                $teacherConflict = 0;
                if (!empty($teacher_assign_ids)) {
                    $teacherConflict = $this->db_timetable->table('tb_timetable_data')
                        ->whereIn('assign_id', $teacher_assign_ids)
                        ->where([
                            'day' => $day, 
                            'period' => $p, 
                            'term' => $term, 
                            'year' => $year
                        ])
                        ->countAllResults();
                }
                
                // 🚀 Check Teacher Constraints (Teacher Locks)
                $is_teacher_locked = $this->db_timetable->table('tb_timetable_constraints')
                    ->where([
                        'teacher_id' => $tid, 
                        'day' => $day, 
                        'period' => $p, 
                        'term' => $term, 
                        'year' => $year
                    ])->countAllResults();

                if ($teacherConflict > 0 || $is_teacher_locked > 0) {
                    $this->db_timetable->transRollback();
                    $msg = ($is_teacher_locked > 0) ? "ครูท่านนี้ถูกล็อคเวลาไม่ว่างในคาบที่ $p" : "ครูมีคาบสอนในคาบที่ $p แล้ว!";
                    return $this->response->setJSON(['status' => 'error', 'message' => $msg]);
                }
            }

            $this->db_timetable->table('tb_timetable_data')->insert([
                'assign_id' => $assign_id, 
                'day' => $day, 
                'period' => $p, 
                'term' => $term, 
                'year' => $year,
                'is_locked' => 1 // 🔒 การจัดมือถือว่าเป็นการล็อคอัตโนมัติ เพื่อไม่ให้หายเมื่อรีตาราง
            ]);
        }
        $this->db_timetable->transComplete();
        return $this->response->setJSON([
            'status' => 'success', 
            'message' => "บันทึกสำเร็จ ($block_size คาบ)",
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function deleteSlot()
    {
        $this->invalidateTimetable();
        $data_id = $this->request->getPost('data_id');
        
        // 1. Find the target record
        $target = $this->db_timetable->table('tb_timetable_data')->where('data_id', $data_id)->get()->getRow();
        if (!$target) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);

        // 2. Find all periods for this assignment on the same day
        $siblings = $this->db_timetable->table('tb_timetable_data')
                    ->where([
                        'assign_id' => $target->assign_id,
                        'day'       => $target->day,
                        'term'      => $target->term,
                        'year'      => $target->year
                    ])
                    ->orderBy('period', 'ASC')
                    ->get()->getResult();

        // 3. Identify the consecutive block that contains our target period
        $block_ids = [];
        $current_block = [];
        $found_target = false;

        for ($i = 0; $i < count($siblings); $i++) {
            if ($i > 0 && ($siblings[$i]->period != $siblings[$i-1]->period + 1)) {
                // Gap found, check if previous block had our target
                if ($found_target) break;
                $current_block = [];
            }
            
            $current_block[] = $siblings[$i]->data_id;
            if ($siblings[$i]->data_id == $data_id) $found_target = true;

            if ($i == count($siblings) - 1 && $found_target) {
                // End of list and we found target in last block
                break;
            }
        }
        
        $block_ids = $current_block;

        // 4. Delete the whole block
        if ($this->db_timetable->table('tb_timetable_data')->whereIn('data_id', $block_ids)->delete()) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'ลบคาบเรียนทั้งบล็อกสำเร็จ (' . count($block_ids) . ' คาบ)',
                'csrf_hash' => csrf_hash()
            ]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบได้', 'csrf_hash' => csrf_hash()]);
    }

    public function toggleLock()
    {
        $this->invalidateTimetable();
        $data_id = $this->request->getPost('data_id');
        $is_locked = $this->request->getPost('is_locked');

        // 1. Find the target record
        $target = $this->db_timetable->table('tb_timetable_data')->where('data_id', $data_id)->get()->getRow();
        if (!$target) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);

        // 2. Find all periods for this assignment on the same day to identify the block
        $siblings = $this->db_timetable->table('tb_timetable_data')
                    ->where([
                        'assign_id' => $target->assign_id,
                        'day'       => $target->day,
                        'term'      => $target->term,
                        'year'      => $target->year
                    ])
                    ->orderBy('period', 'ASC')
                    ->get()->getResult();

        // 3. Identify the consecutive block that contains our target period
        $block_ids = [];
        $current_block = [];
        $found_target = false;

        for ($i = 0; $i < count($siblings); $i++) {
            if ($i > 0 && ($siblings[$i]->period != $siblings[$i-1]->period + 1)) {
                if ($found_target) break;
                $current_block = [];
            }
            $current_block[] = $siblings[$i]->data_id;
            if ($siblings[$i]->data_id == $data_id) $found_target = true;
        }
        
        $block_ids = $current_block;

        // 4. Toggle lock for the whole block
        if ($this->db_timetable->table('tb_timetable_data')->whereIn('data_id', $block_ids)->update(['is_locked' => $is_locked])) {
            $msg = $is_locked == 1 ? 'ล็อคคาบเรียนทั้งบล็อกเรียบร้อย' : 'ปลดล็อคคาบเรียนทั้งบล็อกเรียบร้อย';
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => $msg . ' (' . count($block_ids) . ' คาบ)',
                'csrf_hash' => csrf_hash()
            ]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถเปลี่ยนสถานะการล็อคได้', 'csrf_hash' => csrf_hash()]);
    }

    public function moveSlot()
    {
        $this->invalidateTimetable();
        $data_id = $this->request->getPost('data_id');
        $new_day = $this->request->getPost('day');
        $new_start_period = (int)$this->request->getPost('period');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // 1. Identify the block from data_id
        $target = $this->db_timetable->table('tb_timetable_data')->where('data_id', $data_id)->get()->getRow();
        if (!$target) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
        if ($target->is_locked == 1) return $this->response->setJSON(['status' => 'error', 'message' => 'คาบเรียนนี้ถูกล็อคอยู่ ไม่สามารถย้ายได้']);

        $siblings = $this->db_timetable->table('tb_timetable_data')
                    ->where(['assign_id' => $target->assign_id, 'day' => $target->day, 'term' => $term, 'year' => $year])
                    ->orderBy('period', 'ASC')->get()->getResult();

        $current_block = [];
        $found_target = false;
        for ($i = 0; $i < count($siblings); $i++) {
            if ($i > 0 && ($siblings[$i]->period != $siblings[$i-1]->period + 1)) {
                if ($found_target) break;
                $current_block = [];
            }
            $current_block[] = $siblings[$i]->data_id;
            if ($siblings[$i]->data_id == $data_id) $found_target = true;
        }
        $block_size = count($current_block);
        $old_block_ids = $current_block;

        if ($block_size === 0) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบกลุ่มคาบเรียนที่ต้องการย้าย']);

        // 2. Check availability at new location
        $assign = $this->modTimetable->find($target->assign_id);
        if (!$assign) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลการมอบหมายงาน']);

        // 🚀 Same Day Constraint: Check if this assignment already has slots on the new day (excluding our current block)
        $sameDayCheck = $this->db_timetable->table('tb_timetable_data')
            ->where('assign_id', $target->assign_id)
            ->where('day', $new_day)
            ->where('term', $term)
            ->where('year', $year)
            ->whereNotIn('data_id', $old_block_ids)
            ->countAllResults();
        if ($sameDayCheck > 0) return $this->response->setJSON(['status' => 'error', 'message' => 'วิชานี้มีคาบสอนในวันนี้แล้ว ไม่สามารถย้ายมาซ้ำซ้อนได้ (ตามเงื่อนไขการหั่นคาบ)']);

        $new_end_period = $new_start_period + $block_size - 1;
        $max_p = $this->db_timetable->table('tb_timetable_config_periods')->countAllResults();
        if ($new_end_period > $max_p) return $this->response->setJSON(['status' => 'error', 'message' => 'เกินเวลาตารางสอน']);

        // 🚀 Group-Aware Constraint Check
        $group_members = (!empty($assign->group_id))
            ? $this->db_timetable->table('tb_timetable_assignments')->where('group_id', $assign->group_id)->get()->getResult()
            : [$assign];

        $has_junior = false; $has_senior = false;
        foreach ($group_members as $member) {
            if (preg_match('/ม\.[1-3]/', $member->class_name) || preg_match('/^[1-3]/', $member->class_name)) $has_junior = true;
            if (preg_match('/ม\.[4-6]/', $member->class_name) || preg_match('/^[4-6]/', $member->class_name)) $has_senior = true;
        }

        for ($p = $new_start_period; $p <= $new_end_period; $p++) {
            // Check Lunch Breaks
            if ($has_junior && $p == 4) return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p เป็นเวลาพักของ ม.ต้น (ในกลุ่มมี ม.ต้น เรียนด้วย)"]);
            if ($has_senior && $p == 5) return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p เป็นเวลาพักของ ม.ปลาย (ในกลุ่มมี ม.ปลาย เรียนด้วย)"]);

            // Check School Master Slots for all involved levels
            $levels = ['ALL'];
            if ($has_junior) $levels[] = 'Junior';
            if ($has_senior) $levels[] = 'Senior';

            $is_master = $this->db_timetable->table('tb_timetable_config_master_slots')
                            ->where(['day' => $new_day, 'period' => $p, 'term' => $term, 'year' => $year])
                            ->whereIn('level_group', $levels)
                            ->countAllResults();
            if ($is_master > 0) return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p ติดกิจกรรมโรงเรียนของระดับชั้นในกลุ่ม"]);

            // Class Conflict
            $classConflict = $this->db_timetable->table('tb_timetable_data')
                ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                ->where('tb_timetable_assignments.class_name', $assign->class_name)
                ->where([
                    'tb_timetable_data.day' => $new_day, 
                    'tb_timetable_data.period' => $p, 
                    'tb_timetable_data.term' => $term, 
                    'tb_timetable_data.year' => $year
                ])
                ->whereNotIn('tb_timetable_data.data_id', $old_block_ids)
                ->countAllResults();
            if ($classConflict > 0) return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p มีวิชาอื่นอยู่แล้ว!"]);

            // Teacher Conflict
            $teacher_ids = explode(',', $assign->teacher_id);
            foreach ($teacher_ids as $tid) {
                $teacherConflict = $this->db_timetable->table('tb_timetable_data')
                    ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                    ->where("FIND_IN_SET('$tid', tb_timetable_assignments.teacher_id) >", 0)
                    ->where([
                        'tb_timetable_data.day' => $new_day, 
                        'tb_timetable_data.period' => $p, 
                        'tb_timetable_data.term' => $term, 
                        'tb_timetable_data.year' => $year
                    ])
                    ->whereNotIn('tb_timetable_data.data_id', $old_block_ids)
                    ->countAllResults();
                
                // 🚀 Check Teacher Constraints (Teacher Locks)
                $is_teacher_locked = $this->db_timetable->table('tb_timetable_constraints')
                    ->where([
                        'teacher_id' => $tid, 
                        'day' => $new_day, 
                        'period' => $p, 
                        'term' => $term, 
                        'year' => $year
                    ])->countAllResults();

                if ($teacherConflict > 0 || $is_teacher_locked > 0) {
                    $msg = ($is_teacher_locked > 0) ? "ครูท่านนี้ถูกล็อคเวลาไม่ว่างในคาบที่ $p" : "ครูมีคาบสอนในคาบที่ $p แล้ว!";
                    return $this->response->setJSON(['status' => 'error', 'message' => $msg]);
                }
            }
        }

        // 3. Move it
        $this->db_timetable->transStart();
        $idx = 0;
        for ($p = $new_start_period; $p <= $new_end_period; $p++) {
            $this->db_timetable->table('tb_timetable_data')->where('data_id', $old_block_ids[$idx])
                ->update(['day' => $new_day, 'period' => $p]);
            $idx++;
        }
        $this->db_timetable->transComplete();

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'ย้ายคาบเรียนสำเร็จ',
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function clearClassTimetable()
    {
        $class_name = $this->request->getPost('class_name');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $this->db_timetable->table('tb_timetable_data')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->where('tb_timetable_assignments.class_name', $class_name)
            ->where('tb_timetable_data.term', $term)
            ->where('tb_timetable_data.year', $year)
            ->delete();

        return $this->response->setJSON(['status' => 'success', 'message' => "ล้างตารางห้อง $class_name สำเร็จ"]);
    }

    // --- TIMETABLE SETTINGS ---
    public function masterSettings()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ตั้งค่าตารางหลัก (Master Timetable)";
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        $data['master_slots'] = $this->modConfig->getMasterSlots($term, $year);
        $data['term'] = $term;
        $data['year'] = $year;

        return view('admin/Academic/AdminTimetable/MasterSettings', $data);
    }

    public function saveMasterSlot()
    {
        $this->invalidateTimetable();
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data = [
            'day' => $this->request->getPost('day'),
            'period' => $this->request->getPost('period'),
            'subject_name' => $this->request->getPost('subject_name'),
            'level_group' => $this->request->getPost('level_group'),
            'term' => $term,
            'year' => $year
        ];

        if ($this->modConfig->saveMasterSlot($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกตารางหลักสำเร็จ']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกได้']);
    }

    public function settings()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ตั้งค่าระบบตารางสอน";
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        
        return view('admin/Academic/AdminTimetable/Settings', $data);
    }

    // --- TEACHER CONSTRAINTS (Teacher Locks) ---
    public function teacherConstraints()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);
        $teacher_id = $this->request->getGet('teacher_id');

        $data['title'] = "จัดการเงื่อนไขครู (Teacher Constraints)";
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        $data['teachers'] = $this->db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                                ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                                ->orderBy('pers_firstname', 'ASC')
                                ->get()->getResult();
        
        $data['selected_teacher'] = $teacher_id;
        $data['constraints'] = [];
        if ($teacher_id) {
            $data['constraints'] = $this->db_timetable->table('tb_timetable_constraints')
                ->where(['teacher_id' => $teacher_id, 'term' => $term, 'year' => $year])
                ->get()->getResult();
        }

        // Fetch ALL constraints for summary table
        $data['all_constraints'] = $this->db_timetable->table('tb_timetable_constraints')
            ->select('tb_timetable_constraints.*, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname')
            ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_timetable_constraints.teacher_id', 'left')
            ->where(['term' => $term, 'year' => $year])
            ->orderBy('tb_personnel.pers_firstname', 'ASC')
            ->get()->getResult();
        
        $data['term'] = $term;
        $data['year'] = $year;

        return view('admin/Academic/AdminTimetable/TeacherConstraints', $data);
    }

    public function getMasterTeacherLockGrid()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        
        // 1. Get all active teachers grouped by learning group
        $teachers = $this->db_personnel->table('tb_personnel')
                        ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_learning')
                        ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                        ->where('pers_status', 'กำลังใช้งาน')
                        ->orderBy('pers_learning', 'ASC')
                        ->orderBy('pers_firstname', 'ASC')
                        ->get()->getResult();
        $data['teachers'] = $teachers;

        // 2. Get all teacher locks
        $locks = $this->db_timetable->table('tb_timetable_constraints')
                        ->where(['term' => $term, 'year' => $year])
                        ->get()->getResult();
        
        // Group locks: [teacher_id][day][period]
        $lockMap = [];
        foreach($locks as $l) {
            $lockMap[$l->teacher_id][$l->day][$l->period] = $l;
        }
        $data['lockMap'] = $lockMap;

        return view('admin/Academic/AdminTimetable/Partials/MasterTeacherLockGrid', $data);
    }

    public function saveTeacherConstraint()
    {
        try {
            $this->invalidateTimetable();
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);

            $teacher_id = $this->request->getPost('teacher_id');
            $day = $this->request->getPost('day');
            $period = $this->request->getPost('period');
            
            // Handle both Wizard (action) and original page (is_locked)
            $action = $this->request->getPost('action');
            $is_locked = $this->request->getPost('is_locked');
            $doLock = ($action === 'lock' || $is_locked == 1);

            if ($doLock) {
                // Prevent duplicates
                $exists = $this->db_timetable->table('tb_timetable_constraints')
                    ->where(['teacher_id' => $teacher_id, 'day' => $day, 'period' => $period, 'term' => $term, 'year' => $year])
                    ->countAllResults();
                
                if (!$exists) {
                    $this->db_timetable->table('tb_timetable_constraints')->insert([
                        'teacher_id' => $teacher_id,
                        'day' => $day,
                        'period' => $period,
                        'term' => $term,
                        'year' => $year,
                        'reason' => 'ล็อคโดยผู้ดูแล'
                    ]);
                }
            } else {
                $this->db_timetable->table('tb_timetable_constraints')
                    ->where(['teacher_id' => $teacher_id, 'day' => $day, 'period' => $period, 'term' => $term, 'year' => $year])
                    ->delete();
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตเงื่อนไขครูสำเร็จ', 'csrf_hash' => csrf_hash()]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Internal Server Error: ' . $e->getMessage(), 'csrf_hash' => csrf_hash()]);
        }
    }

    public function updateDay()
    {
        $this->invalidateTimetable();
        $day_id = $this->request->getPost('day_id');
        $is_active = $this->request->getPost('is_active');
        
        if ($this->modConfig->updateDay($day_id, ['is_active' => $is_active])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตวันทำการสำเร็จ']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตได้']);
    }

    public function savePeriod()
    {
        $this->invalidateTimetable();
        $data = [
            'period_id'     => $this->request->getPost('period_id'),
            'period_number' => $this->request->getPost('period_number'),
            'start_time'    => $this->request->getPost('start_time'),
            'end_time'      => $this->request->getPost('end_time'),
            'is_break'      => $this->request->getPost('is_break') ?: 0,
            'level_group'   => $this->request->getPost('level_group') ?: 'ALL'
        ];

        if ($this->modConfig->savePeriod($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลคาบเรียนสำเร็จ']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกได้']);
    }

    public function deletePeriod()
    {
        $this->invalidateTimetable();
        $id = $this->request->getPost('period_id');
        if ($this->modConfig->deletePeriod($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบคาบเรียนสำเร็จ']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบได้']);
    }

    // --- ASSIGNMENTS MANAGEMENT ---
    public function classTimetables()
    {
        if (!$this->checkTimetableCompletion()) {
            return redirect()->to(base_url('admin/academic/timetable/process'))->with('error', 'ข้อมูลมีการเปลี่ยนแปลงหรือตารางยังไม่สมบูรณ์ กรุณาประมวลผล AI ในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนเข้าดูตารางครับ');
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ตารางเรียนรายห้อง";
        $data['term'] = $term;
        $data['year'] = $year;

        // Get unique classes for this term/year
        $classes = $this->db_timetable->table('tb_timetable_assignments')
                    ->select('class_name')
                    ->distinct()
                    ->where('term', $term)
                    ->where('year', $year)
                    ->orderBy('class_name', 'ASC')
                    ->get()->getResult();

        $grouped = [];
        foreach($classes as $c) {
            // Group by level (e.g., ม.1/1 -> ม.1)
            $level = explode('/', $c->class_name)[0];
            $grouped[$level][] = $c->class_name;
        }
        $data['groupedClasses'] = $grouped;

        return view('admin/Academic/AdminTimetable/ClassList', $data);
    }

    public function teacherTimetables()
    {
        if (!$this->checkTimetableCompletion()) {
            return redirect()->to(base_url('admin/academic/timetable/process'))->with('error', 'ข้อมูลมีการเปลี่ยนแปลงหรือตารางยังไม่สมบูรณ์ กรุณาประมวลผล AI ในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนเข้าดูตารางครับ');
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ตารางสอนรายครู";
        $data['term'] = $term;
        $data['year'] = $year;

        // Get Teachers with Official Position and Learning Group names + Total Hours Assigned
        // Start from tb_personnel but use the main db connection to avoid prefix issues with assignments
        // 📊 Calculate Total Hours Assigned (Respecting Combined Groups)
        $subquery = $this->db_timetable->table('skjacth_timetable.tb_timetable_assignments')
                        ->select('COALESCE(group_id, CAST(assign_id AS CHAR)) as unique_key, MAX(hours_per_week) as hours, teacher_id')
                        ->where(['term' => $term, 'year' => $year])
                        ->groupBy('unique_key, teacher_id')
                        ->getCompiledSelect();

        $teachers = $this->db_personnel->table('tb_personnel')
                        ->select('tb_personnel.*, 
                                  skjacth_skj.tb_position.posi_name, 
                                  skjacth_skj.tb_learning.lear_namethai')
                        ->select('(SELECT SUM(hours) FROM (' . $subquery . ') as sub WHERE FIND_IN_SET(tb_personnel.pers_id, sub.teacher_id) > 0) as total_hours')
                        ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = tb_personnel.pers_position', 'left')
                        ->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = tb_personnel.pers_learning', 'left')
                        ->whereIn('skjacth_personnel.tb_personnel.pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                        ->where('skjacth_personnel.tb_personnel.pers_status', 'กำลังใช้งาน')
                        ->orderBy('skjacth_personnel.tb_personnel.pers_learning', 'ASC')
                        ->orderBy('skjacth_personnel.tb_personnel.pers_firstname', 'ASC')
                        ->get()->getResult();

        $grouped = [];
        foreach($teachers as $t) {
            $group = $t->lear_namethai ?: 'ไม่ระบุกลุ่มสาระฯ';
            $grouped[$group][] = $t;
        }
        $data['groupedTeachers'] = $grouped;

        return view('admin/Academic/AdminTimetable/TeacherList', $data);
    }

    public function full()
    {
        if (!$this->checkTimetableCompletion()) {
            return redirect()->to(base_url('admin/academic/timetable/process'))->with('error', 'ข้อมูลมีการเปลี่ยนแปลงหรือตารางยังไม่สมบูรณ์ กรุณาประมวลผล AI ในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนเข้าดูตารางครับ');
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "ตารางสอนรวมทั้งโรงเรียน";
        $data['term'] = $term;
        $data['year'] = $year;

        // Get active days and periods
        $data['days'] = $this->db_timetable->table('tb_timetable_config_days')->where('is_active', 1)->orderBy('day_id', 'ASC')->get()->getResult();
        $data['periods'] = $this->db_timetable->table('tb_timetable_config_periods')->orderBy('period_number', 'ASC')->get()->getResult();

        // Get All Timetable Data
        $timetableData = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name, tb_timetable_assignments.subject_id, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where('tb_timetable_data.term', $term)
            ->where('tb_timetable_data.year', $year)
            ->get()->getResult();

        // Get All Personnel for names
        $teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_firstname')->get()->getResult();
        $teacherMap = [];
        foreach($teachers as $t) $teacherMap[$t->pers_id] = $t->pers_firstname;
        $data['teacherMap'] = $teacherMap;

        // Group data for easy access: [day][class][period]
        $grouped = [];
        $teacherUsage = []; // [day][period][teacher_id] = [class_name, ...]
        
        foreach($timetableData as $row) {
            $grouped[$row->day][$row->class_name][$row->period] = $row;
            
            // Track teacher usage to find conflicts
            $tids = explode(',', $row->teacher_id);
            foreach($tids as $tid) {
                $teacherUsage[$row->day][$row->period][$tid][] = $row->class_name;
            }
        }
        
        // Get Master Slots (Locked subjects)
        $masterSlots = $this->db_timetable->table('tb_timetable_config_master_slots')
            ->where('term', $term)
            ->where('year', $year)
            ->get()->getResult();

        $data['grouped'] = $grouped;
        $data['teacherUsage'] = $teacherUsage;
        $data['masterSlots'] = $masterSlots;

        // Map master slots by day, period and level group
        $masterMap = [];
        foreach($masterSlots as $ms) {
            // Group by day -> period -> level_group
            $masterMap[$ms->day][$ms->period][$ms->level_group] = $ms;
        }
        $data['masterMap'] = $masterMap;

        // Get unique class names sorted
        $classes = $this->db_timetable->table('tb_timetable_assignments')
                    ->select('class_name')
                    ->distinct()
                    ->where('term', $term)
                    ->where('year', $year)
                    ->orderBy('class_name', 'ASC')
                    ->get()->getResult();
        $data['classList'] = array_column($classes, 'class_name');

        return view('admin/Academic/AdminTimetable/FullTimetable', $data);
    }

    public function index()
    {
        return redirect()->to(base_url('admin/academic/timetable/process'));
    }

    public function viewClass($className = null)
    {
        if (!$this->checkTimetableCompletion()) {
            return redirect()->to(base_url('admin/academic/timetable/process'))->with('error', 'ข้อมูลมีการเปลี่ยนแปลงหรือตารางยังไม่สมบูรณ์ กรุณาประมวลผล AI ในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนเข้าดูตารางครับ');
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);
        if(!$className) $className = $this->request->getGet('class');

        $data['title'] = "ตารางเรียนห้อง $className";
        $data['target_name'] = "ห้องเรียน: $className";
        $data['target_type'] = 'class';
        $data['term'] = $term;
        $data['year'] = $year;

        $data['days'] = $this->db_timetable->table('tb_timetable_config_days')->where('is_active', 1)->orderBy('day_id', 'ASC')->get()->getResult();
        
        // 🔍 Determine level for period filtering (Junior: ม.1-3 / Senior: ม.4-6)
        $isSenior = (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className));
        $currentLevel = $isSenior ? 'Senior' : 'Junior';
        $data['lunch_period'] = $isSenior ? 5 : 4;

        // Fetch ALL periods and group them by period_number
        $allPeriods = $this->db_timetable->table('tb_timetable_config_periods')
            ->orderBy('period_number', 'ASC')
            ->get()->getResult();
        
        $finalPeriods = [];
        $tempGroup = [];
        foreach($allPeriods as $p) {
            $tempGroup[$p->period_number][$p->level_group] = $p;
        }

        // For each period number, pick the best match
        foreach($tempGroup as $pNum => $levels) {
            if (isset($levels[$currentLevel])) {
                $finalPeriods[] = $levels[$currentLevel];
            } elseif (isset($levels['ALL'])) {
                $finalPeriods[] = $levels['ALL'];
            } else {
                // If no direct match, pick the first available one to keep the column
                $finalPeriods[] = reset($levels);
            }
        }
        $data['periods'] = $finalPeriods;
        $data['currentLevel'] = $currentLevel;

        $timetableData = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name, tb_timetable_assignments.subject_id, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where(['tb_timetable_assignments.class_name' => $className, 'tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
            ->get()->getResult();

        $teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_firstname')->get()->getResult();
        $teacherMap = [];
        foreach($teachers as $t) $teacherMap[$t->pers_id] = $t->pers_firstname;
        $data['teacherMap'] = $teacherMap;

        $grouped = [];
        foreach($timetableData as $row) {
            $grouped[$row->day][$row->period] = $row;
        }
        $data['grouped'] = $grouped;

        // Get Master Slots for this level
        $masterSlots = $this->db_timetable->table('tb_timetable_config_master_slots')
            ->whereIn('level_group', ['ALL', $currentLevel])
            ->where(['term' => $term, 'year' => $year])
            ->get()->getResult();
        
        $masterMap = [];
        foreach($masterSlots as $ms) {
            $masterMap[$ms->day][$ms->period] = $ms;
        }
        // 📊 Calculate Total Hours for Class
        $totalHours = $this->db_timetable->table('tb_timetable_assignments')
                        ->selectSum('hours_per_week')
                        ->where(['class_name' => $className, 'term' => $term, 'year' => $year])
                        ->get()->getRow()->hours_per_week ?? 0;

        $data['total_hours'] = $totalHours;
        $data['masterMap'] = $masterMap;

        return view('admin/Academic/AdminTimetable/IndividualTimetable', $data);
    }

    public function viewTeacher($teacherId = null)
    {
        if (!$this->checkTimetableCompletion()) {
            return redirect()->to(base_url('admin/academic/timetable/process'))->with('error', 'ข้อมูลมีการเปลี่ยนแปลงหรือตารางยังไม่สมบูรณ์ กรุณาประมวลผล AI ในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนเข้าดูตารางครับ');
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);
        if(!$teacherId) $teacherId = $this->request->getGet('id');

        $teacher = $this->db_personnel->table('tb_personnel')->where('pers_id', $teacherId)->get()->getRow();
        $t_name = $teacher ? ($teacher->pers_prefix . $teacher->pers_firstname . ' ' . $teacher->pers_lastname) : $teacherId;

        // 📊 Calculate Total Hours Assigned (Respecting Combined Groups)
        $subquery = $this->db_timetable->table('tb_timetable_assignments')
                        ->select('COALESCE(group_id, CAST(assign_id AS CHAR)) as unique_key, MAX(hours_per_week) as hours')
                        ->where("FIND_IN_SET('$teacherId', teacher_id) >", 0)
                        ->where(['term' => $term, 'year' => $year])
                        ->groupBy('unique_key')
                        ->get()->getResult();
        
        $totalHours = array_sum(array_column($subquery, 'hours'));

        $data['title'] = "ตารางสอน $t_name";
        $data['target_name'] = "ครูผู้สอน: $t_name";
        $data['total_hours'] = $totalHours;
        $data['target_type'] = 'teacher';
        $data['term'] = $term;
        $data['year'] = $year;

        $data['days'] = $this->db_timetable->table('tb_timetable_config_days')->where('is_active', 1)->orderBy('day_id', 'ASC')->get()->getResult();
        $data['periods'] = $this->db_timetable->table('tb_timetable_config_periods')->orderBy('period_number', 'ASC')->get()->getResult();

        $timetableData = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name, tb_timetable_assignments.subject_id, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where("FIND_IN_SET('$teacherId', tb_timetable_assignments.teacher_id) >", 0)
            ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
            ->get()->getResult();

        $grouped = [];
        foreach($timetableData as $row) {
            $grouped[$row->day][$row->period] = $row;
        }
        $data['grouped'] = $grouped;

        // Get Master Slots
        $masterSlots = $this->db_timetable->table('tb_timetable_config_master_slots')
            ->where(['term' => $term, 'year' => $year])
            ->get()->getResult();
        
        $masterMap = [];
        foreach($masterSlots as $ms) {
            $masterMap[$ms->day][$ms->period] = $ms;
        }
        $data['masterMap'] = $masterMap;

        $teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_firstname')->get()->getResult();
        $teacherMap = [];
        foreach($teachers as $t) $teacherMap[$t->pers_id] = $t->pers_firstname;
        $data['teacherMap'] = $teacherMap;

        return view('admin/Academic/AdminTimetable/IndividualTimetable', $data);
    }

    public function create()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "มอบหมายงานสอนใหม่";
        $data['term'] = $term;
        $data['year'] = $year;
        
        // Get Teachers
        $data['teachers'] = $this->db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                                ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                                ->orderBy('pers_firstname', 'ASC')
                                ->get()->getResult();

        // Get Timetable Subjects for the current year (NOT academic subjects)
        $data['subjects'] = $this->db_timetable->table('tb_timetable_subjects')
                                ->where('term', $term)
                                ->where('year', $year)
                                ->orderBy('tsub_code', 'ASC')
                                ->get()->getResult();

        return view('admin/Academic/AdminTimetable/AssignmentForm', $data);
    }

    public function edit($id)
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $primary = $this->modTimetable->find($id);
        if(!$primary) {
            return redirect()->to(base_url('admin/academic/timetable'))->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }

        // Fetch all classes in this group
        $related = $this->modTimetable->where([
            'teacher_id'     => $primary->teacher_id,
            'subject_id'     => $primary->subject_id,
            'hours_per_week' => $primary->hours_per_week,
            'term'           => $term,
            'year'           => $year
        ])->findAll();

        $primary->class_names = array_column($related, 'class_name');
        $data['assignment'] = $primary;

        $data['title'] = "แก้ไขการมอบหมายงานสอน";
        $data['term'] = $term;
        $data['year'] = $year;

        // Get Subjects for this term/year
        $data['subjects'] = $this->db_timetable->table('tb_timetable_subjects')
                                ->where('term', $term)
                                ->where('year', $year)
                                ->orderBy('tsub_code', 'ASC')
                                ->get()->getResult();

        // Get Teachers (from personnel DB)
        $data['teachers'] = $this->db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                                ->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006'])
                                ->where('pers_status', 'กำลังใช้งาน')
                                ->orderBy('pers_firstname', 'ASC')
                                ->get()->getResult();

        return view('admin/Academic/AdminTimetable/AssignmentForm', $data);
    }

    public function saveAssignment()
    {
        $this->invalidateTimetable();
        
        $edit_ids = $this->request->getPost('edit_ids');
        $teacher_ids = $this->request->getPost('teacher_id');
        $teacher_id_string = is_array($teacher_ids) ? implode(',', $teacher_ids) : $teacher_ids;
        
        $class_names = $this->request->getPost('class_names');
        if (empty($class_names)) $class_names = $this->request->getPost('class_name'); 
        if (!is_array($class_names)) $class_names = [$class_names];

        $term = $this->request->getPost('term');
        $year = $this->request->getPost('year');

        // Validate required fields
        if (empty($term) || empty($year)) {
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);
        }

        $subject_id = $this->request->getPost('subject_id');
        if (empty($subject_id) || empty($teacher_id_string) || empty($class_names) || empty($class_names[0])) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน (วิชา, ครูผู้สอน, ห้องเรียน)'
            ]);
        }

        log_message('info', '[Timetable] saveAssignment: term='.$term.', year='.$year.', subject='.$subject_id.', teachers='.$teacher_id_string.', classes='.implode(',', $class_names).', edit_ids='.$edit_ids);

        $this->db_timetable->transStart();
        
        $existing_group_id = null;
        if (!empty($edit_ids)) {
            $idArray = explode(',', $edit_ids);
            // Get group_id from one of the existing records before deleting
            $existing = $this->modTimetable->whereIn('assign_id', $idArray)->first();
            if ($existing) $existing_group_id = $existing->group_id;
            
            $this->modTimetable->whereIn('assign_id', $idArray)->delete();
        }
        
        foreach ($class_names as $class) {
            if (empty($class)) continue;
            $data = [
                'teacher_id'     => $teacher_id_string,
                'subject_id'     => $subject_id,
                'class_name'     => $class,
                'hours_per_week' => $this->request->getPost('hours_per_week'),
                'period_split'   => $this->request->getPost('period_split'),
                'preferred_time' => $this->request->getPost('preferred_time') ?: 'NONE',
                'group_id'       => $existing_group_id, // Preserve the group!
                'term'           => $term,
                'year'           => $year,
            ];
            $this->modTimetable->insert($data);
        }

        $this->db_timetable->transComplete();

        if ($this->db_timetable->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        } else {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ ' . count($class_names) . ' ห้องเรียน']);
        }
    }

    public function deleteAssignment()
    {
        $this->invalidateTimetable();
        $ids = $this->request->getPost('ids');
        $idArray = explode(',', $ids);
        if ($this->modTimetable->whereIn('assign_id', $idArray)->delete()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }
    }

    public function quickAddSubject()
    {
        $this->invalidateTimetable();
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);
        
        $data = [
            'tsub_code' => $this->request->getPost('SubjectCode'),
            'tsub_name' => $this->request->getPost('SubjectName'),
            'term'      => $term,
            'year'      => $year
        ];

        if ($this->db_timetable->table('tb_timetable_subjects')->insert($data)) {
            $insertID = $this->db_timetable->insertID();
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'บันทึกวิชาสำเร็จ',
                'data' => array_merge(['tsub_id' => $insertID], $data)
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกวิชาได้']);
        }
    }

    public function updateAssignment($id)
    {
        $this->invalidateTimetable();
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // 1. Get the original record to find the group
        $original = $this->modTimetable->find($id);
        if (!$original) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลเดิม']);

        // 2. Delete the entire old group
        $this->db_timetable->table('tb_timetable_assignments')->where([
            'teacher_id'     => $original->teacher_id,
            'subject_id'     => $original->subject_id,
            'hours_per_week' => $original->hours_per_week,
            'term'           => $term,
            'year'           => $year
        ])->delete();

        // 3. Insert new ones
        $teacher_ids = $this->request->getPost('teacher_id');
        $teacher_id_string = is_array($teacher_ids) ? implode(',', $teacher_ids) : $teacher_ids;
        $class_names = $this->request->getPost('class_name');
        if (!is_array($class_names)) $class_names = [$class_names];

        $this->db_timetable->transStart();
        foreach ($class_names as $class) {
            $this->modTimetable->insert([
                'teacher_id'     => $teacher_id_string,
                'subject_id'     => $this->request->getPost('subject_id'),
                'class_name'     => $class,
                'hours_per_week' => $this->request->getPost('hours_per_week'),
                'period_split'   => $this->request->getPost('period_split'),
                'preferred_time' => $this->request->getPost('preferred_time') ?: 'NONE',
                'term'           => $term,
                'year'           => $year,
            ]);
        }
        $this->db_timetable->transComplete();

        if ($this->db_timetable->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตข้อมูลได้']);
        } else {
            return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตข้อมูลสำเร็จ']);
        }
    }

    // --- SUBJECT CONSTRAINTS (Subject Locks by Class) ---
    public function subjectConstraints()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);
        $className = $this->request->getGet('class');

        $data['title'] = "จัดการเงื่อนไขวิชาเรียน (Subject Locks)";
        $data['selected_class'] = $className;
        $data['days'] = $this->modConfig->getDays();

        // ⏰ Determine Level Group
        $level_group = null; 
        if ($className) {
            if (strpos($className, 'ม.4') !== false || strpos($className, 'ม.5') !== false || strpos($className, 'ม.6') !== false) {
                $level_group = 'Senior';
            } else {
                $level_group = 'Junior';
            }
        }

        // ⏰ Fetch ALL unique periods for the header (so columns don't disappear)
        $data['periods'] = $this->db_timetable->table('tb_timetable_config_periods')
            ->select('period_number, MAX(is_break) as is_break') // Get all unique period numbers
            ->groupBy('period_number')
            ->orderBy('period_number', 'ASC')
            ->get()->getResult();

        // If still empty, fallback to 1-10
        if (empty($data['periods'])) {
            $data['periods'] = [];
            for($i=1; $i<=10; $i++) $data['periods'][] = (object)['period_number' => $i, 'is_break' => 0];
        }

        // 🏛️ Fetch Master Slots (Fixed school activities) for this level
        // (We still filter content by level, but the header remains full)
        $master_slots_query = $this->db_timetable->table('tb_timetable_config_master_slots')
            ->where(['term' => $term, 'year' => $year]);
        
        if ($level_group) {
            $master_slots_query->groupStart()
                ->where('level_group', $level_group)
                ->orWhere('level_group', 'ALL')
            ->groupEnd();
        }
        $data['master_slots'] = $master_slots_query->get()->getResult();

        // 🍱 Fetch ALL period configs to check is_break specifically for the selected level group inside the loop
        $data['all_period_configs'] = $this->db_timetable->table('tb_timetable_config_periods')
            ->where(['level_group' => $level_group ?: 'Junior'])
            ->orWhere('level_group', 'ALL')
            ->get()->getResult();
        
        // Get all classes
        $data['classes'] = $this->db_timetable->table('tb_timetable_assignments')
                                ->select('class_name')
                                ->where(['term' => $term, 'year' => $year])
                                ->distinct()
                                ->orderBy('class_name', 'ASC')
                                ->get()->getResult();
        
        $data['locks'] = [];
        $data['assigned_subjects'] = [];

        // 📊 Fetch ALL locks for this term/year for the Summary Table
        $data['all_locks'] = $this->db_timetable->table('tb_timetable_subject_locks')
            ->select('tb_timetable_subject_locks.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_subject_locks.subject_id')
            ->where(['tb_timetable_subject_locks.term' => $term, 'tb_timetable_subject_locks.year' => $year])
            ->orderBy('class_name', 'ASC')
            ->orderBy('day', 'ASC')
            ->orderBy('period', 'ASC')
            ->get()->getResult();

        if ($className) {
            // Get current locks for this class
            $data['locks'] = $this->db_timetable->table('tb_timetable_subject_locks')
                ->select('tb_timetable_subject_locks.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_subject_locks.subject_id')
                ->where(['class_name' => $className, 'tb_timetable_subject_locks.term' => $term, 'tb_timetable_subject_locks.year' => $year])
                ->get()->getResult();

            // Get subjects assigned to THIS class to show in selection
            $data['assigned_subjects'] = $this->db_timetable->table('tb_timetable_assignments')
                ->select('tb_timetable_assignments.subject_id, tb_timetable_assignments.period_split, tb_timetable_assignments.hours_per_week, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
                ->where(['class_name' => $className, 'tb_timetable_assignments.term' => $term, 'tb_timetable_assignments.year' => $year])
                ->distinct()
                ->get()->getResult();
        }

        $data['term'] = $term;
        $data['year'] = $year;

        return view('admin/Academic/AdminTimetable/SubjectConstraints', $data);
    }

    public function saveSubjectLock()
    {
        try {
            $this->invalidateTimetable();
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);

            $className = $this->request->getPost('class_name');
            $subject_id = $this->request->getPost('subject_id');
            $day = $this->request->getPost('day');
            $start_period = (int)$this->request->getPost('period');
            $num_periods = (int)$this->request->getPost('num_periods') ?: 1;

            $move_from_day = $this->request->getPost('move_from_day');
            $move_from_period = $this->request->getPost('move_from_period');

            if ($move_from_day && $move_from_period) {
                $source_target = $this->db_timetable->table('tb_timetable_subject_locks')
                    ->where(['class_name' => $className, 'day' => $move_from_day, 'period' => $move_from_period, 'term' => $term, 'year' => $year])
                    ->get()->getRow();
                if ($source_target) {
                    $this->db_timetable->table('tb_timetable_subject_locks')
                        ->where(['class_name' => $className, 'day' => $move_from_day, 'subject_id' => $source_target->subject_id, 'term' => $term, 'year' => $year])
                        ->delete();
                }
            }

            if ($subject_id) {
                $target_assign = $this->db_timetable->table('tb_timetable_assignments')
                    ->where(['class_name' => $className, 'subject_id' => $subject_id, 'term' => $term, 'year' => $year])
                    ->get()->getRow();
                
                if (!$target_assign) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลวิชา']);

                $group_members = (!empty($target_assign->group_id))
                    ? $this->db_timetable->table('tb_timetable_assignments')->where('group_id', $target_assign->group_id)->get()->getResult()
                    : [$target_assign];

                $member_classes = array_column($group_members, 'class_name');

                foreach ($group_members as $member) {
                    // 🍱 1.5 Strict Lunch Break Check for each member
                    $has_junior = false; $has_senior = false;
                    foreach ($group_members as $m) {
                        if (preg_match('/ม\.[1-3]/', $m->class_name) || preg_match('/^[1-3]/', $m->class_name)) $has_junior = true;
                        if (preg_match('/ม\.[4-6]/', $m->class_name) || preg_match('/^[4-6]/', $m->class_name)) $has_senior = true;
                    }
                    
                    for ($i = 0; $i < $num_periods; $i++) {
                        $p = $start_period + $i;
                        if ($has_junior && $p == 4) {
                            return $this->response->setJSON(['status' => 'error', 'message' => "ไม่สามารถล็อคคาบนี้ได้ เนื่องจากในกลุ่มมี ม.ต้น ซึ่งพักกลางวันในคาบที่ 4"]);
                        }
                        if ($has_senior && $p == 5) {
                            return $this->response->setJSON(['status' => 'error', 'message' => "ไม่สามารถล็อคคาบนี้ได้ เนื่องจากในกลุ่มมี ม.ปลาย ซึ่งพักกลางวันในคาบที่ 5"]);
                        }

                        // Check Master Slots for all involved levels
                        $levels = ['ALL'];
                        if ($has_junior) $levels[] = 'Junior';
                        if ($has_senior) $levels[] = 'Senior';

                        $is_master = $this->db_timetable->table('tb_timetable_config_master_slots')
                                        ->where(['day' => $day, 'period' => $p, 'term' => $term, 'year' => $year])
                                        ->whereIn('level_group', $levels)
                                        ->countAllResults();
                        if ($is_master > 0) return $this->response->setJSON(['status' => 'error', 'message' => "คาบที่ $p ติดกิจกรรมโรงเรียนของระดับชั้นในกลุ่ม"]);
                    }

                    // 🔍 2. Conflict Check
                    $teacher_ids = array_map('trim', explode(',', $member->teacher_id));
                    foreach ($teacher_ids as $tid) {
                        if (empty($tid)) continue;
                        $conflict = $this->db_timetable->table('tb_timetable_data')
                            ->select('tb_timetable_data.*, tb_timetable_assignments.class_name')
                            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                            ->where("FIND_IN_SET('$tid', tb_timetable_assignments.teacher_id) >", 0)
                            ->where(['tb_timetable_data.day' => $day, 'tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
                            ->whereNotIn('tb_timetable_assignments.class_name', $member_classes)
                            ->groupStart()
                                ->where('tb_timetable_data.period >=', $start_period)
                                ->where('tb_timetable_data.period <', $start_period + $num_periods)
                            ->groupEnd()
                            ->get()->getRow();

                        if ($conflict) return $this->response->setJSON(['status' => 'error', 'message' => "ครูมีสอนที่ห้อง {$conflict->class_name} ในคาบนี้"]);
                    }

                    for ($i = 0; $i < $num_periods; $i++) {
                        $p = $start_period + $i;
                        $this->db_timetable->table('tb_timetable_subject_locks')
                            ->where(['class_name' => $member->class_name, 'day' => $day, 'period' => $p, 'term' => $term, 'year' => $year])
                            ->delete();

                        $this->db_timetable->table('tb_timetable_subject_locks')->insert([
                            'class_name' => $member->class_name, 'subject_id' => $member->subject_id, 'day' => $day, 'period' => $p, 'term' => $term, 'year' => $year
                        ]);
                    }
                }
                $affected_classes = $member_classes;
            } else {
                $target = $this->db_timetable->table('tb_timetable_subject_locks')
                    ->where(['class_name' => $className, 'day' => $day, 'period' => $start_period, 'term' => $term, 'year' => $year])
                    ->get()->getRow();

                if ($target) {
                    $assign = $this->db_timetable->table('tb_timetable_assignments')->where(['class_name' => $className, 'subject_id' => $target->subject_id, 'term' => $term, 'year' => $year])->get()->getRow();
                    $affected_members = ($assign && $assign->group_id) 
                        ? $this->db_timetable->table('tb_timetable_assignments')->where('group_id', $assign->group_id)->get()->getResult()
                        : [(object)['class_name' => $className, 'subject_id' => $target->subject_id]];

                    foreach ($affected_members as $m) {
                        $this->db_timetable->table('tb_timetable_subject_locks')
                            ->where(['class_name' => $m->class_name, 'day' => $day, 'term' => $term, 'year' => $year])
                            ->where('subject_id', $m->subject_id)
                            ->delete();
                    }
                    $affected_classes = array_column($affected_members, 'class_name');
                } else {
                    $affected_classes = [$className];
                }
            }

            if (isset($affected_classes)) {
                foreach ($affected_classes as $cls) {
                    $class_assign_ids = $this->db_timetable->table('tb_timetable_assignments')->select('assign_id')->where(['class_name' => $cls, 'term' => $term, 'year' => $year])->get()->getResultArray();
                    $assign_ids = array_column($class_assign_ids, 'assign_id');
                    if (!empty($assign_ids)) {
                        $this->db_timetable->table('tb_timetable_data')->where(['term' => $term, 'year' => $year])->whereIn('assign_id', $assign_ids)->delete();
                    }
                    $current_locks = $this->db_timetable->table('tb_timetable_subject_locks')->where(['class_name' => $cls, 'term' => $term, 'year' => $year])->get()->getResult();
                    foreach ($current_locks as $lock) {
                        $asgn = $this->db_timetable->table('tb_timetable_assignments')->where(['class_name' => $lock->class_name, 'subject_id' => $lock->subject_id, 'term' => $term, 'year' => $year])->get()->getRow();
                        if ($asgn) {
                            $this->db_timetable->table('tb_timetable_data')->insert(['assign_id' => $asgn->assign_id, 'day' => $lock->day, 'period' => $lock->period, 'term' => $term, 'year' => $year, 'is_locked' => 1]);
                        }
                    }
                }
            }
            return $this->response->setJSON(['status' => 'success', 'message' => 'ดำเนินการเรียบร้อยแล้ว']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // --- SUBJECT GROUPS (Simultaneous Classes) ---
    public function subjectGroups()
    {
        // 🛠️ Auto-create tables & columns
        $this->db_timetable->query("CREATE TABLE IF NOT EXISTS tb_timetable_subject_groups (
            group_id INT AUTO_INCREMENT PRIMARY KEY,
            group_name VARCHAR(255) NOT NULL,
            term VARCHAR(5) NOT NULL,
            year VARCHAR(5) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $fields = $this->db_timetable->getFieldNames('tb_timetable_assignments');
        if (!in_array('group_id', $fields)) {
            $this->db_timetable->query("ALTER TABLE tb_timetable_assignments ADD COLUMN group_id INT DEFAULT NULL AFTER preferred_time");
        }

        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['title'] = "จัดการกลุ่มวิชาเรียนพร้อมกัน (Joint Periods)";
        $data['term'] = $term;
        $data['year'] = $year;

        // Fetch all groups
        $data['groups'] = $this->db_timetable->table('tb_timetable_subject_groups')
            ->where(['term' => $term, 'year' => $year])
            ->get()->getResult();

        // Fetch all assignments NOT in a group yet (for adding to group)
        $data['assignments'] = $this->db_timetable->table('tb_timetable_assignments')
            ->select('tb_timetable_assignments.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where(['tb_timetable_assignments.term' => $term, 'tb_timetable_assignments.year' => $year])
            ->get()->getResult();

        return view('admin/Academic/AdminTimetable/SubjectGroups', $data);
    }

    public function saveSubjectGroup()
    {
        try {
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);

            $groupId = $this->request->getPost('group_id');
            $groupName = $this->request->getPost('group_name');
            $assignmentIds = $this->request->getPost('assignment_ids'); // Array

            if ($groupId) {
                // Update
                $this->db_timetable->table('tb_timetable_subject_groups')
                    ->where('group_id', $groupId)
                    ->update(['group_name' => $groupName]);
            } else {
                // Insert
                $this->db_timetable->table('tb_timetable_subject_groups')->insert([
                    'group_name' => $groupName,
                    'term' => $term,
                    'year' => $year
                ]);
                $groupId = $this->db_timetable->insertID();
            }

            // Clear previous assignments in this group
            $this->db_timetable->table('tb_timetable_assignments')
                ->where('group_id', $groupId)
                ->update(['group_id' => null]);

            // Link new assignments
            if (!empty($assignmentIds)) {
                $this->db_timetable->table('tb_timetable_assignments')
                    ->whereIn('assign_id', $assignmentIds)
                    ->update(['group_id' => $groupId]);
            }

            $this->invalidateTimetable();
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกกลุ่มวิชาเรียนสำเร็จ']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteSubjectGroup($id)
    {
        // Unlink assignments
        $this->db_timetable->table('tb_timetable_assignments')
            ->where('group_id', $id)
            ->update(['group_id' => null]);

        // Delete group
        $this->db_timetable->table('tb_timetable_subject_groups')
            ->where('group_id', $id)
            ->delete();

        $this->invalidateTimetable();
        return $this->response->setJSON(['status' => 'success', 'message' => 'ลบกลุ่มวิชาเรียนสำเร็จ']);
    }

    public function getSuggestedTeachers()
    {
        $subject_id = $this->request->getGet('subject_id');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // 1. Get the subject code for the selected subject_id
        $subject = $this->db_timetable->table('tb_timetable_subjects')
            ->where('tsub_id', $subject_id)
            ->get()->getRow();

        if (!$subject) {
            return $this->response->setJSON([]);
        }

        // 2. Find teachers who have submitted plans for this subject code
        // We link by tsub_code = seplan_coursecode
        $suggested = $this->db->table('tb_send_plan')
            ->select('tb_send_plan.seplan_usersend as pers_id, p.pers_prefix, p.pers_firstname, p.pers_lastname')
            ->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = tb_send_plan.seplan_usersend')
            ->where([
                'seplan_coursecode' => $subject->tsub_code,
                'seplan_year'       => $year,
                'seplan_term'       => $term
            ])
            ->groupBy('seplan_usersend')
            ->get()->getResult();

        return $this->response->setJSON($suggested);
    }

    public function getConstraintGrid()
    {
        $className = $this->request->getGet('class');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['selected_class'] = $className;
        $data['term'] = $term;
        $data['year'] = $year;
        
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        $data['master_slots'] = $this->modConfig->getMasterSlots($term, $year);
        $data['all_period_configs'] = $this->db_timetable->table('tb_timetable_config_periods')->get()->getResult();

        // 🔍 Determine Class Level (Junior: ม.1-3 / Senior: ม.4-6)
        $isSenior = (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className));
        $data['class_level'] = $isSenior ? 4 : 1; // 1 for Junior, 4 for Senior
        $data['is_senior'] = $isSenior;

        if ($className) {
            $data['locks'] = $this->db_timetable->table('tb_timetable_subject_locks')
                                ->select('tb_timetable_subject_locks.subject_id, tb_timetable_subject_locks.day, tb_timetable_subject_locks.period, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_subject_locks.subject_id', 'left')
                                ->where('tb_timetable_subject_locks.class_name', $className)
                                ->where('tb_timetable_subject_locks.term', $term)
                                ->where('tb_timetable_subject_locks.year', $year)
                                ->get()->getResult();

            $data['assigned_subjects'] = $this->db_timetable->table('tb_timetable_assignments')
                                ->select('tb_timetable_assignments.subject_id, tb_timetable_assignments.teacher_id, tb_timetable_assignments.period_split, tb_timetable_assignments.hours_per_week, tb_timetable_assignments.group_id, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
                                ->where('tb_timetable_assignments.class_name', $className)
                                ->where('tb_timetable_assignments.term', $term)
                                ->where('tb_timetable_assignments.year', $year)
                                ->distinct()
                                ->get()->getResult();

            // 🍱 Identify Group-Level Constraints (Check if group contains mixed levels)
            foreach ($data['assigned_subjects'] as &$as) {
                $as->has_junior = false;
                $as->has_senior = false;
                if (!empty($as->group_id)) {
                    $members = $this->db_timetable->table('tb_timetable_assignments')->select('class_name')->where('group_id', $as->group_id)->get()->getResult();
                    foreach ($members as $m) {
                        if (preg_match('/ม\.[1-3]/', $m->class_name) || preg_match('/^[1-3]/', $m->class_name)) $as->has_junior = true;
                        if (preg_match('/ม\.[4-6]/', $m->class_name) || preg_match('/^[4-6]/', $m->class_name)) $as->has_senior = true;
                    }
                } else {
                    // Solo subject level
                    if (preg_match('/ม\.[1-3]/', $className) || preg_match('/^[1-3]/', $className)) $as->has_junior = true;
                    if (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className)) $as->has_senior = true;
                }
            }

            // 👨‍🏫 Fetch ALL teacher constraints and current schedule for teachers in THIS class
            $teacherIdsRaw = array_filter(array_column($data['assigned_subjects'], 'teacher_id'));
            $teacherIds = [];
            foreach($teacherIdsRaw as $ids) {
                foreach(explode(',', $ids) as $id) if(!empty(trim($id))) $teacherIds[] = trim($id);
            }
            $teacherIds = array_unique($teacherIds);

            if (!empty($teacherIds)) {
                // Manual Locks
                $data['teacher_locks'] = $this->db_timetable->table('tb_timetable_constraints')
                                    ->whereIn('teacher_id', $teacherIds)
                                    ->where('term', $term)
                                    ->where('year', $year)
                                    ->get()->getResult();
                
                // Existing Assignments (Busy)
                $data['teacher_busy'] = $this->db_timetable->table('tb_timetable_data')
                                    ->select('tb_timetable_data.*, tb_timetable_assignments.class_name, tb_timetable_assignments.teacher_id')
                                    ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                                    ->whereIn('tb_timetable_data.term', [$term])
                                    ->where('tb_timetable_data.year', $year)
                                    ->groupStart();
                                        foreach($teacherIds as $tid) {
                                            $data['teacher_busy']->orWhere("FIND_IN_SET('$tid', tb_timetable_assignments.teacher_id) >", 0);
                                        }
                                    $data['teacher_busy']->groupEnd();
                $data['teacher_busy'] = $data['teacher_busy']->get()->getResult();

                // Teacher Map for Tooltips
                $teachers = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_prefix, pers_firstname, pers_lastname')->get()->getResult();
                $data['teacherMap'] = [];
                foreach($teachers as $t) $data['teacherMap'][$t->pers_id] = $t->pers_prefix . $t->pers_firstname . ' ' . $t->pers_lastname;

            } else {
                $data['teacher_locks'] = [];
                $data['teacher_busy'] = [];
                $data['teacherMap'] = [];
            }
        } else {
            $data['locks'] = [];
            $data['assigned_subjects'] = [];
            $data['teacher_locks'] = [];
        }

        return view('admin/Academic/AdminTimetable/Partials/ConstraintGrid', $data);
    }


    public function getMasterLockGrid()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        
        // 1. Get all assigned classes to use as rows
        $classes = $this->db_timetable->table('tb_timetable_assignments')
                        ->select('class_name')
                        ->where(['term' => $term, 'year' => $year])
                        ->distinct()
                        ->orderBy('class_name', 'ASC')
                        ->get()->getResult();
        $data['classes'] = array_column($classes, 'class_name');

        // 2. Get all subject locks
        $locks = $this->db_timetable->table('tb_timetable_subject_locks')
                        ->select('tb_timetable_subject_locks.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
                        ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_subject_locks.subject_id', 'left')
                        ->where(['tb_timetable_subject_locks.term' => $term, 'tb_timetable_subject_locks.year' => $year])
                        ->get()->getResult();
        
        // Group locks for easy access: [class][day][period]
        $lockMap = [];
        foreach($locks as $l) {
            $lockMap[$l->class_name][$l->day][$l->period] = $l;
        }
        $data['lockMap'] = $lockMap;

        // 3. Get master slots (Locked for everyone)
        $master_slots = $this->modConfig->getMasterSlots($term, $year);
        $masterMap = [];
        foreach($master_slots as $ms) {
            $masterMap[$ms->day][$ms->period] = $ms;
        }
        $data['masterMap'] = $masterMap;
        $data['all_periods'] = $this->db_timetable->table('tb_timetable_config_periods')->get()->getResult();

        return view('admin/Academic/AdminTimetable/Partials/MasterLockGrid', $data);
    }

    public function saveRoomConstraint()
    {
        try {
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);

            $room_name = $this->request->getPost('room_name');
            $day = $this->request->getPost('day');
            $period = $this->request->getPost('period');
            $action = $this->request->getPost('action');

            if ($action === 'lock') {
                $this->db_timetable->table('tb_timetable_room_constraints')->insert([
                    'room_name' => $room_name,
                    'day' => $day,
                    'period' => $period,
                    'term' => $term,
                    'year' => $year
                ]);
            } else {
                $this->db_timetable->table('tb_timetable_room_constraints')->where([
                    'room_name' => $room_name,
                    'day' => $day,
                    'period' => $period,
                    'term' => $term,
                    'year' => $year
                ])->delete();
            }

            return $this->response->setJSON(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getTeacherConstraintSummary()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $days = $this->modConfig->getDays();
        $periods = $this->modConfig->getPeriods();
        
        // 🔒 1. Get All Manual Locks
        $locks = $this->db_timetable->table('tb_timetable_constraints')
                    ->where(['term' => $term, 'year' => $year])
                    ->get()->getResult();
        
        // 📅 2. Get All Current Assignments (Busy)
        $busy_slots = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.day, tb_timetable_data.period, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
            ->get()->getResult();

        // 👨‍🏫 3. Get Teacher Names for display
        $personnel = $this->db_personnel->table('tb_personnel')->select('pers_id, pers_prefix, pers_firstname, pers_lastname')->get()->getResult();
        $teacherMap = [];
        foreach($personnel as $p) $teacherMap[$p->pers_id] = $p->pers_prefix . $p->pers_firstname;

        // 📊 4. Aggregate
        $summary = [];
        foreach($locks as $l) {
            $summary[$l->day][$l->period]['locked'][] = $teacherMap[$l->teacher_id] ?? $l->teacher_id;
        }
        foreach($busy_slots as $bs) {
            $tids = explode(',', $bs->teacher_id);
            foreach($tids as $tid) {
                if(!empty(trim($tid))) {
                    $summary[$bs->day][$bs->period]['busy'][] = ($teacherMap[trim($tid)] ?? trim($tid)) . " ({$bs->class_name})";
                }
            }
        }

        $data = [
            'days' => $days,
            'periods' => $periods,
            'summary' => $summary,
            'term' => $term,
            'year' => $year
        ];

        return view('admin/Academic/AdminTimetable/Partials/TeacherConstraintSummary', $data);
    }

    public function getTeacherConstraintGrid()
    {
        $teacher_id = $this->request->getVar('teacher_id');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['teacher_id'] = $teacher_id;
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        
        // 🔒 1. Get Manual Locks
        $locks = $this->db_timetable->table('tb_timetable_constraints')
                    ->where(['teacher_id' => $teacher_id, 'term' => $term, 'year' => $year])
                    ->get()->getResult();
        
        $data['lock_map'] = [];
        foreach($locks as $l) {
            $data['lock_map'][$l->day . '_' . $l->period] = true;
        }

        // 📅 2. Get Current Teaching Schedule (Busy from assignments)
        $busy_slots = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_assignments.class_name, tb_timetable_subjects.tsub_code')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where("FIND_IN_SET('$teacher_id', tb_timetable_assignments.teacher_id) >", 0)
            ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
            ->get()->getResult();
        
        $data['busy_map'] = [];
        foreach($busy_slots as $bs) {
            $data['busy_map'][$bs->day . '_' . $bs->period] = $bs;
        }

        return view('admin/Academic/AdminTimetable/Partials/TeacherConstraintGrid', $data);
    }

    public function getRoomConstraintGrid()
    {
        $room_name = $this->request->getVar('room_name');
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $data['room_name'] = $room_name;
        $data['days'] = $this->modConfig->getDays();
        $data['periods'] = $this->modConfig->getPeriods();
        
        $locks = $this->db_timetable->table('tb_timetable_room_constraints')
                    ->where(['room_name' => $room_name, 'term' => $term, 'year' => $year])
                    ->get()->getResult();
        
        $data['lock_map'] = [];
        foreach($locks as $l) {
            $data['lock_map'][$l->day . '_' . $l->period] = true;
        }

        return view('admin/Academic/AdminTimetable/Partials/RoomConstraintGrid', $data);
    }

    public function changeYear()
    {
        $year = $this->request->getPost('year');
        if ($year) {
            session()->set('timetable_selected_year', $year);
            return $this->response->setJSON(['status' => 'success', 'message' => 'เปลี่ยนปีการศึกษา (เฉพาะตารางสอน) สำเร็จ']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง']);
    }

    private function getTimetableYear(): string
    {
        return session()->get('timetable_selected_year') ?: get_selected_year();
    }

    public function resetAllData()
    {
        try {
            $selectedYear = $this->getTimetableYear();
            list($term, $year) = explode('/', $selectedYear);

            $this->db_timetable->transStart();

            // 1. Delete Timetable Data
            $this->db_timetable->table('tb_timetable_data')
                ->where(['term' => $term, 'year' => $year])
                ->delete();

            // 2. Delete Subject Locks
            $this->db_timetable->table('tb_timetable_subject_locks')
                ->where(['term' => $term, 'year' => $year])
                ->delete();

            $this->db_timetable->transComplete();

            if ($this->db_timetable->transStatus() === FALSE) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการล้างข้อมูล']);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => "ล้างข้อมูลการล็อคและตารางสอนปี $selectedYear เรียบร้อยแล้ว"]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function auditTimetable()
    {
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        $warnings = [];

        // 1. Get all timetable data with details
        $slots = $this->db_timetable->table('tb_timetable_data')
            ->select('tb_timetable_data.*, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name')
            ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
            ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id')
            ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
            ->get()->getResult();

        // 2. Load teacher names for mapping
        $teachers_raw = $this->db_personnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
            ->get()->getResultArray();
        $teacher_map = [];
        foreach($teachers_raw as $tr) {
            $teacher_map[$tr['pers_id']] = $tr['pers_prefix'].$tr['pers_firstname'].' '.$tr['pers_lastname'];
        }

        // 3. Organize by teacher and by class
        $teacher_schedule = [];
        $class_schedule = [];
        foreach($slots as $s) {
            $teacher_schedule[$s->teacher_id][$s->day][$s->period] = $s;
            $class_schedule[$s->class_name][$s->day][$s->period] = $s;
        }

        // --- Rule 1: Teacher Consecutive Hours (> 4) ---
        foreach($teacher_schedule as $tid => $days) {
            foreach($days as $day => $periods) {
                ksort($periods);
                $consecutive = 0;
                $prev_p = -1;
                foreach($periods as $p => $slot) {
                    if ($prev_p != -1 && $p == $prev_p + 1) {
                        $consecutive++;
                    } else {
                        $consecutive = 1;
                    }
                    if ($consecutive > 4) {
                        $teacherName = $teacher_map[$tid] ?? 'ไม่พบชื่อ';
                        $warnings[] = [
                            'type' => 'Teacher Overload',
                            'severity' => 'warning',
                            'title' => 'ครูสอนติดต่อกันเกิน 4 คาบ',
                            'message' => "{$teacherName} สอนติดต่อกันเกิน 4 คาบ ในวัน{$day} (เริ่มคาบที่ ".($p-3).")",
                            'target' => $teacherName
                        ];
                        break; 
                    }
                    $prev_p = $p;
                }
            }
        }

        // --- Rule 2 & 3: Subject Density and Late Core Subjects ---
        $core_keywords = ['คณิต', 'วิทย์', 'อังกฤษ', 'ไทย', 'สังคม'];
        foreach($class_schedule as $cls => $days) {
            foreach($days as $day => $periods) {
                $core_count = 0;
                foreach($periods as $p => $slot) {
                    $is_core = false;
                    foreach($core_keywords as $kw) {
                        if (mb_strpos($slot->tsub_name, $kw) !== false) { $is_core = true; break; }
                    }

                    if ($is_core) {
                        $core_count++;
                        if ($p >= 7) {
                            $warnings[] = [
                                'type' => 'Late Core Subject',
                                'severity' => 'info',
                                'title' => 'วิชาหลักในคาบเย็น',
                                'message' => "ห้อง {$cls} มีวิชาหลัก ({$slot->tsub_name}) อยู่คาบที่ {$p} (คาบที่เด็กมักจะล้า)",
                                'target' => "ห้อง {$cls}"
                            ];
                        }
                    }
                }
                if ($core_count > 3) {
                    $warnings[] = [
                        'type' => 'Subject Density',
                        'severity' => 'warning',
                        'title' => 'วิชาหลักกระจุกตัว',
                        'message' => "ห้อง {$cls} มีวิชาหลักกองรวมกันถึง {$core_count} วิชา ในวัน{$day}",
                        'target' => "ห้อง {$cls}"
                    ];
                }
            }
        }

        // --- Rule 4: Conflict Check (Locked Subjects vs Teacher Busy/Room Locks) ---
        $teacher_constraints = $this->db_timetable->table('tb_timetable_constraints')
            ->where(['term' => $term, 'year' => $year])
            ->get()->getResult();
        $t_lock_map = [];
        foreach($teacher_constraints as $tc) { $t_lock_map[$tc->teacher_id][$tc->day][$tc->period] = true; }

        foreach($slots as $s) {
            if ($s->is_locked) {
                // Check Teacher Busy
                $tids = explode(',', $s->teacher_id);
                foreach($tids as $tid) {
                    if (isset($t_lock_map[$tid][$s->day][$s->period])) {
                        $teacherName = $teacher_map[$tid] ?? $tid;
                        $warnings[] = [
                            'type' => 'Condition Conflict',
                            'severity' => 'warning',
                            'title' => 'เงื่อนไขขัดแย้งกัน',
                            'message' => "วิชา {$s->tsub_name} (ห้อง {$s->class_name}) ถูกล็อคไว้ในวัน{$s->day} คาบ {$s->period} แต่ครูผู้สอน ({$teacherName}) ระบุว่าไม่ว่างในเวลานี้",
                            'target' => "ความขัดแย้งเงื่อนไข"
                        ];
                    }
                }
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'warnings' => $warnings,
            'count' => count($warnings)
        ]);
    }

    public function saveTeachingGroup()
    {
        $idsStr = $this->request->getVar('ids');
        if (empty($idsStr)) return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเลือกรายการที่ต้องการรวมกลุ่ม']);
        
        $ids = explode(',', $idsStr);
        $selectedYear = $this->getTimetableYear();
        list($term, $year) = explode('/', $selectedYear);

        // 🔍 1. Check for existing locks of these assignments
        $assignments = $this->db_timetable->table('tb_timetable_assignments')
            ->whereIn('assign_id', $ids)
            ->get()->getResult();

        $locks = [];
        foreach($assignments as $as) {
            $lock = $this->db_timetable->table('tb_timetable_subject_locks')
                ->where('class_name', $as->class_name)
                ->where('subject_id', $as->subject_id)
                ->where('term', $term)
                ->where('year', $year)
                ->get()->getRow();
            if ($lock) {
                $locks[] = $lock->day . '_' . $lock->period;
            }
        }

        // ❌ If subjects are locked to different times, they cannot be grouped
        $uniqueLocks = array_unique($locks);
        if (count($uniqueLocks) > 1) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'ไม่สามารถรวมกลุ่มได้ เนื่องจากวิชาที่เลือกมีการล็อคคาบเรียนไว้ "คนละเวลา" กัน กรุณายกเลิกการล็อคคาบวิชาเดิมก่อนมัดรวมกลุ่ม'
            ]);
        }

        $groupId = 'GRP_' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        if ($this->db_timetable->table('tb_timetable_assignments')->whereIn('assign_id', $ids)->update(['group_id' => $groupId])) {
            $this->invalidateTimetable();
            return $this->response->setJSON(['status' => 'success', 'message' => 'รวมกลุ่มสอนควบสำเร็จ', 'group_id' => $groupId]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถรวมกลุ่มได้']);
    }

    public function deleteTeachingGroup()
    {
        $idsStr = $this->request->getVar('ids');
        if (empty($idsStr)) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลกลุ่ม']);

        $ids = explode(',', $idsStr);
        if ($this->db_timetable->table('tb_timetable_assignments')->whereIn('assign_id', $ids)->update(['group_id' => null])) {
            $this->invalidateTimetable();
            return $this->response->setJSON(['status' => 'success', 'message' => 'แยกกลุ่มสอนควบเรียบร้อย']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถแยกกลุ่มได้']);
    }
}
