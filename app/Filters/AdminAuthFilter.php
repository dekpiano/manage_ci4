<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * URI patterns that are allowed without authentication.
     * These match the 'except' list in app/Config/Filters.php.
     */
    protected array $publicExcept = [
        'LoginAdmin',
        'admin/academic/competition',
        'Admin/academic/competition',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = trim($request->getPath(), '/');

        // Allow listed public URIs without authentication
        foreach ($this->publicExcept as $except) {
            $except = trim($except, '/');
            if ($uri === $except || str_starts_with($uri, $except . '/')) {
                return; // skip auth check
            }
        }

        // Check if user is logged in
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LoginAdmin'));
        }

        // Check user role
        $db = \Config\Database::connect();
        $check_status_data = $db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if ($check_status_data) {
            $session = session();
            $session->set('admin_status', $check_status_data->admin_rloes_status);
            $session->set('admin_roles', $check_status_data->admin_rloes_nanetype);
            
            // If user is a superadmin, grant them access to all academic menus automatically
            if ($check_status_data->admin_rloes_status === 'superadmin') {
                $session->set('CheckrloesAcademic', 'งานทะเบียน|งานวัดและประเมินผล|งานหลักสูตร|งานวิจัย|งานกิจกรรมพัฒนาผู้เรียน|งานแนะแนว');
            }
        }

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed after the controller runs
    }
}
