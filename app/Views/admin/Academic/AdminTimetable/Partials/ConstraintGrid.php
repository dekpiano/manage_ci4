<!-- ⬅️ HIDDEN SUBJECT LIST -->
<div id="tempSubjectList" class="d-none">
    <div class="d-flex flex-column gap-2">
        <?php 
        foreach($assigned_subjects as $as): 
            $totalLocked = 0;
            foreach($locks as $l) { 
                if(trim((string)$l->tsub_code) === trim((string)$as->tsub_code)) $totalLocked++; 
            }
            $isFull = ($totalLocked >= (int)$as->hours_per_week);
            
            $split_parts = $as->period_split ? explode(',', $as->period_split) : [$as->hours_per_week];
            $currentSegmentSize = 0;
            $segmentIndex = 0;
            $tempLocked = $totalLocked;
            
            foreach($split_parts as $idx => $part) {
                $pVal = intval($part);
                if($tempLocked >= $pVal) {
                    $tempLocked -= $pVal;
                } else {
                    $currentSegmentSize = $pVal;
                    $segmentIndex = $idx + 1;
                    break;
                }
            }
            
            if($isFull || $currentSegmentSize == 0) {
                $currentSegmentSize = 0; 
                $segLabel = "ลงครบแล้ว";
            } else {
                $segLabel = "ครั้งที่ $segmentIndex ($currentSegmentSize คาบ)";
            }
        ?>
        <div class="subject-card-wizard p-2 border rounded bg-white shadow-sm" 
             draggable="<?= ($currentSegmentSize > 0) ? 'true' : 'false' ?>" 
             ondragstart="drag(event, '<?= $as->subject_id ?>', '<?= $as->tsub_code ?>', '<?= $as->tsub_name ?>', <?= $currentSegmentSize ?>, '<?= $as->teacher_id ?>', <?= $as->has_junior ? 1 : 0 ?>, <?= $as->has_senior ? 1 : 0 ?>)"
             style="cursor: <?= ($currentSegmentSize > 0) ? 'grab' : 'not-allowed' ?>; border-left: 5px solid #<?= ($currentSegmentSize > 0) ? '696cff' : 'd1d3e2' ?> !important; opacity: <?= ($currentSegmentSize > 0) ? '1' : '0.6' ?>;">
            
            <div class="d-flex justify-content-between align-items-start mb-1">
                <div class="overflow-hidden me-2">
                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.75rem;"><?= $as->tsub_name ?></div>
                    <div class="small text-muted" style="font-size: 0.65rem;"><?= $as->tsub_code ?></div>
                </div>
                <span class="badge bg-<?= $isFull ? 'success' : 'label-warning' ?> p-1" style="font-size: 0.6rem;">
                    <?= $totalLocked ?>/<?= $as->hours_per_week ?>
                </span>
            </div>

            <div class="mt-1 pt-1 border-top" style="font-size: 0.65rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-primary fw-bold">หั่น: <?= $as->period_split ?: $as->hours_per_week ?></span>
                    <span class="text-<?= ($currentSegmentSize > 0) ? 'info' : 'muted' ?>"><?= $segLabel ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ⚙️ SCRIPT DATA FOR JS -->
<script>
    window._teacherLocks = <?= json_encode($teacher_locks) ?>;
    window._teacherBusy = <?= json_encode($teacher_busy) ?>;
    window._classLevel = <?= (int)$class_level ?>;
</script>

