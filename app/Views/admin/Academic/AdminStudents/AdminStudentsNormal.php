<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<input type="hidden" id="KeyStatus" value="<?= esc(service('request')->getUri()->getSegment(5) ?? '') ?>">

<style>
/* ===== Custom CSS Variables - Green Theme ===== */
:root {
    --primary-green: #28a745;
    --primary-green-dark: #1e7e34;
    --gradient-green: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
}

/* ===== Page Container ===== */
.students-list-page {
    padding: 1.5rem;
    background: linear-gradient(180deg, #f8fdf9 0%, #ffffff 100%);
    min-height: 100vh;
}

/* ===== Page Header ===== */
.page-header {
    background: var(--gradient-green);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(40, 167, 69, 0.25);
}

.page-header::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header .title {
    color: #fff;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    z-index: 1;
}

.page-header .title i {
    margin-right: 0.5rem;
}

.page-header .breadcrumb-nav {
    position: relative;
    z-index: 1;
}

.page-header .breadcrumb-nav a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s ease;
}

.page-header .breadcrumb-nav a:hover {
    color: #fff;
}

.page-header .breadcrumb-nav span {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0.5rem;
}

/* ===== Filter Card ===== */
.filter-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    margin-bottom: 1.5rem;
}

.filter-card .card-body {
    padding: 1.5rem;
}

.filter-section {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-group label {
    font-weight: 500;
    color: #495057;
    white-space: nowrap;
    margin: 0;
}

.filter-group .form-select {
    min-width: 180px;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.6rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-group .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
}

.filter-actions {
    margin-left: auto;
}

.btn-export {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: #fff;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: #fff;
}

.btn-export i {
    margin-right: 0.5rem;
}

/* ===== Data Table Card ===== */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.table-card .card-body {
    padding: 0;
}

/* ===== DataTables Styling ===== */
#tbStudent {
    border-collapse: separate;
    border-spacing: 0;
    width: 100% !important;
}

#tbStudent thead th {
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

#tbStudent tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    font-size: 0.95rem;
}

#tbStudent tbody tr {
    transition: all 0.2s ease;
}

#tbStudent tbody tr:hover {
    background: rgba(40, 167, 69, 0.04);
}

/* Student Code Badge */
.student-code-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

.student-code-badge i {
    margin-right: 0.35rem;
    color: var(--primary-green);
}

/* Student Name */
.student-name {
    font-weight: 500;
    color: #212529;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Class Badge */
.class-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #1976d2;
}

/* Number Badge */
.number-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #f8f9fa;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

/* Study Line */
.study-line-text {
    max-width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #6c757d;
    font-size: 0.9rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
}

.status-badge.status-normal {
    background: #d4edda;
    color: #28a745;
}

.status-badge.status-absent {
    background: #f8d7da;
    color: #dc3545;
}

.status-badge.status-dismissed {
    background: #fff3cd;
    color: #856404;
}

/* Behavior Badge */
.behavior-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
}

.behavior-badge.behavior-normal {
    background: #d1ecf1;
    color: #0c5460;
}

.behavior-badge.behavior-absent {
    background: #f8d7da;
    color: #721c24;
}

.behavior-badge.behavior-dismissed {
    background: #f5c6cb;
    color: #721c24;
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
    padding: 0.5rem 0.9rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-action.btn-edit {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    color: #212529;
}

.btn-action.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

.btn-action.btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
}

.btn-action.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.btn-action i {
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
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
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

.dataTables_wrapper .dataTables_info {
    color: #6c757d;
    font-size: 0.9rem;
}

/* ===== Modal Styling ===== */
#studentDetailModal .modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

#studentDetailModal .modal-header {
    background: var(--gradient-green);
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

#studentDetailModal .modal-header .modal-title {
    color: #fff;
    font-weight: 600;
}

#studentDetailModal .modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

#studentDetailModal .modal-header .btn-close:hover {
    opacity: 1;
}

#studentDetailModal .modal-body {
    padding: 1.5rem;
    background: #f8f9fa;
}

#studentDetailModal .modal-footer {
    background: #fff;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.5rem;
}

#studentDetailModal .form-floating label {
    color: #495057 !important;
}

#studentDetailModal .form-control,
#studentDetailModal .form-select {
    color: #212529 !important;
    border-radius: 10px;
    border: 2px solid #e9ecef;
}

#studentDetailModal .form-control:focus,
#studentDetailModal .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
}

