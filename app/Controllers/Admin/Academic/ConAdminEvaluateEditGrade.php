<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminSaveScore;

class ConAdminEvaluateEditGrade extends BaseController
{
    protected $modAdminSaveScore;
    protected $DBpersonnel; // Declare DBpersonnel property

    public function __construct()
    {
        $this->modAdminSaveScore = new ModAdminSaveScore();
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

    protected function check_grade($sum) // Changed to protected function
    {
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
    
    public function AdminEvaluateEditGradeMain($Term, $Year)
    {
        $data['admin'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "แสดงผลการเรียน 0 ร";
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['OnOffSaveScore'] = $this->db->table('tb_register_onoff')->where('onoff_id >=', 2)->where('onoff_id <=', 5)->get()->getResult();
        $data['OnOffSaveScoreSystem'] = $this->db->table('tb_register_onoff')->where('onoff_id', 6)->get()->getResult();
        $data['CheckYearRegis'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();

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
                                    ->join('skjacth_academic.tb_subjects', 'skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID')
                                    ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID')
                                    ->where('RegisterYear', $Term . '/' . $Year)
                                    ->groupBy('SubjectCode')
                                    ->get()->getResult();

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminEvaluateEditGrade/AdminEvaluateEditGradeMain', $data);
        
    }

    public function AdminEvaluateEditGradeUpdate($term, $yaer, $subject)
    {
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "บันทึกคะแนนผลการเรียน 0 ร";

        $data['check_student'] = $this->db->table('tb_register')
                                    ->select('
                                        tb_register.SubjectID,
                                        tb_register.RegisterYear,
                                        tb_register.RegisterClass,
                                        tb_register.Score100,
                                        tb_register.TeacherID,
                                        tb_subjects.SubjectCode,
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
                                    ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                    ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
                                    ->where('tb_students.StudentBehavior !=', 'จำหน่าย')
                                    ->where('tb_register.RegisterYear', $term . '/' . $yaer)
                                    ->where('tb_subjects.SubjectYear', $term . '/' . $yaer)
                                    ->where('tb_register.SubjectID', urldecode($subject))
                                    ->orderBy('tb_students.StudentClass', 'ASC')
                                    ->orderBy('tb_students.StudentNumber', 'ASC')
                                    ->get()->getResult();

        $data['Teacher'] = ! empty($data['check_student'][0]->TeacherID) ? 
                            $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_prefix,pers_firstname,pers_lastname')
                                    ->where('pers_id', $data['check_student'][0]->TeacherID)
                                    ->get()->getRow() : null;

        $check_idSubject = $this->db->table('tb_subjects')
                                    ->where('SubjectID', urldecode($subject))
                                    ->where('SubjectYear', $term . '/' . $yaer)
                                    ->get()->getRow();

        $data['set_score'] = ! empty($check_idSubject->SubjectID) ? 
                                $this->db->table('tb_register_score')
                                    ->where('regscore_subjectID', $check_idSubject->SubjectID)
                                    ->get()->getResult() : [];
        $data['onoff_savescore'] = $this->db->table('tb_register_onoff')
                                    ->where('onoff_id >=', 2)
                                    ->where('onoff_id <=', 5)
                                    ->get()->getResult();

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminEvaluateEditGrade/AdminEvaluateEditGrade', $data);
        
    }

    public function insert_score_0W()
    {
        $checkOnOff = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $TimeNum = $this->request->getPost('TimeNum');
        foreach ($this->request->getPost('StudentID') as $num => $value) {
            $study_time = $this->request->getPost('study_time')[$num];

            if ((($TimeNum * 80) / 100) > $study_time) {
                $Grade = "มส";
            } else {
                $studentScores = $this->request->getPost($value);
                if (in_array("ร", $studentScores)) {
                    $Grade = "ร";
                } else {
                    $Grade = $this->check_grade(array_sum($studentScores));
                }
            }

            $key = [
                'StudentID'    => $value,
                'SubjectID'    => $this->request->getPost('SubjectCode'), // Corrected to SubjectCode as per CI3
                'RegisterYear' => $this->request->getPost('RegisterYear'),
            ];

            $checkScore100 = $this->db->table('tb_register')->select('Score100')->where($key)->get()->getRow();

            $currentScore100 = implode("|", $this->request->getPost($value));

            if ((! empty($checkScore100)) && ($checkScore100->Score100 === $currentScore100)) {
                $data = [
                    'Score100'  => $currentScore100,
                    'Grade'     => $Grade,
                    'StudyTime' => $study_time,
                ];
            } else {
                $data = [
                    'Score100'         => $currentScore100,
                    'Grade'            => $Grade,
                    'StudyTime'        => $study_time,
                    'Grade_Type'       => ! empty($checkOnOff[6]->onoff_detail) ? $checkOnOff[6]->onoff_detail : 'แก้ 0 ร',
                    'Grade_UpdateTime' => date('Y-m-d H:i:s'),
                ];
            }

            echo $this->db->table('tb_register')->where($key)->update($data);
        }
    }
}
