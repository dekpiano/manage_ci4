<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    :root {
        --skj-primary: #15a362;
        --skj-secondary: #6c757d;
        --skj-light: #f8f9fa;
        --skj-border: #eef0f2;
    }

    .full-timetable-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: #fff;
    }

    /* Grid Container */
    .timetable-wrapper {
        position: relative;
        max-height: 75vh;
        overflow: auto;
        border-radius: 0.5rem;
        border: 1px solid var(--skj-border);
    }

    .timetable-master {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: fixed;
    }

    /* Sticky Headers */
    .timetable-master thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #fdfdfd;
        border-bottom: 2px solid var(--skj-border);
        padding: 1rem 0.5rem;
        text-align: center;
        font-weight: 700;
        color: #444;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Sticky Left Column (Class Names) */
    .timetable-master tbody th {
        position: sticky;
        left: 0;
        z-index: 90;
        background: #fff;
        border-right: 2px solid var(--skj-border);
        padding: 1rem;
        text-align: left;
        width: 120px;
        font-weight: 700;
        color: var(--skj-primary);
        box-shadow: 2px 0 4px rgba(0,0,0,0.02);
    }

    /* Top Left Corner */
    .timetable-master thead th:first-child {
        position: sticky;
        left: 0;
        top: 0;
        z-index: 110;
        background: #f8f9fa;
        width: 120px;
    }

    .timetable-master td {
        border: 1px solid var(--skj-border);
        padding: 0.4rem;
        vertical-align: middle;
        min-width: 130px;
        height: 85px;
        transition: all 0.2s ease;
    }

    .timetable-master tr:hover td {
        background-color: #fafbfc;
    }

    .timetable-master td:hover {
        background-color: #f0fdf4 !important;
        transform: scale(1.02);
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Cell Content Styles */
    .slot-item {
        height: 100%;
        width: 100%;
        border-radius: 0.6rem;
        padding: 0.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2px;
        font-size: 0.75rem;
        position: relative;
        transition: all 0.2s;
    }

    .slot-assignment {
        background: #e7f7ed;
        color: #065f46;
        border: 1px solid rgba(21, 163, 98, 0.1);
    }

    .slot-master {
        background: #f3f4f6;
        color: #374151;
        border: 1px dashed #d1d5db;
    }

    .slot-break {
        background: #fffcf0;
        color: #b45309;
        font-style: italic;
        opacity: 0.8;
    }

    .slot-conflict {
        background: #fff1f0 !important;
        border: 1.5px solid #ff3e1d !important;
        color: #991b1b !important;
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0% { box-shadow: 0 0 0 0 rgba(255, 62, 29, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(255, 62, 29, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 62, 29, 0); }
    }

    .subject-code {
        font-weight: 800;
        font-size: 0.85rem;
        letter-spacing: -0.01em;
    }

    .teacher-links {
        font-size: 0.65rem;
        opacity: 0.8;
    }

    .teacher-link {
        color: inherit;
        text-decoration: none;
    }
    .teacher-link:hover {
        text-decoration: underline;
        color: var(--skj-primary);
    }

    /* Day Pills */
    .day-selector {
        background: #fff;
        padding: 0.75rem;
        border-radius: 5rem;
        display: inline-flex;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--skj-border);
    }

    .day-pill {
        padding: 0.6rem 1.5rem;
        border-radius: 5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        color: #64748b;
        background: transparent;
    }

    .day-pill.active {
        background: var(--skj-primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.3);
    }

    .day-pill:hover:not(.active) {
        background: #f1f5f9;
        color: #334155;
    }

    /* Legend */
    .timetable-legend {
        display: flex;
        gap: 1.5rem;
        font-size: 0.75rem;
        margin-top: 1rem;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .legend-box {
        width: 14px;
        height: 14px;
        border-radius: 3px;
    }

    @media print {
        .btn-print-hide, .day-selector, .layout-navbar, .layout-menu { display: none !important; }
        .timetable-wrapper { max-height: none !important; overflow: visible !important; }
        .full-timetable-card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .timetable-master th, .timetable-master td { color: #000 !important; }
    }

    /* Ensure SweetAlert2 is always on top */
    .swal2-container {
        z-index: 9999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4 btn-print-hide">
        <div>
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">ระบบตารางสอน /</span> ตารางรวมทั้งโรงเรียน
            </h4>
            <div class="text-muted small mt-1">ปีการศึกษา <?= $term ?>/<?= $year ?> • ตรวจสอบจุดซ้ำซ้อนและกิจกรรมส่วนกลาง</div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bx bx-printer me-1"></i> พิมพ์ตาราง
            </button>
        </div>
    </div>

    <!-- Enhanced Day Selector -->
    <div class="text-center mb-4 btn-print-hide">
        <div class="day-selector">
            <?php foreach($days as $index => $d): ?>
            <button class="day-pill <?= $index === 0 ? 'active' : '' ?>" 
                    data-day="<?= $d->day_key ?>" 
                    onclick="switchDay('<?= $d->day_key ?>', this)">
                <?= $d->day_name ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card full-timetable-card">
        <div class="card-body p-3">
            <div class="timetable-wrapper">
                <?php foreach($days as $index => $d): ?>
                <div class="day-content <?= $index === 0 ? '' : 'd-none' ?>" id="content-<?= $d->day_key ?>">
                    <table class="timetable-master">
                        <thead>
                            <tr>
                                <th>ห้อง / คาบ</th>
                                <?php foreach($periods as $p): ?>
                                <th>
                                    <div class="mb-1">คาบ <?= $p->period_number ?></div>
                                    <div class="fw-normal text-muted" style="font-size: 0.65rem;">
                                        <?= date('H:i', strtotime($p->start_time)) ?>-<?= date('H:i', strtotime($p->end_time)) ?>
                                    </div>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($classList as $className): 
                                // 🔍 Determine level (Junior: ม.1-3 / Senior: ม.4-6)
                                $isSenior = (preg_match('/ม\.[4-6]/', $className) || preg_match('/^[4-6]/', $className));
                                $currentLevel = $isSenior ? 'Senior' : 'Junior';
                                $lunchPeriod = $isSenior ? 5 : 4;
                            ?>
                            <tr>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-chevron-right me-1 small opacity-50"></i>
                                        <a href="<?= base_url('admin/academic/timetable/view-class') ?>?class=<?= urlencode($className) ?>" 
                                           class="text-primary text-decoration-none hover-primary"><?= $className ?></a>
                                    </div>
                                </th>
                                <?php foreach($periods as $p): 
                                    $item = $grouped[$d->day_key][$className][$p->period_number] ?? null;
                                    $master = $masterMap[$d->day_key][$p->period_number]['ALL'] ?? 
                                              $masterMap[$d->day_key][$p->period_number][$currentLevel] ?? null;
                                    
                                    $hasConflict = false;
                                    $conflictInfo = "";
                                    
                                    if ($item) {
                                        $tids = array_map('trim', explode(',', $item->teacher_id));
                                        foreach($tids as $tid) {
                                            if (empty($tid)) continue;
                                            $usage = $teacherUsage[$d->day_key][$p->period_number][$tid] ?? [];
                                            if (count($usage) > 1) {
                                                $hasConflict = true;
                                                $conflictInfo = "ครู " . ($teacherMap[$tid] ?? $tid) . " สอนซ้ำในห้อง: " . implode(', ', $usage);
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                <?php 
                                    $isLunch = ((int)$p->period_number == (int)$lunchPeriod);
                                ?>
                                <td class="<?= $hasConflict ? 'cell-conflict' : '' ?>" title="<?= $hasConflict ? $conflictInfo : '' ?>">
                                    <?php if($item): ?>
                                        <div class="slot-item slot-assignment <?= $hasConflict ? 'slot-conflict' : '' ?>">
                                            <div class="subject-code"><?= $item->tsub_code ?></div>
                                            <div class="teacher-links text-truncate w-100 text-center">
                                                <?php 
                                                    $tids = explode(',', $item->teacher_id);
                                                    foreach($tids as $idx => $tid):
                                                        $tname = $teacherMap[$tid] ?? $tid;
                                                ?>
                                                    <a href="<?= base_url('admin/academic/timetable/view-teacher') ?>?id=<?= $tid ?>" class="teacher-link"><?= $tname ?></a><?= ($idx < count($tids)-1) ? ',' : '' ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if($hasConflict): ?>
                                                <i class="bx bxs-error-circle position-absolute top-0 end-0 m-1" style="font-size: 0.8rem;"></i>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif($master): ?>
                                        <div class="slot-item slot-master">
                                            <div class="fw-bold"><i class="bx bx-lock-alt me-1"></i><?= $master->subject_name ?></div>
                                            <div class="opacity-75" style="font-size: 0.55rem;">กิจกรรมส่วนกลาง</div>
                                        </div>
                                    <?php elseif($isLunch): ?>
                                        <div class="slot-item slot-break border border-warning border-opacity-25">
                                            <span class="fw-bold text-danger" style="font-size: 0.6rem;">พักกลางวัน</span>
                                        </div>
                                    <?php elseif($p->is_break): ?>
                                        <div class="slot-item slot-break">
                                            <span>พักกลางวัน</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Legend and Footer Info -->
            <div class="d-flex justify-content-between align-items-center mt-3 btn-print-hide">
                <div class="timetable-legend">
                    <div class="legend-item">
                        <div class="legend-box slot-assignment"></div>
                        <span>วิชาเรียนปกติ</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box slot-master"></div>
                        <span>กิจกรรมส่วนกลาง (ล็อค)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box bg-label-danger" style="border: 1px solid #ff3e1d"></div>
                        <span>จุดซ้ำซ้อน (Conflict)</span>
                    </div>
                </div>
                <div class="text-muted small">
                    * เลื่อนตารางไปทางขวาเพื่อดูคาบเรียนเพิ่มเติม
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function switchDay(dayKey, el) {
    // UI Update
    $('.day-pill').removeClass('active');
    $(el).addClass('active');
    
    // Content Update with smooth transition
    $('.day-content').addClass('d-none');
    $('#content-' + dayKey).hide().removeClass('d-none').fadeIn(300);
}

// Tooltip initialization if needed
$(function () {
    // Optional: add tooltips for conflict info
});
</script>
<?= $this->endSection() ?>
