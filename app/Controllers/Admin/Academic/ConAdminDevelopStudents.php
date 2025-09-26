<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminDevelopStudents extends BaseController
{
    protected $DBpersonnel; // Declare DBpersonnel property

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LoginAdmin'));
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

        $data['CheckOnoffClub'] = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();

        $data['StatusOnoffClub'] = (!empty($data['CheckOnoffClub']) && @$data['CheckOnoffClub']->c_onoff_regisend <= date("Y-m-d H:i:s")) ? "ปิด" : "เปิด";
        return $data;
    }

    public function ClubsMain()
    {
        $data = $this->AllData();
        $data['title'] = "หน้าแรกชุมนุม";

        // ชื่อตารางชุมนุม
        $data['TotalClubs'] = $this->db->table('tb_clubs')
                                    ->where('club_year', '2567')
                                    ->where('club_trem', '1')
                                    ->get()->getResult();
        // จำนวนนักเรียนลงทะเบียน
        $data['TotalStudent'] = $this->db->table('tb_club_members')
                                        ->select('COUNT(tb_club_members.member_student_id) AS StudentAll')
                                        ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id')
                                        ->where('club_year', '2567')->where('club_trem', '1')
                                        ->get()->getResult();
        // นับจำนวนครู
        $data['TotalTeacher'] = $this->db->table('tb_clubs')
                                        ->select("SUM(LENGTH(club_faculty_advisor) - LENGTH(REPLACE(club_faculty_advisor, '|', '')) + 1) AS total_advisors")
                                        ->where('club_year', '2567')
                                        ->where('club_trem', '1')
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

        echo view('admin/layout/main', $data);
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

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubsAll', $data);
        
    }

    public function ClubsShow()
    {
        $year = urldecode($this->request->getGet('year')); // รับค่าปีการศึกษาจาก AJAX
        $ExYear = explode("/", $year);
        $clubs = $this->db->table('skjacth_academic.tb_clubs')
                        ->select('skjacth_academic.tb_clubs.*,
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
        $advisors = json_decode($this->request->getPost('advisors'));

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
            return $this->response->setJSON(1);
        } else {
            return $this->response->setJSON(0);
        }
    }

    public function ClubsEdit($id)
    {
        $data = $this->db->table('tb_clubs')->where(['club_id' => $id])->get()->getRowArray();
        return $this->response->setJSON($data);
    }

    public function ClubsUpdate()
    {
        $advisors = json_decode($this->request->getPost('advisors'));
        $data = [
            'club_name'             => $this->request->getPost('club_name'),
            'club_description'      => $this->request->getPost('club_description'),
            'club_faculty_advisor'  => implode('|', $advisors),
            'club_year'             => $this->request->getPost('club_year'),
            'club_trem'             => $this->request->getPost('club_trem'),
            'club_max_participants' => $this->request->getPost('club_max_participants'),
        ];
        $id = $this->request->getPost('club_id');
        $Update = $this->db->table('tb_clubs')->where('club_id', $id)->update($data);

        return $this->response->setJSON($Update);
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

    public function ClubsAddStudentToClub()
    {
        $student_ids = $this->request->getPost('student_ids');
        $club_id = $this->request->getPost('club_id');

        if (empty($student_ids)) {
            return $this->response->setJSON(['status' => false, 'message' => 'กรุณาเลือกนักเรียน']);
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
            $all_students = $this->db->table('tb_club_members')
                                    ->where('member_club_id', $club_id)
                                    ->get()->getResultArray();

            return $this->response->setJSON([
                'status'       => 'success',
                'message'      => 'บันทึกสำเร็จ',
                'all_students' => $all_students,
            ]);
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'เกิดข้อผิดพลาด']);
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
        $c_onoff_term = $this->request->getPost('c_onoff_term');
        $c_onoff_year = $this->request->getPost('c_onoff_year');

        $all = $c_onoff_year . '/' . $c_onoff_term;

        $result = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->update(['c_onoff_year' => $all]);

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

        $dateString1 = strtr($c_onoff_regisstart, $thaiMonthFull);
        $start = \DateTime::createFromFormat('d F Y H:i', $dateString1);
        $dateString2 = strtr($c_onoff_regisend, $thaiMonthFull);
        $end = \DateTime::createFromFormat('d F Y H:i', $dateString2);
        
        if ($start === false || $end === false) {
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
    // -------------- สร้างเวลาเรียน 20 สัปดาห์ ------------------------
    public function ClubCreateWeeks()
    {
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }

        $CheckYeaDuplicater = $this->db->table('tb_club_settings_schedule')->where('tcs_academic_year', $CheckYear->c_onoff_year)->get()->getRow();

        if (! $CheckYeaDuplicater) {
            $data = [];
            for ($i = 0; $i < 20; $i++) {
                $data[] = [
                    'tcs_academic_year' => $CheckYear->c_onoff_year,
                    'tcs_week_number'   => $i + 1,
                    'tcs_week_status'   => 'เปิด',
                ];
            }

            // บันทึกข้อมูล
            $this->db->table('tb_club_settings_schedule')->insertBatch($data);

            return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มข้อมูลสัปดาห์สำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'success', 'message' => 'เคยเพิ่มข้อมูลแล้ว']);
        }
    }

    public function ClubGetWeeksToUpdate()
    {
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }

        $weeks = $this->db->table('tb_club_settings_schedule')
                        ->select('tcs_schedule_id,tcs_start_date, tcs_week_number, tcs_week_status')
                        ->where('tcs_academic_year', $CheckYear->c_onoff_year)
                        ->orderBy('tcs_week_number', 'ASC')
                        ->get()->getResultArray();
        if (! empty($weeks)) {
            return $this->response->setJSON(['status' => 'success', 'data' => $weeks]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่มีข้อมูล']);
        }
    }

    public function ClubUpdateSchedule()
    {
        $CheckYear = $this->db->table('tb_club_onoff')->where('c_onoff_id', 1)->get()->getRow();
        
        if (empty($CheckYear) || empty($CheckYear->c_onoff_year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบปีการศึกษาสำหรับชุมนุม']);
        }

        $id = $this->request->getPost('id'); // รับค่า ID
        $date = $this->request->getPost('date'); // รับค่าวันที่ใหม่ในรูปแบบ Y-m-d

        if (! empty($id) && ! empty($date)) {
            $result = $this->db->table('tb_club_settings_schedule')
                            ->where('tcs_academic_year', $CheckYear->c_onoff_year)
                            ->where('tcs_schedule_id', $id)
                            ->update(['tcs_start_date' => $date]); // อัปเดตวันที่

            if ($result) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอัปเดตได้']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
        }
    }

    public function ClubUpdateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // ตรวจสอบค่าที่ส่งมาว่าถูกต้อง
        if (empty($id) || empty($status)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง']);
        }

        // ทำการอัพเดตข้อมูลในฐานข้อมูล
        $data = [
            'tcs_week_status' => $status,
        ];

        $update_result = $this->db->table('tb_club_settings_schedule')
                                ->where('tcs_schedule_id', $id)
                                ->update($data);

        if ($update_result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'สถานะถูกอัพเดตแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'การอัพเดตล้มเหลว']);
        }
    }
}
