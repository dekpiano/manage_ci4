<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<?php 
// Initialize variables with defaults
$ExYearClub = [date('Y'), '1']; // Default to current year and term 1
if (isset($CheckOnoffClubParsed) && is_array($CheckOnoffClubParsed) && count($CheckOnoffClubParsed) >= 2) {
    $ExYearClub = $CheckOnoffClubParsed;
}

// Handle other potential undefined variables
$Status = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? "success" : "danger";
$StatusBg = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? "bg-success-subtle" : "bg-danger-subtle";
$Icon = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? '<i class="bi bi-check-circle"></i>' : '<i class="bi bi-x-circle"></i>';
$formatted_regisstart = isset($formatted_regisstart) ? $formatted_regisstart : '-';
$formatted_regisend = isset($formatted_regisend) ? $formatted_regisend : '-';
?>
<div class="container-xl mt-4">
            <!-- Dashboard Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                            <div>
                                <h4 class="mb-1">แดชบอร์ดระบบชุมนุม</h4>
                                <p class="text-muted mb-0">ภาพรวมข้อมูลเกี่ยวกับชุมนุม ปีการศึกษา <?= esc($ExYearClub[0]) ?> ภาคเรียนที่ <?= esc($ExYearClub[1]) ?></p>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                                                <button type="button" class="btn btn-outline-primary btn-sm" id="MenuSetDateAttendancer">
                                                                    <i class="bx bx-time me-1"></i> ตั้งค่าเวลาเรียน
                                                                </button>
                                
                                                                <div class="dropdown">
                                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="clubSettingsDropdown" 
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="bx bx-cog me-1"></i> ตั้งค่าระบบชุมนุม
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="clubSettingsDropdown">
                                                                        <li><a class="dropdown-item d-flex align-items-center" href="#" id="MenuSetYear">
                                                                            <i class="bx bx-calendar me-2"></i> ตั้งค่าปีการศึกษา
                                                                        </a></li>
                                                                        <li><a class="dropdown-item d-flex align-items-center" href="#" id="MenuSetDateRegister">
                                                                            <i class="bx bx-calendar-check me-2"></i> ตั้งค่าช่วงเวลาลงทะเบียน
                                                                        </a></li>
                                                                        <li><hr class="dropdown-divider"></li>
                                                                        <li><a class="dropdown-item d-flex align-items-center" href="#" id="MenuOpenClubSettings" data-bs-toggle="modal" data-bs-target="#modalClubSettings">
                                                                            <i class="bx bx-toggle-right me-2"></i> เปิด/ปิด ระบบ
                                                                        </a></li>
                                                                    </ul>
                                                                </div>
                                
                                                                <a class="btn btn-primary btn-sm" href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>">
                                                                    <i class="bx bx-list-ul me-1"></i> จัดการชุมนุม
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                            <?php 
                                            $Status = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? "success" : "danger";
                                            $StatusBg = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? "bg-success-subtle" : "bg-danger-subtle";
                                            $Icon = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด" ? '<i class="bx bx-check-circle"></i>' : '<i class="bx bx-x-circle"></i>';
                                            ?>
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="card border-<?= esc($Status) ?> shadow-sm">
                                                        <div class="card-header border-bottom border-<?= esc($Status) ?> <?= esc($StatusBg) ?> py-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <?= $Icon ?>
                                                                    <h5 class="mb-0 ms-2">กำหนดการลงทะเบียนชุมนุม</h5>
                                                                </div>
                                                                <div class="badge bg-<?= esc($Status) ?> px-3 py-2">
                                                                    <?= isset($StatusOnoffClub) ? esc($StatusOnoffClub) : '' ?>ลงทะเบียน
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body p-4">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-muted mb-3">ระยะเวลาลงทะเบียน</h6>
                                                                    <div class="d-flex gap-3 align-items-center mb-2">
                                                                        <i class="bx bx-calendar-check fs-4 text-<?= esc($Status) ?>"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">เริ่มลงทะเบียน</small>
                                                                            <span class="fw-semibold fs-5"><?php echo $formatted_regisstart ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex gap-3 align-items-center">
                                                                        <i class="bx bx-calendar-x fs-4 text-<?= esc($Status) ?>"></i>
                                                                        <div>
                                                                            <small class="text-muted d-block">สิ้นสุดการลงทะเบียน</small>
                                                                            <span class="fw-semibold fs-5"><?php echo $formatted_regisend ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 text-md-end mt-4 mt-md-0">
                                                                    <div class="text-muted mb-2">ภาคเรียนที่ <?= esc($ExYearClub[1]) ?></div>
                                                                    <h4 class="mb-0">ปีการศึกษา <?= esc($ExYearClub[0]) ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Cards Section -->
                                            <div class="row g-4 mb-4">
                                                <!-- Card 1: ชุมนุมทั้งหมด -->
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="content-left">
                                                                    <span class="fw-semibold d-block mb-1">ชุมนุมทั้งหมด</span>
                                                                    <div class="d-flex align-items-baseline mt-2">
                                                                        <h4 class="mb-0 me-2"><?= isset($TotalClubs) && is_array($TotalClubs) ? count($TotalClubs) : 0 ?></h4>
                                                                        <small class="text-success">ชุมนุม</small>
                                                                    </div>
                                                                    <small class="text-muted">ปีการศึกษา <?= esc($ExYearClub[0]) ?>/<?= esc($ExYearClub[1]) ?></small>
                                                                </div>
                                                                <span class="badge bg-primary-subtle p-2">
                                                                    <i class="bx bx-book-bookmark fs-3 text-primary"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <a class="stretched-link" href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>"></a>
                                                    </div>
                                                </div>
                                
                                                <!-- Card 2: นักเรียนลงทะเบียน -->
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="content-left">
                                                                    <span class="fw-semibold d-block mb-1">นักเรียนลงทะเบียน</span>
                                                                    <div class="d-flex align-items-baseline mt-2">
                                                                        <h4 class="mb-0 me-2"><?= isset($TotalStudent[0]->StudentAll) && !is_null($TotalStudent[0]->StudentAll) ? esc($TotalStudent[0]->StudentAll) : 0 ?></h4>
                                                                        <small class="text-info">คน</small>
                                                                    </div>
                                                                    <small class="text-muted">ลงทะเบียนทั้งหมด</small>
                                                                </div>
                                                                <span class="badge bg-info-subtle p-2">
                                                                    <i class="bx bx-group fs-3 text-info"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <a class="stretched-link BtnShowStudent" id="BtnShowStudent" href="#"></a>
                                                    </div>
                                                </div>
                                
                                                <!-- Card 3: ครูที่ปรึกษา -->
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="content-left">
                                                                    <span class="fw-semibold d-block mb-1">ครูที่ปรึกษาชุมนุม</span>
                                                                    <div class="d-flex align-items-baseline mt-2">
                                                                        <h4 class="mb-0 me-2"><?= isset($TotalTeacher[0]->total_advisors) && !is_null($TotalTeacher[0]->total_advisors) ? esc($TotalTeacher[0]->total_advisors) : 0 ?></h4>
                                                                        <small class="text-warning">คน</small>
                                                                    </div>
                                                                    <small class="text-muted">ในระบบ</small>
                                                                </div>
                                                                <span class="badge bg-warning-subtle p-2">
                                                                    <i class="bx bx-user-pin fs-3 text-warning"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <!-- Card 4: ชุมนุมยอดนิยม -->
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start justify-content-between">
                                                                <div class="content-left">
                                                                    <span class="fw-semibold d-block mb-1">ชุมนุมยอดนิยม</span>
                                                                    <div class="d-flex align-items-baseline mt-2">
                                                                        <h4 class="mb-0 me-2 text-truncate" style="max-width: 150px;">
                                                                            <?= isset($ClubPopula->club_name) ? esc($ClubPopula->club_name) : 'ไม่มี' ?>
                                                                        </h4>
                                                                    </div>
                                                                    <small class="text-danger"><?= isset($ClubPopula->total_members) ? esc($ClubPopula->total_members) : '0' ?> คน</small>
                                                                </div>
                                                                <span class="badge bg-danger-subtle p-2">
                                                                    <i class="bx bx-star fs-3 text-danger"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--//row-->


        </div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal ดูนักเรียนที่ลงทะเบียน -->
