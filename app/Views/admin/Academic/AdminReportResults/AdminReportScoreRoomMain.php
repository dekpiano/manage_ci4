<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    /* Sticky Column Styling */
    .table-score-report thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f5f5f9 !important;
        border-bottom: 2px solid #d9dee3 !important;
    }

    .table-score-report th:nth-child(1), .table-score-report td:nth-child(1),
    .table-score-report th:nth-child(2), .table-score-report td:nth-child(2),
    .table-score-report th:nth-child(3), .table-score-report td:nth-child(3) {
        position: sticky;
        background-color: #fff;
        z-index: 9;
    }
    .table-score-report thead th:nth-child(1), .table-score-report thead th:nth-child(2), .table-score-report thead th:nth-child(3) {
        background-color: #f5f5f9 !important;
        z-index: 11;
    }
    .table-score-report th:nth-child(1), .table-score-report td:nth-child(1) { left: 0; min-width: 50px; }
    .table-score-report th:nth-child(2), .table-score-report td:nth-child(2) { left: 50px; min-width: 90px; }
    .table-score-report th:nth-child(3), .table-score-report td:nth-child(3) { left: 140px; min-width: 200px; border-right: 2px solid #d9dee3 !important; }

    .subject-header-cell {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        white-space: nowrap;
        padding: 10px 5px !important;
        height: 180px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: left;
    }
    
    .score-cell {
        text-align: center;
        font-size: 0.8rem;
        min-width: 45px;
        padding: 6px 4px !important;
    }
    .score-cell.has-score { background-color: #e8fadf; }
    .score-cell.no-score { background-color: #fff3cd; color: #856404; }
</style>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class='bx bx-spreadsheet text-primary me-2'></i>
            <?= isset($title) ? esc($title) : 'รายงานผลการบันทึกคะแนน (รายห้องเรียน)' ?>
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="#">งานทะเบียน</a></li>
                <li class="breadcrumb-item active">รายงานผลการบันทึกคะแนน</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="KeyCheckYear" class="form-label fw-semibold">
                    <i class='bx bx-calendar text-primary me-1'></i> ปีการศึกษา
                </label>
                <select class="form-select" id="KeyCheckYear" name="KeyCheckYear">
                    <option value="">-- เลือกปีการศึกษา --</option>
                    <?php foreach ($CheckYear as $v_CheckYear) : ?>
                        <?php 
                            $currentVal = ($Term ?? '') . '/' . ($Year ?? '');
                            $isSelected = ($currentVal == $v_CheckYear->RegisterYear) ? 'selected' : '';
                        ?>
                        <option value="<?= esc($v_CheckYear->RegisterYear) ?>" <?= $isSelected ?>>
                            <?= esc($v_CheckYear->RegisterYear) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="SelectRoomReportScore" class="form-label fw-semibold">
                    <i class='bx bx-chalkboard text-primary me-1'></i> ห้องเรียน
                </label>
                <select class="form-select" id="SelectRoomReportScore" name="SelectRoomReportScore">
                    <option value="">-- เลือกห้องเรียน --</option>
                    <?php foreach ($Room as $v_Room) : ?>
                        <?php 
                            $currentRoom = ($Class ?? '') . '/' . ($RoomValue ?? '');
                            $isSelected = ($currentRoom == $v_Room) ? 'selected' : '';
                        ?>
                        <option value="<?= esc($v_Room) ?>" <?= $isSelected ?>>ม.<?= esc($v_Room) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" id="btnSearch" class="btn btn-primary w-100">
                    <i class="bx bx-search-alt me-1"></i> ค้นหาข้อมูล
                </button>
            </div>
        </div>
    </div>
</div>

<?php if(isset($stu) && !empty($stu)): ?>

<?php if(isset($isOldDataFormat) && $isOldDataFormat): ?>
<!-- Warning for Old Data Format -->
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border-left: 4px solid #dc3545;">
    <div class="d-flex align-items-start">
        <i class='bx bx-error-circle fs-4 me-2 mt-1'></i>
        <div>
            <h6 class="alert-heading mb-1 fw-bold">
                <i class='bx bx-x-circle me-1'></i> ไม่รองรับข้อมูลก่อนปีการศึกษา 1/2568
            </h6>
            <p class="mb-0 small">
                ข้อมูลปี <strong><?= esc($Term) ?>/<?= esc($Year) ?></strong> ไม่ได้เก็บเลขห้องเรียนไว้ในฐานข้อมูล 
                ระบบจึง<strong>ไม่สามารถแยกห้องเรียนได้</strong> และผลลัพธ์ที่แสดงอาจ<strong>ไม่ถูกต้อง</strong>
                <br><span class="text-muted">* กรุณาเลือกปีการศึกษา 1/2568 ขึ้นไปเพื่อความถูกต้องของข้อมูล</span>
            </p>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #696cff 0%, #8385ff 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">จำนวนนักเรียน</h6>
                        <h2 class="mb-0 fw-bold"><?= count($stu) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-user-check fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #71dd37 0%, #8de45c 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">จำนวนรายวิชา</h6>
                        <h2 class="mb-0 fw-bold"><?= count($RegisSubject) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-book-open fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #03c3ec 0%, #41d1f1 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ห้องเรียน</h6>
                        <h2 class="mb-0 fw-bold">ม.<?= esc($Class) ?>/<?= esc($RoomValue) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-chalkboard fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffab00 0%, #ffc233 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ปีการศึกษา</h6>
                        <h2 class="mb-0 fw-bold"><?= esc($Term) ?>/<?= esc($Year) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-calendar fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Score Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom-0 py-3" style="border-radius: 12px 12px 0 0;">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                    <i class='bx bx-table text-primary fs-4'></i>
                </div>
                <div>
                    <h5 class="card-title mb-0 fw-bold">ตารางคะแนนรายวิชา</h5>
                    <small class="text-muted">แสดงคะแนนแยกตามช่วง: ก่อนกลางภาค, กลางภาค, หลังกลางภาค, ปลายภาค</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success btn-sm" id="btnExportExcel">
                    <i class='bx bx-file me-1'></i> Export Excel
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnPrint">
                    <i class='bx bx-printer me-1'></i> พิมพ์
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 70vh; overflow: auto;">
            <table class="table table-bordered table-hover table-score-report mb-0" id="tblScoreRoom">
                <thead>
                    <!-- Row 1: Subject Names -->
                    <tr>
                        <th class="text-center align-middle bg-light" rowspan="2" style="min-width: 50px;">ลำดับ</th>
                        <th class="text-center align-middle bg-light" rowspan="2" style="min-width: 80px;">รหัส</th>
                        <th class="align-middle bg-light" rowspan="2" style="min-width: 200px;">ชื่อ-นามสกุล</th>
                        <?php foreach ($RegisSubject as $subject): ?>
                            <th colspan="4" class="text-center bg-primary bg-opacity-10" style="font-size: 0.7rem; padding: 6px 4px;" title="<?= esc($subject->SubjectCode) ?> - <?= esc($subject->SubjectName) ?>">
                                <div class="fw-bold text-dark" style="font-size: 0.7rem; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0 auto;">
                                    <?= esc($subject->SubjectName) ?>
                                </div>
                                <div class="text-muted" style="font-size: 0.55rem;">
                                    <?= esc($subject->SubjectCode) ?>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <!-- Row 2: Score Types -->
                    <tr>
                        <?php foreach ($RegisSubject as $subject): ?>
                            <th class="text-center score-header" style="background: #e3f2fd; font-size: 0.65rem; min-width: 35px; padding: 4px 2px;">ก่อน</th>
                            <th class="text-center score-header" style="background: #fff3e0; font-size: 0.65rem; min-width: 35px; padding: 4px 2px;">กลาง</th>
                            <th class="text-center score-header" style="background: #e8f5e9; font-size: 0.65rem; min-width: 35px; padding: 4px 2px;">หลัง</th>
                            <th class="text-center score-header" style="background: #fce4ec; font-size: 0.65rem; min-width: 35px; padding: 4px 2px; border-right: 2px solid #dee2e6 !important;">ปลาย</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    <?php foreach ($stu as $student) : ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $num++ ?></td>
                            <td class="text-center small"><?= esc($student->StudentCode) ?></td>
                            <td class="text-nowrap">
                                <?= esc($student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName) ?>
                            </td>
                            <?php foreach ($RegisSubject as $subject) : ?>
                                <?php
                                    $stuId = (string)$student->StudentID;
                                    $subId = (string)$subject->SubjectID;
                                    $scoreString = $scoresMap[$stuId][$subId] ?? '';
                                    
                                    // Split score: ก่อน|กลาง|หลัง|ปลาย
                                    $scores = ['', '', '', ''];
                                    if (!empty($scoreString)) {
                                        $parts = explode('|', $scoreString);
                                        $scores[0] = $parts[0] ?? '';
                                        $scores[1] = $parts[1] ?? '';
                                        $scores[2] = $parts[2] ?? '';
                                        $scores[3] = $parts[3] ?? '';
                                    }
                                ?>
                                <td class="text-center score-cell <?= (strlen($scores[0]) > 0) ? 'has-score' : '' ?>" style="background: #e3f2fd; font-size: 0.8rem; padding: 4px 2px;">
                                    <?= (strlen($scores[0]) > 0) ? esc($scores[0]) : '-' ?>
                                </td>
                                <td class="text-center score-cell <?= (strlen($scores[1]) > 0) ? 'has-score' : '' ?>" style="background: #fff3e0; font-size: 0.8rem; padding: 4px 2px;">
                                    <?= (strlen($scores[1]) > 0) ? esc($scores[1]) : '-' ?>
                                </td>
                                <td class="text-center score-cell <?= (strlen($scores[2]) > 0) ? 'has-score' : '' ?>" style="background: #e8f5e9; font-size: 0.8rem; padding: 4px 2px;">
                                    <?= (strlen($scores[2]) > 0) ? esc($scores[2]) : '-' ?>
                                </td>
                                <td class="text-center score-cell <?= (strlen($scores[3]) > 0) ? 'has-score' : '' ?>" style="background: #fce4ec; font-size: 0.8rem; padding: 4px 2px; border-right: 2px solid #dee2e6 !important;">
                                    <?= (strlen($scores[3]) > 0) ? esc($scores[3]) : '-' ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 16px; height: 16px; background: #e3f2fd;"></span>
                    <small class="text-muted">ก่อนกลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 16px; height: 16px; background: #fff3e0;"></span>
                    <small class="text-muted">กลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 16px; height: 16px; background: #e8f5e9;"></span>
                    <small class="text-muted">หลังกลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 16px; height: 16px; background: #fce4ec;"></span>
                    <small class="text-muted">ปลายภาค</small>
                </span>
            </div>
            <span class="badge bg-label-primary">แสดงทั้งหมด <?= count($stu) ?> คน, <?= count($RegisSubject) ?> รายวิชา</span>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Empty State -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="bx bx-spreadsheet text-primary" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h5 class="text-dark fw-bold">กรุณาเลือกปีการศึกษาและห้องเรียน</h5>
        <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
            ระบุปีการศึกษาที่ต้องการตรวจสอบ และเลือกห้องเรียนเพื่อแสดงรายงานผลการบันทึกคะแนนรายวิชาของนักเรียน
        </p>
        <div class="d-flex justify-content-center gap-3">
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-calendar fs-3 text-primary'></i>
                </div>
                <small class="text-muted">1. เลือกปีการศึกษา</small>
            </div>
            <div class="text-muted align-self-center"><i class='bx bx-right-arrow-alt fs-4'></i></div>
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-chalkboard fs-3 text-success'></i>
                </div>
                <small class="text-muted">2. เลือกห้องเรียน</small>
            </div>
            <div class="text-muted align-self-center"><i class='bx bx-right-arrow-alt fs-4'></i></div>
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-search-alt fs-3 text-info'></i>
                </div>
                <small class="text-muted">3. คลิกค้นหา</small>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Sort Year Dropdown (newest first)
    let select = $('#KeyCheckYear');
    let options = select.find('option').not('[value=""]');
    let selectedValue = select.val();
    
    options.sort(function(a, b) {
        let aVal = a.value.split('/');
        let bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        let aYear = parseInt(aVal[1], 10);
        let bYear = parseInt(bVal[1], 10);
        let aTerm = parseInt(aVal[0], 10);
        let bTerm = parseInt(bVal[0], 10);
        
        if (aYear !== bYear) return bYear - aYear;
        return bTerm - aTerm;
    });
    
    select.find('option').not('[value=""]').remove();
    select.append(options);
    select.val(selectedValue);

    // Search Button
    <?php 
        $currentSegment = service('request')->uri->getSegment(3) ?? 'Evaluate';
        $baseUrl = site_url("Admin/Acade/{$currentSegment}/ReportScoreRoomMain");
    ?>
    const baseUrl = '<?= $baseUrl ?>';

    $('#btnSearch').on('click', function() {
        let selectedYear = $('#KeyCheckYear').val();
        let selectedRoom = $('#SelectRoomReportScore').val();

        if (!selectedYear) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', confirmButtonColor: '#696cff' });
            return;
        }
        if (!selectedRoom) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกห้องเรียน', confirmButtonColor: '#696cff' });
            return;
        }

        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        // URL: baseUrl/Term/Year/Class/Room
        window.location.href = baseUrl + '/' + selectedYear + '/' + selectedRoom;
    });

    // Export Excel
    $('#btnExportExcel').on('click', function() {
        <?php if(isset($Term) && $Term !== 'All' && isset($Year) && $Year !== 'All' && isset($Class) && $Class !== 'All' && isset($RoomValue) && $RoomValue !== 'All'): ?>
            // Build export URL
            const exportUrl = '<?= site_url("Admin/Acade/{$currentSegment}/ExportScoreRoomToExcel/{$Term}/{$Year}/{$Class}/{$RoomValue}") ?>';
            
            Swal.fire({
                title: 'กำลังเตรียมไฟล์ Excel...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            // Redirect to download
            window.location.href = exportUrl;
            
            // Close loading after short delay
            setTimeout(() => { Swal.close(); }, 2000);
        <?php else: ?>
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกข้อมูลก่อน',
                text: 'เลือกปีการศึกษาและห้องเรียน แล้วกดค้นหาก่อนส่งออก',
                confirmButtonColor: '#696cff'
            });
        <?php endif; ?>
    });

    // Print
    $('#btnPrint').on('click', function() {
        window.print();
    });
});
</script>
<?= $this->endSection() ?>