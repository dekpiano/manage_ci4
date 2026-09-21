<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\ModAdminRegisterSubject;

class ConAdminRegisterSubject extends BaseController
{
    protected $modAdminRegisterSubject;
    protected $DBpersonnel;
    protected $db;

    public function __construct()
    {
        $this->modAdminRegisterSubject = new ModAdminRegisterSubject();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            redirect()->to(base_url('LogoutTeacher'))->send();
            exit;
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            redirect()->to(base_url('welcome'))->send();
            exit;
        }
    }

    /**
     * ตรวจสอบว่าระบบจัดการวิชาเรียนเปิดใช้งานอยู่หรือไม่
     */
    protected function isRegisterSubjectOpen()
    {
        $statusRow = $this->db->table('tb_register_onoff')
            ->select('onoff_status')
            ->where('onoff_id', 16)
            ->orWhere('onoff_name', 'จัดการวิชาเรียน')
            ->get()
            ->getRow();

        return !empty($statusRow) && ($statusRow->onoff_status === 'on' || $statusRow->onoff_status === 'true');
    }

    public function update_row($RegisterYear,$SubjectCode, $data) {
        // อัปเดตข้อมูลของแถวเดียวโดยใช้ ID เป็นเงื่อนไข
        $this->db->table('tb_register')->where('RegisterYear', $RegisterYear);
        $this->db->table('tb_register')->where('SubjectCode', $SubjectCode);
        $this->db->table('tb_register')->update($data);
    }

    public function update_data_with_foreach() {
        

        // เริ่มต้น transaction
        $this->db->transStart();


        $da = $this->db->table('tb_subjects')->select('SubjectYear,SubjectCode,SubjectID')->get()->getResult();
        // เตรียมข้อมูลตัวอย่าง
        $data = [];
        // Assuming 1501-1793 is a hardcoded range from CI3. In CI4, this might need dynamic fetching or re-evaluation.
        // For now, retaining the hardcoded loop for migration consistency.
        for ($i = 0; $i < count($da); $i++) { // Adjusted loop to iterate through $da array
            if(isset($da[$i])){
                $data[] = [
                    'SubjectID' => !empty($da[$i]->SubjectID) ? $da[$i]->SubjectID : null,
                    'SubjectCode' => !empty($da[$i]->SubjectCode) ? $da[$i]->SubjectCode : null,
                    'SubjectYear' => !empty($da[$i]->SubjectYear) ? $da[$i]->SubjectYear : null
                ];
            }
        }

        //echo '<pre>';print_r($data);exit();
        // ใช้ foreach อัปเดตข้อมูลทีละแถว
        foreach ($data as $row) {
            //echo '<pre>';print_r($row);
            if (!empty($row['SubjectYear']) && !empty($row['SubjectCode']) && !empty($row['SubjectID'])) {
                $this->update_row($row['SubjectYear'], $row['SubjectCode'],['SubjectCode' => $row['SubjectID']]);
            }
        }
        //exit();
        
        // สรุป transaction (commit หรือ rollback)
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            // กรณีอัปเดตล้มเหลว
            echo "Error updating data";
        } else {
            // กรณีอัปเดตสำเร็จ
            echo "Data updated successfully";
        }
    }

    public function AdminRegisterSubjectSelect(){ 
      
        $data = [];
        $keyYear = $this->request->getPost('keyYear');
        $subject = [];

        $builder = $this->db->table('tb_subjects');
        // เรียงตามปีการศึกษา (หลัง /) และ เทอม (หน้า /) ให้ถูกต้องตามลำดับเวลา โดยปิด escape เพื่อให้ใช้ฟังก์ชัน SQL ได้
        $builder->orderBy("SUBSTRING_INDEX(SubjectYear, '/', -1) DESC, SUBSTRING_INDEX(SubjectYear, '/', 1) DESC", '', false);

        if(!empty($keyYear)){
            $subject = $builder->where('SubjectYear',$keyYear)->get()->getResult();
        }else{
            $currentYear = get_selected_year();
            $subject = $builder->where('SubjectYear', !empty($currentYear) ? $currentYear : null)->get()->getResult();
        }

       
        foreach($subject as $record){
            $data[] = array( 
                "SubjectYear" => !empty($record->SubjectYear) ? $record->SubjectYear : null,
                "SubjectCode" => !empty($record->SubjectCode) ? $record->SubjectCode : null,
                "SubjectName" => !empty($record->SubjectName) ? $record->SubjectName : null,
                "SubjectType" => !empty($record->SubjectType) ? $record->SubjectType : null,
                "FirstGroup" => !empty($record->FirstGroup) ? $record->FirstGroup : null,
                "SubjectClass" => !empty($record->SubjectClass) ? $record->SubjectClass : null,
                "SubjectUnit" => !empty($record->SubjectUnit) ? $record->SubjectUnit : null,
                "SubjectHour" => !empty($record->SubjectHour) ? $record->SubjectHour : null,
                "SubjectID" => !empty($record->SubjectID) ? $record->SubjectID : null,
                "keyYear" => $this->request->getPost('keyYear')
            );

        }
        $output = array(
            "data" =>  $data           
        );
        echo json_encode($output);
    }

    public function AdminRegisterSubjectInsert(){ 
        $subjectCode = $this->request->getPost('SubjectCode');
        $subjectYear = $this->request->getPost('SubjectYear');

        $check_subject = $this->db->table('tb_subjects')
                ->where('SubjectCode',!empty($subjectCode) ? $subjectCode : null)
                ->where('SubjectYear',!empty($subjectYear) ? $subjectYear : null)
                ->countAllResults();

        if($check_subject > 0){
            echo 0 ;

        }else{
            $data = array('SubjectCode' => $this->request->getPost('SubjectCode'),
            'SubjectName' => $this->request->getPost('SubjectName'),
            'SubjectUnit' => $this->request->getPost('SubjectUnit'),
            'SubjectHour' => $this->request->getPost('SubjectHour'),
            'SubjectType' => $this->request->getPost('SubjectType'),
            'FirstGroup' => $this->request->getPost('FirstGroup'),
            'SecondGroup' => $this->request->getPost('SecondGroup'), 
            'SubjectClass' => $this->request->getPost('SubjectClass'),
            'SubjectYear' => $this->request->getPost('SubjectYear'));  
             echo $this->modAdminRegisterSubject->ModSubjectInsert($data);

        }
    }

    public function AdminRegisterSubjectBulkInsert()
    {
        $subjects = $this->request->getPost('subjects');
        $year = $this->request->getPost('year');

        if (empty($subjects) || !is_array($subjects)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลวิชาที่เลือก']);
        }

        $successCount = 0;
        $skipCount = 0;

        foreach ($subjects as $sub) {
            $check = $this->db->table('tb_subjects')
                ->where('SubjectCode', $sub['SubjectCode'])
                ->where('SubjectYear', $year)
                ->countAllResults();

            if ($check > 0) {
                $skipCount++;
                continue;
            }

            $data = [
                'SubjectCode' => $sub['SubjectCode'],
                'SubjectName' => $sub['SubjectName'],
                'SubjectUnit' => $sub['SubjectUnit'],
                'SubjectHour' => $sub['SubjectHour'],
                'SubjectType' => $sub['SubjectType'],
                'FirstGroup' => $sub['FirstGroup'],
                'SecondGroup' => $sub['SecondGroup'],
                'SubjectClass' => $sub['SubjectClass'],
                'SubjectYear' => $year
            ];

            if ($this->db->table('tb_subjects')->insert($data)) {
                $successCount++;
            }
        }

        if ($successCount > 0) {
            $msg = "บันทึกวิชาเรียนสำเร็จ $successCount รายการ";
            if ($skipCount > 0) $msg .= " (ข้าม $skipCount รายการที่ซ้ำ)";
            return $this->response->setJSON(['status' => 'success', 'message' => $msg]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'วิชาที่เลือกทั้งหมดมีอยู่ในระบบแล้วในเทอมนี้']);
        }
    }

    public function AdminRegisterSubjectUpdate(){      
        $data = array(
            'SubjectCode' => trim($this->request->getPost('Up_SubjectCode') ?? ''),
            'SubjectName' => trim($this->request->getPost('Up_SubjectName') ?? ''),
            'SubjectUnit' => $this->request->getPost('Up_SubjectUnit'),
            'SubjectHour' => $this->request->getPost('Up_SubjectHour'),
            'SubjectType' => $this->request->getPost('Up_SubjectType'),
            'FirstGroup' => $this->request->getPost('Up_FirstGroup'),
            'SecondGroup' => $this->request->getPost('Up_SecondGroup'), 
            'SubjectClass' => $this->request->getPost('Up_SubjectClass'),
            'SubjectYear' => trim($this->request->getPost('Up_SubjectYear') ?? '')
        );  
        $key = (int)$this->request->getPost('Up_SubjectID');
        $result = $this->modAdminRegisterSubject->ModSubjectUpdate($data, $key);

        // ซิงค์ข้อมูลการเปลี่ยนแปลงไปยัง tb_teaching_schedule โดยตรงทันที
        try {
            if ($this->db->tableExists('tb_teaching_schedule')) {
                $updateScheduleData = [
                    'subject_code' => $data['SubjectCode'],
                    'subject_name' => $data['SubjectName'],
                    'subject_type' => $data['SubjectType'],
                    'credit'       => (float)$data['SubjectUnit'],
                    'total_hours'  => (int)$data['SubjectHour'],
                ];

                // 1. อัปเดตรายการที่ผูก subject_id ตรงกับวิชานี้
                if ($this->db->fieldExists('subject_id', 'tb_teaching_schedule') && $key > 0) {
                    $this->db->table('tb_teaching_schedule')
                        ->where('subject_id', $key)
                        ->update($updateScheduleData);
                }

                // 2. อัปเดตรายการที่มีรหัสวิชาและปีการศึกษาตรงกัน
                if (!empty($data['SubjectCode'])) {
                    $termYear = $data['SubjectYear'] ?? '';
                    $parts = explode('/', $termYear);
                    $schBuilder = $this->db->table('tb_teaching_schedule')
                        ->where('subject_code', $data['SubjectCode']);
                    if (count($parts) === 2) {
                        $schBuilder->where('term', trim($parts[0]))
                                   ->where('year', trim($parts[1]));
                    }
                    $schUpdate = $updateScheduleData;
                    if ($this->db->fieldExists('subject_id', 'tb_teaching_schedule') && $key > 0) {
                        $schUpdate['subject_id'] = $key;
                    }
                    $schBuilder->update($schUpdate);
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'Auto sync subject to teaching schedule error: ' . $e->getMessage());
        }

        echo $result;
    }

    public function AdminRegisterSubjectEdit(){ 
       echo json_encode($this->modAdminRegisterSubject->ModSubjectEdit($this->request->getPost('KeySubj'))); 
    }

    public function AdminRegisterSubjectDelete($id){ 
        echo $this->modAdminRegisterSubject->ModSubjectDelete($id); 
    }

    public function AdminRegisterSubjectMain(){   
        $data['admin'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['GroupYear'] = $this->db->table('tb_subjects')
                                ->select('SubjectYear')
                                ->groupBy('SubjectYear')
                                ->orderBy("SUBSTRING_INDEX(SubjectYear, '/', -1) DESC, SUBSTRING_INDEX(SubjectYear, '/', 1) DESC", '', false)
                                ->get()->getResult();

        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        
        // ใช้ปีการศึกษาจากระบบกลาง (Session) เป็นค่าเริ่มต้น
        $data['selectedYear'] = get_selected_year();
        $data['title'] = "วิชาเรียน";	
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['onoff_register_subject'] = $this->db->table('tb_register_onoff')
                                            ->where('onoff_id', 16)
                                            ->orWhere('onoff_name', 'จัดการวิชาเรียน')
                                            ->get()->getRow();
        $data['classroom'] = new \App\Libraries\Classroom();
        echo view('admin/Academic/AdminRegisterSubject/AdminRegisterSubjectMain', $data);
    }

    /**
     * สลับสถานะ เปิด - ปิด ระบบจัดการวิชาเรียน (tb_register_onoff)
     */
    public function CheckOnOffRegisterSubject()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $check = $this->request->getPost('check');
        $status = ($check === 'true' || $check === true || $check === 'on') ? 'on' : 'off';

        $exists = $this->db->table('tb_register_onoff')
            ->where('onoff_id', 16)
            ->orWhere('onoff_name', 'จัดการวิชาเรียน')
            ->get()->getRow();

        if ($exists) {
            $this->db->table('tb_register_onoff')
                ->where('onoff_id', $exists->onoff_id)
                ->update([
                    'onoff_status' => $status,
                    'onoff_StartDate' => date('Y-m-d H:i:s')
                ]);
        } else {
            $this->db->table('tb_register_onoff')->insert([
                'onoff_id' => 16,
                'onoff_name' => 'จัดการวิชาเรียน',
                'onoff_status' => $status,
                'onoff_year' => '1/' . (date('Y') + 543),
                'onoff_Level' => '',
                'onoff_detail' => 'งานหลักสูตร',
                'onoff_StartDate' => date('Y-m-d H:i:s'),
                'onoff_EndDate' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'new_status' => $status,
            'message' => $status === 'on' ? 'เปิดระบบจัดการวิชาเรียนเรียบร้อย' : 'ปิดระบบจัดการวิชาเรียนเรียบร้อย'
        ]);
    }

    /**
     * บันทึกการตั้งค่าปีการศึกษาของระบบจัดการวิชาเรียน (tb_register_onoff)
     */
    public function SaveSettingRegisterSubjectYear()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $term = trim($this->request->getPost('setting_term') ?? '');
        $year = trim($this->request->getPost('setting_year') ?? '');
        $onoffYear = $term . '/' . $year;

        if (empty($term) || empty($year)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุภาคเรียนและปีการศึกษาให้ครบถ้วน']);
        }

        $exists = $this->db->table('tb_register_onoff')
            ->where('onoff_id', 16)
            ->orWhere('onoff_name', 'จัดการวิชาเรียน')
            ->get()->getRow();

        if ($exists) {
            $this->db->table('tb_register_onoff')
                ->where('onoff_id', $exists->onoff_id)
                ->update([
                    'onoff_year' => $onoffYear,
                    'onoff_StartDate' => date('Y-m-d H:i:s')
                ]);
        } else {
            $this->db->table('tb_register_onoff')->insert([
                'onoff_id' => 16,
                'onoff_name' => 'จัดการวิชาเรียน',
                'onoff_status' => 'off',
                'onoff_year' => $onoffYear,
                'onoff_Level' => '',
                'onoff_detail' => 'งานหลักสูตร',
                'onoff_StartDate' => date('Y-m-d H:i:s'),
                'onoff_EndDate' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'new_year' => $onoffYear,
            'message' => "บันทึกตั้งค่าปีการศึกษาสำหรับระบบครูเป็น {$onoffYear} เรียบร้อยแล้ว"
        ]);
    }


    public function AdminRegisterSubjectGetMaster()
    {
        $class = $this->request->getGet('class') ?: $this->request->getPost('class');
        $builder = $this->db->table('tb_subjects_master');
        
        if (!empty($class)) {
            $builder->where('subject_class', $class);
        }

        $records = $builder->orderBy('subject_class', 'ASC')
                           ->orderBy('subject_code', 'ASC')
                           ->get()
                           ->getResult();

        $data = [];
        foreach ($records as $sub) {
            $data[] = [
                'code'        => $sub->subject_code,
                'name'        => $sub->subject_name,
                'unit'        => $sub->subject_unit,
                'hour'        => $sub->subject_hour,
                'type'        => $sub->subject_type,
                'firstGroup'  => $sub->first_group,
                'secondGroup' => $sub->second_group,
                'class'       => $sub->subject_class,
                'searchString'=> strtolower($sub->subject_code . ' ' . $sub->subject_name . ' ' . ($sub->first_group ?? '') . ' ' . ($sub->subject_class ?? ''))
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data,
            'total'  => count($data)
        ]);
    }

    /**
     * เปรียบเทียบรายวิชาระหว่างปีการศึกษาต้นทางและเป้าหมาย
     */
    public function AdminRegisterSubjectCompareYears()
    {
        $sourceYear  = $this->request->getPost('source_year');
        $targetYear  = $this->request->getPost('target_year');
        $classFilter = $this->request->getPost('class_filter');
        $groupFilter = $this->request->getPost('group_filter');

        if (empty($sourceYear) || empty($targetYear)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'กรุณาระบุปีการศึกษาต้นทางและเป้าหมาย'
            ]);
        }

        // 1. ดึงรายวิชาที่มีอยู่ในปีเป้าหมาย (Target Year)
        $targetSubjects = $this->db->table('tb_subjects')
            ->select('SubjectCode, SubjectClass')
            ->where('SubjectYear', $targetYear)
            ->get()
            ->getResult();

        $targetMap = [];
        foreach ($targetSubjects as $ts) {
            $key = trim($ts->SubjectCode) . '_' . trim($ts->SubjectClass);
            $targetMap[$key] = true;
        }

        // 2. ดึงรายวิชาจากปีต้นทาง (Source Year)
        $builder = $this->db->table('tb_subjects')->where('SubjectYear', $sourceYear);
        if (!empty($classFilter)) {
            $builder->where('SubjectClass', $classFilter);
        }
        if (!empty($groupFilter)) {
            $builder->where('FirstGroup', $groupFilter);
        }

        $sourceSubjects = $builder->orderBy('SubjectClass', 'ASC')
                                  ->orderBy('SubjectCode', 'ASC')
                                  ->get()
                                  ->getResult();

        $comparisonList  = [];
        $totalSource     = count($sourceSubjects);
        $totalRegistered = 0;
        $totalMissing    = 0;

        foreach ($sourceSubjects as $row) {
            $key = trim($row->SubjectCode) . '_' . trim($row->SubjectClass);
            $isRegistered = isset($targetMap[$key]);

            if ($isRegistered) {
                $totalRegistered++;
            } else {
                $totalMissing++;
            }

            $comparisonList[] = [
                'SubjectID'    => $row->SubjectID,
                'SubjectCode'  => $row->SubjectCode,
                'SubjectName'  => $row->SubjectName,
                'SubjectClass' => $row->SubjectClass,
                'SubjectUnit'  => $row->SubjectUnit,
                'SubjectHour'  => $row->SubjectHour,
                'SubjectType'  => $row->SubjectType,
                'FirstGroup'   => $row->FirstGroup,
                'SecondGroup'  => $row->SecondGroup,
                'is_registered'=> $isRegistered,
                'searchString' => strtolower($row->SubjectCode . ' ' . $row->SubjectName . ' ' . ($row->FirstGroup ?? '') . ' ' . ($row->SubjectClass ?? ''))
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $comparisonList,
            'stats'  => [
                'total'      => $totalSource,
                'registered' => $totalRegistered,
                'missing'    => $totalMissing
            ]
        ]);
    }

    /**
     * คัดลอกรายวิชาที่เลือกจากปีต้นทางเข้าสู่ปีเป้าหมาย
     */
    public function AdminRegisterSubjectCopyFromYear()
    {
        $sourceYear = $this->request->getPost('source_year');
        $targetYear = $this->request->getPost('target_year');
        $subjectIds = $this->request->getPost('subject_ids');

        if (empty($sourceYear) || empty($targetYear)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลปีการศึกษาไม่ถูกต้อง']);
        }

        if (empty($subjectIds) || !is_array($subjectIds)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาเลือกวิชาที่ต้องการคัดลอกอย่างน้อย 1 วิชา']);
        }

        $subjectsToCopy = $this->db->table('tb_subjects')
            ->where('SubjectYear', $sourceYear)
            ->whereIn('SubjectID', $subjectIds)
            ->get()
            ->getResult();

        if (empty($subjectsToCopy)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลวิชาที่เลือก']);
        }

        $insertedCount = 0;
        $skippedCount  = 0;

        $this->db->transStart();

        foreach ($subjectsToCopy as $sub) {
            $exists = $this->db->table('tb_subjects')
                ->where('SubjectCode', $sub->SubjectCode)
                ->where('SubjectClass', $sub->SubjectClass)
                ->where('SubjectYear', $targetYear)
                ->countAllResults();

            if ($exists > 0) {
                $skippedCount++;
                continue;
            }

            $insertData = [
                'SubjectCode'  => $sub->SubjectCode,
                'SubjectName'  => $sub->SubjectName,
                'SubjectUnit'  => $sub->SubjectUnit,
                'SubjectHour'  => $sub->SubjectHour,
                'SubjectType'  => $sub->SubjectType,
                'FirstGroup'   => $sub->FirstGroup,
                'SecondGroup'  => $sub->SecondGroup,
                'SubjectClass' => $sub->SubjectClass,
                'SubjectYear'  => $targetYear
            ];

            if ($this->db->table('tb_subjects')->insert($insertData)) {
                $insertedCount++;
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }

        $msg = "คัดลอกวิชาเข้าสู่ปีการศึกษา {$targetYear} สำเร็จ {$insertedCount} รายการ";
        if ($skippedCount > 0) {
            $msg .= " (ข้าม {$skippedCount} รายการที่มีอยู่แล้ว)";
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => $msg,
            'inserted' => $insertedCount,
            'skipped'  => $skippedCount
        ]);
    }

    /**
     * ดึงรหัสวิชาที่เปิดสอนในเทอม/ปีที่ระบุ (สำหรับ Auto-Select ใน Modal)
     */
    public function AdminRegisterSubjectGetCodesByYear()
    {
        $year  = $this->request->getPost('year') ?: $this->request->getGet('year');
        $class = $this->request->getPost('class') ?: $this->request->getGet('class');

        if (empty($year)) {
            return $this->response->setJSON(['status' => 'error', 'codes' => []]);
        }

        $builder = $this->db->table('tb_subjects')
            ->select('SubjectCode, SubjectClass')
            ->where('SubjectYear', $year);

        if (!empty($class)) {
            $builder->where('SubjectClass', $class);
        }

        $records = $builder->get()->getResult();
        $codes = [];
        foreach ($records as $r) {
            $codes[] = [
                'code'  => $r->SubjectCode,
                'class' => $r->SubjectClass
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'codes'  => $codes,
            'total'  => count($codes)
        ]);
    }
}

