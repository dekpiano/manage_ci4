<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl d-flex align-items-center justify-content-between">
        <h1 class="app-page-title">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
        <div class="d-flex  align-items-center mt-2">
                <div>
                    ปีการศึกษา
                </div>
                <div class="ms-3">
                    <select name="onoff_year" id="onoff_year" class="form-select form-select-sm">
                        <?php foreach ($CheckYearRegis as $key => $value) : ?>
                        <?php // NOTE: This logic should be in the controller
                        $currentYear = (service('request')->uri->getSegment(5) ?? '').'/'.(service('request')->uri->getSegment(6) ?? '');
                        ?>
                        <option <?= isset($value->RegisterYear) && $currentYear == $value->RegisterYear ?"selected":"" ?>
                            value="<?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>"><?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?></option>  
                            <?php endforeach; ?>                          
                    </select>
                </div>
            </div>
    </div>
    <hr class="mb-4">

        <div class="app-card  mt-5">
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table mb-0 text-left" id="Tb_Repeat">
                        <thead>
                            <tr>
                                <th class="cell">ปีการศึกษา</th>
                                <th class="cell">รายวิชา</th>
                                <th class="cell">ครูผู้สอน</th>
                                <th class="cell">แก้ไขคะแนน</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        class="badge bg-warning">แก้ไข</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!--//table-responsive-->
            </div>
            <!--//app-card-body-->
        </div>

    </div>
    <!--//main-wrapper-->
<?= $this->endSection() ?>
