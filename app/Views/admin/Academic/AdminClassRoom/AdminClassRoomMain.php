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
.classroom-dashboard {
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

.welcome-banner .year-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    color: #fff;
    font-weight: 500;
    margin-top: 1rem;
    backdrop-filter: blur(10px);
}

.welcome-banner .year-badge i {
    margin-right: 0.5rem;
}

.welcome-banner .icon-wrapper {
    font-size: 7rem;
    color: rgba(255, 255, 255, 0.15);
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
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

.stat-card.card-primary::before { background: var(--gradient-green); }
.stat-card.card-warning::before { background: linear-gradient(90deg, #ffc107, #ffda44); }
.stat-card.card-info::before { background: linear-gradient(90deg, #17a2b8, #20c997); }
.stat-card.card-success::before { background: var(--gradient-green); }

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
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(-5deg);
}

.stat-icon-wrapper.bg-primary-gradient {
    background: linear-gradient(135deg, #15a362 0%, #128a52 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-warning-gradient {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-info-gradient {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-success-gradient {
    background: linear-gradient(135deg, #15a362 0%, #1bc676 100%);
    color: #fff;
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
    border-bottom: 1px solid rgba(0,0,0,0.05);
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

/* Filter Section */
.filter-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-section label {
    font-weight: 500;
    color: #495057;
    white-space: nowrap;
    margin: 0;
}

.filter-section .form-select {
    min-width: 140px;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-section .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}

/* ===== DataTable Styling ===== */
#tb-classroom {
    width: 100% !important;
}

#tb-classroom thead th {
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

#tb-classroom tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    font-size: 0.95rem;
}

#tb-classroom tbody tr {
    transition: all 0.2s ease;
}

#tb-classroom tbody tr:hover {
    background: rgba(21, 163, 98, 0.04);
}

/* Year Badge */
.year-badge-table {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

.year-badge-table i {
    margin-right: 0.35rem;
    color: var(--primary-green);
}

/* Room Badge */
.room-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
}

.room-badge.badge-head {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    color: #212529;
}

.room-badge.badge-room {
    background: linear-gradient(135deg, #15a362 0%, #128a52 100%);
    color: #fff;
}

.room-badge i {
    margin-right: 0.4rem;
}

/* Teacher Name */
.teacher-name {
    display: flex;
    align-items: center;
}

.teacher-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    color: #6c757d;
    font-size: 1.1rem;
}

.teacher-info .name {
    font-weight: 500;
    color: #212529;
}

.teacher-info .role {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Action Button */
.btn-delete-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.85rem;
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
    border: none;
    transition: all 0.3s ease;
}

.btn-delete-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    color: #fff;
}

.btn-delete-action i {
    margin-right: 0.35rem;
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
#myModal .modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

#myModal .modal-header {
    background: var(--gradient-green);
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

#myModal .modal-header .modal-title {
    color: #fff;
    font-weight: 600;
}

#myModal .modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

#myModal .modal-header .btn-close:hover {
    opacity: 1;
}

#myModal .modal-body {
    padding: 1.5rem;
}

#myModal .modal-footer {
    background: #f8f9fa;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.5rem;
}

#myModal .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

#myModal .form-control,
#myModal .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

#myModal .form-control:focus,
#myModal .form-select:focus {
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

