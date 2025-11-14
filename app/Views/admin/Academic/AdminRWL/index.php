<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">วิชาการ /</span> ตั้งค่าระบบประเมินการอ่าน คิดวิเคราะห์และเขียน
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">ตั้งค่าการประเมิน</h5>
                <div class="card-body">

                    <form action="<?= base_url('admin/academic/rwl/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3 row">
                            <label for="status-toggle" class="col-md-2 col-form-label">สถานะระบบ</label>
                            <div class="col-md-10">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="status-toggle" name="status" value="on" <?= ($settings->onoff_status === 'on' || $settings->onoff_status === 'true') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status-toggle">
                                        เปิดใช้งานระบบประเมินการอ่าน คิดวิเคราะห์และเขียน
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="year-term-select" class="col-md-2 col-form-label">ปีการศึกษา/ภาคเรียน</label>
                            <div class="col-md-10">
                                <select id="year-term-select" class="form-select" name="year_term">
                                    <option>เลือกปีการศึกษา/ภาคเรียน</option>
                                    <?php foreach ($school_years as $year) : ?>
                                        <option value="<?= $year->year_term ?>" <?= ($settings->onoff_year == $year->year_term) ? 'selected' : '' ?>>
                                            ปีการศึกษา <?= explode('/', $year->year_term)[1] ?> / ภาคเรียนที่ <?= explode('/', $year->year_term)[0] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary">บันทึกการตั้งค่า</button>
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
    $(document).ready(function() {
        <?php if (session()->getFlashdata('swal_alert')) : ?>
            const alertData = <?= json_encode(session()->getFlashdata('swal_alert')) ?>;
            Swal.fire({
                icon: alertData.type,
                title: alertData.title,
                text: alertData.text,
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
