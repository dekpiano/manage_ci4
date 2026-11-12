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
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(21, 163, 98, 0.25);
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -40px;
    left: -40px;
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
}

.welcome-banner .content { position: relative; z-index: 1; }
.welcome-banner h1 { font-size: 1.6rem; font-weight: 700; color: #ffffff !important; margin-bottom: 0.25rem; }
.welcome-banner p { color: #ffffff !important; opacity: 1 !important; font-size: 0.95rem; margin: 0; }
.welcome-banner .year-badge {
    display: inline-flex;
    align-items: center;
    background: #ffffff;
    padding: 0.4rem 0.9rem;
    border-radius: 50px;
    color: var(--primary-green-dark);
    font-weight: 700;
    margin-top: 0.75rem;
    font-size: 0.85rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.welcome-banner .year-badge i { margin-right: 0.4rem; }
.welcome-banner .icon-wrapper {
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.15);
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}

/* ===== Stat Cards ===== */
.stat-card {
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 12px 12px 0 0;
}
.stat-card.card-danger::before { background: linear-gradient(90deg, #dc3545, #ff6b6b); }
.stat-card.card-warning::before { background: linear-gradient(90deg, #ffc107, #ffda44); }
.stat-card.card-info::before { background: linear-gradient(90deg, #17a2b8, #20c997); }
.stat-card.card-success::before { background: var(--gradient-green); }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}
.stat-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.45rem;
}
.stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1.2; }
.stat-label { font-size: 0.85rem; color: #6c757d; margin-top: 2px; }

/* ===== Step Workflow Navigation Pills ===== */
.repeat-step-nav {
    background: #ffffff;
    border-radius: 14px;
    padding: 0.6rem;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.04);
}
.repeat-step-pills .nav-link {
    border-radius: 10px;
    background: #f8f9fa;
    color: #566a7f;
    border: 1px solid #e9ecef;
    padding: 0.8rem 1.1rem;
    font-size: 0.92rem;
    transition: all 0.25s ease;
}
.repeat-step-pills .nav-link:hover {
    background: #f0f7f3;
    color: var(--primary-green-dark);
    transform: translateY(-1px);
}
.repeat-step-pills .step-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.08);
    font-size: 0.85rem;
    font-weight: 700;
}

/* Distinct Vibrant Colors for Each Step when Active */
#tab-pending-btn.active {
    background: linear-gradient(135deg, #ff9f43 0%, #ffb900 100%) !important;
    color: #ffffff !important;
    border-color: #ff9f43 !important;
    box-shadow: 0 6px 20px rgba(255, 159, 67, 0.35);
}
#tab-pending-btn.active .step-num {
    background: #ffffff !important;
    color: #c97100 !important;
}

#tab-students-btn.active {
    background: var(--gradient-green) !important;
    color: #ffffff !important;
    border-color: var(--primary-green) !important;
    box-shadow: 0 6px 20px rgba(21, 163, 98, 0.35);
}
#tab-students-btn.active .step-num {
    background: #ffffff !important;
    color: var(--primary-green-dark) !important;
}

#tab-registered-btn.active {
    background: linear-gradient(135deg, #0d6efd 0%, #696cff 100%) !important;
    color: #ffffff !important;
    border-color: #696cff !important;
    box-shadow: 0 6px 20px rgba(105, 108, 255, 0.35);
}
#tab-registered-btn.active .step-num {
    background: #ffffff !important;
    color: #4a4dff !important;
}

#tab-all-subjects-btn.active {
    background: linear-gradient(135deg, #6f42c1 0%, #8540f5 100%) !important;
    color: #ffffff !important;
    border-color: #6f42c1 !important;
    box-shadow: 0 6px 20px rgba(111, 66, 193, 0.35);
}
#tab-all-subjects-btn.active .step-num {
    background: #ffffff !important;
    color: #6f42c1 !important;
}

/* Quick Filter Pills for Students */
.grade-filter-btn {
    border-radius: 20px;
    font-size: 0.82rem;
    padding: 0.35rem 0.85rem;
    font-weight: 600;
    border: 1px solid #d0d7de;
    background: #ffffff;
    color: #495057;
    transition: all 0.2s ease;
}
.grade-filter-btn:hover {
    background: #e8fadf;
    border-color: var(--primary-green);
    color: var(--primary-green-dark);
}
.grade-filter-btn.active {
    background: var(--primary-green) !important;
    color: #ffffff !important;
    border-color: var(--primary-green) !important;
    box-shadow: 0 3px 10px rgba(21, 163, 98, 0.35);
}

/* Single-Line Student Name & Text Lock */
.text-nowrap, .student-name-nowrap {
    white-space: nowrap !important;
}
.student-name-pill {
    display: inline-flex;
    align-items: center;
    white-space: nowrap !important;
    font-weight: 600;
    color: #2b343b;
}

/* Micro Subject Chip for Student Table */
.sub-pill-chip {
    display: inline-flex;
    align-items: center;
    white-space: nowrap !important;
    background: #ffffff;
    border: 1px solid #c7ebd8;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    border-radius: 6px;
    padding: 0.25rem 0.55rem;
    font-size: 0.82rem;
    transition: all 0.15s ease;
}
.sub-pill-chip:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    border-color: var(--primary-green);
}

/* Table Card */
.table-card {
    border-radius: 14px;
    border: none;
    overflow: hidden;
}
.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 1.1rem 1.4rem;
}

/* Badges */
.subject-code-badge {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #495057;
}
.repeat-count-badge {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #212529;
}
.class-badge {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.8rem;
    color: var(--primary-green);
}

.btn-register {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    background: var(--gradient-green);
    border: none;
    color: #fff;
    padding: 0.4rem 0.9rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}
.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.35);
    color: #fff;
}
.btn-register i { margin-right: 0.3rem; }

/* SweetAlert2 & Modals */
.swal2-container { z-index: 9999 !important; }
.modal { z-index: 1060 !important; }
.modal-backdrop { z-index: 1050 !important; }
body:not(.modal-open) .modal-backdrop { display: none !important; pointer-events: none !important; }

