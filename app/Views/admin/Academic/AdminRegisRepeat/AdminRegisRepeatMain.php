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
.welcome-banner h1 { font-size: 1.6rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.welcome-banner p { color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin: 0; }
.welcome-banner .year-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
    color: #fff;
    font-weight: 500;
    margin-top: 0.75rem;
    font-size: 0.85rem;
}
.welcome-banner .year-badge i { margin-right: 0.4rem; }
.welcome-banner .icon-wrapper {
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.12);
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
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}
.stat-icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.4rem;
}
.stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1.2; }
.stat-label { font-size: 0.85rem; color: #6c757d; margin-top: 2px; }

/* ===== Table Card ===== */
.table-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1rem 1.25rem;
}
.table-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.table-card .card-header h5 i { color: var(--primary-green); }

/* ===== DataTable Styling ===== */
#tbRegisRepeatSubject thead th {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #495057;
    padding: 0.9rem 1rem;
    border-bottom: 2px solid #dee2e6;
}
#tbRegisRepeatSubject tbody td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
}
#tbRegisRepeatSubject tbody tr:hover { background: rgba(21, 163, 98, 0.04); }

/* ===== Badges ===== */
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

/* ===== Action Button ===== */
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

/* ===== Modal Styling ===== */
.modal .modal-content { border-radius: 12px; border: none; overflow: hidden; }
#staticBackdrop .modal-header,
#StudentDetailsModal .modal-header {
    background: var(--gradient-green);
    border-bottom: none;
    padding: 1rem 1.25rem;
}
#staticBackdrop .modal-header .modal-title,
#StudentDetailsModal .modal-header .modal-title { color: #fff; font-weight: 600; }
#staticBackdrop .modal-header .btn-close,
#StudentDetailsModal .modal-header .btn-close { filter: brightness(0) invert(1); opacity: 0.8; }

