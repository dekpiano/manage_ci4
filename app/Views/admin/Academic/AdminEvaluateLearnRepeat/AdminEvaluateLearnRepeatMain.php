<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<?php
$onoff_status = isset($checkOnOff[6]) && isset($checkOnOff[6]->onoff_status) ? $checkOnOff[6]->onoff_status : 'off';
$onoff_detail = isset($checkOnOff[6]) && isset($checkOnOff[6]->onoff_detail) ? $checkOnOff[6]->onoff_detail : '';
?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl d-flex justify-content-between align-items-center">
        <div class="">
            <h2 class="heading">จัดการข้อมูล<?= esc($title);?></h2>
        </div>

        <div>
            <div class="d-flex  align-items-center">
                <div>
                    สถานะ
                </div>
                <div class="ms-3">
                    <select name="CheckOnoffRepeat" id="CheckOnoffRepeat" class="form-select form-select-sm border <?= $onoff_status == "on" ? "border-success text-success" : "border-danger text-danger" ?>">
                        <option <?= $onoff_status == "on" ? "selected" : ""?> value="on"> เปิดบันทึกคะแนนเรียนซ้ำ</option>
                        <option <?= $onoff_status == "off" ? "selected" : ""?> value="off">ปิดบันทึกคะแนนเรียนซ้ำ</option>
                    </select>
                </div>
            </div>

            <div class="d-flex  align-items-center mt-2">
                <div>
                    ของปีการศึกษา
                </div>
                <div class="ms-3">
                    <select name="onoff_year" id="onoff_year" class="form-select form-select-sm">
                        <?php foreach ($CountYear as $key => $value) : ?>
                        <?php // NOTE: This logic should be in the controller
                        $currentYear = (service('request')->uri->getSegment(5) ?? '').'/'.(service('request')->uri->getSegment(6) ?? '');
                        ?>
                        <option <?= $currentYear == $value->RegisterYear ? "selected" : "" ?>
                            value="<?= esc($value->RegisterYear) ?>"><?= esc($value->RegisterYear) ?></option>                               
                            <?php endforeach; ?>      
                            <option value="1/2567">1/2567</option>                    
                    </select>
                </div>
            </div>

            <div class="d-flex  align-items-center mt-2">
                <div>
                    เรียนซ้ำ
                </div>
                <div class="ms-3">
                    <select name="CheckTimeRepeat" id="CheckTimeRepeat" class="form-select form-select-sm">
                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 1" ? "selected" : "" ?>
                            value="เรียนซ้ำครั้งที่ 1">ครั้งที่ 1</option>
                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 2" ? "selected" : "" ?>
                            value="เรียนซ้ำครั้งที่ 2">ครั้งที่ 2</option>
                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 3" ? "selected" : "" ?>
                            value="เรียนซ้ำครั้งที่ 3">ครั้งที่ 3</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <!--//container-->
    </section>
    <section class="we-offer-area mt-5">
        <div class="container-fluid">

            <div class="app-card  mb-5">
                <div class="app-card-body p-3">
                    <div class="table-responsive">
                        <table class="table mb-0 text-left" id="Tb_Repeat">
                            <thead>
                                <tr>
                                    <th class="cell">ปีการศึกษา</th>
                                    <th class="cell">รายวิชา</th>
                                    <th class="cell">ครูผู้สอน</th>
                                    <th class="cell">แก้ไขคะแนน (่เรียนซ้ำ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($DataRepeat as $key => $v_result) : ?>
                                <tr>
                                    <td class="cell"><?= isset($v_result->RegisterYear) ? esc($v_result->RegisterYear) : '' ?></td>
                                    <td class="cell"><span
                                            class="truncate"><?= isset($v_result->SubjectCode) ? esc($v_result->SubjectCode.' '.$v_result->SubjectName) : '' ?></span>
                                    </td>
                                    <td class="cell">
                                        <?= isset($v_result->pers_prefix) ? esc($v_result->pers_prefix.$v_result->pers_firstname.' '.$v_result->pers_lastname) : '' ?>
                                    </td>
                                    <td class="cell">
                                        <a href="<?= site_url('Admin/Acade/Evaluate/AcademicRepeat/'.(isset($v_result->RegisterYear) ? esc($v_result->RegisterYear,'url') : '').'/'.(isset($v_result->SubjectID) ? esc($v_result->SubjectID,'url') : '')) ?>"
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
    </section>

</div>
<?= $this->endSection() ?>
