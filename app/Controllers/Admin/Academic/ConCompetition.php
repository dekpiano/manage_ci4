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

        // กรณีการแก้ไขข้อมูล
        if ($id && $existingComp) {
            $oldCerts = json_decode($existingComp->comp_certificate_files, true) ?: [];
            $oldImages = json_decode($existingComp->comp_images, true) ?: [];
            
            // ถ้ามีการอัปโหลดเกียรติบัตรใหม่ ให้ลบของเก่าทิ้งและใช้ของใหม่แทน
            if (!empty($certFiles)) {
                if (!empty($oldCerts)) {
                    $this->deleteFromRemoteApi('academic/competitions/certificates', $oldCerts);
                }
            } else {
                // ถ้าไม่มีการอัปโหลดใหม่ ให้คงของเก่าไว้
                $certFiles = $oldCerts;
            }

            // ถ้ามีการอัปโหลดรูปภาพใหม่ ให้ลบของเก่าทิ้งและใช้ของใหม่แทน
            if (!empty($images)) {
                if (!empty($oldImages)) {
                    $this->deleteFromRemoteApi('academic/competitions/images', $oldImages);
                }
            } else {
                // ถ้าไม่มีการอัปโหลดใหม่ ให้คงของเก่าไว้
                $images = $oldImages;
            }
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
     * ส่งคำขอลบไฟล์ไปยังเซิร์ฟเวอร์หลักปลายทาง
     */
    private function deleteFromRemoteApi($path, array $fileNames)
    {
        $deleteUrl = getenv('upload.server.delete.url') ?: 'https://skj.nsnpao.go.th/delete.php';
        $client = \Config\Services::curlrequest();
        $token = getenv('upload.server.token') ?: 'Dekpiano2025!!';

        log_message('info', 'Attempting remote delete. URL: ' . $deleteUrl . ', Path: ' . $path . ', Files: ' . json_encode($fileNames));

        try {
            $response = $client->setJSON([
                'path' => $path,
                'files' => $fileNames
            ])->setHeader('X-Auth-Token', $token)
              ->request('POST', $deleteUrl);
            
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            
            log_message('info', 'Remote delete response code: ' . $statusCode . ', Body: ' . $body);

            if ($statusCode === 200) {
                $decoded = json_decode($body);
                if ($decoded && isset($decoded->status) && $decoded->status === 'success') {
                    return true;
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete remote files for path ' . $path . ': ' . $e->getMessage());
        }
        return false;
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

        // ลบเกยรติบัตรบนเซิร์ฟเวอร์ปลายทาง
        if (!empty($comp->comp_certificate_files)) {
            $certs = json_decode($comp->comp_certificate_files, true);
            if (is_array($certs) && !empty($certs)) {
                $this->deleteFromRemoteApi('academic/competitions/certificates', $certs);
            }
        }

        // ลบรูปภาพกิจกรรมบนเซิร์ฟเวอร์ปลายทาง
        if (!empty($comp->comp_images)) {
            $images = json_decode($comp->comp_images, true);
            if (is_array($images) && !empty($images)) {
                $this->deleteFromRemoteApi('academic/competitions/images', $images);
            }
        }

        if ($this->modComp->delete($id)) {
            return redirect()->to(base_url('admin/academic/competition'))->with('success', 'ลบข้อมูลและไฟล์แนบเรียบร้อยแล้ว');
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
     * ช่วยย่อขนาดและบีบอัดรูปภาพเพื่อลดขนาดไฟล์ก่อนส่งต่อไปยังเซิร์ฟเวอร์หลัก
     */
    private function compressImageIfNeeded($filePath, $filename)
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($extension, $allowedExtensions)) {
            return;
        }

        // โหลดรูปภาพตามประเภท
        $image = null;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (function_exists('imagecreatefromjpeg')) {
                    $image = @imagecreatefromjpeg($filePath);
                }
                break;
            case 'png':
                if (function_exists('imagecreatefrompng')) {
                    $image = @imagecreatefrompng($filePath);
                }
                break;
            case 'webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = @imagecreatefromwebp($filePath);
                }
                break;
            case 'gif':
                if (function_exists('imagecreatefromgif')) {
                    $image = @imagecreatefromgif($filePath);
                }
                break;
        }

        if (!$image) {
            return; // ไม่สามารถโหลดรูปภาพได้ ให้ข้ามไปใช้ไฟล์เดิม
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $maxDimension = 1200; // จำกัดความกว้าง/สูงสูงสุด 1200px
        $quality = 70;       // คุณภาพ 70%

        // ถ้ารูปมีขนาดใหญ่เกินไป ให้ย่อขนาดลงก่อน
        if ($width > $maxDimension || $height > $maxDimension) {
            if ($width > $height) {
                $newWidth = $maxDimension;
                $newHeight = (int)($height * ($maxDimension / $width));
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int)($width * ($maxDimension / $height));
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // รักษาความโปร่งใสสำหรับ PNG/WebP/GIF
            if ($extension === 'png' || $extension === 'webp' || $extension === 'gif') {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $newImage;
        }

        // เซฟทับไฟล์เดิมด้วยการบีบอัดคุณภาพ
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (function_exists('imagejpeg')) {
                    imagejpeg($image, $filePath, $quality);
                }
                break;
            case 'png':
                if (function_exists('imagepng')) {
                    // PNG compression level 0-9
                    imagepng($image, $filePath, 7);
                }
                break;
            case 'webp':
                if (function_exists('imagewebp')) {
                    imagewebp($image, $filePath, $quality);
                }
                break;
            case 'gif':
                if (function_exists('imagegif')) {
                    imagegif($image, $filePath);
                }
                break;
        }

        imagedestroy($image);
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

        log_message('error', 'Upload Proxy Chunk Data: chunk_index=' . var_export($chunkIndex, true) . ', total_chunks=' . var_export($totalChunks, true) . ', filename=' . $originalName);

        $target_url = getenv('upload.server.url') ?: 'https://skj.nsnpao.go.th/upload.php';
        $token = getenv('upload.server.token') ?: 'Dekpiano2025!!';

        // เตรียมข้อมูลส่งต่อ
        $postFields = [
            'path'     => $path,
            'filename' => $originalName
        ];

        // ถ้าเป็น Chunked upload ให้แนบข้อมูล Chunk ไปด้วยเพื่อให้เซิร์ฟเวอร์ปลายทางประกอบไฟล์
        if ($chunkIndex !== null && $totalChunks !== null) {
            $postFields['chunk_index'] = (string)$chunkIndex;
            $postFields['total_chunks'] = (string)$totalChunks;
        }

        $filePath = $file->getTempName();

        // บีบอัดและย่อรูปภาพก่อนส่ง (กรณีไม่ใช่ Chunked และเป็นไฟล์รูปภาพ)
        if ($chunkIndex === null || $totalChunks === null) {
            $this->compressImageIfNeeded($filePath, $originalName);
        }

        $postFields['file'] = new \CURLFile($filePath, $file->getClientMimeType(), $originalName);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Auth-Token: ' . $token
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Proxy Connection Error: ' . $error]);
        }

        if ($httpCode === 413) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'เซิร์ฟเวอร์ปลายทางปฏิเสธการอัปโหลด (HTTP 413 - Payload Too Large): ขนาดไฟล์หรือชิ้นส่วนใหญ่เกินขีดจำกัดของเซิร์ฟเวอร์ปลายทาง กรุณาลดขนาดมิติรูปภาพหรือคุณภาพไฟล์ PDF ก่อนทำการส่งใหม่อีกครั้ง'
            ]);
        }

        if ($httpCode >= 400) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เซิร์ฟเวอร์หลักภายนอกปฏิเสธการเชื่อมต่อ (HTTP ' . $httpCode . ')']);
        }

        return $this->response->setBody($response)->setContentType('application/json');
    }

}
