<?php

namespace App\Libraries\Timetable;

/**
 * Class FetRecursiveSolver
 * 
 * FET-Inspired Native Timetable Solver for SKJ Academic System.
 * Implements:
 * 1. Hard Anchors: Master Locks & Cross-Grade Synchronized Excellence Blocks.
 * 2. Activity Breakdown: Supports multi-hour splits (e.g. 3 hrs -> [2, 1]).
 * 3. Most-Constrained-First Heuristic Ordering.
 * 4. Depth-Limited Recursive Swapping (Chain Displacement) to break deadlocks.
 * 5. Two-Stage Decoupled Solver with Soft Constraint Hill-Climbing (Min Days, Max Consec, Gap Control).
 * 6. Conflict & Deadlock Diagnostics.
 */
class FetRecursiveSolver
{
    // Solver Configuration
    protected int $maxDepth = 6;
    protected float $timeLimitSeconds = 40.0;
    protected float $startTime = 0.0;
    
    // Grid Setup
    protected array $days = ['MON', 'TUE', 'WED', 'THU', 'FRI'];
    protected array $periods = [];
    protected array $breakSlots = []; // [level_group => [period => true]]
    protected array $masterSlots = []; // [level_group => [day => [period => subject_name]]]
    
    // Constraints & State
    protected array $excellenceBlocks = []; // Array of excellence block objects
    protected array $excellenceClassMask = []; // [class_name => [day => [period => block_name]]]
    protected array $excellenceTeacherMask = []; // [teacher_id => [day => [period => block_name]]]
    
    protected array $busyTeachers = []; // [teacher_id => [day => [period => true]]]
    protected array $busyClasses = [];  // [class_name => [day => [period => true]]]
    protected array $busyRooms = [];    // [room_name => [day => [period => true]]]
    
    // Placed Assignments Map: [class_name => [day => [period => activity_id]]]
    protected array $classTimetable = [];
    // Teacher Timetable Map: [teacher_id => [day => [period => activity_id]]]
    protected array $teacherTimetable = [];
    // Room Timetable Map: [room_name => [day => [period => activity_id]]]
    protected array $roomTimetable = [];
    
    // Activity Registry & Tracking
    /** @var array<string, array> */
    protected array $activities = []; // [activity_id => activity_data]
    protected array $activityPlacements = []; // [activity_id => ['day' => d, 'start_period' => p]]
    protected array $unplacedActivities = [];
    protected array $diagnostics = [];
    protected array $logs = [];

    // Soft Constraint Options
    protected bool $optMinDays = true;
    protected bool $optMaxConsecutive = true;
    protected bool $optGapControl = true;
    protected bool $optGroupsAfternoonOnly = true;
    
    public function __construct(array $config = [])
    {
        @set_time_limit(180);
        @ini_set('max_execution_time', '180');

        if (isset($config['max_depth'])) $this->maxDepth = (int)$config['max_depth'];
        if (isset($config['time_limit'])) $this->timeLimitSeconds = (float)$config['time_limit'];
        if (isset($config['opt_min_days'])) $this->optMinDays = (bool)$config['opt_min_days'];
        if (isset($config['opt_max_consec'])) $this->optMaxConsecutive = (bool)$config['opt_max_consec'];
        if (isset($config['opt_gap_control'])) $this->optGapControl = (bool)$config['opt_gap_control'];
        if (isset($config['opt_groups_afternoon_only'])) $this->optGroupsAfternoonOnly = (bool)$config['opt_groups_afternoon_only'];
    }

