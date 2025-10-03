<?php

namespace App\Controllers;

use App\Models\AdminModels;
use App\Models\FoodReportModel;

class ConUserFoodReport extends BaseController
{
    public function __construct()
    {
        $this->AdminModels = new AdminModels();
        $this->FoodReportModel = new FoodReportModel();
    }

      public function DataMain(){
       $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $data['uri'] = service('uri'); 
       
        return $data;
    }

    public function index()
    {
        $session = session();
        $data = $this->DataMain();
        $data['UrlMenuMain'] = 'FoodReport';
        $data['UrlMenuSub'] = 'FoodReportMain';
        
        $data['title'] = 'รายงานอาหาร';
        $data['description'] = 'รายงานอาหารมื้ออาหาร';
        
        echo view('User/UserFoodReport/PageFoodReportMain', $data);
    }

    public function foodReportInsert()
    {
        $upload_server_url = getenv('upload.server.url');
        if (!$upload_server_url) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Upload server URL is not configured.']);
        }

        $food_date = $this->request->getVar('food_date');
        $food_meal = $this->request->getVar('food_meal');
        $food_menu = $this->request->getVar('food_menu');

        $image_names = [];
        $files = $this->request->getFiles();

        if ($files && isset($files['food_images'])) {
            $client = \Config\Services::curlrequest();
            $date_folder = date('Y-m-d', strtotime($food_date));

            foreach ($files['food_images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $local_temp_path = $img->getTempName();
                    $mimeType = $img->getMimeType();
                    $originalName = $img->getName();

                    try {
                        $response = $client->request('POST', $upload_server_url, [
                            'multipart' => [
                                'file' => new \CURLFile($local_temp_path, $mimeType, $originalName),
                                'path' => 'general/FoodReport/' . $date_folder,
                            ]
                        ]);

                        if ($response->getStatusCode() === 200) {
                            $body = json_decode($response->getBody());
                            if ($body && isset($body->status) && $body->status === 'success' && isset($body->filename)) {
                                $image_names[] = $body->filename;
                            } else {
                                log_message('error', 'File upload to remote server failed: ' . $response->getBody());
                                return $this->response->setJSON(['status' => 'error', 'message' => 'File upload to remote server failed', 'details' => $response->getBody()]);
                            }
                        } else {
                             log_message('error', 'File upload to remote server failed with status code: ' . $response->getStatusCode());
                             log_message('error', 'Remote server response: ' . $response->getBody());
                             return $this->response->setJSON(['status' => 'error', 'message' => 'Remote server error', 'details' => $response->getBody()]);
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Exception during file upload: ' . $e->getMessage());
                        return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                }
            }

            if (count($files['food_images']) > 0 && empty($image_names)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to upload any images. Please check logs.']);
            }
        }

        $food_images_json = json_encode($image_names);

        $data = [
            'food_date' => $food_date,
            'food_meal' => $food_meal,
            'food_menu' => $food_menu,
            'food_images' => $food_images_json,
            'food_admin' => session()->get('id'), // Add the logged-in user's ID
        ];

        if ($this->FoodReportModel->foodReportInsert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    public function foodReportUpdate()
    {
        $food_id = $this->request->getVar('food_id');
        if (!$food_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบ ID รายงานที่ต้องการแก้ไข']);
        }

        // Authorization check: Ensure the logged-in user owns this report
        $report = $this->FoodReportModel->find($food_id);
        if (!$report || $report['food_admin'] != session()->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์แก้ไขรายงานนี้']);
        }

        $food_date = $this->request->getVar('food_date');
        $food_meal = $this->request->getVar('food_meal');
        $food_menu = $this->request->getVar('food_menu');

        $data_to_update = [
            'food_date' => $food_date,
            'food_meal' => $food_meal,
            'food_menu' => $food_menu,
            'food_admin' => session()->get('id'), // Update with current user's ID
        ];

        $image_names = [];
        $files = $this->request->getFiles();
        $has_new_files_to_upload = false;

        // Check if there are actual new files selected by the user
        if (isset($files['food_images']) && is_array($files['food_images'])) {
            foreach ($files['food_images'] as $img) {
                if ($img->isValid() && $img->getError() !== UPLOAD_ERR_NO_FILE) {
                    $has_new_files_to_upload = true;
                    break;
                }
            }
        }

        // Fetch existing report to get old images
        $existingReport = $this->FoodReportModel->find($food_id);
        $old_images = json_decode($existingReport['food_images'] ?? '[]', true);

        if ($has_new_files_to_upload) {
            $upload_server_url = getenv('upload.server.url');
            if (!$upload_server_url) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Upload server URL is not configured.']);
            }

            $client = \Config\Services::curlrequest();
            $date_folder = date('Y-m-d', strtotime($food_date));

            foreach ($files['food_images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $local_temp_path = $img->getTempName();
                    $mimeType = $img->getMimeType();
                    $originalName = $img->getName();

                    try {
                        $response = $client->request('POST', $upload_server_url, [
                            'multipart' => [
                                'file' => new \CURLFile($local_temp_path, $mimeType, $originalName),
                                'path' => 'general/FoodReport/' . $date_folder,
                            ]
                        ]);

                        if ($response->getStatusCode() === 200) {
                            $body = json_decode($response->getBody());
                            if ($body && isset($body->status) && $body->status === 'success' && isset($body->filename)) {
                                $image_names[] = $body->filename;
                            } else {
                                log_message('error', 'File upload to remote server failed: ' . $response->getBody());
                                return $this->response->setJSON(['status' => 'error', 'message' => 'File upload to remote server failed', 'details' => $response->getBody()]);
                            }
                        } else {
                             log_message('error', 'File upload to remote server failed with status code: ' . $response->getStatusCode());
                             log_message('error', 'Remote server response: ' . $response->getBody());
                             return $this->response->setJSON(['status' => 'error', 'message' => 'Remote server error', 'details' => $response->getBody()]);
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Exception during file upload: ' . $e->getMessage());
                        return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                }
            }

            // If new files were intended to be uploaded but none succeeded
            if (count($files['food_images']) > 0 && empty($image_names)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to upload any new images. Please check logs.']);
            }

            // Delete old images from remote server if new ones are uploaded
            if (!empty($old_images)) {
                $upload_server_delete_url = getenv('upload.server.delete.url');
                if ($upload_server_delete_url) {
                    $client = \Config\Services::curlrequest();
                    $old_date_folder = date('Y-m-d', strtotime($existingReport['food_date']));
                    $path = 'general/FoodReport/' . $old_date_folder;

                    try {
                        $response = $client->request('POST', $upload_server_delete_url, [
                            'json' => [
                                'files' => $old_images,
                                'path' => $path
                            ]
                        ]);
                        if ($response->getStatusCode() !== 200) {
                            log_message('error', 'Failed to delete old images from remote server for food_id: ' . $food_id . '. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
                        }
                    } catch (\Throwable $e) {
                        log_message('error', 'Exception during remote old image deletion for food_id: ' . $food_id . ' - ' . $e->getMessage());
                    }
                } else {
                    log_message('error', 'upload.server.delete.url is not configured. Cannot delete old images for food_id: ' . $food_id);
                }
            }
            $data_to_update['food_images'] = json_encode($image_names); // Set to new images
        } else {
            // No new files uploaded, retain existing images
            $data_to_update['food_images'] = json_encode($old_images);
        }

        if ($this->FoodReportModel->update($food_id, $data_to_update)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล']);
        }
    }

    public function foodReportDelete()
    {
        $id = $this->request->getVar('id');
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่ได้ระบุ ID ของรายงาน']);
        }

        $report = $this->FoodReportModel->find($id);
        if (!$report) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรายงานที่ต้องการลบ']);
        }

        // Authorization check: Ensure the logged-in user owns this report
        if ($report['food_admin'] != session()->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ลบรายงานนี้']);
        }

        try {
            $images = json_decode($report['food_images'], true);
            if (is_array($images) && !empty($images)) {
                $upload_server_delete_url = getenv('upload.server.delete.url');
                if ($upload_server_delete_url) {
                    $client = \Config\Services::curlrequest();
                    $foodDate = date('Y-m-d', strtotime($report['food_date']));
                    $path = 'general/FoodReport/' . $foodDate;

                    $response = $client->request('POST', $upload_server_delete_url, [
                        'json' => [
                            'files' => $images,
                            'path' => $path
                        ]
                    ]);

                    if ($response->getStatusCode() !== 200) {
                        log_message('error', 'Failed to delete images from remote server for food_id: ' . $id . '. Status: ' . $response->getStatusCode() . ' Body: ' . $response->getBody());
                    }
                } else {
                    log_message('error', 'upload.server.delete.url is not configured. Cannot delete images for food_id: ' . $id);
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'Exception during remote image deletion for food_id: ' . $id . ' - ' . $e->getMessage());
        }

        // Always proceed to delete from the database.
        if ($this->FoodReportModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบรายงานสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลออกจากฐานข้อมูลได้']);
        }
    }

    public function print($food_id = null)
    {
        $data = $this->DataMain();

        $report = $this->FoodReportModel
            ->select('tb_food_reports.*, p.pers_prefix, p.pers_firstname, p.pers_lastname')
            ->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = tb_food_reports.food_admin', 'left')
            ->find($food_id);

        $data['food_report'] = $report;

        if (empty($data['food_report'])) {
            // Handle report not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Food report not found: ' . $food_id);
        }
        
        $data['title'] = 'พิมพ์รายงานอาหาร';
        $data['description'] = 'พิมพ์รายงานอาหาร';

        return view('User/UserFoodReport/PrintFoodReport', $data);
    }

    public function getFoodReportsJson()
    {
        $reports = $this->FoodReportModel->getFoodReportsWithRecorderDetails(); // Call the new method
        return $this->response->setJSON(['data' => $reports]);
    }

    public function getReportById($food_id = null)
    {
        if (!$food_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบ ID รายงาน']);
        }

        $report = $this->FoodReportModel->find($food_id);

        if ($report) {
            return $this->response->setJSON(['status' => 'success', 'report' => $report]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรายงานที่ระบุ']);
        }
    }

    public function checkVendor()
    {
        echo "<h1>Vendor/Autoloader Check</h1>";
        echo "<pre>";

        echo "PHP Version: " . phpversion() . "\n\n";

        $open_basedir = ini_get('open_basedir');
        echo "open_basedir setting: " . ($open_basedir ?: 'Not Set') . "\n\n";

        $autoloaderPath = APPPATH . '../vendor/autoload.php';
        echo "Checking for autoloader at: " . realpath($autoloaderPath) . "\n";
        echo "is_readable(autoloader)? " . (is_readable($autoloaderPath) ? 'Yes' : 'No') . "\n\n";

        if (is_readable($autoloaderPath)) {
            echo "Requiring autoloader...\n";
            require_once $autoloaderPath;
            echo "Autoloader included successfully.\n\n";

            $className = 'phpseclib3\\Net\\SFTP';
            echo "Checking for class: " . $className . "\n";
            echo "class_exists()? " . (class_exists($className) ? 'Yes' : 'No') . "\n\n";

            if (!class_exists($className)) {
                echo "Class does not exist. Let's check the specific file...\n";
                $sftpClassPath = APPPATH . '../vendor/phpseclib/phpseclib/src/Net/SFTP.php';
                echo "Checking for SFTP class file at: " . realpath($sftpClassPath) . "\n";
                echo "is_readable(SFTP class file)? " . (is_readable($sftpClassPath) ? 'Yes' : 'No') . "\n";
            }
        }

        echo "</pre>";
    }
}