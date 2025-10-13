<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
        <hr class="mb-4">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center mb-3">
             <div class="col-auto">
                <?php
                $level = service('request')->uri->getSegment(3) ?? 'Evaluate'; // Default to Evaluate
                $baseUrl = ($level === 'Executive')
                    ? site_url('Admin/Acade/Executive/ReportPerson')
                    : site_url('Admin/Acade/Evaluate/ReportPerson');
                ?>
                <form action="#" method="post" class="d-flex align-items-center" data-base-url="<?= $baseUrl ?>">
                    <label for="CheckYearSaveScore" class="form-label me-2 mb-0">เลือกปีการศึกษา</label>
                    <select class="form-select w-auto" name="CheckYearSaveScore" id="CheckYearSaveScore">
                        <option value="">-- เลือกปี --</option>
                        <?php if(isset($CheckYearSaveScore)): ?>
                            <?php foreach ($CheckYearSaveScore as $value) : ?>
                            <option <?= (isset($Term) && isset($Year) && ($Term.'/'.$Year) == $value->RegisterYear) ? "selected" : ""?> value="<?= esc($value->RegisterYear) ?>"><?= esc($value->RegisterYear) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <table class="table app-table-hover mb-0 text-left ShowStudent" id="">
                            <thead>
                                <tr>
                                    <th class="cell">เลขประจำตัว</th>
                                    <th class="cell">เลขที่</th>
                                    <th class="cell">ชื่อ</th>
                                    <th class="cell">นามสกุล</th>
                                    <th class="cell">ระดับชั้น</th>
                                    <th class="cell">ดูผลการเรียน</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($stu as $key => $v_stu) : ?>
                                <tr>
                                    <td class="cell"><?= isset($v_stu->StudentCode) ? esc($v_stu->StudentCode) : '' ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentNumber) ? esc($v_stu->StudentNumber) : '' ?></td>
                                    <td class="cell"><?= (isset($v_stu->StudentPrefix) ? esc($v_stu->StudentPrefix) : '').(isset($v_stu->StudentFirstName) ? esc($v_stu->StudentFirstName) : '') ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentLastName) ? esc($v_stu->StudentLastName) : '' ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentClass) ? esc($v_stu->StudentClass) : '' ?></td>

                                    <td class="cell">
                                        <?php // NOTE: This logic should be in the controller
                                        $level = service('request')->uri->getSegment(3) ?? '';
                                        if($level === "Executive") :?>
                                        <a class="btn-sm app-btn-secondary clickLoad-spin"
                                            href="<?= site_url('Admin/Acade/Executive/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                            <i class="bi bi-eye-fill"></i> ดูผลการเรียน
                                        </a>
                                        <?php else: ?>
                                            <a class="btn-sm btn-primary clickLoad-spin"
                                            href="<?= site_url('Admin/Acade/Evaluate/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                            <i class="bi bi-eye-fill"></i> ดูผลการเรียน
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

    </div>
    </section>

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
            return bYear - aYear; // Sort by year descending
        }
        return bTerm - aTerm; // Then by term descending
    });

    select.empty().append(placeholder).append(options);
    select.val(selectedValue);

    // Initialize DataTable
    $('.ShowStudent').DataTable({
        "order": [
            [4, "asc"],
            [1, "asc"]
        ]
    });

    // Handle dropdown change
    $(document).on("change", "#CheckYearSaveScore", function () {
        let selectedYear = $(this).val();
        const baseUrl = $(this).closest('form').data('base-url');

        if (baseUrl && selectedYear) {
            window.location.href = baseUrl + '/' + selectedYear;
        } else if (baseUrl) {
            window.location.href = baseUrl;
        }
    });
});
</script>
<?= $this->endSection() ?>
