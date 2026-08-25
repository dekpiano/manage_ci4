<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminResearch extends BaseController
{
    protected $DBpersonnel;

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect();
        helper('filesystem');

        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function index()
    {
        $data['title'] = "ตั้งค่าส่งงานวิจัย";
        $data['CheckYear'] = $this->db->table('tb_send_research_setup')->get()->getResult();

        echo view('admin/Academic/AdminResearch/AdminResearchSetup', $data);
    }

    public function research_report()
    {
        $data['title'] = "รายงานการส่งงานวิจัย";
        
        $db_skj = \Config\Database::connect('skj');
        $data['learning_groups'] = $db_skj->table('tb_learning')->get()->getResult();

        // Fetch distinct years for the dropdown
        $data['academic_years'] = $this->db->table('tb_send_research')
                                            ->select('seres_year')
                                            ->distinct()
                                            ->orderBy('seres_year', 'DESC')
                                            ->get()
                                            ->getResult();

        $defaultYear = get_selected_year_only();
        $defaultTerm = get_selected_term_only();

        $academic_year = $this->request->getPost('academic_year') ?: $defaultYear;
        $learning_group = $this->request->getPost('learning_group');
        $term = $this->request->getPost('term') ?: $defaultTerm;

        // Pass selected values back to the view for persistence
        $data['selectedYear'] = get_selected_year();
        $data['selected_year'] = $academic_year;
        $data['selected_group'] = $learning_group;
        $data['selected_term'] = $term;
        $data['selected_group_name'] = null;

        $data['research_base_url'] = getenv('upload.server.baseurl.research');

        if ($learning_group) {
            // If a group is selected, fetch all teachers from that group
            $group_info = $db_skj->table('tb_learning')->where('lear_id', $learning_group)->get()->getRow();
            if ($group_info) {
                $data['selected_group_name'] = $group_info->lear_namethai;
            }

            $builder = $this->DBpersonnel->table('tb_personnel as p');
            $builder->select('p.pers_id, p.pers_prefix, p.pers_firstname, p.pers_lastname, p.pers_img, r.seres_ID, r.seres_research_name, r.seres_status, r.seres_file, r.seres_year, r.seres_term');
            $builder->where('p.pers_learning', $learning_group);
            $builder->where('p.pers_status', 'กำลังใช้งาน'); // Filter for active teachers
            $builder->whereIn('p.pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006']); // Filter for teacher positions (posi_003 - posi_006)

            $join_condition = "r.seres_usersend = p.pers_id";
            if ($academic_year) {
                $join_condition .= " AND r.seres_year = " . $this->db->escape($academic_year);
            }
            if ($term) {
                $join_condition .= " AND r.seres_term = " . $this->db->escape($term);
            }
            $builder->join($this->db->getDatabase().'.tb_send_research as r', $join_condition, 'left');
            
            $data['submissions'] = $builder->orderBy('p.pers_firstname', 'ASC')->get()->getResult();

        } else {
            // Default: Show all active teachers and their research for the current/selected academic year/term
            $builder = $this->DBpersonnel->table('tb_personnel as p');
            $builder->select('p.pers_id, p.pers_prefix, p.pers_firstname, p.pers_lastname, p.pers_img, r.seres_ID, r.seres_research_name, r.seres_status, r.seres_file, r.seres_year, r.seres_term');
            $builder->where('p.pers_status', 'กำลังใช้งาน');
            $builder->whereIn('p.pers_position', ['posi_003', 'posi_004', 'posi_005', 'posi_006']); // Filter for teacher positions (posi_003 - posi_006)

            $join_condition = "r.seres_usersend = p.pers_id";
            if ($academic_year) {
                $join_condition .= " AND r.seres_year = " . $this->db->escape($academic_year);
            }
            if ($term) {
                $join_condition .= " AND r.seres_term = " . $this->db->escape($term);
            }
            $builder->join($this->db->getDatabase().'.tb_send_research as r', $join_condition, 'left');

            $data['submissions'] = $builder->orderBy('p.pers_firstname', 'ASC')->get()->getResult();
        }

        echo view('admin/Academic/AdminResearch/AdminResearchReport', $data);
    }

    public function update_setting()
    {
        if ($this->request->getMethod() === 'get') {
            return redirect()->to('Admin/Acade/Research/Setup');
        }

        $data = [
            'seres_setup_startdate' => $this->request->getPost('researchset_startdate'),
            'seres_setup_enddate'   => $this->request->getPost('researchset_enddate'),
            'seres_setup_term'      => $this->request->getPost('researchset_term'),
            'seres_setup_year'      => $this->request->getPost('researchset_year'),
        ];

        // Assuming ID 1 is the default setup row
        $updated =  $this->db->table('tb_send_research_setup')->where('seres_setup_ID', 1)->update($data);

        if ($updated) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกการตั้งค่าเรียบร้อยแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Database update failed.']);
        }
    }
}
