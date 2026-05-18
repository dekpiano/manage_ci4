<?php
// ฟังก์ชันแปลงวันที่คริสตศักราชเป็นปีพุทธศักราช (พ.ศ.) 📅✨
function formatThaiDate($dateStr) {
    if (empty($dateStr) || $dateStr === '-' || $dateStr === '0000-00-00') return '-';
    
    // ตรวจสอบรูปแบบ YYYY-MM-DD
    if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $dateStr, $matches)) {
        $year = (int)$matches[1];
        if ($year < 2400) {
            $year += 543; // แปลง ค.ศ. เป็น พ.ศ.
        }
        $thaiMonths = [
            '01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.', '05' => 'พ.ค.', '06' => 'มิ.ย.',
            '07' => 'ก.ค.', '08' => 'ส.ค.', '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.'
        ];
        return (int)$matches[3] . ' ' . $thaiMonths[$matches[2]] . ' ' . $year;
    }
    
    // ตรวจสอบรูปแบบ YYYY-MM-DD HH:MM:SS
    if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})\s([0-9]{2}):([0-9]{2}):([0-9]{2})$/', $dateStr, $matches)) {
        $year = (int)$matches[1];
        if ($year < 2400) {
            $year += 543;
        }
        $thaiMonths = [
            '01' => 'ม.ค.', '02' => 'ก.พ.', '03' => 'มี.ค.', '04' => 'เม.ย.', '05' => 'พ.ค.', '06' => 'มิ.ย.',
            '07' => 'ก.ค.', '08' => 'ส.ค.', '09' => 'ก.ย.', '10' => 'ต.ค.', '11' => 'พ.ย.', '12' => 'ธ.ค.'
        ];
        return (int)$matches[3] . ' ' . $thaiMonths[$matches[2]] . ' ' . $year . ' ' . $matches[4] . ':' . $matches[5] . ' น.';
    }
    
    return $dateStr;
}
?>

