<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Admin\Academic\ModAdminTeachingSchedule;

class ConAdminTeachingSchedule extends BaseController
{
    protected $model;
    protected $db;

    public function __construct()
    {
        $this->model = new ModAdminTeachingSchedule();
        $this->db    = \Config\Database::connect();
        helper(['url', 'form', 'year']);

        // ตรวจสอบสิทธิ์ Admin (ถ้ามี Session)
        if (empty(session()->get('fullname'))) {
            // ถ้าเป็น AJAX ให้ตอบ JSON 401
            if (service('request')->isAJAX()) {
                response()->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Session expired'])->send();
                exit();
            }
        }
    }

    /**
     * หน้าแรก: ภาพรวมกลุ่มสาระการเรียนรู้ทั้งหมด (Dashboard 9 กลุ่มสาระ)
     */
    public function index()
    {
        $yearTermParam = $this->request->getGet('year_term');
        $parsed = parse_selected_year($yearTermParam);
        $term   = $parsed['term'];
        $year   = $parsed['year'];
        $selectedYearTerm = "{$term}/{$year}";

        // ดึงรายการปี/เทอมทั้งหมดในระบบ
        $yearTerms = $this->model->getDistinctYearTerms();

        // ตรวจสอบว่าปีที่เลือกมีอยู่ในรายการหรือไม่ ถ้าไม่มีให้เพิ่มเข้าไปด้านบน
        $exists = false;
        foreach ($yearTerms as $yt) {
            if ($yt['label'] === $selectedYearTerm) {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            array_unshift($yearTerms, [
                'year'  => $year,
                'term'  => $term,
                'label' => $selectedYearTerm
            ]);
        }

        // ดึงข้อมูลกลุ่มสาระและสถิติ
        $statsData = $this->model->getLearningGroupsWithStats($year, $term);

        $data = [
            'title'            => 'ตรวจสอบการจัดตารางสอนกลุ่มสาระ',
            'groups'           => $statsData['groups'],
            'summary'          => $statsData['summary'],
            'yearTerms'        => $yearTerms,
            'selectedYear'     => $year,
            'selectedTerm'     => $term,
            'selectedYearTerm' => $selectedYearTerm,
            'SchoolYear'       => $this->db->table('tb_schoolyear')->get()->getRow()
        ];

        return view('admin/Academic/AdminTeachingSchedule/AdminTeachingScheduleMain', $data);
    }

    /**
     * หน้ารายละเอียดกลุ่มสาระ: รายชื่อครูและสรุปภาระงาน
     */
    public function groupDetail($groupId)
    {
        $yearTermParam = $this->request->getGet('year_term');
        $parsed = parse_selected_year($yearTermParam);
        $term   = $parsed['term'];
        $year   = $parsed['year'];
        $selectedYearTerm = "{$term}/{$year}";

        $groupInfo = $this->model->getGroupInfo($groupId);
        if (!$groupInfo) {
            return redirect()->to(base_url('Admin/Acade/Course/TeachingSchedule'))
                ->with('error', 'ไม่พบข้อมูลกลุ่มสาระการเรียนรู้ที่ระบุ');
        }

        $teachers = $this->model->getTeachersByGroup($groupId, $year, $term);
        $yearTerms = $this->model->getDistinctYearTerms();

        // คำนวณสรุปของกลุ่มสาระ
        $totalTeachers = count($teachers);
        $completedCount = 0;
        $totalHours = 0;
        foreach ($teachers as $t) {
            if ($t->has_data) {
                $completedCount++;
            }
            $totalHours += $t->total_hours;
        }

        $data = [
            'title'            => 'ภาระงานสอน - ' . $groupInfo->lear_namethai,
            'group'            => $groupInfo,
            'teachers'         => $teachers,
            'totalTeachers'    => $totalTeachers,
            'completedCount'   => $completedCount,
            'pendingCount'     => $totalTeachers - $completedCount,
            'progressPercent'  => $totalTeachers > 0 ? round(($completedCount / $totalTeachers) * 100) : 0,
            'totalHours'       => $totalHours,
            'yearTerms'        => $yearTerms,
            'selectedYear'     => $year,
            'selectedTerm'     => $term,
            'selectedYearTerm' => $selectedYearTerm
        ];

        return view('admin/Academic/AdminTeachingSchedule/AdminTeachingScheduleGroup', $data);
    }

    /**
     * API: ดึงรายละเอียดภาระงานสอนรายบุคคล (วิชาสอน + กิจกรรม + หน้าที่พิเศษ)
     */
    public function getTeacherDetailAjax()
    {
        $teacherId = $this->request->getPost('teacher_id') ?: $this->request->getGet('teacher_id');
        $year      = $this->request->getPost('year') ?: $this->request->getGet('year');
        $term      = $this->request->getPost('term') ?: $this->request->getGet('term');

        if (empty($teacherId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุรหัสครู']);
        }

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year   = $year ?: $parsed['year'];
            $term   = $term ?: $parsed['term'];
        }

        $detail = $this->model->getTeacherDetail($teacherId, $year, $term);

        if (!$detail) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลครูที่ระบุ']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $detail
        ]);
    }

    /**
     * พิมพ์ใบรายงานภาระงานสอนของครูรายบุคคล (Print Workload Slip)
     */
    public function printTeacherWorkload($teacherId, $yearParam = null, $termParam = null)
    {
        $yearParam = $yearParam ?: $this->request->getGet('year');
        $termParam = $termParam ?: $this->request->getGet('term');

        if (empty($yearParam) || empty($termParam)) {
            $parsed    = parse_selected_year();
            $yearParam = $yearParam ?: $parsed['year'];
            $termParam = $termParam ?: $parsed['term'];
        }

        $data = $this->model->getIndividualScheduleData($teacherId, $yearParam, $termParam);

        if (!$data) {
            return "ไม่พบข้อมูลภาระงานสอนของครูท่านนี้";
        }

        $teacher = $data['teacher'];
        $teacherName = ($teacher->pers_prefix ?? '') . ($teacher->pers_firstname ?? '') . ' ' . ($teacher->pers_lastname ?? '');
        $data['title'] = 'ข้อมูลการจัดตารางสอนรายบุคคล - ' . $teacherName;
        // เก็บ detail ไว้เผื่อกรณีต้องการใช้แบบเดิม
        $data['detail'] = $data;

        return view('admin/Academic/AdminTeachingSchedule/AdminTeachingSchedulePrint', $data);
    }

    /**
     * พิมพ์รายงานสรุปข้อมูลการจัดตารางสอนทั้งกลุ่มสาระการเรียนรู้ (Print All Group Teaching Schedule)
     */
    public function printGroupWorkload($groupId, $yearParam = null, $termParam = null)
    {
        $yearParam = $yearParam ?: $this->request->getGet('year');
        $termParam = $termParam ?: $this->request->getGet('term');

        if (empty($yearParam) || empty($termParam)) {
            $parsed    = parse_selected_year();
            $yearParam = $yearParam ?: $parsed['year'];
            $termParam = $termParam ?: $parsed['term'];
        }

        $data = $this->model->getGroupSchedulePrintData($groupId, $yearParam, $termParam);

        if (!$data || empty($data['group'])) {
            return "ไม่พบข้อมูลกลุ่มสาระการเรียนรู้";
        }

        $data['title'] = 'ข้อมูลการจัดตารางสอน' . ($data['group_name'] ?? 'กลุ่มสาระการเรียนรู้') . ' ภาคเรียนที่ ' . $termParam . ' ปีการศึกษา ' . $yearParam;

        return view('admin/Academic/AdminTeachingSchedule/AdminTeachingSchedulePrintAll', $data);
    }

    /**
     * AJAX: ดึงข้อมูลดิบทั้งหมดของครูเพื่อใช้ใน Modal แก้ไขตารางสอน
     */
    public function getTeacherRawDataAjax()
    {
        $teacherId = $this->request->getPost('teacher_id') ?: $this->request->getGet('teacher_id');
        $year      = $this->request->getPost('year') ?: $this->request->getGet('year');
        $term      = $this->request->getPost('term') ?: $this->request->getGet('term');

        if (empty($teacherId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุรหัสครู']);
        }

        if (empty($year) || empty($term)) {
            $parsed = parse_selected_year();
            $year   = $year ?: $parsed['year'];
            $term   = $term ?: $parsed['term'];
        }

        $data = $this->model->getTeacherRawData($teacherId, $year, $term);
        if (!$data) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลครู']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    /**
     * AJAX: บันทึก/อัปเดต รายวิชาสอน (tb_teaching_schedule)
     */
    public function saveScheduleItemAjax()
    {
        $scheduleId    = $this->request->getPost('schedule_id');
        $teacherId     = trim($this->request->getPost('teacher_id') ?? '');
        $year          = trim($this->request->getPost('year') ?? '');
        $term          = trim($this->request->getPost('term') ?? '');
        $subjectCode   = trim($this->request->getPost('subject_code') ?? '');
        $subjectName   = trim($this->request->getPost('subject_name') ?? '');
        $subjectType   = trim($this->request->getPost('subject_type') ?? 'พื้นฐาน');
        $gradeLevel    = trim($this->request->getPost('grade_level') ?? '');
        $room          = trim($this->request->getPost('room') ?? '');
        $credit        = (float)($this->request->getPost('credit') ?? 0);
        $hoursPerWeek  = (int)($this->request->getPost('hours_per_week') ?? 0);
        $totalHours    = (int)($this->request->getPost('total_hours') ?? 0);
        $studyPlan     = trim($this->request->getPost('study_plan') ?? '');
        $remark        = trim($this->request->getPost('remark') ?? '');

        if (empty($teacherId) || empty($year) || empty($term)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลครูหรือปีการศึกษาไม่ถูกต้อง']);
        }

        if (empty($subjectCode) || empty($subjectName)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกรหัสวิชาและชื่อวิชา']);
        }

        if ($totalHours <= 0 && $hoursPerWeek > 0) {
            $totalHours = $hoursPerWeek * 20; // ค่าเริ่มต้น 20 สัปดาห์ต่อภาคเรียน
        }

        $saveData = [
            'schedule_id'    => $scheduleId ? (int)$scheduleId : null,
            'teacher_id'     => $teacherId,
            'year'           => $year,
            'term'           => $term,
            'subject_code'   => $subjectCode,
            'subject_name'   => $subjectName,
            'subject_type'   => $subjectType,
            'grade_level'    => $gradeLevel,
            'room'           => $room,
            'credit'         => $credit,
            'hours_per_week' => $hoursPerWeek,
            'total_hours'    => $totalHours,
            'study_plan'     => $studyPlan,
            'remark'         => $remark
        ];

        try {
            $newId = $this->model->saveTeachingScheduleItem($saveData);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $scheduleId ? 'บันทึกการแก้ไขรายวิชาเรียบร้อยแล้ว' : 'เพิ่มรายวิชาเรียบร้อยแล้ว',
                'id'      => $newId
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: ลบรายวิชาสอน (tb_teaching_schedule)
     */
    public function deleteScheduleItemAjax()
    {
        $scheduleId = (int)$this->request->getPost('schedule_id');
        if (empty($scheduleId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรหัสรายวิชาที่ต้องการลบ']);
        }

        try {
            $this->model->deleteTeachingScheduleItem($scheduleId);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'ลบรายวิชาเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เกิดข้อผิดพลาดในการลบ: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: บันทึก/อัปเดต กิจกรรมพัฒนาผู้เรียน (tb_teaching_schedule_activity)
     */
    public function saveActivityItemAjax()
    {
        $activityId   = $this->request->getPost('activity_id');
        $teacherId    = trim($this->request->getPost('teacher_id') ?? '');
        $year         = trim($this->request->getPost('year') ?? '');
        $term         = trim($this->request->getPost('term') ?? '');
        $activityName = trim($this->request->getPost('activity_name') ?? '');
        $gradeLevel   = trim($this->request->getPost('grade_level') ?? '');
        $room         = trim($this->request->getPost('room') ?? '');
        $hoursPerWeek = (int)($this->request->getPost('hours_per_week') ?? 0);
        $totalHours   = (int)($this->request->getPost('total_hours') ?? 0);
        $remark       = trim($this->request->getPost('remark') ?? '');

        if (empty($teacherId) || empty($activityName)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกชื่อกิจกรรม']);
        }

        if ($totalHours <= 0 && $hoursPerWeek > 0) {
            $totalHours = $hoursPerWeek * 20;
        }

        $saveData = [
            'activity_id'    => $activityId ? (int)$activityId : null,
            'teacher_id'     => $teacherId,
            'year'           => $year,
            'term'           => $term,
            'activity_name'  => $activityName,
            'grade_level'    => $gradeLevel,
            'room'           => $room,
            'hours_per_week' => $hoursPerWeek,
            'total_hours'    => $totalHours,
            'remark'         => $remark
        ];

        try {
            $newId = $this->model->saveActivityItem($saveData);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $activityId ? 'บันทึกการแก้ไขกิจกรรมเรียบร้อยแล้ว' : 'เพิ่มกิจกรรมเรียบร้อยแล้ว',
                'id'      => $newId
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * AJAX: ลบกิจกรรมพัฒนาผู้เรียน (tb_teaching_schedule_activity)
     */
    public function deleteActivityItemAjax()
    {
        $activityId = (int)$this->request->getPost('activity_id');
        if (empty($activityId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรหัสกิจกรรมที่ต้องการลบ']);
        }

        try {
            $this->model->deleteActivityItem($activityId);
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบกิจกรรมเรียบร้อยแล้ว']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * AJAX: บันทึก/อัปเดต หน้าที่พิเศษ (tb_teaching_schedule_duty)
     */
    public function saveDutyItemAjax()
    {
        $dutyId    = $this->request->getPost('duty_id');
        $teacherId = trim($this->request->getPost('teacher_id') ?? '');
        $year      = trim($this->request->getPost('year') ?? '');
        $term      = trim($this->request->getPost('term') ?? '');
        $dutyName  = trim($this->request->getPost('duty_name') ?? '');
        $dutyOrder = (int)($this->request->getPost('duty_order') ?? 1);

        if (empty($teacherId) || empty($dutyName)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกชื่อหน้าที่พิเศษ']);
        }

        $saveData = [
            'duty_id'    => $dutyId ? (int)$dutyId : null,
            'teacher_id' => $teacherId,
            'year'       => $year,
            'term'       => $term,
            'duty_name'  => $dutyName,
            'duty_order' => $dutyOrder
        ];

        try {
            $newId = $this->model->saveDutyItem($saveData);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $dutyId ? 'บันทึกการแก้ไขหน้าที่พิเศษเรียบร้อยแล้ว' : 'เพิ่มหน้าที่พิเศษเรียบร้อยแล้ว',
                'id'      => $newId
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * AJAX: ลบหน้าที่พิเศษ (tb_teaching_schedule_duty)
     */
    public function deleteDutyItemAjax()
    {
        $dutyId = (int)$this->request->getPost('duty_id');
        if (empty($dutyId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบรหัสหน้าที่พิเศษที่ต้องการลบ']);
        }

        try {
            $this->model->deleteDutyItem($dutyId);
            return $this->response->setJSON(['status' => 'success', 'message' => 'ลบหน้าที่พิเศษเรียบร้อยแล้ว']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * AJAX: ค้นหารายวิชาจาก tb_subjects เพื่ออำนวยความสะดวกในการกรอก
     */
    public function searchMasterSubjectsAjax()
    {
        $q = trim($this->request->getGet('q') ?? '');
        if (empty($q)) {
            return $this->response->setJSON([]);
        }

        $builder = $this->db->table('tb_subjects');
        $builder->select('SubjectCode, SubjectName, SubjectUnit, SubjectHour, SubjectType, SubjectClass')
            ->groupStart()
                ->like('SubjectCode', $q)
                ->orLike('SubjectName', $q)
            ->groupEnd()
            ->groupBy('SubjectCode')
            ->limit(15);

        $results = $builder->get()->getResult();

        return $this->response->setJSON($results);
    }
}