/* ===== Truncate Text ===== */
.truncate-text {
    max-width: 180px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: default;
}

/* ===== Typeahead Dropdown ===== */
.twitter-typeahead {
    width: 100%;
}

.tt-menu {
    width: 100%;
    margin-top: 2px;
    padding: 0.5rem 0;
    background-color: #fff;
    border: 2px solid var(--primary-green);
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    z-index: 1100;
}

.tt-suggestion {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    transition: all 0.2s ease;
}

.tt-suggestion.tt-cursor,
.tt-suggestion:hover {
    color: #fff;
    background: var(--primary-green);
    cursor: pointer;
}

/* Fix for floating labels with jquery.thailand.js */
.form-floating.label-floated>label {
    opacity: 0.65;
    transform: scale(.90) translateY(-.5rem) translateX(.15rem);
}

.form-floating:focus label {
    opacity: 0.65;
    transform: scale(.90) translateY(-.5rem) translateX(.15rem);
}

.floating-new {
    padding: 23px 14px 11px;
}

.form-control:focus {
    padding: 23px 14px 11px;
}

/* ===== Back Button ===== */
.btn-back {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    color: #fff;
    transform: translateX(-3px);
}

.btn-back i {
    margin-right: 0.5rem;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .filter-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-actions {
        margin-left: 0;
        margin-top: 1rem;
    }
    
    .page-header .title {
        font-size: 1.25rem;
    }
}

/* Ensure SweetAlert2 (swal2) is always on top of Bootstrap Modals */
.swal2-container {
    z-index: 9999 !important;
}
</style>

<div class="students-list-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="breadcrumb-nav mb-2">
                    <a href="<?= base_url('Admin/Acade/Registration/Students') ?>">
                        <i class="bx bx-home-alt"></i> จัดการนักเรียน
                    </a>
                    <span>/</span>
                    <span class="text-white"><?= isset($title) ? esc($title) : 'รายชื่อนักเรียน' ?></span>
                </div>
                <h1 class="title">
                    <i class="bx bx-group"></i><?= isset($title) ? esc($title) : 'รายชื่อนักเรียน' ?>
                </h1>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-success fw-bold px-3 py-2 fs-6 shadow-sm rounded-pill">
                    <i class="bx bx-calendar-check me-1"></i>ปีการศึกษา <?= get_selected_year() ?>
                </span>
                <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn-back">
                    <i class="bx bx-arrow-back"></i>กลับหน้าหลัก
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card">
        <div class="card-body">
            <div class="filter-section">
                <div class="filter-group">
                    <label for="classFilter"><i class="bx bx-filter-alt me-1"></i>ระดับชั้น</label>
                    <select class="form-select" id="classFilter" name="classFilter">
                        <option value="">ทั้งหมด</option>
                        <?php foreach ($class_list as $v_class) : ?>
                        <option value="ม.<?= esc($v_class) ?>">ม.<?= esc($v_class) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="button" id="exportBtn" class="btn btn-export">
                        <i class="bx bx-download"></i>ส่งออก Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card table-card">
        <div class="card-body">
            <table class="table" id="tbStudent">
                <thead>
                    <tr>
                        <th><i class="bx bx-id-card me-1"></i>เลขประจำตัว</th>
                        <th><i class="bx bx-user me-1"></i>ชื่อ - นามสกุล</th>
                        <th><i class="bx bx-book me-1"></i>ชั้น</th>
                        <th><i class="bx bx-hash me-1"></i>เลขที่</th>
                        <th><i class="bx bx-category me-1"></i>สายการเรียน</th>
                        <th><i class="bx bx-check-circle me-1"></i>สถานะนักเรียน</th>
                        <th><i class="bx bx-info-circle me-1"></i>สถานะพฤติกรรม</th>
                        <th class="text-center"><i class="bx bx-cog me-1"></i>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Student Detail Modal -->
