<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm me-3">
                <i class="bx bx-arrow-back"></i> ย้อนกลับ
            </a>
            <h4 class="fw-bold mb-0">
                <i class='bx bx-user-check text-success me-2'></i>
                <?= esc($title) ?>
            </h4>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>"><i class='bx bx-home'></i> หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="javascript:history.back()">รายงานผลการบันทึกคะแนน</a></li>
                <li class="breadcrumb-item active">ตรวจสอบคะแนน</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Teacher Info Card -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #71dd37 0%, #8de45c 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ครูผู้สอน</h6>
                        <h5 class="mb-0 fw-bold"><?= isset($Teacher) ? esc($Teacher->pers_prefix.$Teacher->pers_firstname.' '.$Teacher->pers_lastname) : '-' ?></h5>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-user fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #48c764 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">ภาคเรียน/ปีการศึกษา</h6>
                        <h5 class="mb-0 fw-bold"><?= esc($Term) ?>/<?= esc($Year) ?></h5>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-calendar fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #20c997 0%, #4dd4ac 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-white-50">จำนวนวิชา</h6>
                        <h5 class="mb-0 fw-bold"><?= count($checkSubject ?? []) ?> วิชา</h5>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2);">
                        <i class='bx bx-book-open fs-3'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subject Accordion -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white border-bottom-0 py-3" style="border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                <i class='bx bx-list-check text-success fs-4'></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">รายวิชาที่สอน</h5>
                <small class="text-muted">คลิกเพื่อดูรายละเอียดคะแนนแต่ละวิชา</small>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="accordion" id="subjectAccordion">
            <?php foreach ($checkSubject as $key => $v_checkSubject) : ?>
                <div class="accordion-item border mb-3" style="border-radius: 10px !important; overflow: hidden;">
                    <h2 class="accordion-header" id="heading<?= $key ?>">
                        <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center w-100">
                                <span class="badge bg-success me-3" style="min-width: 100px;"><?= esc($v_checkSubject->SubjectCode) ?></span>
                                <span class="fw-semibold"><?= esc($v_checkSubject->SubjectName) ?></span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $key ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $key ?>" data-bs-parent="#subjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0 scoreTable" id="scoreTable<?= $key ?>">
                                    <thead class="table-success">
                                        <tr class="text-center">
                                            <th style="width: 120px;">เลขประจำตัว</th>
                                            <th style="width: 100px;">ระดับชั้น</th>
                                            <th style="white-space: nowrap;">ชื่อ - นามสกุล</th>
                                            <th style="width: 80px;">สถานะ</th>
                                            <th style="width: 100px;">ก่อนกลางภาค</th>
                                            <th style="width: 100px;">สอบกลางภาค</th>
                                            <th style="width: 100px;">หลังกลางภาค</th>
                                            <th style="width: 100px;">สอบปลายภาค</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $foundScores = false;
                                        foreach ($CheckScore as $v_CheckScore) :
                                            if ($v_checkSubject->SubjectID == $v_CheckScore->SubjectID) :
                                                $foundScores = true;
                                                $subScore = explode('|', $v_CheckScore->Score100); ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-label-primary"><?= esc($v_CheckScore->StudentCode) ?></span>
                                                    </td>
                                                    <td class="text-center"><?= esc($v_CheckScore->StudentClass) ?></td>
                                                    <td style="white-space: nowrap;"><?= esc($v_CheckScore->StudentPrefix.$v_CheckScore->StudentFirstName.' '.$v_CheckScore->StudentLastName) ?></td>
                                                    <td class="text-center">
                                                        <?php if($v_CheckScore->StudentBehavior == 'ปกติ'): ?>
                                                            <span class="badge bg-success">ปกติ</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning"><?= esc($v_CheckScore->StudentBehavior) ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center"><?= @$subScore[0] ?: '-' ?></td>
                                                    <td class="text-center"><?= @$subScore[1] ?: '-' ?></td>
                                                    <td class="text-center"><?= @$subScore[2] ?: '-' ?></td>
                                                    <td class="text-center"><?= @$subScore[3] ?: '-' ?></td>
                                                </tr>
                                        <?php endif;
                                        endforeach; 
                                        
                                        if (!$foundScores) : ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    <i class='bx bx-info-circle fs-4 me-2'></i>
                                                    ไม่พบข้อมูลคะแนนสำหรับวิชานี้
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(empty($checkSubject)): ?>
        <div class="text-center py-5">
            <i class='bx bx-folder-open text-muted' style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">ไม่พบรายวิชาที่สอนในภาคเรียนนี้</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable for each score table when accordion is shown
    $('.accordion-button').on('click', function() {
        var target = $(this).attr('data-bs-target');
        var tableId = $(target).find('.scoreTable').attr('id');
        
        if (tableId && !$.fn.DataTable.isDataTable('#' + tableId)) {
            setTimeout(function() {
                $('#' + tableId).DataTable({
                    "language": {
                        "lengthMenu": "แสดง _MENU_ รายการ",
                        "zeroRecords": "ไม่พบข้อมูล",
                        "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                        "infoEmpty": "ไม่มีข้อมูล",
                        "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
                        "search": "ค้นหา:",
                        "paginate": {
                            "first": "หน้าแรก",
                            "last": "หน้าสุดท้าย",
                            "next": "ถัดไป",
                            "previous": "ก่อนหน้า"
                        }
                    },
                    "stateSave": false,
                    "order": [[1, "asc"]]
                });
            }, 100);
        }
    });
});
</script>
<?= $this->endSection() ?>
