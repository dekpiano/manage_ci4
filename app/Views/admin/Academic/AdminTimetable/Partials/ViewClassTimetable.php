<?php
/**
 * Helper function for color-coding subjects by Learning Area (กลุ่มสาระการเรียนรู้)
 */
$getSubjectTheme = function($code) {
    $firstChar = mb_substr(trim((string)$code), 0, 1, 'UTF-8');
    
    // Group by Subject Learning Area (หมวดสาระการเรียนรู้)
    $categoryColors = [
        'ท' => ['bg' => '#FFF3E0', 'text' => '#BF360C', 'border' => '#FFB74D', 'label' => 'ภาษาไทย'],                     // ภาษาไทย (ส้ม/พีช)
        'ค' => ['bg' => '#E0F7FA', 'text' => '#006064', 'border' => '#4DD0E1', 'label' => 'คณิตศาสตร์'],                   // คณิตศาสตร์ (ฟ้าครามสดใส)
        'ว' => ['bg' => '#E8F5E9', 'text' => '#1B5E20', 'border' => '#81C784', 'label' => 'วิทยาศาสตร์และเทคโนโลยี'],      // วิทย์/เทคโน (เขียวมิ้นต์)
        'ส' => ['bg' => '#F3E5F5', 'text' => '#4A148C', 'border' => '#BA68C8', 'label' => 'สังคมศึกษาฯ'],                  // สังคมศึกษา (ม่วงพาสเทล)
        'พ' => ['bg' => '#FCE4EC', 'text' => '#880E4F', 'border' => '#F06292', 'label' => 'สุขศึกษาและพลศึกษา'],            // สุขศึกษา/พละ (ชมพูกุหลาบ)
        'ศ' => ['bg' => '#FFF9C4', 'text' => '#E65100', 'border' => '#FFD54F', 'label' => 'ศิลปะ ดนตรี นาฏศิลป์'],        // ศิลปะ (เหลืองทอง)
        'ง' => ['bg' => '#E0F2F1', 'text' => '#004D40', 'border' => '#4DB6AC', 'label' => 'การงานอาชีพ'],                  // การงานอาชีพ (Teal)
        'อ' => ['bg' => '#EDE7F6', 'text' => '#311B92', 'border' => '#9575CD', 'label' => 'ภาษาต่างประเทศ (อังกฤษ)'],       // ภาษาอังกฤษ (Indigo/คราม)
        'จ' => ['bg' => '#FBE9E7', 'text' => '#BF360C', 'border' => '#FF8A65', 'label' => 'ภาษาต่างประเทศ (จีน)'],          // ภาษาจีน (โอรส/แดงชาด)
        'ญ' => ['bg' => '#FCE4EC', 'text' => '#880E4F', 'border' => '#F48FB1', 'label' => 'ภาษาต่างประเทศ (ญี่ปุ่น)'],      // ภาษาญี่ปุ่น (ซากุระ)
        'ก' => ['bg' => '#F1F8E9', 'text' => '#33691E', 'border' => '#AED581', 'label' => 'กิจกรรมพัฒนาผู้เรียน'],          // กิจกรรม (เขียวตอง)
        'I' => ['bg' => '#E8EAF6', 'text' => '#1A237E', 'border' => '#7986CB', 'label' => 'IS / การศึกษาค้นคว้า'],           // IS
        'i' => ['bg' => '#E8EAF6', 'text' => '#1A237E', 'border' => '#7986CB', 'label' => 'IS / การศึกษาค้นคว้า'],
    ];

    if (isset($categoryColors[$firstChar])) {
        return $categoryColors[$firstChar];
    }

    // Dynamic curated fallback palette for other electives / supplementary courses
    $palettes = [
        ['bg' => '#E3F2FD', 'text' => '#0D47A1', 'border' => '#64B5F6', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#F3E5F5', 'text' => '#4A148C', 'border' => '#BA68C8', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#E8F5E9', 'text' => '#1B5E20', 'border' => '#81C784', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#FFF3E0', 'text' => '#E65100', 'border' => '#FFB74D', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#FCE4EC', 'text' => '#880E4F', 'border' => '#F06292', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#E0F7FA', 'text' => '#006064', 'border' => '#4DD0E1', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#EDE7F6', 'text' => '#311B92', 'border' => '#9575CD', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#FBE9E7', 'text' => '#BF360C', 'border' => '#FF8A65', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#E0F2F1', 'text' => '#004D40', 'border' => '#4DB6AC', 'label' => 'วิชาเพิ่มเติม'],
        ['bg' => '#F9FBE7', 'text' => '#827717', 'border' => '#DCE775', 'label' => 'วิชาเพิ่มเติม'],
    ];

    $hash = abs(crc32((string)$code));
    return $palettes[$hash % count($palettes)];
};
?>

<div class="table-responsive rounded-3 border">
    <table class="table table-bordered text-center mb-0 align-middle" style="table-layout: fixed; min-width: 850px;">
        <thead class="modern-table-header">
            <tr>
                <th style="width: 110px; background-color: #f8fafc;" class="text-dark fw-bold">วัน / คาบ</th>
                <?php foreach($periods as $p): 
                    $isBreak = isset($break_map[$p->period_number]);
                    $isLunch = (isset($lunch_period) && (int)$p->period_number == (int)$lunch_period);
                ?>
                <th class="<?= ($isBreak || $isLunch) ? 'bg-label-warning' : '' ?>" style="background-color: <?= ($isBreak || $isLunch) ? '#fff8e6' : '#f8fafc' ?>;">
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">คาบ <?= $p->period_number ?></div>
                    <div class="small text-muted fw-normal" style="font-size: 0.68rem;">
                        <?= $time_map[$p->period_number] ?? '' ?>
                    </div>
                    <?php if($isLunch): ?>
                        <div class="text-danger fw-bold" style="font-size: 0.65rem;">พักกลางวัน</div>
                    <?php endif; ?>
                </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($days as $day): if(!$day->is_active) continue; ?>
            <tr>
                <td class="fw-bold bg-light align-middle text-dark" style="font-size: 0.85rem;">
                    <?= $day->day_name ?>
                </td>
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
                <td class="p-1 align-middle <?= ($isBreak || $isLunch) ? 'bg-label-warning' : '' ?>" style="height: 76px; background-color: <?= ($isBreak || $isLunch) ? '#fffdf7' : '#ffffff' ?>;">
                    <?php if($isLunch): ?>
                        <span class="small fw-bold text-danger"><i class="bx bx-dish me-1"></i>พักกลางวัน</span>
                    <?php elseif($isBreak): ?>
                        <span class="small fw-bold text-warning"><i class="bx bx-coffee me-1"></i>พัก</span>
                    <?php elseif($isMaster): ?>
                        <div class="badge bg-label-info w-100 h-100 d-flex align-items-center justify-content-center text-wrap shadow-xs p-1" style="font-size: 0.7rem; border: 1px solid #bae6fd;">
                            <i class="bx bx-lock-alt me-1"></i><?= $masterName ?>
                        </div>
                    <?php elseif($slotData): 
                        $theme = $getSubjectTheme($slotData->tsub_code);
                    ?>
                        <div class="p-1 px-1 rounded-2 h-100 d-flex flex-column justify-content-center shadow-xs position-relative overflow-hidden" 
                             style="background-color: <?= $theme['bg'] ?> !important; border: 1.5px solid <?= $theme['border'] ?> !important;">
                            <div class="fw-bold" style="font-size: 0.78rem; color: <?= $theme['text'] ?> !important; line-height: 1.1;">
                                <?= esc($slotData->tsub_code) ?>
                            </div>
                            <div class="text-truncate fw-semibold mt-0.5" title="<?= esc($slotData->tsub_name) ?>" style="font-size: 0.68rem; color: #1e293b;">
                                <?= esc($slotData->tsub_name) ?>
                            </div>
                            <div class="mt-1 fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.62rem; color: <?= $theme['text'] ?>;">
                                <i class='bx bx-user' style="font-size: 0.7rem;"></i> 
                                <span class="text-truncate" style="max-width: 90%;">
                                    <?php 
                                        $tids = explode(',', $slotData->teacher_id);
                                        $names = [];
                                        foreach($tids as $tid) $names[] = $teacher_map[$tid] ?? 'ไม่พบชื่อ';
                                        echo esc(implode(', ', $names));
                                    ?>
                                </span>
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

<!-- 🎨 Subject Learning Areas Color Legend -->
<div class="mt-3 p-2 px-3 rounded-3 bg-light-subtle border d-flex align-items-center justify-content-between flex-wrap gap-2" style="font-size: 0.72rem;">
    <div class="fw-bold text-muted d-flex align-items-center gap-1">
        <i class="bx bx-palette text-primary"></i> <span>รหัสสีกลุ่มสาระ:</span>
    </div>
    <div class="d-flex align-items-center flex-wrap gap-2">
        <span class="badge rounded-pill border px-2 py-1" style="background: #FFF3E0; color: #BF360C; border-color: #FFB74D !important;">ท ภาษาไทย</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #E0F7FA; color: #006064; border-color: #4DD0E1 !important;">ค คณิตศาสตร์</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #E8F5E9; color: #1B5E20; border-color: #81C784 !important;">ว วิทยาศาสตร์/เทคโน</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #F3E5F5; color: #4A148C; border-color: #BA68C8 !important;">ส สังคมศึกษา</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #FCE4EC; color: #880E4F; border-color: #F06292 !important;">พ สุขศึกษา/พละ</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #FFF9C4; color: #E65100; border-color: #FFD54F !important;">ศ ศิลปะ</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #E0F2F1; color: #004D40; border-color: #4DB6AC !important;">ง การงานฯ</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #EDE7F6; color: #311B92; border-color: #9575CD !important;">อ/จ ภาษาต่างประเทศ</span>
        <span class="badge rounded-pill border px-2 py-1" style="background: #F1F8E9; color: #33691E; border-color: #AED581 !important;">ก กิจกรรม</span>
    </div>
</div>