<div class="modal fade" id="ModalShowStudentRegisterToClub" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="bx bx-user me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนชุมนุม
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="classFilter" class="form-select">
                                <option value="">แสดงทั้งหมด</option>
                                <!-- Options จะถูกสร้างด้วยข้อมูลห้องเรียนจากฐานข้อมูล -->
                            </select>
                            <label for="classFilter">กรองตามห้องเรียน</label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table id="TbStudentRegisterClub" class="table">
                            <thead>
                                <tr>
                                    <th>รหัสนักเรียน</th>
                                    <th>ชื่อนักเรียน</th>
                                    <th class="text-center">เลขที่</th>
                                    <th class="text-center">ห้องเรียน</th>
                                    <th>ชุมนุม</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0"></tbody>
                        </table>
                    </div>
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


<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetYear.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateRegister.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateAttendance.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/_modalClubsSetting.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Add global SweetAlert2 z-index fix
// Ideally, this CSS should be in a separate global stylesheet.
// But for immediate effect and demonstration, it's placed here.
$('head').append('<style>.swal2-container { z-index: 99999 !important; }</style>');

//---------------------- Club On/Off Settings Script ---------------------------
$(document).ready(function() {

    // Initialize datepickers inside the settings modal when it's shown
    $('#modalClubSettings').on('shown.bs.modal', function () {
        flatpickr(".club-onoff-datepicker", {
            dateFormat: "Y-m-d",
            locale: "th",
            onChange: function(selectedDates, dateStr, instance) {
                const target = $(instance.element).data('target');
                const type = $(instance.element).data('type');
                
                const startDateInput = $(`.club-onoff-datepicker[data-target='${target}'][data-type='start']`);
                const endDateInput = $(`.club-onoff-datepicker[data-target='${target}'][data-type='end']`);

                const startDate = startDateInput.val();
                const endDate = endDateInput.val();

                // Optional: Add validation, e.g., end date must be after start date
                if (startDate && endDate && startDate > endDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'วันที่สิ้นสุดต้องอยู่หลังวันที่เริ่มต้น',
                    });
                    // Revert the changed date
                    // This part can be complex, for now, we just notify the user.
                    return;
                }

                // AJAX call to save the dates
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
                            // Show a small success toast
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'บันทึกวันที่แล้ว'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด!',
                                text: response.message || 'ไม่สามารถบันทึกวันที่ได้'
                            });
                        }
                    },
                    error: function() {
                         Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด!',
                            text: 'เกิดข้อผิดพลาดในการสื่อสารกับเซิร์ฟเวอร์'
                        });
                    }
                });
            }
        });
    });

    $('.club-onoff-toggle').on('change', function() {
        const checkbox = $(this);
        const target = checkbox.data('target');
        const isChecked = checkbox.is(':checked');
        const status = isChecked ? 1 : 0;
        const statusTextElement = $(`#${target}-status-text`);
        
        let newStatusText, title, text;

        if (target === 'system') {
            newStatusText = isChecked ? 'ปิดปรับปรุง' : 'ออนไลน์';
            title = isChecked ? 'ยืนยันการปิดปรับปรุงระบบ?' : 'ยืนยันการเปิดระบบ?';
            text = isChecked 
                ? 'ผู้ใช้ทั่วไปจะไม่สามารถเข้าใช้งานระบบได้จนกว่าจะเปิดอีกครั้ง' 
                : 'ผู้ใช้ทั่วไปจะสามารถกลับเข้าใช้งานระบบได้ตามปกติ';
        } else {
            newStatusText = isChecked ? 'เปิด' : 'ปิด';
            const targetThai = target === 'student' ? 'นักเรียน' : 'ครู';
            title = `ยืนยันการ${newStatusText}ระบบสำหรับ${targetThai}?`;
            text = `ระบบการลงทะเบียนชุมนุมสำหรับ ${targetThai} จะถูก ${newStatusText}`;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with AJAX call
                const originalStatusText = statusTextElement.text();
                statusTextElement.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                checkbox.prop('disabled', true);

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
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: response.message || 'อัปเดตสถานะเรียบร้อยแล้ว',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            checkbox.prop('checked', !isChecked); // Revert checkbox
                            statusTextElement.text(originalStatusText);
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด!',
                                text: response.message || 'ไม่สามารถอัปเดตสถานะได้'
                            });
                        }
                    },
                    error: function() {
                        checkbox.prop('checked', !isChecked); // Revert checkbox
                        statusTextElement.text(originalStatusText);
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด!',
                            text: 'เกิดข้อผิดพลาดในการสื่อสารกับเซิร์ฟเวอร์'
                        });
                    },
                    complete: function() {
                        checkbox.prop('disabled', false);
                    }
                });
            } else {
                // User cancelled, revert the checkbox state
                checkbox.prop('checked', !isChecked);
            }
        });
    });
});

