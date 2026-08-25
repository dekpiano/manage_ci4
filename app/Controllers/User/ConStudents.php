<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class ConStudents extends BaseController
{
    protected $title = "ฝ่ายวิชาการ";
    protected $db; // เปลี่ยนชื่อจาก $DBSKJ เป็น $db
    protected $DBPERS;
    protected $DBSKJ;

    public function __construct()
    {
        $this->db = \Config\Database::connect('default'); // เปลี่ยนเป็นเชื่อมต่อกับ default group
        $this->DBPERS = \Config\Database::connect('personnel');
        $this->DBSKJ = \Config\Database::connect('skj'); // Initialize skjacth_skj database connection
    }

    public function index(){ 
        $data['title'] = "วิชาการ";
        $data['description'] = "วิชาการ";     
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        return view('user/Students/PageStudentsHome', $data);
    }

    public function Home(){      
        $data['title'] = "วิชาการ";
        $data['description'] = "วิชาการ";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";
        
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        return view('user/Students/PageStudentsHome', $data);
    }

    public function StudentsList(){  
        $data['title'] = "รายชื่อนักเรียน";
        $data['description'] = "รายชื่อนักเรียน";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('assets/images/Students/banner.png');
        $data['checkLine'] = $this->db->table('tb_students')->select('StudentStudyLine')
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
    }

    public function StudentsPrintRoom($Class,$Room,$StudyLine = 0){
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $live_mpdf = new Mpdf(
            array(
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font' => 'thsarabun',
                'default_font_size' => 12,
                'margin_top' => 5,
	            'margin_left' => 5,
	            'margin_right' => 5,
	            'mirrorMargins' => 0,
                'tempDir' => WRITEPATH . 'mpdf',
                'fontDir' => array_merge($fontDirs, [FCPATH . 'assets/fonts']),
                'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf',
                        'B' => 'THSarabunNew Bold.ttf',
                        'I' => 'THSarabunNew Italic.ttf',
                        'BI' => 'THSarabunNew BoldItalic.ttf'
                    ]
                ],
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
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

        $exams = $this->db->table('tb_exam_schedule')
                                ->where('exam_status', 'เปิด')
                                ->orderBy('exam_year','DESC')
                                ->orderBy('exam_term','DESC')
                                ->get()->getResult();
        
        $groupedExams = [];
        foreach ($exams as $exam) {
            $key = $exam->exam_term . '/' . $exam->exam_year;
            if (!isset($groupedExams[$key])) {
                $groupedExams[$key] = [
                    'exam_term' => $exam->exam_term,
                    'exam_year' => $exam->exam_year,
                    'exam_type' => $exam->exam_type,
                    'files' => []
                ];
            }
            $groupedExams[$key]['files'][] = $exam->exam_filename;
        }

        $data['Exam'] = $groupedExams;
       
        return view('user/PageExamSchedule', $data);
    }

    public function ExamScheduleOnline(){
        $data['title'] = "ตารางสอบ Online";
        $data['description'] = "ตารางสอบ Online";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url("uploads/banner/ExamScheduleOnline/banner.png");

        $data['Exam'] = $this->db->table('tb_exam_schedule')
                                ->where('exam_status', 'เปิด')
                                ->orderBy('exam_id','DESC')
                                ->limit(6)->get()->getResult();
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

    public function SearchClassSchedule()
    {
        $year = $this->request->getGet('year');
        $term = $this->request->getGet('term');
        $schedule = [];

        if (!empty($year) && !empty($term)) {
            $schedule = $this->db->table('tb_class_schedule')
                ->where('schestu_term', $term)
                ->where('schestu_year', $year)
                ->orderBy('schestu_classname', 'ASC')
                ->get()
                ->getResult();
        }

        return $this->response->setJSON($schedule);
    }

    public function getScheduleYears()
    {
        $years = $this->db->table('tb_class_schedule')
            ->select('schestu_year')
            ->distinct()
            ->orderBy('schestu_year', 'DESC')
            ->get()
            ->getResult();

        return $this->response->setJSON($years);
    }

    //----- ห้องเรียนออนไลน์ ------
    public function LearningOnline(){
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "ห้องเรียนออนไลน์";
        $data['description'] = "ห้องเรียนออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";  
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
        return view('user/PageLearningOnline', $data);
    }

    public function LearningOnlineDetail($key = null){
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "ห้องเรียนออนไลน์";
        $data['description'] = "ห้องเรียนออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = base_url('uploads/banner/RoomOnline/bannerRoomOnline.png');

        $decodedKey = urldecode($key ?? '');
        $learGroup = null;
        if (!empty($decodedKey)) {
            $learGroup = $this->DBSKJ->table('tb_learning')
                ->where('lear_nameeng', $decodedKey)
                ->orWhere('lear_id', $decodedKey)
                ->orWhere('lear_namethai', $decodedKey)
                ->get()->getRow();
        }

        $builder = $this->db->table('tb_room_online')->select([
            'tb_room_online.*',
            'skjacth_personnel.tb_personnel.pers_prefix',
            'skjacth_personnel.tb_personnel.pers_firstname',
            'skjacth_personnel.tb_personnel.pers_lastname',
            'skjacth_personnel.tb_personnel.pers_img',
            'skjacth_personnel.tb_personnel.pers_learning'
        ])->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_room_online.roomon_teachid', 'LEFT');

        if ($learGroup) {
            $builder->where('skjacth_personnel.tb_personnel.pers_learning', $learGroup->lear_id);
            $data['title'] = "ห้องเรียนออนไลน์ - กลุ่มสาระการเรียนรู้" . $learGroup->lear_namethai;
        }

        if ($this->request->getGet('s')) {
            $builder->where('tb_room_online.roomon_classlevel', $this->request->getGet('s'));
        }

        $data['room'] = $builder->orderBy('roomon_classlevel', 'ASC')->orderBy('roomon_coursecode', 'ASC')->get()->getResult();
        $data['learGroup'] = $learGroup;
        $data['key'] = $decodedKey;
        $data['keyroom'] = $this->request->getGet('s');

        return view('user/PageLearningOnlineDetail', $data);
    }

    public function PageReportLearnOnline(){ 
        $data['lear'] = $this->DBSKJ->table('tb_learning')->get()->getResult();
        $data['title'] = "แบบรายงานการเรียนการสอนออนไลน์";
        $data['description'] = "แบบรายงานการเรียนการสอนออนไลน์";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";

        return view('user/PageReportLearnOnline', $data);
    }
}
