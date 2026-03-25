<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ /</span> <?= isset($title) ? esc($title) : 'สรุปผลสัมฤทธิ์ทางการเรียน' ?>
            </h4>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-2">
                    <form method="get" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummary'); ?>" class="row g-2">
                        <div class="col-md-5">
                            <select class="form-select" name="KeyYear" id="KeyYear">
                                <option value="0">เลือกปีการศึกษา...</option>
                                <?php foreach ($CheckYear as $v_CheckYear) : ?>
                                    <option <?= (isset($KeyYear) && $KeyYear == $v_CheckYear->RegisterYear) ? 'selected' : '' ?> value="<?= esc($v_CheckYear->RegisterYear) ?>">
                                        <?= esc($v_CheckYear->RegisterYear) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" name="SelLern">
                                <option value="0">เลือกกลุ่มสาระ...</option>
                                <?php foreach ($lern as $v_lern) : ?>
                                    <option <?= (service('request')->getGet('SelLern') == $v_lern->lear_id) ? "selected" : "" ?> value="<?= esc($v_lern->lear_id) ?>">
                                        <?= esc($v_lern->lear_namethai) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (service('request')->getGet('SelLern') === '0' || empty(service('request')->getGet('SelLern'))) : ?>
        <div class="card shadow-none bg-transparent border border-primary mb-4">
            <div class="card-body text-center">
                <h5 class="card-title text-primary mb-1"><i class="bx bx-info-circle me-1"></i> กรุณาเลือกรายการ</h5>
                <p class="card-text">เลือกปีการศึกษาและกลุ่มสาระการเรียนรู้เพื่อดูรายงานสรุปผลสัมฤทธิ์</p>
            </div>
        </div>
    <?php else : ?>
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">ตารางสรุปผลสัมฤทธิ์ทางการเรียน</h5>
                <div class="dt-buttons btn-group flex-wrap">
                    <!-- DataTables buttons will be injected here if used, or custom buttons -->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-bordered table-sm" id="ReportSummaryTeacher">
                        <thead>
                            <tr class="table-light text-center">
                                <th rowspan="2" class="align-middle">ครูผู้สอน</th>
                                <th rowspan="2" class="align-middle">วิชา</th>
                                <th rowspan="2" class="align-middle">ชั้น</th>
                                <th rowspan="2" class="align-middle">นก.</th>
                                <th rowspan="2" class="align-middle bg-primary text-white">นักเรียน</th>
                                <th colspan="8" class="bg-success text-white">ระดับคะแนน (จำนวนคน)</th>
                                <th colspan="2" class="bg-warning text-dark">สถานะ</th>
                                <th colspan="4" class="bg-info text-dark">สรุปสถิติ</th>
                            </tr>
                            <tr class="table-light text-center">
                                <!-- Grades -->
                                <th class="px-2">4</th>
                                <th class="px-2">3.5</th>
                                <th class="px-2">3</th>
                                <th class="px-2">2.5</th>
                                <th class="px-2">2</th>
                                <th class="px-2">1.5</th>
                                <th class="px-2">1</th>
                                <th class="px-2">0</th>
                                <!-- Status -->
                                <th class="px-2">ร</th>
                                <th class="px-2">มส</th>
                                <!-- New Stats -->
                                <th class="bg-label-info">รวม(0-4)</th>
                                <th class="bg-label-info">ร้อยละ 3+</th>
                                <th class="bg-label-info">เฉลี่ย</th>
                                <th class="bg-label-info">SD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Showdata as $v_data) : 
                                $totalNumeric = (int)$v_data->TotalNumeric;
                                $goodCount = (int)$v_data->G4_0 + (int)$v_data->G3_5 + (int)$v_data->G3_0;
                                $goodPercent = ($totalNumeric > 0) ? ($goodCount / $totalNumeric) * 100 : 0;
                            ?>
                                <tr>
                                    <td>
                                        <small><?= esc($v_data->pers_prefix . $v_data->pers_firstname . ' ' . $v_data->pers_lastname) ?></small>
                                    </td>
                                    <td>
                                        <small><strong><?= esc($v_data->SubjectCode) ?></strong> <?= esc($v_data->SubjectName) ?></small>
                                    </td>
                                    <td class="text-center"><?= esc($v_data->StudentClass) ?></td>
                                    <td class="text-center"><?= esc($v_data->SubjectUnit) ?></td>
                                    <td class="text-center fw-bold text-primary"><?= esc($v_data->SumStu) ?></td>
                                    <!-- Grades -->
                                    <td class="text-center"><?= $v_data->G4_0 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G3_5 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G3_0 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G2_5 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G2_0 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G1_5 ?: '-' ?></td>
                                    <td class="text-center"><?= $v_data->G1_0 ?: '-' ?></td>
                                    <td class="text-center text-danger"><?= $v_data->G0 ?: '-' ?></td>
                                    <!-- Status -->
                                    <td class="text-center text-warning fw-bold"><?= $v_data->G_W ?: '-' ?></td>
                                    <td class="text-center text-warning fw-bold"><?= $v_data->G_MS ?: '-' ?></td>
                                    <!-- Stats -->
                                    <td class="text-center fw-bold"><?= $totalNumeric ?></td>
                                    <td class="text-center <?= $goodPercent >= 50 ? 'text-success' : 'text-danger' ?> fw-bold">
                                        <?= number_format($goodPercent, 2) ?>%
                                    </td>
                                    <td class="text-center fw-bold"><?= number_format((float)$v_data->MeanGrade, 2) ?></td>
                                    <td class="text-center"><?= number_format((float)$v_data->SDGrade, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Sort the dropdown
    var select = $('#KeyYear');
    var options = select.find('option');
    var selectedValue = select.val();
    var placeholder = options.filter('[value="0"]');
    options = options.not('[value="0"]');

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

    select.empty().append(placeholder).append(options);
    select.val(selectedValue);

    // Initialize DataTable
    if ($('#ReportSummaryTeacher').length) {
        $('#ReportSummaryTeacher').DataTable({
            dom: '<"row mx-2"<"col-md-auto d-flex align-items-center justify-content-center justify-content-md-start"l><"col-md-auto ms-auto mt-2 mt-md-0 d-flex align-items-center justify-content-center justify-content-md-end"Bf>>t<"row mx-2"<"col-md-6"i><"col-md-6"p>>',
            buttons: [
                { extend: 'excelHtml5', className: 'btn btn-outline-success btn-sm me-1', text: '<i class="bx bxs-file-export me-1"></i> Excel' },
                { extend: 'pdfHtml5', className: 'btn btn-outline-danger btn-sm me-1', text: '<i class="bx bxs-file-pdf me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4' },
                { extend: 'print', className: 'btn btn-outline-info btn-sm', text: '<i class="bx bx-printer me-1"></i> Print' }
            ],
            autoWidth: false,
            pageLength: -1,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
            }
        });
    }
});
</script>
<style>
    .table-sm th, .table-sm td {
        padding: 0.3rem 0.6rem !important;
        font-size: 0.85rem;
    }
    .bg-label-info {
        background-color: #e7f7ff !important;
        color: #03c3ec !important;
    }
</style>
<?= $this->endSection() ?>