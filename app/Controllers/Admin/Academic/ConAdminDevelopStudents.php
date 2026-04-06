<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModAdminClubs;

class ConAdminDevelopStudents extends BaseController
{
    protected $DBpersonnel; // Declare DBpersonnel property
    protected $datethai; // Declare datethai property
    protected $ModAdminClubs;

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        $this->datethai = new \App\Libraries\Datethai(); // Initialize Datethai library
        $this->ModAdminClubs = new ModAdminClubs(); // Instantiate the new model

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function updateClubOnoffStatus()
    {
        if ($this->request->isAJAX()) {
            $target = $this->request->getPost('target');
            $status = $this->request->getPost('status');
            // $year = $this->request->getPost('year'); // No longer directly from POST
            // $term = $this->request->getPost('term'); // No longer directly from POST

            // Fetch active config for club year/term
            $activeConfig = $this->db->table('tb_club_onoff')
                                        ->select('c_onoff_year, c_onoff_term')
                                        ->where('c_onoff_for', 'active_config')
                                        ->get()->getRow();

            if (empty($activeConfig) || empty($activeConfig->c_onoff_year) || empty($activeConfig->c_onoff_term)) {
                return $this->response->setJSON(['success' => false, 'message' => 'ไม่พบปีการศึกษาหรือภาคเรียนที่ใช้งานอยู่']);
            }

            $raw_year = $activeConfig->c_onoff_year;
            $term = $activeConfig->c_onoff_term;

            // Extract only the year part
            if (strpos($raw_year, '/') !== false) {
                $parts = explode('/', $raw_year);
                $year = end($parts);
            } else {
                $year = $raw_year;
            }

            // Add validation for term (still relevant for the fetched term)
            if (empty($term) || !in_array($term, ['1', '2'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'ภาคเรียนไม่ถูกต้อง']);
            }
            if (in_array($target, ['student', 'teacher', 'system']) && in_array($status, [0, 1]) && !empty($year) && !empty($term)) {
                $result = $this->ModAdminClubs->update_onoff_status($year, $term, $target, $status); // Pass term to model

                if ($result) {
                    $targetThai = '';
                    if ($target === 'student') $targetThai = 'นักเรียน';
                    if ($target === 'teacher') $targetThai = 'ครู';
                    
                    if ($target === 'system') {
                        $message = $status == 1 ? 'ระบบถูกปิดปรับปรุงเรียบร้อยแล้ว' : 'ระบบเปิดใช้งานออนไลน์เรียบร้อยแล้ว';
                    } else {
                        $statusText = $status == 1 ? 'เปิด' : 'ปิด';
                        $message = "อัปเดตสถานะสำหรับ {$targetThai} เป็น '{$statusText}' เรียบร้อยแล้ว";
                    }

                    return $this->response->setJSON(['success' => true, 'message' => $message]);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'ข้อมูลที่ส่งมาไม่ถูกต้อง']);
        }
        return redirect()->to(base_url()); // Redirect if not AJAX
    }

