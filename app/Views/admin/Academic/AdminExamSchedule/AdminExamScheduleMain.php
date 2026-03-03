<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Green Theme #15a362 ===== */
:root {
    --primary-green: #15a362;
    --primary-green-dark: #128a52;
    --primary-green-light: #1bc676;
    --gradient-green: linear-gradient(135deg, #15a362 0%, #1bc676 50%, #20c997 100%);
    --gradient-green-dark: linear-gradient(135deg, #128a52 0%, #15a362 100%);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    --hover-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

/* ===== Page Container ===== */
.exam-schedule-page {
    padding: 1.5rem;
    background: linear-gradient(180deg, #f8fdf9 0%, #ffffff 100%);
    min-height: 100vh;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: var(--gradient-green);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(21, 163, 98, 0.3);
    margin-bottom: 1.5rem;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(3deg); }
}

.welcome-banner .content {
    position: relative;
    z-index: 1;
}

.welcome-banner h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
}

.welcome-banner p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
    margin: 0;
}

.welcome-banner .icon-wrapper {
    font-size: 7rem;
    color: rgba(255, 255, 255, 0.15);
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
}

.welcome-banner .breadcrumb-nav {
    margin-top: 0.75rem;
}

.welcome-banner .breadcrumb-nav a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s ease;
}

.welcome-banner .breadcrumb-nav a:hover {
    color: #fff;
}

.welcome-banner .breadcrumb-nav span {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0.5rem;
}

.btn-add-new {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-add-new:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
    transform: translateY(-2px);
}

.btn-add-new i {
    margin-right: 0.5rem;
}

/* ===== Stat Cards ===== */
.stat-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: var(--card-shadow);
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.stat-card.card-midterm::before { background: linear-gradient(90deg, #17a2b8, #20c997); }
.stat-card.card-final::before { background: linear-gradient(90deg, #ffc107, #ffda44); }
.stat-card.card-total::before { background: var(--gradient-green); }
.stat-card.card-year::before { background: var(--gradient-green); }

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--hover-shadow);
}

.stat-card .card-body {
    padding: 1.5rem;
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: #fff;
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(-5deg);
}

.stat-icon-wrapper.bg-info-gradient {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
}

.stat-icon-wrapper.bg-warning-gradient {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
}

.stat-icon-wrapper.bg-success-gradient {
    background: linear-gradient(135deg, #15a362 0%, #1bc676 100%);
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-meta {
    font-size: 0.8rem;
    color: #adb5bd;
    margin-top: 0.75rem;
}

.stat-meta i {
    margin-right: 0.25rem;
}

/* ===== Table Card ===== */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.25rem 1.5rem;
}

.table-card .card-header h5 {
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.table-card .card-header h5 i {
    color: var(--primary-green);
}

.table-card .card-body {
    padding: 0;
}

/* ===== DataTable Styling ===== */
#examScheduleTable {
    width: 100% !important;
}

#examScheduleTable thead th {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #495057;
    padding: 1rem 1.25rem;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
}

#examScheduleTable tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    font-size: 0.95rem;
}

#examScheduleTable tbody tr {
    transition: all 0.2s ease;
}

#examScheduleTable tbody tr:hover {
    background: rgba(21, 163, 98, 0.04);
}

/* Exam Type Badge */
.exam-type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
}

.exam-type-badge.badge-midterm {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1976d2;
}

.exam-type-badge.badge-final {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
    color: #f57c00;
}

.exam-type-badge i {
    margin-right: 0.4rem;
}

/* Year Badge */
.year-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

.year-badge i {
    margin-right: 0.35rem;
    color: var(--primary-green);
}

/* Term Badge */
.term-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--primary-green);
}

.term-badge i {
    margin-right: 0.35rem;
}

/* File Link */
.file-link {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: rgba(21, 163, 98, 0.08);
    border-radius: 10px;
    text-decoration: none;
    color: var(--primary-green);
    transition: all 0.3s ease;
    max-width: 200px;
}

.file-link:hover {
    background: rgba(21, 163, 98, 0.15);
    color: var(--primary-green-dark);
    transform: translateX(3px);
}

.file-link i {
    font-size: 1.25rem;
    margin-right: 0.5rem;
}

