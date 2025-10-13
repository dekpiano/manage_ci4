<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="d-flex justify-content-between">
        <div class="col-auto justify-content-start">
            <h3 class="app-page-title"><?= isset($title) ? esc($title) : '' ?></h3>
        </div>
        <div class="col-auto justify-content-md-end">
            <div class="page-utilities">
                <div class="row g-2  ">
                    <div class="col-auto">
                        <form action="#" method="post" class="d-flex align-items-center" data-base-url="<?= site_url('Admin/Acade/Evaluate/ReportTeacherSaveScore') ?>">
                            <label for="">เลือกปีการศึกษา</label>
                            <select class="form-select w-auto ms-2" name="CheckYearSaveScore" id="CheckYearSaveScore">
                                <?php foreach ($CheckYearSaveScore as $key => $value) : ?>
                                <option <?= (isset($Term) ? $Term : '').'/'.(isset($Year) ? $Year : '') == (isset($value->RegisterYear) ? $value->RegisterYear : '') ? "selected" : ""?> value="<?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>"><?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>                  
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="">

                <div class="card">
                    <div class="card-body">
                        <table class="table app-table-hover mb-0 text-left ShowStudent" id="">
                            <thead>
                                <tr>
                                    <th class="cell">ภาคเรียน</th>
                                    <th class="cell">กลุ่มสาระ</th>
                                    <th class="cell">ชื่อ - นามสกุล</th>
                                    <th class="cell">ตำแหน่ง</th>
                                    <th class="cell">คำสั่ง</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($Teacher as $key => $v_Teacher) : ?>
                                <tr>
                                    <td class="cell"><?= (isset($Term) ? esc($Term) : '').'/'.(isset($Year) ? esc($Year) : '') ?></td>
                                    <td class="cell"><?= isset($v_Teacher->lear_namethai) ? esc($v_Teacher->lear_namethai) : '' ?></td>
                                    <td class="cell">
                                        <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                                    </td>
                                    <td class="cell"><?= isset($v_Teacher->posi_name) ? esc($v_Teacher->posi_name) : '' ?></td>

                                    <td class="cell">
                                        <?php // NOTE: This logic should be in the controller
                                        $level = service('request')->uri->getSegment(3) ?? ''; ?>
                                        <a class="btn-sm btn-primary clickLoad-spin"
                                            href="<?= site_url('Admin/Acade/'.esc($level, 'url').'/ReportTeacherSaveScoreCheck/'.(isset($Term) ? esc($Term, 'url') : '').'/'.(isset($Year) ? esc($Year, 'url') : '').'/'.(isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id, 'url') : ''));?>">
                                            <i class="bi bi-eye-fill"></i> ดูผลการบันทึกคนแนน
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

    select.empty().append(options);
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
            $('.loader').show();
            window.location.href = baseUrl + '/' + selectedYear;
        } else {
            console.error('Base URL or selected year not found.');
        }
    });
});
</script>
<?= $this->endSection() ?>
