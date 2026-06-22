<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModCompetition;

class ConCompetition extends BaseController
{
    protected $modComp;

    public function __construct()
    {
        $this->modComp = new ModCompetition();
        
        // ตรวจสอบสิทธิ์ว่าได้เข้าสู่ระบบหรือยัง (สำหรับครู) เฉพาะหน้าหลังบ้านหรือหน้าเขียน/แก้ไขข้อมูล
        $router = service('router');
        $method = $router->methodName();
        
        if (!in_array(strtolower($method), ['show', 'getdetail'])) {
            if (empty(session()->get('fullname'))) {
                // ส่งไปหน้าล็อกอินปกติ
                header('Location: ' . base_url('LoginTeacher'));
                exit();
            }
        }
    }

    /**
     * หน้าแสดงผลการแข่งขันสาธารณะ (Public View)
     */
    public function show()
    {
        // ดึงเฉพาะรายการที่ได้รับการอนุมัติแล้วเท่านั้น เพื่อความถูกต้อง
        $competitions = $this->modComp->where('comp_status', 'อนุมัติแล้ว')->orderBy('comp_id', 'DESC')->findAll();

        $data = [
            'title'        => 'ทำเนียบผลงานการแข่งขัน',
            'competitions' => $competitions
        ];

        return view('user/PageShowCompetition', $data);
    }

    /**
     * หน้าจัดการรายการแข่งขันทั้งหมด
     */
    public function index()
    {
        $userId = session()->get('login_id');
        
        // ตรวจสอบสิทธิ์ที่แท้จริงจากฐานข้อมูล
        $db = \Config\Database::connect();
        $roleData = $db->table('tb_admin_rloes')->where('admin_rloes_userid', $userId)->get()->getRow();
        $userStatus = $roleData ? $roleData->admin_rloes_status : 'teacher';

        // Admin/Superadmin/Manager เห็นข้อมูลทั้งหมด, ครูปกติเห็นเฉพาะของตัวเอง
        if (in_array($userStatus, ['admin', 'superadmin', 'manager'])) {
            $competitions = $this->modComp->orderBy('comp_id', 'DESC')->findAll();
        } else {
            $competitions = $this->modComp
                ->where('comp_usersend', $userId)
                ->orderBy('comp_id', 'DESC')
                ->findAll();
        }

        // แนบข้อมูลชื่อครูและนักเรียนของแต่ละแถวเพิ่มเติม
        foreach ($competitions as $comp) {
            $comp->students = $this->modComp->getStudentsByIds($comp->comp_student_ids);
            $comp->teachers = $this->modComp->getTeachersByIds($comp->comp_teacher_ids);
        }

        $data = [
            'title'        => 'ระบบบันทึกผลงานการแข่งขัน',
            'competitions' => $competitions,
            'userStatus'   => $userStatus
        ];

        return view('admin/Academic/AdminCompetition/manage_competition', $data);
    }

    /**
     * หน้าเพิ่มผลงานการแข่งขัน
     */
    public function create()
    {
        $data = [
            'title'  => 'เพิ่มผลงานการแข่งขัน',
            'action' => base_url('admin/academic/competition/save'),
            'comp'   => null
        ];
        return view('admin/Academic/AdminCompetition/form_competition', $data);
    }

    /**
     * หน้าแก้ไขผลงานการแข่งขัน
     */
    public function edit($id)
    {
        $comp = $this->modComp->find($id);
        if (!$comp) {
            return redirect()->to(base_url('admin/academic/competition'))->with('error', 'ไม่พบข้อมูลรายการแข่งขัน');
        }

        // ตรวจสอบสิทธิ์: ครูปกติแก้ไขได้เฉพาะข้อมูลของตัวเอง
        $userId = session()->get('login_id');
        $db = \Config\Database::connect();
        $roleData = $db->table('tb_admin_rloes')->where('admin_rloes_userid', $userId)->get()->getRow();
        $userStatus = $roleData ? $roleData->admin_rloes_status : 'teacher';

        if (!in_array($userStatus, ['admin', 'superadmin', 'manager']) && $comp->comp_usersend != $userId) {
            return redirect()->to(base_url('admin/academic/competition'))->with('error', 'คุณไม่มีสิทธิ์แก้ไขข้อมูลรายการนี้');
        }

        // ดึงรายละเอียดนักเรียนและครูที่เลือกไว้
        $selectedStudents = $this->modComp->getStudentsByIds($comp->comp_student_ids);
        $selectedTeachers = $this->modComp->getTeachersByIds($comp->comp_teacher_ids);

        $data = [
            'title'            => 'แก้ไขผลงานการแข่งขัน',
            'action'           => base_url('admin/academic/competition/update/' . $id),
            'comp'             => $comp,
            'selectedStudents' => $selectedStudents,
            'selectedTeachers' => $selectedTeachers
        ];
        return view('admin/Academic/AdminCompetition/form_competition', $data);
    }

