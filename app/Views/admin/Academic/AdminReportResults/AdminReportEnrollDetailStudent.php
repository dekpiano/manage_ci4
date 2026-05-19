<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Green brand theme overrides */
    .btn-outline-primary {
        color: #15a362 !important;
        border-color: #15a362 !important;
    }
    .btn-outline-primary:hover {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #fff !important;
    }
    .text-primary {
        color: #15a362 !important;
    }
    .bg-label-primary {
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: #15a362 !important;
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link.active:focus, .nav-pills .nav-link.active:hover {
        background-color: #15a362 !important;
        color: #fff !important;
        box-shadow: 0 2px 4px rgba(21, 163, 98, 0.4) !important;
    }
    .nav-pills .nav-link {
        color: #566a7f;
    }
    .nav-pills .nav-link:hover {
        color: #15a362 !important;
        background-color: rgba(21, 163, 98, 0.04) !important;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">งานแนะแนว / รายงานการรับสมัครนักเรียน /</span> รายละเอียดผู้สมัคร
    </h4>

    <div class="row">
        <!-- Student Sidebar Info -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded my-4" 
                                 src="https://admission.skj.ac.th/uploads/recruitstudent/m<?=$recruit_regLevel?>/img/<?=$recruit_img?>" 
                                 height="150" width="150" alt="User avatar" 
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?=$DataStudent->stu_fristName?>+<?=$DataStudent->stu_lastName?>&color=7F9CF5&background=EBF4FF'" />
                            <div class="user-info text-center">
                                <h4 class="mb-2"><?=$DataStudent->stu_prefix.$DataStudent->stu_fristName.' '.$DataStudent->stu_lastName?></h4>
                                <span class="badge bg-label-info mt-1">ม.<?=$recruit_regLevel?></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3 border-top border-bottom">
                        <div class="d-flex align-items-start me-4 mt-3 gap-3">
                            <span class="badge bg-label-success p-2 rounded"><i class="bx bx-phone bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0"><?=$DataStudent->stu_phone?></h5>
                                <span>เบอร์โทรศัพท์</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mt-3 gap-3">
                            <span class="badge bg-label-success p-2 rounded"><i class="bx bx-id-card bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0"><?=$DataStudent->stu_nickName ?: '-'?></h5>
                                <span>ชื่อเล่น</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">รายละเอียดเบื้องต้น</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">เลขบัตรประชาชน:</span>
                                <span><?=$DataStudent->stu_iden?></span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">วันเกิด:</span>
                                <span><?=thai_date_format($DataStudent->stu_birthDay, 'medium')?></span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">ศาสนา:</span>
                                <span><?=$DataStudent->stu_religion?></span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">กรุ๊ปเลือด:</span>
                                <span class="badge bg-label-danger"><?=$DataStudent->stu_bloodType?></span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center pt-3">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">ย้อนกลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Student Sidebar Info -->

        <!-- Student Details Info -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
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
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-history" aria-controls="navs-pills-top-history" aria-selected="false">
                            <i class="bx bx-history me-1"></i> ประวัติการสมัคร
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-all" aria-controls="navs-pills-top-all" aria-selected="false">
                            <i class="bx bx-list-check me-1"></i> ข้อมูลทั้งหมดในฐานข้อมูล
                        </button>
                    </li>
                </ul>
                <div class="tab-content border-0 p-0 bg-transparent">
                    <!-- ข้อมูลทั่วไป -->
                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">ข้อมูลส่วนตัวเพิ่มเติม</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">สถานที่เกิด</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?=$DataStudent->stu_birthHospital?> 
                                            ต.<?=$DataStudent->stu_birthTambon?> อ.<?=$DataStudent->stu_birthDistrict?> จ.<?=$DataStudent->stu_birthProvirce?>
                                        </p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">เชื้อชาติ</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_nationality?></p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">สัญชาติ</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_race?></p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">น้ำหนัก</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_wieght?> กก.</p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">ส่วนสูง</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_hieght?> ซม.</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">โรคประจำตัว</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_diseaes ?: 'ไม่มี'?></p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">สภาพบิดา-มารดา</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_parenalStatus?></p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">สภาพความเป็นอยู่ปัจจุบัน</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_presentLife?></p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">ความสามารถพิเศษ</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_talent ?: 'ไม่มี'?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ที่อยู่ & ติดต่อ -->
                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">ข้อมูลที่อยู่และช่องทางติดต่อ</h5>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-primary"><i class="bx bx-map me-1"></i> ที่อยู่ตามทะเบียนบ้าน</label>
                                    <p class="form-control-plaintext border-bottom">
                                        บ้านเลขที่ <?=$DataStudent->stu_hNumber?> หมู่ <?=$DataStudent->stu_hMoo?> ถนน <?=$DataStudent->stu_hRoad?>
                                        ต.<?=$DataStudent->stu_hTambon?> อ.<?=$DataStudent->stu_hDistrict?> จ.<?=$DataStudent->stu_hProvince?> <?=$DataStudent->stu_hPostCode?>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-primary"><i class="bx bx-pin me-1"></i> ที่อยู่ปัจจุบัน</label>
                                    <p class="form-control-plaintext border-bottom">
                                        บ้านเลขที่ <?=$DataStudent->stu_cNumber?> หมู่ <?=$DataStudent->stu_cMoo?> ถนน <?=$DataStudent->stu_cRoad?>
                                        ต.<?=$DataStudent->stu_cTumbao?> อ.<?=$DataStudent->stu_cDistrict?> จ.<?=$DataStudent->stu_cProvince?> <?=$DataStudent->stu_cPostcode?>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">โทรศัพท์ติดต่อฉุกเฉิน</label>
                                        <p class="form-control-plaintext border-bottom text-danger fw-bold"><?=$DataStudent->stu_phoneUrgent?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">ลักษณะที่พัก</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_natureRoom?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ประวัติการศึกษา -->
                    <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">ข้อมูลการศึกษาเดิม</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">จบการศึกษาชั้น</label>
                                        <p class="form-control-plaintext border-bottom"><?=$DataStudent->stu_gradLevel?></p>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-bold">จากโรงเรียน</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?=$DataStudent->stu_schoolfrom?>
                                            ต.<?=$DataStudent->stu_schoolTambao?> อ.<?=$DataStudent->stu_schoolDistrict?> จ.<?=$DataStudent->stu_schoolProvince?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">เคยเป็นนักเรียน สกจ. หรือไม่</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?php if($DataStudent->stu_usedStudent == 'เคย'): ?>
                                                <span class="badge bg-label-success">เคยเป็นนักเรียนเก่า</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-secondary">ไม่เคย</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ประวัติการสมัคร -->
                    <div class="tab-pane fade" id="navs-pills-top-history" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">ประวัติและสถานะการสมัครเรียน</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">รอบที่สมัคร</label>
                                        <p class="form-control-plaintext border-bottom text-primary fw-bold"><?=$recruit_category?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">สายการเรียน/ประเภทห้องเรียน</label>
                                        <p class="form-control-plaintext border-bottom"><?=$recruit_tpyeRoom?></p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">ผลการตัดสินสุดท้าย</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?php if($recruit_statusFinal): ?>
                                                <span class="badge bg-label-success"><?=$recruit_statusFinal?></span>
                                            <?php else: ?>
                                                <span class="badge bg-label-secondary">รอดำเนินการ</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">สถานะการมอบตัว</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?php if($recruit_statusSurrender): ?>
                                                <span class="badge bg-label-success"><?=$recruit_statusSurrender?></span>
                                            <?php else: ?>
                                                <span class="badge bg-label-warning">ยังไม่ดำเนินการ</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">รายงานตัวในระบบ</label>
                                        <p class="form-control-plaintext border-bottom">
                                            <?php if($DataStudent->stu_UpdateConfirm): ?>
                                                <span class="badge bg-label-success">ยืนยันแล้ว</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-danger">ยังไม่ยืนยัน</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ข้อมูลทั้งหมดในฐานข้อมูล -->
                    <div class="tab-pane fade" id="navs-pills-top-all" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">รายละเอียดข้อมูลดิบทั้งหมดจากระบบรับสมัคร</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped border">
                                        <thead>
                                            <tr>
                                                <th class="bg-light">หัวข้อ (Column)</th>
                                                <th class="bg-light">ข้อมูล (Value)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach((array)$recruitData as $key => $value): ?>
                                                <?php if(!empty($value)): ?>
                                                <tr>
                                                    <td class="fw-bold text-muted small"><?= isset($recruitLabels[$key]) ? $recruitLabels[$key] : $key ?></td>
                                                    <td>
                                                        <?php 
                                                        if (in_array($key, ['recruit_birthday', 'recruit_createdate', 'recruit_updatedate'])) {
                                                            echo thai_date_format($value, 'medium');
                                                        } else {
                                                            echo $value;
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Student Details Info -->
    </div>
</div>
<?= $this->endSection() ?>