//---------------------- แดชบอร์ด ---------------------------
const classFilter = new SlimSelect({
    select: '#classFilter',
    showSearch: true, // เปิดให้สามารถค้นหาได้
    allowDeselect: true, // สามารถเลือกได้มากกว่า 1
});


function convertThaiDateToISO(dateString) {
    // รายชื่อเดือนภาษาไทย
    const thaiMonths = [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];

    console.log("convertThaiDateToISO input:", dateString); // Add this line
    // แยกส่วนวันที่
    const dateParts = dateString.split(" ");
    console.log("dateParts:", dateParts); // Add this line

    const day = dateParts[0];
    const month = thaiMonths.indexOf(dateParts[1]) + 1;
    const year = dateParts[2];

    // ตรวจสอบว่าแปลงสำเร็จหรือไม่
    if (!day || !month || !year) {
        console.error("รูปแบบวันที่ไม่ถูกต้อง! (Debug: day=" + day + ", month=" + month + ", year=" + year + ")"); // Modify this line
        return null;
    }

    // คืนค่ารูปแบบ "YYYY/MM/DD"
    return `${year}-${month.toString().padStart(2, '0')}-${day.padStart(2, '0')}`;
}

//ดูข้อมูลนักเรียน
$(document).on('click', '.BtnShowStudent', function () {   
    $('#ModalShowStudentRegisterToClub').modal('show');

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetClassroom') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            
            var classFilter = $('#classFilter');
            response.classrooms.forEach(function(classroom) {
                classFilter.append('<option value="'+ classroom.StudentClass +'">'+ classroom.StudentClass +'</option>');
            });
        }
    });
});

