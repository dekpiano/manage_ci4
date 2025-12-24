<?php 
// Create variables for easier access and handle potential null values
$student = $student ?? (object)[];
$fields = [
    'StudentID', 'StudentPrefix', 'StudentFirstName', 'StudentLastName', 'StudentCode', 'StudentIDNumber', 
    'StudentDateBirth', 'StudentClass', 'StudentNumber', 'StudentStudyLine', 'StudentStatus', 'StudentBehavior',
    'stu_nickName', 'stu_phone', 'stu_email', 'stu_bloodType', 'stu_diseaes', 'stu_nationality', 'stu_race', 
    'stu_religion', 'stu_wieght', 'stu_hieght', 'stu_hCode', 'stu_hNumber', 'stu_hMoo', 'stu_hRoad', 
    'stu_hTambon', 'stu_hDistrict', 'stu_hProvince', 'stu_hPostCode', 'stu_cNumber', 'stu_cMoo', 'stu_cRoad', 
    'stu_cTumbao', 'stu_cDistrict', 'stu_cProvince', 'stu_cPostcode', 'stu_birthTambon', 'stu_birthDistrict', 
    'stu_birthProvirce', 'stu_birthHospital', 'stu_numberSibling', 'stu_firstChild', 'stu_numberSiblingSkj', 
    'stu_parenalStatus', 'stu_presentLife', 'stu_personOther', 'stu_disablde', 'stu_talent', 'stu_natureRoom', 
    'stu_farSchool', 'stu_travel', 'stu_gradLevel', 'stu_schoolfrom', 'stu_schoolTambao', 'stu_schoolDistrict', 
    'stu_schoolProvince', 'stu_usedStudent', 'stu_inputLevel', 'stu_phoneUrgent', 'stu_phoneFriend', 
    'stu_future_education', 'stu_career_interest'
];

foreach ($fields as $field) {
    $$field = esc($student->$field ?? '');
}
?>

<style>
/* ===== Form Styling ===== */
.student-form {
    --primary-green: #28a745;
    --primary-green-light: #d4edda;
    --gradient-green: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

/* Alert Styling */
.alert-personnel-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
    border: none;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    border-left: 4px solid #ffc107;
}

.alert-personnel-warning i {
    color: #d39e00;
}

/* Tab Navigation */
.student-form .nav-tabs {
    border-bottom: 2px solid #e9ecef;
    gap: 0.25rem;
}

.student-form .nav-tabs .nav-link {
    border: none;
    border-radius: 12px 12px 0 0;
    padding: 0.85rem 1.25rem;
    font-weight: 500;
    color: #6c757d;
    background: transparent;
    transition: all 0.3s ease;
    position: relative;
}

.student-form .nav-tabs .nav-link:hover {
    color: var(--primary-green);
    background: rgba(40, 167, 69, 0.05);
}

.student-form .nav-tabs .nav-link.active {
    color: var(--primary-green);
    background: #fff;
    border-bottom: 3px solid var(--primary-green);
}

.student-form .nav-tabs .nav-link i {
    margin-right: 0.5rem;
}

/* Tab Content */
.student-form .tab-content {
    background: #fff;
    border-radius: 0 0 12px 12px;
    padding: 1.5rem;
}

/* Section Headers */
.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e9ecef;
}

.section-header h5 {
    font-weight: 600;
    color: #212529;
    margin: 0;
    font-size: 1.1rem;
}

.section-header i {
    color: var(--primary-green);
    font-size: 1.25rem;
    margin-right: 0.5rem;
}

.section-header .badge {
    margin-left: auto;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Form Floating */
.student-form .form-floating {
    margin-bottom: 0;
}

.student-form .form-floating .form-control,
.student-form .form-floating .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
    height: auto;
    transition: all 0.3s ease;
}

.student-form .form-floating .form-control:focus,
.student-form .form-floating .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
}

.student-form .form-floating label {
    padding: 1rem 0.9rem;
    color: #6c757d;
}

.student-form .form-floating > .form-control:focus ~ label,
.student-form .form-floating > .form-control:not(:placeholder-shown) ~ label,
.student-form .form-floating > .form-select ~ label {
    color: var(--primary-green);
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Readonly Input */
.student-form .form-control[readonly] {
    background: #f8f9fa;
    border-style: dashed;
}

/* Form Row */
.form-row {
    margin-bottom: 1rem;
}

/* Separator */
.form-separator {
    margin: 1.5rem 0;
    border: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #e9ecef, transparent);
}

/* Input Icons */
.input-icon-wrapper {
    position: relative;
}

.input-icon-wrapper .input-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    font-size: 1.25rem;
    pointer-events: none;
}

