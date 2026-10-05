<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class ConStudents extends BaseController
{
    protected $title = "ฝ่ายวิชาการ";
    protected $db; // เปลี่ยนชื่อจาก $DBSKJ เป็น $db
    protected $DBPERS;
    protected $DBSKJ;

    public function __construct()
    {
        $this->db = \Config\Database::connect('default'); // เปลี่ยนเป็นเชื่อมต่อกับ default group
        $this->DBPERS = \Config\Database::connect('personnel');
        $this->DBSKJ = \Config\Database::connect('skj'); // Initialize skjacth_skj database connection
    }

    public function index(){ 
        $data['title'] = "วิชาการ";
        $data['description'] = "วิชาการ";     
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        return view('user/Students/PageStudentsHome', $data);
    }

    public function Home(){      
        $data['title'] = "วิชาการ";
        $data['description'] = "วิชาการ";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        return view('user/Students/PageStudentsHome', $data);
    }

    public function StudentsList(){  
        $data['title'] = "รายชื่อนักเรียน";
        $data['description'] = "รายชื่อนักเรียน";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('assets/images/Students/banner.png');

        $data['schoolyear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $subYear = !empty($data['schoolyear']->schyear_year) ? explode('/', $data['schoolyear']->schyear_year) : ['', ''];

        $studentList = $this->request->getGet('studentList');
        $className = 'ม.' . $studentList;

        $data['checkLine'] = $this->db->table('tb_students')->select('StudentStudyLine, StudentClass')
        ->where('StudentClass', $className)
        ->groupBy(['StudentStudyLine', 'StudentClass'])
        ->get()->getResult();

        $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
        ->where('StudentStatus','1/ปกติ')  
        ->where('StudentBehavior !=','จำหน่่าย')      
        ->where('StudentClass', $className)
        ->orderBy('StudentNumber','ASC')
        ->get()->getResult();

        $data['TeacRoom'] = [];
        if (!empty($studentList) && !empty($subYear[1])) {
            $data['TeacRoom'] = $this->db->table('tb_regclass')->select([
                'skjacth_personnel.tb_personnel.pers_prefix',
                'skjacth_personnel.tb_personnel.pers_firstname',
                'skjacth_personnel.tb_personnel.pers_lastname',
                'tb_regclass.Reg_Class'
            ])
            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_regclass.class_teacher')
            ->where('Reg_Year', $subYear[1])
            ->where('Reg_Class', $studentList)
            ->get()->getResult();
        }
                
        return view('user/PageStudentsList', $data);
    }

    public function StudentsPrintRoom($Class,$Room,$StudyLine = 0){
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $live_mpdf = new Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 12,
                'margin_top' => 5,
	            'margin_left' => 5,
	            'margin_right' => 5,
	            'mirrorMargins' => 0,
                'tempDir' => WRITEPATH . 'mpdf',
                'fontDir' => array_merge($fontDirs, [FCPATH . 'assets/fonts']),
                'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf',
                        'B' => 'THSarabunNew Bold.ttf',
                        'I' => 'THSarabunNew Italic.ttf',
                        'BI' => 'THSarabunNew BoldItalic.ttf'
                    ]
                ],
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            )
        );

        $data['schoolyear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $subYear = explode('/',$data['schoolyear']->schyear_year);

        $NameRoom = 'ม.'.$Class.'/'.$Room;
        $data['SubRoom'] = explode('.',$NameRoom);
        $data['TeacRoom'] = $this->db->table('tb_regclass')->select([
            'skjacth_personnel.tb_personnel.pers_prefix',
            'skjacth_personnel.tb_personnel.pers_firstname',
            'skjacth_personnel.tb_personnel.pers_lastname',
            'tb_regclass.Reg_Class'
        ])
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_regclass.class_teacher')
        ->where('Reg_Year',$subYear[1])
        ->where('Reg_Class',$data['SubRoom'][1])
        ->get()->getResult();

        $data['checkLine'] = $this->db->table('tb_students')->select('StudentStudyLine')
        ->where('StudentClass',$NameRoom)
        ->groupBy('StudentStudyLine')
        ->get()->getResult();

        if($StudyLine == "All"){
            $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
            ->where('StudentStatus','1/ปกติ')  
            ->where('StudentBehavior !=','จำหน่่าย')      
            ->where('StudentClass',$NameRoom)
            ->orderBy('StudentNumber','ASC')
            ->get()->getResult();
        }else{
            $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
            ->where('StudentStatus','1/ปกติ')  
            ->where('StudentBehavior !=','จำหน่่าย')      
            ->where('StudentClass',$NameRoom)
            ->where('StudentStudyLine',$StudyLine)
            ->orderBy('StudentNumber','ASC')
            ->get()->getResult();
        }

        $ReportFront = view('user/PageStudentsListPrint',$data,['save' => true]);        
        $live_mpdf->WriteHTML($ReportFront);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $live_mpdf->Output('filename.pdf', \Mpdf\Output\Destination::INLINE); 
    }
    
    public function ExamSchedule(){
        $data['title'] = "ตารางสอบ";
        $data['description'] = "ตารางสอบ";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('assets/images/ExamSchedule/banner.jpg');

        $exams = $this->db->table('tb_exam_schedule')
                                ->where('exam_status', 'เปิด')
                                ->orderBy('exam_year','DESC')
                                ->orderBy('exam_term','DESC')
                                ->get()->getResult();
        
        $groupedExams = [];
        foreach ($exams as $exam) {
            $key = $exam->exam_term . '/' . $exam->exam_year;
            if (!isset($groupedExams[$key])) {
                $groupedExams[$key] = [
                    'exam_term' => $exam->exam_term,
                    'exam_year' => $exam->exam_year,
                    'exam_type' => $exam->exam_type,
                    'files' => []
                ];
            }
            $groupedExams[$key]['files'][] = $exam->exam_filename;
        }

        $data['Exam'] = $groupedExams;
       
        return view('user/PageExamSchedule', $data);
    }

    public function ExamScheduleOnline(){
        $data['title'] = "ตารางสอบ Online";
        $data['description'] = "ตารางสอบ Online";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url("uploads/banner/ExamScheduleOnline/banner.png");

        $data['Exam'] = $this->db->table('tb_exam_schedule')
                                ->where('exam_status', 'เปิด')
                                ->orderBy('exam_id','DESC')
                                ->limit(6)->get()->getResult();
        return view('user/PageExamScheduleOnline', $data);
    }

    public function ClassSchedule(){
        $modConfig = new \App\Models\Admin\Academic\ModTimetableConfig();
        $displayMode          = $modConfig->getSetting('class_schedule_display_mode', 'system');
        $classScheduleOnOff   = $modConfig->getSetting('class_schedule_onoff', 'open');
        $teacherScheduleOnOff = $modConfig->getSetting('teacher_schedule_onoff', 'open');
        $openYearFrom         = $modConfig->getSetting('schedule_open_year_from', 'all');

        $data['title']                  = "ตารางเรียนและตารางสอน";
        $data['description']            = "ตารางเรียนและตารางสอน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";  
        $data['full_url']               = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner']                 = base_url("uploads/banner/class_schedule/banner.png");
        $data['display_mode']           = $displayMode;
        $data['class_schedule_onoff']   = $classScheduleOnOff;
        $data['teacher_schedule_onoff'] = $teacherScheduleOnOff;
        $data['schedule_open_year_from']= $openYearFrom;
        
        $data['schedule'] = $this->db->table('tb_class_schedule')->orderBy('schestu_id','DESC')->get()->getResult();
        return view('user/PageClassSchedule', $data);
    }

    public function SearchClassSchedule()
    {
        $year = $this->request->getGet('year');
        $term = $this->request->getGet('term');
        $schedule = [];

        if (!empty($year) && !empty($term)) {
            $schedule = $this->db->table('tb_class_schedule')
                ->where('schestu_term', $term)
                ->where('schestu_year', $year)
                ->orderBy('schestu_classname', 'ASC')
                ->get()
                ->getResult();
        }

        return $this->response->setJSON($schedule);
    }

    public function getScheduleYears()
    {
        $modConfig = new \App\Models\Admin\Academic\ModTimetableConfig();
        $displayMode = $modConfig->getSetting('class_schedule_display_mode', 'system');
        $openYearFrom = $modConfig->getSetting('schedule_open_year_from', 'all');
        
        $map = [];

        if ($displayMode === 'system') {
            try {
                $dbTimetable = \Config\Database::connect('timetable');
                
                // 1. From tb_timetable_assignments
                if ($dbTimetable->tableExists('tb_timetable_assignments')) {
                    $rows1 = $dbTimetable->table('tb_timetable_assignments')
                        ->select('year, term')
                        ->groupBy('year, term')
                        ->get()
                        ->getResult();

                    foreach ($rows1 as $r) {
                        if (!empty($r->year) && !empty($r->term)) {
                            $key = "{$r->term}/{$r->year}";
                            $map[$key] = [
                                'year' => (string)$r->year,
                                'term' => (string)$r->term,
                                'label' => "ภาคเรียนที่ {$r->term}/{$r->year}"
                            ];
                        }
                    }
                }

                // 2. From tb_timetable_data
                if ($dbTimetable->tableExists('tb_timetable_data')) {
                    $rows2 = $dbTimetable->table('tb_timetable_data')
                        ->select('year, term')
                        ->groupBy('year, term')
                        ->get()
                        ->getResult();

                    foreach ($rows2 as $r) {
                        if (!empty($r->year) && !empty($r->term)) {
                            $key = "{$r->term}/{$r->year}";
                            $map[$key] = [
                                'year' => (string)$r->year,
                                'term' => (string)$r->term,
                                'label' => "ภาคเรียนที่ {$r->term}/{$r->year}"
                            ];
                        }
                    }
                }
            } catch (\Throwable $e) {
                log_message('error', 'Error in getScheduleYears system mode: ' . $e->getMessage());
            }
        } else {
            if ($this->db->tableExists('tb_class_schedule')) {
                $rows = $this->db->table('tb_class_schedule')
                    ->select('schestu_year as year, schestu_term as term')
                    ->groupBy('schestu_year, schestu_term')
                    ->get()
                    ->getResult();

                foreach ($rows as $r) {
                    if (!empty($r->year) && !empty($r->term)) {
                        $key = "{$r->term}/{$r->year}";
                        $map[$key] = [
                            'year' => (string)$r->year,
                            'term' => (string)$r->term,
                            'label' => "ภาคเรียนที่ {$r->term}/{$r->year}"
                        ];
                    }
                }
            }
        }

        // กรองขอบเขตปีการศึกษาที่เปิดให้ดู (ตั้งแต่ปี/เทอมที่ระบุ ถึงปีล่าสุด)
        if (!empty($openYearFrom) && $openYearFrom !== 'all' && strpos($openYearFrom, '/') !== false) {
            list($fromTerm, $fromYear) = explode('/', $openYearFrom);
            $fromYear = (int)$fromYear;
            $fromTerm = (int)$fromTerm;

            foreach ($map as $k => $item) {
                $y = (int)$item['year'];
                $t = (int)$item['term'];
                if ($y < $fromYear || ($y === $fromYear && $t < $fromTerm)) {
                    unset($map[$k]);
                }
            }
        }

        // Sort descending numerically by year and then term
        if (!empty($map)) {
            uasort($map, function ($a, $b) {
                if ((int)$a['year'] === (int)$b['year']) {
                    return (int)$b['term'] <=> (int)$a['term'];
                }
                return (int)$b['year'] <=> (int)$a['year'];
            });
            $yearTerms = array_values($map);
        } else {
            $parsed = parse_selected_year();
            $yearTerms = [
                [
                    'year' => (string)$parsed['year'],
                    'term' => (string)$parsed['term'],
                    'label' => "ภาคเรียนที่ {$parsed['term']}/{$parsed['year']}"
                ]
            ];
        }

        return $this->response->setJSON($yearTerms);
    }

    /**
     * ดึงรายชื่อห้องเรียนทั้งหมดที่มีการจัดตารางสอนในระบบ (Live System Timetable)
     */
    public function getSystemTimetableClasses()
    {
        $year = $this->request->getGet('year');
        $term = $this->request->getGet('term');

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year = $year ?: $parsed['year'];
            $term = $term ?: $parsed['term'];
        }

        $dbTimetable = \Config\Database::connect('timetable');
        $classes = $dbTimetable->table('tb_timetable_assignments')
            ->select('class_name, COUNT(assign_id) as total_subjects, SUM(hours_per_week) as total_hours')
            ->where('term', $term)
            ->where('year', $year)
            ->groupBy('class_name')
            ->orderBy('class_name', 'ASC')
            ->get()
            ->getResult();

        return $this->response->setJSON($classes);
    }

    /**
     * ดึงข้อมูลตารางเรียนรายห้องแบบครบถ้วน สำหรับแสดงใน Modal ตารางเรียน
     */
    public function getPublicClassTimetableDetail()
    {
        $className = $this->request->getGet('class_name');
        $year      = $this->request->getGet('year');
        $term      = $this->request->getGet('term');

        if (empty($className)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุห้องเรียน']);
        }

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year = $year ?: $parsed['year'];
            $term = $term ?: $parsed['term'];
        }

        try {
            $dbTimetable = \Config\Database::connect('timetable');
            $dbPersonnel = \Config\Database::connect('personnel');

            $isSenior = (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className));
            $levelGroup = $isSenior ? 'Senior' : 'Junior';
            $lunchPeriod = $isSenior ? 5 : 4;

            // Days
            $days = $dbTimetable->table('tb_timetable_config_days')
                ->where('is_active', 1)
                ->orderBy('day_id', 'ASC')
                ->get()
                ->getResult();

            // Periods for this level
            $allPeriods = $dbTimetable->table('tb_timetable_config_periods')
                ->orderBy('period_number', 'ASC')
                ->get()
                ->getResult();

            $periods = [];
            $tempGroup = [];
            foreach($allPeriods as $p) {
                $tempGroup[$p->period_number][$p->level_group] = $p;
            }
            foreach($tempGroup as $pNum => $levels) {
                if (isset($levels[$levelGroup])) {
                    $periods[] = $levels[$levelGroup];
                } elseif (isset($levels['ALL'])) {
                    $periods[] = $levels['ALL'];
                } else {
                    $periods[] = reset($levels);
                }
            }

            // Master Slots
            $masterSlots = $dbTimetable->table('tb_timetable_config_master_slots')
                ->where(['term' => $term, 'year' => $year])
                ->groupStart()->where('level_group', $levelGroup)->orWhere('level_group', 'ALL')->groupEnd()
                ->get()
                ->getResult();

            // Timetable Data
            $hasRoomName = $dbTimetable->fieldExists('room_name', 'tb_timetable_assignments');
            $selectFields = 'tb_timetable_data.*, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name, tb_timetable_assignments.teacher_id';
            if ($hasRoomName) {
                $selectFields .= ', tb_timetable_assignments.room_name as room';
            }

            $timetableData = $dbTimetable->table('tb_timetable_data')
                ->select($selectFields)
                ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                ->where('tb_timetable_assignments.class_name', $className)
                ->where('tb_timetable_data.term', $term)
                ->where('tb_timetable_data.year', $year)
                ->get()
                ->getResult();

            // Teachers Name Map
            $teachers = $dbPersonnel->table('tb_personnel')->select('pers_id, pers_prefix, pers_firstname, pers_lastname')->get()->getResult();
            $teacherMap = [];
            foreach($teachers as $t) {
                $teacherMap[$t->pers_id] = $t->pers_prefix . $t->pers_firstname;
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'class_name'    => $className,
                    'term'          => $term,
                    'year'          => $year,
                    'level_group'   => $levelGroup,
                    'lunch_period'  => $lunchPeriod,
                    'days'          => $days,
                    'periods'       => $periods,
                    'master_slots'  => $masterSlots,
                    'timetable_data'=> $timetableData,
                    'teacher_map'   => $teacherMap
                ]
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error in getPublicClassTimetableDetail: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการประมวลผลตารางเรียน: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * ดึงปี/ภาคเรียนทั้งหมดที่มีข้อมูลตารางสอนครู
     */
    public function getTeacherScheduleYears()
    {
        $model = new \App\Models\Admin\Academic\ModAdminTeachingSchedule();
        $yearTerms = $model->getDistinctYearTerms();

        $modConfig = new \App\Models\Admin\Academic\ModTimetableConfig();
        $openYearFrom = $modConfig->getSetting('schedule_open_year_from', 'all');

        if (!empty($openYearFrom) && $openYearFrom !== 'all' && strpos($openYearFrom, '/') !== false) {
            list($fromTerm, $fromYear) = explode('/', $openYearFrom);
            $fromYear = (int)$fromYear;
            $fromTerm = (int)$fromTerm;

            $filtered = [];
            foreach ($yearTerms as $yt) {
                $y = (int)$yt['year'];
                $t = (int)$yt['term'];
                if (!($y < $fromYear || ($y === $fromYear && $t < $fromTerm))) {
                    $filtered[] = $yt;
                }
            }
            $yearTerms = $filtered;
        }

        return $this->response->setJSON($yearTerms);
    }

    /**
     * ดึงกลุ่มสาระการเรียนรู้ทั้งหมด
     */
    public function getLearningGroups()
    {
        $groups = $this->DBSKJ->table('tb_learning')
            ->select('lear_id, lear_namethai, lear_nameeng, lear_icon')
            ->orderBy('lear_id', 'ASC')
            ->get()
            ->getResult();

        return $this->response->setJSON($groups);
    }

    /**
     * ค้นหารายชื่อครูและข้อมูลสรุปภาระงานสอนตามปี/ภาคเรียน และกลุ่มสาระฯ
     */
    public function searchTeachersSchedule()
    {
        $year    = $this->request->getGet('year');
        $term    = $this->request->getGet('term');
        $groupId = $this->request->getGet('group_id');

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year   = $year ?: $parsed['year'];
            $term   = $term ?: $parsed['term'];
        }

        $model = new \App\Models\Admin\Academic\ModAdminTeachingSchedule();

        if (!empty($groupId)) {
            $teachers = $model->getTeachersByGroup((string)$groupId, (string)$year, (string)$term);
        } else {
            // ดึงครูทั้งหมดทุกกลุ่มสาระ
            $allGroups = $model->getLearningGroupsWithStats((string)$year, (string)$term);
            $teachers = [];
            foreach ($allGroups['groups'] as $grp) {
                $grpTeachers = $model->getTeachersByGroup((string)$grp->lear_id, (string)$year, (string)$term);
                foreach ($grpTeachers as $t) {
                    $t->group_name = $grp->lear_namethai;
                    $teachers[] = $t;
                }
            }
        }

        return $this->response->setJSON($teachers);
    }

    /**
     * ดึงรายละเอียดตารางสอนรายบุคคลของครู (สำหรับเปิดดูใน Modal)
     */
    public function getTeacherScheduleDetail()
    {
        $teacherId = $this->request->getGet('teacher_id') ?: $this->request->getPost('teacher_id');
        $year      = $this->request->getGet('year') ?: $this->request->getPost('year');
        $term      = $this->request->getGet('term') ?: $this->request->getPost('term');

        if (empty($teacherId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุรหัสครู']);
        }

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year   = $year ?: $parsed['year'];
            $term   = $term ?: $parsed['term'];
        }

        $dbPersonnel = \Config\Database::connect('personnel');
        $teacher = $dbPersonnel->table('tb_personnel')->where('pers_id', $teacherId)->get()->getRow();

        $groupName = '';
        if ($teacher && !empty($teacher->pers_learning)) {
            $dbSkj = \Config\Database::connect('skj');
            $grp = $dbSkj->table('tb_learning')->where('lear_id', $teacher->pers_learning)->get()->getRow();
            if ($grp) $groupName = $grp->lear_namethai;
        }

        try {
            $dbTimetable = \Config\Database::connect('timetable');

            // 1. Days
            $days = $dbTimetable->table('tb_timetable_config_days')
                ->where('is_active', 1)
                ->orderBy('day_id', 'ASC')
                ->get()
                ->getResult();

            if (empty($days)) {
                $days = [
                    (object)['day_key' => 'MON', 'day_name' => 'วันจันทร์', 'is_active' => 1],
                    (object)['day_key' => 'TUE', 'day_name' => 'วันอังคาร', 'is_active' => 1],
                    (object)['day_key' => 'WED', 'day_name' => 'วันพุธ', 'is_active' => 1],
                    (object)['day_key' => 'THU', 'day_name' => 'วันพฤหัสบดี', 'is_active' => 1],
                    (object)['day_key' => 'FRI', 'day_name' => 'วันศุกร์', 'is_active' => 1],
                ];
            }

            // 2. Periods (Deduplicate per period_number)
            $allPeriods = $dbTimetable->table('tb_timetable_config_periods')
                ->orderBy('period_number', 'ASC')
                ->get()
                ->getResult();

            $periods = [];
            $tempGroup = [];
            foreach ($allPeriods as $p) {
                $tempGroup[$p->period_number][$p->level_group] = $p;
            }
            foreach ($tempGroup as $pNum => $levels) {
                if (isset($levels['ALL'])) {
                    $periods[] = $levels['ALL'];
                } elseif (isset($levels['Junior'])) {
                    $periods[] = $levels['Junior'];
                } elseif (isset($levels['Senior'])) {
                    $periods[] = $levels['Senior'];
                } else {
                    $periods[] = reset($levels);
                }
            }

            if (empty($periods)) {
                for ($i = 1; $i <= 10; $i++) {
                    $periods[] = (object)[
                        'period_number' => $i,
                        'start_time' => '',
                        'end_time' => ''
                    ];
                }
            }

            // 3. Master Slots
            $masterSlots = $dbTimetable->table('tb_timetable_config_master_slots')
                ->where(['term' => $term, 'year' => $year])
                ->get()
                ->getResult();

            // 4. Timetable Data for this Teacher
            $hasRoomName = $dbTimetable->fieldExists('room_name', 'tb_timetable_assignments');
            $selectFields = 'tb_timetable_data.*, tb_timetable_assignments.teacher_id, tb_timetable_assignments.class_name, tb_timetable_assignments.subject_id, tb_timetable_subjects.tsub_code, tb_timetable_subjects.tsub_name';
            if ($hasRoomName) {
                $selectFields .= ', tb_timetable_assignments.room_name as room';
            }

            $timetableData = $dbTimetable->table('tb_timetable_data')
                ->select($selectFields)
                ->join('tb_timetable_assignments', 'tb_timetable_assignments.assign_id = tb_timetable_data.assign_id')
                ->join('tb_timetable_subjects', 'tb_timetable_subjects.tsub_id = tb_timetable_assignments.subject_id', 'left')
                ->where("FIND_IN_SET('{$teacherId}', tb_timetable_assignments.teacher_id) >", 0)
                ->where(['tb_timetable_data.term' => $term, 'tb_timetable_data.year' => $year])
                ->get()->getResult();

            $totalHours = count($timetableData);

            $data = [
                'teacher' => $teacher,
                'group_name' => $groupName,
                'total_hours' => $totalHours,
                'days' => $days,
                'periods' => $periods,
                'master_slots' => $masterSlots,
                'timetable_data' => $timetableData,
                'lunch_period' => 4
            ];

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $data
            ]);

        } catch (\Throwable $e) {
            log_message('error', 'Error in getTeacherScheduleDetail: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการประมวลผลตารางสอน: ' . $e->getMessage()
            ]);
        }
    }

    //----- ห้องเรียนออนไลน์ ------
    public function LearningOnline(){
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "ห้องเรียนออนไลน์";
        $data['description'] = "ห้องเรียนออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";        
        $data['banner'] = base_url('uploads/banner/RoomOnline/bannerRoomOnline.png');
        
        $data['room'] = $this->db->table('tb_room_online')->select([
                                            'tb_room_online.*',
                                            'skjacth_personnel.tb_personnel.pers_prefix',
                                            'skjacth_personnel.tb_personnel.pers_firstname',
                                            'skjacth_personnel.tb_personnel.pers_lastname',
                                            'skjacth_personnel.tb_personnel.pers_img'
                                        ])
                                            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_room_online.roomon_teachid','LEFT')
                                ->where('roomon_classlevel',$this->request->getGet('s'))
                                ->get()->getResult();
        $data['keyroom'] = $this->request->getGet('s');
        return view('user/PageLearningOnline', $data);
    }

    public function LearningOnlineDetail($key = null){
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "ห้องเรียนออนไลน์";
        $data['description'] = "ห้องเรียนออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('uploads/banner/RoomOnline/bannerRoomOnline.png');

        $decodedKey = urldecode($key ?? '');
        $learGroup = null;
        if (!empty($decodedKey)) {
            $learGroup = $this->DBSKJ->table('tb_learning')
                ->where('lear_nameeng', $decodedKey)
                ->orWhere('lear_id', $decodedKey)
                ->orWhere('lear_namethai', $decodedKey)
                ->get()->getRow();
        }

        $builder = $this->db->table('tb_room_online')->select([
            'tb_room_online.*',
            'skjacth_personnel.tb_personnel.pers_prefix',
            'skjacth_personnel.tb_personnel.pers_firstname',
            'skjacth_personnel.tb_personnel.pers_lastname',
            'skjacth_personnel.tb_personnel.pers_img',
            'skjacth_personnel.tb_personnel.pers_learning'
        ])->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_room_online.roomon_teachid', 'LEFT');

        if ($learGroup) {
            $builder->where('skjacth_personnel.tb_personnel.pers_learning', $learGroup->lear_id);
            $data['title'] = "ห้องเรียนออนไลน์ - กลุ่มสาระการเรียนรู้" . $learGroup->lear_namethai;
        }

        if ($this->request->getGet('s')) {
            $builder->where('tb_room_online.roomon_classlevel', $this->request->getGet('s'));
        }

        $data['room'] = $builder->orderBy('roomon_classlevel', 'ASC')->orderBy('roomon_coursecode', 'ASC')->get()->getResult();
        $data['learGroup'] = $learGroup;
        $data['key'] = $decodedKey;
        $data['keyroom'] = $this->request->getGet('s');

        return view('user/PageLearningOnlineDetail', $data);
    }

    public function PageReportLearnOnline(){ 
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "แบบรายงานการเรียนการสอนออนไลน์";
        $data['description'] = "แบบรายงานการเรียนการสอนออนไลน์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";

        return view('user/PageReportLearnOnline', $data);
    }
}
