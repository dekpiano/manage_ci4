<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminClassRoom;
use App\Libraries\Classroom; // Assuming this library will be migrated to App\Libraries

class ConAdminClassRoom extends BaseController
{
    protected $modAdminClassRoom;
    protected $classroom;
    protected $DBpersonnel; // Declare DBpersonnel property
    protected $db; // Declare default DB property

    public function __construct()
    {
        $this->modAdminClassRoom = new ModAdminClassRoom();
        $this->classroom = new Classroom(); // Assuming Classroom library is available or will be migrated
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            redirect()->to(base_url('LogoutTeacher'))->send();
            exit;
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            redirect()->to(base_url('welcome'))->send();
            exit;
        }
    }

    public function AdminClassMain($selectedYear = null)
    {
        $data['admin'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ห้องเรียน / ที่ปรึกษา / ครูหัวหน้าระดับ";

        // Get available years for the filter dropdown
        $data['years'] = $this->db->table('tb_regclass')->select('Reg_Year')->distinct()->orderBy('Reg_Year', 'DESC')->get()->getResult();
        
        // Determine the year to display (URL param -> active selected year -> latest in table)
        $sysYear = get_selected_year_only();
        $latestYear = !empty($sysYear) ? $sysYear : (!empty($data['years']) ? $data['years'][0]->Reg_Year : date('Y') + 543);
        $data['selectedYear'] = $selectedYear ?? $latestYear;
        $data['selectedYearFull'] = get_selected_year();
        $data['selectedTerm'] = get_selected_term_only();

        // Get classroom data for the selected year
        $data['classRoom'] = $this->db->table('tb_regclass')
                                    ->select('tb_regclass.*, tb_personnel.pers_id, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_personnel.pers_img, tb_personnel.pers_position, tb_personnel.pers_learning')
                                    ->join($this->DBpersonnel->database . '.tb_personnel', 'tb_personnel.pers_id = tb_regclass.class_teacher', 'left')
                                    ->where('Reg_Year', $data['selectedYear'])
                                    ->orderBy('LENGTH(Reg_Class)', 'ASC')
                                    ->orderBy('Reg_Class', 'ASC')
                                    ->get()->getResult();

        // Build assigned teachers maps for selected year
        $assignedHeads = [];
        $assignedAdvisors = [];
        foreach ($data['classRoom'] as $cr) {
            if (!empty($cr->class_teacher)) {
                if (strlen($cr->Reg_Class) == 1) {
                    $assignedHeads[$cr->class_teacher] = $cr->Reg_Class;
                } else {
                    $assignedAdvisors[$cr->class_teacher] = $cr->Reg_Class;
                }
            }
        }
        $data['assignedHeads'] = $assignedHeads;
        $data['assignedAdvisors'] = $assignedAdvisors;

        $data['NameTeacher'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                        ->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_img,pers_position')
                                        ->where('pers_status', 'กำลังใช้งาน')
                                        ->where('pers_position !=', 'posi_001')
                                        ->where('pers_position !=', 'posi_002')
                                        ->where('pers_position <', 'posi_007')
                                        ->orderBy('pers_learning')
                                        ->get()->getResult();

        // Dashboard Statistics for the selected year
        // Total classrooms (ห้องเรียน - นับเฉพาะห้องที่ไม่ซ้ำกัน ไม่นับครูที่ปรึกษาหลายคนในห้องเดียวกัน)
        $data['total_classrooms'] = $this->db->table('tb_regclass')
            ->select('Reg_Class')
            ->where('Reg_Year', $data['selectedYear'])
            ->where('LENGTH(Reg_Class) >', 1)
            ->distinct()
            ->countAllResults();
        
        // Total level heads (ครูหัวหน้าระดับ - Reg_Class ที่มี 1 หลัก เช่น 1, 2, 3)
        $data['total_level_heads'] = $this->db->table('tb_regclass')
            ->where('Reg_Year', $data['selectedYear'])
            ->where('LENGTH(Reg_Class)', 1)
            ->countAllResults();
        
        // Total advisors (unique teachers) in selected year
        $data['total_advisors'] = $this->db->table('tb_regclass')
            ->select('class_teacher')
            ->where('Reg_Year', $data['selectedYear'])
            ->distinct()
            ->countAllResults();
        
        // Total records in selected year
        $data['total_records'] = $this->db->table('tb_regclass')
            ->where('Reg_Year', $data['selectedYear'])
            ->countAllResults();

        $data['classroom'] = $this->classroom;
        echo view('admin/Academic/AdminClassRoom/AdminClassRoomMain', $data);
        
    }
    
    public function AddClassRoom()
    {
        $year = $this->request->getPost('year');
        $classroom = $this->request->getPost('classroom');
        $teachers = $this->request->getPost('teacher');

        if (empty($year) || empty($classroom) || empty($teachers)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน',
                'csrf_hash' => csrf_hash()
            ]);
        }

        if (!is_array($teachers)) {
            $teachers = [$teachers];
        }

        $isHead = (strlen($classroom) == 1);
        $insertedCount = 0;
        $duplicates = 0;

        foreach ($teachers as $teacherId) {
            $teacherId = trim($teacherId);
            if (empty($teacherId)) continue;

            // Check if teacher already has the same role type in this year
            $builder = $this->db->table('tb_regclass')
                ->where('Reg_Year', $year)
                ->where('class_teacher', $teacherId);

            if ($isHead) {
                // If adding as Head of Level, check if already Head of Level
                $builder->where('LENGTH(Reg_Class)', 1);
            } else {
                // If adding as Classroom Advisor, check if already Classroom Advisor
                $builder->where('LENGTH(Reg_Class) >', 1);
            }

            $exists = $builder->countAllResults();

            if ($exists == 0) {
                $dataClassRoom = [
                    'Reg_Year'      => $year,
                    'Reg_Class'     => $classroom,
                    'class_teacher' => $teacherId,
                ];
                $this->modAdminClassRoom->ClassRoom_Add($dataClassRoom);
                $insertedCount++;
            } else {
                $duplicates++;
            }
        }

        if ($insertedCount > 0) {
            $roleLabel = $isHead ? "หัวหน้าระดับ" : "ครูที่ปรึกษา";
            $msg = "เพิ่ม{$roleLabel}เรียบร้อยแล้ว จำนวน {$insertedCount} ท่าน";
            if ($duplicates > 0) {
                $msg .= " (ข้ามครูที่เป็น{$roleLabel}ในปีนี้แล้ว {$duplicates} ท่าน)";
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $msg,
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            $roleLabel = $isHead ? "หัวหน้าระดับ" : "ครูที่ปรึกษาห้องเรียน";
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "ครูที่เลือกทุกคนได้รับการมอบหมายหน้าที่เป็น{$roleLabel}ในปีการศึกษานี้ไปแล้ว",
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function getAssignedTeachers($year = null)
    {
        if (empty($year)) {
            $year = get_selected_year_only();
        }

        $assigned = $this->db->table('tb_regclass')
            ->select('class_teacher, Reg_Class')
            ->where('Reg_Year', $year)
            ->get()->getResult();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $assigned
        ]);
    }

    public function DeleteClassRoom($id)
    {
        if ($this->request->isAJAX()) {
            // Assuming ClassRoom_Delete returns true on success
            if ($this->modAdminClassRoom->ClassRoom_Delete($id)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ', 'csrf_hash' => csrf_hash()]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้', 'csrf_hash' => csrf_hash()]);
            }
        }
        // Optional: Handle non-AJAX requests if necessary, though the view will be changed to use AJAX.
        return $this->response->setStatusCode(403, 'Forbidden');
    }
}
