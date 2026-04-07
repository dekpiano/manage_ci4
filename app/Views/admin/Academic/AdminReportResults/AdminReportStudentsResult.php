<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Student Section */
    .hero-student {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-student::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .gpa-display {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        text-align: center;
        min-width: 140px;
    }

    /* Premium Cards */
    .result-card { border: none; border-radius: 1.25rem; box-shadow: 0 5px 20px rgba(0,0,0,0.03); }
    .icon-wrapper-large { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: var(--light-emerald); color: var(--primary-emerald); }

    /* Accordion Custom */
    .accordion-item-emerald {
        border: 1px solid rgba(21, 163, 98, 0.1) !important;
        border-radius: 1.25rem !important;
        overflow: hidden;
        margin-bottom: 1rem !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .accordion-button-emerald {
        background-color: white !important;
        color: var(--dark-emerald) !important;
        font-weight: 700;
        padding: 1.25rem;
    }
    .accordion-button-emerald:not(.collapsed) {
        background-color: var(--light-emerald) !important;
        border-bottom: 1px solid rgba(21, 163, 98, 0.1);
    }
    .accordion-button-emerald::after { filter: hue-rotate(90deg) brightness(0.5); }

    /* Table Emerald */
    .table-emerald thead th { background-color: var(--light-emerald) !important; color: var(--dark-emerald); font-weight: 700; font-size: 0.75rem; text-transform: uppercase; padding: 12px 15px !important; }
    .table-emerald tbody td { padding: 12px 15px !important; border-bottom: 1px solid #f1f3f5; }

    /* Badges */
    .badge-grade { min-width: 35px; height: 35px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; }
    .grade-top { background: var(--primary-emerald); color: white; }
    .grade-mid { background: #ffc107; color: #000; }
    .grade-fail { background: #ef4444; color: white; }

    .btn-emerald-outline { border: 1px solid rgba(255, 255, 255, 0.4); color: white; border-radius: 10px; padding: 0.5rem 1rem; transition: all 0.3s; background: rgba(255,255,255,0.1); }
    .btn-emerald-outline:hover { background: white; color: var(--primary-emerald); }

    @media print { .hero-student { background: #fff !important; color: #000 !important; border: 1px solid #ddd; } .btn, .breadcrumb { display: none !important; } }
</style>

<?php 
// Calculate totals
$AllUnit = 0; $AllGrade = 0; 
foreach ($scoreYear as $key_year => $v_scoreYear) {
    $SubGrade = 0;
    foreach ($scoreStudent as $key => $score ){
        if($v_scoreYear->RegisterYear == $score->RegisterYear && $v_scoreYear->RegisterYear == $score->SubjectYear){
            $AllUnit += floatval(floatval($score->SubjectUnit));
            if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == ''){
                $SubGrade += (floatval($score->SubjectUnit)*0);
            }else{
                $SubGrade += ((floatval($score->SubjectUnit))*($score->Grade));
            }
        }
    }$AllGrade += $SubGrade; 
}            
$overallGPA = ($AllUnit != 0) ? number_format(floor(($AllGrade/$AllUnit) * 100) / 100, 2, '.', '') : '0.00';
?>

<div class="animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-student">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 small">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-white opacity-75">รายงานรายบุคคล</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">โปรไฟล์ผลการเรียน</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center flex-wrap">
                    <div class="avatar avatar-xl me-4 mb-3 mb-md-0 border border-3 border-white border-opacity-25 rounded-circle shadow-lg" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700;">
                        <?= mb_substr($stu->StudentFirstName ?? 'S', 0, 1) ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1 text-white"><?= esc($stu->StudentPrefix . $stu->StudentFirstName . ' ' . $stu->StudentLastName) ?></h2>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-white opacity-75"><i class='bx bx-id-card me-1'></i> รหัส: <?= esc($stu->StudentCode) ?></span>
                            <span class="text-white opacity-75"><i class='bx bx-door-open me-1'></i> ม.<?= esc($stu->StudentClass) ?></span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <?php 
                        $hasJunior = false; $hasSenior = false;
                        foreach ($scoreYear as $yr) {
                            $cl = (string)$yr->RegisterClass;
                            if (preg_match('/[1-3]/', $cl)) $hasJunior = true;
                            if (preg_match('/[4-6]/', $cl)) $hasSenior = true;
                        }
                        $levelSeg = service('request')->getUri()->getSegment(3) ?? 'Evaluate';
                        $printBase = base_url("Admin/Acade/{$levelSeg}/PrintTranscript/".esc($stu->StudentID));
                    ?>
                    <?php if ($hasJunior): ?>
                        <a href="<?= $printBase ?>/junior" target="_blank" class="btn-emerald-outline btn-sm"><i class='bx bx-printer me-1'></i> พิมพ์ ปพ.1 (ม.ต้น)</a>
                    <?php endif; ?>
                    <?php if ($hasSenior): ?>
                        <a href="<?= $printBase ?>/senior" target="_blank" class="btn-emerald-outline btn-sm"><i class='bx bx-printer me-1'></i> พิมพ์ ปพ.1 (ม.ปลาย)</a>
                    <?php endif; ?>
                    <?php if (!$hasJunior && !$hasSenior): ?>
                        <a href="<?= $printBase ?>" target="_blank" class="btn-emerald-outline btn-sm"><i class='bx bx-printer me-1'></i> พิมพ์ ปพ.1 (รวม)</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="gpa-display mx-auto d-inline-block shadow-lg">
                    <small class="text-white-50 fw-bold uppercase">GPA สะสม</small>
                    <div class="display-4 fw-bold text-white"><?= $overallGPA ?></div>
                    <div class="badge bg-white text-emerald rounded-pill px-3 py-1 mt-2 fw-bold text-dark" style="color: var(--primary-emerald) !important;">รวม <?= number_format($AllUnit, 1) ?> นก.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card result-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper-large me-3 shadow-sm"><i class='bx bx-book-content'></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?= count($scoreStudent ?? []) ?></h4>
                        <small class="text-muted fw-bold">รายวิชาที่เรียนทั้งหมด</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card result-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper-large me-3 shadow-sm" style="background: rgba(52, 152, 219, 0.1); color: #3498db;"><i class='bx bx-time-five'></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?= count($scoreYear ?? []) ?></h4>
                        <small class="text-muted fw-bold">จำนวนภาคเรียนที่บันทึก</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card result-card p-4 text-primary">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper-large me-3 shadow-sm" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class='bx bx-medal'></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold">ปกติ</h4>
                        <small class="text-muted fw-bold">สถานะการเรียนปัจจุบัน</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Semester Details -->
    <div class="card result-card mb-5">
        <div class="card-header bg-white border-bottom-0 py-4 px-4">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper-large me-3 shadow-sm"><i class='bx bx-history'></i></div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">บันทึกผลการเรียนรายภาคเรียน</h5>
                    <p class="text-muted mb-0 small">รายละเอียดรายวิชาและคะแนนแต่ละเทอม</p>
                </div>
            </div>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="accordion accordion-flush" id="gradeAccordion">
                <?php 
                asort($scoreYear);
                foreach ($scoreYear as $key_year => $v_scoreYear) : 
                ?>
                <div class="accordion-item accordion-item-emerald animate__animated animate__fadeInUp">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-emerald collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#term-<?= $key_year ?>">
                            <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                <span class="fs-5 fw-bold"><i class='bx bx-calendar-check me-2 text-emerald'></i> ภาคเรียนที่ <?= esc($v_scoreYear->RegisterYear) ?></span>
                                <span class="badge bg-white text-dark border px-3 rounded-pill fw-bold">ม.<?= esc($v_scoreYear->RegisterClass) ?></span>
                            </div>
                        </button>
                    </h2>
                    <div id="term-<?= $key_year ?>" class="accordion-collapse collapse" data-bs-parent="#gradeAccordion">
                        <div class="accordion-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8 border-end">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-emerald mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="ps-4">รหัส/รายวิชา</th>
                                                    <th class="text-center" style="width: 100px;">หน่วยกิต</th>
                                                    <th class="text-center" style="width: 100px;">เกรด</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $SemUnit = 0; $SemGrade = 0; $SemCount = 0;
                                                    foreach ($scoreStudent as $score): 
                                                    if($v_scoreYear->RegisterYear == $score->RegisterYear && $v_scoreYear->RegisterYear == $score->SubjectYear):
                                                        $SemCount++;
                                                        $SemUnit += floatval($score->SubjectUnit);
                                                        $gVal = ($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == '') ? 0 : floatval($score->Grade);
                                                        $SemGrade += ($gVal * floatval($score->SubjectUnit));
                                                ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="fw-bold text-dark"><?= esc($score->SubjectCode) ?></div>
                                                        <div class="small text-muted"><?= esc($score->SubjectName) ?></div>
                                                    </td>
                                                    <td class="text-center fw-bold"><?= number_format(floatval($score->SubjectUnit), 1) ?></td>
                                                    <td class="text-center">
                                                        <?php 
                                                            $gClass = 'grade-mid';
                                                            if($score->Grade >= 3) $gClass = 'grade-top';
                                                            if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade === '0') $gClass = 'grade-fail';
                                                        ?>
                                                        <span class="badge-grade <?= $gClass ?> shadow-sm">
                                                            <?= ($score->Grade === '' || $score->Grade === null) ? '-' : esc($score->Grade) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endif; endforeach; ?>
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr class="fw-bold">
                                                    <td class="ps-4">รวม <?= $SemCount ?> รายวิชา</td>
                                                    <td class="text-center"><?= number_format($SemUnit, 1) ?></td>
                                                    <td class="text-center text-emerald">GPA: <?= ($SemUnit != 0) ? number_format(floor(($SemGrade/$SemUnit) * 100) / 100, 2, '.', '') : '0.00' ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-light bg-opacity-50 p-4">
                                    <h6 class="fw-bold mb-3 text-dark"><i class='bx bx-task me-2'></i>กิจกรรมพัฒนาผู้เรียน</h6>
                                    <div class="list-group list-group-flush rounded-3 px-2">
                                        <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                                            <span class="small"><i class='bx bx-check-circle me-1 text-emerald'></i> กิจกรรมแนะแนว</span>
                                            <span class="badge bg-label-success rounded-pill px-3">ผ่าน</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                                            <span class="small"><i class='bx bx-check-circle me-1 text-emerald'></i> กิจกรรมชุมนุม</span>
                                            <span class="badge bg-label-success rounded-pill px-3">ผ่าน</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                                            <span class="small"><i class='bx bx-check-circle me-1 text-emerald'></i> กิจกรรมบำเพ็ญ</span>
                                            <span class="badge bg-label-success rounded-pill px-3">ผ่าน</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if(empty($scoreYear)): ?>
                <div class="text-center py-5">
                    <div class="icon-wrapper-large mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.5rem;"><i class='bx bx-search-alt'></i></div>
                    <h5 class="fw-bold">ไม่มีข้อมูลบันทึกเกรด</h5>
                    <p class="text-muted">ไม่พบข้อมูลการเรียนที่บันทึกไว้ในระบบสำหรับนักเรียนคนนี้</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Reveal accordion with delay
    $('.accordion-item-emerald').each(function(i) {
        $(this).css('animation-delay', (i * 0.1) + 's');
    });
});
</script>
<?= $this->endSection() ?>