var TbStudentRegisterClub = $('#TbStudentRegisterClub').DataTable({
    autoWidth: false, // ปิดการตั้งค่าความกว้างอัตโนมัติ
    responsive: true,
    order: [[3, 'asc'], [2, 'asc']],
    ajax: {
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub') ?>',
        type: 'GET',
        dataType: 'json',
        data: function(d) {
            d.classFilter = $('#classFilter').val(); // ส่งค่าที่เลือกจาก Dropdown ไป
        }
    },
    columns: [
        { data: 'StudentCode',title: 'รหัสนักเรียน' },
        { data: 'Fullname', title: 'ชื่อ - สกุล' },
        { data: 'StudentNumber', title: 'เลขที่' },
        { data: 'StudentClass', title: 'ห้องเรียน' },
        { data: 'club_status', title: 'สถานะชุมนุม',
            render: function(data, type, row) {
                if (data === 'ยังไม่ได้เลือกชุมนุม') {
                    return `<span class="badge bg-danger">${data}</span>`;
                } else {
                    return `<span class="badge bg-success">${data}</span>`;
                }
            }
         }
    ],
    dom: 'Bfrtip', // เพิ่มปุ่ม
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'ดาวน์โหลด Excel',
                className: 'btn btn-success',
                 title: 'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม',
                filename:'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม'
            },
            {
                extend: 'print',
                text: 'พิมพ์รายงาน',
                className: 'btn btn-primary',
                 title: 'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม',
                filename:'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม'
            }
        ],
    responsive: true,
    language: {
        url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json" // เพิ่มภาษาไทย
    }
});

