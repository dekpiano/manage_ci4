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
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    private function check_pid($pid) {
        if(strlen($pid) != 13) return false;
        for($i=0, $sum=0; $i<12; $i++) {
            $sum += (int)($pid[$i])*(13-$i);
        }
        if((11-($sum%11))%10 == (int)($pid[12])) {
            return true;
        }
        return false;
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
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();
        
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
                // Use LIKE to support filtering by level (ม.1) or exact class (ม.1/1)
                $builder->like('StudentClass', $classFilter, 'after');
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
            $range = 'stu1!A2:L1300';  // Updated to L since StudentSex is removed
    
            $response = $service ? $service->spreadsheets_values->get($spreadsheetId, $range) : null;
            $values = $response ? $response->getValues() : [];
    
            if (empty($values)) {
                session()->setFlashdata(['status' => 'error', 'messge' => 'ไม่พบข้อมูลใน Google Sheet หรือไม่สามารถโหลดข้อมูลได้', 'msg' => 'NO']);
                return redirect()->to(base_url('Admin/Acade/Registration/Students/Normal'));
            }
    
            $successCount = 0;
            $conflictCount = 0;
            $skippedCount = 0;
            $invalidIdCount = 0; // Counter for invalid ID numbers
            $conflictDetails = [];
            $invalidIdDetails = []; // Details for invalid ID numbers
            $processedIdentifiers = []; // To track processed StudentCode/StudentIDNumber pairs from the sheet
    
            foreach ($values as $row) {
                $studentCode = isset($row[2]) ? trim($row[2]) : '';
                $studentIdNumberRaw = isset($row[7]) ? trim($row[7]) : '';
                $studentIdNumber = str_replace('-', '', $studentIdNumberRaw); // Clean the ID number for processing
    
                // --- National ID Validation ---
                if (!empty($studentIdNumber) && !$this->check_pid($studentIdNumber)) {
                    $invalidIdCount++;
                    $invalidIdDetails[] = [
                        'code' => $studentCode,
                        'id_number' => $studentIdNumberRaw,
                        'name' => (isset($row[3]) ? $row[3] : '') . (isset($row[4]) ? $row[4] : '') . ' ' . (isset($row[5]) ? $row[5] : '')
                    ];
                    continue; // Skip this row due to invalid ID format
                }
    
                // Skip if both primary identifiers are missing
                if (empty($studentCode) && empty($studentIdNumber)) {
                    $skippedCount++;
                    continue;
                }
    
                // Create a unique key for the combination to check for duplicates within the sheet
                $identifierKey = $studentCode . '-' . $studentIdNumber;
                if (in_array($identifierKey, $processedIdentifiers)) {
                    $skippedCount++;
                    continue; // Skip if this combination has already been processed in this batch
                }
                $processedIdentifiers[] = $identifierKey;
    
                // Detailed duplicate check
                $studentByCode = null;
                if (!empty($studentCode)) {
                    $studentByCode = $this->db->table('tb_students')->where('StudentCode', $studentCode)->get()->getRow();
                }
    
                $studentByIdNumber = null;
                if (!empty($studentIdNumber)) {
                    $studentByIdNumber = $this->db->table('tb_students')->where('StudentIDNumber', $studentIdNumber)->get()->getRow();
                }
    
                $existingStudent = null;
                $isConflict = false;
    
                if ($studentByCode && $studentByIdNumber) {
                    if ($studentByCode->StudentID !== $studentByIdNumber->StudentID) {
                        $isConflict = true; // Conflict: Code and ID belong to different students
                    } else {
                        $existingStudent = $studentByCode; // Both match the same student
                    }
                } elseif ($studentByCode) {
                    $existingStudent = $studentByCode;
                } elseif ($studentByIdNumber) {
                    $existingStudent = $studentByIdNumber;
                }
    
                if ($isConflict) {
                    $conflictCount++;
                    $conflictDetails[] = [
                        'code' => $studentCode,
                        'id_number' => $studentIdNumberRaw,
                        'name' => (isset($row[3]) ? $row[3] : '') . (isset($row[4]) ? $row[4] : '') . ' ' . (isset($row[5]) ? $row[5] : '')
                    ];
                    continue; // Skip this row due to conflict
                }
    
                // Prepare data array from sheet row
                $studentData = [
                    'StudentNumber'    => isset($row[0]) ? $row[0] : '',
                    'StudentClass'     => isset($row[1]) ? $row[1] : '',
                    'StudentCode'      => $studentCode,
                    'StudentPrefix'    => isset($row[3]) ? $row[3] : '',
                    'StudentFirstName' => isset($row[4]) ? $row[4] : '',
                    'StudentLastName'  => isset($row[5]) ? $row[5] : '',
                    'StudentDateBirth' => isset($row[6]) ? $row[6] : '',
                    'StudentIDNumber'  => $studentIdNumberRaw, // Use the original version for DB
                    'StudentStatus'    => isset($row[8]) ? $row[8] : '',
                    'StudentBehavior'  => isset($row[9]) ? $row[9] : '',
                    'StudentStudyLine'    => isset($row[10]) ? $row[10] : '',
                    'StudentDateEntrance' => isset($row[11]) ? $row[11] : '',
                    'StudentSex'          => in_array(isset($row[3]) ? trim($row[3]) : '', ['เด็กชาย', 'นาย']) ? 'ชาย' : 'หญิง',
                ];
    
                if ($existingStudent) {
                    // UPDATE existing record using its primary key
                    if($this->modAdminStudents->update($existingStudent->StudentID, $studentData)){
                        $successCount++;
                    }
                } else {
                    // INSERT new record
                    if($this->modAdminStudents->Students_Insert($studentData)){
                        $successCount++;
                    }
                }
            }
    
            $message = "ประมวลผลเสร็จสิ้น!<br><br>สำเร็จ: {$successCount} รายการ<br>ข้อมูลขัดแย้ง: {$conflictCount} รายการ<br>เลข ปชช. ไม่ถูกต้อง: {$invalidIdCount} รายการ<br>ข้าม (ข้อมูลไม่สมบูรณ์): {$skippedCount} รายการ";
            
            if (!empty($conflictDetails)) {
                $message .= '<br><br><b>รายละเอียดข้อมูลที่ขัดแย้ง:</b><ul style="text-align: left; max-height: 150px; overflow-y: auto;">';
                foreach ($conflictDetails as $conflict) {
                    $message .= '<li>' . htmlspecialchars($conflict['name']) . ' (Code: ' . htmlspecialchars($conflict['code']) . ', ID: ' . htmlspecialchars($conflict['id_number']) . ')</li>';
                }
                $message .= '</ul>';
            }
    
            if (!empty($invalidIdDetails)) {
                $message .= '<br><br><b>รายละเอียดเลข ปชช. ที่ไม่ถูกต้อง:</b><ul style="text-align: left; max-height: 150px; overflow-y: auto;">';
                foreach ($invalidIdDetails as $invalid) {
                    $message .= '<li>' . htmlspecialchars($invalid['name']) . ' (Code: ' . htmlspecialchars($invalid['code']) . ', ID: ' . htmlspecialchars($invalid['id_number']) . ')</li>';
                }
                $message .= '</ul>';
            }
    
            $status = ($successCount > 0) ? 'success' : 'warning';
    
            session()->setFlashdata(['status'=> $status,'messge' => $message,'msg'=>'YES']);
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
        // The query now correctly uses a LEFT JOIN to fetch student data, 
        // ensuring that academic info is returned even if personnel info is missing.
        $student_data = $this->db->table('tb_students AS academic')
            ->join('skjacth_personnel.tb_students AS personnel', "REPLACE(personnel.stu_iden, '-', '') = academic.StudentIDNumber", 'left')
            ->where('academic.StudentID', $student_id)
            ->get()
            ->getRow();

        // If no student data is found in the primary tb_students table, return an error.
        if (empty($student_data)) {
            return '<div class="alert alert-danger">ไม่พบข้อมูลนักเรียน</div>';
        }

        // Determine if linked personnel data was found by checking a field from the joined table.
        $data['personnel_data_found'] = !empty($student_data->stu_iden);

        $data['student'] = $student_data;
        $data['class_list'] = $this->classroom->ListRoom();
        $data['study_line_list'] = $this->classroom->studentStudyLineOptions();

        // Simplified and safer date conversion.
        // It handles dates in 'DD/MM/YYYY' (Buddhist) format and converts them to 'YYYY-MM-DD' (Gregorian) for form input.
        if (!empty($data['student']->StudentDateBirth)) {
            $parts = explode('/', $data['student']->StudentDateBirth);
            // Validate the parts and ensure it's a plausible Buddhist date before converting.
            if (count($parts) === 3 && is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2]) && $parts[2] > 2500) {
                $gregorian_year = (int)$parts[2] - 543;
                // Use checkdate for valid date check
                if (checkdate($parts[1], $parts[0], $gregorian_year)) {
                    $data['student']->StudentDateBirth = sprintf("%04d-%02d-%02d", $gregorian_year, $parts[1], $parts[0]);
                } else {
                    $data['student']->StudentDateBirth = ''; // Invalid date parts
                }
            } elseif (strpos($data['student']->StudentDateBirth, '-') === false) {
                // If the format is not DD/MM/YYYY and not already YYYY-MM-DD, clear it.
                $data['student']->StudentDateBirth = '';
            }
        }

        return view('admin/Academic/AdminStudents/_student_details_form', $data);
    }

    public function update_student_details()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $student_id = $this->request->getPost('StudentID');
        $student_id_number = $this->request->getPost('StudentIDNumber');

        if (empty($student_id) || empty($student_id_number)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Missing Student ID or National ID Number.']);
        }

        // --- Date Conversion ---
        $student_date_birth_gregorian = $this->request->getPost('StudentDateBirth');
        $student_date_birth_buddhist_main = null; // Format: DD/MM/YYYY
        $student_date_birth_buddhist_personnel = null; // Format: DD-MM-YYYY

        if (!empty($student_date_birth_gregorian)) {
            try {
                $date = new \DateTime($student_date_birth_gregorian);
                $buddhist_year = (int)$date->format('Y') + 543;
                $month = $date->format('m');
                $day = $date->format('d');
                
                $student_date_birth_buddhist_main = sprintf('%s/%s/%d', $day, $month, $buddhist_year);
                $student_date_birth_buddhist_personnel = sprintf('%s-%s-%d', $day, $month, $buddhist_year);
            } catch (\Exception $e) {
                // Handle invalid date format from POST
                log_message('error', 'Invalid date format during student update: ' . $e->getMessage());
            }
        }

        // --- Prepare Data Arrays ---
        $data_main = [
            'StudentPrefix' => $this->request->getPost('StudentPrefix'),
            'StudentFirstName' => $this->request->getPost('StudentFirstName'),
            'StudentLastName' => $this->request->getPost('StudentLastName'),
            'StudentClass' => $this->request->getPost('StudentClass'),
            'StudentNumber' => $this->request->getPost('StudentNumber'),
            'StudentCode' => $this->request->getPost('StudentCode'),
            'StudentSex' => in_array($this->request->getPost('StudentPrefix'), ['เด็กชาย', 'นาย']) ? 'ชาย' : 'หญิง',
            'StudentStudyLine' => $this->request->getPost('StudentStudyLine'),
            'StudentStatus' => $this->request->getPost('StudentStatus'),
            'StudentBehavior' => $this->request->getPost('StudentBehavior'),
            'StudentIDNumber' => $student_id_number,
            'StudentDateBirth' => $student_date_birth_buddhist_main,
            'StudentDateEntrance' => $this->request->getPost('StudentDateEntrance')
        ];

        $data_personnel = [
            // Common data synced from main table
            'stu_prefix'    => $this->request->getPost('StudentPrefix'),
            'stu_fristName' => $this->request->getPost('StudentFirstName'), // Note: 'fristName' might be a typo in the original DB schema
            'stu_lastName'  => $this->request->getPost('StudentLastName'),
            'stu_birthDay'  => $student_date_birth_buddhist_personnel,
            'stu_iden'      => $student_id_number,
            // Personnel-specific data
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
            'stu_hCode' => $this->request->getPost('stu_hCode'),
            'stu_hNumber' => $this->request->getPost('stu_hNumber'),
            'stu_hMoo' => $this->request->getPost('stu_hMoo'),
            'stu_hRoad' => $this->request->getPost('stu_hRoad'),
            'stu_hTambon' => $this->request->getPost('stu_hTambon'),
            'stu_hDistrict' => $this->request->getPost('stu_hDistrict'),
            'stu_hProvince' => $this->request->getPost('stu_hProvince'),
            'stu_hPostCode' => $this->request->getPost('stu_hPostCode'),
            'stu_cNumber' => $this->request->getPost('stu_cNumber'),
            'stu_cMoo' => $this->request->getPost('stu_cMoo'),
            'stu_cRoad' => $this->request->getPost('stu_cRoad'),
            'stu_cTumbao' => $this->request->getPost('stu_cTumbao'),
            'stu_cDistrict' => $this->request->getPost('stu_cDistrict'),
            'stu_cProvince' => $this->request->getPost('stu_cProvince'),
            'stu_cPostcode' => $this->request->getPost('stu_cPostcode'),
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
        
        // Remove null/empty values to avoid overwriting existing data unintentionally
        $data_main = array_filter($data_main, fn($value) => $value !== null && $value !== '');
        $data_personnel = array_filter($data_personnel, fn($value) => $value !== null && $value !== '');

        // --- Database Transaction ---
        // Use the default database connection for transaction
        $this->db->transStart();

        // 1. Update main student table
        if (!empty($data_main)) {
            $this->modAdminStudents->update($student_id, $data_main);
        }

        // 2. Upsert (Update or Insert) personnel student table
        if (!empty($data_personnel)) {
            $student_id_number_cleaned = str_replace('-', '', $student_id_number);
            $personnel_student = $this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $student_id_number_cleaned)->get()->getRow();

            if ($personnel_student) {
                // It's safer to use the primary key for updates if available. Assuming 'stu_id'.
                $this->DBpersonnel->table('tb_students')->where('stu_id', $personnel_student->stu_id)->update($data_personnel);
            } else {
                // Insert new record if it doesn't exist
                $this->DBpersonnel->table('tb_students')->insert($data_personnel);
            }
        }

        $this->db->transComplete();

        // --- Response ---
        if ($this->db->transStatus() === false) {
            // Log the error for debugging
            log_message('error', 'Student data update transaction failed.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        } else {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว']);
        }
    }

    public function exportStudents($filterType = 'all')
    {
        $path = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
		require $path . '/librarie_skj/spreadsheet/vendor/autoload.php';

        // Ensure the PhpSpreadsheet library is loaded
        // It's already included via use statements at the top of the file.

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- TEMPORARY: Read headers from M11_2568.xls template ---
        $templateFileName = ROOTPATH . 'M11_2568.xls';
        $templateSpreadsheet = IOFactory::load($templateFileName);
        $templateSheet = $templateSpreadsheet->getActiveSheet();
        $headers = $templateSheet->rangeToArray('A2:' . $templateSheet->getHighestColumn() . '2', NULL, TRUE, TRUE, TRUE)[2];
        echo '<pre>'; print_r($headers); exit();
        // --- END TEMPORARY ---

        // Set headers
        // $headers = [
        //     'รหัสนักเรียน',
        //     'เลขประจำตัวประชาชน',
        //     'คำนำหน้า',
        //     'ชื่อ',
        //     'นามสกุล',
        //     'ชื่อ-นามสกุล',
        //     'เพศ',
        //     'วันเกิด',
        //     'ชั้น',
        //     'เลขที่',
        //     'สายการเรียน',
        //     'สถานะนักเรียน',
        //     'สถานะพฤติกรรม',
        //     'วันที่เข้าเรียน',
        // ];
        $sheet->fromArray($headers, NULL, 'A1');

        // Fetch student data based on filterType and classFilter
        $builder = $this->db->table('tb_students');
        $builder->select(
            'StudentID,'
            .'StudentIDNumber,'
            .'StudentPrefix,'
            .'StudentFirstName,'
            .'StudentLastName,'
            .'CONCAT(StudentPrefix, StudentFirstName, " ", StudentLastName) AS Fullname,'
            .'StudentSex,'
            .'StudentDateBirth,'
            .'StudentClass,'
            .'StudentNumber,'
            .'StudentStudyLine,'
            .'StudentStatus,'
            .'StudentBehavior,'
            .'StudentDateEntrance'
        );

        $Keyword = "";
        if ($filterType == "normal") {
            $Keyword = "StudentStatus = '1/ปกติ' AND StudentBehavior != 'ขาดเรียนนาน'";
        } elseif ($filterType == 'absent_long') {
            $Keyword = "StudentBehavior = 'ขาดเรียนนาน' AND StudentStatus = '1/ปกติ'";
        } elseif ($filterType == 'dismissed') {
            $Keyword = "StudentBehavior = 'จำหน่าย'";
        } elseif ($filterType == 'studying') {
            $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
        } elseif ($filterType == 'all') {
            // No specific filter for 'all', but exclude 'จบการศึกษา' and 'จำหน่าย' by default for a general list
            $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
        }

        if (!empty($Keyword)) {
            $builder->where($Keyword);
        }

        // Apply class filter if present in GET request (for AdminStudentsNormal page)
        $classFilter = $this->request->getGet('classFilter');
        if (!empty($classFilter)) {
            $builder->where('StudentClass', $classFilter);
        }

        $students = $builder->get()->getResultArray();

        $row = 2; // Start data from row 2, after headers
        foreach ($students as $student) {
            $sheet->setCellValueByColumnAndRow(1, $row, $student['StudentID']);
            $sheet->setCellValueByColumnAndRow(2, $row, $student['StudentIDNumber']);
            $sheet->setCellValueByColumnAndRow(3, $row, $student['StudentPrefix']);
            $sheet->setCellValueByColumnAndRow(4, $row, $student['StudentFirstName']);
            $sheet->setCellValueByColumnAndRow(5, $row, $student['StudentLastName']);
            $sheet->setCellValueByColumnAndRow(6, $row, $student['Fullname']);
            $sheet->setCellValueByColumnAndRow(7, $row, $student['StudentSex']);
            $sheet->setCellValueByColumnAndRow(8, $row, $student['StudentDateBirth']);
            $sheet->setCellValueByColumnAndRow(9, $row, $student['StudentClass']);
            $sheet->setCellValueByColumnAndRow(10, $row, $student['StudentNumber']);
            $sheet->setCellValueByColumnAndRow(11, $row, $student['StudentStudyLine']);
            $sheet->setCellValueByColumnAndRow(12, $row, $student['StudentStatus']);
            $sheet->setCellValueByColumnAndRow(13, $row, $student['StudentBehavior']);
            $sheet->setCellValueByColumnAndRow(14, $row, $student['StudentDateEntrance']);
            $row++;
        }

        // Set auto size for columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'student_data_' . date('Ymd_His') . '.xlsx';

        $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->response->setHeader('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $this->response->setHeader('Cache-Control', 'max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
