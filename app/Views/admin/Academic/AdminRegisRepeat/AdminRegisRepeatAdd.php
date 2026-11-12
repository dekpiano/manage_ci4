<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Green Theme #15a362 ===== */
:root {
    --primary-green: #15a362;
    --primary-green-dark: #128a52;
    --primary-green-light: #1bc676;
    --gradient-green: linear-gradient(135deg, #15a362 0%, #1bc676 50%, #20c997 100%);
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: var(--gradient-green);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(21, 163, 98, 0.25);
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}
.welcome-banner .content { position: relative; z-index: 1; }
.welcome-banner h1 { font-size: 1.55rem; font-weight: 700; color: #ffffff !important; margin-bottom: 0.35rem; }
.welcome-banner p { color: #ffffff !important; opacity: 1 !important; }
.welcome-banner .subject-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.75rem;
}
.welcome-banner .subject-badge {
    background: #ffffff;
    padding: 0.45rem 0.9rem;
    border-radius: 25px;
    color: var(--primary-green-dark);
    font-weight: 700;
    font-size: 0.88rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.welcome-banner .teacher-text {
    color: #ffffff !important;
    font-size: 0.92rem;
    font-weight: 500;
}
.welcome-banner .icon-wrapper {
    font-size: 4.5rem;
    color: rgba(255, 255, 255, 0.15);
    position: absolute;
    right: 1.75rem;
    top: 50%;
    transform: translateY(-50%);
}

/* ===== Stat / Info Cards (Sneat Clean Style) ===== */
.stat-info-card {
    border-radius: 12px;
    border: none;
    transition: all 0.25s ease-in-out;
}
.stat-info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}
.stat-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
}

/* ===== Controls Card ===== */
.controls-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.controls-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.9rem 1.25rem;
}
.controls-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.controls-card .card-header h5 i { color: var(--primary-green); }
.controls-card .card-body { padding: 1.1rem 1.25rem; }
.control-label { font-size: .82rem; margin-bottom: .35rem; color: #56616c; font-weight: 600; }
.bulk-actions { padding-left: 1.25rem; border-left: 1px solid #e9ecef; }
.bulk-actions .select2-container { width: 100% !important; max-width: 100%; }
.bulk-action-buttons .btn { flex: 1 1 0; }
@media (max-width: 991.98px) { 
    .bulk-actions { padding-left: 0; border-left: 0; border-top: 1px solid #e9ecef; padding-top: 1rem; } 
}

/* ===== Table Card ===== */
.table-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.25rem;
}
.table-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.table-card .card-header h5 i { color: var(--primary-green); }

/* ===== Table Styling ===== */
#students-table thead th {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #495057;
    padding: 0.85rem 0.85rem;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
}
#students-table tbody td {
    padding: 0.75rem 0.85rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
}
#students-table tbody tr:hover { background: rgba(21, 163, 98, 0.04) !important; }

/* Row Status Colors */
#students-table tbody tr.table-danger { background: rgba(220, 53, 69, 0.07) !important; }
#students-table tbody tr.table-info { background: rgba(23, 162, 184, 0.09) !important; }
#students-table tbody tr.table-success { background: rgba(21, 163, 98, 0.09) !important; }

/* ===== Buttons ===== */
.btn-primary-green {
    background: var(--gradient-green);
    border: none;
    color: #ffffff !important;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-primary-green:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.35);
    color: #ffffff !important;
}

/* ===== Custom Checkbox ===== */
.form-check-input {
    width: 1.25em;
    height: 1.25em;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
}
.form-check-input:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.2);
}

/* ===== Select2 Styling ===== */
.select2-container--bootstrap-5 .select2-selection {
    border-radius: 8px;
    border: 2px solid #e9ecef;
}
.select2-container--bootstrap-5 .select2-selection--single:focus,
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}

/* ===== Badges ===== */
.selection-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.12) 0%, rgba(21, 163, 98, 0.22) 100%);
    padding: 0.35rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--primary-green);
}
.selection-badge i { margin-right: 0.35rem; }

.status-badge {
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    display: inline-block;
}
.status-badge.danger { background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; }
.status-badge.info { background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); color: #0c5460; }
.status-badge.success { background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: var(--primary-green); }
.status-badge.secondary { background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); color: #495057; }

