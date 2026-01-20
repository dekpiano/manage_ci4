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

        // FIX: Always fetch SchoolYear for the layout
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        
        // Use session-stored selected year
        $data['selectedYear'] = get_selected_year();

        // Get available years for dropdown
        $data['CheckYearSaveScore'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();

        // Determine current year
        if ($Term === null || $Year === null) {
            // Use the already fetched SchoolYear object
            if ($data['SchoolYear'] && property_exists($data['SchoolYear'], 'schyear_year')) {
                $parts = explode('/', $data['SchoolYear']->schyear_year);
                $Term = $parts[0] ?? null;
                $Year = $parts[1] ?? null;
            }
        }

        $data['Term'] = $Term;
        $data['Year'] = $Year;
        $currentYear = ($Term && $Year) ? $Term . '/' . $Year : null;

        // Get students for the selected year
        if ($currentYear) {
            $data['stu'] = $this->db->table('tb_students')
                                ->select("tb_students.StudentID, tb_students.StudentNumber, tb_students.StudentClass, tb_students.StudentCode, tb_students.StudentPrefix, tb_students.StudentFirstName, tb_students.StudentLastName, tb_students.StudentStatus")
                                ->distinct()
                                ->join('tb_register', 'tb_register.StudentID = tb_students.StudentID')
                                ->where('tb_students.StudentStatus','1/ปกติ')
                                ->where('tb_register.RegisterYear', $currentYear)
                                ->get()->getResult();
        } else {
            $data['stu'] = []; // No year selected or found, return empty list
        }

        echo view('admin/Academic/AdminReportResults/AdminReportPersonMain',$data);
    }

    public function AdminReportTeacherSaveScoreMain($Term = null, $year = null){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow(); // Fetch SchoolYear

        if ($Term === null || $year === null) {
            // Use SchoolYear as default
            if ($data['SchoolYear'] && property_exists($data['SchoolYear'], 'schyear_year')) {
                $parts = explode('/', $data['SchoolYear']->schyear_year);
                $Term = $parts[0] ?? '2';
                $year = $parts[1] ?? '2567';
            } else {
                $Term = '2';
                $year = '2567';
            }
        }
        
        $data['Term'] = $Term;
        $data['Year'] = $year;

        // Get teacher IDs that have records in the selected term/year
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
                $data['Teacher'] = []; // No teachers found, so pass an empty array to the view
            }
            $data['CheckYearSaveScore'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();        
            $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;       
        $data['title'] = "รายงานผลการบันทึกคะแนนครูผู้สอน";

        
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreMain',$data);
        
        
    }

    public function AdminReportTeacherSaveScoreCheck($Term,$year,$TeacID){  
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['Teacher'] = $this->DBpersonnel->table('tb_personnel')
        ->select('pers_prefix,pers_firstname,pers_lastname')
        ->where('pers_id',$TeacID)
        ->get()->getRow();

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
        
        
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreCheck',$data);
        

    }

    public function AdminReportRoomMain(){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
        $keyroom = $this->request->getPost("keyroom");
        $SubRoom1 = explode('.',$keyroom);
        $SubRoom2 = explode('/',!empty($SubRoom1[1]) ? $SubRoom1[1] : '' );        
        $KeyCheckYear = $this->request->getPost("KeyCheckYear");
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
            $data['totip'] = "ระดับชั้น ".$keyroom;
            
            $data['stu'] = $this->db->table('tb_students')
                                    ->select("StudentID, StudentNumber, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName")
                                    ->where('StudentStatus','1/ปกติ')
                                    ->where('StudentClass',$keyroom)     
                                    ->orderBy('tb_students.StudentNumber','ASC')
                                    ->get()->getResult();

            $data['subject'] = $this->db->table('tb_register')
                            ->select("tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit")
                            ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                            ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
                            ->where('RegisterYear',$KeyCheckYear)
                            ->where('StudentStatus','1/ปกติ')
                            ->where('StudentClass',$keyroom)                                
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
                                $studentGPA = ($studentTotalUnit != 0) ? round($studentTotalGradeValue / $studentTotalUnit, 2) : 0.00;
                                $studentRow[] = $studentGPA; // Add GPA to the student's data array
                                $CheckSub[] = $studentRow;
                            }
                    
                            $data['CheckSub'] = $CheckSub;

                           // echo '<pre>';print_r($CheckSub); exit();   
                                


        }
        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "รายงานผลการเรียนรายห้องเรียน";
        $data['Room'] = $this->classroom->ListRoom(); // Added this line

        
        echo view('admin/Academic/AdminReportResults/AdminReportRoomMain',$data);
        
        
    }

    public function exportRoomReportToExcel()
    {
        ob_start(); // Explicitly start output buffering

         $path = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
		require $path . '/librarie_skj/spreadsheet/vendor/autoload.php';
        //require_once APPPATH . '../vendor/autoload.php';
        
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

        $data['stu'] = $this->db->table('tb_students')
                                ->select("StudentID, StudentNumber, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName")
                                ->where('StudentStatus','1/ปกติ')
                                ->where('StudentClass',$keyroom)     
                                ->orderBy('tb_students.StudentNumber','ASC')
                                ->get()->getResult();

        $data['subject'] = $this->db->table('tb_register')
                        ->select("tb_register.SubjectID, tb_subjects.SubjectName, tb_subjects.SubjectCode, tb_subjects.SubjectUnit")
                        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                        ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
                        ->where('RegisterYear',$KeyCheckYear)
                        ->where('StudentStatus','1/ปกติ')
                        ->where('StudentClass',$keyroom)                                
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
            
            $studentGPA = ($studentTotalUnit != 0) ? round($studentTotalGradeValue / $studentTotalUnit, 2) : 0.00;
            $studentRow[] = $studentGPA; 
            $CheckSub[] = $studentRow;
        }

        // Set headers
        $filename = 'รายงานผลการเรียนรายห้องเรียน_' . $keyroom . '_' . $KeyCheckYear . '.xlsx';
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
                            ->select('StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName')
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
        
            public function AdminReportAcademicSummary(){
                $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
                $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
                $data['title'] = "รายงานสรุปผลสัมฤทธิ์ทางการเรียน"; // Placeholder title
                $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
                $data['lern'] = $this->DBSkj->table('tb_learning')->get()->getResult();

                $data['Keylern'] = $this->request->getGet('SelLern');
                $data['KeyYear'] = urldecode($this->request->getGet('KeyYear'));

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
                echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummary', $data);
            }
        
            public function AdminReportAcademicSummaryRoyalRoseStandard(){
                $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
                $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
                $data['title'] = "รายงานสรุปผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง";        
                $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
        $data['lern'] = $this->DBSkj->table('tb_learning')->get()->getResult();

        $data['KeyLevel'] = $this->request->getGet('SelLevel');
        $data['KeyYear'] = urldecode($this->request->getGet('KeyYear'));
       // echo  $data['KeyYear']; exit();      
       
        $data['Showdata'] = $this->db->table('tb_register')
                            ->select('
                                tb_subjects.FirstGroup,
                                tb_register.RegisterYear,
                                tb_register.RegisterClass,
                                tb_subjects.SubjectCode,
                                tb_subjects.SubjectName,
                                SUM(CASE WHEN tb_register.Grade = 4 THEN 1 ELSE 0 END) AS G4_0,
                                SUM(CASE WHEN tb_register.Grade = 3.5 THEN 1 ELSE 0 END) AS G3_5,
                                SUM(CASE WHEN tb_register.Grade = 3 THEN 1 ELSE 0 END) AS G3_0,
                                SUM(CASE WHEN tb_register.Grade = 2.5 THEN 1 ELSE 0 END) AS G2_5,
                                SUM(CASE WHEN tb_register.Grade = 2 THEN 1 ELSE 0 END) AS G2_0,
                                SUM(CASE WHEN tb_register.Grade = 1.5 THEN 1 ELSE 0 END) AS G1_5,
                                SUM(CASE WHEN tb_register.Grade = 1 THEN 1 ELSE 0 END) AS G1_0,
                                SUM(CASE WHEN tb_register.Grade = 0 or tb_register.Grade = "มส" or tb_register.Grade = "ร" THEN 1 ELSE 0 END) AS G0                                 
                                ')
                            ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
                            ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
                            ->where('tb_subjects.SubjectYear',$data['KeyYear'])
                            ->where('tb_register.RegisterYear',$data['KeyYear'])
                            ->like('tb_register.RegisterClass',$data['KeyLevel'] . '%')
                            ->groupBy('tb_subjects.FirstGroup, tb_subjects.SubjectCode, tb_register.RegisterYear, tb_register.RegisterClass, tb_subjects.SubjectName')
                            ->get()->getResult();        

        
        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummaryRoyalRoseStandard',$data);
        

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
                skjacth_admission.tb_recruitstudent.recruit_idCard,
                skjacth_personnel.tb_students.stu_UpdateConfirm
                ')
        ->join('skjacth_personnel.tb_students','skjacth_admission.tb_recruitstudent.recruit_idCard = skjacth_personnel.tb_students.stu_iden','LEFT')
        ->where('tb_recruitstudent.recruit_year',$keyYear)        
        ->get()->getResult();

        foreach($SelDataStudent as $record){
            
            $data[] = array( 
                "recruit_id" => $record->recruit_id,
                "recruit_regLevel" => $record->recruit_regLevel,
                "recruit_Fullname" => $record->recruit_prefix.$record->recruit_firstName.' '.$record->recruit_lastName,
                "recruit_tpyeRoom" => $record->recruit_tpyeRoom,
                "recruit_category" => $record->recruit_category,
                "recruit_status" => $record->recruit_status,
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

        $CkeckIDEN = $this->DBadmission->table('tb_recruitstudent')->select('recruit_idCard,recruit_regLevel,recruit_img')->where('recruit_id',$IDStu)->get()->getRow();
        $data['recruit_regLevel'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_regLevel : null;
        $data['recruit_img'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_img : null;
        $data['DataStudent'] = !empty($CkeckIDEN->recruit_idCard) ? $this->DBpersonnel->table('tb_students')->where('stu_iden',$CkeckIDEN->recruit_idCard)->get()->getRow() : null;

        //echo '<pre>'; print_r($data['DataStudent']); exit();
        
        echo view('admin/Academic/AdminReportResults/AdminReportEnrollDetailStudent',$data);
        
    }
}
