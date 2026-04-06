<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-green: #15a362;
        --secondary-green: #198754;
        --light-green: #e8f5e9;
        --border-radius: 16px;
    }

    /* Modern Card Styling */
    .card-modern {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 10px 30px rgba(144, 163, 179, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-modern:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(144, 163, 179, 0.15); }

    /* Prominent Filter Card */
    .filter-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafb 100%);
        border-left: 5px solid var(--primary-green);
    }

    /* Stats Cards Gradients */
    .grad-students { background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); }
    .grad-year { background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); }
    .grad-status { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); }

    /* Table Styling */
    .table-modern thead th {
        background-color: #f8fafb !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #edf1f4 !important;
        padding: 15px 20px !important;
    }
    .table-modern tbody td {
        padding: 12px 20px !important;
        border-bottom: 1px solid #f1f3f5 !important;
    }

    /* Select2 Green Tweak */
    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid #edf1f4;
        border-radius: 12px !important;
        height: 50px !important;
        display: flex;
        align-items: center;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important;
    }

    /* Button Styling */
    .btn-view-report {
        background-color: var(--primary-green);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    .btn-view-report:hover {
        background-color: var(--secondary-green);
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(21, 163, 98, 0.3);
        color: white;
    }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 0.5s ease forwards; }
</style>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h4 class="fw-bold mb-1">
            <i class='bx bxs-user-detail text-success me-2'></i>
            <?= isset($title) ? esc($title) : 'รายงานผลการเรียนรายบุคคล' ?>
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home-alt'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-muted">งานทะเบียน</a></li>
                <li class="breadcrumb-item active text-success font-weight-bold">รายงานผลการเรียนรายบุคคล</li>
            </ol>
        </nav>
    </div>
</div>

<?php
    $level = service('request')->getUri()->getSegment(3) ?? 'Evaluate';
    $baseUrl = ($level === 'Executive')
        ? site_url('Admin/Acade/Executive/ReportPerson')
        : site_url('Admin/Acade/Evaluate/ReportPerson');
?>


<!-- Prominent Filter Section -->
<div class="card card-modern filter-card mb-4 fade-in-up" style="animation-delay: 0.1s;">
    <div class="card-body py-4">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-3 mb-lg-0">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class='bx bx-filter-alt text-success fs-3'></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">กรองข้อมูลปีการศึกษา</h5>
                        <p class="text-muted mb-0 small">เลือกปีและห้องเพื่อตรวจสอบ</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2 mb-lg-0">
                <select class="form-select select2" name="CheckYearSaveScore" id="CheckYearSaveScore" data-base-url="<?= $baseUrl ?>">
                    <option value="">-- เลือกปีการศึกษา --</option>
                    <?php if(isset($CheckYearSaveScore)): ?>
                        <?php foreach ($CheckYearSaveScore as $value) : ?>
                        <option <?= (isset($Term) && isset($Year) && ($Term.'/'.$Year) == $value->RegisterYear) ? "selected" : ""?> value="<?= esc($value->RegisterYear) ?>">
                            ปีการศึกษา <?= esc($value->RegisterYear) ?>
                        </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-lg-2 mb-2 mb-lg-0">
                <select class="form-select select2" name="SelectRoom" id="SelectRoom">
                    <option value="">-- ทุกระดับชั้น --</option>
                    <?php if(isset($RoomList)): ?>
                        <?php foreach ($RoomList as $v_room) : ?>
                        <option value="<?= esc($v_room) ?>" <?= (isset($SelRoom) && $SelRoom == $v_room) ? "selected" : "" ?>><?= esc($v_room) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-success w-100 btn-smooth" id="btnSearchReport" style="border-radius: 12px; height: 50px;">
                    <i class='bx bx-search-alt me-1'></i> ค้นหา
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4 fade-in-up" style="animation-delay: 0.2s;">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm card-modern grad-students h-100">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">จำนวนนักเรียนทั้งหมด</h6>
                        <h2 class="mb-0 fw-bold"><?= count($stu ?? []) ?> <small class="fs-6 fw-normal">คน</small></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bxs-user-account fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm card-modern grad-year h-100">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ข้อมูลประจำภาคเรียน</h6>
                        <h2 class="mb-0 fw-bold"><?= (isset($Term) ? esc($Term) : '-').'/'.(isset($Year) ? esc($Year) : '-') ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bxs-calendar-event fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm card-modern grad-status h-100">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">สถานะข้อมูล</h6>
                        <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">พร้อมใช้งาน (<?= date('d/m/Y') ?>)</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bxs-check-shield fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student List Table Card -->
