<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
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

    /* Premium Cards */
    .settings-card { border: none; border-radius: 1.25rem; box-shadow: 0 5px 20px rgba(0,0,0,0.03); transition: transform 0.3s ease; }
    .icon-wrapper { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; background: var(--light-emerald); color: var(--primary-emerald); margin-bottom: 1rem; }

    /* Table Styling */
    .table-modern thead th { background-color: var(--light-emerald) !important; color: var(--dark-emerald); font-weight: 700; font-size: 0.75rem; padding: 15px 20px !important; border-bottom: 2px solid rgba(21, 163, 98, 0.1) !important; }
    .table-modern tbody td { padding: 12px 20px !important; }

    /* Button and UI */
    .btn-emerald { background-color: var(--primary-emerald); border-color: var(--primary-emerald); color: white; font-weight: 600; border-radius: 10px; padding: 0.6rem 1.25rem; transition: all 0.3s ease; }
    .btn-emerald:hover { background-color: var(--dark-emerald); color: white; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2); }

    .select2-container--bootstrap-5 .select2-selection { border: 2px solid #edf1f4; border-radius: 12px !important; min-height: 48px; display: flex; align-items: center; }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection { border-color: var(--primary-emerald) !important; box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important; }

    .avatar-init { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; background: var(--light-emerald); color: var(--primary-emerald); }
</style>

<div class="animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 small">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ตรวจสอบผลการเรียนรายบุคคล</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-2 text-white">
                    <i class='bx bxs-user-detail me-2'></i>
                    <span><?= isset($title) ? esc($title) : 'รายงานผลการเรียนรายบุคคล' ?></span>
                </h2>
                <div class="d-flex align-items-center mt-3">
                    <span class="status-badge status-active">
                        <i class='bx bxs-circle me-1 small animate__animated animate__pulse animate__infinite'></i>
                        เลือกนักเรียนเพื่อดูคะแนนสะสม
                    </span>
                    <?php if(isset($Term)): ?>
                    <span class="ms-3 text-white-50"><i class='bx bx-calendar me-1'></i> ภาคเรียน <?= esc($Term) ?>/<?= esc($Year) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class='bx bxs-group text-white opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <?php
        $levelStr = service('request')->getUri()->getSegment(3) ?? 'Evaluate';
        $baseUrlStr = site_url("Admin/Acade/{$levelStr}/ReportPerson");
    ?>
    <div class="card settings-card border-start border-emerald border-5 mb-4">
        <div class="card-body py-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-bold text-dark small">ปีการศึกษา</label>
                    <select class="form-select select2" id="CheckYearSaveScore" data-base-url="<?= $baseUrlStr ?>">
                        <option value="">-- เลือกปีการศึกษา --</option>
                        <?php if(isset($CheckYearSaveScore)): ?>
                            <?php 
                                $activeReportYear = (isset($Term) && isset($Year) && !empty($Term) && !empty($Year)) ? ($Term . '/' . $Year) : get_selected_year();
                            ?>
                            <?php foreach ($CheckYearSaveScore as $value) : ?>
                            <option <?= ($activeReportYear == $value->RegisterYear) ? "selected" : ""?> value="<?= esc($value->RegisterYear) ?>">
                                ปีการศึกษา <?= esc($value->RegisterYear) ?>
                            </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-bold text-dark small">ระดับชั้น/ห้อง</label>
                    <select class="form-select select2" id="SelectRoom">
                        <option value="">-- แสดงทุกห้องเรียน --</option>
                        <?php if(isset($RoomList)): ?>
                            <?php foreach ($RoomList as $v_room) : ?>
                            <option value="<?= esc($v_room) ?>" <?= (isset($SelRoom) && $SelRoom == $v_room) ? "selected" : "" ?>><?= esc($v_room) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-emerald w-100" id="btnSearchReport">
                        <i class='bx bx-search-alt me-1'></i> ค้นหารายชื่อ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conditional Results Content -->
    <?php if(isset($hasResults) && $hasResults): ?>
        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card settings-card">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mx-auto shadow-sm">
                            <i class='bx bxs-user-account'></i>
                        </div>
                        <h3 class="fw-bold mb-1"><?= count($stu ?? []) ?></h3>
                        <p class="text-muted mb-0 small fw-bold uppercase">จำนวนนักเรียนที่แสดง</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card settings-card">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(26, 188, 156, 0.1); color: #1abc9c;">
                            <i class='bx bxs-calendar-event'></i>
                        </div>
                        <h3 class="fw-bold mb-1"><?= ($Term ?? '-').'/'.($Year ?? '-') ?></h3>
                        <p class="text-muted mb-0 small fw-bold uppercase">ปีการศึกษาที่เลือก</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card settings-card">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                            <i class='bx bxs-check-shield'></i>
                        </div>
                        <h3 class="fw-bold mb-1">พร้อมใช้</h3>
                        <p class="text-muted mb-0 small fw-bold uppercase">สถานะฐานข้อมูลปกติ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Table Card -->
        <div class="card settings-card">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar-init me-3"><i class='bx bx-list-ol'></i></div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">บัญชีรายชื่อนักเรียน</h5>
                        <small class="text-muted">คลิกเพื่อเข้าดูรายละเอียดคะแนนและเกรด</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-modern align-middle" id="studentTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">เลขอ่าน</th>
                                <th class="text-center" style="width: 60px;">เลขที่</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th class="text-center">ระดับชั้น</th>
                                <th class="text-center" style="width: 200px;">การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stu as $v_stu) : ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= esc($v_stu->StudentCode) ?></td>
                                <td class="text-center fw-bold"><?= esc($v_stu->StudentNumber) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-init me-3" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                            <?= mb_substr($v_stu->StudentFirstName ?? 'S', 0, 1) ?>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark"><?= esc($v_stu->StudentPrefix . $v_stu->StudentFirstName . ' ' . $v_stu->StudentLastName) ?></span>
                                            <small class="text-muted x-small">ID-CARD: <?= esc($v_stu->StudentIDNumber ?? '-') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-success rounded-pill px-3">ม.<?= esc($v_stu->StudentClass) ?></span>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-emerald btn-sm w-100 rounded-pill"
                                       href="<?= site_url('Admin/Acade/'.$levelStr.'/ReportPerson/'.esc($v_stu->StudentID, 'url'));?>">
                                        <i class='bx bx-search-alt-2 me-1'></i> ดูผลการเรียน
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="card settings-card border-0 text-center py-5">
            <div class="card-body">
                <div class="icon-wrapper mx-auto mb-4" style="width: 100px; height: 100px; font-size: 3rem;">
                    <i class='bx bx-search-alt'></i>
                </div>
                <h4 class="fw-bold text-dark">กรุณาระบุข้อมูลเพื่อค้นหารายชื่อ</h4>
                <p class="text-muted mx-auto" style="max-width: 450px;">เลือกปีการศึกษาและระดับห้องเรียน เพื่อเริ่มต้นการตรวจสอบผลการเรียนรายบุคคลแบบรายงานสมบูรณ์</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <div class="badge bg-label-info p-2 px-3"><i class='bx bx-info-circle me-1'></i> ระบุปีการศึกษา</div>
                    <div class="badge bg-label-info p-2 px-3"><i class='bx bx-info-circle me-1'></i> ระดับชั้น/ห้อง</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('.select2').each(function() { $(this).select2({ theme: 'bootstrap-5', width: '100%' }); });

    // Newest Year first logic
    let select = $('#CheckYearSaveScore');
    let opts = select.find('option').not('[value=""]');
    let selected = select.val();
    opts.sort((a,b) => (b.value.split('/')[1] - a.value.split('/')[1]) || (b.value.split('/')[0] - a.value.split('/')[0]));
    select.find('option').not('[value=""]').remove(); select.append(opts).val(selected);

    // Initial load for rooms if year is selected
    $(document).on("change", "#CheckYearSaveScore", function () {
        let y = $(this).val(); let b = $(this).data('base-url');
        if (b && y) { 
            Swal.fire({ title: 'กำลังโหลด...', didOpen: () => Swal.showLoading() });
            window.location.href = b + '/' + y; 
        }
    });

    $('#btnSearchReport').on('click', function() {
        let y = $('#CheckYearSaveScore').val();
        let r = $('#SelectRoom').val();
        const base = $('#CheckYearSaveScore').data('base-url');

        if (!y) { Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา' }); return; }

        let url = base + '/' + y + '?search=true';
        if (r) url += '&room=' + encodeURIComponent(r);

        Swal.fire({ title: 'กำลังโหลดข้อมูล...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        window.location.href = url;
    });

    // DataTable setup if results exist
    if ($('#studentTable').length > 0) {
        $('#studentTable').DataTable({
            "language": {
                "lengthMenu": "แสดง _MENU_ คน",
                "search": "ค้นหาด่วน:",
                "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
            },
            "dom": '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row mt-3"<"col-md-6 text-muted small"i><"col-md-6"p>>',
            "stateSave": true,
            "order": [[3, "asc"], [1, "asc"]],
            "pageLength": 15
        });
    }
});
</script>
<?= $this->endSection() ?>
