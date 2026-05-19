<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminSaveScore;
use App\Libraries\Classroom;


class ConAdminReportResult extends BaseController
{
    protected $modAdminSaveScore;
    protected $DBpersonnel;
    protected $DBSkj;
    protected $DBadmission;

    public function __construct()
    {
        $this->modAdminSaveScore = new ModAdminSaveScore();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->DBSkj = \Config\Database::connect('skj');
        $this->DBadmission = \Config\Database::connect('admission');
        $this->db = \Config\Database::connect(); // Initialize the default database connection
        $this->classroom = new Classroom();

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



    public function AdminReportPersonMain($Term = null, $Year = null){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "รายงานผลการเรียนรายบุคคล";

        // Read room filter from POST or GET query parameter
        $RoomFilter = $this->request->getPost('SelectRoom') ?? $this->request->getGet('room');

        // FIX: Always fetch SchoolYear for the layout
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();

        // Get available years for dropdown (Sorted NEWEST first)
        $data['CheckYearSaveScore'] = $this->db->table('tb_register')
            ->select('RegisterYear')
            ->groupBy('RegisterYear')
            ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC, SUBSTRING_INDEX(RegisterYear, "/", 1) DESC', '', false)
            ->get()->getResult();

        // Determine current year — ใช้ get_selected_year() เป็นหลัก
        if ($Term === null || $Year === null) {
            $selectedYearStr = get_selected_year(); // e.g. "1/2568"
            if (!empty($selectedYearStr) && strpos($selectedYearStr, '/') !== false) {
                $parts = explode('/', $selectedYearStr);
                $Term = $parts[0] ?? null;
                $Year = $parts[1] ?? null;
            } elseif ($data['SchoolYear'] && property_exists($data['SchoolYear'], 'schyear_year')) {
                // fallback
                $parts = explode('/', $data['SchoolYear']->schyear_year);
                $Term = $parts[0] ?? null;
                $Year = $parts[1] ?? null;
            }
        }

        $data['Term'] = $Term;
        $data['Year'] = $Year;
        $currentYear = ($Term && $Year) ? $Term . '/' . $Year : null;

        // Get available rooms for the selected year (RAW values from DB)
        if ($currentYear) {
            $roomsRaw = $this->db->table('tb_register')
                ->select('RegisterClass')
                ->where('RegisterYear', $currentYear)
                ->groupBy('RegisterClass')
                ->orderBy('RegisterClass', 'ASC')
                ->get()->getResult();
            
            $data['RoomList'] = [];
            foreach ($roomsRaw as $r) {
                if (!empty($r->RegisterClass)) {
                    $data['RoomList'][] = $r->RegisterClass; // Keep RAW value from DB
                }
            }
        } else {
            $data['RoomList'] = [];
        }

        $data['SelRoom'] = $RoomFilter;

        // Determine if we should show results (Strictly require Search button click)
        $data['hasResults'] = ($this->request->getGet('search') === 'true');

        // Get students for the selected year and room
        if ($currentYear && $data['hasResults']) {
            $builder = $this->db->table('tb_students')
                                ->select("tb_students.StudentID, tb_students.StudentNumber, tb_students.StudentClass, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_students.StudentStatus, tb_students.StudentIDNumber")
                                ->distinct()
                                ->join('tb_register', 'tb_register.StudentID = tb_students.StudentID')
                                ->where('tb_students.StudentStatus','1/ปกติ')
                                ->where('tb_register.RegisterYear', $currentYear);

            if ($RoomFilter !== null && $RoomFilter !== '') {
                // Use the EXACT RegisterClass value from the DB
                $builder->where('tb_register.RegisterClass', $RoomFilter);
            }

            $data['stu'] = $builder->get()->getResult();
        } else {
            $data['stu'] = []; 
        }

        echo view('admin/Academic/AdminReportResults/AdminReportPersonMain',$data);
    }

    public function AdminReportTeacherSaveScoreMain($Term = null, $year = null){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow(); // Fetch SchoolYear

        // ดึงรายการปีการศึกษาที่มีการบันทึกคะแนน เรียงจากล่าสุดก่อนเสมอ (แก้ไข SQL Syntax Error)
        $data['CheckYearSaveScore'] = $this->db->table('tb_register')
            ->select('RegisterYear')
            ->groupBy('RegisterYear')
            ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC, SUBSTRING_INDEX(RegisterYear, "/", 1) DESC')
            ->get()->getResult();

        if ($Term === null || $year === null) {
            if (!empty($data['CheckYearSaveScore'])) {
                // ถ้าไม่ได้ระบุปีมา ให้ใช้ปีล่าสุดที่มีข้อมูลใน tb_register เสมอ
                $latest = $data['CheckYearSaveScore'][0]->RegisterYear;
                $parts = explode('/', $latest);
                $Term = $parts[0] ?? '1';
                $year = $parts[1] ?? '2568';
            } else {
                // Fallback กรณีไม่มีข้อมูลเลย
                $selectedYearStr = get_selected_year();
                if (!empty($selectedYearStr) && strpos($selectedYearStr, '/') !== false) {
                    $parts = explode('/', $selectedYearStr);
                    $Term = $parts[0] ?? '1';
                    $year = $parts[1] ?? '2568';
                } else {
                    $Term = '1';
                    $year = '2568';
                }
            }
        }
            $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;       

        // กู้คืนระบบการดึงรายชื่อครูที่หายไป
        $teacherIdsWithScores = $this->db->table('tb_register')
            ->select('TeacherID')
            ->where('RegisterYear', $Term . '/' . $year)
            ->distinct()
            ->get()
            ->getResultArray();

        $teacherIds = array_column($teacherIdsWithScores, 'TeacherID');

        if (!empty($teacherIds)) {
            $data['Teacher'] = $this->DBpersonnel->table('tb_personnel')
                ->select('skjacth_personnel.tb_personnel.pers_prefix,
                          skjacth_personnel.tb_personnel.pers_firstname,
                          skjacth_personnel.tb_personnel.pers_lastname,
                          skjacth_personnel.tb_personnel.pers_id,
                          skjacth_personnel.tb_personnel.pers_learning,
                          skjacth_personnel.tb_personnel.pers_position,
                          skjacth_skj.tb_position.posi_name,
                          skjacth_skj.tb_learning.lear_namethai,
                          skjacth_personnel.tb_personnel.pers_status')
                ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position', 'left')
                ->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = skjacth_personnel.tb_personnel.pers_learning', 'left')
                ->whereIn('skjacth_personnel.tb_personnel.pers_id', $teacherIds)
                ->orderBy('skjacth_personnel.tb_personnel.pers_learning', 'ASC')
                ->get()
                ->getResult();
        } else {
            $data['Teacher'] = []; 
        }

        $data['title'] = "รายงานผลการบันทึกคะแนนครูผู้สอน";

        
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreMain',$data);
        
        
    }

    public function AdminReportTeacherSaveScoreCheck($Term,$year,$TeacID){  
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['Teacher'] = $this->DBpersonnel->table('tb_personnel')
        ->select('pers_prefix,pers_firstname,pers_lastname,pers_id')
        ->where('pers_id',$TeacID)
        ->get()->getRow();

        // Fetch available academic years for the filter dropdown
        $data['CheckYearSaveScore'] = $this->db->table('tb_register')
            ->select('RegisterYear')
            ->groupBy('RegisterYear')
            ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC, SUBSTRING_INDEX(RegisterYear, "/", 1) DESC')
            ->get()->getResult();

        $data['title'] = "รายงานผลการบันทึกคะแนนของ".( !empty($data['Teacher']) ? $data['Teacher']->pers_prefix.$data['Teacher']->pers_firstname.' '.$data['Teacher']->pers_lastname : '' ).' ปีการศึกษา '.$Term.'/'.$year; 

        $data['checkSubject'] = $this->db->table('tb_register')
        ->select('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode')
        ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
        ->where('TeacherID',$TeacID)
        ->where('RegisterYear',$Term.'/'.$year)
        ->groupBy('tb_subjects.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_register.SubjectID')
        ->get()->getResult();
        
        

        $data['CheckScore'] = $this->db->table('tb_register')
        ->select('tb_register.SubjectID,
                  tb_register.Score100,
                  tb_register.RegisterYear,
                  tb_register.RegisterClass,
                  tb_register.TeacherID,
                  tb_register.StudentID,
                  tb_students.StudentClass,
                  tb_students.StudentPrefix,
                  tb_students.StudentFirstName,
                  tb_students.StudentLastName,
                  tb_students.StudentCode,
                  tb_students.StudentNumber,
                  tb_students.StudentBehavior')
        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$year)
        ->where('tb_register.TeacherID',$TeacID)
        ->where('tb_students.StudentBehavior', 'ปกติ')
        ->orderBy('StudentClass','ASC')
        ->orderBy('StudentNumber','ASC')
        ->get()->getResult();
        
        //echo '<pre>'; print_r($data['CheckScore']); exit();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;
        $data['TeacID'] = $TeacID;
        
        
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreCheck',$data);
        

    }

    public function AdminReportRoomMain(){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $keyroom = $this->request->getPost("keyroom");
        $KeyCheckYear = $this->request->getPost("KeyCheckYear") ?? get_selected_year();

        // Optimized Year retrieval: latest first
        $data['CheckYear'] = $this->db->table('tb_register')
                                     ->select('RegisterYear')
                                     ->distinct()
                                     ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC', '', false)
                                     ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", 1) DESC', '', false)
                                     ->get()
                                     ->getResult();

        $SubRoom1 = explode('.',$keyroom);
        $SubRoom2 = explode('/',!empty($SubRoom1[1]) ? $SubRoom1[1] : '' );        
        $SubKeyCheckYear = explode('/',$KeyCheckYear);
        $Term = !empty($SubKeyCheckYear[0]) ? $SubKeyCheckYear[0] : null;
        $year = !empty($SubKeyCheckYear[1]) ? $SubKeyCheckYear[1] : null;
        $Class = !empty($SubRoom2[0]) ? $SubRoom2[0] : null;
        $Room = !empty($SubRoom2[1]) ? $SubRoom2[1] : null;
        if(empty($keyroom)){
            $data["Nodata"] = 0;
            $data['totip'] = "";
            $data['keyroom'] = '';
            $data['KeyCheckYear'] = $KeyCheckYear;
        }else{
            $data["Nodata"] = 1;
            $data['keyroom'] = $keyroom;
            $data['KeyCheckYear'] = $KeyCheckYear;
            $roomShort = !empty($SubRoom1[1]) ? $SubRoom1[1] : $keyroom;
            $data['keyroom_short'] = $roomShort;
            $data['totip'] = "ชั้น ม." . $roomShort . " ประจำปีการศึกษา " . $KeyCheckYear;
            
            $data['stu'] = $this->db->table('tb_register')
                                    ->select("tb_students.StudentID, tb_students.StudentNumber, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_register.RegisterClass")
                                    ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                                    ->where('tb_register.RegisterYear',$KeyCheckYear)
                                    ->where('tb_register.RegisterClass',$keyroom)
                                    ->where('StudentStatus','1/ปกติ')
                                    ->distinct()
                                    ->orderBy('tb_students.StudentNumber','ASC')
                                    ->get()->getResult();

            $data['subject'] = $this->db->table('tb_register')
                            ->select("tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit")
                            ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                            ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
                            ->where('tb_register.RegisterYear',$KeyCheckYear)
                            ->where('tb_register.RegisterClass',$keyroom)
                            ->where('StudentStatus','1/ปกติ')                                
                            ->where('tb_subjects.SubjectCode !=','I30301')
                            ->where('tb_subjects.SubjectCode !=','I20201')
                            ->groupBy('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit')  
                            ->orderBy('SubjectType',"ASC")  
                            ->orderBy('FirstGroup',"ASC")   
                            ->orderBy('SubjectCode',"ASC")                 
                            ->orderBy('SecondGroup',"ASC")
                            ->get()->getResult();

                            $CheckSub = [];

                            // 1. Get all student IDs for the main query
                            $studentIDs = array_column($data['stu'], 'StudentID');

                            // 2. Fetch all relevant register data in one go
                            $allGradesData = [];
                            if (!empty($studentIDs) && !empty($data['subject'])) {
                                $allGradesResult = $this->db->table('tb_register')
                                    ->select('tb_register.StudentID, tb_register.SubjectID, tb_register.Grade, tb_subjects.SubjectUnit')
                                    ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                                    ->where('tb_register.RegisterYear', $KeyCheckYear)
                                    ->whereIn('tb_register.StudentID', $studentIDs)
                                    ->get()
                                    ->getResult();

                                // Create a lookup map for grades and units
                                foreach ($allGradesResult as $gradeRow) {
                                    $allGradesData[$gradeRow->StudentID][$gradeRow->SubjectID] = [
                                        'grade' => $gradeRow->Grade,
                                        'unit' => $gradeRow->SubjectUnit
                                    ];
                                }
                            }

                            // 3. Process students and subjects using the lookup map
                            foreach ($data['stu'] as $key => $value) {
                                $studentTotalUnit = 0;
                                $studentTotalGradeValue = 0;

                                $studentRow = [];
                                $studentRow[] = $value->StudentID;
                                $studentRow[] = $value->StudentNumber;
                                $studentRow[] = $value->StudentPrefix.$value->StudentFirstName.' '.$value->StudentLastName;
                                $studentRow[] = $value->StudentCode;
                    
                                foreach ($data['subject'] as $key1 => $v_Check) {
                                    $currentSubjectUnit = floatval($v_Check->SubjectUnit);
                                    $grade = '';

                                    if (isset($allGradesData[$value->StudentID][$v_Check->SubjectID])) {
                                        $gradeData = $allGradesData[$value->StudentID][$v_Check->SubjectID];
                                        $grade = $gradeData['grade'];
                                        // Note: SubjectUnit is already in $v_Check, but we can also get it from $gradeData['unit'] if needed
                                    }
                                    
                                    $studentRow[] = $v_Check->SubjectID.'/'.$grade;

                                    // Accumulate for GPA calculation
                                    if (is_numeric($grade) && $grade >= 0) {
                                        $studentTotalUnit += $currentSubjectUnit;
                                        $studentTotalGradeValue += ($currentSubjectUnit * floatval($grade));
                                    }
                                }
                                
                                // Calculate GPA for the current student
                                $studentGPA = ($studentTotalUnit != 0) ? number_format(floor(($studentTotalGradeValue / $studentTotalUnit) * 100) / 100, 2, '.', '') : 0.00;
                                $studentRow[] = $studentGPA; // Add GPA to the student's data array
                                $CheckSub[] = $studentRow;
                            }
                    
                            $data['CheckSub'] = $CheckSub;

                           // echo '<pre>';print_r($CheckSub); exit();   
                                


        }
        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "รายงานผลการเรียนรายห้องเรียน";

        // Fetch available rooms for the school year if selected, otherwise fetch all unique rooms
        $roomBuilder = $this->db->table('tb_register')
                                ->select('RegisterClass')
                                ->distinct()
                                ->orderBy('RegisterClass', 'ASC');
        
        if (!empty($KeyCheckYear)) {
            $roomBuilder->where('RegisterYear', $KeyCheckYear);
        }
        
        $roomsRaw = $roomBuilder->get()->getResult();
        $dbRooms = array_column($roomsRaw, 'RegisterClass');

        // Combine with standard rooms from library to ensure 1/1, 1/2, etc. are always available
        $standardRooms = $this->classroom->ListRoom();
        $formattedStandard = array_map(function($r) { return "ม." . $r; }, $standardRooms);
        
        // Merge and clean up
        $allRooms = array_unique(array_merge($dbRooms, $formattedStandard));
        
        // Custom sort to handle "ม.1/1", "ม.10/1" correctly
        usort($allRooms, function($a, $b) {
            preg_match('/ม\.(\d+)\/(\d+)/', $a, $matchA);
            preg_match('/ม\.(\d+)\/(\d+)/', $b, $matchB);
            
            if (!empty($matchA) && !empty($matchB)) {
                if ($matchA[1] != $matchB[1]) return $matchA[1] - $matchB[1];
                return $matchA[2] - $matchB[2];
            }
            return strcmp($a, $b);
        });

        $data['room'] = $allRooms;

        
        echo view('admin/Academic/AdminReportResults/AdminReportRoomMain',$data);
        
        
    }

    public function exportRoomReportToExcel()
    {
        ob_start(); // Explicitly start output buffering

        $autoloadPath = SHARED_LIB_PATH . '/spreadsheet/vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            require $autoloadPath;
        } else {
            throw new \Exception("ไม่พบไฟล์ Autoload ของ Spreadsheet Library ในเส้นทาง: " . $autoloadPath);
        }
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Replicate data fetching logic from AdminReportRoomMain
        $keyroom = $this->request->getPost("keyroom");
        $SubRoom1 = explode('.',$keyroom);
        $SubRoom2 = explode('/',!empty($SubRoom1[1]) ? $SubRoom1[1] : '' );        
        $KeyCheckYear = $this->request->getPost("KeyCheckYear");
        $SubKeyCheckYear = explode('/',$KeyCheckYear);
        $Term = !empty($SubKeyCheckYear[0]) ? $SubKeyCheckYear[0] : null;
        $year = !empty($SubKeyCheckYear[1]) ? $SubKeyCheckYear[1] : null;
        $Class = !empty($SubRoom2[0]) ? $SubRoom2[0] : null;
        $Room = !empty($SubRoom2[1]) ? $SubRoom2[1] : null;

        if (empty($keyroom) || empty($KeyCheckYear)) {
            return redirect()->back()->with('error', 'กรุณาเลือกปีการศึกษาและห้องเรียนก่อน');
        }

        $data['stu'] = $this->db->table('tb_register')
                                ->select("tb_students.StudentID, tb_students.StudentNumber, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_register.RegisterClass")
                                ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                                ->where('tb_register.RegisterYear',$KeyCheckYear)
                                ->where('tb_register.RegisterClass',$keyroom)
                                ->where('StudentStatus','1/ปกติ')
                                ->distinct()
                                ->orderBy('tb_students.StudentNumber','ASC')
                                ->get()->getResult();

        $data['subject'] = $this->db->table('tb_register')
                        ->select("tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit")
                        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                        ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
                        ->where('tb_register.RegisterYear',$KeyCheckYear)
                        ->where('tb_register.RegisterClass',$keyroom)
                        ->where('StudentStatus','1/ปกติ')                                
                        ->where('tb_subjects.SubjectCode !=','I30301')
                        ->where('tb_subjects.SubjectCode !=','I20201')
                        ->groupBy('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit')  
                        ->orderBy('SubjectType',"ASC")  
                        ->orderBy('FirstGroup',"ASC")   
                        ->orderBy('SubjectCode',"ASC")                 
                        ->orderBy('SecondGroup',"ASC")
                        ->get()->getResult();

        $CheckSub = [];
        $studentIDs = array_column($data['stu'], 'StudentID');

        $allGradesData = [];
        if (!empty($studentIDs) && !empty($data['subject'])) {
            $allGradesResult = $this->db->table('tb_register')
                ->select('tb_register.StudentID, tb_register.SubjectID, tb_register.Grade, tb_subjects.SubjectUnit')
                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                ->where('tb_register.RegisterYear', $KeyCheckYear)
                ->whereIn('tb_register.StudentID', $studentIDs)
                ->get()
                ->getResult();

            foreach ($allGradesResult as $gradeRow) {
                $allGradesData[$gradeRow->StudentID][$gradeRow->SubjectID] = [
                    'grade' => $gradeRow->Grade,
                    'unit' => $gradeRow->SubjectUnit
                ];
            }
        }

        foreach ($data['stu'] as $key => $value) {
            $studentTotalUnit = 0;
            $studentTotalGradeValue = 0;

            $studentRow = [];
            $studentRow[] = $value->StudentNumber; 
            $studentRow[] = $value->StudentPrefix.$value->StudentFirstName.' '.$value->StudentLastName; 
            
            foreach ($data['subject'] as $key1 => $v_Check) {
                $currentSubjectUnit = floatval($v_Check->SubjectUnit);
                $grade = '';

                if (isset($allGradesData[$value->StudentID][$v_Check->SubjectID])) {
                    $gradeData = $allGradesData[$value->StudentID][$v_Check->SubjectID];
                    $grade = $gradeData['grade'];
                }
                
                $studentRow[] = $grade; 

                if (is_numeric($grade) && $grade >= 0) {
                    $studentTotalUnit += $currentSubjectUnit;
                    $studentTotalGradeValue += ($currentSubjectUnit * floatval($grade));
                }
            }
            
            $studentGPA = ($studentTotalUnit != 0) ? number_format(floor(($studentTotalGradeValue / $studentTotalUnit) * 100) / 100, 2, '.', '') : 0.00;
            $studentRow[] = $studentGPA; 
            $CheckSub[] = $studentRow;
        }

        // Set headers with shortened room and year for cleaner filename
        $roomShort = !empty($SubRoom1[1]) ? $SubRoom1[1] : $keyroom;
        $cleanRoom = str_replace(['/', '.'], '_', $roomShort);
        $cleanYear = str_replace('/', '_', $KeyCheckYear);
        $filename = 'รายงานผลการเรียนรายห้อง_' . $cleanRoom . '_' . $cleanYear . '.xlsx';
        ob_clean(); // Clean any previous output that might corrupt the Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Add headers to Excel sheet
        $headers = ['ลำดับที่', 'ชื่อ - นามสกุล'];
        foreach ($data['subject'] as $v_subject) {
            $headers[] = (isset($v_subject->SubjectCode) ? $v_subject->SubjectCode : '') . ' ' . (isset($v_subject->SubjectName) ? $v_subject->SubjectName : '');
        }
        $headers[] = 'GPA เกรดเฉลี่ย';
        $sheet->fromArray($headers, NULL, 'A1');

        // Add data rows to Excel sheet
        $sheet->fromArray($CheckSub, NULL, 'A2');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function AdminStudentsScore($IdStudent){      
        $data['title'] = "ผลการเรียนนักเรียนรายบุคคล";
        $data['ExtraSetting'] = $this->db->table('tb_extra_setting')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['scoreYear'] = $this->db->table('tb_register')
                                    ->select('tb_register.RegisterClass,
                                            tb_register.RegisterYear,
                                            tb_register.StudentID')
                                    ->where('StudentID',$IdStudent)
                                    ->groupBy('tb_register.RegisterYear, tb_register.RegisterClass, tb_register.StudentID')
                                    ->orderBy('tb_register.RegisterClass','asc')
                                    ->orderBy('tb_register.RegisterYear','asc')
                                    ->get()->getResult();
         //echo '<pre>';print_r($data['scoreYear']); exit();
        $data['scoreStudent'] = $this->db->table('tb_register')
                                        ->select('tb_register.StudentID,
                                                tb_register.SubjectID,
                                                tb_register.Score100,
                                                tb_register.Grade,
                                                tb_register.RegisterYear,
                                                tb_register.RegisterClass,
                                                tb_subjects.SubjectName,
                                                tb_subjects.SubjectCode,
                                                tb_subjects.SubjectUnit,
                                                tb_subjects.SubjectYear,
                                                tb_subjects.SubjectType,
                                                tb_subjects.FirstGroup')
                                    ->join('tb_subjects', 'tb_register.SubjectID = tb_subjects.SubjectID')
                                    ->where('StudentID',$IdStudent)
                                    ->where('tb_subjects.SubjectCode !=','I30301')
                                    ->where('tb_subjects.SubjectCode !=','I20201')
                                    ->orderBy('tb_subjects.SubjectType','asc')
                                    ->orderBy('tb_subjects.FirstGroup','asc')
                                    ->orderBy('tb_subjects.SubjectID','asc')
                                    ->get()->getResult();
        $data['stu'] =  $this->db->table('tb_students')
                            ->select('StudentID, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName')
                            ->where('StudentID',$IdStudent)->get()->getRow();
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        // Google Sheets API integration removed as requested.
        // $service = $this->getClient();
        // $spreadsheetId = '1eMgeASo3Vqxh8O0pERAJ0WO_9MLVx4wkuiJEFjquAfQ';
        
        // $range_checkChunum = 'ชุมนุม!A3:F1000';
        // $response_checkChunum = $service ? $service->spreadsheets_values->get($spreadsheetId, $range_checkChunum) : null;
        // $numRows_checkChunum = ($response_checkChunum && !empty($response_checkChunum->getValues())) ? count($response_checkChunum->getValues()) : 0;
       
        // $range_ruksun = 'ลูกเสือ!A3:F1000';
        // $response_ruksun = $service ? $service->spreadsheets_values->get($spreadsheetId, $range_ruksun) : null;
        // $numRows_ruksun = ($response_ruksun && !empty($response_ruksun->getValues())) ? count($response_ruksun->getValues()) : 0;
      
       $checkChunum = [];
    //    if ($response_checkChunum && !empty($response_checkChunum->values)) {
    //        foreach ($response_checkChunum->values as $key => $value) {
    //         $checkChunum[] = !empty($value[1]) ? $value[1] : null;
    //        }   
    //    }
       $data['checkChunum']  = $checkChunum;
     
       $checkRuksun = [];
    //    if ($response_ruksun && !empty($response_ruksun->values)) {
    //        foreach ($response_ruksun->values as $key => $value) {
    //         $checkRuksun[] = !empty($value[1]) ? $value[1] : null;
    //        }   
    //    }
       $data['checkRuksun']  = $checkRuksun;
       $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        
        echo view('admin/Academic/AdminReportResults/AdminReportStudentsResult',$data);
        
              
    }

    public function PrintTranscript($IdStudent, $Level = 'all')
    {
        $data['title'] = "ระเบียนแสดงผลการเรียน (ปพ.1)";
        
        $builderYear = $this->db->table('tb_register')
            ->select('tb_register.RegisterClass, tb_register.RegisterYear, tb_register.StudentID')
            ->where('StudentID', $IdStudent);

        $builderStudent = $this->db->table('tb_register')
            ->select('tb_register.StudentID, tb_register.SubjectID, tb_register.Score100, tb_register.Grade, tb_register.RegisterYear, tb_register.RegisterClass, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit, tb_subjects.SubjectYear, tb_subjects.SubjectType, tb_subjects.FirstGroup')
            ->join('tb_subjects', 'tb_register.SubjectID = tb_subjects.SubjectID')
            ->where('StudentID', $IdStudent)
            ->where('tb_subjects.SubjectCode !=', 'I30301')
            ->where('tb_subjects.SubjectCode !=', 'I20201');

        if ($Level == 'junior') {
            $builderYear->groupStart()
                ->like('tb_register.RegisterClass', '1', 'after')
                ->orLike('tb_register.RegisterClass', '2', 'after')
                ->orLike('tb_register.RegisterClass', '3', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.1', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.2', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.3', 'after')
                ->groupEnd();
            $builderStudent->groupStart()
                ->like('tb_register.RegisterClass', '1', 'after')
                ->orLike('tb_register.RegisterClass', '2', 'after')
                ->orLike('tb_register.RegisterClass', '3', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.1', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.2', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.3', 'after')
                ->groupEnd();
        } elseif ($Level == 'senior') {
            $builderYear->groupStart()
                ->like('tb_register.RegisterClass', '4', 'after')
                ->orLike('tb_register.RegisterClass', '5', 'after')
                ->orLike('tb_register.RegisterClass', '6', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.4', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.5', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.6', 'after')
                ->groupEnd();
            $builderStudent->groupStart()
                ->like('tb_register.RegisterClass', '4', 'after')
                ->orLike('tb_register.RegisterClass', '5', 'after')
                ->orLike('tb_register.RegisterClass', '6', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.4', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.5', 'after')
                ->orLike('tb_register.RegisterClass', 'ม.6', 'after')
                ->groupEnd();
        }

        $data['scoreYear'] = $builderYear->groupBy('tb_register.RegisterYear, tb_register.RegisterClass, tb_register.StudentID')
            ->orderBy('tb_register.RegisterClass', 'asc')
            ->orderBy('tb_register.RegisterYear', 'asc')
            ->get()->getResult();

        // ดึงข้อมูลนักเรียนแบบละเอียดรวมถึงข้อมูลจากฐานข้อมูลบุคลากร
        $stu = $this->db->table('tb_students AS academic')
            ->select('academic.*, personnel.*')
            ->join('skjacth_personnel.tb_students AS personnel', "REPLACE(personnel.stu_iden, '-', '') = academic.StudentIDNumber", 'left')
            ->where('academic.StudentID', $IdStudent)
            ->get()
            ->getRow();

        if (empty($stu)) {
            die("ไม่พบข้อมูลนักเรียน");
        }

        // ดึงข้อมูลโรงเรียน
        $school = $this->db->table('tb_school')->get()->getRow();

        // ดึงข้อมูลเกรดทั้งหมดเพื่อนำมาหยอดตารางและคำนวณ GPAX (ใช้ distinct ป้องกันข้อมูลซ้ำซ้อน)
        $data['scoreStudent'] = $builderStudent->distinct()
            ->select('tb_register.*, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectType, tb_subjects.SubjectUnit, tb_subjects.FirstGroup, tb_subjects.SubjectID')
            ->orderBy('tb_subjects.SubjectType', 'asc')
            ->orderBy('tb_subjects.FirstGroup', 'asc')
            ->orderBy('tb_subjects.SubjectID', 'asc')
            ->get()->getResult();

        // ดึงข้อมูลผู้ปกครอง (บิดา, มารดา, ผู้ปกครอง) - ใช้ stu_iden ที่มีขีดเพื่อความแม่นยำในการจอยกับ tb_parent
        $parent_data = ['father' => null, 'mother' => null, 'guardian' => null];
        if(!empty($stu->stu_iden)){
            $parents = $this->DBpersonnel->table('tb_parent')
                ->where('par_stuID', $stu->stu_iden)
                ->get()
                ->getResult();
            foreach ($parents as $p) {
                if ($p->par_relation == 'บิดา') $parent_data['father'] = $p;
                if ($p->par_relation == 'มารดา') $parent_data['mother'] = $p;
                if ($p->par_relation == 'ผู้ปกครอง') $parent_data['guardian'] = $p;
            }
        }
        $data['parent_data'] = $parent_data;
        $data['stu'] = $stu;

        // ใช้ TCPDF + FPDI (เสถียรกว่า mPDF ในการเทหน้า PDF 1.4)
        require_once SHARED_LIB_PATH . '/tcpdf/vendor/autoload.php';

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('SKJ System');
        $pdf->SetAuthor('SKJ');
        $pdf->SetTitle('ปพ.1 - ' . $data['stu']->StudentFirstName);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);

        // --- ตั้งค่าฟอนต์ TH Sarabun New (แปลงเสร็จแล้ว) ---
        $fontname = 'thsarabunnew';

        // พาธไฟล์ PDF template (เลือกตาม Level)
        $tpl_prefix = ($Level == 'senior') ? 'papor1_senior' : 'papor1_junior';
        
        $tpl_front = FCPATH . 'public/assets/img/transcript_templates/' . $tpl_prefix . '_front.pdf';
        $tpl_back  = FCPATH . 'public/assets/img/transcript_templates/' . $tpl_prefix . '_back.pdf';

        if (!file_exists($tpl_front)) {
            $tpl_front = FCPATH . 'assets/img/transcript_templates/' . $tpl_prefix . '_front.pdf';
            $tpl_back  = FCPATH . 'assets/img/transcript_templates/' . $tpl_prefix . '_back.pdf';
        }

        // หน้าที่ 1 (Front)
        $pdf->AddPage();
        $pdf->setSourceFile($tpl_front);
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0, 210, 297);

        $stu = $data['stu'];
        $pdf->SetFont($fontname, '', 14);

        // หยอดข้อมูลหน้า 1
        $pdf->Text(23, 26, $school->SchoolName ?? 'สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์'); 
        $pdf->SetFontSize(14);
        $pdf->Text(23, 31.5, $school->WorkPlace ?? 'สำนักงานเขตพื้นที่การศึกษามัธยมศึกษานครสวรรค์');
        $pdf->Text(23, 37, $school->District ?? '');
        $pdf->Text(23, 42.5, $school->Prefecture ?? '');
        $pdf->Text(23, 48, $school->Province ?? '');
        $pdf->Text(42, 54, $school->Division ?? '');

        $pdf->SetFontSize(14);
        $pdf->Text(110, 37, $stu->StudentPrefix.$stu->StudentFirstName);
        $pdf->Text(110, 42.5, $stu->StudentLastName);
        $pdf->Text(130, 48, $stu->StudentCode);
        $pdf->SetFont($fontname, '', 14);
        $pdf->Text(130, 54, $stu->StudentIDNumber ?? '-');

        $months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        // วันที่เข้าเรียน (แปลงเป็นไทย)
        if(!empty($stu->StudentDateEntrance)){
            $parts = explode('/', $stu->StudentDateEntrance);
            if(count($parts) == 3){
                $d_entrance = (int)$parts[0]."  ".$months[(int)$parts[1]]."  ".$parts[2];
                $pdf->Text(50.0, 72.5, $d_entrance);
            }
        }
        
        // โรงเรียนเดิม และชั้นเรียนสุดท้าย
        $pdf->SetFontSize(14);
       
        $pdf->Text(23, 65, $stu->stu_schoolfrom ?? '-');
        $pdf->Text(23, 70.3, $stu->stu_schoolProvince ?? '-');
        // ชั้นเรียนสุดท้าย
         $last_class = ($Level == 'senior') ? 'มัธยมศึกษาปีที่ 3' : 'ประถมศึกษาปีที่ 6';
        $pdf->Text(28, 76.5, $last_class);

        // วันเกิด (แปลงเป็นไทย แยกส่วน วัน เดือน ปี)
        if(!empty($stu->StudentDateBirth)){
            $time = strtotime($stu->StudentDateBirth);
            $b_day   = date('j', $time);
            $b_month = $months[date('n', $time)];
            $b_year  = date('Y', $time) + 543;

            $pdf->Text(108, 59.5, $b_day);   // วัน
            $pdf->Text(138, 59.5, $b_month); // เดือน
            $pdf->Text(175, 59.5, $b_year);  // ปี
        }

        // หยอดข้อมูลเพิ่มเติม: เพศ (เช็คจากคำนำหน้า), เชื้อชาติ, สัญชาติ, ศาสนา
        $pdf->SetFontSize(14);
        // เพศ (เช็คจากคำนำหน้า)
        $malePrefixes = ['นาย', 'ด.ช.', 'เด็กชาย'];
        if(in_array($stu->StudentPrefix, $malePrefixes)){
            $pdf->Text(103, 65, 'ชาย'); // ชาย
        } else {
            $pdf->Text(103, 65, 'หญิง'); // หญิง
        }
        
        // สัญชาติ ศาสนา (แยกพิกัดให้ตรงช่อง)
        $pdf->Text(135, 65, $stu->stu_nationality ?? '-'); // สัญชาติ
        $pdf->Text(180, 65, $stu->stu_religion ?? '-');    // ศาสนา

        // ชื่อ-นามสกุล บิดา มารดา ผู้ปกครอง
        if($parent_data['father']){
            $father_name = $parent_data['father']->par_prefix.$parent_data['father']->par_firstName.' '.$parent_data['father']->par_lastName;
            $pdf->Text(120, 70.3, $father_name);
        }
        if($parent_data['mother']){
            $mother_name = $parent_data['mother']->par_prefix.$parent_data['mother']->par_firstName.' '.$parent_data['mother']->par_lastName;
            $pdf->Text(120, 76, $mother_name);
        }

        

        // 5. ตารางเกรด (หยอดข้อมูล 3 คอลัมน์ละ 1 ปีการศึกษา)
        $columns_results = []; // เก็บข้อมูลแยกตามคอลัมน์
        
        $classes = [];
        foreach ($data['scoreStudent'] as $s) {
            // ดึงเฉพาะตัวเลขระดับชั้นออกมา เพื่อจัดกลุ่ม (เช่น ม.1/1 -> 1, ม.2/5 -> 2)
            // ใช้ (int) เพื่อให้ 01 และ 1 จัดอยู่ในกลุ่มเดียวกัน
            preg_match('/\d+/', $s->RegisterClass, $matches);
            $level = isset($matches[0]) ? (int)$matches[0] : trim($s->RegisterClass);
            
            if ($level !== '') {
                $classes[$level][] = $s;
            }
        }
        ksort($classes);
        
        foreach ($classes as $class_lv => $subs) {
            $column_items = [];
            
            // หาปีการศึกษา (BE)
            $years_in_class = [];
            foreach ($subs as $s) {
                $parts = explode('/', $s->RegisterYear);
                $year = end($parts);
                $years_in_class[$year] = $year;
            }
            ksort($years_in_class);
            $main_year = implode('-', $years_in_class);

            // แยกเทอม 1 และ เทอม 2
            for ($term = 1; $term <= 2; $term++) {
                // กรองรายวิชาในเทอมนี้
                $term_subs = array_filter($subs, function($s) use ($term) {
                    return strpos(trim($s->RegisterYear), $term.'/') === 0;
                });

                if (empty($term_subs)) continue; // ถ้าไม่มีวิชาในเทอมนี้ ไม่ต้องเพิ่ม Header

                // Header ภาคเรียน (Simplified format: ภาคเรียนที่ X/YYYY)
                $column_items[] = ['t' => 'h', 'val' => "ภาคเรียนที่ $term/$main_year"];

                // เรียง: พื้นฐานก่อน แล้วค่อยเพิ่มเติม
                usort($term_subs, function($a, $b) {
                    $a_is_base = strpos($a->SubjectType, 'พื้นฐาน') !== false;
                    $b_is_base = strpos($b->SubjectType, 'พื้นฐาน') !== false;
                    if ($a_is_base === $b_is_base) return 0;
                    return $a_is_base ? -1 : 1;
                });

                foreach ($term_subs as $s) {
                    $column_items[] = ['t' => 's', 'd' => $s];
                }

                // สรุปเทอม (ถ้ามีข้อมูล)
                if (count($term_subs) > 0) {
                     // $column_items[] = ['t' => 'sum', 'val' => '--- term summary if needed ---'];
                }
            }

            // --- คำนวณ Scale อัตโนมัติ ---
            $total_lines = count($column_items);
            $max_lines = 36; // ขยายจาก 35 เป็น 36 เพื่อความยืดหยุ่น
            $standard_lh = 4.85; 
            $standard_fs = 11.0; 

            $current_lh = $standard_lh;
            $current_fs = $standard_fs;

            if ($total_lines > $max_lines) {
                $scale = $max_lines / $total_lines;
                $current_lh = $standard_lh * $scale;
                $current_fs = max($standard_fs * $scale, 8.5); // เล็กสุดไม่เกิน 8.5pt
            }

            $columns_results[] = [
                'items'   => $column_items,
                'line_h'  => $current_lh,
                'font_sz' => $current_fs
            ];
        }

        $y_box_start = 114.2; // ปรับพิกัด Y เริ่มต้นให้ตรงบรรทัดแรกของเทมเพลต
        $col_x = [7.2, 73.2, 139.3]; // พิกัด X เริ่มต้นของ 3 ปีการศึกษา
        
        // --- ส่วนการตั้งค่าตำแหน่งคงที่แยกคอลัมน์ (Individually Tuned Offsets) ---
        // คุณครูสามารถปรับตัวเลขในอาเรย์ [ปี1, ปี2, ปี3] เพื่อขยับทีละคอลัมน์ได้เลยครับ
        $off_unit  = [43, 45, 45]; // ระยะเริ่มช่องหน่วยกิต (วัดจากขอบซ้ายของแต่ละคอลัมน์)
        $off_grade = [51, 54, 54]; // ระยะเริ่มช่องเกรด (วัดจากขอบซ้ายของแต่ละคอลัมน์)
        
        $w_name  = 41.5; // ความกว้างช่องชื่อวิชา
        $w_unit  = 10.5; // ความกว้างช่องหน่วยกิต
        $w_grade = 13.5; // ความกว้างช่องเกรด

        foreach ($columns_results as $c_idx => $col_cfg) {
            if ($c_idx > 2) break;
            
            $start_x = $col_x[$c_idx];
            $lh = $col_cfg['line_h'];
            $fs = $col_cfg['font_sz'];
            
            // ดึงค่า Offset เฉพาะของคอลัมน์นี้มาใช้
            $u_x = $start_x + $off_unit[$c_idx];
            $g_x = $start_x + $off_grade[$c_idx];
            
            foreach ($col_cfg['items'] as $i_idx => $item) {
                $curr_y = $y_box_start + ($i_idx * $lh);
                
                if ($item['t'] == 's') { // รายวิชา
                    // 1. ชื่อวิชา
                    $pdf->SetFont($fontname, '', $fs);
                    $pdf->SetXY($start_x, $curr_y - 0.4);
                    $pdf->Cell($w_name, $lh, $item['d']->SubjectCode.' '.$item['d']->SubjectName, 0, 0, 'L', 0, '', 1);
                    
                    // 2. หน่วยกิต (ใช้ X ที่คำนวณแยกคอลัมน์)
                    $pdf->SetFont($fontname, '', $fs);
                    $pdf->SetXY($u_x, $curr_y - 0.4);
                    $pdf->Cell($w_unit, $lh, number_format(floatval($item['d']->SubjectUnit), 1), 0, 0, 'C');
                    
                    // 3. ผลการเรียน (ใช้ X ที่คำนวณแยกคอลัมน์)
                    $pdf->SetXY($g_x, $curr_y - 0.4);
                    $pdf->Cell($w_grade, $lh, $item['d']->Grade, 0, 0, 'C');
                } elseif ($item['t'] == 'h') { // Header ภาคเรียน
                    $pdf->SetFont($fontname, 'B', $fs + 0.5);
                    $pdf->SetXY($start_x, $curr_y);
                    $pdf->Cell($w_name, $lh, $item['val'], 0, 0, 'L');
                }
            }
        }

         // นายทะเบียน
        $pdf->SetFontSize(13);
        $pdf->SetXY(133, 278.5);
        $regis_name = ($school->RegisName ?? '-');
        $pdf->MultiCell(80, 5,$regis_name , 0, 'C');



        // --- หน้าที่ 2 (Back) ---
        $pdf->AddPage();
        $pdf->setSourceFile($tpl_back);
        $tplId2 = $pdf->importPage(1);
        $pdf->useTemplate($tplId2, 0, 0, 210, 297);

        // เตรียมตัวแปรสำหรับสรุปผลการเรียนแยกสาระ (หน้า 2)
        $learning_areas = [
            'ภาษาไทย' => ['c' => 0, 'gp' => 0],
            'คณิตศาสตร์' => ['c' => 0, 'gp' => 0],
            'วิทยาศาสตร์และเทคโนโลยี' => ['c' => 0, 'gp' => 0],
            'สังคมศึกษา ศาสนาและวัฒนธรรม' => ['c' => 0, 'gp' => 0],
            'สุขศึกษาและพลศึกษา' => ['c' => 0, 'gp' => 0],
            'ศิลปะ' => ['c' => 0, 'gp' => 0],
            'การงานอาชีพ' => ['c' => 0, 'gp' => 0],
            'ภาษาต่างประเทศ' => ['c' => 0, 'gp' => 0],
            'การศึกษาค้นคว้าด้วยตนเอง (IS)' => ['c' => 0, 'gp' => 0]
        ];

        // คำนวณสรุปหน่วยกิตและ GPAX (รวมและแยกสาระ)
        $sum_credits = 0;
        $sum_grade_points = 0;
        foreach($data['scoreStudent'] as $s){
            if($s->Grade !== 'ร' && $s->Grade !== 'มส' && $s->Grade !== 'มผ' && is_numeric($s->Grade)){
                $u = floatval($s->SubjectUnit);
                $g = floatval($s->Grade);
                $gp = $u * $g;
                
                $sum_credits += $u;
                $sum_grade_points += $gp;

                // แยกเข้ากลุ่มสาระ
                if(strpos($s->SubjectName, 'การศึกษาค้นคว้าด้วยตนเอง') !== false || strpos($s->SubjectCode, 'IS') === 0){
                    $learning_areas['การศึกษาค้นคว้าด้วยตนเอง (IS)']['c'] += $u;
                    $learning_areas['การศึกษาค้นคว้าด้วยตนเอง (IS)']['gp'] += $gp;
                } else {
                    foreach($learning_areas as $key => $val){
                        if($key == 'การศึกษาค้นคว้าด้วยตนเอง (IS)') continue;
                        // จับคู่กลุ่มสาระ (ใช้คำค้นหาแบบยืดหยุ่น)
                        $match_key = str_replace(['และเทคโนโลยี', ' ศาสนาและวัฒนธรรม', 'และพลศึกษา'], '', $key);
                        if(strpos($s->FirstGroup, $match_key) !== false){
                            $learning_areas[$key]['c'] += $u;
                            $learning_areas[$key]['gp'] += $gp;
                            break;
                        }
                    }
                }
            }
        }
        $gpax = $sum_credits > 0 ? number_format(floor(($sum_grade_points / $sum_credits) * 100) / 100, 2, '.', '') : '0.00';

        // วางคะแนนแยกกลุ่มสาระ (หน้า 2)
        $pdf->SetFont($fontname, '', 12);
        $area_y = 128.5; // พิกัด Y เริ่มต้นของกลุ่มสาระ
        foreach($learning_areas as $area_name => $area_val){
            if ($area_name == 'การศึกษาค้นคว้าด้วยตนเอง (IS)' && $area_val['c'] == 0) {
                $credits_display = '-';
                $area_avg = '-';
            } else {
                $credits_display = number_format($area_val['c'], 1);
                $area_avg = $area_val['c'] > 0 ? number_format(floor(($area_val['gp'] / $area_val['c']) * 100) / 100, 2, '.', '') : '0.00';
            }
            
            $pdf->Text(187, $area_y, $credits_display); // หน่วยกิตสะสม
            $pdf->Text(197, $area_y, $area_avg);        // ผลการเรียนเฉลี่ย
            $area_y += 4.7; 
        }

        // วางสรุปรวม (รวมทุกรายวิชา)
        $pdf->SetFont($fontname, 'B', 12);
        $pdf->Text(187, 174, number_format($sum_credits, 1)); 
        $pdf->Text(197, 174, $gpax);

        $pdf->SetFont($fontname, '', 14);
        
        // นายทะเบียน
        $pdf->SetXY(133, 195);
        $regis_name = ($school->RegisName ?? '-');
        $pdf->MultiCell(80, 5,$regis_name , 0, 'C');

        // ผู้อำนวยการ
        $director_name = ($school->DirectorName ?? '-');
        $school_name   = ($school->SchoolName ?? 'โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์');
        
        $pdf->SetFont($fontname, '', 14);
        $pdf->SetXY(130, 222);
        $pdf->Cell(80, 5, "(" . $director_name . ")", 0, 1, 'C');
        $pdf->SetX(130);
        $pdf->Cell(80, 5, "ผู้อำนวยการสถานศึกษา", 0, 1, 'C');
        
        $pdf->SetFontSize(11.5); // ปรับขนาดชื่อโรงเรียนให้เล็กลง
        $pdf->SetX(130);
        $pdf->Cell(80, 5, $school_name, 0, 1, 'C');

        // บรรทัดที่ 4 วันที่พิมพ์
        $pdf->SetFontSize(13);
        $pdf->SetX(130);
        $print_date = date('j') . ' ' . $months[date('n')] . ' ' . (date('Y') + 543);
        $pdf->Cell(80, 5, $print_date, 0, 1, 'C');

        $fileName = "ปพ1_" . $stu->StudentCode . ".pdf";
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output($fileName, 'I'); 
        exit;
    }

    public function AdminReportSummaryTeacher(){
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "รายงานสรุปผลสัมฤทธิ์ทางการเรียน";
        $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
        $data['lern'] = $this->DBSkj->table('tb_learning')->get()->getResult();

        $data['Keylern'] = $this->request->getGet('SelLern');
        $data['KeyYear'] = urldecode($this->request->getGet('KeyYear'));
       // echo  $data['KeyYear']; exit();      
       
        $data['Showdata'] = $this->db->table('skjacth_academic.tb_register')
                            ->select('
                                COUNT(CASE WHEN tb_register.Grade = 4 then 1 else null end) AS G4_0,
                                COUNT(CASE WHEN tb_register.Grade = 3.5 then 1 else null end) AS G3_5,
                                COUNT(CASE WHEN tb_register.Grade = 3 then 1 else null end) AS G3_0,
                                COUNT(CASE WHEN tb_register.Grade = 2.5 then 1 else null end) AS G2_5,
                                COUNT(CASE WHEN tb_register.Grade = 2 then 1 else null end) AS G2_0,
                                COUNT(CASE WHEN tb_register.Grade = 1.5 then 1 else null end) AS G1_5,
                                COUNT(CASE WHEN tb_register.Grade = 1 then 1 else null end) AS G1_0,
                                COUNT(CASE WHEN tb_register.Grade = "0" then 1 else null end) AS G0,
                                COUNT(CASE WHEN tb_register.Grade = "ร" then 1 else null end) AS G_W,
                                COUNT(CASE WHEN tb_register.Grade = "มส" then 1 else null end) AS G_MS,
                                COUNT(skjacth_academic.tb_students.StudentClass) AS SumStu,
                                skjacth_academic.tb_students.StudentClass,
                                skjacth_academic.tb_students.StudentBehavior,
                                skjacth_academic.tb_register.RegisterYear,
                                skjacth_academic.tb_register.TeacherID,
                                skjacth_academic.tb_register.Grade,
                                skjacth_academic.tb_register.SubjectID,
                                skjacth_personnel.tb_personnel.pers_prefix,
                                skjacth_personnel.tb_personnel.pers_firstname,
                                skjacth_personnel.tb_personnel.pers_lastname,
                                skjacth_personnel.tb_personnel.pers_learning,
                                skjacth_academic.tb_subjects.SubjectName,
                                skjacth_academic.tb_subjects.SubjectCode,
                                skjacth_academic.tb_subjects.SubjectType,
                                skjacth_academic.tb_subjects.SubjectUnit,
                                skjacth_academic.tb_subjects.SubjectYear                                                   
                                ')
                            ->join('skjacth_academic.tb_students','skjacth_academic.tb_students.StudentID = skjacth_academic.tb_register.StudentID')
                            ->join('skjacth_personnel.tb_personnel','skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID')
                            ->join('skjacth_academic.tb_subjects','skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID')
                            ->where('tb_register.RegisterYear',$data['KeyYear'])
                            ->where('tb_subjects.SubjectYear',$data['KeyYear'])
                            ->where('tb_personnel.pers_learning',$data['Keylern'])
                            ->where('StudentBehavior','ปกติ')
                            ->groupBy('tb_students.StudentClass, tb_register.SubjectID, tb_register.RegisterYear, tb_register.TeacherID, tb_register.Grade, tb_students.StudentBehavior, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_personnel.pers_learning, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectType, tb_subjects.SubjectUnit, tb_subjects.SubjectYear')
                            ->orderBy('TeacherID,SubjectID,StudentClass')
                            ->get()->getResult();        

        
                echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummary',$data);
        
        
            }
        
    public function AdminReportAcademicSummary() {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "รายงานสรุปผลสัมฤทธิ์ทางการเรียน";
        $data['CheckYear'] = $this->db->table('tb_register')
                                     ->select('RegisterYear')
                                     ->distinct()
                                     ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC', '', false)
                                     ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", 1) DESC', '', false)
                                     ->get()
                                     ->getResult();
        $data['lern'] = $this->DBSkj->table('tb_learning')->get()->getResult();

        $data['Keylern'] = $this->request->getGet('SelLern');
        $data['KeyYear'] = urldecode($this->request->getGet('KeyYear') ?? '');

        $builder = $this->db->table('skjacth_academic.tb_register');
        $builder->select('
            COUNT(CASE WHEN tb_register.Grade = "4" THEN 1 END) AS G4_0,
            COUNT(CASE WHEN tb_register.Grade = "3.5" THEN 1 END) AS G3_5,
            COUNT(CASE WHEN tb_register.Grade = "3" THEN 1 END) AS G3_0,
            COUNT(CASE WHEN tb_register.Grade = "2.5" THEN 1 END) AS G2_5,
            COUNT(CASE WHEN tb_register.Grade = "2" THEN 1 END) AS G2_0,
            COUNT(CASE WHEN tb_register.Grade = "1.5" THEN 1 END) AS G1_5,
            COUNT(CASE WHEN tb_register.Grade = "1" THEN 1 END) AS G1_0,
            COUNT(CASE WHEN tb_register.Grade = "0" THEN 1 END) AS G0,
            COUNT(CASE WHEN tb_register.Grade = "ร" THEN 1 END) AS G_W,
            COUNT(CASE WHEN tb_register.Grade = "มส" THEN 1 END) AS G_MS,
            COUNT(skjacth_academic.tb_register.StudentID) AS SumStu,
            COUNT(CASE WHEN tb_register.Grade IN ("0","1","1.5","2","2.5","3","3.5","4") THEN 1 END) AS TotalNumeric,
            AVG(CASE WHEN tb_register.Grade IN ("0","1","1.5","2","2.5","3","3.5","4") THEN CAST(tb_register.Grade AS DECIMAL(3,2)) END) AS MeanGrade,
            STDDEV_POP(CASE WHEN tb_register.Grade IN ("0","1","1.5","2","2.5","3","3.5","4") THEN CAST(tb_register.Grade AS DECIMAL(3,2)) END) AS SDGrade,
            
            skjacth_academic.tb_register.RegisterClass AS StudentClass,
            skjacth_academic.tb_register.RegisterYear,
            skjacth_academic.tb_register.TeacherID,
            skjacth_academic.tb_register.SubjectID,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_personnel.tb_personnel.pers_learning,
            skjacth_academic.tb_subjects.SubjectName,
            skjacth_academic.tb_subjects.SubjectCode,
            skjacth_academic.tb_subjects.SubjectType,
            skjacth_academic.tb_subjects.SubjectUnit,
            skjacth_academic.tb_subjects.SubjectYear
        ');
        $builder->join('skjacth_academic.tb_students', 'skjacth_academic.tb_students.StudentID = skjacth_academic.tb_register.StudentID');
        $builder->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID');
        $builder->join('skjacth_academic.tb_subjects', 'skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID');
        
        $builder->where('tb_register.RegisterYear', $data['KeyYear']);
        $builder->where('tb_subjects.SubjectYear', $data['KeyYear']);
        
        if ($data['Keylern'] && $data['Keylern'] != '0') {
            $builder->where('tb_personnel.pers_learning', $data['Keylern']);
        }
        
        $builder->where('skjacth_academic.tb_students.StudentBehavior', 'ปกติ');
        
        $builder->groupBy('skjacth_academic.tb_register.RegisterClass, skjacth_academic.tb_register.SubjectID, skjacth_academic.tb_register.RegisterYear, skjacth_academic.tb_register.TeacherID, skjacth_personnel.tb_personnel.pers_prefix, skjacth_personnel.tb_personnel.pers_firstname, skjacth_personnel.tb_personnel.pers_lastname, skjacth_personnel.tb_personnel.pers_learning, skjacth_academic.tb_subjects.SubjectName, skjacth_academic.tb_subjects.SubjectCode, skjacth_academic.tb_subjects.SubjectType, skjacth_academic.tb_subjects.SubjectUnit, skjacth_academic.tb_subjects.SubjectYear');
        $builder->orderBy('TeacherID, SubjectID, StudentClass');
        
        $data['Showdata'] = $builder->get()->getResult();

        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummary', $data);
    }
        
    public function AdminReportAcademicSummaryRoyalRoseStandard()
    {
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['title'] = "รายงานสรุปผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง";
        $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC, SUBSTRING_INDEX(RegisterYear, "/", 1) DESC', '', false)->get()->getResult();
        $data['lern'] = $this->DBSkj->table('tb_learning')->get()->getResult();

        $data['KeyLevel'] = $this->request->getGet('SelLevel') ?? '0';
        $data['KeyYear'] = urldecode($this->request->getGet('KeyYear') ?? '0');

        $data['SubjectsList'] = [];
        if (!empty($data['KeyLevel']) && !empty($data['KeyYear']) && $data['KeyLevel'] !== '0' && $data['KeyYear'] !== '0') {
            $data['SubjectsList'] = $this->db->table('tb_register')
                ->select('tb_subjects.SubjectID, tb_subjects.SubjectCode, tb_subjects.SubjectName, tb_subjects.FirstGroup, tb_subjects.SubjectType')
                ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
                ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
                ->where('tb_register.RegisterYear', $data['KeyYear'])
                ->like('tb_subjects.SubjectType', 'พื้นฐาน')
                ->like('tb_students.StudentClass', $data['KeyLevel'] . '%')
                ->groupBy('tb_subjects.SubjectID, tb_subjects.SubjectCode, tb_subjects.SubjectName, tb_subjects.FirstGroup, tb_subjects.SubjectType')
                ->orderBy('tb_subjects.FirstGroup', 'ASC')
                ->orderBy('tb_subjects.SubjectCode', 'ASC')
                ->get()->getResult();
        }

        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummaryRoyalRoseStandard', $data);
    }

    public function AdminReportRoyalRoseResult()
    {
        $data['title'] = "ผลการคำนวณมาตรฐานกุหลาบหลวง";
        $data['KeyLevel'] = $this->request->getPost('SelLevel');
        $data['KeyYear'] = $this->request->getPost('KeyYear');
        $data['selected_subjects'] = $this->request->getPost('selected_subjects');

        if (empty($data['selected_subjects'])) {
            return redirect()->back()->with('error', 'กรุณาเลือกวิชาอย่างน้อย 1 วิชา');
        }

        $data['Showdata'] = $this->db->table('tb_register')
            ->select('
                tb_subjects.FirstGroup,
                tb_register.RegisterYear,
                SUM(CASE WHEN tb_register.Grade = "4" THEN 1 ELSE 0 END) AS G4_0,
                SUM(CASE WHEN tb_register.Grade = "3.5" THEN 1 ELSE 0 END) AS G3_5,
                SUM(CASE WHEN tb_register.Grade = "3" THEN 1 ELSE 0 END) AS G3_0,
                SUM(CASE WHEN tb_register.Grade = "2.5" THEN 1 ELSE 0 END) AS G2_5,
                SUM(CASE WHEN tb_register.Grade = "2" THEN 1 ELSE 0 END) AS G2_0,
                SUM(CASE WHEN tb_register.Grade = "1.5" THEN 1 ELSE 0 END) AS G1_5,
                SUM(CASE WHEN tb_register.Grade = "1" THEN 1 ELSE 0 END) AS G1_0,
                SUM(CASE WHEN tb_register.Grade IN ("0", "มส", "ร") THEN 1 ELSE 0 END) AS G0,
                COUNT(tb_register.StudentID) AS TotalStu
            ')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->where('tb_register.RegisterYear', $data['KeyYear'])
            ->whereIn('tb_subjects.SubjectID', $data['selected_subjects'])
            ->where('tb_students.StudentStatus', '1/ปกติ')
            ->like('tb_students.StudentClass', $data['KeyLevel'] . '%')
            ->groupBy('tb_subjects.FirstGroup, tb_register.RegisterYear')
            ->orderBy('tb_subjects.FirstGroup', 'ASC')
            ->get()->getResult();

        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummaryRoyalRoseStandardResult', $data);
    }

    public function exportRoyalRoseToExcel()
    {
        $selectedSubjectIds = $this->request->getPost('selected_subjects');
        $KeyYear = $this->request->getPost('KeyYear');
        $KeyLevel = $this->request->getPost('SelLevel');

        if (empty($selectedSubjectIds)) {
            return redirect()->back()->with('error', 'กรุณากลับไปเลือกรายวิชาก่อน');
        }

        $query = $this->db->table('tb_register')
            ->select('
                tb_subjects.FirstGroup,
                tb_register.RegisterYear,
                SUM(CASE WHEN tb_register.Grade = "4" THEN 1 ELSE 0 END) AS G4_0,
                SUM(CASE WHEN tb_register.Grade = "3.5" THEN 1 ELSE 0 END) AS G3_5,
                SUM(CASE WHEN tb_register.Grade = "3" THEN 1 ELSE 0 END) AS G3_0,
                SUM(CASE WHEN tb_register.Grade = "2.5" THEN 1 ELSE 0 END) AS G2_5,
                SUM(CASE WHEN tb_register.Grade = "2" THEN 1 ELSE 0 END) AS G2_0,
                SUM(CASE WHEN tb_register.Grade = "1.5" THEN 1 ELSE 0 END) AS G1_5,
                SUM(CASE WHEN tb_register.Grade = "1" THEN 1 ELSE 0 END) AS G1_0,
                SUM(CASE WHEN tb_register.Grade IN ("0", "มส", "ร") THEN 1 ELSE 0 END) AS G0,
                COUNT(tb_register.StudentID) AS TotalStu
            ')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID')
            ->join('tb_students', 'tb_students.StudentID = tb_register.StudentID')
            ->where('tb_register.RegisterYear', $KeyYear)
            ->whereIn('tb_subjects.SubjectID', $selectedSubjectIds)
            ->where('tb_students.StudentStatus', '1/ปกติ')
            ->like('tb_students.StudentClass', $KeyLevel . '%')
            ->groupBy('tb_subjects.FirstGroup, tb_register.RegisterYear')
            ->orderBy('tb_subjects.FirstGroup', 'ASC');

        $showData = $query->get()->getResult();

        ob_start();
        require SHARED_LIB_PATH . '/spreadsheet/vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Title
        $sheet->setCellValue('A1', 'รายงานสรุปผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง');
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A2', 'ปีการศึกษา: ' . $KeyYear . ' | ระดับชั้น: ' . $KeyLevel);
        $sheet->mergeCells('A2:L2');

        // Table Header
        $headers = [
            ['กลุ่มสาระการเรียนรู้', 'นักเรียนเข้าสอบ', 'เกรด 4', 'เกรด 3.5', 'เกรด 3', 'เกรด 2.5', 'เกรด 2', 'เกรด 1.5', 'เกรด 1', '0/ร/มส', 'รวม 3 ขึ้นไป', 'ร้อยละ 3 ขึ้นไป']
        ];
        $sheet->fromArray($headers, NULL, 'A4');

        // Data Entry
        $rowIdx = 5;
        $grandTotalStu = 0; $grandG4 = 0; $grandG35 = 0; $grandG3 = 0; $grandG25 = 0; 
        $grandG2 = 0; $grandG15 = 0; $grandG1 = 0; $grandG0 = 0;

        foreach ($showData as $v) {
            $rowGoodTotal = (int)$v->G4_0 + (int)$v->G3_5 + (int)$v->G3_0;
            $rowPercent = $v->TotalStu > 0 ? ($rowGoodTotal / $v->TotalStu) * 100 : 0;

            $dataRow = [
                $v->FirstGroup,
                (int)$v->TotalStu,
                (int)$v->G4_0,
                (int)$v->G3_5,
                (int)$v->G3_0,
                (int)$v->G2_5,
                (int)$v->G2_0,
                (int)$v->G1_5,
                (int)$v->G1_0,
                (int)$v->G0,
                $rowGoodTotal,
                round($rowPercent, 2)
            ];
            $sheet->fromArray($dataRow, NULL, 'A' . $rowIdx);

            $grandTotalStu += (int)$v->TotalStu; $grandG4 += (int)$v->G4_0; $grandG35 += (int)$v->G3_5; 
            $grandG3 += (int)$v->G3_0; $grandG25 += (int)$v->G2_5; $grandG2 += (int)$v->G2_0; 
            $grandG15 += (int)$v->G1_5; $grandG1 += (int)$v->G1_0; $grandG0 += (int)$v->G0;
            $rowIdx++;
        }

        // Summary Row 1: Totals
        $grandGoodTotal = $grandG4 + $grandG35 + $grandG3;
        $overallPercent = $grandTotalStu > 0 ? ($grandGoodTotal / $grandTotalStu) * 100 : 0;
        
        $summaryRow = [
            'รวมทุกกลุ่มสาระการเรียนรู้', $grandTotalStu, 
            $grandG4, $grandG35, $grandG3, $grandG25, $grandG2, $grandG15, $grandG1, $grandG0,
            $grandGoodTotal, round($overallPercent, 2)
        ];
        $sheet->fromArray($summaryRow, NULL, 'A' . $rowIdx);
        $rowIdx++;

        // Summary Row 2: Average Percentages
        $percentG4  = $grandTotalStu > 0 ? round(($grandG4 / $grandTotalStu) * 100, 2) : 0;
        $percentG35 = $grandTotalStu > 0 ? round(($grandG35 / $grandTotalStu) * 100, 2) : 0;
        $percentG3  = $grandTotalStu > 0 ? round(($grandG3 / $grandTotalStu) * 100, 2) : 0;
        $percentG25 = $grandTotalStu > 0 ? round(($grandG25 / $grandTotalStu) * 100, 2) : 0;
        $percentG2  = $grandTotalStu > 0 ? round(($grandG2 / $grandTotalStu) * 100, 2) : 0;
        $percentG15 = $grandTotalStu > 0 ? round(($grandG15 / $grandTotalStu) * 100, 2) : 0;
        $percentG1  = $grandTotalStu > 0 ? round(($grandG1 / $grandTotalStu) * 100, 2) : 0;
        $percentG0  = $grandTotalStu > 0 ? round(($grandG0 / $grandTotalStu) * 100, 2) : 0;

        $averagePercentRow = [
            'ร้อยละเฉลี่ยแยกตามเกรด', '-', 
            $percentG4, $percentG35, $percentG3, $percentG25, $percentG2, $percentG15, $percentG1, $percentG0,
            'ความสำเร็จตามเป้าหมาย (3 ขึ้นไป):', round($overallPercent, 2)
        ];
        $sheet->fromArray($averagePercentRow, NULL, 'A' . $rowIdx);
        $sheet->mergeCells('K' . $rowIdx . ':L' . $rowIdx);

        // Styling
        $lastCol = 'L';
        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:' . $lastCol . '4')->getFont()->setBold(true);
        $sheet->getStyle('A4:' . $lastCol . $rowIdx)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $sheet->getStyle('A' . ($rowIdx-1) . ':' . $lastCol . $rowIdx)->getFont()->setBold(true);
        $sheet->getStyle('B4:' . $lastCol . $rowIdx)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $rowIdx)->getFont()->setItalic(true);

        // Auto column width
        foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'สรุปมาตรฐานกุหลาบหลวง_' . $KeyLevel . '_' . str_replace('/', '-', $KeyYear) . '.xlsx';

        // Clean out buffers
        while (ob_get_level() > 0) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    

    public function ReportScoreRoomMain($Term = 'All', $year = 'All', $Class = 'All', $Room = 'All')
    {
        $data['title'] = "รายงานผลการบันทึกคะแนน (รายห้องเรียน)";
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['Room'] = $this->classroom->ListRoom();
        $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;
        $data['Class'] = $Class;
        $data['RoomValue'] = $Room;

        // Check if parameters are valid, if not, show initial page
        if ($Term === 'All' || $year === 'All' || $Class === 'All' || $Room === 'All') {
            $data['stu'] = [];
            $data['RegisSubject'] = [];
            $data['scoresMap'] = [];
            echo view('admin/Academic/AdminReportResults/AdminReportScoreRoomMain', $data);
            return;
        }

        $currentYear = $Term . '/' . $year;
        
        // Build class string with and without room
        $classPrefix = (strpos($Class, 'ม.') === 0) ? '' : 'ม.';
        $currentClassWithRoom = $classPrefix . $Class . '/' . $Room;  // e.g., ม.5/1
        $currentClassNoRoom = $classPrefix . $Class;                   // e.g., ม.5

        // Strategy: First try to find records by RegisterClass WITH room number
        // If not found, fall back to RegisterClass WITHOUT room number (old data)
        
        // Check if records exist with room number
        $countWithRoom = $this->db->table('tb_register')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $currentClassWithRoom)
            ->countAllResults(false);
        
        $isOldDataFormat = ($countWithRoom == 0);
        $registerClassToUse = $isOldDataFormat ? $currentClassNoRoom : $currentClassWithRoom;
        
        // Pass this info to view for warning display
        $data['isOldDataFormat'] = $isOldDataFormat;
        $data['registerClassUsed'] = $registerClassToUse;

        // Get distinct StudentIDs from tb_register for the selected year and class
        $registerStudentIDs = $this->db->table('tb_register')
            ->distinct()
            ->select('StudentID')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $registerClassToUse)
            ->get()
            ->getResultArray();
        
        $studentIDs = array_column($registerStudentIDs, 'StudentID');

        if (empty($studentIDs)) {
            $data['stu'] = [];
            $data['RegisSubject'] = [];
            $data['scoresMap'] = [];
            echo view('admin/Academic/AdminReportResults/AdminReportScoreRoomMain', $data);
            return;
        }

        // Get student info from tb_students
        $students = $this->db->table('tb_students')
            ->select('StudentID, StudentNumber, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass')
            ->whereIn('StudentID', $studentIDs)
            ->orderBy('StudentNumber', 'ASC')
            ->get()
            ->getResult();
        $data['stu'] = $students;

        // Get all subjects for these students in the selected year
        $data['RegisSubject'] = $this->db->table('tb_register')
            ->select('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID', 'left')
            ->where('tb_register.RegisterYear', $currentYear)
            ->where('tb_register.RegisterClass', $registerClassToUse)
            ->groupBy('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode')
            ->orderBy('tb_subjects.SubjectCode', 'ASC')
            ->get()
            ->getResult();

        // Get all scores for all students in this year and class
        $allScores = $this->db->table('tb_register')
            ->select('StudentID, SubjectID, Score100')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $registerClassToUse)
            ->get()
            ->getResult();

        // Process scores into a map for easy lookup in the view
        $scoresMap = [];
        foreach ($allScores as $score) {
            $sId = (string)$score->StudentID;
            $subId = (string)$score->SubjectID;
            $scoresMap[$sId][$subId] = $score->Score100;
        }
        $data['scoresMap'] = $scoresMap;

        echo view('admin/Academic/AdminReportResults/AdminReportScoreRoomMain', $data);
    }

    /**
     * Export Score Room Report to Excel
     */
    public function exportScoreRoomToExcel($Term = 'All', $year = 'All', $Class = 'All', $Room = 'All')
    {
        if ($Term === 'All' || $year === 'All' || $Class === 'All' || $Room === 'All') {
            return redirect()->back()->with('error', 'กรุณาเลือกปีการศึกษาและห้องเรียนก่อนส่งออก');
        }

        ob_start();
        require SHARED_LIB_PATH . '/spreadsheet/vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $currentYear = $Term . '/' . $year;
        $classPrefix = (strpos($Class, 'ม.') === 0) ? '' : 'ม.';
        $currentClassWithRoom = $classPrefix . $Class . '/' . $Room;
        $currentClassNoRoom = $classPrefix . $Class;

        $countWithRoom = $this->db->table('tb_register')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $currentClassWithRoom)
            ->countAllResults(false);
        
        $registerClassToUse = ($countWithRoom > 0) ? $currentClassWithRoom : $currentClassNoRoom;

        $registerStudentIDs = $this->db->table('tb_register')
            ->distinct()
            ->select('StudentID')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $registerClassToUse)
            ->get()
            ->getResultArray();
        
        $studentIDs = array_column($registerStudentIDs, 'StudentID');

        if (empty($studentIDs)) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลนักเรียน');
        }

        $students = $this->db->table('tb_students')
            ->select('StudentID, StudentNumber, StudentCode, StudentPrefix, StudentFirstName, StudentLastName')
            ->whereIn('StudentID', $studentIDs)
            ->orderBy('StudentNumber', 'ASC')
            ->get()
            ->getResult();

        $subjects = $this->db->table('tb_register')
            ->select('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode')
            ->join('tb_subjects', 'tb_subjects.SubjectID = tb_register.SubjectID', 'left')
            ->where('tb_register.RegisterYear', $currentYear)
            ->where('tb_register.RegisterClass', $registerClassToUse)
            ->groupBy('tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode')
            ->orderBy('tb_subjects.SubjectCode', 'ASC')
            ->get()
            ->getResult();

        $allScores = $this->db->table('tb_register')
            ->select('StudentID, SubjectID, Score100')
            ->where('RegisterYear', $currentYear)
            ->where('RegisterClass', $registerClassToUse)
            ->get()
            ->getResult();

        $scoresMap = [];
        foreach ($allScores as $score) {
            $scoresMap[(string)$score->StudentID][(string)$score->SubjectID] = $score->Score100;
        }

        // Build headers - Row 1: Subject names (merged), Row 2: Score types
        $headers1 = ['ลำดับ', 'รหัส', 'ชื่อ-นามสกุล'];
        $headers2 = ['', '', ''];
        
        foreach ($subjects as $subject) {
            $headers1[] = $subject->SubjectName . ' (' . $subject->SubjectCode . ')';
            $headers1[] = '';
            $headers1[] = '';
            $headers1[] = '';
            $headers2[] = 'ก่อน';
            $headers2[] = 'กลาง';
            $headers2[] = 'หลัง';
            $headers2[] = 'ปลาย';
        }

        $sheet->fromArray($headers1, NULL, 'A1');
        $sheet->fromArray($headers2, NULL, 'A2');

        // Merge subject header cells
        $col = 4; // Start from column D
        foreach ($subjects as $subject) {
            $startCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 3);
            $sheet->mergeCells($startCol . '1:' . $endCol . '1');
            $col += 4;
        }

        // Add data rows
        $row = 3;
        $num = 1;
        foreach ($students as $student) {
            $rowData = [
                $num++,
                $student->StudentCode,
                $student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName
            ];

            foreach ($subjects as $subject) {
                $scoreString = $scoresMap[(string)$student->StudentID][(string)$subject->SubjectID] ?? '';
                $scores = ['', '', '', ''];
                if (!empty($scoreString)) {
                    $parts = explode('|', $scoreString);
                    $scores[0] = $parts[0] ?? '';
                    $scores[1] = $parts[1] ?? '';
                    $scores[2] = $parts[2] ?? '';
                    $scores[3] = $parts[3] ?? '';
                }
                $rowData[] = $scores[0];
                $rowData[] = $scores[1];
                $rowData[] = $scores[2];
                $rowData[] = $scores[3];
            }

            $sheet->fromArray($rowData, NULL, 'A' . $row);
            $row++;
        }

        // Style
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '2')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filename = 'รายงานคะแนน_' . $registerClassToUse . '_' . $currentYear . '.xlsx';
        $filename = str_replace('/', '-', $filename);

        // Clear ALL output buffers
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Set headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function CheckData($Term,$year,$Class,$Room,$IDstu){
        $Check = $this->db->table('tb_register')
        ->select('tb_register.Score100,
                  tb_register.SubjectID,
                  tb_students.StudentID')
        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$year) 
        ->where('tb_students.StudentClass','ม.'.$Class.'/'.$Room)
        ->where('tb_students.StudentID',$IDstu)
        ->orderBy('SubjectID','ASC')
        ->get()->getResult();

        return $Check;
    }

    public function CheckValue($Term,$year,$Class,$Room,$IDstu,$IDSubjuct){
        $Check = $this->db->table('tb_register')
        ->select('tb_register.Score100,
                  tb_register.SubjectID,        
                  tb_register.Grade,
                  tb_students.StudentID')
        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$year) 
        ->where('tb_students.StudentClass','ม.'.$Class.'/'.$Room)
        ->where('tb_students.StudentID',$IDstu)
        ->where('tb_register.SubjectID',$IDSubjuct)
        ->orderBy('tb_register.SubjectID','ASC')
        ->get()->getResult();

        return $Check;
    }


    public function AdminReportGraduationStatsMain()
    {
        $data['title'] = "สถิติการศึกษาต่อและทำงานของผู้สำเร็จการศึกษา";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        
        // Get all unique years of graduates (sorted newest first)
        $data['SelYears'] = $this->db->table('tb_students')
            ->select('YearFinish')
            ->where('YearFinish !=', '')
            ->where('YearFinish IS NOT NULL')
            ->groupBy('YearFinish')
            ->orderBy('YearFinish', 'DESC')
            ->get()->getResult();

        echo view('admin/Academic/AdminReportResults/AdminReportGraduationStatsMain', $data);
    }

    public function AdminReportGraduationStatsData()
    {
        $keyYear = $this->request->getPost('keyYear');

        if (empty($keyYear)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'กรุณาระบุปีการศึกษา'
            ]);
        }

