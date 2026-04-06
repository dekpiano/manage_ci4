<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModAdminCheckPlan;
use App\Libraries\Classroom; // Assuming this library will be migrated to App\Libraries

class ConAdminCheckPlan extends BaseController
{
    protected $ModAdminCheckPlan;

    public function __construct()
    {
        $this->ModAdminCheckPlan = new ModAdminCheckPlan();
         $this->classroom = new Classroom(); // Assuming Classroom library is available or will be migrated
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection
    }

    public function index()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        $data['learningGroups'] = $this->ModAdminCheckPlan->getLearningGroups();
        $data['title'] = 'เลือกกลุ่มสาระการเรียนรู้';
        return view('admin/Academic/AdminCheckPlan/select_group', $data);
    }

    public function plansByGroup($groupId)
    {
         $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $yearTerm = $this->request->getGet('year_term');
        $data['year_terms'] = $this->ModAdminCheckPlan->getDistinctYearTerm();

        if (!empty($yearTerm)) {
            list($year, $term) = explode('/', $yearTerm);
        } else {
            // Use the system's selected year from helper as default
            $selectedYearStr = get_selected_year(); // e.g. "1/2568"
            if (strpos($selectedYearStr, '/') !== false) {
                list($term, $year) = explode('/', $selectedYearStr);
            } else {
                $year = $selectedYearStr ?: date('Y') + 543;
                $term = '1';
            }
        }

        $data['selected_year_term'] = $year . '/' . $term;
        $data['plans'] = $this->ModAdminCheckPlan->getPlansByGroupId($groupId, $year, $term);
        
        $groupedPlans = [];
        foreach ($data['plans'] as $plan) {
            $teacherId = $plan->seplan_usersend; // Assuming seplan_usersend is the teacher's ID
            if (!isset($groupedPlans[$teacherId])) {
                $groupedPlans[$teacherId] = [
                    'pers_id' => $plan->seplan_usersend,
                    'pers_prefix' => $plan->pers_prefix,
                    'pers_firstname' => $plan->pers_firstname,
                    'pers_lastname' => $plan->pers_lastname,
                    'pers_img' => $plan->pers_img,
                    'lear_namethai' => $plan->lear_namethai,
                    'plans' => []
                ];
            }
            $groupedPlans[$teacherId]['plans'][] = $plan;
        }
        $data['groupedPlans'] = $groupedPlans;
        $data['title'] = 'ตรวจสอบแผนการสอน';
        return view('admin/Academic/AdminCheckPlan/ChekPresGroup', $data);
    }

    public function updatePlanStatus()
    {
        $planId = $this->request->getPost('plan_id');
        $level = $this->request->getPost('level');
        $status = $this->request->getPost('status');
        $comment = $this->request->getPost('comment');

        $data = [];
        if ($level == 1) {
            $data['seplan_status1'] = $status;
            $data['seplan_comment1'] = $comment;
        } elseif ($level == 2) {
            $data['seplan_status2'] = $status;
            $data['seplan_comment2'] = $comment;
        }

        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid level provided.']);
        }

        if ($this->ModAdminCheckPlan->updatePlan($planId, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }
    }

    public function getTeacherPlans($teacherId)
    {
        $year = $this->request->getGet('year');
        $term = $this->request->getGet('term');
        $plans = $this->ModAdminCheckPlan->getPlansByTeacherId($teacherId, $year, $term);
        return $this->response->setJSON($plans);
    }

    public function getPlanDetails($planId)
    {
        $planDetails = $this->ModAdminCheckPlan->getPlanDetailsById($planId);
        return $this->response->setJSON($planDetails);
    }

    // ===== Report Check Plan (from ConAdminReportCheckPlan) =====
    public function report()
    {
        if (empty(session()->get('fullname'))) {
             return redirect()->to(base_url('LogoutTeacher'));
        }

        $data['title'] = "รายงานการส่งแผนการสอน";
        $data['groups'] = $this->ModAdminCheckPlan->getLearningGroups();
        $data['year_terms'] = $this->ModAdminCheckPlan->getYearsTerms();

        // Default Selection from Helper
        $selectedYearStr = get_selected_year();
        $defaultTerm = '1';
        $defaultYear = date('Y') + 543;
        if (strpos($selectedYearStr, '/') !== false) {
            list($defaultTerm, $defaultYear) = explode('/', $selectedYearStr);
        }

        $data['sel_year'] = $this->request->getGet('year') ?? $defaultYear;
        $data['sel_term'] = $this->request->getGet('term') ?? $defaultTerm;
        $data['sel_group'] = $this->request->getGet('group') ?? ''; // Empty means none selected or 'all'
        $data['sel_type'] = $this->request->getGet('type') ?? '';

        // If group is selected, fetch data
        if ($data['sel_group']) {
            $data['report_data'] = $this->ModAdminCheckPlan->getReportData($data['sel_group'], $data['sel_year'], $data['sel_term'], $data['sel_type']);
            // Get Group Name for Display
            foreach($data['groups'] as $g) {
                if($g->lear_id == $data['sel_group']) {
                    $data['sel_group_name'] = $g->lear_namethai;
                    break;
                }
            }
        } else {
            $data['report_data'] = [];
        }

        return view('admin/Academic/AdminCheckPlan/ReportCheckPlanMain', $data);
    }
}
