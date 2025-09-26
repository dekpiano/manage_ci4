<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminClassRoom;
use App\Libraries\Classroom;

class ConAdminSchoolYear extends BaseController
{
    protected $modAdminClassRoom;
    protected $classroom;

    public function __construct()
    {
        $this->modAdminClassRoom = new ModAdminClassRoom();
        $this->classroom = new Classroom();
        $this->db = \Config\Database::connect(); // Initialize the default database connection

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

    public function SchoolYear(){           
        //echo $data; exit();
        $result = $this->db->table('tb_schoolyear')->update(array('schyear_year' => $this->request->getPost('schyear_year')), ['schyear_id' => 1]);
        print_r($result);
    }
}
