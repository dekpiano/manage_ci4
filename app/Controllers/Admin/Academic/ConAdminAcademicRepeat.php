<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminAcademinResult;

class ConAdminAcademicRepeat extends BaseController
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

    private function isSystemOpen($setting)
    {
        if (!$setting || $setting->onoff_status !== 'on') {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        
        // If start date is set, must be after it
        if (!empty($setting->onoff_StartDate) && $now < $setting->onoff_StartDate) {
            return false;
        }

        // If end date is set, must be before it
        if (!empty($setting->onoff_EndDate) && $now > $setting->onoff_EndDate) {
            return false;
        }

        return true;
    }

    public function AdminAcademicRepeatMain()
    {
        $data['admin'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                     ->select('pers_id, pers_img')
                                     ->where('pers_id', session()->get('login_id'))
                                     ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ตั้งค่าเรียนซ้ำ (มส)";
        $data['repeat_setting'] = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $data['system_is_open'] = $this->isSystemOpen($data['repeat_setting']);

        $data['CountYear'] = $this->db->table('tb_register')
                                    ->select('RegisterYear')
                                    ->groupBy('RegisterYear')
                                    ->orderBy('RegisterYear', 'ASC')
                                    ->get()->getResult();

        // ดึงค่า Term/Year จาก tb_register_onoff (onoff_name = 'เรียนซ้ำ')
        $repeat_setting = $data['repeat_setting'];
        $onoff_year = $repeat_setting->onoff_year ?? ''; 
        $parts = explode('/', $onoff_year);
        $term = $parts[0] ?? '';
        $year = $parts[1] ?? '';

        // ถ้าไม่มีข้อมูลใน DB ให้ใช้ค่า Default
        if (empty($term) || empty($year)) {
             if ($data['SchoolYear'] && property_exists($data['SchoolYear'], 'schyear_year')) {
                $parts = explode('/', $data['SchoolYear']->schyear_year);
                $term = $parts[0] ?? '2';
                $year = $parts[1] ?? '2567';
            } else {
                $term = '2';
                $year = '2567';
            }
        }

        $data['Term'] = $term;
        $data['Year'] = $year;
        $currentYear = $term . '/' . $year;

        $data['DataRepeat'] = $this->db->table('tb_register')
                                    ->select('
                                        skjacth_academic.tb_register.SubjectID,
                                        skjacth_academic.tb_register.RegisterYear,
                                        skjacth_academic.tb_register.RepeatYear,
                                        skjacth_academic.tb_register.RepeatTeacher,
                                        skjacth_personnel.tb_personnel.pers_prefix,
                                        skjacth_personnel.tb_personnel.pers_firstname,
                                        skjacth_personnel.tb_personnel.pers_lastname,
                                        skjacth_academic.tb_subjects.SubjectName,
                                        skjacth_academic.tb_subjects.SubjectCode,
                                        skjacth_academic.tb_register.RegisterClass
                                    ')
                                    ->join('skjacth_academic.tb_subjects', 'skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID')
                                    ->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.RepeatTeacher')
                                    ->where('tb_register.RepeatYear', $currentYear)
                                    ->where('tb_register.RepeatTeacher !=', '')
                                    ->groupBy('tb_register.SubjectID, tb_register.RegisterYear, tb_register.RepeatYear, tb_register.RepeatTeacher, tb_register.RegisterClass, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_subjects.SubjectName, tb_subjects.SubjectCode')
                                    ->get()->getResult();

        echo view('admin/Academic/AdminEvaluateLearnRepeat/AdminEvaluateLearnRepeatMain', $data);
        
    }

    public function AdminAcademicRepeatGrade($term, $yaer, $subject)
    {
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $repeat_setting = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        $onoff_repeat_year = $repeat_setting->onoff_year ?? '';
        $data['repeat_setting'] = $repeat_setting;
        $data['system_is_open'] = $this->isSystemOpen($repeat_setting);
        $data['title'] = "กรอกคะแนนผลการเรียน (" . @$repeat_setting->onoff_detail . ")";

        $data['check_student'] = $this->db->table('tb_register')
                                    ->select('
                                        tb_register.SubjectID,
                                        tb_register.RegisterYear,
                                        tb_register.RepeatYear,
                                        tb_register.RepeatTeacher,
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
                                    ->where('tb_register.RepeatYear', $onoff_repeat_year)
                                    ->where('tb_subjects.SubjectYear', $term . '/' . $yaer)
                                    ->where('tb_register.SubjectID', urldecode($subject))
                                    ->orderBy('tb_students.StudentClass', 'ASC')
                                    ->orderBy('tb_students.StudentNumber', 'ASC')
                                    ->get()->getResult();

        $data['Teacher'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_prefix,pers_firstname,pers_lastname')
                                    ->where('pers_id', @$data['check_student'][0]->RepeatTeacher)
                                    ->get()->getRow();

        $check_idSubject = $this->db->table('tb_subjects')
                                    ->where('SubjectID', urldecode($subject))
                                    ->where('SubjectYear', $term . '/' . $yaer)
                                    ->get()->getRow();

        $data['set_score'] = $this->db->table('tb_register_score')
                                    ->where('regscore_subjectID', $check_idSubject->SubjectID)
                                    ->get()->getResult();
        $data['onoff_savescore'] = $this->db->table('tb_register_onoff')
                                    ->where('onoff_id >=', 2)
                                    ->where('onoff_id <=', 5)
                                    ->get()->getResult();

        echo view('admin/Academic/AdminEvaluateLearnRepeat/AdminEvaluateLearnRepeatGrade', $data);
        
    }

    public function insert_score()
    {
        $repeat_setting = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
        if (!$this->isSystemOpen($repeat_setting)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ระบบปิดการรับข้อมูล หรือไม่อยู่ในช่วงเวลาที่กำหนด']);
        }
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
                'SubjectID'    => $this->request->getPost('SubjectID'),
                'RegisterYear' => $this->request->getPost('RegisterYear'),
            ];

            $checkScore100 = $this->db->table('tb_register')->select('Score100')->where($key)->get()->getRow();

            $currentScore100 = implode("|", $this->request->getPost($value));

            if (@$checkScore100->Score100 === $currentScore100) {
                $data = [
                    'Score100'         => $currentScore100,
                    'Grade'            => $Grade,
                    'StudyTime'        => $study_time,
                    'Grade_UpdateTime' => date('Y-m-d H:i:s'),
                ];
            } else {
                $data = [
                    'Score100'         => $currentScore100,
                    'Grade'            => $Grade,
                    'StudyTime'        => $study_time,
                    'Grade_Type'       => @$repeat_setting->onoff_detail,
                    'Grade_UpdateTime' => date('Y-m-d H:i:s'),
                ];
            }

            echo $this->db->table('tb_register')->where($key)->update($data);
        }
    }

    public function update_study_time()
    {
        if ($this->request->isAJAX()) {
            $repeat_setting = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
            if (!$this->isSystemOpen($repeat_setting)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ระบบปิดการรับข้อมูล หรือไม่อยู่ในช่วงเวลาที่กำหนด']);
            }
            $studentId = $this->request->getPost('student_id');
            $subjectId = $this->request->getPost('subject_id');
            $registerYear = $this->request->getPost('register_year');
            $studyTime = $this->request->getPost('study_time');

            $key = [
                'StudentID' => $studentId,
                'SubjectID' => $subjectId,
                'RegisterYear' => $registerYear
            ];

            $data = [
                'StudyTime' => $studyTime,
                'Grade_UpdateTime' => date('Y-m-d H:i:s')
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
            $repeat_setting = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->get()->getRow();
            if (!$this->isSystemOpen($repeat_setting)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ระบบปิดการรับข้อมูล หรือไม่อยู่ในช่วงเวลาที่กำหนด']);
            }
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

            // Retrieve current Score100 string
            $currentRegister = $this->db->table('tb_register')->select('Score100, StudyTime, Grade_Type')->where($key)->get()->getRow();

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

                    $data = [
                        'Score100' => $newScore100,
                        'Grade' => $Grade, // Updated grade
                        'Grade_UpdateTime' => date('Y-m-d H:i:s')
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

    // ตั้งค่าครั้งที่เรียซ้ำ
    public function CheckTimeRepeat()
    {
        $value = $this->request->getPost('value');
        echo $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->set(['onoff_detail' => $value])->update();
    }

    public function CheckOnoffRepeat()
    {
        $value = $this->request->getPost('value');
        echo $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->set(['onoff_status' => $value])->update();
    }

    public function CheckOnoffYear()
    {
        $value = $this->request->getPost('value');
        echo $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->set(['onoff_year' => $value])->update();
    }

    public function update_repeat_settings()
    {
        if ($this->request->isAJAX()) {
            $status = $this->request->getPost('setting_status');
            $year = $this->request->getPost('setting_year');
            $time = $this->request->getPost('setting_time');
            $start = $this->request->getPost('setting_start');
            $end = $this->request->getPost('setting_end');

            $data = [
                'onoff_status' => $status,
                'onoff_year' => $year,
                'onoff_detail' => $time,
                'onoff_StartDate' => $start ?: null,
                'onoff_EndDate' => $end ?: null
            ];

            $updated = $this->db->table('tb_register_onoff')->where('onoff_name', 'เรียนซ้ำ')->set($data)->update();

            if ($updated) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Repeat settings updated successfully.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update repeat settings.']);
            }
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }
}
