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
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
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
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();
        
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

        $builder = $this->db->table('skjacth_academic.tb_send_plan');
        $builder->select('
            MAX(skjacth_personnel.tb_personnel.pers_id) as pers_id,
            MAX(skjacth_personnel.tb_personnel.pers_prefix) as pers_prefix,
            MAX(skjacth_personnel.tb_personnel.pers_firstname) as pers_firstname,
            MAX(skjacth_personnel.tb_personnel.pers_lastname) as pers_lastname,
            skjacth_academic.tb_send_plan.seplan_coursecode,
            MAX(skjacth_academic.tb_send_plan.seplan_namesubject) as seplan_namesubject,
            MAX(skjacth_academic.tb_send_plan.seplan_gradelevel) as seplan_gradelevel,
            MAX(skjacth_academic.tb_send_plan.seplan_typesubject) as seplan_typesubject,
            MAX(skjacth_academic.tb_send_plan.seplan_year) as seplan_year,
            MAX(skjacth_academic.tb_send_plan.seplan_term) as seplan_term
        ');
        $builder->join('skjacth_personnel.tb_personnel', 'skjacth_academic.tb_send_plan.seplan_usersend = skjacth_personnel.tb_personnel.pers_id', 'LEFT');
        if (!empty($data['year'])) {
            $builder->where('seplan_year', $data['year']);
        }
        if (!empty($data['term'])) {
            $builder->where('seplan_term', $data['term']);
        }
        $builder->groupBy('skjacth_academic.tb_send_plan.seplan_coursecode, skjacth_academic.tb_send_plan.seplan_usersend');
        $data['Plan'] = $builder->get()->getResult();

        
        echo view('admin/Academic/AdminSendPlan/AdminSendPlanTeacher', $data);
        
    }

    public function UpdateSendPlanYear($term, $year)
    {
        $data = [
            'seplanset_term' => $term,
            'seplanset_year' => $year,
        ];

        $this->db->table('tb_send_plan_setup')->where('seplanset_ID', 1)->update($data);

        return redirect()->to(base_url('Admin/Acade/Course/SendPlan'));
    }

    public function UpdateSendPlanTeacher()
    {
        try {
            $CheckSubject = $this->db->table('tb_subjects')
                                    ->where('SubjectID', $this->request->getPost('SelectSubject'))
                                    ->get()->getRow();

            if (empty($CheckSubject)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรายวิชาที่เลือก']);
            }

            $SubYear = explode('/', $CheckSubject->SubjectYear);
            $Checkplan = $this->db->table('tb_send_plan')
                                ->where('seplan_coursecode', $CheckSubject->SubjectCode)
                                ->where('seplan_usersend', $this->request->getPost('SelectTeacher'))
                                ->where('seplan_year', $SubYear[1])
                                ->where('seplan_term', $SubYear[0])
                                ->countAllResults();

            if ($Checkplan > 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลครูและรายวิชานี้มีอยู่แล้ว']);
            }

            $CheckTeacher = $this->DBpersonnel->table('tb_personnel')
                                        ->select('pers_learning')
                                        ->where('pers_id', $this->request->getPost('SelectTeacher'))
                                        ->get()->getRow();
            
            if (empty($CheckTeacher)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลครูผู้สอน']);
            }

            $status = $this->request->getPost('seplan_sendcomment') ?? '';
            $textToStore = nl2br(esc($status));

            $typePlan = ['บันทึกตรวจใช้แผน', 'แบบตรวจแผนการจัดการเรียนรู้', 'โครงการสอน', 'แผนการสอนหน้าเดียว', 'แผนการสอนเต็ม', 'บันทึกหลังสอน'];
            
            $this->db->transStart();

            foreach ($typePlan as $v_typePlan) {
                $SubjectType = explode('/', $CheckSubject->SubjectType);
                $SubjectYear = explode('/', $CheckSubject->SubjectYear);
                $SubjectClass = explode('.', $CheckSubject->SubjectClass);

                $insert = [
                    'seplan_namesubject'  => $CheckSubject->SubjectName,
                    'seplan_coursecode'   => $CheckSubject->SubjectCode,
                    'seplan_typesubject'  => $SubjectType[1] ?? null,
                    'seplan_year'         => $SubjectYear[1] ?? null,
                    'seplan_term'         => $SubjectYear[0] ?? null,
                    'seplan_status1'      => "รอตรวจ",
                    'seplan_status2'      => "รอตรวจ",
                    'seplan_sendcomment'  => $textToStore,
                    'seplan_gradelevel'   => $SubjectClass[1] ?? null,
                    'seplan_typeplan'     => $v_typePlan,
                    'seplan_usersend'     => $this->request->getPost('SelectTeacher'),
                    'seplan_learning'     => $CheckTeacher->pers_learning,
                ];
                $this->db->table('tb_send_plan')->insert($insert);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
            } else {
                return $this->response->setJSON(['status' => 'success', 'message' => 'เพิ่มข้อมูลครูและรายวิชาเรียบร้อยแล้ว']);
            }

        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดร้ายแรง']);
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

        $updated =  $this->db->table('tb_send_plan_setup')->where('seplanset_ID', 1)->update($data);

        if ($updated) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกการตั้งค่าเรียบร้อยแล้ว']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Database update failed.']);
            }
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

    public function getPlanDetails()
    {
        $request = service('request');

        $planCode = $request->getGet('plan_code');
        $planYear = $request->getGet('plan_year');
        $planTerm = $request->getGet('plan_term');
        $planTeacherId = $request->getGet('plan_teacher_id'); // New

        // ดึงข้อมูลจากฐานข้อมูล
        // ตรวจสอบให้แน่ใจว่า 'tb_send_plan' เป็นชื่อตารางที่ถูกต้อง
        $builder = $this->db->table('tb_send_plan');
        $builder->select('seplan_namesubject, seplan_coursecode, seplan_gradelevel, seplan_typesubject, seplan_year, seplan_term, seplan_usersend');
        $builder->where('seplan_coursecode', $planCode);
        $builder->where('seplan_year', $planYear);
        $builder->where('seplan_term', $planTerm);
        $builder->where('seplan_usersend', $planTeacherId); // New
        $builder->limit(1);
        $planDetails = $builder->get()->getRow();

        if ($planDetails) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $planDetails
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบข้อมูลแผนการสอน'
            ]);
        }
    }

    public function getPlansTableData()
    {
        $year = $this->request->getGet('year');
        $term = $this->request->getGet('term');

        $builder = $this->db->table('skjacth_academic.tb_send_plan');
        $builder->select('
            MAX(skjacth_personnel.tb_personnel.pers_id) as pers_id,
            MAX(skjacth_personnel.tb_personnel.pers_prefix) as pers_prefix,
            MAX(skjacth_personnel.tb_personnel.pers_firstname) as pers_firstname,
            MAX(skjacth_personnel.tb_personnel.pers_lastname) as pers_lastname,
            skjacth_academic.tb_send_plan.seplan_coursecode,
            MAX(skjacth_academic.tb_send_plan.seplan_namesubject) as seplan_namesubject,
            MAX(skjacth_academic.tb_send_plan.seplan_gradelevel) as seplan_gradelevel,
            MAX(skjacth_academic.tb_send_plan.seplan_typesubject) as seplan_typesubject,
            MAX(skjacth_academic.tb_send_plan.seplan_year) as seplan_year,
            MAX(skjacth_academic.tb_send_plan.seplan_term) as seplan_term
        ');
        $builder->join('skjacth_personnel.tb_personnel', 'skjacth_academic.tb_send_plan.seplan_usersend = skjacth_personnel.tb_personnel.pers_id', 'LEFT');
        if (!empty($year)) {
            $builder->where('seplan_year', $year);
        }
        if (!empty($term)) {
            $builder->where('seplan_term', $term);
        }
        $builder->groupBy('skjacth_academic.tb_send_plan.seplan_coursecode, skjacth_academic.tb_send_plan.seplan_usersend');
        $plans = $builder->get()->getResult();

        return $this->response->setJSON($plans);
    }

    public function getFilteredPlanData()
    {
        $request = service('request');
        $ModAdminCourse = new \App\Models\Admin\Academic\ModAdminCourse(); // Instantiate your Model

        $draw = $request->getPost('draw');
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;
        
        $search = $request->getPost('search');
        $searchValue = is_array($search) ? $search['value'] : '';

        $order = $request->getPost('order');
        $columns = $request->getPost('columns');
        $orderColumnIndex = !empty($order) && isset($order[0]['column']) ? $order[0]['column'] : 0;
        $orderDir = !empty($order) && isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
        $orderColumnName = !empty($columns) && isset($columns[$orderColumnIndex]['data']) ? $columns[$orderColumnIndex]['data'] : '';

        $termYear = $request->getPost('term_year');
        $term = null;
        $year = null;

        if (empty($termYear) || strpos($termYear, '/') === false) {
            // If not provided, get default from setup table
            $checkYear = $this->db->table('tb_send_plan_setup')->get()->getRow();
            if ($checkYear) {
                $year = $checkYear->seplanset_year;
                $term = $checkYear->seplanset_term;
            } else {
                // No default is set, so return empty
                $response = [
                    'draw' => intval($draw),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                ];
                return $this->response->setJSON($response);
            }
        } else {
            list($term, $year) = explode('/', $termYear);
        }

        // Fetch data using Model methods
        $data = $ModAdminCourse->getPlansForDatatables($start, $length, $searchValue, $orderColumnName, $orderDir, $term, $year);
        $totalRecords = $ModAdminCourse->getTotalPlans();
        $filteredRecords = $ModAdminCourse->getFilteredPlansCount($searchValue, $term, $year);

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];

        return $this->response->setJSON($response);
    }

    public function updateSchoolYear()
    {
        if ($this->request->getMethod() === 'post') {
            $newYear = $this->request->getPost('schyear_year');

            // Basic validation
            if (empty($newYear) || !preg_match('/^[1-2]\/[0-9]{4}$/', $newYear)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid year format.']);
            }

            $data = [
                'schyear_year' => $newYear
            ];

            $updated = $this->db->table('tb_schoolyear')->where('schyear_id', 1)->update($data);

            if ($updated) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Database update failed.']);
            }
        }
        // Respond with an error if it's not a POST request
        return $this->response->setStatusCode(405)->setJSON(['status' => 'error', 'message' => 'Method not allowed.']);
    }

    public function delete_teacher_subject()
    {
        try {
            $planCode = $this->request->getPost('plan_code');
            $teacherId = $this->request->getPost('plan_teacher_id');
            $planYear = $this->request->getPost('plan_year');
            $planTerm = $this->request->getPost('plan_term');

            if (empty($planCode) || empty($teacherId) || empty($planYear) || empty($planTerm)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Incomplete data provided.']);
            }

            $conditions = [
                'seplan_coursecode' => $planCode,
                'seplan_usersend' => $teacherId,
                'seplan_year' => $planYear,
                'seplan_term' => $planTerm
            ];

            $this->db->table('tb_send_plan')->where($conditions)->delete();

            if ($this->db->affectedRows() > 0) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูล สำหรับส่งแผน เรียบร้อยแล้ว']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No records found to delete.']);
            }
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return $this->response->setJSON(['status' => 'error', 'message' => 'An unexpected error occurred.']);
        }
    }

}
