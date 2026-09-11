<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    /* Custom Modern UI Styles for Setup Page */
    .setup-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .setup-header {
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        color: white;
        padding: 2rem 1.5rem;
        text-align: center;
    }
    .setup-header-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    .form-control:focus, .form-select:focus {
        border-color: #15a362;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.25);
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        color: #15a362;
    }
    .input-group .form-control, .input-group .form-select {
        border-left: none;
    }
    .btn-emerald {
        background-color: #15a362;
        border-color: #15a362;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-emerald:hover {
        background-color: #0d6d41;
        border-color: #0d6d41;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.3);
    }
    .flatpickr-calendar {
        font-family: 'K2D', sans-serif !important;
    }
    .flatpickr-day.selected {
        background: #15a362 !important;
        border-color: #15a362 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">งานวิชาการ /</span> ตั้งค่าระบบวิจัย
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card setup-card">
                <div class="setup-header">
                    <i class="bx bx-cog setup-header-icon"></i>
                    <h4 class="mb-1 text-white fw-bold">กำหนดรอบการส่งงานวิจัย</h4>
                    <p class="mb-0 text-white-50">กำหนดปีการศึกษาและช่วงเวลาสำหรับการส่งไฟล์งานวิจัยของครูผู้สอน</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <?php 
                        $activeResearchYear = !empty($CheckYear[0]->seres_setup_year) ? $CheckYear[0]->seres_setup_year : get_selected_year_only();
                        $activeResearchTerm = !empty($CheckYear[0]->seres_setup_term) ? $CheckYear[0]->seres_setup_term : get_selected_term_only();
                        
                        // ฟังก์ชันแปลงวันที่เบื้องต้นสำหรับแสดงผลให้ดูง่ายขึ้น
                        function formatThaiDate($datetime) {
                            if (empty($datetime)) return '-';
                            $timestamp = strtotime($datetime);
                            $thai_months = [
                                1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
                                7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
                            ];
                            $d = date('j', $timestamp);
                            $m = $thai_months[date('n', $timestamp)];
                            $y = date('Y', $timestamp) + 543;
                            $t = date('H:i', $timestamp);
                            return "$d $m $y เวลา $t น.";
                        }
                    ?>
                    
                    <div class="alert alert-emerald d-flex align-items-center mb-4 shadow-sm border-0" role="alert" style="background-color: #e8f5ee; color: #0d6d41; border-left: 5px solid #15a362 !important;">
                        <i class="bx bx-info-circle fs-3 me-3 text-primary-emerald"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1" style="color: #0d6d41;">ข้อมูลรอบการส่งปัจจุบัน</h6>
                            <p class="mb-0 text-dark">
                                ปีการศึกษา <strong><?= esc($activeResearchYear) ?></strong> ภาคเรียนที่ <strong><?= esc($activeResearchTerm) ?></strong><br>
                                <span class="small text-muted">
                                    <i class='bx bx-time-five'></i> เปิดรับ: <?= formatThaiDate($CheckYear[0]->seres_setup_startdate ?? '') ?> 
                                    &nbsp;|&nbsp; 
                                    <i class='bx bx-timer'></i> ปิดรับ: <?= formatThaiDate($CheckYear[0]->seres_setup_enddate ?? '') ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <form action="#" method="post" id="FormSettingSendResearch">
                        <div class="row g-4">
                            <!-- ปีการศึกษา / ภาคเรียน -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">ปีการศึกษา / ภาคเรียน <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text"><i class="bx bx-calendar-star fs-4"></i></span>
                                    <select name="researchset_year" id="researchset_year" class="form-select border-start-0">
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
                                    <span class="input-group-text bg-light text-muted border-start border-end-0">ภาคเรียนที่</span>
                                    <select name="researchset_term" id="researchset_term" class="form-select border-start-0 text-center" style="max-width: 100px;">
                                        <?php for ($i=1; $i <=3 ; $i++):?>
                                        <option <?= $activeResearchTerm == $i ? 'selected' : ''?> value="<?= esc($i) ?>">
                                            <?= esc($i) ?>
                                        </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- วัน-เวลา เริ่มต้น -->
                            <div class="col-md-6">
                                <label for="researchset_startdate" class="form-label fw-bold text-dark">เปิดรับเวลา (เริ่มต้น) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text"><i class="bx bx-time-five fs-4"></i></span>
                                    <input type="text" name="researchset_startdate" id="researchset_startdate"
                                        class="form-control border-start-0 thai-datetime bg-white" placeholder="เลือกวัน-เวลาเริ่มต้น"
                                        value="<?= isset($CheckYear[0]->seres_setup_startdate) ? esc($CheckYear[0]->seres_setup_startdate) : '' ?>" readonly>
                                </div>
                            </div>

                            <!-- วัน-เวลา สิ้นสุด -->
                            <div class="col-md-6">
                                <label for="researchset_enddate" class="form-label fw-bold text-dark">ปิดรับเวลา (สิ้นสุด) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text"><i class="bx bx-timer fs-4"></i></span>
                                    <input type="text" name="researchset_enddate" id="researchset_enddate"
                                        class="form-control border-start-0 thai-datetime bg-white" placeholder="เลือกวัน-เวลาสิ้นสุด"
                                        value="<?= isset($CheckYear[0]->seres_setup_enddate) ? esc($CheckYear[0]->seres_setup_enddate) : '' ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-emerald btn-lg px-5 rounded-pill shadow-sm BtnUpdateSendResearch">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                <i class="bx bx-save fs-5 me-1"></i> บันทึกการตั้งค่า
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
    
    // ฟังก์ชันช่วยจัดการ Flatpickr ให้แสดงปี พ.ศ. ใน altInput และใน popup ปฏิทิน
    function convertToThaiYear(instance) {
        // เปลี่ยนปีในปฏิทินที่กำลังแสดงอยู่ (Header)
        if (instance.currentYearElement) {
            instance.currentYearElement.value = instance.currentYear + 543;
        }
        
        // เปลี่ยนปีใน input ที่แสดงผลให้ผู้ใช้เห็น (altInput)
        if (instance.altInput && instance.selectedDates.length > 0) {
            let date = instance.selectedDates[0];
            let yearAD = date.getFullYear();
            let yearBE = yearAD + 543;
            // ดึงค่าปัจจุบันที่ flatpickr format ไว้ แล้วเปลี่ยนปี ค.ศ. เป็น พ.ศ.
            let altValue = instance.altInput.value;
            instance.altInput.value = altValue.replace(yearAD, yearBE);
        }
    }

    // Initialize Flatpickr
    flatpickr(".thai-datetime", {
        enableTime: true,
        time_24hr: true,
        altInput: true,
        altFormat: "j F Y H:i", // จะถูก replace ปี ค.ศ. เป็น พ.ศ. ด้วย function convertToThaiYear
        dateFormat: "Y-m-d H:i:s", // รูปแบบที่จะส่งไป backend
        locale: "th",
        onReady: function(selectedDates, dateStr, instance) {
            convertToThaiYear(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertToThaiYear(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertToThaiYear(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertToThaiYear(instance);
        }
    });

    // Form Submit
    $('#FormSettingSendResearch').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnUpdateSendResearch');
        
        submitBtn.prop('disabled', true);
        submitBtn.find('.spinner-border').removeClass('d-none');
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '<?= base_url('admin/academic/research/update_setting') ?>', 
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
                        timer: 1500,
                        customClass: { popup: 'swal2-popup-on-top' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกไม่สำเร็จ',
                        text: response.message,
                        customClass: { popup: 'swal2-popup-on-top' }
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                    customClass: { popup: 'swal2-popup-on-top' }
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
