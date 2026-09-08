<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<?php $classroom = $classroom ?? new \App\Libraries\Classroom(); ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Header */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-settings::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stats Card Premium */
    .stat-card-premium {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: all 0.3s;
    }

    .stat-card-premium:hover .stat-icon-box {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Emerald UI Elements */
    .settings-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: white;
    }

    .settings-card-header {
        background-color: white;
        border-bottom: 1px solid #f1f3f5;
        padding: 1.5rem;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        font-size: 1.2rem;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    /* DataTable Overrides */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #eef2f7;
    }

    .badge-emerald {
        background-color: var(--light-emerald);
        color: var(--dark-emerald);
        border: 1px solid rgba(21, 163, 98, 0.2);
    }

    .form-label { font-weight: 600; color: #444; }
    .form-control, .form-select { border-radius: 10px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; }
    .form-control:focus, .form-select:focus { border-color: var(--primary-emerald); box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.1); }

    /* Subject Picker */
    .subject-picker-item {
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .subject-picker-item:hover {
        background-color: var(--light-emerald);
        border-color: rgba(21, 163, 98, 0.1);
    }
    .btn-outline-white {
        border: 2px solid rgba(255, 255, 255, 0.85);
        color: white;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(5px);
        transition: all 0.3s;
    }
    .btn-outline-white:hover {
        background: white;
        color: var(--primary-emerald);
        border-color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .text-emerald {
        color: var(--dark-emerald) !important;
    }
    .text-primary-emerald {
        color: var(--primary-emerald) !important;
    }
    .btn-white {
        background-color: #ffffff !important;
        color: var(--dark-emerald) !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1) !important;
        font-weight: 700 !important;
        transition: all 0.3s ease;
    }
    .btn-white:hover {
        background-color: #f0fdf4 !important;
        color: #065f46 !important;
        border-color: #86efac !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15) !important;
    }

    /* Switch onoff widget */
    .system-status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.3s ease;
    }
    .status-badge-on {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .status-badge-off {
        background: rgba(220, 53, 69, 0.25);
        color: #ffebee;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .form-switch-lg .form-check-input {
        width: 3.2rem;
        height: 1.7rem;
        cursor: pointer;
    }
    .form-switch-lg .form-check-input:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }
    .form-switch-lg .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
    }
</style>

<?php 
    $isSystemOpen = !empty($onoff_register_subject) && ($onoff_register_subject->onoff_status === 'on' || $onoff_register_subject->onoff_status === 'true');
    $statusText = $isSystemOpen ? 'เปิดระบบ' : 'ปิดระบบ';
    $statusBadgeClass = $isSystemOpen ? 'status-badge-on' : 'status-badge-off';
    $systemSettingYear = !empty($onoff_register_subject->onoff_year) ? $onoff_register_subject->onoff_year : $selectedYear;
    $systemSettingParts = explode('/', $systemSettingYear);
    $systemSettingTerm = $systemSettingParts[0] ?? '1';
    $systemSettingYearOnly = $systemSettingParts[1] ?? (date('Y') + 543);
