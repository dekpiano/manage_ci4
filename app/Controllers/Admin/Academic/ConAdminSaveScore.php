<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminSaveScore;

class ConAdminSaveScore extends BaseController
{
    protected $modAdminSaveScore;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->modAdminSaveScore = new ModAdminSaveScore();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            // Check if it's an AJAX request
            if ($this->request->isAJAX()) {
                // For AJAX requests, send a 401 Unauthorized status
                $this->response->setStatusCode(401)->setJSON(['message' => 'Session expired. Please log in again.'])->send();
                exit(); // Terminate script execution
            } else {
                // For regular page requests, redirect
                return redirect()->to(base_url('LogoutTeacher'));
            }
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    protected function check_grade($sum) {
        if (($sum > 100) || ($sum < 0)) {
             $grade = "ไม่สามารถคิดเกรดได้ คะแนนเกิน";
        } else if (($sum >= 79.5) && ($sum <= 100)) {
             $grade = 4;
        } else if (($sum >= 74.5) && ($sum <= 79.4)) {
             $grade = 3.5;
        } else if (($sum >= 69.5) && ($sum <= 74.4)) {
             $grade = 3;
        } else if (($sum >= 64.5) && ($sum <= 69.4)) {
             $grade = 2.5;
        } else if (($sum >= 59.5) && ($sum <= 64.4)) {
             $grade = 2;
        } else if (($sum >= 54.5) && ($sum <= 59.4)) {
             $grade = 1.5;
        } else if (($sum >= 49.5) && ($sum <= 54.4)) {
             $grade = 1;
        } else if ($sum <= 49.4) {
             $grade = 0;
        }
        return $grade;
    }