<div class="card card-modern fade-in-up" style="animation-delay: 0.3s;">
    <div class="card-header bg-white border-bottom-0 py-4" style="border-radius: var(--border-radius) var(--border-radius) 0 0;">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                    <i class='bx bx-list-check text-success fs-4'></i>
                </div>
                <div>
                    <h5 class="card-title mb-0 fw-bold">รายชื่อนักเรียนตามปีการศึกษา</h5>
                    <p class="text-muted mb-0 small">จัดการและตรวจสอบผลการเรียนรายบุคคล</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-4">
            <table class="table table-hover table-modern align-middle mb-0" id="studentTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">เลขประจำตัว</th>
                        <th class="text-center" style="width: 70px;">เลขที่</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th class="text-center">ระดับชั้น</th>
                        <th class="text-center" style="width: 180px;">ตัวเลือกการตรวจสอบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($stu)): ?>
                    <?php foreach ($stu as $key => $v_stu) : ?>
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-label-secondary font-weight-bold"><?= isset($v_stu->StudentCode) ? esc($v_stu->StudentCode) : '' ?></span>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold"><?= isset($v_stu->StudentNumber) ? esc($v_stu->StudentNumber) : '' ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="text-success small fw-bold"><?= mb_substr($v_stu->StudentFirstName ?? '', 0, 1) ?></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark"><?= (isset($v_stu->StudentPrefix) ? esc($v_stu->StudentPrefix) : '').(isset($v_stu->StudentFirstName) ? esc($v_stu->StudentFirstName) : '').' '.(isset($v_stu->StudentLastName) ? esc($v_stu->StudentLastName) : '') ?></span>
                                    <small class="text-muted" style="font-size: 0.7rem;">ID Card: <?= isset($v_stu->StudentIDNumber) ? esc($v_stu->StudentIDNumber) : '-' ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-outline-success text-white" style="border: 1px solid #15a362; color: #15a362;"><?= isset($v_stu->StudentClass) ? esc($v_stu->StudentClass) : '' ?></span>
                        </td>
                        <td class="text-center">
                            <?php $level = service('request')->getUri()->getSegment(3) ?? ''; ?>
                            <a class="btn btn-view-report btn-sm w-100 clickLoad-spin"
                                href="<?= site_url('Admin/Acade/'.($level === "Executive" ? 'Executive' : 'Evaluate').'/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                <i class='bx bx-search-alt-2 me-1'></i> ตรวจสอบผลการเรียน
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize Select2 with Bootstrap 5 Theme
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Sort the dropdown
    var select = $('#CheckYearSaveScore');
    var options = select.find('option').not('[value=""]');
    var selectedValue = select.val();
    
    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        var aYear = parseInt(aVal[1], 10);
        var bYear = parseInt(bVal[1], 10);
        var aTerm = parseInt(aVal[0], 10);
        var bTerm = parseInt(bVal[0], 10);

        if (aYear !== bYear) return bYear - aYear;
        return bTerm - aTerm;
    });

    select.find('option').not('[value=""]').remove();
    select.append(options);
    select.val(selectedValue);

    // Initialize DataTable
    $('#studentTable').DataTable({
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการ",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "search": "ค้นหาด่วน:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "dom": '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        "stateSave": true,
        "order": [[3, "asc"], [1, "asc"]],
        "pageLength": 15
    });

    // Handle Search Button click
    $('#btnSearchReport').on('click', function() {
        let selectedYear = $('#CheckYearSaveScore').val();
        let selectedRoom = $('#SelectRoom').val();
        const baseUrl = $('#CheckYearSaveScore').data('base-url');

        if (!selectedYear) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', confirmButtonColor: '#15a362' });
            return;
        }

        let targetUrl = baseUrl + '/' + selectedYear;
        if (selectedRoom) {
            targetUrl += '?room=' + encodeURIComponent(selectedRoom);
        }

        Swal.fire({
            title: 'กำลังดึงข้อมูลนักเรียน...',
            text: 'ระบบกำลังประมวลผลข้อมูลรายบุคคล กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        window.location.href = targetUrl;
    });

    // Handle dropdown year change (to refresh rooms list)
    $(document).on("change", "#CheckYearSaveScore", function () {
        let selectedYear = $(this).val();
        const baseUrl = $(this).data('base-url');
        if (baseUrl && selectedYear) {
            window.location.href = baseUrl + '/' + selectedYear;
        }
    });

    // Refresh Button
    $('#btnRefresh').on('click', function() {
        location.reload();
    });
});
</script>
<?= $this->endSection() ?>