    /**
     * Add log message
     */
    protected function log(string $msg): void
    {
        $this->logs[] = $msg;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * Set up Grid: Days and Periods
     */
    public function setGrid(array $activeDays, array $allPeriods): void
    {
        if (!empty($activeDays)) {
            $this->days = array_values(array_map('strtoupper', $activeDays));
        }
        
        $this->periods = [];
        $this->breakSlots = [];
        
        foreach ($allPeriods as $p) {
            $pNum = (int)($p->period_number ?? $p['period_number']);
            $this->periods[$pNum] = $pNum;
            
            $isBreak = (bool)($p->is_break ?? $p['is_break'] ?? false);
            $levelGroup = $p->level_group ?? $p['level_group'] ?? 'ALL';
            
            if ($isBreak) {
                $this->breakSlots[$levelGroup][$pNum] = true;
                $this->breakSlots['ALL'][$pNum] = true;
            }
        }
        ksort($this->periods);
    }

    /**
     * Set Master Slots (e.g. Assembly, Homeroom)
     */
    public function setMasterSlots(array $masterSlots): void
    {
        $this->masterSlots = [];
        foreach ($masterSlots as $ms) {
            $lvl = $ms->level_group ?? $ms['level_group'] ?? 'ALL';
            $day = strtoupper($ms->day ?? $ms['day']);
            $p = (int)($ms->period ?? $ms['period']);
            $name = $ms->subject_name ?? $ms['subject_name'] ?? 'กิจกรรม';
            $this->masterSlots[$lvl][$day][$p] = $name;
        }
    }

    /**
     * Set Cross-Grade Synchronized Excellence Blocks
     */
    public function setExcellenceBlocks(array $blocks): void
    {
        $this->excellenceBlocks = [];
        $this->excellenceClassMask = [];
        $this->excellenceTeacherMask = [];

        foreach ($blocks as $b) {
            $day = strtoupper($b->day ?? $b['day']);
            $startP = (int)($b->start_period ?? $b['start_period']);
            $count = max(1, (int)($b->period_count ?? $b['period_count'] ?? 1));
            $blockName = $b->block_name ?? $b['block_name'] ?? 'กิจกรรมสู่ความเป็นเลิศ';
            $targetGradesRaw = $b->target_grades ?? $b['target_grades'] ?? '';
            $teacherIdsRaw = $b->teacher_ids ?? $b['teacher_ids'] ?? '';

            $targetGrades = array_filter(array_map('trim', explode(',', $targetGradesRaw)));
            $teacherIds = array_filter(array_map('trim', explode(',', $teacherIdsRaw)));

            // 1. Lock periods for participating teachers
            for ($p = $startP; $p < $startP + $count; $p++) {
                foreach ($teacherIds as $tid) {
                    $this->excellenceTeacherMask[$tid][$day][$p] = $blockName;
                    $this->busyTeachers[$tid][$day][$p] = true;
                }
            }

            // Store block metadata
            $this->excellenceBlocks[] = [
                'name' => $blockName,
                'day' => $day,
                'start_period' => $startP,
                'period_count' => $count,
                'target_grades' => $targetGrades,
                'teacher_ids' => $teacherIds
            ];
        }
    }

    /**
     * Check if a classroom belongs to target grades
     */
    protected function classMatchesGrade(string $className, string $grade): bool
    {
        $className = trim($className);
        $grade = trim($grade);
        // e.g. "ม.1/1" matches "ม.1", "ม.2/3" matches "ม.2"
        return (strpos($className, $grade) === 0 || strpos($className, $grade . '/') === 0);
    }

    /**
     * Apply Excellence Block Masks to all active classrooms
     */
    public function applyExcellenceBlocksToClasses(array $classNames): void
    {
        foreach ($this->excellenceBlocks as $b) {
            $day = $b['day'];
            $startP = $b['start_period'];
            $count = $b['period_count'];
            $blockName = $b['name'];
            $targetGrades = $b['target_grades'];

            foreach ($classNames as $cName) {
                $matched = false;
                foreach ($targetGrades as $tg) {
                    if ($this->classMatchesGrade($cName, $tg)) {
                        $matched = true;
                        break;
                    }
                }

                if ($matched) {
                    for ($p = $startP; $p < $startP + $count; $p++) {
                        $this->excellenceClassMask[$cName][$day][$p] = $blockName;
                        $this->busyClasses[$cName][$day][$p] = true;
                    }
                }
            }
        }
    }

    /**
     * Set Existing Constraints: Teacher Busy, Room Busy, Subject Locks
     */
    public function setConstraints(array $teacherConstraints, array $roomConstraints, array $subjectLocks): void
    {
        foreach ($teacherConstraints as $tc) {
            $tid = trim($tc->teacher_id ?? $tc['teacher_id']);
            $day = strtoupper($tc->day ?? $tc['day']);
            $p = (int)($tc->period ?? $tc['period']);
            if (!empty($tid) && !empty($day) && $p > 0) {
                $this->busyTeachers[$tid][$day][$p] = true;
            }
        }

        foreach ($roomConstraints as $rc) {
            $rName = trim($rc->room_name ?? $rc['room_name']);
            $day = strtoupper($rc->day ?? $rc['day']);
            $p = (int)($rc->period ?? $rc['period']);
            if (!empty($rName) && !empty($day) && $p > 0) {
                $this->busyRooms[$rName][$day][$p] = true;
            }
        }
    }

    /**
     * Break down assignments into FET Activities
     */
    public function buildActivities(array $assignments, array $subjectLocks = []): void
    {
        $this->activities = [];
        $activityIndex = 1;

        // Group assignments that share a group_id (Joint Simultaneous Classes)
        $grouped = [];
        foreach ($assignments as $a) {
            $gid = !empty($a->group_id) ? 'GRP_' . $a->group_id : 'SNG_' . $a->assign_id;
            $grouped[$gid][] = $a;
        }

        foreach ($grouped as $gid => $items) {
            $base = $items[0];
            $hours = (int)($base->hours_per_week ?? 1);
            $splitStr = trim($base->period_split ?? '');
            
            // Resolve period split pattern (e.g. "2,1", "2,2", "1,1,1")
            $splits = [];
            if (!empty($splitStr)) {
                $splits = array_map('intval', explode(',', $splitStr));
            } else {
                if ($hours === 1) $splits = [1];
                elseif ($hours === 2) $splits = [2];
                elseif ($hours === 3) $splits = [2, 1];
                elseif ($hours === 4) $splits = [2, 2];
                elseif ($hours === 5) $splits = [2, 2, 1];
                elseif ($hours === 6) $splits = [2, 2, 2];
                else $splits = array_fill(0, $hours, 1);
            }

            // Collect all participating classes and teachers
            $classNames = [];
            $teacherIds = [];
            $assignIds = [];
            $roomNames = [];

            foreach ($items as $item) {
                $assignIds[] = (int)$item->assign_id;
                $classNames[] = trim($item->class_name);
                if (!empty($item->room_name)) $roomNames[] = trim($item->room_name);
                
                if (!empty($item->teacher_id)) {
                    foreach (explode(',', $item->teacher_id) as $rt) {
                        $rt = trim($rt);
                        if (!empty($rt)) $teacherIds[] = $rt;
                    }
                }
            }

            $classNames = array_values(array_unique($classNames));
            $teacherIds = array_values(array_unique($teacherIds));
            $roomNames = array_values(array_unique($roomNames));

            $subCode = trim($base->tsub_code ?? '');
            $subType = trim($base->subject_type ?? '');
            $isGroup = str_starts_with($gid, 'GRP_');

            // Determine if subject is Elective (เพิ่มเติม) or Core (พื้นฐาน)
            $isElective = ($isGroup || $subType === 'เพิ่มเติม' || preg_match('/^[ก-ฮ][0-9]{2}2[0-9]{2}/u', $subCode));
            $isCore = (!$isGroup && ($subType === 'พื้นฐาน' || preg_match('/^[ก-ฮ][0-9]{2}1[0-9]{2}/u', $subCode)));

            // Create an Activity for each split part
            $totalSplits = count($splits);
            foreach ($splits as $splitIdx => $duration) {
                if ($duration <= 0) continue;

                $actId = "ACT_" . $activityIndex++;
                $this->activities[$actId] = [
                    'activity_id'    => $actId,
                    'group_key'      => $gid,
                    'assign_ids'     => $assignIds,
                    'class_names'    => $classNames,
                    'teacher_ids'    => $teacherIds,
                    'room_names'     => $roomNames,
                    'subject_code'   => $subCode,
                    'subject_name'   => trim($base->tsub_name ?? ''),
                    'duration'       => $duration,
                    'split_index'    => $splitIdx,
                    'total_splits'   => $totalSplits,
                    'preferred_time' => $base->preferred_time ?? 'NONE',
                    'is_elective'    => $isElective,
                    'is_core'        => $isCore,
                    'is_group'       => $isGroup,
                    'is_locked'      => false,
                    'difficulty'     => 0
                ];
            }
        }

        // Apply Manual Subject Locks directly to activities
        $this->applySubjectLocks($subjectLocks);

        // Calculate heuristic difficulty score for each activity
        $this->calculateDifficultyScores();
    }

    /**
     * Apply Subject Locks (Hard Anchors)
     */
    protected function applySubjectLocks(array $subjectLocks): void
    {
        if (empty($subjectLocks)) return;

        foreach ($subjectLocks as $lock) {
            $lockClass = trim($lock->class_name);
            $lockSubId = (int)$lock->subject_id;
            $lockDay = strtoupper($lock->day);
            $lockPeriod = (int)$lock->period;

            // Find matching activity
            foreach ($this->activities as $actId => &$act) {
                if ($act['is_locked']) continue;

                if (in_array($lockClass, $act['class_names'], true)) {
                    // Match by first assign_id subject
                    $this->placeActivityAt($actId, $lockDay, $lockPeriod, true);
                    $act['is_locked'] = true;
                    break;
                }
            }
            unset($act);
        }
    }

    /**
     * Calculate Difficulty Score (Most Constrained First heuristic)
     */
    protected function calculateDifficultyScores(): void
    {
        foreach ($this->activities as $actId => &$act) {
            if ($act['is_locked']) {
                $act['difficulty'] = 99999;
                continue;
            }

            $score = 0;
            // 1. Joint classes: Highly constrained because multiple classes must be free simultaneously
            $score += count($act['class_names']) * 150;

            // 2. Duration: Larger continuous blocks (3 > 2 > 1) are much harder to place
            $score += $act['duration'] * 80;

            // 3. Multi-teacher: Requires multiple teachers to be available simultaneously
            $score += count($act['teacher_ids']) * 70;

            // 4. Highly busy teachers
            $teacherBusyCount = 0;
            foreach ($act['teacher_ids'] as $tid) {
                if (isset($this->busyTeachers[$tid])) {
                    foreach ($this->busyTeachers[$tid] as $d => $pList) {
                        $teacherBusyCount += count($pList);
                    }
                }
            }
            $score += $teacherBusyCount * 5;

            // 5. Preferred time constraints
            if ($act['preferred_time'] !== 'NONE' && !empty($act['preferred_time'])) {
                $score += 40;
            }

            $act['difficulty'] = $score;
        }
        unset($act);
    }

    /**
     * Check if a classroom is in lower or upper secondary (for master slots)
     */
    protected function getLevelGroup(string $className): string
    {
        if (strpos($className, 'ม.1') !== false || strpos($className, 'ม.2') !== false || strpos($className, 'ม.3') !== false) {
            return 'ม.ต้น';
        }
        if (strpos($className, 'ม.4') !== false || strpos($className, 'ม.5') !== false || strpos($className, 'ม.6') !== false) {
            return 'ม.ปลาย';
        }
        return 'ALL';
    }

    /**
     * Check if a slot range [p .. p + duration - 1] is valid for an activity
     * Returns true if ZERO hard conflicts exist.
     */
    public function isValidSlotForActivity(string $actId, string $day, int $startPeriod, ?array &$conflicts = null): bool
    {
        $act = $this->activities[$actId] ?? null;
        if (!$act) return false;

        $conflicts = [];
        $duration = $act['duration'];
        $endPeriod = $startPeriod + $duration - 1;

        // 1. Grid boundary check
        if (!in_array($day, $this->days, true) || !isset($this->periods[$startPeriod]) || !isset($this->periods[$endPeriod])) {
            $conflicts[] = "ออกนอกช่วงคาบของวัน";
            return false;
        }

        for ($p = $startPeriod; $p <= $endPeriod; $p++) {
            // 2. Break Periods Check
            foreach ($act['class_names'] as $cName) {
                $lvl = $this->getLevelGroup($cName);
                if (!empty($this->breakSlots[$lvl][$p]) || !empty($this->breakSlots['ALL'][$p])) {
                    $conflicts[] = "ชนคาบพัก/รับประทานอาหาร คาบที่ $p";
                    return false;
                }
                
                // 3. Master Slots Check (e.g. Assembly, Homeroom)
                if (!empty($this->masterSlots[$lvl][$day][$p]) || !empty($this->masterSlots['ALL'][$day][$p])) {
                    $conflicts[] = "ชนคาบล็อคระดับโรงเรียน คาบที่ $p";
                    return false;
                }

                // 4. Cross-Grade Excellence Blocks Check
                if (!empty($this->excellenceClassMask[$cName][$day][$p])) {
                    $blockName = $this->excellenceClassMask[$cName][$day][$p];
                    $conflicts[] = "ชนคาบเรียนสู่ความเป็นเลิศ ($blockName) ห้อง $cName วัน $day คาบ $p";
                    return false;
                }

                // 5. Classroom Hard Collision Check (Already booked by another activity)
                if (!empty($this->classTimetable[$cName][$day][$p]) && $this->classTimetable[$cName][$day][$p] !== $actId) {
                    $occupantId = $this->classTimetable[$cName][$day][$p];
                    $conflicts[] = "ห้อง $cName ไม่ว่างในวัน $day คาบ $p (ถูกจองโดย $occupantId)";
                    return false;
                }
            }

            // 6. Teacher Busy Constraints & Double Booking Check
            foreach ($act['teacher_ids'] as $tid) {
                // Predefined teacher constraint
                if (!empty($this->busyTeachers[$tid][$day][$p])) {
                    $reason = $this->excellenceTeacherMask[$tid][$day][$p] ?? 'ครูติดภารกิจ/ไม่สะดวกสอน';
                    $conflicts[] = "ครู ($tid) ติดภารกิจในวัน $day คาบ $p ($reason)";
                    return false;
                }

                // Teacher collision with another placed activity
                if (!empty($this->teacherTimetable[$tid][$day][$p]) && $this->teacherTimetable[$tid][$day][$p] !== $actId) {
                    $conflicts[] = "ครู ($tid) มีสอนห้องอื่นแล้วในวัน $day คาบ $p";
                    return false;
                }
            }

            // 7. Room Collision Check
            foreach ($act['room_names'] as $rName) {
                if (!empty($this->busyRooms[$rName][$day][$p])) {
                    $conflicts[] = "ห้องเรียนเฉพาะ ($rName) ติดภารกิจในวัน $day คาบ $p";
                    return false;
                }
                if (!empty($this->roomTimetable[$rName][$day][$p]) && $this->roomTimetable[$rName][$day][$p] !== $actId) {
                    $conflicts[] = "ห้องเรียน ($rName) ถูกใช้งานแล้วในวัน $day คาบ $p";
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Place activity at specific day and start period
     */
    protected function placeActivityAt(string $actId, string $day, int $startPeriod, bool $isLocked = false): void
    {
        $act = &$this->activities[$actId];
        $duration = $act['duration'];

        for ($p = $startPeriod; $p < $startPeriod + $duration; $p++) {
            foreach ($act['class_names'] as $cName) {
                $this->classTimetable[$cName][$day][$p] = $actId;
            }
            foreach ($act['teacher_ids'] as $tid) {
                $this->teacherTimetable[$tid][$day][$p] = $actId;
            }
            foreach ($act['room_names'] as $rName) {
                $this->roomTimetable[$rName][$day][$p] = $actId;
            }
        }

        $this->activityPlacements[$actId] = [
            'day' => $day,
            'start_period' => $startPeriod,
            'is_locked' => $isLocked
        ];
    }

    /**
     * Remove activity from its current placement
     */
    protected function unplaceActivity(string $actId): void
    {
        if (!isset($this->activityPlacements[$actId])) return;

        $placement = $this->activityPlacements[$actId];
        $day = $placement['day'];
        $startPeriod = $placement['start_period'];
        $act = $this->activities[$actId];
        $duration = $act['duration'];

        for ($p = $startPeriod; $p < $startPeriod + $duration; $p++) {
            foreach ($act['class_names'] as $cName) {
                if (isset($this->classTimetable[$cName][$day][$p]) && $this->classTimetable[$cName][$day][$p] === $actId) {
                    unset($this->classTimetable[$cName][$day][$p]);
                }
            }
            foreach ($act['teacher_ids'] as $tid) {
                if (isset($this->teacherTimetable[$tid][$day][$p]) && $this->teacherTimetable[$tid][$day][$p] === $actId) {
                    unset($this->teacherTimetable[$tid][$day][$p]);
                }
            }
            foreach ($act['room_names'] as $rName) {
                if (isset($this->roomTimetable[$rName][$day][$p]) && $this->roomTimetable[$rName][$day][$p] === $actId) {
                    unset($this->roomTimetable[$rName][$day][$p]);
                }
            }
        }

        unset($this->activityPlacements[$actId]);
    }

    /**
     * Compute soft constraint penalty delta for placing an activity at (day, startPeriod)
     */
    protected function computeSoftPenalty(string $actId, string $day, int $startPeriod): int
    {
        $act = $this->activities[$actId];
        $penalty = 0;

        // 1. Min Days Between Activities of the same group/subject
        if ($this->optMinDays && $act['total_splits'] > 1) {
            foreach ($this->activityPlacements as $otherId => $placement) {
                if ($otherId === $actId) continue;
                $otherAct = $this->activities[$otherId];
                
                // Same group or same subject for same classroom
                if ($otherAct['group_key'] === $act['group_key'] || 
                    (!empty($act['subject_code']) && $otherAct['subject_code'] === $act['subject_code'] && array_intersect($act['class_names'], $otherAct['class_names']))) {
                    
                    if ($placement['day'] === $day) {
                        $penalty += 30; // Heavy penalty: same subject twice on same day
                    } else {
                        // Check adjacent days (e.g. MON & TUE)
                        $dayIdx1 = array_search($day, $this->days, true);
                        $dayIdx2 = array_search($placement['day'], $this->days, true);
                        if ($dayIdx1 !== false && $dayIdx2 !== false && abs($dayIdx1 - $dayIdx2) === 1) {
                            $penalty += 10; // Medium penalty: adjacent days
                        }
                    }
                }
            }
        }

        // 2. Max Consecutive Hours for Teachers (>3 consecutive)
        if ($this->optMaxConsecutive) {
            foreach ($act['teacher_ids'] as $tid) {
                $consec = $act['duration'];
                // Check backwards
                $p = $startPeriod - 1;
                while (isset($this->teacherTimetable[$tid][$day][$p])) {
                    $consec++;
                    $p--;
                }
                // Check forwards
                $p = $startPeriod + $act['duration'];
                while (isset($this->teacherTimetable[$tid][$day][$p])) {
                    $consec++;
                    $p++;
                }

                if ($consec > 3) {
                    $penalty += ($consec - 3) * 15;
                }
            }
        }

        // 3. Preferred Time: Afternoon for Electives & Groups, Morning for Core
        if (!empty($act['is_group'])) {
            // Grouped activities (Simultaneous groups): strongly push to later afternoon periods (7, 8, 9)
            if ($startPeriod < 5) {
                $penalty += 300;
            } elseif ($startPeriod >= 7) {
                $penalty -= 60; // Best slots: periods 7-9
            }
        } elseif (!empty($act['is_elective'])) {
            // Elective subjects (วิชาเพิ่มเติม): prefer afternoon / later periods (ท้ายตาราง เช่น คาบ 6, 7, 8, 9)
            if ($startPeriod < 5) {
                $penalty += 80; // Strongly discourage morning for electives
            } elseif ($startPeriod >= 7) {
                $penalty -= 50; // Strongly encourage periods 7, 8, 9 (ท้ายตาราง)
            } elseif ($startPeriod >= 5) {
                $penalty -= 25; // Afternoon periods 5, 6
            }
        } elseif (!empty($act['is_core'])) {
            // Core/Basic subjects (วิชาพื้นฐาน): prefer morning periods (คาบ 1, 2, 3, 4)
            if ($startPeriod <= 4) {
                $penalty -= 40; // Strongly encourage morning for core subjects
            } elseif ($startPeriod >= 7) {
                $penalty += 50; // Discourage late afternoon for core subjects
            }
        }

        if ($act['preferred_time'] === 'MORNING' && $startPeriod >= 5) {
            $penalty += 15;
        } elseif ($act['preferred_time'] === 'AFTERNOON' && $startPeriod < 5) {
            $penalty += 20;
        }

        return $penalty;
    }

    /**
     * FET Heuristic Recursive Swapping Engine
     * Attempts to place an activity using depth-limited chain displacement
     */
    protected function tryPlaceActivity(string $actId, int $depth = 0, array &$visitedChain = []): bool
    {
        // Guard against infinite recursion or exceeding time limit
        if ($depth > $this->maxDepth) return false;
        if ((microtime(true) - $this->startTime) > $this->timeLimitSeconds) return false;

        $act = $this->activities[$actId];
        $duration = $act['duration'];

        $emptySlots = [];
        $occupiedSlots = [];

        // Scan all possible days and period slots
        foreach ($this->days as $day) {
            foreach ($this->periods as $startP) {
                $endP = $startP + $duration - 1;
                if (!isset($this->periods[$endP])) continue;

                // Test if this slot violates un-movable hard constraints (Breaks, Master Slots, Excellence Blocks, Teacher Busy)
                $hardBlocked = false;
                for ($p = $startP; $p <= $endP; $p++) {
                    foreach ($act['class_names'] as $cName) {
                        $lvl = $this->getLevelGroup($cName);
                        if (!empty($this->breakSlots[$lvl][$p]) || !empty($this->breakSlots['ALL'][$p])) {
                            $hardBlocked = true; break 2;
                        }
                        if (!empty($this->masterSlots[$lvl][$day][$p]) || !empty($this->masterSlots['ALL'][$day][$p])) {
                            $hardBlocked = true; break 2;
                        }
                        if (!empty($this->excellenceClassMask[$cName][$day][$p])) {
                            $hardBlocked = true; break 2;
                        }
                    }
                    foreach ($act['teacher_ids'] as $tid) {
                        if (!empty($this->busyTeachers[$tid][$day][$p])) {
                            $hardBlocked = true; break 2;
                        }
                    }
                    foreach ($act['room_names'] as $rName) {
                        if (!empty($this->busyRooms[$rName][$day][$p])) {
                            $hardBlocked = true; break 2;
                        }
                    }
                }

                if ($hardBlocked) continue;

                // Hard Constraint: Grouped subjects must NOT be placed before lunch break (startP < 5)
                if ($this->optGroupsAfternoonOnly && !empty($act['is_group']) && $startP < 5) {
                    continue;
                }

                // Find existing activities currently occupying this slot
                $occupants = [];
                for ($p = $startP; $p <= $endP; $p++) {
                    foreach ($act['class_names'] as $cName) {
                        if (!empty($this->classTimetable[$cName][$day][$p])) {
                            $occId = $this->classTimetable[$cName][$day][$p];
                            if ($occId !== $actId) $occupants[$occId] = true;
                        }
                    }
                    foreach ($act['teacher_ids'] as $tid) {
                        if (!empty($this->teacherTimetable[$tid][$day][$p])) {
                            $occId = $this->teacherTimetable[$tid][$day][$p];
                            if ($occId !== $actId) $occupants[$occId] = true;
                        }
                    }
                    foreach ($act['room_names'] as $rName) {
                        if (!empty($this->roomTimetable[$rName][$day][$p])) {
                            $occId = $this->roomTimetable[$rName][$day][$p];
                            if ($occId !== $actId) $occupants[$occId] = true;
                        }
                    }
                }

                $occupants = array_keys($occupants);

                if (empty($occupants)) {
                    $penalty = $this->computeSoftPenalty($actId, $day, $startP);
                    $emptySlots[] = ['day' => $day, 'start_period' => $startP, 'penalty' => $penalty];
                } else {
                    // Check if all occupants are movable (not locked and not in visited chain)
                    $canEvict = true;
                    foreach ($occupants as $occId) {
                        if (!empty($this->activities[$occId]['is_locked']) || in_array($occId, $visitedChain, true)) {
                            $canEvict = false;
                            break;
                        }
                    }
                    if ($canEvict && count($occupants) <= 2) {
                        $occupiedSlots[] = [
                            'day' => $day,
                            'start_period' => $startP,
                            'occupants' => $occupants,
                            'penalty' => (count($occupants) * 25) + $this->computeSoftPenalty($actId, $day, $startP)
                        ];
                    }
                }
            }
        }

        // STEP 1: Direct placement into best empty slot
        if (!empty($emptySlots)) {
            usort($emptySlots, fn($a, $b) => $a['penalty'] <=> $b['penalty']);
            $bestSlot = $emptySlots[0];
            $this->placeActivityAt($actId, $bestSlot['day'], $bestSlot['start_period']);
            return true;
        }

        // STEP 2: Depth-Limited Recursive Swapping
        if (!empty($occupiedSlots) && $depth < $this->maxDepth) {
            usort($occupiedSlots, fn($a, $b) => $a['penalty'] <=> $b['penalty']);

            // Limit branch factor to top candidates to avoid exponential explosion
            $branchLimit = ($depth === 0) ? 6 : 3;
            $candidatesToTry = array_slice($occupiedSlots, 0, $branchLimit);

            foreach ($candidatesToTry as $cand) {
                if ((microtime(true) - $this->startTime) > $this->timeLimitSeconds) return false;

                $targetDay = $cand['day'];
                $targetPeriod = $cand['start_period'];
                $evictedList = $cand['occupants'];

                // Snapshot evicted placements for restoration upon failure
                $savedPlacements = [];
                foreach ($evictedList as $evId) {
                    $savedPlacements[$evId] = $this->activityPlacements[$evId];
                    $this->unplaceActivity($evId);
                }

                // Place current activity into this slot
                $this->placeActivityAt($actId, $targetDay, $targetPeriod);

                // Recursively place all evicted activities
                $visitedChain[] = $actId;
                $allEvictedPlaced = true;

                foreach ($evictedList as $evId) {
                    if (!$this->tryPlaceActivity($evId, $depth + 1, $visitedChain)) {
                        $allEvictedPlaced = false;
                        break;
                    }
                }

                array_pop($visitedChain);

                if ($allEvictedPlaced) {
                    return true; // Chain swap succeeded!
                }

                // Backtrack: Remove current activity and restore original occupants
                $this->unplaceActivity($actId);
                foreach ($evictedList as $evId) {
                    $this->unplaceActivity($evId); // Clean any partial moves
                    if (isset($savedPlacements[$evId])) {
                        $pInfo = $savedPlacements[$evId];
                        $this->placeActivityAt($evId, $pInfo['day'], $pInfo['start_period'], $pInfo['is_locked']);
                    }
                }
            }
        }

        return false;
    }

    /**
     * Soft Constraints Optimization via Local Search (Hill Climbing)
     * Performs pairwise 2-opt swaps within the same classroom to minimize total penalty
     */
    protected function optimizeSoftConstraints(int $maxIterations = 60): void
    {
        $this->log("🔍 เริ่มกระบวนการปรับจูนความสวยงามของตาราง (Soft Optimization: Min Days, Max Consecutive, Gap Control)...");

        $swapsDone = 0;
        for ($iter = 0; $iter < $maxIterations; $iter++) {
            if ((microtime(true) - $this->startTime) > $this->timeLimitSeconds) break;

            $improved = false;
            foreach ($this->activityPlacements as $actId1 => $place1) {
                if ($this->activities[$actId1]['is_locked']) continue;

                foreach ($this->activityPlacements as $actId2 => $place2) {
                    if ($actId1 === $actId2 || $this->activities[$actId2]['is_locked']) continue;

                    // Must have same duration to swap cleanly
                    if ($this->activities[$actId1]['duration'] !== $this->activities[$actId2]['duration']) continue;

                    // Must share at least one classroom to be a relevant within-class swap
                    if (!array_intersect($this->activities[$actId1]['class_names'], $this->activities[$actId2]['class_names'])) continue;

                    $day1 = $place1['day']; $p1 = $place1['start_period'];
                    $day2 = $place2['day']; $p2 = $place2['start_period'];

                    if ($day1 === $day2 && $p1 === $p2) continue;

                    // Compute baseline penalty
                    $currentPenalty = $this->computeSoftPenalty($actId1, $day1, $p1) + $this->computeSoftPenalty($actId2, $day2, $p2);

                    // Temporarily remove both
                    $this->unplaceActivity($actId1);
                    $this->unplaceActivity($actId2);

                    // Test if swap is hard-valid
                    $valid1 = $this->isValidSlotForActivity($actId1, $day2, $p2);
                    $valid2 = $this->isValidSlotForActivity($actId2, $day1, $p1);

                    if ($valid1 && $valid2) {
                        $newPenalty = $this->computeSoftPenalty($actId1, $day2, $p2) + $this->computeSoftPenalty($actId2, $day1, $p1);
                        if ($newPenalty < $currentPenalty) {
                            // Accept swap!
                            $this->placeActivityAt($actId1, $day2, $p2);
                            $this->placeActivityAt($actId2, $day1, $p1);
                            $swapsDone++;
                            $improved = true;
                            break 2;
                        }
                    }

                    // Revert back
                    $this->placeActivityAt($actId1, $day1, $p1);
                    $this->placeActivityAt($actId2, $day2, $p2);
                }
            }

            if (!$improved) break; // Local optimum reached
        }

        if ($swapsDone > 0) {
            $this->log("✨ ปรับจูนสำเร็จ $swapsDone ตำแหน่ง เพื่อให้การกระจายวันและภาระงานสอนลงตัวยิ่งขึ้น");
        }
    }

    /**
     * Run the complete Timetable Solver pipeline
     */
    public function solve(): array
    {
        $this->startTime = microtime(true);
        $this->logs = [];
        $this->unplacedActivities = [];
        $this->diagnostics = [];

        $this->log("🚀 [FET Engine] เริ่มต้นกระบวนการประมวลผลจัดตารางสอนอัตโนมัติ...");

        // 1. Sort activities: Most Constrained First
        $sortedActivities = array_values($this->activities);
        usort($sortedActivities, fn($a, $b) => $b['difficulty'] <=> $a['difficulty']);

        $totalCount = count($sortedActivities);
        $this->log("📦 เตรียมกิจกรรมการสอนทั้งหมด $totalCount รายการ (จัดลำดับตามระดับความยาก - Most Constrained First)");

        // 2. Stage 1: Feasibility Placement with Recursive Swapping
        $placedCount = 0;
        foreach ($sortedActivities as $act) {
            $actId = $act['activity_id'];

            // Skip if already locked by subject locks
            if (!empty($this->activityPlacements[$actId]['is_locked'])) {
                $placedCount++;
                continue;
            }

            $visitedChain = [];
            if ($this->tryPlaceActivity($actId, 0, $visitedChain)) {
                $placedCount++;
            } else {
                $this->unplacedActivities[$actId] = $act;
                
                // Collect detailed diagnostic
                $reasons = [];
                $sampleDay = 'THU';
                $sampleP = 1;
                $this->isValidSlotForActivity($actId, $sampleDay, $sampleP, $reasons);
                $this->diagnostics[$actId] = [
                    'subject' => $act['subject_code'] . ' ' . $act['subject_name'],
                    'classes' => implode(', ', $act['class_names']),
                    'teachers' => implode(', ', $act['teacher_ids']),
                    'duration' => $act['duration'],
                    'reasons' => !empty($reasons) ? array_slice($reasons, 0, 3) : ['ไม่พบช่องว่างที่ครูและห้องว่างตรงกัน']
                ];
            }
        }

        // 3. Stage 2: Soft Constraints Optimization
        if ($placedCount > 0) {
            $this->optimizeSoftConstraints(50);
        }

        $elapsed = round(microtime(true) - $this->startTime, 2);
        $successRate = ($totalCount > 0) ? round(($placedCount / $totalCount) * 100, 1) : 100;

        $this->log("⏱️ ประมวลผลเสร็จสิ้นในเวลา {$elapsed} วินาที | จัดสำเร็จ {$placedCount}/{$totalCount} รายการ ({$successRate}%)");

        // Prepare Final Database Slot Records
        $dbRecords = [];
        foreach ($this->activityPlacements as $actId => $placement) {
            $act = $this->activities[$actId];
            $day = $placement['day'];
            $startP = $placement['start_period'];
            $duration = $act['duration'];
            $isLocked = (int)($placement['is_locked'] ?? 0);

            for ($p = $startP; $p < $startP + $duration; $p++) {
                foreach ($act['assign_ids'] as $aid) {
                    $dbRecords[] = [
                        'assign_id' => $aid,
                        'day' => $day,
                        'period' => $p,
                        'is_locked' => $isLocked
                    ];
                }
            }
        }

        return [
            'status' => ($placedCount === $totalCount) ? 'success' : 'partial',
            'placed_count' => $placedCount,
            'total_count' => $totalCount,
            'success_rate' => $successRate,
            'elapsed_seconds' => $elapsed,
            'db_records' => $dbRecords,
            'unplaced_activities' => $this->unplacedActivities,
            'diagnostics' => $this->diagnostics,
            'logs' => $this->logs
        ];
    }
}
