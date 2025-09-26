<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminExamSchedule;

class ConAdminExamSchedule extends BaseController
{
    protected $modAdminExamSchedule;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->modAdminExamSchedule = new ModAdminExamSchedule();
        $this->DBpersonnel = \Config\Database::connect('personnel');
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

    public function AdminExamScheduleMain(){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ตารางสอบ";     
        $data['exam_schedule'] = $this->db->table('tb_exam_schedule')
                                        ->orderBy('exam_id','DESC')
                                        ->get()->getResult();
   
        echo view('admin/Academic/AdminExamSchedule/AdminExamScheduleMain', $data);
        
        
    }
    
    public function add(){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        $data['title'] = "ตารางสอบ";
        $data['icon'] = '<i class="far fa-plus-square"></i>';
        $data['color'] = 'primary';
        
        $exam_schedule_data = $this->db->table('tb_exam_schedule')
                                        ->orderBy('exam_id','DESC')
                                        ->get()->getResult();

        $data['ClassRoom'] = $this->db->table('tb_regclass')->groupBy('Reg_Class')->get()->getResult();
        
        $num1 = 'exam_001'; // Default value
        if (! empty($exam_schedule_data)) {
            $num = explode("_", $exam_schedule_data[0]->exam_id);
            $num1 = 'exam_' . sprintf("%03d", ($num[1] ?? 0) + 1);
        }
        
        $data['exam_id'] = $num1; // Changed from exam_schedule to exam_id to match view
        $data['action'] = 'insert_exam_schedule';

        echo view('admin/Academic/AdminExamSchedule/AdminExamScheduleForm', $data);
        
    }
    
    public function insert_exam_schedule()
    {
        $validationRule = [
            'exam_filename' => [
                'label' => 'Exam File',
                'rules' => 'uploaded[exam_filename]' // Validate upload
                            . '|mime_in[exam_filename,application/pdf]',
                'errors' => [
                    'uploaded' => 'กรุณาเลือกไฟล์ PDF',
                    'mime_in'  => 'ไฟล์ที่อัปโหลดต้องเป็น PDF เท่านั้น',
                ],
            ],
        ];

        if (! $this->validate($validationRule)) {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);
        }

        $file = $this->request->getFile('exam_filename');
        
        if (! $file->isValid()) {
            return $this->response->setJSON(['error' => $file->getErrorString() . '(' . $file->getError() . ')']);
        }

        $newName = $file->getRandomName();
        $uploadPath = 'uploads/academic/exam_schedule/';
        $file->move(ROOTPATH . 'public/' . $uploadPath, $newName);

        $dat_insert = [
                'exam_id'       => $this->request->getPost('exam_id'),
                'exam_type'     => $this->request->getPost('exam_type'),
                'exam_term'     => $this->request->getPost('exam_term'),
                'exam_year'     => $this->request->getPost('exam_year'),
                'exam_filename' => $newName,
                'exam_create'   => date('Y-m-d H:i:s'),
                'exam_user'     => session()->get('login_id'),
            ];
        if($this->modAdminExamSchedule->exam_schedule_insert($dat_insert)){
            return $this->response->setJSON(['success' => 1]);
        } else {
            return $this->response->setJSON(['error' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }
    }

    public function delete_exam_schedule($data,$img)
    {   
        if (!empty($img) && file_exists(FCPATH."uploads/academic/exam_schedule/".$img)) {
            unlink(FCPATH."uploads/academic/exam_schedule/".$img);
        }
        
        if($this->modAdminExamSchedule->exam_schedule_delete($data)){
            session()->setFlashdata(['alert'=> 'success','messge' => 'ลบข้อมูลสำเร็จ']);
            return redirect()->to(base_url('Admin/ExamSchedule'));
        } else {
            session()->setFlashdata(['alert'=> 'error','messge' => 'ไม่สามารถลบข้อมูลได้']);
            return redirect()->to(base_url('Admin/ExamSchedule'));
        }
    }
}
