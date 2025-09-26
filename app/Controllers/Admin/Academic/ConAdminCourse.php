<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminCourse extends BaseController
{
    protected $DBpersonnel; // Declare DBpersonnel property

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        helper('filesystem'); // Load filesystem helper

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

    public function SendPlanMain()
    {
        $data['title'] = "ข้อมูลการส่งแผน";

        $data['Teacher'] = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                    ->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname')
                                    ->where('pers_status', 'กำลังใช้งาน')
                                    ->groupStart()
                                        ->where('pers_position', 'posi_003')
                                        ->orWhere('pers_position', 'posi_004')
                                        ->orWhere('pers_position', 'posi_005')
                                        ->orWhere('pers_position', 'posi_006')
                                    ->groupEnd()
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CheckYearSendPlan'] = $this->db->table('tb_send_plan')
                                            ->select('seplan_year,seplan_term')
                                            ->groupBy('seplan_year,seplan_term')
                                            ->get()->getResult();
        $data['CheckYear'] = $this->db->table('tb_send_plan_setup')->get()->getResult();

        if ($this->request->getGet('onoff_year')) {
            $SubYear = explode('/', $this->request->getGet('onoff_year'));
            $data['year'] = $SubYear[1];
            $data['term'] = $SubYear[0];
        } else {
            $data['year'] = ! empty($data['CheckYear'][0]->seplanset_year) ? $data['CheckYear'][0]->seplanset_year : null;
            $data['term'] = ! empty($data['CheckYear'][0]->seplanset_term) ? $data['CheckYear'][0]->seplanset_term : null;
        }

        $data['Subject'] = $this->db->table('tb_subjects')
                                    ->where('SubjectYear', $data['term'] . '/' . $data['year'])
                                    ->get()->getResult();

        $data['Plan'] = $this->db->table('skjacth_academic.tb_send_plan')
                                ->select('skjacth_personnel.tb_personnel.pers_id,
                                        skjacth_personnel.tb_personnel.pers_prefix,
                                        skjacth_personnel.tb_personnel.pers_firstname,
                                        skjacth_personnel.tb_personnel.pers_lastname,
                                        skjacth_personnel.tb_personnel.pers_learning,
                                        skjacth_academic.tb_send_plan.*')
                                ->join('skjacth_personnel.tb_personnel', 'skjacth_academic.tb_send_plan.seplan_usersend = skjacth_personnel.tb_personnel.pers_id', 'LEFT')
                                ->where('seplan_year', $data['year'])
                                ->where('seplan_term', $data['term'])
                                ->groupBy('seplan_coursecode,pers_id')->get()->getResult();

        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminSendPlan/AdminSendPlanTeacher', $data);
        
    }

    public function UpdateSendPlanTeacher()
    {
        $CheckSubject = $this->db->table('tb_subjects')
                                ->where('SubjectID', $this->request->getPost('SelectSubject'))
                                ->get()->getRow(); // Use getRow() for single result

        if (empty($CheckSubject)) {
            echo 0; // Subject not found
            return;
        }

        $SubYear = explode('/', $CheckSubject->SubjectYear);
        $Checkplan = $this->db->table('tb_send_plan')
                            ->where('seplan_coursecode', $CheckSubject->SubjectCode)
                            ->where('seplan_usersend', $this->request->getPost('SelectTeacher'))
                            ->where('seplan_year', $SubYear[1])
                            ->where('seplan_term', $SubYear[0])
                            ->countAllResults();

        if ($Checkplan <= 0) {
            $CheckTeacher = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                        ->select('pers_learning')
                                        ->where('pers_id', $this->request->getPost('SelectTeacher'))
                                        ->get()->getRow(); // Use getRow() for single result
            
            if (empty($CheckTeacher)) {
                echo 0; // Teacher not found
                return;
            }

            $status = $this->request->getPost('seplan_sendcomment');
            $textToStore = nl2br(esc($status));

            $typePlan = ['บันทึกตรวจใช้แผน', 'แบบตรวจแผนการจัดการเรียนรู้', 'โครงการสอน', 'แผนการสอนหน้าเดียว', 'แผนการสอนเต็ม', 'บันทึกหลังสอน'];

            foreach ($typePlan as $v_typePlan) {
                $SubjectType = explode('/', $CheckSubject->SubjectType);
                $SubjectYear = explode('/', $CheckSubject->SubjectYear);
                $SubjectClass = explode('.', $CheckSubject->SubjectClass);

                $insert = [
                    'seplan_namesubject'  => $CheckSubject->SubjectName,
                    'seplan_coursecode'   => $CheckSubject->SubjectCode,
                    'seplan_typesubject'  => $SubjectType[1],
                    'seplan_year'         => $SubjectYear[1],
                    'seplan_term'         => $SubjectYear[0],
                    'seplan_status1'      => "รอตรวจ",
                    'seplan_status2'      => "รอตรวจ",
                    'seplan_sendcomment'  => $textToStore,
                    'seplan_gradelevel'   => $SubjectClass[1],
                    'seplan_typeplan'     => $v_typePlan,
                    'seplan_usersend'     => $this->request->getPost('SelectTeacher'),
                    'seplan_learning'     => $CheckTeacher->pers_learning,
                ];
                $result = $this->db->table('tb_send_plan')->insert($insert);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    public function UpdateSettingSendPlan()
    {
        $data = [
            'seplanset_startdate' => $this->request->getPost('seplanset_startdate'),
            'seplanset_enddate'   => $this->request->getPost('seplanset_enddate'),
            'seplanset_term'      => $this->request->getPost('seplanset_term'),
            'seplanset_year'      => $this->request->getPost('seplanset_year'),
        ];

        echo $this->db->table('tb_send_plan_setup')->where('seplanset_ID', 1)->update($data);
    }

    public function EditSettingSendPlan()
    {
        $PlanCode = $this->request->getPost('PlanCode');
        $PlanYear = $this->request->getPost('PlanYear');
        $PlanTerm = $this->request->getPost('PlanTerm');

        $json = $this->db->table('tb_send_plan')
                        ->select('seplan_namesubject,seplan_coursecode,seplan_gradelevel,seplan_typesubject,seplan_year,seplan_term,seplan_usersend')
                        ->where('seplan_coursecode', $PlanCode)
                        ->where('seplan_year', $PlanYear)
                        ->where('seplan_term', $PlanTerm)
                        ->limit(1)
                        ->get()->getResult();

        return $this->response->setJSON($json);
    }

    public function UpdateSettingSendPlanTeacher()
    {
        $Teacher = $this->DBpersonnel->table('tb_personnel') // Use the class property
                                ->select('pers_id,pers_learning')
                                ->where('pers_id', $this->request->getPost('up_seplan_usersend'))
                                ->get()->getRow(); // Use getRow() for single result
        
        if (empty($Teacher)) {
            echo 0; // Teacher not found
            return;
        }

        $data = [
            'seplan_namesubject'  => $this->request->getPost('up_seplan_namesubject'),
            'seplan_gradelevel'   => $this->request->getPost('up_seplan_gradelevel'),
            'seplan_typesubject'  => $this->request->getPost('up_seplan_typesubject'),
            'seplan_usersend'     => $this->request->getPost('up_seplan_usersend'),
            'seplan_learning'     => $Teacher->pers_learning,
        ];
        $IF = [
            'seplan_coursecode' => $this->request->getPost('up_seplan_coursecode'),
            'seplan_year'       => $this->request->getPost('up_seplan_year'),
            'seplan_term'       => $this->request->getPost('up_seplan_term'),
        ];
        $result = $this->db->table('tb_send_plan')->where($IF)->update($data);

        echo ($result);
    }

    public function DeleteSettingSendPlan()
    {
        $DelPlanCode = $this->request->getPost('PlanCode');
        $DelPlanTerm = $this->request->getPost('PlanTerm');
        $DelPlanYear = $this->request->getPost('PlanYear');
        $DelPlanName = $this->request->getPost('PlanName');

        $IF = [
            'seplan_coursecode' => $DelPlanCode,
            'seplan_year'       => $DelPlanYear,
            'seplan_term'       => $DelPlanTerm,
        ];
        $result = $this->db->table('tb_send_plan')->where($IF)->delete();

        $dir_path = FCPATH . 'uploads/academic/course/plan/' . $DelPlanYear . '/' . $DelPlanTerm . '/' . $DelPlanName;
        
        if (is_dir($dir_path)) {
            // Use CodeIgniter 4's FileSystem library if available, or direct PHP functions
            // For simplicity, using direct PHP functions here. Consider using recursiveDirectoryIterator for robust deletion.
            // helper('filesystem'); // Already loaded in constructor
            delete_files($dir_path, true); // Delete all files in the directory
            rmdir($dir_path); // Remove the directory itself
        }

        echo $result;
    }
}
