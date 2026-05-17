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
/* Ensure SweetAlert2 is always on top of modals */
.swal2-container {
    z-index: 9999 !important;
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
        <div class="col-md-5 col-lg-3">
            <div class="choice-card text-center" onclick="switchMode('manual')" id="mode-manual">
                <div class="check-badge text-success fs-3"><i class='bx bxs-check-circle'></i></div>
                <div class="choice-icon">
                    <i class='bx bx-user-plus'></i>
                </div>
                <h4 class="fw-bold mb-2">เพิ่มทีละคน</h4>
                <p class="text-muted mb-0 small">เหมาะสำหรับเพิ่มนักเรียนใหม่ที่ย้ายเข้ามาระหว่างเทอม หรือต้องการข้อมูลละเอียด</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-3">
            <div class="choice-card text-center" onclick="switchMode('google')" id="mode-google">
                <div class="check-badge text-success fs-3"><i class='bx bxs-check-circle'></i></div>
                <div class="choice-icon">
                    <i class='bx bxl-google-cloud'></i>
                </div>
                <h4 class="fw-bold mb-2 text-success">นำเข้าเป็นชุด</h4>
                <p class="text-muted mb-0 small">จัดการข้อมูลผ่าน Google Sheets และซิงค์เข้าสู่ระบบแบบอัตโนมัติ</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-3">
            <div class="choice-card text-center" onclick="switchMode('admission')" id="mode-admission">
                <div class="check-badge text-success fs-3"><i class='bx bxs-check-circle'></i></div>
                <div class="choice-icon">
                    <i class='bx bx-building-house'></i>
                </div>
                <h4 class="fw-bold mb-2 text-success">จากระบบรับสมัคร</h4>
                <p class="text-muted mb-0 small">นำเข้าข้อมูลนักเรียนที่สมัครเข้าเรียนใหม่จากระบบงานรับสมัครนักเรียน</p>
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
                        <div class="bg-success bg-opacity-10 p-3 rounded-pill text-success me-3" style="background-color: rgba(21, 163, 98, 0.1) !important; color: #15a362 !important;">
                            <i class='bx bx-sync fs-2'></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-success" style="color: #15a362 !important;">ตั้งค่าการซิงค์ข้อมูล (Sync Settings)</h4>
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
                                        <div class="d-flex align-items-center text-success fw-bold" style="color: #15a362 !important;">
                                            <i class='bx bxs-check-shield fs-4 me-2'></i>
                                            ระบบตรวจสอบข้อมูลก่อนบันทึก (Safe Sync)
                                        </div>
                                        <div class="small text-muted">แสดงพรีวิวให้ตรวจสอบก่อนบันทึกจริงเสมอ</div>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 shadow-lg fw-bold" style="background-color: #15a362 !important; border-color: #15a362 !important;">
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

    <!-- ADMISSION Workspace -->
    <div id="section-admission" class="workspace-section">
        <div class="glass-panel p-4 p-lg-5">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 p-3 rounded-pill text-success me-3" style="background-color: rgba(21, 163, 98, 0.1) !important; color: #15a362 !important;">
                    <i class='bx bx-building-house fs-2'></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0" style="color: #15a362;">นำเข้าข้อมูลจากระบบรับสมัครนักเรียน</h4>
                    <p class="text-muted mb-0 small">เลือกนักเรียนจากช่องซ้าย แล้วตรวจสอบรายชื่อที่เลือกในช่องขวา ก่อนนำเข้าเข้าสู่ระบบ</p>
                </div>
            </div>

            <!-- Dual Panel Layout -->
            <div class="row g-4">
                <!-- LEFT PANEL: ค้นหาและเลือกนักเรียน -->
                <div class="col-lg-7">
                    <div class="card border shadow-none h-100" style="border-color: #20c997 !important; border-width: 1px !important;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(32, 201, 151, 0.15), rgba(32, 201, 151, 0.04)); border-bottom: 1px solid rgba(32, 201, 151, 0.15);">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold mb-0" style="color: #119a71;"><i class='bx bx-list-ul me-1 fs-5'></i> รายชื่อจากระบบรับสมัคร</h6>
                                <span class="badge bg-white text-success border px-3 py-2 rounded-pill fw-bold" id="admissionTotalBadge" style="border-color: #20c997 !important; color: #119a71 !important;">0 รายการ</span>
                            </div>
                            <!-- Filters -->
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <select id="admissionFilterYear" class="form-select form-select-sm rounded-3" style="border-color: rgba(32, 201, 151, 0.4) !important;">
                                        <option value="all">ทุกปีการศึกษา</option>
                                        <?php if(!empty($admission_years)): foreach($admission_years as $ay): ?>
                                            <option value="<?= $ay->recruit_year ?>"><?= $ay->recruit_year ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="admissionFilterClass" class="form-select form-select-sm rounded-3" style="border-color: rgba(32, 201, 151, 0.4) !important;">
                                        <option value="all">ทุกระดับชั้น</option>
                                        <?php if(!empty($admission_levels)): foreach($admission_levels as $al): ?>
                                            <option value="<?= $al->recruit_regLevel ?>"><?= $al->recruit_regLevel ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0" style="border-color: rgba(32, 201, 151, 0.4) !important;"><i class='bx bx-search text-muted'></i></span>
                                        <input type="text" id="admissionSearch" class="form-control border-start-0 rounded-end-3" placeholder="พิมพ์ชื่อ หรือเลขบัตร..." style="border-color: rgba(32, 201, 151, 0.4) !important;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0 table-sm" style="font-size: 0.82rem;">
                                <thead class="sticky-top" style="background-color: #f1faf6; border-bottom: 2px solid #20c997;">
                                    <tr class="text-nowrap" style="color: #119a71;">
                                        <th class="ps-3" style="width: 40px;">#</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>เลขบัตร ปชช.</th>
                                        <th>ชั้น</th>
                                        <th class="pe-3 text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody id="admissionTableBody">
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class='bx bx-search-alt fs-1 d-block mb-2 opacity-25'></i>
                                            <div class="small">เลือก "ปีการศึกษา" หรือ "ระดับชั้น" เพื่อแสดงรายชื่อ</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANEL: รายชื่อที่เลือกแล้ว (Basket) -->
                <div class="col-lg-5">
                    <div class="card border shadow-none h-100" style="border-color: #15a362 !important;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #15a36215, #15a36208);">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold mb-0" style="color: #15a362;"><i class='bx bx-check-circle me-1'></i> รายชื่อที่เลือก</h6>
                                <span class="badge bg-white text-success border border-success px-3 py-2 rounded-pill fw-bold" id="selectedCountBadge" style="border-color: #15a362 !important; color: #15a362 !important;">0 คน</span>
                            </div>
                        </div>
                        <div class="card-body p-0" style="max-height: 440px; overflow-y: auto;">
                            <div id="selectedBasketList" class="list-group list-group-flush">
                                <div class="text-center py-5 text-muted" id="emptyBasketMsg">
                                    <i class='bx bx-user-plus fs-1 d-block mb-2 opacity-25'></i>
                                    <div class="small">คลิกเลือกนักเรียนจากช่องซ้าย<br>เพื่อเพิ่มเข้ารายการนำเข้า</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" id="btnClearBasket" onclick="clearBasket()" style="display:none;">
                                    <i class='bx bx-trash me-1'></i> ล้างทั้งหมด
                                </button>
                                <span></span>
                            </div>
                            <button type="button" class="btn w-100 btn-lg rounded-pill fw-bold shadow-sm" id="btnImportAdmission" onclick="importAdmissionStudents()" disabled
                                style="background: #15a362; color: #fff; border: none;">
                                <i class='bx bx-import me-2 fs-4'></i> ตรวจสอบข้อมูลก่อนนำเข้า (<span id="selectedImportCount">0</span> คน)
                            </button>
                        </div>
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
            <div class="modal-header bg-success text-white border-0 py-3" style="background-color: #15a362 !important;">
                <h5 class="modal-title fw-bold text-white" id="previewSyncModalLabel">
                    <i class='bx bx-search-alt-2 me-2'></i>ตรวจสอบข้อมูลก่อนการซิงค์
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div id="previewSummary" class="fw-bold text-success" style="color: #15a362 !important;"></div>
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
                <button type="button" id="confirmSyncBtn" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold" style="background-color: #15a362 !important; border-color: #15a362 !important;">
                    <i class='bx bx-check-double me-1'></i> ยืนยันการซิงค์ข้อมูลจริง
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Admission Import Preview Modal -->
<div class="modal fade" id="admissionImportPreviewModal" tabindex="-1" aria-labelledby="admissionImportPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white border-0 py-3">
                <h5 class="modal-title fw-bold text-white" id="admissionImportPreviewModalLabel">
                    <i class='bx bx-check-shield me-2 fs-4'></i> ตรวจสอบและกรอกข้อมูลเพิ่มเติม (ก่อนนำเข้าจริง)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 d-flex flex-column h-100">
                <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div class="fw-bold text-success">
                        <i class='bx bx-info-circle me-1'></i> ตรวจพบนักเรียนที่เลือกทั้งหมด <span id="admPreviewCount" class="badge bg-success px-2 py-1 rounded-pill">0</span> คน กรุณากรอกหรือแก้ไขข้อมูลส่วนที่ยังไม่สมบูรณ์
                    </div>
                    <div class="small text-muted text-end">
                        <span class="text-danger">*</span> หมายถึงข้อมูลจำเป็นที่ต้องกรอก
                    </div>
                </div>
                <div class="table-responsive flex-grow-1" style="height: 0; min-height: 200px;">
                    <table class="table table-hover align-middle mb-0 table-sm" id="admissionPreviewTable" style="font-size: 0.85rem;">
                        <thead class="bg-light sticky-top">
                            <tr class="text-nowrap text-success" style="border-bottom: 2px solid var(--skj-primary);">
                                <th class="ps-4" style="width: 80px;">เลขที่ <span class="text-danger">*</span></th>
                                <th style="width: 100px;">ชั้นปี <span class="text-danger">*</span></th>
                                <th style="width: 130px;">เลขประจำตัว <span class="text-danger">*</span></th>
                                <th style="width: 100px;">คำนำหน้า</th>
                                <th style="width: 150px;">ชื่อ <span class="text-danger">*</span></th>
                                <th style="width: 150px;">นามสกุล <span class="text-danger">*</span></th>
                                <th style="width: 150px;">วันเกิด (วว/ดด/ปปปป พ.ศ.) <span class="text-danger">*</span></th>
                                <th style="width: 180px;">เลขบัตรประชาชน (13 หลัก) <span class="text-danger">*</span></th>
                                <th style="width: 180px;">สายการเรียน</th>
                                <th class="pe-4" style="width: 150px;">วันที่เข้าเรียน (พ.ศ.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically loaded via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3">
                <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" id="confirmAdmissionImportBtn" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold">
                    <i class='bx bx-check-double me-1'></i> บันทึกและนำเข้าข้อมูลเข้าระบบ
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
                    <div class="spinner-border text-success border-3 mb-3" style="width: 3.5rem; height: 3.5rem; color: #15a362 !important;"></div>
                    <h5 class="fw-bold mb-1 text-success" style="color: #15a362 !important;">${modeText}</h5>
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

    // =====================================================
    // Admission Import Functions — Dual Panel + Real-time Search
    // =====================================================

    let admissionData = [];
    let admissionExistingIds = [];
    let selectedBasket = {}; // { recruit_id: studentObj }
    let admissionSearchTimer = null;

    // Auto-load on filter change
    $('#admissionFilterYear, #admissionFilterClass').on('change', function() {
        loadAdmissionStudents();
    });

    // Real-time search with debounce (300ms)
    $('#admissionSearch').on('input', function() {
        clearTimeout(admissionSearchTimer);
        admissionSearchTimer = setTimeout(() => {
            loadAdmissionStudents();
        }, 300);
    });

    window.loadAdmissionStudents = function() {
        const targetYear = $('#admissionFilterYear').val();
        const targetClass = $('#admissionFilterClass').val();
        const search = $('#admissionSearch').val();

        // แสดง loading ในตารางซ้ายเท่านั้น (ไม่ใช้ Swal)
        $('#admissionTableBody').html(`
            <tr><td colspan="5" class="text-center py-4">
                <div class="spinner-border spinner-border-sm text-success me-2" style="color: #15a362 !important;"></div>
                <span class="text-muted small">กำลังโหลดข้อมูล...</span>
            </td></tr>
        `);

        $.ajax({
            url: '<?= base_url('Admin/Academic/ConAdminStudents/getAdmissionStudents') ?>',
            method: 'GET',
            data: { target_year: targetYear, target_class: targetClass, search: search },
            success: function(res) {
                if (res.status === 'success') {
                    admissionData = res.students || [];
                    admissionExistingIds = res.existing_ids || [];
                    renderAdmissionTable();
                } else {
                    $('#admissionTableBody').html(`
                        <tr><td colspan="5" class="text-center py-4 text-danger small">
                            <i class='bx bx-error-circle fs-3 d-block mb-1'></i>${res.message}
                        </td></tr>
                    `);
                }
            },
            error: function() {
                $('#admissionTableBody').html(`
                    <tr><td colspan="5" class="text-center py-4 text-danger small">
                        <i class='bx bx-error-circle fs-3 d-block mb-1'></i>ไม่สามารถเชื่อมต่อกับฐานข้อมูลรับสมัครได้
                    </td></tr>
                `);
            }
        });
    };

    function renderAdmissionTable() {
        const $tbody = $('#admissionTableBody');
        $tbody.empty();

        if (admissionData.length === 0) {
            $tbody.html(`<tr><td colspan="5" class="text-center py-5 text-muted">
                <i class='bx bx-inbox fs-1 d-block mb-2 opacity-25'></i>
                ไม่พบข้อมูลนักเรียน
            </td></tr>`);
            $('#admissionTotalBadge').text('0 รายการ');
            return;
        }

        let count = 0;
        admissionData.forEach((s) => {
            const fullName = `${s.recruit_prefix || ''}${s.recruit_firstName || ''} ${s.recruit_lastName || ''}`.trim();
            const idCard = s.recruit_idCard || '';
            const classVal = s.recruit_regLevel || '-';
            const idCardClean = idCard.replace(/-/g, '');
            const isDuplicate = admissionExistingIds.includes(idCardClean);
            const isSelected = selectedBasket.hasOwnProperty(s.recruit_id);
            const pkValue = s.recruit_id;

            let statusBadge, rowClass, cursorStyle;
            if (isDuplicate) {
                statusBadge = '<span class="badge bg-danger bg-opacity-10 text-danger px-2 rounded-pill" style="font-size:0.7rem;">ซ้ำ</span>';
                rowClass = 'table-secondary opacity-50';
                cursorStyle = 'cursor: not-allowed;';
            } else if (isSelected) {
                statusBadge = '<span class="badge bg-primary bg-opacity-10 text-primary px-2 rounded-pill" style="font-size:0.7rem;"><i class="bx bx-check"></i> เลือกแล้ว</span>';
                rowClass = 'table-success bg-opacity-10';
                cursorStyle = 'cursor: pointer;';
            } else {
                statusBadge = '<span class="badge bg-white text-success border border-success px-2 rounded-pill" style="font-size:0.7rem; border-color: #15a362 !important; color: #15a362 !important;">พร้อม</span>';
                rowClass = '';
                cursorStyle = 'cursor: pointer;';
            }

            count++;
            $tbody.append(`
                <tr class="${rowClass}" style="${cursorStyle}" 
                    onclick="${isDuplicate ? '' : `toggleStudentSelection(${pkValue})`}" 
                    data-recruit-id="${pkValue}">
                    <td class="ps-3 text-muted small">${count}</td>
                    <td class="fw-semibold">${fullName || '-'}</td>
                    <td class="font-monospace small">${idCard || '-'}</td>
                    <td class="small">${classVal}</td>
                    <td class="pe-3 text-center">${statusBadge}</td>
                </tr>
            `);
        });

        $('#admissionTotalBadge').text(`${admissionData.length} รายการ`);
    }

    window.toggleStudentSelection = function(recruitId) {
        if (selectedBasket.hasOwnProperty(recruitId)) {
            // ลบออกจาก basket
            delete selectedBasket[recruitId];
        } else {
            // เพิ่มเข้า basket
            const student = admissionData.find(s => s.recruit_id == recruitId);
            if (student) {
                selectedBasket[recruitId] = student;
            }
        }
        renderAdmissionTable(); // อัปเดตตารางซ้าย (สถานะ)
        renderBasket(); // อัปเดตช่องขวา
    };

    window.removeFromBasket = function(recruitId) {
        delete selectedBasket[recruitId];
        renderAdmissionTable();
        renderBasket();
    };

    window.clearBasket = function() {
        Swal.fire({
            title: 'ล้างรายชื่อทั้งหมด?',
            text: 'รายชื่อที่เลือกไว้จะถูกล้างออกทั้งหมด',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ล้างทั้งหมด',
            cancelButtonText: 'ยกเลิก'
        }).then(r => {
            if (r.isConfirmed) {
                selectedBasket = {};
                renderAdmissionTable();
                renderBasket();
            }
        });
    };

    function renderBasket() {
        const $list = $('#selectedBasketList');
        const keys = Object.keys(selectedBasket);
        const count = keys.length;

        $('#selectedCountBadge').text(`${count} คน`);
        $('#selectedImportCount').text(count);
        $('#btnImportAdmission').prop('disabled', count === 0);
        $('#btnClearBasket').toggle(count > 0);

        $list.empty();

        if (count === 0) {
            $list.html(`
                <div class="text-center py-5 text-muted" id="emptyBasketMsg">
                    <i class='bx bx-user-plus fs-1 d-block mb-2 opacity-25'></i>
                    <div class="small">คลิกเลือกนักเรียนจากช่องซ้าย<br>เพื่อเพิ่มเข้ารายการนำเข้า</div>
                </div>
            `);
            return;
        }

        keys.forEach((id, idx) => {
            const s = selectedBasket[id];
            const fullName = `${s.recruit_prefix || ''}${s.recruit_firstName || ''} ${s.recruit_lastName || ''}`.trim();
            const classVal = s.recruit_regLevel || '-';

            $list.append(`
                <div class="list-group-item d-flex align-items-center py-2 px-3" style="font-size: 0.82rem;">
                    <span class="badge bg-white text-success border border-success rounded-pill me-2" style="min-width: 28px; border-color: #15a362 !important; color: #15a362 !important;">${idx + 1}</span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">${fullName}</div>
                        <div class="text-muted" style="font-size: 0.72rem;">${classVal}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-0 d-flex align-items-center justify-content-center" 
                        style="width: 24px; height: 24px;" onclick="removeFromBasket(${id})" title="ลบออก">
                        <i class='bx bx-x' style="font-size: 14px;"></i>
                    </button>
                </div>
            `);
        });
    }

    window.importAdmissionStudents = function() {
        const selectedIds = Object.keys(selectedBasket).map(id => parseInt(id));

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'แจ้งเตือน',
                text: 'กรุณาเลือกนักเรียนอย่างน้อย 1 คน',
                confirmButtonColor: '#15a362',
                customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' }
            });
            return;
        }
        Swal.fire({
            title: 'กำลังเตรียมพรีวิวข้อมูล...',
            html: `
                <div class="text-center p-3">
                    <div class="spinner-border text-success mb-3" style="width: 3.5rem; height: 3.5rem;"></div>
                    <p class="text-muted small mb-0">กรุณารอสักครู่ ระบบกำลังดึงและจัดเรียงข้อมูล...</p>
                </div>`,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: '<?= base_url('Admin/Academic/ConAdminStudents/getAdmissionImportPreview') ?>',
            method: 'POST',
            data: {
                selected_ids: selectedIds,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function(res) {
                Swal.close();
                if (res.status === 'success') {
                    const $tbody = $('#admissionPreviewTable tbody');
                    $tbody.empty();

                    $('#admPreviewCount').text(res.students.length);

                    const studyLineOptions = [
                        "SMT(S)", "SMT(T)", "CEP", "CP", "PAP1", "PAP2", "PAP3", "PAP4", "SP1", "SP2", "SP3", "SP4"
                    ];

                    const classRoomOptions = [
                        '1/1','1/2','1/3','1/4','1/5','1/6',
                        '2/1','2/2','2/3','2/4','2/5','2/6',
                        '3/1','3/2','3/3','3/4','3/5','3/6',
                        '4/1','4/2','4/3','4/4','4/5','4/6',
                        '5/1','5/2','5/3','5/4','5/5','5/6',
                        '6/1','6/2','6/3','6/4','6/5','6/6'
                    ];

                    res.students.forEach((s, idx) => {
                        const trClass = s.isDuplicate ? 'table-danger bg-opacity-10' : '';
                        const dupWarning = s.isDuplicate ? `<div class="text-danger small mt-1 font-monospace" style="font-size:0.7rem;"><i class="bx bx-error-circle"></i> เลขบัตรประชาชนซ้ำในระบบ</div>` : '';

                        const slVal = (s.StudentStudyLine || '').trim();
                        const isPredefined = studyLineOptions.includes(slVal);
                        const selectedOption = isPredefined ? slVal : (slVal ? 'custom' : studyLineOptions[0]);
                        const showInputClass = (selectedOption === 'custom') ? '' : 'd-none';
                        const inputVal = (selectedOption === 'custom') ? slVal : '';

                        const optionsHtml = studyLineOptions.map(opt => 
                            `<option value="${opt}" ${selectedOption === opt ? 'selected' : ''}>${opt}</option>`
                        ).join('');

                        // สร้าง dropdown ชั้นปี
                        const classVal = (s.StudentClass || '').trim();
                        const classOptionsHtml = classRoomOptions.map(room => 
                            `<option value="${room}" ${classVal === room ? 'selected' : ''}>ม.${room}</option>`
                        ).join('');

                        $tbody.append(`
                            <tr class="${trClass}" data-idx="${idx}">
                                <td class="ps-4">
                                    <input type="text" class="form-control form-control-sm text-center fw-bold row-student-number" value="${s.StudentNumber}" style="width: 60px;">
                                    <input type="hidden" class="row-student-region" value="${s.StudentRegion || ''}">
                                    <input type="hidden" class="row-student-yearin" value="${s.YearIn || ''}">
                                </td>
                                <td>
                                    <select class="form-select form-select-sm row-student-class" style="width: 100px;">
                                        ${classOptionsHtml}
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm font-monospace text-primary fw-bold row-student-code" value="${s.StudentCode}" style="width: 120px;">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm row-student-prefix" value="${s.StudentPrefix}" style="width: 90px;">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm fw-bold row-student-firstname" value="${s.StudentFirstName}" style="width: 130px;">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm fw-bold row-student-lastname" value="${s.StudentLastName}" style="width: 130px;">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center row-student-birth" value="${s.StudentDateBirth}" placeholder="วว/ดด/ปปปป" style="width: 110px;">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm font-monospace row-student-idcard" value="${s.StudentIDNumber}" placeholder="เลข 13 หลัก" style="width: 150px;">
                                    ${dupWarning}
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <select class="form-select form-select-sm row-student-studyline-select" style="width: 150px;" onchange="handleStudyLineSelectChange(this)">
                                            ${optionsHtml}
                                            <option value="custom" ${selectedOption === 'custom' ? 'selected' : ''}>✏️ อื่นๆ...</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm row-student-studyline-input ${showInputClass}" value="${inputVal}" placeholder="ระบุสายการเรียน..." style="width: 150px;">
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <input type="text" class="form-control form-control-sm text-center row-student-entrance" value="${s.StudentDateEntrance}" style="width: 110px;">
                                </td>
                            </tr>
                        `);
                    });

                    const previewModal = new bootstrap.Modal(document.getElementById('admissionImportPreviewModal'));
                    previewModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: res.message,
                        confirmButtonColor: '#15a362'
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'การเชื่อมต่อล้มเหลว',
                    text: 'กรุณาตรวจสอบการเชื่อมต่อและลองอีกครั้ง',
                    confirmButtonColor: '#15a362'
                });
            }
        });
    };

    $('#confirmAdmissionImportBtn').on('click', function() {
        const students = [];
        let hasError = false;
        let errorMessage = '';

        $('#admissionPreviewTable tbody tr').each(function() {
            const $row = $(this);
            const num = $row.find('.row-student-number').val().trim();
            const cls = $row.find('.row-student-class').val().trim();
            const code = $row.find('.row-student-code').val().trim();
            const prefix = $row.find('.row-student-prefix').val().trim();
            const fname = $row.find('.row-student-firstname').val().trim();
            const lname = $row.find('.row-student-lastname').val().trim();
            const birth = $row.find('.row-student-birth').val().trim();
            const idcard = $row.find('.row-student-idcard').val().trim();
            let studyline = $row.find('.row-student-studyline-select').val();
            if (studyline === 'custom') {
                studyline = $row.find('.row-student-studyline-input').val().trim();
            }
            const entrance = $row.find('.row-student-entrance').val().trim();
            const region = $row.find('.row-student-region').val().trim();
            const yearin = $row.find('.row-student-yearin').val().trim();

            if (!num || !cls || !code || !fname || !lname || !birth || !idcard) {
                hasError = true;
                errorMessage = 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วนทุกช่อง (เลขที่, ชั้นปี, เลขประจำตัว, ชื่อ, นามสกุล, วันเกิด, เลขบัตรประชาชน)';
                return false; 
            }

            students.push({
                StudentNumber: num,
                StudentClass: cls,
                StudentCode: code,
                StudentPrefix: prefix,
                StudentFirstName: fname,
                StudentLastName: lname,
                StudentDateBirth: birth,
                StudentIDNumber: idcard,
                StudentStudyLine: studyline,
                StudentDateEntrance: entrance,
                StudentRegion: region,
                YearIn: yearin
            });
        });

        if (hasError) {
            Swal.fire({
                icon: 'warning',
                title: 'ข้อมูลไม่ครบถ้วน',
                text: errorMessage,
                confirmButtonColor: '#15a362'
            });
            return;
        }

        Swal.fire({
            title: 'ยืนยันการนำเข้าข้อมูล?',
            text: `ระบบจะนำเข้าข้อมูลนักเรียนทั้งหมด ${students.length} รายการเข้าสู่ระบบ`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันนำเข้า',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'rounded-pill px-4 fw-bold me-2', cancelButton: 'rounded-pill px-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึกข้อมูล...',
                    html: `
                        <div class="text-center p-3">
                            <div class="spinner-border text-success mb-3" style="width: 3.5rem; height: 3.5rem;"></div>
                            <h5 class="fw-bold mb-1">กำลังบันทึก ${students.length} รายการ</h5>
                            <p class="text-muted small mb-0">อาจใช้เวลาสักครู่ กรุณารอสักครู่...</p>
                        </div>`,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '<?= base_url('Admin/Academic/ConAdminStudents/processAdmissionImport') ?>',
                    method: 'POST',
                    data: {
                        students: students,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(res) {
                        Swal.close();
                        if (res.status === 'success') {
                            const modalEl = document.getElementById('admissionImportPreviewModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) modalInstance.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'นำเข้าสำเร็จ!',
                                html: `<div class="p-3 fs-6">${res.message}</div>`,
                                confirmButtonText: 'เรียบร้อย',
                                confirmButtonColor: '#15a362',
                                customClass: { confirmButton: 'rounded-pill px-5 fw-bold' }
                            }).then(() => {
                                selectedBasket = {};
                                renderAdmissionTable();
                                renderBasket();
                                loadAdmissionStudents();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด',
                                text: res.message,
                                confirmButtonColor: '#15a362'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        let errorMsg = 'กรุณาลองใหม่อีกครั้ง';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: errorMsg,
                            confirmButtonColor: '#15a362'
                        });
                    }
                });
            }
        });
    });

    window.handleStudyLineSelectChange = function(selectEl) {
        const $select = $(selectEl);
        const $input = $select.siblings('.row-student-studyline-input');
        if ($select.val() === 'custom') {
            $input.removeClass('d-none').focus();
        } else {
            $input.addClass('d-none');
        }
    };

    // Enter key สำหรับ search
    $('#admissionSearch').on('keypress', function(e) {
        if (e.which === 13) loadAdmissionStudents();
    });

});
</script>
<?= $this->endSection() ?>
