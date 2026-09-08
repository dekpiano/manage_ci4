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
        background: linear-gradient(135deg, var(--dark-emerald) 0%, var(--primary-emerald) 100%) !important;
        color: #ffffff !important;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
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
                        <th class="text-center" style="width: 140px;">จัดการ</th>
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
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-emerald rounded-pill px-3 btn-view-teacher shadow-xs" 
                                        data-id="<?= esc($t->pers_id) ?>" 
                                        data-name="<?= esc($t->fullname) ?>"
                                        title="ดูรายละเอียดภาระงาน">
                                    <i class="bx bx-show me-1"></i> รายละเอียด
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
<!-- Modal: รายละเอียดภาระงานสอนรายบุคคล (3 ส่วนเต็ม) -->
<!-- ========================================== -->
<div class="modal fade animate__animated animate__fadeIn" id="modalTeacherScheduleDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header modal-teaching-header px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <img id="m-teacher-img" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="ครูผู้สอน" class="modal-avatar-lg">
                    <div>
                        <h4 class="fw-bold text-white mb-0" id="m-teacher-name">ชื่อครูผู้สอน</h4>
                        <div class="d-flex align-items-center flex-wrap gap-2 text-white opacity-90 small mt-1">
                            <span id="m-teacher-position"><i class="bx bx-briefcase me-1"></i>ตำแหน่ง</span>
                            <span>•</span>
                            <span id="m-teacher-group"><i class="bx bx-category me-1"></i>กลุ่มสาระ</span>
                            <span>•</span>
                            <span class="badge bg-white text-emerald rounded-pill fw-bold shadow-sm" style="background-color: #ffffff !important; color: #0d6d41 !important; border: 1px solid #15a362;" id="m-teacher-term">ภาคเรียนที่ -</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <!-- Summary 4 Cards Row (High Contrast) -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3 shadow-xs text-center" style="background-color: #f0f9ff !important; border: 1px solid #bae6fd !important;">
                            <small class="fw-bold text-muted d-block mb-1">วิชาที่สอน</small>
                            <h3 class="mb-0 fw-bold" style="color: #0369a1 !important;" id="sum-subjects">0</h3>
                            <small class="text-muted">รายวิชา</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3 shadow-xs text-center" style="background-color: #f0fdf4 !important; border: 1px solid #bbf7d0 !important;">
                            <small class="fw-bold text-muted d-block mb-1">คาบสอนวิชาการ</small>
                            <h3 class="mb-0 fw-bold" style="color: #15803d !important;" id="sum-teach-hours">0</h3>
                            <small class="text-muted">คาบ/สัปดาห์</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3 shadow-xs text-center" style="background-color: #ecfeff !important; border: 1px solid #a5f3fc !important;">
                            <small class="fw-bold text-muted d-block mb-1">คาบกิจกรรม/PLC</small>
                            <h3 class="mb-0 fw-bold" style="color: #0891b2 !important;" id="sum-act-hours">0</h3>
                            <small class="text-muted">คาบ/สัปดาห์</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3 shadow-xs text-center" style="background-color: #f0fdf4 !important; border: 2px solid #86efac !important;">
                            <small class="fw-bold text-muted d-block mb-1">ภาระงานสอนรวม</small>
                            <h3 class="mb-0 fw-bold" style="color: #0d6d41 !important;" id="sum-grand-hours">0</h3>
                            <small class="fw-bold" style="color: #0d6d41 !important;">คาบ/สัปดาห์</small>
                        </div>
                    </div>
                </div>

                <!-- Section 1: ตารางสอนรายวิชา (tb_teaching_schedule) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-emerald rounded-circle p-2"><i class="bx bx-book-bookmark text-white"></i></span>
                            <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 1: ตารางสอนรายวิชา (tb_teaching_schedule)</h6>
                        </div>
                        <span class="badge bg-label-primary rounded-pill" id="badge-subject-count">0 วิชา</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อรายวิชา</th>
                                    <th class="text-center">ประเภท</th>
                                    <th class="text-center">ระดับชั้น</th>
                                    <th class="text-center">ห้อง</th>
                                    <th>แผนการเรียน</th>
                                    <th class="text-center">หน่วยกิต</th>
                                    <th class="text-center">คาบ/สัปดาห์</th>
                                    <th class="text-center">รวมชม.</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody id="m-table-schedules">
                                <tr><td colspan="11" class="text-center py-4 text-muted">กำลังโหลดข้อมูล...</td></tr>
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="7" class="text-end">รวมคาบสอนรายวิชา:</td>
                                    <td class="text-center text-primary" id="foot-credits">0</td>
                                    <td class="text-center text-success" id="foot-teach-hours">0</td>
                                    <td class="text-center text-dark" id="foot-teach-periods">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Section 2: กิจกรรมพัฒนาผู้เรียน (tb_teaching_schedule_activity) -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info rounded-circle p-2"><i class="bx bx-run text-white"></i></span>
                            <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 2: กิจกรรมพัฒนาผู้เรียน / PLC / ชุมนุม (tb_teaching_schedule_activity)</h6>
                        </div>
                        <span class="badge bg-label-info rounded-pill" id="badge-activity-count">0 กิจกรรม</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>ชื่อกิจกรรม</th>
                                    <th class="text-center">ระดับชั้น</th>
                                    <th class="text-center">ห้อง</th>
                                    <th class="text-center">คาบ/สัปดาห์</th>
                                    <th class="text-center">รวมชั่วโมง</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody id="m-table-activities">
                                <tr><td colspan="7" class="text-center py-4 text-muted">-</td></tr>
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="4" class="text-end">รวมคาบกิจกรรม:</td>
                                    <td class="text-center text-info" id="foot-act-hours">0</td>
                                    <td class="text-center text-dark" id="foot-act-periods">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Section 3: หน้าที่พิเศษที่ได้รับมอบหมาย (tb_teaching_schedule_duty) -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning rounded-circle p-2"><i class="bx bx-award text-white"></i></span>
                            <h6 class="fw-bold mb-0 text-dark">ส่วนที่ 3: หน้าที่พิเศษ / คำสั่งที่ได้รับมอบหมาย (tb_teaching_schedule_duty)</h6>
                        </div>
                        <span class="badge bg-label-warning rounded-pill" id="badge-duty-count">0 งาน</span>
                    </div>
                    <div class="p-3 bg-white" id="m-list-duties">
                        <p class="text-muted small mb-0">- ไม่มีข้อมูลหน้าที่พิเศษ -</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small" id="m-footer-evaluated">
                    <i class="bx bx-shield-check text-success me-1"></i> ข้อมูลเชื่อมโยงโดยตรงจากฐานข้อมูลกลุ่มสาระฯ
                </span>
                <div class="d-flex gap-2">
                    <a href="#" id="btn-modal-print" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="bx bx-printer me-1"></i> พิมพ์ใบภาระงาน
                    </a>
                    <button type="button" class="btn btn-emerald rounded-pill px-4" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                </div>
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

    // 1. Filter Status (All / Done / Pending)
    $('.filter-status').on('change', function() {
        const val = $(this).val();
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

    // 3. Click "ดูรายละเอียด" Button
    $(document).on('click', '.btn-view-teacher', function() {
        const teacherId = $(this).data('id');
        if (!teacherId) return;

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

                schedHtml += `
                    <tr>
                        <td class="text-center text-muted fw-bold">${i + 1}</td>
                        <td><span class="fw-bold text-dark font-monospace">${s.subject_code}</span></td>
                        <td class="fw-medium">${s.subject_name}</td>
                        <td class="text-center">${typeBadge}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${s.grade_level || '-'}</span></td>
                        <td class="text-center">${roomBadge}</td>
                        <td><small class="text-muted">${s.study_plan || '-'}</small></td>
                        <td class="text-center fw-bold">${credit}</td>
                        <td class="text-center fw-bold text-success">${totalWeeklyHours}</td>
                        <td class="text-center">${s.total_hours || totalWeeklyHours}</td>
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
            actHtml = '<tr><td colspan="7" class="text-center py-3 text-muted"><i class="bx bx-info-circle me-1"></i> ไม่มีการบันทึกกิจกรรมพัฒนาผู้เรียนในเทอมนี้</td></tr>';
        } else {
            activities.forEach((a, i) => {
                actHtml += `
                    <tr>
                        <td class="text-center text-muted fw-bold">${i + 1}</td>
                        <td class="fw-medium text-dark"><i class="bx bx-check-circle text-info me-1"></i>${a.activity_name}</td>
                        <td class="text-center"><span class="badge badge-grade-level">${a.grade_level || '-'}</span></td>
                        <td class="text-center">${a.room || '-'}</td>
                        <td class="text-center fw-bold text-info">${a.hours_per_week || 0}</td>
                        <td class="text-center">${a.total_hours || 0}</td>
                        <td><small class="text-muted">${a.remark || '-'}</small></td>
                    </tr>
                `;
            });
        }
        $('#m-table-activities').html(actHtml);
        $('#foot-act-hours').text(sum.total_activity_hours || 0);
        $('#foot-act-periods').text(sum.total_activity_periods || 0);

        // Section 3: Duties List
        $('#badge-duty-count').text(`${duties.length} งาน`);
        let dutyHtml = '';
        if (duties.length === 0) {
            dutyHtml = '<p class="text-muted small mb-0"><i class="bx bx-info-circle me-1"></i> ไม่มีข้อมูลหน้าที่พิเศษที่ได้รับมอบหมาย</p>';
        } else {
            dutyHtml = '<div class="row g-2">';
            duties.forEach((d, i) => {
                dutyHtml += `
                    <div class="col-md-6">
                        <div class="p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <span class="badge bg-label-warning rounded-circle p-1"><i class="bx bx-check"></i></span>
                            <span class="text-dark small fw-medium">${d.duty_name}</span>
                        </div>
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
