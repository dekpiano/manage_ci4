<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .report-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .timetable-report {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .timetable-report th, .timetable-report td {
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        height: 80px;
    }
    .timetable-report thead th {
        background: #f8f9fa;
        font-weight: bold;
        height: 60px;
    }
    .day-column {
        width: 100px;
        font-weight: bold;
        background: #f8f9fa;
    }
    .subject-box {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4px;
    }
    .subject-code {
        font-weight: bold;
        font-size: 0.9rem;
        color: #333;
    }
    .subject-detail {
        font-size: 0.75rem;
        color: #666;
        line-height: 1.2;
    }
    @media print {
        .btn-print-group { display: none !important; }
        .layout-navbar, .layout-menu-horizontal, .footer { display: none !important; }
        .content-wrapper { padding: 0 !important; margin: 0 !important; }
        .container-xxl { max-width: 100% !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        body { background: #fff !important; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4 btn-print-group">
        <div>
            <h4 class="fw-bold mb-0"><?= $title ?></h4>
            <div class="text-muted">ปีการศึกษา <?= $term ?>/<?= $year ?></div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4">
                <i class="bx bx-printer me-1"></i> พิมพ์ตาราง
            </button>
            <a href="<?= base_url('admin/academic/timetable/full') ?>" class="btn btn-label-secondary rounded-pill">
                <i class="bx bx-chevron-left me-1"></i> กลับไปตารางรวม
            </a>
        </div>
    </div>

    <div class="card report-card overflow-hidden">
        <div class="card-body p-4">
            <div class="text-center mb-4 position-relative">
                <h3 class="fw-bold mb-1"><?= $target_name ?></h3>
                <h5 class="text-muted">ตารางปฏิบัติการสอน / ตารางเรียน ภาคเรียนที่ <?= $term ?> ปีการศึกษา <?= $year ?></h5>
                
                <?php if(isset($total_hours)): ?>
                    <div class="position-absolute end-0 top-0 d-none d-md-block btn-print-group" style="margin-top: 5px;">
                        <div class="text-dark fw-bold border-dark border-2 pb-1">
                            <?= $total_hours ?> คาบ
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="timetable-report">
                    <thead>
                        <tr>
                            <th class="day-column">วัน / คาบ</th>
                            <?php foreach($periods as $p): ?>
                            <th>
                                <div>คาบที่ <?= $p->period_number ?></div>
                                <div class="fw-normal small"><?= date('H:i', strtotime($p->start_time)) ?> - <?= date('H:i', strtotime($p->end_time)) ?></div>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $dayLabels = [
                            'MON' => 'จันทร์',
                            'TUE' => 'อังคาร',
                            'WED' => 'พุธ',
                            'THU' => 'พฤหัสบดี',
                            'FRI' => 'ศุกร์',
                            'SAT' => 'เสาร์',
                            'SUN' => 'อาทิตย์'
                        ];
                        foreach($days as $d): 
                        ?>
                        <tr>
                            <td class="day-column"><?= $dayLabels[$d->day_key] ?? $d->day_name ?></td>
                            <?php foreach($periods as $p): 
                                $item = $grouped[$d->day_key][$p->period_number] ?? null;
                            ?>
                            <td>
                                <?php 
                                    $item = $grouped[$d->day_key][$p->period_number] ?? null;
                                    $master = $masterMap[$d->day_key][$p->period_number] ?? null;
                                    $isLunch = (isset($lunch_period) && (int)$p->period_number == (int)$lunch_period);
                                    $isBreak = ($p->is_break && ($p->level_group == 'ALL' || $p->level_group == ($currentLevel ?? '')));

                                    if($item): 
                                ?>
                                    <div class="subject-box">
                                        <div class="subject-code"><?= $item->tsub_code ?></div>
                                        <div class="subject-detail text-truncate" title="<?= $item->tsub_name ?>"><?= $item->tsub_name ?></div>
                                        <div class="subject-detail fw-bold mt-1">
                                            <?php if($target_type == 'teacher'): ?>
                                                ห้อง: <?= $item->class_name ?>
                                            <?php else: ?>
                                                ครู: <?= implode(', ', array_map(fn($id) => $teacherMap[$id] ?? $id, explode(',', $item->teacher_id))) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php elseif($master): ?>
                                    <div class="subject-box bg-label-secondary border-0 rounded">
                                        <div class="subject-code"><i class="bx bx-lock-alt me-1"></i><?= $master->subject_name ?></div>
                                        <div class="subject-detail">กิจกรรมส่วนกลาง</div>
                                    </div>
                                <?php elseif($isLunch || $isBreak): ?>
                                    <div class="bg-light h-100 d-flex align-items-center justify-content-center rounded border border-warning border-opacity-25">
                                        <span class="fw-bold <?= $isLunch ? 'text-danger' : 'text-muted' ?>">
                                            <?= $isLunch ? 'พักกลางวัน' : 'พัก' ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 small text-muted">
                * ข้อมูล ณ วันที่ <?= date('d/m/') . (date('Y')+543) ?> | ระบบจัดตารางสอนโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