<div class="row">
    <!-- Student Sidebar Info -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        <?php 
                        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(($DataStudent->stu_prefix ?? '') . ($DataStudent->stu_fristName ?? '') . '+' . ($DataStudent->stu_lastName ?? '')) . '&color=7F9CF5&background=EBF4FF';
                        if (!empty($recruit_img) && !empty($recruit_regLevel)):
                            $avatarUrl = 'https://admission.skj.ac.th/uploads/recruitstudent/m' . $recruit_regLevel . '/img/' . $recruit_img;
                        endif;
                        ?>
                        <img class="img-fluid rounded-3 my-3 shadow-sm border" 
                             src="<?= $avatarUrl ?>" 
                             height="140" width="140" alt="Student avatar" 
                             style="object-fit: cover; border: 3px solid #15a362 !important;"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($student->StudentFirstName . '+' . $student->StudentLastName) ?>&color=ffffff&background=15a362'" />
                        <div class="user-info text-center mt-2">
                            <h5 class="mb-1 fw-bold"><?= esc($student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName) ?></h5>
                            <div class="d-flex gap-2 justify-content-center align-items-center mt-2">
                                <span class="badge bg-label-success px-3 py-1.5"><i class="bx bx-book-open me-1"></i>ม.<?= esc($student->StudentClass) ?>/<?= esc($student->StudentNumber ?? '-') ?></span>
                                <?php if (!empty($recruitData)): ?>
                                    <span class="badge bg-label-info px-3 py-1.5"><i class="bx bx-check-double me-1"></i>มีใบสมัครแนะแนว</span>
                                <?php else: ?>
                                    <span class="badge bg-label-secondary px-3 py-1.5"><i class="bx bx-info-circle me-1"></i>ไม่มีใบสมัคร</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-around flex-wrap my-4 py-3 border-top border-bottom">
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-label-success p-2 rounded"><i class="bx bx-phone"></i></span>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= esc($DataStudent->stu_phone ?? '-') ?></h6>
                            <small class="text-muted">เบอร์โทรศัพท์</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-label-success p-2 rounded"><i class="bx bx-smile"></i></span>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= esc($DataStudent->stu_nickName ?? '-') ?></h6>
                            <small class="text-muted">ชื่อเล่น</small>
                        </div>
                    </div>
                </div>

                <h6 class="pb-2 border-bottom mb-3 fw-bold text-success"><i class="bx bx-detail me-1"></i>รายละเอียดเบื้องต้น</h6>
                <div class="info-container">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold text-muted me-2">เลขบัตรประชาชน:</span>
                            <span class="fw-semibold text-dark"><?= esc($student->StudentIDNumber) ?></span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold text-muted me-2">วันเกิด:</span>
                            <span class="fw-semibold text-dark"><?= formatThaiDate($DataStudent->stu_birthDay) ?></span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold text-muted me-2">ศาสนา:</span>
                            <span class="fw-semibold text-dark"><?= esc($DataStudent->stu_religion ?? '-') ?></span>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold text-muted me-2">กรุ๊ปเลือด:</span>
                            <span class="badge bg-label-danger"><?= esc($DataStudent->stu_bloodType ?? '-') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/ Student Sidebar Info -->

    <!-- Student Details Info -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <?php if (empty($recruitData)): ?>
            <div class="alert alert-warning d-flex align-items-center mb-4 shadow-xs" role="alert">
                <i class="bx bx-error-circle bx-sm me-3 text-warning"></i>
                <div>
                    <strong>หมายเหตุ:</strong> ไม่พบข้อมูลประวัติใบสมัครนักเรียนคนนี้จากระบบรับสมัครนักเรียน (Admission) ระบบจะใช้ข้อมูลพื้นฐานจากระบบบุคลากร/ทะเบียนทดแทน
                </div>
            </div>
        <?php endif; ?>

        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist" style="gap: 5px;">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                        <i class="bx bx-user me-1"></i> ข้อมูลทั่วไป
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                        <i class="bx bx-home me-1"></i> ที่อยู่ & ติดต่อ
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">
                        <i class="bx bx-graduation me-1"></i> ประวัติการศึกษา
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-family" aria-controls="navs-pills-top-family" aria-selected="false">
                        <i class="bx bx-group me-1"></i> ข้อมูลครอบครัว
                    </button>
                </li>
                <?php if (!empty($recruitData)): ?>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-admission" aria-controls="navs-pills-top-admission" aria-selected="false">
                        <i class="bx bx-certification me-1"></i> ประวัติการสมัคร
                    </button>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-all" aria-controls="navs-pills-top-all" aria-selected="false">
                        <i class="bx bx-list-check me-1"></i> ข้อมูลดิบฐานข้อมูล
                    </button>
                </li>
            </ul>
            <div class="tab-content border-0 p-0 bg-transparent shadow-none">
                <!-- ข้อมูลทั่วไป -->
                <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm">
                        <h5 class="card-header bg-white border-bottom fw-bold text-success py-3"><i class="bx bx-user me-1"></i>ข้อมูลส่วนตัวเพิ่มเติม</h5>
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">สถานที่เกิด</label>
                                    <p class="form-control-plaintext border-bottom">
                                        <?= esc($DataStudent->stu_birthHospital ?? '-') ?> 
                                        ต.<?= esc($DataStudent->stu_birthTambon ?? '-') ?> อ.<?= esc($DataStudent->stu_birthDistrict ?? '-') ?> จ.<?= esc($DataStudent->stu_birthProvirce ?? '-') ?>
                                    </p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-muted">เชื้อชาติ</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_nationality ?? '-') ?></p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-muted">สัญชาติ</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_race ?? '-') ?></p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-muted">น้ำหนัก</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_wieght ?? '-') ?> กก.</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-muted">ส่วนสูง</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_hieght ?? '-') ?> ซม.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">โรคประจำตัว</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_diseaes ?: 'ไม่มี') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">สภาพบิดา-มารดา</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_parenalStatus ?? '-') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">สภาพความเป็นอยู่ปัจจุบัน</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_presentLife ?? '-') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">ความสามารถพิเศษ</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_talent ?: 'ไม่มี') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ที่อยู่ & ติดต่อ -->
                <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm">
                        <h5 class="card-header bg-white border-bottom fw-bold text-success py-3"><i class="bx bx-map-pin me-1"></i>ข้อมูลที่อยู่และช่องทางติดต่อ</h5>
                        <div class="card-body pt-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-success"><i class="bx bx-map me-1"></i> ที่อยู่ตามทะเบียนบ้าน</label>
                                <p class="form-control-plaintext border-bottom">
                                    บ้านเลขที่ <?= esc($DataStudent->stu_hNumber ?? '-') ?> หมู่ <?= esc($DataStudent->stu_hMoo ?? '-') ?> ถนน <?= esc($DataStudent->stu_hRoad ?? '-') ?>
                                    ต.<?= esc($DataStudent->stu_hTambon ?? '-') ?> อ.<?= esc($DataStudent->stu_hDistrict ?? '-') ?> จ.<?= esc($DataStudent->stu_hProvince ?? '-') ?> <?= esc($DataStudent->stu_hPostCode ?? '-') ?>
                                </p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-success"><i class="bx bx-pin me-1"></i> ที่อยู่ปัจจุบัน</label>
                                <p class="form-control-plaintext border-bottom">
                                    บ้านเลขที่ <?= esc($DataStudent->stu_cNumber ?? '-') ?> หมู่ <?= esc($DataStudent->stu_cMoo ?? '-') ?> ถนน <?= esc($DataStudent->stu_cRoad ?? '-') ?>
                                    ต.<?= esc($DataStudent->stu_cTumbao ?? '-') ?> อ.<?= esc($DataStudent->stu_cDistrict ?? '-') ?> จ.<?= esc($DataStudent->stu_cProvince ?? '-') ?> <?= esc($DataStudent->stu_cPostcode ?? '-') ?>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">โทรศัพท์ติดต่อฉุกเฉิน</label>
                                    <p class="form-control-plaintext border-bottom text-danger fw-bold"><?= esc($DataStudent->stu_phoneUrgent ?? '-') ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">ลักษณะที่พัก</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_natureRoom ?? '-') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ประวัติการศึกษา -->
                <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm">
                        <h5 class="card-header bg-white border-bottom fw-bold text-success py-3"><i class="bx bx-graduation me-1"></i>ข้อมูลการศึกษาเดิม</h5>
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">จบการศึกษาชั้น</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($DataStudent->stu_gradLevel ?? '-') ?></p>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold text-muted">จากโรงเรียน</label>
                                    <p class="form-control-plaintext border-bottom">
                                        <?= esc($DataStudent->stu_schoolfrom ?? '-') ?>
                                        ต.<?= esc($DataStudent->stu_schoolTambao ?? '-') ?> อ.<?= esc($DataStudent->stu_schoolDistrict ?? '-') ?> จ.<?= esc($DataStudent->stu_schoolProvince ?? '-') ?>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">เคยเป็นนักเรียน สกจ. หรือไม่</label>
                                    <p class="form-control-plaintext border-bottom">
                                        <?php if (($DataStudent->stu_usedStudent ?? '') == 'เคย'): ?>
                                            <span class="badge bg-label-success">เคยเป็นนักเรียนเก่า</span>
                                        <?php else: ?>
                                            <span class="badge bg-label-secondary">ไม่เคยเป็นนักเรียนเก่า</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ข้อมูลครอบครัว (บิดา, มารดา, ผู้ปกครอง) -->
                <div class="tab-pane fade" id="navs-pills-top-family" role="tabpanel">


                    <?php
                    if (!function_exists('renderParentCard')) {
                        function renderParentCard($type, $p, $recruitData) {
                            if ($type === 'father') {
                                $title = 'ข้อมูลบิดา';
                                $sub = 'Father\'s Info';
                                $border_color = '#3f51b5';
                                $bg_label = 'bg-label-primary';
                                $text_color = 'text-primary';
                                $icon = 'bx-male-sign';
                                
                                $fallback_name = !empty($recruitData) ? (($recruitData->recruit_fPrefix ?? '') . ($recruitData->recruit_fFirstName ?? '') . ' ' . ($recruitData->recruit_fLastName ?? '')) : '-';
                                $fallback_phone = !empty($recruitData) ? ($recruitData->recruit_fPhone ?? '-') : '-';
                                $fallback_job = !empty($recruitData) ? ($recruitData->recruit_fJob ?? '-') : '-';
                                $fallback_salary = !empty($recruitData) ? ($recruitData->recruit_fSalary ?? '-') : '-';
                                $fallback_idcard = !empty($recruitData) ? ($recruitData->recruit_fIdCard ?? '-') : '-';
                            } elseif ($type === 'mother') {
                                $title = 'ข้อมูลมารดา';
                                $sub = 'Mother\'s Info';
                                $border_color = '#e91e63';
                                $bg_label = 'bg-label-danger';
                                $text_color = 'text-danger';
                                $icon = 'bx-female-sign';
                                
                                $fallback_name = !empty($recruitData) ? (($recruitData->recruit_mPrefix ?? '') . ($recruitData->recruit_mFirstName ?? '') . ' ' . ($recruitData->recruit_mLastName ?? '')) : '-';
                                $fallback_phone = !empty($recruitData) ? ($recruitData->recruit_mPhone ?? '-') : '-';
                                $fallback_job = !empty($recruitData) ? ($recruitData->recruit_mJob ?? '-') : '-';
                                $fallback_salary = !empty($recruitData) ? ($recruitData->recruit_mSalary ?? '-') : '-';
                                $fallback_idcard = !empty($recruitData) ? ($recruitData->recruit_mIdCard ?? '-') : '-';
                            } else {
                                $title = 'ข้อมูลผู้ปกครอง';
                                $sub = 'Guardian\'s Info';
                                $border_color = '#15a362';
                                $bg_label = 'bg-label-success';
                                $text_color = 'text-success';
                                $icon = 'bx-group';
                                
                                $fallback_name = !empty($recruitData) ? (($recruitData->recruit_pPrefix ?? '') . ($recruitData->recruit_pFirstName ?? '') . ' ' . ($recruitData->recruit_pLastName ?? '')) : '-';
                                $fallback_phone = !empty($recruitData) ? ($recruitData->recruit_pPhone ?? '-') : '-';
                                $fallback_job = !empty($recruitData) ? ($recruitData->recruit_pJob ?? '-') : '-';
                                $fallback_salary = !empty($recruitData) ? ($recruitData->recruit_pSalary ?? '-') : '-';
                                $fallback_idcard = !empty($recruitData) ? ($recruitData->recruit_pIdCard ?? '-') : '-';
                            }

                            $has_full_data = !empty($p);
                            
                            $relation = $has_full_data ? ($p->par_relation ?? '-') : ($type === 'father' ? 'บิดา' : ($type === 'mother' ? 'มารดา' : 'ผู้ปกครอง'));
                            $name = $has_full_data ? (($p->par_prefix ?? '') . ($p->par_firstName ?? '') . ' ' . ($p->par_lastName ?? '')) : $fallback_name;
                            $phone = $has_full_data ? ($p->par_phone ?? '-') : $fallback_phone;
                            $job = $has_full_data ? ($p->par_career ?? '-') : $fallback_job;
                            $salary = $has_full_data ? ($p->par_salary ?? '-') : $fallback_salary;
                            if (is_numeric($salary)) {
                                $salary = number_format($salary) . ' บาท';
                            }
                            $idcard = $has_full_data ? ($p->par_IdNumber ?? '-') : $fallback_idcard;
                            
                            $ago = $has_full_data ? ($p->par_ago ?? '-') : '-';
                            $national = $has_full_data ? ($p->par_national ?? '-') : '-';
                            $race = $has_full_data ? ($p->par_race ?? '-') : '-';
                            $religion = $has_full_data ? ($p->par_religion ?? '-') : '-';
                            $education = $has_full_data ? ($p->par_education ?? '-') : '-';
                            $positionJob = $has_full_data ? ($p->par_positionJob ?? '-') : '-';
                            $decease = $has_full_data ? ($p->par_decease ?? '-') : '-';
                            if ($decease && $decease !== '-' && strpos($decease, '0000') === false) {
                                $time = strtotime($decease);
                                if ($time !== false) {
                                    $decease = date('d/m/', $time) . (date('Y', $time) + 543);
                                }
                            }
                            
                            // ที่อยู่ทะเบียนบ้าน
                            $hAddr = '-';
                            if ($has_full_data && (!empty($p->par_hNumber) || !empty($p->par_hProvince))) {
                                $addrParts = [];
                                if (!empty($p->par_hNumber)) $addrParts[] = 'บ้านเลขที่ ' . $p->par_hNumber;
                                if (!empty($p->par_hMoo)) $addrParts[] = 'หมู่ที่ ' . $p->par_hMoo;
                                if (!empty($p->par_hTambon)) $addrParts[] = 'ต. ' . $p->par_hTambon;
                                if (!empty($p->par_hDistrict)) $addrParts[] = 'อ. ' . $p->par_hDistrict;
                                if (!empty($p->par_hProvince)) $addrParts[] = 'จ. ' . $p->par_hProvince;
                                if (!empty($p->par_hPostcode)) $addrParts[] = $p->par_hPostcode;
                                $hAddr = implode(' ', $addrParts);
                            }
                            
                            // ที่อยู่ปัจจุบัน
                            $cAddr = '-';
                            if ($has_full_data && (!empty($p->par_cNumber) || !empty($p->par_cProvince))) {
                                $addrParts = [];
                                if (!empty($p->par_cNumber)) $addrParts[] = 'บ้านเลขที่ ' . $p->par_cNumber;
                                if (!empty($p->par_cMoo)) $addrParts[] = 'หมู่ที่ ' . $p->par_cMoo;
                                if (!empty($p->par_cTambon)) $addrParts[] = 'ต. ' . $p->par_cTambon;
                                if (!empty($p->par_cDistrict)) $addrParts[] = 'อ. ' . $p->par_cDistrict;
                                if (!empty($p->par_cProvince)) $addrParts[] = 'จ. ' . $p->par_cProvince;
                                if (!empty($p->par_cPostcode)) $addrParts[] = $p->par_cPostcode;
                                $cAddr = implode(' ', $addrParts);
                            }
                            
                            $rest = $has_full_data ? ($p->par_rest ?? '-') : '-';
                            $restOrthor = $has_full_data ? ($p->par_restOrthor ?? '-') : '-';
                            $service = $has_full_data ? ($p->par_service ?? '-') : '-';
                            $serviceName = $has_full_data ? ($p->par_serviceName ?? '-') : '-';
                            $claim = $has_full_data ? ($p->par_claim ?? '-') : '-';
                            
                            $unique_id = 'parent_' . $type;
                            ?>
                            <div class="card border shadow-sm h-100" style="border-top: 4px solid <?= $border_color ?> !important; border-radius: 8px; background-color: #fff;">
                                <div class="card-body pt-3 px-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge <?= $bg_label ?> p-2 rounded me-3"><i class="bx <?= $icon ?> fs-4"></i></div>
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold <?= $text_color ?>"><?= $title ?></h5>
                                            <small class="text-muted"><?= $sub ?></small>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-unstyled mb-3">
                                        <li class="mb-2 border-bottom pb-1">
                                            <label class="small text-muted fw-semibold">ชื่อ - นามสกุล</label>
                                            <div class="fw-bold text-dark"><?= esc($name) ?></div>
                                        </li>
                                        <li class="mb-2 border-bottom pb-1">
                                            <label class="small text-muted fw-semibold">ความสัมพันธ์</label>
                                            <div><span class="badge <?= $bg_label ?> px-2 py-0.5"><?= esc($relation) ?></span></div>
                                        </li>
                                        <li class="mb-2 border-bottom pb-1">
                                            <label class="small text-muted fw-semibold">เลขบัตรประชาชน</label>
                                            <div class="fw-bold text-dark"><?= esc($idcard) ?></div>
                                        </li>
                                        <li class="mb-2 border-bottom pb-1">
                                            <label class="small text-muted fw-semibold">เบอร์โทรศัพท์</label>
                                            <div class="fw-bold text-dark"><?= esc($phone) ?></div>
                                        </li>
                                    </ul>

                                    <?php if ($has_full_data): ?>
                                        <!-- Bootstrap Accordion inside Card -->
                                        <div class="accordion accordion-header-primary" id="accordion_<?= $unique_id ?>">
                                            <!-- ข้อมูลส่วนตัวเพิ่มเติม -->
                                            <div class="accordion-item border mb-1">
                                                <h2 class="accordion-header" id="headingOne_<?= $unique_id ?>">
                                                    <button type="button" class="accordion-button collapsed py-2 px-3 small fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#collapseOne_<?= $unique_id ?>" aria-expanded="false" aria-controls="collapseOne_<?= $unique_id ?>" style="font-size: 11px;">
                                                        <i class="bx bx-user me-1 text-primary"></i> ข้อมูลส่วนตัวเพิ่มเติม
                                                    </button>
                                                </h2>
                                                <div id="collapseOne_<?= $unique_id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne_<?= $unique_id ?>" data-bs-parent="#accordion_<?= $unique_id ?>">
                                                    <div class="accordion-body py-2 px-3" style="font-size: 11px; background-color: #fcfcfc;">
                                                        <div class="row g-2">
                                                            <div class="col-6 mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold d-block">อายุ</span>
                                                                <span class="fw-bold text-dark"><?= esc($ago) ?> ปี</span>
                                                            </div>
                                                            <div class="col-6 mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold d-block">วุฒิการศึกษา</span>
                                                                <span class="fw-bold text-dark"><?= esc($education) ?></span>
                                                            </div>
                                                            <div class="col-12 mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold d-block">สัญชาติ / เชื้อชาติ / ศาสนา</span>
                                                                <span class="fw-bold text-dark"><?= esc($national) ?> / <?= esc($race) ?> / <?= esc($religion) ?></span>
                                                            </div>
                                                            <?php if ($decease && $decease !== '-'): ?>
                                                            <div class="col-12 mb-1">
                                                                <span class="text-danger fw-semibold d-block">วันที่เสียชีวิต/สถานะ</span>
                                                                <span class="fw-bold text-danger"><?= esc($decease) ?></span>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ข้อมูลการทำงาน -->
                                            <div class="accordion-item border mb-1">
                                                <h2 class="accordion-header" id="headingTwo_<?= $unique_id ?>">
                                                    <button type="button" class="accordion-button collapsed py-2 px-3 small fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#collapseTwo_<?= $unique_id ?>" aria-expanded="false" aria-controls="collapseTwo_<?= $unique_id ?>" style="font-size: 11px;">
                                                        <i class="bx bx-briefcase me-1 text-info"></i> ข้อมูลการทำงาน
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo_<?= $unique_id ?>" class="accordion-collapse collapse" aria-labelledby="headingTwo_<?= $unique_id ?>" data-bs-parent="#accordion_<?= $unique_id ?>">
                                                    <div class="accordion-body py-2 px-3" style="font-size: 11px; background-color: #fcfcfc;">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold">อาชีพ</span>
                                                                <div class="fw-bold text-dark"><?= esc($job) ?></div>
                                                            </li>
                                                            <li class="mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold">ตำแหน่งงาน</span>
                                                                <div class="fw-bold text-dark"><?= esc($positionJob) ?></div>
                                                            </li>
                                                            <li class="mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold">เงินเดือน / รายได้</span>
                                                                <div class="fw-bold text-success"><?= esc($salary) ?></div>
                                                            </li>
                                                            <li class="mb-1 border-bottom pb-1">
                                                                <span class="text-muted fw-semibold">สถานที่รับราชการ / ชื่อหน่วยงาน</span>
                                                                <div class="fw-bold text-dark"><?= esc($service) ?> <?= $serviceName !== '-' ? '('.esc($serviceName).')' : '' ?></div>
                                                            </li>
                                                            <li class="mb-0">
                                                                <span class="text-muted fw-semibold">สิทธิการเบิกค่าเล่าเรียน</span>
                                                                <div class="fw-bold text-dark"><?= esc($claim) ?></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ที่อยู่ตามทะเบียนบ้าน -->
                                            <div class="accordion-item border mb-1">
                                                <h2 class="accordion-header" id="headingThree_<?= $unique_id ?>">
                                                    <button type="button" class="accordion-button collapsed py-2 px-3 small fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#collapseThree_<?= $unique_id ?>" aria-expanded="false" aria-controls="collapseThree_<?= $unique_id ?>" style="font-size: 11px;">
                                                        <i class="bx bx-home me-1 text-warning"></i> ที่อยู่ทะเบียนบ้าน
                                                    </button>
                                                </h2>
                                                <div id="collapseThree_<?= $unique_id ?>" class="accordion-collapse collapse" aria-labelledby="headingThree_<?= $unique_id ?>" data-bs-parent="#accordion_<?= $unique_id ?>">
                                                    <div class="accordion-body py-2 px-3" style="font-size: 11px; background-color: #fcfcfc;">
                                                        <div class="text-dark fw-semibold" style="line-height: 1.4;"><?= esc($hAddr) ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ที่อยู่ปัจจุบัน -->
                                            <div class="accordion-item border mb-0">
                                                <h2 class="accordion-header" id="headingFour_<?= $unique_id ?>">
                                                    <button type="button" class="accordion-button collapsed py-2 px-3 small fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#collapseFour_<?= $unique_id ?>" aria-expanded="false" aria-controls="collapseFour_<?= $unique_id ?>" style="font-size: 11px;">
                                                        <i class="bx bx-map me-1 text-success"></i> ที่อยู่ปัจจุบัน
                                                    </button>
                                                </h2>
                                                <div id="collapseFour_<?= $unique_id ?>" class="accordion-collapse collapse" aria-labelledby="headingFour_<?= $unique_id ?>" data-bs-parent="#accordion_<?= $unique_id ?>">
                                                    <div class="accordion-body py-2 px-3" style="font-size: 11px; background-color: #fcfcfc;">
                                                        <div class="text-dark fw-semibold mb-1" style="line-height: 1.4;"><?= esc($cAddr) ?></div>
                                                        <div class="border-top pt-1 mt-1">
                                                            <span class="text-muted fw-semibold">ลักษณะที่พัก:</span>
                                                            <span class="fw-bold text-dark"><?= esc($rest) ?> <?= $restOrthor !== '-' ? '('.esc($restOrthor).')' : '' ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-light p-2 mb-0" style="font-size: 11px; border: 1px dashed #d9dee3;">
                                            <i class="bx bx-info-circle text-muted me-1"></i>ไม่มีข้อมูลประวัติตามทะเบียนบ้านกลาง (กำลังแสดงข้อมูลสำรองจากใบสมัครสอบเข้า)
                                            <div class="mt-1">
                                                <b>อาชีพ:</b> <?= esc($job) ?><br>
                                                <b>รายได้:</b> <?= esc($salary) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="row g-4">
                        <!-- บิดา -->
                        <div class="col-md-4">
                            <?php renderParentCard('father', $parent_data['father'] ?? null, $recruitData); ?>
                        </div>

                        <!-- มารดา -->
                        <div class="col-md-4">
                            <?php renderParentCard('mother', $parent_data['mother'] ?? null, $recruitData); ?>
                        </div>

                        <!-- ผู้ปกครอง -->
                        <div class="col-md-4">
                            <?php renderParentCard('guardian', $parent_data['guardian'] ?? null, $recruitData); ?>
                        </div>
                    </div>
                </div>

                <!-- ประวัติการสมัครเรียน (ถ้ามีข้อมูล) -->
                <?php if (!empty($recruitData)): ?>
                <div class="tab-pane fade" id="navs-pills-top-admission" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm">
                        <h5 class="card-header bg-white border-bottom fw-bold text-success py-3"><i class="bx bx-id-card me-1"></i>ประวัติใบสมัครในระบบแนะแนว/แอดมิชชั่น</h5>
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">เลขใบสมัคร/เลขที่สอบ</label>
                                    <p class="form-control-plaintext border-bottom fw-bold text-success"><?= esc($recruitData->recruit_regNum ?? '-') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">ประเภทโควตา/ประเภทการสมัคร</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($recruitData->recruit_category ?? '-') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">ปีการศึกษา</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($recruitData->recruit_year ?? '-') ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">สายการเรียน/ประเภทห้องเรียนที่เลือก</label>
                                    <p class="form-control-plaintext border-bottom fw-semibold text-primary"><?= esc($recruitData->recruit_tpyeRoom ?? '-') ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">สายการเรียนสำรอง</label>
                                    <p class="form-control-plaintext border-bottom"><?= esc($recruitData->recruit_tpyeRoomBackup ?? $recruitData->recruit_typeRoomBackup ?? 'ไม่มี') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">เกรดเฉลี่ยสะสม (GPA)</label>
                                    <p class="form-control-plaintext border-bottom fw-bold text-info"><?= esc($recruitData->recruit_grade ?? '-') ?></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">ผลการตัดสิน</label>
                                    <p class="form-control-plaintext border-bottom">
                                        <?php if (($recruitData->recruit_statusFinal ?? '') == 'ผ่าน'): ?>
                                            <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i>ผ่านการคัดเลือก</span>
                                        <?php elseif (($recruitData->recruit_statusFinal ?? '') == 'ตัวสำรอง'): ?>
                                            <span class="badge bg-warning"><i class="bx bx-time me-1"></i>ตัวสำรอง</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i>ไม่ผ่าน/ไม่มีข้อมูล</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-muted">สถานะการยืนยันตัวตน/มอบตัว</label>
                                    <p class="form-control-plaintext border-bottom">
                                        <?php if (($recruitData->recruit_statusSurrender ?? '') == 'มอบตัวแล้ว'): ?>
                                            <span class="badge bg-success"><i class="bx bx-badge-check me-1"></i>มอบตัวเสร็จสิ้น</span>
                                        <?php elseif (($recruitData->recruit_statusSurrender ?? '') == 'สละสิทธิ์'): ?>
                                            <span class="badge bg-danger"><i class="bx bx-x me-1"></i>สละสิทธิ์</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="bx bx-help-circle me-1"></i>ยังไม่มอบตัว</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ข้อมูลดิบทั้งหมดในฐานข้อมูล -->
                <div class="tab-pane fade" id="navs-pills-top-all" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm" style="max-height: 400px; overflow-y: auto;">
                        <h5 class="card-header bg-white border-bottom fw-bold text-success py-3 sticky-top"><i class="bx bx-database me-1"></i>ฟิลด์ข้อมูลทั้งหมดใน skjacth_admission.tb_recruitstudent</h5>
                        <div class="card-body pt-3 px-0">
                            <?php if (empty($recruitData)): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bx bx-data bx-md mb-2"></i>
                                    <p>ไม่พบข้อมูลประวัติใบสมัคร (Admission)</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">ชื่อฟิลด์ข้อมูล</th>
                                                <th>คำอธิบายภาษาไทย</th>
                                                <th class="pe-4">ค่าข้อมูลจริง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ((array)$recruitData as $key => $value): ?>
                                                <tr>
                                                    <td class="ps-4 font-monospace text-primary" style="font-size: 0.85rem;"><?= esc($key) ?></td>
                                                    <td class="fw-semibold text-muted" style="font-size: 0.85rem;"><?= esc($recruitLabels[$key] ?? $key) ?></td>
                                                    <td class="pe-4 text-dark font-monospace" style="font-size: 0.85rem; word-break: break-all;">
                                                        <?php 
                                                        if (in_array($key, ['recruit_createdate', 'recruit_updatedate', 'recruit_birthday'])) {
                                                            echo esc(formatThaiDate($value));
                                                        } else {
                                                            echo esc($value !== null ? $value : '-');
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
