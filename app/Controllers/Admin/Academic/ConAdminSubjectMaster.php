<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminSubjectMaster;

class ConAdminSubjectMaster extends BaseController
{
    protected $modAdminSubjectMaster;
    protected $DBpersonnel;
    protected $db;

    public function __construct()
    {
        $this->modAdminSubjectMaster = new ModAdminSubjectMaster();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect();

        helper(['url', 'form']);

        if (empty(session()->get('fullname'))) {
            redirect()->to(base_url('LogoutTeacher'))->send();
            exit();
        }

        $check_status_data = $this->db->table('tb_admin_rloes')
            ->where('admin_rloes_userid', session()->get('login_id'))
            ->get()->getRow();

        if (empty($check_status_data) || (!in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธิ์ในระบบนี้ ติดต่อผู้ดูแลระบบ', 'alert' => 'error']);
            redirect()->to(base_url('welcome'))->send();
            exit();
        }
    }

    /**
     * หน้าหลักคลังรายวิชาหลักสูตรกลาง
     */
    public function index()
    {
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')
            ->select('pers_id, pers_img')
            ->where('pers_id', session()->get('login_id'))
            ->get()->getRow();

        $data['title']         = "คลังรายวิชาหลักสูตรกลาง";
        $data['classroom']     = new \App\Libraries\Classroom();
        $data['stats']         = $this->modAdminSubjectMaster->getStatistics();
        $data['filterOptions'] = $this->modAdminSubjectMaster->getFilterOptions();

        return view('admin/Academic/AdminSubjectMaster/AdminSubjectMasterMain', $data);
    }

    /**
     * ดึงข้อมูลสำหรับ DataTable
     */
    public function getMasterSubjectsSelect()
    {
        $filters = [
            'first_group'   => $this->request->getPost('first_group'),
            'subject_class' => $this->request->getPost('subject_class'),
            'subject_type'  => $this->request->getPost('subject_type'),
        ];

        $records = $this->modAdminSubjectMaster->getMasterSubjects($filters);
        $data = [];

        foreach ($records as $row) {
            $data[] = [
                'master_id'     => $row->master_id,
                'subject_code'  => $row->subject_code,
                'subject_name'  => $row->subject_name,
                'subject_unit'  => $row->subject_unit,
                'subject_hour'  => $row->subject_hour,
                'subject_type'  => $row->subject_type,
                'first_group'   => $row->first_group,
                'second_group'  => $row->second_group,
                'subject_class' => $row->subject_class,
                'updated_at'    => $row->updated_at
            ];
        }

        return $this->response->setJSON([
            'data'  => $data,
            'stats' => $this->modAdminSubjectMaster->getStatistics()
        ]);
    }

    /**
     * เพิ่มรายวิชาใหม่เข้าคลังกลาง
     */
    public function insert()
    {
        $code  = trim($this->request->getPost('subject_code'));
        $class = trim($this->request->getPost('subject_class'));

        // ตรวจสอบความซ้ำซ้อน
        $check = $this->modAdminSubjectMaster
            ->where('subject_code', $code)
            ->where('subject_class', $class)
            ->countAllResults();

        if ($check > 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "รหัสวิชา {$code} ในระดับชั้น {$class} มีอยู่ในคลังรายวิชากลางแล้ว"
            ]);
        }

        $data = [
            'subject_code'  => $code,
            'subject_name'  => trim($this->request->getPost('subject_name')),
            'subject_unit'  => trim($this->request->getPost('subject_unit')),
            'subject_hour'  => (int)$this->request->getPost('subject_hour'),
            'subject_type'  => trim($this->request->getPost('subject_type')),
            'first_group'   => trim($this->request->getPost('first_group')),
            'second_group'  => trim($this->request->getPost('second_group')),
            'subject_class' => $class,
        ];

