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

    public function __construct()
    {
        $this->modAdminClassRoom = new ModAdminClassRoom();
        $this->classroom = new Classroom(); // Assuming Classroom library is available or will be migrated
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
        
        // Determine the year to display
        $latestYear = !empty($data['years']) ? $data['years'][0]->Reg_Year : ($data['SchoolYear']->schoolyear_year ?? date('Y') + 543);
        $data['selectedYear'] = $selectedYear ?? $latestYear;

        // Get classroom data for the selected year
        $data['classRoom'] = $this->db->table('tb_regclass')
                                    ->select('*')
                                    ->join($this->DBpersonnel->database . '.tb_personnel', 'tb_personnel.pers_id = tb_regclass.class_teacher')
                                    ->where('Reg_Year', $data['selectedYear'])
                                    ->orderBy('Reg_Class', 'ASC')
                                    ->get()->getResult();

        $data['NameTeacher'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                        ->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_position')
                                        ->where('pers_position !=', 'posi_001')
                                        ->where('pers_position !=', 'posi_002')
                                        ->where('pers_position <', 'posi_007')
                                        ->orderBy('pers_learning')
                                        ->get()->getResult();

        echo view('admin/Academic/AdminClassRoom/AdminClassRoomMain', $data);
        
    }
    
    public function AddClassRoom()
    {
        $dataClassRoom = [
            'Reg_Year'      => $this->request->getPost('year'),
            'Reg_Class'     => $this->request->getPost('classroom'),
            'class_teacher' => $this->request->getPost('teacher'),
        ];
        echo $this->modAdminClassRoom->ClassRoom_Add($dataClassRoom);
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
