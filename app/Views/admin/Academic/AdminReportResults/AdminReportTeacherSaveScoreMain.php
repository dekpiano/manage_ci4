<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl d-flex justify-content-between">
        <div class="col-auto justify-content-start">
            <h1 class="app-page-title"><?= isset($title) ? esc($title) : '' ?></h1>
        </div>
        <div class="col-auto justify-content-md-end">
            <div class="page-utilities">
                <div class="row g-2  ">
                    <div class="col-auto">
                        <form action="#" method="post" class="d-flex align-items-center">
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
        <div class="container-fluid">

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
$('.ShowStudent').DataTable({
    "order": [
        [4, "asc"],
        [1, "asc"]
    ]
});
</script>
<?= $this->endSection() ?>
