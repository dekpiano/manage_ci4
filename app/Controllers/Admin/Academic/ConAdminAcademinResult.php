<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminAcademinResult;

class ConAdminAcademinResult extends BaseController
{
    protected $modAdminAcademinResult;
    protected $DBpersonnel; // Declare DBpersonnel property

    public function __construct()
    {
        $this->modAdminAcademinResult = new ModAdminAcademinResult();
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

    public function AdminAcademinResultMain()
    {
        $data['admin'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ดูผลการเรียนของนักเรียน";

        $data['checkYear'] = $this->db->table('tb_subjects')
                                    ->select('SubjectYear')
                                    ->groupBy('SubjectYear')
                                    ->get()->getResult();

        // ฟังก์ชันเรียงลำดับ
        usort($data['checkYear'], function ($a, $b) {
            list($termA, $yearA) = explode('/', $a->SubjectYear);
            list($termB, $yearB) = explode('/', $b->SubjectYear);

            if ($yearA == $yearB) {
                return $termA <=> $termB; // เรียงตามภาคเรียน
            }
            return $yearA <=> $yearB; // เรียงตามปี
        });

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminAcademicResult/AdminAcademicResultMain', $data);
        
    }
    
    public function CheckOnOffDoGrade()
    {
        echo $this->modAdminAcademinResult->UpdateOnOff($this->request->getPost('check'));
    }
    public function CheckOnOffOpenYear()
    {
        echo $this->db->table('tb_register_onoff')->where('onoff_ID', 1)->set(['onoff_year' => $this->request->getPost('check')])->update();
    }
    public function OnOffLevel()
    {
        echo $this->db->table('tb_register_onoff')->where('onoff_ID', 1)->set(['onoff_Level' => $this->request->getPost('data')])->update();
    }

    public function add()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ตารางเรียน";
        $data['icon'] = '<i class="far fa-plus-square"></i>';
        $data['color'] = 'primary';

        $class_schedule_data = $this->db->table('tb_class_schedule')
                                        ->orderBy('schestu_id', 'DESC')
                                        ->get()->getResult();

        $num1 = 'schestu_001'; // Default value
        if (! empty($class_schedule_data)) {
            $num = explode("_", $class_schedule_data[0]->schestu_id);
            $num1 = 'schestu_' . sprintf("%03d", ($num[1] ?? 0) + 1);
        }
        
        $data['class_schedule'] = $num1;
        $data['action'] = 'insert_class_schedule';

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminClassSchedule/AdminClassScheduleForm', $data);
        
    }
}