    public function updateClubOnoffDates()
    {
        if ($this->request->isAJAX()) {
            $target = $this->request->getPost('target');
            $startDate = $this->request->getPost('startDate');
            $endDate = $this->request->getPost('endDate');
            
            // Get active year and term from DB
            $activeConfig = $this->db->table('tb_club_onoff')->where('c_onoff_for', 'active_config')->get()->getRow();
            if (empty($activeConfig) || empty($activeConfig->c_onoff_year) || empty($activeConfig->c_onoff_term)) {
                return $this->response->setJSON(['success' => false, 'message' => 'ไม่พบการตั้งค่าปีการศึกษา']);
            }
            $year = $activeConfig->c_onoff_year;
            $term = $activeConfig->c_onoff_term;

            // Basic validation
            if (!in_array($target, ['student', 'teacher', 'system'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'เป้าหมายไม่ถูกต้อง']);
            }

            $result = $this->ModAdminClubs->update_onoff_dates($year, $term, $target, $startDate, $endDate);

            if ($result) {
                return $this->response->setJSON(['success' => true, 'message' => 'อัปเดตวันที่สำเร็จ']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'อัปเดตวันที่ไม่สำเร็จ']);
            }
        }
        return redirect()->to(base_url());
    }

    protected function AllData()
    {
        // $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow(); // Removed dependency
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CheckYear'] = $this->db->table('tb_send_plan_setup')->get()->getResult();

        // Fetch active config for club year/term
        $activeConfig = $this->db->table('tb_club_onoff')
                                            ->select('c_onoff_year, c_onoff_term')
                                            ->where('c_onoff_for', 'active_config')
                                            ->get()->getRow();

        // Parse c_onoff_year into year and term for safer access
        $activeYear = date('Y') + 543; // Default value
        $activeTerm = '1'; // Default value
        if ($activeConfig) {
            $raw_year = $activeConfig->c_onoff_year ?? '';
            $term = $activeConfig->c_onoff_term ?? '';
            if (strpos($raw_year, '/') !== false) {
                $parts = explode('/', $raw_year);
                $activeYear = end($parts);
            } else {
                $activeYear = $raw_year;
            }
            $activeTerm = $term;
        }
        $data['CheckOnoffClubParsed'] = [$activeYear, $activeTerm];

        // Fetch student, teacher, and system registration periods
        $onoffData = $this->db->table('tb_club_onoff')
                              ->where('c_onoff_year', $activeYear)
                              ->where('c_onoff_term', $activeTerm)
                              ->whereIn('c_onoff_for', ['student', 'teacher', 'system'])
                              ->get()->getResult();

        $student_dates = array_filter($onoffData, fn($row) => $row->c_onoff_for === 'student');
        $teacher_dates = array_filter($onoffData, fn($row) => $row->c_onoff_for === 'teacher');
        $system_status = array_filter($onoffData, fn($row) => $row->c_onoff_for === 'system');

        $student_dates = reset($student_dates);
        $teacher_dates = reset($teacher_dates);
        $system_status = reset($system_status);

        $isSystemClosed = (isset($system_status->c_onoff_status) && $system_status->c_onoff_status == 1);

        // Format dates for display
        $data['formatted_student_regisstart'] = isset($student_dates->c_onoff_regisstart) ? $this->datethai->thai_date_and_time(strtotime($student_dates->c_onoff_regisstart)) : '-';
        $data['formatted_student_regisend'] = isset($student_dates->c_onoff_regisend) ? $this->datethai->thai_date_and_time(strtotime($student_dates->c_onoff_regisend)) : '-';
        $data['formatted_teacher_regisstart'] = isset($teacher_dates->c_onoff_regisstart) ? $this->datethai->thai_date_and_time(strtotime($teacher_dates->c_onoff_regisstart)) : '-';
        $data['formatted_teacher_regisend'] = isset($teacher_dates->c_onoff_regisend) ? $this->datethai->thai_date_and_time(strtotime($teacher_dates->c_onoff_regisend)) : '-';

        // Student Status Logic
        if ($isSystemClosed) {
            $data['StatusOnoffClubStudent'] = "ปิด";
        } else {
            $data['StatusOnoffClubStudent'] = (isset($student_dates->c_onoff_status) && $student_dates->c_onoff_status == 1 && (!isset($student_dates->c_onoff_regisend) || $student_dates->c_onoff_regisend > date("Y-m-d H:i:s"))) ? "เปิด" : "ปิด";
        }

        // Teacher Status Logic: More flexible, priorities manual status if set to 1
        if ($isSystemClosed) {
            $data['StatusOnoffClubTeacher'] = "ปิด";
        } else {
            // For teachers, we focus on the manual status first. If it's 1, it's open unless the system is closed.
            // Dates are informative but status toggle is the primary control for teachers.
            $data['StatusOnoffClubTeacher'] = (isset($teacher_dates->c_onoff_status) && $teacher_dates->c_onoff_status == 1) ? "เปิด" : "ปิด";
        }

        return $data;
    }

    public function ClubsMain()
    {
        $data = $this->AllData();
        $data['title'] = "หน้าแรกชุมนุม";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        $activeYear = $data['CheckOnoffClubParsed'][0];
        $activeTerm = $data['CheckOnoffClubParsed'][1];

        // --- Data for Settings Modal ---
        $current_year = $activeYear; // Use activeYear from AllData()
        $current_term = $activeTerm; // Use activeTerm from AllData()
        $data['current_year'] = $current_year;
        $data['current_term'] = $current_term; // Pass current term to view
        $data['onoff_status'] = $this->ModAdminClubs->get_onoff_status($current_year, $current_term); // Pass term to model
        // --- End Data for Settings Modal ---

        // ชื่อตารางชุมนุม
        $data['TotalClubs'] = $this->db->table('tb_clubs')
                                    ->where('club_year', $activeYear)
                                    ->where('club_trem', $activeTerm)
                                    ->get()->getResult();
        // จำนวนนักเรียนลงทะเบียน
        $data['TotalStudent'] = $this->db->table('tb_club_members')
                                        ->select('COUNT(tb_club_members.member_student_id) AS StudentAll')
                                        ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id')
                                        ->join('tb_students', 'tb_club_members.member_student_id = tb_students.StudentID') // New JOIN
                                        ->where('tb_clubs.club_year', $activeYear)
                                        ->where('tb_clubs.club_trem', $activeTerm)
                                        ->where('tb_club_members.member_status', 'active') // New WHERE
                                        ->where('tb_students.StudentStatus', '1/ปกติ') // New WHERE
                                        ->get()->getResult();
        // นับจำนวนครู
        $data['TotalTeacher'] = $this->db->table('tb_clubs')
                                        ->select("SUM(LENGTH(club_faculty_advisor) - LENGTH(REPLACE(club_faculty_advisor, '|', '')) + 1) AS total_advisors")
                                        ->where('club_year', $activeYear)
                                        ->where('club_trem', $activeTerm)
                                        ->get()->getResult();
        // ชุมนุมยอดนิยม
        $data['ClubPopula'] = $this->db->table('tb_clubs')
                                    ->select('
                                        tb_clubs.club_id,
                                        tb_clubs.club_name,
                                        COUNT(tb_club_members.member_student_id) AS total_members
                                    ')
                                    ->join('tb_club_members', 'tb_club_members.member_club_id = tb_clubs.club_id AND tb_club_members.member_status = "active"', 'left')
                                    ->where('tb_clubs.club_year', $activeYear)
                                    ->where('tb_clubs.club_trem', $activeTerm)
                                    ->groupBy('tb_clubs.club_id')
                                    ->orderBy('total_members', 'DESC')
                                    ->limit(1)->get()->getRow();

        
        echo view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsMain', $data);
        
    }

    public function ClubGetDateRegister()
    {
        date_default_timezone_set('Asia/Bangkok');
        
        // Get active year and term from active_config
        $activeConfig = $this->db->table('tb_club_onoff')
                                  ->select('c_onoff_year, c_onoff_term')
                                  ->where('c_onoff_for', 'active_config')
                                  ->get()->getRow();
        
        if (empty($activeConfig)) {
            return $this->response->setJSON(['datetime' => null]);
        }
        
        $activeYear = $activeConfig->c_onoff_year;
        $activeTerm = $activeConfig->c_onoff_term;
        
        // Get student registration dates for active year/term
        $Dete = $this->db->table('tb_club_onoff')
                        ->select('c_onoff_regisstart, c_onoff_regisend')
                        ->where('c_onoff_for', 'student')
                        ->where('c_onoff_year', $activeYear)
                        ->where('c_onoff_term', $activeTerm)
                        ->get()->getRow();

        return $this->response->setJSON(['datetime' => $Dete]);
    }

    public function ClubsAll()
    {
        $data = $this->AllData();
        $data['title'] = "ชุมนุมทัังหมด";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        $data['Teacher'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                    ->where('pers_status', 'กำลังใช้งาน')
                                    ->groupStart()
                                        ->where('pers_position', 'posi_003')
                                        ->orWhere('pers_position', 'posi_004')
                                        ->orWhere('pers_position', 'posi_005')
                                        ->orWhere('pers_position', 'posi_006')
                                    ->groupEnd()
                                    ->where('pers_status', 'กำลังใช้งาน')
                                    ->get()->getResult();

        $data['YearAll'] = $this->ClubsViweYearAll();

        
        echo view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsAll', $data);
        
    }

    public function ClubsShow()
    {
        $year = urldecode($this->request->getGet('year')); // รับค่าปีการศึกษาจาก AJAX
        $ExYear = explode("/", $year);
        $clubs = $this->db->table('skjacth_academic.tb_clubs')
                        ->select('skjacth_academic.tb_clubs.*,
                            (SELECT COUNT(*) FROM skjacth_academic.tb_club_members WHERE skjacth_academic.tb_club_members.member_club_id = skjacth_academic.tb_clubs.club_id AND skjacth_academic.tb_club_members.member_status = "active") as member_count,
                            GROUP_CONCAT(CONCAT(skjacth_personnel.tb_personnel.pers_prefix,skjacth_personnel.tb_personnel.pers_firstname," ",skjacth_personnel.tb_personnel.pers_lastname) SEPARATOR ", ") as advisor_names') // Explicitly reference DBpersonnel table
                        ->join($this->DBpersonnel->database . '.tb_personnel', 'FIND_IN_SET(' . $this->DBpersonnel->database . '.tb_personnel.pers_id , REPLACE(club_faculty_advisor, "|", ",")) > 0', 'LEFT') // Use the class property for DBpersonnel
                        ->where('club_year', @$ExYear[1])
                        ->where('club_trem', @$ExYear[0])
                        ->groupBy('club_id')
                        ->get()->getResult();

        return $this->response->setJSON(["filters" => [
            "year" => $year
        ],
            'data' => $clubs]); // ส่งข้อมูลกลับในรูปแบบ JSON
    }

    public function ClubsInsert()
    {
        $rules = [
            'club_name' => 'required|min_length[3]|max_length[255]',
            'club_year' => 'required|numeric|exact_length[4]',
            'club_trem' => 'required|numeric|in_list[1,2]',
            'club_max_participants' => 'required|numeric|greater_than[0]',
            'advisors' => 'required', // Will be checked after json_decode
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $advisors = json_decode($this->request->getPost('advisors'));
        if (empty($advisors)) {
            return $this->response->setJSON(['status' => 'error', 'message' => ['advisors' => 'กรุณาเลือกครูที่ปรึกษาอย่างน้อยหนึ่งคน']]);
        }

        $d_est = new \DateTime();
        $date_est = $d_est->format('d/m/') . ((int)$d_est->format('Y') + 543);
        
        $data = [
            'club_name'             => $this->request->getPost('club_name'),
            'club_description'      => $this->request->getPost('club_description'),
            'club_faculty_advisor'  => implode('|', $advisors),
            'club_year'             => $this->request->getPost('club_year'),
            'club_trem'             => $this->request->getPost('club_trem'),
            'club_max_participants' => $this->request->getPost('club_max_participants'),
            'club_status'           => 'open',
            'club_established_date' => $date_est,
        ];

        if ($this->db->table('tb_clubs')->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    public function ClubsEdit($id)
    {
        $data = $this->db->table('tb_clubs')->where(['club_id' => $id])->get()->getRowArray();

        if (!empty($data['club_faculty_advisor'])) {
            $advisorIds = explode('|', $data['club_faculty_advisor']);
            $preselectedAdvisors = $this->DBpersonnel->table('tb_personnel')
                                                    ->select('pers_id, CONCAT(pers_prefix,pers_firstname," ",pers_lastname) AS FullName')
                                                    ->whereIn('pers_id', $advisorIds)
                                                    ->get()->getResultArray();
            $data['preselected_advisor_details'] = $preselectedAdvisors;
        } else {
            $data['preselected_advisor_details'] = [];
        }

        return $this->response->setJSON($data);
    }

    public function ClubsUpdate()
    {
        log_message('debug', 'ClubsUpdate method called.');
        log_message('debug', 'Incoming POST data: ' . json_encode($this->request->getPost()));

        $rules = [
            'club_id' => 'required|numeric', // Ensure club_id is present for update
            'club_name' => 'required|min_length[3]|max_length[255]',
            'club_year' => 'required|numeric|exact_length[4]',
            'club_trem' => 'required|numeric|in_list[1,2]',
            'club_max_participants' => 'required|numeric|greater_than[0]',
            'advisors' => 'required', // Will be checked after json_decode
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'ClubsUpdate validation failed: ' . json_encode($this->validator->getErrors()));
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $advisors = json_decode($this->request->getPost('advisors'));
        log_message('debug', 'Decoded advisors: ' . json_encode($advisors));

        if (empty($advisors)) {
            log_message('error', 'ClubsUpdate: Advisors array is empty.');
            return $this->response->setJSON(['status' => 'error', 'message' => ['advisors' => 'กรุณาเลือกครูที่ปรึกษาอย่างน้อยหนึ่งคน']]);
        }

        $data = [
            'club_name'             => $this->request->getPost('club_name'),
            'club_description'      => $this->request->getPost('club_description'),
            'club_faculty_advisor'  => implode('|', $advisors),
            'club_year'             => $this->request->getPost('club_year'),
            'club_trem'             => $this->request->getPost('club_trem'),
            'club_max_participants' => $this->request->getPost('club_max_participants'),
        ];
        $id = $this->request->getPost('club_id');
        log_message('debug', 'ClubsUpdate data for update: ' . json_encode($data) . ' for club_id: ' . $id);

        $Update = $this->db->table('tb_clubs')->where('club_id', $id)->update($data);

        if ($Update) {
            log_message('debug', 'ClubsUpdate successful for club_id: ' . $id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตข้อมูลสำเร็จ']);
        } else {
            log_message('error', 'ClubsUpdate failed for club_id: ' . $id . '. Database error: ' . $this->db->error()['message']);
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล']);
        }
    }

    public function ClubsDelete($id)
    {
        $result = $this->db->table('tb_clubs')->where('club_id', $id)->delete();
        if ($result) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function ClubsViweYearAll()
    {
        return $this->db->table('tb_clubs')
                        ->select('club_year,club_trem')
                        ->groupBy('club_year, club_trem') // รวมปีและเทอมที่ไม่ซ้ำ
                        ->orderBy('club_year', 'DESC') // เรียงปีการศึกษาล่าสุดลงไป
                        ->orderBy('club_trem', 'DESC') // เรียงเทอม
                        ->get()->getResultArray();
    }

    public function ClubsStudentList()
    {
        $students = $this->db->table('tb_students')
                            ->select('StudentID, CONCAT(StudentPrefix,StudentFirstName," ",StudentLastName," ",StudentClass," เลขที่ ",StudentNumber) AS FullName,StudentClass')
                            ->where('StudentStatus', '1/ปกติ')
                            ->orderBy('StudentClass', 'ASC')
                            ->orderBy('StudentNumber', 'ASC')
                            ->get()->getResultArray();
        return $this->response->setJSON($students);
    }

    public function ClubsTeacherList()
    {
        $teachers = $this->DBpersonnel->table('tb_personnel')
                                    ->select('pers_id, CONCAT(pers_prefix,pers_firstname," ",pers_lastname) AS FullName')
                                    ->where('pers_status', 'กำลังใช้งาน')
                                    ->groupStart()
                                        ->where('pers_position', 'posi_003')
                                        ->orWhere('pers_position', 'posi_004')
                                        ->orWhere('pers_position', 'posi_005')
                                        ->orWhere('pers_position', 'posi_006')
                                    ->groupEnd()
                                    ->get()->getResultArray();
        return $this->response->setJSON($teachers);
    }

    public function ClubsAddStudentToClub()
    {
        $rules = [
            'club_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $student_ids = $this->request->getVar('student_ids');
        $club_id = $this->request->getVar('club_id');

        if (empty($student_ids) || !is_array($student_ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => ['student_ids' => 'กรุณาเลือกนักเรียนอย่างน้อยหนึ่งคน']]);
        }

        // เช็ดข้อมูลซ้ำ (เฉพาะ active members)
        $result = $this->db->table('tb_club_members')
                            ->select('
                                CONCAT(StudentCode," ",StudentPrefix,StudentFirstName," ",StudentLastName," ",tb_students.StudentClass) AS Fullname,
                                tb_students.StudentID,
                                tb_students.StudentNumber,
                                tb_club_members.member_club_id,
                                tb_club_members.member_student_id')
                            ->join('tb_students', 'tb_students.StudentID = tb_club_members.member_student_id')
                            ->where('member_club_id', $club_id)
                            ->where('tb_club_members.member_status', 'active')
                            ->whereIn('member_student_id', $student_ids)
                            ->get()->getResultArray();
        $duplicate_students = array_column($result, 'Fullname');

        if (! empty($duplicate_students)) {
            return $this->response->setJSON([
                'status'             => 'duplicate',
                'duplicate_students' => $duplicate_students,
            ]);
        }

        $d_join = new \DateTime();
        $date_join = $d_join->format('d/m/') . ((int)$d_join->format('Y') + 543);

        $data = [];
        foreach ($student_ids as $student_id) {
            $data[] = [
                'member_club_id'    => $club_id,
                'member_student_id' => $student_id,
                'member_join_date'  => $date_join,
                'member_role'       => 'Member',
            ];
        }
        // เพิ่มนักเรียนเข้าชุมนุม
        $result = $this->db->table('tb_club_members')->insertBatch($data);

        if ($result) {
            return $this->response->setJSON([
                'status'       => 'success',
                'message'      => 'บันทึกสำเร็จ',
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด']);
        }
    }

    public function ClubsTbShowStudentList()
    {
        $club_id = $this->request->getGet('club_id');

        $query = $this->db->table('tb_club_members')
                        ->select('
                            CONCAT_WS(" ", StudentPrefix, StudentFirstName, StudentLastName) AS Fullname,
                            tb_students.StudentCode,
                            tb_students.StudentID,
                            tb_students.StudentClass,
                            tb_students.StudentNumber,
                            tb_club_members.member_club_id')
                        ->join('tb_students', 'tb_students.StudentID = tb_club_members.member_student_id')
                        ->where('member_club_id', $club_id)
                        ->where('tb_club_members.member_status', 'active')
                        ->orderBy('tb_students.StudentClass', 'ASC')
                        ->orderBy('tb_students.StudentNumber', 'ASC')
                        ->get();
        return $this->response->setJSON($query->getResultArray());
    }

    public function ClubDeleteStudentToClub()
    {
        $rules = [
            'club_id' => 'required|numeric',
            'student_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $club_id = $this->request->getPost('club_id');
        $student_id = $this->request->getPost('student_id');

        // ลบข้อมูลนักเรียนออกจากชุมนุม
        $this->db->table('tb_club_members')
                ->where('member_club_id', $club_id)
                ->where('member_student_id', $student_id)
                ->delete();

        if ($this->db->affectedRows() > 0) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }
    }

    //------------------------ แดชบอร์ด --------------------------
    // ดูนักเรียนลงทะเบียน
    public function ClubGetClassroom()
    {
        $query = $this->db->table('tb_students')
                        ->select('StudentClass')
                        ->distinct()
                        ->where('StudentStatus', '1/ปกติ')
                        ->orderBy('StudentClass', 'ASC')
                        ->get();
        $classrooms = $query->getResultArray();

        return $this->response->setJSON(['classrooms' => $classrooms]);
    }

    public function ClubGetStudentRegisterClub()
    {
        $data = $this->AllData();
        $activeYear = $data['CheckOnoffClubParsed'][0];
        $activeTerm = $data['CheckOnoffClubParsed'][1];

        $builder = $this->db->table('tb_students')
                        ->select('
                            IFNULL(tb_clubs.club_name, "ยังไม่ได้เลือกชุมนุม") AS club_name,
                            tb_students.StudentClass,
                            tb_students.StudentCode,
                            tb_students.StudentNumber,
                            CONCAT_WS(" ", StudentPrefix, StudentFirstName, StudentLastName) AS Fullname
                        ')
                        ->join('tb_club_members', 'tb_club_members.member_student_id = tb_students.StudentID AND tb_club_members.member_status = "active"', 'left')
                        ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id AND tb_clubs.club_year = '.$this->db->escape($activeYear).' AND tb_clubs.club_trem = '.$this->db->escape($activeTerm), 'left');
        
        $builder->where('tb_students.StudentStatus', '1/ปกติ');
        $builder->orderBy('tb_students.StudentClass', 'ASC');
        $builder->orderBy('tb_students.StudentNumber', 'ASC');
        $query = $builder->get();
        return $this->response->setJSON(['data' => $query->getResultArray()]);
    }

    public function ClubsStudentRegistrationPage()
    {
        $data['title'] = "ข้อมูลนักเรียนที่ลงทะเบียนชุมนุม";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        return view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsStudentRegistration', $data);
    }

    // ตั้งค่าปีการศึกษา
    public function ClubSetOnoffYear()
    {
        

        $c_onoff_term = $this->request->getPost('c_onoff_term');
        $c_onoff_year = $this->request->getPost('c_onoff_year');
       
        $builder = $this->db->table('tb_club_onoff');
        $existingConfig = $builder->where('c_onoff_for', 'active_config')->get()->getRow();
      
        //print_r($existingConfig); exit();
        $dataToSave = [
            'c_onoff_year' => $c_onoff_year,
            'c_onoff_term' => $c_onoff_term
        ];
        

        if ($existingConfig) {
            $result = $builder->where('c_onoff_for', 'active_config')->update($dataToSave);
        } else {
            $dataToSave['c_onoff_for'] = 'active_config';
            $dataToSave['c_onoff_status'] = 1; // Default to active
            $result = $builder->insert($dataToSave);
        }
        
        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    // ตั้งค่าวันลงทะเบียน
    public function ClubSetDateRegister()
    {
        // แปลงชื่อเดือนจากภาษาไทยเป็นภาษาอังกฤษ
        $thaiMonthFull = [
            'มกราคม' => 'January', 'กุมภาพันธ์' => 'February', 'มีนาคม' => 'March', 'เมษายน' => 'April',
            'พฤษภาคม' => 'May', 'มิถุนายน' => 'June', 'กรกฎาคม' => 'July', 'สิงหาคม' => 'August',
            'กันยายน' => 'September', 'ตุลาคม' => 'October', 'พฤศจิกายน' => 'November', 'ธันวาคม' => 'December',
        ];

        $c_onoff_regisstart = $this->request->getPost('c_onoff_regisstart');
        $c_onoff_regisend = $this->request->getPost('c_onoff_regisend');

        log_message('debug', 'Incoming c_onoff_regisstart: ' . $c_onoff_regisstart); // Debug log
        log_message('debug', 'Incoming c_onoff_regisend: ' . $c_onoff_regisend); // Debug log

        $dateString1 = strtr($c_onoff_regisstart, $thaiMonthFull);
        log_message('debug', 'After strtr c_onoff_regisstart: ' . $dateString1); // Debug log
        $start = \DateTime::createFromFormat('d F Y H:i', $dateString1);
        
        $dateString2 = strtr($c_onoff_regisend, $thaiMonthFull);
        log_message('debug', 'After strtr c_onoff_regisend: ' . $dateString2); // Debug log
        $end = \DateTime::createFromFormat('d F Y H:i', $dateString2);
        
        if ($start === false || $end === false) {
            log_message('error', 'DateTime::createFromFormat failed for start: ' . ($start === false ? 'true' : 'false') . ' and end: ' . ($end === false ? 'true' : 'false')); // Debug log
            return $this->response->setJSON(['status' => 'error', 'message' => 'รูปแบบวันที่ไม่ถูกต้อง']);
        }

        $start1 = $start->format('Y-m-d H:i:s');
        $end1 = $end->format('Y-m-d H:i:s');

        // Get active year and term from active_config
        $activeConfig = $this->db->table('tb_club_onoff')
                                  ->select('c_onoff_year, c_onoff_term')
                                  ->where('c_onoff_for', 'active_config')
                                  ->get()->getRow();
        
        if (empty($activeConfig)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบการตั้งค่าปีการศึกษา']);
        }
        
        $activeYear = $activeConfig->c_onoff_year;
        $activeTerm = $activeConfig->c_onoff_term;

        // Update student registration dates for active year/term
        $result = $this->db->table('tb_club_onoff')
                           ->where('c_onoff_for', 'student')
                           ->where('c_onoff_year', $activeYear)
                           ->where('c_onoff_term', $activeTerm)
                           ->update(['c_onoff_regisstart' => $start1, 'c_onoff_regisend' => $end1]);
        
        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    //-----------------------------  ข้อมูลพื้นฐานระบบ ------------------------------
    public function ClubGetWeeksToUpdate()
    {
        log_message('debug', 'ClubGetWeeksToUpdate method called.');
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_for', 'active_config')->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year) || empty($CheckYear->c_onoff_term)) {
            log_message('error', 'ClubGetWeeksToUpdate: tb_club_onoff is empty or year/term is not set.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาหรือภาคเรียนสำหรับชุมนุม']);
        }
        $raw_year = $CheckYear->c_onoff_year;
        // Extract only the year part
        if (strpos($raw_year, '/') !== false) {
            $parts = explode('/', $raw_year);
            $academicYear = end($parts);
        } else {
            $academicYear = $raw_year;
        }
        log_message('debug', 'ClubGetWeeksToUpdate: c_onoff_year is ' . $academicYear . ' and c_onoff_term is ' . $CheckYear->c_onoff_term);
        $academicTerm = $CheckYear->c_onoff_term;

        $weeks = $this->db->table('tb_club_settings_schedule')
                        ->select('tcs_schedule_id, tcs_start_date, tcs_week_number, tcs_week_status, tcs_academic_trem')
                        ->where('tcs_academic_year', $academicYear)
                        ->where('tcs_academic_trem', $academicTerm)
                        ->orderBy('tcs_week_number', 'ASC')
                        ->get()->getResultArray();
        
        if (! empty($weeks)) {
            log_message('debug', 'ClubGetWeeksToUpdate: Found ' . count($weeks) . ' weeks.');
            
            // Map weeks and convert B.E. back to A.D. for HTML5 date inputs
            $formattedWeeks = array_map(function($week) {
                if (!empty($week['tcs_start_date']) && strpos($week['tcs_start_date'], '/') !== false) {
                    $parts = explode('/', $week['tcs_start_date']);
                    if (count($parts) === 3) {
                        // dd/mm/yyyy (B.E.) -> yyyy-mm-dd (A.D.)
                        $ad_year = (int)$parts[2] - 543;
                        $week['tcs_start_date'] = $ad_year . '-' . $parts[1] . '-' . $parts[0];
                    }
                }
                return $week;
            }, $weeks);

            return $this->response->setJSON(['status' => 'success', 'data' => $formattedWeeks]);
        } else {
            log_message('debug', 'ClubGetWeeksToUpdate: No weeks found for academic year ' . $academicYear . ' term ' . $academicTerm);
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่มีข้อมูล']);
        }
    }

    public function ClubCreateWeeks()
    {
        log_message('debug', 'ClubCreateWeeks method called.');
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_for', 'active_config')->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year) || empty($CheckYear->c_onoff_term)) {
            log_message('error', 'ClubCreateWeeks: tb_club_onoff is empty or year/term is not set.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาหรือภาคเรียนสำหรับชุมนุม']);
        }
        $raw_year = $CheckYear->c_onoff_year;
        // Extract only the year part
        if (strpos($raw_year, '/') !== false) {
            $parts = explode('/', $raw_year);
            $academicYear = end($parts);
        } else {
            $academicYear = $raw_year;
        }
        log_message('debug', 'ClubCreateWeeks: c_onoff_year is ' . $academicYear . ' and c_onoff_term is ' . $CheckYear->c_onoff_term);
        $academicTerm = $CheckYear->c_onoff_term;

        $CheckYeaDuplicater = $this->db->table('tb_club_settings_schedule')
                                        ->where('tcs_academic_year', $academicYear)
                                        ->where('tcs_academic_trem', $academicTerm)
                                        ->get()->getRow();

        if (! $CheckYeaDuplicater) {
            log_message('debug', 'ClubCreateWeeks: No existing weeks found, creating new ones.');
            $data = [];
            for ($i = 0; $i < 20; $i++) {
                $data[] = [
                    'tcs_academic_year' => $academicYear,
                    'tcs_academic_trem' => $academicTerm,
                    'tcs_week_number'   => $i + 1,
                    'tcs_week_status'   => 'เปิด',
                ];
            }

            // บันทึกข้อมูล
            $this->db->table('tb_club_settings_schedule')->insertBatch($data);
            log_message('debug', 'ClubCreateWeeks: Successfully inserted 20 weeks.');

            return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มข้อมูลสัปดาห์สำเร็จ']);
        } else {
            log_message('debug', 'ClubCreateWeeks: Weeks already exist for academic year ' . $academicYear . ' term ' . $academicTerm);
            return $this->response->setJSON(['status' => 'success', 'message' => 'เคยเพิ่มข้อมูลแล้ว']);
        }
    }

    public function ClubUpdateSchedule()
    {
        $rules = [
            'id' => 'required|numeric',
            'date' => 'required|valid_date[Y-m-d]', // Assuming date is in Y-m-d format
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_for', 'active_config')->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year) || empty($CheckYear->c_onoff_term)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาหรือภาคเรียนสำหรับชุมนุม']);
        }
        $raw_year = $CheckYear->c_onoff_year;
        // Extract only the year part
        if (strpos($raw_year, '/') !== false) {
            $parts = explode('/', $raw_year);
            $academicYear = end($parts);
        } else {
            $academicYear = $raw_year;
        }

        $id = $this->request->getPost('id'); // รับค่า ID
        $date = $this->request->getPost('date'); // รับค่าวันที่ใหม่ในรูปแบบ Y-m-d

        // Convert incoming Gregorian date (from input type="date") to B.E. (dd/mm/yyyy)
        $formatted_date = $date;
        if (!empty($date)) {
            $d = new \DateTime($date);
            $formatted_date = $d->format('d/m/') . ((int)$d->format('Y') + 543);
        }

        $result = $this->db->table('tb_club_settings_schedule')
                            ->where('tcs_academic_year', $academicYear)
                            ->where('tcs_academic_trem', $CheckYear->c_onoff_term)
                            ->where('tcs_schedule_id', $id)
                            ->update(['tcs_start_date' => $formatted_date]); // อัปเดตวันที่เป็น พ.ศ.

            if ($result) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตได้']);
            }
    }

    public function ClubGetAcademicYears()
    {
        $activeConfig = $this->db->table('tb_club_onoff')
                                ->select('c_onoff_year')
                                ->where('c_onoff_for', 'active_config')
                                ->get()->getRow();

        $academicYears = [];
        $currentYear = date('Y') + 543; // Default to current Buddhist year

        if ($activeConfig && !empty($activeConfig->c_onoff_year)) {
            $raw_year = $activeConfig->c_onoff_year;
            // Extract only the year part
            if (strpos($raw_year, '/') !== false) {
                $parts = explode('/', $raw_year);
                $activeYear = end($parts);
            } else {
                $activeYear = $raw_year;
            }
            $currentYear = (int)$activeYear;
        }
        
        // Add the current active year and the next year to the list
        $academicYears[] = $currentYear;
        $academicYears[] = $currentYear + 1;
        
        sort($academicYears); // Sort years in ascending order
        return $this->response->setJSON($academicYears);
    }

    // ===================== รายงานผลชุมนุม =====================

    /**
     * แสดงหน้ารายงานผลการประเมินชุมนุม (ผ่าน/ไม่ผ่าน)
     */
    public function ClubsReport()
    {
        $data['title'] = 'รายงานผลการประเมินชุมนุม';
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        // ดึงปีการศึกษาจาก tb_clubs
        $data['AcademicYears'] = $this->db->table('tb_clubs')
            ->select('club_year')
            ->where('club_year IS NOT NULL')
            ->groupBy('club_year')
            ->orderBy('club_year', 'DESC')
            ->get()->getResult();

        // ดึงปีปัจจุบันจาก club_onoff
        $activeConfig = $this->db->table('tb_club_onoff')
            ->select('c_onoff_year')
            ->where('c_onoff_for', 'active_config')
            ->get()->getRow();
        $data['currentYear'] = $activeConfig->c_onoff_year ?? '';

        // ดึงรายชื่อชุมนุมทั้งหมด
        $data['Clubs'] = $this->db->table('tb_clubs')
            ->select('club_id, club_name')
            ->orderBy('club_name', 'ASC')
            ->get()->getResult();

        echo view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsReport', $data);
    }

    /**
     * AJAX: ดึงข้อมูลรายงานผลชุมนุม
     */
    public function ClubReportData()
    {
        try {
            $year   = $this->request->getPost('year');
            $term   = $this->request->getPost('term');
            $clubId = $this->request->getPost('club_id');

            // 1. ดึงสมาชิกชุมนุม
            $builder = $this->db->table('tb_club_members AS m')
                ->select('
                    m.member_student_id,
                    m.member_club_id,
                    s.StudentCode AS student_code,
                    s.StudentPrefix AS student_prefix,
                    s.StudentFirstName AS student_firstname,
                    s.StudentLastName AS student_lastname,
                    s.StudentClass AS student_class,
                    c.club_name,
                    c.club_faculty_advisor
                ')
                ->join('tb_students AS s', 's.StudentID = m.member_student_id', 'left')
                ->join('tb_clubs AS c', 'c.club_id = m.member_club_id', 'left')
                ->where('c.club_year', $year)
                ->where('c.club_trem', $term)
                ->where('m.member_status', 'active');

            if ($clubId && $clubId !== 'all') {
                $builder->where('m.member_club_id', $clubId);
            }

            $builder->orderBy('c.club_name', 'ASC')
                    ->orderBy('s.StudentClass', 'ASC')
                    ->orderBy('s.StudentNumber', 'ASC');

            $members = $builder->get()->getResult();

            // 2. ดึงหน้าผลประเมินสรุป
            $evalData = [];
            $sumQuery = $this->db->table('tb_club_student_summary')
                ->select('student_id, club_id, objective_result')
                ->where('academic_year', $year)
                ->where('academic_term', $term);
            if ($clubId && $clubId !== 'all') {
                $sumQuery->where('club_id', $clubId);
            }
            $summaries = $sumQuery->get()->getResult();

            foreach ($summaries as $s) {
                $key = trim($s->student_id) . '|' . $s->club_id;
                $val = trim((string)$s->objective_result);
                if ($val !== '') {
                    $evalData[$key] = $val;
                }
            }

            // 3. ดึงความก้าวหน้า (เช็คเงื่อนไข: 0 แม้แต่ตัวเดียว คือ ไม่ผ่าน)
            $progQuery = $this->db->table('tb_club_student_progress AS p')
                ->select('p.student_id, p.club_id, p.status')
                ->join('tb_clubs AS c', 'c.club_id = p.club_id')
                ->where('c.club_year', $year)
                ->where('c.club_trem', $term);
            if ($clubId && $clubId !== 'all') {
                $progQuery->where('p.club_id', $clubId);
            }
            $progresses = $progQuery->get()->getResult();
            
            // ประมวลผลความก้าวหน้า
            $progFail = []; // เก็บคนที่ตก (มี 0)
            $progPass = []; // เก็บคนที่ผ่านทุกตัว (หรืออย่างน้อยมี 1 แต่ไม่มี 0)
            foreach ($progresses as $p) {
                $key = trim($p->student_id) . '|' . $p->club_id;
                if ($p->status == 0) {
                    $progFail[$key] = true;
                } else {
                    $progPass[$key] = true;
                }
            }
            
            // อัปเดต evalData: ถ้าตกใน progress ให้บังคับเป็น มผ ทันที (Override Summary)
            foreach ($progFail as $key => $ignore) {
                $evalData[$key] = 'มผ';
            }
            // ถ้าไม่มีใน evalData และไม่มีใน progFail แต่มีใน progPass ให้ถือว่า ผ่าน
            foreach ($progPass as $key => $ignore) {
                if (!isset($evalData[$key])) {
                    $evalData[$key] = 'ผ';
                }
            }

            // 4. ดึงข้อมูลครูที่ปรึกษา (แตก pipe แยกคน)
            $advisorMap = [];
            $allAdvisorIds = [];
            foreach ($members as $m) {
                if ($m->club_faculty_advisor) {
                    $ids = explode('|', $m->club_faculty_advisor);
                    $allAdvisorIds = array_merge($allAdvisorIds, $ids);
                }
            }
            $allAdvisorIds = array_unique(array_filter($allAdvisorIds));
            
            if (!empty($allAdvisorIds)) {
                $advisors = $this->DBpersonnel->table('tb_personnel')
                    ->select('pers_id, pers_prefix, pers_firstname, pers_lastname')
                    ->whereIn('pers_id', $allAdvisorIds)
                    ->get()->getResult();
                foreach ($advisors as $adv) {
                    $advisorMap[$adv->pers_id] = $adv->pers_prefix . $adv->pers_firstname . ' ' . $adv->pers_lastname;
                }
            }

            // 5. สรุปข้อมูลรายคน
            $data = [];
            $passCount = 0; $failCount = 0; $pendingCount = 0;

            foreach ($members as $m) {
                $cid = $m->member_club_id;
                $keyID = trim($m->member_student_id) . '|' . $cid;
                $keyCode = trim($m->student_code) . '|' . $cid;

                $res = $evalData[$keyID] ?? ($evalData[$keyCode] ?? '');
                $resultCode = '';

                if ((string)$res !== '') {
                    $resStr = trim((string)$res);
                    // ตรวจสอบผลประเมิน (แก้ไขเพื่อไม่ให้ มผ ไปติดใน ผ)
                    if ($resStr === 'มผ' || $resStr === '0' || $res === 0 || preg_match('/ไม่ผ่าน/u', $resStr)) {
                        $resultCode = 'มผ'; $failCount++;
                    } elseif ($resStr === 'ผ' || $resStr === '1' || preg_match('/ผ่าน|ดี/u', $resStr)) {
                        $resultCode = 'ผ'; $passCount++;
                    } else {
                        $pendingCount++;
                    }
                } else {
                    $pendingCount++;
                }

                // สรุปชื่อครูที่ปรึกษา
                $advNames = [];
                if ($m->club_faculty_advisor) {
                    $ids = explode('|', $m->club_faculty_advisor);
                    foreach ($ids as $id) {
                        if (isset($advisorMap[$id])) {
                            $advNames[] = $advisorMap[$id];
                        }
                    }
                }

                $data[] = [
                    'student_code'      => $m->student_code,
                    'student_prefix'    => $m->student_prefix,
                    'student_firstname' => $m->student_firstname,
                    'student_lastname'  => $m->student_lastname,
                    'student_class'     => $m->student_class,
                    'club_name'         => $m->club_name,
                    'advisor_name'      => !empty($advNames) ? implode(', ', $advNames) : '-',
                    'result'            => $resultCode
                ];
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'data'    => $data,
                'summary' => [
                    'total' => count($data), 'pass' => $passCount, 'fail' => $failCount, 'pending' => $pendingCount
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: ดึงข้อมูลรายงานบันทึกการมาเรียนชุมนุม
     * ข้อมูลจาก tb_club_recoed_activity (tcra_ma, tcra_khad, tcra_rapwy, tcra_rakic เก็บเป็น comma-separated StudentIDs)
     */
    public function ClubAttendanceReportData()
    {
        try {
            $year   = $this->request->getPost('year');
            $term   = $this->request->getPost('term');
            $clubId = $this->request->getPost('club_id');

            // ดึงสัปดาห์ทั้งหมดของปี/เทอมนี้
            $weeks = $this->db->table('tb_club_settings_schedule')
                ->select('tcs_schedule_id, tcs_week_number, tcs_start_date, tcs_week_status')
                ->where('tcs_academic_year', $year)
                ->where('tcs_academic_trem', $term)
                ->orderBy('tcs_week_number', 'ASC')
                ->get()->getResult();

            // ดึงสมาชิกชุมนุม
            $memberBuilder = $this->db->table('tb_club_members AS m')
                ->select('m.member_student_id, s.StudentPrefix, s.StudentFirstName, s.StudentLastName, s.StudentClass, s.StudentNumber, c.club_name, c.club_id')
                ->join('tb_students AS s', 'CAST(s.StudentID AS UNSIGNED) = m.member_student_id', 'left')
                ->join('tb_clubs AS c', 'c.club_id = m.member_club_id', 'left')
                ->where('c.club_year', $year)
                ->where('c.club_trem', $term)
                ->where('m.member_status', 'active');

            if ($clubId && $clubId !== 'all') {
                $memberBuilder->where('m.member_club_id', $clubId);
            }

            $memberBuilder->orderBy('c.club_name', 'ASC')
                          ->orderBy('s.StudentClass', 'ASC')
                          ->orderBy('CAST(s.StudentNumber AS UNSIGNED)', 'ASC');

            $members = $memberBuilder->get()->getResult();

            // ดึงข้อมูลการเช็คชื่อ
            $actBuilder = $this->db->table('tb_club_record_activity AS a')
                ->select('a.tcra_club_id, a.trca_schedule_id, a.tcra_ma, a.tcra_khad, a.tcra_rapwy, a.tcra_rakic')
                ->join('tb_club_settings_schedule AS ss', 'ss.tcs_schedule_id = a.trca_schedule_id', 'left')
                ->where('ss.tcs_academic_year', $year)
                ->where('ss.tcs_academic_trem', $term);

            if ($clubId && $clubId !== 'all') {
                $actBuilder->where('a.tcra_club_id', $clubId);
            }

            $activities = $actBuilder->get()->getResult();

            // สร้าง map [club_id][schedule_id] => { ma:[], khad:[], ... }
            $actMap = [];
            $checkedSchedules = [];
            foreach ($activities as $act) {
                $cid = $act->tcra_club_id;
                $sid = $act->trca_schedule_id;
                $checkedSchedules[$sid] = true;

                $actMap[$cid][$sid] = [
                    'ma'    => array_map('trim', array_filter(explode(',', $act->tcra_ma ?? ''))),
                    'khad'  => array_map('trim', array_filter(explode(',', $act->tcra_khad ?? ''))),
                    'rapwy' => array_map('trim', array_filter(explode(',', $act->tcra_rapwy ?? ''))),
                    'rakic' => array_map('trim', array_filter(explode(',', $act->tcra_rakic ?? ''))),
                ];
            }

            // สร้างข้อมูลต่อนักเรียน
            $data = [];
            $highAbsent = 0;

            foreach ($members as $m) {
                $studentName = ($m->StudentPrefix ?? '') . ($m->StudentFirstName ?? '') . ' ' . ($m->StudentLastName ?? '');
                $weekly = [];
                $sumMa = 0; $sumKhad = 0; $sumPuay = 0; $sumKij = 0;

                // cast เป็น string เพื่อเทียบกับ explode result
                $studentIdStr = (string) $m->member_student_id;

                foreach ($weeks as $w) {
                    $schedId = $w->tcs_schedule_id;
                    $weekNum = $w->tcs_week_number;
                    $clubAct = $actMap[$m->club_id][$schedId] ?? null;

                    $status = '';
                    if ($clubAct) {
                        if (in_array($studentIdStr, $clubAct['ma'])) {
                            $status = 'มา'; $sumMa++;
                        } elseif (in_array($studentIdStr, $clubAct['khad'])) {
                            $status = 'ขาด'; $sumKhad++;
                        } elseif (in_array($studentIdStr, $clubAct['rapwy'])) {
                            $status = 'ลาป่วย'; $sumPuay++;
                        } elseif (in_array($studentIdStr, $clubAct['rakic'])) {
                            $status = 'ลากิจ'; $sumKij++;
                        }
                    }
                    $weekly[$weekNum] = $status;
                }

                if ($sumKhad >= 3) { $highAbsent++; }

                $data[] = [
                    'student_name'  => trim($studentName),
                    'student_class' => $m->StudentClass ?? '-',
                    'club_name'     => $m->club_name ?? '-',
                    'weekly'        => $weekly,
                    'sum_ma'        => $sumMa,
                    'sum_khad'      => $sumKhad,
                    'sum_puay'      => $sumPuay,
                    'sum_kij'       => $sumKij,
                ];
            }

            // สร้าง weeks array สำหรับ header
            $weeksForHeader = [];
            foreach ($weeks as $w) {
                $weeksForHeader[] = [
                    'week_number' => $w->tcs_week_number,
                    'date'        => $w->tcs_start_date,
                ];
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'data'    => $data,
                'weeks'   => $weeksForHeader,
                'summary' => [
                    'total_students' => count($members),
                    'weeks_total'    => count($weeks),
                    'weeks_checked'  => count($checkedSchedules),
                    'high_absent'    => $highAbsent,
                ]
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'file'    => $e->getFile() . ':' . $e->getLine(),
                'data'    => [],
                'weeks'   => [],
                'summary' => ['total_students' => 0, 'weeks_total' => 0, 'weeks_checked' => 0, 'high_absent' => 0]
            ]);
        }
    }
}
