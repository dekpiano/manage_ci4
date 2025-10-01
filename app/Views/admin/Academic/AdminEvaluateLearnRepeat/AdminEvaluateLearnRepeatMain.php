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
<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h2 class="heading mb-3"><?= esc($title);?></h2>
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home');?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($title);?></li>
            </ol>
        </nav>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">ตั้งค่าระบบ เรียนซ้ำ</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="CheckOnoffRepeat" class="form-label">สถานะ:</label>
                        <select name="CheckOnoffRepeat" id="CheckOnoffRepeat"
                            class="form-select form-select border <?= $onoff_status == "on" ? "border-success text-success" : "border-danger text-danger" ?>">
                            <option <?= $onoff_status == "on" ? "selected" : ""?> value="on"> เปิดบันทึกคะแนนเรียนซ้ำ
                            </option>
                            <option <?= $onoff_status == "off" ? "selected" : ""?> value="off">ปิดบันทึกคะแนนเรียนซ้ำ
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="onoff_year" class="form-label">ปีการศึกษา:</label>
                        <select name="onoff_year" id="onoff_year" class="form-select form-select">
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
                    <div class="col-md-4">
                        <label for="CheckTimeRepeat" class="form-label">เรียนซ้ำ:</label>
                        <select name="CheckTimeRepeat" id="CheckTimeRepeat" class="form-select form-select">
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

        
            <?php if(0):?>
            <section class="we-offer-area mt-3">
                <div class="">

                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0 text-left" id="Tb_Repeat">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="cell">ปีการศึกษา</th>
                                            <th class="cell">รายวิชา</th>
                                            <th class="cell">ครูผู้สอน</th>
                                            <th class="cell">แก้ไขคะแนน (เรียนซ้ำ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($DataRepeat)): ?>
                                        <?php foreach ($DataRepeat as $key => $v_result) : ?>
                                        <tr>
                                            <td class="cell">
                                                <?= isset($v_result->RegisterYear) ? esc($v_result->RegisterYear) : '' ?>
                                            </td>
                                            <td class="cell"><span
                                                    class="truncate"><?= isset($v_result->SubjectCode) ? esc($v_result->SubjectCode.' '.$v_result->SubjectName) : '' ?></span>
                                            </td>
                                            <td class="cell">
                                                <?= isset($v_result->pers_prefix) ? esc($v_result->pers_prefix.$v_result->pers_firstname.' '.$v_result->pers_lastname) : '' ?>
                                            </td>
                                            <td class="cell">
                                                <a href="<?= site_url('Admin/Acade/Evaluate/AcademicRepeat/'.(isset($v_result->RegisterYear) ? esc($v_result->RegisterYear,'url') : '').'/'.(isset($v_result->SubjectID) ? esc($v_result->SubjectID,'url') : '')) ?>"
                                                    class="btn btn-sm btn-warning"><i
                                                        class="bi bi-pencil-square me-1"></i>แก้ไข</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center p-4">ไม่มีข้อมูลรายวิชาเรียนซ้ำ</td>
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
            </section>
            <?php endif;?>
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
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
        }
    });
        
            // Handle settings changes and save to database
            $('#CheckOnoffRepeat, #onoff_year, #CheckTimeRepeat').on('change', function() {
                var status = $('#CheckOnoffRepeat').val();
                var year = $('#onoff_year').val();
                var time = $('#CheckTimeRepeat').val();
        
                $.ajax({
                    url: '<?= site_url('Admin/Acade/Evaluate/update_repeat_settings') ?>', // Placeholder URL for saving settings
                    type: 'POST',
                    data: {
                        setting_status: status,
                        setting_year: year,
                        setting_time: time
                    },
                    success: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'บันทึกการตั้งค่าสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        console.log('Settings updated:', response);
                        // Optionally, redirect or refresh the table data after saving settings
                        // window.location.href = '<?= site_url('Admin/Acade/Evaluate/AcademicRepeat/') ?>' + year + '/' + status + '/' + time;
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการบันทึกการตั้งค่า',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        console.error('Error updating settings:', error);
                    }
                });
            });
        });
        </script>
        <?= $this->endSection() ?>