.file-link span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 500;
}

/* Date Display */
.date-display {
    display: flex;
    align-items: center;
    color: #495057;
}

.date-display i {
    color: var(--primary-green);
    margin-right: 0.5rem;
}

.date-display .time {
    color: #adb5bd;
    margin-left: 0.5rem;
    font-size: 0.85rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-action.btn-view {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.2) 100%);
    color: var(--primary-green);
}

.btn-action.btn-view:hover {
    background: var(--gradient-green);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.4);
}

.btn-action.btn-delete {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.2) 100%);
    color: #dc3545;
}

.btn-action.btn-delete:hover {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

/* DataTables Custom Styling */
.dataTables_wrapper {
    padding: 1.25rem;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
    padding: 0.4rem 2rem 0.4rem 0.8rem;
    border: 2px solid #e9ecef;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 10px;
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
    outline: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    margin: 0 2px;
    border: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: var(--gradient-green) !important;
    color: #fff !important;
    border: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e9ecef !important;
    color: #212529 !important;
    border: none !important;
}

/* ===== Modal Styling ===== */
#examScheduleModal .modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

#examScheduleModal .modal-header {
    background: var(--gradient-green);
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

#examScheduleModal .modal-header .modal-title {
    color: #fff;
    font-weight: 600;
}

#examScheduleModal .modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

#examScheduleModal .modal-header .btn-close:hover {
    opacity: 1;
}

#examScheduleModal .modal-body {
    padding: 1.5rem;
}

#examScheduleModal .modal-footer {
    background: #f8f9fa;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.5rem;
}

#examScheduleModal .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

#examScheduleModal .form-control,
#examScheduleModal .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

#examScheduleModal .form-control:focus,
#examScheduleModal .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}

.btn-save {
    background: var(--gradient-green);
    border: none;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(21, 163, 98, 0.4);
    color: #fff;
}

/* File Input Styling */
.file-input-wrapper .form-control {
    padding: 0.5rem 1rem;
}

.file-input-wrapper .input-group-text {
    background: var(--gradient-green);
    border: none;
    color: #fff;
    font-weight: 500;
    border-radius: 0 10px 10px 0;
}