// เมื่อเลือกห้องเรียนใหม่
$('#classFilter').on('change', function() {
    TbStudentRegisterClub.ajax.reload(); // รีเฟรชข้อมูล
});

// กำหนดปีการศึกษา
$(document).on('click', '#MenuSetYear', function () { 
    $('#ModalClubSetYear').modal('show');
 });

$('#ModalClubSetYear').on('shown.bs.modal', function () {
    const currentAcademicYear = '<?= esc($ExYearClub[0]) ?>'; // Get current year from PHP
    const currentAcademicTerm = '<?= esc($ExYearClub[1]) ?>'; // Get current term from PHP

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetAcademicYears') ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Response from ClubGetAcademicYears:', response); // Debugging line
            const yearSelect = $('#c_onoff_year');
            yearSelect.empty(); // Clear existing options

            // Add a default disabled option
            yearSelect.append($('<option>', {
                value: '',
                text: 'เลือกปีการศึกษา',
                disabled: true,
                selected: true
            }));

            // Populate with years from the database
            response.forEach(function (year) {
                const option = $('<option>', {
                    value: year,
                    text: year
                });
                if (year == currentAcademicYear) {
                    option.attr('selected', true);
                }
                yearSelect.append(option);
            });

            // Populate and pre-select the current term
            const termSelect = $('#c_onoff_term');
            termSelect.empty(); // Clear existing options
            termSelect.append($('<option>', { value: '1', text: '1' }));
            termSelect.append($('<option>', { value: '2', text: '2' }));
            termSelect.val(currentAcademicTerm);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error for ClubGetAcademicYears:", textStatus, errorThrown, jqXHR);
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน!",
                text: "ไม่สามารถโหลดปีการศึกษาได้: " + textStatus
            });

            // Fallback: Populate with current year and next year
            const yearSelect = $('#c_onoff_year');
            yearSelect.empty();
            yearSelect.append($('<option>', {
                value: '',
                text: 'เลือกปีการศึกษา',
                disabled: true,
                selected: true
            }));
            const currentYear = new Date().getFullYear();
            yearSelect.append($('<option>', { value: currentYear, text: currentYear }));
            yearSelect.append($('<option>', { value: currentYear + 1, text: currentYear + 1 }));
            yearSelect.val(currentAcademicYear); // Try to pre-select current year
        }
    });
});

 $(document).on('submit','#FormClubSetOnoffYear',function (e) {
    e.preventDefault();
    // ดึงค่าจากฟอร์ม
    const c_onoff_term = $('#c_onoff_term').val();
    const c_onoff_year = $('#c_onoff_year').val();

    // ตรวจสอบค่าก่อนส่ง
    if (!c_onoff_term || !c_onoff_year) {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        return;
    }

    // ส่งข้อมูลผ่าน AJAX
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubSetOnoffYear') ?>', // ชี้ไปที่ Controller
        type: 'POST',
        dataType: 'json',
        data: {
            c_onoff_term: c_onoff_term,
            c_onoff_year: c_onoff_year
        },
        success: function (response) {
            console.log('Response ', response); // Debugging line
             
            if (response.status === 'success') {
                        
                $('#ModalClubSetYear').modal('hide');
                $('.modal-backdrop').remove();  
                Swal.fire({
                    title: "แจ้งเตือน?",
                    text: response.message,
                    icon: "success",
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                  });
 
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            
            console.log(' ', xhr.responseText); // Debugging line
        }
    });
});

