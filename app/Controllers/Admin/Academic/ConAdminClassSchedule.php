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

        session()->set('SchoolYear', $data['SchoolYear']->schyear_year);
        
        echo view('admin/Academic/AdminClassSchedule/AdminClassScheduleMain', $data);
        
    }
    
    public function add()
    {
        $DBpersonnel = \Config\Database::connect('personnel');

        $data['admin'] = $DBpersonnel->table('tb_personnel')
                                    ->select('pers_id,pers_img')
                                    ->where('pers_id', session()->get('login_id'))
                                    ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "ตารางเรียน";
        $data['icon'] = '<i class="far fa-plus-square"></i>';
        $data['color'] = 'primary';

        $data['class_schedule'] = 'schestu_' . uniqid();
        $data['action'] = 'insert_class_schedule';

        echo view('admin/Academic/AdminClassSchedule/AdminClassScheduleForm', $data);
        
    }

    public function insert_class_schedule()
    {
        $validationRule = [
            'schestu_filename' => [
                'label' => 'Image File',
                'rules' => 'uploaded[schestu_filename]' // Validate upload
                            . '|is_image[schestu_filename]'
                            . '|mime_in[schestu_filename,image/jpg,image/jpeg,image/gif,image/png]',
                'errors' => [
                    'uploaded' => 'กรุณาเลือกไฟล์ภาพ',
                    'is_image' => 'ไฟล์ที่อัปโหลดไม่ใช่ภาพที่ถูกต้อง',
                    'mime_in'  => 'ไฟล์ที่อัปโหลดต้องเป็น JPG, JPEG, PNG',
                ],
            ],
        ];

        if (! $this->validate($validationRule)) {
            $errors = $this->validator->getErrors();
            $errorString = implode(' ', array_values($errors));
            return $this->response->setJSON(['error' => $errorString]);
        }

        $img = $this->request->getFile('schestu_filename');
        
        if (! $img->isValid()) {
            return $this->response->setJSON(['error' => $img->getErrorString() . '(' . $img->getError() . ')']);
        }

        $schestu_id = $this->request->getPost('schestu_id');
        $term = $this->request->getPost('schestu_term');
        $year = $this->request->getPost('schestu_year');
        $fileExtension = $img->getClientExtension();

        // Construct the new filename to send to the remote server
        $newOriginalName = 'schestu_' . $schestu_id . '_' . $term . '_' . $year . '.' . $fileExtension;

        // Pass the $img object and the new original name to the helper
        $remoteFileName = $this->uploadToRemoteApi($img, $newOriginalName, $term, $year); 

        if (is_string($remoteFileName) && strpos($remoteFileName, 'Error:') === 0) {
            return $this->response->setJSON(['error' => $remoteFileName]);
        } elseif ($remoteFileName !== false) {
            $remotePath = 'academic/ClassSchedule/' . $year . '/' . $term . '/' . $remoteFileName; // Use the filename returned by remote server

            $dat_insert = [
                'schestu_id'        => $schestu_id,
                'schestu_name'      => $this->request->getPost('schestu_name'),
                'schestu_classname' => $this->request->getPost('schestu_classname'),
                'schestu_filename'  => $remoteFileName, // Save only the filename
                'schestu_term'      => $term,
                'schestu_year'      => $year,
                'schestu_datetime'  => date('Y-m-d H:i:s'),
                'schestu_user'      => session()->get('login_id'),
            ];

            if ($this->modAdminClassSchedule->class_schedule_insert($dat_insert)) {
                return $this->response->setJSON(['success' => 1]);
            } else {
                // Log the data being inserted and the database error
                log_message('error', 'Failed to insert class schedule. Data: ' . print_r($dat_insert, true));
                $dbError = $this->db->error(); // Get the last database error
                log_message('error', 'Database Error: Code ' . $dbError['code'] . ' - ' . $dbError['message']);

                return $this->response->setJSON(['error' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้: ' . $dbError['message']]);
            }
        } else {
            return $this->response->setJSON(['error' => 'ไม่สามารถอัปโหลดไฟล์ไปยังเซิร์ฟเวอร์อื่นได้ (ไม่ทราบสาเหตุ)']);
        }
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

    private function uploadToRemoteApi($img, $newOriginalName, $term, $year) // Accept $img object and new original name
    {
        $uploadUrl = getenv('upload.server.url');
        if (!$uploadUrl) {
            return 'Error: ไม่พบค่า upload.server.url ในไฟล์ .env';
        }

        $path = 'academic/ClassSchedule/' . $year . '/' . $term;

        try {
            $client = \Config\Services::curlrequest();

            $response = $client->request('POST', $uploadUrl, [
                'multipart' => [
                    'file' => new \CURLFile($img->getTempName(), $img->getMimeType(), $newOriginalName), // Use CURLFile
                    'path' => $path
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody());
                if ($body && isset($body->status) && $body->status === 'success' && isset($body->filename)) {
                    return $body->filename; // Return the filename from the remote server
                }
                else {
                    return 'Error: การอัปโหลดไฟล์ไปยังเซิร์ฟเวอร์ปลายทางล้มเหลว: ' . ($body->message ?? 'ไม่ทราบสาเหตุ');
                }
            } else {
                return 'Error: เซิร์ฟเวอร์ปลายทางตอบกลับมาว่า: ' . $response->getStatusCode() . ' - ' . $response->getReason();
            }
        } catch (\Exception $e) {
            return 'Error: เกิดข้อผิดพลาดในการเชื่อมต่อ: ' . $e->getMessage();
        }
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
        $year = $this->request->getPost('year');
        $Ex = explode('/', $year);
        $term = $Ex[0];
        $year = $Ex[1];

        $query = $this->db->table('tb_class_schedule')
                        ->select('schestu_id, schestu_name, schestu_classname, schestu_term, schestu_year, schestu_filename, schestu_datetime') // Explicitly select all needed columns
                        ->where('schestu_term', $term)
                        ->where('schestu_year', $year)
                        ->get();
        $data = $query->getResultArray();

        return $this->response->setJSON(['data' => $data]);
    }
}
