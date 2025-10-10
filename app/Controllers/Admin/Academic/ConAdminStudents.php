<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminStudents;
use App\Libraries\Classroom; // Add this line
use Google\Client;
use Google\Service\Sheets;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ConAdminStudents extends BaseController
{
    protected $modAdminStudents;
    protected $DBpersonnel;
    protected $db;

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
        $path = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
		require $path . '/librarie_skj/google_sheet/vendor/autoload.php';

        // Our service account access key
        $googleAccountKeyFilePath = WRITEPATH . 'service_key.json'; // Assuming service_key.json is in the project root
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

        // Create new client
        $client = new Client();
        // Set credentials
        $client->useApplicationDefaultCredentials();

        // Adding an access area for reading, editing, creating and deleting tables
        $client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $service = new Sheets($client);

        return $service;
    }

     public function AdminStudentsMain($Key = null){ 
    $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CountAllStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stuall')
        ->where('StudentStatus !=','5/จบการศึกษา')
        ->where('StudentBehavior !=','จำหน่าย')
        ->get()->getRow();
        $data['CountNormalStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stunormal')
        ->where('StudentStatus','1/ปกติ')
        ->where('StudentBehavior !=','ขาดเรียนนาน')
        ->get()->getRow();
        $data['CountAbsentStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stuabsent')
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
        
        echo view('admin/Academic/AdminStudents/AdminStudentsMain', $data);
        

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
            
            echo view('admin/Academic/AdminStudents/AdminStudentsNormal',$data);
            

    }

    public function AdminStudentsNormalShow($Key = null){
        try {
            $Keyword = "";
            $Key = urldecode($Key);

            if($Key == "normal"){
                $Keyword = "StudentStatus = '1/ปกติ' AND StudentBehavior != 'ขาดเรียนนาน'";
            } elseif($Key == 'absent_long'){
                $Keyword = "StudentBehavior = 'ขาดเรียนนาน' AND StudentStatus = '1/ปกติ'";
            } elseif($Key == 'dismissed'){
                $Keyword = "StudentBehavior = 'จำหน่าย'";
            } elseif($Key == 'studying'){
                // นักเรียนทั้งหมดที่กำลังศึกษาอยู่ (ไม่จบการศึกษาและไม่จำหน่าย)
                $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
            } else {
                // Default to studying students if Key is not recognized or empty
                $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
            }
           
            $builder = $this->db->table('tb_students');
            $builder->select('StudentID,
                            StudentNumber,
                            StudentClass,
                            StudentCode,
                            StudentPrefix,
                            StudentFirstName,
                            StudentLastName,
                            CONCAT(StudentPrefix, StudentFirstName, " ", StudentLastName) AS Fullname,
                            StudentStatus,
                            StudentBehavior,
                            StudentStudyLine,
                            StudentSex');
            $builder->where($Keyword); 

            // Filter by class
            $classFilter = $this->request->getPost('classFilter');
            if (!empty($classFilter)) {
                $builder->where('StudentClass', $classFilter);
            }

            // DataTables parameters
            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $length = $this->request->getPost('length');
            
            $searchValue = '';
            if (isset($this->request->getPost('search')['value'])) {
                $searchValue = $this->request->getPost('search')['value'];
            }

            $orderColumn = 0; // Default column index
            $orderDir = 'asc'; // Default order direction
            if (isset($this->request->getPost('order')[0])) {
                $orderColumn = $this->request->getPost('order')[0]['column'];
                $orderDir = $this->request->getPost('order')[0]['dir'];
            }
            $columns = $this->request->getPost('columns');

            // Total records (before filtering)
            $totalRecords = $builder->countAllResults(false); // false to not reset the query

            // Apply search filter
            if (!empty($searchValue)) {
                $builder->groupStart()
                        ->orLike('StudentCode', $searchValue)
                        ->orLike('StudentFirstName', $searchValue)
                        ->orLike('StudentLastName', $searchValue)
                        ->orLike('StudentClass', $searchValue)
                        ->groupEnd();
            }

            // Records after filtering
            $filteredRecords = $builder->countAllResults(false); // false to not reset the query

            // Apply order
            if (isset($columns[$orderColumn]['data'])) {
                $orderData = $columns[$orderColumn]['data'];
                if ($orderData === 'StudentNumber') {
                    $builder->orderBy('CAST(StudentNumber AS UNSIGNED)', $orderDir);
                } elseif ($orderData === 'StudentClass') {
                    // For StudentClass, sort by the numeric part after 'ม.'
                    $builder->orderBy('CAST(SUBSTRING(StudentClass, LOCATE('.', StudentClass) + 1) AS UNSIGNED)', $orderDir);
                } else {
                    $builder->orderBy($orderData, $orderDir);
                }
            }

            // Apply limit and offset
            $builder->limit($length, $start);

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
                    "StudentBehavior" => $record->StudentBehavior,
                    "StudentSex" => $record->StudentSex
                );

            }
            $output = array(
                "draw" => intval($draw),
                "recordsTotal" => intval($totalRecords),
                "recordsFiltered" => intval($filteredRecords),
                "data" =>  $data,           
            );


            return $this->response->setJSON($output);
        } catch (\Exception $e) {
            log_message('error', 'Error in AdminStudentsNormalShow: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'draw' => $this->request->getPost('draw') ?? 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'An internal server error occurred: ' . $e->getMessage()
            ]);
        }

    }

    public function AdminStudentsUpdate()
    {
        $service = $this->getClient();
        $spreadsheetId = '1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec'; // Assuming this is correct
        $range = 'stu1!A2:K1000';  // TODO: Update placeholder value.

        $response = $service ? $service->spreadsheets_values->get($spreadsheetId, $range) : null;
        $values = $response ? $response->getValues() : [];

        if (empty($values)) {
            session()->setFlashdata(['status' => 'error', 'messge' => 'ไม่พบข้อมูลใน Google Sheet หรือไม่สามารถโหลดข้อมูลได้', 'msg' => 'NO']);
            return redirect()->to(base_url('Admin/Acade/Registration/Students/Normal'));
        }

        $processedIdentifiers = []; // To track processed StudentCode/StudentIDNumber pairs from the sheet

        foreach ($values as $row) {
            $studentCode = !empty($row[2]) ? trim($row[2]) : '';
            $studentIdNumber = !empty($row[7]) ? str_replace('-', '', trim($row[7])) : ''; // Clean the ID number

            // Skip if both primary identifiers are missing
            if (empty($studentCode) && empty($studentIdNumber)) {
                continue;
            }

            // Create a unique key for the combination to check for duplicates within the sheet
            $identifierKey = $studentCode . '-' . $studentIdNumber;
            if (in_array($identifierKey, $processedIdentifiers)) {
                continue; // Skip if this combination has already been processed in this batch
            }
            $processedIdentifiers[] = $identifierKey;

            // Find existing student by StudentCode OR StudentIDNumber
            $builder = $this->db->table('tb_students');
            $builder->select('StudentID');
            $builder->groupStart();
            if (!empty($studentCode)) {
                $builder->where('StudentCode', $studentCode);
            }
            if (!empty($studentIdNumber)) {
                $builder->orWhere('StudentIDNumber', $studentIdNumber);
            }
            $builder->groupEnd();
            $existingStudent = $builder->get()->getRow();

            // Prepare data array from sheet row
            $studyLine = !empty($row[10]) ? $row[10] : '';
            $studentData = [
                'StudentNumber'    => !empty($row[0]) ? $row[0] : '',
                'StudentClass'     => !empty($row[1]) ? $row[1] : '',
                'StudentCode'      => $studentCode,
                'StudentPrefix'    => !empty($row[3]) ? $row[3] : '',
                'StudentFirstName' => !empty($row[4]) ? $row[4] : '',
                'StudentLastName'  => !empty($row[5]) ? $row[5] : '',
                'StudentDateBirth' => !empty($row[6]) ? $row[6] : '',
                'StudentIDNumber'  => !empty($row[7]) ? $row[7] : '', // Use the original, uncleaned version for DB
                'StudentStatus'    => !empty($row[8]) ? $row[8] : '',
                'StudentBehavior'  => !empty($row[9]) ? $row[9] : '',
                'StudentStudyLine' => $studyLine,
            ];

            if ($existingStudent) {
                // UPDATE existing record using its primary key
                $this->modAdminStudents->update($existingStudent->StudentID, $studentData);
            } else {
                // INSERT new record
                $this->modAdminStudents->Students_Insert($studentData);
            }
        }

        session()->setFlashdata(['status'=> 'success','messge' => 'อัพเดพข้อมูลสำเร็จ','msg'=>'YES']);
        return redirect()->to(base_url('Admin/Acade/Registration/Students/normal'));
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
        
        // เตรียมข้อมูลสำหรับส่งให้ Chart.js
        $class_labels = [];
        $male_data = [];
        $female_data = [];
        foreach ($students_by_class_from_db as $class) {
            $class_labels[] = 'ม.' . $class->class_level;
            $male_data[] = (int)$class->male_count;
            $female_data[] = (int)$class->female_count;
        }

        // 3. ดึงข้อมูลนักเรียนล่าสุด
        $recent_students = $this->modAdminStudents->get_recent_students(5);

        // จัดรูปแบบข้อมูลสำหรับส่งกลับเป็น JSON
        $data = [
            'gender_count' => [
                'male' => $gender_count->male ?? '0',
                'female' => $gender_count->female ?? '0'
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
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "จัดการข้อมูลนักเรียน LEC";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
       
        echo view('admin/Academic/AdminStudents/AdminStudentsDataLEC', $data);
        

    }

    

    public function get_student_details($student_id)
    {
        // Rewritten to use a direct JOIN as per user request.
        // This query joins the academic and personnel student tables using an INNER JOIN.
        // Note: This assumes the default DB user has permissions on the 'skjacth_personnel' database.
        $student_data = $this->db->table('tb_students AS academic')
            ->join('skjacth_personnel.tb_students AS personnel', "REPLACE(personnel.stu_iden, '-', '') = academic.StudentIDNumber",'left')
            ->where('academic.StudentID', $student_id)
            ->get()
            ->getRow();

            //echo '<pre>';print_r($student_data);exit();

        // If the INNER JOIN returns no result, it means no matching record was found in the personnel table.
        // In this case, we fall back to fetching only the main academic data.
        if (empty($student_data)) {
            $student_data = $this->modAdminStudents->get_student_by_id($student_id);
            // If still no data, then the student doesn't exist at all.
            if (empty($student_data)) {
                return '<div class="alert alert-danger">ไม่พบข้อมูลนักเรียน</div>';
            }
            // Set a flag to indicate that the linked personnel data was not found.
            $data['personnel_data_found'] = false;
        } else {
            $data['personnel_data_found'] = true;
        }

        $data['student'] = $student_data;
        $data['class_list'] = $this->classroom->ListRoom();
        $data['study_line_list'] = $this->classroom->studentStudyLineOptions();
        
        // Date conversion logic
        if (!empty($data['student']->StudentDateBirth)) {
            // Check if the date is in Buddhist format 'DD/MM/YYYY'
            $Ex = explode('/', $data['student']->StudentDateBirth);
            if (count($Ex) === 3 && is_numeric($Ex[2]) && (int)$Ex[2] > 1000) {
                $gregorian_year = (int)$Ex[2] - 543;
                $data['student']->StudentDateBirth = sprintf("%04d-%02d-%02d", $gregorian_year, $Ex[1], $Ex[0]);
            } elseif (strpos($data['student']->StudentDateBirth, '-') === false) {
                // If it's not in the expected Buddhist format and not already YYYY-MM-DD, clear it to avoid errors.
                 $data['student']->StudentDateBirth = '';
            }
        }
        
        return view('admin/Academic/AdminStudents/_student_details_form', $data);
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
            $student_date_birth_buddhist = sprintf('%02d-%02d-%04d', $day, $month, $buddhist_year); // Corrected format to match original CI3 data 'DD/MM/YYYY' for Buddhist year
        }
        if (!empty($student_date_birth_gregorian)) {
            list($gregorian_year, $month, $day) = explode('-', $student_date_birth_gregorian);
            $buddhist_year = (int)$gregorian_year + 543;
            $student_date_birth_buddhist_main = sprintf('%02d/%02d/%04d', $day, $month, $buddhist_year); // Corrected format to match original CI3 data 'DD/MM/YYYY' for Buddhist year
        }

        // Data for default tb_students
        $data_main = [
            'StudentPrefix' => $this->request->getPost('StudentPrefix'),
            'StudentFirstName' => $this->request->getPost('StudentFirstName'),
            'StudentLastName' => $this->request->getPost('StudentLastName'),
            'StudentClass' => $this->request->getPost('StudentClass'),
            'StudentNumber' => $this->request->getPost('StudentNumber'),
            'StudentCode' => $this->request->getPost('StudentCode'),
            'StudentSex' => $this->request->getPost('StudentSex'),
            'StudentStudyLine' => $this->request->getPost('StudentStudyLine'),
            'StudentStatus' => $this->request->getPost('StudentStatus'),
            'StudentBehavior' => $this->request->getPost('StudentBehavior'),
            'StudentIDNumber' => $this->request->getPost('StudentIDNumber'),
            'StudentDateBirth' => $student_date_birth_buddhist_main // Use converted Buddhist year
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

        // Sync common data to personnel table based on user request
        // Assuming column names like 'stu_firstname', 'stu_lastname', etc. exist in personnel.tb_students
        $common_data_for_personnel = [
            'stu_prefix'    => $this->request->getPost('StudentPrefix'),
            'stu_fristName' => $this->request->getPost('StudentFirstName'),
            'stu_lastName'  => $this->request->getPost('StudentLastName'),
            'stu_birthDay' => $student_date_birth_buddhist,
            'stu_iden'      => $this->request->getPost('StudentIDNumber')
        ];
        $data_personnel = array_merge($data_personnel, $common_data_for_personnel);

       
        // Remove null values to avoid overwriting existing data with empty strings
        $data_main = array_filter($data_main, function($value) { return $value !== null && $value !== ''; });
        $data_personnel = array_filter($data_personnel, function($value) { return $value !== null && $value !== ''; });
       
        // Clean the student ID number to remove dashes for matching with 'stu_iden' in the personnel database
        $student_id_number_cleaned = str_replace('-', '', $student_id_number);

        //    // --- DEBUGGING POST DATA ---
        // echo '<pre>';
        // print_r($student_id_number_cleaned);
        // echo '</pre>';
        // exit;
        // // --- END DEBUGGING ---


        // Assuming personnel table has stu_iden as primary key or unique identifier for update
        $success = $this->modAdminStudents->update_student_data($student_id, $data_main);
        $success_personnel = $this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $student_id_number_cleaned)->update($data_personnel);

        if ($success || $success_personnel) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }
}