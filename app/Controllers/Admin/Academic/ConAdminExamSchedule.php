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
        ob_start(); // Start output buffering
        // Validation rules for the data received from the form
        $rules = [
            'exam_type'     => 'required',
            'exam_term'     => 'required',
            'exam_year'     => 'required',
            'exam_filename' => 'required',
        ];

        if (! $this->validate($rules)) {
            ob_clean(); // Clean buffer
            // If validation fails, return errors in the expected JSON format
            return $this->response->setJSON([
                'success' => false,
                'message' => implode('<br>', $this->validator->getErrors())
            ]);
        }

        // Generate new exam_id
        $latest_exam = $this->db->table('tb_exam_schedule')
                                ->orderBy('exam_id', 'DESC')
                                ->limit(1)
                                ->get()->getRow();

        $new_exam_id = 'exam_001'; // Default value
        if (!empty($latest_exam)) {
            $num_part = explode("_", $latest_exam->exam_id)[1] ?? 0;
            $new_exam_id = 'exam_' . sprintf("%03d", $num_part + 1);
        }

        // Prepare data for insertion
        $remoteFileName = $this->request->getPost('exam_filename');

        $dat_insert = [
                'exam_id'       => $new_exam_id, // Add the newly generated ID
                'exam_type'     => $this->request->getPost('exam_type'),
                'exam_term'     => $this->request->getPost('exam_term'),
                'exam_year'     => $this->request->getPost('exam_year'),
                'exam_filename' => $remoteFileName, // Use the filename from the remote server
                'exam_create'   => date('Y-m-d H:i:s'),
                'exam_user'     => session()->get('login_id'),
            ];

        // Insert data into the database
        $result = $this->modAdminExamSchedule->exam_schedule_insert($dat_insert);
                    ob_clean(); // Clean buffer
            // Error response
            return $this->response->setJSON([
                'success' => true,
                'message' => $result 
            ]);
        
    }

    public function delete_exam_schedule($id)
    {
        // The remote file is deleted by the client-side script before calling this.
        // This function now only needs to delete the database record.

        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing ID.'])->setStatusCode(400);
        }

        if($this->modAdminExamSchedule->exam_schedule_delete($id)){
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Could not delete the record from the database.']);
        }
    }
}