/* Select2 Emerald Theme Enhancements */
.select2-container--bootstrap-5 .select2-selection {
    border-color: #d9dee3;
    font-size: 0.875rem;
    min-height: calc(1.5em + 0.5rem + 2px);
    border-radius: 0.375rem;
}
.select2-container--bootstrap-5.select2-container--focus .select2-selection,
.select2-container--bootstrap-5.select2-container--open .select2-selection {
    border-color: #15a362 !important;
    box-shadow: 0 0 0 0.2rem rgba(21, 163, 98, 0.25) !important;
}
.select2-container--bootstrap-5 .select2-dropdown .select2-results__option--highlighted[aria-selected] {
    background-color: #15a362 !important;
    color: #ffffff !important;
}
.select2-container--bootstrap-5 .select2-dropdown .select2-results__option--selected {
    background-color: #e8fadf !important;
    color: #15a362 !important;
    font-weight: 600;
}
.select2-container { z-index: 1055; }
.modal .select2-container { z-index: 1065 !important; }
.modal .select2-dropdown { z-index: 1075 !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <?php
        $repeatSetting = $repeat_setting ?? null;
        $repeatStatus = is_object($repeatSetting) ? ($repeatSetting->onoff_status ?? 'off') : 'off';
        $repeatDetail = is_object($repeatSetting) ? ($repeatSetting->onoff_detail ?? '') : '';
        $repeatYear = is_object($repeatSetting) ? ($repeatSetting->onoff_year ?? ($selectedYear ?? '')) : ($selectedYear ?? '');
        $repeatYearParts = explode('/', (string) $repeatYear, 2);
        $repeatTerm = count($repeatYearParts) === 2 ? $repeatYearParts[0] : '';
        $repeatAcademicYear = count($repeatYearParts) === 2 ? $repeatYearParts[1] : $repeatYear;
        $availableTerms = ['1' => '1', '2' => '2'];
        $availableAcademicYears = [];
        foreach (($CountYear ?? []) as $yearRecord) {
            $yearParts = explode('/', (string) ($yearRecord->RegisterYear ?? ''), 2);
            if (count($yearParts) === 2) {
                $availableTerms[$yearParts[0]] = $yearParts[0];
                $availableAcademicYears[$yearParts[1]] = $yearParts[1];
            } elseif ($yearParts[0] !== '') {
                $availableAcademicYears[$yearParts[0]] = $yearParts[0];
            }
        }
        if ($repeatTerm !== '' && !isset($availableTerms[$repeatTerm])) {
            $availableTerms[$repeatTerm] = $repeatTerm;
        }
        if ($repeatAcademicYear !== '' && !isset($availableAcademicYears[$repeatAcademicYear])) {
            $availableAcademicYears[$repeatAcademicYear] = $repeatAcademicYear;
        }
        ksort($availableTerms);
        krsort($availableAcademicYears, SORT_NUMERIC);
        $repeatStart = (is_object($repeatSetting) && !empty($repeatSetting->onoff_StartDate)) ? date('Y-m-d H:i:s', strtotime($repeatSetting->onoff_StartDate)) : '';
        $repeatEnd = (is_object($repeatSetting) && !empty($repeatSetting->onoff_EndDate)) ? date('Y-m-d H:i:s', strtotime($repeatSetting->onoff_EndDate)) : '';
        $repeatStatusLabel = $repeatStatus === 'on' ? 'เปิดใช้งาน' : 'ปิดใช้งาน';
        $repeatTermLabel = $repeatTerm !== '' ? 'ภาคเรียนที่ ' . $repeatTerm : '-';
        $repeatYearLabel = $repeatAcademicYear !== '' ? $repeatAcademicYear : '-';
        $repeatDetailLabel = $repeatDetail !== '' ? $repeatDetail : '-';
        $repeatStartLabel = $repeatStart !== '' ? date('d/m/', strtotime($repeatStart)) . (date('Y', strtotime($repeatStart)) + 543) . date(' H:i', strtotime($repeatStart)) : 'ไม่กำหนด';
        $repeatEndLabel = $repeatEnd !== '' ? date('d/m/', strtotime($repeatEnd)) . (date('Y', strtotime($repeatEnd)) + 543) . date(' H:i', strtotime($repeatEnd)) : 'ไม่กำหนด';
    ?>

    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1><i class="bx bx-refresh me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : 'ลงทะเบียนเรียนซ้ำ' ?></h1>
                    <p class="mb-2">
                        ระบบบริหารจัดการการเรียนซ้ำสำหรับนักเรียนที่มีผลการเรียน 0, ร, มส &bull; มอบหมายครูผู้สอนและติดตามผล
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <div class="year-badge" id="header-selected-year-badge">
                            <i class="bx bx-calendar text-success"></i>ปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
                        </div>
                        <?php 
                            $currentRepeatAttempt = '-';
                            foreach ($checkOnOff as $v_onoff) {
                                if ($v_onoff->onoff_name == 'เรียนซ้ำ') {
                                    $currentRepeatAttempt = $v_onoff->onoff_detail;
                                    break;
                                }
                            }
                        ?>
                        <div class="year-badge">
                            <i class="bx bx-revision text-warning"></i><?= esc($currentRepeatAttempt) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-flex justify-content-lg-end align-items-center flex-wrap gap-2">
                        <button type="button" class="btn btn-light fw-semibold text-nowrap shadow-sm" data-bs-toggle="modal" data-bs-target="#repeatSettingsModal">
                            <i class="bx bx-cog me-1"></i>ตั้งค่ารอบเรียนซ้ำ
                        </button>
                        <a href="<?= site_url('Admin/Acade/Registration/Repeat/Report') ?>" class="btn btn-primary fw-semibold text-nowrap shadow-sm">
                            <i class="bx bx-bar-chart-alt-2 me-1"></i>รายงานสรุป (ซ้ำ)
                        </a>
                        <!-- ปุ่มไปที่ขั้นตอนที่ 2: รายชื่อนักเรียนที่ลงทะเบียนซ้ำ -->
                        <button type="button" class="btn btn-warning fw-bold text-dark text-nowrap shadow-sm" onclick="switchToStudentsTab()">
                            <i class="bx bx-user-check me-1"></i>รายชื่อนักเรียน (ซ้ำ)
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-book-reader"></i>
        </div>
    </div>

    <!-- Repeat Settings Current Summary Card -->
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 14px;">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <h6 class="mb-0 fw-bold text-dark"><i class="bx bx-slider me-2 text-success"></i>การตั้งค่ารอบการเรียนซ้ำปัจจุบัน (ระบบเปิด-ปิด)</h6>
            <span class="badge <?= $repeatStatus === 'on' ? 'bg-success' : 'bg-secondary' ?> px-3 py-2 rounded-pill"><?= esc($repeatStatusLabel) ?></span>
        </div>
        <div class="card-body pt-0">
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.78rem;">ภาคเรียนที่เปิด</small>
                    <strong class="text-dark fs-6"><?= esc($repeatTermLabel) ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.78rem;">ปีการศึกษาที่เรียนซ้ำ</small>
                    <strong class="text-success fs-6">พ.ศ. <?= esc($repeatYearLabel) ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.78rem;">ครั้งที่เรียนซ้ำ</small>
                    <strong class="text-warning fs-6"><?= esc($repeatDetailLabel) ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.78rem;">ช่วงเวลากรอกคะแนน</small>
                    <strong class="text-secondary small"><?= esc($repeatStartLabel) ?> – <?= esc($repeatEndLabel) ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: วิชาที่มีเรียนซ้ำ -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-danger h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-danger" id="stat-repeat-subjects"><?= isset($total_subjects_repeat) ? number_format($total_subjects_repeat) : 0 ?></div>
                            <div class="stat-label">รายวิชาที่มีเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bx bx-book-bookmark"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted" id="stat-repeat-year"><i class="bx bx-calendar me-1"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: นักเรียนเรียนซ้ำ (ไฮไลท์) -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-warning h-100 shadow-sm" style="cursor: pointer;" onclick="switchToStudentsTab()" title="คลิกเพื่อดูรายชื่อนักเรียน">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-repeat-students"><?= isset($total_repeat_students) ? number_format($total_repeat_students) : 0 ?></div>
                            <div class="stat-label fw-bold">นักเรียนที่ลงทะเบียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-user-check"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-id-card me-1"></i><span id="stat-repeat-registrations"><?= isset($total_repeat_registrations) ? number_format($total_repeat_registrations) : 0 ?> รายการวิชา</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: ครูดูแลเรียนซ้ำ -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-info h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-repeat-teachers"><?= isset($total_repeat_teachers) ? number_format($total_repeat_teachers) : 0 ?></div>
                            <div class="stat-label">ครูดูแลเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-chalkboard me-1"></i>ผู้รับผิดชอบการสอน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: ปีการศึกษาที่เลือก -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-success h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษาที่เรียกดู</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-info-circle me-1"></i>กรองตามรอบปีการศึกษา</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar: ปีการศึกษา และ ครั้งที่เรียนซ้ำ -->
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 12px;">
        <div class="card-body py-2 px-3">
            <div class="row align-items-center g-3">
                <div class="col-auto d-flex align-items-center gap-2">
                    <label for="CheckYearRegisRepeat" class="form-label mb-0 fw-bold text-nowrap">
                        <i class="bx bx-filter-alt me-1 text-success"></i>ปีการศึกษา:
                    </label>
                    <div style="min-width: 160px;">
                        <select class="form-select form-select-sm select2" id="CheckYearRegisRepeat" name="CheckYearRegisRepeat" style="width: 100%;">
                            <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                            <option <?= (isset($selectedYear) && isset($v_GroupYear->SubjectYear) && (string)$selectedYear === (string)$v_GroupYear->SubjectYear) ? "selected" : "" ?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>">
                                <?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-auto d-none d-md-block">
                    <div class="vr h-100" style="min-height: 24px;"></div>
                </div>

                <div class="col-auto d-flex align-items-center gap-2">
                    <label for="FilterAttempt" class="form-label mb-0 fw-bold text-nowrap">
                        <i class="bx bx-revision me-1 text-warning"></i>ครั้งที่เรียนซ้ำ:
                    </label>
                    <div style="min-width: 200px;">
                        <select class="form-select form-select-sm select2" id="FilterAttempt" style="width: 100%;">
                            <option value="" <?= empty($selectedAttempt) ? 'selected' : '' ?>>ทั้งหมดทุกครั้ง</option>
                            <option value="เรียนซ้ำครั้งที่ 1" <?= ($selectedAttempt ?? '') === 'เรียนซ้ำครั้งที่ 1' ? 'selected' : '' ?>>เรียนซ้ำครั้งที่ 1</option>
                            <option value="เรียนซ้ำครั้งที่ 2" <?= ($selectedAttempt ?? '') === 'เรียนซ้ำครั้งที่ 2' ? 'selected' : '' ?>>เรียนซ้ำครั้งที่ 2</option>
                            <option value="เรียนซ้ำครั้งที่ 3" <?= ($selectedAttempt ?? '') === 'เรียนซ้ำครั้งที่ 3' ? 'selected' : '' ?>>เรียนซ้ำครั้งที่ 3</option>
                            <option value="เรียนซ้ำครั้งที่ 4" <?= ($selectedAttempt ?? '') === 'เรียนซ้ำครั้งที่ 4' ? 'selected' : '' ?>>เรียนซ้ำครั้งที่ 4</option>
                        </select>
                    </div>
                </div>
                
                <div class="col text-end d-none d-lg-block">
                    <small class="text-muted"><i class="bx bx-check-double me-1 text-success"></i>ขั้นตอนการดำเนินงานแบ่งเป็น 3 ขั้นตอนด้านล่าง</small>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">

    <!-- ===== Global Instant Student Search Bar (ค้นหาตามชื่อเพื่อลงทะเบียนเรียนซ้ำทันที ทุกปีการศึกษา) ===== -->
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 14px; background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border: 1.5px solid #86efac !important;">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success p-2 rounded-3 text-white shadow-xs" style="background-color: #15a362 !important;"><i class="bx bx-search-alt fs-4"></i></span>
                        <div>
                            <h6 class="fw-bold text-dark mb-0"><i class="bx bx-user-check me-1 text-success"></i>ค้นหาตามชื่อเพื่อลงทะเบียนเรียนซ้ำ (ทันที)</h6>
                            <small class="text-muted">พิมพ์ชื่อหรือรหัสได้เลย ไม่ต้องทราบว่าเคยติด 0, ร, มส หรือลงทะเบียนเรียนซ้ำปีไหน</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="position-relative">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-success"><i class="bx bx-user-pin fs-5"></i></span>
                            <input type="text" id="globalStudentSearchInput" class="form-control border-start-0 border-end-0 ps-0" placeholder="พิมพ์ชื่อ, นามสกุล หรือเลขประจำตัวนักเรียน (เช่น สมชาย หรือ 05432)..." autocomplete="off">
                            <button type="button" class="btn btn-outline-secondary border-start-0 d-none" id="btnClearGlobalStudentSearch" title="ล้างการค้นหา"><i class="bx bx-x"></i></button>
                            <button type="button" class="btn btn-success fw-bold px-3" id="btnRunGlobalStudentSearch" style="background-color: #15a362; border-color: #15a362;">
                                <i class="bx bx-search me-1"></i>ค้นหานักเรียน
                            </button>
                        </div>
                        
                        <!-- Floating Instant Search Results Dropdown/Panel -->
                        <div id="globalStudentSearchResults" class="position-absolute w-100 bg-white shadow-lg rounded-3 border p-3 mt-1 d-none" style="z-index: 1050; max-height: 420px; overflow-y: auto;">
                            <!-- Results will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ขั้นตอนการทำงาน (Step Workflow Navigation) ===== -->
    <div class="repeat-step-nav mb-4">
        <ul class="nav nav-pills nav-fill repeat-step-pills gap-2" role="tablist">
            <!-- Step 1: รายการรอลงทะเบียนเรียนซ้ำ (ตามวิชา) -->
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active d-flex align-items-center justify-content-center py-2 px-3 fw-bold" id="tab-pending-btn" data-bs-toggle="pill" data-bs-target="#tab-pending" role="tab" aria-controls="tab-pending" aria-selected="true">
                    <span class="step-num me-2">1</span>
                    <i class="bx bx-time-five me-1 fs-5"></i>
                    <span>วิชาที่รอลงทะเบียนซ้ำ</span>
                    <span class="badge bg-danger ms-2 rounded-pill px-2" id="pending-count-pill">0</span>
                </button>
            </li>
            
            <!-- Step 2: รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำแล้ว -->
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link d-flex align-items-center justify-content-center py-2 px-3 fw-bold" id="tab-students-btn" data-bs-toggle="pill" data-bs-target="#tab-students" role="tab" aria-controls="tab-students" aria-selected="false">
                    <span class="step-num me-2">2</span>
                    <i class="bx bx-user-check me-1 fs-5"></i>
                    <span>นักเรียนที่ลงทะเบียนแล้ว</span>
                    <span class="badge bg-success ms-2 rounded-pill px-2" id="students-count-pill">0</span>
                </button>
            </li>

            <!-- Step 3: วิชาที่ลงทะเบียนเรียนซ้ำแล้ว -->
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link d-flex align-items-center justify-content-center py-2 px-3 fw-bold" id="tab-registered-btn" data-bs-toggle="pill" data-bs-target="#tab-registered" role="tab" aria-controls="tab-registered" aria-selected="false">
                    <span class="step-num me-2">3</span>
                    <i class="bx bx-book-bookmark me-1 fs-5"></i>
                    <span>วิชาที่ลงทะเบียนแล้ว</span>
                    <span class="badge bg-primary ms-2 rounded-pill px-2" id="registered-count-pill">0</span>
                </button>
            </li>

            <!-- Tab 4: รายการวิชาหลักทั้งหมด (เสริม) -->
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link d-flex align-items-center justify-content-center py-2 px-3 fw-semibold text-muted" id="tab-all-subjects-btn" data-bs-toggle="pill" data-bs-target="#tab-all-subjects" role="tab" aria-controls="tab-all-subjects" aria-selected="false">
                    <i class="bx bx-list-ul me-1 fs-5"></i>
                    <span>วิชาหลักทั้งหมด</span>
                    <span class="badge bg-secondary ms-2 rounded-pill px-2" id="all-subjects-count-pill">0</span>
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Contents for Steps -->
    <div class="tab-content p-0" id="repeatStepTabContent">

        <!-- ========================================== -->
        <!-- TAB 1: รายการรอลงทะเบียนเรียนซ้ำ (Step 1) -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="tab-pending" role="tabpanel" aria-labelledby="tab-pending-btn">
            <div class="card table-card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #ffc107;">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-time-five me-2 text-warning"></i>ขั้นตอนที่ 1: รายการรอลงทะเบียนเรียนซ้ำ (ติด 0, ร, มส)</h5>
                        <small class="text-muted">ตรวจสอบรายวิชาที่นักเรียนมีผลการเรียนไม่ผ่าน แล้วคลิก <strong>"มอบหมาย"</strong> เพื่อกำหนดครูผู้สอน</small>
                    </div>
                    <span class="badge bg-label-warning fs-6 px-3 py-2" id="pending-count-badge">รอลงทะเบียน 0 วิชา</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbRegisRepeatPending">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bx bx-calendar me-1"></i>เรียนปี</th>
                                    <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                                    <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                                    <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                                    <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                                    <th><i class="bx bx-user me-1"></i>ครูผู้สอน (หลัก)</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-user-x me-1"></i>รอลงทะเบียน</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================================= -->
        <!-- TAB 2: รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำแล้ว (Step 2 - ติดตามรายบุคคล) -->
        <!-- ======================================================================= -->
        <div class="tab-pane fade" id="tab-students" role="tabpanel" aria-labelledby="tab-students-btn">
            <div class="card table-card shadow-sm border-0">
                <div class="card-header pb-3" style="border-left: 5px solid #15a362;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-user-check me-2 text-success"></i>ขั้นตอนที่ 2: รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำแล้ว (ติดตามรายบุคคล)</h5>
                            <small class="text-muted">ค้นหา ตรวจสอบรายชื่อนักเรียนที่ได้รับการมอบหมายครูผู้สอนแล้ว พร้อมดูวิชาที่ลงทะเบียนเรียนซ้ำ</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= site_url('Admin/Acade/Registration/Repeat/Report') ?>" class="btn btn-sm btn-outline-success fw-semibold">
                                <i class="bx bx-printer me-1"></i>พิมพ์รายงานสรุป
                            </a>
                        </div>
                    </div>

                    <!-- Smart Filter Toolbar สำหรับรายชื่อนักเรียน -->
                    <div class="p-3 rounded-3 border" style="background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%); border-color: #dcfce7 !important;">
                        <div class="row g-2 align-items-center">
                            <!-- ระดับชั้นด่วน (Quick Grade Filter Pills) -->
                            <div class="col-12 col-xl-7">
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <span class="small fw-bold text-dark me-2"><i class="bx bx-layer me-1 text-success"></i>ระดับชั้น:</span>
                                    <button type="button" class="btn btn-sm grade-filter-btn active" data-grade="all">ทั้งหมด</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.1">ม.1</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.2">ม.2</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.3">ม.3</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.4">ม.4</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.5">ม.5</button>
                                    <button type="button" class="btn btn-sm grade-filter-btn" data-grade="ม.6">ม.6</button>
                                </div>
                            </div>

                            <!-- กรองห้องเรียนและค้นหาด่วน -->
                            <div class="col-12 col-xl-5">
                                <div class="d-flex gap-2 align-items-center">
                                    <div style="min-width: 150px;">
                                        <select class="form-select form-select-sm select2" id="studentRoomSelect" style="width: 100%;">
                                            <option value="">ทุกห้องเรียน</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm flex-grow-1">
                                        <span class="input-group-text bg-white border-end-0 text-success"><i class="bx bx-search"></i></span>
                                        <input type="text" id="studentQuickSearch" class="form-control border-start-0 ps-0" placeholder="พิมพ์ชื่อ, สกุล หรือรหัสนักเรียน">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tb_RegisteredStudentsMain">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th style="width: 50px;" class="text-nowrap">ลำดับ</th>
                                    <th style="width: 80px;" class="text-nowrap">ห้อง</th>
                                    <th style="width: 60px;" class="text-nowrap">เลขที่</th>
                                    <th style="width: 110px;" class="text-nowrap">รหัสประจำตัว</th>
                                    <th class="text-start ps-3 text-nowrap" style="min-width: 180px;"><i class="bx bx-user me-1 text-primary"></i>ชื่อ - นามสกุล</th>
                                    <th style="width: 120px;" class="text-nowrap">ครั้งที่เรียนซ้ำ</th>
                                    <th style="width: 100px;" class="text-nowrap">จำนวนวิชา</th>
                                    <th class="text-start text-nowrap">วิชาที่ลงทะเบียน & ครูผู้ดูแล</th>
                                    <th style="width: 110px;" class="text-nowrap"><i class="bx bx-history me-1"></i>ประวัติ</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TAB 4: วิชาที่ลงทะเบียนเรียนซ้ำแล้ว (Step 4) -->
        <!-- ============================================== -->
        <div class="tab-pane fade" id="tab-registered" role="tabpanel" aria-labelledby="tab-registered-btn">
            <div class="card table-card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #0d6efd;">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-book-bookmark me-2 text-primary"></i>ขั้นตอนที่ 4: สรุปตามรายวิชาที่ลงทะเบียนเรียนซ้ำแล้ว</h5>
                        <small class="text-muted">รายการวิชาที่ได้รับการมอบหมายครูผู้สอนเรียบร้อยแล้ว สามารถกด <strong>"แก้ไข"</strong> หรือคลิกดูรายชื่อนักเรียนในวิชานั้นได้</small>
                    </div>
                    <span class="badge bg-label-success fs-6 px-3 py-2" id="registered-count-badge">ลงทะเบียนแล้ว 0 วิชา</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbRegisRepeatSubject">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bx bx-calendar me-1"></i>เรียนปี</th>
                                    <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                                    <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                                    <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                                    <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                                    <th><i class="bx bx-user me-1"></i>ครูดูแลซ้ำ</th>
                                    <th class="text-center"><i class="bx bx-revision me-1"></i>ครั้งที่</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-refresh me-1"></i>นักเรียน</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================== -->
        <!-- TAB 4: วิชาหลักทั้งหมด (All Subjects) -->
        <!-- ======================================== -->
        <div class="tab-pane fade" id="tab-all-subjects" role="tabpanel" aria-labelledby="tab-all-subjects-btn">
            <div class="card table-card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #6610f2;">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-book-open me-2" style="color: #6610f2;"></i>วิชาหลักทั้งหมดที่มีการลงทะเบียนนักเรียน</h5>
                        <small class="text-muted">รายวิชาทั้งหมดที่เปิดสอนในภาคเรียนนี้ สำหรับค้นหาหรือตรวจสอบรายวิชาทั่วไป</small>
                    </div>
                    <span class="badge bg-label-secondary fs-6 px-3 py-2" id="main-subjects-count-badge">0 วิชา</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbMainSubjects">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bx bx-calendar me-1"></i>เรียนปี</th>
                                    <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                                    <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                                    <th><i class="bx bx-star me-1"></i>หน่วยกิต</th>
                                    <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                                    <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                                    <th><i class="bx bx-user me-1"></i>ครูผู้สอน</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-group me-1"></i>นักเรียน</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<!-- Section Modals: วางนอก Content Stacking Context เพื่อป้องกันจอดำค้าง 100% -->
<?= $this->section('modals') ?>

<!-- Modal 1: Repeat Settings Modal -->
<div class="modal fade" id="repeatSettingsModal" tabindex="-1" aria-labelledby="repeatSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="repeatSettingsModalLabel"><i class="bx bx-cog me-2"></i>ตั้งค่ารอบการเรียนซ้ำ</h5>
                    <small style="color: #ffffff !important; opacity: 1 !important;">จัดการการเปิด-ปิดระบบและกำหนดช่วงเวลาการเรียนซ้ำ</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="ปิด"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="RepeatSettingStatus" class="form-label fw-bold text-dark">สถานะระบบ</label>
                        <select id="RepeatSettingStatus" class="form-select">
                            <option value="on" <?= $repeatStatus === 'on' ? 'selected' : '' ?>>เปิดระบบ (ใช้งานอยู่)</option>
                            <option value="off" <?= $repeatStatus !== 'on' ? 'selected' : '' ?>>ปิดระบบ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="RepeatSettingTerm" class="form-label fw-bold text-dark">ภาคเรียน</label>
                        <select id="RepeatSettingTerm" class="form-select">
                            <?php foreach ($availableTerms as $term): ?>
                                <option value="<?= esc($term) ?>" <?= (string) $repeatTerm === (string) $term ? 'selected' : '' ?>>ภาคเรียนที่ <?= esc($term) ?></option>
                            <?php endforeach; ?>
                            <?php if (empty($availableTerms)): ?><option value="1" selected>ภาคเรียนที่ 1</option><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="RepeatSettingYear" class="form-label fw-bold text-dark">ปีการศึกษา (พ.ศ.)</label>
                        <select id="RepeatSettingYear" class="form-select">
                            <?php foreach ($availableAcademicYears as $year): ?>
                                <option value="<?= esc($year) ?>" <?= (string) $repeatAcademicYear === (string) $year ? 'selected' : '' ?>><?= esc($year) ?></option>
                            <?php endforeach; ?>
                            <?php if (empty($availableAcademicYears)): ?><option value="<?= esc($repeatAcademicYear) ?>" selected><?= esc($repeatAcademicYear) ?></option><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="RepeatSettingAttempt" class="form-label fw-bold text-dark">ครั้งที่เรียนซ้ำ</label>
                        <select id="RepeatSettingAttempt" class="form-select">
                            <?php foreach ([1,2,3,4] as $attempt): $attemptText = 'เรียนซ้ำครั้งที่ ' . $attempt; ?>
                                <option value="<?= $attemptText ?>" <?= $repeatDetail === $attemptText ? 'selected' : '' ?>><?= $attemptText ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="RepeatSettingStart" class="form-label fw-bold text-dark">วันที่เริ่มต้น (พ.ศ.)</label>
                        <input type="text" id="RepeatSettingStart" class="form-control repeat-setting-datetime" placeholder="วัน/เดือน/ปี พ.ศ. เวลา" value="<?= esc($repeatStart) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="RepeatSettingEnd" class="form-label fw-bold text-dark">วันที่สิ้นสุด (พ.ศ.)</label>
                        <input type="text" id="RepeatSettingEnd" class="form-control repeat-setting-datetime" placeholder="วัน/เดือน/ปี พ.ศ. เวลา" value="<?= esc($repeatEnd) ?>">
                    </div>
                </div>
                <div class="alert alert-info mt-3 mb-0 py-2">
                    <i class="bx bx-info-circle me-1"></i>การตั้งค่านี้ใช้ร่วมกับหน้ากรอกคะแนนเรียนซ้ำของคุณครู
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" id="btnSaveRepeatSettings" class="btn btn-success fw-bold px-4" style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-save me-1"></i>บันทึกการตั้งค่า
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Show Repeat Students for a specific subject group -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <h5 class="modal-title ShowSubjectName text-white mb-0 fw-bold"><i class="bx bx-book-reader me-2"></i>รายชื่อนักเรียนในรายวิชา</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tb_ShowRegisRepeat">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center text-nowrap">ห้อง</th>
                                <th class="text-center text-nowrap">เลขที่</th>
                                <th class="text-center text-nowrap">เลขประจำตัว</th>
                                <th class="text-start ps-3 text-nowrap"><i class="bx bx-user me-1 text-primary"></i>ชื่อ - นามสกุล</th>
                                <th class="text-center text-nowrap">ครั้งที่</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Student Details Modal (เมื่อกดปุ่มดูรายชื่อนักเรียนซ้ำจากข้างบน) -->
<div class="modal fade" id="StudentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0"><i class="bx bx-user-circle me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำทั้งหมด</h5>
                    <small style="color: #ffffff !important; opacity: 1 !important;">ปีการศึกษา <span id="student-modal-year"></span></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100" id="tb_StudentDetails">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center text-nowrap">ห้อง</th>
                                <th class="text-center text-nowrap">เลขที่</th>
                                <th class="text-center text-nowrap">เลขประจำตัว</th>
                                <th class="text-start ps-3 text-nowrap"><i class="bx bx-user me-1 text-primary"></i>ชื่อ - นามสกุล</th>
                                <th class="text-center text-nowrap">ปีที่เรียนซ้ำ</th>
                                <th class="text-center text-nowrap">ครั้งที่</th>
                                <th class="text-center text-nowrap">จำนวนวิชา</th>
                                <th class="text-start text-nowrap">วิชาที่ลงทะเบียน & ครูผู้ดูแล</th>
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

<!-- Modal 4: Student History Detail Modal (ดูรายละเอียดประวัติการเรียนซ้ำรายบุคคล) -->
<div class="modal fade" id="StudentHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <h5 class="modal-title fw-bold text-white mb-0" id="studentHistoryModalTitle">
                    <i class="bx bx-user-detail me-2"></i>รายละเอียดการลงทะเบียนเรียนซ้ำรายบุคคล
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="student-history-content">
                <div class="text-center py-4">
                    <div class="spinner-border text-success"></div>
                    <div class="mt-2 text-muted">กำลังดึงข้อมูล...</div>
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

<!-- Modal 5: Student Assign Modal (มอบหมายวิชาเรียนซ้ำตามตัวนักเรียน - Student-Centric Mode) -->
<div class="modal fade" id="StudentAssignModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header text-white" style="background: var(--gradient-green); padding: 1.1rem 1.4rem;">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0">
                        <i class="bx bx-user-plus me-2"></i>มอบหมายวิชาเรียนซ้ำรายบุคคล (Student-Centric Mode)
                    </h5>
                    <small style="color: #ffffff !important; opacity: 1 !important;">
                        เลือกลงทะเบียนและระบุครูผู้ดูแลเรียนซ้ำสำหรับนักเรียนคนนี้ได้ครบทุกวิชาในหน้าต่างเดียว
                    </small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4" id="student-assign-modal-body">
                <div class="text-center py-5">
                    <div class="spinner-border text-success"></div>
                    <div class="mt-2 text-muted">กำลังดึงข้อมูลรายวิชาที่ติด 0, ร, มส ของนักเรียน...</div>
                </div>
            </div>

            <div class="modal-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
                <button type="button" class="btn btn-success fw-bold px-4 shadow-sm" id="btn-save-student-assign" style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-save me-1"></i>บันทึกการมอบหมายวิชาเรียนซ้ำ
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function updateRepeatCalendarYearToBE(instance) {
    setTimeout(function() {
        var yearInput = instance.currentYearElement;
        if (yearInput && instance.currentYear < 2400) {
            yearInput.value = instance.currentYear + 543;
        }
    }, 0);
}

if (typeof flatpickr !== 'undefined') {
    flatpickr('.repeat-setting-datetime', {
        enableTime: true,
        time_24hr: true,
        disableMobile: true,
        allowInput: true,
        altInput: true,
        altFormat: 'd/m/Y H:i',
        dateFormat: 'Y-m-d H:i:s',
        locale: 'th',
        formatDate: function(date, format) {
            if (format === 'd/m/Y H:i') {
                var day = String(date.getDate()).padStart(2, '0');
                var month = String(date.getMonth() + 1).padStart(2, '0');
                return day + '/' + month + '/' + (date.getFullYear() + 543) + ' ' +
                    String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
            }
            return flatpickr.formatDate(date, format);
        },
        parseDate: function(value, format) {
            if (format === 'd/m/Y H:i' && value && value.indexOf('/') !== -1) {
                var match = value.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{2})$/);
                if (match) {
                    return new Date(Number(match[3]) - 543, Number(match[2]) - 1, Number(match[1]), Number(match[4]), Number(match[5]));
                }
            }
            return flatpickr.parseDate(value, format);
        },
        onReady: function(_, __, instance) { updateRepeatCalendarYearToBE(instance); },
        onOpen: function(_, __, instance) { updateRepeatCalendarYearToBE(instance); },
        onMonthChange: function(_, __, instance) { updateRepeatCalendarYearToBE(instance); },
        onYearChange: function(_, __, instance) { updateRepeatCalendarYearToBE(instance); }
    });
}

