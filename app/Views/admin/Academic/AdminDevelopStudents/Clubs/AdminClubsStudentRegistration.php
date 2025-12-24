<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header (New Style) -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="page-title">
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน / ชุมนุม /</span> ข้อมูลการลงทะเบียน
            </h4>
            <div class="text-muted small">ตรวจสอบและส่งออกข้อมูลนักเรียนที่ลงทะเบียนในแต่ละชุมนุม</div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>">หน้าแรกชุมนุม</a></li>
                <li class="breadcrumb-item active">ข้อมูลการลงทะเบียน</li>
            </ol>
        </nav>
    </div>

    <!-- Quick Stats Tiles -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-border-shadow-primary h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="totalStudents">0</h4>
                    </div>
                    <p class="mb-1 text-muted small">นักเรียนทั้งหมดในระบบ</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-border-shadow-success h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="registeredStudents">0</h4>
                    </div>
                    <p class="mb-1 text-muted small" id="regisPercent">ลงทะเบียนแล้ว (0%)</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-border-shadow-danger h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error-circle"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0" id="notRegisteredStudents">0</h4>
                    </div>
                    <p class="mb-1 text-muted small" id="unregisPercent">ยังไม่เลือกชุมนุม (0%)</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <label class="form-label fw-bold text-uppercase x-small mb-2"><i class="bx bx-filter-alt me-1"></i> กรองห้องเรียน</label>
                    <select id="filterClassroom" class="form-select select2">
                        <option value="">ทุกห้องเรียน</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 bg-label-info rounded me-1">
                    <i class="bx bx-list-check fs-4"></i>
                </div>
                <h5 class="mb-0 fw-bold">รายชื่อนักเรียนแยกตามชุมนุม</h5>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-outline-success shadow-none px-3" id="btnExportExcel">
                    <i class="bx bx-spreadsheet me-1"></i> Excel
                </button>
                <button type="button" class="btn btn-outline-secondary shadow-none px-3" id="btnPrintTable">
                    <i class="bx bx-printer me-1"></i> พิมพ์
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table id="studentClubRegisTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="bg-light-primary border-top-0">
                        <tr>
                            <th class="py-3 text-center" style="width: 50px;">#</th>
                            <th class="py-3"><i class="bx bx-id-card me-1 small"></i>รหัสประจำตัว</th>
                            <th class="py-3"><i class="bx bx-user me-1 small"></i>ชื่อ-นามสกุล</th>
                            <th class="py-3 text-center"><i class="bx bx-door-open me-1 small"></i>ชั้น/ห้อง</th>
                            <th class="py-3 text-center" style="width: 80px;"><i class="bx bx-list-ol me-1 small"></i>เลขที่</th>
                            <th class="py-3"><i class="bx bx-bookmark-heart me-1 small"></i>สถานะการลงทะเบียน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loading State -->
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 mb-0 text-muted">กำลังดึงข้อมูล...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-primary { background-color: #f0f2ff !important; }
    #studentClubRegisTable thead th { 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.5px; 
        color: #566a7f;
        border-bottom: 2px solid #e7e7ff !important;
    }
    .card-border-shadow-primary { border-bottom: 3.5px solid #696cff !important; }
    .card-border-shadow-success { border-bottom: 3.5px solid #71dd37 !important; }
    .card-border-shadow-danger { border-bottom: 3.5px solid #ff3e1d !important; }
    .x-small { font-size: 0.7rem; }
    
    /* DataTable Visual Enhancement */
    .dataTables_wrapper .dataTables_filter { padding: 1rem 1.5rem; }
    .dataTables_wrapper .dataTables_length { padding: 1rem 1.5rem; }
    .dataTables_wrapper .dataTables_info { padding: 1rem 1.5rem; }
    .dataTables_wrapper .dataTables_paginate { padding: 1rem 1.5rem; }
    
    @media print {
        .container-p-y { padding: 0 !important; }
        .breadcrumb, .stats-row, .card-header .btn, #studentClubRegisTable_length, #studentClubRegisTable_filter, #studentClubRegisTable_paginate { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        table { width: 100% !important; border: 1px solid #eee !important; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initializing Select2 for premium feel
    $('.select2').select2({ theme: 'bootstrap-5' });

    // Load Classrooms for Filter
    $.get('<?= base_url("admin/academic/ConAdminDevelopStudents/ClubGetClassroom") ?>', function(res) {
        if(res.classrooms) {
            res.classrooms.forEach(c => {
                $('#filterClassroom').append(`<option value="${c.StudentClass}">${c.StudentClass}</option>`);
            });
        }
    });

    // Initialize DataTable
    const table = $('#studentClubRegisTable').DataTable({
        "processing": true,
        "ajax": {
            "url": "<?= base_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub') ?>",
            "type": "GET",
            "dataSrc": function(json) {
                updateQuickStats(json.data);
                return json.data;
            }
        },
        "columns": [
            { 
                "data": null, 
                "render": (data, type, row, meta) => `<span class="fw-semibold text-muted">${meta.row + 1}</span>`,
                "className": "text-center"
            },
            { "data": "StudentCode", "className": "fw-bold small" },
            { "data": "Fullname", "className": "fw-bold text-dark" },
            { 
                "data": "StudentClass", 
                "className": "text-center",
                "render": (data) => `<span class="badge bg-label-info px-3">${data}</span>`
            },
            { "data": "StudentNumber", "className": "text-center fw-medium" },
            { 
                "data": "club_name",
                "render": function(data, type, row) {
                    if (data === 'ยังไม่ได้เลือกชุมนุม') {
                        return `<span class="text-danger fw-bold"><i class="bx bx-error-circle me-1"></i>${data}</span>`;
                    } else {
                        return `<span class="text-success fw-bold"><i class="bx bx-check-double me-1"></i>${data}</span>`;
                    }
                }
            }
        ],
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        },
        "dom": '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>B t <"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "buttons": [
            {
                extend: 'excelHtml5',
                title: 'ทะเบียนนักเรียนลงทะเบียนชุมนุม',
                className: 'd-none',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
            },
            {
                extend: 'print',
                title: 'ทะเบียนนักเรียนลงทะเบียนชุมนุม',
                className: 'd-none',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
            }
        ],
        "order": [[3, 'asc'], [4, 'asc']],
        "drawCallback": function(settings) {
            $('.dataTables_filter input').addClass('form-control shadow-none border-light-subtle').attr('placeholder', 'ค้นหาชื่อ, รหัส, หรือชื่อชุมนุม...');
            $('.dataTables_length select').addClass('form-select border-light-subtle');
        }
    });

    // Filter by Classroom
    $('#filterClassroom').on('change', function() {
        table.column(3).search(this.value).draw();
    });

    // Stats Updater
    function updateQuickStats(data) {
        const total = data.length;
        const registered = data.filter(s => s.club_name !== 'ยังไม่ได้เลือกชุมนุม').length;
        const notRegistered = total - registered;
        
        const regisPercent = total > 0 ? ((registered / total) * 100).toFixed(1) : 0;
        const unregisPercent = total > 0 ? ((notRegistered / total) * 100).toFixed(1) : 0;

        $('#totalStudents').text(total.toLocaleString());
        $('#registeredStudents').text(registered.toLocaleString());
        $('#notRegisteredStudents').text(notRegistered.toLocaleString());
        
        $('#regisPercent').text(`ลงทะเบียนแล้ว (${regisPercent}%)`);
        $('#unregisPercent').text(`ยังไม่เลือกชุมนุม (${unregisPercent}%)`);
    }

    // Export & Print Connectors
    $('#btnExportExcel').on('click', () => table.button('.buttons-excel').trigger());
    $('#btnPrintTable').on('click', () => table.button('.buttons-print').trigger());
});
</script>
<?= $this->endSection() ?>
