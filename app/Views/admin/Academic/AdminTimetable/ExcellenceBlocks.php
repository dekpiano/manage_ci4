<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .excellence-card {
        transition: all 0.25s ease;
        border-left: 5px solid #15a362;
    }
    .excellence-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(21, 163, 98, 0.15) !important;
    }
    .swal2-container {
        z-index: 9999 !important;
    }
    .badge-grade {
        background-color: #e8fadf;
        color: #15a362;
        font-weight: 600;
        border: 1px solid rgba(21, 163, 98, 0.2);
    }
    .badge-day-MON { background-color: #fff8e1; color: #f57f17; }
    .badge-day-TUE { background-color: #fce4ec; color: #c2185b; }
    .badge-day-WED { background-color: #e8f5e9; color: #2e7d32; }
    .badge-day-THU { background-color: #fff3e0; color: #e65100; }
    .badge-day-FRI { background-color: #e1f5fe; color: #0277bd; }
    
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        background-color: #15a362 !important;
        color: #ffffff !important;
        border: none;
        border-radius: 4px;
        padding: 3px 8px;
    }
    body:not(.modal-open) .modal-backdrop { 
        display: none !important; 
        pointer-events: none !important; 
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-2 mb-1">
                <span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> คาบเรียนสู่ความเป็นเลิศ (Cross-Grade Blocks)
            </h4>
            <div class="text-muted small">
                กำหนดและล็อคช่วงเวลาเรียนพร้อมกันข้ามระดับชั้น สำหรับวิชาส่งเสริมความเป็นเลิศ/กิจกรรมวิชาการ (Hard Constraints)
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-outline-secondary rounded-pill">
                <i class="bx bx-arrow-back me-1"></i> ไปหน้าจัดตารางสอน
            </a>
            <button class="btn btn-primary rounded-pill" onclick="openBlockModal()" style="background-color: #15a362; border-color: #15a362;">
                <i class="bx bx-plus me-1"></i> สร้างบล็อกความเป็นเลิศ
            </button>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="alert alert-primary d-flex align-items-center mb-4 border-0 shadow-sm" style="background-color: #e8fadf; color: #0d683c;" role="alert">
        <i class="bx bx-info-circle fs-3 me-3"></i>
        <div>
            <strong>หลักการของบล็อกความเป็นเลิศ (Cross-Grade Synchronization):</strong> 
            เมื่อกำหนดบล็อกขึ้นมา เช่น <em>"ความเป็นเลิศ ม.ต้น วันพฤหัสบดี คาบ 7–8"</em> ระบบจะ <strong>Hard Lock ทุกห้องเรียนใน ม.1, ม.2, ม.3 พร้อมกันทันที</strong> 
            เพื่อไม่ให้มีวิชาปกติอื่นใดมาแทรก และจะดึงครูผู้สอนที่ระบุไว้เข้าสู่คาบนี้เป็นลำดับแรกสุดตามมาตรฐาน FET
        </div>
    </div>

    <!-- Blocks List -->
    <div class="row">
        <?php if(empty($blocks)): ?>
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm p-5">
                <div class="mb-3">
                    <i class="bx bx-calendar-star text-success" style="font-size: 5rem; color: #15a362 !important;"></i>
                </div>
                <h5 class="fw-bold text-dark">ยังไม่มีการกำหนดบล็อกความเป็นเลิศ</h5>
                <p class="text-muted">คลิกที่ปุ่ม "สร้างบล็อกความเป็นเลิศ" เพื่อเริ่มต้นกำหนดช่วงเวลาเรียนพร้อมกันข้ามระดับชั้น</p>
                <div class="mt-2">
                    <button class="btn btn-primary rounded-pill px-4" onclick="openBlockModal()" style="background-color: #15a362; border-color: #15a362;">
                        <i class="bx bx-plus me-1"></i> เริ่มสร้างบล็อกแรก
                    </button>
                </div>
            </div>
        </div>
        <?php else: ?>
            <?php foreach($blocks as $b): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm excellence-card border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-day-<?= esc($b->day) ?> px-3 py-2 rounded-pill fw-bold">
                                <i class="bx bx-calendar me-1"></i>
                                <?php 
                                    $dayMap = ['MON' => 'จันทร์', 'TUE' => 'อังคาร', 'WED' => 'พุธ', 'THU' => 'พฤหัสบดี', 'FRI' => 'ศุกร์'];
                                    echo $dayMap[$b->day] ?? $b->day;
                                ?>
                                (คาบ <?= esc($b->start_period) ?> - <?= esc($b->start_period + $b->period_count - 1) ?>)
                            </span>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick='editBlock(<?= json_encode($b) ?>)'>
                                        <i class="bx bx-edit-alt me-1 text-warning"></i> แก้ไข
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteBlock(<?= $b->block_id ?>)">
                                        <i class="bx bx-trash me-1"></i> ลบ
                                    </a>
                                </div>
                            </div>
                        </div>

                        <h5 class="card-title fw-bold text-dark mt-2 mb-1"><?= esc($b->block_name) ?></h5>
                        <div class="text-muted small mb-3">
                            <i class="bx bx-time-five me-1"></i> รวม <?= esc($b->period_count) ?> คาบต่อเนื่อง
                        </div>

                        <!-- Target Grades -->
                        <div class="mb-3">
                            <div class="text-muted small mb-1 fw-bold">ระดับชั้นที่เข้าร่วม (Synchronized):</div>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach(explode(',', $b->target_grades) as $grade): ?>
                                    <span class="badge badge-grade px-2 py-1 rounded">
                                        <i class="bx bx-check-circle me-1"></i><?= esc(trim($grade)) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Teachers -->
                        <div class="mt-auto pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    <i class="bx bx-user me-1 text-success" style="color: #15a362 !important;"></i>
                                    ครูผู้สอนที่ผูกไว้: <strong><?= esc($b->teacher_count) ?></strong> ท่าน
                                </span>
                                <?php if($b->teacher_count > 0): ?>
                                    <button class="btn btn-xs btn-outline-success rounded-pill px-2" type="button" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($b->teacher_names) ?>">
                                        ดูรายชื่อ
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Create / Edit Excellence Block -->
<div class="modal fade" id="modalExcellenceBlock" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color: #15a362;">
                <h5 class="modal-title text-white fw-bold" id="modalBlockTitle">
                    <i class="bx bx-star me-2"></i> สร้างบล็อกความเป็นเลิศข้ามระดับชั้น
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExcellenceBlock">
                <?= csrf_field() ?>
                <input type="hidden" name="block_id" id="block_id">
                
                <div class="modal-body p-4">
                    <!-- Step 1: Basic Info -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">
                            ชื่อบล็อกความเป็นเลิศ <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="block_name" id="block_name" 
                               placeholder="เช่น กิจกรรมสู่ความเป็นเลิศ ม.ต้น (ม.1 - ม.3)" required>
                    </div>

                    <!-- Step 2: Target Grades -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">
                            เลือกระดับชั้นเป้าหมายที่เรียนพร้อมกัน (Target Grades) <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            <?php 
                                $gradeOptions = ['ม.1', 'ม.2', 'ม.3', 'ม.4', 'ม.5', 'ม.6'];
                                foreach($gradeOptions as $g): 
                            ?>
                            <div class="form-check form-check-inline border rounded px-3 py-2">
                                <input class="form-check-input grade-checkbox" type="checkbox" name="target_grades[]" 
                                       id="grade_<?= $g ?>" value="<?= $g ?>">
                                <label class="form-check-label fw-semibold cursor-pointer" for="grade_<?= $g ?>">
                                    ชั้น <?= $g ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-text small text-muted">ทุกห้องเรียนในระดับชั้นที่เลือก จะถูกล็อคเวลาเรียนในคาบนี้ตรงกันทั้งหมด</div>
                    </div>

                    <!-- Step 3: Day and Periods -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">วันในสัปดาห์ <span class="text-danger">*</span></label>
                            <select class="form-select" name="day" id="day" required>
                                <option value="MON">วันจันทร์ (MON)</option>
                                <option value="TUE">วันอังคาร (TUE)</option>
                                <option value="WED">วันพุธ (WED)</option>
                                <option value="THU" selected>วันพฤหัสบดี (THU)</option>
                                <option value="FRI">วันศุกร์ (FRI)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">คาบเริ่มต้น <span class="text-danger">*</span></label>
                            <select class="form-select" name="start_period" id="start_period" required>
                                <?php for($p = 1; $p <= 10; $p++): ?>
                                    <option value="<?= $p ?>" <?= ($p == 7 ? 'selected' : '') ?>>คาบที่ <?= $p ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">จำนวนคาบต่อเนื่อง <span class="text-danger">*</span></label>
                            <select class="form-select" name="period_count" id="period_count" required>
                                <option value="1">1 คาบ</option>
                                <option value="2" selected>2 คาบคู่</option>
                                <option value="3">3 คาบ</option>
                                <option value="4">4 คาบ</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 4: Assigned Teachers -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">
                            ครูผู้สอนที่รับผิดชอบวิชาความเป็นเลิศในคาบนี้ (Multi-Teachers)
                        </label>
                        <select class="form-select select2-teachers" name="teacher_ids[]" id="teacher_ids" multiple="multiple">
                            <?php foreach($teachers as $t): ?>
                                <option value="<?= $t->pers_id ?>">
                                    <?= esc($t->pers_prefix . $t->pers_firstname . ' ' . $t->pers_lastname) ?> 
                                    <?= !empty($t->pers_department) ? '('.esc($t->pers_department).')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text small text-muted">ครูที่เลือกจะถูกกันเวลาในคาบนี้ไว้สำหรับวิชาความเป็นเลิศ (ห้ามจัดวิชาปกติชน)</div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSubmitBlock" style="background-color: #15a362; border-color: #15a362;">
                        <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Select2 for teachers
    if ($.fn.select2) {
        $('#teacher_ids').select2({
            dropdownParent: $('#modalExcellenceBlock'),
            placeholder: "ค้นหาและเลือกครูผู้สอน...",
            allowClear: true,
            width: '100%'
        });
    }

    // Modal backdrop safeguard
    $('#modalExcellenceBlock').on('hidden.bs.modal', function () {
        if ($('.modal.show').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
        }
    });

    // Submit block form
    $('#formExcellenceBlock').on('submit', function(e) {
        e.preventDefault();
        
        var checkedGrades = $('.grade-checkbox:checked').length;
        if (checkedGrades === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกระดับชั้น',
                text: 'ต้องเลือกระดับชั้นเป้าหมายอย่างน้อย 1 ระดับชั้น',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        var btn = $('#btnSubmitBlock');
        btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> กำลังบันทึก...');

        $.ajax({
            url: '<?= base_url("admin/academic/timetable/save-excellence-block") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูล');
                if (res.status === 'success') {
                    $('#modalExcellenceBlock').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message,
                        timer: 1200,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: res.message,
                        confirmButtonColor: '#15a362'
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูล');
                Swal.fire({
                    icon: 'error',
                    title: 'เชื่อมต่อล้มเหลว',
                    text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#15a362'
                });
            }
        });
    });
});

function openBlockModal() {
    $('#formExcellenceBlock')[0].reset();
    $('#block_id').val('');
    $('.grade-checkbox').prop('checked', false);
    if ($.fn.select2) {
        $('#teacher_ids').val([]).trigger('change');
    }
    $('#modalBlockTitle').html('<i class="bx bx-star me-2"></i> สร้างบล็อกความเป็นเลิศข้ามระดับชั้น');
    $('#modalExcellenceBlock').modal('show');
}

function editBlock(block) {
    $('#block_id').val(block.block_id);
    $('#block_name').val(block.block_name);
    $('#day').val(block.day);
    $('#start_period').val(block.start_period);
    $('#period_count').val(block.period_count);

    // Set target grades checkboxes
    $('.grade-checkbox').prop('checked', false);
    if (block.target_grades) {
        var grades = block.target_grades.split(',');
        grades.forEach(function(g) {
            $('#grade_' + g.trim()).prop('checked', true);
        });
    }

    // Set teachers
    if ($.fn.select2 && block.teacher_ids) {
        var tids = block.teacher_ids.split(',').map(function(item) { return item.trim(); });
        $('#teacher_ids').val(tids).trigger('change');
    } else if ($.fn.select2) {
        $('#teacher_ids').val([]).trigger('change');
    }

    $('#modalBlockTitle').html('<i class="bx bx-edit me-2"></i> แก้ไขบล็อกความเป็นเลิศข้ามระดับชั้น');
    $('#modalExcellenceBlock').modal('show');
}

function deleteBlock(id) {
    Swal.fire({
        title: 'ยืนยันการลบบล็อกความเป็นเลิศ?',
        text: 'คาบเวลาของระดับชั้นที่เคยผูกไว้จะถูกปลดล็อคให้เป็นคาบว่างปกติ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.post('<?= base_url("admin/academic/timetable/delete-excellence-block") ?>/' + id, {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            }, function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message });
                }
            }, 'json');
        }
    });
}
</script>
<?= $this->endSection() ?>

