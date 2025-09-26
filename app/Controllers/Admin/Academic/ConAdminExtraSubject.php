<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminExtraSubject;

class ConAdminExtraSubject extends BaseController
{
    protected $modAdminExtraSubject;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->modAdminExtraSubject = new ModAdminExtraSubject();
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

    public function index(){

        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ลงทะเบียนวิชาเพิ่มเติม";
        $ExtraSetting = $this->db->table('tb_extra_setting')->get()->getRow();

        $data['ExtraSubject'] = [];
        if (!empty($ExtraSetting) && !empty($ExtraSetting->extra_setting_year) && !empty($ExtraSetting->extra_setting_term)) {
            $data['ExtraSubject'] = $this->db->table('tb_extra_subject')
                                            ->where('extra_year',$ExtraSetting->extra_setting_year)
                                            ->where('extra_term',$ExtraSetting->extra_setting_term)
                                            ->get()->getResult();
        }

        $data['CountStudentRegister'] = $this->db->table('tb_extra_register')
                                                ->select('tb_extra_register.fk_std_id,
                                                        COUNT(tb_extra_register.fk_std_id) AS CountAll,
                                                        tb_extra_register.fk_extr-id
                                                        ')->groupBy('tb_extra_register.fk_extr-id')
                                                        ->get()->getResult();
        $data['NameTeacher'] = $this->DBpersonnel->table('tb_personnel')
        ->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_position,pers_learning')
        ->where('pers_position !=','posi_001')
        ->where('pers_position !=','posi_002')
        ->where('pers_position !=','posi_007')
        ->where('pers_position !=','posi_008')
        ->where('pers_position !=','posi_009')
        ->where('pers_position !=','posi_010')        
        ->orderBy('pers_learning')
        ->get()->getResult();

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminExtraSubject/AdminExtraSubjectMain.php');
        
    }

    public function AddExtraSubject(){   
        //print_r(implode("|",$this->input->post('extra_grade_level'))); exit();
        $extraGradeLevel = $this->request->getPost('extra_grade_level');
        $dataExtraSubject = array('extra_year' => $this->request->getPost('extra_year'),
                                'extra_term' => $this->request->getPost('extra_term'),
                                'extra_key_room' => $this->request->getPost('extra_key_room'),
                                'extra_course_code' => $this->request->getPost('extra_course_code'),
                                'extra_course_name' => $this->request->getPost('extra_course_name'),
                                'extra_course_teacher' => $this->request->getPost('extra_course_teacher'),
                                'extra_grade_level' => !empty($extraGradeLevel) ? implode("|", $extraGradeLevel) : '',
                                'extra_number_students' => $this->request->getPost('extra_number_students'),
                                'extra_comment' => $this->request->getPost('extra_comment')
                            );
        echo $this->modAdminExtraSubject->ExtraSubject_Add($dataExtraSubject);
    }

    public function EditExtraSubject(){         
        $re = $this->db->table('tb_extra_subject')->where('extr-id', $this->request->getPost('Extraid'))->get()->getRow();
        echo json_encode($re);
    }

    public function UpdateExtraSubject(){ 
             
        $extraGradeLevel = $this->request->getPost('extra_grade_level');
        $dataExtraSubject = array('extra_year' => $this->request->getPost('extra_year'),
                                'extra_term' => $this->request->getPost('extra_term'),
                                'extra_key_room' => $this->request->getPost('extra_key_room'),
                                'extra_course_code' => $this->request->getPost('extra_course_code'),
                                'extra_course_name' => $this->request->getPost('extra_course_name'),
                                'extra_course_teacher' => $this->request->getPost('extra_course_teacher'),
                                'extra_grade_level' => !empty($extraGradeLevel) ? implode("|", $extraGradeLevel) : '',
                                'extra_number_students' => $this->request->getPost('extra_number_students'),
                                'extra_comment' => $this->request->getPost('extra_comment')
                            );
        echo $this->modAdminExtraSubject->ExtraSubject_Update($dataExtraSubject,$this->request->getPost('extr-id'));
    }

    // ------------------ ตั้งค่าระบบ ---------------------------
    public function SystemMainExtraSubject(){ 

        $data['title'] = "ตั้งค่าระบบ";
        $data['OnoffSystem'] = $this->db->table('tb_extra_setting')->get()->getRow();
        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminExtraSubject/AdminExtraSystemMain.php');

    }

    public function ExtraSettingOnoff() {
        $data = array('extra_setting_onoff' =>$this->request->getPost('onoff') );
        $result = $this->db->table('tb_extra_setting')->update($data, ['extra_setting_id' => 1]);
        echo $result;
    }

    public function ExtraSettingTerm() {
        $data = array('extra_setting_term' => $this->request->getPost('Term'));
        $result = $this->db->table('tb_extra_setting')->update($data, ['extra_setting_id' => 1]);
        if($result == 1){
            echo $this->request->getPost('Term');
        }else{
            echo 0;
        }
    }

    public function ExtraSettingYear() {
        $data = array('extra_setting_year' => $this->request->getPost('Year'));
        $result = $this->db->table('tb_extra_setting')->update($data, ['extra_setting_id' => 1]);
        if($result == 1){
            echo $this->request->getPost('Year');
        }else{
            echo 0;
        }
    }

    public function ExtraSettingDateStart() {
       // echo $this->input->post('DateStart'); exit();
        $dateStart = $this->request->getPost('DateStart');
        $data = array('extra_setting_datestart' => $dateStart);
        $result = $this->db->table('tb_extra_setting')->update($data, ['extra_setting_id' => 1]);
        if($result == 1){
            echo date('d-m-Y H:i', strtotime(!empty($dateStart) ? $dateStart : 'now'));
        }else{
            echo 0;
        }
    }

    public function ExtraSettingDateEnd() {
        // echo $this->input->post('DateStart'); exit();
         $dateEnd = $this->request->getPost('DateEnd');
         $data = array('extra_setting_dateend' => $dateEnd);
         $result = $this->db->table('tb_extra_setting')->update($data, ['extra_setting_id' => 1]);
         if($result == 1){
             echo date('d-m-Y H:i', strtotime(!empty($dateEnd) ? $dateEnd : 'now'));
         }else{
             echo 0;
         }
     }

     public function ExtraReport() {
        $data['title'] = "รายงาน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        $ExtraSetting = $this->db->table('tb_extra_setting')->get()->getRow();
        $data['OnoffSystem'] = $this->db->table('tb_extra_setting')->get()->getRow();
        
        $data['Report'] = [];
        if (!empty($ExtraSetting) && !empty($ExtraSetting->extra_setting_year) && !empty($ExtraSetting->extra_setting_term)) {
            $data['Report'] = $this->db->table('tb_extra_register')
                                                ->select('tb_extra_subject.extra_year,
                                                        tb_extra_subject.extra_term,
                                                        tb_extra_subject.extra_course_name,
                                                        tb_extra_subject.extra_course_code,
                                                        tb_extra_subject.extra_course_teacher,
                                                        tb_extra_register.fk_std_id,
                                                        tb_extra_register.fk_extr-id,
                                                        tb_extra_register.regis_ex_id,
                                                        tb_extra_register.regis_ex_datecreated,
                                                        tb_student_express.StudentPrefix,
                                                        tb_student_express.StudentFirstName,
                                                        tb_student_express.StudentLastName,
                                                        tb_student_express.StudentNumber,
                                                        tb_student_express.StudentClass')
                                                ->join('tb_extra_subject','tb_extra_subject.extr-id = tb_extra_register.fk_extr-id')   
                                                ->join('tb_student_express','tb_student_express.StudentCode = tb_extra_register.fk_std_id')   
                                                ->where('extra_year',$ExtraSetting->extra_setting_year)
                                                ->where('extra_term',$ExtraSetting->extra_setting_term)
                                                ->get()->getResult();
        }

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminExtraSubject/AdminExtraReport.php');
     }
}
