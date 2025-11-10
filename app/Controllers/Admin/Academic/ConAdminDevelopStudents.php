<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminDevelopStudents extends BaseController
{
    protected $DBpersonnel; // Declare DBpersonnel property
    protected $datethai; // Declare datethai property

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        $this->datethai = new \App\Libraries\Datethai(); // Initialize Datethai library

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    protected function AllData()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CheckYear'] = $this->db->table('tb_send_plan_setup')->get()->getResult();

        $data['CheckOnoffClub'] = $this->db->table('tb_club_onoff')->select('c_onoff_id, c_onoff_year, c_onoff_term, c_onoff_regisstart, c_onoff_regisend')->where('c_onoff_id', 1)->get()->getRow();

        // Parse c_onoff_year into year and term for safer access in views
        $data['CheckOnoffClubParsed'] = ['','']; // Default values
        if (isset($data['CheckOnoffClub']->c_onoff_year) && isset($data['CheckOnoffClub']->c_onoff_term)) {
            $data['CheckOnoffClubParsed'] = [$data['CheckOnoffClub']->c_onoff_year, $data['CheckOnoffClub']->c_onoff_term];
        }

        // Format registration dates using the Datethai library
        $data['formatted_regisstart'] = isset($data['CheckOnoffClub']->c_onoff_regisstart) ? $this->datethai->thai_date_and_time(strtotime($data['CheckOnoffClub']->c_onoff_regisstart)) : '';
        $data['formatted_regisend'] = isset($data['CheckOnoffClub']->c_onoff_regisend) ? $this->datethai->thai_date_and_time(strtotime($data['CheckOnoffClub']->c_onoff_regisend)) : '';


        $data['StatusOnoffClub'] = (!empty($data['CheckOnoffClub']) && @$data['CheckOnoffClub']->c_onoff_regisend <= date("Y-m-d H:i:s")) ? "ปิด" : "เปิด";
        return $data;
    }

    public function ClubsMain()
    {
        $data = $this->AllData();
        $data['title'] = "หน้าแรกชุมนุม";

        $activeYear = $data['CheckOnoffClubParsed'][0];
        $activeTerm = $data['CheckOnoffClubParsed'][1];

        // ชื่อตารางชุมนุม
        $data['TotalClubs'] = $this->db->table('tb_clubs')
                                    ->where('club_year', $activeYear)
                                    ->where('club_trem', $activeTerm)
                                    ->get()->getResult();
        // จำนวนนักเรียนลงทะเบียน
        $data['TotalStudent'] = $this->db->table('tb_club_members')
                                        ->select('COUNT(tb_club_members.member_student_id) AS StudentAll')
                                        ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id')
                                        ->where('club_year', $activeYear)->where('club_trem', $activeTerm)
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
                                    ->join('tb_club_members', 'tb_club_members.member_club_id = tb_clubs.club_id', 'left')
                                    ->groupBy('tb_clubs.club_id')
                                    ->orderBy('total_members', 'DESC')
                                    ->limit(1)->get()->getRow();

        
        echo view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsMain', $data);
        
    }

    public function ClubGetDateRegister()
    {
        date_default_timezone_set('Asia/Bangkok');
        $Dete = $this->db->table('tb_club_onoff')
                        ->select('c_onoff_regisstart,c_onoff_regisend')
                        ->where('c_onoff_id', 1)->get()->getRow();

        return $this->response->setJSON(['datetime' => $Dete]);
    }

    public function ClubsAll()
    {
        $data = $this->AllData();
        $data['title'] = "ชุมนุมทัังหมด";

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
                            (SELECT COUNT(*) FROM skjacth_academic.tb_club_members WHERE skjacth_academic.tb_club_members.member_club_id = skjacth_academic.tb_clubs.club_id) as member_count,
                            GROUP_CONCAT(CONCAT(skjacth_personnel.tb_personnel.pers_prefix,skjacth_personnel.tb_personnel.pers_firstname," ",skjacth_personnel.tb_personnel.pers_lastname) SEPARATOR ", ") as advisor_names') // Explicitly reference DBpersonnel table
                        ->join($this->DBpersonnel->database . '.tb_personnel', 'FIND_IN_SET(' . $this->DBpersonnel->database . '.tb_personnel.pers_id , REPLACE(club_faculty_advisor, "|", ",")) > 0', 'LEFT') // Use the class property for DBpersonnel
                        ->where('club_year', $ExYear[1])
                        ->where('club_trem', $ExYear[0])
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

        $data = [
            'club_name'             => $this->request->getPost('club_name'),
            'club_description'      => $this->request->getPost('club_description'),
            'club_faculty_advisor'  => implode('|', $advisors),
            'club_year'             => $this->request->getPost('club_year'),
            'club_trem'             => $this->request->getPost('club_trem'),
            'club_max_participants' => $this->request->getPost('club_max_participants'),
            'club_status'           => 'open',
            'club_established_date' => date('Y-m-d'),
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
                        ->orderBy('club_trem', 'ASC') // เรียงเทอม
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

        // เช็ดข้อมูลซ้ำ
        $result = $this->db->table('tb_club_members')
                            ->select('
                                CONCAT(StudentCode," ",StudentPrefix,StudentFirstName," ",StudentLastName," ",tb_students.StudentClass) AS Fullname,
                                tb_students.StudentID,
                                tb_students.StudentNumber,
                                tb_club_members.member_club_id,
                                tb_club_members.member_student_id')
                            ->join('tb_students', 'tb_students.StudentID = tb_club_members.member_student_id')
                            ->where('member_club_id', $club_id)
                            ->whereIn('member_student_id', $student_ids)
                            ->get()->getResultArray();
        $duplicate_students = array_column($result, 'Fullname');

        if (! empty($duplicate_students)) {
            return $this->response->setJSON([
                'status'             => 'duplicate',
                'duplicate_students' => $duplicate_students,
            ]);
        }

        $data = [];
        foreach ($student_ids as $student_id) {
            $data[] = [
                'member_club_id'    => $club_id,
                'member_student_id' => $student_id,
                'member_join_date'  => date('Y-m-d'),
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
                            CONCAT(StudentPrefix,StudentFirstName," ",StudentLastName) AS Fullname,
                            tb_students.StudentCode,
                            tb_students.StudentID,
                            tb_students.StudentClass,
                            tb_students.StudentNumber,
                            tb_club_members.member_club_id')
                        ->join('tb_students', 'tb_students.StudentID = tb_club_members.member_student_id')
                        ->where('member_club_id', $club_id)
                        ->orderBy('StudentClass,StudentNumber', 'ASC')
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
                        ->select('DISTINCT StudentClass')
                        ->where('StudentStatus', '1/ปกติ')
                        ->orderBy('StudentClass', 'ASC')
                        ->get();
        $classrooms = $query->getResultArray();

        return $this->response->setJSON(['classrooms' => $classrooms]);
    }

    public function ClubGetStudentRegisterClub()
    {
        $classFilter = $this->request->getGet('classFilter');
        $this->db->table('tb_students')
                ->select('
                    IFNULL(tb_clubs.club_name, "ยังไม่ได้เลือกชุมนุม") AS club_status,
                    tb_clubs.club_id,
                    tb_clubs.club_name,
                    tb_students.StudentClass,
                    tb_students.StudentCode,
                    tb_students.StudentNumber,
                    CONCAT(StudentPrefix,StudentFirstName," ",StudentLastName) AS Fullname
                ')
                ->join('tb_club_members', 'tb_club_members.member_student_id = tb_students.StudentID', 'left')
                ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id', 'left')
                ->where('tb_students.StudentStatus', '1/ปกติ');
        if (! empty($classFilter)) {
            $this->db->where('tb_students.StudentClass', $classFilter);
        }
        $query = $this->db->get();
        return $this->response->setJSON(['data' => $query->getResultArray()]);
    }

    // ตั้งค่าปีการศึกษา
    public function ClubSetOnoffYear()
    {
        $rules = [
            'c_onoff_year' => 'required|numeric|exact_length[4]',
            'c_onoff_term' => 'required|numeric|in_list[1,2]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => $this->validator->getErrors()]);
        }

        $c_onoff_term = $this->request->getPost('c_onoff_term');
        $c_onoff_year = $this->request->getPost('c_onoff_year');

        $result = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->update(['c_onoff_year' => $c_onoff_year, 'c_onoff_term' => $c_onoff_term]);

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

        $result = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->update(['c_onoff_regisstart' => $start1, 'c_onoff_regisend' => $end1]);
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
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            log_message('error', 'ClubGetWeeksToUpdate: tb_club_onoff is empty or c_onoff_year is not set.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }
        log_message('debug', 'ClubGetWeeksToUpdate: c_onoff_year is ' . $CheckYear->c_onoff_year);
        $academicYear = $CheckYear->c_onoff_year; // Use the year directly

        $weeks = $this->db->table('tb_club_settings_schedule')
                        ->select('tcs_schedule_id,tcs_start_date, tcs_week_number, tcs_week_status')
                        ->where('tcs_academic_year', $academicYear)
                        ->orderBy('tcs_week_number', 'ASC')
                        ->get()->getResultArray();
        
        if (! empty($weeks)) {
            log_message('debug', 'ClubGetWeeksToUpdate: Found ' . count($weeks) . ' weeks.');
            return $this->response->setJSON(['status' => 'success', 'data' => $weeks]);
        } else {
            log_message('debug', 'ClubGetWeeksToUpdate: No weeks found for academic year ' . $academicYear);
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่มีข้อมูล']);
        }
    }

    public function ClubCreateWeeks()
    {
        log_message('debug', 'ClubCreateWeeks method called.');
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            log_message('error', 'ClubCreateWeeks: tb_club_onoff is empty or c_onoff_year is not set.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }
        log_message('debug', 'ClubCreateWeeks: c_onoff_year is ' . $CheckYear->c_onoff_year);
        $academicYear = $CheckYear->c_onoff_year; // Use the year directly

        $CheckYeaDuplicater = $this->db->table('tb_club_settings_schedule')->where('tcs_academic_year', $academicYear)->get()->getRow();

        if (! $CheckYeaDuplicater) {
            log_message('debug', 'ClubCreateWeeks: No existing weeks found, creating new ones.');
            $data = [];
            for ($i = 0; $i < 20; $i++) {
                $data[] = [
                    'tcs_academic_year' => $academicYear,
                    'tcs_week_number'   => $i + 1,
                    'tcs_week_status'   => 'เปิด',
                ];
            }

            // บันทึกข้อมูล
            $this->db->table('tb_club_settings_schedule')->insertBatch($data);
            log_message('debug', 'ClubCreateWeeks: Successfully inserted 20 weeks.');

            return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มข้อมูลสัปดาห์สำเร็จ']);
        } else {
            log_message('debug', 'ClubCreateWeeks: Weeks already exist for academic year ' . $academicYear);
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

        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }

        $id = $this->request->getPost('id'); // รับค่า ID
        $date = $this->request->getPost('date'); // รับค่าวันที่ใหม่ในรูปแบบ Y-m-d

        $result = $this->db->table('tb_club_settings_schedule')
                            ->where('tcs_academic_year', $CheckYear->c_onoff_year)
                            ->where('tcs_schedule_id', $id)
                            ->update(['tcs_start_date' => $date]); // อัปเดตวันที่

            if ($result) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตได้']);
            }
    }

    public function ClubGetAcademicYears()
    {
        $years = $this->db->table('tb_club_onoff')
                        ->select('c_onoff_year')
                        ->distinct()
                        ->get()->getResultArray();

        $academicYears = [];
        $latestYear = date('Y'); // Default to current year if no years in DB

        foreach ($years as $yearData) {
            if (isset($yearData['c_onoff_year'])) {
                $year = (int)$yearData['c_onoff_year'];
                if (!in_array($year, $academicYears)) {
                    $academicYears[] = $year;
                }
                if ($year > $latestYear) {
                    $latestYear = $year;
                }
            }
        }

        // Add the next year to the list
        $nextYear = $latestYear + 1;
        if (!in_array($nextYear, $academicYears)) {
            $academicYears[] = $nextYear;
        }
        
        sort($academicYears); // Sort years in ascending order
        return $this->response->setJSON($academicYears);
    }
}