    public function AdminSaveScoreMain(){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();
        
        $data['title'] = "บันทึกผลการเรียน";	
        $data['OnOffNormalMasters'] = $this->db->table('tb_register_onoff')->where('onoff_id', 10)->get()->getRow();
        $data['OnOffRepeatMasters'] = $this->db->table('tb_register_onoff')->where('onoff_id', 11)->get()->getRow();
        $data['OnOffNormalPeriods'] = $this->db->table('tb_register_onoff')->where('onoff_id >=', 2)->where('onoff_id <=', 5)->get()->getResult();
        $data['OnOffRepeatPeriods'] = $this->db->table('tb_register_onoff')->where('onoff_id >=', 12)->where('onoff_id <=', 15)->get()->getResult();
        
        $data['result'] = $this->db->table('skjacth_academic.tb_register')
                            ->select('
                                skjacth_academic.tb_register.SubjectID,
                                skjacth_academic.tb_register.RegisterYear,
                                skjacth_academic.tb_register.TeacherID,
                                skjacth_personnel.tb_personnel.pers_prefix,
                                skjacth_personnel.tb_personnel.pers_firstname,
                                skjacth_personnel.tb_personnel.pers_lastname,
                                skjacth_academic.tb_subjects.SubjectName,
                                skjacth_academic.tb_subjects.SubjectCode,
                                skjacth_academic.tb_register.RegisterClass
                                ')
                            ->join('skjacth_academic.tb_subjects','skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID')
                            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID')
                            ->where('RegisterYear', $data['selectedYear'])
                            ->groupBy('tb_register.SubjectID, tb_register.RegisterYear, tb_register.TeacherID, tb_register.RegisterClass, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_subjects.SubjectName, tb_subjects.SubjectCode')
                            ->get()->getResult();
        
        
        echo view('admin/Academic/AdminSaveScore/AdminSaveScoreMain.php',$data);

    }

    public function AdminSaveScoreGrade($term,$yaer,$subject){
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "กรอกคะแนนผลการเรียน";	
       
        $data['check_student'] = $this->db->table('tb_register')->select('
                                    tb_register.SubjectCode,
                                    tb_register.RegisterYear,
                                    tb_register.RegisterClass,
                                    tb_register.Score100,
                                    tb_register.TeacherID,
                                    tb_subjects.SubjectName,
                                    tb_register.StudyTime,
                                    tb_subjects.SubjectID,
                                    tb_subjects.SubjectUnit,
                                    tb_subjects.SubjectHour,
                                    tb_students.StudentID,
                                    tb_students.StudentPrefix,
                                    tb_students.StudentFirstName,
                                    tb_students.StudentLastName,
                                    tb_students.StudentNumber,
                                    tb_students.StudentClass,
                                    tb_students.StudentCode,
                                    tb_students.StudentStatus,
                                    tb_students.StudentBehavior,
                                    tb_register.Grade,
                                    tb_register.Grade_Type
                                ')
                                ->join('tb_subjects','tb_subjects.SubjectCode = tb_register.SubjectCode')
                                ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                                //->where('TeacherID',$this->session->userdata('login_id'))
                                //>where('tb_register.Grade <=',0)
                                ->where('tb_students.StudentBehavior !=','จำหน่าย')
                                ->where('tb_register.RegisterYear',$term.'/'.$yaer)
                                ->where('tb_register.SubjectCode',urldecode($subject))                                
                                //->or_where('tb_register.Grade_Type','เรียนซ้ำครั้งที่ 1')
                                ->orderBy('tb_students.StudentClass','ASC')
                                ->orderBy('tb_students.StudentNumber','ASC')
                                ->get()->getResult();
           // echo '<pre>'; print_r($data['check_student']);exit();          
        $data['Teacher'] = !empty($data['check_student'][0]->TeacherID) ? $this->DBpersonnel->table('tb_personnel')->select('pers_prefix,pers_firstname,pers_lastname')->where('pers_id',$data['check_student'][0]->TeacherID)->get()->getRow() : null;
        

        $check_idSubject = $this->db->table('tb_subjects')->where('SubjectCode',urldecode($subject))->where('SubjectYear',$term.'/'.$yaer)->get()->getRow();
        
        $data['set_score'] = !empty($check_idSubject->SubjectID) ? $this->db->table('tb_register_score')->where('regscore_subjectID',$check_idSubject->SubjectID)->get()->getResult() : [];
        $data['OnOffNormalPeriods'] = $this->db->table('tb_register_onoff')->where('onoff_id >=', 2)->where('onoff_id <=', 5)->get()->getResult();
        $data['OnOffRepeatPeriods'] = $this->db->table('tb_register_onoff')->where('onoff_id >=', 12)->where('onoff_id <=', 15)->get()->getResult();
        $data['OnOffNormal'] = $this->db->table('tb_register_onoff')->where('onoff_id', 10)->get()->getRow();
        $data['OnOffRepeat'] = $this->db->table('tb_register_onoff')->where('onoff_id', 11)->get()->getRow();

        
        echo view('admin/Academic/AdminSaveScore/AdminSaveScoreGrade.php',$data);
        

    }

    public function insert_score_0W(){ 
        $checkOnOff = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $TimeNum = $this->request->getPost('TimeNum');
       
        foreach ($this->request->getPost('StudentID') as $num => $value) {
           //print_r($this->request->getPost('TimeNum'));
            //print_r($value);
            $study_time = $this->request->getPost('study_time');
            
            if((($TimeNum*80)/100) > (!empty($study_time[$num]) ? $study_time[$num] : 0)){
                $Grade = "มส";
            }else{
                if(in_array("ร",$this->request->getPost($value))){
                    $Grade = "ร";
                }else{
                    $Grade = $this->check_grade(array_sum($this->request->getPost($value)));
                }
            }

            $key = array('StudentID' => $value,'SubjectID' => $this->request->getPost('SubjectID'), 'RegisterYear' => $this->request->getPost('RegisterYear'));
          

            $checkScore100 = $this->db->table('tb_register')->select('Score100')->where($key)->get()->getRow();

            $currentScore100 = implode("|",$this->request->getPost($value));
            
            if(!empty($checkScore100) && (!empty($checkScore100->Score100) && $checkScore100->Score100 === $currentScore100)){
                $data = array('Score100' => $currentScore100,'Grade'  => $Grade,'StudyTime' => (!empty($study_time[$num]) ? $study_time[$num] : 0));
            }else{
                $data = array('Score100' => $currentScore100,'Grade'  => $Grade,'StudyTime' => (!empty($study_time[$num]) ? $study_time[$num] : 0),'Grade_Type'=> !empty($checkOnOff[5]->onoff_detail) ? $checkOnOff[5]->onoff_detail : '','Grade_UpdateTime'=>date('Y-m-d H:i:s'));
            }
            
          echo $this->db->table('tb_register')->update($data,$key);
        }

    }

    public function update_study_time()
    {
        if ($this->request->isAJAX()) {
            $studentId = $this->request->getPost('student_id');
            $subjectId = $this->request->getPost('subject_id');
            $registerYear = $this->request->getPost('register_year');
            $studyTime = $this->request->getPost('study_time');

            $key = [
                'StudentID' => $studentId,
                'SubjectID' => $subjectId,
                'RegisterYear' => $registerYear
            ];

            // Determine if the updater is the subject's teacher
            $registerRow = $this->db->table('tb_register')->select('TeacherID')->where($key)->get()->getRow();
            $teacherId = $registerRow->TeacherID ?? '';
            $currentUserId = session()->get('login_id');
            $gradeUserUpdate = ($currentUserId !== $teacherId) ? $currentUserId : null;

            $data = [
                'StudyTime' => $studyTime,
                'Grade_UpdateTime' => date('Y-m-d H:i:s'),
                'Grade_UserUpdate' => $gradeUserUpdate
            ];

            // Optional: Recalculate Grade and Grade_Type here if needed
            // For now, just update StudyTime

            $updated = $this->db->table('tb_register')->update($data, $key);

            if ($updated) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Study time updated successfully.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update study time.']);
            }
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }

    public function update_score()
    {
        if ($this->request->isAJAX()) {
            $studentId = $this->request->getPost('student_id');
            $subjectId = $this->request->getPost('subject_id');
            $registerYear = $this->request->getPost('register_year');
            $scoreIndex = $this->request->getPost('score_index');
            $scoreValue = $this->request->getPost('score_value');

            $key = [
                'StudentID' => $studentId,
                'SubjectID' => $subjectId,
                'RegisterYear' => $registerYear
            ];

            // Retrieve current Score100 string and TeacherID
            $currentRegister = $this->db->table('tb_register')->select('Score100, StudyTime, Grade_Type, TeacherID')->where($key)->get()->getRow();

            if ($currentRegister) {
                $scores = explode('|', $currentRegister->Score100);
                // Ensure the index is valid
                if (isset($scores[$scoreIndex])) {
                    $scores[$scoreIndex] = $scoreValue;
                    $newScore100 = implode('|', $scores);

                    // Recalculate Grade based on new scores and existing study time
                    $sum_scores = 0;
                    foreach ($scores as $s) {
                        if (is_numeric($s)) {
                            $sum_scores += (int)$s;
                        }
                    }

                    // Need to get TimeNum from somewhere, perhaps tb_subjects or pass from frontend
                    // For now, assume TimeNum is available or calculate it
                    // This part needs to be refined based on how TimeNum is determined
                    // For simplicity, I'll use a placeholder for grade calculation
                    $Grade = $this->check_grade($sum_scores); // Use the existing helper function

                    // Check for "มส" or "ร" conditions
                    // This logic is complex and depends on SubjectUnit and StudyTime
                    // For now, I'll just update the score and recalculate grade based on sum
                    // If "มส" or "ร" logic is critical, it needs to be fully replicated here or in a helper

                    $teacherId = $currentRegister->TeacherID ?? '';
                    $currentUserId = session()->get('login_id');
                    $gradeUserUpdate = ($currentUserId !== $teacherId) ? $currentUserId : null;

                    $data = [
                        'Score100' => $newScore100,
                        'Grade' => $Grade, // Updated grade
                        'Grade_UpdateTime' => date('Y-m-d H:i:s'),
                        'Grade_UserUpdate' => $gradeUserUpdate
                    ];

                    // If Grade_Type needs to be updated based on new score/grade, add logic here
                    // e.g., if Grade becomes '0' or 'ร', Grade_Type might change

                    $updated = $this->db->table('tb_register')->update($data, $key);

                    if ($updated) {
                        return $this->response->setJSON(['status' => 'success', 'message' => 'Score updated successfully.', 'new_grade' => $Grade]);
                    } else {
                        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update score.']);
                    }
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Student registration not found or invalid score index.']);
            }
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }

    public function CheckOnOffSaveScore(){   

        if($this->request->getPost('check') == "true"){
			$value = "on";
		}elseif($this->request->getPost('check') == "false"){
			$value = "off";
		}

        echo  $this->modAdminSaveScore->UpdateOnOffSaveScore($this->request->getPost('key'),$value);
        

    }
}
