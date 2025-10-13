<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminHome extends BaseController
{
    protected $DBpersonnel;
    protected $db; // Add this line

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect('default'); // Add this line

        helper(['url', 'form']);

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

    public function AdminHome(){      
        $data['title'] = "หน้าแรก";
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();


                // Query for statistics
        $data['total_students'] = $this->db->table('tb_students')->where('StudentStatus', '1/ปกติ')->countAllResults();
        $data['total_teachers'] = $this->DBpersonnel->table('tb_personnel')->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005','posi_006'])->countAllResults();
        if ($data['SchoolYear']) {
            $data['total_subjects'] = $this->db->table('tb_subjects')->where('SubjectYear', $data['SchoolYear']->schyear_year)->countAllResults();
        } else {
            $data['total_subjects'] = 0;
        }
        //$data['total_classrooms'] = $this->db->table('tb_students')->where('StudentBehavior', '1/ปกติ')->distinct()->countAll('StudentClass');
        $data['total_classrooms'] = 36;


        echo view('admin/Academic/AdminHome/AdminHome', $data);
        
    }
}
