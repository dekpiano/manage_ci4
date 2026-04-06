<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-green: #15a362;
        --secondary-green: #198754;
        --light-green: #e8f5e9;
        --border-radius: 16px;
    }

    /* Table Container Styling */
    .table-container-score {
        position: relative;
        max-height: 75vh;
        overflow: auto;
        border: 1px solid #edf1f4;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    /* Baseline Table Sticky Header */
    .table-score-report {
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .table-score-report thead th {
        position: sticky !important;
        top: 0;
        z-index: 40;
        background-color: #fcfdfe !important;
        border-bottom: 2px solid #e9ecef !important;
        border-right: 1px solid #e9ecef !important;
        white-space: nowrap;
        font-weight: 700;
        color: #495057;
        font-size: 0.72rem;
        letter-spacing: 0.3px;
        padding: 10px 8px !important;
    }

    /* Second Row of Header Sticky */
    .table-score-report thead tr:nth-child(2) th {
        top: 48px !important; 
        z-index: 39;
        font-size: 0.65rem;
        background-color: #f8f9fa !important;
    }

    /* Sticky Columns Logic */
    .sticky-col {
        position: sticky !important;
        background-color: #fff !important;
        z-index: 10;
        white-space: nowrap;
        border-right: 1px solid #e9ecef !important;
        font-size: 0.82rem;
    }
    
    /* Intersection Header & Column */
    .table-score-report thead th.sticky-col {
        z-index: 110 !important;
        background-color: #fcfdfe !important;
        top: 0 !important;
    }
    
    .table-score-report thead tr:nth-child(2) th.sticky-col {
        top: 48px !important;
        z-index: 109 !important;
    }

    .sticky-col-1 { left: 0; min-width: 50px; text-align: center; color: #adb5bd; }
    .sticky-col-2 { left: 50px; min-width: 90px; text-align: center; font-weight: 500; color: #6c757d; }
    .sticky-col-3 { 
        left: 140px; 
        min-width: 220px; 
        font-weight: 600;
        color: #212529;
        border-right: 3px solid var(--primary-green) !important;
        box-shadow: 6px 0 10px rgba(0,0,0,0.04);
    }

    /* Subject Headers Branding */
    .subject-header-group {
        border-bottom: 3px solid var(--primary-green) !important;
        background-color: rgba(21, 163, 98, 0.04) !important;
    }

    /* Hover effect */
    .table-score-report tbody tr {
        transition: all 0.2s ease;
    }
    .table-score-report tbody tr:hover td {
        background-color: rgba(21, 163, 98, 0.03) !important;
    }
    .table-score-report tbody tr:hover .sticky-col {
        background-color: #fcfdfe !important;
    }

    /* Score Cell Tweak */
    .score-cell {
        text-align: center;
        font-size: 0.8rem;
        min-width: 42px;
        padding: 8px 4px !important;
        border-right: 1px solid #f1f3f5 !important;
        color: #495057;
    }
    .score-cell.has-score { 
        color: var(--primary-green); 
        font-weight: 700;
    }
    .score-cell.last-of-group {
        border-right: 2px solid #dee2e6 !important;
    }

    /* Group shading */
    .bg-group-pre { background-color: rgba(21, 163, 98, 0.02) !important; }
    .bg-group-mid { background-color: rgba(21, 163, 98, 0.04) !important; }
    .bg-group-post { background-color: rgba(21, 163, 98, 0.06) !important; }
    .bg-group-final { background-color: rgba(21, 163, 98, 0.08) !important; }

    .subject-header-cell {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        white-space: nowrap;
        padding: 12px 6px !important;
        height: 200px;
        font-size: 0.75rem;
        font-weight: 700;
        text-align: left;
    }
    
    .score-cell {
        text-align: center;
        font-size: 0.85rem;
        min-width: 48px;
        padding: 8px 4px !important;
        transition: background-color 0.2s ease;
    }
    .score-cell:hover { background-color: rgba(21, 163, 98, 0.05) !important; }
    .score-cell.has-score { background-color: rgba(21, 163, 98, 0.1) !important; color: #15a362; font-weight: 600; }
    .score-cell.no-score { background-color: #fff8e1 !important; color: #b78103; }

    /* Custom Card */
    .card-modern {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 10px 30px rgba(144, 163, 179, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-modern:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(144, 163, 179, 0.15); }

    /* Button Styling */
    .btn-smooth {
        border-radius: 12px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-smooth:active { transform: scale(0.96); }

    .btn-success-modern {
        background: linear-gradient(135deg, #15a362 0%, #118d54 100%);
        border: none;
        color: white;
    }
    .btn-success-modern:hover {
        background: linear-gradient(135deg, #118d54 0%, #0d7546 100%);
        box-shadow: 0 4px 15px rgba(21, 163, 98, 0.3);
    }

    /* Select2 Modern Green Tweak */
    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid #edf1f4;
        border-radius: 12px !important;
        min-height: 48px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding-left: 1rem;
        color: #495057;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
        border-radius: 12px !important;
        border: 2px solid var(--primary-green) !important;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .select2-results__option--highlighted {
        background-color: var(--primary-green) !important;
    }
</style>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class='bx bx-spreadsheet text-success me-2'></i>
            <?= isset($title) ? esc($title) : 'รายงานผลการบันทึกคะแนน (รายห้องเรียน)' ?>
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home-alt'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-muted">งานทะเบียน</a></li>
                <li class="breadcrumb-item active text-success">รายงานผลการบันทึกคะแนน</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter Card -->
<div class="card card-modern mb-4">
    <div class="card-body py-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="KeyCheckYear" class="form-label fw-bold text-dark">
                    <i class='bx bx-calendar-star text-success me-1'></i> ปีการศึกษา
                </label>
                <select class="form-select select2" id="KeyCheckYear" name="KeyCheckYear">
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
                <label for="SelectRoomReportScore" class="form-label fw-bold text-dark">
                    <i class='bx bx-group text-success me-1'></i> ห้องเรียน
                </label>
                <select class="form-select select2" id="SelectRoomReportScore" name="SelectRoomReportScore">
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
                <button type="button" id="btnSearch" class="btn btn-success-modern btn-smooth w-100">
                    <i class="bx bx-search-alt-2 me-1"></i> ค้นหาข้อมูล
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
        <div class="card border-0 shadow-sm card-modern h-100" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);">
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
        <div class="card border-0 shadow-sm card-modern h-100" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);">
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
        <div class="card border-0 shadow-sm card-modern h-100" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
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
        <div class="card border-0 shadow-sm card-modern h-100" style="background: linear-gradient(135deg, #f39c12 0%, #d35400 100%);">
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
<div class="card card-modern">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                    <i class='bx bx-table text-success fs-4'></i>
                </div>
                <div>
                    <h5 class="card-title mb-0 fw-bold">ตารางคะแนนรายวิชา</h5>
                    <small class="text-muted">ภาคเรียนที่ <?= (isset($Term) ? esc($Term) : '').'/'.(isset($Year) ? esc($Year) : '') ?></small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success btn-smooth btn-sm" id="btnExportExcel">
                    <i class='bx bx-file me-1'></i> Export Excel
                </button>
                <button type="button" class="btn btn-outline-dark btn-smooth btn-sm" id="btnPrint">
                    <i class='bx bx-printer me-1'></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-container-score" id="tableContainer">
            <table class="table table-bordered table-hover table-score-report mb-0" id="tblScoreRoom" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <!-- Row 1: Subject Names -->
                    <tr>
                        <th class="text-center align-middle sticky-col sticky-col-1" rowspan="2">#</th>
                        <th class="text-center align-middle sticky-col sticky-col-2" rowspan="2">รหัส</th>
                        <th class="align-middle sticky-col sticky-col-3" rowspan="2">ชื่อ-นามสกุล</th>
                        <?php foreach ($RegisSubject as $subject): ?>
                            <th colspan="4" class="text-center subject-header-group" style="padding: 10px 4px;" title="<?= esc($subject->SubjectCode) ?> - <?= esc($subject->SubjectName) ?>">
                                <div class="fw-bold text-success" style="font-size: 0.75rem; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0 auto;">
                                    <?= esc($subject->SubjectName) ?>
                                </div>
                                <div class="text-muted fw-normal" style="font-size: 0.62rem;">
                                    <?= esc($subject->SubjectCode) ?>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                    <!-- Row 2: Score Types -->
                    <tr>
                        <?php foreach ($RegisSubject as $subject): ?>
                            <th class="text-center score-header bg-group-pre" style="font-size: 0.65rem; min-width: 38px; padding: 6px 2px;">ก่อน</th>
                            <th class="text-center score-header bg-group-mid" style="font-size: 0.65rem; min-width: 38px; padding: 6px 2px;">กลาง</th>
                            <th class="text-center score-header bg-group-post" style="font-size: 0.65rem; min-width: 38px; padding: 6px 2px;">หลัง</th>
                            <th class="text-center score-header bg-group-final" style="font-size: 0.65rem; min-width: 38px; padding: 6px 2px; border-right: 2px solid #dee2e6 !important;">ปลาย</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; ?>
                    <?php foreach ($stu as $student) : ?>
                        <tr>
                            <td class="text-center fw-bold sticky-col sticky-col-1"><?= $num++ ?></td>
                            <td class="text-center small sticky-col sticky-col-2"><?= esc($student->StudentCode) ?></td>
                            <td class="text-nowrap sticky-col sticky-col-3">
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
                                <td class="text-center score-cell bg-group-pre <?= (strlen($scores[0]) > 0) ? 'has-score' : '' ?>">
                                    <?= (strlen($scores[0]) > 0) ? esc($scores[0]) : '-' ?>
                                </td>
                                <td class="text-center score-cell bg-group-mid <?= (strlen($scores[1]) > 0) ? 'has-score' : '' ?>">
                                    <?= (strlen($scores[1]) > 0) ? esc($scores[1]) : '-' ?>
                                </td>
                                <td class="text-center score-cell bg-group-post <?= (strlen($scores[2]) > 0) ? 'has-score' : '' ?>">
                                    <?= (strlen($scores[2]) > 0) ? esc($scores[2]) : '-' ?>
                                </td>
                                <td class="text-center score-cell bg-group-final last-of-group <?= (strlen($scores[3]) > 0) ? 'has-score' : '' ?>">
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
                    <span class="d-inline-block rounded" style="width: 14px; height: 14px; background: rgba(21, 163, 98, 0.02); border: 1px solid #eee;"></span>
                    <small class="text-muted">ก่อนกลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 14px; height: 14px; background: rgba(21, 163, 98, 0.04); border: 1px solid #eee;"></span>
                    <small class="text-muted">กลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 14px; height: 14px; background: rgba(21, 163, 98, 0.06); border: 1px solid #eee;"></span>
                    <small class="text-muted">หลังกลางภาค</small>
                </span>
                <span class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded" style="width: 14px; height: 14px; background: rgba(21, 163, 98, 0.08); border: 1px solid #eee;"></span>
                    <small class="text-muted">ปลายภาค</small>
                </span>
            </div>
            <span class="badge bg-label-success">แสดงทั้งหมด <?= count($stu) ?> คน, <?= count($RegisSubject) ?> รายวิชา</span>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Empty State -->
<div class="card border-0 shadow-sm card-modern">
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="bx bx-spreadsheet text-success" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h5 class="text-dark fw-bold">กรุณาเลือกปีการศึกษาและห้องเรียน</h5>
        <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
            ระบุปีการศึกษาที่ต้องการตรวจสอบ และเลือกห้องเรียนเพื่อแสดงรายงานผลการบันทึกคะแนนรายวิชาของนักเรียน
        </p>
        <div class="d-flex justify-content-center gap-3">
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-calendar fs-3 text-success'></i>
                </div>
                <small class="text-muted">1. เลือกปีการศึกษา</small>
            </div>
            <div class="text-muted align-self-center"><i class='bx bx-right-arrow-alt fs-4'></i></div>
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-group fs-3 text-success'></i>
                </div>
                <small class="text-muted">2. เลือกห้องเรียน</small>
            </div>
            <div class="text-muted align-self-center"><i class='bx bx-right-arrow-alt fs-4'></i></div>
            <div class="text-center">
                <div class="rounded bg-light p-3 mb-2">
                    <i class='bx bx-search-alt fs-3 text-success'></i>
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
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('body'),
        width: '100%'
    });

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
        $currentSegment = service('request')->getUri()->getSegment(3) ?? 'Evaluate';
        $baseUrl = site_url("Admin/Acade/{$currentSegment}/ReportScoreRoomMain");
    ?>
    const baseUrl = '<?= $baseUrl ?>';

    $('#btnSearch').on('click', function() {
        let selectedYear = $('#KeyCheckYear').val();
        let selectedRoom = $('#SelectRoomReportScore').val();

        if (!selectedYear) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', confirmButtonColor: '#15a362' });
            return;
        }
        if (!selectedRoom) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกห้องเรียน', confirmButtonColor: '#15a362' });
            return;
        }

        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        window.location.href = baseUrl + '/' + selectedYear + '/' + selectedRoom;
    });

    // Export Excel
    $('#btnExportExcel').on('click', function() {
        <?php if(isset($Term) && $Term !== 'All' && isset($Year) && $Year !== 'All' && isset($Class) && $Class !== 'All' && isset($RoomValue) && $RoomValue !== 'All'): ?>
            const exportUrl = '<?= site_url("Admin/Acade/{$currentSegment}/ExportScoreRoomToExcel/{$Term}/{$Year}/{$Class}/{$RoomValue}") ?>';
            
            Swal.fire({
                title: 'กำลังเตรียมไฟล์ Excel...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            window.location.href = exportUrl;
            setTimeout(() => { Swal.close(); }, 2000);
        <?php else: ?>
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกข้อมูลก่อน',
                text: 'เลือกปีการศึกษาและห้องเรียน แล้วกดค้นหาก่อนส่งออก',
                confirmButtonColor: '#15a362'
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