/* ===== Empty State ===== */
.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-state i {
    font-size: 4rem;
    color: #e9ecef;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #6c757d;
    font-weight: 500;
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

<div class="classroom-dashboard">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>
                        <i class="bx bx-building-house me-2"></i>จัดการ<?= isset($title) ? esc($title) : 'ห้องเรียน' ?>
                    </h1>
                    <p>ระบบจัดการห้องเรียน ที่ปรึกษา และหัวหน้าระดับชั้น สำหรับปีการศึกษาปัจจุบัน</p>
                    <div class="year-badge" id="header-selected-year-badge">
                        <i class="bx bx-calendar"></i>ปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="icon-wrapper">
                        <i class="bx bxs-school"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 mb-4">
        <!-- Total Classrooms Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-classrooms"><?= isset($total_classrooms) ? number_format($total_classrooms) : 0 ?></div>
                            <div class="stat-label">ห้องเรียนทั้งหมด</div>
                        </div>
                        <div class="stat-icon-wrapper bg-primary-gradient">
                            <i class="bx bx-chalkboard"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-calendar"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Level Heads Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-level-heads"><?= isset($total_level_heads) ? number_format($total_level_heads) : 0 ?></div>
                            <div class="stat-label">ครูหัวหน้าระดับ</div>
                        </div>
                        <div class="stat-icon-wrapper bg-warning-gradient">
                            <i class="bx bx-crown"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-check-circle"></i>มอบหมายแล้ว
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Advisors Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-advisors"><?= isset($total_advisors) ? number_format($total_advisors) : 0 ?></div>
                            <div class="stat-label">ครูที่ปรึกษา</div>
                        </div>
                        <div class="stat-icon-wrapper bg-info-gradient">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-group"></i>ได้รับมอบหมาย
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Year Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษาที่เลือก</div>
                        </div>
                        <div class="stat-icon-wrapper bg-success-gradient">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-meta">
                        <i class="bx bx-list-check"></i><span id="stat-total-records"><?= isset($total_records) ? number_format($total_records) : 0 ?> รายการทั้งหมด</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card table-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5><i class="bx bx-list-ul me-2"></i>รายการห้องเรียน / ที่ปรึกษา</h5>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="filter-section">
                    <label for="yearFilter"><i class="bx bx-filter-alt me-1"></i>ปีการศึกษา:</label>
                    <select class="form-select form-select-sm" id="yearFilter">
                        <?php if (!empty($years)): ?>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year->Reg_Year ?>" <?= ($year->Reg_Year == $selectedYear) ? 'selected' : '' ?>>
                                    <?= $year->Reg_Year ?>
                                </option>
                            <?php endforeach; ?>
                        <?php elseif(isset($selectedYear)): ?>
                            <option value="<?= $selectedYear ?>" selected><?= $selectedYear ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <button class="btn btn-add-new" style="background: linear-gradient(135deg, #15a362 0%, #128a52 100%); border: none; color: #fff; padding: 0.5rem 1.25rem; border-radius: 10px; font-weight: 600;" id="ModalAddClassRoom" data-bs-toggle="modal" data-bs-target="#myModal">
                    <i class="bx bx-plus-circle me-1"></i>เพิ่ม<?= isset($title) ? esc($title) : '' ?>
                </button>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" class="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tb-classroom">
                    <thead>
                        <tr>
                            <th><i class="bx bx-calendar me-1"></i>ปีการศึกษา</th>
                            <th><i class="bx bx-door-open me-1"></i>ห้องเรียน</th>
                            <th><i class="bx bx-user me-1"></i>ครูที่ปรึกษา / ครูหัวหน้าระดับ</th>
                            <th class="text-center"><i class="bx bx-cog me-1"></i>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tea = []; foreach ($classRoom as $key => $v_classRoom) : 
                            $tea[] = isset($v_classRoom->class_teacher) ? $v_classRoom->class_teacher : '';
                        ?>
                        <tr id="row-<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id) : '' ?>">
                            <td>
                                <span class="year-badge-table">
                                    <i class="bx bx-calendar"></i><?= isset($v_classRoom->Reg_Year) ? esc($v_classRoom->Reg_Year) : '' ?>
                                </span>
                            </td>
                            <td>
                                <?php if(isset($v_classRoom->Reg_Class) && strlen($v_classRoom->Reg_Class) == 1) : ?>
                                    <span class="room-badge badge-head">
                                        <i class="bx bx-crown"></i>หัวหน้าระดับ ม.<?= esc($v_classRoom->Reg_Class) ?>
                                    </span>
                                <?php else : ?>
                                    <span class="room-badge badge-room">
                                        <i class="bx bx-chalkboard"></i>ห้อง ม.<?= isset($v_classRoom->Reg_Class) ? esc($v_classRoom->Reg_Class) : '' ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="teacher-name">
                                    <div class="teacher-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div class="teacher-info">
                                        <div class="name"><?= (isset($v_classRoom->pers_prefix) ? esc($v_classRoom->pers_prefix) : '').(isset($v_classRoom->pers_firstname) ? esc($v_classRoom->pers_firstname) : '').' '.(isset($v_classRoom->pers_lastname) ? esc($v_classRoom->pers_lastname) : '') ?></div>
                                        <div class="role">
                                            <?php if(isset($v_classRoom->Reg_Class) && strlen($v_classRoom->Reg_Class) == 1) : ?>
                                                หัวหน้าระดับ
                                            <?php else : ?>
                                                ครูที่ปรึกษา
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn-delete-action btn-delete" data-id="<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id, 'url') : '' ?>">
                                    <i class="bx bx-trash"></i>ลบ
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-plus-circle me-2"></i>เพิ่ม<?= isset($title) ? esc($title) : '' ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="AddClassRoom" action="#" method="post">
                    <div class="mb-3">
                        <label for="year" class="form-label">
                            <i class="bx bx-calendar me-1"></i>ปีการศึกษา
                        </label>
                        <?php 
                            $activeModalYear = isset($selectedYear) ? $selectedYear : get_selected_year_only();
                            $d = (date('Y')+543)-1; 
                        ?>
                        <select name="year" id="year" class="form-select">
                            <?php for($i=$d; $i<=$d+2; $i++) : ?>
                            <option value="<?= esc($i) ?>" <?= $i == $activeModalYear ? 'selected' : '' ?>><?= esc($i) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="classroom" class="form-label">
                            <i class="bx bx-door-open me-1"></i>ห้องเรียน / ระดับชั้น
                        </label>
                        <select name="classroom" id="classroom" class="form-select" required>
                            <option value="1">หัวหน้าระดับชั้น ม.1</option>
                            <option value="2">หัวหน้าระดับชั้น ม.2</option>
                            <option value="3">หัวหน้าระดับชั้น ม.3</option>
                            <option value="4">หัวหน้าระดับชั้น ม.4</option>
                            <option value="5">หัวหน้าระดับชั้น ม.5</option>
                            <option value="6">หัวหน้าระดับชั้น ม.6</option>
                            <?php 
                            if (!isset($classroom)) {
                                $classroom = new App\Libraries\Classroom();
                            }
                            foreach ($classroom->ListRoom() as $key => $ListRoom) : ?>
                            <option value="<?= esc($ListRoom) ?>">ที่ปรึกษาห้อง <?= esc($ListRoom) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="teacher" class="form-label">
                            <i class="bx bx-user me-1"></i>ครูที่ปรึกษา / ครูหัวหน้าระดับ
                        </label>
                        <select name="teacher" id="teacher" class="form-select" required>
                            <option value=''>-- เลือกครู --</option>
                            <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ยกเลิก
                </button>
                <button type="submit" class="btn btn-save">
                    <i class="bx bx-save me-1"></i>บันทึก
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on('submit', '#AddClassRoom', function (e) {
    e.preventDefault();
    var formadd = $('#AddClassRoom').serialize();
    $.ajax({
        type: 'post',
        url: "<?= site_url('admin/academic/ConAdminClassRoom/AddClassRoom') ?>",
        data: formadd,
        beforeSend: function () {
            Swal.fire({
                title: 'กำลังบันทึก...',
                html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        },
        success: function (result) {
            $('#myModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                text: 'ข้อมูลห้องเรียนถูกเพิ่มเรียบร้อยแล้ว',
                showConfirmButton: true,
                confirmButtonColor: '#15a362',
                confirmButtonText: 'ตกลง'
            }).then((result) => {
                window.location.reload();
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถบันทึกข้อมูลได้',
                confirmButtonColor: '#dc3545'
            });
        }
    });
});

$(document).ready(function () {
    var ta = $('#tb-classroom').DataTable({
        "order": [
            [0, "desc"],
            [1, "asc"]
        ],
        "language": {
            "processing": '<div class="d-flex justify-content-center align-items-center py-4"><div class="spinner-border text-success"></div><span class="ms-3">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "zeroRecords": '<div class="empty-state"><i class="bx bx-folder-open"></i><h5>ไม่พบข้อมูลห้องเรียน</h5><p class="text-muted">กรุณาเพิ่มข้อมูลห้องเรียนใหม่</p></div>',
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "แสดง 0 รายการ",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "paginate": {
                "first": '<i class="bx bx-chevrons-left"></i>',
                "last": '<i class="bx bx-chevrons-right"></i>',
                "next": '<i class="bx bx-chevron-right"></i>',
                "previous": '<i class="bx bx-chevron-left"></i>'
            }
        }
    });

    $('#year').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#classroom').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#teacher').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
});

$('#yearFilter').on('change', function() {
    var year = $(this).val();
    if(year) {
        window.location.href = '<?= site_url('Admin/Acade/Registration/ClassRoom/') ?>' + year;
    }
});

$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= site_url('admin/academic/ConAdminClassRoom/DeleteClassRoom/') ?>' + id;
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    Swal.fire({
        title: 'ยืนยันการลบ',
        text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",
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
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(response) {
                    $('.csrf_token').val(response.csrf_hash);
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ!',
                            text: response.message,
                            confirmButtonColor: '#15a362'
                        });
                        $('#row-' + id).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด!',
                            text: response.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