.grade-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.95rem;
}
.grade-badge.fail { background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); color: #fff; }
.grade-badge.pass { background: linear-gradient(135deg, #15a362 0%, #20c997 100%); color: #fff; }

/* SweetAlert2 Highest Layer */
.swal2-container {
    z-index: 9999 !important;
}

/* Safeguard Modal */
.modal { z-index: 1060 !important; }
.modal-backdrop { z-index: 1050 !important; }
body:not(.modal-open) .modal-backdrop { display: none !important; pointer-events: none !important; }

/* Single-Line Student Name & Text Lock */
.text-nowrap, .student-name-nowrap {
    white-space: nowrap !important;
}
.student-name-pill {
    display: inline-flex;
    align-items: center;
    white-space: nowrap !important;
    font-weight: 600;
}
</style>

<?php
    // คำนวณข้อมูลการตั้งค่าเรียนซ้ำรอบปัจจุบัน และชื่อครูประจำวิชา
    $activeRepeatYear = isset($repeat_setting->onoff_year) && !empty($repeat_setting->onoff_year) ? $repeat_setting->onoff_year : $Year;
    $repeatAttemptRaw = isset($repeat_setting->onoff_detail) && !empty($repeat_setting->onoff_detail) ? $repeat_setting->onoff_detail : '1';
    $repeatAttemptDisplay = str_contains($repeatAttemptRaw, 'ครั้งที่') ? $repeatAttemptRaw : 'ครั้งที่ ' . $repeatAttemptRaw;

    // รหัสและชื่อวิชา
    $subjectCodeDisplay = isset($Subject->SubjectCode) ? $Subject->SubjectCode : (isset($DataRepeat[0]->SubjectCode) ? $DataRepeat[0]->SubjectCode : '');
    $subjectNameDisplay = isset($Subject->SubjectName) ? $Subject->SubjectName : (isset($DataRepeat[0]->SubjectName) ? $DataRepeat[0]->SubjectName : '');

    // ครูผู้สอนประจำวิชา
    $mainTeacherName = '';
    $regularTeacherID = isset($TechID) && $TechID !== 'all' ? $TechID : (isset($DataRepeat[0]->TeacherID) ? $DataRepeat[0]->TeacherID : null);
    
    if (isset($mainTeacher) && $mainTeacher) {
        $mainTeacherName = (isset($mainTeacher->pers_prefix) ? esc($mainTeacher->pers_prefix) : '') .
                          (isset($mainTeacher->pers_firstname) ? esc($mainTeacher->pers_firstname) : '') . ' ' .
                          (isset($mainTeacher->pers_lastname) ? esc($mainTeacher->pers_lastname) : '');
    } elseif ($regularTeacherID && isset($Teacher)) {
        foreach ($Teacher as $v_t) {
            if (isset($v_t->pers_id) && $v_t->pers_id == $regularTeacherID) {
                $mainTeacherName = (isset($v_t->pers_prefix) ? esc($v_t->pers_prefix) : '') .
                                  (isset($v_t->pers_firstname) ? esc($v_t->pers_firstname) : '') . ' ' .
                                  (isset($v_t->pers_lastname) ? esc($v_t->pers_lastname) : '');
                break;
            }
        }
    }

    // คำนวณสรุปสถิตินักเรียนในรายวิชานี้ (เฉพาะนักเรียนที่ติด 0, ร, มส)
    $countTotal = isset($DataRepeat) ? count($DataRepeat) : 0;
    $countNeedsRepeat = 0;
    $countRegistered = 0;

    if (isset($DataRepeat) && $DataRepeat) {
        foreach ($DataRepeat as $stu) {
            $isCurrentRepeat = (!empty($activeRepeatYear) && isset($stu->RepeatYear) && $stu->RepeatYear == $activeRepeatYear);
            $hasTeacher = (!empty($stu->RepeatTeacher));
            $isReg = ($hasTeacher && $isCurrentRepeat && isset($stu->RepeatStatus) && $stu->RepeatStatus == "ไม่ผ่าน");

            if ($isReg) {
                $countRegistered++;
            } else {
                $countNeedsRepeat++;
            }
        }
    }
?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Welcome Banner with Repeat Details -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <!-- Badges แสดง เทอม, ปีการศึกษา, ครั้งที่เรียนซ้ำ -->
                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm rounded-pill" style="font-size: 0.85rem;">
                            <i class="bx bx-calendar me-1 text-success"></i>ภาคเรียนที่ <?= esc($Term) ?> / <?= esc($Year) ?>
                        </span>
                        <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm rounded-pill" style="font-size: 0.85rem;">
                            <i class="bx bx-revision me-1 text-warning"></i><?= esc($repeatAttemptDisplay) ?>
                        </span>
                        <span class="badge bg-white text-dark fw-bold px-3 py-2 shadow-sm rounded-pill" style="font-size: 0.85rem;">
                            <i class="bx bx-calendar-check me-1 text-primary"></i>ปีการศึกษาที่เรียนซ้ำ <?= esc($activeRepeatYear) ?>
                        </span>
                    </div>

                    <h1><i class="bx bx-user-check me-2"></i>มอบหมายครูผู้สอนลงทะเบียนเรียนซ้ำ</h1>
                    <p class="mb-2" style="color: #ffffff !important; font-size: 0.95rem;">
                        จัดการรายชื่อนักเรียนที่มีผลการเรียน 0, ร, มส และมอบหมายครูผู้รับผิดชอบการเรียนซ้ำในรายวิชา
                    </p>

                    <!-- Subject & Teacher Info Badges -->
                    <div class="subject-info">
                        <span class="subject-badge">
                            <i class="bx bx-book-bookmark me-1"></i><?= esc($subjectCodeDisplay) ?>
                        </span>
                        <span class="text-white fw-semibold" style="color: #ffffff !important; font-size: 1.05rem;">
                            <?= esc($subjectNameDisplay) ?>
                        </span>
                        <?php if (!empty($mainTeacherName)): ?>
                            <span class="badge bg-dark bg-opacity-25 text-white px-3 py-2 rounded-pill" style="color: #ffffff !important; font-size: 0.85rem;">
                                <i class="bx bx-chalkboard me-1"></i>ครูประจำวิชา: <?= esc($mainTeacherName) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2 mt-3 mt-lg-0">
                    <button type="button" class="btn btn-warning fw-bold shadow-sm" onclick="showSubjectStudentDetailsModal()">
                        <i class="bx bx-show me-1"></i>ดูประวัติเรียนซ้ำวิชานี้
                    </button>
                    <a class="btn btn-outline-light fw-semibold" href="<?= site_url('Admin/Acade/Registration/Repeat?year=' . urlencode($Term . '/' . $Year)) ?>">
                        <i class="bx bx-arrow-back me-1"></i>ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-book-reader"></i>
        </div>
    </div>

    <!-- 4 Sneat Summary Cards: เทอม, ปีการศึกษา, ครั้งที่เรียนซ้ำ, สถิตินักเรียน -->
    <div class="row g-3 mb-4">
        <!-- Card 1: ภาคเรียน (เทอม) -->
        <div class="col-6 col-md-3">
            <div class="card stat-info-card shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stat-icon-box bg-label-primary me-3 flex-shrink-0">
                        <i class="bx bx-time-five"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">ภาคเรียน (เทอม)</small>
                        <h5 class="mb-0 fw-bold text-primary">เทอม <?= esc($Term) ?></h5>
                        <small class="text-muted" style="font-size: 0.75rem;">ปีการศึกษา <?= esc($Year) ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: ปีการศึกษา -->
        <div class="col-6 col-md-3">
            <div class="card stat-info-card shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stat-icon-box bg-label-success me-3 flex-shrink-0">
                        <i class="bx bx-calendar"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">ปีการศึกษา (เรียนซ้ำ)</small>
                        <h5 class="mb-0 fw-bold text-success">พ.ศ. <?= esc($activeRepeatYear) ?></h5>
                        <small class="text-muted" style="font-size: 0.75rem;">รอบเปิดเรียนซ้ำ</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: ครั้งที่เรียนซ้ำ -->
        <div class="col-6 col-md-3">
            <div class="card stat-info-card shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stat-icon-box bg-label-warning me-3 flex-shrink-0">
                        <i class="bx bx-revision"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">ครั้งที่เรียนซ้ำ</small>
                        <h5 class="mb-0 fw-bold text-warning"><?= esc($repeatAttemptDisplay) ?></h5>
                        <small class="text-muted" style="font-size: 0.75rem;">รอบปัจจุบัน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: สถิตินักเรียน -->
        <div class="col-6 col-md-3">
            <div class="card stat-info-card shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stat-icon-box bg-label-danger me-3 flex-shrink-0">
                        <i class="bx bx-user-x"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">นักเรียนติด 0, ร, มส</small>
                        <h5 class="mb-0 fw-bold text-danger"><?= $countTotal ?> <small class="text-muted fs-6">คน</small></h5>
                        <small class="text-muted" style="font-size: 0.75rem;">รอลงทะเบียน <?= $countNeedsRepeat ?> / ลงแล้ว <?= $countRegistered ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($DataRepeat) && $DataRepeat) :?>
    
    <!-- Controls Card & Bulk Actions -->
    <div class="card controls-card shadow-sm mb-4">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5><i class="bx bx-slider-alt me-2"></i>ตัวกรองและมอบหมายครูผู้สอน</h5>
            <small class="text-muted">เลือกนักเรียนในตาราง หรือกดปุ่ม <strong>"มอบหมาย"</strong> รายบุคคลได้ทันที</small>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4 col-lg-3">
                    <label for="statusFilter" class="form-label control-label">สถานะการเรียนซ้ำ</label>
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="ทั้งหมด" selected>ทั้งหมด (ติด 0, ร, มส)</option>
                        <option value="ต้องเรียนซ้ำ">ต้องเรียนซ้ำ (รอลงทะเบียน)</option>
                        <option value="ลงทะเบียนเรียนซ้ำ">ลงทะเบียนเรียนซ้ำแล้ว</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <label for="classFilter" class="form-label control-label">ห้องเรียน</label>
                    <select id="classFilter" class="form-select form-select-sm">
                        <option value="ทั้งหมด">ทั้งหมด</option>
                        <?php
                            $uniqueClasses = [];
                            foreach ($DataRepeat as $v_DataRepeat) {
                                if (isset($v_DataRepeat->StudentClass) && !empty($v_DataRepeat->StudentClass)) {
                                    $uniqueClasses[$v_DataRepeat->StudentClass] = $v_DataRepeat->StudentClass;
                                }
                            }
                            sort($uniqueClasses); 
                            foreach ($uniqueClasses as $class) {
                                echo '<option value="' . esc($class) . '">' . esc($class) . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <!-- Search Box -->
                <div class="col-6 col-md-5 col-lg-3">
                    <label for="nameSearch" class="form-label control-label">ค้นหาชื่อหรือรหัส</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bx bx-search text-muted"></i></span>
                        <input type="text" id="nameSearch" class="form-control" placeholder="พิมพ์ชื่อหรือรหัสนักเรียน">
                    </div>
                </div>

                <!-- Bulk Assignment Section -->
                <div class="col-12 col-lg-4 bulk-actions">
                   <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                       <label for="GlobalTeacherSelect" class="form-label control-label text-success mb-0 fw-bold">
                           <i class="bx bx-user-plus me-1"></i>มอบหมายครูผู้สอน (เลือกหลายคน)
                       </label>
                       <span class="selection-badge py-1 px-2" id="SelectionCount">
                           <i class="bx bx-user-check"></i>เลือก 0 คน
                       </span>
                   </div>
                   <div class="d-flex flex-column gap-2 align-items-stretch">
                        <div class="w-100">
                            <select id="GlobalTeacherSelect" class="form-select form-select-sm">
                                <option value="">เลือกครูผู้สอนเพื่อมอบหมาย...</option>
                                <?php 
                                    $sortedTeachers = [];
                                    $regularTeacherObj = null;
                                    
                                    if (isset($Teacher) && is_array($Teacher)) {
                                        foreach ($Teacher as $t) {
                                            if ($regularTeacherID && isset($t->pers_id) && $t->pers_id == $regularTeacherID) {
                                                $regularTeacherObj = $t;
                                            } else {
                                                $sortedTeachers[] = $t;
                                            }
                                        }
                                        if ($regularTeacherObj) {
                                            array_unshift($sortedTeachers, $regularTeacherObj);
                                        }
                                        
                                        foreach ($sortedTeachers as $v_Teache): 
                                            $isRegular = ($regularTeacherID && isset($v_Teache->pers_id) && $v_Teache->pers_id == $regularTeacherID);
                                            $selected = $isRegular ? 'selected' : '';
                                            $tName = (isset($v_Teache->pers_prefix) ? esc($v_Teache->pers_prefix) : '').(isset($v_Teache->pers_firstname) ? esc($v_Teache->pers_firstname) : '').' '.(isset($v_Teache->pers_lastname) ? esc($v_Teache->pers_lastname) : '');
                                            if ($isRegular) $tName .= ' ⭐ (ครูประจำวิชา)';
                                ?>
                                    <option value="<?= isset($v_Teache->pers_id) ? esc($v_Teache->pers_id) : '' ?>" <?= $selected ?>>
                                        <?= $tName ?>
                                    </option>
                                <?php 
                                        endforeach;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex gap-2 bulk-action-buttons">
                            <!-- ปุ่มมอบหมายหลักแบบกลุ่ม -->
                            <button id="BtnBulkRegister" type="button" class="btn btn-success btn-sm fw-bold text-nowrap py-2" style="background-color: #15a362; border-color: #15a362;">
                                <i class="bx bx-user-plus me-1"></i>มอบหมายครูผู้สอน
                            </button>
                            <button id="BtnBulkCancel" type="button" class="btn btn-outline-danger btn-sm fw-semibold text-nowrap py-2">
                                <i class="bx bx-trash me-1"></i>ยกเลิกเรียนซ้ำ
                            </button>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table Card -->
    <div class="card table-card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5><i class="bx bx-list-ul me-2"></i>รายชื่อนักเรียนที่ต้องเรียนซ้ำ (ติด 0, ร, มส)</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-label-danger"><i class="bx bx-error-circle me-1"></i>รอลงทะเบียน <?= $countNeedsRepeat ?> คน</span>
                <span class="badge bg-label-success"><i class="bx bx-check-circle me-1"></i>ลงทะเบียนแล้ว <?= $countRegistered ?> คน</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="students-table">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 45px;">
                                <input type="checkbox" id="SelectAll" class="form-check-input" title="เลือกทั้งหมด">
                            </th>
                            <th style="width: 70px;" class="text-nowrap">ห้อง</th>
                            <th style="width: 60px;" class="text-nowrap">เลขที่</th>
                            <th style="width: 100px;" class="text-nowrap">รหัสประจำตัว</th>
                            <th class="text-start ps-3 text-nowrap" style="min-width: 190px;"><i class="bx bx-user me-1 text-primary"></i>ชื่อ - นามสกุล</th>
                            <th style="width: 85px;" class="text-nowrap">วิชาอื่น</th>
                            <th style="width: 75px;" class="text-nowrap">เกรดเดิม</th>
                            <th style="width: 130px;" class="text-nowrap">สถานะ</th>
                            <th class="text-nowrap">ครูผู้สอน (เรียนซ้ำ)</th>
                            <!-- ปุ่มมอบหมายและคำสั่งรายคน -->
                            <th class="text-center text-nowrap" style="width: 140px;">
                                <i class="bx bx-cog me-1"></i>คำสั่ง / มอบหมาย
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($DataRepeat as $key => $v_DataRepeat) : ?>
                        <?php
                            // ลงทะเบียนเรียนซ้ำในรอบปัจจุบันแล้ว: ต้องเป็นปีปัจจุบัน มีครูดูแลซ้ำ และสถานะไม่ผ่าน
                            $isCurrentRepeatYear = (!empty($activeRepeatYear) && isset($v_DataRepeat->RepeatYear) && $v_DataRepeat->RepeatYear == $activeRepeatYear);
                            $hasRepeatTeacher = (!empty($v_DataRepeat->RepeatTeacher));
                            $isRegisteredForRepeat = ($hasRepeatTeacher && $isCurrentRepeatYear && isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ไม่ผ่าน");

                            if ($isRegisteredForRepeat) {
                                $statusText = 'ลงทะเบียนเรียนซ้ำ';
                                $statusClass = 'info';
                                $rowClass = 'table-info';
                            } else {
                                $statusText = 'ต้องเรียนซ้ำ';
                                $statusClass = 'danger';
                                $rowClass = 'table-danger';
                            }

                            $studentFullName = (isset($v_DataRepeat->StudentPrefix) ? esc($v_DataRepeat->StudentPrefix) : '').
                                               (isset($v_DataRepeat->StudentFirstName) ? esc($v_DataRepeat->StudentFirstName) : '').' '.
                                               (isset($v_DataRepeat->StudentLastName) ? esc($v_DataRepeat->StudentLastName) : '');
                            
                            $currentTeacherId = !empty($v_DataRepeat->RepeatTeacher) ? $v_DataRepeat->RepeatTeacher : $regularTeacherID;
                        ?>
                        <tr class="<?= $rowClass ?>" data-status="<?= $statusText ?>"
                            data-class="<?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>"
                            data-name="<?= esc($studentFullName) ?>"
                            data-code="<?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?>">
                            <td class="text-center">
                                <input type="checkbox" name="SelRepeat[]" 
                                    value="<?= isset($v_DataRepeat->StudentID) ? esc($v_DataRepeat->StudentID) : '' ?>"
                                    class="form-check-input SelRepeat">
                            </td>
                            <td class="text-center text-nowrap">
                                <span class="badge bg-label-primary fw-bold text-nowrap"><?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?></span>
                            </td>
                            <td class="text-center text-nowrap"><?= isset($v_DataRepeat->StudentNumber) ? esc($v_DataRepeat->StudentNumber) : '' ?></td>
                            <td class="text-center text-nowrap">
                                <span class="badge bg-label-dark fw-bold text-nowrap"><?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?></span>
                            </td>
                            <td class="fw-medium ps-3 text-nowrap">
                                <div class="d-inline-flex align-items-center text-nowrap">
                                    <i class="bx bx-user-circle me-1 text-success fs-5"></i>
                                    <span class="fw-bold text-dark text-nowrap"><?= $studentFullName ?></span>
                                </div>
                                <?php if(isset($v_DataRepeat->Grade_Type) && !empty($v_DataRepeat->Grade_Type) && $isRegisteredForRepeat) : ?>
                                    <span class="badge bg-label-warning text-nowrap ms-1" style="font-size: 0.68rem;"><i class="bx bx-revision me-1"></i><?= esc($v_DataRepeat->Grade_Type) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(isset($v_DataRepeat->OtherRepeatCount) && $v_DataRepeat->OtherRepeatCount > 0) : ?>
                                    <span class="badge bg-label-danger rounded-pill" title="ลงทะเบียนวิชาอื่นแล้ว <?= $v_DataRepeat->OtherRepeatCount ?> วิชา">
                                        <i class="bx bx-layer me-1"></i><?= $v_DataRepeat->OtherRepeatCount ?>
                                    </span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="grade-badge fail"><?= isset($v_DataRepeat->Grade) ? esc($v_DataRepeat->Grade) : '' ?></span>
                            </td>
                            <td class="text-center">
                                <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                                <?php if ($isRegisteredForRepeat && isset($v_DataRepeat->RepeatYear) && !empty($v_DataRepeat->RepeatYear)): ?>
                                    <div class="small text-muted mt-1" style="font-size: 0.72rem;">
                                        <i class="bx bx-calendar-alt me-1"></i>ปี <?= esc($v_DataRepeat->RepeatYear) ?>
                                    </div>
                                <?php elseif (!empty($v_DataRepeat->RepeatYear)): ?>
                                    <div class="small text-danger mt-1" style="font-size: 0.72rem;">
                                        <i class="bx bx-history me-1"></i>รอบเดิมปี <?= esc($v_DataRepeat->RepeatYear) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center small">
                                <?php if ($isRegisteredForRepeat): ?>
                                    <span class="text-success fw-semibold">
                                        <i class="bx bx-user-check me-1"></i><?= isset($v_DataRepeat->RepeatTeacherName) && !empty($v_DataRepeat->RepeatTeacherName) ? esc($v_DataRepeat->RepeatTeacherName) : '-' ?>
                                    </span>
                                <?php elseif (!empty($v_DataRepeat->RepeatTeacherName)): ?>
                                    <span class="text-muted"><i class="bx bx-user me-1"></i><?= esc($v_DataRepeat->RepeatTeacherName) ?> <small class="text-danger">(รอบเดิม)</small></span>
                                <?php else: ?>
                                    <span class="text-muted">- ยังไม่ได้ระบุ -</span>
                                <?php endif; ?>
                            </td>

                            <!-- Action Column: ปุ่มมอบหมาย / เปลี่ยนครู / ยกเลิก -->
                            <td class="text-center text-nowrap">
                                <?php if ($isRegisteredForRepeat): ?>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-warning btn-single-assign" 
                                            data-stuid="<?= esc($v_DataRepeat->StudentID) ?>" 
                                            data-stucode="<?= esc($v_DataRepeat->StudentCode) ?>"
                                            data-stuname="<?= esc($studentFullName) ?>" 
                                            data-class="<?= esc($v_DataRepeat->StudentClass) ?>" 
                                            data-grade="<?= esc($v_DataRepeat->Grade) ?>" 
                                            data-teacher="<?= esc($currentTeacherId) ?>"
                                            title="แก้ไข/เปลี่ยนครูผู้สอน">
                                            <i class="bx bx-edit me-1"></i>เปลี่ยนครู
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-single-cancel" 
                                            data-stuid="<?= esc($v_DataRepeat->StudentID) ?>" 
                                            data-stuname="<?= esc($studentFullName) ?>" 
                                            title="ยกเลิกการลงทะเบียนเรียนซ้ำ">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <!-- ปุ่มมอบหมายสำหรับนักเรียนที่ยังไม่ได้ลงทะเบียนในรอบนี้ -->
                                    <button type="button" class="btn btn-sm btn-success fw-bold btn-single-assign" 
                                        data-stuid="<?= esc($v_DataRepeat->StudentID) ?>" 
                                        data-stucode="<?= esc($v_DataRepeat->StudentCode) ?>"
                                        data-stuname="<?= esc($studentFullName) ?>" 
                                        data-class="<?= esc($v_DataRepeat->StudentClass) ?>" 
                                        data-grade="<?= esc($v_DataRepeat->Grade) ?>" 
                                        data-teacher="<?= esc($regularTeacherID) ?>"
                                        style="background-color: #15a362; border-color: #15a362;">
                                        <i class="bx bx-user-plus me-1"></i>มอบหมาย
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Hidden Inputs for context -->
    <input type="hidden" id="YearRepeat" value="<?= esc($Term . '/' . $Year) ?>">
    <input type="hidden" id="SubjectRepeat" value="<?= esc($IDSubject) ?>">

    <?php else :  ?>
    <!-- Empty State -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center py-5">
                <i class="bx bx-check-circle display-1 text-success mb-3"></i>
                <h5 class="fw-bold text-dark">ไม่มีนักเรียนที่ต้องเรียนซ้ำในรายวิชานี้</h5>
                <p class="text-muted">ไม่พบนักเรียนที่มีผลการเรียน 0, ร, มส ในภาคเรียนที่ <?= esc($Term) ?> / ปีการศึกษา <?= esc($Year) ?> (นักเรียนทุกคนมีผลการเรียนผ่านปกติ)</p>
                <a class="btn btn-primary-green mt-3" href="<?= site_url('Admin/Acade/Registration/Repeat?year=' . urlencode($Term . '/' . $Year)) ?>">
                    <i class="bx bx-arrow-back me-1"></i>ย้อนกลับไปหน้ารวมการเรียนซ้ำ
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<!-- Section Modals: วางนอก Content Stacking Context ตามกฎระบบเพื่อป้องกันจอดำค้าง -->
<?= $this->section('modals') ?>

<!-- Modal มอบหมายครูผู้สอนรายบุคคล (Single Assign Modal) -->
<div class="modal fade" id="SingleAssignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <h5 class="modal-title fw-bold text-white mb-0" id="singleAssignModalTitle">
                    <i class="bx bx-user-plus me-2"></i>มอบหมายครูผู้สอนเรียนซ้ำ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- ข้อมูลรอบการเรียนซ้ำ -->
                <div class="alert alert-success d-flex align-items-center mb-3 py-2 px-3">
                    <i class="bx bx-info-circle fs-4 me-2"></i>
                    <div style="font-size: 0.88rem;">
                        <strong>รอบเรียนซ้ำ:</strong> ภาคเรียน <?= esc($Term) ?>/<?= esc($Year) ?> &bull; 
                        <strong><?= esc($repeatAttemptDisplay) ?></strong> (ปีการศึกษา <?= esc($activeRepeatYear) ?>)
                    </div>
                </div>

                <!-- ข้อมูลนักเรียน -->
                <div class="card bg-light border-0 mb-3 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small">ชื่อ - นามสกุล:</span>
                        <span class="fw-bold text-dark fs-6" id="singleModalStudentName">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small">รหัสนักเรียน:</span>
                        <span class="fw-semibold text-primary" id="singleModalStudentCode">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small">ห้องเรียน:</span>
                        <span class="fw-semibold" id="singleModalStudentClass">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">ผลการเรียนเดิม:</span>
                        <span class="badge bg-danger fs-6" id="singleModalStudentGrade">-</span>
                    </div>
                </div>

                <!-- Dropdown เลือกครูผู้สอน -->
                <div class="mb-3">
                    <label for="singleTeacherSelect" class="form-label fw-bold text-dark">
                        <i class="bx bx-user me-1 text-success"></i>เลือกครูผู้สอน (เรียนซ้ำ) <span class="text-danger">*</span>
                    </label>
                    <select id="singleTeacherSelect" class="form-select form-select-lg">
                        <option value="">-- กรุณาเลือกครูผู้สอน --</option>
                        <?php 
                            if (isset($sortedTeachers) && is_array($sortedTeachers)) {
                                foreach ($sortedTeachers as $v_t): 
                                    $isReg = ($regularTeacherID && isset($v_t->pers_id) && $v_t->pers_id == $regularTeacherID);
                                    $tName = (isset($v_t->pers_prefix) ? esc($v_t->pers_prefix) : '').(isset($v_t->pers_firstname) ? esc($v_t->pers_firstname) : '').' '.(isset($v_t->pers_lastname) ? esc($v_t->pers_lastname) : '');
                                    if ($isReg) $tName .= ' ⭐ (ครูประจำวิชา)';
                        ?>
                            <option value="<?= isset($v_t->pers_id) ? esc($v_t->pers_id) : '' ?>">
                                <?= $tName ?>
                            </option>
                        <?php 
                                endforeach;
                            }
                        ?>
                    </select>
                    <small class="text-muted mt-1 d-block">ระบบตั้งต้นครูประจำวิชาไว้ให้อัตโนมัติ สามารถเปลี่ยนเป็นครูท่านอื่นได้</small>
                </div>

                <input type="hidden" id="singleModalStudentID" value="">
            </div>
            <div class="modal-footer bg-light px-4 py-3 border-0">
                <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ยกเลิก
                </button>
                <button type="button" id="btnConfirmSingleAssign" class="btn btn-success fw-bold px-4" style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-check me-1"></i>บันทึกการมอบหมาย
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำในวิชานี้ (ประวัติ) -->
<div class="modal fade" id="SubjectStudentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <h5 class="modal-title fw-bold text-white mb-0">
                    <i class="bx bx-user-circle me-2"></i>ประวัตินักเรียนที่ลงทะเบียนเรียนซ้ำในรายวิชา
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-success d-flex align-items-center mb-3">
                    <i class="bx bx-book-bookmark fs-4 me-2"></i>
                    <div>รายวิชา: <strong><?= esc($subjectCodeDisplay) ?> <?= esc($subjectNameDisplay) ?></strong></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tb_SubjectStudentDetails">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center text-nowrap">ห้อง</th>
                                <th class="text-center text-nowrap">เลขที่</th>
                                <th class="text-center text-nowrap">เลขประจำตัว</th>
                                <th class="text-start ps-3 text-nowrap"><i class="bx bx-user me-1 text-primary"></i>ชื่อ - นามสกุล</th>
                                <th class="text-center text-nowrap">สถานะ</th>
                                <th class="text-nowrap">ครูผู้สอน (เรียนซ้ำ)</th>
                                <th class="text-center text-nowrap">ปีการศึกษา</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 border-0">
                <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Function to show student details modal for this subject
function showSubjectStudentDetailsModal() {
    $('#SubjectStudentDetailsModal').modal('show');
    
    if ($.fn.DataTable.isDataTable('#tb_SubjectStudentDetails')) {
        $('#tb_SubjectStudentDetails').DataTable().destroy();
    }
    
    var subjectID = $('#SubjectRepeat').val();
    
    $('#tb_SubjectStudentDetails').DataTable({
        destroy: true,
        processing: true,
        autoWidth: false,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetailsBySubject') ?>",
            type: "POST",
            data: { subject_id: subjectID }
        },
        columns: [
            { 
                data: 'StudentClass',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-primary fw-bold text-nowrap">' + (data || '-') + '</span>';
                }
            },
            { data: 'StudentNumber', className: 'text-center text-nowrap' },
            { 
                data: 'StudentCode',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-dark fw-bold text-nowrap">' + (data || '-') + '</span>';
                }
            },
            { 
                data: null,
                className: 'text-nowrap',
                render: function(data, type, row) {
                    var name = (data.StudentPrefix || '') + (data.StudentFirstName || '') + ' ' + (data.StudentLastName || '');
                    var badge = data.Grade_Type ? ' <span class="badge bg-label-warning text-nowrap ms-1" style="font-size: 0.68rem;"><i class="bx bx-revision me-1"></i>' + data.Grade_Type + '</span>' : '';
                    return '<div class="d-inline-flex align-items-center text-nowrap"><i class="bx bx-user-circle me-1 text-success fs-5"></i><span class="fw-bold text-dark text-nowrap">' + name + '</span>' + badge + '</div>';
                }
            },
            { 
                data: 'RepeatStatus',
                className: 'text-center',
                render: function(data) {
                    if (data === 'ผ่าน') {
                        return '<span class="badge bg-label-success"><i class="bx bx-check me-1"></i>ผ่าน</span>';
                    } else if (data === 'ไม่ผ่าน') {
                        return '<span class="badge bg-label-info"><i class="bx bx-time me-1"></i>กำลังเรียนซ้ำ</span>';
                    } else {
                        return '<span class="badge bg-label-secondary">' + (data || '-') + '</span>';
                    }
                }
            },
            { 
                data: 'RepeatTeacherName',
                 render: function(data) {
                    return data ? '<span class="text-success"><i class="bx bx-user me-1"></i>' + data + '</span>' : '-';
                }
            },
            { 
                 data: 'RepeatYear',
                 className: 'text-center',
                 render: function(data) {
                    return data ? '<span class="badge bg-label-success">' + data + '</span>' : '-';
                }
             }
        ],
        order: [[0, 'asc'], [1, 'asc']],
        language: {
            processing: '<div class="py-3"><div class="spinner-border text-success"></div></div>',
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });
}

$(document).ready(function() {
    
    // --- 0. Initialize Select2 for Teachers ---
    $('#GlobalTeacherSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'เลือกครูผู้สอนเพื่อมอบหมาย...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('body')
    });

    $('#singleTeacherSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'เลือกครูผู้สอน (เรียนซ้ำ)...',
        allowClear: false,
        width: '100%',
        dropdownParent: $('#SingleAssignModal')
    });

    $('#statusFilter, #classFilter').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // --- Backdrop Safeguard Cleanup ---
    $('.modal').on('hidden.bs.modal', function() {
        if ($('.modal.show').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
        }
    });

    // --- 1. Filtering Logic ---
    function filterStudents() {
        const selectedStatus = $('#statusFilter').val();
        const selectedClass = $('#classFilter').val();
        const searchTerm = $('#nameSearch').val().toLowerCase();

        $('#students-table tbody tr').each(function() {
            const rowStatus = $(this).data('status');
            const rowClass = $(this).data('class');
            const rowName = String($(this).data('name') || '').toLowerCase();
            const rowCode = String($(this).data('code') || '').toLowerCase();

            const statusMatch = (selectedStatus === 'ทั้งหมด' || rowStatus === selectedStatus);
            const classMatch = (selectedClass === 'ทั้งหมด' || rowClass === selectedClass);
            const searchMatch = (searchTerm === '' || rowName.includes(searchTerm) || rowCode.includes(searchTerm));

            if (statusMatch && classMatch && searchMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        updateSelectionState();
    }

    $('#statusFilter, #classFilter, #nameSearch').on('change keyup', filterStudents);
    filterStudents();

    // --- 2. Selection Logic (Bulk) ---
    $('#SelectAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.SelRepeat:visible:not(:disabled)').prop('checked', isChecked);
        updateSelectionState();
    });

    $(document).on('change', '.SelRepeat', function() {
        updateSelectionState();
        const allVisible = $('.SelRepeat:visible:not(:disabled)');
        const allChecked = $('.SelRepeat:visible:checked');
        $('#SelectAll').prop('checked', allVisible.length > 0 && allVisible.length === allChecked.length);
        $('#SelectAll').prop('indeterminate', allChecked.length > 0 && allChecked.length < allVisible.length);
    });

    function updateSelectionState() {
        const checkedCount = $('.SelRepeat:checked').length;
        $('#SelectionCount').html('<i class="bx bx-user-check me-1"></i>เลือก ' + checkedCount + ' คน');
    }

    // --- 3. Bulk Action: มอบหมายครูผู้สอน ---
    $('#BtnBulkRegister').click(function() {
        const selectedStudents = [];
        $('.SelRepeat:checked').each(function() {
            selectedStudents.push($(this).val());
        });

        if (selectedStudents.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'ยังไม่ได้เลือกนักเรียน',
                text: 'กรุณาติ๊กเลือกนักเรียนในตารางที่ต้องการมอบหมายอย่างน้อย 1 คน',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        const teacherID = $('#GlobalTeacherSelect').val();
        const teacherName = $('#GlobalTeacherSelect option:selected').text().trim();

        if (!teacherID) {
            Swal.fire({
                icon: 'warning',
                title: 'ยังไม่ได้เลือกครู',
                text: 'กรุณาเลือกครูผู้สอนจากรายการมอบหมายก่อนกดยืนยัน',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        Swal.fire({
            title: 'ยืนยันมอบหมายครูผู้สอน?',
            html: `ต้องการมอบหมายนักเรียน <b>${selectedStudents.length} คน</b><br>ให้เรียนซ้ำกับครู <b>${teacherName}</b> ใช่หรือไม่?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: '<i class="bx bx-check me-1"></i>ยืนยันมอบหมาย',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performSaveAction('register', selectedStudents, teacherID);
            }
        });
    });

    // --- Bulk Action: ยกเลิกเรียนซ้ำ ---
    $('#BtnBulkCancel').click(function() {
        const selectedStudents = [];
        $('.SelRepeat:checked').each(function() {
            selectedStudents.push($(this).val());
        });

        if (selectedStudents.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'ยังไม่ได้เลือกนักเรียน',
                text: 'กรุณาติ๊กเลือกนักเรียนในตารางที่ต้องการยกเลิกอย่างน้อย 1 คน',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        Swal.fire({
            title: 'ยืนยันยกเลิกเรียนซ้ำ?',
            html: `ต้องการยกเลิกการลงทะเบียนเรียนซ้ำของนักเรียน <b>${selectedStudents.length} คน</b> ใช่หรือไม่?<br><small class="text-danger">ข้อมูลการเรียนซ้ำและครูผู้ดูแลจะถูกถอนออก</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: '<i class="bx bx-trash me-1"></i>ยืนยันยกเลิก',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ไม่ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performSaveAction('delete', selectedStudents, null);
            }
        });
    });

    // --- 4. Single Student Assignment (มอบหมาย / เปลี่ยนครู รายบุคคล) ---
    $(document).on('click', '.btn-single-assign', function() {
        const stuId = $(this).data('stuid');
        const stuCode = $(this).data('stucode') || '-';
        const stuName = $(this).data('stuname') || '-';
        const stuClass = $(this).data('class') || '-';
        const stuGrade = $(this).data('grade') || '-';
        const teacherId = $(this).data('teacher') || '';

        $('#singleModalStudentID').val(stuId);
        $('#singleModalStudentCode').text(stuCode);
        $('#singleModalStudentName').text(stuName);
        $('#singleModalStudentClass').text(stuClass);
        $('#singleModalStudentGrade').text(stuGrade);

        if (teacherId) {
            $('#singleTeacherSelect').val(teacherId).trigger('change');
        } else {
            $('#singleTeacherSelect').val($('#GlobalTeacherSelect').val()).trigger('change');
        }

        $('#SingleAssignModal').modal('show');
    });

    // ยืนยันใน Single Modal
    $('#btnConfirmSingleAssign').click(function() {
        const stuId = $('#singleModalStudentID').val();
        const teacherId = $('#singleTeacherSelect').val();
        const teacherName = $('#singleTeacherSelect option:selected').text().trim();

        if (!stuId) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่พบรหัสนักเรียน', confirmButtonColor: '#dc3545' });
            return;
        }

        if (!teacherId) {
            Swal.fire({ icon: 'warning', title: 'ยังไม่ได้เลือกครู', text: 'กรุณาเลือกครูผู้สอนก่อนบันทึก', confirmButtonColor: '#15a362' });
            return;
        }

        $('#SingleAssignModal').modal('hide');

        performSaveAction('register', [stuId], teacherId);
    });

    // --- 5. Single Student Cancel (ยกเลิกรายบุคคล) ---
    $(document).on('click', '.btn-single-cancel', function() {
        const stuId = $(this).data('stuid');
        const stuName = $(this).data('stuname') || '';

        Swal.fire({
            title: 'ยืนยันยกเลิกเรียนซ้ำ?',
            html: `ต้องการยกเลิกการลงทะเบียนเรียนซ้ำของ <b>${stuName}</b> ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: '<i class="bx bx-trash me-1"></i>ยืนยันยกเลิก',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ไม่ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performSaveAction('delete', [stuId], null);
            }
        });
    });

    // --- 6. Helper Function: Perform AJAX Save / Delete ---
    function performSaveAction(action, studentIDs, teacherID) {
        const formData = {
            YearRepeat: $('#YearRepeat').val(),
            SubjectRepeat: $('#SubjectRepeat').val(),
        };

        if (action === 'register') {
            formData.StuID = studentIDs;
            formData.RepeatTeacher = teacherID;
        } else if (action === 'delete') {
            formData.DelStuID = studentIDs;
            formData.DelStatus = "Del";
        }

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
            type: 'post',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังบันทึกข้อมูล...',
                    html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message + (response.affected_rows ? ' (' + response.affected_rows + ' รายการ)' : ''),
                        confirmButtonColor: '#15a362',
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }

});
</script>
<?= $this->endSection() ?>
