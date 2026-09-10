<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<?php 
$ExYearClub = $CheckOnoffClubParsed ?? [(date('Y')+543), '1'];
$studentStatus = $StatusOnoffClubStudent ?? 'ปิด';
$teacherStatus = $StatusOnoffClubTeacher ?? 'ปิด';

// Helper for status styling
$getStatusConfig = function($status) {
    if ($status == "เปิด") {
        return [
            'class' => 'success',
            'bg' => 'bg-label-success',
            'icon' => 'bx-check-double',
            'label' => 'เปิดระบบ'
        ];
    }
    return [
        'class' => 'danger',
        'bg' => 'bg-label-danger',
        'icon' => 'bx-power-off',
        'label' => 'ปิดระบบ'
    ];
};

$stdCfg = $getStatusConfig($studentStatus);
$tchCfg = $getStatusConfig($teacherStatus);
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- 1. Page Header & Primary Actions -->
    <div class="d-flex align-items-md-center justify-content-between mb-4 flex-column flex-md-row gap-3">
        <div>
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ /</span> กิจกรรมพัฒนาผู้เรียน
            </h4>
            <div class="text-muted small">ศูนย์ควบคุมและบริหารจัดการกิจกรรมชุมนุม และกิจกรรมลูกเสือ - เนตรนารี</div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button class="btn btn-outline-success border-2 fw-semibold px-3 py-2 shadow-sm" type="button" id="MenuSetDateAttendancer">
                <i class="bx bx-calendar-event me-1"></i> ตารางเวลาเช็คชื่อ (พ.ศ.)
            </button>
            <button class="btn btn-outline-primary border-2 fw-semibold px-3 py-2 shadow-sm" type="button" id="MenuSetYear">
                <i class="bx bx-calendar me-1"></i> ปีการศึกษาที่ใช้งาน
            </button>
            <button class="btn btn-outline-danger border-2 fw-semibold px-3 py-2 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalClubSystemSettings">
                <i class="bx bx-power-off me-1"></i> ปิดปรับปรุงระบบ
            </button>
        </div>
    </div>

    <!-- 2. Hero Context Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm position-relative overflow-hidden" 
                 style="background: <?= ($isViewingHistory ?? false) ? 'linear-gradient(135deg, #4b6584 0%, #2f3542 100%)' : 'linear-gradient(135deg, #15a362 0%, #0d6e42 100%)' ?>; min-height: 110px; border-radius: 16px;">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between flex-column flex-md-row gap-3">
                        <div class="d-flex align-items-center text-white">
                            <div class="avatar avatar-lg me-3 flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-white text-success shadow" style="color: #15a362 !important; width: 54px; height: 54px;">
                                    <i class="bx <?= ($isViewingHistory ?? false) ? 'bx-history' : 'bxs-graduation' ?> fs-2"></i>
                                </span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                    <h4 class="mb-0 text-white fw-bold">
                                        ภาคเรียนที่ <?= esc($filterTerm) ?> / ปีการศึกษา <?= esc($filterYear) ?>
                                    </h4>
                                    <?php if ($isViewingHistory ?? false): ?>
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="bx bx-history me-1"></i>โหมดย้อนหลัง</span>
                                    <?php else: ?>
                                        <span class="badge bg-white text-success px-2 py-1 shadow-sm fw-bold"><i class="bx bx-check-circle me-1"></i>ภาคเรียนปัจจุบัน</span>
                                    <?php endif; ?>
                                </div>
                                <p class="mb-0 text-white opacity-75 small">
                                    <?= ($isViewingHistory ?? false) 
                                        ? 'กำลังดูสถิติย้อนหลัง (ปัจจุบันคือ ภาคเรียนที่ ' . esc($CheckOnoffClubParsed[1]) . '/' . esc($CheckOnoffClubParsed[0]) . ')' 
                                        : 'สถานะภาพรวมและกำหนดการลงทะเบียนประจำภาคเรียนของโรงเรียน' ?>
                                </p>
                            </div>
                        </div>

                        <!-- Year/Term Selector -->
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-merge shadow-sm" style="min-width: 240px;">
                                <span class="input-group-text bg-white border-0 text-muted"><i class="bx bx-filter-alt"></i></span>
                                <select class="form-select bg-white border-0 fw-semibold text-dark shadow-sm" id="filterYearTerm" style="cursor: pointer; border-radius: 0 8px 8px 0;">
                                    <?php if (!empty($YearAll)): ?>
                                        <?php foreach ($YearAll as $yt): ?>
                                            <option value="<?= esc($yt['club_year']) ?>|<?= esc($yt['club_trem']) ?>"
                                                <?= ($yt['club_year'] == $filterYear && $yt['club_trem'] == $filterTerm) ? 'selected' : '' ?>>
                                                ภาคเรียนที่ <?= esc($yt['club_trem']) ?> / <?= esc($yt['club_year']) ?>
                                                <?= ($yt['club_year'] == $CheckOnoffClubParsed[0] && $yt['club_trem'] == $CheckOnoffClubParsed[1]) ? ' ★ ล่าสุด' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <?php if ($isViewingHistory ?? false): ?>
                                <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="btn btn-sm btn-light text-dark fw-bold text-nowrap shadow-sm px-3">
                                    <i class="bx bx-arrow-back me-1"></i>กลับปัจจุบัน
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Subtle Background Icon Decoration -->
                <div class="position-absolute top-50 end-0 translate-middle-y opacity-15 pe-4 d-none d-lg-block pointer-events-none" style="pointer-events: none;">
                    <i class="bx <?= ($isViewingHistory ?? false) ? 'bx-history' : 'bx-compass' ?> text-white" style="font-size: 9rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Quick Action Navigation Hub (4 เมนูหลัก แยกสัดส่วนชัดเจน) -->
    <div class="row g-3 mb-4">
        <!-- 3.1 จัดการชุมนุม -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm modern-action-card border-start border-4 border-success">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-extension fs-3"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">จัดการชุมนุม</h6>
                                    <small class="text-muted">สร้าง/แก้ไข/รับสมาชิก</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-right fs-3 text-muted action-arrow"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3.2 จัดการลูกเสือ -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Scout/All') ?>" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm modern-action-card border-start border-4 border-success">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-compass fs-3 text-success"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">จัดการลูกเสือ</h6>
                                    <small class="text-muted">กองลูกเสือ - เนตรนารี</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-right fs-3 text-muted action-arrow"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3.3 รายงานชุมนุม -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Report') ?>" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm modern-action-card border-start border-4 border-info">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="bx bx-bar-chart-alt-2 fs-3"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">รายงานผลชุมนุม</h6>
                                    <small class="text-muted">เช็คชื่อ & ผลประเมิน</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-right fs-3 text-muted action-arrow"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3.4 รายงานลูกเสือ -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Scout/Report') ?>" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm modern-action-card border-start border-4 border-primary">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-check-shield fs-3"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">รายงานผลลูกเสือ</h6>
                                    <small class="text-muted">ผลประเมิน & เวลาเรียน</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-right fs-3 text-muted action-arrow"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- 4. KPI Metrics Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Metric 1: ชุมนุมทั้งหมด -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 metric-kpi-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase">ชุมนุมที่เปิดสอน</span>
                        <span class="badge bg-label-success rounded-pill px-2 py-1"><i class="bx bx-book-open me-1"></i>ชุมนุม</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="mb-0 fw-bold text-dark"><?= count($TotalClubs ?? []) ?></h2>
                        <small class="text-muted">ชุมนุม</small>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">ประจำภาคเรียนนี้</small>
                        <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>" class="small fw-semibold text-success text-decoration-none">ดูทั้งหมด &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric 2: นักเรียนลงทะเบียนแล้ว -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 metric-kpi-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase">นักเรียนลงทะเบียน</span>
                        <span class="badge bg-label-info rounded-pill px-2 py-1"><i class="bx bx-group me-1"></i>สมาชิก</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="mb-0 fw-bold text-info"><?= number_format($TotalStudent[0]->StudentAll ?? 0) ?></h2>
                        <small class="text-muted">คน</small>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">อัปเดตข้อมูลล่าสุด</small>
                        <a href="<?= base_url('admin/academic/develop-students/student-registrations') ?>" class="small fw-semibold text-info text-decoration-none">ตรวจสอบ &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric 3: ครูที่ปรึกษา / ผู้กำกับ -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 metric-kpi-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase">ครูที่ปรึกษา / ผู้กำกับ</span>
                        <span class="badge bg-label-success rounded-pill px-2 py-1"><i class="bx bx-user-voice me-1"></i>ครูผู้สอน</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="mb-0 fw-bold text-success"><?= number_format($TotalTeacher[0]->total_advisors ?? 0) ?></h2>
                        <small class="text-muted">ท่าน</small>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">มีรายชื่อรับผิดชอบ</small>
                        <span class="badge bg-label-secondary small">ปฏิบัติหน้าที่</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric 4: ชุมนุมยอดนิยม -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 metric-kpi-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold text-uppercase">ยอดนิยมอันดับ 1</span>
                        <span class="badge bg-label-danger rounded-pill px-2 py-1"><i class="bx bxs-hot me-1"></i>ยอดนิยม</span>
                    </div>
                    <h5 class="mb-1 fw-bold text-dark text-truncate" title="<?= esc($ClubPopula->club_name ?? 'ไม่มีข้อมูล') ?>">
                        <?= esc($ClubPopula->club_name ?? 'ไม่มีข้อมูล') ?>
                    </h5>
                    <div class="d-flex align-items-baseline gap-1">
                        <span class="fw-bold text-danger fs-5"><?= $ClubPopula->total_members ?? 0 ?></span>
                        <small class="text-muted">คนเข้าร่วม</small>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">สมาชิกสูงสุด</small>
                        <i class="bx bx-trending-up text-danger fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. System Control & Registration Schedules (จัดสัดส่วนเปิด/ปิดระบบ) -->
    <div class="row g-4">
        <!-- 5.1 Student Registration Schedule -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 system-control-card">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded bg-label-<?= $stdCfg['class'] ?> me-3">
                            <i class="bx bx-calendar-event fs-4 text-<?= $stdCfg['class'] ?>"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">กำหนดการลงทะเบียน (นักเรียน)</h6>
                            <small class="text-muted">เปิด/ปิดให้นักเรียนเลือกชุมนุมตามช่วงเวลา</small>
                        </div>
                    </div>
                    <span class="badge bg-label-<?= $stdCfg['class'] ?> px-3 py-2 fw-bold rounded-pill">
                        <i class="bx <?= $stdCfg['icon'] ?> me-1"></i><?= $stdCfg['label'] ?>
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 rounded bg-light border-0 d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-white rounded shadow-sm d-flex align-items-center justify-content-center">
                                    <i class="bx bx-play-circle text-success fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">วันที่เริ่มลงทะเบียน</small>
                                    <span class="fw-bold text-dark"><?= $formatted_student_regisstart ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded bg-light border-0 d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-white rounded shadow-sm d-flex align-items-center justify-content-center">
                                    <i class="bx bx-stop-circle text-danger fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">วันที่สิ้นสุดลงทะเบียน</small>
                                    <span class="fw-bold text-dark"><?= $formatted_student_regisend ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-success w-100 fw-bold py-2 border-2" data-bs-toggle="modal" data-bs-target="#modalClubStudentSettings" style="border-color: #15a362; color: #15a362;">
                        <i class="bx bx-slider-alt me-1"></i> ตั้งค่าช่วงเวลาและเปิด/ปิดระบบนักเรียน
                    </button>
                </div>
            </div>
        </div>

        <!-- 5.2 Teacher Management Schedule -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 system-control-card">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded bg-label-<?= $tchCfg['class'] ?> me-3">
                            <i class="bx bx-user-check fs-4 text-<?= $tchCfg['class'] ?>"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">กำหนดการเข้าถึงข้อมูล (ครูที่ปรึกษา)</h6>
                            <small class="text-muted">เปิด/ปิดให้ครูเข้ามาจัดการข้อมูลและเช็คชื่อ</small>
                        </div>
                    </div>
                    <span class="badge bg-label-<?= $tchCfg['class'] ?> px-3 py-2 fw-bold rounded-pill">
                        <i class="bx <?= $tchCfg['icon'] ?> me-1"></i><?= $tchCfg['label'] ?>
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 rounded bg-light border-0 d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-white rounded shadow-sm d-flex align-items-center justify-content-center">
                                    <i class="bx bx-play-circle text-info fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">วันที่เริ่มจัดการข้อมูล</small>
                                    <span class="fw-bold text-dark"><?= $formatted_teacher_regisstart ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded bg-light border-0 d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-white rounded shadow-sm d-flex align-items-center justify-content-center">
                                    <i class="bx bx-stop-circle text-danger fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">วันที่สิ้นสุดจัดการข้อมูล</small>
                                    <span class="fw-bold text-dark"><?= $formatted_teacher_regisend ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-info w-100 fw-bold py-2 border-2" data-bs-toggle="modal" data-bs-target="#modalClubTeacherSettings">
                        <i class="bx bx-slider-alt me-1"></i> ตั้งค่าช่วงเวลาและเปิด/ปิดระบบสำหรับครู
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern UX/UI Styles for Develop Students Main */
.modern-action-card {
    transition: all 0.25s ease;
    border-radius: 12px;
}
.modern-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.08) !important;
}
.modern-action-card:hover .action-arrow {
    transform: translateX(4px);
    color: #15a362 !important;
    transition: all 0.2s ease;
}
.metric-kpi-card {
    border-radius: 14px;
    transition: all 0.25s ease;
}
.metric-kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.06) !important;
}
.system-control-card {
    border-radius: 14px;
}
.bg-label-success { background-color: #e8fadf !important; color: #15a362 !important; }
.bg-label-warning { background-color: #fff2d6 !important; color: #ff9f43 !important; }
.bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
.bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
.bg-label-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
</style>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetYear.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateAttendance.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/_modalClubsSetting.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Add global SweetAlert2 z-index fix
    $('head').append('<style>.swal2-container { z-index: 99999 !important; }</style>');

    // Year/Term Filter Handler
    $('#filterYearTerm').on('change', function() {
        const val = $(this).val().split('|');
        const year = val[0];
        const term = val[1];
        window.location.href = '<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>?year=' + encodeURIComponent(year) + '&term=' + encodeURIComponent(term);
    });

    // Reload page when specific setting modals are closed to refresh dashboard stats
    $('#ModalClubSetYear, #modalClubStudentSettings, #modalClubTeacherSettings, #modalClubSystemSettings').on('hidden.bs.modal', function() {
        window.location.reload();
    });

    // Helper ฟังก์ชันแปลงปีใน Flatpickr ให้เป็น พ.ศ.
    function updateCalendarToBE(instance) {
        setTimeout(() => {
            const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
            if (yearDisplay) {
                const year = parseInt(instance.currentYear);
                if (year < 2400) {
                    if (yearDisplay.tagName === "INPUT") yearDisplay.value = year + 543;
                    else yearDisplay.textContent = year + 543;
                }
            }
            const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
            if (yearInput && parseInt(instance.currentYear) < 2400) {
                yearInput.value = parseInt(instance.currentYear) + 543;
            }
        }, 5);
    }

    // Initialize datepickers inside any of the setting modals when shown (ปฏิทินไทย พ.ศ.)
    $('#modalClubStudentSettings, #modalClubTeacherSettings, #modalClubSystemSettings').on('shown.bs.modal', function () {
        flatpickr(".club-onoff-datepicker", {
            disableMobile: true,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            locale: "th",
            allowInput: true,
            onOpen: (s, d, i) => updateCalendarToBE(i),
            onMonthChange: (s, d, i) => updateCalendarToBE(i),
            onYearChange: (s, d, i) => updateCalendarToBE(i),
            formatDate: (date, format) => {
                if (format === "d/m/Y") {
                    const y = date.getFullYear() + 543;
                    return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${y}`;
                }
                return flatpickr.formatDate(date, format);
            },
            parseDate: (dateStr) => {
                if (dateStr && dateStr.includes('/')) {
                    const p = dateStr.split('/');
                    return new Date(parseInt(p[2]) - 543, parseInt(p[1]) - 1, parseInt(p[0]));
                }
                return flatpickr.parseDate(dateStr, "Y-m-d");
            },
            onChange: function(selectedDates, dateStr, instance) {
                const target = $(instance.element).data('target');
                const startDateInput = $(`.club-onoff-datepicker[data-target='${target}'][data-type='start']`);
                const endDateInput = $(`.club-onoff-datepicker[data-target='${target}'][data-type='end']`);
                const startDate = startDateInput.val();
                const endDate = endDateInput.val();

                if (startDate && endDate && startDate > endDate) {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'วันที่สิ้นสุดต้องอยู่หลังวันที่เริ่มต้น' });
                    return;
                }

                $.ajax({
                    url: '<?= site_url('admin/academic/developstudents/update_onoff_dates') ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        target: target,
                        startDate: startDate,
                        endDate: endDate
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                            Toast.fire({ icon: 'success', title: 'บันทึกวันที่แล้ว' });
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                        }
                    }
                });
            }
        });
    });

    // Handle On/Off toggles
    $(document).on('change', '.club-onoff-toggle', function() {
        const checkbox = $(this);
        const target = checkbox.data('target');
        const isChecked = checkbox.is(':checked');
        const status = isChecked ? 1 : 0;
        const statusTextElement = $(`#${target}-status-text`);
        
        let newStatusText, title, text;
        if (target === 'system') {
            newStatusText = isChecked ? 'ปิดปรับปรุง' : 'ออนไลน์ปกติ';
            title = isChecked ? 'ยืนยันการปิดปรับปรุงระบบ?' : 'ยืนยันการเปิดระบบ?';
            text = isChecked ? 'ผู้ใช้ปกติจะไม่สามารถเข้าใช้งานได้' : 'ผู้ใช้จะสามารถใช้งานได้ตามปกติ';
        } else {
            newStatusText = isChecked ? 'เปิดระบบ' : 'ปิดระบบ';
            const targetThai = target === 'student' ? 'นักเรียน' : 'ครู';
            title = `ยืนยันการ${newStatusText}สำหรับ${targetThai}?`;
            text = `ระบบสำหรับ ${targetThai} จะถูก ${newStatusText}`;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/developstudents/update_onoff_status') ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        target: target,
                        status: status,
                        year: '<?= esc($current_year) ?>',
                        term: '<?= esc($current_term) ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            statusTextElement.text(newStatusText);
                            statusTextElement.removeClass('bg-label-success bg-label-danger bg-success bg-danger');
                            if (target === 'system') {
                                statusTextElement.addClass(isChecked ? 'badge bg-danger' : 'badge bg-success');
                            } else {
                                statusTextElement.addClass(isChecked ? 'badge bg-label-success' : 'badge bg-label-danger');
                            }
                            Swal.fire({ icon: 'success', title: 'สำเร็จ!', timer: 1500, showConfirmButton: false });
                        } else {
                            checkbox.prop('checked', !isChecked);
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message });
                        }
                    },
                    error: function() {
                        checkbox.prop('checked', !isChecked);
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'การเชื่อมต่อเซิร์ฟเวอร์ขัดข้อง' });
                    }
                });
            } else { checkbox.prop('checked', !isChecked); }
        });
    });

    // Academic Year Handlers
    $(document).on('click', '#MenuSetYear', function () { $('#ModalClubSetYear').modal('show'); });
    $(document).on('click', '#MenuSetDateAttendancer', function () { 
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    loadWeeksData();
                    $('#ClubSetDateAttendance').modal('show');
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถเริ่มต้นตั้งค่าตารางเช็คชื่อได้' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
            }
        });
    });

    // Handle Weeks / Attendance Data (กำหนดเวลาเรียนชุมนุม ปฏิทินไทย พ.ศ. แสดงผลแบบ 2 คอลัมน์กระชับ)
    function loadWeeksData() {
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let rows1 = '';
                let rows2 = '';
                let totalWeeks = 0;
                let openWeeks = 0;

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    totalWeeks = response.data.length;
                    const half = Math.ceil(totalWeeks / 2);

                    response.data.forEach(function (week, index) {
                        let checked = (week.tcs_week_status == "เปิด") ? "checked" : "";
                        if (week.tcs_week_status == "เปิด") openWeeks++;

                        let rowHtml = `<tr id="week-row-${week.tcs_schedule_id}" class="${checked ? '' : 'table-light opacity-75'}">
                            <td class="text-center fw-bold py-1">
                                <span class="badge ${checked ? 'bg-label-success' : 'bg-label-secondary'} px-2 py-0.5" style="font-size: 0.775rem;">สัปดาห์ ${index + 1}</span>
                            </td>
                            <td class="py-1">
                                <div class="input-group input-group-merge input-group-sm">
                                    <span class="input-group-text py-0 px-2"><i class="bx bx-calendar text-success" style="font-size: 0.9rem;"></i></span>
                                    <input type="text" class="form-control form-control-sm tcs_academic_year py-1" id="tcs_academic_year${index + 1}" data-id="${week.tcs_schedule_id}" value="${week.tcs_start_date || ''}" placeholder="วว/ดด/ปปปป">
                                </div>
                            </td>
                            <td class="text-center py-1">
                                <div class="form-check form-switch d-flex justify-content-center mb-0">
                                    <input class="form-check-input status-btn" type="checkbox" data-status="${week.tcs_week_status}" data-id="${week.tcs_schedule_id}" ${checked}>
                                </div>
                            </td>
                        </tr>`;

                        if (index < half) {
                            rows1 += rowHtml;
                        } else {
                            rows2 += rowHtml;
                        }
                    });

                    $('#part1Label').html(`<i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ 1 - ${half}`);
                    $('#part2Label').html(`<i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ ${half + 1} - ${totalWeeks}`);
                } else {
                    rows1 = '<tr><td colspan="3" class="text-center py-3 text-muted small">ไม่มีข้อมูลสัปดาห์</td></tr>';
                    rows2 = '<tr><td colspan="3" class="text-center py-3 text-muted small">-</td></tr>';
                }

                $('#TbDateWeeksCol1 tbody').html(rows1);
                $('#TbDateWeeksCol2 tbody').html(rows2);
                $('#TbDateWeeks tbody').html(rows1 + rows2);

                // Update Counters
                $('#countWeeksTotal').text(totalWeeks);
                $('#countWeeksOpen').text(openWeeks);
                $('#countWeeksClosed').text(totalWeeks - openWeeks);

                // ผูก Flatpickr ปฏิทินไทย พ.ศ. ให้กับช่องวันที่เรียนทุกสัปดาห์
                initWeeksFlatpickr();
            }
        });
    }
    loadWeeksData();

    // ฟังก์ชันผูก Flatpickr ปฏิทินไทย พ.ศ. สำหรับตารางสัปดาห์เรียนชุมนุม
    function initWeeksFlatpickr() {
        $(".tcs_academic_year").flatpickr({
            disableMobile: true,
            dateFormat: "Y-m-d", // ส่งค่า ค.ศ. ISO ให้ Backend เพื่อบันทึกลง tb_club_settings_schedule
            altInput: true,      // แสดงผลแบบ พ.ศ. ให้ผู้ใช้เห็น
            altFormat: "d/m/Y",  // รูปแบบ วัน/เดือน/ปี พ.ศ.
            locale: "th",
            allowInput: true,
            onOpen: (s, d, i) => updateCalendarToBE(i),
            onMonthChange: (s, d, i) => updateCalendarToBE(i),
            onYearChange: (s, d, i) => updateCalendarToBE(i),
            formatDate: (date, format) => {
                if (format === "d/m/Y") {
                    const y = date.getFullYear() + 543;
                    return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${y}`;
                }
                return flatpickr.formatDate(date, format);
            },
            parseDate: (dateStr) => {
                if (dateStr && dateStr.includes('/')) {
                    const p = dateStr.split('/');
                    return new Date(parseInt(p[2]) - 543, parseInt(p[1]) - 1, parseInt(p[0]));
                }
                return flatpickr.parseDate(dateStr, "Y-m-d");
            },
            onChange: function(selectedDates, dateStr, instance) {
                const id = $(instance.element).data('id');
                if (!dateStr || !id) return;

                $.ajax({
                    url: '<?= site_url('admin/academic/developstudents/update_schedule') ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        id: id,
                        date: dateStr
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                            Toast.fire({ icon: 'success', title: 'บันทึกวันที่แล้ว' });
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
                    }
                });
            }
        });
    }

    // Save status when toggled
    $(document).on('change', '.status-btn', function() {
        const checkbox = $(this);
        const id = checkbox.data('id');
        const currentStatus = checkbox.data('status');
        const newStatus = (currentStatus === 'เปิด') ? 'ปิด' : 'เปิด';

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus') ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                id: id,
                status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    checkbox.data('status', newStatus);
                    const row = checkbox.closest('tr');
                    if (newStatus === 'เปิด') {
                        row.removeClass('table-light opacity-75');
                        row.find('.badge').removeClass('bg-label-secondary').addClass('bg-label-success');
                    } else {
                        row.addClass('table-light opacity-75');
                        row.find('.badge').removeClass('bg-label-success').addClass('bg-label-secondary');
                    }
                    const total = $('.status-btn').length;
                    const open = $('.status-btn:checked').length;
                    $('#countWeeksOpen').text(open);
                    $('#countWeeksClosed').text(total - open);

                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: 'อัปเดตสถานะสำเร็จ' });
                } else {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                }
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ' });
            }
        });
    });

    // Handle Year Form AJAX submission
    $(document).on('submit', '#FormClubSetOnoffYear', function (e) {
        e.preventDefault();
        const c_onoff_term = $('#c_onoff_term').val();
        const c_onoff_year = $('#c_onoff_year').val();

        if (!c_onoff_term || !c_onoff_year) {
            Swal.fire({ icon: 'warning', title: 'แจ้งเตือน', text: 'กรุณากรอกข้อมูลให้ครบถ้วน' });
            return;
        }

        const $btn = $(this).find('button[type="submit"]');
        const origHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubSetOnoffYear') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                c_onoff_term: c_onoff_term,
                c_onoff_year: c_onoff_year
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#ModalClubSetYear').modal('hide');
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: response.message,
                        icon: "success",
                    }).then((result) => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: "error", title: "ผิดพลาด!", text: response.message });
                }
            },
            error: function () {
                Swal.fire({ icon: "error", title: "ผิดพลาด!", text: "เกิดข้อผิดพลาดในการบันทึกข้อมูล" });
            },
            complete: function () {
                $btn.prop('disabled', false).html(origHtml);
            }
        });
    });

    // Prevent traditional submit on Attendance Form
    $(document).on('submit', '#FormClubSetDateAttendance', function (e) {
        e.preventDefault();
        $('#ClubSetDateAttendance').modal('hide');
    });

});
</script>
<?= $this->endSection() ?>

