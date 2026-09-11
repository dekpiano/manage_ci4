<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* High Contrast Text & Background Utilities */
    .text-emerald {
        color: var(--dark-emerald) !important;
    }
    .text-primary-emerald {
        color: var(--primary-emerald) !important;
    }
    .bg-emerald {
        background-color: var(--primary-emerald) !important;
        color: #ffffff !important;
    }
    .bg-emerald-light {
        background-color: var(--light-emerald) !important;
        color: var(--dark-emerald) !important;
    }

    .hero-group {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.2rem;
        color: #ffffff !important;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.2);
    }

    .hero-group::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -5%;
        width: 260px;
        height: 260px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .btn-outline-white {
        border: 2px solid rgba(255, 255, 255, 0.9) !important;
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.15) !important;
        font-weight: 700 !important;
        transition: all 0.3s ease;
    }

    .btn-outline-white:hover {
        background: #ffffff !important;
        color: var(--dark-emerald) !important;
        border-color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    }

    .stat-card-custom {
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        background: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card-custom:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        border-color: var(--primary-emerald);
    }

    .teacher-avatar-table {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #c8e6c9;
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    }

    .modal-avatar-lg {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    }

    .btn-emerald {
        background-color: var(--primary-emerald) !important;
        border-color: var(--primary-emerald) !important;
        color: #ffffff !important;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald) !important;
        border-color: var(--dark-emerald) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(21, 163, 98, 0.25);
    }

    /* Modal Styling */
    .modal-teaching-header {
        background: linear-gradient(135deg, #0d6d41 0%, #15a362 100%) !important;
        color: #ffffff !important;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .modal-teaching-header::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -20px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .modal-stat-widget {
        background: #ffffff;
        border-radius: 14px;
        padding: 1.1rem 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .modal-stat-widget:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    .modal-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .modal-section-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        background: #ffffff;
        overflow: hidden;
    }
    .modal-section-header {
        background: #ffffff;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-modern thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
        padding: 0.85rem 0.75rem;
    }
    .table-modern tbody td {
        padding: 0.8rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.86rem;
    }
    .table-modern tbody tr:hover {
        background-color: #f0fdf4 !important;
    }

    /* High-contrast Badges */
    .badge-workload-pass {
        background-color: #dcfce7 !important;
        color: #14532d !important;
        border: 1px solid #86efac !important;
        font-weight: 700 !important;
    }

    .badge-workload-low {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a !important;
        font-weight: 700 !important;
    }

    .badge-status-done {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #a7f3d0 !important;
        font-weight: 700 !important;
    }

    .badge-status-pending {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 600 !important;
    }

    .badge-subject-tag {
        background-color: #e0f2fe !important;
        color: #0369a1 !important;
        border: 1px solid #bae6fd !important;
        font-weight: 700 !important;
    }

    .badge-leader-tag {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
        font-weight: 700 !important;
    }

    .badge-subject-basic {
        background-color: #dcfce7 !important;
        color: #14532d !important;
        border: 1px solid #86efac !important;
        font-weight: 700 !important;
    }

    .badge-subject-extra {
        background-color: #e0f2fe !important;
        color: #0369a1 !important;
        border: 1px solid #bae6fd !important;
        font-weight: 700 !important;
    }

    .badge-grade-level {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a !important;
        font-weight: 700 !important;
    }

    /* Filter Buttons Styling */
    .filter-status:checked + label {
        background-color: var(--primary-emerald) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 2px 8px rgba(21, 163, 98, 0.3) !important;
    }
    .filter-status + label {
        color: #334155 !important;
        font-weight: 600 !important;
        transition: all 0.2s;
    }
    .filter-status + label:hover {
        color: var(--dark-emerald) !important;
        background-color: rgba(21, 163, 98, 0.1) !important;
    }

    /* Table Head Contrast */
    #tbTeacherWorkload thead th {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 0.82rem !important;
        border-bottom: 2px solid #cbd5e1 !important;
        letter-spacing: 0.3px;
    }
    #tbTeacherWorkload tbody tr:hover {
        background-color: #f0fdf4 !important;
    }

    .swal2-container {
        z-index: 9999 !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-group">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Acade/Course/TeachingSchedule') ?>" class="text-white opacity-75">ตรวจสอบตารางสอนกลุ่มสาระ</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page"><?= esc($group->lear_namethai) ?></li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white d-flex align-items-center flex-wrap gap-2">
                    <span><?= esc($group->lear_namethai) ?></span>
                    <span class="badge bg-white text-emerald fs-6 rounded-pill px-3 shadow-sm fw-bold border border-success"><?= esc($group->lear_id) ?></span>
                </h2>
                <p class="mb-0 text-white opacity-90">
                    ตรวจสอบรายชื่อครูและภาระงานสอนที่หัวหน้ากลุ่มสาระฯ บันทึกข้อมูลประจำภาคเรียนที่ <span class="fw-bold text-white text-decoration-underline"><?= esc($selectedYearTerm) ?></span>
                </p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-md-end align-items-center gap-2" style="position: relative; z-index: 5;">
                <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule/print-all/' . esc($group->lear_id) . '/' . esc($selectedYear) . '/' . esc($selectedTerm)) ?>" 
                   target="_blank" 
                   class="btn btn-white text-emerald fw-bold rounded-pill px-3 shadow-sm border-0"
                   title="พิมพ์ข้อมูลการจัดตารางสอนทั้งกลุ่มสาระฯ">
                    <i class="bx bx-printer me-1"></i> พิมพ์ทั้งหมด
                </a>
                <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule?year_term=' . urlencode($selectedYearTerm)) ?>" class="btn btn-outline-white fw-bold rounded-pill px-3">
                    <i class="bx bx-arrow-back me-1"></i> กลับหน้ารวมกลุ่ม
                </a>
                <form method="GET" action="<?= current_url() ?>" class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-20 p-2 rounded-pill shadow-sm">
                    <span class="text-white fw-bold ps-2 small"><i class="bx bx-calendar me-1"></i>ภาคเรียน:</span>
                    <select name="year_term" class="form-select form-select-sm fw-bold shadow-sm rounded-pill" style="min-width: 130px; background-color: #ffffff !important; color: #0d6d41 !important; border: 1px solid #ffffff !important;" onchange="this.form.submit()">
                        <?php foreach ($yearTerms as $yt): ?>
                        <option value="<?= esc($yt['label']) ?>" <?= ($selectedYearTerm == $yt['label']) ? 'selected' : '' ?>>
                            <?= esc($yt['label']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Mini Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-custom p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark"><?= number_format($totalTeachers) ?></h3>
                        <p class="text-muted mb-0 small">ครูทั้งหมดในกลุ่มสาระ</p>
                    </div>
                    <div class="stat-icon-wrapper p-3 rounded-3" style="background: #e8f5ee; color: var(--primary-emerald);">
                        <i class="bx bx-group fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-custom p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #15803d !important;"><?= number_format($completedCount) ?></h3>
                        <p class="text-muted mb-0 small">บันทึกภาระงานแล้ว (<?= $progressPercent ?>%)</p>
                    </div>
                    <div class="stat-icon-wrapper p-3 rounded-3" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="bx bx-check-circle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-custom p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #b45309 !important;"><?= number_format($pendingCount) ?></h3>
                        <p class="text-muted mb-0 small">ยังไม่มีข้อมูลภาระงาน</p>
                    </div>
                    <div class="stat-icon-wrapper p-3 rounded-3" style="background: #fff8e1; color: #b45309;">
                        <i class="bx bx-time fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-custom p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #0369a1 !important;"><?= number_format($totalHours) ?></h3>
                        <p class="text-muted mb-0 small">รวมคาบสอน/สัปดาห์ (กลุ่มสาระ)</p>
                    </div>
                    <div class="stat-icon-wrapper p-3 rounded-3" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bx bx-book-open fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-3" style="background: var(--light-emerald); color: var(--primary-emerald);">
                    <i class="bx bx-list-check fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">รายชื่อครูและสรุปภาระงานสอน</h5>
                    <small class="text-muted">คลิก "ดูรายละเอียด" เพื่อดูตารางสอน กิจกรรม และหน้าที่พิเศษ</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <!-- Status Filter -->
                <div class="btn-group btn-group-sm rounded-pill p-1 bg-light" role="group">
                    <input type="radio" class="btn-check filter-status" name="filter_status" id="status_all" value="all" checked>
                    <label class="btn btn-sm rounded-pill px-3" for="status_all">ทั้งหมด (<?= $totalTeachers ?>)</label>

                    <input type="radio" class="btn-check filter-status" name="filter_status" id="status_done" value="done">
                    <label class="btn btn-sm rounded-pill px-3" for="status_done">บันทึกแล้ว (<?= $completedCount ?>)</label>

                    <input type="radio" class="btn-check filter-status" name="filter_status" id="status_pending" value="pending">
                    <label class="btn btn-sm rounded-pill px-3" for="status_pending">ยังไม่บันทึก (<?= $pendingCount ?>)</label>
                </div>
                <!-- Search Box -->
                <div class="input-group input-group-sm" style="width: 220px;">
                    <span class="input-group-text bg-light border-0"><i class="bx bx-search"></i></span>
                    <input type="text" id="searchTeacherTable" class="form-control bg-light border-0" placeholder="ค้นหาชื่อครู...">
                </div>

                <!-- Print All Button -->
                <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule/print-all/' . esc($group->lear_id) . '/' . esc($selectedYear) . '/' . esc($selectedTerm)) ?>" 
                   target="_blank" 
                   class="btn btn-sm btn-emerald rounded-pill px-3 shadow-sm"
                   title="พิมพ์ข้อมูลการจัดตารางสอนทั้งกลุ่มสาระฯ">
                    <i class="bx bx-printer me-1"></i> พิมพ์ทั้งหมด
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tbTeacherWorkload">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>ครูผู้สอน</th>
                        <th>ตำแหน่ง / วิทยฐานะ</th>
                        <th class="text-center">วิชาที่สอน</th>
                        <th class="text-center">คาบสอนวิชา</th>
                        <th class="text-center">คาบกิจกรรม</th>
                        <th class="text-center">ภาระงานรวม</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center" style="width: 180px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($teachers)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bx bx-user-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                            ไม่พบข้อมูลครูในกลุ่มสาระนี้
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php $idx = 1; foreach ($teachers as $t): ?>
                    <tr class="teacher-row" data-status="<?= $t->has_data ? 'done' : 'pending' ?>" data-search="<?= strtolower($t->fullname . ' ' . ($t->pers_position ?? '') . ' ' . ($t->pers_id ?? '')) ?>">
                        <td class="text-center text-muted fw-bold"><?= $idx++ ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <?php 
                                    if (!empty($t->pers_img)) {
                                        $tImg = (strpos($t->pers_img, 'http://') === 0 || strpos($t->pers_img, 'https://') === 0) 
                                            ? $t->pers_img 
                                            : 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $t->pers_img;
                                    } else {
                                        $tImg = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
                                    }
                                ?>
                                <img src="<?= esc($tImg) ?>" alt="<?= esc($t->fullname) ?>" class="teacher-avatar-table" onerror="this.src='https://skj.ac.th/uploads/logo/LogoSKJ_4.png';">
                                <div>
                                    <span class="fw-bold text-dark d-block">
                                        <?= esc($t->fullname) ?>
                                        <?php if ($t->is_leader): ?>
                                            <span class="badge badge-leader-tag rounded-pill ms-1" style="font-size: 0.68rem;"><i class="bx bx-crown me-1"></i>หัวหน้ากลุ่ม</span>
                                        <?php endif; ?>
                                    </span>
                                    <small class="text-muted font-monospace"><?= esc($t->pers_id) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-dark d-block small fw-medium"><?= esc($t->pers_position ?: '-') ?></span>
                            <small class="text-muted"><?= esc($t->pers_academic ?: '-') ?></small>
                        </td>
                        <td class="text-center">
                            <?php if ($t->subject_count > 0): ?>
                                <span class="badge badge-subject-tag rounded-pill px-3 py-1"><?= $t->subject_count ?> วิชา</span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($t->teaching_hours > 0): ?>
                                <span class="fw-bold text-dark fs-6"><?= $t->teaching_hours ?></span> <small class="text-muted">คาบ</small>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($t->activity_hours > 0): ?>
                                <span class="fw-bold text-dark fs-6"><?= $t->activity_hours ?></span> <small class="text-muted">คาบ</small>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($t->total_hours > 0): ?>
                                <span class="badge <?= $t->total_hours >= 18 ? 'badge-workload-pass' : 'badge-workload-low' ?> rounded-pill px-3 py-1 shadow-xs">
                                    <i class="bx <?= $t->total_hours >= 18 ? 'bx-check' : 'bx-info-circle' ?> me-1"></i><?= $t->total_hours ?> คาบ/สัปดาห์
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($t->has_data): ?>
                                <span class="badge badge-status-done rounded-pill px-3 py-1 shadow-xs">
                                    <i class="bx bx-check-circle me-1"></i>บันทึกแล้ว
                                </span>
                            <?php else: ?>
                                <span class="badge badge-status-pending rounded-pill px-3 py-1">
                                    <i class="bx bx-time me-1"></i>ยังไม่มีข้อมูล
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-emerald rounded-pill px-2 py-1 btn-view-teacher shadow-xs" 
                                        data-id="<?= esc($t->pers_id) ?>" 
                                        data-name="<?= esc($t->fullname) ?>"
                                        title="ดูรายละเอียดภาระงาน">
                                    <i class="bx bx-show me-1"></i> ตรวจสอบ
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill px-2 py-1 btn-edit-teacher shadow-xs fw-bold" 
                                        data-id="<?= esc($t->pers_id) ?>" 
                                        data-name="<?= esc($t->fullname) ?>"
                                        title="แก้ไขตารางสอนของครูท่านนี้">
                                    <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                </button>
                                <?php if ($t->has_data): ?>
                                <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule/print/' . esc($t->pers_id) . '?year=' . esc($selectedYear) . '&term=' . esc($selectedTerm)) ?>" 
                                    target="_blank" 
                                    class="btn btn-sm btn-icon btn-label-secondary rounded-pill" 
                                    title="พิมพ์ใบภาระงานสอน">
                                    <i class="bx bx-printer"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- Modal: รายละเอียดภาระงานสอนรายบุคคล (ดีไซน์โมเดิร์น สัดส่วนลงตัว) -->
<!-- ========================================== -->
<div class="modal fade animate__animated animate__fadeIn" id="modalTeacherScheduleDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
            
            <!-- Modal Header (Gradient Emerald & High Contrast Profile) -->
            <div class="modal-header modal-teaching-header px-4 py-3 border-0">
                <div class="d-flex align-items-center gap-3">
                    <img id="m-teacher-img" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="ครูผู้สอน" class="modal-avatar-lg shadow-sm">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold text-white mb-0" id="m-teacher-name">ชื่อครูผู้สอน</h4>
                            <span class="badge bg-white text-emerald rounded-pill fw-bold px-3 py-1 shadow-xs" style="font-size: 0.75rem;" id="m-teacher-term">ภาคเรียนที่ -</span>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 text-white text-opacity-75 small">
                            <span id="m-teacher-position" class="d-inline-flex align-items-center"><i class="bx bx-briefcase me-1"></i>ตำแหน่ง</span>
                            <span>•</span>
                            <span id="m-teacher-group" class="d-inline-flex align-items-center"><i class="bx bx-category me-1"></i>กลุ่มสาระ</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc;">
                
                <!-- 1. Summary 4 Cards Row (Modern Widget Style) -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="modal-stat-widget">
                            <div class="modal-stat-icon" style="background-color: #e8f5ee; color: #15a362;">
                                <i class="bx bx-book-open"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="color: #064e3b;" id="sum-subjects">0</h3>
                                <small class="text-muted fw-semibold">วิชาที่สอน (วิชา)</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="modal-stat-widget">
                            <div class="modal-stat-icon" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="bx bx-time-five"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="color: #0369a1;" id="sum-teach-hours">0</h3>
                                <small class="text-muted fw-semibold">คาบสอนวิชาการ (คาบ/สัปดาห์)</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="modal-stat-widget">
                            <div class="modal-stat-icon" style="background-color: #ecfeff; color: #0891b2;">
                                <i class="bx bx-run"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="color: #0e7490;" id="sum-act-hours">0</h3>
                                <small class="text-muted fw-semibold">คาบกิจกรรม/PLC (คาบ/สัปดาห์)</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="modal-stat-widget" style="border: 2px solid #86efac; background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);">
                            <div class="modal-stat-icon" style="background-color: #dcfce7; color: #0d6d41;">
                                <i class="bx bx-check-shield"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="color: #0d6d41;" id="sum-grand-hours">0</h3>
                                <small class="fw-bold" style="color: #0d6d41;">ภาระงานสอนรวม (คาบ/สัปดาห์)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Section 1: ตารางสอนรายวิชา (Full Width) -->
                <div class="modal-section-card mb-4">
                    <div class="modal-section-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-circle p-2" style="background-color: #15a362; color: #ffffff;"><i class="bx bx-book-bookmark"></i></span>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 1: ตารางสอนรายวิชา</h6>
                                <small class="text-muted">ข้อมูลรายวิชา ห้องเรียน คาบสอน และหน่วยกิต</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill fw-bold px-3 py-2" style="background-color: #e8f5ee; color: #0d6d41; border: 1px solid #a7f3d0;" id="badge-subject-count">0 วิชา</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-modern mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 45px;">#</th>
                                    <th style="width: 110px;">รหัสวิชา</th>
                                    <th>ชื่อรายวิชา</th>
                                    <th class="text-center" style="width: 95px;">ประเภท</th>
                                    <th class="text-center" style="width: 80px;">ระดับชั้น</th>
                                    <th class="text-center" style="width: 90px;">ห้อง</th>
                                    <th>แผนการเรียน</th>
                                    <th class="text-center" style="width: 85px;">หน่วยกิต</th>
                                    <th class="text-center" style="width: 105px;">คาบ/สัปดาห์</th>
                                    <th class="text-center" style="width: 85px;">รวมชม.</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody id="m-table-schedules">
                                <tr><td colspan="11" class="text-center py-4 text-muted">กำลังโหลดข้อมูล...</td></tr>
                            </tbody>
                            <tfoot style="background-color: #f8fafc; font-weight: 700; border-top: 2px solid #e2e8f0;">
                                <tr>
                                    <td colspan="7" class="text-end text-dark">รวมคาบสอนรายวิชา:</td>
                                    <td class="text-center" style="color: #0284c7;" id="foot-credits">0</td>
                                    <td class="text-center" style="color: #15a362; font-size: 0.95rem;" id="foot-teach-hours">0</td>
                                    <td class="text-center text-dark" id="foot-teach-periods">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- 3. New Balanced Grid: Section 2 & Section 3 Side-by-Side (7 : 5) -->
                <div class="row g-4">
                    
                    <!-- Section 2: กิจกรรมพัฒนาผู้เรียน (7 Cols) -->
                    <div class="col-lg-7">
                        <div class="modal-section-card h-100 d-flex flex-column">
                            <div class="modal-section-header d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-circle p-2" style="background-color: #0891b2; color: #ffffff;"><i class="bx bx-run"></i></span>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 2: กิจกรรมพัฒนาผู้เรียน / PLC / ชุมนุม</h6>
                                        <small class="text-muted">กิจกรรมแนะแนว ลูกเสือ ชุมนุม และ PLC</small>
                                    </div>
                                </div>
                                <span class="badge rounded-pill fw-bold px-3 py-2" style="background-color: #ecfeff; color: #0891b2; border: 1px solid #a5f3fc;" id="badge-activity-count">0 กิจกรรม</span>
                            </div>
                            <div class="table-responsive flex-grow-1">
                                <table class="table table-hover table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">#</th>
                                            <th>ชื่อกิจกรรม</th>
                                            <th class="text-center" style="width: 70px;">ชั้น</th>
                                            <th class="text-center" style="width: 70px;">ห้อง</th>
                                            <th class="text-center" style="width: 100px;">คาบ/สัปดาห์</th>
                                            <th class="text-center" style="width: 80px;">รวมชม.</th>
                                            <th>หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="m-table-activities">
                                        <tr><td colspan="7" class="text-center py-4 text-muted">-</td></tr>
                                    </tbody>
                                    <tfoot style="background-color: #f8fafc; font-weight: 700; border-top: 2px solid #e2e8f0;">
                                        <tr>
                                            <td colspan="4" class="text-end text-dark">รวมคาบกิจกรรม:</td>
                                            <td class="text-center" style="color: #0891b2; font-size: 0.95rem;" id="foot-act-hours">0</td>
                                            <td class="text-center text-dark" id="foot-act-periods">0</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: หน้าที่พิเศษที่ได้รับมอบหมาย (5 Cols) -->
                    <div class="col-lg-5">
                        <div class="modal-section-card h-100 d-flex flex-column">
                            <div class="modal-section-header d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-circle p-2" style="background-color: #d97706; color: #ffffff;"><i class="bx bx-award"></i></span>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 3: หน้าที่พิเศษ / คำสั่ง</h6>
                                        <small class="text-muted">งานพิเศษตามคำสั่งโรงเรียน</small>
                                    </div>
                                </div>
                                <span class="badge rounded-pill fw-bold px-3 py-2" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;" id="badge-duty-count">0 งาน</span>
                            </div>
                            <div class="p-3 bg-white flex-grow-1" id="m-list-duties" style="min-height: 160px;">
                                <p class="text-muted small mb-0">- ไม่มีข้อมูลหน้าที่พิเศษ -</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal Footer (Clean & Modern Action Bar) -->
            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small d-inline-flex align-items-center" id="m-footer-evaluated">
                    <i class="bx bx-shield-check text-success me-1 fs-5"></i> ข้อมูลเชื่อมโยงโดยตรงจากฐานข้อมูลกลุ่มสาระฯ
                </span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning rounded-pill px-3 fw-bold shadow-xs text-dark" id="btn-modal-open-edit">
                        <i class="bx bx-edit-alt me-1"></i> แก้ไขตารางสอน
                    </button>
                    <a href="#" id="btn-modal-print" target="_blank" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-xs">
                        <i class="bx bx-printer me-1"></i> พิมพ์ใบภาระงาน
                    </a>
                    <button type="button" class="btn btn-emerald rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- Modal: จัดการและแก้ไขตารางสอนกลุ่มของครู (Edit Teacher Schedule Modal) -->
<!-- ========================================== -->
<div class="modal fade animate__animated animate__fadeIn" id="modalEditTeacherSchedule" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header px-4 py-3 border-0 text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-3">
                    <img id="edit-m-teacher-img" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="ครูผู้สอน" class="modal-avatar-lg shadow-sm" style="border-color: #f59e0b;">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold text-white mb-0" id="edit-m-teacher-name">จัดการและแก้ไขตารางสอนครู</h4>
                            <span class="badge rounded-pill fw-bold px-3 py-1 bg-warning text-dark shadow-xs" style="font-size: 0.75rem;">
                                <i class="bx bx-edit-alt me-1"></i> โหมดแก้ไข
                            </span>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 text-white text-opacity-75 small">
                            <span id="edit-m-teacher-position"><i class="bx bx-briefcase me-1"></i>ตำแหน่ง</span>
                            <span>•</span>
                            <span id="edit-m-teacher-group"><i class="bx bx-category me-1"></i>กลุ่มสาระ</span>
                            <span>•</span>
                            <span class="badge bg-white text-dark rounded-pill px-2 py-0" id="edit-m-teacher-term">ภาคเรียนที่ -</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background-color: #f8fafc;">
                
                <!-- Nav Tabs (Sneat modern pills) -->
                <ul class="nav nav-pills nav-fill mb-4 bg-white p-2 rounded-4 shadow-2xs border" id="editScheduleTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 py-2" id="tab-schedules-btn" data-bs-toggle="pill" data-bs-target="#tab-edit-schedules" type="button" role="tab">
                            <i class="bx bx-book-open fs-5"></i> 1. ตารางสอนรายวิชา
                            <span class="badge rounded-pill bg-success text-white px-2 py-1" id="badge-edit-sched-count">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 py-2 text-secondary" id="tab-activities-btn" data-bs-toggle="pill" data-bs-target="#tab-edit-activities" type="button" role="tab">
                            <i class="bx bx-run fs-5"></i> 2. กิจกรรมพัฒนาผู้เรียน
                            <span class="badge rounded-pill bg-info text-white px-2 py-1" id="badge-edit-act-count">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 py-2 text-secondary" id="tab-duties-btn" data-bs-toggle="pill" data-bs-target="#tab-edit-duties" type="button" role="tab">
                            <i class="bx bx-task fs-5"></i> 3. หน้าที่พิเศษ / คำสั่ง
                            <span class="badge rounded-pill bg-warning text-dark px-2 py-1" id="badge-edit-duty-count">0</span>
                        </button>
                    </li>
                </ul>

                <!-- Tab Panes -->
                <div class="tab-content" id="editScheduleTabContent">
                    
                    <!-- TAB 1: รายวิชาสอน -->
                    <div class="tab-pane fade show active" id="tab-edit-schedules" role="tabpanel">
                        
                        <!-- Toolbar & Add Button -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 bg-white p-3 rounded-3 border shadow-2xs">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                    <i class="bx bx-book-bookmark text-success me-2 fs-5"></i> รายการวิชาสอนในระบบ (รายห้อง)
                                </h6>
                                <small class="text-muted">เจ้าหน้าที่สามารถตรวจสอบ เพิ่ม ลบ หรือแก้ไขข้อมูลรายวิชาที่ครูลงมาผิดได้ทันที</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-emerald rounded-pill px-3 shadow-xs fw-bold" id="btn-show-add-schedule">
                                <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาใหม่
                            </button>
                        </div>

                        <!-- Collapsible Form: เพิ่ม/แก้ไขรายวิชา -->
                        <div class="card border border-2 border-success rounded-4 shadow-sm mb-4 d-none" id="card-schedule-form">
                            <div class="card-header bg-success text-white py-2 px-3 d-flex align-items-center justify-content-between">
                                <span class="fw-bold small" id="form-schedule-title"><i class="bx bx-edit me-1"></i> แบบฟอร์มรายวิชาสอน</span>
                                <button type="button" class="btn-close btn-close-white btn-sm" id="btn-close-schedule-form"></button>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <form id="formTeachingSchedule">
                                    <input type="hidden" name="schedule_id" id="f_sch_id" value="">
                                    <input type="hidden" name="teacher_id" id="f_sch_teacher_id" value="">
                                    <input type="hidden" name="year" id="f_sch_year" value="">
                                    <input type="hidden" name="term" id="f_sch_term" value="">

                                    <div class="row g-2 mb-2">
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-dark mb-1">รหัสวิชา <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control fw-bold" name="subject_code" id="f_sch_code" placeholder="เช่น ว30284" required autocomplete="off">
                                                <button class="btn btn-outline-secondary" type="button" id="btn-search-subject" title="ค้นหาจากคลังวิชา"><i class="bx bx-search"></i></button>
                                            </div>
                                            <div id="subject-search-results" class="list-group position-absolute shadow-lg d-none" style="z-index: 1050; max-height: 200px; overflow-y: auto; width: 300px;"></div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small fw-bold text-dark mb-1">ชื่อวิชา <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm fw-medium" name="subject_name" id="f_sch_name" placeholder="ชื่อรายวิชา" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">ประเภทวิชา</label>
                                            <select class="form-select form-select-sm" name="subject_type" id="f_sch_type">
                                                <option value="พื้นฐาน">พื้นฐาน</option>
                                                <option value="เพิ่มเติม">เพิ่มเติม</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">ระดับชั้น</label>
                                            <select class="form-select form-select-sm" name="grade_level" id="f_sch_grade">
                                                <option value="ม.1">ม.1</option>
                                                <option value="ม.2">ม.2</option>
                                                <option value="ม.3">ม.3</option>
                                                <option value="ม.4">ม.4</option>
                                                <option value="ม.5">ม.5</option>
                                                <option value="ม.6">ม.6</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-2">
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">ห้องเรียน</label>
                                            <input type="text" class="form-control form-control-sm text-center fw-bold" name="room" id="f_sch_room" placeholder="เช่น 1 หรือ 2">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">หน่วยกิต</label>
                                            <input type="number" step="0.5" class="form-control form-control-sm text-center fw-bold" name="credit" id="f_sch_credit" placeholder="1.0" value="1.0">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">คาบ/สัปดาห์</label>
                                            <input type="number" class="form-control form-control-sm text-center fw-bold text-success" name="hours_per_week" id="f_sch_hours" placeholder="2" value="2">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">คาบรวมทั้งเทอม</label>
                                            <input type="number" class="form-control form-control-sm text-center" name="total_hours" id="f_sch_total_hours" placeholder="40" value="40">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-dark mb-1">แผนการเรียน</label>
                                            <input type="text" class="form-control form-control-sm" name="study_plan" id="f_sch_plan" placeholder="เช่น วิทย์-คณิต, SMT(T)">
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-dark mb-1">หมายเหตุ</label>
                                            <input type="text" class="form-control form-control-sm" name="remark" id="f_sch_remark" placeholder="หมายเหตุเพิ่มเติม (ถ้ามี)">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 border-top pt-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btn-cancel-schedule-form">ยกเลิก</button>
                                        <button type="submit" class="btn btn-sm btn-emerald rounded-pill px-4 fw-bold shadow-xs">
                                            <i class="bx bx-save me-1"></i> บันทึกข้อมูลรายวิชา
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Schedules Table -->
                        <div class="card border rounded-4 overflow-hidden shadow-2xs bg-white">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tb-edit-raw-schedules">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>รหัสวิชา</th>
                                            <th>ชื่อวิชา</th>
                                            <th class="text-center">ประเภท</th>
                                            <th class="text-center">ชั้น</th>
                                            <th class="text-center">ห้อง</th>
                                            <th class="text-center">หน่วยกิต</th>
                                            <th class="text-center">คาบ/สัปดาห์</th>
                                            <th>แผนการเรียน</th>
                                            <th>หมายเหตุ</th>
                                            <th class="text-center" style="width: 120px;">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-edit-schedules">
                                        <tr><td colspan="11" class="text-center py-4 text-muted">กำลังโหลดข้อมูล...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- TAB 2: กิจกรรมพัฒนาผู้เรียน -->
                    <div class="tab-pane fade" id="tab-edit-activities" role="tabpanel">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 bg-white p-3 rounded-3 border shadow-2xs">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                    <i class="bx bx-run text-info me-2 fs-5"></i> กิจกรรมพัฒนาผู้เรียน
                                </h6>
                                <small class="text-muted">จัดการกิจกรรมพัฒนาผู้เรียน เช่น ชุมนุม ลูกเสือ แนะแนว ลดเวลาเรียน</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-xs fw-bold" id="btn-show-add-activity">
                                <i class="bx bx-plus-circle me-1"></i> เพิ่มกิจกรรม
                            </button>
                        </div>

                        <!-- Collapsible Form: เพิ่ม/แก้ไขกิจกรรม -->
                        <div class="card border border-2 border-info rounded-4 shadow-sm mb-4 d-none" id="card-activity-form">
                            <div class="card-header bg-info text-white py-2 px-3 d-flex align-items-center justify-content-between">
                                <span class="fw-bold small" id="form-activity-title"><i class="bx bx-edit me-1"></i> แบบฟอร์มกิจกรรมพัฒนาผู้เรียน</span>
                                <button type="button" class="btn-close btn-close-white btn-sm" id="btn-close-activity-form"></button>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <form id="formTeachingActivity">
                                    <input type="hidden" name="activity_id" id="f_act_id" value="">
                                    <input type="hidden" name="teacher_id" id="f_act_teacher_id" value="">
                                    <input type="hidden" name="year" id="f_act_year" value="">
                                    <input type="hidden" name="term" id="f_act_term" value="">

                                    <div class="row g-2 mb-2">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-bold text-dark mb-1">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="activity_name" id="f_act_name" placeholder="เช่น แนะแนว, ลูกเสือ-เนตรนารี, ชุมนุม" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">ระดับชั้น</label>
                                            <input type="text" class="form-control form-control-sm" name="grade_level" id="f_act_grade" placeholder="เช่น ม.1">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold text-dark mb-1">ห้อง</label>
                                            <input type="text" class="form-control form-control-sm text-center" name="room" id="f_act_room" placeholder="เช่น 1 หรือ ทุกห้อง">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-dark mb-1">คาบ/สัปดาห์</label>
                                            <input type="number" class="form-control form-control-sm text-center fw-bold" name="hours_per_week" id="f_act_hours" placeholder="1" value="1">
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-dark mb-1">หมายเหตุ</label>
                                            <input type="text" class="form-control form-control-sm" name="remark" id="f_act_remark" placeholder="หมายเหตุเพิ่มเติม">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2 border-top pt-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btn-cancel-activity-form">ยกเลิก</button>
                                        <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-4 fw-bold shadow-xs">
                                            <i class="bx bx-save me-1"></i> บันทึกกิจกรรม
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Activities Table -->
                        <div class="card border rounded-4 overflow-hidden shadow-2xs bg-white">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tb-edit-raw-activities">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>ชื่อกิจกรรม</th>
                                            <th class="text-center">ระดับชั้น</th>
                                            <th class="text-center">ห้อง</th>
                                            <th class="text-center">คาบ/สัปดาห์</th>
                                            <th class="text-center">คาบรวม</th>
                                            <th>หมายเหตุ</th>
                                            <th class="text-center" style="width: 120px;">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-edit-activities">
                                        <tr><td colspan="8" class="text-center py-4 text-muted">กำลังโหลดข้อมูล...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: หน้าที่พิเศษ -->
                    <div class="tab-pane fade" id="tab-edit-duties" role="tabpanel">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 bg-white p-3 rounded-3 border shadow-2xs">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                    <i class="bx bx-task text-warning me-2 fs-5"></i> หน้าที่พิเศษ / คำสั่งโรงเรียน
                                </h6>
                                <small class="text-muted">จัดการหน้าที่พิเศษตามคำสั่งโรงเรียนที่มอบหมายให้ครู</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill px-3 shadow-xs fw-bold" id="btn-show-add-duty">
                                <i class="bx bx-plus-circle me-1"></i> เพิ่มหน้าที่พิเศษ
                            </button>
                        </div>

                        <!-- Collapsible Form: เพิ่ม/แก้ไขหน้าที่พิเศษ -->
                        <div class="card border border-2 border-warning rounded-4 shadow-sm mb-4 d-none" id="card-duty-form">
                            <div class="card-header bg-warning text-dark py-2 px-3 d-flex align-items-center justify-content-between">
                                <span class="fw-bold small" id="form-duty-title"><i class="bx bx-edit me-1"></i> แบบฟอร์มหน้าที่พิเศษ</span>
                                <button type="button" class="btn-close btn-sm" id="btn-close-duty-form"></button>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <form id="formTeachingDuty">
                                    <input type="hidden" name="duty_id" id="f_duty_id" value="">
                                    <input type="hidden" name="teacher_id" id="f_duty_teacher_id" value="">
                                    <input type="hidden" name="year" id="f_duty_year" value="">
                                    <input type="hidden" name="term" id="f_duty_term" value="">

                                    <div class="row g-2 mb-2">
                                        <div class="col-md-9">
                                            <label class="form-label small fw-bold text-dark mb-1">ชื่องาน / คำสั่งหน้าที่พิเศษ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="duty_name" id="f_duty_name" placeholder="เช่น ปฏิบัติหน้าที่หัวหน้างานกลุ่มบริหารงานบุคคล" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-dark mb-1">ลำดับการแสดงผล</label>
                                            <input type="number" class="form-control form-control-sm text-center" name="duty_order" id="f_duty_order" placeholder="1" value="1">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2 border-top pt-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btn-cancel-duty-form">ยกเลิก</button>
                                        <button type="submit" class="btn btn-sm btn-warning text-dark rounded-pill px-4 fw-bold shadow-xs">
                                            <i class="bx bx-save me-1"></i> บันทึกหน้าที่พิเศษ
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Duties Table -->
                        <div class="card border rounded-4 overflow-hidden shadow-2xs bg-white">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tb-edit-raw-duties">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 70px;">ลำดับ</th>
                                            <th>หน้าที่พิเศษ / งานที่ได้รับมอบหมาย</th>
                                            <th class="text-center" style="width: 120px;">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-edit-duties">
                                        <tr><td colspan="3" class="text-center py-4 text-muted">กำลังโหลดข้อมูล...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="bx bx-info-circle text-primary me-1"></i> เจ้าหน้าที่สามารถตรวจสอบและปรับปรุงรายวิชากับครูผู้สอนได้โดยตรง
                </span>
                <button type="button" class="btn btn-emerald rounded-pill px-4 fw-bold shadow-sm" id="btn-finish-edit-schedule">
                    <i class="bx bx-check me-1"></i> เสร็จสิ้น / ปิดหน้าต่าง
                </button>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    const activeYear = '<?= esc($selectedYear) ?>';
    const activeTerm = '<?= esc($selectedTerm) ?>';

    let currentEditingTeacherId = null;
    let hasDataModified = false;
    let cachedTeacherRawData = null;

    // Toast Notification helper using SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // 1. Filter Status (All / Done / Pending)
    $('.filter-status').on('change', function() {
        applyTableFilter();
    });

    // 2. Search Box Live Filter
    $('#searchTeacherTable').on('input', function() {
        applyTableFilter();
    });

    function applyTableFilter() {
        const statusVal = $('input[name="filter_status"]:checked').val();
        const query = ($('#searchTeacherTable').val() || '').toLowerCase().trim();

        $('.teacher-row').each(function() {
            const rowStatus = $(this).data('status');
            const rowSearch = $(this).data('search') || '';

            const matchStatus = (statusVal === 'all') || (rowStatus === statusVal);
            const matchSearch = !query || rowSearch.includes(query);

            if (matchStatus && matchSearch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // 3. Click "ตรวจสอบ" Button (View Details Modal)
    $(document).on('click', '.btn-view-teacher', function() {
        const teacherId = $(this).data('id');
        if (!teacherId) return;

        currentEditingTeacherId = teacherId;

        // Open modal with loading state
        $('#m-teacher-name').text('กำลังโหลดข้อมูล...');
        $('#m-teacher-position').html('<span class="spinner-border spinner-border-sm me-1"></span>');
        $('#m-table-schedules').html('<tr><td colspan="11" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-success me-2"></div>กำลังโหลดตารางสอน...</td></tr>');
        $('#m-table-activities').html('<tr><td colspan="7" class="text-center py-3 text-muted">กำลังโหลด...</td></tr>');
        $('#m-list-duties').html('<p class="text-muted small mb-0">กำลังโหลด...</p>');

        $('#modalTeacherScheduleDetail').modal('show');

        // Fetch AJAX
        $.ajax({
            url: '<?= base_url('admin/academic/teaching-schedule/teacher-detail') ?>',
            type: 'POST',
            data: {
                teacher_id: teacherId,
                year: activeYear,
                term: activeTerm
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    renderTeacherModal(res.data);
                } else {
                    $('#m-table-schedules').html(`<tr><td colspan="11" class="text-center py-4 text-danger">${res.message || 'ไม่พบข้อมูล'}</td></tr>`);
                }
            },
            error: function() {
                $('#m-table-schedules').html('<tr><td colspan="11" class="text-center py-4 text-danger">เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</td></tr>');
            }
        });
    });

    // 4. Click "แก้ไขตารางสอน" จากปุ่มใน Modal รายละเอียด
    $('#btn-modal-open-edit').on('click', function() {
        if (!currentEditingTeacherId) return;
        $('#modalTeacherScheduleDetail').modal('hide');
        setTimeout(() => {
            openEditTeacherScheduleModal(currentEditingTeacherId);
        }, 300);
    });

    // 5. Click "แก้ไข" Button จากตารางรายชื่อครูโดยตรง
    $(document).on('click', '.btn-edit-teacher', function() {
        const teacherId = $(this).data('id');
        if (!teacherId) return;
        openEditTeacherScheduleModal(teacherId);
    });

    // Function: เปิด Modal แก้ไขตารางสอน
    function openEditTeacherScheduleModal(teacherId) {
        currentEditingTeacherId = teacherId;
        hasDataModified = false;

        // Reset forms
        hideAllEditForms();

        // Initial Loading UI
        $('#edit-m-teacher-name').text('กำลังโหลดข้อมูล...');
        $('#tbody-edit-schedules').html('<tr><td colspan="11" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-success me-2"></div>กำลังโหลดรายวิชา...</td></tr>');
        $('#tbody-edit-activities').html('<tr><td colspan="8" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-info me-2"></div>กำลังโหลดกิจกรรม...</td></tr>');
        $('#tbody-edit-duties').html('<tr><td colspan="3" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm text-warning me-2"></div>กำลังโหลดหน้าที่พิเศษ...</td></tr>');

        $('#modalEditTeacherSchedule').modal('show');

        loadTeacherRawData(teacherId);
    }

    // Function: ดึงข้อมูลดิบของครูผ่าน AJAX
    function loadTeacherRawData(teacherId) {
        $.ajax({
            url: '<?= base_url('admin/academic/teaching-schedule/get-raw-data') ?>',
            type: 'POST',
            data: {
                teacher_id: teacherId,
                year: activeYear,
                term: activeTerm
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    cachedTeacherRawData = res.data;
                    renderEditModal(res.data);
                } else {
                    $('#tbody-edit-schedules').html(`<tr><td colspan="11" class="text-center py-4 text-danger">${res.message || 'ไม่พบข้อมูล'}</td></tr>`);
                }
            },
            error: function() {
                $('#tbody-edit-schedules').html('<tr><td colspan="11" class="text-center py-4 text-danger">เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</td></tr>');
            }
        });
    }

    // Function: Render ข้อมูลลงใน Modal แก้ไข
    function renderEditModal(data) {
        const t = data.teacher || {};
        const g = data.group || {};
        const schedules = data.schedules || [];
        const activities = data.activities || [];
        const duties = data.duties || [];

        // Header info
        const fullName = `${t.pers_prefix || ''}${t.pers_firstname || ''} ${t.pers_lastname || ''}`;
        $('#edit-m-teacher-name').text(`แก้ไขตารางสอน: ${fullName}`);
        let teacherImgUrl = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
        if (t.pers_img) {
            teacherImgUrl = (t.pers_img.startsWith('http://') || t.pers_img.startsWith('https://')) 
                ? t.pers_img 
                : `https://personnel.skj.ac.th/uploads/admin/Personnal/${t.pers_img}`;
        }
        $('#edit-m-teacher-img').attr('src', teacherImgUrl);
        $('#edit-m-teacher-position').html(`<i class="bx bx-briefcase me-1"></i>${t.pers_position || 'ครูผู้สอน'} (${t.pers_academic || '-'})`);
        $('#edit-m-teacher-group').html(`<i class="bx bx-category me-1"></i>${g.lear_namethai || 'กลุ่มสาระฯ'}`);
        $('#edit-m-teacher-term').text(`ภาคเรียนที่ ${data.year_term || `${activeTerm}/${activeYear}`}`);

        // Badges Count
        $('#badge-edit-sched-count').text(schedules.length);
        $('#badge-edit-act-count').text(activities.length);
        $('#badge-edit-duty-count').text(duties.length);

        // Render Tab 1: Schedules Table
        renderRawSchedulesTable(schedules);

        // Render Tab 2: Activities Table
        renderRawActivitiesTable(activities);

        // Render Tab 3: Duties Table
        renderRawDutiesTable(duties);
    }

    // -------------------------------------------------------------
    // TAB 1: ตารางสอนรายวิชา (Schedules)
    // -------------------------------------------------------------
    function renderRawSchedulesTable(schedules) {
        let html = '';
        if (!schedules || schedules.length === 0) {
            html = '<tr><td colspan="11" class="text-center py-4 text-muted"><i class="bx bx-info-circle me-1"></i> ยังไม่มีรายวิชาที่สอนในเทอมนี้ คลิก "เพิ่มรายวิชาใหม่" ด้านบนเพื่อเพิ่ม</td></tr>';
        } else {
            schedules.forEach((s, idx) => {
                const typeBadge = (s.subject_type || '').includes('พื้นฐาน') 
                    ? '<span class="badge badge-subject-basic">พื้นฐาน</span>' 
                    : '<span class="badge badge-subject-extra">เพิ่มเติม</span>';

                html += `
                    <tr id="sch-row-${s.schedule_id}">
                        <td class="text-center text-muted fw-bold">${idx + 1}</td>
                        <td><span class="badge bg-light text-dark border font-monospace px-2 py-1">${s.subject_code}</span></td>
                        <td class="fw-bold text-dark">${s.subject_name}</td>
                        <td class="text-center">${typeBadge}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${s.grade_level || '-'}</span></td>
                        <td class="text-center fw-bold text-dark">${s.room || '-'}</td>
                        <td class="text-center fw-bold">${s.credit || 0}</td>
                        <td class="text-center"><span class="fw-bold text-success">${s.hours_per_week || 0}</span></td>
                        <td><small class="text-muted">${s.study_plan || '-'}</small></td>
                        <td><small class="text-muted">${s.remark || '-'}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning btn-edit-sch-item" data-id="${s.schedule_id}" title="แก้ไขวิชานี้">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-label-danger btn-delete-sch-item" data-id="${s.schedule_id}" data-name="${s.subject_name} (${s.subject_code})" title="ลบวิชานี้">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tbody-edit-schedules').html(html);
    }

    // แสดงฟอร์มเพิ่มรายวิชา
    $('#btn-show-add-schedule').on('click', function() {
        resetScheduleForm();
        $('#form-schedule-title').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาสอนใหม่');
        $('#card-schedule-form').removeClass('d-none');
        $('html, body, #modalEditTeacherSchedule .modal-body').animate({
            scrollTop: $('#card-schedule-form').offset().top - 100
        }, 200);
        $('#f_sch_code').focus();
    });

    $('#btn-close-schedule-form, #btn-cancel-schedule-form').on('click', function() {
        $('#card-schedule-form').addClass('d-none');
        resetScheduleForm();
    });

    function resetScheduleForm() {
        $('#formTeachingSchedule')[0].reset();
        $('#f_sch_id').value = '';
        $('#f_sch_id').val('');
        $('#f_sch_teacher_id').val(currentEditingTeacherId);
        $('#f_sch_year').val(activeYear);
        $('#f_sch_term').val(activeTerm);
        $('#f_sch_type').val('พื้นฐาน');
        $('#f_sch_credit').val('1.0');
        $('#f_sch_hours').val('2');
        $('#f_sch_total_hours').val('40');
        $('#subject-search-results').addClass('d-none').empty();
    }

    // คลิกแก้ไขรายวิชาในตาราง
    $(document).on('click', '.btn-edit-sch-item', function() {
        const schId = $(this).data('id');
        if (!cachedTeacherRawData || !cachedTeacherRawData.schedules) return;

        const item = cachedTeacherRawData.schedules.find(x => x.schedule_id == schId);
        if (!item) return;

        $('#f_sch_id').val(item.schedule_id);
        $('#f_sch_teacher_id').val(currentEditingTeacherId);
        $('#f_sch_year').val(activeYear);
        $('#f_sch_term').val(activeTerm);
        $('#f_sch_code').val(item.subject_code);
        $('#f_sch_name').val(item.subject_name);
        $('#f_sch_type').val(item.subject_type || 'พื้นฐาน');
        $('#f_sch_grade').val(item.grade_level || 'ม.1');
        $('#f_sch_room').val(item.room || '');
        $('#f_sch_credit').val(item.credit || '1.0');
        $('#f_sch_hours').val(item.hours_per_week || '2');
        $('#f_sch_total_hours').val(item.total_hours || '40');
        $('#f_sch_plan').val(item.study_plan || '');
        $('#f_sch_remark').val(item.remark || '');

        $('#form-schedule-title').html(`<i class="bx bx-edit me-1"></i> แก้ไขรายวิชา: ${item.subject_code} ${item.subject_name}`);
        $('#card-schedule-form').removeClass('d-none');
        
        $('html, body, #modalEditTeacherSchedule .modal-body').animate({
            scrollTop: $('#card-schedule-form').offset().top - 100
        }, 200);
        $('#f_sch_name').focus();
    });

    // Auto-calculate Total Hours เมื่อเปลี่ยน Hours per week
    $('#f_sch_hours').on('input change', function() {
        const hpw = parseInt($(this).val()) || 0;
        $('#f_sch_total_hours').val(hpw * 20);
    });

    // Auto-suggest รายวิชาจาก tb_subjects
    let searchTimer = null;
    $('#f_sch_code').on('input', function() {
        const q = $(this).val().trim();
        clearTimeout(searchTimer);
        if (q.length < 2) {
            $('#subject-search-results').addClass('d-none').empty();
            return;
        }

        searchTimer = setTimeout(() => {
            $.ajax({
                url: '<?= base_url('admin/academic/teaching-schedule/search-subjects') ?>',
                type: 'GET',
                data: { q: q },
                dataType: 'json',
                success: function(subjects) {
                    if (!subjects || subjects.length === 0) {
                        $('#subject-search-results').addClass('d-none').empty();
                        return;
                    }
                    let resHtml = '';
                    subjects.forEach(sub => {
                        resHtml += `
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action item-suggest-subject py-2" 
                               data-code="${sub.SubjectCode}" 
                               data-name="${sub.SubjectName}"
                               data-type="${sub.SubjectType || 'พื้นฐาน'}"
                               data-unit="${sub.SubjectUnit || '1.0'}"
                               data-hour="${sub.SubjectHour || '2'}"
                               data-class="${sub.SubjectClass || ''}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong class="text-success font-monospace">${sub.SubjectCode}</strong>
                                    <span class="badge bg-light text-dark border">${sub.SubjectType || 'พื้นฐาน'}</span>
                                </div>
                                <div class="small text-dark text-truncate">${sub.SubjectName}</div>
                                <small class="text-muted">${sub.SubjectClass || ''} | ${sub.SubjectUnit || 0} หน่วยกิต (${sub.SubjectHour || 0} คาบ)</small>
                            </a>
                        `;
                    });
                    $('#subject-search-results').html(resHtml).removeClass('d-none');
                }
            });
        }, 300);
    });

    // เมื่อคลิกเลือกวิชาจาก Suggestion
    $(document).on('click', '.item-suggest-subject', function() {
        const code = $(this).data('code');
        const name = $(this).data('name');
        const type = $(this).data('type');
        const unit = $(this).data('unit');
        const hour = $(this).data('hour');
        const sClass = $(this).data('class');

        $('#f_sch_code').val(code);
        $('#f_sch_name').val(name);
        if (type) $('#f_sch_type').val(type);
        if (unit) $('#f_sch_credit').val(unit);
        if (hour) {
            $('#f_sch_hours').val(hour);
            $('#f_sch_total_hours').val(parseInt(hour) * 20);
        }
        if (sClass && sClass.startsWith('ม.')) {
            $('#f_sch_grade').val(sClass);
        }

        $('#subject-search-results').addClass('d-none').empty();
    });

    // ปิด Suggestion เมื่อคลิกด้านนอก
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#f_sch_code, #subject-search-results').length) {
            $('#subject-search-results').addClass('d-none');
        }
    });

    // ส่งฟอร์มบันทึกรายวิชา
    $('#formTeachingSchedule').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= base_url('admin/academic/teaching-schedule/save-item') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    hasDataModified = true;
                    Toast.fire({
                        icon: 'success',
                        title: res.message || 'บันทึกรายวิชาเรียบร้อยแล้ว'
                    });
                    $('#card-schedule-form').addClass('d-none');
                    resetScheduleForm();
                    loadTeacherRawData(currentEditingTeacherId);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: res.message || 'ไม่สามารถบันทึกได้',
                        customClass: { container: 'swal2-highest-zindex' }
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เชื่อมต่อล้มเหลว',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                    customClass: { container: 'swal2-highest-zindex' }
                });
            }
        });
    });

    // ลบรายวิชา
    $(document).on('click', '.btn-delete-sch-item', function() {
        const schId = $(this).data('id');
        const schName = $(this).data('name');
        if (!schId) return;

        Swal.fire({
            title: 'ยืนยันการลบรายวิชา?',
            text: `ต้องการลบรายวิชา "${schName}" ออกจากตารางสอนของครูท่านนี้ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bx bx-trash me-1"></i> ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-highest-zindex' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/academic/teaching-schedule/delete-item') ?>',
                    type: 'POST',
                    data: { schedule_id: schId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            hasDataModified = true;
                            Toast.fire({
                                icon: 'success',
                                title: res.message || 'ลบรายวิชาเรียบร้อยแล้ว'
                            });
                            loadTeacherRawData(currentEditingTeacherId);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่สามารถลบได้',
                                text: res.message || 'เกิดข้อผิดพลาด',
                                customClass: { container: 'swal2-highest-zindex' }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                            customClass: { container: 'swal2-highest-zindex' }
                        });
                    }
                });
            }
        });
    });

    // -------------------------------------------------------------
    // TAB 2: กิจกรรมพัฒนาผู้เรียน (Activities)
    // -------------------------------------------------------------
    function renderRawActivitiesTable(activities) {
        let html = '';
        if (!activities || activities.length === 0) {
            html = '<tr><td colspan="8" class="text-center py-4 text-muted"><i class="bx bx-info-circle me-1"></i> ยังไม่มีกิจกรรมในเทอมนี้ คลิก "เพิ่มกิจกรรม" ด้านบนเพื่อเพิ่ม</td></tr>';
        } else {
            activities.forEach((a, idx) => {
                html += `
                    <tr>
                        <td class="text-center text-muted fw-bold">${idx + 1}</td>
                        <td class="fw-bold text-dark"><i class="bx bx-check-circle text-info me-1"></i>${a.activity_name}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${a.grade_level || '-'}</span></td>
                        <td class="text-center">${a.room || '-'}</td>
                        <td class="text-center"><span class="fw-bold text-info">${a.hours_per_week || 0}</span></td>
                        <td class="text-center">${a.total_hours || 0}</td>
                        <td><small class="text-muted">${a.remark || '-'}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning btn-edit-act-item" data-id="${a.activity_id}" title="แก้ไขกิจกรรมนี้">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-label-danger btn-delete-act-item" data-id="${a.activity_id}" data-name="${a.activity_name}" title="ลบกิจกรรมนี้">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tbody-edit-activities').html(html);
    }

    $('#btn-show-add-activity').on('click', function() {
        resetActivityForm();
        $('#form-activity-title').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มกิจกรรมใหม่');
        $('#card-activity-form').removeClass('d-none');
        $('#f_act_name').focus();
    });

    $('#btn-close-activity-form, #btn-cancel-activity-form').on('click', function() {
        $('#card-activity-form').addClass('d-none');
        resetActivityForm();
    });

    function resetActivityForm() {
        $('#formTeachingActivity')[0].reset();
        $('#f_act_id').val('');
        $('#f_act_teacher_id').val(currentEditingTeacherId);
        $('#f_act_year').val(activeYear);
        $('#f_act_term').val(activeTerm);
        $('#f_act_hours').val('1');
    }

    $(document).on('click', '.btn-edit-act-item', function() {
        const actId = $(this).data('id');
        if (!cachedTeacherRawData || !cachedTeacherRawData.activities) return;

        const item = cachedTeacherRawData.activities.find(x => x.activity_id == actId);
        if (!item) return;

        $('#f_act_id').val(item.activity_id);
        $('#f_act_teacher_id').val(currentEditingTeacherId);
        $('#f_act_year').val(activeYear);
        $('#f_act_term').val(activeTerm);
        $('#f_act_name').val(item.activity_name);
        $('#f_act_grade').val(item.grade_level || '');
        $('#f_act_room').val(item.room || '');
        $('#f_act_hours').val(item.hours_per_week || '1');
        $('#f_act_remark').val(item.remark || '');

        $('#form-activity-title').html(`<i class="bx bx-edit me-1"></i> แก้ไขกิจกรรม: ${item.activity_name}`);
        $('#card-activity-form').removeClass('d-none');
        $('#f_act_name').focus();
    });

    $('#formTeachingActivity').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= base_url('admin/academic/teaching-schedule/save-activity') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    hasDataModified = true;
                    Toast.fire({ icon: 'success', title: res.message || 'บันทึกกิจกรรมเรียบร้อยแล้ว' });
                    $('#card-activity-form').addClass('d-none');
                    resetActivityForm();
                    loadTeacherRawData(currentEditingTeacherId);
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, customClass: { container: 'swal2-highest-zindex' } });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'เชื่อมต่อล้มเหลว', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', customClass: { container: 'swal2-highest-zindex' } });
            }
        });
    });

    $(document).on('click', '.btn-delete-act-item', function() {
        const actId = $(this).data('id');
        const actName = $(this).data('name');
        if (!actId) return;

        Swal.fire({
            title: 'ยืนยันการลบกิจกรรม?',
            text: `ต้องการลบ "${actName}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ลบกิจกรรม',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-highest-zindex' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/academic/teaching-schedule/delete-activity') ?>',
                    type: 'POST',
                    data: { activity_id: actId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            hasDataModified = true;
                            Toast.fire({ icon: 'success', title: res.message });
                            loadTeacherRawData(currentEditingTeacherId);
                        } else {
                            Swal.fire({ icon: 'error', title: 'ไม่สามารถลบได้', text: res.message, customClass: { container: 'swal2-highest-zindex' } });
                        }
                    }
                });
            }
        });
    });

    // -------------------------------------------------------------
    // TAB 3: หน้าที่พิเศษ (Duties)
    // -------------------------------------------------------------
    function renderRawDutiesTable(duties) {
        let html = '';
        if (!duties || duties.length === 0) {
            html = '<tr><td colspan="3" class="text-center py-4 text-muted"><i class="bx bx-info-circle me-1"></i> ไม่มีข้อมูลหน้าที่พิเศษ คลิก "เพิ่มหน้าที่พิเศษ" ด้านบนเพื่อเพิ่ม</td></tr>';
        } else {
            duties.forEach((d, idx) => {
                html += `
                    <tr>
                        <td class="text-center fw-bold text-muted">${d.duty_order || (idx + 1)}</td>
                        <td class="text-dark fw-medium">${d.duty_name}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-icon btn-label-warning btn-edit-duty-item" data-id="${d.duty_id}" title="แก้ไขหน้าที่พิเศษ">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-label-danger btn-delete-duty-item" data-id="${d.duty_id}" data-name="${d.duty_name}" title="ลบหน้าที่พิเศษ">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tbody-edit-duties').html(html);
    }

    $('#btn-show-add-duty').on('click', function() {
        resetDutyForm();
        $('#form-duty-title').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มหน้าที่พิเศษใหม่');
        $('#card-duty-form').removeClass('d-none');
        $('#f_duty_name').focus();
    });

    $('#btn-close-duty-form, #btn-cancel-duty-form').on('click', function() {
        $('#card-duty-form').addClass('d-none');
        resetDutyForm();
    });

    function resetDutyForm() {
        $('#formTeachingDuty')[0].reset();
        $('#f_duty_id').val('');
        $('#f_duty_teacher_id').val(currentEditingTeacherId);
        $('#f_duty_year').val(activeYear);
        $('#f_duty_term').val(activeTerm);
        $('#f_duty_order').val('1');
    }

    $(document).on('click', '.btn-edit-duty-item', function() {
        const dutyId = $(this).data('id');
        if (!cachedTeacherRawData || !cachedTeacherRawData.duties) return;

        const item = cachedTeacherRawData.duties.find(x => x.duty_id == dutyId);
        if (!item) return;

        $('#f_duty_id').val(item.duty_id);
        $('#f_duty_teacher_id').val(currentEditingTeacherId);
        $('#f_duty_year').val(activeYear);
        $('#f_duty_term').val(activeTerm);
        $('#f_duty_name').val(item.duty_name);
        $('#f_duty_order').val(item.duty_order || '1');

        $('#form-duty-title').html(`<i class="bx bx-edit me-1"></i> แก้ไขหน้าที่พิเศษ`);
        $('#card-duty-form').removeClass('d-none');
        $('#f_duty_name').focus();
    });

    $('#formTeachingDuty').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= base_url('admin/academic/teaching-schedule/save-duty') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    hasDataModified = true;
                    Toast.fire({ icon: 'success', title: res.message || 'บันทึกหน้าที่พิเศษเรียบร้อยแล้ว' });
                    $('#card-duty-form').addClass('d-none');
                    resetDutyForm();
                    loadTeacherRawData(currentEditingTeacherId);
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, customClass: { container: 'swal2-highest-zindex' } });
                }
            }
        });
    });

    $(document).on('click', '.btn-delete-duty-item', function() {
        const dutyId = $(this).data('id');
        const dutyName = $(this).data('name');
        if (!dutyId) return;

        Swal.fire({
            title: 'ยืนยันการลบหน้าที่พิเศษ?',
            text: `ต้องการลบ "${dutyName}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ลบรายการ',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-highest-zindex' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/academic/teaching-schedule/delete-duty') ?>',
                    type: 'POST',
                    data: { duty_id: dutyId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            hasDataModified = true;
                            Toast.fire({ icon: 'success', title: res.message });
                            loadTeacherRawData(currentEditingTeacherId);
                        } else {
                            Swal.fire({ icon: 'error', title: 'ไม่สามารถลบได้', text: res.message, customClass: { container: 'swal2-highest-zindex' } });
                        }
                    }
                });
            }
        });
    });

    // ซ่อนแบบฟอร์มแก้ไขทั้งหมด
    function hideAllEditForms() {
        $('#card-schedule-form').addClass('d-none');
        $('#card-activity-form').addClass('d-none');
        $('#card-duty-form').addClass('d-none');
        $('#subject-search-results').addClass('d-none').empty();
    }

    // เมื่อปิด Modal แก้ไข (ปุ่มเสร็จสิ้น หรือปุ่มปิด)
    $('#btn-finish-edit-schedule').on('click', function() {
        $('#modalEditTeacherSchedule').modal('hide');
    });

    $('#modalEditTeacherSchedule').on('hidden.bs.modal', function() {
        hideAllEditForms();
        if (hasDataModified) {
            // ถ้ามีการแก้ไขข้อมูลจริง ให้รีโหลดหน้าเพื่อให้สถิติและตารางหลักปรับปรุงตรงกัน
            location.reload();
        }
    });

    // -------------------------------------------------------------
    // Modal รายละเอียดการสอน (View Schedule Detail Render)
    // -------------------------------------------------------------
    function renderTeacherModal(data) {
        const t = data.teacher || {};
        const g = data.group || {};
        const sum = data.summary || {};
        const schedules = data.schedules || [];
        const activities = data.activities || [];
        const duties = data.duties || [];

        // Header info
        const fullName = `${t.pers_prefix || ''}${t.pers_firstname || ''} ${t.pers_lastname || ''}`;
        $('#m-teacher-name').text(fullName);
        let teacherImgUrl = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
        if (t.pers_img) {
            teacherImgUrl = (t.pers_img.startsWith('http://') || t.pers_img.startsWith('https://')) 
                ? t.pers_img 
                : `https://personnel.skj.ac.th/uploads/admin/Personnal/${t.pers_img}`;
        }
        $('#m-teacher-img').attr('src', teacherImgUrl);
        $('#m-teacher-position').html(`<i class="bx bx-briefcase me-1"></i>${t.pers_position || 'ครูผู้สอน'} (${t.pers_academic || '-'})`);
        $('#m-teacher-group').html(`<i class="bx bx-category me-1"></i>${g.lear_namethai || 'กลุ่มสาระฯ'}`);
        $('#m-teacher-term').text(`ภาคเรียนที่ ${data.year_term || `${activeTerm}/${activeYear}`}`);

        // Set Print Link
        $('#btn-modal-print').attr('href', `<?= base_url('Admin/Acade/Course/TeachingSchedule/print') ?>/${t.pers_id}/${activeYear}/${activeTerm}`);

        // Summary Cards
        $('#sum-subjects').text(sum.total_subjects || 0);
        $('#sum-teach-hours').text(sum.total_teaching_hours || 0);
        $('#sum-act-hours').text(sum.total_activity_hours || 0);
        $('#sum-grand-hours').text(sum.grand_total_hours || 0);

        // Section 1: Schedules Table (grouped by subject_code + grade_level)
        $('#badge-subject-count').text(`${schedules.length} รายวิชา (จัดกลุ่มแล้ว)`);
        let schedHtml = '';
        let sumCredits = 0;
        let sumTeachHours = 0;
        if (schedules.length === 0) {
            schedHtml = '<tr><td colspan="11" class="text-center py-4 text-muted"><i class="bx bx-info-circle me-1"></i> ยังไม่มีการบันทึกตารางสอนรายวิชาในเทอมนี้</td></tr>';
        } else {
            schedules.forEach((s, i) => {
                const typeBadge = (s.subject_type || '').includes('พื้นฐาน') 
                    ? '<span class="badge badge-subject-basic">พื้นฐาน</span>' 
                    : '<span class="badge badge-subject-extra">เพิ่มเติม</span>';

                const roomDisplay = s.room_text || s.room || '-';
                const roomCount = s.room_count || 1;
                const hoursPerWeek = parseFloat(s.hours_per_week) || 0;
                const totalWeeklyHours = parseFloat(s.total_weekly_hours) || (hoursPerWeek * roomCount);
                const credit = parseFloat(s.credit) || 0;

                sumCredits += credit;
                sumTeachHours += totalWeeklyHours;

                // แสดงจำนวนห้องเพิ่มเติมถ้ามากกว่า 1
                const roomBadge = roomCount > 1 
                    ? `<span class="fw-bold">${roomDisplay}</span> <small class="text-muted">(${roomCount} ห้อง)</small>` 
                    : `<span>${roomDisplay}</span>`;

                // ถ้ามีห้องมากกว่า 1 ห้อง ในส่วนของ แผนการเรียน ไม่ต้องแสดงผล
                const studyPlanDisplay = (roomCount > 1) ? '-' : (s.study_plan && s.study_plan !== '-' ? s.study_plan : '-');

                schedHtml += `
                    <tr>
                        <td class="text-center text-muted fw-bold">${i + 1}</td>
                        <td><span class="badge bg-light text-dark border font-monospace px-2 py-1">${s.subject_code}</span></td>
                        <td class="fw-bold text-dark">${s.subject_name}</td>
                        <td class="text-center">${typeBadge}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${s.grade_level || '-'}</span></td>
                        <td class="text-center">${roomBadge}</td>
                        <td><small class="text-muted">${studyPlanDisplay}</small></td>
                        <td class="text-center fw-bold text-dark">${credit}</td>
                        <td class="text-center"><span class="fw-bold" style="color: #15a362; font-size: 0.95rem;">${totalWeeklyHours}</span></td>
                        <td class="text-center text-secondary fw-semibold">${s.total_hours || totalWeeklyHours}</td>
                        <td><small class="text-muted">${s.remark || '-'}</small></td>
                    </tr>
                `;
            });
        }
        $('#m-table-schedules').html(schedHtml);
        $('#foot-credits').text(sum.total_credits || sumCredits);
        $('#foot-teach-hours').text(sum.total_teaching_hours || sumTeachHours);
        $('#foot-teach-periods').text(sum.total_teaching_periods || sumTeachHours);

        // Section 2: Activities Table
        $('#badge-activity-count').text(`${activities.length} กิจกรรม`);
        let actHtml = '';
        if (activities.length === 0) {
            actHtml = '<tr><td colspan="7" class="text-center py-4 text-muted"><i class="bx bx-info-circle me-1"></i> ไม่มีการบันทึกกิจกรรมพัฒนาผู้เรียนในเทอมนี้</td></tr>';
        } else {
            activities.forEach((a, i) => {
                actHtml += `
                    <tr>
                        <td class="text-center text-muted fw-bold">${i + 1}</td>
                        <td class="fw-bold text-dark"><i class="bx bx-check-circle text-info me-1"></i>${a.activity_name}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${a.grade_level || '-'}</span></td>
                        <td class="text-center">${a.room || '-'}</td>
                        <td class="text-center"><span class="fw-bold" style="color: #0891b2;">${a.hours_per_week || 0}</span></td>
                        <td class="text-center text-secondary">${a.total_hours || 0}</td>
                        <td><small class="text-muted">${a.remark || '-'}</small></td>
                    </tr>
                `;
            });
        }
        $('#m-table-activities').html(actHtml);
        $('#foot-act-hours').text(sum.total_activity_hours || 0);
        $('#foot-act-periods').text(sum.total_activity_periods || 0);

        // Section 3: Duties List (Vertical Stack Card List)
        $('#badge-duty-count').text(`${duties.length} งาน`);
        let dutyHtml = '';
        if (duties.length === 0) {
            dutyHtml = '<div class="text-center py-4 text-muted small"><i class="bx bx-info-circle me-1 fs-5 d-block mb-1"></i>ไม่มีข้อมูลหน้าที่พิเศษที่ได้รับมอบหมาย</div>';
        } else {
            dutyHtml = '<div class="d-flex flex-column gap-2">';
            duties.forEach((d, i) => {
                dutyHtml += `
                    <div class="p-2 px-3 border rounded-3 bg-light d-flex align-items-center gap-2 shadow-2xs">
                        <span class="badge rounded-circle p-1" style="background-color: #fef3c7; color: #b45309;"><i class="bx bx-check"></i></span>
                        <span class="text-dark small fw-semibold flex-grow-1">${d.duty_name}</span>
                        ${d.remark ? `<small class="text-muted">(${d.remark})</small>` : ''}
                    </div>
                `;
            });
            dutyHtml += '</div>';
        }
        $('#m-list-duties').html(dutyHtml);
    }
});
</script>
<?= $this->endSection() ?>
