<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* Modern Green Premium Design System for Add Student */
:root {
    --skj-primary: #15a362;
    --skj-secondary: #20c997;
    --skj-light: #e8f5ed;
    --skj-dark: #10804d;
    --glass-bg: rgba(255, 255, 255, 0.9);
}

.add-student-container {
    padding-bottom: 4rem;
}

/* Choice Cards - Mode Selection */
.choice-card {
    border-radius: 24px;
    border: 3px solid transparent;
    background: #fff;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    height: 100%;
    position: relative;
    overflow: hidden;
    padding: 2.5rem 1.5rem;
}

.choice-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(21, 163, 98, 0.12);
    border-color: var(--skj-light);
}

.choice-card.active {
    border-color: var(--skj-primary);
    background: var(--skj-light);
}

.choice-icon {
    width: 80px;
    height: 80px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 1.5rem;
    background: #fff;
    color: var(--skj-primary);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: all 0.3s;
}

.choice-card.active .choice-icon {
    background: var(--skj-primary);
    color: #fff;
}

.choice-card .check-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s;
}

.choice-card.active .check-badge {
    opacity: 1;
    transform: scale(1);
}

/* Workspace Layout */
.workspace-section {
    display: none;
    animation: fadeInUp 0.5s ease both;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Glass Card for Forms */
.glass-panel {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 15px 50px rgba(0,0,0,0.08);
}

.premium-title {
    background: linear-gradient(135deg, var(--skj-primary), var(--skj-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
}

.sync-settings-card {
    background: #f8fdfa;
    border: 2px dashed var(--skj-primary);
    border-radius: 24px;
    padding: 2rem;
    margin-top: 2rem;
}

.action-card-sync {
    background: #fff;
    border-radius: 24px;
    padding: 2.5rem;
    border: 1px solid #eee;
    transition: all 0.3s;
    text-align: center;
    height: 100%;
}
.action-card-sync:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.05);
}

.form-check-input:checked {
    background-color: var(--skj-primary);
    border-color: var(--skj-primary);
}
</style>

<div class="add-student-container container-xxl">
    <!-- Header Banner -->
    <div class="row pt-4 mb-5">
        <div class="col-12 text-center">
            <h2 class="premium-title mb-2">ระบบเพิ่มข้อมูลนักเรียน</h2>
            <p class="text-muted fs-5">เลือกรูปแบบการนำเข้าข้อมูลที่ต้องการ เพื่อความสะดวกและรวดเร็ว</p>
        </div>
    </div>

    <!-- Mode Selectors -->
    <div class="row g-4 mb-5 justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="choice-card text-center" onclick="switchMode('manual')" id="mode-manual">
                <div class="check-badge text-success fs-3"><i class='bx bxs-check-circle'></i></div>
                <div class="choice-icon">
                    <i class='bx bx-user-plus'></i>
                </div>
                <h4 class="fw-bold mb-2">เพิ่มทีละคน</h4>
                <p class="text-muted mb-0 small">เหมาะสำหรับเพิ่มนักเรียนใหม่ที่ย้ายเข้ามาระหว่างเทอม หรือต้องการข้อมูลละเอียด</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div class="choice-card text-center" onclick="switchMode('google')" id="mode-google">
                <div class="check-badge text-primary fs-3"><i class='bx bxs-check-circle text-primary'></i></div>
                <div class="choice-icon">
                    <i class='bx bxl-google-cloud text-primary'></i>
                </div>
                <h4 class="fw-bold mb-2 text-primary">นำเข้าเป็นชุด</h4>
                <p class="text-muted mb-0 small">จัดการข้อมูลผ่าน Google Sheets และซิงค์เข้าสู่ระบบแบบอัตโนมัติ</p>
            </div>
        </div>
    </div>

    <!-- MANUAL Workspace -->
    <div id="section-manual" class="workspace-section">
        <form id="studentAddFormManual" action="<?= base_url('Admin/Acade/Registration/Students/Insert') ?>" method="post">
            <?= csrf_field() ?>
            <div class="glass-panel overflow-hidden border-0">
                <div class="bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success"><i class="bx bx-edit-alt me-2"></i>รายละเอียดข้อมูลนักเรียนรายบุคคล</h5>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-label-secondary rounded-pill px-4">ล้างฟอร์ม</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                            <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </div>
                <div class="p-4 p-lg-5">
                    <?php include('_student_details_form.php'); ?>
                </div>
                <div class="p-4 bg-light-subtle border-top text-center">
                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-lg fw-bold">
                        <i class="bx bx-save me-1"></i> ยืนยันบันทึกข้อมูลเข้าฐานข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- GOOGLE Workspace -->
    <div id="section-google" class="workspace-section">
        <div class="row g-4 justify-content-center pt-3">
            <!-- Open Google Sheets -->
            <div class="col-md-5">
                <div class="action-card-sync">
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 p-4 d-inline-block rounded-pill text-success mb-3">
                            <i class='bx bx-spreadsheet fs-1'></i>
                        </div>
                        <h4 class="fw-bold mb-2 text-success">จัดการข้อมูลใน Sheet</h4>
                        <p class="text-muted px-lg-4">เปิด Google Sheets เพื่อเพิ่มหรือแก้ไขข้อมูลนักเรียนเป็นกลุ่มให้สะดวกและรวดเร็ว</p>
                    </div>
                    <a href="https://docs.google.com/spreadsheets/d/1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec/edit?gid=0#gid=0" 
                       target="_blank" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm fw-bold">
                        <i class='bx bx-link-external me-2'></i> เปิด Google Sheet
                    </a>
                </div>
            </div>

            <!-- Sync Data -->
            <div class="col-md-7">
                <div class="glass-panel p-4 p-lg-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-pill text-primary me-3">
                            <i class='bx bx-sync fs-2'></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-primary">ตั้งค่าการซิงค์ข้อมูล (Sync Settings)</h4>
                            <p class="text-muted mb-0 small">กำหนดเงื่อนไขก่อนเริ่มดึงข้อมูลจาก Google Sheets</p>
                        </div>
                    </div>

                    <form id="googleSheetImportForm" action="<?= base_url('Admin/Acade/Registration/Students/ImportGoogle') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="spreadsheet_id" value="1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec">
                        <input type="hidden" name="sheet_name" value="stu1">
                        <input type="hidden" name="sheet_range" value="A2:L1300">
                        
                        <div class="row g-4">
                            <!-- Target Grade -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class='bx bx-filter-alt me-1'></i>เลือกระดับชั้นที่ต้องการซิงค์</label>
                                <select name="target_class" class="form-select rounded-3 p-2">
                                    <option value="all">-- ทุกระดับชั้น (ที่มีใน Sheet) --</option>
                                    <?php for($i=1;$i<=6;$i++): ?>
                                        <option value="ม.<?= $i ?>">ชั้นมัธยมศึกษาปีที่ <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="form-text small">ระบบจะนำเข้าข้อมูลเฉพาะนักเรียนที่อยู่ในระดับชั้นที่เลือก</div>
                            </div>

                            <!-- Sync Mode -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class='bx bx-git-pull-request me-1'></i>รูปแบบการจัดการข้อมูล</label>
                                <div class="bg-light p-3 rounded-3 border">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="sync_mode" id="modeUpsert" value="upsert" checked>
                                        <label class="form-check-label fw-semibold" for="modeUpsert">
                                            เพิ่มใหม่ + อัปเดตข้อมูลเก่า
                                        </label>
                                        <div class="small text-muted" style="margin-left: 1.5rem; font-size: 0.7rem;">ทับข้อมูลเดิมที่มีอยู่แล้วด้วยข้อมูลล่าสุดจาก Sheet</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sync_mode" id="modeAppend" value="append">
                                        <label class="form-check-label fw-semibold" for="modeAppend">
                                            เพิ่มเฉพาะรายชื่อใหม่เท่านั้น
                                        </label>
                                        <div class="small text-muted" style="margin-left: 1.5rem; font-size: 0.7rem;">ข้ามรายชื่อที่มีอยู่แล้วในระบบ ป้องกันการอัปเดตทับ</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operations -->
                            <div class="col-12 border-top pt-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center text-primary fw-bold">
                                            <i class='bx bxs-check-shield fs-4 me-2'></i>
                                            ระบบตรวจสอบข้อมูลก่อนบันทึก (Safe Sync)
                                        </div>
                                        <div class="small text-muted">แสดงพรีวิวให้ตรวจสอบก่อนบันทึกจริงเสมอ</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg fw-bold">
                                        <i class='bx bx-sync me-2 fs-4'></i> เริ่มการซิงค์ข้อมูล
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <div class="alert alert-info border-0 rounded-4 d-inline-block px-4 py-3 shadow-sm bg-opacity-10 bg-info">
                <div class="d-flex align-items-center text-dark">
                    <i class='bx bx-info-circle fs-3 me-2 text-info'></i>
                    <div class="small fw-semibold">
                        <b>ข้อแนะนำ:</b> หากมีการเพิ่มคอลัมน์ใหม่ใน Google Sheets กรุณาตรวจสอบลำดับคอลัมน์ให้ตรงตามระบบ 💎
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewSyncModal" tabindex="-1" aria-labelledby="previewSyncModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold text-white" id="previewSyncModalLabel">
                    <i class='bx bx-search-alt-2 me-2'></i>ตรวจสอบข้อมูลก่อนการซิงค์
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div id="previewSummary" class="fw-bold text-primary"></div>
                    <div class="small text-muted text-end">
                        <i class='bx bx-info-circle me-1'></i>กรุณาตรวจสอบความถูกต้องของข้อมูลก่อนยืนยัน
                    </div>
                </div>
                <div class="table-responsive h-100">
                    <table class="table table-hover align-middle mb-0 table-sm" id="previewTable" style="font-size: 0.78rem;">
                        <thead class="bg-light sticky-top">
                            <tr class="text-nowrap">
                                <th class="ps-4">เลขที่</th>
                                <th>ชั้นปี</th>
                                <th>เลขประจำตัว</th>
                                <th>คำนำหน้า</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>วันเกิด</th>
                                <th>เลขประจำตัวประชาชน</th>
                                <th>สถานะนักเรียน</th>
                                <th>สถานะพฤติกรรม</th>
                                <th>สายการเรียน</th>
                                <th>วันที่เข้าเรียน</th>
                                <th class="text-center">การเตรียมการ</th>
                                <th class="pe-4">หมายเหตุ/ข้อผิดพลาด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3">
                <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" id="confirmSyncBtn" class="btn btn-primary rounded-pill px-5 shadow-sm fw-bold">
                    <i class='bx bx-check-double me-1'></i> ยืนยันการซิงค์ข้อมูลจริง
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Include Thailand.js library -->
<script type="text/javascript" src="<?= SHARED_LIB_PATH ?>/thailand/JQL.min.js"></script>
<script type="text/javascript" src="<?= SHARED_LIB_PATH ?>/thailand/typeahead.bundle.js"></script>
<link rel="stylesheet" href="<?= SHARED_LIB_PATH ?>/thailand/jquery.Thailand.min.css">
<script type="text/javascript" src="<?= SHARED_LIB_PATH ?>/thailand/jquery.Thailand.min.js"></script>

<script>
function switchMode(mode) {
    $('.choice-card').removeClass('active');
    $(`#mode-${mode}`).addClass('active');

    $('.workspace-section').fadeOut(200, function() {
        $(`#section-${mode}`).fadeIn(300);
        $('html, body').animate({
            scrollTop: $(`#section-${mode}`).offset().top - 40
        }, 500);
    });
}

$(document).ready(function() {
    function updateFloatingLabels() {
        $('input, select, textarea').each(function() {
            if ($(this).val() !== '') {
                $(this).siblings('label').addClass('active');
            }
        });
    }

    const addressGroups = [
        { database: 'p_home', district: '#stu_hTambon', amphoe: '#stu_hDistrict', province: '#stu_hProvince', zipcode: '#stu_hPostCode' },
        { database: 'p_current', district: '#stu_cTumbao', amphoe: '#stu_cDistrict', province: '#stu_cProvince', zipcode: '#stu_cPostcode' },
        { database: 'p_school', district: '#stu_schoolTambao', amphoe: '#stu_schoolDistrict', province: '#stu_schoolProvince', zipcode: null }
    ];

    addressGroups.forEach(group => {
        $.Thailand({
            database: '<?= base_url('assets/database/db.json') ?>',
            $district: $(group.district), $amphoe: $(group.amphoe),
            $province: $(group.province), $zipcode: group.zipcode ? $(group.zipcode) : undefined,
            onDataFill: function(data) { setTimeout(updateFloatingLabels, 100); }
        });
    });

    // --- Individual Student Add Validation ---
    function checkThaiID(id) {
        if (!id || id.length !== 13 || !/^\d+$/.test(id)) return false;
        let sum = 0;
        for (let i = 0; i < 12; i++) {
            sum += parseFloat(id.charAt(i)) * (13 - i);
        }
        if ((11 - (sum % 11)) % 10 !== parseFloat(id.charAt(12))) return false;
        return true;
    }

    $(document).on('blur', '#StudentIDNumber, #StudentCode', function() {
        const $el = $(this);
        const name = $el.attr('name');
        const val = $el.val();
        if (!val) return;

        if (name === 'StudentIDNumber' && !checkThaiID(val)) {
            $el.addClass('is-invalid').removeClass('is-valid');
            Swal.fire({
                icon: 'error',
                title: 'เลขบัตรประชาชนไม่ถูกต้อง',
                text: 'กรุณาตรวจสอบเลขประจำตัวประชาชน 13 หลักให้ถูกต้องตามหลักการคำนวณ'
            });
            return;
        }

        $.ajax({
            url: '<?= base_url('Admin/Acade/Registration/Students/CheckDuplicate') ?>',
            method: 'POST',
            data: {
                [name]: val,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
            success: function(res) {
                if (res.status === 'duplicate') {
                    $el.addClass('is-invalid').removeClass('is-valid');
                    Swal.fire({
                        icon: 'warning',
                        title: res.message,
                        html: `
                            <div class="text-start p-3 border rounded bg-light" style="font-size: 0.9rem;">
                                <p class="mb-1"><strong>ชื่อ-นามสกุล:</strong> ${res.student.StudentPrefix}${res.student.StudentFirstName} ${res.student.StudentLastName}</p>
                                <p class="mb-1"><strong>เลขประจำตัว:</strong> ${res.student.StudentCode}</p>
                                <p class="mb-1"><strong>ชั้น:</strong> ${res.student.StudentClass} (เลขที่ ${res.student.StudentNumber})</p>
                                <p class="mb-0"><strong>สถานะ:</strong> <span class="badge bg-primary">${res.student.StudentStatus}</span></p>
                            </div>
                        `,
                        confirmButtonText: 'รับทราบ',
                        footer: '<div class="text-danger fw-bold"><i class="bx bx-error"></i> มีข้อมูลนี้อยู่ในระบบแล้ว กรุณาตรวจสอบ</div>'
                    });
                } else if (res.status === 'error_format') {
                    $el.addClass('is-invalid').removeClass('is-valid');
                    Swal.fire({ icon: 'error', title: 'รูปแบบไม่ถูกต้อง', text: res.message });
                } else {
                    $el.removeClass('is-invalid').addClass('is-valid');
                }
            }
        });
    });

    $('#studentAddFormManual').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const idNum = $('#StudentIDNumber').val();
        const stuCode = $('#StudentCode').val();

        // Final validation before actual submit
        if (!checkThaiID(idNum)) {
            Swal.fire('ข้อผิดพลาด', 'เลขประจำตัวประชาชนไม่ถูกต้อง', 'error');
            return;
        }

        if ($('.is-invalid').length > 0) {
            Swal.fire('ข้อผิดพลาด', 'กรุณาแก้ไขข้อมูลที่ซ้ำหรือผิดพลาดก่อนบันทึก', 'error');
            return;
        }

        submitForm($form, "เพิ่มนักเรียนรายบุคคลเรียบร้อยแล้ว", true);
    });

    $('#googleSheetImportForm').on('submit', function(e) {
        e.preventDefault();
        syncExecution(true);
    });

    function syncExecution(isDryRun) {
        const modeText = isDryRun ? 'กำลังตรวจสอบข้อมูล...' : 'กำลังบันทึกข้อมูลเข้าฐานข้อมูล...';

        Swal.fire({
            title: isDryRun ? 'เตรียมข้อมูลพรีวิว' : 'ระบบกำลังทำงาน',
            html: `
                <div class="text-center p-4">
                    <div class="spinner-border text-primary border-3 mb-3" style="width: 3.5rem; height: 3.5rem;"></div>
                    <h5 class="fw-bold mb-1 text-primary">${modeText}</h5>
                    <p class="text-muted small mb-0">อาจใช้เวลาสักครู่ ขึ้นอยู่กับปริมาณข้อมูล</p>
                </div>`,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const form = $('#googleSheetImportForm')[0];
        const formData = new FormData(form);
        formData.set('dry_run', isDryRun ? 'true' : 'false');

        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === 'success') {
                    if (isDryRun) {
                        Swal.close();
                        showPreviewModal(res);
                    } else {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: 'ซิงค์ข้อมูลสำเร็จ!',
                            html: `<div class="p-3 fs-6">${res.message}</div>`,
                            confirmButtonText: 'เรียบร้อย',
                            confirmButtonColor: '#15a362',
                            customClass: { confirmButton: 'rounded-pill px-5 fw-bold' }
                        }).then(() => {
                            window.location.href = "<?= base_url('Admin/Acade/Registration/Students') ?>";
                        });
                    }
                } else {
                    Swal.fire({ title: 'ผิดพลาด', text: res.message, icon: 'error' });
                }
            },
            error: function() {
                Swal.fire('เชื่อมต่อล้มเหลว', 'โปรดตรวจสอบการเชื่อมต่ออินเทอร์เน็ตหรือลองอีกครั้ง', 'error');
            }
        });
    }

    function showPreviewModal(data) {
        const $tbody = $('#previewTable tbody');
        $tbody.empty();
        
        $('#previewSummary').html(data.message);

        if (data.preview && data.preview.length > 0) {
            data.preview.forEach(item => {
                const actionBadge = item.Action === 'อัปเดต' 
                    ? '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 rounded-pill">อัปเดต</span>'
                    : '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 rounded-pill">เพิ่มใหม่</span>';

                $tbody.append(`
                    <tr class="${item.Action === 'ขัดแย้ง' || item.Action === 'ข้าม' && item.Notes.includes('ไม่ถูกต้อง') ? 'table-danger bg-opacity-10' : ''}">
                        <td class="ps-4 fw-bold text-nowrap">${item.StudentNumber || '-'}</td>
                        <td class="small fw-semibold text-nowrap">${item.StudentClass || '-'}</td>
                        <td class="text-primary font-monospace">${item.StudentCode || '-'}</td>
                        <td class="small">${item.StudentPrefix || '-'}</td>
                        <td class="small">${item.StudentFirstName || '-'}</td>
                        <td class="small">${item.StudentLastName || '-'}</td>
                        <td class="small text-nowrap">${item.StudentDateBirth || '-'}</td>
                        <td class="small font-monospace">${item.StudentIDNumber || '-'}</td>
                        <td class="small text-nowrap">${item.StudentStatus || '-'}</td>
                        <td class="small text-nowrap">${item.StudentBehavior || '-'}</td>
                        <td class="small text-nowrap">${item.StudentStudyLine || '-'}</td>
                        <td class="small text-nowrap">${item.StudentDateEntrance || '-'}</td>
                        <td class="text-center">${actionBadge}</td>
                        <td class="pe-4 small">${item.Notes || '-'}</td>
                    </tr>
                `);
            });
        } else {
            $tbody.append('<tr><td colspan="14" class="text-center py-5 text-muted">ไม่พบข้อมูลที่ตรงกับเงื่อนไขการซิงค์</td></tr>');
        }

        $('#previewSyncModal').modal('show');
    }

    $('#confirmSyncBtn').on('click', function() {
        $('#previewSyncModal').modal('hide');
        syncExecution(false);
    });

    function submitForm($form, successMsg, redirect) {
        Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: successMsg }).then(() => {
                        if(redirect) window.location.href = "<?= base_url('Admin/Acade/Registration/Students') ?>";
                    });
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    }

    updateFloatingLabels();
});
</script>
<?= $this->endSection() ?>
