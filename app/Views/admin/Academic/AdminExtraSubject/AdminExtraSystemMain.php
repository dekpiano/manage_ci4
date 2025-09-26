<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.switchToggle input[type=checkbox] {
    height: 0;
    width: 0;
    visibility: hidden;
    position: absolute;
}

.switchToggle label {
    cursor: pointer;
    text-indent: -9999px;
    width: 70px;
    max-width: 70px;
    height: 30px;
    background: #d1d1d1;
    display: block;
    border-radius: 100px;
    position: relative;
}

.switchToggle label:after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 26px;
    height: 26px;
    background: #fff;
    border-radius: 90px;
    transition: 0.3s;
}

.switchToggle input:checked+label,
.switchToggle input:checked+input+label {
    background: #3e98d3;
}

.switchToggle input+label:before,
.switchToggle input+input+label:before {
    content: 'ปิด';
    position: absolute;
    top: 5px;
    left: 35px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked+label:before,
.switchToggle input:checked+input+label:before {
    content: 'เปิด';
    position: absolute;
    top: 5px;
    left: 10px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked+label:after,
.switchToggle input:checked+input+label:after {
    left: calc(100% - 2px);
    transform: translateX(-100%);
}

.switchToggle label:active:after {
    width: 60px;
}

.toggle-switchArea {
    margin: 10px 0 10px 0;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">
                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>
            </div>
            <!--//container-->
        </section>
        <div class="container-xl">
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">จัดการ เปิด - ปิดระบบ</h3>
                    <div class="section-intro">ตั้งค่าการเปิดปิดระบบลงทะเบียนวิชาเพิ่มเติม</div>
                </div>
                <div class="col-12 col-md-8">
                    <form class="settings-form">
                        <div class=" mb-3">
                            <div class="switchToggle">
                                <input type="checkbox" <?= isset($OnoffSystem[0]->extra_setting_onoff) && $OnoffSystem[0]->extra_setting_onoff == 'false' ? '' : 'checked';?> id="extra_setting_onoff" name="extra_setting_onoff" value="เปิด">
                                <label for="extra_setting_onoff">Toggle</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">จัดการภาคเรียนและปีการศึกษา</h3>
                    <div class="section-intro">ตั้งค่าภาคเรียนและปีการศึกษาในแต่ละปี </div>
                    <div class="section-intro text-danger">(ไม่ควรเปลี่ยนแปลงข้อมูลในระหว่างที่เปิดระบบให้ลงทะเบียน อาจทำข้อมูลคาดเคลื่อน โปรดระวัง!) </div>
                </div>
                <div class="col-12 col-md-8">
                    <form class="settings-form">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select form-select-lg mb-3"
                                    aria-label=".form-select-lg example" id="extra_setting_term" name="extra_setting_term">
                                    <?php for ($i=1; $i <=3 ; $i++) : ?>
                                    <option <?= isset($OnoffSystem[0]->extra_setting_term) && $OnoffSystem[0]->extra_setting_term == $i ? 'selected' : '';?> value="<?= esc($i)?>">ภาคเรียนที่ <?= esc($i)?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select form-select-lg mb-3"
                                    aria-label=".form-select-lg example" id="extra_setting_year" name="extra_setting_year">
                                    <?php $d = date('Y')+543; ?>
                                    <?php for ($i=$d-1; $i < $d+2; $i++):
                                    ?>
                                    <option <?= isset($OnoffSystem[0]->extra_setting_year) && $OnoffSystem[0]->extra_setting_year == $i ? 'selected' : '';?> value="<?= esc($i);?>"><?= esc($i);?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">จัดการวันและเวลา</h3>
                    <div class="section-intro">ตั้งค่าวันและเวลาที่จะเปิดปิดการลงทะเบียน</div>
                </div>
                <div class="col-12 col-md-8">
                    <form class="settings-form">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control form-control-lg" type="datetime-local"
                                    placeholder=".form-control-lg" aria-label=".form-control-lg example" id="extra_setting_datestart" name="extra_setting_datestart" value="<?= isset($OnoffSystem[0]->extra_setting_datestart) ? date('Y-m-d	H:i', strtotime($OnoffSystem[0]->extra_setting_datestart)) : '' ?>">
                                    
                            </div>
                            <div class="col-md-6">
                                <input class="form-control form-control-lg" type="datetime-local"
                                    placeholder=".form-control-lg" aria-label=".form-control-lg example" id="extra_setting_dateend" name="extra_setting_dateend" value="<?= isset($OnoffSystem[0]->extra_setting_dateend) ? date('Y-m-d	H:i', strtotime($OnoffSystem[0]->extra_setting_dateend)) : '' ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on("change", "#extra_setting_onoff", function () {
    $.post("<?= site_url('admin/ConAdminExtraSubject/ExtraSettingOnoff') ?>", { onoff: $(this).prop('checked') }, function (data, status) {
        if (data == 1) {
            alertify.success('เปลี่ยนแปลงข้อมูลเปิด - ปิดระบบสำเร็จ');
        } else {
            alertify.error('เปลี่ยนแปลงข้อมูลไม่สำเร็จ');
        }
    });
});

$(document).on("change", "#extra_setting_term", function () {
    $.post("<?= site_url('admin/ConAdminExtraSubject/ExtraSettingTerm') ?>", { Term: $(this).val() }, function (data, status) {
        if (data == 0) {
            alertify.error('เปลี่ยนแปลงข้อมูลไม่สำเร็จ');
        } else {
            alertify.success('คุณเปลี่ยนภาคเรียน ' + data + ' เรียบร้อย');
        }
    });
});

$(document).on("change", "#extra_setting_year", function () {
    $.post("<?= site_url('admin/ConAdminExtraSubject/ExtraSettingYear') ?>", { Year: $(this).val() }, function (data, status) {
        if (data == 0) {
            alertify.error('เปลี่ยนแปลงข้อมูลไม่สำเร็จ');
        } else {
            alertify.success('คุณเปลี่ยนภาคเรียน ' + data + ' เรียบร้อย');
        }
    });
});

$(document).on("change", "#extra_setting_datestart", function () {
    $.post("<?= site_url('admin/ConAdminExtraSubject/ExtraSettingDateStart') ?>", { DateStart: $(this).val() }, function (data, status) {
        console.log(data);
        if (data == 0) {
            alertify.error('เปลี่ยนแปลงข้อมูลไม่สำเร็จ');
        } else {
            alertify.success('คุณเปลี่ยนวันเริ่มต้นเป็น ' + data + ' เรียบร้อย');
        }
    });
});

$(document).on("change", "#extra_setting_dateend", function () {
    $.post("<?= site_url('admin/ConAdminExtraSubject/ExtraSettingDateEnd') ?>", { DateEnd: $(this).val() }, function (data, status) {
        console.log(data);
        if (data == 0) {
            alertify.error('เปลี่ยนแปลงข้อมูลไม่สำเร็จ');
        } else {
            alertify.success('คุณเปลี่ยนวันสิ้นสุดเป็น ' + data + ' เรียบร้อย');
        }
    });
});
</script>
<?= $this->endSection() ?>