<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminSaveScore;
use Google\Client;
use Google\Service\Sheets;

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

        // configure the Google Client
        $client = new Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        // credentials.json is the key file we downloaded while setting up our Google Sheets API
        $serviceKeyPath = WRITEPATH . 'service_key.json'; // Assuming service_key.json is in the project root
        if (file_exists($serviceKeyPath)) {
            $client->setAuthConfig($serviceKeyPath);
        } else {
            // Handle case where service_key.json is not found
            // Log an error or throw an exception
            log_message('error', 'service_key.json not found at ' . $serviceKeyPath);
            // You might want to return null or throw an exception here.
            return null;
        }

        // configure the Sheets Service
        $service = new Sheets($client);
         
        return $service;
    }

    public function AdminReportPersonMain(){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['stu'] = $this->db->table('tb_students')
                            ->select("StudentID, StudentNumber, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentStatus")
                            ->where('StudentStatus','1/ปกติ')
                            ->get()->getResult();
        $data['title'] = "รายงานผลการเรียนรายบุคคล";

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportPersonMain');
        
        
    }

    public function AdminReportTeacherSaveScoreMain($Term,$year){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
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
        ->join('skjacth_skj.tb_position','skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position')
        ->join('skjacth_skj.tb_learning','skjacth_skj.tb_learning.lear_id = skjacth_personnel.tb_personnel.pers_learning')
        ->get()->getResult();
        $data['CheckYearSaveScore'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;       
        $data['title'] = "รายงานผลการบันทึกคะแนนครูผู้สอน";

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreMain');
        
        
    }

    public function AdminReportTeacherSaveScoreCheck($Term,$year,$TeacID){  
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
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
        ->groupBy('tb_subjects.SubjectID')
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
        ->orderBy('StudentClass','ASC')
        ->orderBy('StudentNumber','ASC')
        ->get()->getResult();
        
        //echo '<pre>'; print_r($data['CheckScore']); exit();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;
        
        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportTeacherSaveScoreCheck');
        

    }

    public function AdminReportRoomMain(){   
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
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
                            ->groupBy('tb_register.SubjectID')  
                            ->orderBy('SubjectType',"ASC")  
                            ->orderBy('FirstGroup',"ASC")   
                            ->orderBy('SubjectCode',"ASC")                 
                            ->orderBy('SecondGroup',"ASC")
                            ->get()->getResult();

                            $CheckSub = [];
                            foreach ($data['stu'] as $key => $value) {
                                
                                $CheckSub[$key][] = $value->StudentID;
                                $CheckSub[$key][] = $value->StudentNumber;
                                $CheckSub[$key][] = $value->StudentPrefix.$value->StudentFirstName.' '.$value->StudentLastName;
                                $CheckSub[$key][] = $value->StudentCode;
                    
                    
                                $check_sub = array();
                                $da = $this->CheckData($Term,$year,$Class,$Room,$value->StudentID);
                                    foreach ($da as $key22 => $v_da) {
                                        $check_sub[] = $v_da->SubjectID;
                                    }
                                   // echo '<pre>'; print_r($check_sub);
                    
                                 foreach ($data['subject'] as $key1 => $v_Check) {
                                   // echo array_search($v_Check->SubjectCode, $check_sub);
                                    if(in_array($v_Check->SubjectID, $check_sub)){
                                        $dat = $this->CheckValue($Term,$year,$Class,$Room,$value->StudentID,$v_Check->SubjectID);
                                       
                                        $CheckSub[$key][] = $v_Check->SubjectID.'/'.(!empty($dat[0]->Grade) ? $dat[0]->Grade : '' );
                                    }else{
                                        $CheckSub[$key][] = $v_Check->SubjectID.'/';
                                    }
                                   
                                }
                               
                            }
                    
                            $data['CheckSub'] = $CheckSub;

                           // echo '<pre>';print_r($CheckSub); exit();   
                                


        }
        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['title'] = "รายงานผลการเรียนรายห้องเรียน";

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportRoomMain');
        
        
    }

    public function AdminStudentsScore($IdStudent){      
        $data['title'] = "ผลการเรียนนักเรียนรายบุคคล";
        $data['ExtraSetting'] = $this->db->table('tb_extra_setting')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        $data['scoreYear'] = $this->db->table('tb_register')
                                    ->select('tb_register.RegisterClass,
                                            tb_register.RegisterYear,
                                            tb_register.StudentID')
                                    ->where('StudentID',$IdStudent)
                                    ->groupBy('tb_register.RegisterYear')
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
        $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        
        // The getClient method should return a valid Google_Service_Sheets object
        $service = $this->getClient();
        $spreadsheetId = '1eMgeASo3Vqxh8O0pERAJ0WO_9MLVx4wkuiJEFjquAfQ'; // Assuming this is correct
        
        $range_checkChunum = 'ชุมนุม!A3:F1000';  // TODO: Update placeholder value.
        $response_checkChunum = $service ? $service->spreadsheets_values->get($spreadsheetId, $range_checkChunum) : null;
        $numRows_checkChunum = ($response_checkChunum && !empty($response_checkChunum->getValues())) ? count($response_checkChunum->getValues()) : 0;
       
        $range_ruksun = 'ลูกเสือ!A3:F1000';  // TODO: Update placeholder value.
        $response_ruksun = $service ? $service->spreadsheets_values->get($spreadsheetId, $range_ruksun) : null;
        $numRows_ruksun = ($response_ruksun && !empty($response_ruksun->getValues())) ? count($response_ruksun->getValues()) : 0;
      
       $checkChunum = [];
       if ($response_checkChunum && !empty($response_checkChunum->values)) {
           foreach ($response_checkChunum->values as $key => $value) {
            $checkChunum[] = !empty($value[1]) ? $value[1] : null;
           }   
       }
       $data['checkChunum']  = $checkChunum;
     
       $checkRuksun = [];
       if ($response_ruksun && !empty($response_ruksun->values)) {
           foreach ($response_ruksun->values as $key => $value) {
            $checkRuksun[] = !empty($value[1]) ? $value[1] : null;
           }   
       }
       $data['checkRuksun']  = $checkRuksun;
       $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportStudentsResult');
        
              
    }

    public function AdminReportSummaryTeacher(){
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
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
                            ->groupBy('tb_students.StudentClass,tb_register.SubjectID')
                            ->orderBy('TeacherID,SubjectID,StudentClass')
                            ->get()->getResult();        

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummary');
        

    }

    public function AdminReportAcademicSummaryRoyalRoseStandard(){
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
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
                            ->where('tb_register.RegisterClass',$data['KeyLevel'])
                            ->groupBy('tb_subjects.FirstGroup,tb_subjects.SubjectCode')
                            ->get()->getResult();        

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportAcademicSummaryRoyalRoseStandard');
        

    }

    

    public function ReportScoreRoomMain($Term,$year,$Class,$Room){
        $data['title'] = "รายงานผลการบันทึกคะแนน (รายห้องเรียน)"; 
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        // The `classroom` library is not defined in CI4, assuming it's a custom helper or will be migrated separately
        // For now, removing the call to it. If it's crucial, a CI4 equivalent needs to be created.
        // $data['Room'] = $this->classroom->ListRoom(); 
        $data['CheckYear'] = $this->db->table('tb_register')->select('RegisterYear')->groupBy('RegisterYear')->get()->getResult();

        $data['stu'] = $this->db->table('tb_students')
        ->select('tb_students.StudentID,tb_students.StudentNumber,tb_students.StudentClass,tb_students.StudentCode,tb_students.StudentPrefix,tb_students.StudentFirstName,tb_students.StudentLastName,tb_register.Score100,tb_register.SubjectID')
        ->join('tb_register','tb_students.StudentID = tb_register.StudentID')
        ->where('tb_register.RegisterYear',$Term.'/'.$year) 
        ->where('tb_students.StudentStatus','1/ปกติ')
        ->where('tb_students.StudentClass','ม.'.$Class.'/'.$Room)        
        ->groupBy('StudentCode') 
        ->orderBy('tb_students.StudentNumber','ASC')
        ->get()->getResult();

        $data['RegisSubject'] = $this->db->table('tb_register')
        ->select('tb_register.SubjectID,
        tb_subjects.SubjectName,
        tb_subjects.SubjectCode')
        ->join('tb_students','tb_students.StudentID = tb_register.StudentID')
        ->join('tb_subjects','tb_subjects.SubjectID = tb_register.SubjectID')
        ->where('tb_register.RegisterYear',$Term.'/'.$year)  
        ->where('tb_students.StudentClass','ม.'.$Class.'/'.$Room)  
        ->orderBy('tb_register.SubjectID','ASC')
        ->groupBy('tb_register.SubjectID') 
        ->get()->getResult();
        
                  
        $CheckSub = [];
        foreach ($data['stu'] as $key => $value) {
            
            $CheckSub[$key][] = $value->StudentID;
            $CheckSub[$key][] = $value->StudentNumber;
            $CheckSub[$key][] = $value->StudentPrefix.$value->StudentFirstName.' '.$value->StudentLastName;
            $CheckSub[$key][] = $value->StudentCode;


            $check_sub = array();
            $da = $this->CheckData($Term,$year,$Class,$Room,$value->StudentID);
                foreach ($da as $key22 => $v_da) {
                    $check_sub[] = $v_da->SubjectID;
                }
               // echo '<pre>'; print_r($check_sub);

             foreach ($data['RegisSubject'] as $key1 => $v_Check) {
               // echo array_search($v_Check->SubjectCode, $check_sub);
                if(in_array($v_Check->SubjectID, $check_sub)){
                    $dat = $this->CheckValue($Term,$year,$Class,$Room,$value->StudentID,$v_Check->SubjectID);
                   
                    $CheckSub[$key][] = $v_Check->SubjectID.'/'.(!empty($dat[0]->Score100) ? $dat[0]->Score100 : '' );
                }else{
                    $CheckSub[$key][] = $v_Check->SubjectID.'/';
                }
               
            }
           
        }

        $data['CheckSub'] = $CheckSub;
       //echo '<pre>'; print_r($data['CheckSub']);  exit();
        
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['Term'] = $Term;
        $data['Year'] = $year;
        
        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportScoreRoomMain');
        
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
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();
        $data['SelYear'] = $this->DBadmission->table('tb_recruitstudent')->select('recruit_year')->groupBy('recruit_year')->get()->getResult();
        $data['CheckYearadmission'] = $this->DBadmission->table('tb_openyear')->select('openyear_year')->get()->getRow();

        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportEnrollMain');
        
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
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getRow();

        $CkeckIDEN = $this->DBadmission->table('tb_recruitstudent')->select('recruit_idCard,recruit_regLevel,recruit_img')->where('recruit_id',$IDStu)->get()->getRow();
        $data['recruit_regLevel'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_regLevel : null;
        $data['recruit_img'] =  !empty($CkeckIDEN) ? $CkeckIDEN->recruit_img : null;
        $data['DataStudent'] = !empty($CkeckIDEN->recruit_idCard) ? $this->DBpersonnel->table('tb_students')->where('stu_iden',$CkeckIDEN->recruit_idCard)->get()->getRow() : null;

        //echo '<pre>'; print_r($data['DataStudent']); exit();
        echo view('admin/layout/main',$data);
        echo view('admin/Academic/AdminReportResults/AdminReportEnrollDetailStudent');
        
    }
}