    /**
     * บันทึกข้อมูล (Save & Update)
     */
    public function save($id = null)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'comp_name'          => 'required',
            'comp_activity'      => 'required',
            'comp_level'         => 'required',
            'comp_date'          => 'required|valid_date',
            'comp_academic_year' => 'required',
            'comp_term'          => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $comp_id = $id;
        $existingComp = $id ? $this->modComp->find($id) : null;

        // ในระบบอัปโหลดแบบ Chunk ไฟล์จะถูกส่งขึ้น Server ภายนอกล่วงหน้าผ่าน AJAX
        // และจะส่งเพียงรายชื่อไฟล์ผลลัพธ์กลับมาบันทึกในรูปแบบ JSON
        $certFilesJson = $this->request->getPost('comp_certificate_files') ?: '[]';
        $imagesJson = $this->request->getPost('comp_images') ?: '[]';

        $certFiles = json_decode($certFilesJson, true) ?: [];
        $images = json_decode($imagesJson, true) ?: [];

        // กรณีการแก้ไขข้อมูลและต้องการรวมกับไฟล์ของเดิมที่มีอยู่แล้ว
        if ($id && $existingComp) {
            $oldCerts = json_decode($existingComp->comp_certificate_files, true) ?: [];
            $oldImages = json_decode($existingComp->comp_images, true) ?: [];
            
            // นำไฟล์ใหม่ที่เพิ่งอัปโหลดสำเร็จไปรวมกับไฟล์เดิม
            $certFiles = array_merge($oldCerts, $certFiles);
            $images = array_merge($oldImages, $images);
        }

        // รับข้อมูล Array จาก Form
        $awards = $this->request->getPost('comp_awards') ?: [];
        $studentIds = $this->request->getPost('comp_student_ids') ?: [];
        $teacherIds = $this->request->getPost('comp_teacher_ids') ?: [];

        $dataSave = [
            'comp_name'              => $this->request->getPost('comp_name'),
            'comp_activity'          => $this->request->getPost('comp_activity'),
            'comp_level'             => $this->request->getPost('comp_level'),
            'comp_date'              => $this->request->getPost('comp_date'),
            'comp_location'          => $this->request->getPost('comp_location'),
            'comp_organizer'         => $this->request->getPost('comp_organizer'),
            'comp_academic_year'     => $this->request->getPost('comp_academic_year'),
            'comp_term'              => $this->request->getPost('comp_term'),
            'comp_awards'            => json_encode($awards, JSON_UNESCAPED_UNICODE),
            'comp_student_ids'       => json_encode($studentIds, JSON_UNESCAPED_UNICODE),
            'comp_teacher_ids'       => json_encode($teacherIds, JSON_UNESCAPED_UNICODE),
            'comp_certificate_files' => json_encode($certFiles, JSON_UNESCAPED_UNICODE),
            'comp_images'            => json_encode($images, JSON_UNESCAPED_UNICODE),
            'comp_usersend'          => session()->get('login_id') ?: 'guest_teacher'
        ];

        if ($id) {
            $this->modComp->update($id, $dataSave);
            $message = 'ปรับปรุงข้อมูลผลงานเรียบร้อยแล้ว';
        } else {
            $dataSave['comp_status'] = 'อนุมัติแล้ว'; // เปลี่ยนให้อนุมัติอัตโนมัติทันที
            $this->modComp->insert($dataSave);
            $message = 'บันทึกข้อมูลผลงานเรียบร้อยแล้ว';
        }

