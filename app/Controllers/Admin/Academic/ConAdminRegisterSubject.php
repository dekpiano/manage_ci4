<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminRegisterSubject;

class ConAdminRegisterSubject extends BaseController
{
    protected $modAdminRegisterSubject;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->modAdminRegisterSubject = new ModAdminRegisterSubject();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

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

    public function update_row($RegisterYear,$SubjectCode, $data) {
        // อัปเดตข้อมูลของแถวเดียวโดยใช้ ID เป็นเงื่อนไข
        $this->db->table('tb_register')->where('RegisterYear', $RegisterYear);
        $this->db->table('tb_register')->where('SubjectCode', $SubjectCode);
        $this->db->table('tb_register')->update($data);
    }

    public function update_data_with_foreach() {
        

        // เริ่มต้น transaction
        $this->db->transStart();


        $da = $this->db->table('tb_subjects')->select('SubjectYear,SubjectCode,SubjectID')->get()->getResult();
        // เตรียมข้อมูลตัวอย่าง
        $data = [];
        // Assuming 1501-1793 is a hardcoded range from CI3. In CI4, this might need dynamic fetching or re-evaluation.
        // For now, retaining the hardcoded loop for migration consistency.
        for ($i = 0; $i < count($da); $i++) { // Adjusted loop to iterate through $da array
            if(isset($da[$i])){
                $data[] = [
                    'SubjectID' => !empty($da[$i]->SubjectID) ? $da[$i]->SubjectID : null,
                    'SubjectCode' => !empty($da[$i]->SubjectCode) ? $da[$i]->SubjectCode : null,
                    'SubjectYear' => !empty($da[$i]->SubjectYear) ? $da[$i]->SubjectYear : null
                ];
            }
        }

        //echo '<pre>';print_r($data);exit();
        // ใช้ foreach อัปเดตข้อมูลทีละแถว
        foreach ($data as $row) {
            //echo '<pre>';print_r($row);
            if (!empty($row['SubjectYear']) && !empty($row['SubjectCode']) && !empty($row['SubjectID'])) {
                $this->update_row($row['SubjectYear'], $row['SubjectCode'],['SubjectCode' => $row['SubjectID']]);
            }
        }
        //exit();
        
        // สรุป transaction (commit หรือ rollback)
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            // กรณีอัปเดตล้มเหลว
            echo "Error updating data";
        } else {
            // กรณีอัปเดตสำเร็จ
            echo "Data updated successfully";
        }
    }

    public function AdminRegisterSubjectSelect(){ 
      
        $data = [];
        $keyYear = $this->request->getPost('keyYear');
        $subject = [];

        if(!empty($keyYear)){
            $subject = $this->db->table('tb_subjects')->where('SubjectYear',$keyYear)->get()->getResult();
        }else{
            // ใช้ปีการศึกษาจากระบบกลาง
            $currentYear = get_selected_year();
            $subject = $this->db->table('tb_subjects')->where('SubjectYear', !empty($currentYear) ? $currentYear : null)->get()->getResult();
        }

       
        foreach($subject as $record){
            $data[] = array( 
                "SubjectYear" => !empty($record->SubjectYear) ? $record->SubjectYear : null,
                "SubjectCode" => !empty($record->SubjectCode) ? $record->SubjectCode : null,
                "SubjectName" => !empty($record->SubjectName) ? $record->SubjectName : null,
                "SubjectType" => !empty($record->SubjectType) ? $record->SubjectType : null,
                "FirstGroup" => !empty($record->FirstGroup) ? $record->FirstGroup : null,
                "SubjectClass" => !empty($record->SubjectClass) ? $record->SubjectClass : null,
                "SubjectYear" => !empty($record->SubjectYear) ? $record->SubjectYear : null,
                "SubjectID" => !empty($record->SubjectID) ? $record->SubjectID : null,
                "keyYear" => $this->request->getPost('keyYear')
            );

        }
        $output = array(
            "data" =>  $data           
        );
        echo json_encode($output);
    }

    public function AdminRegisterSubjectInsert(){ 

        $subjectCode = $this->request->getPost('SubjectCode');
        $subjectYear = $this->request->getPost('SubjectYear');

        $check_subject = $this->db->table('tb_subjects')
                ->where('SubjectCode',!empty($subjectCode) ? $subjectCode : null)
                ->where('SubjectYear',!empty($subjectYear) ? $subjectYear : null)
                ->countAllResults();

        if($check_subject > 0){
            echo 0 ;

        }else{
            $data = array('SubjectCode' => $this->request->getPost('SubjectCode'),
            'SubjectName' => $this->request->getPost('SubjectName'),
            'SubjectUnit' => $this->request->getPost('SubjectUnit'),
            'SubjectHour' => $this->request->getPost('SubjectHour'),
            'SubjectType' => $this->request->getPost('SubjectType'),
            'FirstGroup' => $this->request->getPost('FirstGroup'),
            'SecondGroup' => $this->request->getPost('SecondGroup'), 
            'SubjectClass' => $this->request->getPost('SubjectClass'),
            'SubjectYear' => $this->request->getPost('SubjectYear'));  
             echo $this->modAdminRegisterSubject->ModSubjectInsert($data);

        }
        
       
    }

    public function AdminRegisterSubjectUpdate(){      
        $data = array('SubjectCode' => $this->request->getPost('Up_SubjectCode'),
        'SubjectName' => $this->request->getPost('Up_SubjectName'),
        'SubjectUnit' => $this->request->getPost('Up_SubjectUnit'),
        'SubjectHour' => $this->request->getPost('Up_SubjectHour'),
        'SubjectType' => $this->request->getPost('Up_SubjectType'),
        'FirstGroup' => $this->request->getPost('Up_FirstGroup'),
        'SecondGroup' => $this->request->getPost('Up_SecondGroup'), 
        'SubjectClass' => $this->request->getPost('Up_SubjectClass'),
        'SubjectYear' => $this->request->getPost('Up_SubjectYear'));  
        $key = $this->request->getPost('Up_SubjectID');
        echo $this->modAdminRegisterSubject->ModSubjectUpdate($data,$key);
    }

    public function AdminRegisterSubjectEdit(){ 
       echo json_encode($this->modAdminRegisterSubject->ModSubjectEdit($this->request->getPost('KeySubj'))); 
    }

    public function AdminRegisterSubjectDelete($id){ 
        echo $this->modAdminRegisterSubject->ModSubjectDelete($id); 
    }

    public function AdminRegisterSubjectMain(){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['GroupYear'] = $this->db->table('tb_subjects')->select('SubjectYear')->groupBy('SubjectYear')->orderBy('SubjectYear','ASC')->get()->getResult();

        //$this->update_data_with_foreach(); exit();
       
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        // ใช้ปีการศึกษาจากระบบกลาง (session หรือ tb_schoolyear)
        $data['selectedYear'] = get_selected_year();
        $data['title'] = "วิชาเรียน";	
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['classroom'] = new \App\Libraries\Classroom();
        
        echo view('admin/Academic/AdminRegisterSubject/AdminRegisterSubjectMain', $data);

    }
}
