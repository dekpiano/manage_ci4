<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminRegisterSubject;

class ConAdminSettingAdminRoles extends BaseController
{
    protected $ModAdminRegisterSubject;
    protected $db;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->ModAdminRegisterSubject = new ModAdminRegisterSubject();
        $this->db = \Config\Database::connect();
        $this->DBpersonnel = \Config\Database::connect('personnel');

        if (empty(session('fullname'))) {
            // In CI4, you should return a redirect response.
            // The actual redirect will be handled by the framework.
            // Note: This check might be better handled by a filter.
            return redirect()->to('LoginAdmin');
        }

        $check_status = $this->db->table('tb_admin_rloes')
                                 ->where('admin_rloes_userid', session('login_id'))
                                 ->orderBy("CASE WHEN admin_rloes_nanetype != '' THEN 0 ELSE 1 END", 'ASC', false)
                                 ->orderBy("FIELD(admin_rloes_status, 'superadmin', 'admin', 'manager')", 'ASC', false)
                                 ->get()
                                 ->getRow();

        if (!in_array(@$check_status->admin_rloes_status, ['admin', 'manager', 'superadmin'])) {
            session()->setFlashdata('msg', 'OK');
            session()->setFlashdata('messge', 'คุณไม่มีสิทธิ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม');
            session()->setFlashdata('alert', 'error');
            // In CI4, you should return a redirect response.
            return redirect()->to('welcome');
        }
    }

    public function AcademicSettingAdminRoles()
    {
        $currentUserRole = $this->db->table('tb_admin_rloes')
            ->where('admin_rloes_userid', session('login_id'))
            ->get()
            ->getRow();

        // admin_rloes_status = 'superadmin' is Super Admin
        // The user record for 'หัวหน้าฝ่ายวิชาการ' has admin_rloes_id = 3
        $isSuperAdmin = ($currentUserRole && $currentUserRole->admin_rloes_status === 'superadmin');
        $isAcademicHead = ($currentUserRole && $currentUserRole->admin_rloes_id == 3);

        if (!$isSuperAdmin && !$isAcademicHead) {
            session()->setFlashdata('msg', 'OK');
            session()->setFlashdata('messge', 'คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้');
            session()->setFlashdata('alert', 'error');
            return redirect()->to('admin/home');
        }

        $data['title'] = "บทบาทในวิชาการ";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        $data['Manager'] = $this->db->table('tb_admin_rloes')
                                    ->select('admin_rloes_userid, admin_rloes_id, admin_rloes_nanetype, admin_rloes_status, admin_rloes_academic_position')
                                    ->get()
                                    ->getResult();

        $data['NameTeacher'] = $this->DBpersonnel->table('tb_personnel')
                                                 ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_position, pers_learning')
                                                 ->orderBy('pers_learning')
                                                 ->get()
                                                 ->getResult();
        
        // In CI4, it's common to pass data to a single view that extends a layout.
        return view('admin/Academic/AdminSettingAdminRoles/AdminSettingAdminRolesMain', $data);
    }

    public function AcademicSettingManager()
    {
        $data = ['admin_rloes_userid' => $this->request->getPost('TeachID')];
        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_id', 1)->update($data);
        return $this->response->setJSON(['success' => (bool)$result]);
    }

    public function AcademicSettingDeputy()
    {
        $data = ['admin_rloes_userid' => $this->request->getPost('TeachID')];
        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_id', 2)->update($data);
        return $this->response->setJSON(['success' => (bool)$result]);
    }

    public function AcademicSettingLeader()
    {
        $data = ['admin_rloes_userid' => $this->request->getPost('TeachID')];
        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_id', 3)->update($data);
        return $this->response->setJSON(['success' => (bool)$result]);
    }

    public function AcademicSettingAdmin()
    {
        $data = ['admin_rloes_userid' => $this->request->getPost('TeachID')];
        $adminId = $this->request->getPost('AdminID');
        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_id', $adminId)->update($data);
        return $this->response->setJSON(['success' => (bool)$result]);
    }

    public function SelectWork()
    {
        $options = $this->request->getPost('option');
        if (empty($options)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No options provided.']);
        }

        $this->db->transStart();
        foreach ($options as $value) {
            $mainKey = $value['mainKey'] ?? null;
            $checkboxValues = $value['options'] ?? null;

            if ($mainKey && !empty($checkboxValues)) {
                $data = ['admin_rloes_nanetype' => implode("|", $checkboxValues)];
                $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', $mainKey)->update($data);
            }
        }
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Database transaction failed.']);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function addAcademicStaff()
    {
        $persId = $this->request->getPost('pers_id');

        if (empty($persId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่พบรหัสบุคลากร']);
        }

        // Check if the personnel already exists in tb_admin_rloes
        $existingStaff = $this->db->table('tb_admin_rloes')
                                  ->where('admin_rloes_userid', $persId)
                                  ->get()
                                  ->getRow();

        if ($existingStaff) {
            return $this->response->setJSON(['success' => false, 'message' => 'บุคลากรนี้เป็นเจ้าหน้าที่อยู่แล้ว']);
        }

        $data = [
            'admin_rloes_userid' => $persId,
            'admin_rloes_status' => 'admin', // Default status for new academic staff
            'admin_rloes_nanetype' => '' // Empty permissions by default
        ];

        $result = $this->db->table('tb_admin_rloes')->insert($data);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'เพิ่มเจ้าหน้าที่สำเร็จ']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่สามารถเพิ่มเจ้าหน้าที่ได้']);
        }
    }

    public function deleteAcademicStaff()
    {
        $userId = $this->request->getPost('user_id');

        if (empty($userId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่พบรหัสผู้ใช้']);
        }

        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', $userId)->delete();

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'ลบเจ้าหน้าที่สำเร็จ']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่สามารถลบเจ้าหน้าที่ได้']);
        }
    }

    public function updateStaffDetails()
    {
        $userId = $this->request->getPost('user_id');
        $permissions = $this->request->getPost('permissions');
        $position = $this->request->getPost('position');

        if (empty($userId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่พบรหัสผู้ใช้']);
        }

        $data = [
            'admin_rloes_nanetype' => $permissions,
            'admin_rloes_academic_position' => $position
        ];

        $result = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', $userId)->update($data);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'อัปเดตข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'ไม่สามารถอัปเดตข้อมูลได้']);
        }
    }
}