<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="max-height: 90vh;">
            <form id="editStudentForm" method="post">
                <div class="modal-header" style="flex-shrink: 0;">
                    <h5 class="modal-title" id="studentDetailModalLabel">
                        <i class="bx bx-edit me-2"></i>แก้ไขข้อมูลนักเรียน
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: calc(90vh - 130px);">
                    <div id="studentDetailContent">
                        <!-- Student details form will be loaded here dynamically -->
                    </div>
                </div>
                <div class="modal-footer" style="flex-shrink: 0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>ปิด
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save me-1"></i>บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Function to fix floating labels for inputs wrapped by typeahead.js
function updateFloatingLabels() {
    setTimeout(function() {
        $('.form-floating .twitter-typeahead .tt-input').each(function () {
            var $input = $(this);
            var $parent = $input.closest('.form-floating');
            if ($input.val() && $input.val().trim().length > 0) {
                $parent.addClass('label-floated');
            } else {
                $parent.removeClass('label-floated');
            }
        });
    }, 50);
}

    // Handle floating labels for typeahead inputs globally
    $(document).on('keyup change typeahead:change typeahead:select', '.twitter-typeahead .tt-input', updateFloatingLabels);

// Helper functions for status badges
function getStatusBadge(status) {
    if (status && status.includes('ปกติ')) {
        return `<span class="status-badge status-normal"><i class="bx bx-check-circle me-1"></i>${status}</span>`;
    } else if (status && (status.includes('ขาด') || status.includes('พัก'))) {
        return `<span class="status-badge status-absent"><i class="bx bx-time-five me-1"></i>${status}</span>`;
    } else {
        return `<span class="status-badge status-dismissed"><i class="bx bx-info-circle me-1"></i>${status || '-'}</span>`;
    }
}

function getBehaviorBadge(behavior) {
    if (behavior === 'ปกติ') {
        return `<span class="behavior-badge behavior-normal">${behavior}</span>`;
    } else if (behavior === 'ขาดเรียนนาน') {
        return `<span class="behavior-badge behavior-absent"><i class="bx bx-error me-1"></i>${behavior}</span>`;
    } else if (behavior === 'จำหน่าย') {
        return `<span class="behavior-badge behavior-dismissed"><i class="bx bx-x-circle me-1"></i>${behavior}</span>`;
    } else {
        return `<span class="behavior-badge behavior-normal">${behavior || '-'}</span>`;
    }
}

