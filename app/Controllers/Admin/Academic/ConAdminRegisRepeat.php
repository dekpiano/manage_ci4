<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminAcademinResult;

class ConAdminRegisRepeat extends BaseController
{
    protected $modAdminAcademinResult;
    protected $DBPers;

    public function __construct()
    {
        $this->modAdminAcademinResult = new ModAdminAcademinResult();
        $this->DBPers = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if ((session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function AdminRegisRepeatMain(){   
        $data['admin'] = $this->DBPers->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult(); // Changed to getResult()
        $data['repeat_setting'] = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $data['TeacherList'] = $this->DBPers->table('tb_personnel')
            ->select('pers_id,pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_learning !=', '')
            ->where('pers_status', 'กำลังใช้งาน')
            ->orderBy('pers_firstname', 'ASC')
            ->get()->getResult();
        $data['CountYear'] = $this->db->table('tb_register')
            ->select('RegisterYear')
            ->groupBy('RegisterYear')
            ->orderBy('RegisterYear', 'DESC')
            ->get()->getResult();
        
        // Retrieve selected year: Priority 1) Query param 'year', 2) Session 'repeat_selected_year', 3) Default get_selected_year()
        $reqYear = $this->request->getGet('year');
        if (!empty($reqYear)) {
            $data['selectedYear'] = $reqYear;
            session()->set('repeat_selected_year', $reqYear);
        } elseif (session()->has('repeat_selected_year') && !empty(session()->get('repeat_selected_year'))) {
            $data['selectedYear'] = session()->get('repeat_selected_year');
        } else {
            $data['selectedYear'] = get_selected_year();
        }

        // Retrieve selected attempt: Priority 1) Query param 'attempt', 2) Session
        $reqAttempt = $this->request->getGet('attempt');
        if (!empty($reqAttempt)) {
            $data['selectedAttempt'] = $reqAttempt;
            session()->set('repeat_selected_attempt', $reqAttempt);
        } elseif (session()->has('repeat_selected_attempt')) {
            $data['selectedAttempt'] = session()->get('repeat_selected_attempt');
        } else {
            $data['selectedAttempt'] = '';
        }

        // Retrieve selected tab: Priority 1) Query param 'tab', 2) Session
        $reqTab = $this->request->getGet('tab');
        if (!empty($reqTab)) {
            $data['selectedTab'] = $reqTab;
            session()->set('repeat_selected_tab', $reqTab);
        } elseif (session()->has('repeat_selected_tab')) {
            $data['selectedTab'] = session()->get('repeat_selected_tab');
        } else {
            $data['selectedTab'] = '';
        }
        
        $data['title'] = "ลงทะเบียนเรียน (ซ้ำ)";	

        $data['GroupYear'] = $this->db->table('tb_subjects')->select('SubjectYear')->groupBy('SubjectYear')->get()->getResult();

        // Sort the GroupYear array in PHP (Year DESC, Term DESC)
        usort($data['GroupYear'], function($a, $b) {
            $subjectYearA = $a->SubjectYear ?? '';
            $subjectYearB = $b->SubjectYear ?? '';

            // Handle empty SubjectYear values
            if (empty($subjectYearA) && empty($subjectYearB)) return 0;
            if (empty($subjectYearA)) return 1; // Empty comes last
            if (empty($subjectYearB)) return -1; // Empty comes last

            $partsA = explode('/', $subjectYearA);
            $partsB = explode('/', $subjectYearB);

            $yearA = (count($partsA) > 1) ? (int)$partsA[1] : (int)$partsA[0];
            $termA = (count($partsA) > 1) ? (int)$partsA[0] : 0;

            $yearB = (count($partsB) > 1) ? (int)$partsB[1] : (int)$partsB[0];
            $termB = (count($partsB) > 1) ? (int)$partsB[0] : 0;

            if ($yearA == $yearB) {
                return $termB <=> $termA; // Sort by term descending
            }
            return $yearB <=> $yearA; // Sort by year descending
        });

        // Dashboard Statistics for repeat registration
        $currentYear = $data['selectedYear'];
        
        // Total subjects with repeat registrations in selected year
        // (วิชาที่มีนักเรียนลงทะเบียนเรียนซ้ำ = มี RepeatTeacher และยังไม่ผ่าน)
        $data['total_subjects_repeat'] = $this->db->table('tb_register')
            ->select('SubjectID')
            ->where('RepeatYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน')
            ->distinct()
            ->countAllResults();
        
        // Total students with repeat registrations (distinct) in selected year
        $data['total_repeat_students'] = $this->db->table('tb_register')
            ->select('StudentID')
            ->where('RepeatYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน')
            ->distinct()
            ->countAllResults();
        
        // Total repeat registration records in selected year
        $data['total_repeat_registrations'] = $this->db->table('tb_register')
            ->where('RepeatYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน')
            ->countAllResults();
        
        // Total teachers handling repeat students
        $data['total_repeat_teachers'] = $this->db->table('tb_register')
            ->select('RepeatTeacher')
            ->where('RepeatYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน')
            ->distinct()
            ->countAllResults();
        
        return view('admin/Academic/AdminRegisRepeat/AdminRegisRepeatMain', $data);
        
    }

    /**
     * AJAX endpoint to get dashboard statistics for repeat registration
     */
    public function getDashboardStats()
    {
        $year = $this->request->getPost('year') ?? $this->request->getGet('year');
        $attempt = $this->request->getPost('attempt') ?? $this->request->getGet('attempt');
        
        if (empty($year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Year is required']);
        }

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : $year;

        // 1. Stats for Cards (Registered Students in active repeat year)
        $builderStats = $this->db->table('tb_register')
            ->where('RepeatYear', $activeRepeatYear)
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน');
            
        if (!empty($attempt)) {
            $builderStats->where('Grade_Type', $attempt);
        }

        $stats = $builderStats->select('
            COUNT(DISTINCT SubjectID) as total_subjects_repeat,
            COUNT(DISTINCT StudentID) as total_repeat_students,
            COUNT(*) as total_repeat_registrations,
            COUNT(DISTINCT RepeatTeacher) as total_repeat_teachers
        ')->get()->getRow();

        // 2. Count for Main Subjects Accordion Badge
        $countMain = count($this->db->table('tb_register')
            ->select('tb_register.SubjectID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->where('tb_register.RegisterYear', $year)
            ->where('tb_subjects.SubjectYear', $year)
            ->groupBy('tb_register.SubjectID, tb_register.TeacherID')
            ->get()->getResult());

        // 3. Count for Pending Accordion Badge
        // ดึงวิชาที่มีนักเรียนรอลงทะเบียนเรียนซ้ำ (Grade = 0, ร, มส หรือ RepeatStatus = ไม่ผ่าน)
        // ที่ยังไม่ได้ลงทะเบียนในรอบเรียนซ้ำปัจจุบัน (RepeatTeacher ว่าง หรือ RepeatYear != activeRepeatYear)
        $countPending = count($this->db->table('tb_register')
            ->select('tb_register.SubjectID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->where('tb_register.RegisterYear', $year)
            ->where('tb_subjects.SubjectYear', $year)
            ->groupStart()
                ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
                ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
            ->groupEnd()
            ->groupStart()
                ->where('tb_register.RepeatStatus !=', 'ผ่าน')
                ->orWhere('tb_register.RepeatStatus IS NULL')
            ->groupEnd()
            ->groupStart()
                ->where('tb_register.RepeatTeacher', '')
                ->orWhere('tb_register.RepeatTeacher IS NULL')
                ->orGroupStart()
                    ->where('tb_register.RepeatYear !=', $activeRepeatYear)
                    ->orWhere('tb_register.RepeatYear', '')
                    ->orWhere('tb_register.RepeatYear IS NULL')
                ->groupEnd()
            ->groupEnd()
            ->groupBy('tb_register.SubjectID, tb_register.TeacherID')
            ->get()->getResult());

        // 4. Count for Registered Accordion Badge
        $builderRegMatch = $this->db->table('tb_register')
            ->select('SubjectID')
            ->where('RepeatTeacher !=', '')
            ->where('RepeatStatus', 'ไม่ผ่าน');

        if ($year == $activeRepeatYear) {
            $builderRegMatch->where('RepeatYear', $activeRepeatYear);
        } else {
            $builderRegMatch->where('RegisterYear', $year)
                            ->where('RepeatYear', $activeRepeatYear);
        }

        if (!empty($attempt)) {
            $builderRegMatch->where('Grade_Type', $attempt);
        }
        $countRegistered = count($builderRegMatch->groupBy('SubjectID, RepeatTeacher, TeacherID, Grade_Type')->get()->getResult());

        // 5. Count of distinct students eligible for repeat study in selected year
        $countEligibleStudents = count($this->db->table('tb_register')
            ->select('StudentID')
            ->where('RegisterYear', $year)
            ->groupStart()
                ->whereIn('Grade', ['0', '0.0', 'ร', 'มส'])
                ->orWhere('RepeatStatus', 'ไม่ผ่าน')
            ->groupEnd()
            ->groupStart()
                ->where('RepeatStatus !=', 'ผ่าน')
                ->orWhere('RepeatStatus IS NULL')
            ->groupEnd()
            ->groupBy('StudentID')
            ->get()->getResult());

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'total_subjects_repeat' => $stats->total_subjects_repeat ?? 0,
                'total_repeat_students' => $stats->total_repeat_students ?? 0,
                'total_repeat_registrations' => $stats->total_repeat_registrations ?? 0,
                'total_repeat_teachers' => $stats->total_repeat_teachers ?? 0,
                'count_main' => $countMain,
                'count_pending' => $countPending,
                'count_registered' => $countRegistered,
                'count_eligible_students' => $countEligibleStudents,
                'year' => $year,
                'attempt' => $attempt
            ]
        ]);
    }

    /**
     * AJAX endpoint to get list of students registered for repeat study
     */
    public function getRepeatStudentDetails()
    {
        $year = $this->request->getPost('year') ?? $this->request->getGet('year');
        
        if (empty($year)) {
            $checkRepeat = $this->db->table('tb_register_onoff')
            ->select('onoff_year')
            ->where('onoff_name', 'เรียนซ้ำ')
            ->get()->getRow();
            $year = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : null;
        }
        
        if (empty($year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Active repeat year not found in system settings']);
        }

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : $year;

        $attempt = $this->request->getPost('attempt') ?? $this->request->getGet('attempt');

        $builder = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber, 
                tb_register.RepeatYear,
                tb_register.Grade_Type,
                COUNT(tb_register.SubjectID) as SubjectCount,
                GROUP_CONCAT(tb_subjects.SubjectCode SEPARATOR ", ") as RepeatedSubjects,
                GROUP_CONCAT(CONCAT(tb_subjects.SubjectCode, "::", tb_subjects.SubjectName, "::", IFNULL(repeat_teacher.pers_prefix, ""), IFNULL(repeat_teacher.pers_firstname, ""), " ", IFNULL(repeat_teacher.pers_lastname, ""), "::", IFNULL(tb_register.Grade, "")) SEPARATOR "||") as SubjectDetails
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT')
            ->where('tb_register.RepeatTeacher !=', '')
            ->where('tb_register.RepeatStatus', 'ไม่ผ่าน');

        if ($year == $activeRepeatYear) {
            $builder->where('tb_register.RepeatYear', $activeRepeatYear);
        } else {
            $builder->where('tb_register.RegisterYear', $year)
                    ->where('tb_register.RepeatYear', $activeRepeatYear);
        }

        if (!empty($attempt)) {
            $builder->where('tb_register.Grade_Type', $attempt);
        }

        $students = $builder->groupBy('tb_students.StudentID, tb_register.RepeatYear, tb_register.Grade_Type')
            ->orderBy('tb_students.StudentClass', 'ASC')
            ->orderBy('tb_students.StudentNumber', 'ASC')
            ->get()->getResult();

        return $this->response->setJSON(['status' => 'success', 'data' => $students]);
    }

    /**
     * AJAX endpoint to get list of students registered for repeat study for a SPECIFIC SUBJECT
     */
    public function getRepeatStudentDetailsBySubject()
    {
        $subjectID = $this->request->getPost('subject_id');
        
        if (empty($subjectID)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Subject ID is required']);
        }

        // Fetch the active repeat year
        $checkRepeat = $this->db->table('tb_register_onoff')
            ->select('onoff_year')
            ->where('onoff_name', 'เรียนซ้ำ')
            ->get()->getRow();
        
        $year = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : null;

        if (empty($year)) {
            // Fallback or error? Let's just return empty if no active year.
            return $this->response->setJSON(['status' => 'error', 'message' => 'No active repeat year found']);
        }

        $students = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber,
                tb_register.RepeatYear,
                tb_register.RepeatStatus,
                tb_register.Grade_Type,
                CONCAT(repeat_teacher.pers_prefix, repeat_teacher.pers_firstname, " ", repeat_teacher.pers_lastname) as RepeatTeacherName
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            // Join personnel for repeat teacher name
            ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT')
            ->where('tb_register.SubjectID', $subjectID)
            ->where('tb_register.RepeatYear', $year)
            ->where('tb_register.RepeatTeacher !=', '')
            ->orderBy('tb_students.StudentClass', 'ASC')
            ->orderBy('tb_students.StudentNumber', 'ASC')
            ->get()->getResult();

        return $this->response->setJSON(['status' => 'success', 'data' => $students]);
    }

    /**
     * AJAX endpoint to get list of students eligible for repeat study (Failing grades: 0, ร, มส that have not passed)
     * Student-Centric Mode
     */
    public function getEligibleRepeatStudents()
    {
        $year = $this->request->getPost('year') ?? $this->request->getGet('year');
        $grade = $this->request->getPost('grade'); // e.g. 'ม.1'
        $class = $this->request->getPost('class'); // e.g. 'ม.1/1'
        $statusFilter = $this->request->getPost('status_filter'); // 'all', 'pending', 'assigned'
        $search = trim($this->request->getPost('search') ?? '');

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : $year;

        $builder = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber,
                COUNT(tb_register.SubjectID) as TotalFailingCount,
                SUM(CASE WHEN tb_register.RepeatTeacher != "" AND tb_register.RepeatTeacher IS NOT NULL AND tb_register.RepeatYear = ' . $this->db->escape($activeRepeatYear) . ' AND tb_register.RepeatStatus = "ไม่ผ่าน" THEN 1 ELSE 0 END) as AssignedCount,
                SUM(CASE WHEN tb_register.RepeatTeacher = "" OR tb_register.RepeatTeacher IS NULL OR tb_register.RepeatYear != ' . $this->db->escape($activeRepeatYear) . ' OR tb_register.RepeatYear IS NULL THEN 1 ELSE 0 END) as PendingCount,
                GROUP_CONCAT(DISTINCT tb_register.RegisterYear ORDER BY tb_register.RegisterYear DESC SEPARATOR ", ") as FailingYears,
                GROUP_CONCAT(
                    CONCAT(
                        tb_subjects.SubjectCode, "::", 
                        tb_subjects.SubjectName, "::", 
                        IFNULL(tb_register.Grade, "-"), "::", 
                        IFNULL(tb_register.RegisterYear, "-"), "::", 
                        IF(tb_register.RepeatTeacher != "" AND tb_register.RepeatTeacher IS NOT NULL AND tb_register.RepeatYear = ' . $this->db->escape($activeRepeatYear) . ' AND tb_register.RepeatStatus = "ไม่ผ่าน", "assigned", "pending"), "::",
                        IFNULL(repeat_teacher.pers_prefix, ""), IFNULL(repeat_teacher.pers_firstname, ""), " ", IFNULL(repeat_teacher.pers_lastname, "")
                    ) 
                    ORDER BY tb_register.RegisterYear DESC, tb_subjects.SubjectCode ASC 
                    SEPARATOR "||"
                ) as FailingDetails
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT')
            ->groupStart()
                ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
                ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
            ->groupEnd()
            ->groupStart()
                ->where('tb_register.RepeatStatus !=', 'ผ่าน')
                ->orWhere('tb_register.RepeatStatus IS NULL')
            ->groupEnd();

        if (!empty($year) && $year !== 'all') {
            $builder->where('tb_register.RegisterYear', $year);
        }

        if (!empty($class) && $class !== 'all') {
            $builder->where('tb_students.StudentClass', $class);
        } elseif (!empty($grade) && $grade !== 'all') {
            $builder->like('tb_students.StudentClass', $grade, 'after');
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tb_students.StudentCode', $search)
                ->orLike('tb_students.StudentFirstName', $search)
                ->orLike('tb_students.StudentLastName', $search)
                ->orLike("CONCAT(tb_students.StudentFirstName, ' ', tb_students.StudentLastName)", $search)
                ->groupEnd();
        }

        $builder->groupBy('tb_students.StudentID, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_students.StudentClass, tb_students.StudentNumber')
            ->orderBy('tb_students.StudentClass', 'ASC')
            ->orderBy('tb_students.StudentNumber', 'ASC');

        $students = $builder->get()->getResult();

        // Optional post-filter by status
        if ($statusFilter === 'pending') {
            $students = array_values(array_filter($students, function($s) {
                return (int)$s->PendingCount > 0;
            }));
        } elseif ($statusFilter === 'assigned') {
            $students = array_values(array_filter($students, function($s) {
                return (int)$s->PendingCount === 0 && (int)$s->AssignedCount > 0;
            }));
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $students,
            'active_repeat_year' => $activeRepeatYear
        ]);
    }

    /**
     * AJAX endpoint to search students for repeat registration by name or student code across ALL years
     */
    public function searchStudentsForRepeat()
    {
        $keyword = trim($this->request->getPost('keyword') ?? '');
        if (empty($keyword) || mb_strlen($keyword, 'UTF-8') < 2) {
            return $this->response->setJSON(['status' => 'success', 'data' => [], 'count' => 0]);
        }

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : '';

        $builder = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber,
                COUNT(tb_register.SubjectID) as TotalFailingCount,
                SUM(CASE WHEN tb_register.RepeatTeacher != "" AND tb_register.RepeatTeacher IS NOT NULL AND tb_register.RepeatYear = ' . $this->db->escape($activeRepeatYear) . ' AND tb_register.RepeatStatus = "ไม่ผ่าน" THEN 1 ELSE 0 END) as AssignedCount,
                SUM(CASE WHEN tb_register.RepeatTeacher = "" OR tb_register.RepeatTeacher IS NULL OR tb_register.RepeatYear != ' . $this->db->escape($activeRepeatYear) . ' OR tb_register.RepeatYear IS NULL THEN 1 ELSE 0 END) as PendingCount,
                GROUP_CONCAT(DISTINCT tb_register.RegisterYear ORDER BY tb_register.RegisterYear DESC SEPARATOR ", ") as FailingYears,
                GROUP_CONCAT(
                    CONCAT(
                        tb_subjects.SubjectCode, "::", 
                        tb_subjects.SubjectName, "::", 
                        IFNULL(tb_register.Grade, "-"), "::", 
                        IFNULL(tb_register.RegisterYear, "-"), "::", 
                        IF(tb_register.RepeatTeacher != "" AND tb_register.RepeatTeacher IS NOT NULL AND tb_register.RepeatYear = ' . $this->db->escape($activeRepeatYear) . ' AND tb_register.RepeatStatus = "ไม่ผ่าน", "assigned", "pending")
                    ) 
                    ORDER BY tb_register.RegisterYear DESC, tb_subjects.SubjectCode ASC 
                    SEPARATOR "||"
                ) as FailingDetails
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->groupStart()
                ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
                ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
            ->groupEnd()
            ->groupStart()
                ->where('tb_register.RepeatStatus !=', 'ผ่าน')
                ->orWhere('tb_register.RepeatStatus IS NULL')
            ->groupEnd()
            ->groupStart()
                ->like('tb_students.StudentCode', $keyword)
                ->orLike('tb_students.StudentFirstName', $keyword)
                ->orLike('tb_students.StudentLastName', $keyword)
                ->orLike("CONCAT(tb_students.StudentFirstName, ' ', tb_students.StudentLastName)", $keyword)
            ->groupEnd()
            ->groupBy('tb_students.StudentID, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_students.StudentClass, tb_students.StudentNumber')
            ->orderBy('tb_students.StudentClass', 'ASC')
            ->orderBy('tb_students.StudentNumber', 'ASC')
            ->limit(25);

        $students = $builder->get()->getResult();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $students,
            'count' => count($students),
            'active_repeat_year' => $activeRepeatYear
        ]);
    }

    /**
     * AJAX endpoint to get all failing subjects for a single student (for student-centric assignment modal)
     */
    public function getStudentFailingSubjects()
    {
        $studentId = $this->request->getPost('student_id');
        if (empty($studentId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Student ID is required']);
        }

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : '';
        $activeAttempt = !empty($checkRepeat->onoff_detail) ? $checkRepeat->onoff_detail : 'เรียนซ้ำครั้งที่ 1';

        $student = $this->db->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber')
            ->where('StudentID', $studentId)
            ->get()->getRow();

        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลนักเรียน']);
        }

        $subjects = $this->db->table('tb_register')
            ->select('
                tb_register.StudentID,
                tb_register.SubjectID,
                tb_register.Grade,
                tb_register.RegisterYear,
                tb_register.RepeatStatus,
                tb_register.RepeatYear,
                tb_register.RepeatTeacher,
                tb_register.Grade_Type,
                tb_register.TeacherID as OriginalTeacherID,
                tb_subjects.SubjectCode,
                tb_subjects.SubjectName,
                tb_subjects.SubjectUnit,
                tb_subjects.FirstGroup,
                orig_teacher.pers_prefix as orig_prefix,
                orig_teacher.pers_firstname as orig_fname,
                orig_teacher.pers_lastname as orig_lname,
                rep_teacher.pers_prefix as rep_prefix,
                rep_teacher.pers_firstname as rep_fname,
                rep_teacher.pers_lastname as rep_lname
            ')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join($this->DBPers->database . '.tb_personnel AS orig_teacher', 'orig_teacher.pers_id = tb_register.TeacherID', 'LEFT')
            ->join($this->DBPers->database . '.tb_personnel AS rep_teacher', 'rep_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT')
            ->where('tb_register.StudentID', $studentId)
            ->groupStart()
                ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
                ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
            ->groupEnd()
            ->groupStart()
                ->where('tb_register.RepeatStatus !=', 'ผ่าน')
                ->orWhere('tb_register.RepeatStatus IS NULL')
            ->groupEnd()
            ->orderBy('tb_register.RegisterYear', 'DESC')
            ->orderBy('tb_subjects.SubjectCode', 'ASC')
            ->get()->getResult();

        return $this->response->setJSON([
            'status' => 'success',
            'student' => $student,
            'subjects' => $subjects,
            'active_repeat_year' => $activeRepeatYear,
            'active_attempt' => $activeAttempt
        ]);
    }

    /**
     * AJAX endpoint to save/update repeat assignments for a single student across multiple subjects
     */
    public function saveRepeatAssignmentByStudent()
    {
        $studentId = $this->request->getPost('student_id');
        $assignments = $this->request->getPost('assignments');

        if (empty($studentId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Student ID is required']);
        }

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : '';
        $activeAttempt = !empty($checkRepeat->onoff_detail) ? $checkRepeat->onoff_detail : 'เรียนซ้ำครั้งที่ 1';

        if (empty($assignments) || !is_array($assignments)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่มีรายการวิชาที่เลือกดำเนินการ']);
        }

        $updatedCount = 0;
        foreach ($assignments as $item) {
            $subjectId = $item['subject_id'] ?? '';
            $registerYear = $item['register_year'] ?? '';
            $action = $item['action'] ?? 'assign'; // 'assign' or 'cancel'
            $repeatTeacher = $item['repeat_teacher'] ?? '';

            if (empty($subjectId) || empty($registerYear)) continue;

            if ($action === 'assign') {
                if (empty($repeatTeacher)) continue; // Must specify repeat teacher

                $updateData = [
                    'RepeatTeacher' => $repeatTeacher,
                    'RepeatYear' => $activeRepeatYear,
                    'Grade_Type' => $activeAttempt,
                    'RepeatStatus' => 'ไม่ผ่าน'
                ];

                $this->db->table('tb_register')
                    ->where('StudentID', $studentId)
                    ->where('SubjectID', $subjectId)
                    ->where('RegisterYear', $registerYear)
                    ->update($updateData);

                $updatedCount++;
            } elseif ($action === 'cancel') {
                $updateData = [
                    'RepeatTeacher' => '',
                    'RepeatYear' => '',
                    'Grade_Type' => '',
                    'RepeatStatus' => ''
                ];

                $this->db->table('tb_register')
                    ->where('StudentID', $studentId)
                    ->where('SubjectID', $subjectId)
                    ->where('RegisterYear', $registerYear)
                    ->update($updateData);

                $updatedCount++;
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'บันทึกการมอบหมายวิชาเรียนซ้ำเรียบร้อยแล้ว (' . $updatedCount . ' รายการ)',
            'updated_count' => $updatedCount
        ]);
    }

    /**
     * AJAX endpoint to persist current repeat filters (year, attempt, tab) to session
     */
    public function setRepeatSessionYear()
    {
        $year = $this->request->getPost('year');
        $attempt = $this->request->getPost('attempt');
        $tab = $this->request->getPost('tab');

        if (!empty($year)) {
            session()->set('repeat_selected_year', $year);
        }
        if ($attempt !== null) {
            session()->set('repeat_selected_attempt', $attempt);
        }
        if (!empty($tab)) {
            session()->set('repeat_selected_tab', $tab);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    public function AdminRegisRepeatDetail($Term,$Year,$IDSubject,$TechID){
        $data['admin'] = $this->DBPers->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['repeat_setting'] = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $data['title'] = "ลงทะเบียนเรียนซ้ำนักเรียนรายวิชา";

        $data['Term'] = $Term;
        $data['Year'] = $Year;
        $data['IDSubject'] = $IDSubject;
        $data['TechID'] = $TechID;

        // Remember current repeat year in session so returning back retains the exact year
        $repeatYearKey = $Term . '/' . $Year;
        session()->set('repeat_selected_year', $repeatYearKey);

        // ดึงข้อมูลวิชาและครูผู้สอนประจำวิชาโดยตรง
        $data['Subject'] = $this->db->table('tb_subjects')->where('SubjectID', urldecode($IDSubject))->get()->getRow();
        $data['mainTeacher'] = $this->DBPers->table('tb_personnel')
            ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
            ->where('pers_id', $TechID)
            ->get()->getRow();

        $data['Teacher'] = $this->DBPers->table('tb_personnel')
        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
        ->where('pers_learning !=',"")
        ->where('pers_status',"กำลังใช้งาน")
        ->get()->getResult();

        $builder = $this->db->table('tb_register')->select("
        tb_students.StudentID,
        tb_students.StudentPrefix,
        tb_students.StudentFirstName,
        tb_students.StudentLastName,
        tb_students.StudentClass,
        tb_students.StudentCode,
        tb_students.StudentNumber,
        tb_students.StudentStatus,
        tb_students.StudentBehavior,       
        tb_subjects.SubjectName,
        tb_subjects.SubjectYear,
        tb_register.SubjectID,
        tb_subjects.SubjectCode,
        tb_register.RegisterYear,
        tb_register.Grade,
        tb_register.RepeatStatus,
        tb_register.Grade_Type,
        tb_register.TeacherID,
        tb_register.RepeatTeacher,
        tb_register.RepeatYear,
        CONCAT(teacher.pers_prefix,teacher.pers_firstname,' ',teacher.pers_lastname) AS TeacherName,
        CONCAT(repeat_teacher.pers_prefix,repeat_teacher.pers_firstname,' ',repeat_teacher.pers_lastname) AS RepeatTeacherName")
        ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
        ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
        ->join($this->DBPers->database . '.tb_personnel AS teacher', 'teacher.pers_id = tb_register.TeacherID','LEFT')
        ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher','LEFT')
        ->where('tb_register.RegisterYear',$Term.'/'.$Year)
        ->where('tb_register.SubjectID',urldecode($IDSubject))
        // แสดงเฉพาะนักเรียนที่ไม่ผ่าน ติด 0, ร, มส เท่านั้น (คนเกรดผ่านแต่แรก หรือผ่านการเรียนซ้ำแล้ว ไม่ต้องแสดงผล)
        ->groupStart()
            ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
            ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
        ->groupEnd()
        ->groupStart()
            ->where('tb_register.RepeatStatus !=', 'ผ่าน')
            ->orWhere('tb_register.RepeatStatus IS NULL')
        ->groupEnd();

        if (!empty($TechID) && $TechID !== 'all' && $TechID !== '0') {
            $builder->groupStart()
                ->where('tb_register.TeacherID', $TechID)
                ->orWhere('tb_register.RepeatTeacher', $TechID)
            ->groupEnd();
        }

        $data['DataRepeat'] = $builder->orderBy('StudentClass','ASC')
            ->orderBy('StudentNumber','ASC')
            ->get()->getResult();

        $builderTeacher = $this->db->table('tb_register')->select("       
        tb_register.RepeatTeacher")
        ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
        ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$Year)
        ->where('tb_register.SubjectID',urldecode($IDSubject))
        ->where('tb_register.RepeatTeacher !=','')
        ->groupStart()
            ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
            ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
        ->groupEnd()
        ->groupStart()
            ->where('tb_register.RepeatStatus !=', 'ผ่าน')
            ->orWhere('tb_register.RepeatStatus IS NULL')
        ->groupEnd();

        if (!empty($TechID) && $TechID !== 'all' && $TechID !== '0') {
            $builderTeacher->groupStart()
                ->where('tb_register.TeacherID', $TechID)
                ->orWhere('tb_register.RepeatTeacher', $TechID)
            ->groupEnd();
        }

        $data['DataRepeatTeacher'] = $builderTeacher->groupBy("RepeatTeacher")->get()->getResult();
        

       //echo '<pre>'; print_r((session()->get('fullname'))); exit();
        return view('admin/Academic/AdminRegisRepeat/AdminRegisRepeatAdd', $data);
    }

    public function AdminRegisRepeatEdit($codeSub,$TeachID){
        $data['title'] = "แก้ไขรายชื่อการลงทะเบียนเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getRow(); // Use getRow() for single result
        $data['teacher'] = $this->DBPers->table('tb_personnel')
                                        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                        ->where('pers_learning !=',"")
                                        ->get()->getResult();
        $data['Register'] = $this->db->table('tb_register')->select("tb_register.RegisterYear,
                                    tb_subjects.SubjectName,
                                    tb_subjects.SubjectID,
                                    tb_register.SubjectID,
                                    tb_register.StudentID,
                                    tb_register.TeacherID,
                                    tb_students.StudentCode,
                                    tb_students.StudentClass,
                                    tb_students.StudentNumber,
                                    tb_students.StudentPrefix,
                                    tb_students.StudentFirstName,
                                    tb_students.StudentLastName   
                                    ")
                                    ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                    ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
                                    //->where('RegisterYear',$CheckYear[0]->schyear_year) 
                                    ->where('TeacherID',$TeachID)
                                    ->where('SubjectID',$codeSub)
                                    ->get()->getResult();

        
      
        $data['classroom'] = new \App\Libraries\Classroom();
        echo view('admin/Academic/AdminRegisRepeat/AdminEnrollFormEdit.php', $data);
    }

    public function AdminRegisRepeatAdd(){
        try {
            $CheckRepeat = $this->db->table('tb_register_onoff')->select('onoff_detail,onoff_year')->where('onoff_name','เรียนซ้ำ')->get()->getRow();
                 
            $IdStuRepeat = array();
            $CountUpSucceed =0;

             if($this->request->getPost('StuID')){
                   $DataUpdateRepeat = array('Grade_Type' => !empty($CheckRepeat->onoff_detail) ? $CheckRepeat->onoff_detail : '','RepeatStatus'=>'ไม่ผ่าน','RepeatYear'=>!empty($CheckRepeat->onoff_year) ? $CheckRepeat->onoff_year : '','RepeatTeacher' => $this->request->getPost('RepeatTeacher'));

                   $registerYear = $this->request->getPost('YearRepeat');
                   $subjectID = $this->request->getPost('SubjectRepeat');
                   $studentIDs = $this->request->getPost('StuID'); // Can be array or single

                   if (!is_array($studentIDs)) {
                       $studentIDs = [$studentIDs];
                   }

                   $updated = $this->db->table('tb_register')
                                       ->where('SubjectID',$subjectID)
                                       ->where('RegisterYear',$registerYear)
                                       ->whereIn('StudentID',$studentIDs)
                                       ->update($DataUpdateRepeat);
                   $updatedCount = $this->db->affectedRows() > 0 ? $this->db->affectedRows() : ($updated ? count($studentIDs) : 0);
                   
                   if ($updatedCount > 0) {
                       return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มนักเรียนเรียนซ้ำสำเร็จ', 'affected_rows' => $updatedCount]);
                   } else {
                       return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถเพิ่มนักเรียนเรียนซ้ำได้', 'affected_rows' => 0]);
                   }
            }

            if($this->request->getPost('DelStatus') == "Del"){
                $DataDelete = array('Grade_Type' => "",'RepeatStatus'=>'','RepeatYear'=>"",'RepeatTeacher' => "");                    
                $subjectID = $this->request->getPost('SubjectRepeat');
                $studentIDs = $this->request->getPost('DelStuID'); // Can be array or single
                $registerYear = $this->request->getPost('YearRepeat');

                if (!is_array($studentIDs)) {
                    $studentIDs = [$studentIDs];
                }

                 $updated =  $this->db->table('tb_register')
                                     ->where('SubjectID',$subjectID)
                                     ->where('RepeatConfirm',"")
                                     ->where('RegisterYear',$registerYear)
                                     ->whereIn('StudentID',$studentIDs)
                                     ->update($DataDelete);
                 $updatedCount = $this->db->affectedRows() > 0 ? $this->db->affectedRows() : ($updated ? count($studentIDs) : 0);
                
                if ($updatedCount > 0) {
                    return $this->response->setJSON(['status' => 'success', 'message' => 'ถอนข้อมูลนักเรียนเรียนซ้ำสำเร็จ', 'affected_rows' => $updatedCount]);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถถอนข้อมูลนักเรียนเรียนซ้ำได้', 'affected_rows' => 0]);
                }
            }

            return $this->response->setJSON(['status' => 'info', 'message' => 'ไม่มีการดำเนินการ']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function AdminRegisRepeatDel(){

        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregisupdate'))->get()->getRow();

        foreach ($this->request->getPost('to') as $key => $value) {
         $a =  array('StudentID' => $value,
         'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
         'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
         'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
         'TeacherID' => $this->request->getPost('teacherregis')
         );   
             $this->db->table('tb_register')->where($a);
        echo $this->db->table('tb_register')->delete();
        }     
     }

    public function AdminRegisRepeatSelect(){
        $KeyStudyLines = $this->request->getPost('KeyStudyLines');
        $KeyRoom = $this->request->getPost('KeyRoom');
        $subject = [];

        if($KeyStudyLines === "All"){
            $subject = $this->db->table('tb_students')->select('StudentID,StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentClass,StudentStudyLine,
            (SELECT GROUP_CONCAT(DISTINCT StudentStudyLine SEPARATOR "|") 
            FROM tb_students WHERE StudentClass = "ม.'.(!empty($KeyRoom) ? $KeyRoom : '').'" AND StudentStatus="1/ปกติ") AS StudyLines
            ')
                                ->where('StudentClass','ม.'.(!empty($KeyRoom) ? $KeyRoom : ''))
                                ->where('StudentStatus','1/ปกติ')
                                ->orderBy('StudentNumber')
                                ->get()->getResult();
        }else{
            $subject = $this->db->table('tb_students')->select('StudentID,StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentClass,StudentStudyLine,
            (SELECT GROUP_CONCAT(DISTINCT StudentStudyLine SEPARATOR "|") 
            FROM tb_students WHERE StudentClass = "ม.'.(!empty($KeyRoom) ? $KeyRoom : '').'" AND StudentStatus="1/ปกติ") AS StudyLines
            ')
                            ->where('StudentClass','ม.'.(!empty($KeyRoom) ? $KeyRoom : ''))
                            ->where('StudentStudyLine',$KeyStudyLines)
                            ->where('StudentStatus','1/ปกติ')
                            ->orderBy('StudentNumber')
                            ->get()->getResult();
        }
       
        return $this->response->setJSON($subject);
        
    }

    public function AdminRegisRepeatShow(){ 
        $data = [];
        $keyYear = $this->request->getVar('keyYear');
        $keyAttempt = $this->request->getVar('keyAttempt');

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : $keyYear;
       
        $builder = $this->db->table('tb_register')->select("
                                    skjacth_academic.tb_register.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectName,
                                    skjacth_academic.tb_subjects.FirstGroup,
                                    GROUP_CONCAT(DISTINCT skjacth_academic.tb_register.RegisterClass ORDER BY skjacth_academic.tb_register.RegisterClass SEPARATOR ', ') AS RegisterClass,
                                    skjacth_academic.tb_register.TeacherID,
                                    skjacth_academic.tb_register.RepeatTeacher,
                                    skjacth_academic.tb_subjects.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectCode,
                                    skjacth_academic.tb_subjects.SubjectYear,
                                    main_teacher.pers_firstname AS main_pers_firstname,
                                    main_teacher.pers_prefix AS main_pers_prefix,
                                    main_teacher.pers_lastname AS main_pers_lastname,
                                    repeat_teacher.pers_firstname AS repeat_pers_firstname,
                                    repeat_teacher.pers_prefix AS repeat_pers_prefix,
                                    repeat_teacher.pers_lastname AS repeat_pers_lastname,
                                    skjacth_academic.tb_register.RepeatYear,
                                    skjacth_academic.tb_register.Grade_Type,
                                    COUNT(*) AS SumRepeat")
                                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                ->join($this->DBPers->database . '.tb_personnel AS main_teacher', 'main_teacher.pers_id = skjacth_academic.tb_register.TeacherID', 'LEFT')
                                ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = skjacth_academic.tb_register.RepeatTeacher', 'LEFT')
                                ->where('tb_register.RepeatTeacher !=', '')
                                ->where('tb_register.RepeatStatus', 'ไม่ผ่าน');

        if ($keyYear == $activeRepeatYear) {
            $builder->where('tb_register.RepeatYear', $activeRepeatYear);
        } else {
            $builder->where('tb_register.RegisterYear', $keyYear)
                    ->where('tb_register.RepeatYear', $activeRepeatYear);
        }

        if (!empty($keyAttempt)) {
            $builder->where('tb_register.Grade_Type', $keyAttempt);
        }

        $Register = $builder->groupBy('skjacth_academic.tb_register.SubjectID, skjacth_academic.tb_register.RepeatTeacher, skjacth_academic.tb_register.TeacherID, skjacth_academic.tb_subjects.SubjectName, skjacth_academic.tb_subjects.FirstGroup, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectYear, skjacth_academic.tb_register.RepeatYear, skjacth_academic.tb_register.Grade_Type, main_teacher.pers_firstname, main_teacher.pers_prefix, main_teacher.pers_lastname, repeat_teacher.pers_firstname, repeat_teacher.pers_prefix, repeat_teacher.pers_lastname')
                                ->get()->getResult();

        foreach($Register as $record){
            
            $data[] = array( 
                "SubjectYear" => $record->SubjectYear,
                "SubjectCode" => $record->SubjectCode,
                "SubjectName" => $record->SubjectName,
                "FirstGroup" => $record->FirstGroup,
                "SubjectClass" => $record->RegisterClass,
                "SubjectID" => $record->SubjectID,
                "TeacherName" => $record->repeat_pers_prefix . $record->repeat_pers_firstname . ' ' . $record->repeat_pers_lastname,
                "MainTeacherName" => $record->main_pers_prefix . $record->main_pers_firstname . ' ' . $record->main_pers_lastname,
                "TeacherID" => $record->RepeatTeacher,
                "Grade_Type" => $record->Grade_Type,
                "RepeatYear" => $record->RepeatYear,
                "SumRepeat" => $record->SumRepeat
            );
           
        }   

        $output = array(
            "data" =>  $data
        );

        return $this->response->setJSON($output);
    }

    /**
     * ดึงข้อมูลวิชาหลักทั้งหมดในปีการศึกษา (แสดงครูผู้สอนและจำนวนนักเรียน)
     */
    public function AdminRegisRepeatShowMainSubjects(){ 
        $data = [];
        $keyYear = $this->request->getVar('keyYear');
       
        // ดึงวิชาหลักทั้งหมดที่มีการลงทะเบียนนักเรียน
        $Register = $this->db->table('tb_register')->select("
                                    skjacth_academic.tb_register.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectName,
                                    skjacth_academic.tb_subjects.FirstGroup,
                                    GROUP_CONCAT(DISTINCT skjacth_academic.tb_register.RegisterClass ORDER BY skjacth_academic.tb_register.RegisterClass SEPARATOR ', ') AS RegisterClass,
                                    skjacth_academic.tb_register.TeacherID,
                                    skjacth_academic.tb_subjects.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectCode,
                                    skjacth_academic.tb_subjects.SubjectYear,
                                    skjacth_academic.tb_subjects.SubjectUnit,
                                    teacher.pers_firstname,
                                    teacher.pers_prefix,
                                    teacher.pers_lastname,
                                    COUNT(*) AS TotalStudents")
                                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                ->join($this->DBPers->database . '.tb_personnel AS teacher', 'teacher.pers_id = skjacth_academic.tb_register.TeacherID', 'LEFT')
                                ->where('tb_register.RegisterYear', $keyYear)
                                ->where('tb_subjects.SubjectYear', $keyYear)
                                ->groupBy('skjacth_academic.tb_register.SubjectID, skjacth_academic.tb_register.TeacherID, skjacth_academic.tb_subjects.SubjectName, skjacth_academic.tb_subjects.FirstGroup, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectYear, skjacth_academic.tb_subjects.SubjectUnit, teacher.pers_firstname, teacher.pers_prefix, teacher.pers_lastname')
                                ->get()->getResult();

        foreach($Register as $record){
            $data[] = array( 
                "SubjectYear" => $record->SubjectYear,
                "SubjectCode" => $record->SubjectCode,
                "SubjectName" => $record->SubjectName,
                "SubjectUnit" => $record->SubjectUnit,
                "FirstGroup" => $record->FirstGroup,
                "SubjectClass" => $record->RegisterClass,
                "SubjectID" => $record->SubjectID,
                "TeacherName" => $record->pers_prefix . $record->pers_firstname . ' ' . $record->pers_lastname,
                "TeacherID" => $record->TeacherID,
                "TotalStudents" => $record->TotalStudents
            );
        }   

        $output = array(
            "data" =>  $data
        );

        return $this->response->setJSON($output);
    }

    /**
     * ดึงข้อมูลรายวิชาที่รอลงทะเบียนเรียนซ้ำ (Grade = 0 หรือ ร และ RepeatTeacher ว่าง)
     */
    public function AdminRegisRepeatShowPending(){ 
        $data = [];
        $keyYear = $this->request->getVar('keyYear');

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : '';
       
        // ดึงวิชาที่มีนักเรียนรอลงทะเบียนเรียนซ้ำ (Grade = 0, ร, มส หรือ RepeatStatus = ไม่ผ่าน) ที่ยังไม่ได้ลงทะเบียนในรอบเรียนซ้ำปัจจุบัน
        $Register = $this->db->table('tb_register')->select("
                                    skjacth_academic.tb_register.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectName,
                                    skjacth_academic.tb_subjects.FirstGroup,
                                    GROUP_CONCAT(DISTINCT skjacth_academic.tb_register.RegisterClass ORDER BY skjacth_academic.tb_register.RegisterClass SEPARATOR ', ') AS RegisterClass,
                                    skjacth_academic.tb_register.TeacherID,
                                    skjacth_academic.tb_subjects.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectCode,
                                    skjacth_academic.tb_subjects.SubjectYear,
                                    teacher.pers_firstname,
                                    teacher.pers_prefix,
                                    teacher.pers_lastname,
                                    COUNT(*) AS SumPending")
                                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                ->join($this->DBPers->database . '.tb_personnel AS teacher', 'teacher.pers_id = skjacth_academic.tb_register.TeacherID', 'LEFT')
                                ->where('tb_register.RegisterYear', $keyYear)
                                ->where('tb_subjects.SubjectYear', $keyYear)
                                ->groupStart()
                                    ->whereIn('tb_register.Grade', ['0', '0.0', 'ร', 'มส'])
                                    ->orWhere('tb_register.RepeatStatus', 'ไม่ผ่าน')
                                ->groupEnd()
                                ->groupStart()
                                    ->where('tb_register.RepeatStatus !=', 'ผ่าน')
                                    ->orWhere('tb_register.RepeatStatus IS NULL')
                                ->groupEnd()
                                ->groupStart()
                                    ->where('tb_register.RepeatTeacher', '')
                                    ->orWhere('tb_register.RepeatTeacher IS NULL')
                                    ->orGroupStart()
                                        ->where('tb_register.RepeatYear !=', $activeRepeatYear)
                                        ->orWhere('tb_register.RepeatYear', '')
                                        ->orWhere('tb_register.RepeatYear IS NULL')
                                    ->groupEnd()
                                ->groupEnd()
                                ->groupBy('skjacth_academic.tb_register.SubjectID, skjacth_academic.tb_register.TeacherID, skjacth_academic.tb_subjects.SubjectName, skjacth_academic.tb_subjects.FirstGroup, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectYear, teacher.pers_firstname, teacher.pers_prefix, teacher.pers_lastname')
                                ->get()->getResult();

        foreach($Register as $record){
            
            $data[] = array( 
                "SubjectYear" => $record->SubjectYear,
                "SubjectCode" => $record->SubjectCode,
                "SubjectName" => $record->SubjectName,
                "FirstGroup" => $record->FirstGroup,
                "SubjectClass" => $record->RegisterClass,
                "SubjectID" => $record->SubjectID,
                "TeacherName" => $record->pers_prefix . $record->pers_firstname . ' ' . $record->pers_lastname,
                "TeacherID" => $record->TeacherID,
                "SumPending" => $record->SumPending
            );
           
        }   

        $output = array(
            "data" =>  $data
        );

        return $this->response->setJSON($output);
    }

    public function AdminRegisRepeatInsert(){

       $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregis'))->get()->getRow();       
       // print_r($chk_Subject->SubjectCode);
       // print_r($chk_Subject->SubjectYear);
       // print_r($chk_Subject->SubjectClass);
       // print_r($this->request->getPost('teacherregis'));
       // print_r($this->request->getPost('to'));
        
       foreach ($this->request->getPost('to') as $key => $value) {
        $a =  array('StudentID' => $value,
        'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
        'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
        'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
        'TeacherID' => $this->request->getPost('teacherregis')
        );   
        echo $data = $this->db->table('tb_register')->insert($a);
       }     
    }

    public function AdminRegisRepeatUpdate(){

        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregisupdate'))->get()->getRow();

        foreach ($this->request->getPost('to') as $key => $value) {
         $a =  array('StudentID' => $value,
         'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
         'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
         'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
         'TeacherID' => $this->request->getPost('teacherregis')
         );   
         echo $data = $this->db->table('tb_register')->insert($a);
        }     
     }

    public function AdminRegisRepeatCancel(){

      
         $a =  array(
         'SubjectCode' => $this->request->getPost('KeySubject'),
         'TeacherID' => $this->request->getPost('KeyTeacher')
         );   
             $this->db->table('tb_register')->where($a);
        echo $this->db->table('tb_register')->delete();
            
     }

    /**
     * Update global repeat settings in tb_register_onoff
     */
    public function updateRepeatGlobalSettings()
    {
        $attempt = $this->request->getPost('attempt');
        $year = $this->request->getPost('year');

        if (empty($attempt)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุครั้งที่เรียนซ้ำ']);
        }

        $updateData = [
            'onoff_detail' => $attempt,
            'onoff_year' => $year
        ];

        $existing = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();

        if ($existing) {
            $result = $this->db->table('tb_register_onoff')
                ->where('onoff_name', 'เรียนซ้ำ')
                ->update($updateData);
        } else {
            $updateData['onoff_name'] = 'เรียนซ้ำ';
            $updateData['onoff_status'] = 'on';
            $updateData['onoff_Level'] = '';
            $updateData['onoff_StartDate'] = date('Y-m-d 00:00:00');
            $updateData['onoff_EndDate'] = date('Y-m-d 23:59:59', strtotime('+30 days'));
            $result = $this->db->table('tb_register_onoff')->insert($updateData);
        }

        if (!empty($year)) {
            helper('year');
            if (function_exists('set_selected_year')) {
                set_selected_year($year);
            }
            session()->set('admin_selected_year', $year);
        }

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตการตั้งค่าสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตข้อมูลได้ หรือข้อมูลเหมือนเดิม']);
        }
    }
    /**
     * AJAX endpoint to search for a student and get all their repeat registrations
     */
    public function getStudentRepeatRegistrations()
    {
        $studentCode = $this->request->getPost('student_code');
        $year = $this->request->getPost('year');

        if (empty($studentCode)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Student code is required']);
        }

        $student = $this->db->table('tb_students')
            ->select('StudentID, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber')
            ->where('StudentCode', $studentCode)
            ->orWhere('StudentID', $studentCode)
            ->get()->getRow();

        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Student not found']);
        }

        $registrations = $this->db->table('tb_register')
            ->select('
                tb_register.SubjectID,
                tb_subjects.SubjectCode,
                tb_subjects.SubjectName,
                tb_register.RegisterYear,
                tb_register.RepeatYear,
                tb_register.RepeatStatus,
                tb_register.Grade_Type,
                tb_register.Grade,
                CONCAT(repeat_teacher.pers_prefix, repeat_teacher.pers_firstname, " ", repeat_teacher.pers_lastname) as RepeatTeacherName
            ')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT')
            ->where('tb_register.StudentID', $student->StudentID)
            ->where('tb_register.RepeatYear', $year)
            ->where('tb_register.RepeatTeacher !=', '')
            ->get()->getResult();

        return $this->response->setJSON([
            'status' => 'success',
            'student' => $student,
            'data' => $registrations
        ]);
    }

    /**
     * AJAX endpoint to get students for a specific subject and teacher group
     */
    public function getRepeatStudentsBySubjectGroup()
    {
        $subjectID = $this->request->getPost('subid');
        $teacherID = $this->request->getPost('teachid');
        $year = $this->request->getPost('year');
        $attempt = $this->request->getPost('attempt'); // Catch attempt filter

        $checkRepeat = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $activeRepeatYear = !empty($checkRepeat->onoff_year) ? $checkRepeat->onoff_year : $year;

        $builder = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber,
                tb_register.Grade_Type,
                tb_register.RepeatStatus,
                tb_register.RepeatYear,
                tb_register.RegisterYear
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->where('tb_register.SubjectID', $subjectID)
            ->where('tb_register.RepeatTeacher', $teacherID)
            ->where('tb_register.RepeatStatus', 'ไม่ผ่าน'); // Match the main count logic

        if ($year == $activeRepeatYear) {
            $builder->where('tb_register.RepeatYear', $activeRepeatYear);
        } else {
            $builder->where('tb_register.RegisterYear', $year)
                    ->where('tb_register.RepeatYear', $activeRepeatYear);
        }
            
        if (!empty($attempt)) {
            $builder->where('tb_register.Grade_Type', $attempt);
        }

        $students = $builder->get()->getResult();

        return $this->response->setJSON(['status' => 'success', 'data' => $students]);
    }

    public function AdminRegisRepeatReport()
    {
        $data['admin'] = $this->DBPers->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id', session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $reqYear = $this->request->getGet('year');
        if (!empty($reqYear)) {
            $data['selectedYear'] = $reqYear;
        } elseif (session()->has('repeat_selected_year') && !empty(session()->get('repeat_selected_year'))) {
            $data['selectedYear'] = session()->get('repeat_selected_year');
        } else {
            $data['selectedYear'] = get_selected_year();
        }
        $data['title'] = "รายงานการลงทะเบียนเรียนซ้ำ";
        
        $data['GroupYear'] = $this->db->table('tb_register')
            ->select('RepeatYear')
            ->where('RepeatYear !=', '')
            ->groupBy('RepeatYear')
            ->orderBy('RepeatYear', 'DESC')
            ->get()->getResult();

        return view('admin/Academic/AdminRegisRepeat/AdminRegisRepeatReport', $data);
    }

    /**
     * AJAX endpoint for the repeat report table
     */
    public function getRepeatReportData()
    {
        $year = $this->request->getPost('year');
        $status = $this->request->getPost('status');
        $attempt = $this->request->getPost('attempt');

        $builder = $this->db->table('tb_register')
            ->select('
                tb_students.StudentID,
                tb_students.StudentCode, 
                tb_students.StudentPrefix, 
                tb_students.StudentFirstName, 
                tb_students.StudentLastName, 
                tb_students.StudentClass, 
                tb_students.StudentNumber,
                tb_subjects.SubjectCode,
                tb_subjects.SubjectName,
                tb_register.RegisterYear,
                tb_register.RepeatYear,
                tb_register.RepeatStatus,
                tb_register.Grade_Type,
                tb_register.Grade,
                CONCAT(repeat_teacher.pers_prefix, repeat_teacher.pers_firstname, " ", repeat_teacher.pers_lastname) as RepeatTeacherName
            ')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher', 'LEFT');

        if (!empty($year)) {
            $builder->where('tb_register.RepeatYear', $year);
        } else {
            // If no year specified, only show records that have repeat info
            $builder->where('tb_register.RepeatYear !=', '');
        }

        if (!empty($status) && $status !== 'ทั้งหมด') {
            $builder->where('tb_register.RepeatStatus', $status);
        } else {
            $builder->where('tb_register.RepeatStatus !=', '');
        }

        if (!empty($attempt)) {
            $builder->where('tb_register.Grade_Type', $attempt);
        }

        $results = $builder->orderBy('tb_register.RepeatYear', 'DESC')
                          ->orderBy('tb_students.StudentClass', 'ASC')
                          ->orderBy('tb_students.StudentNumber', 'ASC')
                          ->get()->getResult();

        return $this->response->setJSON(['data' => $results]);
    }
}
