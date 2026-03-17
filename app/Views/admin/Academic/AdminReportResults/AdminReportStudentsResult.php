<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

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
                if(floatval($score->Score100) == ''){
                    $SubGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                }else{
                    $SubGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                }
            }
        }
       
    }$AllGrade += $SubGrade; 
}            
$overallGPA = ($AllUnit != 0) ? number_format(floor(($AllGrade/$AllUnit) * 100) / 100, 2, '.', '') : 'N/A';
?>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm me-3">
                <i class="bx bx-arrow-back"></i> ย้อนกลับ
            </a>
            <h4 class="fw-bold mb-0">
                <i class='bx bx-user-circle text-success me-2'></i>
                <?= esc($title) ?>
            </h4>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="javascript:history.back()">รายงานผลการเรียนรายบุคคล</a></li>
                <li class="breadcrumb-item active"><?= esc($stu->StudentPrefix.$stu->StudentFirstName.' '.$stu->StudentLastName) ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <?php 
        $hasJunior = false;
        $hasSenior = false;
        foreach ($scoreYear as $yr) {
            $class = (string)$yr->RegisterClass;
            // ตรวจสอบ ม.ต้น (1, 2, 3 หรือ ม.1, ม.2, ม.3)
            if (str_contains($class, '1') || str_contains($class, '2') || str_contains($class, '3')) {
                // กันเหนียวกรณีเป็น ม.11, ม.12 (ถ้ามี) แต่ในระบบโรงเรียนน่าจะเป็น 1-6
                if (!str_contains($class, '4') && !str_contains($class, '5') && !str_contains($class, '6')) {
                    $hasJunior = true;
                }
            }
            // ตรวจสอบ ม.ปลาย (4, 5, 6 หรือ ม.4, ม.5, ม.6)
            if (str_contains($class, '4') || str_contains($class, '5') || str_contains($class, '6')) {
                $hasSenior = true;
            }
        }
        ?>
        
        <?php if ($hasJunior): ?>
        <a href="<?= base_url('Admin/Acade/Evaluate/PrintTranscript/'.esc($stu->StudentID).'/junior') ?>" target="_blank" class="btn btn-primary d-flex align-items-center">
            <i class='bx bx-printer me-2'></i> พิมพ์ ปพ.1 (ม.ต้น)
        </a>
        <?php endif; ?>

        <?php if ($hasSenior): ?>
        <a href="<?= base_url('Admin/Acade/Evaluate/PrintTranscript/'.esc($stu->StudentID).'/senior') ?>" target="_blank" class="btn btn-success d-flex align-items-center">
            <i class='bx bx-printer me-2'></i> พิมพ์ ปพ.1 (ม.ปลาย)
        </a>
        <?php endif; ?>

        <?php if (!$hasJunior && !$hasSenior): ?>
        <a href="<?= base_url('Admin/Acade/Evaluate/PrintTranscript/'.esc($stu->StudentID)) ?>" target="_blank" class="btn btn-secondary d-flex align-items-center">
            <i class='bx bx-printer me-2'></i> พิมพ์ใบ ปพ.1 (รวม)
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Student Info Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #71dd37 0%, #8de45c 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">นักเรียน</h6>
                        <h5 class="mb-0 fw-bold" style="font-size: 1rem;"><?= esc($stu->StudentPrefix.$stu->StudentFirstName) ?></h5>
                        <small><?= esc($stu->StudentLastName) ?></small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-user fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #48c764 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ระดับชั้น</h6>
                        <h5 class="mb-0 fw-bold"><?= esc($stu->StudentClass) ?></h5>
                        <small>เลขประจำตัว: <?= esc($stu->StudentCode) ?></small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-id-card fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #20c997 0%, #4dd4ac 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">หน่วยกิตรวม</h6>
                        <h5 class="mb-0 fw-bold"><?= number_format($AllUnit, 1) ?></h5>
                        <small>หน่วยกิต</small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-book fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #3dbdd4 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">เกรดเฉลี่ยสะสม</h6>
                        <h5 class="mb-0 fw-bold"><?= $overallGPA ?></h5>
                        <small>GPA รวม</small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-trophy fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Semester Accordion -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom-0 py-3" style="border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                <i class='bx bx-calendar text-success fs-4'></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">ผลการเรียนรายภาคเรียน</h5>
                <small class="text-muted">คลิกเพื่อดูรายละเอียดแต่ละภาคเรียน</small>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="accordion" id="semesterAccordion">
            <?php 
            asort($scoreYear);
            foreach ($scoreYear as $key_year => $v_scoreYear) : 
            ?>
            <div class="accordion-item border mb-3" style="border-radius: 10px !important; overflow: hidden;">
                <h2 class="accordion-header" id="heading<?= $key_year ?>">
                    <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key_year ?>" aria-expanded="false" aria-controls="collapse<?= $key_year ?>" style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-3">ภาคเรียน</span>
                            <span class="fw-semibold"><?= esc($v_scoreYear->RegisterYear) ?></span>
                        </div>
                    </button>
                </h2>
                <div id="collapse<?= $key_year ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $key_year ?>" data-bs-parent="#semesterAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <!-- Subject Table -->
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <div class="card border shadow-sm">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0"><i class='bx bx-book-open me-2'></i>รายวิชา</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="table-light">
                                                <tr class="text-center">
                                                    <th style="width: 120px;">รหัสวิชา</th>
                                                    <th>ชื่อวิชา</th>
                                                    <th style="width: 80px;">ประเภท</th>
                                                    <th style="width: 80px;">หน่วยกิต</th>
                                                    <th style="width: 80px;">เกรด</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php  $SumUnit = 0; $SumGrade = 0; $scoreLevel=0; $CountSubjectAll = 0;
                                                foreach ($scoreStudent as $key => $score ):                                         
                                                if($v_scoreYear->RegisterYear == $score->RegisterYear && $v_scoreYear->RegisterYear == $score->SubjectYear):
                                                    $c = floatval($score->Score100);
                                                    $type = explode("/",$score->SubjectType);
                                                    $CountSubjectAll += 1;
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-label-primary"><?= esc($score->SubjectCode) ?></span>
                                                    </td>
                                                    <td style="white-space: nowrap;"><?= esc($score->SubjectName) ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-label-<?= ($type[1] ?? '') == 'พื้นฐาน' ? 'success' : 'info' ?>">
                                                            <?= esc($type[1] ?? '-') ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center"><?= number_format(floatval($score->SubjectUnit), 1) ?></td>
                                                    <td class="text-center">
                                                        <?php if($score->Grade == 'ร' || $score->Grade == 'มส'): ?>
                                                            <span class="badge bg-danger"><?= esc($score->Grade) ?></span>
                                                        <?php elseif($score->Grade == '' || $score->Grade == null): ?>
                                                            <span class="text-muted">-</span>
                                                        <?php elseif(floatval($score->Grade) >= 2): ?>
                                                            <span class="badge bg-success"><?= esc($score->Grade) ?></span>
                                                        <?php elseif(floatval($score->Grade) >= 1): ?>
                                                            <span class="badge bg-warning"><?= esc($score->Grade) ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger"><?= esc($score->Grade) ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php $SumUnit += floatval($score->SubjectUnit);
                                                if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == ''){
                                                    $scoreLevel += (floatval($score->SubjectUnit)*0);
                                                    $SumGrade += (floatval($score->SubjectUnit)*0);
                                                }else{
                                                    if(floatval($score->Score100) == ''){
                                                        $SumGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                                                    }else{
                                                        $scoreLevel += floatval($score->Score100);
                                                        $SumGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                                                    }
                                                }
                                                endif; 
                                                endforeach;?>
                                            </tbody>
                                            <tfoot class="table-success">
                                                <tr class="fw-bold">
                                                    <td class="text-center" colspan="2">
                                                        <i class='bx bx-book-reader me-1'></i><?= $CountSubjectAll ?> วิชา
                                                    </td>
                                                    <td class="text-center">รวม</td>
                                                    <td class="text-center"><?= number_format($SumUnit, 1) ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success fs-6">
                                                            <?= ($SumUnit != 0) ? number_format(floor(($SumGrade/$SumUnit) * 100) / 100, 2, '.', '') : 'N/A' ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Activities Card -->
                            <div class="col-lg-4">
                                <div class="card border shadow-sm h-100">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0"><i class='bx bx-run me-2'></i>กิจกรรมพัฒนาผู้เรียน</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td><i class='bx bx-compass me-2 text-success'></i>กิจกรรมแนะแนว</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success">ผ่าน</span>
                                                    </td>
                                                </tr>
                                                <?php if($stu->StudentClass <= 'ม.4/1') : ?>
                                                <tr>
                                                    <td><i class='bx bx-flag me-2 text-success'></i>ลูกเสือ/เนตรนารี</td>
                                                    <td class="text-center">
                                                        <?php if(in_array($stu->StudentCode, $checkChunum)): ?>
                                                            <span class="badge bg-danger">ไม่ผ่าน</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">ผ่าน</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td><i class='bx bx-group me-2 text-success'></i>กิจกรรมชุมนุม</td>
                                                    <td class="text-center">
                                                        <?php if(in_array($stu->StudentCode, $checkRuksun)): ?>
                                                            <span class="badge bg-danger">ไม่ผ่าน</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">ผ่าน</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><i class='bx bx-heart me-2 text-success'></i>กิจกรรมเพื่อสังคม</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success">ผ่าน</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
            <i class='bx bx-folder-open text-muted' style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">ไม่พบข้อมูลผลการเรียน</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
