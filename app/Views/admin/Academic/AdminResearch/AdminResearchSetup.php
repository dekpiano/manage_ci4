<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">งานวิชาการ /</span> ตั้งค่าระบบวิจัย
            </h4>

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-label-primary py-3">
                    <h5 class="mb-0 text-primary"><i class="bx bx-cog me-2"></i>กำหนดรอบการส่งงานวิจัย</h5>
                </div>
                <div class="card-body pt-4">
                    <form action="#" method="post" id="FormSettingSendResearch">
                        <div class="mb-4 text-center">
                            <div class="avatar avatar-xl mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-calendar-event fs-1"></i></span>
                            </div>
                            <h5 class="mb-1">ช่วงเวลาเปิดรับงานวิจัย</h5>
                            <p class="text-muted small">กำหนดวันเริ่มต้นและสิ้นสุดสำหรับครูผู้สอนในการส่งไฟล์งานวิจัย</p>
                        </div>

                        <div class="row g-3">
                             <div class="col-12">
                                <label class="form-label fw-bold">ปีการศึกษา / ภาคเรียน</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <select name="researchset_year" id="researchset_year" class="form-select">
                                        <?php 
                                            $d = date("Y")+543; 
                                            $activeResearchYear = !empty($CheckYear[0]->seres_setup_year) ? $CheckYear[0]->seres_setup_year : get_selected_year_only();
                                            $activeResearchTerm = !empty($CheckYear[0]->seres_setup_term) ? $CheckYear[0]->seres_setup_term : get_selected_term_only();
                                            for ($i=$d-1; $i <= $d+1 ; $i++):
                                        ?>
                                        <option <?= $activeResearchYear == $i ? 'selected' : ''?> value="<?= esc($i) ?>">
                                            ปีการศึกษา <?= esc($i) ?>
                                        </option>
                                        <?php endfor; ?>
                                    </select>
                                    <span class="input-group-text">ภาคเรียนที่</span>
                                    <select name="researchset_term" id="researchset_term" class="form-select">
                                        <?php for ($i=1; $i <=3 ; $i++):?>
                                        <option <?= $activeResearchTerm == $i ? 'selected' : ''?> value="<?= esc($i) ?>">
                                            <?= esc($i) ?>
                                        </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="researchset_startdate" class="form-label fw-bold">วัน-เวลา เริ่มต้น</label>
                                <input type="datetime-local" name="researchset_startdate" id="researchset_startdate"
                                    class="form-control"
                                    value="<?= isset($CheckYear[0]->seres_setup_startdate) ? esc($CheckYear[0]->seres_setup_startdate) : '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="researchset_enddate" class="form-label fw-bold">วัน-เวลา สิ้นสุด</label>
                                <input type="datetime-local" name="researchset_enddate" id="researchset_enddate"
                                    class="form-control"
                                    value="<?= isset($CheckYear[0]->seres_setup_enddate) ? esc($CheckYear[0]->seres_setup_enddate) : '' ?>">
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-primary px-4 BtnUpdateSendResearch">
                                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                <i class="bx bx-save me-1"></i> บันทึกการตั้งค่า
                            </button>
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
    $('#FormSettingSendResearch').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnUpdateSendResearch');
        var originalContent = submitBtn.html();
        
        submitBtn.prop('disabled', true);
        submitBtn.find('.spinner-border').removeClass('d-none');
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '<?= base_url('admin/academic/research/update_setting') ?>', // Ensure this URL matches your route
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกไม่สำเร็จ',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้: ' + error
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.find('.spinner-border').addClass('d-none');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