$(document).on('click', '#MenuSetDateRegister', function () { 
    $('#ClubSetDateRegister').modal('show');
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetDateRegister') ?>', // URL ของ PHP ที่ดึงข้อมูล
        method: 'GET',
        dataType: 'json',
        success: function (response) {

            var c_onoff_regisstart = response.datetime.c_onoff_regisstart;
            var c_onoff_regisend = response.datetime.c_onoff_regisend;

            // แปลงค่าให้เป็น Date Object (เพื่อป้องกันการแปลง Time Zone ผิด)
            var TimeStart = new Date(c_onoff_regisstart);
            var TimeEnd = new Date(c_onoff_regisend);
            // ใช้งาน Flatpickr พร้อมตั้งค่าภาษาไทย
            flatpickr(".thaiDateTimeStart", {
                enableTime: true, // เปิดเลือกเวลา
                dateFormat: "d F Y H:i", // กำหนดรูปแบบวันที่เวลา
                locale: "th", // ตั้งค่าภาษาไทย
                disableMobile: true ,
                defaultDate: TimeStart,
            });

            flatpickr(".thaiDateTimeEnd", {
                enableTime: true, // เปิดเลือกเวลา
                dateFormat: "d F Y H:i", // กำหนดรูปแบบวันที่เวลา
                locale: "th", // ตั้งค่าภาษาไทย
                disableMobile: true ,
                defaultDate: TimeEnd,
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching date:", error);
        }
    });


   
 });



$(document).on('submit','#FormClubSetDateRegister',function (e) {
    e.preventDefault();
    // ดึงค่าจากฟอร์ม
    const c_onoff_regisstart = $('#c_onoff_regisstart').val();
    const c_onoff_regisend = $('#c_onoff_regisend').val();
    
    // ตรวจสอบค่าก่อนส่ง
    if (!c_onoff_regisstart || !c_onoff_regisend) {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        return;
    }

    // ส่งข้อมูลผ่าน AJAX
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubSetDateRegister') ?>', // ชี้ไปที่ Controller
        type: 'POST',
        dataType: 'json',
        data: {
            c_onoff_regisstart: c_onoff_regisstart,
            c_onoff_regisend: c_onoff_regisend
        },
        success: function (response) {
            if (response.status === 'success') {
                $('#ClubSetDateRegister').modal('hide');
                $('.modal-backdrop').remove();
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: response.message,
                    icon: "success",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error for ClubSetDateRegister:", textStatus, errorThrown, jqXHR);
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน!",
                text: "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " + textStatus
            });
        }
    });
});


$(document).on('click', '#MenuSetDateAttendancer', function () { 
    $('#ClubSetDateAttendance').modal('show');
    

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>', // URL ของ Controller
        type: 'GET',                    // ประเภทคำขอ
        dataType: 'json',               // ประเภทข้อมูลที่รับมา
        success: function (response) {
            
            if (response.status === 'success') {
                response.data.forEach(function (week, index) {
                   // console.log("week.tcs_start_date:", week.tcs_start_date); // Add this line

                    var TimeEnd = null; // Initialize to null
                    if (week.tcs_start_date && week.tcs_start_date !== '0000-00-00 00:00:00') { // Check if date is valid
                        TimeEnd = new Date(week.tcs_start_date);
                        if (isNaN(TimeEnd.getTime())) { // Check if new Date() resulted in Invalid Date
                            TimeEnd = null;
                        }
                    }

                    flatpickr("#tcs_academic_year"+(index+1), {
                        dateFormat: "d F Y", // กำหนดรูปแบบวันที่เวลา
                        locale: "th", // ตั้งค่าภาษาไทย
                        disableMobile: true ,
                        defaultDate: TimeEnd,
                        onChange: function (selectedDates, dateStr, instance) {
                           // console.log("flatpickr dateStr:", dateStr); // Keep debugging log
                            const isoDate = convertThaiDateToISO(dateStr); // Convert to YYYY-MM-DD
                            let id = $(instance.input).data('id');
                           // console.log("Selected Date ID:", id, "ISO Date:", isoDate); // Debug log
                            updateClubDateSchedule(id, isoDate); // Call update function
                        }
                    });
                });
              
            }
        }
    });
    
   

    $.ajax({
        url: `<?= site_url('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks') ?>`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            //console.log(data); // เช็คข้อมูลที่ดึงมา
        },
        error: function () {
            console.error('ไม่สามารถดึงข้อมูลได้');
        }
    });
});