        if ($this->modAdminSubjectMaster->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'บันทึกรายวิชาเข้าคลังกลางสำเร็จ'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
        ]);
    }

    /**
     * ดึงข้อมูลสำหรับ Modal แก้ไข
     */
    public function edit($id)
    {
        $subject = $this->modAdminSubjectMaster->find($id);
        if (!$subject) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบข้อมูลรายวิชาที่ระบุ'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $subject
        ]);
    }

    /**
     * อัปเดตข้อมูลรายวิชา
     */
    public function update()
    {
        $id    = $this->request->getPost('master_id');
        $code  = trim($this->request->getPost('subject_code'));
        $class = trim($this->request->getPost('subject_class'));

        $subject = $this->modAdminSubjectMaster->find($id);
        if (!$subject) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบข้อมูลรายวิชาที่ต้องการแก้ไข'
            ]);
        }

        // ตรวจสอบความซ้ำซ้อนกับรายการอื่น
        $check = $this->modAdminSubjectMaster
            ->where('subject_code', $code)
            ->where('subject_class', $class)
            ->where('master_id !=', $id)
            ->countAllResults();

        if ($check > 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "รหัสวิชา {$code} ในระดับชั้น {$class} มีอยู่แล้วในรายการอื่น"
            ]);
        }

        $data = [
            'subject_code'  => $code,
            'subject_name'  => trim($this->request->getPost('subject_name')),
            'subject_unit'  => trim($this->request->getPost('subject_unit')),
            'subject_hour'  => (int)$this->request->getPost('subject_hour'),
            'subject_type'  => trim($this->request->getPost('subject_type')),
            'first_group'   => trim($this->request->getPost('first_group')),
            'second_group'  => trim($this->request->getPost('second_group')),
            'subject_class' => $class,
        ];

        if ($this->modAdminSubjectMaster->update($id, $data)) {
            // ซิงค์การเปลี่ยนแปลงไปยัง tb_subjects (รายวิชาประจำเทอมทั้งหมด) และ tb_teaching_schedule
            $oldCode = $subject->subject_code ?? ($subject['subject_code'] ?? $code);
            $oldClass = $subject->subject_class ?? ($subject['subject_class'] ?? $class);
            $this->propagateMasterToSemesterSubjects($oldCode, $oldClass, $data);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'ปรับปรุงข้อมูลรายวิชาในคลังกลาง และซิงค์ข้อมูลไปยังรายวิชาประจำเทอมเรียบร้อยแล้ว'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'เกิดข้อผิดพลาดในการปรับปรุงข้อมูล'
        ]);
    }

    /**
     * ซิงค์ข้อมูลที่แก้ไขในคลังกลางไปยัง tb_subjects และ tb_teaching_schedule ทุกภาคเรียน
     */
    protected function propagateMasterToSemesterSubjects($oldCode, $oldClass, array $masterData)
    {
        try {
            $tbSubjectUpdate = [
                'SubjectCode'  => $masterData['subject_code'],
                'SubjectName'  => $masterData['subject_name'],
                'SubjectUnit'  => $masterData['subject_unit'],
                'SubjectHour'  => $masterData['subject_hour'],
                'SubjectType'  => $masterData['subject_type'],
                'FirstGroup'   => $masterData['first_group'],
                'SecondGroup'  => $masterData['second_group'],
                'SubjectClass' => $masterData['subject_class'],
            ];

            if (!empty($oldCode)) {
                $builder = $this->db->table('tb_subjects')->where('SubjectCode', $oldCode);
                if (!empty($oldClass)) {
                    $builder->where('SubjectClass', $oldClass);
                }
                $builder->update($tbSubjectUpdate);
            }

            if ($this->db->tableExists('tb_teaching_schedule') && !empty($oldCode)) {
                $this->db->table('tb_teaching_schedule')
                    ->where('subject_code', $oldCode)
                    ->update([
                        'subject_code' => $masterData['subject_code'],
                        'subject_name' => $masterData['subject_name'],
                        'subject_type' => $masterData['subject_type'],
                        'credit'       => (float)$masterData['subject_unit'],
                        'total_hours'  => (int)$masterData['subject_hour'],
                    ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Propagate master subject update error: ' . $e->getMessage());
        }
    }

    /**
     * ลบรายวิชาออกจากคลังกลาง
     */
    public function delete($id)
    {
        if ($this->modAdminSubjectMaster->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'ลบรายวิชาออกจากคลังกลางสำเร็จ'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
        ]);
    }

    /**
     * ซิงค์ข้อมูลนำเข้าจาก Google Sheets CSV กลาง
     */
    public function syncFromGoogleSheets()
    {
        $csvUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSkmM4H4BP9GDxlVIHb7Eon1xR1jqwmeASdrKAfJLJ3Iplg1cRZGmgkNhNX5Q6ZkrhDSx95WF7h8HHE/pub?output=csv";

        $client = \Config\Services::curlrequest([
            'timeout' => 30,
            'verify'  => false
        ]);

        try {
            $response = $client->get($csvUrl);
            $csvText  = $response->getBody();

            if (empty($csvText)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'ไม่สามารถดาวน์โหลดข้อมูลจาก Google Sheets ได้'
                ]);
            }

            // แยกแถว
            $lines = preg_split('/\r\n|\r|\n/', trim($csvText));
            if (count($lines) < 2) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'ข้อมูลในไฟล์ CSV ว่างเปล่าหรือไม่ถูกต้อง'
                ]);
            }

            $subjects = [];
            // ข้าม header บรรทัดแรก
            for ($i = 1; $i < count($lines); $i++) {
                $line = trim($lines[$i]);
                if (empty($line)) continue;

                $row = str_getcsv($line);
                if (count($row) < 2) continue;

                $subjects[] = [
                    'subject_code'  => $row[0] ?? '',
                    'subject_name'  => $row[1] ?? '',
                    'subject_unit'  => $row[2] ?? '',
                    'subject_hour'  => $row[3] ?? '',
                    'subject_type'  => $row[4] ?? '',
                    'first_group'   => $row[5] ?? '',
                    'second_group'  => $row[6] ?? '',
                    'subject_class' => $row[7] ?? ''
                ];
            }

            $result = $this->modAdminSubjectMaster->syncBatch($subjects);

            if ($result === false) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล'
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => "ซิงค์ข้อมูลสำเร็จ! เพิ่มใหม่ {$result['inserted']} รายการ, อัปเดต {$result['updated']} รายการ (รวม {$result['total']} รายการ)",
                'stats'   => $this->modAdminSubjectMaster->getStatistics()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * API ส่งข้อมูลวิชากลางสำหรับหน้าเลือกวิชาลงทะเบียน (RegisterSubject)
     */
    public function getForRegister()
    {
        $class = $this->request->getGet('class') ?: $this->request->getPost('class');
        $filters = [];
        if (!empty($class)) {
            $filters['subject_class'] = $class;
        }

        $records = $this->modAdminSubjectMaster->getMasterSubjects($filters);

        $data = [];
        foreach ($records as $sub) {
            $data[] = [
                'code'        => $sub->subject_code,
                'name'        => $sub->subject_name,
                'unit'        => $sub->subject_unit,
                'hour'        => $sub->subject_hour,
                'type'        => $sub->subject_type,
                'firstGroup'  => $sub->first_group,
                'secondGroup' => $sub->second_group,
                'class'       => $sub->subject_class,
                'searchString'=> strtolower($sub->subject_code . ' ' . $sub->subject_name)
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data,
            'total'  => count($data)
        ]);
    }
}