/* ===== Empty State ===== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 5rem;
    color: #e9ecef;
    margin-bottom: 1.5rem;
}

.empty-state h5 {
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #adb5bd;
    font-size: 0.9rem;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .welcome-banner {
        padding: 1.5rem;
    }
    
    .welcome-banner h1 {
        font-size: 1.35rem;
    }
    
    .welcome-banner .icon-wrapper {
        display: none;
    }
    
    .stat-value {
        font-size: 1.75rem;
    }
}
</style>

<div class="exam-schedule-page">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>
                        <i class="bx bx-calendar-check me-2"></i>จัดการ<?= isset($title) ? esc($title) : 'ตารางสอบ' ?>
                    </h1>
                    <p>ระบบจัดการตารางสอบกลางภาคและปลายภาค ประจำภาคเรียนและปีการศึกษา</p>
                    <div class="breadcrumb-nav">
                        <a href="<?= base_url('Admin/Home') ?>"><i class="bx bx-home-alt"></i> หน้าหลัก</a>
                        <span>/</span>
                        <a href="#">งานทะเบียน</a>
                        <span>/</span>
                        <span class="text-white"><?= isset($title) ? esc($title) : 'ตารางสอบ' ?></span>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#examScheduleModal">
                        <i class="bx bx-plus-circle"></i>เพิ่มตารางสอบ
                    </button>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-calendar-edit"></i>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <?php 
        $midtermCount = 0;
        $finalCount = 0;
        $currentYear = date('Y') + 543;
        foreach($exam_schedule as $exam) {
            if($exam->exam_type == 'กลางภาค') $midtermCount++;
            if($exam->exam_type == 'ปลายภาค') $finalCount++;
        }
        $totalCount = count($exam_schedule);
        ?>
        
        <!-- Midterm Count -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-midterm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info"><?= $midtermCount ?></div>
                            <div class="stat-label">ตารางสอบกลางภาค</div>
                        </div>
                        <div class="stat-icon-wrapper bg-info-gradient">
                            <i class="bx bx-book-open"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-calendar"></i>รายการทั้งหมด
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Count -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-final h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning"><?= $finalCount ?></div>
                            <div class="stat-label">ตารางสอบปลายภาค</div>
                        </div>
                        <div class="stat-icon-wrapper bg-warning-gradient">
                            <i class="bx bx-bookmark-alt"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-calendar"></i>รายการทั้งหมด
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Count -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-total h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success"><?= $totalCount ?></div>
                            <div class="stat-label">ตารางสอบทั้งหมด</div>
                        </div>
                        <div class="stat-icon-wrapper bg-success-gradient">
                            <i class="bx bx-file"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-check-circle"></i>อัปโหลดแล้ว
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Year -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-year h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success"><?= $currentYear ?></div>
                            <div class="stat-label">ปีการศึกษาปัจจุบัน</div>
                        </div>
                        <div class="stat-icon-wrapper bg-success-gradient">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-time"></i>อัปเดตล่าสุด
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card table-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5><i class="bx bx-table me-2"></i>รายการตารางสอบทั้งหมด</h5>
            <button type="button" class="btn btn-add-new d-md-none" style="background: var(--gradient-green); border: none; color: #fff; padding: 0.5rem 1rem; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#examScheduleModal">
                <i class="bx bx-plus-circle me-1"></i>เพิ่มตารางสอบ
            </button>
        </div>
        <div class="card-body">
            <?php if(!empty($exam_schedule)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="examScheduleTable" width="100%">
                    <thead>
                        <tr>
                            <th><i class="bx bx-category me-1"></i>ประเภทการสอบ</th>
                            <th><i class="bx bx-calendar me-1"></i>ปีการศึกษา</th>
                            <th><i class="bx bx-book me-1"></i>ภาคเรียน</th>
                            <th><i class="bx bx-file me-1"></i>ไฟล์ตารางสอบ</th>
                            <th><i class="bx bx-time me-1"></i>วันที่อัปโหลด</th>
                            <th class="text-center"><i class="bx bx-show me-1"></i>สถานะ</th>
                            <th class="text-center"><i class="bx bx-cog me-1"></i>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $remoteBaseUrl = "https://skj.nsnpao.go.th/uploads/academic/ExamSchedule/";
                    foreach ($exam_schedule as $key => $v_exam_schedule) : 
                        $fileName = isset($v_exam_schedule->exam_filename) ? esc($v_exam_schedule->exam_filename) : '';
                        $fileUrl = $remoteBaseUrl . rawurlencode($fileName);
                        $localDeleteUrl = site_url('Admin/Acade/ConAdminExamSchedule/delete_exam_schedule/'.(isset($v_exam_schedule->exam_id) ? esc($v_exam_schedule->exam_id, 'url') : ''));
                    ?>
                    <tr>
                        <td>
                            <span class="exam-type-badge <?= $v_exam_schedule->exam_type == 'กลางภาค' ? 'badge-midterm' : 'badge-final' ?>">
                                <i class="bx <?= $v_exam_schedule->exam_type == 'กลางภาค' ? 'bx-book-open' : 'bx-bookmark-alt' ?>"></i>
                                สอบ<?= isset($v_exam_schedule->exam_type) ? esc($v_exam_schedule->exam_type) : '' ?>
                            </span>
                        </td>
                        <td>
                            <span class="year-badge">
                                <i class="bx bx-calendar"></i><?= isset($v_exam_schedule->exam_year) ? esc($v_exam_schedule->exam_year) : '' ?>
                            </span>
                        </td>
                        <td>
                            <span class="term-badge">
                                <i class="bx bx-book"></i>ภาคเรียนที่ <?= isset($v_exam_schedule->exam_term) ? esc($v_exam_schedule->exam_term) : '' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer" class="file-link">
                                <i class="bx bx-file"></i>
                                <span><?= $fileName ?></span>
                            </a>
                        </td>
                        <td>
                            <div class="date-display">
                                <i class="bx bx-calendar-alt"></i>
                                <?= date('d/m/Y', strtotime($v_exam_schedule->exam_create)) ?>
                                <span class="time"><?= date('H:i', strtotime($v_exam_schedule->exam_create)) ?> น.</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="statusSwitch_<?= $v_exam_schedule->exam_id ?>" 
                                    <?= ($v_exam_schedule->exam_status ?? 'เปิด') == 'เปิด' ? 'checked' : '' ?>
                                    onchange="updateExamStatus('<?= $v_exam_schedule->exam_id ?>', this.checked ? 'เปิด' : 'ปิด')">
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= $fileUrl ?>" target="_blank" class="btn-action btn-view" title="ดูไฟล์">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button type="button" onclick="deleteExamSchedule('<?= $localDeleteUrl ?>', '<?= $fileName ?>')" class="btn-action btn-delete" title="ลบ">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="bx bx-calendar-x"></i>
                <h5>ไม่พบข้อมูลตารางสอบ</h5>
                <p>ยังไม่มีการอัปโหลดตารางสอบในระบบ กรุณาเพิ่มตารางสอบใหม่</p>
                <button type="button" class="btn btn-save mt-3" data-bs-toggle="modal" data-bs-target="#examScheduleModal">
                    <i class="bx bx-plus-circle me-1"></i>เพิ่มตารางสอบ
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="examScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="examScheduleForm" action="<?= site_url('admin/academic/ConAdminExamSchedule/insert_exam_schedule');?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-calendar-plus me-2"></i>เพิ่มตารางสอบ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label"><i class="bx bx-category me-1"></i>ประเภทการสอบ</label>
                            <select name="exam_type" class="form-select" required>
                                <option value="">-- เลือกประเภทการสอบ --</option>
                                <option value="กลางภาค">สอบกลางภาค</option>
                                <option value="ปลายภาค">สอบปลายภาค</option>
                            </select>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label"><i class="bx bx-book me-1"></i>ภาคเรียน</label>
                            <select name="exam_term" class="form-select" required>
                                <option value="">-- เลือก --</option>
                                <option value="1">ภาคเรียนที่ 1</option>
                                <option value="2">ภาคเรียนที่ 2</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label"><i class="bx bx-calendar me-1"></i>ปีการศึกษา</label>
                            <select name="exam_year" class="form-select" required>
                                <option value="">-- เลือก --</option>
                                <?php 
                                $currentYear = date('Y')+543;
                                for($i = $currentYear; $i >= $currentYear-2; $i--): 
                                ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="bx bx-upload me-1"></i>ไฟล์ตารางสอบ</label>
                            <div class="file-input-wrapper">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="exam_filename" id="exam_filename" accept=".pdf,.xls,.xlsx,.doc,.docx,.jpg,.jpeg,.png,.gif" required>
                                    <label class="input-group-text" for="exam_filename">
                                        <i class="bx bx-folder-open me-1"></i>เลือกไฟล์
                                    </label>
                                </div>
                            </div>
                            <div class="text-muted mt-2" style="font-size: 0.8rem;">
                                <i class="bx bx-info-circle me-1"></i>รองรับไฟล์: PDF (จะถูกแปลงเป็นรูป), รูปภาพ (ขนาดไม่เกิน 5MB)
                            </div>
                            <!-- Hidden canvas for PDF processing -->
                            <canvas id="pdf-canvas" style="display: none;"></canvas>
                            <div id="image-preview-container" class="mt-3 text-center" style="display: none;">
                                <p class="small text-muted mb-1">ตัวอย่างรูปภาพที่จะถูกบันทึก:</p>
                                <img id="image-preview" src="" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>ยกเลิก
                    </button>
                    <button type="submit" id="saveButton" class="btn btn-save">
                        <i class="bx bx-save me-1"></i>บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<!-- PDF.js library for PDF to Image conversion -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    // Initialize PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<script>
    const UPLOAD_URL = '<?= site_url('admin/academic/ConAdminExamSchedule/upload_proxy') ?>';
    const DELETE_URL = '<?= site_url('admin/academic/ConAdminExamSchedule/delete_proxy') ?>';
    const UPLOAD_PATH = 'academic/ExamSchedule';

    // Initialize DataTable
    var table = $('#examScheduleTable').DataTable({
        "processing": true,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
        "language": {
            "processing": '<div class="d-flex justify-content-center align-items-center py-4"><div class="spinner-border text-success"></div><span class="ms-3">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": '<div class="empty-state py-4"><i class="bx bx-search-alt" style="font-size: 3rem;"></i><h6 class="mt-2 text-muted">ไม่พบข้อมูลที่ค้นหา</h6></div>',
            "paginate": {
                "first": '<i class="bx bx-chevrons-left"></i>',
                "last": '<i class="bx bx-chevrons-right"></i>',
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"]],
        "columnDefs": [
            { "targets": [3, 5], "orderable": false }
        ],
        "order": [[4, 'desc']],
        responsive: true
    });

    function deleteRemoteFile(fileName, path) {
        const postData = {
            files: [fileName],
            path: path
        };

        return $.ajax({
            url: DELETE_URL,
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json'
        });
    }

    function deleteExamSchedule(localDeleteUrl, remoteFileName) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: "ไฟล์จะถูกลบจากเซิร์ฟเวอร์และข้อมูลจะถูกลบจากฐานข้อมูล!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bx bx-trash me-1"></i>ใช่, ลบเลย!',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRemoteFile(remoteFileName, UPLOAD_PATH).always(function(deleteResponse) {
                    console.log('Remote delete response:', deleteResponse);

                    $.ajax({
                        url: localDeleteUrl,
                        type: 'POST',
                        success: function(localResponse) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลแล้ว!',
                                text: 'ข้อมูลของคุณถูกลบเรียบร้อยแล้ว',
                                confirmButtonColor: '#15a362'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลออกจากฐานข้อมูลได้',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                });
            }
        });
    }

    function updateExamStatus(id, status) {
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminExamSchedule/update_status') ?>',
            type: 'POST',
            data: { id: id, status: status },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'อัปเดตสถานะการแสดงผลแล้ว'
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถอัปเดตสถานะได้' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
            }
        });
    }

    // Form Submit Handler
    $('#examScheduleForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const fileInput = $('#exam_filename')[0];
        const saveBtn = $('#saveButton');
        const originalBtnHtml = saveBtn.html();

        if (fileInput.files.length === 0) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'กรุณาเลือกไฟล์ที่ต้องการอัปโหลด', confirmButtonColor: '#dc3545' });
            return;
        }

        const file = fileInput.files[0];
        const fileExt = file.name.split('.').pop().toLowerCase();

        // Loading state on button
        saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>กำลังประมวลผล...');

        Swal.fire({
            title: 'กำลังประมวลผลไฟล์...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-2">หากเป็นไฟล์ PDF ระบบกำลังแปลงเป็นรูปภาพ...</p></div>',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        // Function to trim whitespace from canvas
        function trimCanvas(canvas) {
            const context = canvas.getContext('2d');
            const width = canvas.width;
            const height = canvas.height;
            const imgData = context.getImageData(0, 0, width, height);
            const pixels = imgData.data;

            let minX = width, minY = height, maxX = 0, maxY = 0;
            let found = false;

            // Process pixels to find content boundaries (non-white pixels)
            for (let y = 0; y < height; y++) {
                for (let x = 0; x < width; x++) {
                    const index = (y * width + x) * 4;
                    const r = pixels[index];
                    const g = pixels[index + 1];
                    const b = pixels[index + 2];
                    // PDF renders on white (255,255,255). 
                    // Threshold 253 to account for anti-aliasing.
                    if (r < 253 || g < 253 || b < 253) {
                        if (x < minX) minX = x;
                        if (x > maxX) maxX = x;
                        if (y < minY) minY = y;
                        if (y > maxY) maxY = y;
                        found = true;
                    }
                }
            }

            if (!found) return canvas;

            // Add slight padding
            const padding = 15;
            minX = Math.max(0, minX - padding);
            minY = Math.max(0, minY - padding);
            maxX = Math.min(width, maxX + padding);
            maxY = Math.min(height, maxY + padding);

            const cropWidth = maxX - minX;
            const cropHeight = maxY - minY;

            const croppedCanvas = document.createElement('canvas');
            croppedCanvas.width = cropWidth;
            croppedCanvas.height = cropHeight;
            const croppedContext = croppedCanvas.getContext('2d');
            
            // Fill background with white for the JPEG
            croppedContext.fillStyle = '#FFFFFF';
            croppedContext.fillRect(0, 0, cropWidth, cropHeight);
            croppedContext.drawImage(canvas, minX, minY, cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);
            
            return croppedCanvas;
        }

        // Function to perform the actual upload
        const performUpload = (blob, fileName) => {
            const remoteUploadFormData = new FormData();
            remoteUploadFormData.append('file', blob, fileName);
            remoteUploadFormData.append('path', UPLOAD_PATH);
            remoteUploadFormData.append('filename', fileName);

            $.ajax({
                url: UPLOAD_URL,
                type: 'POST',
                data: remoteUploadFormData,
                processData: false,
                contentType: false,
                dataType: 'json', 
                success: function(uploadResponse) {
                    if (uploadResponse.status === 'success' && uploadResponse.filename) {
                        const remoteFileName = uploadResponse.filename;

                        const localFormData = new FormData(form);
                        localFormData.delete('exam_filename');
                        localFormData.append('exam_filename', remoteFileName);

                        $.ajax({
                            url: $(form).attr('action'),
                            type: 'POST',
                            data: localFormData,
                            processData: false,
                            contentType: false,
                            dataType: 'json', 
                            success: function(localResponse) {
                                if (localResponse.success) {
                                    $('#examScheduleModal').modal('hide');
                                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: 'บันทึกข้อมูลเรียบร้อยแล้ว', confirmButtonColor: '#15a362' }).then(() => location.reload());
                                } else {
                                    Swal.fire({ icon: 'error', title: 'บันทึกข้อมูลไม่สำเร็จ!', html: localResponse.message || 'กรุณาลองใหม่อีกครั้ง', confirmButtonColor: '#dc3545' });
                                    deleteRemoteFile(remoteFileName, UPLOAD_PATH);
                                    saveBtn.prop('disabled', false).html(originalBtnHtml);
                                }
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล', confirmButtonColor: '#dc3545' });
                                deleteRemoteFile(remoteFileName, UPLOAD_PATH);
                                saveBtn.prop('disabled', false).html(originalBtnHtml);
                            }
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'อัปโหลดไฟล์ไม่สำเร็จ!', text: uploadResponse.message || 'กรุณาลองใหม่อีกครั้ง', confirmButtonColor: '#dc3545' });
                        saveBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์อัปโหลดได้', confirmButtonColor: '#dc3545' });
                    saveBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        };

        if (fileExt === 'pdf') {
            // Convert PDF to Image
            const reader = new FileReader();
            reader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                    // Get first page
                    pdf.getPage(1).then(function(page) {
                        const viewport = page.getViewport({ scale: 2.0 }); // Higher scale for better quality
                        const canvas = document.getElementById('pdf-canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(function() {
                            const trimmedCanvas = trimCanvas(canvas);
                            trimmedCanvas.toBlob(function(blob) {
                                const newFileName = Date.now() + '-' + file.name.replace('.pdf', '.jpg');
                                performUpload(blob, newFileName);
                            }, 'image/jpeg', 0.9);
                        });
                    });
                }).catch(function(error) {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ไม่สามารถอ่านไฟล์ PDF ได้: ' + error.message, confirmButtonColor: '#dc3545' });
                    saveBtn.prop('disabled', false).html(originalBtnHtml);
                });
            };
            reader.readAsArrayBuffer(file);
        } else {
            // Already an image
            const uniqueFileName = Date.now() + '-' + file.name;
            performUpload(file, uniqueFileName);
        }
    });

    // File Input Validation
    $('#exam_filename').on('change', function() {
        var file = this.files[0];
        if(file) {
            var fileSize = file.size / 1024 / 1024;
            if(fileSize > 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์มีขนาดใหญ่เกินไป',
                    text: 'กรุณาเลือกไฟล์ขนาดไม่เกิน 5MB',
                    confirmButtonColor: '#dc3545'
                });
                this.value = '';
                return;
            }

            var validExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'];
            var fileExt = file.name.split('.').pop().toLowerCase();
            if (!validExtensions.includes(fileExt)) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์ไม่ถูกต้อง',
                    text: 'รองรับเฉพาะไฟล์ PDF, Excel, Word และรูปภาพเท่านั้น',
                    confirmButtonColor: '#dc3545'
                });
                this.value = '';
                return;
            }
        }
    });
</script>
<?= $this->endSection() ?>