?>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-md-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">งานหลักสูตร</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <h2 class="fw-bold mb-0 text-white">จัดการรายวิชา</h2>
                    <span id="badge-system-status" class="system-status-badge <?= $statusBadgeClass ?>" title="สถานะสิทธิ์สำหรับครูผู้สอน">
                        <i class="bx <?= $isSystemOpen ? 'bx-check-circle' : 'bx-lock-alt' ?>"></i>
                        <span>ระบบครู: <b id="text-system-status"><?= $statusText ?></b></span>
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap text-white opacity-90 small mt-1">
                    <span>ตารางปัจจุบัน: <b id="headerYear"><?= esc($selectedYear) ?></b></span>
                    <span class="text-white-50">|</span>
                    <span>ปีการศึกษาที่ระบบครูใช้: <span id="label-system-year" class="badge bg-white text-dark fw-bold px-2 py-1 rounded-pill"><?= esc($systemSettingYear) ?></span></span>
                </div>
            </div>
            <div class="col-md-7 text-md-end mt-3 mt-md-0 d-flex flex-wrap align-items-center justify-content-md-end gap-2" style="position: relative; z-index: 5;">
                <!-- System On/Off Toggle Card inside Header (สำหรับตั้งค่าสิทธิ์ระบบครู) -->
                <div class="bg-white rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 shadow-sm border">
                    <span class="text-dark small fw-bold"><i class="bx bx-power-off text-emerald me-1"></i>เปิดให้ครูจัดการ:</span>
                    <span id="text-switch-state" class="badge <?= $isSystemOpen ? 'bg-success' : 'bg-danger' ?> rounded-pill px-2 py-1 small"><?= $isSystemOpen ? 'เปิด' : 'ปิด' ?></span>
                    <div class="form-check form-switch form-switch-lg m-0 p-0 d-flex align-items-center">
                        <input class="form-check-input ms-0" type="checkbox" id="toggle-system-onoff" 
                            <?= $isSystemOpen ? 'checked' : '' ?> 
                            data-onoff-id="<?= !empty($onoff_register_subject) ? esc($onoff_register_subject->onoff_id) : '16' ?>"
                            title="สลับสถานะเปิด-ปิดระบบให้ครูจัดการตารางสอน">
                    </div>
                </div>

                <!-- ปุ่มตั้งค่าปีการศึกษาสำหรับระบบครู -->
                <button class="btn btn-outline-white fw-bold shadow-sm px-3 py-2 rounded-pill" 
                    type="button" 
                    id="btn-modal-setting-year"
                    data-bs-toggle="modal" 
                    data-bs-target="#ModalSettingYear">
                    <i class="bx bx-calendar-cog me-1"></i> ตั้งค่าปีการศึกษา
                </button>

                <button class="btn btn-outline-white fw-bold shadow-sm px-3 py-2 rounded-pill" 
                    type="button" 
                    id="btn-modal-compare"
                    data-bs-toggle="modal" 
                    data-bs-target="#ModalCompareYear">
                    <i class="bx bx-git-compare me-1"></i> เปรียบเทียบกับปีก่อนหน้า
                </button>
                <button class="btn btn-white text-emerald fw-bold border-0 shadow-lg px-3 py-2 rounded-pill" 
                    type="button" 
                    id="btn-modal-add"
                    data-bs-toggle="modal" 
                    data-bs-target="#ModalAddSubject">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark" id="stat-total">0</h3>
                        <p class="text-muted mb-0 small">รายวิชาทั้งหมด</p>
                    </div>
                    <div class="stat-icon-box" style="background: var(--light-emerald); color: var(--primary-emerald);">
                        <i class="bx bx-book-content"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-success" id="stat-basic">0</h3>
                        <p class="text-muted mb-0 small">วิชาพื้นฐาน</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="bx bx-book-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-info" id="stat-advanced">0</h3>
                        <p class="text-muted mb-0 small">วิชาเพิ่มเติม</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e1f5fe; color: #0288d1;">
                        <i class="bx bx-bookmark-plus"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #b45309 !important;" id="stat-year"><?= esc($selectedYear) ?></h3>
                        <p class="text-muted mb-0 small">ปีการศึกษาที่ดำเนินการ</p>
                    </div>
                    <div class="stat-icon-box" style="background: #fff8e1; color: #b45309;">
                        <i class="bx bx-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="CheckYearNow" value="<?= isset($selectedYear) ? esc($selectedYear) : '' ?>">

    <!-- Data Table Card -->
    <div class="card settings-card">
        <div class="settings-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper me-3">
                    <i class="bx bx-list-ul"></i>
                </div>
                <h5 class="mb-0 fw-bold">รายการวิชาที่เปิดสอน</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <label class="me-2 fw-bold text-muted small uppercase">เลือกปีการศึกษา:</label>
                    <select class="form-select form-select-sm SelectSubject shadow-sm border-emerald" style="min-width: 160px; border-radius: 12px;">
                        <option value="">ทั้งหมด</option>
                        <?php 
                        $years = array_column($GroupYear, 'SubjectYear');
                        if (!in_array($selectedYear, $years)) {
                            array_unshift($years, $selectedYear);
                        }
                        foreach ($years as $v_Year): ?>
                        <option <?= (isset($selectedYear) && $v_Year == $selectedYear) ? "selected" : ""?>
                            value="<?= esc($v_Year) ?>">
                            <?= esc($v_Year) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover w-100" id="tbSubject">
                    <thead>
                        <tr>
                            <th>ปีการศึกษา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อรายวิชา</th>
                            <th>กลุ่มสาระ</th>
                            <th>ระดับชั้น</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Subject -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalAddSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-subject-bulk">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="icon-wrapper me-3 bg-white text-emerald">
                            <i class="bx bx-plus-circle"></i>
                        </div>
                        <div>
                            <h5 class="modal-title text-white fw-bold mb-0">เพิ่มรายวิชาใหม่ (จากคลังวิชาหลัก)</h5>
                            <small class="text-white opacity-75">ดึงข้อมูลจากฐานข้อมูลคลังรายวิชาแกนกลางของโรงเรียน</small>
                        </div>
                        <a href="<?= base_url('Admin/Acade/Course/MasterSubject') ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-pill ms-auto me-3">
                            <i class="bx bx-cog me-1"></i> จัดการคลังวิชาหลัก
                        </a>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Left Column: Config -->
                        <div class="col-lg-4 border-end">
                            <div class="mb-4">
                                <label class="form-label d-flex align-items-center">
                                    <span class="badge bg-emerald me-2">1</span> ภาคเรียน/ปีการศึกษา
                                </label>
                                <select class="form-select shadow-sm" required name="SubjectYear" id="SubjectYear">
                                    <option value="">เลือกภาคเรียน</option>
                                    <?php $d = date('Y')+541; 
                                    for ($i=$d+2; $i >= $d-1 ; $i--) :
                                        for($j=2; $j>=1; $j--):?>
                                    <option <?= (isset($selectedYear) && $selectedYear == $j.'/'.$i) ? "selected" : ""?>
                                        value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                    <?php endfor; endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-flex align-items-center">
                                    <span class="badge bg-emerald me-2">2</span> ระดับชั้นที่เปิดสอน
                                </label>
                                <select class="form-select shadow-sm" required name="SubjectClass" id="SubjectClass">
                                    <option value="">เลือกระดับชั้น</option>
                                    <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                    <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="toggle-filter-class" checked>
                                    <label class="form-check-label small text-muted" for="toggle-filter-class">กรองแสดงเฉพาะระดับชั้นที่เลือก</label>
                                </div>
                                <div class="card bg-light border-0 p-2 mt-3 rounded-3">
                                    <label class="form-label small fw-bold text-dark mb-1"><i class="bx bx-history me-1 text-primary"></i> เลือกตามปีก่อนหน้า (Auto-Select):</label>
                                    <div class="input-group input-group-sm mb-1">
                                        <select id="quick-history-year" class="form-select">
                                            <option value="">เลือกปีอ้างอิง</option>
                                            <?php 
                                            $allYears = array_column($GroupYear, 'SubjectYear');
                                            foreach ($allYears as $y): 
                                                if ($y != $selectedYear): ?>
                                                <option value="<?= esc($y) ?>"><?= esc($y) ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                        <button type="button" class="btn btn-outline-success" id="btn-auto-select-history" title="ติ๊กถูกวิชาที่เคยเปิดสอนในปีก่อนหน้าให้อัตโนมัติ">
                                            <i class="bx bx-magic-wand"></i> เลือกตามปีนี้
                                        </button>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">ระบบจะค้นหาวิชาที่ระดับชั้นนี้เคยเปิดสอนในปีก่อน แล้วติ๊กเลือกให้อัตโนมัติ</small>
                                </div>
                            </div>
                            <div class="alert alert-soft-emerald small border-0 mt-3">
                                <i class="bx bx-info-circle me-1"></i> 
                                รายวิชาจะถูกดึงมาจาก <strong>ฐานข้อมูลคลังวิชาหลัก (MySQL)</strong> คุณสามารถเลือกติ๊กรายวิชาที่เปิดสอนแล้วกดบันทึกพร้อมกันได้ทันที
                            </div>
                        </div>

                        <!-- Right Column: Subject Picker -->
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                <label class="form-label mb-0 d-flex align-items-center">
                                    <span class="badge bg-emerald me-2">3</span> เลือกรายวิชาจากคลังหลัก
                                </label>
                                <span class="text-muted small" id="checked-count">เลือกแล้ว 0 วิชา</span>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-md-7">
                                    <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                                        <span class="input-group-text bg-white border-0"><i class="bx bx-search text-muted"></i></span>
                                        <input type="text" id="search-central-subject" class="form-control border-0 px-2" placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา...">
                                        <button class="btn btn-outline-secondary border-0 btn-sm px-3" type="button" id="clear-search"><i class="bx bx-x"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <select id="filter-central-group" class="form-select shadow-sm rounded-pill border">
                                        <option value="">ทุกกลุ่มสาระ</option>
                                        <?php foreach ($classroom->GroupSaraMain() as $v_grp): ?>
                                            <option value="<?= esc($v_grp) ?>"><?= esc($v_grp) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="subject-picker-container border rounded-3 p-3" style="max-height: 420px; overflow-y: auto; background: #fcfcfc;">
                                <div class="mb-2 pb-2 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="check-all-subjects">
                                        <label class="form-check-label fw-bold text-dark" for="check-all-subjects">เลือกทั้งหมดที่แสดง</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge badge-emerald" id="source-badge"><i class="bx bx-data me-1"></i> คลังวิชาหลัก</span>
                                        <span class="badge bg-label-secondary" id="total-source-count">ทั้งหมด 0 รายการ</span>
                                    </div>
                                </div>
                                <div id="central-subject-list" class="mt-2">
                                    <div class="text-center py-5 text-muted">
                                        <div class="spinner-border spinner-border-sm me-2 text-success" role="status"></div>
                                        กำลังโหลดข้อมูลจากคลังวิชาหลัก...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-5 shadow-sm rounded-pill fw-bold" id="btn-submit-bulk">
                        <i class="bx bx-save me-1"></i> บันทึกวิชาเรียนที่เลือก
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Compare Year -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalCompareYear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="icon-wrapper me-3 bg-white text-emerald">
                        <i class="bx bx-git-compare fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">เปรียบเทียบและคัดลอกรายวิชาจากปีก่อนหน้า</h5>
                        <small class="text-white opacity-75">เปรียบเทียบรายวิชากับปีก่อนหน้า และคัดลอกเข้าสู่ปีปัจจุบัน (<?= esc($selectedYear) ?>) ได้ทันที</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Control Panel -->
                <div class="card bg-light border-0 mb-4 p-3 rounded-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark small"><i class="bx bx-history me-1 text-primary"></i> ปีการศึกษาอ้างอิง (ปีก่อนหน้า):</label>
                            <select class="form-select shadow-sm" id="compare-source-year">
                                <?php 
                                $allYears = array_column($GroupYear, 'SubjectYear');
                                foreach ($allYears as $y): 
                                    if ($y != $selectedYear): ?>
                                    <option value="<?= esc($y) ?>"><?= esc($y) ?></option>
                                <?php endif; endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark small"><i class="bx bx-target-lock me-1 text-success"></i> ปีการศึกษาเป้าหมาย (ปัจจุบัน):</label>
                            <input type="text" class="form-control shadow-sm fw-bold text-emerald bg-white" id="compare-target-year" value="<?= esc($selectedYear) ?>" readonly>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark small">ระดับชั้น:</label>
                            <select class="form-select shadow-sm" id="compare-class-filter">
                                <option value="">ทุกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark small">กลุ่มสาระ:</label>
                            <select class="form-select shadow-sm" id="compare-group-filter">
                                <option value="">ทุกกลุ่มสาระ</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_grp):?>
                                <option value="<?= esc($v_grp) ?>"><?= esc($v_grp) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Mini Stats Cards -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between shadow-xs">
                            <div>
                                <small class="text-muted d-block">วิชาทั้งหมดในปีก่อนหน้า</small>
                                <h4 class="mb-0 fw-bold text-dark" id="cmp-stat-total">0</h4>
                            </div>
                            <div class="badge bg-label-primary p-2 rounded"><i class="bx bx-book fs-4"></i></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between shadow-xs">
                            <div>
                                <small class="text-muted d-block">มีในเทอมปัจจุบันแล้ว</small>
                                <h4 class="mb-0 fw-bold text-success" id="cmp-stat-registered">0</h4>
                            </div>
                            <div class="badge bg-label-success p-2 rounded"><i class="bx bx-check-circle fs-4"></i></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between shadow-xs">
                            <div>
                                <small class="text-muted d-block">ยังไม่มีในเทอมนี้ (ขาด)</small>
                                <h4 class="mb-0 fw-bold" style="color: #b45309 !important;" id="cmp-stat-missing">0</h4>
                            </div>
                            <div class="badge p-2 rounded" style="background-color: #fef3c7; color: #b45309;"><i class="bx bx-time fs-4"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Table Action Controls -->
                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="toggle-show-only-missing" checked>
                            <label class="form-check-label fw-bold small text-dark" for="toggle-show-only-missing">
                                แสดงเฉพาะวิชาที่ยังไม่มีในเทอมนี้ (<span id="missing-count-label">0</span>)
                            </label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="search-compare-table" class="form-control form-control-sm rounded-pill" placeholder="ค้นหาในตาราง..." style="width: 200px;">
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-select-all-missing">
                            <i class="bx bx-check-double me-1"></i> เลือกวิชาที่ยังไม่มีทั้งหมด
                        </button>
                    </div>
                </div>

                <!-- Comparison Table -->
                <div class="table-responsive border rounded-3" style="max-height: 380px;">
                    <table class="table table-hover table-striped mb-0" id="tbCompare">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 40px;" class="text-center">
                                    <input type="checkbox" class="form-check-input" id="check-all-compare">
                                </th>
                                <th>รหัสวิชา</th>
                                <th>ชื่อรายวิชา</th>
                                <th class="text-center">ระดับชั้น</th>
                                <th>กลุ่มสาระ</th>
                                <th class="text-center">หน่วยกิต / ชม.</th>
                                <th class="text-center">ประเภท</th>
                                <th class="text-center">สถานะในเทอมนี้</th>
                            </tr>
                        </thead>
                        <tbody id="compare-table-body" class="align-middle">
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">กำลังโหลดข้อมูลเปรียบเทียบ...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer px-4 py-3 bg-light border-0 d-flex justify-content-between align-items-center" style="border-radius: 0 0 20px 20px;">
                <div>
                    <span class="fw-bold text-dark" id="compare-checked-count">เลือกแล้ว 0 วิชา</span>
                    <small class="text-muted d-block">วิชาที่เลือกจะถูกบันทึกเข้าสู่ปีการศึกษา <?= esc($selectedYear) ?></small>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-emerald px-4 shadow-sm rounded-pill fw-bold" id="btn-copy-selected-subjects">
                        <i class="bx bx-copy-alt me-1"></i> คัดลอกวิชาที่เลือกเข้าเทอมปัจจุบัน
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalUpdateSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-update-subject">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <h5 class="modal-title text-white fw-bold"><i class="bx bx-edit me-2"></i>แก้ไขข้อมูลรายวิชา</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <input type="hidden" name="Up_SubjectID" id="Up_SubjectID">
                        <div class="col-md-6">
                            <label class="form-label">ภาคเรียน/ปีการศึกษา</label>
                            <select class="form-select" required name="Up_SubjectYear" id="Up_SubjectYear">
                                <?php $d = date('Y')+541; for ($i=$d+2; $i >= $d-1 ; $i--) :?>
                                <option value="1/<?= esc($i);?>">1/<?= esc($i);?></option>
                                <option value="2/<?= esc($i);?>">2/<?= esc($i);?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ระดับชั้น</label>
                            <select class="form-select" required name="Up_SubjectClass" id="Up_SubjectClass">
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">รหัสวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectCode" id="Up_SubjectCode">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ชื่อวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectName" id="Up_SubjectName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">หน่วยกิต / ชั่วโมง</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required name="Up_SubjectUnit" id="Up_SubjectUnit" placeholder="นก.">
                                <input type="text" class="form-control" required name="Up_SubjectHour" id="Up_SubjectHour" placeholder="ชม.">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ประเภทวิชา</label>
                            <select class="form-select" required name="Up_SubjectType" id="Up_SubjectType">
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">สาระหลัก</label>
                            <select class="form-select" required name="Up_FirstGroup" id="Up_FirstGroup">
                                <?php foreach ($classroom->GroupSaraMain() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">สาระย่อย</label>
                            <select class="form-select" required name="Up_SecondGroup" id="Up_SecondGroup">
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4 shadow-sm">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Setting System Academic Year (ตั้งค่าปีการศึกษาสำหรับระบบครู) -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalSettingYear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                    <i class="bx bx-calendar-cog fs-4"></i>
                    <span>ตั้งค่าปีการศึกษา (ระบบครู)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-setting-year">
                <div class="modal-body p-4">
                    <div class="alert alert-light border d-flex align-items-start gap-2 mb-3 rounded-3 p-3">
                        <i class="bx bx-info-circle text-emerald fs-4 mt-1"></i>
                        <div class="small text-muted">
                            กำหนดภาคเรียนและปีการศึกษาเริ่มต้นที่ระบบครูผู้สอนจะใช้ในการจัดการตารางสอนและการมอบหมายวิชา
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-5">
                            <label class="form-label fw-bold text-dark">ภาคเรียน <span class="text-danger">*</span></label>
                            <select class="form-select text-center fw-bold" id="setting_term" name="setting_term" required>
                                <option value="1" <?= ($systemSettingTerm == '1') ? 'selected' : '' ?>>ภาคเรียนที่ 1</option>
                                <option value="2" <?= ($systemSettingTerm == '2') ? 'selected' : '' ?>>ภาคเรียนที่ 2</option>
                            </select>
                        </div>
                        <div class="col-sm-7">
                            <label class="form-label fw-bold text-dark">ปีการศึกษา (พ.ศ.) <span class="text-danger">*</span></label>
                            <select class="form-select text-center fw-bold" id="setting_year" name="setting_year" required>
                                <?php 
                                    $currentBE = date('Y') + 543;
                                    for ($y = $currentBE + 2; $y >= $currentBE - 3; $y--) : 
                                ?>
                                    <option value="<?= esc($y) ?>" <?= ($systemSettingYearOnly == $y) ? 'selected' : '' ?>>
                                        <?= esc($y) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mt-3 text-center border">
                        <small class="text-muted d-block mb-1">ผลลัพธ์ที่จะบันทึกเข้าระบบ:</small>
                        <span class="fs-4 fw-bold text-emerald" id="preview-setting-year"><?= esc($systemSettingYear) ?></span>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4 shadow-sm" id="btn-save-setting-year">
                        <i class="bx bx-save me-1"></i> บันทึกการตั้งค่า
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let tablel_Subject;
    let currentYear = $('#CheckYearNow').val();
    let centralSubjects = [];
    let isSystemOpen = <?= $isSystemOpen ? 'true' : 'false' ?>;

    loadTable(currentYear);

    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;
        const total = data.length;
        const basic = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('พื้นฐาน') || type.startsWith('1');
        }).length;
        const advanced = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('เพิ่มเติม') || type.startsWith('2');
        }).length;

        $('#stat-total').text(total);
        $('#stat-basic').text(basic);
        $('#stat-advanced').text(advanced);
    }

    // ฟังก์ชันปรับสถานะ UI แสดงผลสิทธิ์ของระบบครู
    function updateSystemUI(isOpen) {
        isSystemOpen = isOpen;
        const badge = $('#badge-system-status');
        const badgeText = $('#text-system-status');
        const switchState = $('#text-switch-state');

        if (isOpen) {
            badge.removeClass('status-badge-off').addClass('status-badge-on');
            badge.find('i').removeClass('bx-lock-alt').addClass('bx-check-circle');
            badgeText.text('เปิดระบบ');
            switchState.removeClass('bg-danger').addClass('bg-success').text('เปิด');
        } else {
            badge.removeClass('status-badge-on').addClass('status-badge-off');
            badge.find('i').removeClass('bx-check-circle').addClass('bx-lock-alt');
            badgeText.text('ปิดระบบ');
            switchState.removeClass('bg-success').addClass('bg-danger').text('ปิด');
        }
    }

    // Toggle On/Off Switch Event
    $('#toggle-system-onoff').on('change', function() {
        const isChecked = $(this).prop('checked');
        const toggleSwitch = $(this);

        toggleSwitch.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminRegisterSubject/CheckOnOffRegisterSubject') ?>",
            type: "POST",
            data: {
                check: isChecked ? 'on' : 'off'
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    const isOpen = res.new_status === 'on';
                    updateSystemUI(isOpen);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: isOpen ? 'success' : 'info',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        customClass: {
                            container: 'swal2-container-top'
                        }
                    });
                } else {
                    toggleSwitch.prop('checked', !isChecked);
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: res.message || 'ไม่สามารถบันทึกสถานะได้'
                    });
                }
            },
            error: function() {
                toggleSwitch.prop('checked', !isChecked);
                Swal.fire({
                    icon: 'error',
                    title: 'เชื่อมต่อล้มเหลว',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง'
                });
            },
            complete: function() {
                toggleSwitch.prop('disabled', false);
            }
        });
    });

    // ==========================================
    // Setting System Academic Year (ระบบครู)
    // ==========================================
    function updateSettingYearPreview() {
        const term = $('#setting_term').val();
        const year = $('#setting_year').val();
        $('#preview-setting-year').text(`${term}/${year}`);
    }

    $('#setting_term, #setting_year').on('change', function() {
        updateSettingYearPreview();
    });

    $('#form-setting-year').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btn-save-setting-year');
        const term = $('#setting_term').val();
        const year = $('#setting_year').val();
        const targetYear = `${term}/${year}`;

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminRegisterSubject/SaveSettingRegisterSubjectYear') ?>",
            type: "POST",
            data: {
                setting_term: term,
                setting_year: year
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    $('#label-system-year').text(targetYear);
                    $('#ModalSettingYear').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'ตั้งค่าสำเร็จ!',
                        text: res.message,
                        confirmButtonColor: '#15a362',
                        customClass: { container: 'swal2-container' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: res.message || 'ไม่สามารถบันทึกการตั้งค่าได้'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เชื่อมต่อล้มเหลว',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง'
                });
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกการตั้งค่า');
            }
        });
    });

    $(document).on('change', '.SelectSubject', function() {
        const selectedYear = $(this).val();
        $('#headerYear').text(selectedYear || '-');
        $('#stat-year').text(selectedYear || '-');
        if (selectedYear) {
            $('#compare-target-year').val(selectedYear);
            $('#SubjectYear').val(selectedYear);
        }
        loadTable(selectedYear);
    });

    function loadTable(Year) {
        if ($.fn.DataTable.isDataTable('#tbSubject')) {
            $('#tbSubject').DataTable().destroy();
        }

        tablel_Subject = $('#tbSubject').DataTable({
            responsive: true,
            processing: true,
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json" },
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect') ?>",
                type: "POST",
                data: { "keyYear": Year },
                dataSrc: function(json) {
                    let rows = (json.data) ? json.data : json;
                    updateStats(rows); 
                    return rows;
                }
            },
            columns: [
                {
                    data: 'SubjectYear',
                    render: function(data) {
                        return '<span class="badge badge-emerald rounded-pill px-3">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectCode',
                    render: function(data) {
                        return '<span class="fw-bold text-dark">' + data + '</span>';
                    }
                },
                { data: 'SubjectName', className: 'fw-medium' },
                {
                    data: 'FirstGroup',
                    render: function(data) {
                        return '<span class="badge bg-label-info">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectClass',
                    render: function(data) {
                        return '<span class="badge bg-label-warning">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectID',
                    className: 'text-center',
                    render: function(data) {
                        return `
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-label-warning EditSubject" idSbuj="${data}" title="แก้ไขข้อมูลรายวิชา"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-icon btn-label-danger delete_subject" idSbuj="${data}" title="ลบรายวิชา"><i class="bx bx-trash"></i></button>
                        </div>`;
                    }
                }
            ]
        });
    }

    // Central Database Integration (Master Subject Catalog)
    const db_master_url = "<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectGetMaster') ?>";
    const csv_url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSkmM4H4BP9GDxlVIHb7Eon1xR1jqwmeASdrKAfJLJ3Iplg1cRZGmgkNhNX5Q6ZkrhDSx95WF7h8HHE/pub?output=csv";

    function parseCSV(csvText) {
        const lines = csvText.split(/\r?\n/);
        const result = [];
        const splitLine = (line) => {
            const pattern = /("([^"]*)"|([^,]*))(,|$)/g;
            const fields = [];
            let match;
            while ((match = pattern.exec(line)) !== null) {
                let field = match[2] !== undefined ? match[2] : match[3];
                fields.push(field);
                if (match.index === pattern.lastIndex) pattern.lastIndex++;
                if (match[4] === "") break;
            }
            return fields;
        };

        for (let i = 1; i < lines.length; i++) {
            if (!lines[i].trim()) continue;
            const row = splitLine(lines[i]);
            if (row.length < 2) continue;
            result.push({
                code: row[0],
                name: row[1],
                unit: row[2],
                hour: row[3],
                type: row[4],
                firstGroup: row[5],
                secondGroup: row[6],
                class: row[7],
                searchString: (row[0] + ' ' + row[1] + ' ' + (row[5] || '') + ' ' + (row[7] || '')).toLowerCase()
            });
        }
        return result;
    }

    function renderSubjectList(list) {
        const container = $('#central-subject-list');
        container.empty();
        
        if (list.length === 0) {
            container.append('<div class="text-center py-4 text-muted"><i class="bx bx-search-alt fs-2 d-block mb-1 text-muted"></i>ไม่พบวิชาที่ตรงกับการค้นหาหรือตัวกรอง</div>');
            $('#total-source-count').text(`แสดง 0 รายการ`);
            return;
        }

        list.forEach((sub, index) => {
            const isTypeBasic = (sub.type || '').includes('พื้นฐาน');
            const typeBadge = isTypeBasic 
                ? '<span class="badge bg-label-success">พื้นฐาน</span>' 
                : '<span class="badge bg-label-info">เพิ่มเติม</span>';

            container.append(`
                <div class="subject-picker-item p-2 mb-2 rounded border bg-white d-flex align-items-center justify-content-between" data-index="${index}">
                    <div class="form-check mb-0 flex-grow-1">
                        <input class="form-check-input subject-checkbox" type="checkbox" 
                            id="chk-${index}" 
                            data-code="${sub.code}" 
                            data-name="${sub.name}"
                            data-unit="${sub.unit}"
                            data-hour="${sub.hour}"
                            data-type="${sub.type}"
                            data-first="${sub.firstGroup}"
                            data-second="${sub.secondGroup}"
                            data-class="${sub.class}">
                        <label class="form-check-label ms-2 d-block cursor-pointer" for="chk-${index}">
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <span class="fw-bold text-dark font-monospace me-2">${sub.code}</span>
                                <span class="text-dark fw-medium">${sub.name}</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap gap-1 mt-1 small">
                                ${sub.class ? `<span class="badge bg-label-warning me-1">${sub.class}</span>` : ''}
                                ${sub.firstGroup ? `<span class="badge bg-label-primary me-1">${sub.firstGroup}</span>` : ''}
                                ${typeBadge}
                                <span class="badge bg-light text-dark border ms-1">${sub.unit || 0} นก. (${sub.hour || 0} ชม.)</span>
                            </div>
                        </label>
                    </div>
                </div>
            `);
        });
        
        $('#total-source-count').text(`แสดง ${list.length} รายการ`);
    }

    // Filter Logic: Combines Search + Class + Group
    function applyFilters() {
        const query = ($('#search-central-subject').val() || '').toLowerCase().trim();
        const selectedGroup = $('#filter-central-group').val();
        const selectedClass = $('#SubjectClass').val();
        const filterByClass = $('#toggle-filter-class').is(':checked');

        const filtered = centralSubjects.filter(sub => {
            const matchQuery = !query || sub.searchString.includes(query);
            const matchGroup = !selectedGroup || (sub.firstGroup && sub.firstGroup.includes(selectedGroup));
            const matchClass = !filterByClass || !selectedClass || (sub.class === selectedClass);
            return matchQuery && matchGroup && matchClass;
        });

        renderSubjectList(filtered);
    }

    // Load from Database (tb_subjects_master)
    function loadCentralSubjects() {
        $.ajax({
            url: db_master_url,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data && res.data.length > 0) {
                    centralSubjects = res.data;
                    $('#source-badge').html('<i class="bx bx-cylinder me-1"></i> คลังวิชาหลัก (' + res.total + ' รายการ)');
                    applyFilters();
                } else {
                    fetchFromGoogleSheets();
                }
            },
            error: function() {
                fetchFromGoogleSheets();
            }
        });
    }

    function fetchFromGoogleSheets() {
        fetch(csv_url)
            .then(response => response.text())
            .then(csvText => {
                centralSubjects = parseCSV(csvText);
                $('#source-badge').html('<i class="bx bx-cloud me-1"></i> Google Sheets (' + centralSubjects.length + ' รายการ)');
                applyFilters();
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                $('#central-subject-list').html('<div class="alert alert-danger">ไม่สามารถโหลดข้อมูลจากคลังวิชาได้</div>');
            });
    }

    loadCentralSubjects();

    // Trigger Filters
    $('#search-central-subject').on('input', applyFilters);
    $('#filter-central-group').on('change', applyFilters);
    $('#SubjectClass').on('change', applyFilters);
    $('#toggle-filter-class').on('change', applyFilters);

    $('#clear-search').click(function() {
        $('#search-central-subject').val('');
        applyFilters();
    });

    // Checkbox Interactions
    $(document).on('change', '.subject-checkbox', function() {
        $(this).closest('.subject-picker-item').toggleClass('selected', $(this).is(':checked'));
        const count = $('.subject-checkbox:checked').length;
        $('#checked-count').text(`เลือกแล้ว ${count} วิชา`).toggleClass('text-emerald fw-bold', count > 0);
    });

    $('#check-all-subjects').change(function() {
        const isChecked = $(this).is(':checked');
        $('.subject-checkbox:visible').prop('checked', isChecked).trigger('change');
    });

    // Bulk Submit
    $('#form-subject-bulk').submit(function(e) {
        e.preventDefault();
        const year = $('#SubjectYear').val();
        const level = $('#SubjectClass').val();
        const checked = $('.subject-checkbox:checked');

        if (checked.length === 0) {
            Swal.fire('คำเตือน!', 'กรุณาเลือกวิชาอย่างน้อย 1 วิชา', 'warning');
            return;
        }

        const subjects = [];
        checked.each(function() {
            subjects.push({
                SubjectCode: $(this).data('code'),
                SubjectName: $(this).data('name'),
                SubjectUnit: $(this).data('unit'),
                SubjectHour: $(this).data('hour'),
                SubjectType: $(this).data('type'),
                FirstGroup: $(this).data('first'),
                SecondGroup: $(this).data('second'),
                SubjectClass: $(this).data('class') || level, // Use from CSV or from Form
                SubjectYear: year
            });
        });

        const submitBtn = $('#btn-submit-bulk');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectBulkInsert') ?>',
            type: 'POST',
            data: { 
                subjects: subjects,
                year: year
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'สำเร็จ!', 
                        text: response.message,
                        showConfirmButton: false, 
                        timer: 2000 
                    });
                    $('#ModalAddSubject').modal('hide');
                    tablel_Subject.ajax.reload();
                    // Reset form
                    $('.subject-checkbox').prop('checked', false).trigger('change');
                    $('#check-all-subjects').prop('checked', false);
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกวิชาเรียนที่เลือก');
            }
        });
    });

    // Edit and Delete
    $(document).on('click', '.EditSubject', function() {
        let id = $(this).attr('idSbuj');
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit') ?>',
            type: 'post',
            data: { KeySubj: id },
            dataType: 'json',
            success: function(data) {
                let d = data[0];
                $('#Up_SubjectYear').val(d.SubjectYear);
                $('#Up_SubjectClass').val(d.SubjectClass);
                $('#Up_SubjectCode').val(d.SubjectCode);
                $('#Up_SubjectName').val(d.SubjectName);
                $('#Up_SubjectUnit').val(d.SubjectUnit);
                $('#Up_SubjectHour').val(d.SubjectHour);
                $('#Up_SubjectType').val(d.SubjectType);
                $('#Up_FirstGroup').val(d.FirstGroup);
                $('#Up_SecondGroup').val(d.SecondGroup);
                $('#Up_SubjectID').val(d.SubjectID);
                $('#ModalUpdateSubject').modal('show');
            }
        });
    });

    $(document).on('submit', '#form-update-subject', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate') ?>',
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                $('#ModalUpdateSubject').modal('hide');
                Swal.fire({ icon: 'success', title: 'ปรับปรุงข้อมูลสำเร็จ', showConfirmButton: false, timer: 1500 });
                tablel_Subject.ajax.reload();
            }
        });
    });

    $(document).on('click', '.delete_subject', function() {
        let id = $(this).attr("idSbuj");
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรายวิชาจะถูกลบถาวร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectDelete/') ?>' + id,
                    type: 'DELETE',
                    success: function(data) {
                        Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบออกจากระบบแล้ว', 'success');
                        tablel_Subject.ajax.reload();
                    }
                });
            }
        })
    });

    // ==========================================
    // Comparison & Copy from Previous Year Logic
    // ==========================================
    let compareSubjectList = [];

    function loadCompareData() {
        const sourceYear  = $('#compare-source-year').val();
        const targetYear  = $('#compare-target-year').val();
        const classFilter = $('#compare-class-filter').val();
        const groupFilter = $('#compare-group-filter').val();

        if (!sourceYear || !targetYear) return;
        if (sourceYear === targetYear) {
            $('#compare-table-body').html('<tr><td colspan="8" class="text-center py-4 text-warning"><i class="bx bx-error-circle me-1"></i> ปีการศึกษาต้นทางและเป้าหมายต้องไม่เป็นปีเดียวกัน</td></tr>');
            $('#cmp-stat-total').text('0');
            $('#cmp-stat-registered').text('0');
            $('#cmp-stat-missing').text('0');
            $('#missing-count-label').text('0');
            return;
        }

        $('#compare-table-body').html('<tr><td colspan="8" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-success me-2"></div>กำลังโหลดข้อมูลเปรียบเทียบ...</td></tr>');

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectCompareYears') ?>',
            type: 'POST',
            data: {
                source_year:  sourceYear,
                target_year:  targetYear,
                class_filter: classFilter,
                group_filter: groupFilter
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    compareSubjectList = res.data || [];
                    const stats = res.stats || { total: 0, registered: 0, missing: 0 };

                    $('#cmp-stat-total').text(Number(stats.total).toLocaleString());
                    $('#cmp-stat-registered').text(Number(stats.registered).toLocaleString());
                    $('#cmp-stat-missing').text(Number(stats.missing).toLocaleString());
                    $('#missing-count-label').text(stats.missing);

                    renderCompareTable();
                } else {
                    $('#compare-table-body').html(`<tr><td colspan="8" class="text-center py-4 text-danger">${res.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล'}</td></tr>`);
                }
            },
            error: function() {
                $('#compare-table-body').html('<tr><td colspan="8" class="text-center py-4 text-danger">ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์เพื่อเปรียบเทียบข้อมูลได้</td></tr>');
            }
        });
    }

    function renderCompareTable() {
        const tbody = $('#compare-table-body');
        tbody.empty();

        const showOnlyMissing = $('#toggle-show-only-missing').is(':checked');
        const query = ($('#search-compare-table').val() || '').toLowerCase().trim();

        const filtered = compareSubjectList.filter(row => {
            const matchMissing = !showOnlyMissing || !row.is_registered;
            const matchQuery   = !query || row.searchString.includes(query);
            return matchMissing && matchQuery;
        });

        if (filtered.length === 0) {
            tbody.append('<tr><td colspan="8" class="text-center py-4 text-muted">ไม่พบข้อมูลที่ตรงกับเงื่อนไขการแสดงผล</td></tr>');
            updateCompareCount();
            return;
        }

        filtered.forEach(row => {
            const isRegistered = row.is_registered;
            const statusBadge  = isRegistered 
                ? '<span class="badge bg-label-success"><i class="bx bx-check me-1"></i> บันทึกแล้ว</span>'
                : '<span class="badge bg-label-warning"><i class="bx bx-time me-1"></i> ยังไม่มีในเทอมนี้</span>';

            const checkboxHtml = isRegistered
                ? '<input type="checkbox" class="form-check-input" disabled title="มีในเทอมนี้แล้ว">'
                : `<input type="checkbox" class="form-check-input compare-checkbox" value="${row.SubjectID}">`;

            const rowClass = isRegistered ? 'opacity-75 bg-light' : '';

            tbody.append(`
                <tr class="${rowClass}">
                    <td class="text-center">${checkboxHtml}</td>
                    <td><span class="fw-bold text-dark font-monospace">${row.SubjectCode}</span></td>
                    <td class="fw-medium">${row.SubjectName}</td>
                    <td class="text-center"><span class="badge bg-label-warning">${row.SubjectClass || '-'}</span></td>
                    <td><span class="badge bg-label-primary">${row.FirstGroup || '-'}</span></td>
                    <td class="text-center"><span class="badge bg-light text-dark border">${row.SubjectUnit || 0} นก. / ${row.SubjectHour || 0} ชม.</span></td>
                    <td class="text-center">${(row.SubjectType || '').includes('พื้นฐาน') ? '<span class="badge bg-label-success">พื้นฐาน</span>' : '<span class="badge bg-label-info">เพิ่มเติม</span>'}</td>
                    <td class="text-center">${statusBadge}</td>
                </tr>
            `);
        });

        updateCompareCount();
    }

    function updateCompareCount() {
        const checked = $('.compare-checkbox:checked').length;
        $('#compare-checked-count').text(`เลือกแล้ว ${checked} วิชา`);
        $('#btn-copy-selected-subjects').prop('disabled', checked === 0);
    }

    // Compare Modal Events
    $('#ModalCompareYear').on('shown.bs.modal', function() {
        loadCompareData();
    });

    $('#compare-source-year, #compare-class-filter, #compare-group-filter').on('change', function() {
        loadCompareData();
    });

    $('#toggle-show-only-missing').on('change', renderCompareTable);
    $('#search-compare-table').on('input', renderCompareTable);

    $(document).on('change', '.compare-checkbox', function() {
        updateCompareCount();
    });

    $('#check-all-compare').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.compare-checkbox:visible').prop('checked', isChecked);
        updateCompareCount();
    });

    $('#btn-select-all-missing').on('click', function() {
        $('.compare-checkbox').prop('checked', true);
        $('#check-all-compare').prop('checked', true);
        updateCompareCount();
    });

    // Copy Selected Subjects Submit
    $('#btn-copy-selected-subjects').on('click', function() {
        if (!isSystemOpen) {
            Swal.fire({
                icon: 'warning',
                title: 'ระบบปิดอยู่',
                text: 'ไม่สามารถคัดลอกรายวิชาได้ เนื่องจากระบบจัดการรายวิชาปิดอยู่'
            });
            return;
        }

        const selectedIds = [];
        $('.compare-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกวิชา', text: 'กรุณาเลือกวิชาที่ต้องการคัดลอกอย่างน้อย 1 วิชา' });
            return;
        }

        const sourceYear = $('#compare-source-year').val();
        const targetYear = $('#compare-target-year').val();

        Swal.fire({
            title: 'ยืนยันคัดลอกรายวิชา?',
            html: `ต้องการคัดลอกวิชาที่เลือกจำนวน <b>${selectedIds.length}</b> วิชา<br>จากปี <b>${sourceYear}</b> เข้าสู่ปี <b>${targetYear}</b> หรือไม่?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bx bx-copy me-1"></i> ยืนยันคัดลอก',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-container' }
        }).then((result) => {
            if (result.isConfirmed) {
                const btn = $('#btn-copy-selected-subjects');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังคัดลอก...');

                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectCopyFromYear') ?>',
                    type: 'POST',
                    data: {
                        source_year: sourceYear,
                        target_year: targetYear,
                        subject_ids: selectedIds
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: res.message,
                                confirmButtonColor: '#15a362',
                                customClass: { container: 'swal2-container' }
                            });
                            // Reload both tables
                            tablel_Subject.ajax.reload();
                            loadCompareData();
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message });
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="bx bx-copy-alt me-1"></i> คัดลอกวิชาที่เลือกเข้าเทอมปัจจุบัน');
                    }
                });
            }
        });
    });

    // ==========================================
    // Auto-Select Subjects by Previous Year (In Add Modal)
    // ==========================================
    $('#btn-auto-select-history').on('click', function() {
        const historyYear = $('#quick-history-year').val();
        const selectedClass = $('#SubjectClass').val();

        if (!historyYear) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีอ้างอิง', text: 'กรุณาเลือกปีการศึกษาที่ต้องการดึงรายวิชามาก่อน' });
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> ดึงข้อมูล...');

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectGetCodesByYear') ?>',
            type: 'POST',
            data: {
                year: historyYear,
                class: selectedClass
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.codes && res.codes.length > 0) {
                    const codeSet = new Set(res.codes.map(item => item.code.trim()));
                    let matchCount = 0;

                    $('.subject-checkbox').each(function() {
                        const code = $(this).data('code');
                        if (code && codeSet.has(code.trim())) {
                            $(this).prop('checked', true).trigger('change');
                            matchCount++;
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'เลือกตามปีก่อนหน้าสำเร็จ!',
                        text: `ระบบได้ติ๊กเลือกวิชาที่ตรงกับปี ${historyYear} ให้แล้ว ${matchCount} วิชา`,
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { container: 'swal2-container' }
                    });
                } else {
                    Swal.fire({ icon: 'info', title: 'ไม่พบข้อมูล', text: `ไม่พบวิชาที่เปิดสอนในระดับชั้นนี้ของปีการศึกษา ${historyYear}` });
                }
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="bx bx-magic-wand"></i> เลือกตามปีนี้');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
