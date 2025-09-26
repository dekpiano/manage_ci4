<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Controllers\Admin\Academic\ConAdminStudents;
use App\Libraries\Classroom;
use App\Models\Admin\ModAdminAcademinResult; // Assuming ModAdminAcademinResult is used here

class ConAdminEnroll extends BaseController
{
    protected $modAdminAcademinResult;
    protected $DBPers;
    protected $db;

    public function __construct()
    {
        $this->modAdminAcademinResult = new ModAdminAcademinResult();

        // CI3 session check equivalent
        // Initialize database connections first
        $this->DBPers = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Default database

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            // For AJAX requests, return a JSON error
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
            }
            return redirect()->to(base_url('LoginAdmin'));
        }

    $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager"]))) {
            // For AJAX requests, return a JSON error
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Forbidden']);
            }
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function AdminEnrollMain()
    {
        $data['admin'] = $this->DBPers->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ลงทะเบียนเรียน";

        $data['GroupYear'] = $this->db->table('tb_subjects')
                                    ->select('SubjectYear')
                                    ->groupBy('SubjectYear')
                                    ->orderBy('SubjectYear', 'ASC')
                                    ->get()->getResult();

        echo view('admin/Academic/AdminEnroll/AdminEnrollMain', $data);
        
    }

    public function AdminEnrollAdd($Term, $Year)
    {
        $data['title'] = "เพิ่มรายชื่อการลงทะเบียนเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
    $CheckYear = $this->db->table('tb_schoolyear')->get()->getResult();
    $data['teacher'] = $this->DBPers->table('tb_personnel')
                    ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                    ->where('pers_learning !=', "")
                    ->get()->getResult();
        $data['subject'] = $this->db->table('tb_subjects')->where('SubjectYear', $Term . '/' . $Year)->get()->getResult();
    $data['classroom'] = new Classroom(); // Instantiate Classroom library
        
        echo view('admin/Academic/AdminEnroll/AdminEnrollFormAdd', $data);
        
    }

    public function AdminEnrollEdit($codeSub, $TeachID)
    {
        $data['title'] = "แก้ไขรายชื่อการลงทะเบียนเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getResult();
        $data['teacher'] = $this->DBPers->table('tb_personnel') // Use the class property
                                        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                        ->where('pers_learning !=', "")
                                        ->get()->getResult();
        $data['CheckYearSubject'] = $this->db->table('tb_subjects')->select('SubjectYear')->where('SubjectID', $codeSub)->get()->getResult();

    $data['Register'] = $this->db->table("tb_register")
                    ->select("tb_register.RegisterYear,
                        tb_subjects.SubjectName,
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
                    ->where('TeacherID', $TeachID)
                    ->where('tb_subjects.SubjectID', $codeSub)
                    ->get()->getResult();
    $data['enrolledStudents'] = $data['Register']; // Pass the registered students to the view
    $data['classroom'] = new Classroom(); // Instantiate Classroom library
    return view('admin/Academic/AdminEnroll/AdminEnrollFormEdit', $data);
    }

    public function AdminEnrollDelete($codeSub, $TeachID)
    {
        $data['title'] = "ถอนรายชื่อการลงทะเบียนเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getResult();
        $data['teacher'] = $this->DBPers->table('tb_personnel') // Use the class property
                                        ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                        ->where('pers_learning !=', "")
                                        ->get()->getResult();

        $data['CheckYearSubject'] = $this->db->table('tb_subjects')->select('SubjectYear')->where('SubjectID', $codeSub)->get()->getResult();

        $registerYear = !empty($data['CheckYearSubject'][0]->SubjectYear) ? $data['CheckYearSubject'][0]->SubjectYear : null;

    $data['Register'] = $this->db->table("tb_register")
                    ->select("tb_register.RegisterYear,
                        tb_subjects.SubjectName,
                        tb_subjects.SubjectID,
                        tb_subjects.SubjectCode,
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
                    ->where('tb_register.RegisterYear', $registerYear)
                    ->where('tb_subjects.SubjectID', $codeSub)
                    ->get()->getResult();
    $data['classroom'] = new Classroom(); // Instantiate Classroom library
    return view('admin/Academic/AdminEnroll/AdminEnrollFormDelete', $data);
        
    }

    public function AdminEnrollSelect()
    {
        $keyRoom = $this->request->getPost('KeyRoom');

        if (empty($keyRoom)) {
            return $this->response->setJSON([]); // Return empty array if KeyRoom is not provided
        }

        $subject = $this->db->table('tb_students')
                            ->select('StudentID,StudentNumber,StudentCode,StudentPrefix,StudentFirstName,StudentLastName,StudentClass')
                            ->where('StudentClass', 'ม.'.$keyRoom)
                            ->where('StudentStatus', '1/ปกติ')
                            ->orderBy('StudentNumber')
                            ->get()->getResult();

        return $this->response->setJSON($subject);
    }

    public function AdminEnrollShow()
    {
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getResult();
        $Register = $this->db->table("tb_register")
                                    ->select("tb_register.RegisterYear,
                                            tb_subjects.SubjectName,
                                            tb_subjects.SubjectID,
                                            tb_subjects.SubjectCode,
                                            tb_register.SubjectID,
                                            tb_register.StudentID,
                                            tb_register.TeacherID,
                                            tb_students.StudentCode,
                                            tb_students.StudentClass,
                                            tb_students.StudentNumber,
                                            tb_students.StudentPrefix,
                                            tb_students.StudentFirstName,
                                            tb_students.StudentLastName,
                                            skjacth_personnel.tb_personnel.pers_firstname,
                                            skjacth_personnel.tb_personnel.pers_prefix,
                                            skjacth_personnel.tb_personnel.pers_lastname   
                                            ")
                                    ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                    ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
                                    ->join($this->DBPers->database . '.tb_personnel', $this->DBPers->database . '.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID') // Use the class property for DBPers
                                    ->where('RegisterYear', $this->request->getPost('yearid'))
                                    ->where('TeacherID', $this->request->getPost('teachid'))
                                    ->where('tb_subjects.SubjectID', $this->request->getPost('subid'))
                                    ->orderBy('StudentClass')
                                    ->orderBy('StudentNumber')
                                    ->get()->getResult();

        return $this->response->setJSON($Register);
    }

    public function AdminEnrollInsert()
    {
        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID', $this->request->getPost('subjectregis'))->get()->getRow(); // Use getRow()

        if (empty($chk_Subject)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบวิชา']);
        }

        foreach ($this->request->getPost('to') as $key => $value) {
            $a = [
                'StudentID'    => $value,
                'SubjectID'    => $chk_Subject->SubjectID,
                'RegisterYear' => $chk_Subject->SubjectYear,
                'RegisterClass' => $chk_Subject->SubjectClass,
                'TeacherID'    => $this->request->getPost('teacherregis'),
            ];
            echo $this->db->table('tb_register')->insert($a);
        }
    }

    public function AdminEnrollUpdate()
    {
        $subjectID = $this->request->getPost('subjectregisupdate');
        $registerYear = $this->request->getPost('SubjectYearregisupdate');
        $teacherID = $this->request->getPost('teacherregis');
        $newStudentIDs = $this->request->getPost('to');

        // Validate required data
        if (empty($subjectID) || empty($registerYear) || empty($teacherID)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วนสำหรับการอัปเดต']);
        }

        // If no students are selected to be added, do nothing.
        if (empty($newStudentIDs) || !is_array($newStudentIDs)) {
            return $this->response->setJSON(['status' => 'info', 'message' => 'กรุณาเลือกนักเรียนที่ต้องการลงทะเบียน']);
        }

        $subjectDetails = $this->db->table('tb_subjects')->select('SubjectClass, SubjectName')->where('SubjectID', $subjectID)->get()->getRow();
        if (!$subjectDetails) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลวิชา']);
        }
        $registerClass = $subjectDetails->SubjectClass;
        $subjectName = $subjectDetails->SubjectName;

        $insertedStudentNames = [];
        $alreadyRegisteredStudentNames = [];

        foreach ($newStudentIDs as $studentID) {
            // Check if the student is already registered for this subject in this year.
            $existing = $this->db->table('tb_register')
                                 ->where('StudentID', $studentID)
                                 ->where('SubjectID', $subjectID)
                                 ->where('RegisterYear', $registerYear)
                                 ->countAllResults() > 0;

            if ($existing) {
                // Already registered. Get full name for the message.
                $studentInfo = $this->db->table('tb_students')->select('StudentPrefix, StudentFirstName, StudentLastName')->where('StudentID', $studentID)->get()->getRow();
                if ($studentInfo) {
                    $fullName = $studentInfo->StudentPrefix . $studentInfo->StudentFirstName . ' ' . $studentInfo->StudentLastName;
                    $alreadyRegisteredStudentNames[] = $fullName;
                }
            } else {
                // Not registered, so insert.
                $dataToInsert = [
                    'StudentID'     => $studentID,
                    'SubjectID'     => $subjectID,
                    'RegisterYear'  => $registerYear,
                    'TeacherID'     => $teacherID,
                    'RegisterClass' => $registerClass,
                ];
                $this->db->table('tb_register')->insert($dataToInsert);
                if ($this->db->affectedRows() > 0) {
                    $studentInfo = $this->db->table('tb_students')->select('StudentPrefix, StudentFirstName, StudentLastName')->where('StudentID', $studentID)->get()->getRow();
                    if ($studentInfo) {
                        $fullName = $studentInfo->StudentPrefix . $studentInfo->StudentFirstName . ' ' . $studentInfo->StudentLastName;
                        $insertedStudentNames[] = $fullName;
                    }
                }
            }
        }

        $status = 'info';
        $title = 'ไม่มีการเปลี่ยนแปลง';

        if (!empty($insertedStudentNames) && !empty($alreadyRegisteredStudentNames)) {
            $status = 'success';
            $title = 'อัปเดตการลงทะเบียนสำเร็จ';
        } elseif (!empty($insertedStudentNames)) {
            $status = 'success';
            $title = 'เพิ่มนักเรียนเรียบร้อยแล้ว';
        } elseif (!empty($alreadyRegisteredStudentNames)) {
            $status = 'warning';
            $title = 'นักเรียนบางคนลงทะเบียนแล้ว';
        }
        
        if (count($newStudentIDs) === count($alreadyRegisteredStudentNames) && empty($insertedStudentNames)) {
            $title = 'นักเรียนที่เลือกทั้งหมดได้ลงทะเบียนแล้ว';
        }

        return $this->response->setJSON([
            'status' => $status,
            'title' => $title,
            'inserted' => $insertedStudentNames,
            'duplicates' => $alreadyRegisteredStudentNames
        ]);
    }

    public function AdminEnrollDel()
    {
        $chk_Subject = $this->db->table('tb_subjects')->where('SubjectID', $this->request->getPost('subjectregisupdate'))->get()->getRow(); // Use getRow()

        if (empty($chk_Subject)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบวิชาที่จะลบ']);
        }

        foreach ($this->request->getPost('to') as $key => $value) {
            $a = [
                'StudentID'    => $value,
                'SubjectID'    => $chk_Subject->SubjectID,
                'RegisterYear' => $chk_Subject->SubjectYear,
                'RegisterClass' => $chk_Subject->SubjectClass,
                'TeacherID'    => $this->request->getPost('teacherregis'),
            ];
            $this->db->table('tb_register')->where($a)->delete();
            echo $this->db->affectedRows(); // Assuming affectedRows() is what was intended by echo
        }
    }

    public function AdminEnrollSubject()
    {
        $CheckYear = $this->db->table('tb_schoolyear')->get()->getResult();
        $data = [];
        $keyYear = $this->request->getPost('keyYear');

        $Register = $this->db->table("tb_register")
                                ->select("skjacth_academic.tb_register.SubjectID,
                                        skjacth_academic.tb_subjects.SubjectCode,
                                        skjacth_academic.tb_subjects.SubjectName,
                                        skjacth_academic.tb_subjects.FirstGroup,
                                        skjacth_academic.tb_register.RegisterClass,
                                        skjacth_academic.tb_register.TeacherID,
                                        skjacth_academic.tb_subjects.SubjectID,
                                        skjacth_academic.tb_subjects.SubjectYear,
                                        skjacth_personnel.tb_personnel.pers_firstname,
                                        skjacth_personnel.tb_personnel.pers_prefix,
                                        skjacth_personnel.tb_personnel.pers_lastname")
                                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                ->join($this->DBPers->database . '.tb_personnel', $this->DBPers->database . '.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID') // Use the class property for DBPers
                                ->where('tb_subjects.SubjectYear', $keyYear)
                                ->where('tb_register.RegisterYear', $keyYear)
                                ->groupBy('tb_register.SubjectID')
                                ->groupBy('tb_register.RegisterClass')
                                ->groupBy('tb_register.TeacherID')
                                ->get()->getResult();

        foreach ($Register as $record) {
            $data[] = [
                "SubjectYear"  => $record->SubjectYear,
                "SubjectCode"  => $record->SubjectCode,
                "SubjectName"  => $record->SubjectName,
                "FirstGroup"   => $record->FirstGroup,
                "SubjectClass" => $record->RegisterClass,
                "SubjectID"    => $record->SubjectID,
                "TeacherName"  => $record->pers_prefix . $record->pers_firstname . ' ' . $record->pers_lastname,
                "TeacherID"    => $record->TeacherID,
            ];
        }

        $output = [
            "data" => $data,
        ];

        return $this->response->setJSON($output);
    }

    public function AdminEnrollCancel()
    {
        $a = [
            'SubjectID' => $this->request->getPost('KeySubject'),
            'TeacherID' => $this->request->getPost('KeyTeacher'),
        ];
        $result = $this->db->table('tb_register')->where($a)->delete();
        return $this->response->setJSON($result); // Return JSON response
    }

    public function AdminEnrollChangeTeacher()
    {
        // This is a POST request, so we can validate it.
        if ($this->request->getMethod() === 'post') {
            $data = ['TeacherID' => $this->request->getPost('KeyTeacher')];
            $this->db->table('tb_register')
                    ->where('SubjectID', $this->request->getPost('KeySubjectID'))
                    ->where('RegisterYear', $this->request->getPost('KeySubjectYear'))
                    ->update($data);

            $response = [
                'status'        => 'success',
                'affected_rows' => $this->db->affectedRows(),
                'csrf_hash'     => csrf_hash() // Return new hash for the next request
            ];
            return $this->response->setJSON($response);
        }
        // If it's not a POST request, return an error. This handles the GET case.
        return $this->response->setStatusCode(405, 'Method Not Allowed');
    }

    public function AdminEnrollChangeSubjectToTeacher()
    {
        $Ex = explode("/", $this->request->getPost('KeySelectYearRegister'));

        $CheckIdSubject = $this->db->table('tb_subjects')
                                ->select('SubjectCode')
                                ->where('SubjectID', $this->request->getPost('Keysubjectregis'))
                                ->get()->getRow(); // Use getRow()

        if (empty($CheckIdSubject)) {
            return $this->response->setJSON(null); // Subject not found
        }

        $TacherId = $this->db->table('tb_send_plan')
                            ->select('seplan_usersend')
                            ->where('seplan_coursecode', $CheckIdSubject->SubjectCode)
                            ->where('seplan_year', !empty($Ex[1]) ? $Ex[1] : null)
                            ->where('seplan_term', !empty($Ex[0]) ? $Ex[0] : null)
                            ->get()->getRow(); // Use getRow()

        $teacherId = !empty($TacherId) ? $TacherId->seplan_usersend : null;
        return $this->response->setJSON(['teacherId' => $teacherId]);
    }
}


