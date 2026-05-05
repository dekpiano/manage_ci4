<div class="table-responsive">
    <table class="table table-bordered text-center mb-0" style="table-layout: fixed; min-width: 800px;">
        <thead class="bg-light">
            <tr>
                <th style="width: 100px;">วัน / คาบ</th>
                <?php foreach($periods as $p): 
                    $isBreak = isset($break_map[$p->period_number]);
                    $isLunch = (isset($lunch_period) && (int)$p->period_number == (int)$lunch_period);
                ?>
                <th class="<?= ($isBreak || $isLunch) ? 'bg-label-warning' : '' ?>">
                    <div class="fw-bold">คาบ <?= $p->period_number ?></div>
                    <div class="small text-muted fw-normal" style="font-size: 0.65rem;">
                        <?= $time_map[$p->period_number] ?? '' ?>
                    </div>
                    <?php if($isLunch): ?>
                        <div class="text-danger" style="font-size: 0.6rem;">พักกลางวัน</div>
                    <?php endif; ?>
                </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($days as $day): if(!$day->is_active) continue; ?>
            <tr>
                <td class="fw-bold bg-light align-middle text-primary"><?= $day->day_name ?></td>
                <?php foreach($periods as $p): 
                    $isBreak = isset($break_map[$p->period_number]);
                    $isLunch = (isset($lunch_period) && (int)$p->period_number == (int)$lunch_period);
                    
                    $slotData = null;
                    $isMaster = false;
                    $masterName = '';

                    // Check Master Slots
                    foreach($master_slots as $ms) {
                        if($ms->day == $day->day_key && $ms->period == $p->period_number) {
                            $isMaster = true;
                            $masterName = $ms->subject_name;
                            break;
                        }
                    }

                    // Check Timetable Data
                    foreach($timetable_data as $td) {
                        if($td->day == $day->day_key && $td->period == $p->period_number) {
                            $slotData = $td;
                            break;
                        }
                    }
                ?>
                <td class="p-1 align-middle <?= ($isBreak || $isLunch) ? 'bg-label-warning' : '' ?>" style="height: 70px;">
                    <?php if($isLunch): ?>
                        <span class="small fw-bold">พักกลางวัน</span>
                    <?php elseif($isBreak): ?>
                        <span class="small fw-bold">พัก</span>
                    <?php elseif($isMaster): ?>
                        <div class="badge bg-label-info w-100 h-100 d-flex align-items-center justify-content-center text-wrap" style="font-size: 0.65rem;">
                            <?= $masterName ?>
                        </div>
                    <?php elseif($slotData): ?>
                        <div class="p-1 rounded bg-label-success h-100 d-flex flex-column justify-content-center border border-success border-opacity-10 shadow-xs">
                            <div class="fw-bold text-dark" style="font-size: 0.75rem;"><?= $slotData->tsub_code ?></div>
                            <div class="text-truncate small" title="<?= $slotData->tsub_name ?>" style="font-size: 0.65rem;"><?= $slotData->tsub_name ?></div>
                            <div class="mt-1 text-primary fw-semibold" style="font-size: 0.6rem;">
                                <i class='bx bx-user-voice' style="font-size: 0.65rem;"></i> 
                                <?php 
                                    $tids = explode(',', $slotData->teacher_id);
                                    $names = [];
                                    foreach($tids as $tid) $names[] = $teacher_map[$tid] ?? 'ไม่พบชื่อ';
                                    echo implode(', ', $names);
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