// Initialize Select2 in Repeat Settings Modal
$('#repeatSettingsModal').on('shown.bs.modal', function() {
    if ($.fn.select2) {
        $('#RepeatSettingStatus, #RepeatSettingTerm, #RepeatSettingYear, #RepeatSettingAttempt').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#repeatSettingsModal'),
            width: '100%'
        });
    }
});

// Backdrop Safeguard per rules
$('.modal').on('hidden.bs.modal', function() {
    if ($('.modal.show').length === 0) {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
    }
});

// Save repeat settings from this page
$(document).on('click', '#btnSaveRepeatSettings', function() {
    var $btn = $(this);
    var start = $('#RepeatSettingStart').val();
    var end = $('#RepeatSettingEnd').val();

    if (start && end && new Date(start.replace(' ', 'T')) > new Date(end.replace(' ', 'T'))) {
        Swal.fire({ icon: 'warning', title: 'ตรวจสอบช่วงเวลา', text: 'วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด' });
        return;
    }

    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังบันทึก...');

    $.ajax({
        url: '<?= site_url('Admin/Acade/Evaluate/update_repeat_settings') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            setting_status: $('#RepeatSettingStatus').val(),
            setting_year: $('#RepeatSettingTerm').val() + '/' + $('#RepeatSettingYear').val(),
            setting_time: $('#RepeatSettingAttempt').val(),
            setting_start: start,
            setting_end: end
        },
        success: function(response) {
            if (response && response.status === 'success') {
                Swal.fire({ icon: 'success', title: 'บันทึกเรียบร้อย', text: 'ตั้งค่าการเรียนซ้ำเรียบร้อยแล้ว', timer: 1400, showConfirmButton: false })
                    .then(function() { window.location.reload(); });
            } else {
                Swal.fire({ icon: 'error', title: 'บันทึกไม่สำเร็จ', text: (response && response.message) ? response.message : 'ไม่สามารถบันทึกการตั้งค่าได้' });
            }
        },
        error: function(xhr) {
            Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: xhr.responseJSON?.message || 'ไม่สามารถเชื่อมต่อกับระบบได้' });
        },
        complete: function() {
            $btn.prop('disabled', false).html('<i class="bx bx-save me-1"></i>บันทึกการตั้งค่า');
        }
    });
});

