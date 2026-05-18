<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminClassSchedule;
use CodeIgniter\Files\File; // For upload class

class ConAdminClassSchedule extends BaseController
{
    protected $modAdminClassSchedule;
    protected $upload;
    protected $image_lib;

    public function __construct()
    {
        $this->modAdminClassSchedule = new ModAdminClassSchedule();
        $this->upload = service('upload'); // CI4 Upload service
        $this->image_lib = service('image'); // CI4 Image manipulation service
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function AdminClassScheduleMain()
    {
        $DBpersonnel = \Config\Database::connect('personnel');

        $data['admin'] = $DBpersonnel->table('tb_personnel')
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ตารางเรียน";

        $eX = explode('/', $data['SchoolYear']->schyear_year);

        $data['class_schedule'] = $this->db->table('tb_class_schedule')
                                        ->orderBy('schestu_classname', 'ASC')
                                        ->get()->getResult();

        $data['YearAll'] = $this->db->table('tb_class_schedule')
                                    ->select('CONCAT(schestu_term,"/",schestu_year) AS Year')
                                    ->groupBy('schestu_term')
                                    ->groupBy('schestu_year')
                                    ->orderBy('schestu_year', 'DESC')
                                    ->orderBy('schestu_term', 'DESC')
                                    ->get()->getResult();

        // Ensure the current active school year is always present in YearAll to prevent empty dropdown
        $currentActiveYear = isset($data['SchoolYear']->schyear_year) ? $data['SchoolYear']->schyear_year : '';
        $hasCurrent = false;
        foreach ($data['YearAll'] as $v) {
            if ($v->Year === $currentActiveYear) {
                $hasCurrent = true;
                break;
            }
        }
        if (!$hasCurrent && !empty($currentActiveYear)) {
            $newYear = new \stdClass();
            $newYear->Year = $currentActiveYear;
            array_unshift($data['YearAll'], $newYear);
        }

        session()->set('SchoolYear', $data['SchoolYear']->schyear_year);
        
        echo view('admin/Academic/AdminClassSchedule/AdminClassScheduleMain', $data);
        
    }
    
    public function add()
    {
        return redirect()->to(base_url('Admin/Acade/Course/ClassSchedule?action=add'));
    }

    public function insert_class_schedule()
    {
        $schestu_id_form = $this->request->getPost('schestu_id');
        $term = $this->request->getPost('schestu_term');
        $year = $this->request->getPost('schestu_year');
        $remoteFileName = $this->request->getPost('schestu_filename');

        if (empty($remoteFileName)) {
            return $this->response->setJSON(['success' => false, 'error' => 'ไม่พบไฟล์ที่อัปโหลด หรือการอัพโหลดไม่สมบูรณ์']);
        }

        // Check if updating or inserting
        $check = $this->modAdminClassSchedule->where('schestu_id', $schestu_id_form)->first();
        
        if ($check) {
            // Update
            $dat_save = [
                'schestu_name'      => $this->request->getPost('schestu_name'),
                'schestu_classname' => $this->request->getPost('schestu_classname'),
                'schestu_filename'  => $remoteFileName, 
                'schestu_term'      => $term,
                'schestu_year'      => $year,
                'schestu_datetime'  => date('Y-m-d H:i:s'),
                'schestu_user'      => session()->get('login_id'),
            ];
            $result = $this->modAdminClassSchedule->class_schedule_update($dat_save, $schestu_id_form);
        } else {
            // Insert - Generate new ID like Exam Schedule
            $latest = $this->db->table('tb_class_schedule')
                                ->orderBy('schestu_id', 'DESC')
                                ->limit(1)
                                ->get()->getRow();

            $new_id = 'schestu_001';
            if (!empty($latest)) {
                $num_part = explode("_", $latest->schestu_id)[1] ?? 0;
                $new_id = 'schestu_' . sprintf("%03d", (int)$num_part + 1);
            }

            $dat_save = [
                'schestu_id'        => $new_id,
                'schestu_name'      => $this->request->getPost('schestu_name'),
                'schestu_classname' => $this->request->getPost('schestu_classname'),
                'schestu_filename'  => $remoteFileName, 
                'schestu_term'      => $term,
                'schestu_year'      => $year,
                'schestu_datetime'  => date('Y-m-d H:i:s'),
                'schestu_user'      => session()->get('login_id'),
            ];
            $result = $this->modAdminClassSchedule->class_schedule_insert($dat_save);
        }

        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้ กรุณาตรวจสอบข้อมูลอีกครั้ง']);
        }
    }

