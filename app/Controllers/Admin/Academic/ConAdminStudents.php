<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminStudents;
use App\Models\Admin\ModAdminClassRoom;
use App\Libraries\Classroom; // Add this line

class ConAdminStudents extends BaseController
{
    protected $modAdminStudents;
    protected $modAdminClassRoom;
    protected $DBpersonnel;
    protected $db;
    protected $classroom;

    public function __construct()
    {
        $this->modAdminStudents = new ModAdminStudents();
        $this->modAdminClassRoom = new ModAdminClassRoom();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        $this->classroom = new Classroom(); // Initialize the Classroom library

        helper(['url', 'form', 'year']);

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

    /**
     * ดึงข้อมูลจาก Google Sheets - วิธีที่ 1 (CSV Publish to Web) 💎
     * ง่ายที่สุด บรรทัดเดียวจบ! ไม่ต้องใช้ Service Key
     */
    private function getSheetsData($input)
    {
        $csvUrl = $input;
        
        // หากสิ่งที่ส่งมา ไม่ใช่ลิงก์ (ไม่มี http) แสดงว่าเป็นแค่ ID ของชีตแน่ๆ
        // เราจะทำการแปลงร่างให้เป็นลิงก์ดึง CSV ให้เลยแบบอัตโนมัติครับ! 💎
        if (!preg_match('/^https?:\/\//i', $input)) {
            $csvUrl = "https://docs.google.com/spreadsheets/d/{$input}/export?format=csv&gid=0";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $csvUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // เพิ่ม User-Agent เพื่อให้ Google ไม่มองว่าเป็นบอทแปลกปลอม
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        
        $csvData = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($csvData === false) {
            throw new \Exception("cURL Error: " . $curlError);
        }

        if ($httpCode !== 200) {
            throw new \Exception("HTTP Error: บีบข้อมูลไม่สำเร็จ (Code: $httpCode)");
        }

        // ตรวจสอบว่าสิ่งที่ได้มาคือหน้าเว็บ (HTML) หรือไม่? 
        if (preg_match('/^\s*<(!DOCTYPE|html)/i', $csvData)) {
            throw new \Exception("ลิงก์ไม่ถูกต้อง: ข้อมูลที่ได้รับเป็นหน้าเว็บ (HTML) ไม่ใช่ CSV กรุณาตรวจสอบว่าได้เลือก 'Publish to web' และเลือกเป็น 'CSV' แล้วหรือยัง");
        }

        // แปลง CSV เป็น Array ด้วยวิธีที่รองรับ Multiline ในช่องครับ 💎
        $values = [];
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $csvData);
        rewind($stream);
        
        while (($row = fgetcsv($stream)) !== false) {
            // ข้ามแถวที่ว่างเปล่าจริงๆ ครับ
            if (empty(array_filter($row, function($cell) { return trim($cell) !== ""; }))) continue;
            $values[] = $row;
        }
        fclose($stream);

        return $values;
    }

    public function changeYear($year)
    {
        session()->set('schyear_year', $year);
        return redirect()->back();
    }

    public function AdminStudentsMain($Key = null){ 
    $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['CountAllStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stuall')
            ->where('StudentStatus', '1/ปกติ')
            ->get()->getRow();
            
        $data['CountNormalStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stunormal')
            ->where('StudentStatus', '1/ปกติ')
            ->groupStart()
                ->where('StudentBehavior', 'ปกติ')
                ->orWhere('StudentBehavior', '')
                ->orWhere('StudentBehavior', NULL)
            ->groupEnd()
            ->get()->getRow();
            
        $data['CountAbsentStu'] = $this->db->table('tb_students')->select('COUNT(StudentID) AS stuabsent')
            ->where('StudentBehavior', 'ขาดเรียนนาน')
            ->where('StudentStatus', '1/ปกติ')
            ->get()->getRow();

        $data['school_years'] = $this->db->table('tb_schoolyear')->orderBy('schyear_year', 'desc')->get()->getResult();
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

    public function AdminStudentsLifecycle()
    {
        // Auto-check and add columns if they don't exist
        try {
            if (!$this->db->fieldExists('StudentStatusDate', 'tb_students')) {
                $this->db->query("ALTER TABLE tb_students ADD COLUMN StudentStatusDate VARCHAR(10) NULL AFTER StudentStatus");
            }
            if (!$this->db->fieldExists('StudentStatusYear', 'tb_students')) {
                $this->db->query("ALTER TABLE tb_students ADD COLUMN StudentStatusYear VARCHAR(10) NULL AFTER StudentStatusDate");
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to add lifecycle columns: ' . $e->getMessage());
        }

        $data['title'] = "จัดการเลื่อนชั้นและสถานะนักเรียน";
        $data['class_list'] = $this->classroom->ListRoom();
        
        $data['school_years'] = $this->db->table('tb_schoolyear')->orderBy('schyear_year', 'desc')->get()->getResult();

        return view('admin/Academic/AdminStudents/AdminStudentsLifecycle', $data);
    }

    public function getStudentsByFilters()
    {
        try {
            $class = $this->request->getGet('class');
            $status = $this->request->getGet('status');

            $builder = $this->db->table('tb_students');
            $builder->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber, StudentStatus, StudentBehavior, StudentDateEntrance, StudentDateApprove, StudentDateFinish, StudentStatusDate');
            
            if (!empty($class)) {
                $builder->like('StudentClass', $class, 'after');
            }
            
            if (!empty($status)) {
                $builder->where('StudentStatus', $status);
            } else {
                $builder->where('StudentStatus', '1/ปกติ');
            }

            // Simple ordering to avoid complex SQL issues
            $builder->orderBy('StudentClass', 'ASC');
            $builder->orderBy('StudentNumber', 'ASC');

            $students = $builder->get()->getResult();

            return $this->response->setJSON($students);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function processStatusUpdateBulk()
    {
        $studentIds  = $this->request->getPost('student_ids');
        $newStatus   = $this->request->getPost('new_status');
        $statusYear  = $this->request->getPost('status_year') ?: get_selected_year(); // e.g., '2568/1' or '1/2568'
        $leaveReason = $this->request->getPost('leave_reason');
        $dateApprove = $this->request->getPost('date_approve');
        $dateFinish  = $this->request->getPost('date_finish');

        // Robust Year Extraction: find the 4-digit part
        $yearOnly = $statusYear;
        $parts = explode('/', $statusYear);
        foreach($parts as $p) {
            if(strlen(trim($p)) == 4) {
                $yearOnly = trim($p);
                break;
            }
        }

        if (empty($studentIds) || empty($newStatus)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
        }

        $this->db->transStart();

        foreach ($studentIds as $id) {
            $student = $this->db->table('tb_students')->where('StudentID', $id)->get()->getRow();
            if ($student) {
                $finalLeaveReason = $leaveReason;

                // Auto-fill Logic based on requirements
                if (empty($finalLeaveReason)) {
                    if ($newStatus == '5/จบการศึกษา') {
                        if (strpos($student->StudentClass, '3') !== false) {
                            $finalLeaveReason = 'จบการศึกษาภาคบังคับ';
                        } elseif (strpos($student->StudentClass, '6') !== false) {
                            $finalLeaveReason = 'จบการศึกษาขั้นพื้นฐาน';
                        }
                    } elseif ($newStatus == '2/ย้ายสถานศึกษา') {
                        $finalLeaveReason = 'ศึกษาต่อสถานศึกษาอื่น';
                    }
                }

                // Convert date_approve to B.E. (dd/mm/yyyy) if not empty
                $formatted_approve = null;
                if (!empty($dateApprove)) {
                    $d = new \DateTime($dateApprove);
                    $formatted_approve = $d->format('d/m/') . ((int)$d->format('Y') + 543);
                }

                // Convert date_finish to B.E. (dd/mm/yyyy) if not empty
                $formatted_finish = null;
                if (!empty($dateFinish)) {
                    $d = new \DateTime($dateFinish);
                    $formatted_finish = $d->format('d/m/') . ((int)$d->format('Y') + 543);
                }

                $d_now = new \DateTime();
                $date_now = $d_now->format('d/m/') . ((int)$d_now->format('Y') + 543);

                $data = [
                    'StudentStatus'      => $newStatus,
                    'StudentDateApprove' => $formatted_approve,
                    'StudentDateFinish'  => $formatted_finish,
                    'StudentStatusDate'  => $date_now,
                    'StudentLeave'       => $finalLeaveReason
                ];

                // Only set YearFinish if the student is finishing their education here (Graduate/Transfer/Exit)
                // If they are just moving back to 'Normal' or 'Suspended', YearFinish should be cleared/null
                if (in_array($newStatus, ['5/จบการศึกษา', '2/ย้ายสถานศึกษา', '3/จำหน่าย'])) {
                    $data['YearFinish'] = $yearOnly;
                } else {
                    $data['YearFinish'] = null; 
                }

                $this->db->table('tb_students')->where('StudentID', $id)->update($data);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'อัปเดตสถานะนักเรียน ' . count($studentIds) . ' รายการสำเร็จ']);
    }

    public function processPromotionBulk()
    {
        $studentIds = $this->request->getPost('student_ids');
        $nextGrade = $this->request->getPost('next_grade'); // e.g., '2'
        $nextRoom = $this->request->getPost('next_room');   // e.g., '1'
        $nextStatus = $this->request->getPost('next_status'); // For those who graduate
        $statusYear = $this->request->getPost('status_year') ?: get_selected_year();

        // Robust Year Extraction: find the 4-digit part
        $yearOnly = $statusYear;
        $parts = explode('/', $statusYear);
        foreach($parts as $p) {
            if(strlen(trim($p)) == 4) {
                $yearOnly = trim($p);
                break;
            }
        }

        if (empty($studentIds)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเลือกนักเรียน']);
        }

        $this->db->transStart();

        $updateData = [];

        // Only set YearFinish if we are specifically setting a "Finish" status (Graduate/Exit)
        // If it's a normal promotion, nextStatus will be empty or 1/ปกติ
        if (!empty($nextStatus) && in_array($nextStatus, ['5/จบการศึกษา', '2/ย้ายสถานศึกษา', '3/จำหน่าย'])) {
            $updateData['YearFinish'] = $yearOnly;
        } else {
            // Ensure YearFinish is null for normal promotions
            $updateData['YearFinish'] = null;
        }

        if (!empty($nextStatus)) {
            $updateData['StudentStatus'] = $nextStatus;
        }

        if (!empty($nextGrade) && !empty($nextRoom)) {
            $updateData['StudentClass'] = "ม.{$nextGrade}/{$nextRoom}";
        }

        $this->db->table('tb_students')->whereIn('StudentID', $studentIds)->update($updateData);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการประมวลผล']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'ดำเนินการสำเร็จ ' . count($studentIds) . ' รายการ']);
    }


    public function AdminStudentsNormal(){
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['class_list'] = $this->classroom->ListRoom(); // Use the initialized classroom library
        $data['school_years'] = $this->db->table('tb_schoolyear')->orderBy('schyear_year','desc')->get()->getResult();
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
                $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
            } else {
                $Keyword = "StudentStatus != '5/จบการศึกษา' AND StudentBehavior != 'จำหน่าย'";
            }
           
            $builder = $this->db->table('tb_students');
            $builder->select('StudentID, StudentNumber, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, CONCAT(StudentPrefix, StudentFirstName, " ", StudentLastName) AS Fullname, StudentStatus, StudentBehavior, StudentStudyLine, StudentSex');
            $builder->where($Keyword); 

            $classFilter = $this->request->getPost('classFilter');
            if (!empty($classFilter)) {
                $builder->like('StudentClass', $classFilter, 'after');
            }

            $draw = $this->request->getPost('draw');
            $start = $this->request->getPost('start');
            $length = $this->request->getPost('length');
            
            $searchValue = '';
            if (isset($this->request->getPost('search')['value'])) {
                $searchValue = $this->request->getPost('search')['value'];
            }

            $orderColumn = 0; 
            $orderDir = 'asc'; 
            if (isset($this->request->getPost('order')[0])) {
                $orderColumn = $this->request->getPost('order')[0]['column'];
                $orderDir = $this->request->getPost('order')[0]['dir'];
            }
            $columns = $this->request->getPost('columns');

            $totalRecords = $builder->countAllResults(false); 

            if (!empty($searchValue)) {
                $builder->groupStart()
                        ->orLike('StudentCode', $searchValue)
                        ->orLike('StudentFirstName', $searchValue)
                        ->orLike('StudentLastName', $searchValue)
                        ->orLike('StudentClass', $searchValue)
                        ->groupEnd();
            }

            $filteredRecords = $builder->countAllResults(false); 

            if (isset($columns[$orderColumn]['data'])) {
                $orderData = $columns[$orderColumn]['data'];
                if ($orderData === 'StudentNumber') {
                    $builder->orderBy('CAST(StudentNumber AS UNSIGNED)', $orderDir);
                } elseif ($orderData === 'StudentClass') {
                    $builder->orderBy('CAST(SUBSTRING(StudentClass, LOCATE(".", StudentClass) + 1) AS UNSIGNED)', $orderDir);
                } else {
                    $builder->orderBy($orderData, $orderDir);
                }
            }

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
        try {
            // ลิงก์ CSV ตัวจริงที่คุณครูให้มาครับ! 🚀
            $csvUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vS1yjCeCmtPr8KRN_TLuLmMME2yjL8mlGShG36iivJEtmrfX81Le9Do9iqYJ5mbHekkO6_PSyO7f9rO/pub?gid=0&single=true&output=csv";
            
            $values = $this->getSheetsData($csvUrl);

        if (empty($values)) {
            session()->setFlashdata(['status' => 'error', 'messge' => 'ไม่พบข้อมูลใน Google Sheet หรือไม่สามารถโหลดข้อมูลได้', 'msg' => 'NO']);
            return redirect()->to(base_url('Admin/Acade/Registration/Students/Normal'));
        }

        $successCount = 0;
        $conflictCount = 0;
        $skippedCount = 0;
        $invalidIdCount = 0; 
        $conflictDetails = [];
        $invalidIdDetails = []; 
        $processedIdentifiers = []; 

        $isHeader = true;
        foreach ($values as $row) {
            // ข้ามแถวหัวตารางครับ 💎
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            // ข้ามแถวที่ไม่มีข้อมูลลำดับสำคัญ (Col 2: เลขประจำตัว)
            if (!isset($row[2]) || empty(trim($row[2]))) {
                $skippedCount++;
                continue;
            }

            $studentNumber    = trim($row[0] ?? '');  // StudentNumber / เลขที่
            $studentClass     = trim($row[1] ?? '');  // ชั้นปี
            $studentCode      = trim($row[2] ?? '');  // เลขประจำตัว
            $prefix           = trim($row[3] ?? '');  // คำนำหน้า
            $firstName        = trim($row[4] ?? '');  // ชื่อ
            $lastName         = trim($row[5] ?? '');  // นามสกุล
            $dateBirth        = trim($row[6] ?? '');  // วันเกิด
            $idNumberRaw      = trim($row[7] ?? '');  // เลขประจำตัวประชาชน
            $status           = trim($row[8] ?? '1/ปกติ'); // สถานะนักเรียน
            $behavior         = trim($row[9] ?? 'ปกติ');  // สถานะพฤติกรรม
            $studyLine        = trim($row[10] ?? '');  // Lineสายการเรียน
            $dateEntrance     = trim($row[11] ?? '');  // วันที่เข้าเรียน

            $studentIdNumber = str_replace(['-', ' '], '', $idNumberRaw); 

            if (!empty($studentIdNumber) && !$this->check_pid($studentIdNumber)) {
                $invalidIdCount++;
                $invalidIdDetails[] = [
                    'code' => $studentCode,
                    'id_number' => $idNumberRaw,
                    'name' => "$prefix$firstName $lastName"
                ];
                continue; 
            }

            if (empty($studentCode) && empty($studentIdNumber)) {
                $skippedCount++;
                continue;
            }

            $identifierKey = "$studentCode-$studentIdNumber";
            if (in_array($identifierKey, $processedIdentifiers)) {
                $skippedCount++;
                continue; 
            }
            $processedIdentifiers[] = $identifierKey;

            $studentByCode = !empty($studentCode) ? $this->db->table('tb_students')->where('StudentCode', $studentCode)->get()->getRow() : null;
            $studentByIdNumber = !empty($studentIdNumber) ? $this->db->table('tb_students')->where('REPLACE(StudentIDNumber, "-", "")', $studentIdNumber)->get()->getRow() : null;

            $existingStudent = null;
            $isConflict = false;

            if ($studentByCode && $studentByIdNumber) {
                if ($studentByCode->StudentID !== $studentByIdNumber->StudentID) {
                    $isConflict = true; 
                } else {
                    $existingStudent = $studentByCode;
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
                    'id_number' => $idNumberRaw,
                    'name' => "$prefix$firstName $lastName"
                ];
                continue; 
            }

            $studentData = [
                'StudentNumber'    => $studentNumber,
                'StudentClass'     => $studentClass,
                'StudentCode'      => $studentCode,
                'StudentPrefix'    => $prefix,
                'StudentFirstName' => $firstName,
                'StudentLastName'  => $lastName,
                'StudentDateBirth' => $dateBirth,
                'StudentIDNumber'  => $idNumberRaw, 
                'StudentStatus'    => $status,
                'StudentBehavior'  => $behavior,
                'StudentStudyLine'    => $studyLine,
                'StudentDateEntrance' => $dateEntrance,
                'StudentSex'          => in_array($prefix, ['เด็กชาย', 'นาย']) ? 'ชาย' : 'หญิง',
            ];

            if ($existingStudent) {
                if($this->modAdminStudents->update($existingStudent->StudentID, $studentData)){
                    $successCount++;
                }
            } else {
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
    } catch (\Exception $e) { 
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'API Error: ' . $e->getMessage()
        ]); 
    }
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

    public function getDashboardData(){
        $this->response->setHeader('Content-Type', 'application/json');
        $gender_count = $this->modAdminStudents->get_gender_count();
        $students_by_class_from_db = $this->modAdminStudents->get_students_by_class();
        $class_labels = [];
        $male_data = [];
        $female_data = [];
        foreach ($students_by_class_from_db as $class) {
            $class_labels[] = 'ม.' . $class->class_level;
            $male_data[] = (int)$class->male_count;
            $female_data[] = (int)$class->female_count;
        }
        $recent_students = $this->modAdminStudents->get_recent_students(5);
        $data = [
            'gender_count' => [
                'male' => $gender_count->male ?? '0',
                'female' => $gender_count->female ?? '0'
            ],
            'students_by_class' => [
                'labels' => $class_labels,
                'datasets' => [
                    ['label' => 'ชาย','data' => $male_data,'backgroundColor' => 'rgba(54, 162, 235, 0.5)'],
                    ['label' => 'หญิง','data' => $female_data,'backgroundColor' => 'rgba(255, 99, 132, 0.5)']
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
        $student_data = $this->db->table('tb_students AS academic')
            ->join('skjacth_personnel.tb_students AS personnel', "REPLACE(personnel.stu_iden, '-', '') = academic.StudentIDNumber", 'left')
            ->where('academic.StudentID', $student_id)
            ->get()->getRow();
        if (empty($student_data)) {
            return '<div class="alert alert-danger">ไม่พบข้อมูลนักเรียน</div>';
        }
        $data['personnel_data_found'] = !empty($student_data->stu_iden);
        $data['student'] = $student_data;
        $data['class_list'] = $this->classroom->ListRoom();
        $data['study_line_list'] = $this->classroom->studentStudyLineOptions();
        // Keep dates in B.E. format (dd/mm/yyyy) for the B.E. date picker
        /*
        $date_fields = ['StudentDateBirth', 'StudentDateEntrance'];
        foreach ($date_fields as $field) {
            if (!empty($data['student']->$field)) {
                $parts = explode('/', $data['student']->$field);
                if (count($parts) === 3 && is_numeric($parts[2]) && $parts[2] > 2500) {
                    $gregorian_year = (int)$parts[2] - 543;
                    $data['student']->$field = sprintf("%04d-%02d-%02d", $gregorian_year, $parts[1], $parts[0]);
                }
            }
        }
        */
        return view('admin/Academic/AdminStudents/_student_details_form', $data);
    }

    public function update_student_details()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $student_id = $this->request->getPost('StudentID');
        $student_id_number = $this->request->getPost('StudentIDNumber');
        if (empty($student_id) || empty($student_id_number)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Missing ID.']);
        }
        $student_date_birth_buddhist_main = null; 
        $student_date_birth_buddhist_personnel = null; 
        $student_date_entrance_buddhist = null;
        if ($birth = $this->request->getPost('StudentDateBirth')) {
            try {
                $date = new \DateTime($birth);
                $buddhist_year = (int)$date->format('Y') + 543;
                $student_date_birth_buddhist_main = $date->format("d/m/$buddhist_year");
                $student_date_birth_buddhist_personnel = $date->format("d-m-$buddhist_year");
            } catch (\Exception $e) {}
        }
        if ($entrance = $this->request->getPost('StudentDateEntrance')) {
            try {
                $date = new \DateTime($entrance);
                $buddhist_year = (int)$date->format('Y') + 543;
                $student_date_entrance_buddhist = $date->format("d/m/$buddhist_year");
            } catch (\Exception $e) {}
        }
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
            'StudentDateEntrance' => $student_date_entrance_buddhist
        ];
        $data_personnel = [
            'stu_prefix'    => $this->request->getPost('StudentPrefix'),
            'stu_fristName' => $this->request->getPost('StudentFirstName'),
            'stu_lastName'  => $this->request->getPost('StudentLastName'),
            'stu_birthDay'  => $student_date_birth_buddhist_personnel,
            'stu_iden'      => $student_id_number,
        ];

        // Only update these if they are actually sent (they are now removed from simple form)
        $extra_fields = ['stu_nickName', 'stu_phone', 'stu_email', 'stu_bloodType', 'stu_nationality', 'stu_race', 'stu_religion', 'stu_hNumber', 'stu_hTambon', 'stu_hDistrict', 'stu_hProvince', 'stu_hPostCode'];
        foreach ($extra_fields as $f) {
            $val = $this->request->getPost($f);
            if ($val !== null) $data_personnel[$f] = $val;
        }
        $this->db->transStart();
        try {
            $this->modAdminStudents->update($student_id, $data_main);
            
            $student_id_number_cleaned = str_replace('-', '', $student_id_number);
            
            // ใช้ query แบบ raw SQL นิดหน่อยเพื่อให้ชัวร์เรื่องฟังค์ชั่น REPLACE ครับ
            $personnel_check = $this->DBpersonnel->query("SELECT COUNT(*) AS count FROM tb_students WHERE REPLACE(stu_iden, '-', '') = '$student_id_number_cleaned'")->getRow();

            if ($personnel_check && $personnel_check->count > 0) {
                // อัปเดตข้อมูลเดิม (ใช้ raw query เพื่อความแม่นยำกับตัวแปรที่มีอักขระพิเศษ)
                $this->DBpersonnel->table('tb_students')
                    ->where("REPLACE(stu_iden, '-', '') = '$student_id_number_cleaned'", null, false)
                    ->update($data_personnel);
            } else {
                // ถ้าไม่มีข้อมูลเดิม ให้เพิ่มใหม่
                $data_personnel['stu_iden'] = $student_id_number;
                $this->DBpersonnel->table('tb_students')->insert($data_personnel);
            }

            $this->db->transComplete();
            
            if ($this->db->transStatus() === false) {
                throw new \Exception("ไม่สามารถจบ Transaction ของฐานข้อมูลหลักได้");
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว']);

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Update Student Details Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'เกิดความผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage()
            ]);
        }
    }

    public function AdminStudentsEditSearch()
    {
        $data['title'] = "ค้นหาข้อมูลนักเรียนเพื่อแก้ไขรายบุคคล";
        return view('admin/Academic/AdminStudents/AdminStudentsEditSearch', $data);
    }

    public function processGoogleSheetImport()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $csvUrl = $this->request->getPost('spreadsheet_id') ?: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vS1yjCeCmtPr8KRN_TLuLmMME2yjL8mlGShG36iivJEtmrfX81Le9Do9iqYJ5mbHekkO6_PSyO7f9rO/pub?gid=0&single=true&output=csv';
        $syncMode = $this->request->getPost('sync_mode') ?: 'upsert'; 
        $targetClass = $this->request->getPost('target_class') ?: 'all'; 
        $isDryRun = $this->request->getPost('dry_run') === 'true';

        try {
            $values = $this->getSheetsData($csvUrl);
            if (empty($values)) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลใน CSV หรือลิงก์ไม่ถูกต้อง']);

            $successCount = 0; $conflictCount = 0; $skippedCount = 0; $invalidIdCount = 0; $filteredOutCount = 0;
            $processedIdentifiers = [];
            $previewData = [];

            if (!$isDryRun) $this->db->transStart();

            $isHeader = true;
            foreach ($values as $row) {
                // ข้ามแถวหัวตารางครับ 💎
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }
                
                // ข้ามแถวว่าง (ตรวจสอบจากเลขประจำตัวที่ Col 2)
                if (!isset($row[2]) || empty(trim($row[2]))) continue;

                $studentNumber = trim($row[0] ?? '');  // StudentNumber / เลขที่
                $studentClass = trim($row[1] ?? '');   // ชั้นปี
                $studentCode = trim($row[2] ?? '');    // เลขประจำตัว
                $prefix = trim($row[3] ?? '');         // คำนำหน้า
                $firstName = trim($row[4] ?? '');      // ชื่อ
                $lastName = trim($row[5] ?? '');       // นามสกุล
                $dateBirth = trim($row[6] ?? '');      // วันเกิด
                $idNumberRaw = trim($row[7] ?? '');    // เลขประจำตัวประชาชน
                $status = trim($row[8] ?? '1/ปกติ');   // สถานะนักเรียน
                $behavior = trim($row[9] ?? 'ปกติ');  // สถานะพฤติกรรม
                $studyLine = trim($row[10] ?? '');     // Lineสายการเรียน
                $dateEntrance = trim($row[11] ?? '');  // วันที่เข้าเรียน

                if ($targetClass !== 'all' && strpos($studentClass, $targetClass) === false) { $filteredOutCount++; continue; }
                
                $studentIdNumber = str_replace(['-', ' '], '', $idNumberRaw);
                $isIdValid = empty($studentIdNumber) || $this->check_pid($studentIdNumber);
                
                if (!$isIdValid) { 
                    $invalidIdCount++; 
                    if ($isDryRun) {
                        $previewData[] = [
                            'StudentNumber' => $studentNumber, 
                            'StudentClass' => $studentClass, 'StudentCode' => $studentCode,
                            'StudentPrefix' => $prefix, 'StudentFirstName' => $firstName, 'StudentLastName' => $lastName,
                            'StudentDateBirth' => $dateBirth, 'StudentIDNumber' => $idNumberRaw, 
                            'StudentStatus' => $status, 'StudentBehavior' => $behavior, 
                            'StudentStudyLine' => $studyLine, 'StudentDateEntrance' => $dateEntrance,
                            'Action' => 'ข้าม', 'Notes' => '<span class="text-danger">เลขประจำตัวประชาชนไม่ถูกต้อง</span>'
                        ];
                    }
                    continue; 
                }

                if (empty($studentCode) && empty($studentIdNumber)) { $skippedCount++; continue; }
                $identifierKey = $studentCode . '-' . $studentIdNumber;
                if (in_array($identifierKey, $processedIdentifiers)) { $skippedCount++; continue; }
                $processedIdentifiers[] = $identifierKey;

                $studentByCode = !empty($studentCode) ? $this->db->table('tb_students')->where('StudentCode', $studentCode)->get()->getRow() : null;
                $studentByIdNumber = !empty($studentIdNumber) ? $this->db->table('tb_students')->where('REPLACE(StudentIDNumber, "-", "")', $studentIdNumber)->get()->getRow() : null;
                
                $isConflict = ($studentByCode && $studentByIdNumber && $studentByCode->StudentID !== $studentByIdNumber->StudentID);
                
                if ($isConflict) {
                    $conflictCount++;
                    if ($isDryRun) {
                        $previewData[] = [
                            'StudentNumber' => $studentNumber, 
                            'StudentClass' => $studentClass, 'StudentCode' => $studentCode,
                            'StudentPrefix' => $prefix, 'StudentFirstName' => $firstName, 'StudentLastName' => $lastName,
                            'StudentDateBirth' => $dateBirth, 'StudentIDNumber' => $idNumberRaw, 
                            'StudentStatus' => $status, 'StudentBehavior' => $behavior, 
                            'StudentStudyLine' => $studyLine, 'StudentDateEntrance' => $dateEntrance,
                            'Action' => 'ขัดแย้ง', 'Notes' => '<span class="text-danger">ข้อมูลซ้ำซ้อน (เลขประจำตัวคู่กับนร. คนอื่น)</span>'
                        ];
                    }
                    continue;
                }

                $existingStudent = $studentByCode ?: $studentByIdNumber;
                
                if ($existingStudent && $syncMode === 'append') { 
                    $skippedCount++; 
                    if ($isDryRun) {
                        $previewData[] = [
                            'StudentNumber' => $studentNumber, 
                            'StudentClass' => $studentClass, 'StudentCode' => $studentCode,
                            'StudentPrefix' => $prefix, 'StudentFirstName' => $firstName, 'StudentLastName' => $lastName,
                            'StudentDateBirth' => $dateBirth, 'StudentIDNumber' => $idNumberRaw, 
                            'StudentStatus' => $status, 'StudentBehavior' => $behavior, 
                            'StudentStudyLine' => $studyLine, 'StudentDateEntrance' => $dateEntrance,
                            'Action' => 'ข้าม', 'Notes' => '<span class="text-muted">มีข้อมูลอยู่แล้ว (โหมดเพิ่มเท่านั้น)</span>'
                        ];
                    }
                    continue; 
                }

                $action = $existingStudent ? 'อัปเดต' : 'เพิ่มใหม่';
                $notes = '';
                
                if ($existingStudent && $existingStudent->StudentStatus === '1/ปกติ' && str_replace(['-', ' '], '', $existingStudent->StudentIDNumber) !== $studentIdNumber) {
                    $notes = '<span class="text-warning">อัปเดตข้อมูลนักเรียนปัจจุบัน</span>';
                }

                if ($isDryRun) {
                    $previewData[] = [
                        'StudentNumber' => $studentNumber, 
                        'StudentClass' => $studentClass, 'StudentCode' => $studentCode,
                        'StudentPrefix' => $prefix, 'StudentFirstName' => $firstName, 'StudentLastName' => $lastName,
                        'StudentDateBirth' => $dateBirth, 'StudentIDNumber' => $idNumberRaw, 
                        'StudentStatus' => $status, 'StudentBehavior' => $behavior, 
                        'StudentStudyLine' => $studyLine, 'StudentDateEntrance' => $dateEntrance,
                        'Action' => $action, 'Notes' => $notes
                    ];
                } else {
                    $data_main = [
                        'StudentNumber' => $studentNumber, 
                        'StudentClass' => $studentClass, 'StudentCode' => $studentCode,
                        'StudentPrefix' => $prefix, 'StudentFirstName' => $firstName, 'StudentLastName' => $lastName,
                        'StudentDateBirth' => $dateBirth, 'StudentIDNumber' => $idNumberRaw, 
                        'StudentStatus' => $status, 'StudentBehavior' => $behavior, 
                        'StudentStudyLine' => $studyLine, 'StudentDateEntrance' => $dateEntrance,
                        'StudentSex' => in_array($prefix, ['เด็กชาย', 'นาย']) ? 'ชาย' : 'หญิง'
                    ];
                    if ($existingStudent) $this->modAdminStudents->update($existingStudent->StudentID, $data_main);
                    else $this->modAdminStudents->insert($data_main);
                    
                    $data_p = ['stu_prefix'=>$prefix, 'stu_fristName'=>$firstName, 'stu_lastName'=>$lastName, 'stu_iden'=>$idNumberRaw];
                    $ex_p = $this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $studentIdNumber)->countAllResults();
                    if ($ex_p > 0) $this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $studentIdNumber)->update($data_p);
                    else $this->DBpersonnel->table('tb_students')->insert($data_p);
                }
                $successCount++;
            }
            if (!$isDryRun) $this->db->transComplete();
            
            $msg = ($isDryRun ? "<b>[PREVIEW]</b> " : "สำเร็จ! ") . "ผลลัพธ์: พบ {$successCount} รายการ | ขัดแย้ง {$conflictCount} | ผิดพลาด {$invalidIdCount} | ไม่ตรงกลุ่ม {$filteredOutCount} | ข้าม {$skippedCount}";
            
            $response = [
                'status' => 'success',
                'message' => $msg,
                'counts' => [
                    'success' => $successCount,
                    'conflict' => $conflictCount,
                    'invalid' => $invalidIdCount,
                    'filtered' => $filteredOutCount,
                    'skipped' => $skippedCount
                ]
            ];

            if ($isDryRun) {
                $response['preview'] = $previewData;
            }

            return $this->response->setJSON($response);
        } catch (\Exception $e) { 
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'API Error: ' . $e->getMessage()
            ]); 
        }
    }

    public function AdminStudentsAdd()
    {
        $data['title'] = "เพิ่มข้อมูลนักเรียนใหม่";
        $data['class_list'] = $this->classroom->ListRoom();
        $data['study_line_list'] = $this->classroom->studentStudyLineOptions();
        $data['student'] = null;
        $data['personnel_data_found'] = false;
        return view('admin/Academic/AdminStudents/AdminStudentsAdd', $data);
    }

    public function processStudentAdd()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $id_num = $this->request->getPost('StudentIDNumber');
        if (empty($id_num)) return $this->response->setJSON(['status' => 'error', 'message' => 'Missing ID.']);
        if ($this->modAdminStudents->where('StudentIDNumber', $id_num)->first()) return $this->response->setJSON(['status'=>'error','message'=>'Already exists.']);

        $birth_m = null; $birth_p = null; $ent_m = null;
        if ($b = $this->request->getPost('StudentDateBirth')) {
            $d = new \DateTime($b); $by = (int)$d->format('Y') + 543;
            $birth_m = $d->format("d/m/$by"); $birth_p = $d->format("d-m-$by");
        }
        if ($e = $this->request->getPost('StudentDateEntrance')) {
            $d = new \DateTime($e); $by = (int)$d->format('Y') + 543;
            $ent_m = $d->format("d/m/$by");
        }

        $data_m = [
            'StudentPrefix' => $this->request->getPost('StudentPrefix'),
            'StudentFirstName' => $this->request->getPost('StudentFirstName'),
            'StudentLastName' => $this->request->getPost('StudentLastName'),
            'StudentClass' => $this->request->getPost('StudentClass'),
            'StudentNumber' => $this->request->getPost('StudentNumber'),
            'StudentCode' => $this->request->getPost('StudentCode'),
            'StudentSex' => in_array($this->request->getPost('StudentPrefix'), ['เด็กชาย', 'นาย']) ? 'ชาย' : 'หญิง',
            'StudentStudyLine' => $this->request->getPost('StudentStudyLine'),
            'StudentStatus' => $this->request->getPost('StudentStatus') ?: '1/ปกติ',
            'StudentBehavior' => $this->request->getPost('StudentBehavior') ?: 'ปกติ',
            'StudentIDNumber' => $id_num, 'StudentDateBirth' => $birth_m, 'StudentDateEntrance' => $ent_m
        ];

        $this->db->transStart();
        $this->modAdminStudents->insert($data_m);
        $id_c = str_replace('-', '', $id_num);
        $data_p = ['stu_prefix'=>$data_m['StudentPrefix'], 'stu_fristName'=>$data_m['StudentFirstName'], 'stu_lastName'=>$data_m['StudentLastName'], 'stu_birthDay'=>$birth_p, 'stu_iden'=>$id_num];
        if ($this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $id_c)->countAllResults() > 0) {
            $this->DBpersonnel->table('tb_students')->where('REPLACE(stu_iden, "-", "")', $id_c)->update($data_p);
        } else {
            $this->DBpersonnel->table('tb_students')->insert($data_p);
        }
        $this->db->transComplete();
        return $this->response->setJSON(['status' => 'success', 'message' => 'Added.']);
    }

    public function checkDuplicate()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        
        $id_num_raw = $this->request->getPost('StudentIDNumber');
        $student_code = $this->request->getPost('StudentCode');
        
        $id_clean = str_replace('-', '', $id_num_raw);
        
        // 1. Check ID Number format
        if (!empty($id_clean)) {
            if (!$this->check_pid($id_clean)) {
                return $this->response->setJSON([
                    'status' => 'error_format',
                    'message' => 'เลขประจำตัวประชาชนไม่ถูกต้องตามหลักการคำนวณ (Checksum Error)'
                ]);
            }
            
            // 2. Check duplicate ID Number (Status 1/ปกติ)
            $dupe_id = $this->db->table('tb_students')
                ->where('REPLACE(StudentIDNumber, "-", "")', $id_clean)
                ->where('StudentStatus', '1/ปกติ')
                ->get()->getRow();
                
            if ($dupe_id) {
                return $this->response->setJSON([
                    'status' => 'duplicate',
                    'message' => 'พบเลขประจำตัวประชาชนซ้ำกับนักเรียนสถานะปกติในระบบ',
                    'student' => $dupe_id,
                    'field' => 'StudentIDNumber'
                ]);
            }
        }
        
        // 3. Check duplicate Student Code
        if (!empty($student_code)) {
            $dupe_code = $this->db->table('tb_students')
                ->where('StudentCode', $student_code)
                ->get()->getRow();
                
            if ($dupe_code) {
                return $this->response->setJSON([
                    'status' => 'duplicate',
                    'message' => 'พบเลขประจำตัวนักเรียนซ้ำในระบบ',
                    'student' => $dupe_code,
                    'field' => 'StudentCode'
                ]);
            }
        }
        
        return $this->response->setJSON(['status' => 'success']);
    }

    public function AdminStudentsEdit($student_id)
    {
        $student = $this->db->table('tb_students AS academic')
            ->select('academic.*, personnel.stu_prefix, personnel.stu_fristName, personnel.stu_lastName, personnel.stu_birthDay, personnel.stu_iden, personnel.stu_nickName, personnel.stu_phone, personnel.stu_email, personnel.stu_bloodType, personnel.stu_nationality, personnel.stu_race, personnel.stu_religion, personnel.stu_hNumber, personnel.stu_hTambon, personnel.stu_hDistrict, personnel.stu_hProvince, personnel.stu_hPostCode')
            ->join('skjacth_personnel.tb_students AS personnel', "REPLACE(personnel.stu_iden, '-', '') = academic.StudentIDNumber", 'left')
            ->where('academic.StudentID', $student_id)
            ->get()->getRow();

        if (!$student) {
            return redirect()->to(base_url('Admin/Acade/Registration/Students'))->with('status', 'error')->with('message', 'ไม่พบข้อมูลนักเรียน');
        }

        // แปลงวันที่ พ.ศ. (dd/mm/yyyy) เป็น ค.ศ. (yyyy-mm-dd) สำหรับ <input type="date">
        $student->StudentDateBirth = $this->convertToISODate($student->StudentDateBirth);
        $student->StudentDateEntrance = $this->convertToISODate($student->StudentDateEntrance);

        $data['title'] = "แก้ไขข้อมูลนักเรียน";
        $data['student'] = $student;
        $data['student_id'] = $student_id;
        $data['class_list'] = $this->classroom->ListRoom();
        $data['study_line_list'] = $this->classroom->studentStudyLineOptions();
        
        return view('admin/Academic/AdminStudents/AdminStudentsEdit', $data);
    }

    private function convertToISODate($beDate)
    {
        if (empty($beDate)) return '';
        // กรณีรูปแบบ dd/mm/yyyy
        $parts = explode('/', $beDate);
        if (count($parts) === 3) {
            $year = (int)$parts[2] - 543;
            return sprintf('%04d-%02d-%02d', $year, $parts[1], $parts[0]);
        }
        return $beDate;
    }
    public function AdminStudentsAdjustNumber()
    {
        $data['title'] = "จัดการเลขที่นักเรียนรายห้อง";
        $data['classroom'] = $this->classroom->ListRoom();
        $data['school_years'] = $this->db->table('tb_schoolyear')->orderBy('schyear_year','desc')->get()->getResult();
        return view('admin/Academic/AdminStudents/AdminStudentsAdjustNumber', $data);
    }

    public function getStudentsByClassForNumbering()
    {
        $class = $this->request->getPost('className'); 
        
        if (empty($class)) return $this->response->setJSON([]);
        
        $builder = $this->db->table('tb_students');
        $builder->where('StudentClass', $class);
        $builder->where('StudentStatus', '1/ปกติ');
        $builder->orderBy('StudentNumber', 'ASC');
        $builder->orderBy('StudentCode', 'ASC');
        
        $students = $builder->get()->getResult();
        return $this->response->setJSON($students);
    }

    public function updateStudentNumbers()
    {
        $numbers = $this->request->getPost('numbers'); // Array [student_id => number]
        if (empty($numbers)) return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่มีข้อมูลสำหรับอัปเดต']);
        
        $this->db->transStart();
        try {
            foreach ($numbers as $studentID => $newNumber) {
                $this->db->table('tb_students')
                    ->where('StudentID', $studentID)
                    ->update(['StudentNumber' => $newNumber]);
            }
            $this->db->transComplete();
            
            if ($this->db->transStatus() === false) {
                throw new \Exception("Database error during update.");
            }
            
            return $this->response->setJSON(['status' => 'success', 'message' => 'ปรับปรุงเลขที่นักเรียนเรียบร้อยแล้ว']);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดความผิดพลาด: ' . $e->getMessage()]);
        }
    }

    public function getGlobalSearchStudents()
    {
        $search = $this->request->getPost('search');
        if (empty($search)) return $this->response->setJSON([]);
        
        $builder = $this->db->table('tb_students');
        $builder->groupStart()
                ->like('StudentFirstName', $search)
                ->orLike('StudentLastName', $search)
                ->orLike('StudentCode', $search)
                ->groupEnd()
                ->limit(20);
        
        $students = $builder->get()->getResult();
        return $this->response->setJSON($students);
    }
}
