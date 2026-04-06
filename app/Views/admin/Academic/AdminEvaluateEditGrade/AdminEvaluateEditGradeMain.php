<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="">
    <div class="">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h3>
            <div class=" card p-2">
                 <div class="d-flex align-items-center">
                <div class="me-2">
                    ปีการศึกษา:
                </div>
                <div>
                    <select name="onoff_year" id="onoff_year" class="form-select form-select-sm">
                        <?php foreach ($CheckYearRegis as $key => $value) : ?>
                        <?php // NOTE: This logic should be in the controller
                        $currentYear = (service('request')->getUri()->getSegment(5) ?? '').'/'.(service('request')->getUri()->getSegment(6) ?? '');
                        ?>
                        <option <?= isset($value->RegisterYear) && $currentYear == $value->RegisterYear ?"selected":"" ?>
                            value="<?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>"><?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            </div>
           
        </div>
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home');?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">ประเมินผลการเรียน</li>
            </ol>
        </nav>
        <div class="card mb-4">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 text-left" id="Tb_Repeat">
                        <thead class="bg-light">
                            <tr>
                                <th class="cell">ปีการศึกษา</th>
                                <th class="cell">รายวิชา</th>
                                <th class="cell">ครูผู้สอน</th>
                                <th class="cell">แก้ไขคะแนน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($result)): ?>
                            <?php foreach ($result as $key => $v_result) : ?>
                            <tr>
                                <td class="cell"><?= isset($v_result->RegisterYear) ? esc($v_result->RegisterYear) : '' ?></td>
                                <td class="cell"><span
                                        class="truncate"><?= (isset($v_result->SubjectCode) ? esc($v_result->SubjectCode) : '').' '.(isset($v_result->SubjectName) ? esc($v_result->SubjectName) : '') ?></span>
                                </td>
                                <td class="cell">
                                    <?= (isset($v_result->pers_prefix) ? esc($v_result->pers_prefix) : '').(isset($v_result->pers_firstname) ? esc($v_result->pers_firstname) : '').' '.(isset($v_result->pers_lastname) ? esc($v_result->pers_lastname) : '') ?>
                                </td>
                                <td class="cell">
                                    <a href="<?= site_url('Admin/Acade/Evaluate/EditGrade/'.(isset($v_result->RegisterYear) ? esc($v_result->RegisterYear, 'url') : '').'/'.(isset($v_result->SubjectID) ? esc($v_result->SubjectID, 'url') : '')) ?>"
                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-1"></i>แก้ไข</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center p-4">ไม่มีข้อมูลรายวิชาที่ต้องประเมิน</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!--//table-responsive-->
            </div>
            <!--//card-body-->
        </div>

    </div>
    <!--//main-wrapper-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Sort academic year dropdown
    var $onoffYearSelect = $('#onoff_year');
    var options = $onoffYearSelect.find('option').get();

    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');

        var aTerm = parseInt(aVal[0]);
        var aYear = parseInt(aVal[1]);
        var bTerm = parseInt(bVal[0]);
        var bYear = parseInt(bVal[1]);

        if (aYear !== bYear) {
            return aYear - bYear; // Sort by year first
        }
        return aTerm - bTerm; // Then by term
    });

    $onoffYearSelect.empty().append(options); // Clear and re-append sorted options

    $('#Tb_Repeat').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });

    // Handle year filter change
    $('#onoff_year').on('change', function() {
        var selectedYear = $(this).val();
        window.location.href = '<?= site_url('Admin/Acade/Evaluate/EditGrade/') ?>' + selectedYear;
    });
});
</script>
<?= $this->endSection() ?>