        return $this->response->setJSON(['status' => 'success', 'message' => $message]);
    }

    /**
     * เปลี่ยนสถานะการอนุมัติ (สำหรับแอดมิน)
     */
    public function updateStatus()
    {
        $id = $this->request->getPost('comp_id');
        $status = $this->request->getPost('comp_status');
        $feedback = $this->request->getPost('comp_feedback');

        if ($id && in_array($status, ['รออนุมัติ', 'อนุมัติแล้ว', 'ตีกลับ/แก้ไข'])) {
            $this->modComp->update($id, [
                'comp_status'   => $status,
                'comp_feedback' => $feedback
            ]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'ปรับปรุงสถานะสำเร็จ']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง'], 400);
    }

    /**
     * ลบรายการการแข่งขัน
     */
    public function delete($id)
    {
        $comp = $this->modComp->find($id);
        if (!$comp) {
            return redirect()->to(base_url('admin/academic/competition'))->with('error', 'ไม่พบข้อมูลรายการแข่งขัน');
        }

        // ตรวจสอบสิทธิ์: ครูปกติลบได้เฉพาะข้อมูลของตัวเอง
        $userId = session()->get('login_id');
        $db = \Config\Database::connect();
        $roleData = $db->table('tb_admin_rloes')->where('admin_rloes_userid', $userId)->get()->getRow();
        $userStatus = $roleData ? $roleData->admin_rloes_status : 'teacher';

        if (!in_array($userStatus, ['admin', 'superadmin', 'manager']) && $comp->comp_usersend != $userId) {
            return redirect()->to(base_url('admin/academic/competition'))->with('error', 'คุณไม่มีสิทธิ์ลบข้อมูลรายการนี้');
        }

        if ($this->modComp->delete($id)) {
            return redirect()->to(base_url('admin/academic/competition'))->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
        }
        return redirect()->to(base_url('admin/academic/competition'))->with('error', 'ไม่สามารถลบข้อมูลได้');
    }

    /**
     * ดึงรายละเอียดรายการแข่งเพื่อแสดงใน Modal รายละเอียด (AJAX)
     */
    public function getDetail($id)
    {
        $comp = $this->modComp->find($id);
        if (!$comp) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล'], 404);
        }

        $students = $this->modComp->getStudentsByIds($comp->comp_student_ids);
        $teachers = $this->modComp->getTeachersByIds($comp->comp_teacher_ids);

        // แปลงวันที่เป็น พ.ศ.
        $thaiDate = '';
        if ($comp->comp_date) {
            $date = strtotime($comp->comp_date);
            $day = date('j', $date);
            $months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            $month = $months[date('n', $date)];
            $year = date('Y', $date) + 543;
            $thaiDate = "$day $month $year";
        }

        return $this->response->setJSON([
            'status'    => 'success',
            'comp'      => $comp,
            'thaiDate'  => $thaiDate,
            'students'  => $students,
            'teachers'  => $teachers,
            'awards'    => json_decode($comp->comp_awards) ?: [],
            'certs'     => json_decode($comp->comp_certificate_files) ?: [],
            'images'    => json_decode($comp->comp_images) ?: []
        ]);
    }

    /**
     * API ค้นหานักเรียน (Select2)
     */
    public function searchStudents()
    {
        $keyword = $this->request->getVar('q') ?: '';
        $results = $this->modComp->searchStudents($keyword);
        return $this->response->setJSON($results);
    }

    /**
     * API ค้นหาครู (Select2)
     */
    public function searchTeachers()
    {
        $keyword = $this->request->getVar('q') ?: '';
        $results = $this->modComp->searchTeachers($keyword);
        return $this->response->setJSON($results);
    }

    /**
     * Proxy อัปโหลดไฟล์ชิ้นส่วนแบบ Chunk เพื่อส่งต่อไปที่เครื่องเซิร์ฟเวอร์อัปโหลดหลักภายนอก
     */
    public function upload_proxy()
    {
        $file = $this->request->getFile('file');
        if (!$file) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบไฟล์ที่ถูกส่งมา (ไม่พบข้อมูลในคีย์ file)']);
        }
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'ไฟล์ชิ้นส่วนไม่สมบูรณ์: ' . $file->getErrorString()
            ]);
        }

        $path = $this->request->getPost('path') ?: 'academic/competitions/general';
        $originalName = $this->request->getPost('filename') ?: $file->getRandomName();

        // รับข้อมูล Chunk Info
        $chunkIndex = $this->request->getPost('chunk_index');
        $totalChunks = $this->request->getPost('total_chunks');

        // หากเป็นไฟล์ขนาดเล็ก (ไม่มีการแบ่ง Chunk) ให้ยิงส่งตรงไปเลย
        if ($chunkIndex === null || $totalChunks === null) {
            $target_url = getenv('upload.server.url') ?: 'https://skj.nsnpao.go.th/upload.php';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'file'     => new \CURLFile($file->getTempName(), $file->getClientMimeType(), $originalName),
                'path'     => $path,
                'filename' => $originalName
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($error) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Proxy Connection Error: ' . $error]);
            }
            if ($httpCode >= 400) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เซิร์ฟเวอร์หลักภายนอกปฏิเสธการเชื่อมต่อ (HTTP ' . $httpCode . ')']);
            }

            return $this->response->setBody($response)->setContentType('application/json');
        }

        // กรณีเป็น Chunked upload:
        $chunkIndex = (int)$chunkIndex;
        $totalChunks = (int)$totalChunks;

        $temp_dir = WRITEPATH . 'uploads/chunks/';
        if (!is_dir($temp_dir)) {
            mkdir($temp_dir, 0777, true);
        }

        // ตั้งชื่อไฟล์ชั่วคราวที่ไม่ซ้ำกัน
        $temp_filename = md5(session()->get('login_id') . '_' . $originalName) . '.tmp';
        $temp_filepath = $temp_dir . $temp_filename;

        // บันทึกและนำเนื้อหาชิ้นส่วนไปต่อท้ายไฟล์เดิม (FILE_APPEND)
        $chunk_content = file_get_contents($file->getTempName());
        if ($chunkIndex === 0) {
            file_put_contents($temp_filepath, $chunk_content);
        } else {
            file_put_contents($temp_filepath, $chunk_content, FILE_APPEND);
        }

        // ถ้าส่งมาจนถึงชิ้นส่วนสุดท้ายแล้ว ให้รวมไฟล์และยิงต่อไปยังเซิร์ฟเวอร์ภายนอก
        if ($chunkIndex === $totalChunks - 1) {
            if (!file_exists($temp_filepath) || filesize($temp_filepath) === 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไฟล์ชิ้นส่วนสูญหายหรือไม่สามารถรวมไฟล์ได้']);
            }

            $target_url = getenv('upload.server.url') ?: 'https://skj.nsnpao.go.th/upload.php';
            $mime_type = $file->getClientMimeType() ?: 'application/octet-stream';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'file'     => new \CURLFile($temp_filepath, $mime_type, $originalName),
                'path'     => $path,
                'filename' => $originalName
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // ลบไฟล์ชั่วคราวออกเพื่อป้องกันขยะในเซิร์ฟเวอร์
            if (file_exists($temp_filepath)) {
                unlink($temp_filepath);
            }

            if ($error) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Proxy Error on assembly: ' . $error]);
            }
            if ($httpCode === 413) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เซิร์ฟเวอร์ปลายทางปฏิเสธการอัปโหลด (HTTP 413 - Payload Too Large): ไฟล์ที่ประกอบเสร็จมีขนาดใหญ่เกินขีดจำกัดของเซิร์ฟเวอร์ปลายทาง กรุณาลดขนาดมิติรูปภาพหรือคุณภาพไฟล์ PDF ก่อนทำการส่งใหม่อีกครั้ง'
                ]);
            }
            if ($httpCode >= 400) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เซิร์ฟเวอร์ภายนอกล้มเหลวขณะรวมไฟล์ชิ้นส่วนสุดท้าย (HTTP ' . $httpCode . ')']);
            }

            return $this->response->setBody($response)->setContentType('application/json');
        }

        // คืนค่า chunk_saved กลับไปเพื่อให้ JavaScript ส่งชิ้นถัดไป
        return $this->response->setJSON([
            'status' => 'chunk_saved',
            'chunk_index' => $chunkIndex,
            'total_chunks' => $totalChunks
        ]);
    }
}
