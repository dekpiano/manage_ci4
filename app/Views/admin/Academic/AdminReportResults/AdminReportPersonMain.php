<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class='bx bx-user text-success me-2'></i>
            <?= isset($title) ? esc($title) : 'รายงานผลการเรียนรายบุคคล' ?>
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="#">งานทะเบียน</a></li>
                <li class="breadcrumb-item active">รายงานผลการเรียนรายบุคคล</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <?php
        $level = service('request')->uri->getSegment(3) ?? 'Evaluate';
        $baseUrl = ($level === 'Executive')
            ? site_url('Admin/Acade/Executive/ReportPerson')
            : site_url('Admin/Acade/Evaluate/ReportPerson');
        ?>
        <div class="input-group" style="width: auto;">
            <span class="input-group-text bg-success text-white">
                <i class='bx bx-calendar'></i>
            </span>
            <select class="form-select" name="CheckYearSaveScore" id="CheckYearSaveScore" style="min-width: 130px;" data-base-url="<?= $baseUrl ?>">
                <option value="">-- เลือกปี --</option>
                <?php if(isset($CheckYearSaveScore)): ?>
                    <?php foreach ($CheckYearSaveScore as $value) : ?>
                    <option <?= (isset($Term) && isset($Year) && ($Term.'/'.$Year) == $value->RegisterYear) ? "selected" : ""?> value="<?= esc($value->RegisterYear) ?>"><?= esc($value->RegisterYear) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
</div>

<!-- Summary Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #71dd37 0%, #8de45c 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">จำนวนนักเรียน</h6>
                        <h2 class="mb-0 fw-bold"><?= count($stu ?? []) ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-group fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #48c764 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ภาคเรียน/ปีการศึกษา</h6>
                        <h2 class="mb-0 fw-bold"><?= (isset($Term) ? esc($Term) : '-').'/'.(isset($Year) ? esc($Year) : '-') ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-calendar-check fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #20c997 0%, #4dd4ac 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">สถานะ</h6>
                        <h2 class="mb-0 fw-bold" style="font-size: 1.2rem;">พร้อมดูผลการเรียน</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-check-circle fs-2'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Data Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom-0 py-3" style="border-radius: 12px 12px 0 0;">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                    <i class='bx bx-list-ul text-success fs-4'></i>
                </div>
                <div>
                    <h5 class="card-title mb-0 fw-bold">รายชื่อนักเรียน</h5>
                    <small class="text-muted">แสดงข้อมูลนักเรียน ภาคเรียน <?= (isset($Term) ? esc($Term) : '').'/'.(isset($Year) ? esc($Year) : '') ?></small>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="studentTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">เลขประจำตัว</th>
                        <th>เลขที่</th>
                        <th style="white-space: nowrap;">ชื่อ - นามสกุล</th>
                        <th>ระดับชั้น</th>
                        <th class="text-center" style="width: 150px;">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stu as $key => $v_stu) : ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-label-primary"><?= isset($v_stu->StudentCode) ? esc($v_stu->StudentCode) : '' ?></span>
                        </td>
                        <td><?= isset($v_stu->StudentNumber) ? esc($v_stu->StudentNumber) : '' ?></td>
                        <td style="white-space: nowrap;">
                            <?= (isset($v_stu->StudentPrefix) ? esc($v_stu->StudentPrefix) : '').(isset($v_stu->StudentFirstName) ? esc($v_stu->StudentFirstName) : '').' '.(isset($v_stu->StudentLastName) ? esc($v_stu->StudentLastName) : '') ?>
                        </td>
                        <td>
                            <span class="badge bg-label-success"><?= isset($v_stu->StudentClass) ? esc($v_stu->StudentClass) : '' ?></span>
                        </td>
                        <td class="text-center">
                            <?php $level = service('request')->uri->getSegment(3) ?? '';
                            if($level === "Executive") :?>
                            <a class="btn btn-outline-success btn-sm rounded-pill px-3 clickLoad-spin"
                                href="<?= site_url('Admin/Acade/Executive/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                <i class='bx bx-show me-1'></i> ดูผลการเรียน
                            </a>
                            <?php else: ?>
                            <a class="btn btn-success btn-sm rounded-pill px-3 clickLoad-spin"
                                href="<?= site_url('Admin/Acade/Evaluate/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                <i class='bx bx-show me-1'></i> ดูผลการเรียน
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Sort the dropdown
    var select = $('#CheckYearSaveScore');
    var options = select.find('option');
    var selectedValue = select.val();
    var placeholder = options.filter('[value=""]');
    options = options.not('[value=""]');

    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        var aYear = parseInt(aVal[1], 10);
        var bYear = parseInt(bVal[1], 10);
        var aTerm = parseInt(aVal[0], 10);
        var bTerm = parseInt(bVal[0], 10);

        if (aYear !== bYear) {
            return bYear - aYear;
        }
        return bTerm - aTerm;
    });

    select.empty().append(placeholder).append(options);
    select.val(selectedValue);

    // Initialize DataTable
    $('#studentTable').DataTable({
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการ",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "search": "ค้นหา:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "stateSave": true,
        "order": [[3, "asc"], [1, "asc"]]
    });

    // Handle dropdown change
    $(document).on("change", "#CheckYearSaveScore", function () {
        let selectedYear = $(this).val();
        const baseUrl = $(this).data('base-url');

        if (baseUrl && selectedYear) {
            Swal.fire({
                title: 'กำลังโหลดข้อมูล...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            window.location.href = baseUrl + '/' + selectedYear;
        } else if (baseUrl) {
            window.location.href = baseUrl;
        }
    });
});
</script>
<?= $this->endSection() ?>