const allTeachersList = <?= json_encode($TeacherList ?? []) ?>;
let tbRegisRepeatSubject;
let tbRegisRepeatPending;
let tbRegisteredStudentsMain;
let tbMainSubjects;
let currentAssignStudentData = null;

// Safe Tab Switching Helper (Compatible with Bootstrap 5 native and jQuery)
function showTabSafely(selectorOrEl) {
    var $el = $(selectorOrEl);
    if ($el.length === 0) return;
    var el = $el[0];
    try {
        if (typeof bootstrap !== 'undefined' && bootstrap.Tab) {
            var tabInstance = (typeof bootstrap.Tab.getOrCreateInstance === 'function') 
                ? bootstrap.Tab.getOrCreateInstance(el) 
                : new bootstrap.Tab(el);
            tabInstance.show();
        } else if (typeof $el.tab === 'function') {
            $el.tab('show');
        } else {
            $el.trigger('click');
        }
    } catch(err) {
        $el.trigger('click');
    }
}

// Helper to switch to Registered Students Tab
function switchToStudentsTab() {
    showTabSafely('#tab-students-btn');
    $('html, body').animate({
        scrollTop: $("#repeatStepTabContent").offset().top - 80
    }, 400);
}

// ===============================================================
// RESTORE STATE & PERSISTENCE (จดจำปีการศึกษา, ครั้งที่เรียนซ้ำ และแท็บเดิมเมื่อย้อนกลับ ⭐)
// ===============================================================
(function restoreRepeatFilters() {
    var urlParams = new URLSearchParams(window.location.search);
    var paramYear = urlParams.get('year');
    var paramAttempt = urlParams.get('attempt');
    var paramTab = urlParams.get('tab');

    // 1. กู้คืนปีการศึกษาที่เลือกไว้
    var savedYear = paramYear || localStorage.getItem('repeat_selected_year');
    if (savedYear && $("#CheckYearRegisRepeat option[value='" + savedYear + "']").length > 0) {
        if ($('#CheckYearRegisRepeat').val() !== savedYear) {
            $('#CheckYearRegisRepeat').val(savedYear);
        }
    }

    // 2. กู้คืนครั้งที่เรียนซ้ำ
    var savedAttempt = paramAttempt || localStorage.getItem('repeat_selected_attempt');
    if (savedAttempt !== null && $("#FilterAttempt option[value='" + savedAttempt + "']").length > 0) {
        $('#FilterAttempt').val(savedAttempt);
    }

    // 3. กู้คืนแท็บขั้นตอนการทำงานที่เลือกค้างไว้
    var savedTab = paramTab || localStorage.getItem('repeat_selected_tab');
    if (savedTab && $(".repeat-step-pills button[data-bs-target='" + savedTab + "']").length > 0) {
        showTabSafely(".repeat-step-pills button[data-bs-target='" + savedTab + "']");
    }

    // 4. Initialize Select2 for all filter dropdowns
    if ($.fn.select2) {
        $('#CheckYearRegisRepeat, #FilterAttempt').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        $('#studentRoomSelect').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Trigger change to sync select2 display
        $('#CheckYearRegisRepeat').trigger('change.select2');
        $('#FilterAttempt').trigger('change.select2');
    }
})();

// Helper บันทึกสถานะลง URL & Session
function syncRepeatFilterState() {
    var curYear = $('#CheckYearRegisRepeat').val();
    var curAttempt = $('#FilterAttempt').val();
    var curTab = $('.repeat-step-pills .nav-link.active').data('bs-target') || '#tab-pending';

    try {
        if (curYear) localStorage.setItem('repeat_selected_year', curYear);
        if (curAttempt !== undefined) localStorage.setItem('repeat_selected_attempt', curAttempt);
        if (curTab) localStorage.setItem('repeat_selected_tab', curTab);
    } catch(e) {}

    // อัปเดต URL query parameter โดยไม่ reload หน้า เพื่อให้เวลาคัดลอกลิงก์หรือกดย้อนกลับจะอยู่ปีเดิมเสมอ
    var url = new URL(window.location.href);
    if (curYear) url.searchParams.set('year', curYear);
    if (curAttempt) url.searchParams.set('attempt', curAttempt);
    else url.searchParams.delete('attempt');
    if (curTab) url.searchParams.set('tab', curTab);
    window.history.replaceState({}, '', url.toString());

    // ซิงค์ลง Session ฝั่งเซิร์ฟเวอร์
    $.post("<?= site_url('Admin/Academic/ConAdminRegisRepeat/setRepeatSessionYear') ?>", {
        year: curYear,
        attempt: curAttempt,
        tab: curTab,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
    });
}

// Initial dashboard stats load and set badges with active year
var initialYear = $('#CheckYearRegisRepeat').val();
updateRepeatDashboardStats(initialYear);

// โหลดตารางของแท็บที่กำลัง Active อยู่จริง
var currentInitialTab = $('.repeat-step-pills .nav-link.active').data('bs-target') || '#tab-pending';
if (currentInitialTab === '#tab-pending') {
    TB_RegisRepeatPending(initialYear);
} else if (currentInitialTab === '#tab-students') {
    TB_RegisteredStudentsMain(initialYear);
} else if (currentInitialTab === '#tab-registered') {
    TB_RegisRepeatSubject(initialYear);
} else if (currentInitialTab === '#tab-all-subjects') {
    TB_MainSubjects(initialYear);
}

// Tab Switch Listener: Load table on demand & adjust columns & persist tab
$('button[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
    var target = $(e.target).data('bs-target');
    var year = $('#CheckYearRegisRepeat').val();

    syncRepeatFilterState();

    if (target === '#tab-pending') {
        if (!$.fn.DataTable.isDataTable('#tbRegisRepeatPending')) {
            TB_RegisRepeatPending(year);
        }
    } else if (target === '#tab-students') {
        if (!$.fn.DataTable.isDataTable('#tb_RegisteredStudentsMain')) {
            TB_RegisteredStudentsMain(year);
        }
    } else if (target === '#tab-registered') {
        if (!$.fn.DataTable.isDataTable('#tbRegisRepeatSubject')) {
            TB_RegisRepeatSubject(year);
        }
    } else if (target === '#tab-all-subjects') {
        if (!$.fn.DataTable.isDataTable('#tbMainSubjects')) {
            TB_MainSubjects(year);
        }
    }

    setTimeout(function() {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    }, 150);
});

// Year change handler
$(document).on('change', '#CheckYearRegisRepeat', function() {
    var selectedYear = $(this).val();
    syncRepeatFilterState();
    
    // Destroy all tables to force reload with new year
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatPending')) $('#tbRegisRepeatPending').DataTable().destroy();
    if ($.fn.DataTable.isDataTable('#tb_RegisteredStudentsMain')) $('#tb_RegisteredStudentsMain').DataTable().destroy();
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatSubject')) $('#tbRegisRepeatSubject').DataTable().destroy();
    if ($.fn.DataTable.isDataTable('#tbMainSubjects')) $('#tbMainSubjects').DataTable().destroy();

    // Reload active tab
    var activeTab = $('.repeat-step-pills .nav-link.active').data('bs-target');
    if (activeTab === '#tab-pending') TB_RegisRepeatPending(selectedYear);
    else if (activeTab === '#tab-students') TB_RegisteredStudentsMain(selectedYear);
    else if (activeTab === '#tab-registered') TB_RegisRepeatSubject(selectedYear);
    else if (activeTab === '#tab-all-subjects') TB_MainSubjects(selectedYear);
    
    updateRepeatDashboardStats(selectedYear);
});

// Repeat Attempt filter handler
$(document).on('change', '#FilterAttempt', function() {
    var year = $('#CheckYearRegisRepeat').val();
    syncRepeatFilterState();
    
    if ($.fn.DataTable.isDataTable('#tb_RegisteredStudentsMain')) {
        TB_RegisteredStudentsMain(year);
    }
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatSubject')) {
        TB_RegisRepeatSubject(year);
    }
    updateRepeatDashboardStats(year);
});

// จดจำสถานะเมื่อคลิกลิงก์เข้าสู่หน้า Detail ใด ๆ
$(document).on('click', 'a[href*="/Admin/Acade/Registration/Repeat/Detail/"]', function() {
    syncRepeatFilterState();
});