/* ===== DataTables Custom ===== */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.4rem 0.8rem;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
    outline: none;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: var(--gradient-green) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 6px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-refresh me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : 'ลงทะเบียนเรียนซ้ำ' ?></h1>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <div class="year-badge" id="header-selected-year-badge">
                            <i class="bx bx-calendar"></i>ปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
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
                        <div class="year-badge bg-warning bg-opacity-25" style="border: 1px solid rgba(255,255,255,0.3);">
                            <i class="bx bx-revision"></i><?= esc($currentRepeatAttempt) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <a href="<?= site_url('Admin/Acade/Registration/Repeat/Report') ?>" class="btn btn-primary fw-semibold me-2">
                        <i class="bx bx-bar-chart-alt-2 me-1"></i>ดูรายงานสรุป (ซ้ำ)
                    </a>
                    <button class="btn btn-light fw-semibold" onclick="showStudentDetailsModal()">
                        <i class="bx bx-show me-1"></i>ดูรายชื่อนักเรียน (ซ้ำ)
                    </button>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-book-reader"></i>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Repeat Subjects Card -->
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

        <!-- Repeat Students Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-warning h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-repeat-students"><?= isset($total_repeat_students) ? number_format($total_repeat_students) : 0 ?></div>
                            <div class="stat-label">นักเรียนเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-user-x"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-id-card me-1"></i><span id="stat-repeat-registrations"><?= isset($total_repeat_registrations) ? number_format($total_repeat_registrations) : 0 ?> รายการ</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repeat Teachers Card -->
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
                        <small class="text-muted"><i class="bx bx-chalkboard me-1"></i>รับผิดชอบนักเรียน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-success h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษาที่เลือก</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-info-circle me-1"></i>ข้อมูลการเรียนซ้ำ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Settings Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <div class="row align-items-center g-3">
                <!-- Year Filter -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <label for="CheckYearRegisRepeat" class="form-label mb-0 fw-medium text-nowrap">
                        <i class="bx bx-filter-alt me-1"></i>ปีการศึกษา:
                    </label>
                    <select class="form-select form-select-sm" id="CheckYearRegisRepeat" name="CheckYearRegisRepeat" style="width: auto; min-width: 130px;">
                        <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                        <option <?= (isset($selectedYear) && isset($v_GroupYear->SubjectYear) && $selectedYear == $v_GroupYear->SubjectYear) ? "selected" : "" ?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Vertical Divider -->
                <div class="col-auto d-none d-md-block">
                    <div class="vr h-100" style="min-height: 24px;"></div>
                </div>

                <!-- Repeat Attempt Filter -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <label for="FilterAttempt" class="form-label mb-0 fw-medium text-nowrap">
                        <i class="bx bx-revision me-1"></i>ครั้งที่เรียนซ้ำ:
                    </label>
                    <select class="form-select form-select-sm" id="FilterAttempt" style="width: auto; min-width: 180px;">
                        <option value="">ทั้งหมด</option>
                        <option value="เรียนซ้ำครั้งที่ 1">เรียนซ้ำครั้งที่ 1</option>
                        <option value="เรียนซ้ำครั้งที่ 2">เรียนซ้ำครั้งที่ 2</option>
                        <option value="เรียนซ้ำครั้งที่ 3">เรียนซ้ำครั้งที่ 3</option>
                        <option value="เรียนซ้ำครั้งที่ 4">เรียนซ้ำครั้งที่ 4</option>
                    </select>
                </div>
                
                <div class="col text-end">
                    <small class="text-muted"><i class="bx bx-info-circle me-1"></i>เลือกเพื่อกรองข้อมูลการเรียนซ้ำในแต่ละรอบ</small>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">

    <!-- Accordion Section -->
    <div class="accordion" id="accordionRepeatData">
        
        <!-- Main Subjects Item -->
        <div class="accordion-item card shadow-sm mb-3">
            <h2 class="accordion-header" id="headingMainSubjects">
                <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMainSubjects" aria-expanded="false" aria-controls="collapseMainSubjects" style="border-left: 4px solid #6610f2;">
                    <div class="d-flex align-items-center w-100">
                        <i class="bx bx-book-open me-2 fs-4" style="color: #6610f2;"></i>
                        <span class="h5 mb-0 fw-bold">วิชาหลักทั้งหมด</span>
                        <span class="badge ms-2" style="background: rgba(102, 16, 242, 0.1); color: #6610f2;" id="main-subjects-count">0</span>
                        <small class="text-muted ms-auto me-3 d-none d-md-inline font-weight-normal"><i class="bx bx-info-circle me-1"></i>รายการวิชาทั้งหมดที่มีการลงทะเบียนนักเรียนในปีการศึกษานี้</small>
                    </div>
                </button>
            </h2>
            <div id="collapseMainSubjects" class="accordion-collapse collapse" aria-labelledby="headingMainSubjects" data-bs-parent="#accordionRepeatData">
                <div class="accordion-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbMainSubjects">
                            <thead>
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

        <!-- Pending Registration Item -->
        <div class="accordion-item card shadow-sm mb-3">
            <h2 class="accordion-header" id="headingPending">
                <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePending" aria-expanded="false" aria-controls="collapsePending" style="border-left: 4px solid #ffc107;">
                    <div class="d-flex align-items-center w-100">
                        <i class="bx bx-time-five me-2 fs-4 text-warning"></i>
                        <span class="h5 mb-0 fw-bold">รายการรอลงทะเบียนเรียนซ้ำ</span>
                        <span class="badge bg-label-warning ms-2" id="pending-count">0</span>
                        <small class="text-muted ms-auto me-3 d-none d-md-inline font-weight-normal"><i class="bx bx-info-circle me-1"></i>วิชาที่ได้ 0, ร หรือ มส ที่ยังไม่ได้มอบหมายครูดูแล</small>
                    </div>
                </button>
            </h2>
            <div id="collapsePending" class="accordion-collapse collapse" aria-labelledby="headingPending" data-bs-parent="#accordionRepeatData">
                <div class="accordion-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbRegisRepeatPending">
                            <thead>
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

        <!-- Registered Item -->
        <div class="accordion-item card shadow-sm">
            <h2 class="accordion-header" id="headingRegistered">
                <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegistered" aria-expanded="false" aria-controls="collapseRegistered" style="border-left: 4px solid #15a362;">
                    <div class="d-flex align-items-center w-100">
                        <i class="bx bx-check-circle me-2 fs-4 text-success"></i>
                        <span class="h5 mb-0 fw-bold">รายการที่ลงทะเบียนเรียนซ้ำแล้ว</span>
                        <span class="badge bg-label-success ms-2" id="registered-count">0</span>
                        <small class="text-muted ms-auto me-3 d-none d-md-inline font-weight-normal"><i class="bx bx-info-circle me-1"></i>วิชาที่มอบหมายครูดูแลเรียนซ้ำเรียบร้อยแล้ว</small>
                    </div>
                </button>
            </h2>
            <div id="collapseRegistered" class="accordion-collapse collapse" aria-labelledby="headingRegistered" data-bs-parent="#accordionRepeatData">
                <div class="accordion-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 w-100" id="tbRegisRepeatSubject">
                            <thead>
                                <tr>
                                    <th><i class="bx bx-calendar me-1"></i>เรียนปี</th>
                                    <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                                    <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                                    <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                                    <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                                    <th><i class="bx bx-user me-1"></i>ครูดูแลซ้ำ</th>
                                    <th class="text-center"><i class="bx bx-revision me-1"></i>ครั้งที่</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                                    <th class="text-center text-nowrap"><i class="bx bx-refresh me-1"></i>เรียนซ้ำ</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Repeat Students -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ShowSubjectName"><i class="bx bx-book-reader me-2"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="tb_ShowRegisRepeat">
                        <thead class="table-light">
                            <tr>
                                <th>ห้อง</th>
                                <th>เลขที่</th>
                                <th>เลขประจำตัว</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th class="text-center">ครั้งที่</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Student Details Modal -->
