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
                    <p>ระบบจัดการลงทะเบียนเรียนซ้ำสำหรับนักเรียนที่ไม่ผ่านเกณฑ์</p>
                    <div class="year-badge" id="header-selected-year-badge">
                        <i class="bx bx-calendar"></i>ปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
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

    <!-- Data Table Section -->
    <div class="card table-card shadow-sm">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5><i class="bx bx-list-ul me-2"></i>รายการลงทะเบียนเรียนซ้ำ</h5>
            <div class="d-flex align-items-center gap-2">
                <label for="CheckYearRegisRepeat" class="form-label mb-0 fw-medium text-nowrap">
                    <i class="bx bx-filter-alt me-1"></i>ปีการศึกษา:
                </label>
                <select class="form-select form-select-sm" id="CheckYearRegisRepeat" name="CheckYearRegisRepeat" style="width: auto; min-width: 130px;">
                    <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                    <option <?= (isset($selectedYear) && isset($v_GroupYear->SubjectYear) && $selectedYear == $v_GroupYear->SubjectYear) ? "selected" : "" ?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbRegisRepeatSubject">
                    <thead>
                        <tr>
                            <th><i class="bx bx-calendar me-1"></i>เรียนปี</th>
                            <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                            <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                            <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                            <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                            <th><i class="bx bx-user me-1"></i>ครูผู้สอน</th>
                            <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                            <th class="text-center text-nowrap"><i class="bx bx-refresh me-1"></i>เรียนซ้ำ</th>
                        </tr>
                    </thead>
                </table>
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

// Initialize on page load
TB_RegisRepeatSubject($('#CheckYearRegisRepeat').val());

// Year change handler
$(document).on('change', '#CheckYearRegisRepeat', function() {
    var selectedYear = $(this).val();
    
    // Save selected year to session
    $.post("<?= site_url('Admin/SetSelectedYear') ?>", { year: selectedYear });
    
    // Reload table with new year
    TB_RegisRepeatSubject(selectedYear);
    
    // Update dashboard stats
    updateRepeatDashboardStats(selectedYear);
});

// Function to update dashboard statistics
function updateRepeatDashboardStats(year) {
    $.ajax({
        url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getDashboardStats') ?>",
        type: "POST",
        data: { year: year },
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
                    return (data.StudentPrefix || '') + (data.StudentFirstName || '') + ' ' + (data.StudentLastName || '');
                }
            },
            { 
                data: 'SubjectCount',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge bg-label-warning">' + data + '</span>';
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

function TB_RegisRepeatSubject(Year) {
    tbRegisRepeatSubject = $('#tbRegisRepeatSubject').DataTable({
        destroy: true,
        "order": [[7, "desc"]],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>",
            "type": "POST",
            data: { "keyYear": Year }
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
                    return '<span class="class-badge">ม.' + data + '</span>';
                }
            },
            {
                data: 'TeacherName',
                render: function(data, type, row) {
                    return '<div class="d-flex align-items-center"><div class="rounded-circle bg-success bg-opacity-10 p-2 me-2"><i class="bx bx-user text-success"></i></div><span>' + data + '</span></div>';
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<a class="btn-register" href="<?= site_url('Admin/Acade/Registration/Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectID ? row.SubjectID : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'"><i class="bx bx-edit-alt"></i>ลงทะเบียน</a>';
                }
            },
            {
                data: 'SumRepeat',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="repeat-count-badge"><i class="bx bx-user me-1"></i>' + data + ' คน</span>';
                }
            }
        ]
    });
}

// Show Repeat Students Modal
$(document).on("click", ".ShowRegisRepeat", function() {
    $('#tb_ShowRegisRepeat tbody tr').remove();
    $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>", {
        subid: $(this).attr('sub-id'),
        teachid: $(this).attr('teach-id')
    }, function(data, status) {
        $('.ShowSubjectName').html("<i class='bx bx-book-reader me-2'></i>วิชา " + (data[0].SubjectName ? data[0].SubjectName : '') + "<br><small class='text-white-50'>ครูผู้สอน " + (data[0].pers_prefix ? data[0].pers_prefix : '') + (data[0].pers_firstname ? data[0].pers_firstname : '') + ' ' + (data[0].pers_lastname ? data[0].pers_lastname : '') + "</small>");
        $.each(data, function(index, value) {
            $('#tb_ShowRegisRepeat tbody').append('<tr><td>' + (value.StudentClass ? value.StudentClass : '') + '</td><td>' + (value.StudentNumber ? value.StudentNumber : '') + '</td><td>' + (value.StudentCode ? value.StudentCode : '') + '</td><td>' + (value.StudentPrefix ? value.StudentPrefix : '') + (value.StudentFirstName ? value.StudentFirstName : '') + ' ' + (value.StudentLastName ? value.StudentLastName : '') + '</td></tr>');
        });
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
