<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
    }

    /* Hero Section */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-settings::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .status-active {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Premium Card */
    .settings-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        margin-bottom: 1.5rem;
    }

    /* Table Styling Custom */
    .table-custom thead th {
        background-color: var(--light-emerald);
        color: var(--dark-emerald);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        border: none;
        padding: 1rem;
    }

    .table-custom tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f2f2f2;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.5rem 1.25rem;
        transition: all 0.3s ease;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .text-emerald {
        color: var(--primary-emerald) !important;
    }
    
    .card-title-balanced {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="animate__animated animate__fadeIn">
    <!-- Hero Section -->
    <div class="hero-settings animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-lg-8 animate__animated animate__slideInLeft">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">รายงานบันทึกคะแนนครู</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-2 text-white card-title-balanced">
                    <i class='bx bx-bar-chart-alt-2'></i>
                    <span><?= isset($title) ? esc($title) : 'รายงานผลการบันทึกคะแนนครูผู้สอน' ?></span>
                </h2>
                <div class="d-flex align-items-center mt-3">
                    <span class="status-badge status-active">
                        <i class='bx bxs-circle me-1 small animate__animated animate__pulse animate__infinite'></i>
                        ระบบพร้อมตรวจสอบ
                    </span>
                    <span class="text-white-50 ms-3 small d-flex align-items-center">
                        <i class='bx bx-calendar-event me-1'></i> ภาคเรียน/ปีการศึกษา: <?= (isset($Term) ? esc($Term) : '-').'/'.(isset($Year) ? esc($Year) : '-') ?>
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block animate__animated animate__zoomIn">
                <i class='bx bx-stats text-white opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards Row -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm">
                        <i class='bx bx-group'></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark"><?= count($Teacher ?? []) ?></h3>
                    <p class="text-muted mb-0 small uppercase fw-bold">จำนวนครูทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm">
                        <i class='bx bx-category'></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">
                        <?php 
                            $uniqueLearning = [];
                            foreach ($Teacher ?? [] as $t) { if (!empty($t->lear_namethai)) $uniqueLearning[$t->lear_namethai] = true; }
                            echo count($uniqueLearning);
                        ?>
                    </h3>
                    <p class="text-muted mb-0 small uppercase fw-bold">กลุ่มสาระการเรียนรู้</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(255, 171, 0, 0.1); color: #ffab00;">
                        <i class='bx bx-calendar'></i>
                    </div>
                    <label class="form-label text-muted small mb-1 d-block fw-bold">เปลี่ยนปีการศึกษา</label>
                    <select class="form-select border-0 bg-light fw-bold text-dark text-center" name="CheckYearSaveScore" id="CheckYearSaveScore">
                        <?php foreach ($CheckYearSaveScore as $value) : ?>
                        <option <?= (isset($Term) ? $Term : '').'/'.(isset($Year) ? $Year : '') == (isset($value->RegisterYear) ? $value->RegisterYear : '') ? "selected" : ""?> 
                            value="<?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>">
                            <?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(21, 163, 98, 0.1); color: var(--primary-emerald);">
                        <i class='bx bx-printer'></i>
                    </div>
                    <p class="text-muted mb-2 small fw-bold">เครื่องมือรายงาน</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-emerald btn-sm rounded-pill" id="btnPrint">
                            <i class='bx bx-printer'></i>
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm rounded-pill" id="btnExportExcel">
                            <i class='bx bx-file'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Card -->
    <div class="card settings-card border-top border-emerald border-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
        <div class="card-header bg-white border-bottom-0 py-4 px-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-label-success me-3 mb-0" style="width: 45px; height: 45px; font-size: 1.25rem;">
                        <i class='bx bx-list-ul text-emerald'></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0 fw-bold">รายชื่อครูผู้สอนในระบบ</h5>
                        <small class="text-muted">ตรวจสอบสถานะการบันทึกคะแนน แยกตามกลุ่มสาระฯ</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0" id="teacherTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>ครูผู้สอน / ข้อมูลบัตร</th>
                            <th>กลุ่มสาระการเรียนรู้</th>
                            <th>ตำแหน่ง</th>
                            <th class="text-center">ปีการศึกษา</th>
                            <th class="text-center" style="width: 130px;">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php foreach ($Teacher as $key => $v_Teacher) : ?>
                        <tr>
                            <td class="text-center text-muted small"><?= $key + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2 bg-label-emerald rounded-circle">
                                        <span class="avatar-initial fs-6"><?= mb_substr($v_Teacher->pers_firstname, 0, 1) ?></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold"><?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').esc($v_Teacher->pers_firstname).' '.esc($v_Teacher->pers_lastname) ?></h6>
                                        <small class="text-muted"><i class='bx bx-fingerprint me-1'></i> <?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '-' ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-emerald rounded-pill px-3">
                                    <?= isset($v_Teacher->lear_namethai) ? esc($v_Teacher->lear_namethai) : '-' ?>
                                </span>
                            </td>
                            <td>
                                <div class="text-dark small fw-semibold">
                                    <i class='bx bx-briefcase me-1 text-muted'></i>
                                    <?= isset($v_Teacher->posi_name) ? esc($v_Teacher->posi_name) : '-' ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark fw-bold border">
                                    <?= (isset($Term) ? esc($Term) : '').'/'.(isset($Year) ? esc($Year) : '') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php $level = service('request')->getUri()->getSegment(3) ?? ''; ?>
                                <a class="btn btn-emerald btn-sm rounded-pill px-3 shadow-none"
                                    href="<?= site_url('Admin/Acade/'.esc($level, 'url').'/ReportTeacherSaveScoreCheck/'.(isset($Term) ? esc($Term, 'url') : '').'/'.(isset($Year) ? esc($Year, 'url') : '').'/'.(isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id, 'url') : ''));?>">
                                    <i class='bx bx-search-alt me-1'></i> รายละเอียด
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
    // Dropdown Sorting
    var select = $('#CheckYearSaveScore');
    var options = select.find('option');
    var selectedValue = select.val();

    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        return (parseInt(bVal[1]) - parseInt(aVal[1])) || (parseInt(bVal[0]) - parseInt(aVal[0]));
    });

    select.empty().append(options).val(selectedValue);

    // DataTable Init
    $('#teacherTable').DataTable({
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการ",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "search": "ค้นหาครู:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "stateSave": true,
        "pageLength": 25,
        "order": [[2, "asc"]]
    });

    // Handle Year Change
    $(document).on("change", "#CheckYearSaveScore", function () {
        let selectedYear = $(this).val();
        let currentUrl = window.location.pathname;
        let path = currentUrl.includes('Executive') ? 'Executive' : 'Evaluate';
        const baseUrl = "<?= site_url('Admin/Acade') ?>/" + path + "/ReportTeacherSaveScore";
        
        if (selectedYear) {
            Swal.fire({
                title: 'กำลังกรองข้อมูล...', allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            window.location.href = baseUrl + '/' + selectedYear;
        }
    });

    $('#btnExportExcel').on('click', function() {
        Swal.fire({ icon: 'info', title: 'ฟังก์ชัน Excel', text: 'กำลังพัฒนาระบบสถิติส่งออก', timer: 2000, showConfirmButton: false });
    });

    $('#btnPrint').on('click', function() { window.print(); });
});
</script>
<?= $this->endSection() ?>