<div class="modal fade" id="StudentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-user-circle me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success d-flex align-items-center">
                    <i class="bx bx-info-circle bx-sm me-2"></i>
                    <div>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำในปีการศึกษา <strong id="student-modal-year"></strong></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tb_StudentDetails">
                        <thead class="table-light">
                            <tr>
                                <th>ห้อง</th>
                                <th>เลขที่</th>
                                 <th>เลขประจำตัว</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th class="text-center">ปีที่เรียนซ้ำ</th>
                                <th class="text-center">ครั้งที่</th>
                                <th class="text-center">จำนวนวิชา</th>
                                <th>วิชาที่ลงทะเบียน</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let tbRegisRepeatSubject;
let tbRegisRepeatPending;
let tbMainSubjects;

// Initial dashboard stats load and set badges
updateRepeatDashboardStats($('#CheckYearRegisRepeat').val());

// Year change handler
$(document).on('change', '#CheckYearRegisRepeat', function() {
    var selectedYear = $(this).val();
    $.post("<?= site_url('Admin/SetSelectedYear') ?>", { 
        year: selectedYear,
        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
    });
    
    // Clear initialized flags so they reload when opened
    $('.accordion-collapse').each(function() {
        $(this).data('initialized', false);
    });
    
    // If an accordion is currently open, reload its table
    var openAccordion = $('.accordion-collapse.show');
    if (openAccordion.length > 0) {
        var targetId = openAccordion.attr('id');
        loadTableForAccordion(targetId, selectedYear);
    }
    
    updateRepeatDashboardStats(selectedYear);
});

// Repeat Attempt filter handler
$(document).on('change', '#FilterAttempt', function() {
    var attempt = $(this).val();
    var year = $('#CheckYearRegisRepeat').val();
    
    // Clear initialized flags for Registered table
    $('#collapseRegistered').data('initialized', false);
    
    // If Registered accordion is open, reload it
    if ($('#collapseRegistered').hasClass('show')) {
        TB_RegisRepeatSubject(year);
    }

    updateRepeatDashboardStats(year);
});

// Lazy load tables on accordion expansion
$(document).on('shown.bs.collapse', '.accordion-collapse', function () {
    var targetId = $(this).attr('id');
    var year = $('#CheckYearRegisRepeat').val();
    
    // Only load if not already initialized for this year/filter
    if (!$(this).data('initialized')) {
        loadTableForAccordion(targetId, year);
    }
    
    // Adjust columns for layout
    $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
});

function loadTableForAccordion(targetId, year) {
    if (targetId === 'collapseMainSubjects') {
        TB_MainSubjects(year);
        $('#collapseMainSubjects').data('initialized', true);
    } else if (targetId === 'collapsePending') {
        TB_RegisRepeatPending(year);
        $('#collapsePending').data('initialized', true);
    } else if (targetId === 'collapseRegistered') {
        TB_RegisRepeatSubject(year);
        $('#collapseRegistered').data('initialized', true);
    }
}

// Function to update dashboard statistics
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
                $('#header-selected-year-badge').html('<i class="bx bx-calendar me-1"></i>ปีการศึกษา ' + data.year);
                
                // Update Accordion Badges
                $('#main-subjects-count').text(numberFormat(data.count_main));
                $('#pending-count').text(numberFormat(data.count_pending));
                $('#registered-count').text(numberFormat(data.count_registered));
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dashboard stats:', error);
        }
    });
}

