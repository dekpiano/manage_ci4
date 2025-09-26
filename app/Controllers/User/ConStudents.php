<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class ConStudents extends BaseController
{
    protected $title = "แผงควบคุม";
    protected $db; // เปลี่ยนชื่อจาก $DBSKJ เป็น $db
    protected $DBPERS;
    protected $DBSKJ;

    public function __construct()
    {
        $this->db = \Config\Database::connect('default'); // เปลี่ยนการเชื่อมต่อเป็น default group
        $this->DBPERS = \Config\Database::connect('personnel');
        $this->DBSKJ = \Config\Database::connect('skj'); // Initialize skjacth_skj database connection
    }

    public function index(){ 
        $data['title'] = "หน้าแรก";
        $data['description'] = "หน้าหลัก";     
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
    return view('user/Students/PageStudentsHome', $data);

        // delete_cookie('username_cookie'); 
		// delete_cookie('password_cookie'); 
        // $this->session->sess_destroy();
        
    }

    public function Home(){      
        
        $data['title'] = "หน้าแรก";
        $data['description'] = "หน้าแรก";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
    return view('user/Students/PageStudentsHome', $data);

        // delete_cookie('username_cookie'); 
		// delete_cookie('password_cookie'); 
        // $this->session->sess_destroy();
        
    }

    public function StudentsList(){  
        $data['title'] = "รายชื่อนักเรียนและครูที่ปรึกษา";
        $data['description'] = "ตรวจสอบรายชื่อนักเรียนและครูที่ปรึกษา";
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('uploads/banner/StudentList/bannerStu.png');
        $data['schoolyear'] = $this->db->table('tb_schoolyear')->get()->getRow();

        $data['SelectSubject'] = $this->db->table('tb_subjects')->select('SubjectCode,SubjectName')
        ->where('SubjectYear',$data['schoolyear']->schyear_year)
        ->orderBy('FirstGroup','ASC')
        ->get()->getResult();

        
       
        $subYear = explode('/',$data['schoolyear']->schyear_year);
        $data['TeacRoom'] = $this->db->table('tb_regclass')->select([
            'skjacth_personnel.tb_personnel.pers_prefix',
            'skjacth_personnel.tb_personnel.pers_firstname',
            'skjacth_personnel.tb_personnel.pers_lastname',
            'tb_regclass.Reg_Class'
        ])
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_regclass.class_teacher')
        ->where('Reg_Year',$subYear[1])
        ->where('Reg_Class',$this->request->getGet('studentList'))
        ->get()->getResult();

        $data['checkLine'] = $this->db->table('tb_students')->select('StudentClass,StudentStudyLine')
        ->where('StudentClass','ม.'.$this->request->getGet('studentList'))
        ->groupBy('StudentStudyLine')
        ->get()->getResult();
        $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
        ->where('StudentStatus','1/ปกติ')  
        ->where('StudentBehavior !=','จำหน่่าย')      
        ->where('StudentClass','ม.'.$this->request->getGet('studentList'))
        ->orderBy('StudentNumber','ASC')
        ->get()->getResult();
                
    return view('user/PageStudentsList', $data);

        // delete_cookie('username_cookie'); 
		// delete_cookie('password_cookie'); 
        // $this->session->sess_destroy();
        
    }

    public function StudentsPrintRoom($Class,$Room,$StudyLine = 0){
   
        $path = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
		require $path . '/librarie_skj/mpdf/vendor/autoload.php';

        $live_mpdf = new \Mpdf\Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 12,
                'margin_top' => 5,
	            'margin_left' => 5,
	            'margin_right' => 5,
	            'mirrorMargins' => 0
            )
        );

        $data['schoolyear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $subYear = explode('/',$data['schoolyear']->schyear_year);

        

        $NameRoom = 'ม.'.$Class.'/'.$Room;
        $data['SubRoom'] = explode('.',$NameRoom);
        $data['TeacRoom'] = $this->db->table('tb_regclass')->select([
            'skjacth_personnel.tb_personnel.pers_prefix',
            'skjacth_personnel.tb_personnel.pers_firstname',
            'skjacth_personnel.tb_personnel.pers_lastname',
            'tb_regclass.Reg_Class'
        ])
        ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_regclass.class_teacher')
        ->where('Reg_Year',$subYear[1])
        ->where('Reg_Class',$data['SubRoom'][1])
        ->get()->getResult();

        //echo '<pre>'; print_r($data['TeacRoom']); exit();

        $data['checkLine'] = $this->db->table('tb_students')->select('StudentStudyLine')
        ->where('StudentClass',$NameRoom)
        ->groupBy('StudentStudyLine')
        ->get()->getResult();

        if($StudyLine == "All"){
            $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
            ->where('StudentStatus','1/ปกติ')  
            ->where('StudentBehavior !=','จำหน่่าย')      
            ->where('StudentClass',$NameRoom)
            ->orderBy('StudentNumber','ASC')
            ->get()->getResult();
        }else{
            $data['selStudent'] = $this->db->table('tb_students')->select('StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentStudyLine,StudentBehavior')
            ->where('StudentStatus','1/ปกติ')  
            ->where('StudentBehavior !=','จำหน่่าย')      
            ->where('StudentClass',$NameRoom)
            ->where('StudentStudyLine',$StudyLine)
            ->orderBy('StudentNumber','ASC')
            ->get()->getResult();
        }

        // true
        $ReportFront = view('user/PageStudentsListPrint',$data,['save' => true]);        
        $live_mpdf->WriteHTML($ReportFront);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $live_mpdf->Output('filename.pdf', \Mpdf\Output\Destination::INLINE); 
    }
    
    public function ExamSchedule(){
        $data['title'] = "ตารางสอบ";
        $data['description'] = "ตารางสอบ";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('assets/images/ExamSchedule/banner.jpg');

        $data['Exam'] = $this->db->table('tb_exam_schedule')->orderBy('exam_id','DESC')->limit(6)->get()->getResult();
       
    return view('user/PageExamSchedule', $data);
    }

    public function ExamScheduleOnline(){
        $data['title'] = "ตารางสอบ Online";
        $data['description'] = "ตารางสอบ Online";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url("uploads/banner/ExamScheduleOnline/banner.png");

        $data['Exam'] = $this->db->table('tb_exam_schedule')->orderBy('exam_id','DESC')->limit(6)->get()->getResult();
    return view('user/PageExamScheduleOnline', $data);
    }

    public function ClassSchedule(){
        $data['title'] = "ตารางเรียน 1/2568";
        $data['description'] = "ตารางเรียน 1/2568";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url("uploads/banner/class_schedule/banner.png");;
        
        $data['schedule'] = $this->db->table('tb_class_schedule')->orderBy('schestu_id','DESC')->get()->getResult();
    return view('user/PageClassSchedule', $data);
    }

    public function SearchClassSchedule(){
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();

        $Ex = explode('/',$data['SchoolYear']->schyear_year);
        
        $data['schedule'] = $this->db->table('tb_class_schedule')
        ->where('schestu_term', $Ex[0])
        ->where('schestu_year', $Ex[1])
        ->orderBy('schestu_classname','ASC')
        ->get()->getResult();
        header('Content-Type: application/json');
        return $this->response->setJSON($data['schedule']);

    }

    //-----ห้องเรียนออนไลน์ ------
    public function LearningOnline(){
        $data['lear'] =	$this->DBSKJ->table('tb_learning')->get()->getResult(); //กลุ่มสาระ
         $data['title'] = "ห้องเรียนออนไลน์";
         $data['description'] = "ห้องเรียนออนไลน์";  
         $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";        
         $data['banner'] = base_url('uploads/banner/RoomOnline/bannerRoomOnline.png');
         
         $data['room'] = $this->db->table('tb_room_online')->select([
                                            'tb_room_online.*',
                                            'skjacth_personnel.tb_personnel.pers_prefix',
                                            'skjacth_personnel.tb_personnel.pers_firstname',
                                            'skjacth_personnel.tb_personnel.pers_lastname',
                                            'skjacth_personnel.tb_personnel.pers_img'
                                        ])
                                            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = tb_room_online.roomon_teachid','LEFT')
                                ->where('roomon_classlevel',$this->request->getGet('s'))
                                ->get()->getResult();
        $data['keyroom'] = $this->request->getGet('s');
         return view('user/LearnOnline/PageLearnOnlineDetail', $data);
     }

     public function LearningOnlineDetail($key){
        $data['lear'] =	$this->DBSKJ->table('tb_learning')->get()->getResult(); //กลุ่มสาระ
         $data['title'] = "ห้องเรียนออนไลน์";
         $data['description'] = "ห้องเรียนออนไลน์";  
         $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
         $data['banner'] = base_url('uploads/banner/RoomOnline/bannerRoomOnline.png');

         return view('user/LearnOnline/PageLearnOnlineDetail', $data);
     }


     public function PageReportLearnOnline(){ 
        $data['lear'] =	$this->DBSKJ->table('tb_learning')->get()->getResult(); //กลุ่มสาระ
        $data['title'] = "แบบรายงานการเรียนการสอนออนไลน์";
        $data['description'] = "แบบรายงานการเรียนการสอนออนไลน์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";

         return view('user/PageReportLearnOnline', $data);
     }
}
