<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminStudents;
use App\Libraries\Classroom; // Add this line

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ConAdminStudents extends BaseController
{
    protected $modAdminStudents;
    protected $DBpersonnel;
    protected $classroom;

    public function __construct()
    {
        $this->modAdminStudents = new ModAdminStudents();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        $this->classroom = new Classroom(); // Initialize the Classroom library

        helper(['url', 'form']);

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LoginAdmin'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    function getClient()
    {
        // Since we cannot rely on the exact file structure, we assume the vendor autoloader is available
        // and the path to service_key.json is accessible.
        // If this path is incorrect in the CI4 environment, it will need manual adjustment.
        $path = WRITEPATH . 'vendor/autoload.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            // Fallback for different environments or if path is dynamic
            // Attempt to load from Composer's autoloader directly if available
            if (file_exists(APPPATH . '../vendor/autoload.php')) {
                require_once APPPATH . '../vendor/autoload.php';
            }
        }

        // Our service account access key
        $googleAccountKeyFilePath = WRITEPATH . 'service_key.json'; // Assuming service_key.json is in the project root
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

        // Create new client
        $client = new \Google\Client();
        // Set credentials
        $client->useApplicationDefaultCredentials();

        // Adding an access area for reading, editing, creating and deleting tables
        $client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $service = new \Google\Service\Sheets($client);

        return $service;
    }

     public function AdminStudentsMain($Key = null){ 
    $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CountAllStu'] = $this->db->table('tb_students')->select('COUNT(StudentBehavior) AS stuall')
        ->where('StudentStatus','1/ปกติ')
        ->get()->getRow();
        $data['CountNormalStu'] = $this->db->table('tb_students')->select('COUNT(StudentBehavior) AS stunormal')
        ->where('StudentStatus','1/ปกติ')
        ->where('StudentBehavior !=','ขาดเรียนนาน')
        ->get()->getRow();
        $data['CountAbsentStu'] = $this->db->table('tb_students')->select('COUNT(StudentBehavior) AS stuabsent')
        ->where('StudentBehavior','ขาดเรียนนาน')
        ->where('StudentStatus','1/ปกติ')
        ->get()->getRow();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();

        if(urldecode($Key) == "ปกติ"){
           $ta = "StudentStatus='1/ปกติ'";           
        } elseif(urldecode($Key) == 'จำหน่าย'){
            $ta = "StudentBehavior!='ปกติ'  AND StudentBehavior = ''";            
        }else{
            $ta = 1;
        }       
        if($Key != 'All'){
              
                                           
        }

       
        $data['title'] = "จัดการข้อมูลนักเรียน";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminStudents/AdminStudentsMain');
        

    }

    public function AdminStudentsNormal(){
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
             
        // The `classroom` library is not defined in CI4, assuming it's a custom helper or will be migrated separately
        // For now, removing the call to it. If it's crucial, a CI4 equivalent needs to be created.
        // $data['class_list'] = $this->classroom->ListRoom();
        $data['class_list'] = $this->classroom->ListRoom(); // Use the initialized classroom library
        $data['school_years'] = $this->db->table('tb_schoolyear')->orderBy('schyear_year','desc')->get()->getResult();

            // echo '<pre>'; print_r($data['stu']);  exit(); 
            $data['title'] = "จัดการข้อมูลนักเรียนปกติ";
            $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
            echo view('admin/layout/main', $data);
            echo view('admin/Academic/AdminStudents/AdminStudentsNormal',$data);
            

    }

    public function AdminStudentsNormalShow($Key){
        if(urldecode($Key) == "Normal"){
            $Keyword = "StudentStatus = '1/ปกติ'";
        }else{
            $Keyword = "StudentStatus != '1/ปกติ'";
        }
       
        $builder = $this->db->table('tb_students');
        $builder->select('StudentID,
                        StudentNumber,
                        StudentClass,
                        StudentCode,
                        StudentPrefix,
                        StudentFirstName,
                        StudentLastName,
                        StudentIDNumber,
                        StudentStatus,
                        StudentBehavior,
                        StudentStudyLine');
        $builder->where($Keyword); 

        $classFilter = $this->request->getPost('classFilter');
        if(!empty($classFilter)){
            $builder->where('StudentClass', $classFilter);
        }

        $school_year = $this->request->getPost('school_year');
        if(!empty($school_year)){
            $builder->where('StudentSchoolYear', $school_year);
        }

        $stu = $builder->get()->getResult();   

        $data = [];
        foreach($stu as $record){
            $data[] = array( 
                "StudentCode" => $record->StudentCode,
                "StudentID" => $record->StudentID,
                "Fullname" => $record->StudentPrefix.$record->StudentFirstName.' '.$record->StudentLastName,
                "StudentClass" => $record->StudentClass,
                "StudentNumber" => $record->StudentNumber,
                "StudentStudyLine" => $record->StudentStudyLine,
                "StudentStatus" => $record->StudentStatus,
                "StudentBehavior" => $record->StudentBehavior
            );

        }
        $output = array(
            "data" =>  $data,           
        );


        return $this->response->setJSON($output);

    }

    public function AdminStudentsUpdate(){
        
        $service = $this->getClient();
        $spreadsheetId = '1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec'; // Assuming this is correct
        
        $range = 'stu1!A2:K1000';  // TODO: Update placeholder value.

        $response = $service ? $service->spreadsheets_values->get($spreadsheetId, $range) : null;
        $numRows = ($response && !empty($response->getValues())) ? count($response->getValues()) : 0;
       
        $checkStu = [];
        $re = $this->db->table('tb_students')->select('StudentCode,StudentIDNumber,StudentStatus')        
        ->get()->getResult();
        foreach ($re as $key => $v_re) {
            $checkStu[] = $v_re->StudentCode;
        }
        
        //echo '<pre>';print_r($response);exit();
        for ($i=0; $i < $numRows; $i++) { 
            if(!empty($response->values[$i][10]) && isset($response->values[$i][10])){
               $StudyLine = $response->values[$i][10];
            }else{
                $StudyLine = '';
            }

            if (!empty($response->values[$i][2]) && in_array($response->values[$i][2], $checkStu))
            {
             $arrayName = array('StudentNumber' => !empty($response->values[$i][0]) ? $response->values[$i][0] : null, 
                                'StudentClass' => !empty($response->values[$i][1]) ? $response->values[$i][1] : null,
                                'StudentPrefix' => !empty($response->values[$i][3]) ? $response->values[$i][3] : null, 
                                'StudentFirstName' => !empty($response->values[$i][4]) ? $response->values[$i][4] : null, 
                                'StudentLastName' => !empty($response->values[$i][5]) ? $response->values[$i][5] : null,
                                'StudentStatus' => !empty($response->values[$i][8]) ? $response->values[$i][8] : null,
                                'StudentBehavior' => !empty($response->values[$i][9]) ? $response->values[$i][9] : null,
                                'StudentStudyLine' => $StudyLine);
            $this->modAdminStudents->Students_Update($arrayName,!empty($response->values[$i][2]) ? $response->values[$i][2] : null);
            }
          else
            {
                $arrayName = array('StudentNumber' => !empty($response->values[$i][0]) ? $response->values[$i][0] : null, 
                'StudentClass' => !empty($response->values[$i][1]) ? $response->values[$i][1] : null,
                'StudentCode' => !empty($response->values[$i][2]) ? $response->values[$i][2] : null, 
                'StudentPrefix' => !empty($response->values[$i][3]) ? $response->values[$i][3] : null, 
                'StudentFirstName' => !empty($response->values[$i][4]) ? $response->values[$i][4] : null, 
                'StudentLastName' => !empty($response->values[$i][5]) ? $response->values[$i][5] : null,
                'StudentIDNumber' => !empty($response->values[$i][7]) ? $response->values[$i][7] : null,
                'StudentDateBirth' => !empty($response->values[$i][6]) ? $response->values[$i][6] : null,
                'StudentStatus' => !empty($response->values[$i][8]) ? $response->values[$i][8] : null,
                'StudentBehavior' => !empty($response->values[$i][9]) ? $response->values[$i][9] : null,
                'StudentStudyLine' => $StudyLine);
                $this->modAdminStudents->Students_Inaert($arrayName);
            }
        }
        session()->setFlashdata(['status'=> 'success','messge' => 'อัพเดพข้อมูลสำเร็จ','msg'=>'YES']);
        return redirect()->to(base_url('Admin/Acade/Registration/Students/Normal'));
    }

    public function AdminStudentsMain1(){   

        $DBpersonnel = $this->DBpersonnel; 
        $data['admin'] = $DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        
        $data['title'] = "นักเรียน";
       
        $inputFileName = ROOTPATH . 'uploads/m.11.xls';//ชื่อไฟล์ Excel ที่ต้องการอ่านข้อมูล

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        foreach ($sheetData as $key => $v_sheetData) {
            
           if($key != 1){
            //echo '<pre>'; print_r($v_sheetData['E']);
            $studentOdd = $this->db->table('tb_student_express')->select('StudentCode')->where('StudentCode',!empty($v_sheetData['E']) ? $v_sheetData['E'] : null)->countAllResults();
            if($studentOdd == 1){
                echo "มีแล้ว";
            }else{
                echo  "ยังไม่มี";
            }
            echo '<br>';
            
           }
                
                
        }
        exit();
        
        //echo '<pre>'; print_r($sheetData);
        

        // echo view('admin/layout/Header',$data);
        // echo view('admin/AdminStudents/AdminStudentsMain');
        // 

    }

    public function AdminUpdateStudentBehavior(){
        $valueBehavior = $this->request->getPost('ValueBehavior');
        $keyStuId = $this->request->getPost('KeyStuId');

        $data = ['StudentBehavior' => $valueBehavior];
        $result = $this->db->table('tb_students')->where('StudentID', $keyStuId)->update($data);
        
        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => $valueBehavior]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update behavior.']);
        }
        
    }

    public function AdminUpdateStudentStatus(){
        $valueStudentStatus = $this->request->getPost('ValueStudentStatus');
        $keyStuId = $this->request->getPost('KeyStuId');

        $data = ['StudentStatus' => $valueStudentStatus];
        $result = $this->db->table('tb_students')->where('StudentID', $keyStuId)->update($data);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => $valueStudentStatus]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update status.']);
        }
        
    }
    
    public function AdminStudentsDelete($id){   
      
        if ($this->modAdminStudents->Students_Delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }
    }

  
    
    // Chart นักเรียนทั้งหมด
    public function getDashboardData(){
        $this->response->setHeader('Content-Type', 'application/json');

        // 1. ดึงข้อมูลสรุปเพศ
        $gender_count = $this->modAdminStudents->get_gender_count();

        // 2. ดึงข้อมูลนักเรียนตามระดับชั้น (แยกชาย/หญิง)
        $students_by_class_from_db = $this->modAdminStudents->get_students_by_class();
        
        //print_r($students_by_class_from_db); exit();
        // สร้างโครงข้อมูล 6 ระดับชั้น โดยให้มีค่าเริ่มต้นเป็น 0
        $class_counts = [
            '1' => ['male' => 0, 'female' => 0],
            '2' => ['male' => 0, 'female' => 0],
            '3' => ['male' => 0, 'female' => 0],
            '4' => ['male' => 0, 'female' => 0],
            '5' => ['male' => 0, 'female' => 0],
            '6' => ['male' => 0, 'female' => 0]
        ];

        // นำข้อมูลจากฐานข้อมูลมาอัปเดตในโครงที่เตรียมไว้
        foreach($students_by_class_from_db as $class) {
            if (array_key_exists($class->class_level, $class_counts)) {
                $class_counts[$class->class_level]['male'] = (int)$class->male_count;
                $class_counts[$class->class_level]['female'] = (int)$class->female_count;
            }
        }

        // เตรียมข้อมูลสำหรับส่งให้ Chart.js
        $class_labels = [];
        $male_data = [];
        $female_data = [];
        foreach ($class_counts as $level => $counts) {
            $class_labels[] = 'ม.' . $level;
            $male_data[] = $counts['male'];
            $female_data[] = $counts['female'];
        }

        // 3. ดึงข้อมูลนักเรียนล่าสุด
        $recent_students = $this->modAdminStudents->get_recent_students(5);

        // จัดรูปแบบข้อมูลสำหรับส่งกลับเป็น JSON
        $data = [
            'gender_count' => [
                'male' => $gender_count->male_students ?? '0',
                'female' => $gender_count->female_students ?? '0'
            ],
            'students_by_class' => [
                'labels' => $class_labels,
                'datasets' => [
                    [
                        'label' => 'ชาย',
                        'data' => $male_data,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.5)'
                    ],
                    [
                        'label' => 'หญิง',
                        'data' => $female_data,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.5)'
                    ]
                ]
            ],
            'recent_students' => $recent_students
        ];

        return $this->response->setJSON($data);
    }

    public function AdminStudentsData(){
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        $data['title'] = "จัดการข้อมูลนักเรียน LEC";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminStudents/AdminStudentsDataLEC');
        

    }

    

    public function get_student_details($student_id)
    {
        $this->response->setHeader('Content-Type', 'application/json');
        // The `classroom` library is not defined in CI4, assuming it's a custom helper or will be migrated separately
        // For now, returning empty arrays. If it's crucial, a CI4 equivalent needs to be created.
        // $this->load->library('classroom');

        $student_data = $this->modAdminStudents->get_student_by_id($student_id);
        $class_list = $this->classroom->ListRoom(); // Use the initialized classroom library
        $study_line_list = $this->classroom->studentStudyLineOptions(); // Use the initialized classroom library
        
        if ($student_data && !empty($student_data->StudentDateBirth)) {
            // Convert Buddhist year to Gregorian year for input type="date"
            $Ex = explode('/', $student_data->StudentDateBirth);
            $gregorian_year = (int)$Ex[2] - 543;
            $student_data->StudentDateBirth = sprintf("%04d-%02d-%02d", $gregorian_year,$Ex[1],$Ex[0]);
        }
        
        $response_data = [
            'student_data' => $student_data,
            'class_list'   => $class_list,
            'study_line_list' => $study_line_list
        ];

        return $this->response->setJSON($response_data);
    }

    public function update_student_details()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $student_id = $this->request->getPost('StudentID');
        $student_id_number = $this->request->getPost('StudentIDNumber'); // Use StudentIDNumber

        if (empty($student_id) || empty($student_id_number)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Missing Student ID or National ID Number.']);
        }

        // Convert Gregorian year from form to Buddhist year for database
        $student_date_birth_gregorian = $this->request->getPost('StudentDateBirth');
        $student_date_birth_buddhist = null;
        if (!empty($student_date_birth_gregorian)) {
            list($gregorian_year, $month, $day) = explode('-', $student_date_birth_gregorian);
            $buddhist_year = (int)$gregorian_year + 543;
            $student_date_birth_buddhist = sprintf('%04d/%02d/%02d', $day, $month, $buddhist_year); // Corrected format to match original CI3 data 'DD/MM/YYYY' for Buddhist year
        }

        // Data for default tb_students
        $data_main = [
            'StudentPrefix' => $this->request->getPost('StudentPrefix'),
            'StudentFirstName' => $this->request->getPost('StudentFirstName'),
            'StudentLastName' => $this->request->getPost('StudentLastName'),
            'StudentClass' => $this->request->getPost('StudentClass'),
            'StudentNumber' => $this->request->getPost('StudentNumber'),
            'StudentStudyLine' => $this->request->getPost('StudentStudyLine'),
            'StudentStatus' => $this->request->getPost('StudentStatus'),
            'StudentBehavior' => $this->request->getPost('StudentBehavior'),
            'StudentIDNumber' => $this->request->getPost('StudentIDNumber'),
            'StudentDateBirth' => $student_date_birth_buddhist // Use converted Buddhist year
        ];

        // Data for personnel.tb_students
        $data_personnel = [
            'stu_nickName' => $this->request->getPost('stu_nickName'),
            'stu_phone' => $this->request->getPost('stu_phone'),
            'stu_email' => $this->request->getPost('stu_email'),
            'stu_bloodType' => $this->request->getPost('stu_bloodType'),
            'stu_diseaes' => $this->request->getPost('stu_diseaes'),
            'stu_nationality' => $this->request->getPost('stu_nationality'),
            'stu_race' => $this->request->getPost('stu_race'),
            'stu_religion' => $this->request->getPost('stu_religion'),
            'stu_wieght' => $this->request->getPost('stu_wieght'),
            'stu_hieght' => $this->request->getPost('stu_hieght'),
            // Home Address
            'stu_hCode' => $this->request->getPost('stu_hCode'),
            'stu_hNumber' => $this->request->getPost('stu_hNumber'),
            'stu_hMoo' => $this->request->getPost('stu_hMoo'),
            'stu_hRoad' => $this->request->getPost('stu_hRoad'),
            'stu_hTambon' => $this->request->getPost('stu_hTambon'),
            'stu_hDistrict' => $this->request->getPost('stu_hDistrict'),
            'stu_hProvince' => $this->request->getPost('stu_hProvince'),
            'stu_hPostCode' => $this->request->getPost('stu_hPostCode'),
            // Current Address
            'stu_cNumber' => $this->request->getPost('stu_cNumber'),
            'stu_cMoo' => $this->request->getPost('stu_cMoo'),
            'stu_cRoad' => $this->request->getPost('stu_cRoad'),
            'stu_cTumbao' => $this->request->getPost('stu_cTumbao'),
            'stu_cDistrict' => $this->request->getPost('stu_cDistrict'),
            'stu_cProvince' => $this->request->getPost('stu_cProvince'),
            'stu_cPostcode' => $this->request->getPost('stu_cPostcode'),
            // General Info
            'stu_birthTambon' => $this->request->getPost('stu_birthTambon'),
            'stu_birthDistrict' => $this->request->getPost('stu_birthDistrict'),
            'stu_birthProvirce' => $this->request->getPost('stu_birthProvirce'),
            'stu_birthHospital' => $this->request->getPost('stu_birthHospital'),
            'stu_numberSibling' => $this->request->getPost('stu_numberSibling'),
            'stu_firstChild' => $this->request->getPost('stu_firstChild'),
            'stu_numberSiblingSkj' => $this->request->getPost('stu_numberSiblingSkj'),
            'stu_parenalStatus' => $this->request->getPost('stu_parenalStatus'),
            'stu_presentLife' => $this->request->getPost('stu_presentLife'),
            'stu_personOther' => $this->request->getPost('stu_personOther'),
            'stu_disablde' => $this->request->getPost('stu_disablde'),
            'stu_talent' => $this->request->getPost('stu_talent'),
            'stu_natureRoom' => $this->request->getPost('stu_natureRoom'),
            'stu_farSchool' => $this->request->getPost('stu_farSchool'),
            'stu_travel' => $this->request->getPost('stu_travel'),
            'stu_gradLevel' => $this->request->getPost('stu_gradLevel'),
            'stu_schoolfrom' => $this->request->getPost('stu_schoolfrom'),
            'stu_schoolTambao' => $this->request->getPost('stu_schoolTambao'),
            'stu_schoolDistrict' => $this->request->getPost('stu_schoolDistrict'),
            'stu_schoolProvince' => $this->request->getPost('stu_schoolProvince'),
            'stu_usedStudent' => $this->request->getPost('stu_usedStudent'),
            'stu_inputLevel' => $this->request->getPost('stu_inputLevel'),
            'stu_phoneUrgent' => $this->request->getPost('stu_phoneUrgent'),
            'stu_phoneFriend' => $this->request->getPost('stu_phoneFriend'),
            'stu_future_education' => $this->request->getPost('stu_future_education'),
            'stu_career_interest' => $this->request->getPost('stu_career_interest')
        ];

        // Remove null values to avoid overwriting existing data with empty strings
        $data_main = array_filter($data_main, function($value) { return $value !== null && $value !== ''; });
        $data_personnel = array_filter($data_personnel, function($value) { return $value !== null && $value !== ''; });

        $success = $this->modAdminStudents->update_student_data($student_id, $data_main);
        // Assuming personnel table has stu_iden as primary key or unique identifier for update
        $success_personnel = $this->DBpersonnel->table('tb_students')->where('stu_iden', $student_id_number)->update($data_personnel);

        if ($success || $success_personnel) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }
}