// Function to update dashboard statistics and step badges
function updateRepeatDashboardStats(year) {
    var attempt = $('#FilterAttempt').val();
    $.ajax({
        url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getDashboardStats') ?>",
        type: "POST",
        data: { 
            year: year,
            attempt: attempt
        },
        dataType: "json",
        beforeSend: function() {
            $('.stat-value').html('<i class="bx bx-loader-alt bx-spin"></i>');
        },
        success: function(response) {
            if (response.status === 'success') {
                var data = response.data;
                animateValue('#stat-repeat-subjects', data.total_subjects_repeat);
                animateValue('#stat-repeat-students', data.total_repeat_students);
                animateValue('#stat-repeat-teachers', data.total_repeat_teachers);
                $('#stat-repeat-registrations').text(numberFormat(data.total_repeat_registrations) + ' รายการ');
                $('#stat-repeat-year').html('<i class="bx bx-calendar me-1"></i>ในปีการศึกษา ' + data.year);
                $('#stat-selected-year').text(data.year);
                $('#header-selected-year-badge').html('<i class="bx bx-calendar me-1 text-success"></i>ปีการศึกษา ' + data.year);
                
                // Update Step Pills Badges
                $('#pending-count-pill').text(numberFormat(data.count_pending));
                $('#pending-count-badge').text('รอลงทะเบียน ' + numberFormat(data.count_pending) + ' วิชา');
                
                $('#students-count-pill').text(numberFormat(data.total_repeat_students));
                
                $('#registered-count-pill').text(numberFormat(data.count_registered));
                $('#registered-count-badge').text('ลงทะเบียนแล้ว ' + numberFormat(data.count_registered) + ' วิชา');
                
                $('#all-subjects-count-pill').text(numberFormat(data.count_main));
                $('#main-subjects-count-badge').text(numberFormat(data.count_main) + ' วิชา');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dashboard stats:', error);
        }
    });
}

function numberFormat(num) {
    return (num || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function animateValue(selector, value) {
    $(selector).fadeOut(100, function() {
        $(this).text(numberFormat(value)).fadeIn(100);
    });
}

function repeatDetailUrl(row) {
    const subjectYear = String(row.SubjectYear || '').split('/');
    const term = subjectYear[0] || '';
    const year = subjectYear[1] || '';
    const subjectId = encodeURIComponent(row.SubjectID || '');
    const teacherId = encodeURIComponent(row.TeacherID || '');

    if (!term || !year || !subjectId || !teacherId) {
        return '#';
    }

    return <?= json_encode(site_url('Admin/Acade/Registration/Repeat/Detail/')) ?> +
        encodeURIComponent(term) + '/' +
        encodeURIComponent(year) + '/' +
        subjectId + '/' +
        teacherId;
}

// ===============================================================
// TABLE 1: Pending Registration (Step 1)
// ===============================================================
function TB_RegisRepeatPending(Year) {
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatPending')) {
        $('#tbRegisRepeatPending').DataTable().destroy();
    }
    
    tbRegisRepeatPending = $('#tbRegisRepeatPending').DataTable({
        destroy: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        searchDelay: 400,
        order: [[7, "desc"]],
        processing: true,
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowPending') ?>",
            type: "POST",
            data: { "keyYear": Year },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        language: {
            processing: '<div class="py-3"><div class="spinner-border text-warning"></div><span class="ms-2">กำลังโหลดรายการรอ...</span></div>',
            lengthMenu: "แสดง _MENU_ รายการ",
            search: '<i class="bx bx-search me-1"></i>ค้นหา:',
            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ วิชา",
            infoEmpty: "ไม่พบรายการ",
            zeroRecords: '<div class="text-center py-4"><i class="bx bx-check-circle bx-lg text-success"></i><p class="text-success mt-2 mb-0 fw-semibold">ไม่มีรายการค้างรอลงทะเบียนเรียนซ้ำในรอบนี้</p></div>',
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        columns: [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<strong class="text-dark">' + data + '</strong>';
                }
            },
            { data: 'SubjectName' },
            { data: 'FirstGroup' },
            { 
                data: 'SubjectClass',
                render: function(data) {
                    return '<span class="class-badge">' + data + '</span>';
                }
            },
            {
                data: 'TeacherName',
                render: function(data) {
                    return '<div class="d-flex align-items-center"><i class="bx bx-user me-1 text-muted"></i>' + data + '</div>';
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    var detailUrl = repeatDetailUrl(row);
                    return detailUrl === '#' ? '<span class="text-muted">ข้อมูลไม่ครบ</span>' : '<a class="btn btn-sm btn-success fw-bold text-nowrap px-3" style="background-color: #15a362; border-color: #15a362;" href="' + detailUrl + '"><i class="bx bx-user-plus me-1"></i>มอบหมาย</a>';
                }
            },
            {
                data: 'SumPending',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge bg-label-danger fs-7 fw-bold"><i class="bx bx-user-x me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// ===============================================================
// GLOBAL INSTANT STUDENT SEARCH (ค้นหาตามชื่อเพื่อลงทะเบียนเรียนซ้ำทันที ⭐)
// ===============================================================
let globalSearchTimer = null;

function performGlobalStudentSearch(keyword) {
    keyword = (keyword || '').trim();
    var $results = $('#globalStudentSearchResults');
    var $clearBtn = $('#btnClearGlobalStudentSearch');

    if (keyword.length === 0) {
        $clearBtn.addClass('d-none');
        $results.addClass('d-none').empty();
        return;
    }

    $clearBtn.removeClass('d-none');

    if (keyword.length < 2) {
        $results.removeClass('d-none').html(
            '<div class="text-center py-2 text-muted small"><i class="bx bx-info-circle me-1"></i>กรุณาพิมพ์อย่างน้อย 2 ตัวอักษรเพื่อค้นหา</div>'
        );
        return;
    }

    $results.removeClass('d-none').html(
        '<div class="text-center py-3">' +
        '<div class="spinner-border spinner-border-sm text-success" role="status"></div>' +
        '<span class="ms-2 text-muted small">กำลังค้นหาประวัตินักเรียนที่มีผลการเรียน 0, ร, มส ทุกปีการศึกษา...</span>' +
        '</div>'
    );

    $.post("<?= site_url('Admin/Academic/ConAdminRegisRepeat/searchStudentsForRepeat') ?>", {
        keyword: keyword,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
    }, function(res) {
        if (res.status === 'success' && res.data) {
            renderGlobalSearchResults(res.data, keyword);
        } else {
            $results.html('<div class="text-center py-3 text-danger small"><i class="bx bx-error-circle me-1"></i>ไม่สามารถค้นหาข้อมูลได้</div>');
        }
    }, 'json').fail(function() {
        $results.html('<div class="text-center py-3 text-danger small"><i class="bx bx-wifi-off me-1"></i>เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</div>');
    });
}

function renderGlobalSearchResults(students, keyword) {
    var $results = $('#globalStudentSearchResults');
    if (!students || students.length === 0) {
        $results.html(
            '<div class="text-center py-3 text-muted">' +
            '<i class="bx bx-info-circle fs-4 text-warning d-block mb-1"></i>' +
            '<div class="fw-semibold">ไม่พบนักเรียนที่มีผลการเรียน 0, ร, มส ค้างในระบบตามคำค้นหา "' + keyword + '"</div>' +
            '<small class="text-muted">(อาจไม่มีประวัติผลการเรียนไม่ผ่าน หรือแก้ไขเกรดผ่านเรียบร้อยแล้ว)</small>' +
            '</div>'
        );
        return;
    }

    var html = '<div class="d-flex justify-content-between align-items-center mb-2 px-1 pb-1 border-bottom">' +
               '<span class="small fw-bold text-dark"><i class="bx bx-check-circle me-1 text-success"></i>พบผู้มีสิทธิ์เรียนซ้ำ <strong>' + students.length + '</strong> คน:</span>' +
               '<button type="button" class="btn btn-link btn-sm p-0 text-muted" id="btnCloseGlobalSearchResults" title="ปิดหน้าต่าง"><i class="bx bx-x fs-5"></i></button>' +
               '</div>' +
               '<div class="list-group list-group-flush gap-2">';

    students.forEach(function(s) {
        var prefix = s.StudentPrefix || '';
        var fname = s.StudentFirstName || '';
        var lname = s.StudentLastName || '';
        var fullName = prefix + fname + ' ' + lname;
        var totalFail = parseInt(s.TotalFailingCount) || 0;
        var assigned = parseInt(s.AssignedCount) || 0;
        var pending = parseInt(s.PendingCount) || 0;
        var failingYears = s.FailingYears || '';

        var statusBadge = '';
        if (pending === 0 && assigned > 0) {
            statusBadge = '<span class="badge bg-label-success text-nowrap"><i class="bx bx-check-double me-1"></i>มอบหมายครบแล้ว</span>';
        } else if (assigned > 0) {
            statusBadge = '<span class="badge bg-label-warning text-dark text-nowrap"><i class="bx bx-time me-1"></i>มอบหมาย ' + assigned + ' (รอ ' + pending + ')</span>';
        } else {
            statusBadge = '<span class="badge bg-label-danger text-nowrap"><i class="bx bx-error-circle me-1"></i>ยังไม่มอบหมาย (' + pending + ' วิชา)</span>';
        }

        html += '<div class="list-group-item list-group-item-action border rounded-3 p-2 p-md-3 d-flex align-items-center justify-content-between flex-wrap gap-2 shadow-xs" style="background: #fafdfa;">' +
                '<div class="d-flex align-items-center gap-2">' +
                '<span class="badge bg-success bg-opacity-10 text-success p-2 rounded-circle fs-5"><i class="bx bx-user"></i></span>' +
                '<div>' +
                '<div class="fw-bold text-dark text-nowrap">' + fullName + ' ' +
                '<span class="badge bg-label-primary ms-1 text-nowrap">' + (s.StudentClass || '-') + '</span> ' +
                '<span class="badge bg-label-dark text-nowrap">เลขที่ ' + (s.StudentNumber || '-') + '</span>' +
                '</div>' +
                '<div class="small text-muted text-nowrap mt-1">' +
                'รหัสประจำตัว: <strong class="text-primary">' + (s.StudentCode || '-') + '</strong> &bull; ' +
                '<span class="text-danger fw-semibold"><i class="bx bx-book-bookmark me-1"></i>ติด 0, ร, มส รวม <strong>' + totalFail + '</strong> วิชา</span>' +
                (failingYears ? ' &bull; <span class="text-secondary">ปีที่ติด: ' + failingYears + '</span>' : '') +
                '</div>' +
                '<div class="mt-1">' + statusBadge + '</div>' +
                '</div>' +
                '</div>' +
                '<div>' +
                '<button type="button" class="btn btn-sm btn-success fw-bold text-nowrap btn-assign-student shadow-xs px-3" data-studentid="' + s.StudentID + '" style="background-color: #15a362; border-color: #15a362;">' +
                '<i class="bx bx-user-plus me-1"></i>ลงทะเบียนเรียนซ้ำทันที' +
                '</button>' +
                '</div>' +
                '</div>';
    });

    html += '</div>';
    $results.html(html);
}

// Live typing with debounce
$(document).on('keyup', '#globalStudentSearchInput', function(e) {
    if (e.key === 'Escape') {
        $('#globalStudentSearchResults').addClass('d-none');
        return;
    }
    clearTimeout(globalSearchTimer);
    var kw = $(this).val();
    globalSearchTimer = setTimeout(function() {
        performGlobalStudentSearch(kw);
    }, 280);
});

// Click search button
$(document).on('click', '#btnRunGlobalStudentSearch', function() {
    performGlobalStudentSearch($('#globalStudentSearchInput').val());
});

// Enter key in search box
$(document).on('keydown', '#globalStudentSearchInput', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        performGlobalStudentSearch($(this).val());
    }
});

// Clear search button
$(document).on('click', '#btnClearGlobalStudentSearch', function() {
    $('#globalStudentSearchInput').val('').focus();
    $('#btnClearGlobalStudentSearch').addClass('d-none');
    $('#globalStudentSearchResults').addClass('d-none').empty();
});

// Close results dropdown button
$(document).on('click', '#btnCloseGlobalSearchResults', function() {
    $('#globalStudentSearchResults').addClass('d-none');
});

// Hide dropdown on outside click
$(document).on('click', function(e) {
    if (!$(e.target).closest('#globalStudentSearchInput, #globalStudentSearchResults, #btnRunGlobalStudentSearch').length) {
        $('#globalStudentSearchResults').addClass('d-none');
    }
});

// Auto-hide search results when modal opens
$(document).on('show.bs.modal', '#StudentAssignModal', function() {
    $('#globalStudentSearchResults').addClass('d-none');
});

// ===============================================================
// TABLE 3: Registered Students Table (Step 3 - รายชื่อนักเรียนที่ลงทะเบียนซ้ำแล้ว)
// ===============================================================
function TB_RegisteredStudentsMain(Year) {
    if ($.fn.DataTable.isDataTable('#tb_RegisteredStudentsMain')) {
        $('#tb_RegisteredStudentsMain').DataTable().destroy();
    }
    
    var attempt = $('#FilterAttempt').val();

    tbRegisteredStudentsMain = $('#tb_RegisteredStudentsMain').DataTable({
        destroy: true,
        processing: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        order: [[1, 'asc'], [2, 'asc']],
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetails') ?>",
            type: "POST",
            data: { year: Year, attempt: attempt },
            dataSrc: function(json) {
                const students = json.data || [];
                populateStudentRoomOptions(students);
                return students;
            }
        },
        language: {
            processing: '<div class="py-3"><div class="spinner-border text-success"></div><span class="ms-2">กำลังโหลดรายชื่อนักเรียน...</span></div>',
            lengthMenu: "แสดง _MENU_ คน",
            search: '<i class="bx bx-search me-1"></i>ค้นหาในตาราง:',
            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ คน",
            infoEmpty: "ไม่พบรายชื่อนักเรียน",
            zeroRecords: '<div class="text-center py-4"><i class="bx bx-user-x bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบนักเรียนที่ลงทะเบียนเรียนซ้ำตามเงื่อนไขนี้</p></div>',
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        columns: [
            { 
                data: null, 
                className: 'text-center text-muted small text-nowrap',
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { 
                data: 'StudentClass',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-primary fw-bold px-2 py-1 text-nowrap">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'StudentNumber', 
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="fw-semibold text-secondary">' + (data || '-') + '</span>';
                }
            },
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
                    var prefix = row.StudentPrefix || '';
                    var fname = row.StudentFirstName || '';
                    var lname = row.StudentLastName || '';
                    return '<div class="d-inline-flex align-items-center text-nowrap"><i class="bx bx-user-circle me-1 text-success fs-5"></i><span class="fw-bold text-dark text-nowrap">' + prefix + fname + '&nbsp;' + lname + '</span></div>';
                }
            },
            { 
                data: 'Grade_Type',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return data ? '<span class="badge bg-label-warning text-nowrap px-2 py-1"><i class="bx bx-revision me-1"></i>' + data + '</span>' : '<span class="text-muted">-</span>';
                }
            },
            { 
                data: 'SubjectCount',
                className: 'text-center text-nowrap',
                render: function(data) {
                    var cnt = parseInt(data) || 0;
                    var badgeClass = cnt > 1 ? 'bg-danger' : 'bg-primary';
                    return '<span class="badge ' + badgeClass + ' text-white fw-bold px-2 py-1 text-nowrap shadow-xs"><i class="bx bx-book-open me-1"></i>' + cnt + ' วิชา</span>';
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    if (row.SubjectDetails) {
                        var items = row.SubjectDetails.split('||');
                        var html = '<div class="d-flex flex-wrap gap-1">';
                        items.forEach(function(item) {
                            var parts = item.split('::');
                            var subCode = parts[0] || '';
                            var subName = parts[1] || '';
                            var teacherName = parts[2] ? parts[2].trim() : '';
                            html += '<span class="sub-pill-chip" title="' + subName + '">';
                            html += '<b class="text-success me-1">' + subCode + '</b> <span class="text-dark">' + subName + '</span>';
                            if (teacherName && teacherName !== '-') {
                                html += ' <span class="badge bg-label-info ms-1 text-nowrap"><i class="bx bx-user me-1"></i>' + teacherName + '</span>';
                            }
                            html += '</span>';
                        });
                        html += '</div>';
                        return html;
                    } else if (row.RepeatedSubjects) {
                        return '<span class="sub-pill-chip text-dark">' + row.RepeatedSubjects + '</span>';
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
            {
                data: null,
                className: 'text-center text-nowrap',
                render: function(data, type, row) {
                    return '<button type="button" class="btn btn-sm btn-outline-success fw-bold text-nowrap btn-view-student-detail shadow-xs" data-student-code="' + row.StudentCode + '" title="ดูประวัติการเรียนซ้ำของนักเรียนคนนี้"><i class="bx bx-history me-1"></i>ดูประวัติ</button>';
                }
            }
        ]
    });
}

// Populate room dropdown dynamically based on loaded data
function populateStudentRoomOptions(students) {
    var $select = $('#studentRoomSelect');
    var currentVal = $select.val();
    $select.empty().append('<option value="">ทุกห้องเรียน</option>');
    
    var uniqueRooms = {};
    students.forEach(function(s) {
        if (s.StudentClass) {
            uniqueRooms[s.StudentClass] = true;
        }
    });

    var sortedRooms = Object.keys(uniqueRooms).sort();
    sortedRooms.forEach(function(r) {
        $select.append('<option value="' + r + '">' + r + '</option>');
    });

    if (currentVal && uniqueRooms[currentVal]) {
        $select.val(currentVal);
    }
    if ($.fn.select2) {
        $select.trigger('change.select2');
    }
}

// Quick filter: Grade level pills (ม.1 - ม.6)
$(document).on('click', '.grade-filter-btn', function() {
    $('.grade-filter-btn').removeClass('active');
    $(this).addClass('active');

    var grade = $(this).data('grade');
    if (!tbRegisteredStudentsMain) return;

    if (grade === 'all') {
        tbRegisteredStudentsMain.column(1).search('').draw();
    } else {
        // Search class column matching e.g. "ม.1"
        tbRegisteredStudentsMain.column(1).search('^' + grade, true, false).draw();
    }
});

// Quick filter: Room select
$(document).on('change', '#studentRoomSelect', function() {
    var room = $(this).val();
    if (!tbRegisteredStudentsMain) return;

    if (room === '') {
        // If grade pill is active, keep grade filter
        var activeGrade = $('.grade-filter-btn.active').data('grade');
        if (activeGrade && activeGrade !== 'all') {
            tbRegisteredStudentsMain.column(1).search('^' + activeGrade, true, false).draw();
        } else {
            tbRegisteredStudentsMain.column(1).search('').draw();
        }
    } else {
        tbRegisteredStudentsMain.column(1).search('^' + room + '$', true, false).draw();
    }
});

// Quick filter: Search box
$(document).on('keyup', '#studentQuickSearch', function() {
    if (tbRegisteredStudentsMain) {
        tbRegisteredStudentsMain.search($(this).val()).draw();
    }
});

// Detail button: Show student repeat history modal
$(document).on('click', '.btn-view-student-detail', function() {
    var studentCode = $(this).data('student-code');
    var year = $('#CheckYearRegisRepeat').val();
    
    $('#StudentHistoryModal').modal('show');
    $('#student-history-content').html('<div class="text-center py-4"><div class="spinner-border text-success"></div><div class="mt-2 text-muted">กำลังดึงข้อมูล...</div></div>');
    
    $.post("<?= site_url('Admin/Academic/ConAdminRegisRepeat/getStudentRepeatRegistrations') ?>", {
        student_code: studentCode,
        year: year
    }, function(res) {
        if (res.status === 'success' && res.student) {
            var stu = res.student;
            var fullName = (stu.StudentPrefix || '') + (stu.StudentFirstName || '') + ' ' + (stu.StudentLastName || '');
            
            var html = '<div class="card bg-light border-0 mb-3 p-3">' +
                       '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">' +
                       '<div>' +
                       '<h5 class="fw-bold text-dark mb-1 text-nowrap"><i class="bx bx-user-circle me-2 text-success fs-4"></i><span class="text-nowrap">' + fullName + '</span></h5>' +
                       '<div class="text-muted small text-nowrap">รหัสประจำตัว: <strong class="text-primary">' + (stu.StudentCode || '-') + '</strong> &bull; ห้อง: <strong class="text-dark">' + (stu.StudentClass || '-') + '</strong> &bull; เลขที่: <strong>' + (stu.StudentNumber || '-') + '</strong></div>' +
                       '</div>' +
                       '<div><span class="badge bg-success px-3 py-2 rounded-pill text-nowrap"><i class="bx bx-calendar me-1"></i>ปีการศึกษา ' + year + '</span></div>' +
                       '</div></div>';

            html += '<h6 class="fw-bold text-dark mb-2"><i class="bx bx-list-check me-1 text-success"></i>รายวิชาที่ลงทะเบียนเรียนซ้ำในรอบนี้:</h6>';
            html += '<div class="table-responsive"><table class="table table-bordered table-hover mb-0"><thead class="table-light text-center">' +
                    '<tr><th>รหัสวิชา</th><th>ชื่อวิชา</th><th>ภาค/ปีเดิม</th><th>เกรดเดิม</th><th>ครูผู้ดูแลเรียนซ้ำ</th><th>ครั้งที่</th><th>สถานะ</th></tr></thead><tbody>';

            if (res.data && res.data.length > 0) {
                res.data.forEach(function(item) {
                    var statusBadge = item.RepeatStatus === 'ผ่าน' ? '<span class="badge bg-label-success">ผ่านแล้ว</span>' : '<span class="badge bg-label-warning">กำลังเรียนซ้ำ</span>';
                    html += '<tr>' +
                            '<td class="text-center fw-bold text-success">' + (item.SubjectCode || '-') + '</td>' +
                            '<td>' + (item.SubjectName || '-') + '</td>' +
                            '<td class="text-center">' + (item.RegisterYear || '-') + '</td>' +
                            '<td class="text-center"><span class="badge bg-danger">' + (item.Grade || '-') + '</span></td>' +
                            '<td>' + (item.RepeatTeacherName || '-') + '</td>' +
                            '<td class="text-center"><span class="badge bg-label-warning">' + (item.Grade_Type || '-') + '</span></td>' +
                            '<td class="text-center">' + statusBadge + '</td>' +
                            '</tr>';
                });
            } else {
                html += '<tr><td colspan="7" class="text-center py-3 text-muted">ไม่พบรายการวิชา</td></tr>';
            }

            html += '</tbody></table></div>';
            $('#student-history-content').html(html);
        } else {
            $('#student-history-content').html('<div class="alert alert-danger mb-0">ไม่พบข้อมูลนักเรียน</div>');
        }
    }, 'json').fail(function() {
        $('#student-history-content').html('<div class="alert alert-danger mb-0">เกิดข้อผิดพลาดในการโหลดข้อมูล</div>');
    });
});

// ===============================================================
// TABLE 3: Registered Subjects Table (Step 3)
// ===============================================================
function TB_RegisRepeatSubject(Year) {
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatSubject')) {
        $('#tbRegisRepeatSubject').DataTable().destroy();
    }
    
    tbRegisRepeatSubject = $('#tbRegisRepeatSubject').DataTable({
        destroy: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        searchDelay: 400,
        order: [[7, "desc"]],
        processing: true,
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>",
            type: "POST",
            data: function(d) {
                d.keyYear = Year;
                d.keyAttempt = $('#FilterAttempt').val();
            },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        language: {
            processing: '<div class="py-3"><div class="spinner-border text-success"></div><span class="ms-2">กำลังโหลดรายการที่ลงแล้ว...</span></div>',
            lengthMenu: "แสดง _MENU_ รายการ",
            search: '<i class="bx bx-search me-1"></i>ค้นหา:',
            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ วิชา",
            infoEmpty: "ไม่พบรายการ",
            zeroRecords: '<div class="text-center py-4"><i class="bx bx-folder-open bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบวิชาที่มีการลงทะเบียนเรียนซ้ำ</p></div>',
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        columns: [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<strong class="text-dark">' + data + '</strong>';
                }
            },
            { data: 'SubjectName' },
            { data: 'FirstGroup' },
            { 
                data: 'SubjectClass',
                render: function(data) {
                    return '<span class="class-badge">' + data + '</span>';
                }
            },
            {
                data: 'TeacherName',
                render: function(data, type, row) {
                    var html = '<div class="d-flex align-items-center"><div class="rounded-circle bg-success bg-opacity-10 p-2 me-2"><i class="bx bx-user text-success"></i></div>';
                    html += '<div><span>' + data + '</span>';
                    if (row.MainTeacherName && row.TeacherName && row.MainTeacherName.trim() === row.TeacherName.trim()) {
                        html += '<br><small class="text-success"><i class="bx bx-badge-check me-1"></i>ครูประจำวิชา</small>';
                    } else if (row.MainTeacherName && row.MainTeacherName.trim() !== '') {
                        html += '<br><small class="text-muted"><i class="bx bx-user-pin me-1"></i>ครูเดิม: ' + row.MainTeacherName + '</small>';
                    }
                    html += '</div></div>';
                    return html;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    var html = '<span class="badge bg-label-info">' + (row.Grade_Type || '-') + '</span>';
                    if (row.RepeatYear) {
                        html += '<br><small class="text-muted" style="font-size: 0.7rem;">ปี ' + row.RepeatYear + '</small>';
                    }
                    return html;
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    var detailUrl = repeatDetailUrl(row);
                    return detailUrl === '#' ? '<span class="text-muted">ข้อมูลไม่ครบ</span>' : '<a class="btn btn-sm btn-outline-warning fw-semibold text-nowrap" href="' + detailUrl + '"><i class="bx bx-edit-alt me-1"></i>แก้ไข</a>';
                }
            },
            {
                data: 'SumRepeat',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="repeat-count-badge ShowRegisRepeat" style="cursor:pointer" sub-id="' + row.SubjectID + '" teach-id="' + row.TeacherID + '" title="คลิกดูรายชื่อนักเรียนในวิชานี้"><i class="bx bx-user me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// ===============================================================
// TABLE 4: All Main Subjects Table (Auxiliary Tab)
// ===============================================================
function TB_MainSubjects(Year) {
    if ($.fn.DataTable.isDataTable('#tbMainSubjects')) {
        $('#tbMainSubjects').DataTable().destroy();
    }
    
    tbMainSubjects = $('#tbMainSubjects').DataTable({
        destroy: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        searchDelay: 500,
        order: [[8, "desc"]],
        processing: true,
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowMainSubjects') ?>",
            type: "POST",
            data: { "keyYear": Year },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        language: {
            processing: '<div class="py-3"><div class="spinner-border" style="color: #6610f2;"></div><span class="ms-2">กำลังโหลด...</span></div>',
            lengthMenu: "แสดง _MENU_ รายการ",
            search: '<i class="bx bx-search me-1"></i>ค้นหา:',
            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            infoEmpty: "ไม่พบรายการ",
            zeroRecords: '<div class="text-center py-4"><i class="bx bx-folder-open bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบวิชาที่มีการลงทะเบียนนักเรียนในปีการศึกษานี้</p></div>',
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        columns: [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<strong class="text-dark">' + data + '</strong>';
                }
            },
            { data: 'SubjectName' },
            { 
                data: 'SubjectUnit',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge bg-label-secondary">' + (data || '-') + '</span>';
                }
            },
            { data: 'FirstGroup' },
            { 
                data: 'SubjectClass',
                render: function(data) {
                    return '<span class="class-badge">' + data + '</span>';
                }
            },
            {
                data: 'TeacherName',
                render: function(data) {
                    return '<div class="d-flex align-items-center"><i class="bx bx-user me-1 text-muted"></i>' + data + '</div>';
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    var detailUrl = repeatDetailUrl(row);
                    return detailUrl === '#' ? '<span class="text-muted">ข้อมูลไม่ครบ</span>' : '<a class="btn-register" style="background: linear-gradient(135deg, #6610f2 0%, #9b59b6 100%);" href="' + detailUrl + '"><i class="bx bx-plus-circle"></i>ลงทะเบียนซ้ำ</a>';
                }
            },
            {
                data: 'TotalStudents',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge" style="background: rgba(102, 16, 242, 0.1); color: #6610f2;"><i class="bx bx-group me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// Show Repeat Students Modal for a specific subject
$(document).on("click", ".ShowRegisRepeat", function() {
    var subid = $(this).attr('sub-id');
    var teachid = $(this).attr('teach-id');
    var year = $('#CheckYearRegisRepeat').val();
    var attempt = $('#FilterAttempt').val();
    
    $('#tb_ShowRegisRepeat tbody').html('<tr><td colspan="5" class="text-center py-3"><div class="spinner-border text-success"></div></td></tr>');
    $('#staticBackdrop').modal('show');
    
    $.post("<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentsBySubjectGroup') ?>", {
        subid: subid,
        teachid: teachid,
        year: year,
        attempt: attempt
    }, function(response) {
        if (response.status === 'success') {
            var html = '';
            if (response.data.length > 0) {
                $.each(response.data, function(index, value) {
                    var name = (value.StudentPrefix || '') + (value.StudentFirstName || '') + ' ' + (value.StudentLastName || '');
                    html += '<tr>' +
                            '<td class="text-center text-nowrap"><span class="badge bg-label-primary px-2 py-1 text-nowrap">' + (value.StudentClass || '-') + '</span></td>' +
                            '<td class="text-center text-nowrap">' + (value.StudentNumber || '-') + '</td>' +
                            '<td class="text-center text-nowrap"><strong class="text-dark">' + (value.StudentCode || '-') + '</strong></td>' +
                            '<td class="text-nowrap"><div class="d-inline-flex align-items-center text-nowrap"><i class="bx bx-user-circle me-1 text-success fs-5"></i><span class="fw-bold text-dark text-nowrap">' + name + '</span></div></td>' +
                            '<td class="text-center text-nowrap"><span class="badge bg-label-warning text-nowrap"><i class="bx bx-revision me-1"></i>' + (value.Grade_Type || '-') + '</span></td>' +
                            '</tr>';
                });
            } else {
                html = '<tr><td colspan="5" class="text-center py-3 text-muted">ไม่พบข้อมูลนักเรียน</td></tr>';
            }
            $('#tb_ShowRegisRepeat tbody').html(html);
        }
    }, 'json');
});

// Function to show student details modal from top banner
function showStudentDetailsModal() {
    var year = $('#CheckYearRegisRepeat').val();
    $('#student-modal-year').text(year);
    $('#StudentDetailsModal').modal('show');
    
    if ($.fn.DataTable.isDataTable('#tb_StudentDetails')) {
        $('#tb_StudentDetails').DataTable().destroy();
    }
    
    $('#tb_StudentDetails').DataTable({
        destroy: true,
        processing: true,
        autoWidth: false,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetails') ?>",
            type: "POST",
            data: { year: year }
        },
        columns: [
            { 
                data: 'StudentClass',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-primary fw-bold px-2 py-1 text-nowrap">' + (data || '-') + '</span>';
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
                    var name = (row.StudentPrefix || '') + (row.StudentFirstName || '') + ' ' + (row.StudentLastName || '');
                    var badge = row.Grade_Type ? ' <span class="badge bg-label-warning text-nowrap ms-1" style="font-size: 0.68rem;"><i class="bx bx-revision me-1"></i>' + row.Grade_Type + '</span>' : '';
                    return '<div class="d-inline-flex align-items-center text-nowrap"><i class="bx bx-user-circle me-1 text-success fs-5"></i><span class="fw-bold text-dark text-nowrap">' + name + '</span>' + badge + '</div>';
                }
            },
            { 
                data: 'RepeatYear',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-info text-nowrap">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'Grade_Type',
                className: 'text-center text-nowrap',
                render: function(data) {
                    return '<span class="badge bg-label-warning text-nowrap">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'SubjectCount',
                className: 'text-center text-nowrap',
                render: function(data) {
                    var cnt = parseInt(data) || 0;
                    return '<span class="badge ' + (cnt > 1 ? 'bg-danger' : 'bg-primary') + ' text-white fw-bold px-2 py-1 text-nowrap"><i class="bx bx-book me-1"></i>' + cnt + ' วิชา</span>';
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    if (row.SubjectDetails) {
                        var items = row.SubjectDetails.split('||');
                        var html = '<div class="d-flex flex-wrap gap-1">';
                        items.forEach(function(item) {
                            var parts = item.split('::');
                            var subCode = parts[0] || '';
                            var subName = parts[1] || '';
                            var teacherName = parts[2] ? parts[2].trim() : '';
                            html += '<span class="sub-pill-chip" title="' + subName + '">';
                            html += '<b class="text-success me-1">' + subCode + '</b> <span class="text-dark">' + subName + '</span>';
                            if (teacherName && teacherName !== '-') {
                                html += ' <span class="badge bg-label-info ms-1 text-nowrap"><i class="bx bx-user me-1"></i>' + teacherName + '</span>';
                            }
                            html += '</span>';
                        });
                        html += '</div>';
                        return html;
                    }
                    return row.RepeatedSubjects || '-';
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

// ===============================================================
// STUDENT-CENTRIC ASSIGNMENT LOGIC (โหมดมอบหมายตามตัวนักเรียน ⭐)
// ===============================================================

// Helper: สร้าง Options รายชื่อครูทั้งหมดสำหรับ Dropdown
function buildTeacherOptions(selectedId, suggestedId) {
    var options = '<option value="">-- เลือกครูผู้ดูแลเรียนซ้ำ --</option>';
    if (Array.isArray(allTeachersList)) {
        allTeachersList.forEach(function(t) {
            var isSelected = (selectedId && t.pers_id === selectedId) || (!selectedId && suggestedId && t.pers_id === suggestedId);
            var selectedAttr = isSelected ? 'selected' : '';
            var isOrigTag = (suggestedId && t.pers_id === suggestedId) ? ' ⭐ (ครูผู้สอนเดิม)' : '';
            var tName = (t.pers_prefix || '') + (t.pers_firstname || '') + ' ' + (t.pers_lastname || '');
            options += '<option value="' + t.pers_id + '" ' + selectedAttr + '>' + tName + isOrigTag + '</option>';
        });
    }
    return options;
}

// Event: เปิด Modal มอบหมายวิชาเรียนซ้ำรายบุคคล
$(document).on('click', '.btn-assign-student', function() {
    var studentId = $(this).data('studentid');
    if (!studentId) return;

    $('#StudentAssignModal').modal('show');
    $('#student-assign-modal-body').html(
        '<div class="text-center py-5">' +
        '<div class="spinner-border text-success"></div>' +
        '<div class="mt-2 text-muted fw-semibold">กำลังดึงข้อมูลรายวิชาที่ติด 0, ร, มส ของนักเรียน...</div>' +
        '</div>'
    );
    $('#btn-save-student-assign').prop('disabled', true);

    $.post("<?= site_url('Admin/Academic/ConAdminRegisRepeat/getStudentFailingSubjects') ?>", {
        student_id: studentId
    }, function(res) {
        if (res.status === 'success' && res.student) {
            currentAssignStudentData = res;
            renderStudentAssignModal(res);
            $('#btn-save-student-assign').prop('disabled', false);
        } else {
            $('#student-assign-modal-body').html(
                '<div class="alert alert-danger mb-0"><i class="bx bx-error-circle me-1"></i> ' + (res.message || 'ไม่สามารถดึงข้อมูลได้') + '</div>'
            );
        }
    }, 'json').fail(function() {
        $('#student-assign-modal-body').html(
            '<div class="alert alert-danger mb-0"><i class="bx bx-wifi-off me-1"></i> เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</div>'
        );
    });
});

// Render Modal UI สำหรับมอบหมายวิชาเรียนซ้ำของนักเรียนคนนี้
function renderStudentAssignModal(res) {
    var stu = res.student;
    var subjects = res.subjects || [];
    var activeYear = res.active_repeat_year || '';
    var activeAttempt = res.active_attempt || 'เรียนซ้ำครั้งที่ 1';
    
    var fullName = (stu.StudentPrefix || '') + (stu.StudentFirstName || '') + ' ' + (stu.StudentLastName || '');
    
    var totalCount = subjects.length;
    var assignedCount = 0;
    var pendingCount = 0;

    subjects.forEach(function(sub) {
        if (sub.RepeatTeacher && sub.RepeatYear === activeYear && sub.RepeatStatus === 'ไม่ผ่าน') {
            assignedCount++;
        } else {
            pendingCount++;
        }
    });

    // 1. Header Card ข้อมูลนักเรียน
    var html = '<div class="card border-0 mb-3 shadow-xs" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; border-left: 5px solid #15a362 !important;">' +
               '<div class="card-body p-3">' +
               '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">' +
               '<div>' +
               '<div class="d-flex align-items-center gap-2 mb-1">' +
               '<span class="badge bg-success p-2 rounded-circle"><i class="bx bx-user fs-4 text-white"></i></span>' +
               '<div>' +
               '<h5 class="fw-bold text-dark mb-0 text-nowrap">' + fullName + '</h5>' +
               '<div class="text-muted small text-nowrap">' +
               'รหัสประจำตัว: <strong class="text-primary">' + (stu.StudentCode || '-') + '</strong> &bull; ' +
               'ชั้นเรียน: <span class="badge bg-label-primary fw-bold text-nowrap">' + (stu.StudentClass || '-') + '</span> &bull; ' +
               'เลขที่: <strong>' + (stu.StudentNumber || '-') + '</strong>' +
               '</div>' +
               '</div>' +
               '</div>' +
               '</div>' +
               '<div class="d-flex flex-column align-items-end gap-1">' +
               '<span class="badge bg-success px-3 py-2 rounded-pill text-nowrap shadow-xs" style="background-color: #15a362 !important;">' +
               '<i class="bx bx-calendar-check me-1"></i>รอบเรียนซ้ำปัจจุบัน: ' + (activeYear || '-') + ' (' + activeAttempt + ')' +
               '</span>' +
               '<div class="d-flex gap-1 flex-wrap mt-1">' +
               '<span class="badge bg-danger text-white px-2 py-1 text-nowrap"><i class="bx bx-error-circle me-1"></i>ติดทั้งหมด ' + totalCount + ' วิชา</span>' +
               '<span class="badge bg-label-success px-2 py-1 text-nowrap" id="modal-assigned-badge"><i class="bx bx-check-circle me-1"></i>มอบหมายแล้ว ' + assignedCount + '</span>' +
               '<span class="badge bg-label-warning text-dark px-2 py-1 text-nowrap" id="modal-pending-badge"><i class="bx bx-time me-1"></i>รอมอบหมาย ' + pendingCount + '</span>' +
               '</div>' +
               '</div>' +
               '</div>' +
               '</div>' +
               '</div>';

    // 2. Toolbar ช่วยมอบหมายด่วน (Bulk Actions)
    html += '<div class="card border border-light-subtle bg-light mb-3 shadow-none rounded-3">' +
            '<div class="card-body p-2 px-3">' +
            '<div class="row g-2 align-items-center">' +
            '<div class="col-12 col-md-auto">' +
            '<span class="small fw-bold text-dark text-nowrap"><i class="bx bx-bolt-circle me-1 text-warning"></i>จัดการด่วน:</span>' +
            '</div>' +
            '<div class="col-12 col-md-5 col-lg-4">' +
            '<select id="bulk-repeat-teacher" class="form-select form-select-sm">' +
            buildTeacherOptions('', '') +
            '</select>' +
            '</div>' +
            '<div class="col-12 col-md-auto d-flex gap-2 flex-wrap">' +
            '<button type="button" class="btn btn-sm btn-primary fw-semibold" id="btn-apply-bulk-teacher">' +
            '<i class="bx bx-check-double me-1"></i>ใส่ครูนี้ให้ทุกวิชาที่เลือก' +
            '</button>' +
            '<button type="button" class="btn btn-sm btn-outline-secondary fw-semibold" id="btn-copy-orig-teachers">' +
            '<i class="bx bx-copy me-1"></i>ใช้ครูเดิมของแต่ละวิชา' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

    // 3. Table ตารางรายวิชาที่ติด 0, ร, มส
    html += '<div class="table-responsive rounded-3 border">' +
            '<table class="table table-hover align-middle mb-0" id="table-student-assign-subjects">' +
            '<thead class="table-light">' +
            '<tr class="text-center">' +
            '<th style="width: 45px;"><input type="checkbox" class="form-check-input" id="assignModalSelectAll" checked title="เลือก/ยกเลิกทั้งหมด"></th>' +
            '<th style="width: 50px;" class="text-nowrap">ลำดับ</th>' +
            '<th style="width: 105px;" class="text-nowrap">รหัสวิชา</th>' +
            '<th class="text-start" style="min-width: 170px;">ชื่อวิชา</th>' +
            '<th style="width: 100px;" class="text-nowrap">ภาค/ปีเดิม</th>' +
            '<th style="width: 85px;" class="text-nowrap">เกรดเดิม</th>' +
            '<th class="text-start text-nowrap" style="min-width: 140px;">ครูผู้สอนเดิม</th>' +
            '<th class="text-start text-nowrap" style="min-width: 230px;"><i class="bx bx-user-check me-1 text-success"></i>ครูผู้ดูแลเรียนซ้ำ</th>' +
            '<th style="width: 125px;" class="text-center text-nowrap">สถานะ</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';

    if (subjects.length === 0) {
        html += '<tr><td colspan="9" class="text-center py-4 text-success fw-bold"><i class="bx bx-check-circle fs-4 me-1"></i>นักเรียนคนนี้ไม่มีผลการเรียน 0, ร, มส ค้างในระบบ</td></tr>';
    } else {
        subjects.forEach(function(sub, idx) {
            var isAssigned = (sub.RepeatTeacher && sub.RepeatYear === activeYear && sub.RepeatStatus === 'ไม่ผ่าน');
            var selectedTeacher = isAssigned ? sub.RepeatTeacher : (sub.OriginalTeacherID || '');
            var origTeacherName = (sub.orig_prefix || '') + (sub.orig_fname || '') + ' ' + (sub.orig_lname || '');
            if (!origTeacherName.trim()) origTeacherName = '-';

            var teacherOptions = buildTeacherOptions(sub.RepeatTeacher, sub.OriginalTeacherID);

            var statusBadge = isAssigned
                ? '<span class="badge bg-label-success text-nowrap px-2 py-1"><i class="bx bx-check me-1"></i>มอบหมายแล้ว</span>'
                : '<span class="badge bg-label-danger text-nowrap px-2 py-1"><i class="bx bx-time me-1"></i>รอมอบหมาย</span>';

            html += '<tr class="student-assign-row ' + (isAssigned ? 'table-success bg-opacity-25' : '') + '" ' +
                    'data-subject-id="' + sub.SubjectID + '" ' +
                    'data-register-year="' + sub.RegisterYear + '" ' +
                    'data-previously-assigned="' + (isAssigned ? '1' : '0') + '" ' +
                    'data-orig-teacher-id="' + (sub.OriginalTeacherID || '') + '">' +
                    '<td class="text-center"><input type="checkbox" class="form-check-input row-assign-checkbox" ' + (isAssigned || true ? 'checked' : '') + '></td>' +
                    '<td class="text-center text-muted small">' + (idx + 1) + '</td>' +
                    '<td class="text-center fw-bold text-dark text-nowrap">' + sub.SubjectCode + '</td>' +
                    '<td class="text-start">' +
                    '<div class="fw-semibold text-dark">' + sub.SubjectName + '</div>' +
                    '<small class="text-muted">' + (sub.SubjectUnit ? sub.SubjectUnit + ' หน่วยกิต' : '') + ' &bull; ' + (sub.FirstGroup || '') + '</small>' +
                    '</td>' +
                    '<td class="text-center text-nowrap"><span class="badge bg-label-secondary">' + sub.RegisterYear + '</span></td>' +
                    '<td class="text-center text-nowrap"><span class="badge bg-danger fw-bold px-2 py-1">' + (sub.Grade || '-') + '</span></td>' +
                    '<td class="text-start text-nowrap small text-muted"><i class="bx bx-user me-1"></i>' + origTeacherName + '</td>' +
                    '<td class="text-start" style="min-width: 240px;">' +
                    '<select class="form-select form-select-sm row-repeat-teacher select2" style="width: 100%;">' +
                    teacherOptions +
                    '</select>' +
                    '</td>' +
                    '<td class="text-center text-nowrap row-status-col">' + statusBadge + '</td>' +
                    '</tr>';
        });
    }

    html += '</tbody></table></div>';

    // หมายเหตุคำแนะนำ
    html += '<div class="alert alert-secondary d-flex align-items-center mt-3 mb-0 py-2 small">' +
            '<i class="bx bx-info-circle fs-5 me-2 text-primary"></i>' +
            '<div>' +
            '<strong>คำแนะนำ:</strong> ติ๊กเลือกวิชาที่ต้องการลงทะเบียนเรียนซ้ำ และเลือกครูผู้ดูแลสำหรับแต่ละวิชา ' +
            '(หากยกเลิกการติ๊กเลือกในวิชาที่เคยลงทะเบียนแล้ว ระบบจะทำการยกเลิกการมอบหมายวิชานั้น)' +
            '</div>' +
            '</div>';

    $('#student-assign-modal-body').html(html);

    // Initialize Select2 in Student Assign Modal
    if ($.fn.select2) {
        $('#bulk-repeat-teacher').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#StudentAssignModal'),
            width: '100%',
            placeholder: '-- เลือกครูผู้ดูแลเรียนซ้ำ --'
        });

        $('#StudentAssignModal .row-repeat-teacher').each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#StudentAssignModal'),
                width: '100%',
                placeholder: '-- เลือกครูผู้ดูแล --'
            });
        });
    }
}

// Check/Uncheck All ใน Modal
$(document).on('change', '#assignModalSelectAll', function() {
    var isChecked = $(this).is(':checked');
    $('.row-assign-checkbox').prop('checked', isChecked);
});

// นำครูผู้ดูแลที่เลือกใน Toolbar ไปใส่ทุกแถวที่ติ๊กเลือก
$(document).on('click', '#btn-apply-bulk-teacher', function() {
    var selectedTeacher = $('#bulk-repeat-teacher').val();
    if (!selectedTeacher) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเลือกครู',
            text: 'กรุณาเลือกครูผู้ดูแลจากช่องเลือกก่อนกดใช้งาน',
            customClass: { popup: 'swal2-top-layer' }
        });
        return;
    }

    var count = 0;
    $('.student-assign-row').each(function() {
        if ($(this).find('.row-assign-checkbox').is(':checked')) {
            var $rowTeacher = $(this).find('.row-repeat-teacher');
            $rowTeacher.val(selectedTeacher);
            if ($.fn.select2) {
                $rowTeacher.trigger('change.select2');
            }
            count++;
        }
    });

    if (count > 0) {
        var tName = $('#bulk-repeat-teacher option:selected').text();
        Swal.fire({
            icon: 'success',
            title: 'กำหนดครูเรียบร้อย',
            text: 'นำ ' + tName + ' ไปใส่ให้กับ ' + count + ' วิชาที่เลือกแล้ว',
            timer: 1200,
            showConfirmButton: false,
            customClass: { popup: 'swal2-top-layer' }
        });
    } else {
        Swal.fire({
            icon: 'info',
            title: 'ไม่มีรายการที่เลือก',
            text: 'กรุณาติ๊กถูกที่ช่องเลือกวิชาอย่างน้อย 1 รายการ',
            customClass: { popup: 'swal2-top-layer' }
        });
    }
});

// คัดลอกครูผู้สอนเดิมของแต่ละวิชามาเป็นครูผู้ดูแลเรียนซ้ำ
$(document).on('click', '#btn-copy-orig-teachers', function() {
    var count = 0;
    $('.student-assign-row').each(function() {
        var origId = $(this).data('orig-teacher-id');
        if (origId) {
            var $rowTeacher = $(this).find('.row-repeat-teacher');
            $rowTeacher.val(origId);
            if ($.fn.select2) {
                $rowTeacher.trigger('change.select2');
            }
            count++;
        }
    });

    Swal.fire({
        icon: 'success',
        title: 'คัดลอกครูเดิมเรียบร้อย',
        text: 'ตั้งค่าครูผู้สอนเดิมเป็นครูผู้ดูแล ' + count + ' วิชาเรียบร้อยแล้ว',
        timer: 1200,
        showConfirmButton: false,
        customClass: { popup: 'swal2-top-layer' }
    });
});

// บันทึกการมอบหมายวิชาเรียนซ้ำรายบุคคล
$(document).on('click', '#btn-save-student-assign', function() {
    if (!currentAssignStudentData || !currentAssignStudentData.student) {
        Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่พบข้อมูลนักเรียน' });
        return;
    }

    var studentId = currentAssignStudentData.student.StudentID;
    var assignments = [];
    var validationError = null;

    $('.student-assign-row').each(function() {
        var $row = $(this);
        var subId = $row.data('subject-id');
        var regYear = $row.data('register-year');
        var prevAssigned = $row.data('previously-assigned') == 1;
        var isChecked = $row.find('.row-assign-checkbox').is(':checked');
        var repeatTeacher = $row.find('.row-repeat-teacher').val();

        if (isChecked) {
            if (!repeatTeacher) {
                var subCode = $row.find('td:nth-child(3)').text().trim();
                validationError = 'กรุณาระบุครูผู้ดูแลเรียนซ้ำสำหรับวิชา ' + subCode;
                $row.find('.row-repeat-teacher').focus().addClass('is-invalid');
                return false; // Break each loop
            } else {
                $row.find('.row-repeat-teacher').removeClass('is-invalid');
            }
            assignments.push({
                subject_id: subId,
                register_year: regYear,
                action: 'assign',
                repeat_teacher: repeatTeacher
            });
        } else if (prevAssigned) {
            // Was previously assigned but now unchecked -> Cancel assignment
            assignments.push({
                subject_id: subId,
                register_year: regYear,
                action: 'cancel'
            });
        }
    });

    if (validationError) {
        Swal.fire({
            icon: 'warning',
            title: 'ข้อมูลไม่ครบถ้วน',
            text: validationError,
            customClass: { popup: 'swal2-top-layer' }
        });
        return;
    }

    if (assignments.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'ไม่มีการเปลี่ยนแปลง',
            text: 'ไม่มีรายการวิชาที่เลือกมอบหมายหรือยกเลิก',
            customClass: { popup: 'swal2-top-layer' }
        });
        return;
    }

    Swal.fire({
        title: 'ยืนยันการบันทึกการมอบหมาย?',
        text: 'ต้องการบันทึกการเรียนซ้ำสำหรับนักเรียนคนนี้ (' + assignments.length + ' รายการ) ใช่หรือไม่?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#8592a3',
        confirmButtonText: '<i class="bx bx-check me-1"></i>ยืนยันบันทึก',
        cancelButtonText: 'ยกเลิก',
        customClass: { popup: 'swal2-top-layer' }
    }).then(function(result) {
        if (result.isConfirmed) {
            var $saveBtn = $('#btn-save-student-assign');
            $saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังบันทึก...');

            $.ajax({
                url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/saveRepeatAssignmentByStudent') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    student_id: studentId,
                    assignments: assignments
                },
                success: function(res) {
                    if (res && res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ!',
                            text: res.message || 'บันทึกการมอบหมายวิชาเรียนซ้ำเรียบร้อยแล้ว',
                            timer: 1600,
                            showConfirmButton: false,
                            customClass: { popup: 'swal2-top-layer' }
                        });

                        $('#StudentAssignModal').modal('hide');

                        // Refresh ตารางนักเรียนที่ลงทะเบียนแล้ว
                        if (tbRegisteredStudentsMain) {
                            tbRegisteredStudentsMain.ajax.reload(null, false);
                        }

                        // Refresh ตารางสรุปตามรายวิชา
                        if (tbRegisRepeatSubject) {
                            tbRegisRepeatSubject.ajax.reload(null, false);
                        }

                        // Update Dashboard Stats
                        var currentYear = $('#CheckYearRegisRepeat').val();
                        if (typeof updateRepeatDashboardStats === 'function') {
                            updateRepeatDashboardStats(currentYear);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'บันทึกไม่สำเร็จ',
                            text: (res && res.message) ? res.message : 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                            customClass: { popup: 'swal2-top-layer' }
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: xhr.responseJSON?.message || 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                        customClass: { popup: 'swal2-top-layer' }
                    });
                },
                complete: function() {
                    $saveBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i>บันทึกการมอบหมายวิชาเรียนซ้ำ');
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
