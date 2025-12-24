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
.btn-add-new {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 0.6rem 1.25rem;
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
.btn-add-new i { margin-right: 0.5rem; }

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
.stat-card.card-primary::before { background: linear-gradient(90deg, #007bff, #17a2b8); }
.stat-card.card-success::before { background: var(--gradient-green); }
.stat-card.card-info::before { background: linear-gradient(90deg, #17a2b8, #20c997); }
.stat-card.card-warning::before { background: linear-gradient(90deg, #ffc107, #ffda44); }

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
#tbErollSubject thead th {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #495057;
    padding: 0.9rem 1rem;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
}
#tbErollSubject tbody td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
}
#tbErollSubject tbody tr:hover { background: rgba(21, 163, 98, 0.04); }

/* ===== Badges ===== */
.year-badge-table {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #495057;
}
.subject-code-badge {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.2) 100%);
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--primary-green);
}
.class-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.8rem;
    color: var(--primary-green);
}
.student-count-badge {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    background: linear-gradient(135deg, #15a362 0%, #1bc676 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}
.student-count-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.4);
}
.student-count-badge i { margin-right: 0.35rem; }

/* ===== Action Buttons ===== */
.action-buttons {
    display: flex;
    gap: 0.4rem;
    justify-content: center;
}
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: none;
}
.btn-action.btn-edit {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.2) 100%);
    color: var(--primary-green);
}
.btn-action.btn-edit:hover {
    background: var(--gradient-green);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.4);
}
.btn-action.btn-transfer {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.2) 100%);
    color: #d39e00;
}
.btn-action.btn-transfer:hover {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    color: #212529;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
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
                    <h1><i class="bx bx-book-open me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : 'ลงทะเบียนเรียน' ?></h1>
                    <p>ระบบจัดการลงทะเบียนรายวิชาสำหรับนักเรียนแต่ละชั้นปี</p>
                    <div class="year-badge" id="header-year-badge">
                        <i class="bx bx-calendar"></i>ปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <a class="btn-add-new" href="<?= site_url('Admin/Acade/Registration/Enroll/Add/'). (isset($SchoolYear->schyear_year) ? $SchoolYear->schyear_year : '') ?>">
                        <i class="bx bx-plus-circle"></i>ลงทะเบียนเรียน
                    </a>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-book-alt"></i>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Subjects Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-primary h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total-subjects"><?= isset($total_subjects) ? number_format($total_subjects) : 0 ?></div>
                            <div class="stat-label">รายวิชาทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-book"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted" id="stat-selected-year"><i class="bx bx-calendar me-1"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registered Students Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-success h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-total-students"><?= isset($total_registered_students) ? number_format($total_registered_students) : 0 ?></div>
                            <div class="stat-label">นักเรียนลงทะเบียน</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-user-check"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-id-card me-1"></i><span id="stat-total-registrations"><?= isset($total_registrations) ? number_format($total_registrations) : 0 ?> รายการ</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-info h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-total-teachers"><?= isset($total_teachers) ? number_format($total_teachers) : 0 ?></div>
                            <div class="stat-label">ครูผู้สอน</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-circle"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-chalkboard me-1"></i>มีรายวิชาสอน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Groups Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card card-warning h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-total-groups"><?= isset($total_groups) ? number_format($total_groups) : 0 ?></div>
                            <div class="stat-label">กลุ่มสาระการเรียนรู้</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-category"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted"><i class="bx bx-layer me-1"></i>เปิดสอนในปีนี้</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card table-card shadow-sm">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5><i class="bx bx-list-ul me-2"></i>รายการลงทะเบียนเรียน</h5>
            <div class="d-flex align-items-center gap-2">
                <label for="CheckYearEnroll" class="form-label mb-0 fw-medium text-nowrap">
                    <i class="bx bx-filter-alt me-1"></i>ปีการศึกษา:
                </label>
                <select class="form-select form-select-sm" id="CheckYearEnroll" name="CheckYearEnroll" style="width: auto; min-width: 130px;">
                    <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                    <option <?= isset($selectedYear) && isset($v_GroupYear->SubjectYear) && $selectedYear == $v_GroupYear->SubjectYear ? "selected" : ""?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbErollSubject">
                    <thead>
                        <tr>
                            <th><i class="bx bx-calendar me-1"></i>ปีการศึกษา</th>
                            <th><i class="bx bx-hash me-1"></i>รหัสวิชา</th>
                            <th><i class="bx bx-book me-1"></i>ชื่อวิชา</th>
                            <th><i class="bx bx-category me-1"></i>กลุ่มสาระ</th>
                            <th><i class="bx bx-door-open me-1"></i>ชั้น</th>
                            <th><i class="bx bx-user me-1"></i>ครูผู้สอน</th>
                            <th class="text-center text-nowrap"><i class="bx bx-group me-1"></i>นักเรียน</th>
                            <th class="text-center text-nowrap"><i class="bx bx-cog me-1"></i>คำสั่ง</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let tbErollSubject;

// Initialize on page load
TB_ErollSubject($('#CheckYearEnroll').val());

// Year change handler
$(document).on('change', '#CheckYearEnroll', function() {
    var selectedYear = $(this).val();
    
    // Save selected year to session
    $.post("<?= site_url('Admin/SetSelectedYear') ?>", { year: selectedYear });
    
    // Reload table with new year
    TB_ErollSubject(selectedYear);
    
    // Update dashboard stats
    updateDashboardStats(selectedYear);
});

// Function to update dashboard statistics
function updateDashboardStats(year) {
    $.ajax({
        url: "<?= site_url('Admin/Academic/ConAdminEnroll/getDashboardStats') ?>",
        type: "POST",
        data: { year: year },
        dataType: "json",
        beforeSend: function() {
            $('.stat-value').html('<i class="bx bx-loader-alt bx-spin"></i>');
        },
        success: function(response) {
            if (response.status === 'success') {
                var data = response.data;
                animateValue('#stat-total-subjects', data.total_subjects);
                animateValue('#stat-total-students', data.total_registered_students);
                animateValue('#stat-total-teachers', data.total_teachers);
                animateValue('#stat-total-groups', data.total_groups);
                $('#stat-total-registrations').text(numberFormat(data.total_registrations) + ' รายการ');
                $('#stat-selected-year').html('<i class="bx bx-calendar me-1"></i>ในปีการศึกษา ' + data.year);
                $('#header-year-badge').html('<i class="bx bx-calendar me-1"></i>ปีการศึกษา ' + data.year);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dashboard stats:', error);
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

function TB_ErollSubject(Year) {
    tbErollSubject = $('#tbErollSubject').DataTable({
        destroy: true,
        "order": [[1, "asc"]],
        'processing': true,
        "ajax": {
            url: "<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSubject') ?>",
            "type": "POST",
            data: { "keyYear": Year }
        },
        "language": {
            "processing": '<div class="py-3"><div class="spinner-border text-success"></div><span class="ms-2">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": '<i class="bx bx-search me-1"></i>ค้นหา:',
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": '<div class="text-center py-4"><i class="bx bx-folder-open bx-lg text-muted"></i><p class="text-muted mt-2 mb-0">ไม่พบข้อมูลการลงทะเบียน</p></div>',
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
                    return '<span class="year-badge-table">' + data + '</span>';
                }
            },
            { 
                data: 'SubjectCode',
                render: function(data) {
                    return '<span class="subject-code-badge">' + data + '</span>';
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
                    return '<div class="d-flex align-items-center"><div class="rounded-circle bg-success bg-opacity-10 p-2 me-2"><i class="bx bx-user text-success"></i></div><span>' + data + '</span></div>';
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="student-count-badge ShowEnroll" sub-id="' + row.SubjectID + '" teach-id="' + row.TeacherID + '" year-id="' + row.SubjectYear + '"><i class="bx bx-user-check"></i>ลงทะเบียนแล้ว</span>';
                }
            },
            {
                data: 'SubjectID',
                className: 'text-center',
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
                        '<a href="<?= site_url('Admin/Acade/Registration/Enroll/Edit/') ?>' + row.SubjectID + '/' + row.TeacherID + '" class="btn-action btn-edit" title="จัดการนักเรียน"><i class="bx bx-edit"></i></a>' +
                        '<a href="<?= site_url('Admin/Acade/Registration/Enroll/Delete/') ?>' + row.SubjectID + '/' + row.TeacherID + '" class="btn-action btn-transfer" title="ถอนรายชื่อ / เปลี่ยนครูสอน"><i class="bx bx-transfer"></i></a>' +
                        '<button type="button" class="btn-action btn-delete CancelEnroll" key-subject="' + row.SubjectID + '" key-teacher="' + row.TeacherID + '" title="ลบลงทะเบียน"><i class="bx bx-trash"></i></button>' +
                        '</div>';
                }
            }
        ]
    });
}

$(document).on("click", ".ShowEnroll", function() {
    const subId = $(this).attr('sub-id');
    const teachId = $(this).attr('teach-id');
    const yearId = $(this).attr('year-id');

    Swal.fire({
        title: 'กำลังโหลดข้อมูล...',
        html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false
    });

    $.post("<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollShow') ?>", {
        subid: subId,
        teachid: teachId,
        yearid: yearId
    }, function(data, status) {
        if (data && data.length > 0) {
            const subjectName = data[0].SubjectName;
            const teacherName = data[0].pers_prefix + data[0].pers_firstname + ' ' + data[0].pers_lastname;
            
            let contentHtml = `
                <div class="text-start mb-3 p-3 rounded" style="background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.05) 100%);">
                    <p class="mb-1"><i class="bx bx-book text-success me-2"></i><strong>วิชา:</strong> ${subjectName}</p>
                    <p class="mb-1"><i class="bx bx-user text-success me-2"></i><strong>ครูผู้สอน:</strong> ${teacherName}</p>
                    <p class="mb-0"><i class="bx bx-group text-success me-2"></i><strong>จำนวนนักเรียนทั้งหมด:</strong> <span class="badge bg-success">${data.length} คน</span></p>
                </div>
            `;

            const studentsByClass = data.reduce((acc, student) => {
                const className = student.StudentClass || 'ไม่ระบุห้อง';
                if (!acc[className]) {
                    acc[className] = [];
                }
                acc[className].push(student);
                return acc;
            }, {});

            contentHtml += '<div class="accordion text-start" id="accordionStudentClasses">';
            let index = 0;

            for (const [className, students] of Object.entries(studentsByClass)) {
                const headingId = `heading${index}`;
                const collapseId = `collapse${index}`;
                const isFirst = index === 0;

                contentHtml += `
                    <div class="accordion-item border-0 mb-2 rounded overflow-hidden shadow-sm">
                        <h2 class="accordion-header" id="${headingId}">
                            <button class="accordion-button ${!isFirst ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="${isFirst}" aria-controls="${collapseId}" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <i class="bx bx-door-open text-success me-2"></i>ห้อง ${className} <span class="badge bg-success ms-2 rounded-pill">${students.length} คน</span>
                            </button>
                        </h2>
                        <div id="${collapseId}" class="accordion-collapse collapse ${isFirst ? 'show' : ''}" aria-labelledby="${headingId}" data-bs-parent="#accordionStudentClasses">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" width="15%">เลขที่</th>
                                                <th class="text-center" width="25%">รหัสนักเรียน</th>
                                                <th>ชื่อ - นามสกุล</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                `;

                students.forEach(student => {
                    contentHtml += `
                        <tr>
                            <td class="text-center">${student.StudentNumber}</td>
                            <td class="text-center">${student.StudentCode}</td>
                            <td>${student.StudentPrefix}${student.StudentFirstName} ${student.StudentLastName}</td>
                        </tr>
                    `;
                });

                contentHtml += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                index++;
            }
            contentHtml += '</div>';

            Swal.fire({
                title: '<i class="bx bx-user-check text-success me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนแล้ว',
                html: contentHtml,
                width: '800px',
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false
            });
        } else {
            Swal.fire({
                title: 'ไม่พบข้อมูล',
                text: 'ไม่พบนักเรียนที่ลงทะเบียนในวิชานี้',
                icon: 'warning',
                confirmButtonColor: '#15a362',
                confirmButtonText: 'ตกลง'
            });
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถดึงข้อมูลได้: ' + textStatus,
            icon: 'error',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'ตกลง'
        });
    });
});

$(document).on("click", ".CancelEnroll", function() {
    const keyTeacher = $(this).attr('key-teacher');
    const keySubject = $(this).attr('key-subject');
    const tr = $(this).parents('tr');

    Swal.fire({
        title: 'ยืนยันการลบการลงทะเบียน?',
        text: 'การลบนี้จะทำให้ข้อมูลการลงทะเบียนและคะแนนทั้งหมดหายไป ไม่สามารถกู้คืนได้!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bx bx-trash me-1"></i>ลบข้อมูลทันที',
        cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollCancel') ?>",
                type: 'POST',
                data: {
                    KeyTeacher: keyTeacher,
                    KeySubject: keySubject
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังลบข้อมูล...',
                        html: '<div class="py-3"><div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                success: function(data) {
                    Swal.fire({
                        title: 'ลบข้อมูลเรียบร้อย!',
                        text: 'ข้อมูลการลงทะเบียนได้ถูกลบแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#15a362',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                         if (typeof tbErollSubject !== 'undefined') {
                             tbErollSubject.ajax.reload(null, false);
                         } else {
                             tr.remove();
                         }
                    });
                },
                error: function() {
                     Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                     });
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