function loadWeeksData() {
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>', // URL ของ Controller
        type: 'GET',                    // ประเภทคำขอ
        dataType: 'json',               // ประเภทข้อมูลที่รับมา
        success: function (response) {
            let rows = '';
            if (response.status === 'success') {
                response.data.forEach(function (week, index) {
                    
                    if(week.tcs_week_status == "เปิด"){
                        var Ckecked = "checked";
                    }else{
                        var Ckecked = "";
                    }
                    rows += `
                        <tr>
                            <td>สัปดาห์ที่ ${index + 1}</td>
                            <td><input type="date" class="form-control tcs_academic_year" name="tcs_academic_year" id="tcs_academic_year${index + 1}" value="" data-id="${week.tcs_schedule_id}"></td>
                            <td>
                                <div class="form-check form-switch d-flex">
                                    <input class="form-check-input status-btn" type="checkbox" data-status="${week.tcs_week_status}" data-id="${week.tcs_schedule_id}" ${Ckecked} id="customSwitch${index + 1}" >
                                    <label class="form-check-switch-label" for="customSwitch${index + 1}"></label>
                                </div>
                            </td>
                            
                        </tr>
                    `;

                });

            } else {
                rows = '<tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>';
            }
            $('#TbDateWeeks tbody').html(rows); // แสดงข้อมูลในตาราง
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error for loadWeeksData:", textStatus, errorThrown, jqXHR);
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน!",
                text: "ไม่สามารถโหลดข้อมูลได้: " + textStatus
            });
        }
    });
}

// อัปเดตวันที่เวลาเรียนในฐานข้อมูล
function updateClubDateSchedule(id, newDate) {
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateSchedule') ?>', // URL ของ Controller
        type: 'POST',
        data: {
            id: id, // ID ของข้อมูลที่จะแก้ไข
            date: newDate // วันที่ใหม่ในรูปแบบ Y-m-d
        },
        dataType:'json',
        success: function (response) {
            console.log("updateClubDateSchedule response:", response); // Add this line
            if (response.status === 'success') {
                
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "อัปเดตวันที่สำเร็จ",
                    showConfirmButton: false,
                    timer: 1500
                  });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: 'เกิดข้อผิดพลาด: ' + (response.message || 'ไม่สามารถอัปเดตวันที่ได้')
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error for ClubUpdateSchedule:", textStatus, errorThrown, jqXHR);
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน!",
                text: "ไม่สามารถอัปเดตวันที่ได้: " + textStatus
            });
        }
    });
}

// เรียกฟังก์ชันโหลดข้อมูล
loadWeeksData();

// --------- เปิด-ปิด ปุ่มสถานะชุมนุม ---------------
$(document).on('click', '.status-btn', function() {
    var statusButton = $(this);
    var Id = statusButton.data('id');  // id ของชุมนุม
    var currentStatus = statusButton.data('status');  // สถานะปัจจุบัน (เปิดหรือปิด)

    // สลับสถานะ
    var newStatus = (currentStatus === 'เปิด') ? 'ปิด' : 'เปิด';  // เปลี่ยนสถานะ

    // ส่งคำขอ AJAX ไปอัพเดตสถานะในฐานข้อมูล
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus') ?>',  // URL สำหรับอัพเดตสถานะ
        method: 'POST',
        data: {
            id: Id,  // ส่ง id ของชุมนุม
            status: newStatus  // ส่งสถานะใหม่
        },
        dataType:'json',
        success: function(response) {
            console.log(response.status);
            
            // เมื่ออัพเดตสำเร็จ, เปลี่ยนสถานะใน UI
            if (response.status === "success") {
                // เปลี่ยนข้อความในปุ่มตามสถานะใหม่
                statusButton.data('status', newStatus);  // อัพเดตสถานะใน data attribute
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "สถานะถูกอัพเดตแล้ว",
                    showConfirmButton: false,
                    timer: 1500
                  });
            } else {
                alert('เกิดข้อผิดพลาดในการอัพเดตสถานะ');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error for ClubUpdateStatus:", textStatus, errorThrown, jqXHR);
            Swal.fire({
                icon: "error",
                title: "แจ้งเตือน!",
                text: "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้: " + textStatus
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
