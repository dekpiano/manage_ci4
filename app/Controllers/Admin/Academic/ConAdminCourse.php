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

        // ลำดับความสำคัญของปีการศึกษา: GET -> Session -> Latest Data -> Setup Table
        $onoffYear = $this->request->getGet('onoff_year');
        $selectedYearStr = $onoffYear ?: get_selected_year();

        if ($selectedYearStr && strpos($selectedYearStr, '/') !== false) {
            list($data['term'], $data['year']) = explode('/', $selectedYearStr);
        } else {
            // ถ้าไม่มีใน Session หรือ GET ให้ลองหาจากข้อมูลล่าสุดที่มีในระบบ
            $latestYear = $this->db->table('tb_send_plan')
                                   ->select('seplan_year, seplan_term')
                                   ->orderBy('seplan_year', 'DESC')
                                   ->orderBy('seplan_term', 'DESC')
                                   ->limit(1)
                                   ->get()->getRow();
            
            if ($latestYear) {
                $data['year'] = $latestYear->seplan_year;
                $data['term'] = $latestYear->seplan_term;
            } else {
                // สุดท้ายไปดึงจากค่าตั้งค่ากลาง
                $data['year'] = ! empty($data['CheckYear'][0]->seplanset_year) ? $data['CheckYear'][0]->seplanset_year : null;
                $data['term'] = ! empty($data['CheckYear'][0]->seplanset_term) ? $data['CheckYear'][0]->seplanset_term : null;
            }
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
            MAX(skjacth_personnel.tb_personnel.pers_img) as pers_img,
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
            $selectSubjects = $this->request->getPost('SelectSubject');
            $selectTeacher = $this->request->getPost('SelectTeacher');
            $formYear = $this->request->getPost('SelectYear');

            if (empty($selectSubjects) || !is_array($selectSubjects)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเลือกรายวิชาอย่างน้อยหนึ่งวิชา']);
            }

            if (empty($selectTeacher)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบครูผู้สอนที่เลือก']);
            }

            $CheckTeacher = $this->DBpersonnel->table('tb_personnel')
                                    ->select('pers_id, pers_learning')
                                    ->where('pers_id', $selectTeacher)
                                    ->get()->getRow();

            if (empty($CheckTeacher)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบครูผู้สอนที่เลือกในฐานข้อมูล']);
            }

            $typePlan = $this->db->table('tb_send_plan_type')->get()->getResult();
            $status = $this->request->getPost('seplan_sendcomment') ?? '';
            $textToStore = nl2br(esc($status));

            $this->db->transException(true)->transStart();

            $successCount = 0;
            $skipCount = 0;

            foreach ($selectSubjects as $subjectID) {
                $CheckSubject = $this->db->table('tb_subjects')
                                        ->where('SubjectID', $subjectID)
                                        ->get()->getRow();

                if (empty($CheckSubject)) continue;

                // Get Year/Term from Form or Fallback to Subject's Year
                if (!empty($formYear) && strpos($formYear, '/') !== false) {
                    $SubYear = explode('/', $formYear);
                } else {
                    $SubYear = explode('/', $CheckSubject->SubjectYear);
                }

                $year = $SubYear[1] ?? $SubYear[0];
                $term = (count($SubYear) > 1) ? $SubYear[0] : null;

                $Checkplan = $this->db->table('tb_send_plan')
                                    ->where('seplan_coursecode', $CheckSubject->SubjectCode)
                                    ->where('seplan_usersend', $selectTeacher)
                                    ->where('seplan_year', $year)
                                    ->where('seplan_term', $term)
                                    ->countAllResults();

                if ($Checkplan > 0) {
                    $skipCount++;
                    continue;
                }

                foreach ($typePlan as $v_typePlan) {
                    $SubjectType_arr = explode('/', $CheckSubject->SubjectType);
                    $SubjectClass_arr = explode('.', $CheckSubject->SubjectClass);

                    $insert = [
                        'seplan_namesubject'  => $CheckSubject->SubjectName,
                        'seplan_coursecode'   => $CheckSubject->SubjectCode,
                        'seplan_typesubject'  => (count($SubjectType_arr) > 1) ? $SubjectType_arr[1] : $CheckSubject->SubjectType,
                        'seplan_year'         => $year,
                        'seplan_term'         => $term,
                        'seplan_status1'      => "รอตรวจ",
                        'seplan_status2'      => "รอตรวจ",
                        'seplan_sendcomment'  => $textToStore,
                        'seplan_gradelevel'   => (count($SubjectClass_arr) > 1) ? $SubjectClass_arr[1] : $CheckSubject->SubjectClass,
                        'seplan_typeplan'     => $v_typePlan->type_name,
                        'seplan_typeplan_id'  => $v_typePlan->type_id,
                        'seplan_usersend'     => $selectTeacher,
                        'seplan_learning'     => $CheckTeacher->pers_learning ?? null,
                        'seplan_createdate'   => date('Y-m-d H:i:s'),
                        'seplan_inspector1'   => '',
                        'seplan_inspector2'   => '',
                        'seplan_comment1'     => '',
                        'seplan_comment2'     => '',
                        'seplan_file'         => '',
                        'seplan_checkdate1'   => '0000-00-00 00:00:00',
                        'seplan_checkdate2'   => '0000-00-00 00:00:00',
                    ];
                    $this->db->table('tb_send_plan')->insert($insert);
                }
                $successCount++;
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
            } else {
                if ($successCount > 0) {
                    $msg = "เพิ่มข้อมูลสำเร็จ $successCount รายการ";
                    if ($skipCount > 0) {
                        $msg .= "<br/><small class='text-warning'>ข้าม $skipCount รายการที่ซ้ำกันอยู่แล้ว</small>";
                    }
                    return $this->response->setJSON(['status' => 'success', 'message' => $msg]);
                } else {
                    if ($skipCount > 0) {
                        return $this->response->setJSON([
                            'status' => 'warning', 
                            'message' => "วิชาที่เลือกถูกลงทะเบียนให้ครูท่านนี้ไว้ก่อนแล้ว ($skipCount รายการ)"
                        ]);
                    }
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลวิชาที่เลือกหรือเกิดข้อผิดพลาด']);
                }
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
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

        $newTeacherId = $this->request->getPost('up_seplan_usersend');
        $courseCode = $this->request->getPost('up_seplan_coursecode');
        $year = $this->request->getPost('up_seplan_year');
        $term = $this->request->getPost('up_seplan_term');

        // Check if the NEW teacher already has this course assignment (Duplicate Check)
        $existing = $this->db->table('tb_send_plan')
            ->where('seplan_coursecode', $courseCode)
            ->where('seplan_usersend', $newTeacherId)
            ->where('seplan_year', $year)
            ->where('seplan_term', $term)
            ->get()->getRow();

        if ($existing) {
            echo json_encode(['status' => 'error', 'message' => 'ครูท่านนี้ถูกลงทะเบียนในวิชานี้ไว้แล้วในเทอมนี้ ไม่สามารถเปลี่ยนซ้ำได้']);
            return;
        }

        $data = [
            'seplan_namesubject'  => $this->request->getPost('up_seplan_namesubject'),
            'seplan_gradelevel'   => $this->request->getPost('up_seplan_gradelevel'),
            'seplan_typesubject'  => $this->request->getPost('up_seplan_typesubject'),
            'seplan_usersend'     => $newTeacherId,
            'seplan_learning'     => $Teacher->pers_learning,
        ];
        $IF = [
            'seplan_coursecode' => $courseCode,
            'seplan_year'       => $year,
            'seplan_term'       => $term,
        ];
        $result = $this->db->table('tb_send_plan')->where($IF)->update($data);

        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว']);
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
            MAX(skjacth_personnel.tb_personnel.pers_img) as pers_img,
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
            // ใช้ปีการศึกษาหลักของระบบ (admin_selected_year session)
            $selectedYearStr = get_selected_year();
            if (strpos($selectedYearStr, '/') !== false) {
                list($term, $year) = explode('/', $selectedYearStr);
            } else {
                // fallback สุดท้ายไปดู tb_send_plan_setup
                $checkYear = $this->db->table('tb_send_plan_setup')->get()->getRow();
                if ($checkYear) {
                    $year = $checkYear->seplanset_year;
                    $term = $checkYear->seplanset_term;
                } else {
                    $response = [
                        'draw' => intval($draw),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                    ];
                    return $this->response->setJSON($response);
                }
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

    public function getSubjectsByYear()
    {
        $yearTerm = $this->request->getGet('yearTerm');
        if (empty($yearTerm)) {
            return $this->response->setJSON([]);
        }

        $subjects = $this->db->table('tb_subjects')
                            ->where('SubjectYear', $yearTerm)
                            ->get()->getResult();

        return $this->response->setJSON($subjects);
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