// Function to show student details modal
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
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetails') ?>",
            type: "POST",
            data: { year: year }
        },
        columns: [
            { data: 'StudentClass' },
            { data: 'StudentNumber' },
            { data: 'StudentCode' },
            { 
                data: null,
                render: function(data, type, row) {
                    var name = (row.StudentPrefix || '') + (row.StudentFirstName || '') + ' ' + (row.StudentLastName || '');
                    if (row.Grade_Type) {
                        name += ' <span class="badge bg-label-warning" style="font-size: 0.6rem;"><i class="bx bx-revision me-1"></i>' + row.Grade_Type + '</span>';
                    }
                    return name;
                }
            },
            { 
                data: 'RepeatYear',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="badge bg-label-info">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'Grade_Type',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="badge bg-label-warning">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'SubjectCount',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge bg-label-info">' + (data || '-') + '</span>';
                }
            },
            { 
                data: 'RepeatedSubjects',
                render: function(data) {
                    return data ? '<small class="text-muted">' + data + '</small>' : '-';
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

function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function animateValue(selector, value) {
    $(selector).fadeOut(150, function() {
        $(this).text(numberFormat(value)).fadeIn(150);
    });
}

// Function to load Main Subjects Table (All subjects with registered students)
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
        "order": [[8, "desc"]],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowMainSubjects') ?>",
            "type": "POST",
            data: { "keyYear": Year },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        "language": {
            "processing": '<div class="py-3"><div class="spinner-border" style="color: #6610f2;"></div><span class="ms-2">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": '<div class="text-center py-4"><i class="bx bx-folder-open bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบวิชาที่มีการลงทะเบียนนักเรียนในปีการศึกษานี้</p></div>',
            "paginate": {
                "first": '<i class="bx bx-chevrons-left"></i>',
                "last": '<i class="bx bx-chevrons-right"></i>',
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        },
        'columns': [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<span class="fw-semibold">' + data + '</span>';
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
                render: function(data, type, row) {
                    var html = '<div class="d-flex align-items-center"><div class="rounded-circle p-2 me-2" style="background: rgba(102, 16, 242, 0.1);"><i class="bx bx-user" style="color: #6610f2;"></i></div>';
                    html += '<div><span>' + data + '</span></div></div>';
                    return html;
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<a class="btn-register" style="background: linear-gradient(135deg, #6610f2 0%, #9b59b6 100%);" href="<?= site_url('Admin/Acade/Registration/Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectID ? row.SubjectID : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'"><i class="bx bx-plus-circle"></i>ลงทะเบียนซ้ำ</a>';
                }
            },
            {
                data: 'TotalStudents',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="badge" style="background: rgba(102, 16, 242, 0.1); color: #6610f2;"><i class="bx bx-group me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// Function to load Pending Registration Table (Subjects waiting to be assigned for repeat)
function TB_RegisRepeatPending(Year) {
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatPending')) {
        $('#tbRegisRepeatPending').DataTable().destroy();
    }
    
    tbRegisRepeatPending = $('#tbRegisRepeatPending').DataTable({
        destroy: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        searchDelay: 500,
        "order": [[1, "asc"]],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowPending') ?>",
            "type": "POST",
            data: { "keyYear": Year },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        "language": {
            "processing": '<div class="py-3"><div class="spinner-border text-warning"></div><span class="ms-2">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": '<div class="text-center py-4"><i class="bx bx-check-circle bx-lg text-success"></i><p class="text-muted mt-2 mb-0">ไม่มีวิชาที่รอลงทะเบียนเรียนซ้ำ ทุกวิชาได้รับการมอบหมายแล้ว!</p></div>',
            "paginate": {
                "first": '<i class="bx bx-chevrons-left"></i>',
                "last": '<i class="bx bx-chevrons-right"></i>',
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        },
        'columns': [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<span class="fw-semibold">' + data + '</span>';
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
                    var html = '<div class="d-flex align-items-center"><div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2"><i class="bx bx-user text-warning"></i></div>';
                    html += '<div><span>' + data + '</span>';
                    html += '<br><small class="text-muted"><i class="bx bx-info-circle me-1"></i>ครูหลัก (ยังไม่มีครูดูแลซ้ำ)</small>';
                    html += '</div></div>';
                    return html;
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<a class="btn-register" style="background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%); color: #212529;" href="<?= site_url('Admin/Acade/Registration/Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectID ? row.SubjectID : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'"><i class="bx bx-user-plus"></i>มอบหมาย</a>';
                }
            },
            {
                data: 'SumPending',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="badge bg-label-danger"><i class="bx bx-user-x me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// Function to load Registered Table (Subjects already assigned for repeat)
function TB_RegisRepeatSubject(Year) {
    if ($.fn.DataTable.isDataTable('#tbRegisRepeatSubject')) {
        $('#tbRegisRepeatSubject').DataTable().destroy();
    }
    
    tbRegisRepeatSubject = $('#tbRegisRepeatSubject').DataTable({
        destroy: true,
        autoWidth: false,
        width: '100%',
        deferRender: true,
        orderClasses: false,
        searchDelay: 500,
        "order": [[7, "desc"]],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>",
            "type": "POST",
            data: function(d) {
                d.keyYear = Year;
                d.keyAttempt = $('#FilterAttempt').val();
            },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        "language": {
            "processing": '<div class="py-3"><div class="spinner-border text-success"></div><span class="ms-2">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": '<div class="text-center py-4"><i class="bx bx-folder-open bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบข้อมูลการลงทะเบียนเรียนซ้ำ</p></div>',
            "paginate": {
                "first": '<i class="bx bx-chevrons-left"></i>',
                "last": '<i class="bx bx-chevrons-right"></i>',
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        },
        'columns': [
            { 
                data: 'SubjectYear',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<span class="fw-semibold">' + data + '</span>';
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
                    // ถ้าครูเรียนซ้ำ = ครูหลัก แสดง "ครูหลัก"
                    if (row.MainTeacherName && row.TeacherName && row.MainTeacherName.trim() === row.TeacherName.trim()) {
                        html += '<br><small class="text-success"><i class="bx bx-badge-check me-1"></i>ครูหลัก</small>';
                    } else if (row.MainTeacherName && row.MainTeacherName.trim() !== '') {
                        // ถ้าครูเรียนซ้ำ ≠ ครูหลัก แสดงชื่อครูหลักด้วย
                        html += '<br><small class="text-muted"><i class="bx bx-user-pin me-1"></i>ครูหลัก: ' + row.MainTeacherName + '</small>';
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
                    return '<a class="btn-register" href="<?= site_url('Admin/Acade/Registration/Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectID ? row.SubjectID : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'"><i class="bx bx-edit-alt"></i>แก้ไข</a>';
                }
            },
            {
                data: 'SumRepeat',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="repeat-count-badge ShowRegisRepeat" style="cursor:pointer" sub-id="' + row.SubjectID + '" teach-id="' + row.TeacherID + '"><i class="bx bx-user me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// Show Repeat Students Modal
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
                            '<td>' + (value.StudentClass || '-') + '</td>' +
                            '<td>' + (value.StudentNumber || '-') + '</td>' +
                            '<td>' + (value.StudentCode || '-') + '</td>' +
                            '<td>' + name + '</td>' +
                            '<td class="text-center"><span class="badge bg-label-warning">' + (value.Grade_Type || '-') + '</span></td>' +
                            '</tr>';
                });
            } else {
                html = '<tr><td colspan="5" class="text-center py-3 text-muted">ไม่พบข้อมูล</td></tr>';
            }
            $('#tb_ShowRegisRepeat tbody').html(html);
        }
    }, 'json');
});

// Cancel Repeat Registration
$(document).on("click", ".CancelRegisRepeat", function() {
    var btn = $(this);
    Swal.fire({
        title: 'ต้องการลบการลงทะเบียนหรือไม่?',
        text: 'เมื่อลบการลงทะเบียนวิชานี้แล้ว คะแนนและรายชื่อนักเรียนในวิชานี้ จะถูกลบทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bx bx-trash me-1"></i>ใช่, ลบเลย!',
        cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'กำลังลบข้อมูล...',
                html: '<div class="py-3"><div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatCancel') ?>", {
                KeyTeacher: btn.attr('key-teacher'),
                KeySubject: btn.attr('key-subject')
            }, function(data, status) {
                btn.parents('tr').fadeOut(300, function() {
                    $(this).remove();
                });
                Swal.fire({
                    icon: 'success',
                    title: 'ลบข้อมูลเรียบร้อย!',
                    text: 'ข้อมูลการลงทะเบียนถูกลบแล้ว',
                    confirmButtonColor: '#15a362'
                });
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