<!-- ➡️ GRID CONTENT -->
<div class="table-responsive">
    <table class="table table-bordered m-0 table-hover" id="constraintTable" style="font-size: 0.75rem;">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 100px;">วัน / คาบ</th>
                <?php foreach($periods as $p): ?>
                <th class="py-2">
                    <div class="fw-bold">คาบ <?= $p->period_number ?></div>
                    <div class="small text-muted"><?= date('H:i', strtotime($p->start_time)) ?></div>
                </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $dayMap = [
                'MON' => ['จันทร์', '#ffebee', '#f44336'],
                'TUE' => ['อังคาร', '#fce4ec', '#e91e63'],
                'WED' => ['พุธ', '#e8f5e9', '#4caf50'],
                'THU' => ['พฤหัสบดี', '#fff3e0', '#ff9800'],
                'FRI' => ['ศุกร์', '#e3f2fd', '#2196f3'],
                'SAT' => ['เสาร์', '#f3e5f5', '#9c27b0'],
                'SUN' => ['อาทิตย์', '#fffde7', '#fbc02d']
            ];
            foreach($days as $day): 
                if(!$day->is_active) continue;
                $colors = $dayMap[$day->day_key] ?? ['#f8f9fa', '#6c757d'];
            ?>
            <tr>
                <td class="fw-bold text-center align-middle" style="background: <?= $colors[0] ?>; color: <?= $colors[1] ?>; height: 65px;">
                    <?= $day->day_name ?>
                </td>
                <?php 
                foreach($periods as $p): 
                    $locked_sub = null;
                    foreach($locks as $l) { if($l->day == $day->day_key && $l->period == $p->period_number) { $locked_sub = $l; break; } }
                    
                    // 🍱 LUNCH BREAK LOGIC (แยก ม.ต้น คาบ 4 / ม.ปลาย คาบ 5)
                    $isLunch = false;
                    if ($class_level >= 1 && $class_level <= 3 && (int)$p->period_number == 4) $isLunch = true; 
                    if ($class_level >= 4 && $class_level <= 6 && (int)$p->period_number == 5) $isLunch = true; 
                    
                    // 🛑 GLOBAL BREAK CONFIG (จากระบบตั้งค่าคาบเรียน)
                    $isBreakConfig = false;
                    foreach($all_period_configs as $apc) { 
                        if((int)$apc->period_number == (int)$p->period_number && $apc->is_break == 1) { 
                            $isBreakConfig = true; 
                            break; 
                        } 
                    }
                    
                    // 🧠 SMART OVERRIDE: แยกเงื่อนไขตามชั้น
                    // ถ้าเป็นคาบ 4 หรือ 5 แต่ไม่ใช่เวลาพักของระดับชั้นนั้น ให้ "ปลดล็อค" ให้ลงวิชาได้
                    if (((int)$p->period_number == 4 || (int)$p->period_number == 5) && !$isLunch) {
                        $isForbidden = false; 
                    } else {
                        $isForbidden = ($isLunch || $isBreakConfig);
                    }
                    
                    $masterSlot = null;
                    foreach($master_slots as $ms) { if($ms->day == $day->day_key && $ms->period == $p->period_number) { $masterSlot = $ms; break; } }

                    // 👨‍🏫 TEACHER BUSY LOGIC (Check if ANY teacher of THIS class is busy)
                    $busyTeachersNames = [];
                    $teacherIdsInClass = [];
                    foreach($assigned_subjects as $as) {
                        foreach(explode(',', $as->teacher_id) as $tid) {
                            $tid = trim($tid); if($tid) $teacherIdsInClass[] = $tid;
                        }
                    }
                    $teacherIdsInClass = array_unique($teacherIdsInClass);

                    foreach($teacherIdsInClass as $tid) {
                        // Check Manual Locks
                        foreach($teacher_locks as $tl) {
                            if($tl->teacher_id == $tid && $tl->day == $day->day_key && $tl->period == $p->period_number) {
                                $busyTeachersNames[] = "ครู ".($teacherMap[$tid] ?? $tid)." (ล็อคไม่ว่าง)";
                            }
                        }
                        // Check Other Assignments
                        foreach($teacher_busy as $tb) {
                            if($tb->day == $day->day_key && $tb->period == $p->period_number && in_array($tid, explode(',', $tb->teacher_id))) {
                                if ($tb->class_name != $selected_class) { // Only show if busy in OTHER class
                                    $busyTeachersNames[] = "ครู ".($teacherMap[$tid] ?? $tid)." (สอนห้อง $tb->class_name)";
                                }
                            }
                        }
                    }
                    $busyTeachersNames = array_unique($busyTeachersNames);
                ?>
                <?php if($isForbidden): ?>
                    <td class="bg-light text-center align-middle text-muted small slot-forbidden" 
                        data-is-forbidden="1" data-day="<?= $day->day_key ?>" data-period="<?= $p->period_number ?>"
                        style="opacity: 0.6; background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(0,0,0,.02) 5px, rgba(0,0,0,.02) 10px);">
                        <div class="fw-bold"><?= $isLunch ? 'พักกลางวัน' : 'พัก' ?></div>
                    </td>
                <?php elseif($masterSlot): ?>
                    <td class="bg-label-info text-center align-middle p-1">
                        <div class="small fw-bold border border-info border-dashed rounded p-1 d-flex align-items-center justify-content-center text-info" style="height: 50px; font-size: 0.6rem; background: rgba(3, 195, 236, 0.05);">
                            <?= mb_substr($masterSlot->subject_name, 0, 15) ?>
                        </div>
                    </td>
                <?php elseif($locked_sub): ?>
                    <td class="p-1 align-middle">
                        <div class="lock-slot-wizard border rounded-3 d-flex flex-column align-items-center justify-content-center text-center bg-label-success border-success fw-bold" 
                             onclick="removeLockWizard('<?= $day->day_key ?>', '<?= $p->period_number ?>')"
                             style="height: 50px; transition: all 0.2s ease; cursor: pointer; position: relative;">
                            <div style="font-size: 0.7rem;" class="text-dark"><?= $locked_sub->tsub_code ?></div>
                            <div class="text-truncate px-1 text-muted" style="font-size: 0.55rem; width: 100%;"><?= $locked_sub->tsub_name ?></div>
                            <button type="button" class="btn btn-danger btn-icon btn-xs rounded-circle shadow-sm"
                                    style="position: absolute; top: -8px; right: -8px; width: 22px; height: 22px; z-index: 10;">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                    </td>
                <?php else: ?>
                    <td class="p-1 align-middle slot-empty <?= !empty($busyTeachersNames) ? 'bg-label-warning' : '' ?>" 
                        data-day="<?= $day->day_key ?>" 
                        data-period="<?= $p->period_number ?>"
                        title="<?= !empty($busyTeachersNames) ? implode("\n", $busyTeachersNames) : '' ?>"
                        ondrop="dropConstraint(event, '<?= $day->day_key ?>', '<?= $p->period_number ?>')" 
                        ondragover="allowDrop(event)"
                        ondragenter="highlightSlots(this, true)"
                        ondragleave="highlightSlots(this, false)">
                        <div class="lock-slot-wizard border border-dashed rounded d-flex flex-column align-items-center justify-content-center text-center text-muted" 
                             style="height: 50px; transition: all 0.2s ease; opacity: <?= !empty($busyTeachersNames) ? '0.5' : '0.2' ?>;">
                            <?php if(!empty($busyTeachersNames)): ?>
                                <i class="bx bx-error-circle small text-warning"></i>
                                <div style="font-size: 0.5rem;" class="text-warning mt-1">ครูไม่ว่าง</div>
                            <?php else: ?>
                                <i class="bx bx-plus small"></i>
                            <?php endif; ?>
                        </div>
                    </td>
                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
