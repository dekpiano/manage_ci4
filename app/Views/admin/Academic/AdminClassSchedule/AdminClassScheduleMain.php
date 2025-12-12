<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.5rem;
}
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 4px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานหลักสูตร /</span> จัดการตารางเรียน
            </h4>
            <p class="text-muted mb-0">ปีการศึกษา: <strong id="headerYear"><?= isset($YearAll[0]->Year) ? esc($YearAll[0]->Year) : '-' ?></strong></p>
        </div>
        <div class="col-auto">
            <a href="<?= site_url('Admin/Acade/Course/ClassSchedule/add');?>" class="btn btn-primary">
                <i class="bx bx-plus-circle me-1"></i> เพิ่มตารางเรียนใหม่
            </a>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Files -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total">0</div>
                            <div class="stat-label">ตารางเรียนทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Junior High -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-m13">0</div>
                            <div class="stat-label">มัธยมต้น (ม.1-3)</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Senior High -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-m46">0</div>
                            <div class="stat-label">มัธยมปลาย (ม.4-6)</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Files Uploaded -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-files">0</div>
                            <div class="stat-label">ไฟล์แนบแล้ว</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-file"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการตารางเรียน
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="SelYearClassSchedule" class="form-label mb-0 fw-medium">เลือกปี:</label>
                        <select name="SelYearClassSchedule" id="SelYearClassSchedule" class="form-select form-select-sm" style="width: auto; min-width: 140px;">
                            <?php foreach ($YearAll as $key => $v_YearAll) : ?>
                            <option <?= isset($v_YearAll->Year) && '1/2568' == $v_YearAll->Year ? "selected" : ""; ?>
                                value="<?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?>">
                                <?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="TbClassSchedule">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">ชื่อห้องเรียน</th>
                            <th class="cell">ชั้น/ห้อง</th>
                            <th class="cell">ปีการศึกษา</th>
                            <th class="cell">วันที่ลงข้อมูล</th>
                            <th class="cell text-center">ไฟล์ตารางสอน</th>
                            <th class="cell text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let tableClassSchedule;
    const remoteBaseUrl = '<?= getenv('upload.server.baseurl') ?>';

    // Update Dashboard Stats
    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;

        const total = data.length;
        // Count M1-3
        const m13 = data.filter(row => {
            let cls = (row.schestu_classname || '');
            return cls.match(/^[1-3]\//);
        }).length;
        
        // Count M4-6
        const m46 = data.filter(row => {
            let cls = (row.schestu_classname || '');
            return cls.match(/^[4-6]\//);
        }).length;

        // Count Files
        const files = data.filter(row => row.schestu_filename && row.schestu_filename !== '').length;

        // Animate
        $('#stat-total').fadeOut(150, function() { $(this).text(total).fadeIn(150); });
        $('#stat-m13').fadeOut(150, function() { $(this).text(m13).fadeIn(150); });
        $('#stat-m46').fadeOut(150, function() { $(this).text(m46).fadeIn(150); });
        $('#stat-files').fadeOut(150, function() { $(this).text(files).fadeIn(150); });
    }

    function loadClassSchedule(year) {
        if ($.fn.DataTable.isDataTable('#TbClassSchedule')) {
            $('#TbClassSchedule').DataTable().destroy();
        }

        tableClassSchedule = $('#TbClassSchedule').DataTable({
            responsive: true,
            processing: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
            },
            ajax: {
                url: '<?= site_url('admin/academic/ConAdminClassSchedule/getDataByYear') ?>',
                type: 'POST',
                data: { year: year },
                dataSrc: function(json) {
                    let rows = (json.data) ? json.data : json;
                    updateStats(rows);
                    return rows;
                }
            },
            columns: [
                { 
                    data: 'schestu_name',
                    render: function(data) {
                        return '<span class="fw-bold text-primary">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_classname',
                    render: function(data) {
                        return '<span class="badge bg-label-info">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_year',
                    render: function(data) {
                        return '<span class="badge bg-label-warning">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_datetime',
                    render: function(data) {
                       return '<small class="text-muted"><i class="bx bx-time me-1"></i>' + data + '</small>'; 
                    }
                },
                { 
                    data: 'schestu_filename',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data) {
                            const fullRemotePath = remoteBaseUrl + row.schestu_year + '/' + row.schestu_term + '/' + data;
                            return '<a href="' + fullRemotePath + '" target="_blank" class="btn btn-sm btn-label-secondary"><i class="bx bx-link-external me-1"></i>ดูไฟล์</a>';
                        }
                        return '<span class="text-muted">-</span>';
                    }
                },
                { 
                    data: 'schestu_id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                        <div class="dropdown">
                          <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?= site_url('Admin/Acade/Course/ClassSchedule/edit/') ?>${data}">
                                <i class="bx bx-edit-alt me-2 text-warning"></i>แก้ไข
                            </a>
                            <a class="dropdown-item delete-schedule" href="javascript:void(0);" data-id="${data}" data-filename="${row.schestu_filename}" data-year="${row.schestu_year}" data-term="${row.schestu_term}">
                                <i class="bx bx-trash me-2 text-danger"></i>ลบ
                            </a>
                          </div>
                        </div>`;
                    }
                }
            ]
        });
    }

    // Initial load
    $(document).ready(function() {
        let initialYear = $('#SelYearClassSchedule').val();
         // Initial update to header
        $('#headerYear').text(initialYear || '-');
        loadClassSchedule(initialYear);
    });

    // Handle year change
    $('#SelYearClassSchedule').on('change', function() {
        let selectedYear = $(this).val();
        $('#headerYear').text(selectedYear || '-');
        loadClassSchedule(selectedYear);
    });

    $(document).on('click', '.delete-schedule', function() {
        let id = $(this).data('id');
        let filename = $(this).data('filename');
        const year = $(this).data('year');
        const term = $(this).data('term');
        
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรายวิชาและไฟล์ที่แนบจะถูกลบถาวร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminClassSchedule/delete_class_schedule') ?>/' + id + '/' + encodeURIComponent(filename) + '/' + year + '/' + term,
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบเรียบร้อยแล้ว', 'success');
                            tableClassSchedule.ajax.reload();
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.message || 'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>