        // Query students who graduated in this year
        $students = $this->db->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentIDNumber, YearFinish')
            ->where('YearFinish', $keyYear)
            ->orderBy('StudentClass', 'ASC')
            ->orderBy('StudentNumber', 'ASC')
            ->get()->getResult();

        // Get details from skjacth_personnel.tb_students
        $studentIds = array_column($students, 'StudentIDNumber');
        
        // Clean all IDs by removing hyphens to guarantee comparison matches
        $cleanedStudentIds = array_map(function($id) {
            return str_replace('-', '', $id);
        }, $studentIds);

        $personnelData = [];
        if (!empty($cleanedStudentIds)) {
            $personnelDataRaw = $this->DBpersonnel->table('tb_students')
                ->select("REPLACE(stu_iden, '-', '') as clean_iden, stu_future_education, stu_career_interest")
                ->whereIn("REPLACE(stu_iden, '-', '')", $cleanedStudentIds)
                ->get()->getResult();
            
            foreach ($personnelDataRaw as $p) {
                $personnelData[$p->clean_iden] = [
                    'future_education' => $p->stu_future_education,
                    'career_interest' => $p->stu_career_interest
                ];
            }
        }

        $data = [];
        $studyingCount = 0;
        $workingCount = 0;
        $otherCount = 0;

