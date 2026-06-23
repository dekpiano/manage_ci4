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
    <!-- Page Header & Main Actions -->
    <div class="d-flex align-items-md-center justify-content-between mb-4 flex-column flex-md-row gap-3">
        <div>
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน /</span> ระบบชุมนุม
            </h4>
            <div class="text-muted small">จัดการข้อมูลสถานะและกำหนดการลงทะเบียน</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="dropdown">
                <button class="btn btn-primary shadow-sm px-4 py-2 fw-bold" type="button" id="clubSettingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-cog me-1"></i> ตั้งค่าการลงทะเบียนและระบบ
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="clubSettingsDropdown">
                    <li class="dropdown-header text-uppercase small fw-bold text-primary">การตั้งค่าหลัก</li>
                    <li><a class="dropdown-item py-2" href="javascript:void(0)" id="MenuSetYear"><i class="bx bx-calendar me-2"></i>ปีการศึกษาที่ใช้งาน</a></li>
                    <li><a class="dropdown-item py-2" href="javascript:void(0)" id="MenuSetDateAttendancer"><i class="bx bx-time-five me-2"></i>ตารางเวลาเช็คชื่อ</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-header text-uppercase small fw-bold text-danger">การเข้าถึงระบบ</li>
                    <li><a class="dropdown-item py-2 text-danger fw-semibold" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalClubSystemSettings"><i class="bx bx-toggle-right me-2"></i>เปิด/ปิด การใช้งานระบบ (ครู/นักเรียน)</a></li>
                </ul>
            </div>
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Report') ?>" class="btn btn-info shadow-sm px-4 py-2 fw-bold">
                <i class="bx bx-bar-chart-alt-2 me-1"></i> รายงานผลชุมนุม
            </a>
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>" class="btn btn-warning shadow-sm px-4 py-2 fw-bold">
                <i class="bx bx-list-check me-1"></i> จัดการชุมนุมทั้งหมด
            </a>
        </div>
    </div>

    <!-- Summary Banner with Year/Term Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card <?= ($isViewingHistory ?? false) ? 'bg-secondary' : 'bg-primary' ?> bg-gradient border-0 shadow-sm position-relative overflow-hidden" style="min-height: 100px;">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between flex-column flex-md-row gap-3">
                        <div class="d-flex align-items-center text-white">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded bg-white <?= ($isViewingHistory ?? false) ? 'text-secondary' : 'text-primary' ?> shadow-sm">
                                    <i class="bx <?= ($isViewingHistory ?? false) ? 'bx-history' : 'bxs-graduation' ?> fs-3"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0 text-white fw-bold">
                                    ปีการศึกษา <?= esc($filterYear) ?> ภาคเรียนที่ <?= esc($filterTerm) ?>
                                </h4>
                                <p class="mb-0 opacity-75">
                                    <?php if ($isViewingHistory ?? false): ?>
                                        <i class="bx bx-info-circle me-1"></i>กำลังดูข้อมูลย้อนหลัง (ปัจจุบัน: <?= esc($CheckOnoffClubParsed[0]) ?>/<?= esc($CheckOnoffClubParsed[1]) ?>)
                                    <?php else: ?>
                                        สถานะและกำหนดการลงทะเบียนชุมนุมประจำภาคเรียน
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <!-- Year/Term Filter -->
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="min-width: 250px;">
                                <span class="input-group-text bg-white border-0 text-muted"><i class="bx bx-filter-alt"></i></span>
                                <select class="form-select form-select-sm bg-white border-0 fw-semibold text-dark shadow-sm" id="filterYearTerm" style="cursor: pointer;">
                                    <?php if (!empty($YearAll)): ?>
                                        <?php foreach ($YearAll as $yt): ?>
                                            <option value="<?= esc($yt['club_year']) ?>|<?= esc($yt['club_trem']) ?>"
                                                <?= ($yt['club_year'] == $filterYear && $yt['club_trem'] == $filterTerm) ? 'selected' : '' ?>>
                                                ปี <?= esc($yt['club_year']) ?> / เทอม <?= esc($yt['club_trem']) ?>
                                                <?= ($yt['club_year'] == $CheckOnoffClubParsed[0] && $yt['club_trem'] == $CheckOnoffClubParsed[1]) ? ' ★ ปัจจุบัน' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <?php if ($isViewingHistory ?? false): ?>
                                <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="btn btn-sm btn-light fw-bold text-nowrap shadow-sm">
                                    <i class="bx bx-arrow-back me-1"></i>กลับปัจจุบัน
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Abstract Decor -->
                <div class="position-absolute top-50 end-0 translate-middle-y opacity-25 pe-5">
                    <i class="bx <?= ($isViewingHistory ?? false) ? 'bx-history' : 'bx-bar-chart-alt-2' ?> text-white" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-4">
        <!-- Total Clubs -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-hover shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary shadow-sm"><i class="bx bx-collection fs-3"></i></span>
                        </div>
                        <div>
                            <span class="d-block text-muted small fw-semibold uppercase">ชุมนุมทั้งหมด</span>
                            <h3 class="card-title mb-0"><?= count($TotalClubs ?? []) ?></h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-primary fw-semibold small">
                        <span>เปิดสอนในเทอมนี้</span>
                        <i class="bx bx-chevron-right ms-1"></i>
                    </div>
                </div>
                <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>" class="stretched-link"></a>
            </div>
        </div>

        <!-- Registered Students -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-hover shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info shadow-sm"><i class="bx bx-group fs-3"></i></span>
                        </div>
                        <div>
                            <span class="d-block text-muted small fw-semibold uppercase">นักเรียนลงทะเบียน</span>
                            <h3 class="card-title mb-0"><?= $TotalStudent[0]->StudentAll ?? 0 ?></h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-info fw-semibold small">
                        <span>ข้อมูลอัปเดตเรียลไทม์</span>
                        <i class="bx bx-check-circle ms-1"></i>
                    </div>
                </div>
                <a href="<?= base_url('admin/academic/develop-students/student-registrations') ?>" class="stretched-link"></a>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning shadow-sm"><i class="bx bx-user-voice fs-3"></i></span>
                        </div>
                        <div>
                            <span class="d-block text-muted small fw-semibold uppercase">ครูที่ปรึกษา</span>
                            <h3 class="card-title mb-0"><?= $TotalTeacher[0]->total_advisors ?? 0 ?></h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-warning fw-semibold small">
                        <span>ทั้งหมดในระบบแยกตามรายชื่อ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Club -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 text-truncate">
                        <div class="avatar avatar-md flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger shadow-sm border-2 border-white"><i class="bx bxs-hot fs-3"></i></span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="d-block text-muted small fw-semibold uppercase">ยอดนิยมอันดับ 1</span>
                            <h5 class="card-title mb-0 text-truncate" title="<?= esc($ClubPopula->club_name ?? 'ไม่มี') ?>">
                                <?= esc($ClubPopula->club_name ?? 'ไม่มี') ?>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="progress w-100 mt-1" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="ms-2 fw-bold text-danger"><?= $ClubPopula->total_members ?? 0 ?></span>
                    </div>
                    <small class="text-muted mt-1 d-block fw-300">จำนวนนักเรียนที่เข้าร่วม</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule & Status -->
    <div class="row g-4">
        <!-- Student Schedule -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body pb-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-label-<?= $stdCfg['class'] ?> rounded me-3 shadow-sm">
                                <i class="bx bx-calendar-event fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">กำหนดการเปิด/ปิด (นักเรียน)</h5>
                                <small class="text-muted">นักเรียนลงทะเบียนเลือกชุมนุม</small>
                            </div>
                        </div>
                        <span class="badge <?= $stdCfg['bg'] ?> text-<?= $stdCfg['class'] ?> text-uppercase px-3 py-2 fw-bold shadow-sm">
                            <i class="bx <?= $stdCfg['icon'] ?> me-1"></i><?= $stdCfg['label'] ?>
                        </span>
                    </div>

                    <div class="row g-0 bg-light rounded overflow-hidden mb-3">
                        <div class="col-6 border-end border-white">
                            <div class="p-3 d-flex align-items-center">
                                <i class="bx bx-play-circle text-primary me-2 fs-3 opacity-75"></i>
                                <div>
                                    <p class="mb-0 text-muted small">เริ่มระบบ</p>
                                    <span class="fw-bold small"><?= $formatted_student_regisstart ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 d-flex align-items-center">
                                <i class="bx bx-stop-circle text-danger me-2 fs-3 opacity-75"></i>
                                <div>
                                    <p class="mb-0 text-muted small">จบระบบ</p>
                                    <span class="fw-bold small"><?= $formatted_student_regisend ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4 mt-auto">
                    <button class="btn btn-outline-primary w-100 fw-bold border-2" data-bs-toggle="modal" data-bs-target="#modalClubStudentSettings">
                        <i class="bx bx-cog me-1"></i> ตั้งค่าการลงทะเบียนนักเรียน
                    </button>
                </div>
            </div>
        </div>

        <!-- Teacher Schedule -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body pb-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-label-<?= $tchCfg['class'] ?> rounded me-3 shadow-sm">
                                <i class="bx bx-user-check fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">กำหนดการเปิด/ปิด (ครู)</h5>
                                <small class="text-muted">ครูที่ปรึกษาจัดการข้อมูลชุมนุม</small>
                            </div>
                        </div>
                        <span class="badge <?= $tchCfg['bg'] ?> text-<?= $tchCfg['class'] ?> text-uppercase px-3 py-2 fw-bold shadow-sm">
                            <i class="bx <?= $tchCfg['icon'] ?> me-1"></i><?= $tchCfg['label'] ?>
                        </span>
                    </div>

                    <div class="row g-0 bg-light rounded overflow-hidden mb-3">
                        <div class="col-6 border-end border-white">
                            <div class="p-3 d-flex align-items-center">
                                <i class="bx bx-play-circle text-primary me-2 fs-3 opacity-75"></i>
                                <div>
                                    <p class="mb-0 text-muted small">เริ่มระบบ</p>
                                    <span class="fw-bold small"><?= $formatted_teacher_regisstart ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 d-flex align-items-center">
                                <i class="bx bx-stop-circle text-danger me-2 fs-3 opacity-75"></i>
                                <div>
                                    <p class="mb-0 text-muted small">จบระบบ</p>
                                    <span class="fw-bold small"><?= $formatted_teacher_regisend ?? '-' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4 mt-auto">
                    <button class="btn btn-outline-info w-100 fw-bold border-2" data-bs-toggle="modal" data-bs-target="#modalClubTeacherSettings">
                        <i class="bx bx-cog me-1"></i> ตั้งค่าการเข้าถึงของครู
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
.bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
.bg-label-warning { background-color: #fff2d6 !important; color: #ffab00 !important; }
.bg-label-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
.bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }

