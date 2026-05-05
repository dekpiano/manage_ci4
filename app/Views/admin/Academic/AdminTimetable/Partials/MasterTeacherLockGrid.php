<?php 
    // คำนวณความกว้างทั้งหมดที่ต้องใช้
    $teacherWidth = 150;
    $periodWidth = 25;
    $activeDaysCount = 0;
    foreach($days as $day) if($day->is_active) $activeDaysCount++;
    $totalPeriods = $activeDaysCount * count($periods);
    $totalTableWidth = $teacherWidth + ($totalPeriods * $periodWidth);
?>
<style>
    .master-teacher-wrapper {
        position: relative;
        max-height: 70vh;
        overflow: scroll !important;
        border-radius: 12px;
        border: 1px solid #e6e8eb;
        background: #fff;
    }

    .master-teacher-table {
        border-collapse: separate;
        border-spacing: 0;
        table-layout: fixed !important; /* บังคับใช้ขนาดที่กำหนดเท่านั้น */
        width: <?= $totalTableWidth ?>px !important; /* กำหนดความกว้างรวมแบบตายตัว */
    }

    /* 📌 Sticky Header & Column */
    .master-teacher-table thead tr:first-child th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #f8f9fa;
        border-bottom: 2px solid #e6e8eb;
        height: 35px;
        font-size: 0.7rem;
    }
    .master-teacher-table thead tr:nth-child(2) th {
        position: sticky;
        top: 35px;
        z-index: 100;
        background: #fdfdfd;
        border-bottom: 1px solid #e6e8eb;
        height: 25px;
    }
    .master-teacher-table td:first-child, 
    .master-teacher-table th:first-child {
        position: sticky;
        left: 0;
        z-index: 90;
        background: #fff;
        border-right: 2px solid #e6e8eb;
        font-weight: 700;
        color: #d9534f;
        width: <?= $teacherWidth ?>px !important;
        text-align: left !important;
        padding-left: 8px !important;
        font-size: 0.7rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .master-teacher-table thead tr:first-child th:first-child {
        z-index: 110;
        background: #d9534f !important;
        color: #fff !important;
    }
    .master-teacher-table thead tr:nth-child(2) th:first-child {
        z-index: 110;
    }

    /* 🎨 Cell Styles */
    .teacher-lock-cell {
        height: 28px;
        transition: all 0.2s ease;
        padding: 0 !important; /* เอา Padding ออกเพื่อให้ช่องเท่ากันเป๊ะ */
        width: <?= $periodWidth ?>px !important;
        overflow: hidden;
    }
    .lock-indicator {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(217, 83, 79, 0.1);
        color: #d9534f;
        font-weight: bold;
        font-size: 0.6rem;
    }
    
    .teacher-group-row {
        background-color: #f8f9fa !important;
        font-weight: bold;
        font-size: 0.65rem;
        color: #566a7f;
        height: 25px;
    }
</style>

<div class="mb-3 d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm border border-light">
    <div>
        <h6 class="mb-0 fw-bold text-dark"><i class='bx bx-user-x me-1 text-danger'></i> สรุปภาพรวมเวลาไม่ว่างของครู (Teacher Availability)</h6>
        <p class="small text-muted mb-0">ช่องสีแดง <span class="badge bg-label-danger p-1">X</span> หมายถึงครูไม่ว่างในคาบนั้นๆ</p>
    </div>
</div>

<div class="master-teacher-wrapper shadow-none border rounded-3 overflow-hidden">
    <table class="table master-teacher-table mb-0 text-center">
        <!-- 📌 บังคับขนาดคอลัมน์ด้วย <colgroup> และ Pixel ที่แน่นอน -->
        <colgroup>
            <col style="width: <?= $teacherWidth ?>px;">
            <?php for($i=0; $i<$totalPeriods; $i++): ?>
                <col style="width: <?= $periodWidth ?>px;">
            <?php endfor; ?>
        </colgroup>
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">ชื่อครูผู้สอน</th>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                <th colspan="<?= count($periods) ?>" class="py-2 border-start" style="background: #fdf5f5;">
                    <span class="fw-bold" style="color: #d9534f;"><?= $day->day_name ?></span>
                </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                    <?php foreach($periods as $p): ?>
                    <th class="py-1 border-start small text-muted fw-normal" style="font-size: 0.6rem;">
                        <?= $p->period_number ?>
                    </th>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $currentGroup = '';
            foreach($teachers as $t): 
                if($currentGroup != $t->pers_learning): $currentGroup = $t->pers_learning; ?>
                <tr class="teacher-group-row">
                    <td colspan="<?= 1 + $totalPeriods ?>" class="text-start ps-3 py-1">
                        <i class='bx bx-group me-1'></i> กลุ่มสาระฯ <?= $currentGroup ?: 'ไม่ระบุ' ?>
                    </td>
                </tr>
                <?php endif; ?>
            <tr>
                <td class="text-truncate" title="<?= $t->pers_prefix.$t->pers_firstname.' '.$t->pers_lastname ?>">
                    <?= $t->pers_prefix.$t->pers_firstname ?>
                </td>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                    <?php foreach($periods as $p): 
                        $isLocked = isset($lockMap[$t->pers_id][$day->day_key][$p->period_number]);
                    ?>
                    <td class="teacher-lock-cell border-start align-middle">
                        <?php if($isLocked): ?>
                            <div class="lock-indicator" title="ครูไม่ว่าง"><i class='bx bx-x small'></i></div>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // Initialize tooltips for the new grid
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
</script>
