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
}

