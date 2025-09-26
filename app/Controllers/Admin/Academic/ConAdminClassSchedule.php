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
            return redirect()->to(base_url('LoginAdmin'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (! @$check_status_data->admin_rloes_status === "admin" && ! @$check_status_data->admin_rloes_status === "manager") {
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
                                    ->groupBy('schestu_year')
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

        $class_schedule_data = $this->db->table('tb_class_schedule')
                                        ->orderBy('schestu_id', 'DESC')
                                        ->get()->getResult();

        $data['ClassRoom'] = $this->db->table('tb_regclass')
                                    ->groupBy('Reg_Class')
                                    ->get()->getResult();

        $num = @explode("_", @$class_schedule_data[0]->schestu_id);
        $num1 = @sprintf("%03d", (@$num[1] ?? 0) + 1);
        $data['class_schedule'] = 'schestu_' . $num1;
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
                            . '|mime_in[schestu_filename,image/jpg,image/jpeg,image/gif,image/png,application/pdf]',
                'errors' => [
                    'uploaded' => 'กรุณาเลือกไฟล์ภาพหรือ PDF',
                    'is_image' => 'ไฟล์ที่อัปโหลดไม่ใช่ภาพที่ถูกต้อง',
                    'mime_in'  => 'ไฟล์ที่อัปโหลดต้องเป็น JPG, JPEG, PNG, GIF หรือ PDF',
                ],
            ],
        ];

        if (! $this->validate($validationRule)) {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);
        }

        $img = $this->request->getFile('schestu_filename');
        
        if (! $img->isValid()) {
            return $this->response->setJSON(['error' => $img->getErrorString() . '(' . $img->getError() . ')']);
        }

        $newName = $img->getRandomName();
        $uploadPath = 'uploads/academic/class_schedule/';
        $img->move(ROOTPATH . 'public/' . $uploadPath, $newName);

        // Resize image if it's an image file
        $fileExtension = $img->getClientExtension();
        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            $this->image_lib->withFile(ROOTPATH . 'public/' . $uploadPath . $newName)
                            ->fit(2048, 1080, 'center')
                            ->save(ROOTPATH . 'public/' . $uploadPath . $newName);
        }

        $dat_insert = [
            'schestu_id'        => $this->request->getPost('schestu_id'),
            'schestu_name'      => $this->request->getPost('schestu_name'),
            'schestu_classname' => $this->request->getPost('schestu_classname'),
            'schestu_filename'  => $newName,
            'schestu_term'      => $this->request->getPost('schestu_term'),
            'schestu_year'      => $this->request->getPost('schestu_year'),
            'schestu_datetime'  => date('Y-m-d H:i:s'),
            'schestu_user'      => session()->get('login_id'),
        ];

        if ($this->modAdminClassSchedule->class_schedule_insert($dat_insert)) {
            return $this->response->setJSON(['success' => 1]);
        } else {
            return $this->response->setJSON(['error' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }
    }

    public function delete_class_schedule($data, $img)
    {
        // Delete the file
        $filePath = FCPATH . 'uploads/academic/class_schedule/' . $img;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record from the database
        if ($this->modAdminClassSchedule->class_schedule_delete($data) == 1) {
            session()->setFlashdata(['alert' => 'success', 'messge' => 'ลบข้อมูลสำเร็จ']);
            return redirect()->to(base_url('Admin/Acade/Course/ClassSchedule'));
        }
    }

    public function getDataByYear()
    {
        $year = $this->request->getPost('year');
        $Ex = explode('/', $year);
        $term = $Ex[0];
        $year = $Ex[1];

        $query = $this->db->table('tb_class_schedule')
                        ->where('schestu_term', $term)
                        ->where('schestu_year', $year)
                        ->get();
        $data = $query->getResultArray();

        return $this->response->setJSON(['data' => $data]);
    }
}
