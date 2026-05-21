<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<?php
// คำนวณสถิติรวมจังหวัดทั้งหมดไว้ก่อน เพื่อใช้ทั้งในส่วน JS และ HTML
$totalAllProvinces = 0;
$totalAllMale = 0;
$totalAllFemale = 0;
$totalProvinceCount = 0;
if (!empty($provinces)) {
    foreach ($provinces as $pv) {
        $totalAllProvinces += $pv->total_count;
        $totalAllMale += $pv->male_count;
        $totalAllFemale += $pv->female_count;
    }
    $totalProvinceCount = count($provinces);
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap py-3 mb-4 gap-2 border-bottom border-light">
        <h4 class="fw-bold m-0 text-dark">
            <span class="text-muted fw-light">จัดการข้อมูลนักเรียน /</span> ข้อมูลนักเรียนสำหรับ LEC
        </h4>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addressCleansingModal" style="padding: 0.55rem 1.15rem; border-radius: 8px; font-weight: 600; border-color: #d9dee3; background-color: #fff; color: #566a7f;">
                <i class="bx bx-cog fs-4 text-secondary"></i>
                <span>ล้างข้อมูลสะกดผิดที่อยู่ (Cleansing Tool)</span>
            </button>
            <button type="button" class="btn btn-success shadow-sm d-flex align-items-center gap-1 animate__animated animate__pulse animate__infinite animate__slower" data-bs-toggle="modal" data-bs-target="#dashboardModal" style="background-color: #15a362; border-color: #15a362; padding: 0.55rem 1.15rem; border-radius: 8px; font-weight: 600;">
                <i class="bx bx-bar-chart-alt-2 fs-4"></i>
                <span>สรุปและวิเคราะห์สถิติเชิงลึก (In-depth Analytics)</span>
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Widgets -->
    <div class="row g-3 mb-4">
        <!-- Card 1: นักเรียนทั้งหมด -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar flex-shrink-0 p-2 rounded" style="background-color: #e8f5ed !important;">
                            <i class="bx bx-group fs-3" style="color: #15a362;"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold text-success" style="background-color: #e8f5ed; color: #15a362;">ปกติ</span>
                    </div>
                    <span class="d-block mb-1 text-muted fw-semibold">นักเรียนสถานะปกติ</span>
                    <h3 class="card-title mb-2 text-success fw-bold" id="statTotalActive"><?= number_format($stats['total_active']) ?> <span class="fs-6 fw-normal text-muted">คน</span></h3>
                    <small class="text-muted"><i class="bx bx-user me-1 text-success"></i>กำลังศึกษาในปัจจุบัน</small>
                </div>
            </div>
        </div>
        
        <!-- Card 2: ชาย / หญิง -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar flex-shrink-0 p-2 rounded" style="background-color: #e3f2fd !important;">
                            <i class="bx bx-male-female fs-3" style="color: #03a9f4;"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold text-info" style="background-color: #e3f2fd; color: #03a9f4;">สัดส่วนเพศ</span>
                    </div>
                    <span class="d-block mb-1 text-muted fw-semibold">ชาย / หญิง (ปกติ)</span>
                    <h3 class="card-title mb-2 text-info fw-bold">
                        <span id="statMale"><?= number_format($stats['male']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span> / 
                        <span id="statFemale"><?= number_format($stats['female']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span>
                    </h3>
                    <small class="text-muted"><i class="bx bx-check-double me-1 text-info"></i>คิดตามข้อมูลระบุเพศ</small>
                </div>
            </div>
        </div>

        <!-- Card 3: ระดับชั้น ม.ต้น / ม.ปลาย -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar flex-shrink-0 p-2 rounded" style="background-color: #ebeefc !important;">
                            <i class="bx bx-book-reader fs-3" style="color: #696cff;"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold text-primary" style="background-color: #ebeefc; color: #696cff;">ระดับชั้น</span>
                    </div>
                    <span class="d-block mb-1 text-muted fw-semibold">ม.ต้น / ม.ปลาย (ปกติ)</span>
                    <h3 class="card-title mb-2 text-primary fw-bold">
                        <span id="statLowerSec"><?= number_format($stats['lower_sec']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span> / 
                        <span id="statUpperSec"><?= number_format($stats['upper_sec']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span>
                    </h3>
                    <small class="text-muted"><i class="bx bx-graduation me-1 text-primary"></i>จำแนกตามช่วงชั้นเรียน</small>
                </div>
            </div>
        </div>

        <!-- Card 4: ความเสี่ยง / จำหน่าย -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar flex-shrink-0 p-2 rounded" style="background-color: #ffebee !important;">
                            <i class="bx bx-error-alt fs-3" style="color: #ff3e1d;"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold text-danger" style="background-color: #ffebee; color: #ff3e1d;">ความเสี่ยง</span>
                    </div>
                    <span class="d-block mb-1 text-muted fw-semibold">ขาดเรียนนาน / จำหน่าย</span>
                    <h3 class="card-title mb-2 text-danger fw-bold">
                        <span id="statBehaviorRisk"><?= number_format($stats['behavior_risk']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span> / 
                        <span id="statBehaviorDismissed"><?= number_format($stats['behavior_dismissed']) ?></span> <span class="fs-6 fw-normal text-muted">คน</span>
                    </h3>
                    <small class="text-muted"><i class="bx bx-shield-quarter me-1 text-danger"></i>กลุ่มเฝ้าระวัง & พ้นสภาพ</small>
                </div>
            </div>
        </div>
    </div>



    <div class="row g-4">
        <!-- Sidebar Filters & Column Selectors -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-filter-alt me-2"></i>ตัวกรองข้อมูลนักเรียน
                    </h5>
                </div>
                <div class="card-body pt-3">
                    <!-- Filters Form -->
                    <form id="filterForm">
                        <!-- Class Filter -->
                        <div class="mb-3">
                            <label for="classFilter" class="form-label fw-bold">ระดับชั้น / ห้องเรียน</label>
                            <select id="classFilter" name="classFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ม.1">ม.1 ทั้งหมด</option>
                                <option value="ม.2">ม.2 ทั้งหมด</option>
                                <option value="ม.3">ม.3 ทั้งหมด</option>
                                <option value="ม.4">ม.4 ทั้งหมด</option>
                                <option value="ม.5">ม.5 ทั้งหมด</option>
                                <option value="ม.6">ม.6 ทั้งหมด</option>
                                <option value="" disabled>───────────────────</option>
                                <?php if (!empty($class_list)): ?>
                                    <?php foreach ($class_list as $cls): ?>
                                        <option value="ม.<?= $cls ?>">ม.<?= $cls ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-3">
                            <label for="statusFilter" class="form-label fw-bold">สถานะนักเรียน</label>
                            <select id="statusFilter" name="statusFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="1/ปกติ" selected>1/ปกติ</option>
                                <option value="2/ย้ายสถานศึกษา">2/ย้ายสถานศึกษา</option>
                                <option value="3/ขาดประจำ">3/ขาดประจำ</option>
                                <option value="4/พักการเรียน">4/พักการเรียน</option>
                                <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                            </select>
                        </div>

                        <!-- Behavior Filter -->
                        <div class="mb-3">
                            <label for="behaviorFilter" class="form-label fw-bold">สถานะพฤติกรรม</label>
                            <select id="behaviorFilter" name="behaviorFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ปกติ" selected>ปกติ</option>
                                <option value="ขาดเรียนนาน">ขาดเรียนนาน</option>
                                <option value="พฤติกรรมเสี่ยง">พฤติกรรมเสี่ยง</option>
                                <option value="จำหน่าย">จำหน่าย</option>
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="mb-3">
                            <label for="genderFilter" class="form-label fw-bold">เพศ</label>
                            <select id="genderFilter" name="genderFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>


                    </form>
                </div>
            </div>

            <!-- Export Column Selection Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-select-multiple me-2"></i>เลือกคอลัมน์สำหรับส่งออก
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-success btn-xs" id="selectAllCols">เลือกทั้งหมด</button>
                        <button type="button" class="btn btn-outline-secondary btn-xs" id="clearAllCols">ล้างทั้งหมด</button>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <form id="exportColumnsForm" action="<?= base_url('Admin/Acade/Registration/Students/DataExport') ?>" method="get">
                        <!-- Hidden inputs for filters to pass with export -->
                        <input type="hidden" name="classFilter" id="exportClassFilter">
                        <input type="hidden" name="statusFilter" id="exportStatusFilter">
                        <input type="hidden" name="behaviorFilter" id="exportBehaviorFilter">
                        <input type="hidden" name="genderFilter" id="exportGenderFilter">
                        <input type="hidden" name="provinceFilter" id="exportProvinceFilter">
                        <input type="hidden" name="districtFilter" id="exportDistrictFilter">
                        <input type="hidden" name="tambonFilter" id="exportTambonFilter">
                        <input type="hidden" name="format" id="exportFormat" value="excel">

                        <!-- Column Groups -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-id-card me-1"></i>ข้อมูลหลักของนักเรียน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentCode" id="col_StudentCode" checked>
                                <label class="form-check-label" for="col_StudentCode">เลขประจำตัวนักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentIDNumber" id="col_StudentIDNumber" checked>
                                <label class="form-check-label" for="col_StudentIDNumber">เลขประจำตัวประชาชน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentPrefix" id="col_StudentPrefix" checked>
                                <label class="form-check-label" for="col_StudentPrefix">คำนำหน้าชื่อ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentFirstName" id="col_StudentFirstName" checked>
                                <label class="form-check-label" for="col_StudentFirstName">ชื่อจริง</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentLastName" id="col_StudentLastName" checked>
                                <label class="form-check-label" for="col_StudentLastName">นามสกุล</label>
                            </div>

                        </div>

                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-book-bookmark me-1"></i>ข้อมูลระดับชั้นเรียน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentClass" id="col_StudentClass" checked>
                                <label class="form-check-label" for="col_StudentClass">ระดับชั้น</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentNumber" id="col_StudentNumber" checked>
                                <label class="form-check-label" for="col_StudentNumber">เลขที่</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentStudyLine" id="col_StudentStudyLine" checked>
                                <label class="form-check-label" for="col_StudentStudyLine">สายการเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="YearIn" id="col_YearIn">
                                <label class="form-check-label" for="col_YearIn">ปีการศึกษาที่เข้าเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="YearFinish" id="col_YearFinish">
                                <label class="form-check-label" for="col_YearFinish">ปีการศึกษาที่จำหน่าย/จบ</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-user-check me-1"></i>ข้อมูลส่วนตัวและสถานะ
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentDateBirth" id="col_StudentDateBirth" checked>
                                <label class="form-check-label" for="col_StudentDateBirth">วันเกิด (พ.ศ.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentDateEntrance" id="col_StudentDateEntrance">
                                <label class="form-check-label" for="col_StudentDateEntrance">วันที่เข้าเรียน (พ.ศ.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentNationality" id="col_StudentNationality">
                                <label class="form-check-label" for="col_StudentNationality">สัญชาติ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentRace" id="col_StudentRace">
                                <label class="form-check-label" for="col_StudentRace">เชื้อชาติ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentRegion" id="col_StudentRegion">
                                <label class="form-check-label" for="col_StudentRegion">ศาสนา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentStatus" id="col_StudentStatus" checked>
                                <label class="form-check-label" for="col_StudentStatus">สถานะนักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentBehavior" id="col_StudentBehavior" checked>
                                <label class="form-check-label" for="col_StudentBehavior">สถานะพฤติกรรม</label>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-home me-1"></i>ข้อมูลที่อยู่ตามทะเบียนบ้าน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hNumber" id="col_stu_hNumber">
                                <label class="form-check-label" for="col_stu_hNumber">บ้านเลขที่</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hTambon" id="col_stu_hTambon">
                                <label class="form-check-label" for="col_stu_hTambon">ตำบล (แขวง)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hDistrict" id="col_stu_hDistrict">
                                <label class="form-check-label" for="col_stu_hDistrict">อำเภอ (เขต)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hProvince" id="col_stu_hProvince">
                                <label class="form-check-label" for="col_stu_hProvince">จังหวัด</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hPostCode" id="col_stu_hPostCode">
                                <label class="form-check-label" for="col_stu_hPostCode">รหัสไปรษณีย์</label>
                            </div>
                        </div>

                        <!-- Additional Personal Info -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-user me-1"></i>ข้อมูลประวัติส่วนตัวเพิ่มเติม
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_nickName" id="col_stu_nickName">
                                <label class="form-check-label" for="col_stu_nickName">ชื่อเล่น</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_phone" id="col_stu_phone">
                                <label class="form-check-label" for="col_stu_phone">เบอร์โทรศัพท์นักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_email" id="col_stu_email">
                                <label class="form-check-label" for="col_stu_email">อีเมล</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_bloodType" id="col_stu_bloodType">
                                <label class="form-check-label" for="col_stu_bloodType">กรุ๊ปเลือด</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_birthDay" id="col_stu_birthDay">
                                <label class="form-check-label" for="col_stu_birthDay">วันเกิด (จาก skjacth_personnel)</label>
                            </div>
                        </div>

                        <!-- Parent Info -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-group me-1"></i>ข้อมูลบิดา / มารดา / ผู้ปกครอง
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="FatherName" id="col_FatherName">
                                <label class="form-check-label" for="col_FatherName">ชื่อ - นามสกุลบิดา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="MotherName" id="col_MotherName">
                                <label class="form-check-label" for="col_MotherName">ชื่อ - นามสกุลมารดา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="GuardianName" id="col_GuardianName">
                                <label class="form-check-label" for="col_GuardianName">ชื่อ - นามสกุลผู้ปกครอง</label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-success w-100 d-flex align-items-center justify-content-center py-2" id="btnExportExcel" style="background-color: #15a362; border-color: #15a362;">
                                    <i class="bx bxs-file-json me-1 fs-5"></i> Excel (.xlsx)
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-2" id="btnExportCSV" style="color: #15a362; border-color: #15a362;">
                                    <i class="bx bx-file me-1 fs-5"></i> CSV (.csv)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Live Preview Data Table -->
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-list-ol me-2"></i>รายการพรีวิวข้อมูลนักเรียน
                    </h5>
                    <span class="badge bg-label-success rounded-pill fw-bold" id="previewCountBadge" style="color: #15a362; background-color: #e8f5ed;">
                        ค้นพบ: - คน
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border-top w-100 text-nowrap" id="tbStudent">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">ดูข้อมูล</th>
                                    <th>เลขประจำตัว</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th class="text-center">ชั้น</th>
                                    <th class="text-center">เลขที่</th>
                                    <th>สายการเรียน</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">พฤติกรรม</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 & Modal Backdrop Override Style (Required by UX/UI guidelines) -->
<style>
    .swal2-container {
        z-index: 9999 !important;
    }
    /* Disable modal backdrop for this page to prevent any clicking interference */
    .modal-backdrop {
        display: none !important;
        visibility: hidden !important;
    }
</style>

<!-- DataTables & Interactions JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let table = null;

    // ป้องกัน Bootstrap Modal แย่งโฟกัสจาก SweetAlert2 Input (ทำให้พิมพ์ไม่ได้)
    document.addEventListener('focusin', function(e) {
        if (e.target.closest('.swal2-container')) {
            e.stopImmediatePropagation();
        }
    }, true);

    // Move recruitment details modal to body immediately on load to prevent z-index backdrop issues
    $('#studentRecruitModal').appendTo('body');

    // Make absolutely sure that the backdrop is destroyed when modal is hidden
    $(document).on('hidden.bs.modal', '#studentRecruitModal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

    // Load DataTables
    function initializeDataTable() {
        table = $('#tbStudent').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            ajax: {
                url: '<?= base_url("Admin/Acade/Registration/Students/DataShow") ?>',
                type: 'POST',
                data: function(d) {
                    d.classFilter = $('#classFilter').val();
                    d.statusFilter = $('#statusFilter').val();
                    d.behaviorFilter = $('#behaviorFilter').val();
                    d.genderFilter = $('#genderFilter').val();
                    d.provinceFilter = $('#provinceFilter').val();
                    d.districtFilter = $('#districtFilter').val();
                    d.tambonFilter = $('#tambonFilter').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', error, thrown);
                }
            },
            columns: [
                {
                    data: 'StudentID',
                    className: 'text-center',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <button type="button" class="btn btn-icon btn-sm btn-success btn-view-recruit" data-id="${data}" style="background-color: #15a362; border-color: #15a362;" title="ดูข้อมูล">
                                <i class="bx bx-show fs-4"></i>
                            </button>
                        `;
                    }
                },
                { data: 'StudentCode', className: 'fw-bold text-nowrap' },
                { 
                    data: 'Fullname', 
                    className: 'text-nowrap',
                    render: function(data, type, row) {
                        let sub = '';
                        if (row.stu_province) {
                            sub = `<br><small class="text-muted" style="font-size: 11px;"><i class="bx bx-map text-success me-1"></i>จ.${row.stu_province}`;
                            if (row.stu_district) {
                                sub += ` › อ.${row.stu_district}`;
                            }
                            sub += `</small>`;
                        }
                        return `<div><span class="fw-semibold">${data}</span>${sub}</div>`;
                    }
                },
                { data: 'StudentClass', className: 'text-center fw-bold text-success' },
                { data: 'StudentNumber', className: 'text-center' },
                { data: 'StudentStudyLine' },
                { 
                    data: 'StudentStatus',
                    className: 'text-center',
                    render: function(data) {
                        let color = 'secondary';
                        if (data === '1/ปกติ') color = 'success';
                        else if (data === '2/ย้ายสถานศึกษา') color = 'warning';
                        else if (data === '5/จบการศึกษา') color = 'primary';
                        return `<span class="badge bg-label-${color}">${data}</span>`;
                    }
                },
                { 
                    data: 'StudentBehavior',
                    className: 'text-center',
                    render: function(data) {
                        let color = 'secondary';
                        if (data === 'ปกติ') color = 'success';
                        else if (data === 'ขาดเรียนนาน') color = 'danger';
                        else if (data === 'จำหน่าย') color = 'dark';
                        return `<span class="badge bg-${color}">${data}</span>`;
                    }
                }
            ],
            language: {
                processing: '<div class="spinner-border text-success" role="status"><span class="visually-hidden">กำลังโหลด...</span></div>',
                lengthMenu: 'แสดง _MENU_ รายการ',
                zeroRecords: 'ไม่พบข้อมูลนักเรียน',
                info: 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ คน',
                infoEmpty: 'แสดง 0 ถึง 0 จากทั้งหมด 0 คน',
                infoFiltered: '(กรองจากทั้งหมด _MAX_ คน)',
                search: 'ค้นหาด่วน:',
                paginate: {
                    first: 'หน้าแรก',
                    last: 'หน้าสุดท้าย',
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            },
            order: [[3, 'asc'], [4, 'asc']], // Order by class first, then number
            drawCallback: function(settings) {
                // Update dynamic total counts badge
                const api = this.api();
                const totalFiltered = api.page.info().recordsFiltered;
                $('#previewCountBadge').text(`ค้นพบ: ${totalFiltered} คน`);
            }
        });
    }

    function numberWithCommas(x) {
        if (x === undefined || x === null) return '0';
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function escapeHtml(string) {
        if (!string) return '';
        return String(string).replace(/[&<>"']/g, function (s) {
            return {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#039;"
            }[s];
        });
    }

    let genderChartInstance = null;

    function initGenderChart(male, female) {
        const chartEl = document.querySelector('#genderDoughnutChart');
        if (!chartEl) return;

        const options = {
            chart: {
                height: 230,
                type: 'donut',
                fontFamily: 'K2D, sans-serif'
            },
            labels: ['ชาย', 'หญิง'],
            series: [parseInt(male) || 0, parseInt(female) || 0],
            colors: ['#03a9f4', '#ff3e1d'], // Blue for Male, Red/Pink for Female
            stroke: {
                width: 5,
                colors: ['#fff']
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15,
                    left: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                color: '#435971',
                                offsetY: -15,
                                formatter: function (val) {
                                    return numberWithCommas(val) + ' คน';
                                }
                            },
                            name: {
                                offsetY: 20
                            },
                            total: {
                                show: true,
                                label: 'รวม',
                                color: '#8e97a9',
                                fontSize: '0.85rem',
                                formatter: function (w) {
                                    return numberWithCommas(w.globals.seriesTotals.reduce((a, b) => a + b, 0)) + ' คน';
                                }
                            }
                        }
                    }
                }
            }
        };

        if (genderChartInstance !== null) {
            genderChartInstance.destroy();
        }
        
        genderChartInstance = new ApexCharts(chartEl, options);
        genderChartInstance.render();
    }

    // Initialize chart with starting PHP values
    initGenderChart(<?= $stats['male'] ?>, <?= $stats['female'] ?>);

    initializeDataTable();

    // Catch custom server-side errors & update live dynamic stats
    table.on('xhr.dt', function(e, settings, json, xhr) {
        if (json && json.error) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการโหลดข้อมูล',
                html: `<div class="text-start fs-7 text-danger p-2 bg-light border rounded" style="font-family: monospace; white-space: pre-wrap; font-size: 13px;">` + json.error + `</div>`,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#15a362'
            });
        }

        if (json && json.stats) {
            // Update Dashboard cards in real-time
            $('#statTotalActive').html(numberWithCommas(json.stats.total_active) + ' <span class="fs-6 fw-normal text-muted">คน</span>');
            $('#statMale').text(numberWithCommas(json.stats.male));
            $('#statFemale').text(numberWithCommas(json.stats.female));
            $('#statLowerSec').text(numberWithCommas(json.stats.lower_sec));
            $('#statUpperSec').text(numberWithCommas(json.stats.upper_sec));
            $('#statBehaviorRisk').text(numberWithCommas(json.stats.behavior_risk));
            $('#statBehaviorDismissed').text(numberWithCommas(json.stats.behavior_dismissed));
            
            // Update Doughnut Chart Card side numbers
            $('#chartMaleCount').text(numberWithCommas(json.stats.male) + ' คน');
            $('#chartFemaleCount').text(numberWithCommas(json.stats.female) + ' คน');
            
            // Update ApexCharts series dynamically with nice transition animations
            if (genderChartInstance) {
                genderChartInstance.updateSeries([parseInt(json.stats.male) || 0, parseInt(json.stats.female) || 0]);
            }

            // Update Dynamic Province list based on filtered results
            if (json.stats.top_provinces) {
                let provinceHtml = '';
                const colors = ['#15a362', '#03a9f4', '#696cff'];
                const bgColors = ['#e8f5ed', '#e3f2fd', '#ebeefc'];
                
                if (json.stats.top_provinces.length > 0) {
                    json.stats.top_provinces.forEach(function(prov, index) {
                        const color = colors[index % 3];
                        const bgColor = bgColors[index % 3];
                        provinceHtml += `
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar flex-shrink-0 p-2 rounded me-3" style="background-color: ${bgColor} !important; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold fs-6" style="color: ${color};">#${index + 1}</span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0 fw-bold">จ.${prov.province}</h6>
                                        <small class="text-muted">
                                            ${numberWithCommas(prov.count)} คน 
                                            <span class="text-info fw-semibold" style="font-size: 0.78rem;">(ชาย ${numberWithCommas(prov.male || 0)}</span> / 
                                            <span class="text-danger fw-semibold" style="font-size: 0.78rem;">หญิง ${numberWithCommas(prov.female || 0)})</span>
                                        </small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <span class="badge rounded-pill fw-bold" style="background-color: ${bgColor}; color: ${color};">${prov.percent}%</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    provinceHtml = '<div class="text-center text-muted py-3">ไม่มีข้อมูลจังหวัด</div>';
                }
                $('#topProvincesContainer').html(provinceHtml);
            }

            // Update In-depth Province Statistics Table inside Modal dynamically
            if (json.stats.provinces_all) {
                // Update badge showing total number of provinces found under current filters
                $('#modalProvinceBadge').text(numberWithCommas(json.stats.provinces_all.length) + ' จังหวัด');

                let totalAllProvinces = 0;
                let totalAllMale = 0;
                let totalAllFemale = 0;
                
                json.stats.provinces_all.forEach(function(item) {
                    totalAllProvinces += parseInt(item.count) || 0;
                    totalAllMale += parseInt(item.male) || 0;
                    totalAllFemale += parseInt(item.female) || 0;
                });

                let tbodyHtml = '';
                if (json.stats.provinces_all.length > 0) {
                    json.stats.provinces_all.forEach(function(pv, idx) {
                        let percent = totalAllProvinces > 0 ? ((pv.count / totalAllProvinces) * 100).toFixed(1) : 0;
                        tbodyHtml += `
                            <tr>
                                <td class="text-center text-muted fw-semibold">${idx + 1}</td>
                                <td class="fw-semibold">${escapeHtml(pv.province)}</td>
                                <td class="text-center text-info fw-semibold">${numberWithCommas(pv.male)}</td>
                                <td class="text-center text-danger fw-semibold">${numberWithCommas(pv.female)}</td>
                                <td class="text-center fw-bold text-success">${numberWithCommas(pv.count)}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-label-success fw-bold" style="font-size: 0.7rem;">${percent}%</span>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbodyHtml = '<tr><td colspan="6" class="text-center text-muted py-3">ไม่มีข้อมูลจังหวัด</td></tr>';
                }
                $('#modalProvinceTable tbody').html(tbodyHtml);

                let tfootHtml = `
                    <tr class="fw-bold">
                        <td colspan="2" class="text-end text-success">รวมทั้งหมด</td>
                        <td class="text-center text-info">${numberWithCommas(totalAllMale)}</td>
                        <td class="text-center text-danger">${numberWithCommas(totalAllFemale)}</td>
                        <td class="text-center text-success">${numberWithCommas(totalAllProvinces)}</td>
                        <td class="text-center"><span class="badge rounded-pill bg-success fw-bold" style="font-size: 0.7rem;">100%</span></td>
                    </tr>
                `;
                $('#modalProvinceTable tfoot').html(tfootHtml);
            }
        }
    });

    // Redraw table on filter change
    $('#classFilter, #statusFilter, #behaviorFilter, #genderFilter, #provinceFilter, #districtFilter, #tambonFilter').on('change', function() {
        if (table) {
            table.draw();
        }
    });

    // Cascading Address Filters (Province -> District -> Tambon)
    $('#provinceFilter').on('change', function() {
        const province = $(this).val();
        
        // Dynamic info panel for selected province stats
        const selectedOpt = $(this).find('option:selected');
        const total = selectedOpt.data('total');
        const male = selectedOpt.data('male');
        const female = selectedOpt.data('female');

        if (province && total !== undefined) {
            $('#provinceInfoText').html(`
                จังหวัด <strong>${province}</strong> มีนักเรียน <strong>${numberWithCommas(total)}</strong> คน 
                (<span class="text-info fw-semibold">ชาย ${numberWithCommas(male)}</span> / <span class="text-danger fw-semibold">หญิง ${numberWithCommas(female)}</span>)
            `);
            $('#provinceInfoBox').find('small:first').text('สถิติจังหวัดที่เลือก');
            $('#provinceInfoBox').slideDown(200);
        } else {
            // กลับไปแสดงสถิติภาพรวมทั้งหมด
            $('#provinceInfoBox').find('small:first').text('สถิติภาพรวมทั้งหมด (<?= count($provinces ?? []) ?> จังหวัด)');
            $('#provinceInfoText').html('รวม <?= number_format($totalAllProvinces) ?> คน — <span class="text-info fw-semibold">ชาย <?= number_format($totalAllMale) ?></span> / <span class="text-danger fw-semibold">หญิง <?= number_format($totalAllFemale) ?></span>');
            $('#provinceInfoBox').slideDown(200);
        }
        
        // Reset district filter
        $('#districtFilter').html('<option value="">--- ทั้งหมด ---</option>').prop('disabled', true);
        // Reset tambon filter
        $('#tambonFilter').html('<option value="">--- ทั้งหมด ---</option>').prop('disabled', true);

        if (!province) {
            return;
        }

        // Fetch districts via AJAX POST
        $.ajax({
            url: '<?= base_url("Admin/Acade/Registration/Students/GetDistricts") ?>',
            type: 'POST',
            data: { 
                province: province,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    let html = '<option value="">--- ทั้งหมด ---</option>';
                    data.forEach(function(item) {
                        if (item.stu_hDistrict) {
                            html += `<option value="${item.stu_hDistrict}">${item.stu_hDistrict}</option>`;
                        }
                    });
                    $('#districtFilter').html(html).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch districts:', error);
            }
        });
    });

    $('#districtFilter').on('change', function() {
        const province = $('#provinceFilter').val();
        const district = $(this).val();

        // Reset tambon filter
        $('#tambonFilter').html('<option value="">--- ทั้งหมด ---</option>').prop('disabled', true);

        if (!province || !district) {
            return;
        }

        // Fetch tambons via AJAX POST
        $.ajax({
            url: '<?= base_url("Admin/Acade/Registration/Students/GetTambons") ?>',
            type: 'POST',
            data: { 
                province: province,
                district: district,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    let html = '<option value="">--- ทั้งหมด ---</option>';
                    data.forEach(function(item) {
                        if (item.stu_hTambon) {
                            html += `<option value="${item.stu_hTambon}">${item.stu_hTambon}</option>`;
                        }
                    });
                    $('#tambonFilter').html(html).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch tambons:', error);
            }
        });
    });

    // Two-way sync between Sidebar filters and Modal filters
    $('#modalClassFilter').on('change', function() {
        $('#classFilter').val($(this).val()).trigger('change');
    });
    $('#modalStatusFilter').on('change', function() {
        $('#statusFilter').val($(this).val()).trigger('change');
    });
    $('#modalBehaviorFilter').on('change', function() {
        $('#behaviorFilter').val($(this).val()).trigger('change');
    });
    $('#modalGenderFilter').on('change', function() {
        $('#genderFilter').val($(this).val()).trigger('change');
    });

    $('#classFilter').on('change', function() {
        $('#modalClassFilter').val($(this).val());
    });
    $('#statusFilter').on('change', function() {
        $('#modalStatusFilter').val($(this).val());
    });
    $('#behaviorFilter').on('change', function() {
        $('#modalBehaviorFilter').val($(this).val());
    });
    $('#genderFilter').on('change', function() {
        $('#modalGenderFilter').val($(this).val());
    });

    // Clear all filters in modal
    $('#btnClearModalFilters').on('click', function() {
        $('#modalClassFilter').val('');
        $('#modalStatusFilter').val('1/ปกติ');
        $('#modalBehaviorFilter').val('ปกติ');
        $('#modalGenderFilter').val('');
        $('#provinceFilter').val('').trigger('change');
    });

    // Checklist toggles
    $('#selectAllCols').on('click', function() {
        $('.col-chk').prop('checked', true);
    });

    // Clear all cols checklist toggle (preserve at least one required to avoid empty query error)
    $('#clearAllCols').on('click', function() {
        $('.col-chk').prop('checked', false);
        $('#col_StudentCode').prop('checked', true); // Safe fallback
    });

    // Handle export clicks
    function triggerExport(format) {
        // Collect checked columns
        const checkedCols = [];
        $('.col-chk:checked').each(function() {
            checkedCols.push($(this).val());
        });

        if (checkedCols.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'โปรดเลือกคอลัมน์',
                text: 'กรุณาเลือกคอลัมน์ที่จะส่งออกอย่างน้อย 1 คอลัมน์ครับ!',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        // Set hidden filter inputs
        $('#exportClassFilter').val($('#classFilter').val());
        $('#exportStatusFilter').val($('#statusFilter').val());
        $('#exportBehaviorFilter').val($('#behaviorFilter').val());
        $('#exportGenderFilter').val($('#genderFilter').val());
        $('#exportProvinceFilter').val($('#provinceFilter').val());
        $('#exportDistrictFilter').val($('#districtFilter').val());
        $('#exportTambonFilter').val($('#tambonFilter').val());
        $('#exportFormat').val(format);

        // Submit form
        $('#exportColumnsForm').submit();

        // Premium alert toast
        Swal.fire({
            icon: 'success',
            title: 'เริ่มดาวน์โหลดไฟล์',
            text: `ระบบกำลังดึงข้อมูลและเตรียมไฟล์ ${format.toUpperCase()} ให้กับคุณครับ`,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    $('#btnExportExcel').on('click', function() {
        triggerExport('excel');
    });

    $('#btnExportCSV').on('click', function() {
        triggerExport('csv');
    });

    // AJAX click handler to view student recruitment details modal
    $(document).on('click', '.btn-view-recruit', function() {
        const studentId = $(this).data('id');
        
        // Show SweetAlert2 loading spinner first
        Swal.fire({
            title: 'กำลังดึงข้อมูลใบสมัคร...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Fetch detailed content
        $.ajax({
            url: '<?= base_url("Admin/Academic/ConAdminStudents/get_student_admission_details") ?>/' + studentId,
            type: 'GET',
            success: function(responseHtml) {
                Swal.close();
                setTimeout(function() {
                    $('#studentRecruitContent').html(responseHtml);
                    $('#studentRecruitModal').appendTo('body').modal('show');
                }, 150);
            },
            error: function(xhr, status, error) {
                Swal.close();
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถโหลดข้อมูลผู้สมัครได้: ' + error,
                        confirmButtonColor: '#15a362'
                    });
                }, 150);
            }
        });
    });

    // Trigger window resize event when modal is shown to let ApexCharts correctly adapt its layout/width
    $('#dashboardModal').on('shown.bs.modal', function () {
        window.dispatchEvent(new Event('resize'));
    });

    // === ADDRESS DATA CLEANSING INTERACTION ===
    
    // โหลดรายการที่อยู่สำหรับ Cleansing
    function loadAddressCleansingList() {
        const type = $('input[name="cleansingType"]:checked').val();
        const search = $('#cleansingSearch').val();
        
        $('#cleansingListContainer').html(`
            <tr>
                <td colspan="3" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    <span class="ms-2">กำลังดึงข้อมูลที่อยู่...</span>
                </td>
            </tr>
        `);

        $.ajax({
            url: '<?= base_url("Admin/Acade/Registration/Students/AddressList") ?>',
            type: 'POST',
            data: {
                type: type,
                search: search,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(data) {
                let html = '';
                if (data && data.length > 0) {
                    data.forEach(function(item) {
                        html += `
                            <tr>
                                <td>
                                    <span class="fw-semibold text-dark">${item.name}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-success rounded-pill fw-bold" style="color: #15a362; background-color: #e8f5ed;">${numberWithCommas(item.student_count)} คน</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-success btn-clean-address d-flex align-items-center gap-1 mx-auto" 
                                            data-type="${type}" 
                                            data-name="${item.name}" 
                                            data-count="${item.student_count}"
                                            style="color: #15a362; border-color: #15a362;">
                                        <i class="bx bx-edit"></i> แก้ไขคำผิด
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="bx bx-info-circle fs-4 d-block mb-1"></i>
                                ไม่พบข้อมูลที่ต้องการจัดระเบียบ
                            </td>
                        </tr>
                    `;
                }
                $('#cleansingListContainer').html(html);
            },
            error: function(xhr, status, error) {
                $('#cleansingListContainer').html(`
                    <tr>
                        <td colspan="3" class="text-center text-danger py-4">
                            <i class="bx bx-error fs-4 d-block mb-1"></i>
                            ดึงข้อมูลไม่สำเร็จ: ${error}
                        </td>
                    </tr>
                `);
            }
        });
    }

    // ทำงานเมื่อสลับแท็บประเภท
    $('input[name="cleansingType"]').on('change', function() {
        $('#cleansingSearch').val('');
        loadAddressCleansingList();
    });

    // กำหนดเวลาหน่วงค้นหา (Debounce) เพื่อไม่ให้ยิง AJAX บ่อยเกินไปตอนพิมพ์ค้นหา
    let searchTimeout = null;
    $('#cleansingSearch').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadAddressCleansingList();
        }, 300);
    });

    $('#btnRefreshCleansing').on('click', function() {
        loadAddressCleansingList();
    });

    // เมื่อเปิด Modal Cleansing ให้โหลดข้อมูลทันที
    $('#addressCleansingModal').on('shown.bs.modal', function() {
        loadAddressCleansingList();
    });

    // จัดการแก้ไขสะกดคำผิดข้ามฐานข้อมูลแบบ Bulk
    $(document).on('click', '.btn-clean-address', function() {
        const type = $(this).data('type');
        const oldName = $(this).data('name');
        const count = $(this).data('count');
        
        let label = 'จังหวัด';
        if (type === 'district') label = 'อำเภอ';
        else if (type === 'tambon') label = 'ตำบล';

        Swal.fire({
            title: `แก้ไขสะกดคำผิดของ${label}`,
            html: `
                <div class="text-start mb-3">
                    <p class="mb-2">คำที่ต้องการแก้ไข: <strong class="text-danger">${oldName}</strong></p>
                    <p class="mb-2">มีนักเรียนที่จะถูกปรับปรุงข้อมูล: <strong class="text-success">${numberWithCommas(count)} คน</strong></p>
                    <p class="text-muted small" style="font-size: 12px;"><i class="bx bx-info-circle text-warning me-1"></i>ข้อมูลจะถูกปรับปรุงให้ถูกต้องตรงกันทุกจุด ทั้งข้อมูลนักเรียนปัจจุบัน ทะเบียนประวัติ และระบบรับสมัครเรียน</p>
                </div>
            `,
            input: 'text',
            inputValue: oldName,
            inputPlaceholder: `พิมพ์ชื่อ${label}ที่สะกดถูกต้องที่นี่...`,
            showCancelButton: true,
            confirmButtonText: 'บันทึกข้อมูลและปรับปรุงทั้งหมด',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return `กรุณากรอกชื่อ${label}ที่ถูกต้องก่อนบันทึกครับ!`;
                }
                if (value.trim() === oldName) {
                    return 'คำใหม่ต้องต่างจากชื่อเดิมเพื่อดำเนินการแก้ไขครับ!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const newName = result.value.trim();

                // แสดง Loading
                Swal.fire({
                    title: 'กำลังล้างข้อมูลและอัปเดตข้ามฐานข้อมูล...',
                    html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // ส่งคำขอแก้ไขแบบ AJAX POST
                $.ajax({
                    url: '<?= base_url("Admin/Acade/Registration/Students/AddressClean") ?>',
                    type: 'POST',
                    data: {
                        type: type,
                        old_value: oldName,
                        new_value: newName,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        if (response && response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'ปรับปรุงข้อมูลสำเร็จ!',
                                text: `แก้ไขตัวสะกดและเชื่อมโยงข้อมูลของนักเรียนทั้งหมด ${numberWithCommas(response.affected_rows)} แถวเรียบร้อยแล้วครับ!`,
                                confirmButtonColor: '#15a362'
                            }).then(() => {
                                // โหลดรายการใหม่ใน Modal ปัจจุบัน
                                loadAddressCleansingList();
                                
                                // สั่งรีเฟรชตารางนักเรียนหน้าหลักและวิเคราะห์สถิติด้านหลัง
                                if (table) {
                                    table.ajax.reload(null, false);
                                }
                                
                                // เสนอทางเลือกในการรีโหลดหน้า เพื่อให้ PHP ดึงรายการจังหวัดที่ถูกต้องใหม่ในฝั่งฟิลเตอร์หลัก
                                Swal.fire({
                                    title: 'ต้องการรีเฟรชหน้าเว็บเพื่ออัปเดตตัวกรองหรือไม่?',
                                    text: 'เนื่องจากมีการแก้ไขชื่อภูมิศาสตร์ โครงสร้างตัวกรองหลักจำเป็นต้องอัปเดตใหม่ครับ',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'รีเฟรชเลย',
                                    cancelButtonText: 'ข้ามก่อน',
                                    confirmButtonColor: '#15a362',
                                    cancelButtonColor: '#8592a3'
                                }).then((refreshResult) => {
                                    if (refreshResult.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่สามารถปรับปรุงได้',
                                text: response.message || 'เกิดข้อผิดพลาดในการอัปเดต',
                                confirmButtonColor: '#15a362'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        let errorMsg = error;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const parsed = JSON.parse(xhr.responseText);
                                if (parsed && parsed.message) {
                                    errorMsg = parsed.message;
                                }
                            } catch(e) {}
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                            text: errorMsg,
                            confirmButtonColor: '#15a362'
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- Address Cleansing Modal -->
<div class="modal fade" id="addressCleansingModal" aria-labelledby="addressCleansingModalLabel" aria-hidden="true" style="z-index: 1055;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header py-3" style="background-color: #566a7f; border-bottom: none;">
                <h5 class="modal-title text-white fw-bold" id="addressCleansingModalLabel">
                    <i class="bx bx-cog me-2 fs-4"></i>เครื่องมือล้างและปรับปรุงคำสะกดผิดที่อยู่ของนักเรียน (Address Cleansing Tool)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light-subtle">
                <!-- Selection Options -->
                <div class="row g-3 mb-4 align-items-end">
                    <div class="col-12 col-md-5">
                        <label class="form-label fw-bold text-muted small mb-1">เลือกประเภทข้อมูลที่ต้องการล้าง</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="cleansingType" id="cleanTypeProvince" value="province" checked>
                            <label class="btn btn-outline-secondary" for="cleanTypeProvince">จังหวัด</label>

                            <input type="radio" class="btn-check" name="cleansingType" id="cleanTypeDistrict" value="district">
                            <label class="btn btn-outline-secondary" for="cleanTypeDistrict">อำเภอ</label>

                            <input type="radio" class="btn-check" name="cleansingType" id="cleanTypeTambon" value="tambon">
                            <label class="btn btn-outline-secondary" for="cleanTypeTambon">ตำบล</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <label for="cleansingSearch" class="form-label fw-bold text-muted small mb-1">ค้นหาคำที่สะกดผิด</label>
                        <div class="input-group">
                            <input type="text" id="cleansingSearch" class="form-control" placeholder="พิมพ์เพื่อค้นหาข้อมูลที่อยู่...">
                            <button class="btn btn-outline-secondary" type="button" id="btnRefreshCleansing">
                                <i class="bx bx-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Address List Table -->
                <div class="table-responsive border rounded" style="max-height: 400px; background: #fff;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">ข้อมูลที่อยู่ปัจจุบัน</th>
                                <th class="fw-bold text-center" style="width: 150px;">จำนวนคน</th>
                                <th class="fw-bold text-center" style="width: 150px;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="cleansingListContainer">
                            <!-- Dynamic Content -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2 border-top bg-light">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>

<!-- In-depth Analytics & Summary Modal -->
<div class="modal fade" id="dashboardModal" aria-labelledby="dashboardModalLabel" aria-hidden="true" style="z-index: 1055;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable animate__animated animate__fadeInDown">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header py-3" style="background-color: #15a362; border-bottom: none;">
                <h5 class="modal-title text-white fw-bold" id="dashboardModalLabel">
                    <i class="bx bx-bar-chart-alt-2 me-2 fs-4"></i>แผงสรุปและวิเคราะห์ข้อมูลสถิตินักเรียนเชิงลึก (Student Analytics Dashboard)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light-subtle">
                <!-- Filters row inside Modal -->
                <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeIn" style="background-color: #fcfefe; border-left: 5px solid #15a362 !important;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold m-0 text-success d-flex align-items-center">
                                <i class="bx bx-filter-alt me-2 fs-5"></i>ตัวกรองเพื่อวิเคราะห์ข้อมูลเชิงลึก (Analytics Filters)
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" id="btnClearModalFilters" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 6px;">
                                <i class="bx bx-refresh"></i> ล้างตัวกรองทั้งหมด
                            </button>
                        </div>
                        
                        <!-- Row 1: Academic Filters -->
                        <div class="row g-3 mb-3">
                            <!-- Class Filter -->
                            <div class="col-12 col-md-3">
                                <label for="modalClassFilter" class="form-label fw-bold text-muted small mb-1">ระดับชั้น / ห้องเรียน</label>
                                <select id="modalClassFilter" class="form-select border-light-subtle bg-white">
                                    <option value="">--- ทั้งหมด ---</option>
                                    <option value="ม.1">ม.1 ทั้งหมด</option>
                                    <option value="ม.2">ม.2 ทั้งหมด</option>
                                    <option value="ม.3">ม.3 ทั้งหมด</option>
                                    <option value="ม.4">ม.4 ทั้งหมด</option>
                                    <option value="ม.5">ม.5 ทั้งหมด</option>
                                    <option value="ม.6">ม.6 ทั้งหมด</option>
                                    <option value="" disabled>───────────────────</option>
                                    <?php if (!empty($class_list)): ?>
                                        <?php foreach ($class_list as $cls): ?>
                                            <option value="ม.<?= $cls ?>">ม.<?= $cls ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Status Filter -->
                            <div class="col-12 col-md-3">
                                <label for="modalStatusFilter" class="form-label fw-bold text-muted small mb-1">สถานะนักเรียน</label>
                                <select id="modalStatusFilter" class="form-select border-light-subtle bg-white">
                                    <option value="">--- ทั้งหมด ---</option>
                                    <option value="1/ปกติ" selected>1/ปกติ</option>
                                    <option value="2/ย้ายสถานศึกษา">2/ย้ายสถานศึกษา</option>
                                    <option value="3/ขาดประจำ">3/ขาดประจำ</option>
                                    <option value="4/พักการเรียน">4/พักการเรียน</option>
                                    <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                                </select>
                            </div>
                            <!-- Behavior Filter -->
                            <div class="col-12 col-md-3">
                                <label for="modalBehaviorFilter" class="form-label fw-bold text-muted small mb-1">สถานะพฤติกรรม</label>
                                <select id="modalBehaviorFilter" class="form-select border-light-subtle bg-white">
                                    <option value="">--- ทั้งหมด ---</option>
                                    <option value="ปกติ" selected>ปกติ</option>
                                    <option value="ขาดเรียนนาน">ขาดเรียนนาน</option>
                                    <option value="พฤติกรรมเสี่ยง">พฤติกรรมเสี่ยง</option>
                                    <option value="จำหน่าย">จำหน่าย</option>
                                </select>
                            </div>
                            <!-- Gender Filter -->
                            <div class="col-12 col-md-3">
                                <label for="modalGenderFilter" class="form-label fw-bold text-muted small mb-1">เพศ (คำนำหน้า)</label>
                                <select id="modalGenderFilter" class="form-select border-light-subtle bg-white">
                                    <option value="">--- ทั้งหมด ---</option>
                                    <option value="ชาย">ชาย</option>
                                    <option value="หญิง">หญิง</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Address Statistics Filters -->
                        <div class="row g-3 border-top pt-3">
                            <!-- Province Filter -->
                            <div class="col-12 col-md-4">
                                <label for="provinceFilter" class="form-label fw-bold text-muted small mb-1">จังหวัด (ภูมิลำเนา)</label>
                                <select id="provinceFilter" name="provinceFilter" class="form-select border-light-subtle bg-white">

                                    <option value="">--- ทั้งหมด (<?= number_format($totalAllProvinces) ?> คน | <?= count($provinces ?? []) ?> จังหวัด) ---</option>
                                    <?php if (!empty($provinces)): ?>
                                        <?php foreach ($provinces as $pv): ?>
                                            <option value="<?= esc($pv->stu_hProvince) ?>"
                                                    data-total="<?= $pv->total_count ?>"
                                                    data-male="<?= $pv->male_count ?>"
                                                    data-female="<?= $pv->female_count ?>">
                                                <?= esc($pv->stu_hProvince) ?> (<?= number_format($pv->total_count) ?> คน)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                
                                <!-- Beautiful dynamic info panel for selected province stats -->
                                <div id="provinceInfoBox" class="mt-2 p-2 border border-success-subtle rounded animate__animated animate__fadeIn" style="display: block; background-color: #f4fbf7;">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 p-1 rounded-circle me-2" style="background-color: #e8f5ed; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bx bx-info-circle text-success fs-6"></i>
                                        </div>
                                        <div class="w-100">
                                            <small class="d-block text-success fw-bold" style="font-size: 0.75rem; line-height: 1.2;">สถิติภาพรวมทั้งหมด (<?= count($provinces ?? []) ?> จังหวัด)</small>
                                            <small id="provinceInfoText" class="text-dark" style="font-size: 0.72rem;">รวม <?= number_format($totalAllProvinces) ?> คน — <span class="text-info fw-semibold">ชาย <?= number_format($totalAllMale) ?></span> / <span class="text-danger fw-semibold">หญิง <?= number_format($totalAllFemale) ?></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- District Filter -->
                            <div class="col-12 col-md-4">
                                <label for="districtFilter" class="form-label fw-bold text-muted small mb-1">อำเภอ / เขต</label>
                                <select id="districtFilter" name="districtFilter" class="form-select border-light-subtle bg-white" disabled>
                                    <option value="">--- ทั้งหมด ---</option>
                                </select>
                            </div>
                            <!-- Tambon Filter -->
                            <div class="col-12 col-md-4">
                                <label for="tambonFilter" class="form-label fw-bold text-muted small mb-1">ตำบล / แขวง</label>
                                <select id="tambonFilter" name="tambonFilter" class="form-select border-light-subtle bg-white" disabled>
                                    <option value="">--- ทั้งหมด ---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inside Modal, display the charts and provinces breakdown side-by-side -->
                <div class="row g-3">
                    <!-- Gender Chart Card (Compact) -->
                    <div class="col-12 col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-transparent border-bottom py-2">
                                <h6 class="card-title mb-0 text-success fw-bold">
                                    <i class="bx bx-pie-chart-alt-2 me-1"></i>สัดส่วนเพศ (ชาย / หญิง)
                                </h6>
                            </div>
                            <div class="card-body py-2 px-3">
                                <div id="genderDoughnutChart" style="min-height: 180px;"></div>
                                <div class="d-flex justify-content-around align-items-center mt-2 border-top pt-2">
                                    <div class="text-center">
                                        <span class="d-block text-muted" style="font-size: 0.72rem;"><i class="bx bxs-circle me-1" style="color: #03a9f4;"></i>ชาย</span>
                                        <h6 class="mb-0 fw-bold text-info" id="chartMaleCount"><?= number_format($stats['male']) ?> คน</h6>
                                    </div>
                                    <div class="text-center">
                                        <span class="d-block text-muted" style="font-size: 0.72rem;"><i class="bx bxs-circle me-1" style="color: #ff3e1d;"></i>หญิง</span>
                                        <h6 class="mb-0 fw-bold text-danger" id="chartFemaleCount"><?= number_format($stats['female']) ?> คน</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Province Distribution Table Card (Full Width) -->
                    <div class="col-12 col-lg-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0 text-success fw-bold">
                                    <i class="bx bx-map-pin me-2"></i>สถิตินักเรียนรายจังหวัด
                                </h5>
                                <span id="modalProvinceBadge" class="badge bg-label-success px-2 py-1 fw-bold" style="font-size: 0.72rem;"><?= $totalProvinceCount ?> จังหวัด</span>
                            </div>
                            <div class="card-body p-0" style="max-height: 340px; overflow-y: auto;">
                                <table id="modalProvinceTable" class="table table-hover table-sm mb-0" style="font-size: 0.8rem;">
                                    <thead class="table-light sticky-top" style="z-index: 1;">
                                        <tr>
                                            <th class="text-center" style="width: 35px;">#</th>
                                            <th>จังหวัด</th>
                                            <th class="text-center text-info"><i class="bx bx-male-sign"></i> ชาย</th>
                                            <th class="text-center text-danger"><i class="bx bx-female-sign"></i> หญิง</th>
                                            <th class="text-center text-success">รวม</th>
                                            <th class="text-center" style="width: 55px;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($provinces)): ?>
                                            <?php foreach ($provinces as $idx => $pv): 
                                                $pvPercent = $totalAllProvinces > 0 ? round(($pv->total_count / $totalAllProvinces) * 100, 1) : 0;
                                            ?>
                                                <tr>
                                                    <td class="text-center text-muted fw-semibold"><?= $idx + 1 ?></td>
                                                    <td class="fw-semibold"><?= esc($pv->stu_hProvince) ?></td>
                                                    <td class="text-center text-info fw-semibold"><?= number_format($pv->male_count) ?></td>
                                                    <td class="text-center text-danger fw-semibold"><?= number_format($pv->female_count) ?></td>
                                                    <td class="text-center fw-bold text-success"><?= number_format($pv->total_count) ?></td>
                                                    <td class="text-center">
                                                        <span class="badge rounded-pill bg-label-success fw-bold" style="font-size: 0.7rem;"><?= $pvPercent ?>%</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center text-muted py-3">ไม่มีข้อมูลจังหวัด</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot class="table-light sticky-bottom border-top">
                                        <tr class="fw-bold">
                                            <td colspan="2" class="text-end text-success">รวมทั้งหมด</td>
                                            <td class="text-center text-info"><?= number_format($totalAllMale) ?></td>
                                            <td class="text-center text-danger"><?= number_format($totalAllFemale) ?></td>
                                            <td class="text-center text-success"><?= number_format($totalAllProvinces) ?></td>
                                            <td class="text-center"><span class="badge rounded-pill bg-success fw-bold" style="font-size: 0.7rem;">100%</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2 border-top bg-light">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Student Admission Details Modal -->
<div class="modal fade" id="studentRecruitModal" aria-labelledby="studentRecruitModalLabel" aria-hidden="true" data-bs-backdrop="false" style="z-index: 1060;">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header py-3" style="background-color: #15a362; border-bottom: none;">
                <h5 class="modal-title text-white fw-bold" id="studentRecruitModalLabel">
                    <i class="bx bx-user-circle me-2 fs-4"></i>ประวัติข้อมูลการรับสมัครเรียนรายบุคคล (Admission)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light-subtle" id="studentRecruitContent">
                <!-- Dynamically loaded student recruitment details -->
            </div>
            <div class="modal-footer py-2 border-top bg-light">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>