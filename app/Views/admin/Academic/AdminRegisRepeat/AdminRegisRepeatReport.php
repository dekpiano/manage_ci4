<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Blue Theme #0d6efd ===== */
:root {
    --primary-blue: #0d6efd;
    --primary-blue-dark: #0a58ca;
    --primary-blue-light: #3d8bfd;
    --gradient-blue: linear-gradient(135deg, #0d6efd 0%, #3d8bfd 50%, #0dcaf0 100%);
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: var(--gradient-blue);
    border-radius: 16px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(13, 110, 253, 0.25);
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

.welcome-banner .content { position: relative; z-index: 1; }
.welcome-banner h1 { font-size: 1.6rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.welcome-banner p { color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin: 0; }
.welcome-banner .icon-wrapper {
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.12);
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}

/* ===== Filter Card ===== */
.filter-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* ===== Table Card ===== */
.table-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.075);
}

.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem;
}

/* ===== DataTables Styling ===== */
#tbRepeatReport thead th {
    background: #f8f9fa;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #495057;
    padding: 1rem;
    border-bottom: 2px solid #e9ecef;
}

#tbRepeatReport tbody td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
}

/* ===== Badges ===== */
.badge-status {
    padding: 0.4rem 0.7rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.75rem;
}

.bg-light-success { background: rgba(25, 135, 84, 0.1); color: #198754; }
.bg-light-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
.bg-light-info { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; }

</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-bar-chart-alt-2 me-2"></i><?= isset($title) ? esc($title) : 'รายงานการลงทะเบียนเรียนซ้ำ' ?></h1>
                    <p>ตรวจสอบและติดตามสถานะนักเรียนที่ลงทะเบียนเรียนซ้ำรายบุคคล</p>
                </div>
                <div class="col text-end">
                    <a href="<?= site_url('Admin/Acade/Registration/Repeat') ?>" class="btn btn-light">
                        <i class="bx bx-arrow-back me-1"></i>กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
        <div class="icon-wrapper">
            <i class="bx bx-file-find"></i>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <?php $activeRepYear = isset($selectedYear) ? $selectedYear : get_selected_year(); ?>
                    <select id="FilterYear" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <?php foreach($GroupYear as $v_year): ?>
                            <option value="<?= esc($v_year->RepeatYear) ?>" <?= ($activeRepYear == $v_year->RepeatYear) ? 'selected' : '' ?>><?= esc($v_year->RepeatYear) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">สถานะ</label>
                    <select id="FilterStatus" class="form-select">
                        <option value="ทั้งหมด">ทั้งหมด</option>
                        <option value="ไม่ผ่าน">กำลังเรียนซ้ำ</option>
                        <option value="ผ่าน">เรียนซ้ำสำเร็จ</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">ครั้งที่เรียนซ้ำ</label>
                    <select id="FilterAttempt" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <option value="เรียนซ้ำครั้งที่ 1">ครั้งที่ 1</option>
                        <option value="เรียนซ้ำครั้งที่ 2">ครั้งที่ 2</option>
                        <option value="เรียนซ้ำครั้งที่ 3">ครั้งที่ 3</option>
                        <option value="เรียนซ้ำครั้งที่ 4">ครั้งที่ 4</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ค้นหา</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" id="SearchBox" class="form-control" placeholder="ค้นหาชื่อ, รหัสวิชา, ห้องเรียน...">
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-primary w-100" id="BtnExportExcel">
                        <i class="bx bx-export me-1"></i>ส่งออก Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table Card -->
    <div class="card table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bx bx-list-check me-2 text-primary"></i>รายการลงทะเบียนเรียนซ้ำ</h5>
            <div class="d-flex gap-2">
                <span class="badge bg-light-info" id="TotalCount">ทั้งหมด 0 รายการ</span>
                <span class="badge bg-light-warning" id="PendingCount">กำลังเรียน 0</span>
                <span class="badge bg-light-success" id="SuccessCount">สำเร็จ 0</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover w-100" id="tbRepeatReport">
                    <thead>
                        <tr>
                            <th>นักเรียน</th>
                            <th>ห้อง/เลขที่</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th>ครั้งที่</th>
                            <th>ปีที่เรียนซ้ำ</th>
                            <th>ครูที่ดูแล</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    let table = $('#tbRepeatReport').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatReportData') ?>",
            type: "POST",
            data: function(d) {
                d.year = $('#FilterYear').val();
                d.status = $('#FilterStatus').val();
                d.attempt = $('#FilterAttempt').val();
            }
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row) {
                    return `<div>
                                <div class="fw-bold">${row.StudentPrefix}${row.StudentFirstName} ${row.StudentLastName}</div>
                                <small class="text-muted">รหัส: ${row.StudentCode}</small>
                            </div>`;
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    return `<div>${row.StudentClass}</div><small class="text-muted">เลขที่ ${row.StudentNumber}</small>`;
                }
            },
            { data: 'SubjectCode' },
            { data: 'SubjectName' },
            { 
                data: 'Grade_Type',
                render: function(data) {
                    return data ? `<span class="badge bg-label-warning">${data}</span>` : '-';
                }
            },
            { data: 'RepeatYear' },
            { 
                data: 'RepeatTeacherName',
                render: function(data) {
                    return data ? `<span class="text-primary fw-medium"><i class="bx bx-user me-1"></i>${data}</span>` : '-';
                }
            },
            { 
                data: 'RepeatStatus',
                className: 'text-center',
                render: function(data) {
                    if (data === 'ผ่าน') {
                        return '<span class="badge-status bg-light-success"><i class="bx bx-check-circle me-1"></i>สำเร็จ</span>';
                    } else {
                        return '<span class="badge-status bg-light-warning"><i class="bx bx-time-five me-1"></i>กำลังเรียน</span>';
                    }
                }
            }
        ],
        drawCallback: function(settings) {
            let json = settings.json;
            if (json && json.data) {
                let total = json.data.length;
                let success = json.data.filter(i => i.RepeatStatus === 'ผ่าน').length;
                let pending = total - success;
                
                $('#TotalCount').text(`ทั้งหมด ${total} รายการ`);
                $('#SuccessCount').text(`สำเร็จ ${success}`);
                $('#PendingCount').text(`กำลังเรียน ${pending}`);
            }
        },
        dom: 'rt<"d-flex justify-content-between p-3"ip>',
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        },
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'รายงานการลงทะเบียนเรียนซ้ำ_' + new Date().toLocaleDateString(),
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    // Custom Filters
    $('#FilterYear, #FilterStatus, #FilterAttempt').change(function() {
        table.ajax.reload();
    });

    $('#SearchBox').keyup(function() {
        table.search($(this).val()).draw();
    });

    $('#BtnExportExcel').click(function() {
        table.button('.buttons-excel').trigger();
    });
});
</script>
<?= $this->endSection() ?>
