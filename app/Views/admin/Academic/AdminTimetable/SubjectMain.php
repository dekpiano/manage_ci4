<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
.subject-card {
    transition: all 0.3s ease;
    border: 1px solid #f0f2f4;
}
.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    border-color: #15a362;
}
.sticky-top-sub {
    position: sticky;
    top: 140px;
    z-index: 100;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> รายวิชา
            </h4>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalImportSubject">
                <i class="bx bx-download me-1"></i> นำเข้าจากระบบทะเบียน
            </button>
            <button class="btn btn-outline-primary rounded-pill px-4 ms-2" data-bs-toggle="modal" data-bs-target="#modalAddSubject">
                <i class="bx bx-plus me-1"></i> เพิ่มเอง (ไม่มีรหัส)
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/academic/timetable') ?>" class="btn btn-label-secondary text-start border-0">
                            <i class="bx bx-chevron-left me-2"></i> กลับหน้าหลัก
                        </a>
                        <hr class="my-2">
                        <a href="<?= base_url('admin/academic/timetable/subjects') ?>" class="btn btn-primary text-start border-0 active shadow-none" style="background: #15a362 !important;">
                            <i class="bx bx-book me-2"></i> รายวิชาตารางสอน
                        </a>
                        <a href="<?= base_url('admin/academic/timetable') ?>" class="btn btn-label-secondary text-start border-0">
                            <i class="bx bx-user-check me-2"></i> มอบหมายงานสอน
                        </a>
                        <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-label-secondary text-start border-0">
                            <i class="bx bx-magic-wand me-2"></i> ประมวลผลตาราง
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-label-success">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">คำแนะนำ</h6>
                    <small class="text-muted d-block mb-2">1. นำเข้าวิชาที่มีรหัสจากระบบทะเบียนก่อน</small>
                    <small class="text-muted d-block mb-2">2. เพิ่มวิชากิจกรรมหรืออื่นๆ ที่ไม่มีรหัสเองได้</small>
                    <small class="text-muted d-block">3. วิชาเหล่านี้จะถูกนำไปใช้ในหน้ามอบหมายงานสอน</small>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-bottom bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-list-check me-1 text-success"></i> รายวิชาทั้งหมดในตารางสอน (<?= $term ?>/<?= $year ?>)</h5>
                    <div class="badge bg-label-success rounded-pill px-3"><?= count($timetable_subjects) ?> วิชา</div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="bg-label-secondary">
                                <th class="fw-bold">รหัสวิชา</th>
                                <th class="fw-bold">ชื่อวิชา (สำหรับแสดงในตาราง)</th>
                                <th class="fw-bold text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($timetable_subjects)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bx bx-book-open mb-3 text-light" style="font-size: 4rem;"></i>
                                            <p class="text-muted">ยังไม่มีรายวิชาในระบบตารางสอน</p>
                                            <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalImportSubject">เริ่มนำเข้าข้อมูล</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($timetable_subjects as $s): ?>
                                <tr>
                                    <td><span class="badge bg-label-dark fw-bold"><?= $s->tsub_code ?: '-' ?></span></td>
                                    <td><span class="fw-bold text-dark"><?= $s->tsub_name ?></span></td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-label-danger btn-sm rounded-circle btn-delete" data-id="<?= $s->tsub_id ?>">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImportSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold"><i class="bx bx-download me-2 text-primary"></i> นำเข้ารายวิชาจากระบบทะเบียน (<?= $term ?>/<?= $year ?>)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formImportSubjects">
                    <?= csrf_field() ?>
                    <input type="hidden" name="term" value="<?= $term ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0 small">เลือกวิชาที่ต้องการนำเข้าสู่ระบบตารางสอน</p>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="btnSelectAll">เลือกทั้งหมด</button>
                    </div>
                    <div class="row g-3" style="max-height: 400px; overflow-y: auto;">
                        <?php foreach($academic_subjects as $as): ?>
                        <div class="col-md-6">
                            <div class="form-check custom-option custom-option-basic">
                                <label class="form-check-label custom-option-content" for="as_<?= $as->SubjectID ?>">
                                    <input class="form-check-input check-subject" type="checkbox" name="subject_ids[]" value="<?= $as->SubjectID ?>" id="as_<?= $as->SubjectID ?>">
                                    <span class="custom-option-header">
                                        <span class="fw-bold">[<?= $as->SubjectCode ?>]</span>
                                        <small class="text-muted"><?= $as->SubjectName ?></small>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #15a362 !important;">นำเข้าวิชาที่เลือก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Manual -->
<div class="modal fade" id="modalAddSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold">เพิ่มวิชาเอง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formAddSubject">
                    <?= csrf_field() ?>
                    <input type="hidden" name="term" value="<?= $term ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold">รหัสวิชา (ถ้ามี)</label>
                        <input type="text" class="form-control" name="tsub_code" placeholder="เช่น กิจกรรม">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อวิชา <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tsub_name" placeholder="เช่น ลูกเสือ, ชุมนุม" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2" style="background: #15a362 !important;">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#btnSelectAll').on('click', function() {
        const allChecked = $('.check-subject:checked').length === $('.check-subject').length;
        $('.check-subject').prop('checked', !allChecked);
        $(this).text(allChecked ? 'เลือกทั้งหมด' : 'ยกเลิกการเลือก');
    });

    $('#formImportSubjects').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('กำลังนำเข้า...');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/import-subjects') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                // 🟢 Close modal first
                $('#modalImportSubject').modal('hide');

                if (res.status === 'success') {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'สำเร็จ', 
                        text: res.message, 
                        timer: 1500, 
                        showConfirmButton: false,
                        position: 'center',
                        zIndex: 10000 // Ensure it's on top
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: res.message,
                        zIndex: 10000
                    });
                    $btn.prop('disabled', false).text('นำเข้าวิชาที่เลือก');
                }
            }
        });
    });

    $('#formAddSubject').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('กำลังบันทึก...');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/save-subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                // 🟢 Close modal first
                $('#modalAddSubject').modal('hide');

                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ!',
                        timer: 1000,
                        showConfirmButton: false,
                        zIndex: 10000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: res.message,
                        zIndex: 10000
                    });
                    $btn.prop('disabled', false).text('บันทึกข้อมูล');
                }
            }
        });
    });

    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลวิชานี้จะถูกลบออกจากตารางสอน (ไม่กระทบระบบทะเบียน)",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger rounded-pill me-2', cancelButton: 'btn btn-label-secondary rounded-pill' },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/delete-subject') ?>',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    data: {
                        id: id
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            location.reload();
                        } else {
                            Swal.fire('ข้อผิดพลาด', res.message, 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
