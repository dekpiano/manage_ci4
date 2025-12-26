<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --light-green: #e8f5e9;
        --dark-green: #0d7042;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s;
    }

    .card-custom:hover {
        transform: translateY(-2px);
    }

    .header-banner {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        border-radius: 15px;
        color: white;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .header-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }

    .section-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        font-size: 1.5rem;
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-on {
        background-color: var(--light-green);
        color: var(--primary-green);
    }

    .status-off {
        background-color: #ffebee;
        color: #f44336;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Banner -->
    <div class="header-banner shadow-lg">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="display-6 fw-bold mb-2 text-white"><i class='bx bx-edit-alt me-2'></i><?= isset($title) ? esc($title) : 'ระบบบันทึกผลการเรียน' ?></h2>
                <p class="lead mb-0 op-8">จัดการสถานะการเปิด-ปิด ระบบการบันทึกคะแนน แยกตามกลุ่มนักเรียนและช่วงเวลา</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-white text-success px-3 py-2 fs-6 shadow-sm">
                    <i class='bx bx-calendar me-1'></i> <?= $selectedYear; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Configuration Panel - Normal Students -->
        <div class="col-lg-6">
            <div class="card card-custom border-top border-5 border-success h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0"><i class='bx bx-user'></i> ตั้งค่านักเรียนปกติ</h5>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input onoff_savescore" type="checkbox"
                                onoff-id="<?= isset($OnOffNormalMasters->onoff_id) ? esc($OnOffNormalMasters->onoff_id) : '' ?>"
                                value="<?= isset($OnOffNormalMasters->onoff_status) ? esc($OnOffNormalMasters->onoff_status) : '' ?>"
                                <?= (isset($OnOffNormalMasters->onoff_status) && $OnOffNormalMasters->onoff_status == "on") ? "checked" : ""?>>
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 border">
                        <h6 class="fw-bold mb-3 d-flex align-items-center"><i class='bx bx-list-check me-2 text-success'></i>ช่วงเวลาการเก็บคะแนน (ปกติ)</h6>
                        <div class="row g-3">
                            <?php foreach ($OnOffNormalPeriods as $v_OnOffSaveScore) : ?>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded shadow-sm border-start border-3 border-success">
                                        <div>
                                            <span class="fw-semibold small"><?= isset($v_OnOffSaveScore->onoff_name) ? esc($v_OnOffSaveScore->onoff_name) : '' ?></span>
                                            <div class="mt-1">
                                                <span class="status-badge py-0 px-2 <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "status-on" : "status-off"?>" style="font-size: 0.7rem;">
                                                    <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "เปิด" : "ปิด"?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input onoff_savescore" type="checkbox"
                                                onoff-id="<?= isset($v_OnOffSaveScore->onoff_id) ? esc($v_OnOffSaveScore->onoff_id) : '' ?>"
                                                value="<?= isset($v_OnOffSaveScore->onoff_status) ? esc($v_OnOffSaveScore->onoff_status) : '' ?>"
                                                <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "checked" : ""?>>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration Panel - Repeat Students -->
        <div class="col-lg-6">
            <div class="card card-custom border-top border-5 border-warning h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0" style="color: #856404;"><i class='bx bx-refresh'></i> ตั้งค่านักเรียนเรียนซ้ำ</h5>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input onoff_savescore" type="checkbox"
                                onoff-id="<?= isset($OnOffRepeatMasters->onoff_id) ? esc($OnOffRepeatMasters->onoff_id) : '' ?>"
                                value="<?= isset($OnOffRepeatMasters->onoff_status) ? esc($OnOffRepeatMasters->onoff_status) : '' ?>"
                                <?= (isset($OnOffRepeatMasters->onoff_status) && $OnOffRepeatMasters->onoff_status == "on") ? "checked" : ""?>>
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 border">
                        <h6 class="fw-bold mb-3 d-flex align-items-center"><i class='bx bx-list-check me-2 text-warning'></i>ช่วงเวลาการเก็บคะแนน (เรียนซ้ำ)</h6>
                        <div class="row g-3">
                            <?php foreach ($OnOffRepeatPeriods as $v_OnOffSaveScore) : ?>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded shadow-sm border-start border-3 border-warning">
                                        <div>
                                            <span class="fw-semibold small"><?= isset($v_OnOffSaveScore->onoff_name) ? esc($v_OnOffSaveScore->onoff_name) : '' ?></span>
                                            <div class="mt-1">
                                                <span class="status-badge py-0 px-2 <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "status-on" : "status-off"?>" style="font-size: 0.7rem;">
                                                    <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "เปิด" : "ปิด"?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input onoff_savescore" type="checkbox"
                                                onoff-id="<?= isset($v_OnOffSaveScore->onoff_id) ? esc($v_OnOffSaveScore->onoff_id) : '' ?>"
                                                value="<?= isset($v_OnOffSaveScore->onoff_status) ? esc($v_OnOffSaveScore->onoff_status) : '' ?>"
                                                <?= (isset($v_OnOffSaveScore->onoff_status) && $v_OnOffSaveScore->onoff_status == "on") ? "checked" : ""?>>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on("change", ".onoff_savescore", function() {
    var self = $(this);
    var isChecked = self.prop('checked');
    var badge = self.closest('.d-flex').find('.status-badge');

    $.post("<?= site_url('admin/academic/ConAdminSaveScore/CheckOnOffSaveScore') ?>", {
            check: isChecked,
            key: self.attr('onoff-id'),
            value: self.val()
        },
        function(data, status) {
            // Update the badge text and style dynamically
            if (badge.length) {
                if (isChecked) {
                    badge.text('เปิด').removeClass('status-off').addClass('status-on');
                } else {
                    badge.text('ปิด').removeClass('status-on').addClass('status-off');
                }
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'เปลี่ยนแปลงข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        });
})
</script>
<?= $this->endSection() ?>