    public function upload_proxy()
    {
        $file = $this->request->getFile('schestu_filename');
        if (!$file) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No file uploaded or retrieved under key "schestu_filename".']);
        }
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'ไฟล์ไม่สมบูรณ์: รหัสข้อผิดพลาด ' . $file->getError() . ' (' . $file->getErrorString() . ')'
            ]);
        }

        $term = $this->request->getPost('term');
        $year = $this->request->getPost('year');
        $path = 'academic/ClassSchedule/' . $year . '/' . $term;

        // Use filename from JS if provided, otherwise generate one
        $requestedName = $this->request->getPost('filename');
        if ($requestedName) {
            $originalName = $requestedName;
        } else {
            $classname = $this->request->getPost('classname');
            $cleanClassName = str_replace(['/', '\\'], '-', $classname);
            $originalName = $year . '-' . $term . '-Room-' . $cleanClassName . '.jpg';
        }

        // Get Chunk Info
        $chunkIndex = $this->request->getPost('chunk_index');
        $totalChunks = $this->request->getPost('total_chunks');

        // If not chunked, standard direct upload
        if ($chunkIndex === null || $totalChunks === null) {
            $target_url = getenv('upload.server.url');
            if (!$target_url) {
                $target_url = 'https://skj.nsnpao.go.th/upload.php'; // Fallback if env is missing
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, true);
            
            $post_data = [
                'file'     => new \CURLFile($file->getTempName(), $file->getClientMimeType(), $originalName),
                'path'     => $path,
                'filename' => $originalName
            ];
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($error) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Proxy Error: ' . $error]);
            }

            if ($httpCode >= 400) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เซิร์ฟเวอร์ปลายทางปฏิเสธไฟล์ (HTTP ' . $httpCode . ') — ไฟล์อาจมีขนาดใหญ่เกินไป'
                ]);
            }

            $decoded = json_decode($response);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เซิร์ฟเวอร์ปลายทางตอบกลับรูปแบบไม่ถูกต้อง (HTTP ' . $httpCode . ')'
                ]);
            }

            return $this->response->setBody($response)->setContentType('application/json');
        }

        // Chunked upload handling
        $chunkIndex = (int)$chunkIndex;
        $totalChunks = (int)$totalChunks;

        $temp_dir = WRITEPATH . 'uploads/chunks/';
        if (!is_dir($temp_dir)) {
            mkdir($temp_dir, 0777, true);
        }

        // Create a unique temporary filename based on session and sanitised filename
        $temp_filename = md5(session()->get('login_id') . '_' . $originalName) . '.tmp';
        $temp_filepath = $temp_dir . $temp_filename;

        // Write/Append chunk data
        $chunk_content = file_get_contents($file->getTempName());
        if ($chunkIndex === 0) {
            file_put_contents($temp_filepath, $chunk_content);
        } else {
            file_put_contents($temp_filepath, $chunk_content, FILE_APPEND);
        }

        // If it's the final chunk, assemble and upload to remote server
        if ($chunkIndex === $totalChunks - 1) {
            if (!file_exists($temp_filepath) || filesize($temp_filepath) === 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ไฟล์ชิ้นส่วนสูญหายหรือไม่สามารถรวมไฟล์ได้']);
            }

            $target_url = getenv('upload.server.url');
            if (!$target_url) {
                $target_url = 'https://skj.nsnpao.go.th/upload.php';
            }

            // Detect mime type
            $mime_type = 'image/jpeg';
            if (function_exists('mime_content_type')) {
                $mime_type = mime_content_type($temp_filepath);
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, true);
            
            $post_data = [
                'file'     => new \CURLFile($temp_filepath, $mime_type, $originalName),
                'path'     => $path,
                'filename' => $originalName
            ];
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Clean up temporary file
            if (file_exists($temp_filepath)) {
                unlink($temp_filepath);
            }

            if ($error) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Proxy Error on assembly: ' . $error]);
            }

            // Validate remote server response - check HTTP status and ensure it's valid JSON
            if ($httpCode >= 400) {
                $fileSizeMB = round(filesize($temp_filepath ?? '') / 1024 / 1024, 2);
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'เซิร์ฟเวอร์ปลายทางปฏิเสธไฟล์ (HTTP ' . $httpCode . ') — ไฟล์อาจมีขนาดใหญ่เกินไป กรุณาลดคุณภาพหรือขนาดไฟล์'
                ]);
            }

            // Ensure the response is valid JSON before forwarding
            $decoded = json_decode($response);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'เซิร์ฟเวอร์ปลายทางตอบกลับรูปแบบไม่ถูกต้อง (HTTP ' . $httpCode . ')'
                ]);
            }

            return $this->response->setBody($response)->setContentType('application/json');
        }

        // Return chunk saved status to tell client to send the next chunk
        return $this->response->setJSON([
            'status' => 'chunk_saved',
            'chunk_index' => $chunkIndex,
            'total_chunks' => $totalChunks
        ]);
    }

    public function delete_class_schedule($id, $filename, $year, $term) // Accept year and term
    {
        // Reconstruct the full path for the remote server
        $remotePathForDelete = 'academic/ClassSchedule/' . $year . '/' . $term;

        // Delete the remote file via API
        $remoteDeleteResult = $this->deleteFromRemoteApi($remotePathForDelete, $filename);
        if ($remoteDeleteResult !== true) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบไฟล์จากเซิร์ฟเวอร์ปลายทางได้: ' . $remoteDeleteResult]);
        }

        // Delete the record from the database
        if ($this->modAdminClassSchedule->class_schedule_delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
        } else {
            $dbError = $this->db->error();
            $errorMessage = 'ไม่สามารถลบข้อมูลจากฐานข้อมูลได้. ';
            if ($dbError['code'] !== 0) {
                $errorMessage .= 'DB Error: Code ' . $dbError['code'] . ' - ' . $dbError['message'];
            } else {
                $errorMessage .= 'ไม่พบข้อผิดพลาดจากฐานข้อมูลเฉพาะ.';
            }
            log_message('error', 'Failed to delete class schedule from DB. ID: ' . $id . '. ' . $errorMessage);
            return $this->response->setJSON(['status' => 'error', 'message' => $errorMessage]);
        }
    }

    public function edit($id)
    {
        return redirect()->to(base_url('Admin/Acade/Course/ClassSchedule?action=edit&id=' . $id));
    }

    private function deleteFromRemoteApi($path, $fileName)
    {
        $deleteUrl = getenv('upload.server.delete.url');
        if (!$deleteUrl) {
            return 'Error: ไม่พบค่า upload.server.delete.url ในไฟล์ .env';
        }

        $client = \Config\Services::curlrequest();

        log_message('error', 'Attempting remote delete for path: ' . $path . ', filename: ' . $fileName); // Add this line

        try {
            $response = $client->setJSON([
                'path' => $path,
                'files' => [$fileName]
            ])->request('POST', $deleteUrl);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody());
                if ($body && isset($body->status) && $body->status === 'success') {
                    if (!empty($body->deleted)) { // Check if any files were actually deleted
                        log_message('info', 'Remote delete successful for ' . $fileName . '. Response: ' . $response->getBody());
                        return true;
                    } else {
                        // delete.php reported success, but no files were deleted.
                        log_message('error', 'Remote delete reported success but no files were deleted for ' . $fileName . '. Response: ' . $response->getBody());
                        return 'Error: เซิร์ฟเวอร์ปลายทางรายงานว่าลบสำเร็จ แต่ไม่มีไฟล์ใดถูกลบ (อาจเป็นปัญหาเรื่องสิทธิ์หรือไฟล์ไม่พบ)';
                    }
                } else {
                    log_message('error', 'Remote delete failed for ' . $fileName . '. Response: ' . $response->getBody());
                    return 'Error: การลบไฟล์จากเซิร์ฟเวอร์ปลายทางล้มเหลว: ' . ($body->message ?? 'ไม่ทราบสาเหตุ');
                }
            } else {
                log_message('error', 'Remote delete failed for ' . $fileName . '. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
                return 'Error: เซิร์ฟเวอร์ปลายทางตอบกลับมาว่า: ' . $response->getStatusCode() . ' - ' . $response->getReason();
            }
        } catch (\Exception $e) {
            return 'Error: เกิดข้อผิดพลาดในการเชื่อมต่อเพื่อลบไฟล์: ' . $e->getMessage();
        }
    }

    public function getDataByYear()
    {
        $yearParam = $this->request->getPost('year');
        if (empty($yearParam)) {
            $schoolYearRow = $this->db->table('tb_schoolyear')->get()->getRow();
            $yearParam = !empty($schoolYearRow) ? $schoolYearRow->schyear_year : '';
        }

        if (empty($yearParam) || strpos($yearParam, '/') === false) {
            // Return empty data instead of error to prevent annoying DataTable warning dialog
            return $this->response->setJSON(['data' => []]);
        }

        $Ex = explode('/', $yearParam);
        $term = $Ex[0];
        $year = $Ex[1];

        try {
            $query = $this->db->table('tb_class_schedule')
                            ->select('schestu_id, schestu_name, schestu_classname, schestu_term, schestu_year, schestu_filename, schestu_datetime')
                            ->where('schestu_term', $term)
                            ->where('schestu_year', $year)
                            ->get();
            $data = $query->getResultArray();
            return $this->response->setJSON(['data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getDataByYear: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Database error']);
        }
    }
}
