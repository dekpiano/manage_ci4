<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModAdminCharacteristics;

class ConAdminCharacteristics extends BaseController
{
    protected $ModAdminCharacteristics;
    protected $setting_name = 'DesirableCharacteristics';
    protected $DBpersonnel;
    protected $db;

    public function __construct()
    {
        $this->ModAdminCharacteristics = new ModAdminCharacteristics();
        $this->DBpersonnel = \Config\Database::connect('personnel'); // Initialize DBpersonnel
        $this->db = \Config\Database::connect(); // Initialize the default database connection
    }

    public function index()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        $settings = $this->ModAdminCharacteristics->getSettings($this->setting_name);
        
        // If settings don't exist, create a default placeholder
        if (!$settings) {
            $settings = (object)[
                'onoff_status' => 'off',
                'onoff_year' => get_selected_year(),
                'onoff_name' => $this->setting_name
            ];
        } elseif (empty($settings->onoff_year)) {
            $settings->onoff_year = get_selected_year();
        }

        // Generate year/term combinations
        $years = [];
        $current_buddhist_year = date('Y') + 543;
        for ($i = $current_buddhist_year + 2; $i >= 2565; $i--) {
            for ($j = 2; $j >= 1; $j--) {
                $years[] = (object)['year_term' => $j . '/' . $i];
            }
        }

        $data['title'] = 'ตั้งค่าระบบประเมินคุณลักษณะอันพึงประสงค์';
        $data['settings'] = $settings;
        $data['school_years'] = $years;

        return view('admin/Academic/AdminCharacteristics/index', $data);
    }

    public function update()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        if (!$this->request->is('post') && strtolower((string)$this->request->getMethod()) !== 'post') {
            return redirect()->to('admin/academic/characteristics/settings')->with('error', 'Invalid request method.');
        }

        $status = $this->request->getPost('status') === 'on' ? 'on' : 'off';
        $yearTerm = $this->request->getPost('year_term');

        $data = [
            'onoff_status' => $status,
            'onoff_year' => $yearTerm
        ];

        if ($this->ModAdminCharacteristics->updateSettings($this->setting_name, $data)) {
            session()->setFlashdata('swal_alert', [
                'type' => 'success',
                'title' => 'สำเร็จ!',
                'text' => 'บันทึกการตั้งค่าเรียบร้อยแล้ว'
            ]);
        } else {
            session()->setFlashdata('swal_alert', [
                'type' => 'error',
                'title' => 'ผิดพลาด!',
                'text' => 'ไม่สามารถบันทึกการตั้งค่าได้'
            ]);
        }

        return redirect()->to('admin/academic/characteristics/settings');
    }
}
