<?php

namespace App\Controllers;

use App\Models\Model_login;

class Auth extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model_login();
    }

    public function login()
    {
        if (session()->get('login_id')) {
            $status = session()->get('status');
            if (in_array($status, ['admin', 'academic', 'general', 'superadmin', 'manager'])) {
                return redirect()->to(base_url('Admin/Home'));
            }
        }

        $config = config('Google');
        $params = [
            'client_id'     => $config->clientId,
            'redirect_uri'  => base_url('Auth/googleLogin'),
            'response_type' => 'code',
            'scope'         => 'email profile openid',
            'access_type'   => 'online',
            'prompt'        => 'select_account'
        ];
        return redirect()->to('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    public function doLogin()
    {
        // ... (keep this for manual login if needed via direct URL, otherwise can be removed later)
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $password_md5 = md5(md5($password));
        $result = $this->model->fetch_teacher_login1($username, $password_md5);

        if ($result) {
            $status = $result->academic_status ?: 'admin';
            if (!in_array($status, ['admin', 'academic', 'general', 'superadmin', 'manager'])) {
                return redirect()->to(base_url('/'))->with('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้');
            }
// ... (rest of session data)

            // ดึงปีการศึกษาเริ่มต้นจาก tb_schoolyear เพื่อ set ลง session ตอน login
            $db = \Config\Database::connect();
            $schoolYear = $db->table('tb_schoolyear')->get()->getRow();
            $defaultYear = $schoolYear->schyear_year ?? '';

            $sessionData = [
                'login_id' => $result->pers_id,
                'pers_learning' => $result->pers_learning,
                'fullname' => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                'status' => $status,
                'admin_rloes_status' => $status,
                'img' => $result->pers_img,
                'groupleade' => $result->pers_groupleade,
                'pers_position' => $result->pers_position,
                'CheckrloesAcademic' => $status === 'superadmin' ? 'งานทะเบียน|งานวัดและประเมินผล|งานหลักสูตร|งานวิจัย|งานกิจกรรมพัฒนาผู้เรียน|งานแนะแนว' : (string)($result->academic_nanetype ?? ''),
                'CheckrloesGeneral' => (string)($result->general_nanetype ?? ''),
                'isLoggedIn' => true,
                'admin_selected_year' => $defaultYear,
            ];
            session()->set($sessionData);
            return redirect()->to(base_url('Admin/Home'));
        }
        return redirect()->to(base_url('/'))->with('error', 'ชื่อผู้ใช้งานหรือรหัสผ่าน ไม่ถูกต้อง');
    }

    public function googleLogin()
    {
        $code = $this->request->getVar('code');
        if (!$code) {
            return redirect()->to(base_url('/'))->with('error', 'การยืนยันตัวตนล้มเหลว (Missing Code)');
        }

        $config = config('Google');
        $curl = \Config\Services::curlrequest();

        try {
            // 1. Exchange code for access_token and id_token
            $response = $curl->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'code'          => $code,
                    'client_id'     => $config->clientId,
                    'client_secret' => $config->clientSecret,
                    'redirect_uri'  => base_url('Auth/googleLogin'),
                    'grant_type'    => 'authorization_code',
                ],
            ]);
            $tokens = json_decode($response->getBody(), true);

            // 2. Get user profile using access_token
            $response = $curl->get('https://www.googleapis.com/oauth2/v3/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokens['access_token'],
                ],
            ]);
            $payload = json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return redirect()->to(base_url('/'))->with('error', 'การเชื่อมต่อกับ Google ล้มเหลว: ' . $e->getMessage());
        }

        if (!$payload || !isset($payload['email'])) {
            return redirect()->to(base_url('/'))->with('error', 'ไม่สามารถดึงข้อมูลอีเมลได้');
        }

        $email = $payload['email'];
        $google_sub = $payload['sub'];

        if ($this->model->check_login_teacher($email) >= 1) {
            $result = $this->model->fetch_teacher_login($email);
            
            if ($result) {
                $status = $result->academic_status ?: 'admin';
                if (!in_array($status, ['admin', 'academic', 'general', 'superadmin', 'manager'])) {
                    return redirect()->to(base_url('/'))->with('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้');
                }
// ... (rest of update user data and session)

                $current_datetime = date('Y-m-d H:i:s');
                $user_data = [
                    'updated_at' => $current_datetime,
                    'login_oauth_uid' => $google_sub
                ];
                $this->model->Update_user_data($user_data, $email);

                // ดึงปีการศึกษาเริ่มต้นจาก tb_schoolyear เพื่อ set ลง session ตอน login
                $db = \Config\Database::connect();
                $schoolYear = $db->table('tb_schoolyear')->get()->getRow();
                $defaultYear = $schoolYear->schyear_year ?? '';

                $sessionData = [
                    'login_id' => $result->pers_id,
                    'pers_learning' => $result->pers_learning,
                    'fullname' => $result->pers_prefix . $result->pers_firstname . ' ' . $result->pers_lastname,
                    'status' => $status,
                    'admin_rloes_status' => $status,
                    'img' => $result->pers_img,
                    'groupleade' => $result->pers_groupleade,
                    'pers_position' => $result->pers_position,
                    'CheckrloesAcademic' => $status === 'superadmin' ? 'งานทะเบียน|งานวัดและประเมินผล|งานหลักสูตร|งานวิจัย|งานกิจกรรมพัฒนาผู้เรียน|งานแนะแนว' : (string)($result->academic_nanetype ?? ''),
                    'CheckrloesGeneral' => (string)($result->general_nanetype ?? ''),
                    'isLoggedIn' => true,
                    'admin_selected_year' => $defaultYear,
                ];
                session()->set($sessionData);
                return redirect()->to(base_url('Admin/Home'));
            }
        }
        
        return redirect()->to(base_url('/'))->with('error', "ไม่พบอีเมล $email ในระบบ หรือคุณไม่มีสิทธิ์เข้าใช้งาน");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
