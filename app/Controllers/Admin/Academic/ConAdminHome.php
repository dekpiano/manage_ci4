<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminHome extends BaseController
{
    protected $DBpersonnel;
    protected $db; // Add this line

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect('default'); // Add this line

        helper(['url', 'form']);

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

    public function AdminHome(){      
        $data['title'] = "หน้าแรก";
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['selectedYear'] = get_selected_year(); // Format: "1/2568"
        
        // Roles for Permission check
        $CheckrloesAcademic = session()->get('CheckrloesAcademic') ?? '';
        $data['Exp_Checkrloes'] = explode('|', $CheckrloesAcademic);

        // Split year and term for tables that keep them separate
        $yearParts = explode('/', $data['selectedYear']);
        $term = $yearParts[0] ?? '';
        $year = $yearParts[1] ?? '';

        // --- 1. Basic Stats ---
        $data['total_students'] = $this->db->table('tb_students')->where('StudentStatus', '1/ปกติ')->countAllResults();
        $data['total_teachers'] = $this->DBpersonnel->table('tb_personnel')->whereIn('pers_position', ['posi_003', 'posi_004', 'posi_005','posi_006'])->countAllResults();
        $data['total_subjects'] = $this->db->table('tb_subjects')->where('SubjectYear', $data['selectedYear'])->countAllResults();
        $data['total_classrooms'] = $this->db->table('tb_students')->where('StudentStatus', '1/ปกติ')->distinct()->select('StudentClass')->countAllResults();

        // --- 2. Lesson Plan Stats ---
        $data['plan_stats'] = $this->db->table('tb_send_plan')
            ->select('seplan_status2, COUNT(*) as count')
            ->where('seplan_year', $year)
            ->where('seplan_term', $term)
            ->groupBy('seplan_status2')
            ->get()->getResultArray();
        
        // Calculate percentages/counts for plans
        $data['plan_total'] = array_sum(array_column($data['plan_stats'], 'count'));
        $data['plan_approved'] = 0;
        $data['plan_pending'] = 0;
        foreach($data['plan_stats'] as $ps) {
            if($ps['seplan_status2'] == 'ผ่านการตรวจสอบ') $data['plan_approved'] = $ps['count'];
            if($ps['seplan_status2'] == 'รอการตรวจสอบ') $data['plan_pending'] = $ps['count'];
        }

        // --- 3. Club Stats ---
        $data['total_clubs'] = $this->db->table('tb_clubs')->countAllResults();
        $data['club_registrations'] = $this->db->table('tb_club_members')
            ->join('tb_clubs', 'tb_club_members.member_club_id = tb_clubs.club_id')
            ->where('tb_club_members.member_status', 'active')
            ->where('tb_clubs.club_year', $year) // Table tb_clubs uses year and trem separately
            ->where('tb_clubs.club_trem', $term)
            ->countAllResults();
        
        // --- 4. Enrollment Stats (Normal) ---
        $data['enrolled_students'] = $this->db->table('tb_register')
            ->distinct()
            ->select('StudentID')
            ->where('RegisterYear', $data['selectedYear'])
            ->countAllResults();

        // --- 5. Research Stats ---
        $data['research_total'] = $this->db->table('tb_send_research')
            ->where('seres_year', $year) // Research usually uses year and term separately too
            ->where('seres_term', $term)
            ->countAllResults();

        echo view('admin/Academic/AdminHome/AdminHome', $data);
    }

    /**
     * Set the selected academic year in session (AJAX endpoint)
     */
    public function setSelectedYear()
    {
        $year = $this->request->getPost('year');
        if (!empty($year)) {
            session()->set('admin_selected_year', $year);
            return $this->response->setJSON(['status' => 'success', 'year' => $year]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Year is required']);
    }

    /**
     * Get the selected academic year from session (AJAX endpoint)
     */
    public function getSelectedYear()
    {
        $year = session()->get('admin_selected_year');
        return $this->response->setJSON(['year' => $year]);
    }
}
