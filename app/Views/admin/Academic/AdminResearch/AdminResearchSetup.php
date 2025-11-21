<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="">

    <div class="d-flex align-items-center justify-content-between">
        <h3 class="page-title">จัดการ<?= isset($title) ? esc($title) : '' ?></h3>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            ตั้งค่าส่งงานวิจัย
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mt-2">
                <form action="#" method="post" id="FormSettingSendResearch" class="w-100">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="researchset_startdate" class="form-label">เริ่มต้น</label>
                            <input type="datetime-local" name="researchset_startdate" id="researchset_startdate"
                                class="form-control"
                                value="<?= isset($CheckYear[0]->seres_setup_startdate) ? esc($CheckYear[0]->seres_setup_startdate) : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="researchset_enddate" class="form-label">สิ้นสุด</label>
                            <input type="datetime-local" name="researchset_enddate" id="researchset_enddate"
                                class="form-control"
                                value="<?= isset($CheckYear[0]->seres_setup_enddate) ? esc($CheckYear[0]->seres_setup_enddate) : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="researchset_term" class="form-label">ปีการศึกษา</label>
                            <div class="d-flex">
                                <select name="researchset_term" id="researchset_term"
                                    class="form-select form-select-sm me-2">
                                    <?php for ($i=1; $i <=3 ; $i++):?>
                                    <option
                                        <?= (isset($CheckYear[0]->seres_setup_term) && $CheckYear[0]->seres_setup_term == $i) ? 'selected' : ''?>
                                        value="<?= esc($i) ?>">
                                        <?= esc($i) ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                                <select name="researchset_year" id="researchset_year"
                                    class="form-select form-select-sm">
                                    <?php $d = date("Y")+543; for ($i=$d-1; $i <= $d+1 ; $i++):?>
                                    <option
                                        <?= (isset($CheckYear[0]->seres_setup_year) && $CheckYear[0]->seres_setup_year == $i) ? 'selected' : ''?>
                                        value="<?= esc($i) ?>">
                                        <?= esc($i) ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 BtnUpdateSendResearch">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                บันทึก
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // FormSettingSendResearch submission
    $('#FormSettingSendResearch').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnUpdateSendResearch');
        submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('admin/academic/research/update_setting') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('สำเร็จ!', response.message, 'success');
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                    'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).find('.spinner-border').addClass(
                    'd-none');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