.card-hover:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.border-dashed { border-style: dashed !important; }

.uppercase { text-transform: uppercase; letter-spacing: 0.5px; }

/* Dashboard Widgets Icons shadow */
.avatar-initial {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.btn-white {
    background-color: #fff;
    color: #696cff;
    border: 1px solid #fff;
}
.btn-white:hover {
    background-color: #f8f9fa;
    border-color: #f8f9fa;
}
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

    // Initialize datepickers inside any of the setting modals when shown
    $('#modalClubStudentSettings, #modalClubTeacherSettings, #modalClubSystemSettings').on('shown.bs.modal', function () {
        flatpickr(".club-onoff-datepicker", {
            disableMobile: true,
            dateFormat: "Y-m-d",
            locale: "th",
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

    // Handle Weeks / Attendance Data (Existing dynamic loading)
    function loadWeeksData() {
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let rows = '';
                if (response.status === 'success') {
                    response.data.forEach(function (week, index) {
                        let checked = (week.tcs_week_status == "เปิด") ? "checked" : "";
                        rows += `<tr>
                            <td>สัปดาห์ที่ ${index + 1}</td>
                            <td><input type="date" class="form-control tcs_academic_year" id="tcs_academic_year${index + 1}" data-id="${week.tcs_schedule_id}" value="${week.tcs_start_date || ''}"></td>
                            <td>
                                <div class="form-check form-switch d-flex">
                                    <input class="form-check-input status-btn" type="checkbox" data-status="${week.tcs_week_status}" data-id="${week.tcs_schedule_id}" ${checked}>
                                </div>
                            </td>
                        </tr>`;
                    });
                } else { rows = '<tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>'; }
                $('#TbDateWeeks tbody').html(rows);
            }
        });
    }
    loadWeeksData();

    // Save week dates when changed
    $(document).on('change', '.tcs_academic_year', function() {
        const id = $(this).data('id');
        const date = $(this).val();
        
        if (!date) return;

        $.ajax({
            url: '<?= site_url('admin/academic/developstudents/update_schedule') ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                id: id,
                date: date
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: 'บันทึกวันที่แล้ว' });
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                }
            }
        });
    });

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

