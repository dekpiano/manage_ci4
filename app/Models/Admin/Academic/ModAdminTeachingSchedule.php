<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminTeachingSchedule extends Model
{
    protected $dbAcademic;
    protected $dbPersonnel;
    protected $dbSkj;

    public function __construct()
    {
        parent::__construct();
        $this->dbAcademic  = \Config\Database::connect();
        $this->dbPersonnel = \Config\Database::connect('personnel');
        $this->dbSkj       = \Config\Database::connect('skj');
    }

    /**
     * ดึงรายการปีการศึกษาและภาคเรียนที่มีข้อมูลในระบบ
     */
    public function getDistinctYearTerms()
    {
        $years = [];

        // 1. จาก tb_teaching_schedule
        $res1 = $this->dbAcademic->table('tb_teaching_schedule')
            ->select('year, term')
            ->groupBy('year, term')
            ->get()
            ->getResult();

        foreach ($res1 as $r) {
            if (!empty($r->year) && !empty($r->term)) {
                $key = "{$r->term}/{$r->year}";
                $years[$key] = ['year' => $r->year, 'term' => $r->term, 'label' => $key];
            }
        }

        // 2. จาก tb_teaching_schedule_activity
        $res2 = $this->dbAcademic->table('tb_teaching_schedule_activity')
            ->select('year, term')
            ->groupBy('year, term')
            ->get()
            ->getResult();

        foreach ($res2 as $r) {
            if (!empty($r->year) && !empty($r->term)) {
                $key = "{$r->term}/{$r->year}";
                $years[$key] = ['year' => $r->year, 'term' => $r->term, 'label' => $key];
            }
        }

        // เรียงตามปีและเทอมล่าสุด
        uasort($years, function ($a, $b) {
            if ($a['year'] == $b['year']) {
                return $b['term'] <=> $a['term'];
            }
            return $b['year'] <=> $a['year'];
        });

        return array_values($years);
    }

    /**
     * ดึงข้อมูลกลุ่มสาระฯ ทั้งหมด พร้อมสถิติจำนวนครูและสถานะการจัดตารางสอน
     */
    public function getLearningGroupsWithStats(string $year, string $term)
    {
        // 1. ดึงกลุ่มสาระทั้งหมดจาก tb_learning
        $learningGroups = $this->dbSkj->table('tb_learning')
            ->select('lear_id, lear_namethai, lear_nameeng, lear_icon')
            ->orderBy('lear_id', 'ASC')
            ->get()
            ->getResult();

        // 2. ดึงครูที่กำลังใช้งานทั้งหมดจาก tb_personnel
        $teachers = $this->dbPersonnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_img, pers_position, pers_academic, pers_learning, pers_groupleade')
            ->where('pers_status', 'กำลังใช้งาน')
            ->get()
            ->getResult();

        // 3. ดึงครูที่มีตารางสอนในเทอมนี้จาก tb_teaching_schedule
        $schedules = $this->dbAcademic->table('tb_teaching_schedule')
            ->select('teacher_id, hours_per_week, total_hours')
            ->where('year', $year)
            ->where('term', $term)
            ->get()
            ->getResult();

        // 4. ดึงครูที่มีกิจกรรมในเทอมนี้จาก tb_teaching_schedule_activity
        $activities = $this->dbAcademic->table('tb_teaching_schedule_activity')
            ->select('teacher_id, hours_per_week, total_hours')
            ->where('year', $year)
            ->where('term', $term)
            ->get()
            ->getResult();

        // รวมยอดชั่วโมงและสถานะต่อครู
        $teacherTeachingHours = [];
        $teacherActivityHours = [];
        $teacherHasSchedule   = [];

        foreach ($schedules as $s) {
            $tid = trim($s->teacher_id);
            $teacherHasSchedule[$tid] = true;
            $teacherTeachingHours[$tid] = ($teacherTeachingHours[$tid] ?? 0) + (float)$s->hours_per_week;
        }

        foreach ($activities as $a) {
            $tid = trim($a->teacher_id);
            $teacherActivityHours[$tid] = ($teacherActivityHours[$tid] ?? 0) + (float)$a->hours_per_week;
        }

        // จัดกลุ่มครูตาม pers_learning
        $teachersByGroup = [];
        $leadersByGroup  = [];

        foreach ($teachers as $t) {
            $gid = trim($t->pers_learning ?? '');
            if (!empty($gid)) {
                $teachersByGroup[$gid][] = $t;
                if (!empty($t->pers_groupleade) && strpos($t->pers_groupleade, 'หัวหน้ากลุ่มสาระ') !== false) {
                    $leadersByGroup[$gid] = $t;
                }
            }
        }

        // ประกอบสถิติของแต่ละกลุ่มสาระ
        $result = [];
        $totalSchoolTeachers  = 0;
        $totalSchoolCompleted = 0;
        $totalSchoolHours     = 0;

        foreach ($learningGroups as $grp) {
            $gid = $grp->lear_id;
            $grpTeachers = $teachersByGroup[$gid] ?? [];
            $teacherCount = count($grpTeachers);
            $completedCount = 0;
            $grpHours = 0;

            foreach ($grpTeachers as $t) {
                $tid = trim($t->pers_id);
                if (!empty($teacherHasSchedule[$tid])) {
                    $completedCount++;
                }
                $grpHours += ($teacherTeachingHours[$tid] ?? 0) + ($teacherActivityHours[$tid] ?? 0);
            }

            $totalSchoolTeachers  += $teacherCount;
            $totalSchoolCompleted += $completedCount;
            $totalSchoolHours     += $grpHours;

            $percent = $teacherCount > 0 ? round(($completedCount / $teacherCount) * 100) : 0;
            $leader = $leadersByGroup[$gid] ?? null;

            $result[] = (object)[
                'lear_id'           => $grp->lear_id,
                'lear_namethai'     => $grp->lear_namethai,
                'lear_nameeng'      => $grp->lear_nameeng,
                'lear_icon'         => $grp->lear_icon,
                'leader'            => $leader,
                'total_teachers'    => $teacherCount,
                'completed_teachers'=> $completedCount,
                'pending_teachers'  => $teacherCount - $completedCount,
                'progress_percent'  => $percent,
                'total_hours'       => $grpHours
            ];
        }

        return [
            'groups' => $result,
            'summary' => [
                'total_teachers'    => $totalSchoolTeachers,
                'completed_teachers'=> $totalSchoolCompleted,
                'pending_teachers'  => $totalSchoolTeachers - $totalSchoolCompleted,
                'progress_percent'  => $totalSchoolTeachers > 0 ? round(($totalSchoolCompleted / $totalSchoolTeachers) * 100) : 0,
                'total_hours'       => $totalSchoolHours
            ]
        ];
    }

    /**
     * ดึงข้อมูลกลุ่มสาระเดียว
     */
    public function getGroupInfo(string $groupId)
    {
        return $this->dbSkj->table('tb_learning')
            ->where('lear_id', $groupId)
            ->get()
            ->getRow();
    }

    /**
     * ดึงรายชื่อครูทุกคนในกลุ่มสาระ พร้อมสรุปภาระงานในเทอมที่กำหนด
     */
    public function getTeachersByGroup(string $groupId, string $year, string $term)
    {
        // ดึงครูในกลุ่มสาระ
        $teachers = $this->dbPersonnel->table('tb_personnel')
            ->select('tb_personnel.pers_id, tb_personnel.pers_prefix, tb_personnel.pers_firstname, tb_personnel.pers_lastname, tb_personnel.pers_img, skjacth_skj.tb_position.posi_name as pers_position, tb_personnel.pers_academic, tb_personnel.pers_learning, tb_personnel.pers_groupleade, tb_personnel.pers_phone')
            ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = tb_personnel.pers_position', 'left')
            ->where('tb_personnel.pers_learning', $groupId)
            ->where('tb_personnel.pers_status', 'กำลังใช้งาน')
            ->orderBy("CASE WHEN tb_personnel.pers_groupleade LIKE '%หัวหน้ากลุ่มสาระ%' THEN 0 ELSE 1 END", 'ASC', false)
            ->orderBy('tb_personnel.pers_firstname', 'ASC')
            ->get()
            ->getResult();

        if (empty($teachers)) {
            return [];
        }

        $teacherIds = array_map(function ($t) {
            return trim($t->pers_id);
        }, $teachers);

        // ดึงรายการตารางสอนของครูในกลุ่มนี้
        $schedules = $this->dbAcademic->table('tb_teaching_schedule')
            ->select('teacher_id, subject_code, credit, hours_per_week, total_hours')
            ->where('year', $year)
            ->where('term', $term)
            ->whereIn('teacher_id', $teacherIds)
            ->get()
            ->getResult();

        // ดึงกิจกรรมของครูในกลุ่มนี้
        $activities = $this->dbAcademic->table('tb_teaching_schedule_activity')
            ->select('teacher_id, hours_per_week, total_hours')
            ->where('year', $year)
            ->where('term', $term)
            ->whereIn('teacher_id', $teacherIds)
            ->get()
            ->getResult();

        // ดึงหน้าที่พิเศษของครูในกลุ่มนี้
        $duties = $this->dbAcademic->table('tb_teaching_schedule_duty')
            ->select('teacher_id')
            ->where('year', $year)
            ->where('term', $term)
            ->whereIn('teacher_id', $teacherIds)
            ->get()
            ->getResult();

        // จัดกลุ่มสรุปผล
        $scheduleStats = [];
        foreach ($schedules as $s) {
            $tid = trim($s->teacher_id);
            if (!isset($scheduleStats[$tid])) {
                $scheduleStats[$tid] = ['subject_codes' => [], 'subjects' => 0, 'credits' => 0, 'hours' => 0];
            }
            $subCode = trim($s->subject_code ?? '');
            if ($subCode !== '' && !in_array($subCode, $scheduleStats[$tid]['subject_codes'])) {
                $scheduleStats[$tid]['subject_codes'][] = $subCode;
                $scheduleStats[$tid]['subjects']++;
            }
            $scheduleStats[$tid]['credits'] += (float)($s->credit ?? 0);
            $scheduleStats[$tid]['hours']   += (float)($s->hours_per_week ?? 0);
        }

        $activityStats = [];
        foreach ($activities as $a) {
            $tid = trim($a->teacher_id);
            if (!isset($activityStats[$tid])) {
                $activityStats[$tid] = ['activities' => 0, 'hours' => 0];
            }
            $activityStats[$tid]['activities']++;
            $activityStats[$tid]['hours'] += (float)($a->hours_per_week ?? 0);
        }

        $dutyStats = [];
        foreach ($duties as $d) {
            $tid = trim($d->teacher_id);
            $dutyStats[$tid] = ($dutyStats[$tid] ?? 0) + 1;
        }

        // ผสานข้อมูล
        $teacherList = [];
        foreach ($teachers as $t) {
            $tid = trim($t->pers_id);
            $subStat = $scheduleStats[$tid] ?? ['subjects' => 0, 'credits' => 0, 'hours' => 0];
            $actStat = $activityStats[$tid] ?? ['activities' => 0, 'hours' => 0];
            $dutyCount = $dutyStats[$tid] ?? 0;

            $totalHours = $subStat['hours'] + $actStat['hours'];
            $hasData = ($subStat['subjects'] > 0 || $actStat['activities'] > 0 || $dutyCount > 0);

            $teacherList[] = (object)[
                'pers_id'         => $t->pers_id,
                'pers_prefix'     => $t->pers_prefix,
                'pers_firstname'  => $t->pers_firstname,
                'pers_lastname'   => $t->pers_lastname,
                'fullname'        => "{$t->pers_prefix}{$t->pers_firstname} {$t->pers_lastname}",
                'pers_img'        => $t->pers_img,
                'pers_position'   => $t->pers_position,
                'pers_academic'   => $t->pers_academic,
                'pers_groupleade' => $t->pers_groupleade,
                'is_leader'       => (!empty($t->pers_groupleade) && strpos($t->pers_groupleade, 'หัวหน้ากลุ่มสาระ') !== false),
                'subject_count'   => $subStat['subjects'],
                'credit_total'    => $subStat['credits'],
                'teaching_hours'  => $subStat['hours'],
                'activity_count'  => $actStat['activities'],
                'activity_hours'  => $actStat['hours'],
                'duty_count'      => $dutyCount,
                'total_hours'     => $totalHours,
                'has_data'        => $hasData
            ];
        }

        return $teacherList;
    }

    /**
     * ดึงรายละเอียดภาระงานสอนเต็มของครูรายบุคคล (วิชาสอน + กิจกรรม + หน้าที่พิเศษ)
     * จัดกลุ่มวิชาตาม subject_code + grade_level (ตรงตามระบบ print view)
     */
    public function getTeacherDetail(string $teacherId, string $year, string $term)
    {
        // 1. ข้อมูลครู
        $teacher = $this->dbPersonnel->table('tb_personnel')
            ->where('pers_id', $teacherId)
            ->get()
            ->getRow();

        if (!$teacher) {
            return null;
        }

        // 2. ข้อมูลกลุ่มสาระ
        $groupInfo = null;
        if (!empty($teacher->pers_learning)) {
            $groupInfo = $this->dbSkj->table('tb_learning')
                ->where('lear_id', $teacher->pers_learning)
                ->get()
                ->getRow();
        }

        // 3. ตารางสอนรายวิชา - ดึง raw แล้วจัดกลุ่มตาม subject_code + grade_level
        $rawSchedules = $this->dbAcademic->table('tb_teaching_schedule')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('grade_level', 'ASC')
            ->orderBy('subject_code', 'ASC')
            ->get()
            ->getResultArray();

        $groupedSubjects = [];
        $totalCredit = 0;
        $totalTeachingHours = 0;

        foreach ($rawSchedules as $sch) {
            $groupKey = trim($sch['subject_code']) . '_' . trim($sch['grade_level']);
            if (!isset($groupedSubjects[$groupKey])) {
                $groupedSubjects[$groupKey] = [
                    'subject_code'   => $sch['subject_code'],
                    'subject_name'   => $sch['subject_name'],
                    'subject_type'   => $sch['subject_type'] ?? 'พื้นฐาน',
                    'credit'         => (float)($sch['credit'] ?? 0),
                    'hours_per_week' => (float)($sch['hours_per_week'] ?? 0),
                    'grade_level'    => $sch['grade_level'],
                    'rooms'          => [],
                    'study_plans'    => [],
                    'remarks'        => []
                ];
                $totalCredit += (float)($sch['credit'] ?? 0);
            }

            $r = trim((string)$sch['room']);
            if ($r !== '' && !in_array($r, $groupedSubjects[$groupKey]['rooms'], true)) {
                $groupedSubjects[$groupKey]['rooms'][] = $r;
            }
            $p = trim((string)($sch['study_plan'] ?? ''));
            if ($p !== '' && !in_array($p, $groupedSubjects[$groupKey]['study_plans'], true)) {
                $groupedSubjects[$groupKey]['study_plans'][] = $p;
            }
            $rem = trim((string)($sch['remark'] ?? ''));
            if ($rem !== '' && !in_array($rem, $groupedSubjects[$groupKey]['remarks'], true)) {
                $groupedSubjects[$groupKey]['remarks'][] = $rem;
            }
        }

        // ประมวลผลกลุ่มวิชา: คำนวณ room_count, room_text, total_weekly_hours
        foreach ($groupedSubjects as &$sub) {
            usort($sub['rooms'], function($a, $b) {
                $nA = is_numeric($a) ? (int)$a : null;
                $nB = is_numeric($b) ? (int)$b : null;
                if ($nA !== null && $nB !== null) return $nA - $nB;
                return strnatcasecmp($a, $b);
            });
            $sub['room_count'] = max(count($sub['rooms']), 1);
            $sub['room_text'] = $this->formatRoomRange($sub['rooms']);
            $sub['total_weekly_hours'] = $sub['hours_per_week'] * $sub['room_count'];
            $totalTeachingHours += $sub['total_weekly_hours'];

            // รวม study_plan และ remark เป็นข้อความเดียว
            $remarkParts = [];
            $uniquePlans = array_values(array_unique(array_filter($sub['study_plans'])));
            if (!empty($uniquePlans)) {
                $remarkParts[] = implode(', ', $uniquePlans);
            }
            if (!empty($sub['remarks'])) {
                $remarkParts[] = implode(', ', $sub['remarks']);
            }
            $sub['study_plan'] = !empty($uniquePlans) ? implode(', ', $uniquePlans) : '';
            $sub['remark'] = implode(' ', $remarkParts);
        }
        unset($sub);

        $groupedSchedules = array_values($groupedSubjects);

        // 4. กิจกรรม (tb_teaching_schedule_activity)
        $activities = $this->dbAcademic->table('tb_teaching_schedule_activity')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('activity_id', 'ASC')
            ->get()
            ->getResult();

        // 5. หน้าที่พิเศษ (tb_teaching_schedule_duty)
        $duties = $this->dbAcademic->table('tb_teaching_schedule_duty')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('duty_order', 'ASC')
            ->get()
            ->getResult();

        // รวมยอดกิจกรรม
        $totalActivityHours  = 0;
        $totalActivityPeriod = 0;
        foreach ($activities as $a) {
            $totalActivityHours  += (float)($a->hours_per_week ?? 0);
            $totalActivityPeriod += (int)($a->total_hours ?? 0);
        }

        $grandTotalHoursPerWeek = $totalTeachingHours + $totalActivityHours;

        return [
            'teacher'     => $teacher,
            'group'       => $groupInfo,
            'schedules'   => $groupedSchedules,
            'activities'  => $activities,
            'duties'      => $duties,
            'year'        => $year,
            'term'        => $term,
            'year_term'   => "{$term}/{$year}",
            'summary'     => [
                'total_subjects'         => count($groupedSchedules),
                'total_credits'          => $totalCredit,
                'total_teaching_hours'   => $totalTeachingHours,
                'total_teaching_periods' => 0,
                'total_activities'       => count($activities),
                'total_activity_hours'   => $totalActivityHours,
                'total_activity_periods' => $totalActivityPeriod,
                'total_duties'           => count($duties),
                'grand_total_hours'      => $grandTotalHoursPerWeek
            ]
        ];
    }

    /**
     * จัดรูปแบบการแสดงผลช่วงห้อง (เช่น 1, 2, 3 -> "1 - 3" หรือ 1, 3 -> "1, 3")
     */
    public function formatRoomRange(array $rooms): string
    {
        if (empty($rooms)) return '';
        if (count($rooms) === 1) return (string)$rooms[0];

        $numbers = [];
        $allNumeric = true;
        foreach ($rooms as $r) {
            if (!is_numeric($r)) {
                $allNumeric = false;
                break;
            }
            $numbers[] = (int)$r;
        }

        if ($allNumeric) {
            sort($numbers);
            $isSequential = true;
            for ($i = 0; $i < count($numbers) - 1; $i++) {
                if ($numbers[$i + 1] !== $numbers[$i] + 1) {
                    $isSequential = false;
                    break;
                }
            }
            if ($isSequential && count($numbers) >= 2) {
                return $numbers[0] . ' - ' . end($numbers);
            }
        }

        return implode(', ', $rooms);
    }

    /**
     * ดึงข้อมูลจัดตารางสอนรายบุคคลแบบจัดกลุ่มวิชา (ตรงตามระบบครู schedule_print)
     */
    public function getIndividualScheduleData(string $teacherId, string $year, string $term)
    {
        // 1. ข้อมูลครู
        $teacher = $this->dbPersonnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_learning, pers_position')
            ->where('pers_id', $teacherId)
            ->get()->getRow();

        if (!$teacher) {
            return null;
        }

        // 2. ข้อมูลกลุ่มสาระการเรียนรู้
        $learningName = 'กลุ่มสาระการเรียนรู้';
        if ($this->dbSkj && !empty($teacher->pers_learning)) {
            $learRow = $this->dbSkj->table('tb_learning')->where('lear_id', $teacher->pers_learning)->get()->getRow();
            if ($learRow && !empty($learRow->lear_namethai)) {
                $learningName = $learRow->lear_namethai;
            }
        }

        // 3. ดึงวิชาสอนและรวมวิชาที่เหมือนกัน (subject_code + grade_level)
        $rawSchedules = $this->dbAcademic->table('tb_teaching_schedule')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('grade_level', 'ASC')
            ->orderBy('subject_code', 'ASC')
            ->get()->getResultArray();

        $groupedSubjects = [];
        $totalCredit = 0;
        $totalBasicHours = 0;
        $totalAdditionalHours = 0;
        $totalSubjectWeeklyHours = 0;
        $basicSubjectCount = 0;
        $additionalSubjectCount = 0;

        foreach ($rawSchedules as $sch) {
            $groupKey = trim($sch['subject_code']) . '_' . trim($sch['grade_level']);
            if (!isset($groupedSubjects[$groupKey])) {
                $groupedSubjects[$groupKey] = [
                    'subject_code'   => $sch['subject_code'],
                    'subject_name'   => $sch['subject_name'],
                    'subject_type'   => $sch['subject_type'] ?? 'พื้นฐาน',
                    'credit'         => (float)($sch['credit'] ?? 0),
                    'hours_per_week' => (float)($sch['hours_per_week'] ?? 0),
                    'grade_level'    => $sch['grade_level'],
                    'rooms'          => [],
                    'study_plans'    => [],
                    'remarks'        => []
                ];
                $totalCredit += (float)($sch['credit'] ?? 0);
                if (mb_strpos($sch['subject_type'] ?? '', 'เพิ่มเติม') !== false) {
                    $additionalSubjectCount++;
                } else {
                    $basicSubjectCount++;
                }
            }

            $r = trim((string)$sch['room']);
            if ($r !== '' && !in_array($r, $groupedSubjects[$groupKey]['rooms'], true)) {
                $groupedSubjects[$groupKey]['rooms'][] = $r;
            }
            $p = trim((string)($sch['study_plan'] ?? ''));
            if ($p !== '' && !in_array($p, $groupedSubjects[$groupKey]['study_plans'], true)) {
                $groupedSubjects[$groupKey]['study_plans'][] = $p;
            }
            $rem = trim((string)($sch['remark'] ?? ''));
            if ($rem !== '' && !in_array($rem, $groupedSubjects[$groupKey]['remarks'], true)) {
                $groupedSubjects[$groupKey]['remarks'][] = $rem;
            }
        }

        // ประมวลผลกลุ่มวิชา
        foreach ($groupedSubjects as &$sub) {
            usort($sub['rooms'], function($a, $b) {
                $nA = is_numeric($a) ? (int)$a : null;
                $nB = is_numeric($b) ? (int)$b : null;
                if ($nA !== null && $nB !== null) return $nA - $nB;
                return strnatcasecmp($a, $b);
            });
            $sub['room_count'] = max(count($sub['rooms']), 1);
            $sub['room_text'] = $this->formatRoomRange($sub['rooms']);
            $sub['total_weekly_hours'] = $sub['hours_per_week'] * $sub['room_count'];
            $totalSubjectWeeklyHours += $sub['total_weekly_hours'];

            if (mb_strpos($sub['subject_type'], 'เพิ่มเติม') !== false) {
                $totalAdditionalHours += $sub['total_weekly_hours'];
            } else {
                $totalBasicHours += $sub['total_weekly_hours'];
            }

            $remarkParts = [];
            $uniquePlans = array_values(array_unique(array_filter($sub['study_plans'])));
            if (!empty($uniquePlans)) {
                $remarkParts[] = implode(', ', $uniquePlans);
            }
            if (!empty($sub['remarks'])) {
                $remarkParts[] = implode(', ', $sub['remarks']);
            }
            $sub['final_remark'] = implode(' ', $remarkParts);
        }
        unset($sub);

        // 4. ดึงข้อมูลกิจกรรม
        $activities = $this->dbAcademic->table('tb_teaching_schedule_activity')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('activity_id', 'ASC')
            ->get()->getResultArray();

        $totalActivityWeeklyHours = 0;
        foreach ($activities as $act) {
            $totalActivityWeeklyHours += (float)($act['hours_per_week'] ?? 0);
        }

        // 5. รวมชั่วโมงทั้งสิ้น
        $grandTotalWeeklyHours = $totalSubjectWeeklyHours + $totalActivityWeeklyHours;

        // 6. ดึงข้อมูลหน้าที่พิเศษ
        $duties = $this->dbAcademic->table('tb_teaching_schedule_duty')
            ->where('teacher_id', $teacherId)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('duty_order', 'ASC')
            ->orderBy('duty_id', 'ASC')
            ->get()->getResultArray();

        // 7. ข้อมูลโรงเรียนและผู้ลงนาม
        $school = $this->dbAcademic->table('tb_school')->get()->getRow();

        // หัวหน้ากลุ่มสาระ
        $deptHead = $this->dbPersonnel->table('tb_personnel')
            ->where('pers_learning', $teacher->pers_learning)
            ->groupStart()
                ->where('pers_position', 'posi_003')
                ->orWhere('pers_groupleade', 1)
            ->groupEnd()
            ->get()->getRow();

        // รองผู้อำนวยการฝ่ายวิชาการ
        $viceDirector = $this->dbPersonnel->table('tb_personnel')
            ->where('pers_position', 'posi_002')
            ->get()->getRow();

        return [
            'year'                       => $year,
            'term'                       => $term,
            'teacher'                    => $teacher,
            'learning_name'              => $learningName,
            'grouped_subjects'           => array_values($groupedSubjects),
            'total_credit'               => $totalCredit,
            'total_basic_hours'          => $totalBasicHours,
            'total_additional_hours'     => $totalAdditionalHours,
            'total_subject_weekly_hours' => $totalSubjectWeeklyHours,
            'basic_subject_count'        => $basicSubjectCount,
            'additional_subject_count'   => $additionalSubjectCount,
            'activities'                 => $activities,
            'total_activity_weekly_hours'=> $totalActivityWeeklyHours,
            'grand_total_weekly_hours'   => $grandTotalWeeklyHours,
            'duties'                     => $duties,
            'school'                     => $school,
            'dept_head'                  => $deptHead,
            'vice_director'              => $viceDirector,
        ];
    }

    /**
     * ดึงข้อมูลการจัดตารางสอนทั้งกลุ่มสาระฯ เพื่อพิมพ์รายงานสรุปภาพรวม (Group Teaching Schedule Summary)
     */
    public function getGroupSchedulePrintData(string $groupId, string $year, string $term): array
    {
        // 1. ดึงข้อมูลกลุ่มสาระ
        $group = $this->dbSkj->table('tb_learning')
            ->where('lear_id', $groupId)
            ->get()
            ->getRow();

        $groupName = $group->lear_namethai ?? 'กลุ่มสาระการเรียนรู้';

        // 2. ดึงครูทุกคนในกลุ่มสาระที่สถานะกำลังใช้งาน
        $teachers = $this->dbPersonnel->table('tb_personnel')
            ->select('pers_id, pers_prefix, pers_firstname, pers_lastname, pers_img, pers_position, pers_academic, pers_learning, pers_groupleade')
            ->where('pers_learning', $groupId)
            ->where('pers_status', 'กำลังใช้งาน')
            ->orderBy("CASE WHEN pers_groupleade LIKE '%หัวหน้ากลุ่มสาระ%' THEN 0 ELSE 1 END", 'ASC', false)
            ->orderBy('pers_firstname', 'ASC')
            ->get()
            ->getResult();

        if (empty($teachers)) {
            return [
                'year'         => $year,
                'term'         => $term,
                'group'        => $group,
                'group_name'   => $groupName,
                'teachers'     => [],
                'rows'         => [],
                'total_hours'  => 0,
                'school'       => $this->dbAcademic->table('tb_school')->get()->getRow(),
                'dept_head'    => null,
                'vice_director'=> null,
            ];
        }

        $teacherIds = array_map(function ($t) {
            return trim($t->pers_id);
        }, $teachers);

        $teacherMap = [];
        $headTeacher = null;
        foreach ($teachers as $t) {
            $tid = trim($t->pers_id);
            $fullName = ($t->pers_prefix ?? '') . ($t->pers_firstname ?? '') . ' ' . ($t->pers_lastname ?? '');
            $t->fullname = $fullName;
            $teacherMap[$tid] = $t;

            if (!empty($t->pers_groupleade) && (strpos($t->pers_groupleade, 'หัวหน้ากลุ่มสาระ') !== false || $t->pers_groupleade == '1')) {
                if (!$headTeacher) {
                    $headTeacher = $t;
                }
            }
        }

        // 3. ดึงรายการตารางสอนของครูทุกคนในกลุ่มสาระ
        $rawSchedules = $this->dbAcademic->table('tb_teaching_schedule')
            ->whereIn('teacher_id', $teacherIds)
            ->where('year', $year)
            ->where('term', $term)
            ->orderBy('grade_level', 'ASC')
            ->orderBy('subject_code', 'ASC')
            ->get()
            ->getResultArray();

        // 4. จัดกลุ่มตารางสอนแยกตามครูผู้สอน + (รหัสวิชา + ระดับชั้น)
        $teacherGroupedSubjects = [];
        foreach ($rawSchedules as $sch) {
            $tid = trim($sch['teacher_id']);
            $groupKey = trim($sch['subject_code']) . '_' . trim($sch['grade_level']);

            if (!isset($teacherGroupedSubjects[$tid][$groupKey])) {
                $teacherGroupedSubjects[$tid][$groupKey] = [
                    'teacher_id'     => $tid,
                    'subject_code'   => $sch['subject_code'],
                    'subject_name'   => $sch['subject_name'],
                    'subject_type'   => $sch['subject_type'] ?? 'พื้นฐาน',
                    'credit'         => (float)($sch['credit'] ?? 0),
                    'hours_per_week' => (float)($sch['hours_per_week'] ?? 0),
                    'grade_level'    => $sch['grade_level'],
                    'rooms'          => [],
                    'study_plans'    => [],
                    'remarks'        => []
                ];
            }

            $r = trim((string)$sch['room']);
            if ($r !== '' && !in_array($r, $teacherGroupedSubjects[$tid][$groupKey]['rooms'], true)) {
                $teacherGroupedSubjects[$tid][$groupKey]['rooms'][] = $r;
            }
            $p = trim((string)($sch['study_plan'] ?? ''));
            if ($p !== '' && !in_array($p, $teacherGroupedSubjects[$tid][$groupKey]['study_plans'], true)) {
                $teacherGroupedSubjects[$tid][$groupKey]['study_plans'][] = $p;
            }
            $rem = trim((string)($sch['remark'] ?? ''));
            if ($rem !== '' && !in_array($rem, $teacherGroupedSubjects[$tid][$groupKey]['remarks'], true)) {
                $teacherGroupedSubjects[$tid][$groupKey]['remarks'][] = $rem;
            }
        }

        // 5. สร้างโครงสร้างแถวข้อมูล (Rows) สำหรับพิมพ์ตาราง (เอาเฉพาะรายวิชาสอน ไม่รวมกิจกรรม)
        $reportRows = [];
        $overallTotalHours = 0;
        $rowNumber = 1;

        foreach ($teachers as $t) {
            $tid = trim($t->pers_id);
            $subs = isset($teacherGroupedSubjects[$tid]) ? array_values($teacherGroupedSubjects[$tid]) : [];

            // คำนวณชั่วโมงรวมของครูท่านนี้ (เฉพาะวิชาสอน)
            $teacherTotalHours = 0;

            // จัดรูปแบบรายวิชา
            $processedSubs = [];
            foreach ($subs as $sub) {
                usort($sub['rooms'], function($a, $b) {
                    $nA = is_numeric($a) ? (int)$a : null;
                    $nB = is_numeric($b) ? (int)$b : null;
                    if ($nA !== null && $nB !== null) return $nA - $nB;
                    return strnatcasecmp($a, $b);
                });
                $roomCount = max(count($sub['rooms']), 1);
                $roomText = $this->formatRoomRange($sub['rooms']);
                $totalWeekly = $sub['hours_per_week'] * $roomCount;
                $teacherTotalHours += $totalWeekly;
                $overallTotalHours += $totalWeekly;

                $sub['room_count'] = $roomCount;
                $sub['room_text'] = $roomText;
                $sub['total_weekly_hours'] = $totalWeekly;
                $processedSubs[] = $sub;
            }

            $itemCount = count($processedSubs);

            if ($itemCount === 0) {
                // ถ้าครูยังไม่ได้จัดตารางสอน
                $reportRows[] = [
                    'row_no'             => $rowNumber++,
                    'teacher_name'       => $t->fullname,
                    'teacher_id'         => $tid,
                    'teacher_total_hours'=> 0,
                    'rowspan'            => 1,
                    'is_first_sub'       => true,
                    'subject_code'       => '-',
                    'subject_name'       => 'ยังไม่ระบุตารางสอน',
                    'is_basic'           => false,
                    'is_additional'      => false,
                    'credit'             => '-',
                    'hours_per_week'     => 0,
                    'grade_level'        => '-',
                    'room_text'          => '-',
                    'total_weekly_hours' => 0,
                    'remark'             => '-',
                ];
            } else {
                foreach ($processedSubs as $idx => $item) {
                    $isBasic = false;
                    $isAdditional = false;
                    $typeStr = (string)($item['subject_type'] ?? '');
                    if (mb_strpos($typeStr, 'เพิ่มเติม') !== false) {
                        $isAdditional = true;
                    } elseif (mb_strpos($typeStr, 'พื้นฐาน') !== false) {
                        $isBasic = true;
                    }

                    $reportRows[] = [
                        'row_no'             => $rowNumber++,
                        'teacher_name'       => $t->fullname,
                        'teacher_id'         => $tid,
                        'teacher_total_hours'=> $teacherTotalHours,
                        'rowspan'            => $itemCount,
                        'is_first_sub'       => ($idx === 0),
                        'subject_code'       => $item['subject_code'],
                        'subject_name'       => $item['subject_name'],
                        'is_basic'           => $isBasic,
                        'is_additional'      => $isAdditional,
                        'credit'             => $item['credit'],
                        'hours_per_week'     => $item['hours_per_week'],
                        'grade_level'        => $item['grade_level'],
                        'room_text'          => $item['room_text'],
                        'total_weekly_hours' => $item['total_weekly_hours'],
                        'remark'             => !empty($item['remarks']) ? implode(' ', $item['remarks']) : '',
                    ];
                }
            }
        }

        // 7. ข้อมูลโรงเรียนและผู้ลงนาม
        $school = $this->dbAcademic->table('tb_school')->get()->getRow();

        if (!$headTeacher) {
            $headTeacher = $this->dbPersonnel->table('tb_personnel')
                ->where('pers_learning', $groupId)
                ->groupStart()
                    ->where('pers_position', 'posi_003')
                    ->orWhere('pers_groupleade', 1)
                ->groupEnd()
                ->get()->getRow();
        }

        $viceDirector = $this->dbPersonnel->table('tb_personnel')
            ->where('pers_position', 'posi_002')
            ->get()->getRow();

        return [
            'year'         => $year,
            'term'         => $term,
            'group'        => $group,
            'group_name'   => $groupName,
            'teachers'     => $teachers,
            'rows'         => $reportRows,
            'total_hours'  => $overallTotalHours,
            'school'       => $school,
            'dept_head'    => $headTeacher,
            'vice_director'=> $viceDirector,
        ];
    }
}