$(document).ready(function() {
    // Display success message from session flashdata
    <?php if (session()->getFlashdata('msg') === 'YES'): ?>
        Swal.fire({
            title: 'ผลการประมวลผล',
            html: '<?= session()->getFlashdata('messge') ?>',
            icon: '<?= session()->getFlashdata('status') ?>',
            width: '600px',
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#28a745'
        });
    <?php endif; ?>

    const keyStatus = $('#KeyStatus').val();
    console.log('KeyStatus sent to controller:', keyStatus);
    
    const tbStudent = $('#tbStudent').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "asc" ]],
        "ajax": {
            "url": "<?= site_url('Admin/Academic/ConAdminStudents/AdminStudentsNormalShow/') ?>" + keyStatus,
            "type": "POST",
            "data": function (d) {
                d.classFilter = $('#classFilter').val();
                d.school_year = $('#school_year_filter').val() || '';
            }
        },
        "language": {
            "processing": '<div class="d-flex justify-content-center align-items-center py-4"><div class="spinner-border text-success" role="status"></div><span class="ms-3">กำลังโหลด...</span></div>',
            "lengthMenu": "แสดง _MENU_ รายการ",
            "zeroRecords": '<div class="text-center py-4 text-muted"><i class="bx bx-info-circle bx-lg"></i><p class="mt-2">ไม่พบข้อมูลนักเรียน</p></div>',
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
        },
        "columns": [
            { 
                "data": "StudentCode",
                "render": function(data, type, row) {
                    return `<span class="student-code-badge"><i class="bx bx-id-card"></i>${data}</span>`;
                }
            },
            { 
                "data": "Fullname",
                "render": function(data, type, row) {
                    return `<span class="student-name" title="${data}">${data}</span>`;
                }
            },
            { 
                "data": "StudentClass",
                "render": function(data, type, row) {
                    return `<span class="class-badge">${data}</span>`;
                }
            },
            { 
                "data": "StudentNumber",
                "render": function(data, type, row) {
                    return `<span class="number-badge">${data}</span>`;
                }
            },
            { 
                "data": "StudentStudyLine",
                "render": function(data, type, row) {
                    if (!data) return `<span class="text-muted">-</span>`;
                    return `<span class="study-line-text" title="${data}">${data}</span>`;
                }
            },
            { 
                "data": "StudentStatus",
                "render": function(data, type, row) {
                    return getStatusBadge(data);
                }
            },
            { 
                "data": "StudentBehavior",
                "render": function(data, type, row) {
                    return getBehaviorBadge(data);
                }
            },
            {
                "data": "StudentID",
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                        <div class="action-buttons">
                            <button type="button" class="btn-action btn-edit edit-student" data-id="${data}" title="แก้ไขข้อมูลนักเรียน">
                                <i class="bx bx-edit-alt"></i>แก้ไข
                            </button>
                            <button type="button" class="btn-action btn-delete delete-student" data-id="${data}" title="ลบนักเรียน">
                                <i class="bx bx-trash"></i>ลบ
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    // Filter by class
    $('#classFilter').on('change', function() {
        tbStudent.ajax.reload();
    });

    // Filter by school year
    $('#school_year_filter').on('change', function() {
        tbStudent.ajax.reload();
    });

    // Handle Export button click
    $('#exportBtn').on('click', function(e) {
        e.preventDefault();
        const currentKeyStatus = $('#KeyStatus').val();
        const currentClassFilter = $('#classFilter').val();
        
        let exportUrl = `<?= site_url('admin/academic/students/export/') ?>${currentKeyStatus}`;
        if (currentClassFilter) {
            exportUrl += `?classFilter=${currentClassFilter}`;
        }
        window.location.href = exportUrl;
    });

    // Edit Student Modal
    $(document).on('click', '.edit-student', function() {
        const studentId = $(this).data('id');
        
        // Show loading spinner
        $('#studentDetailContent').html(`
            <div class="text-center p-5">
                <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-3">กำลังโหลดข้อมูลนักเรียน...</p>
            </div>
        `);
        
        // Show modal
        $('#studentDetailModal').modal('show');

        // Fetch form content
        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/get_student_details/') ?>' + studentId,
            type: 'GET',
            success: function(responseHtml) {
                $('#studentDetailContent').html(responseHtml);

                // Initialize Thailand Address Autocomplete
                $.Thailand({
                    database: '<?= base_url('assets/database/db.json') ?>',
                    $district: $('#stu_hTambon'),
                    $amphoe: $('#stu_hDistrict'),
                    $province: $('#stu_hProvince'),
                    $zipcode: $('#stu_hPostCode'),
                });

                // Current Address
                $.Thailand({
                    database: '<?= base_url('assets/database/db.json') ?>',
                    $district: $('#stu_cTumbao'),
                    $amphoe: $('#stu_cDistrict'),
                    $province: $('#stu_cProvince'),
                    $zipcode: $('#stu_cPostcode'),
                });

                // School Address
                $.Thailand({
                    database: '<?= base_url('assets/database/db.json') ?>',
                    $district: $('#stu_schoolTambao'),
                    $amphoe: $('#stu_schoolDistrict'),
                    $province: $('#stu_schoolProvince'),
                });

                // Fix floating labels
                updateFloatingLabels();
            },
            error: function(xhr, status, error) {
                $('#studentDetailContent').html(`
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bx bx-error-circle bx-lg me-3"></i>
                        <div>
                            <strong>เกิดข้อผิดพลาด</strong><br>
                            ไม่สามารถดึงข้อมูลได้: ${error}
                        </div>
                    </div>
                `);
            }
        });
    });

    // Form Submit
    $('#editStudentForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/update_student_details') ?>',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังบันทึก...',
                    html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#15a362'
                    });
                    $('#studentDetailModal').modal('hide');
                    tbStudent.ajax.reload();
                } else {
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'ผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + xhr.responseText,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });

    // Delete Student
    $(document).on('click', '.delete-student', function() {
        const studentId = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบนักเรียน?',
            html: `คุณแน่ใจว่าต้องการลบข้อมูลนักเรียนนี้หรือไม่?<br><br>
                   <div class="alert alert-danger px-1 py-1" role="alert" style="font-size: 0.9rem;">
                     <i class="bx bx-error-circle me-1"></i> <strong>คำเตือน:</strong> ข้อมูลทางวิชาการและประวัตินักเรียนทั้งหมดจะถูกลบออกจากฐานข้อมูลและไม่สามารถกู้คืนได้
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bx bx-trash me-1"></i>ใช่, ลบข้อมูลทั้งหมด!',
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
                    url: '<?= site_url('Admin/Academic/ConAdminStudents/AdminStudentsDelete/') ?>' + studentId,
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'ลบสำเร็จ!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#15a362'
                            });
                            tbStudent.ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'ผิดพลาด!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'ผิดพลาด!',
                            text: 'เกิดข้อผิดพลาดในการลบข้อมูล: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>