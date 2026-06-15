<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=K2D:wght@200;300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #15a362;
        --primary-green-rgb: 21, 163, 98;
        --secondary-green: #2ecc71;
        --soft-bg: #f8fafc;
        --card-shadow: 0 8px 26px rgba(0, 0, 0, 0.03);
        --hover-shadow: 0 15px 30px rgba(21, 163, 98, 0.1);
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Outfit', 'K2D', sans-serif !important;
        background-color: var(--soft-bg);
    }

    /* Mobile First Padding */
    .registration-container {
        padding: 1rem;
        animation: fadeIn 0.6s ease-out;
    }

    @media (min-width: 768px) {
        .registration-container {
            padding: 2rem;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Green Theme Badges & Overrides */
    .bg-light-green {
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: var(--primary-green) !important;
    }

    /* Stat Cards - Mobile First Grid */
    .stats-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--hover-shadow);
    }

    .stats-card .card-body {
        padding: 1rem;
    }

    @media (min-width: 768px) {
        .stats-card .card-body {
            padding: 1.5rem;
        }
    }

    .stats-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    @media (min-width: 768px) {
        .stats-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            font-size: 1.5rem;
        }
    }

    /* Borders matching green and colors */
    .card-border-green { border-bottom: 3.5px solid var(--primary-green) !important; }
    .card-border-success { border-bottom: 3.5px solid var(--secondary-green) !important; }
    .card-border-danger { border-bottom: 3.5px solid #ff3e1d !important; }

    /* Custom Table Style */
    #studentClubRegisTable thead th { 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.5px; 
        color: #566a7f;
        background-color: rgba(21, 163, 98, 0.05) !important;
        border-bottom: 2px solid rgba(21, 163, 98, 0.15) !important;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Search & Page Length Controls spacing for mobile */
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 1rem;
    }

    @media (min-width: 768px) {
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem 1.5rem;
        }
    }

    .page-link.active, .active > .page-link {
        background-color: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
    }

    .btn-outline-success {
        color: var(--primary-green);
        border-color: var(--primary-green);
    }
    .btn-outline-success:hover {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: #ffffff;
    }

    @media print {
        .container-p-y { padding: 0 !important; }
        .breadcrumb, .stats-row, .card-header .btn, #studentClubRegisTable_length, #studentClubRegisTable_filter, #studentClubRegisTable_paginate { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        table { width: 100% !important; border: 1px solid #eee !important; }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y registration-container">
    <!-- Page Header - Mobile First -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="page-title">
            <h4 class="fw-bold py-1 mb-0" style="font-size: calc(1.1rem + 0.5vw);">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน / ชุมนุม /</span> ข้อมูลการลงทะเบียน
            </h4>
            <div class="text-muted small">ตรวจสอบและส่งออกข้อมูลนักเรียนที่ลงทะเบียนในแต่ละชุมนุม</div>
        </div>
        <nav aria-label="breadcrumb" class="d-none d-sm-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="text-success">หน้าแรกชุมนุม</a></li>
                <li class="breadcrumb-item active">ข้อมูลการลงทะเบียน</li>
            </ol>
        </nav>
    </div>

    <!-- Quick Stats Tiles - 2 Columns on Mobile, 4 Columns on Desktop -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-green h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stats-avatar bg-light-green me-2">
                            <i class="bx bx-user text-success"></i>
                        </div>
                        <h4 class="ms-1 mb-0 fw-bold" id="totalStudents" style="font-size: calc(1rem + 0.4vw);">0</h4>
                    </div>
                    <p class="mb-0 text-muted small">นักเรียนในระบบ</p>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stats-avatar bg-light-green me-2">
                            <i class="bx bx-check-circle text-success"></i>
                        </div>
                        <h4 class="ms-1 mb-0 fw-bold" id="registeredStudents" style="font-size: calc(1rem + 0.4vw);">0</h4>
                    </div>
                    <p class="mb-0 text-muted small text-truncate" id="regisPercent">ลงทะเบียนแล้ว (0%)</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stats-avatar bg-light-danger me-2" style="background-color: rgba(255, 62, 29, 0.08) !important;">
                            <i class="bx bx-error-circle text-danger"></i>
                        </div>
                        <h4 class="ms-1 mb-0 fw-bold" id="notRegisteredStudents" style="font-size: calc(1rem + 0.4vw);">0</h4>
                    </div>
                    <p class="mb-0 text-muted small text-truncate" id="unregisPercent">ยังไม่เลือกชุมนุม (0%)</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stats-card h-100">
                <div class="card-body d-flex flex-column justify-content-center h-100">
                    <label class="form-label fw-bold text-uppercase mb-1" style="font-size: 0.75rem;"><i class="bx bx-filter-alt me-1 text-success"></i> กรองห้องเรียน</label>
                    <select id="filterClassroom" class="form-select select2 py-1">
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
                <div class="p-2 bg-light-green rounded me-1">
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
                    <thead>
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
                                <div class="spinner-border text-success" role="status">
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
            "emptyTable": "ไม่มีข้อมูลในตาราง",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
            "infoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
            "infoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "แสดง _MENU_ แถว",
            "loadingRecords": "กำลังโหลดข้อมูล...",
            "processing": "กำลังดำเนินการ...",
            "search": "ค้นหา:",
            "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            },
            "aria": {
                "sortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                "sortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
            }
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
