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

        $request = \Config\Services::request();
        $response = \Config\Services::response();

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            // For AJAX requests, return a JSON error
            if ($request->is('ajax')) {
                $response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->send();
                exit();
            }
            header('Location: ' . base_url('LogoutTeacher'));
            exit();
        }

        $check_status_data = $this->db->table('tb_admin_rloes')
                                      ->where('admin_rloes_userid', session()->get('login_id'))
                                      ->orderBy("CASE WHEN admin_rloes_nanetype != '' THEN 0 ELSE 1 END", 'ASC', false)
                                      ->orderBy("FIELD(admin_rloes_status, 'superadmin', 'admin', 'manager')", 'ASC', false)
                                      ->get()
                                      ->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            header('Location: ' . base_url('welcome'));
            exit();
        }
    }

    public function AdminHome(){      
        $data['title'] = "หน้าแรก - ระบบบริหารจัดการงานวิชาการ";
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img,pers_prefix,pers_firstname,pers_lastname,pers_position')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['selectedYear'] = get_selected_year(); // Format: "1/2568"
        
        // Roles for Permission check
        $CheckrloesAcademic = session()->get('CheckrloesAcademic') ?? '';
        $data['Exp_Checkrloes'] = array_filter(array_map('trim', explode('|', $CheckrloesAcademic)));

        $data['admin_role_info'] = $this->db->table('tb_admin_rloes')
                                      ->where('admin_rloes_userid', session()->get('login_id'))
                                      ->get()
                                      ->getRow();
        $data['is_superadmin'] = (@$data['admin_role_info']->admin_rloes_status === 'superadmin');
        $data['is_manager'] = (session()->get('status') === "manager" || session()->get('login_id') == "pers_021" || $data['is_superadmin']);

        // Split year and term for tables that keep them separate
        $yearParts = explode('/', $data['selectedYear']);
        $term = $yearParts[0] ?? '';
        $year = $yearParts[1] ?? '';

        echo view('admin/Academic/AdminHome/AdminHome', $data);
    }

    /**
     * Set the selected academic year in session (AJAX endpoint)
     */
    public function setSelectedYear()
    {
        $year = $this->request->getPost('year');
        if (!empty($year)) {
            // 1. บันทึกลง session สำหรับใช้งานทันที
            session()->set('admin_selected_year', $year);

            // 2. บันทึกลง tb_schoolyear ในฐานข้อมูล เพื่อให้คงอยู่หลัง logout/login
            $this->db->table('tb_schoolyear')->where('schyear_id', 1)->update(['schyear_year' => $year]);

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
