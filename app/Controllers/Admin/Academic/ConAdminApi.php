<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminApi extends BaseController
{
    protected $db;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->db = \Config\Database::connect('default');
        $this->DBpersonnel = \Config\Database::connect('personnel');

        helper(['url', 'form']);

        if (empty(session()->get('fullname'))) {
            header('Location: ' . base_url('LogoutTeacher'));
            exit();
        }
    }

    public function index()
    {
        $data['title'] = "จัดการ API";
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')
                                           ->select('pers_id, pers_img')
                                           ->where('pers_id', session()->get('login_id'))
                                           ->get()
                                           ->getRow();

        // API Configuration (Hardcoded for now as per implementation)
        $data['api_key'] = getenv('API_KEY') ?: 'skj_api_secret_2025';
        $data['base_url'] = base_url('api/v1');

        $data['endpoints'] = [
            [
                'name' => 'สถิติจำนวนนักเรียน (ม.1-ม.6)',
                'method' => 'GET',
                'url' => base_url('api/v1/students/stats'),
                'desc' => 'จำนวนนักเรียนแยกตามระดับชั้นและเพศ'
            ],
            [
                'name' => 'สถิติการจบการศึกษา',
                'method' => 'GET',
                'url' => base_url('api/v1/students/graduation-stats'),
                'desc' => 'สถิติเด็กจบการศึกษาแยกตามปีและเพศ พร้อมคำนวณ %'
            ],
            [
                'name' => 'รายชื่อนักเรียน',
                'method' => 'GET',
                'url' => base_url('api/v1/students'),
                'desc' => 'ค้นหาด้วยชื่อหรือห้องเรียน (?q=ชื่อ หรือ ?class=1/1)'
            ],
            [
                'name' => 'รายชื่อบุคลากร/ครู',
                'method' => 'GET',
                'url' => base_url('api/v1/personnel'),
                'desc' => 'ดึงข้อมูลบุคลากรทั้งหมด'
            ],
            [
                'name' => 'รายวิชา',
                'method' => 'GET',
                'url' => base_url('api/v1/subjects'),
                'desc' => 'ดึงข้อมูลวิชาที่เปิดสอนตามปีการศึกษา (?year=2568)'
            ]
        ];

        return view('admin/Academic/AdminApi/Dashboard', $data);
    }
}