/* Info Text */
.info-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Responsive Tab Labels */
@media (max-width: 768px) {
    .student-form .nav-tabs .nav-link {
        padding: 0.75rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .student-form .nav-tabs .nav-link span {
        display: none;
    }
    
    .student-form .nav-tabs .nav-link i {
        margin-right: 0;
    }
}

/* Floating label fix for typeahead */
.form-floating.label-floated > label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.floating-new {
    padding-top: 1.625rem !important;
    padding-bottom: 0.625rem !important;
}
</style>

<div class="student-form">
    <?php if (isset($personnel_data_found) && !$personnel_data_found): ?>
    <div class="alert alert-personnel-warning d-flex align-items-start mb-3" role="alert">
        <i class="bx bx-info-circle bx-lg me-3 mt-1"></i>
        <div>
            <strong>แจ้งเตือน:</strong> ไม่พบข้อมูลนักเรียนในฐานข้อมูลส่วนตัว (personnel) ข้อมูลบางส่วนอาจไม่ถูกแสดงผล
        </div>
    </div>
    <?php endif; ?>

    <input type="hidden" name="StudentID" value="<?= $StudentID ?>">
    <input type="hidden" name="StudentIDNumber" value="<?= $StudentIDNumber ?>">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="studentEditTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info"
                type="button" role="tab" aria-controls="basic-info" aria-selected="true">
                <i class="bx bx-user"></i><span>ข้อมูลนักเรียน</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="personal-info-tab" data-bs-toggle="tab" data-bs-target="#personal-info"
                type="button" role="tab" aria-controls="personal-info" aria-selected="false">
                <i class="bx bx-heart"></i><span>ข้อมูลส่วนตัว</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button"
                role="tab" aria-controls="address" aria-selected="false">
                <i class="bx bx-home"></i><span>ที่อยู่</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button"
                role="tab" aria-controls="education" aria-selected="false">
                <i class="bx bx-book-open"></i><span>การศึกษาและอื่นๆ</span>
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="studentEditTabsContent">
        <!-- ==================== Basic Info Tab ==================== -->
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
            
            <!-- Basic Info Section -->
            <div class="section-header">
                <i class="bx bx-id-card"></i>
                <h5>ข้อมูลพื้นฐาน</h5>
                <span class="badge bg-success bg-opacity-10 text-success">จำเป็น</span>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" id="StudentPrefix" name="StudentPrefix">
                            <option value="">เลือก</option>
                            <?php foreach (['เด็กชาย', 'เด็กหญิง', 'นาย', 'นางสาว'] as $prefix): ?>
                            <option value="<?= $prefix ?>" <?= $StudentPrefix === $prefix ? 'selected' : '' ?>><?= $prefix ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="StudentPrefix">คำนำหน้า</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="StudentFirstName" name="StudentFirstName" placeholder="ชื่อ" value="<?= $StudentFirstName ?>">
                        <label for="StudentFirstName">ชื่อ</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="StudentLastName" name="StudentLastName" placeholder="นามสกุล" value="<?= $StudentLastName ?>">
                        <label for="StudentLastName">นามสกุล</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_nickName" name="stu_nickName" placeholder="ชื่อเล่น" value="<?= $stu_nickName ?>">
                        <label for="stu_nickName">ชื่อเล่น</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="StudentDateBirth" name="StudentDateBirth" placeholder="วันเกิด" value="<?= $StudentDateBirth ?>">
                        <label for="StudentDateBirth">วันเกิด</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="StudentCode" name="StudentCode" placeholder="เลขประจำตัว" value="<?= $StudentCode ?>" readonly>
                        <label for="StudentCode">เลขประจำตัว</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="StudentIDNumber" name="StudentIDNumber" placeholder="เลขประจำตัวประชาชน" value="<?= $StudentIDNumber ?>" pattern="[0-9]{13}" maxlength="13" title="กรอกเลข 13 หลักไม่ต้องมีขีด">
                        <label for="StudentIDNumber">เลขประจำตัวประชาชน</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="stu_phone" name="stu_phone" placeholder="เบอร์โทรศัพท์" value="<?= $stu_phone ?>">
                        <label for="stu_phone">เบอร์โทรศัพท์</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="stu_email" name="stu_email" placeholder="อีเมล" value="<?= $stu_email ?>">
                        <label for="stu_email">อีเมล</label>
                    </div>
                </div>
            </div>
            
            <hr class="form-separator">
            
            <!-- Academic Info Section -->
            <div class="section-header">
                <i class="bx bx-book-reader"></i>
                <h5>ข้อมูลการเรียน</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="StudentClass" name="StudentClass">
                            <option value="">เลือกระดับชั้น</option>
                            <?php if (!empty($class_list)): foreach ($class_list as $cls): ?>
                            <option value="ม.<?= $cls ?>" <?= $StudentClass === ('ม.' . $cls) ? 'selected' : '' ?>>ม.<?= $cls ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                        <label for="StudentClass">ระดับชั้น</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="StudentNumber" name="StudentNumber" placeholder="เลขที่" value="<?= $StudentNumber ?>">
                        <label for="StudentNumber">เลขที่</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="StudentStudyLine" name="StudentStudyLine">
                            <option value="">เลือกสายการเรียน</option>
                            <?php if (!empty($study_line_list)): foreach ($study_line_list as $line): ?>
                            <option value="<?= $line ?>" <?= $StudentStudyLine === $line ? 'selected' : '' ?>><?= $line ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                        <label for="StudentStudyLine">สายการเรียน</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" id="StudentSex" name="StudentSex">
                            <option value="">เลือก</option>
                            <option value="ชาย" <?= ($student->StudentSex ?? '') === 'ชาย' ? 'selected' : '' ?>>ชาย</option>
                            <option value="หญิง" <?= ($student->StudentSex ?? '') === 'หญิง' ? 'selected' : '' ?>>หญิง</option>
                        </select>
                        <label for="StudentSex">เพศ</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="StudentStatus" name="StudentStatus">
                            <option value="">สถานะนักเรียน</option>
                            <?php foreach (['1/ปกติ', '2/ย้ายสถานศึกษา', '3/ขาดประจำ', '4/พักการเรียน', '5/จบการศึกษา'] as $status): ?>
                            <option value="<?= $status ?>" <?= $StudentStatus === $status ? 'selected' : '' ?>><?= $status ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="StudentStatus">สถานะนักเรียน</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="StudentBehavior" name="StudentBehavior">
                            <option value="">สถานะพฤติกรรม</option>
                            <?php foreach (['ปกติ', 'ขาดเรียนนาน', 'จำหน่าย'] as $behavior): ?>
                            <option value="<?= $behavior ?>" <?= $StudentBehavior === $behavior ? 'selected' : '' ?>><?= $behavior ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="StudentBehavior">สถานะพฤติกรรม</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== Personal Info Tab ==================== -->
        <div class="tab-pane fade" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
            
            <!-- Health Info Section -->
            <div class="section-header">
                <i class="bx bx-plus-medical"></i>
                <h5>ข้อมูลสุขภาพ</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" step="0.1" class="form-control" id="stu_wieght" name="stu_wieght" placeholder="น้ำหนัก" value="<?= $stu_wieght ?>">
                        <label for="stu_wieght">น้ำหนัก (กก.)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" step="0.1" class="form-control" id="stu_hieght" name="stu_hieght" placeholder="ส่วนสูง" value="<?= $stu_hieght ?>">
                        <label for="stu_hieght">ส่วนสูง (ซม.)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="stu_bloodType" name="stu_bloodType">
                            <option value="">เลือกกรุ๊ปเลือด</option>
                            <?php foreach (['A', 'B', 'AB', 'O'] as $blood): ?>
                            <option value="<?= $blood ?>" <?= $stu_bloodType === $blood ? 'selected' : '' ?>><?= $blood ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="stu_bloodType">กรุ๊ปเลือด</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_diseaes" name="stu_diseaes" placeholder="โรคประจำตัว" value="<?= $stu_diseaes ?>">
                        <label for="stu_diseaes">โรคประจำตัว</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_disablde" name="stu_disablde" placeholder="ความพิการ" value="<?= $stu_disablde ?>">
                        <label for="stu_disablde">ความพิการ (ถ้ามี)</label>
                    </div>
                </div>
            </div>
            
            <hr class="form-separator">
            
            <!-- Nationality Section -->
            <div class="section-header">
                <i class="bx bx-flag"></i>
                <h5>ข้อมูลสัญชาติ</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_nationality" name="stu_nationality" placeholder="สัญชาติ" value="<?= $stu_nationality ?>">
                        <label for="stu_nationality">สัญชาติ</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_race" name="stu_race" placeholder="เชื้อชาติ" value="<?= $stu_race ?>">
                        <label for="stu_race">เชื้อชาติ</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="stu_religion" name="stu_religion">
                            <option value="">เลือกศาสนา</option>
                            <?php foreach (['พุทธ', 'คริสต์', 'อิสลาม', 'ฮินดู', 'ซิกข์', 'อื่นๆ'] as $religion): ?>
                            <option value="<?= $religion ?>" <?= $stu_religion === $religion ? 'selected' : '' ?>><?= $religion ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="stu_religion">ศาสนา</label>
                    </div>
                </div>
            </div>
            
            <hr class="form-separator">
            
            <!-- Family Section -->
            <div class="section-header">
                <i class="bx bx-group"></i>
                <h5>ข้อมูลครอบครัว</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="stu_numberSibling" name="stu_numberSibling" placeholder="จำนวนพี่น้อง" value="<?= $stu_numberSibling ?>">
                        <label for="stu_numberSibling">จำนวนพี่น้อง (คน)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="stu_firstChild" name="stu_firstChild" placeholder="เป็นบุตรคนที่" value="<?= $stu_firstChild ?>">
                        <label for="stu_firstChild">เป็นบุตรคนที่</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="stu_numberSiblingSkj" name="stu_numberSiblingSkj" placeholder="พี่น้องที่เรียน SKJ" value="<?= $stu_numberSiblingSkj ?>">
                        <label for="stu_numberSiblingSkj">พี่น้องที่เรียน SKJ</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="stu_parenalStatus" name="stu_parenalStatus">
                            <option value="">เลือกสถานภาพ</option>
                            <?php foreach (['อยู่ด้วยกัน', 'แยกกันอยู่', 'หย่าร้าง', 'บิดาถึงแก่กรรม', 'มารดาถึงแก่กรรม', 'ถึงแก่กรรมทั้งคู่'] as $status): ?>
                            <option value="<?= $status ?>" <?= $stu_parenalStatus === $status ? 'selected' : '' ?>><?= $status ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="stu_parenalStatus">สถานภาพบิดามารดา</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" id="stu_presentLife" name="stu_presentLife">
                            <option value="">เลือก</option>
                            <?php foreach (['บิดา-มารดา', 'บิดา', 'มารดา', 'ญาติ', 'อื่นๆ'] as $living): ?>
                            <option value="<?= $living ?>" <?= $stu_presentLife === $living ? 'selected' : '' ?>><?= $living ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="stu_presentLife">ปัจจุบันอาศัยอยู่กับ</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_personOther" name="stu_personOther" placeholder="กรณีอื่นๆ" value="<?= $stu_personOther ?>">
                        <label for="stu_personOther">กรณีอื่นๆ (ระบุ)</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== Address Tab ==================== -->
        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            
            <!-- Home Address Section -->
            <div class="section-header">
                <i class="bx bx-home-heart"></i>
                <h5>ที่อยู่ตามทะเบียนบ้าน</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_hNumber" name="stu_hNumber" placeholder="บ้านเลขที่" value="<?= $stu_hNumber ?>">
                        <label for="stu_hNumber">บ้านเลขที่</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_hMoo" name="stu_hMoo" placeholder="หมู่" value="<?= $stu_hMoo ?>">
                        <label for="stu_hMoo">หมู่</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_hRoad" name="stu_hRoad" placeholder="ถนน" value="<?= $stu_hRoad ?>">
                        <label for="stu_hRoad">ถนน</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_hTambon" id="stu_hTambon" placeholder="" value="<?= $stu_hTambon ?>">
                        <label for="stu_hTambon">ตำบล/แขวง</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_hDistrict" id="stu_hDistrict" placeholder="" value="<?= $stu_hDistrict ?>">
                        <label for="stu_hDistrict">อำเภอ/เขต</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_hProvince" id="stu_hProvince" placeholder="" value="<?= $stu_hProvince ?>">
                        <label for="stu_hProvince">จังหวัด</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_hPostCode" id="stu_hPostCode" placeholder="" value="<?= $stu_hPostCode ?>">
                        <label for="stu_hPostCode">รหัสไปรษณีย์</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_hCode" name="stu_hCode" placeholder="รหัสบ้าน" value="<?= $stu_hCode ?>">
                        <label for="stu_hCode">รหัสบ้าน (11 หลัก)</label>
                    </div>
                </div>
            </div>
            
            <hr class="form-separator">
            
            <!-- Current Address Section -->
            <div class="section-header">
                <i class="bx bx-current-location"></i>
                <h5>ที่อยู่ปัจจุบัน</h5>
                <span class="badge bg-info bg-opacity-10 text-info">สำหรับติดต่อ</span>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_cNumber" name="stu_cNumber" placeholder="บ้านเลขที่" value="<?= $stu_cNumber ?>">
                        <label for="stu_cNumber">บ้านเลขที่</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_cMoo" name="stu_cMoo" placeholder="หมู่" value="<?= $stu_cMoo ?>">
                        <label for="stu_cMoo">หมู่</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_cRoad" name="stu_cRoad" placeholder="ถนน" value="<?= $stu_cRoad ?>">
                        <label for="stu_cRoad">ถนน</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_cTumbao" id="stu_cTumbao" placeholder="" value="<?= $stu_cTumbao ?>">
                        <label for="stu_cTumbao">ตำบล/แขวง</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_cDistrict" id="stu_cDistrict" placeholder="" value="<?= $stu_cDistrict ?>">
                        <label for="stu_cDistrict">อำเภอ/เขต</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_cProvince" id="stu_cProvince" placeholder="" value="<?= $stu_cProvince ?>">
                        <label for="stu_cProvince">จังหวัด</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control floating-new" name="stu_cPostcode" id="stu_cPostcode" placeholder="" value="<?= $stu_cPostcode ?>">
                        <label for="stu_cPostcode">รหัสไปรษณีย์</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== Education Tab ==================== -->
        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
            
            <!-- Previous Education Section -->
            <div class="section-header">
                <i class="bx bx-building-house"></i>
                <h5>ข้อมูลการศึกษาเดิม</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_gradLevel" name="stu_gradLevel" placeholder="จบชั้น" value="<?= $stu_gradLevel ?>">
                        <label for="stu_gradLevel">จบระดับชั้น</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_schoolfrom" name="stu_schoolfrom" placeholder="จากโรงเรียน" value="<?= $stu_schoolfrom ?>">
                        <label for="stu_schoolfrom">จากโรงเรียน</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_usedStudent" name="stu_usedStudent" placeholder="รหัสนักเรียนเดิม" value="<?= $stu_usedStudent ?>">
                        <label for="stu_usedStudent">รหัสนักเรียนเดิม</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_schoolTambao" name="stu_schoolTambao" placeholder="ตำบล" value="<?= $stu_schoolTambao ?>">
                        <label for="stu_schoolTambao">ตำบล</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_schoolDistrict" name="stu_schoolDistrict" placeholder="อำเภอ" value="<?= $stu_schoolDistrict ?>">
                        <label for="stu_schoolDistrict">อำเภอ</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_schoolProvince" name="stu_schoolProvince" placeholder="จังหวัด" value="<?= $stu_schoolProvince ?>">
                        <label for="stu_schoolProvince">จังหวัด</label>
                    </div>
                </div>
            </div>
            
            <hr class="form-separator">
            
            <!-- Other Info Section -->
            <div class="section-header">
                <i class="bx bx-star"></i>
                <h5>ข้อมูลอื่นๆ</h5>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_talent" name="stu_talent" placeholder="ความสามารถพิเศษ" value="<?= $stu_talent ?>">
                        <label for="stu_talent">ความสามารถพิเศษ</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" step="0.1" class="form-control" id="stu_farSchool" name="stu_farSchool" placeholder="ระยะทางมาโรงเรียน" value="<?= $stu_farSchool ?>">
                        <label for="stu_farSchool">ระยะทางมาโรงเรียน (กม.)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="stu_travel" name="stu_travel">
                            <option value="">เลือก</option>
                            <?php foreach (['ผู้ปกครองมาส่ง', 'รถยนต์ส่วนตัว', 'รถจักรยานยนต์', 'รถประจำทาง', 'รถรับส่งนักเรียน', 'เดิน', 'อื่นๆ'] as $travel): ?>
                            <option value="<?= $travel ?>" <?= $stu_travel === $travel ? 'selected' : '' ?>><?= $travel ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="stu_travel">การเดินทางมาโรงเรียน</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="stu_phoneUrgent" name="stu_phoneUrgent" placeholder="เบอร์โทรฉุกเฉิน" value="<?= $stu_phoneUrgent ?>">
                        <label for="stu_phoneUrgent">เบอร์โทรฉุกเฉิน</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="stu_phoneFriend" name="stu_phoneFriend" placeholder="เบอร์เพื่อนสนิท" value="<?= $stu_phoneFriend ?>">
                        <label for="stu_phoneFriend">เบอร์เพื่อนสนิท</label>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 form-row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_future_education" name="stu_future_education" placeholder="ศึกษาต่อ" value="<?= $stu_future_education ?>">
                        <label for="stu_future_education">แผนการศึกษาต่อ</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="stu_career_interest" name="stu_career_interest" placeholder="อาชีพที่สนใจ" value="<?= $stu_career_interest ?>">
                        <label for="stu_career_interest">อาชีพที่สนใจ</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>