        foreach ($students as $index => $s) {
            // Clean the student's ID number to search in the personnel array keys
            $idenCleaned = str_replace('-', '', $s->StudentIDNumber);
            $edu = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['future_education'] : '';
            $career = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['career_interest'] : '';

            $edu = trim($edu);
            $career = trim($career);

            $status = 'ยังไม่ระบุ';
            if (!empty($edu) && $edu !== '-') {
                $status = 'ศึกษาต่อ';
                $studyingCount++;
            } elseif (!empty($career) && $career !== '-') {
                $status = 'ทำงาน';
                $workingCount++;
            } else {
                $otherCount++;
            }

            $data[] = [
                'index' => $index + 1,
                'student_code' => $s->StudentCode,
                'student_iden' => $s->StudentIDNumber,
                'fullname' => $s->StudentPrefix . $s->StudentFirstName . ' ' . $s->StudentLastName,
                'class' => $s->StudentClass,
                'status' => $status,
                'destination' => $status === 'ศึกษาต่อ' ? $edu : ($status === 'ทำงาน' ? $career : '-'),
                'year_finish' => $s->YearFinish
            ];
        }

        $total = count($students);

        return $this->response->setJSON([
            'status' => 'success',
            'summary' => [
                'total' => $total,
                'studying' => $studyingCount,
                'working' => $workingCount,
                'other' => $otherCount,
                'studying_percent' => $total > 0 ? round(($studyingCount / $total) * 100, 1) : 0,
                'working_percent' => $total > 0 ? round(($workingCount / $total) * 100, 1) : 0,
                'other_percent' => $total > 0 ? round(($otherCount / $total) * 100, 1) : 0,
            ],
            'students' => $data
        ]);
    }

    public function AdminReportGraduationStatsSave()
    {
        $iden = $this->request->getPost('iden');
        $status = $this->request->getPost('status');
        $destination = $this->request->getPost('destination');
        $yearFinish = $this->request->getPost('year_finish');

        if (empty($iden)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบข้อมูลเลขประจำตัวประชาชนนักเรียน'
            ]);
        }

        // Clean citizen ID to match db
        $idenClean = str_replace('-', '', $iden);

        // Check if student exists in skjacth_personnel.tb_students
        $student = $this->DBpersonnel->table('tb_students')
            ->where("REPLACE(stu_iden, '-', '')", $idenClean)
            ->get()->getRow();

        if (empty($student)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่พบข้อมูลประวัตินักเรียนคนนี้ในระบบทะเบียนประวัติ (skjacth_personnel.tb_students)'
            ]);
        }

        $updateData = [];
        if ($status === 'ศึกษาต่อ') {
            $updateData['stu_future_education'] = $destination;
            $updateData['stu_career_interest'] = ''; // Clear other
        } elseif ($status === 'ทำงาน') {
            $updateData['stu_career_interest'] = $destination;
            $updateData['stu_future_education'] = ''; // Clear other
        } else {
            $updateData['stu_future_education'] = '';
            $updateData['stu_career_interest'] = '';
        }

        // Update YearFinish in tb_students (default database)
        $yearUpdated = false;
        if (!empty($yearFinish)) {
            $yearUpdated = $this->db->table('tb_students')
                ->where("REPLACE(StudentIDNumber, '-', '')", $idenClean)
                ->update(['YearFinish' => $yearFinish]);
        }

        $updated = $this->DBpersonnel->table('tb_students')
            ->where("REPLACE(stu_iden, '-', '')", $idenClean)
            ->update($updateData);

        if ($updated || $yearUpdated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'บันทึกข้อมูลเส้นทางชีวิตและปีจบการศึกษาสำเร็จเรียบร้อยแล้ว'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้ หรือไม่มีการเปลี่ยนค่าข้อมูลใหม่'
            ]);
        }
    }

    public function AdminReportGraduationStatsApi()
    {
        $year = $this->request->getGet('year');
        if (empty($year)) {
            $year = $this->request->getPost('year');
        }

        // If no year specified, let's return a list of all years with summary stats for each year!
        if (empty($year)) {
            // Get all unique years of graduates
            $yearsList = $this->db->table('tb_students')
                ->select('YearFinish')
                ->where('YearFinish !=', '')
                ->where('YearFinish IS NOT NULL')
                ->groupBy('YearFinish')
                ->orderBy('YearFinish', 'DESC')
                ->get()->getResult();

            $summaryData = [];
            foreach ($yearsList as $y) {
                $keyYear = $y->YearFinish;
                
                // Query students who graduated in this year
                $students = $this->db->table('tb_students')
                    ->select('StudentIDNumber')
                    ->where('YearFinish', $keyYear)
                    ->get()->getResult();
                
                $studentIds = array_column($students, 'StudentIDNumber');
                $cleanedStudentIds = array_map(function($id) {
                    return str_replace('-', '', $id);
                }, $studentIds);

                $studyingCount = 0;
                $workingCount = 0;
                $otherCount = 0;

                if (!empty($cleanedStudentIds)) {
                    $personnelDataRaw = $this->DBpersonnel->table('tb_students')
                        ->select("stu_future_education, stu_career_interest")
                        ->whereIn("REPLACE(stu_iden, '-', '')", $cleanedStudentIds)
                        ->get()->getResult();
                    
                    foreach ($personnelDataRaw as $p) {
                        $edu = trim($p->stu_future_education);
                        $career = trim($p->stu_career_interest);
                        if (!empty($edu) && $edu !== '-') {
                            $studyingCount++;
                        } elseif (!empty($career) && $career !== '-') {
                            $workingCount++;
                        } else {
                            $otherCount++;
                        }
                    }
                }

                // Add students who had no records in personnel as 'other'
                $total = count($students);
                $foundRecordsCount = $studyingCount + $workingCount + $otherCount;
                if ($total > $foundRecordsCount) {
                    $otherCount += ($total - $foundRecordsCount);
                }

                $summaryData[] = [
                    'year_finish' => $keyYear,
                    'total_graduates' => $total,
                    'studying' => $studyingCount,
                    'working' => $workingCount,
                    'other' => $otherCount,
                    'studying_percent' => $total > 0 ? round(($studyingCount / $total) * 100, 1) : 0,
                    'working_percent' => $total > 0 ? round(($workingCount / $total) * 100, 1) : 0,
                    'other_percent' => $total > 0 ? round(($otherCount / $total) * 100, 1) : 0,
                ];
            }

            return $this->response->setJSON([
                'status' => 'success',
                'description' => 'ข้อมูลสรุปสถิติปลายทางของผู้สำเร็จการศึกษา แยกตามปีการศึกษา',
                'data' => $summaryData
            ]);
        }

        // If a specific year is requested, return the detailed statistics of that year!
        $students = $this->db->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentIDNumber, YearFinish')
            ->where('YearFinish', $year)
            ->orderBy('StudentClass', 'ASC')
            ->orderBy('StudentNumber', 'ASC')
            ->get()->getResult();

        $studentIds = array_column($students, 'StudentIDNumber');
        $cleanedStudentIds = array_map(function($id) {
            return str_replace('-', '', $id);
        }, $studentIds);

        $personnelData = [];
        if (!empty($cleanedStudentIds)) {
            $personnelDataRaw = $this->DBpersonnel->table('tb_students')
                ->select("REPLACE(stu_iden, '-', '') as clean_iden, stu_future_education, stu_career_interest")
                ->whereIn("REPLACE(stu_iden, '-', '')", $cleanedStudentIds)
                ->get()->getResult();
            
            foreach ($personnelDataRaw as $p) {
                $personnelData[$p->clean_iden] = [
                    'future_education' => $p->stu_future_education,
                    'career_interest' => $p->stu_career_interest
                ];
            }
        }

        $data = [];
        $studyingCount = 0;
        $workingCount = 0;
        $otherCount = 0;

        foreach ($students as $index => $s) {
            $idenCleaned = str_replace('-', '', $s->StudentIDNumber);
            $edu = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['future_education'] : '';
            $career = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['career_interest'] : '';

            $edu = trim($edu);
            $career = trim($career);

            $status = 'ยังไม่ระบุ';
            if (!empty($edu) && $edu !== '-') {
                $status = 'ศึกษาต่อ';
                $studyingCount++;
            } elseif (!empty($career) && $career !== '-') {
                $status = 'ทำงาน';
                $workingCount++;
            } else {
                $otherCount++;
            }

            $data[] = [
                'index' => $index + 1,
                'student_code' => $s->StudentCode,
                'student_iden' => $s->StudentIDNumber,
                'fullname' => $s->StudentPrefix . $s->StudentFirstName . ' ' . $s->StudentLastName,
                'class' => $s->StudentClass,
                'status' => $status,
                'destination' => $status === 'ศึกษาต่อ' ? $edu : ($status === 'ทำงาน' ? $career : '-'),
                'year_finish' => $s->YearFinish
            ];
        }

        $total = count($students);

        return $this->response->setJSON([
            'status' => 'success',
            'year' => $year,
            'summary' => [
                'total' => $total,
                'studying' => $studyingCount,
                'working' => $workingCount,
                'other' => $otherCount,
                'studying_percent' => $total > 0 ? round(($studyingCount / $total) * 100, 1) : 0,
                'working_percent' => $total > 0 ? round(($workingCount / $total) * 100, 1) : 0,
                'other_percent' => $total > 0 ? round(($otherCount / $total) * 100, 1) : 0,
            ],
            'students' => $data
        ]);
    }

    public function AdminReportEnrollMain(){
        $data['title'] = "รายงานการรับสมัครนักเรียน"; 
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['SelYear'] = $this->DBadmission->table('tb_recruitstudent')->select('recruit_year')->groupBy('recruit_year')->get()->getResult();
        $data['CheckYearadmission'] = $this->DBadmission->table('tb_openyear')->select('openyear_year')->get()->getRow();

        
        echo view('admin/Academic/AdminReportResults/AdminReportEnrollMain',$data);
        
    }

    public function AdminReportEnrollData(){
        $data = [];
        $keyYear = $this->request->getPost('keyYear');

        $SelDataStudent = $this->DBadmission->table('skjacth_admission.tb_recruitstudent')
        ->select('skjacth_admission.tb_recruitstudent.recruit_id,
                skjacth_admission.tb_recruitstudent.recruit_regLevel,
                skjacth_admission.tb_recruitstudent.recruit_prefix,
                skjacth_admission.tb_recruitstudent.recruit_firstName,
                skjacth_admission.tb_recruitstudent.recruit_lastName,
                skjacth_admission.tb_recruitstudent.recruit_tpyeRoom,
                skjacth_admission.tb_recruitstudent.recruit_category,
                skjacth_admission.tb_recruitstudent.recruit_status,
                skjacth_admission.tb_recruitstudent.recruit_statusSurrender,
                skjacth_admission.tb_recruitstudent.recruit_statusFinal,
                skjacth_admission.tb_recruitstudent.recruit_idCard,
                skjacth_personnel.tb_students.stu_UpdateConfirm
                ')
        ->join('skjacth_personnel.tb_students','skjacth_admission.tb_recruitstudent.recruit_idCard = skjacth_personnel.tb_students.stu_iden','LEFT')
        ->where('tb_recruitstudent.recruit_year',$keyYear)        
        ->where('tb_recruitstudent.recruit_statusFinal IS NOT NULL')
        ->where('tb_recruitstudent.recruit_statusSurrender IS NOT NULL')
        ->get()->getResult();

        foreach($SelDataStudent as $record){
            
            $data[] = array( 
                "recruit_id" => $record->recruit_id,
                "recruit_regLevel" => $record->recruit_regLevel,
                "recruit_Fullname" => $record->recruit_prefix.$record->recruit_firstName.' '.$record->recruit_lastName,
                "recruit_tpyeRoom" => $record->recruit_tpyeRoom,
                "recruit_category" => $record->recruit_category,
                "recruit_status" => $record->recruit_status,
                "recruit_statusFinal" => $record->recruit_statusFinal,
                "stu_UpdateConfirm" => $record->stu_UpdateConfirm,
                "recruit_statusSurrender" => $record->recruit_statusSurrender,
                "recruit_idCard" => $record->recruit_idCard
            );
           
        }   
        $output = array(
            "data" =>  $data
        );
       return $this->response->setJSON($output);
    }

    public function AdminReportEnrollDetailStudent($IDStu){
        $data['title'] = "ข้อมูลนักเรียนรายบุคคล"; 
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();

        $CkeckIDEN = $this->DBadmission->table('tb_recruitstudent')->select('*')->where('recruit_id',$IDStu)->get()->getRow();
        $data['recruitData'] = $CkeckIDEN;
        $data['recruit_regLevel'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_regLevel : null;
        $data['recruit_img'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_img : null;
        $data['recruit_statusFinal'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_statusFinal : null;
        $data['recruit_statusSurrender'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_statusSurrender : null;
        $data['recruit_category'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_category : null;
        $data['recruit_tpyeRoom'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_tpyeRoom : null;

        // ดึงข้อมูลนักเรียนจากฐานข้อมูลบุคลากร โดยทำความสะอาดและรองรับเลขประจำตัวประชาชนที่มีหรือไม่มีขีด
        $idCardClean = !empty($CkeckIDEN->recruit_idCard) ? str_replace(['-', ' '], '', $CkeckIDEN->recruit_idCard) : null;
        $DataStudent = null;
        if (!empty($idCardClean)) {
            $DataStudent = $this->DBpersonnel->table('tb_students')
                ->where('REPLACE(stu_iden, "-", "")', $idCardClean)
                ->get()
                ->getRow();
        }

        // กรณีที่นักเรียนยังไม่ถูกสร้างหรือซิงค์ข้อมูลลงใน tb_students ของระบบบุคลากร (เช่น ผู้สมัครใหม่)
        // จะทำการสร้าง fallback object จากข้อมูลใบสมัครจริง (tb_recruitstudent) เพื่อไม่ให้เกิด Error ในหน้า View
        if (empty($DataStudent)) {
            $DataStudent = new \stdClass();
            $DataStudent->stu_prefix = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_prefix ?? '') : '';
            $DataStudent->stu_fristName = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_firstName ?? '') : '';
            $DataStudent->stu_lastName = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_lastName ?? '') : '';
            $DataStudent->stu_phone = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_phone ?? '-') : '-';
            $DataStudent->stu_nickName = '-';
            $DataStudent->stu_iden = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_idCard ?? '') : '';
            $DataStudent->stu_birthDay = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_birthday ?? '-') : '-';
            $DataStudent->stu_religion = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_religion ?? '-') : '-';
            $DataStudent->stu_bloodType = '-';
            $DataStudent->stu_birthHospital = '-';
            $DataStudent->stu_birthTambon = '-';
            $DataStudent->stu_birthDistrict = '-';
            $DataStudent->stu_birthProvirce = '-';
            $DataStudent->stu_nationality = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_nationality ?? '-') : '-';
            $DataStudent->stu_race = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_race ?? '-') : '-';
            $DataStudent->stu_wieght = '-';
            $DataStudent->stu_hieght = '-';
            $DataStudent->stu_diseaes = '-';
            $DataStudent->stu_parenalStatus = '-';
            $DataStudent->stu_presentLife = '-';
            $DataStudent->stu_talent = '-';
            
            // ข้อมูลที่อยู่ตามทะเบียนบ้าน
            $DataStudent->stu_hNumber = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_address ?? '-') : '-';
            $DataStudent->stu_hMoo = '-';
            $DataStudent->stu_hRoad = '-';
            $DataStudent->stu_hTambon = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_tambon ?? '-') : '-';
            $DataStudent->stu_hDistrict = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_district ?? '-') : '-';
            $DataStudent->stu_hProvince = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_province ?? '-') : '-';
            $DataStudent->stu_hPostCode = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_zipcode ?? '-') : '-';
            
            // ข้อมูลที่อยู่ปัจจุบัน
            $DataStudent->stu_cNumber = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_address ?? '-') : '-';
            $DataStudent->stu_cMoo = '-';
            $DataStudent->stu_cRoad = '-';
            $DataStudent->stu_cTumbao = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_tambon ?? '-') : '-';
            $DataStudent->stu_cDistrict = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_district ?? '-') : '-';
            $DataStudent->stu_cProvince = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_province ?? '-') : '-';
            $DataStudent->stu_cPostcode = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_zipcode ?? '-') : '-';
            
            $DataStudent->stu_phoneUrgent = '-';
            $DataStudent->stu_natureRoom = '-';
            
            // ประวัติการศึกษาเดิม
            $DataStudent->stu_gradLevel = '-';
            $DataStudent->stu_schoolfrom = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_schoolName ?? '-') : '-';
            $DataStudent->stu_schoolTambao = '-';
            $DataStudent->stu_schoolDistrict = '-';
            $DataStudent->stu_schoolProvince = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_schoolProvince ?? '-') : '-';
            
            $DataStudent->stu_usedStudent = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_oldStudent ?? 'ไม่เคย') : 'ไม่เคย';
            $DataStudent->stu_UpdateConfirm = !empty($CkeckIDEN) ? ($CkeckIDEN->recruit_status ?? null) : null;
        }

        $data['DataStudent'] = $DataStudent;

        $data['recruitLabels'] = [
            'recruit_id' => 'ID ผู้สมัคร',
            'recruit_regLevel' => 'ชั้นที่สมัคร',
            'recruit_prefix' => 'คำนำหน้า',
            'recruit_firstName' => 'ชื่อ',
            'recruit_lastName' => 'นามสกุล',
            'recruit_idCard' => 'เลขประจำตัวประชาชน',
            'recruit_birthday' => 'วันเกิด',
            'recruit_sex' => 'เพศ',
            'recruit_religion' => 'ศาสนา',
            'recruit_nationality' => 'สัญชาติ',
            'recruit_race' => 'เชื้อชาติ',
            'recruit_phone' => 'เบอร์โทรศัพท์',
            'recruit_email' => 'อีเมล',
            'recruit_schoolName' => 'โรงเรียนเดิม',
            'recruit_schoolProvince' => 'จังหวัดโรงเรียนเดิม',
            'recruit_grade' => 'เกรดเฉลี่ย (GPA)',
            'recruit_category' => 'รอบที่สมัคร/ประเภทโควตา',
            'recruit_tpyeRoom' => 'สายการเรียน/ประเภทห้องเรียน',
            'recruit_typeRoomBackup' => 'สายการเรียนสำรอง',
            'recruit_img' => 'ชื่อไฟล์รูปภาพ',
            'recruit_status' => 'สถานะการสมัคร',
            'recruit_statusFinal' => 'ผลการตัดสินสุดท้าย',
            'recruit_statusSurrender' => 'สถานะการมอบตัว',
            'recruit_year' => 'ปีการศึกษา',
            'recruit_regNum' => 'เลขที่สมัคร/เลขที่นั่งสอบ',
            
            // ข้อมูลบิดา
            'recruit_fPrefix' => 'คำนำหน้าบิดา',
            'recruit_fFirstName' => 'ชื่อบิดา',
            'recruit_fLastName' => 'นามสกุลบิดา',
            'recruit_fPhone' => 'เบอร์โทรศัพท์บิดา',
            'recruit_fIdCard' => 'เลขบัตรประชาชนบิดา',
            'recruit_fJob' => 'อาชีพบิดา',
            'recruit_fSalary' => 'รายได้บิดา',
            'recruit_fStatus' => 'สถานภาพบิดา',
            
            // ข้อมูลมารดา
            'recruit_mPrefix' => 'คำนำหน้ามารดา',
            'recruit_mFirstName' => 'ชื่อมารดา',
            'recruit_mLastName' => 'นามสกุลมารดา',
            'recruit_mPhone' => 'เบอร์โทรศัพท์มารดา',
            'recruit_mIdCard' => 'เลขบัตรประชาชนมารดา',
            'recruit_mJob' => 'อาชีพมารดา',
            'recruit_mSalary' => 'รายได้มารดา',
            'recruit_mStatus' => 'สถานภาพมารดา',
            
            // ข้อมูลผู้ปกครอง
            'recruit_pPrefix' => 'คำนำหน้าผู้ปกครอง',
            'recruit_pFirstName' => 'ชื่อผู้ปกครอง',
            'recruit_pLastName' => 'นามสกุลผู้ปกครอง',
            'recruit_pPhone' => 'เบอร์โทรศัพท์ผู้ปกครอง',
            'recruit_pIdCard' => 'เลขบัตรประชาชนผู้ปกครอง',
            'recruit_pRelation' => 'ความสัมพันธ์ผู้ปกครอง',
            'recruit_pJob' => 'อาชีพผู้ปกครอง',
            'recruit_pSalary' => 'รายได้ผู้ปกครอง',
            
            // ที่อยู่
            'recruit_oldStudent' => 'สถานะนักเรียนเก่า',
            'recruit_province' => 'จังหวัดที่อยู่',
            'recruit_district' => 'อำเภอที่อยู่',
            'recruit_tambon' => 'ตำบลที่อยู่',
            'recruit_address' => 'บ้านเลขที่/ที่อยู่',
            'recruit_zipcode' => 'รหัสไปรษณีย์',
            
            // ระบบ
            'recruit_createdate' => 'วันที่สมัคร',
            'recruit_updatedate' => 'วันที่แก้ไขล่าสุด',
            'recruit_userUpdate' => 'ผู้แก้ไขล่าสุด',
            'recruit_ipUpdate' => 'IP ที่เข้าถึงล่าสุด',
            'recruit_token' => 'รหัส Token ระบบ'
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }
        
        echo view('admin/Academic/AdminReportResults/AdminReportEnrollDetailStudent',$data);
    }
}
