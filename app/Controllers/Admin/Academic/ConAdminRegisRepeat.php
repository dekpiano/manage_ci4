<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminAcademinResult;

class ConAdminRegisRepeat extends BaseController
{
    protected $modAdminAcademinResult;
    protected $DBPers;

    public function __construct()
    {
        $this->modAdminAcademinResult = new ModAdminAcademinResult();
        $this->DBPers = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if ((session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function AdminRegisRepeatMain(){   
        $data['admin'] = $this->DBPers->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult(); // Changed to getResult()
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();
        
        $data['title'] = "ลงทะเบียนเรียน (ซ้ำ)";	

        $data['GroupYear'] = $this->db->table('tb_subjects')->select('SubjectYear')->groupBy('SubjectYear')->get()->getResult();

        // Sort the GroupYear array in PHP (Year DESC, Term DESC)
        usort($data['GroupYear'], function($a, $b) {
            $subjectYearA = $a->SubjectYear ?? '';
            $subjectYearB = $b->SubjectYear ?? '';

            // Handle empty SubjectYear values
            if (empty($subjectYearA) && empty($subjectYearB)) return 0;
            if (empty($subjectYearA)) return 1; // Empty comes last
            if (empty($subjectYearB)) return -1; // Empty comes last

            $partsA = explode('/', $subjectYearA);
            $partsB = explode('/', $subjectYearB);

            $yearA = (count($partsA) > 1) ? (int)$partsA[1] : (int)$partsA[0];
            $termA = (count($partsA) > 1) ? (int)$partsA[0] : 0;

            $yearB = (count($partsB) > 1) ? (int)$partsB[1] : (int)$partsB[0];
            $termB = (count($partsB) > 1) ? (int)$partsB[0] : 0;

            if ($yearA == $yearB) {
                return $termB <=> $termA; // Sort by term descending
            }
            return $yearB <=> $yearA; // Sort by year descending
        });

        // Dashboard Statistics for repeat registration
        $currentYear = $data['selectedYear'];
        
        // Total subjects with repeat registrations in selected year
        // (วิชาที่มีนักเรียนลงทะเบียนเรียนซ้ำ = มี RepeatTeacher)
        $data['total_subjects_repeat'] = $this->db->table('tb_register')
            ->select('SubjectID')
            ->where('RegisterYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        // Total students with repeat registrations (distinct) in selected year
        // (นักเรียนที่ลงทะเบียนเรียนซ้ำ = มี RepeatTeacher)
        $data['total_repeat_students'] = $this->db->table('tb_register')
            ->select('StudentID')
            ->where('RegisterYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        // Total repeat registration records in selected year
        // (จำนวนรายการลงทะเบียนเรียนซ้ำทั้งหมด)
        $data['total_repeat_registrations'] = $this->db->table('tb_register')
            ->where('RegisterYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->countAllResults();
        
        // Total teachers handling repeat students
        // (ครูที่รับผิดชอบนักเรียนเรียนซ้ำ)
        $data['total_repeat_teachers'] = $this->db->table('tb_register')
            ->select('RepeatTeacher')
            ->where('RegisterYear', $currentYear)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        return view('admin/Academic/AdminRegisRepeat/AdminRegisRepeatMain', $data);
        
    }

    /**
     * AJAX endpoint to get dashboard statistics for repeat registration
     */
    public function getDashboardStats()
    {
        $year = $this->request->getPost('year') ?? $this->request->getGet('year');
        
        if (empty($year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Year is required']);
        }
        
        // Total subjects with repeat registrations in selected year
        // (วิชาที่มีนักเรียนลงทะเบียนเรียนซ้ำ = มี RepeatTeacher)
        $total_subjects_repeat = $this->db->table('tb_register')
            ->select('SubjectID')
            ->where('RegisterYear', $year)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        // Total students with repeat registrations (distinct) in selected year
        // (นักเรียนที่ลงทะเบียนเรียนซ้ำ = มี RepeatTeacher)
        $total_repeat_students = $this->db->table('tb_register')
            ->select('StudentID')
            ->where('RegisterYear', $year)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        // Total repeat registration records in selected year
        // (จำนวนรายการลงทะเบียนเรียนซ้ำทั้งหมด)
        $total_repeat_registrations = $this->db->table('tb_register')
            ->where('RegisterYear', $year)
            ->where('RepeatTeacher !=', '')
            ->countAllResults();
        
        // Total teachers handling repeat students
        // (ครูที่รับผิดชอบนักเรียนเรียนซ้ำ)
        $total_repeat_teachers = $this->db->table('tb_register')
            ->select('RepeatTeacher')
            ->where('RegisterYear', $year)
            ->where('RepeatTeacher !=', '')
            ->distinct()
            ->countAllResults();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'total_subjects_repeat' => $total_subjects_repeat,
                'total_repeat_students' => $total_repeat_students,
                'total_repeat_registrations' => $total_repeat_registrations,
                'total_repeat_teachers' => $total_repeat_teachers,
                'year' => $year
            ]
        ]);
    }

    public function AdminRegisRepeatDetail($Term,$Year,$IDSubject,$TechID){
        $data['admin'] = $this->DBPers->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ลงทะเบียนเรียนซ้ำนักเรียนรายวิชา";

        $data['Teacher'] = $this->DBPers->table('tb_personnel')
        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
        ->where('pers_learning !=',"")
        ->where('pers_status',"กำลังใช้งาน")
        ->get()->getResult();

        $data['DataRepeat'] = $this->db->table('tb_register')->select("
        tb_students.StudentID,
        tb_students.StudentPrefix,
        tb_students.StudentFirstName,
        tb_students.StudentLastName,
        tb_students.StudentClass,
        tb_students.StudentCode,
        tb_students.StudentNumber,
        tb_students.StudentStatus,
        tb_students.StudentBehavior,       
        tb_subjects.SubjectName,
        tb_subjects.SubjectYear,
        tb_register.SubjectID,
        tb_subjects.SubjectCode,
        tb_register.RegisterYear,
        tb_register.Grade,
        tb_register.RepeatStatus,
        tb_register.Grade_Type,
        tb_register.TeacherID,
        tb_register.RepeatTeacher,
        tb_register.RepeatYear,
        CONCAT(teacher.pers_prefix,teacher.pers_firstname,' ',teacher.pers_lastname) AS TeacherName,
        CONCAT(repeat_teacher.pers_prefix,repeat_teacher.pers_firstname,' ',repeat_teacher.pers_lastname) AS RepeatTeacherName")
        ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
        ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
        ->join($this->DBPers->database . '.tb_personnel AS teacher', 'teacher.pers_id = tb_register.TeacherID','LEFT')
        ->join($this->DBPers->database . '.tb_personnel AS repeat_teacher', 'repeat_teacher.pers_id = tb_register.RepeatTeacher','LEFT')
        ->where('tb_register.RegisterYear',$Term.'/'.$Year)
        ->where('tb_subjects.SubjectYear',$Term.'/'.$Year)
        ->where('tb_subjects.SubjectID',urldecode($IDSubject))
        ->where('tb_register.TeacherID',$TechID)
        ->orderBy('StudentClass','ASC')
        ->orderBy('StudentNumber','ASC')
        ->get()->getResult();

        $data['DataRepeatTeacher'] = $this->db->table('tb_register')->select("       
        tb_register.RepeatTeacher")
        ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
        ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$Year)
        ->where('tb_subjects.SubjectYear',$Term.'/'.$Year)
        ->where('tb_subjects.SubjectID',urldecode($IDSubject))
        ->where('tb_register.RepeatTeacher !=','')
        ->groupBy("RepeatTeacher")
        ->get()->getResult();
        

       //echo '<pre>'; print_r((session()->get('fullname'))); exit();
        return view('admin/Academic/AdminRegisRepeat/AdminRegisRepeatAdd', $data);
    }

    public function AdminRegisRepeatEdit($codeSub,$TeachID){
        $data['title'] = "แก้ไขรายชื่อการลงทะเบียนเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getRow(); // Use getRow() for single result
        $data['teacher'] = $this->DBPers->table('tb_personnel')
                                        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                        ->where('pers_learning !=',"")
                                        ->get()->getResult();
        $data['Register'] = $this->db->table('tb_register')->select("tb_register.RegisterYear,
                                    tb_subjects.SubjectName,
                                    tb_subjects.SubjectID,
                                    tb_register.SubjectID,
                                    tb_register.StudentID,
                                    tb_register.TeacherID,
                                    tb_students.StudentCode,
                                    tb_students.StudentClass,
                                    tb_students.StudentNumber,
                                    tb_students.StudentPrefix,
                                    tb_students.StudentFirstName,
                                    tb_students.StudentLastName   
                                    ")
                                    ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                    ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
                                    //->where('RegisterYear',$CheckYear[0]->schyear_year) 
                                    ->where('TeacherID',$TeachID)
                                    ->where('SubjectID',$codeSub)
                                    ->get()->getResult();

        
      
        $data['classroom'] = new \App\Libraries\Classroom();
        echo view('admin/Academic/AdminRegisRepeat/AdminEnrollFormEdit.php', $data);
    }

    public function AdminRegisRepeatAdd(){

        $CheckRepeat = $this->db->table('tb_register_onoff')->select('onoff_detail,onoff_year')->where('onoff_name','เรียนซ้ำ')->get()->getRow();
             
        $IdStuRepeat = array();
        $CountUpSucceed =0;

         if($this->request->getPost('StuID')){
               $DataUpdateRepeat = array('Grade_Type' => !empty($CheckRepeat->onoff_detail) ? $CheckRepeat->onoff_detail : '','RepeatStatus'=>'ไม่ผ่าน','RepeatYear'=>!empty($CheckRepeat->onoff_year) ? $CheckRepeat->onoff_year : '','RepeatTeacher' => $this->request->getPost('RepeatTeacher'));

               $registerYear = $this->request->getPost('YearRepeat');
               $subjectID = $this->request->getPost('SubjectRepeat');
               $studentID = $this->request->getPost('StuID');

               $updated = $this->db->table('tb_register')
                                    ->where('SubjectID',$subjectID)
                                    ->where('StudentID',$studentID)
                                    ->where('RegisterYear',$registerYear)
                                    ->update($DataUpdateRepeat);
               
               if ($updated) {
                   return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มนักเรียนเรียนซ้ำสำเร็จ', 'affected_rows' => $this->db->affectedRows()]);
               } else {
                   return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถเพิ่มนักเรียนเรียนซ้ำได้', 'affected_rows' => 0]);
               }
        }

        if($this->request->getPost('DelStatus') == "Del"){
            $DataDelete = array('Grade_Type' => "",'RepeatStatus'=>'','RepeatYear'=>"",'RepeatTeacher' => "");                    
            $subjectID = $this->request->getPost('SubjectRepeat');
            $studentID = $this->request->getPost('DelStuID');
            $registerYear = $this->request->getPost('YearRepeat');

            log_message('debug', 'AdminRegisRepeatAdd: Delete parameters - RegisterYear: ' . $registerYear . ', SubjectID: ' . $subjectID . ', StudentID: ' . $studentID . ', DataDelete: ' . print_r($DataDelete, true));

             $updated =  $this->db->table('tb_register')
             ->where('SubjectID',$subjectID)
             ->where('RepeatConfirm',"")
             ->where('StudentID',$studentID)
             ->where('RegisterYear',$registerYear)
             ->update($DataDelete);
            
            if ($updated) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'ถอนข้อมูลนักเรียนเรียนซ้ำสำเร็จ', 'affected_rows' => $this->db->affectedRows()]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถอนข้อมูลนักเรียนเรียนซ้ำได้', 'affected_rows' => 0]);
            }
        }

        return $this->response->setJSON(['status' => 'info', 'message' => 'ไม่มีการดำเนินการ']);
    }

    public function AdminRegisRepeatDel(){

        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregisupdate'))->get()->getRow();

        foreach ($this->request->getPost('to') as $key => $value) {
         $a =  array('StudentID' => $value,
         'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
         'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
         'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
         'TeacherID' => $this->request->getPost('teacherregis')
         );   
             $this->db->table('tb_register')->where($a);
        echo $this->db->table('tb_register')->delete();
        }     
     }

    public function AdminRegisRepeatSelect(){
        $KeyStudyLines = $this->request->getPost('KeyStudyLines');
        $KeyRoom = $this->request->getPost('KeyRoom');
        $subject = [];

        if($KeyStudyLines === "All"){
            $subject = $this->db->table('tb_students')->select('StudentID,StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentClass,StudentStudyLine,
            (SELECT GROUP_CONCAT(DISTINCT StudentStudyLine SEPARATOR "|") 
            FROM tb_students WHERE StudentClass = "ม.'.(!empty($KeyRoom) ? $KeyRoom : '').'" AND StudentStatus="1/ปกติ") AS StudyLines
            ')
                                ->where('StudentClass','ม.'.(!empty($KeyRoom) ? $KeyRoom : ''))
                                ->where('StudentStatus','1/ปกติ')
                                ->orderBy('StudentNumber')
                                ->get()->getResult();
        }else{
            $subject = $this->db->table('tb_students')->select('StudentID,StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentClass,StudentStudyLine,
            (SELECT GROUP_CONCAT(DISTINCT StudentStudyLine SEPARATOR "|") 
            FROM tb_students WHERE StudentClass = "ม.'.(!empty($KeyRoom) ? $KeyRoom : '').'" AND StudentStatus="1/ปกติ") AS StudyLines
            ')
                            ->where('StudentClass','ม.'.(!empty($KeyRoom) ? $KeyRoom : ''))
                            ->where('StudentStudyLine',$KeyStudyLines)
                            ->where('StudentStatus','1/ปกติ')
                            ->orderBy('StudentNumber')
                            ->get()->getResult();
        }
       
        echo json_encode($subject);
        
    }

    public function AdminRegisRepeatShow(){ 
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getRow();
        $data = [];
        $keyYear = $this->request->getVar('keyYear');
        //$subject = $this->db->where('SubjectYear','1/2565')->get('tb_subjects')->result();
       
        $Register = $this->db->table('tb_register')->select("
                                    skjacth_academic.tb_register.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectName,
                                    skjacth_academic.tb_subjects.FirstGroup,
                                    skjacth_academic.tb_register.RegisterClass,
                                    skjacth_academic.tb_register.TeacherID,
                                    skjacth_academic.tb_subjects.SubjectID,
                                    skjacth_academic.tb_subjects.SubjectCode,
                                    skjacth_academic.tb_subjects.SubjectYear,
                                    skjacth_personnel.tb_personnel.pers_firstname,
                                    skjacth_personnel.tb_personnel.pers_prefix,
                                    skjacth_personnel.tb_personnel.pers_lastname,
                                    SUM(CASE WHEN skjacth_academic.tb_register.RepeatStatus = 'ไม่ผ่าน' THEN 1 ELSE 0 END) AS SumRepeat")
                                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                ->join($this->DBPers->database . '.tb_personnel', $this->DBPers->database . '.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID')
                                ->where('tb_register.RegisterYear',$keyYear)
                                ->where('tb_subjects.SubjectYear',$keyYear)
                                ->groupBy('skjacth_academic.tb_register.SubjectID, skjacth_academic.tb_register.TeacherID, skjacth_academic.tb_register.RegisterClass, skjacth_academic.tb_subjects.SubjectName, skjacth_academic.tb_subjects.FirstGroup, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectYear, skjacth_personnel.tb_personnel.pers_firstname, skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_lastname')
                                ->get()->getResult();

        //echo '<pre>'; print_r($Register);   exit();    

        foreach($Register as $record){
            
            $data[] = array( 
                "SubjectYear" => $record->SubjectYear,
                "SubjectCode" => $record->SubjectCode,
                "SubjectName" => $record->SubjectName,
                "FirstGroup" => $record->FirstGroup,
                "SubjectClass" => $record->RegisterClass,
                "SubjectID" => $record->SubjectID,
                "TeacherName" =>  $record->pers_prefix.$record->pers_firstname.' '.$record->pers_lastname,
                "TeacherID" => $record->TeacherID,
                "SumRepeat" => $record->SumRepeat
            );
           
        }   

        $output = array(
            "data" =>  $data
        );

      
      
       echo json_encode($output);
    }

    public function AdminRegisRepeatInsert(){

       $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregis'))->get()->getRow();       
       // print_r($chk_Subject->SubjectCode);
       // print_r($chk_Subject->SubjectYear);
       // print_r($chk_Subject->SubjectClass);
       // print_r($this->request->getPost('teacherregis'));
       // print_r($this->request->getPost('to'));
        
       foreach ($this->request->getPost('to') as $key => $value) {
        $a =  array('StudentID' => $value,
        'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
        'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
        'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
        'TeacherID' => $this->request->getPost('teacherregis')
        );   
        echo $data = $this->db->table('tb_register')->insert($a);
       }     
    }

    public function AdminRegisRepeatUpdate(){

        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID',$this->request->getPost('subjectregisupdate'))->get()->getRow();

        foreach ($this->request->getPost('to') as $key => $value) {
         $a =  array('StudentID' => $value,
         'SubjectCode' => !empty($chk_Subject->SubjectCode) ? $chk_Subject->SubjectCode : null,
         'RegisterYear' => !empty($chk_Subject->SubjectYear) ? $chk_Subject->SubjectYear : null,
         'RegisterClass' => !empty($chk_Subject->SubjectClass) ? $chk_Subject->SubjectClass : null,
         'TeacherID' => $this->request->getPost('teacherregis')
         );   
         echo $data = $this->db->table('tb_register')->insert($a);
        }     
     }

    public function AdminRegisRepeatCancel(){

      
         $a =  array(
         'SubjectCode' => $this->request->getPost('KeySubject'),
         'TeacherID' => $this->request->getPost('KeyTeacher')
         );   
             $this->db->table('tb_register')->where($a);
        echo $this->db->table('tb_register')->delete();
            
     }
}
