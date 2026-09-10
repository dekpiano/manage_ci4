<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --secondary-green: #2ecc71;
        --soft-bg: #f8fafc;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        --hover-shadow: 0 10px 24px rgba(21, 163, 98, 0.12);
        --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .registration-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bg-light-green {
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: var(--primary-green) !important;
    }

    .stats-card {
        background: #ffffff;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .stats-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .card-border-green { border-bottom: 3.5px solid var(--primary-green) !important; }
    .card-border-success { border-bottom: 3.5px solid var(--secondary-green) !important; }
    .card-border-danger { border-bottom: 3.5px solid #ff3e1d !important; }
    .card-border-info { border-bottom: 3.5px solid #03c3ec !important; }

    #studentClubRegisTable thead th { 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.5px; 
        color: #566a7f;
        background-color: #f8fafc !important;
        border-bottom: 2px solid rgba(21, 163, 98, 0.15) !important;
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
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
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="page-title">
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน / ชุมนุม /</span> ข้อมูลการลงทะเบียน
            </h4>
            <div class="text-muted small">ตรวจสอบและส่งออกข้อมูลนักเรียนที่ลงทะเบียนในแต่ละชุมนุม</div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="text-success">หน้าแรกพัฒนาผู้เรียน</a></li>
                <li class="breadcrumb-item active">ข้อมูลการลงทะเบียน</li>
            </ol>
        </nav>
    </div>

    <!-- Quick Stats Tiles - 4 Balanced KPI Cards -->
    <div class="row g-3 mb-4 stats-row">
        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-green h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">นักเรียนทั้งหมด</span>
                        <div class="stats-avatar bg-light-green">
                            <i class="bx bx-group text-success"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="totalStudents">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">ตามฐานข้อมูลปัจจุบัน</small>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-success h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ลงทะเบียนแล้ว</span>
                        <div class="stats-avatar bg-light-green">
                            <i class="bx bx-check-circle text-success"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-success" id="registeredStudents">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-success fw-semibold" id="regisPercent" style="font-size: 0.75rem;">คิดเป็น 0%</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-danger h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ยังไม่เลือกชุมนุม</span>
                        <div class="stats-avatar" style="background-color: rgba(255, 62, 29, 0.08) !important;">
                            <i class="bx bx-error-circle text-danger"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-danger" id="notRegisteredStudents">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-danger fw-semibold" id="unregisPercent" style="font-size: 0.75rem;">รอลงทะเบียน 0%</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stats-card card-border-info h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">อัตราลงทะเบียนรวม</span>
                        <div class="stats-avatar" style="background-color: rgba(3, 195, 236, 0.08) !important;">
                            <i class="bx bx-pie-chart-alt-2 text-info"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-info" id="completionRateDisplay">0%</h4>
                    </div>
                    <div class="progress mt-2" style="height: 5px; background-color: #f0f2f5; border-radius: 6px;">
                        <div class="progress-bar bg-info" id="overallProgressBar" role="progressbar" style="width: 0%; border-radius: 6px;"></div>
                    </div>
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
                <div>
                    <h5 class="mb-0 fw-bold">รายชื่อนักเรียนและสถานะการลงทะเบียน</h5>
                    <small class="text-muted">ตรวจสอบรายชื่อนักเรียนและชุมนุมที่เลือก</small>
                </div>
            </div>
            
            <!-- Toolbar Filters & Actions -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Classroom Filter -->
                <div class="input-group input-group-merge shadow-sm" style="min-width: 170px;">
                    <span class="input-group-text bg-light border-end-0 py-1"><i class="bx bx-door-open text-muted"></i></span>
                    <select id="filterClassroom" class="form-select border-start-0 py-1 fw-semibold small">
                        <option value="">ทุกห้องเรียน</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="input-group input-group-merge shadow-sm" style="min-width: 180px;">
                    <span class="input-group-text bg-light border-end-0 py-1"><i class="bx bx-filter text-muted"></i></span>
                    <select id="filterStatus" class="form-select border-start-0 py-1 fw-semibold small">
                        <option value="">ทุกสถานะ</option>
                        <option value="registered">ลงทะเบียนแล้ว</option>
                        <option value="not_registered">ยังไม่ได้เลือกชุมนุม</option>
                    </select>
                </div>

                <div class="btn-group shadow-sm">
                    <button type="button" class="btn btn-outline-success px-3 py-1" id="btnExportExcel" title="ส่งออกข้อมูลเป็นไฟล์ Excel">
                        <i class="bx bx-spreadsheet me-1"></i> Excel
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-3 py-1" id="btnPrintTable" title="พิมพ์หน้ารายการนี้">
                        <i class="bx bx-printer me-1"></i> พิมพ์
                    </button>
                </div>
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
                                    <span class="visually-hidden">กำลังโหลด...</span>
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
    // Load Classrooms for Filter
    $.get('<?= base_url("admin/academic/ConAdminDevelopStudents/ClubGetClassroom") ?>', function(res) {
        if(res.classrooms) {
            res.classrooms.forEach(c => {
                $('#filterClassroom').append(`<option value="${c.StudentClass}">${c.StudentClass}</option>`);
            });
        }
    });

    // Custom DataTables filter for Status (Registered vs Not Registered)
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex, rowData, counter) {
            if (!settings || !settings.nTable || settings.nTable.id !== 'studentClubRegisTable') return true;
            const statusFilter = $('#filterStatus').val();
            if (!statusFilter) return true;
            const isNotRegis = (rowData && rowData.club_name === 'ยังไม่ได้เลือกชุมนุม');
            if (statusFilter === 'registered') {
                return !isNotRegis;
            } else if (statusFilter === 'not_registered') {
                return isNotRegis;
            }
            return true;
        }
    );

    // Initialize DataTable
    const table = $('#studentClubRegisTable').DataTable({
        "processing": true,
        "ajax": {
            "url": "<?= base_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub') ?>",
            "type": "GET",
            "dataSrc": function(json) {
                updateQuickStats(json.data || []);
                return json.data || [];
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
                        return `<span class="badge bg-label-danger px-2 py-1"><i class="bx bx-error-circle me-1"></i>${data}</span>`;
                    } else {
                        return `<span class="badge bg-label-success px-2 py-1"><i class="bx bx-check-double me-1"></i>${data}</span>`;
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

    // Filter by Status
    $('#filterStatus').on('change', function() {
        table.draw();
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
        $('#completionRateDisplay').text(`${regisPercent}%`);
        $('#overallProgressBar').css('width', `${regisPercent}%`);
    }

    // Export & Print Connectors
    $('#btnExportExcel').on('click', () => table.button('.buttons-excel').trigger());
    $('#btnPrintTable').on('click', () => table.button('.buttons-print').trigger());
});
</script>
<?= $this->endSection() ?>
