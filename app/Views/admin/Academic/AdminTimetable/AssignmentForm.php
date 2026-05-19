<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
.form-card {
    border: none;
    border-radius: 1.25rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.form-header {
    background: #fff;
    border-bottom: 1px solid #f0f2f4;
    padding: 2rem;
    border-radius: 1.25rem 1.25rem 0 0;
}
.form-body {
    padding: 2rem;
}
.step-badge {
    width: 32px;
    height: 32px;
    background: #e0f5eb;
    color: #15a362;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    margin-right: 12px;
}
.select2-container--bootstrap-5 .select2-selection {
    border: 1px solid #d9dee3 !important;
    border-radius: 0.75rem !important;
    min-height: 50px !important;
    display: flex !important;
    align-items: center !important;
    transition: all 0.2s ease-in-out !important;
}
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: #15a362 !important;
    box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important;
}
.split-box {
    background: #fff9f0;
    border: 1px solid #ffe8cc;
    transition: all 0.3s ease;
}
.split-box:hover {
    border-color: #f39c12;
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.08);
}
/* Ensure SweetAlert2 is always on top */
.swal2-container {
    z-index: 9999 !important;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/academic/timetable') ?>">ระบบจัดตารางสอน</a></li>
                    <li class="breadcrumb-item active"><?= isset($assignment) ? 'แก้ไขการมอบหมาย' : 'มอบหมายงานสอนใหม่' ?></li>
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <a href="<?= base_url('admin/academic/timetable') ?>" class="btn btn-icon btn-label-secondary rounded-circle me-3">
                    <i class="bx bx-chevron-left fs-4"></i>
                </a>
                <h4 class="fw-bold mb-0"><?= isset($assignment) ? 'แก้ไขการมอบหมายงานสอน' : 'มอบหมายงานสอนใหม่' ?></h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="form-header">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-label-success p-2 rounded-3 me-3">
                            <i class="bx bx-user-plus fs-2"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold text-dark"><?= isset($assignment) ? 'แก้ไขรายละเอียด' : 'รายละเอียดการมอบหมายงานสอน' ?></h5>
                            <p class="mb-0 text-muted">แก้ไขข้อมูลครูผู้สอน รายวิชา และคาบเรียนให้ถูกต้อง</p>
                        </div>
                    </div>
                </div>
                <div class="form-body bg-white">
                    <form id="formAddAssignment" data-id="<?= isset($assignment) ? $assignment->assign_id : '' ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="term" value="<?= $term ?>">
                        <input type="hidden" name="year" value="<?= $year ?>">

                        <!-- Step 1: Subject -->
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label text-dark fw-bold fs-6 mb-0 d-flex align-items-center">
                                    <span class="step-badge">1</span> รายวิชาที่สอน <span class="text-danger ms-1">*</span>
                                </label>
                                <button type="button" class="btn btn-sm btn-label-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalQuickAddSubject">
                                    <i class="bx bx-plus me-1"></i> เพิ่มวิชาใหม่
                                </button>
                            </div>
                            <select class="form-select select2" name="subject_id" id="subject_id" required data-placeholder="ค้นหาด้วยรหัสวิชาหรือชื่อวิชา...">
                                <option value=""></option>
                                <?php foreach($subjects as $s): ?>
                                <option value="<?= $s->tsub_id ?>" <?= (isset($assignment) && $assignment->subject_id == $s->tsub_id) ? 'selected' : '' ?>><?= ($s->tsub_code ? '['.$s->tsub_code.'] ' : '').$s->tsub_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Step 2: Teachers -->
                        <div class="mb-5">
                            <label class="form-label text-dark fw-bold fs-6 mb-3 d-flex align-items-center">
                                <span class="step-badge">2</span> คัดเลือกครูผู้สอน <span class="text-danger ms-1">*</span>
                            </label>
                            <select class="form-select select2" name="teacher_id[]" multiple required data-placeholder="ค้นหาและเลือกครูผู้สอน (สอนร่วมกันได้)...">
                                <?php 
                                    $selected_teachers = isset($assignment) ? explode(',', $assignment->teacher_id) : [];
                                    foreach($teachers as $t): 
                                ?>
                                <option value="<?= $t->pers_id ?>" <?= in_array($t->pers_id, $selected_teachers) ? 'selected' : '' ?>><?= $t->pers_prefix.$t->pers_firstname.' '.$t->pers_lastname ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-muted mt-2">
                                <i class="bx bx-info-circle me-1"></i> สามารถเลือกครูได้หลายท่าน หากเป็นวิชาที่สอนร่วมกัน (Co-teaching)
                            </div>
                        </div>

                        <!-- Step 3: Class and Hours -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-bold fs-6 mb-3 d-flex align-items-center">
                                    <span class="step-badge">3</span> ห้องเรียน (เลือกได้หลายห้อง) <span class="text-danger ms-1">*</span>
                                </label>
                                <select class="form-select select2" name="class_name[]" multiple required data-placeholder="ค้นหาและเลือกห้องเรียน...">
                                    <?php 
                                        $selected_classes = isset($assignment) ? $assignment->class_names : [];
                                        for($grade=1; $grade<=6; $grade++): 
                                    ?>
                                        <optgroup label="มัธยมศึกษาปีที่ <?= $grade ?>">
                                            <?php for($room=1; $room<=6; $room++): ?>
                                                <option value="ม.<?= $grade ?>/<?= $room ?>" <?= in_array("ม.$grade/$room", $selected_classes) ? 'selected' : '' ?>>ม.<?= $grade ?>/<?= $room ?></option>
                                            <?php endfor; ?>
                                        </optgroup>
                                    <?php endfor; ?>
                                </select>
                                <div class="form-text mt-2"><i class="bx bx-info-circle me-1"></i> เลือกทุกห้องที่ครูท่านนี้สอนในวิชาดังกล่าวครับ</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-bold fs-6 mb-3 d-flex align-items-center">
                                    <span class="step-badge">4</span> จำนวนคาบต่อสัปดาห์ <span class="text-danger ms-1">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control text-center fw-bold" name="hours_per_week" id="hours_per_week" value="<?= isset($assignment) ? $assignment->hours_per_week : '2' ?>" min="1" max="10" required style="height: 50px; border-radius: 0.75rem 0 0 0.75rem;">
                                    <span class="input-group-text bg-light text-muted fw-bold px-3" style="border-radius: 0 0.75rem 0.75rem 0;">คาบ</span>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Split Pattern -->
                        <div class="mb-5">
                            <div class="split-box p-4 rounded-4">
                                <label class="form-label text-dark fw-bold fs-6 mb-3 d-flex align-items-center">
                                    <span class="step-badge" style="background: #f39c12; color: #fff;">5</span> รูปแบบการแบ่งคาบเรียน
                                </label>
                                <select class="form-select select2-no-search" name="period_split" id="period_split" required>
                                    <!-- Options populated by JS -->
                                </select>
                                <div class="form-text mt-3">
                                    <i class="bx bxs-bulb text-warning me-1"></i> รูปแบบนี้จะถูกนำไปใช้ในอัลกอริทึมจัดตารางสอนอัตโนมัติ เพื่อกระจายคาบเรียนให้เหมาะสม
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Preferred Time (Constraint) -->
                        <div class="mb-5">
                            <label class="form-label text-dark fw-bold fs-6 mb-3 d-flex align-items-center">
                                <span class="step-badge" style="background: #696cff; color: #fff;">6</span> ช่วงเวลาที่ต้องการจัดสอน (ทางเลือก)
                            </label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="preferred_time" id="pref_none" value="NONE" <?= (!isset($assignment) || $assignment->preferred_time == 'NONE') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-secondary w-100 py-3 rounded-4" for="pref_none">
                                        <i class="bx bx-infinite d-block mb-1 fs-3"></i>
                                        <span>ตามความเหมาะสม</span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="preferred_time" id="pref_morning" value="MORNING" <?= (isset($assignment) && $assignment->preferred_time == 'MORNING') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary w-100 py-3 rounded-4" for="pref_morning">
                                        <i class="bx bx-sun d-block mb-1 fs-3"></i>
                                        <span>ช่วงเช้าเท่านั้น</span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="preferred_time" id="pref_afternoon" value="AFTERNOON" <?= (isset($assignment) && $assignment->preferred_time == 'AFTERNOON') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-warning w-100 py-3 rounded-4" for="pref_afternoon">
                                        <i class="bx bx-cloud-light-rain d-block mb-1 fs-3"></i>
                                        <span>ช่วงบ่ายเท่านั้น</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-text mt-3">
                                <i class="bx bx-help-circle me-1"></i> หากเลือกช่วงเช้า ระบบจะพยายามจัดวิชานี้ให้อยู่ในช่วงก่อนพักเที่ยง (และในทางกลับกัน)
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="<?= base_url('admin/academic/timetable') ?>" class="btn btn-label-secondary rounded-pill px-5 py-2">
                                <i class="bx bx-x me-1"></i> ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm" style="background: #15a362 !important; border: none;">
                                <i class="bx bx-save me-1"></i> บันทึกข้อมูลการมอบหมาย
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quick Add Subject -->
<div class="modal fade" id="modalQuickAddSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bx bx-book-add me-1 text-primary"></i> เพิ่มวิชาใหม่แบบเร่งด่วน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formQuickAddSubject">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">รหัสวิชา</label>
                        <input type="text" class="form-control" name="SubjectCode" placeholder="เช่น กิจกรรม, ส31101" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อวิชา</label>
                        <input type="text" class="form-control" name="SubjectName" placeholder="เช่น ลูกเสือ, ชุมนุม" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">บันทึกวิชาใหม่</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// 🛡️ Global AJAX CSRF Sync
function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

$(document).ajaxSend(function(event, jqXHR, settings) {
    if (settings.type === 'POST') {
        let token = getCookie('csrf_cookie_name');
        if (token) {
            jqXHR.setRequestHeader('X-CSRF-TOKEN', token);
        }
    }
});

$(document).ajaxComplete(function(event, xhr, settings) {
    let token = getCookie('csrf_cookie_name');
    if (token) {
        // Update all hidden CSRF inputs on the page
        $('input[name="csrf_test_name"]').val(token);
    }
});

$(document).ready(function() {
    // 🟢 Initialize Smooth Select2
    $('.select2').each(function() {
        $(this).select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: $(this).data('placeholder'),
        });
    });

    // 🚀 Quick Add Subject Logic
    $('#formQuickAddSubject').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('กำลังบันทึก...');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/quick-add-subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    // Add to select2
                    const displayName = (res.data.tsub_code ? '[' + res.data.tsub_code + '] ' : '') + res.data.tsub_name;
                    const newOption = new Option(displayName, res.data.tsub_id, true, true);
                    $('#subject_id').append(newOption).trigger('change');
                    
                    $('#modalQuickAddSubject').modal('hide');
                    $('#formQuickAddSubject')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มวิชาสำเร็จ!',
                        timer: 1000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', res.message, 'error');
                }
                $btn.prop('disabled', false).text('บันทึกวิชาใหม่');
            }
        });
    });

    $('.select2-no-search').select2({
        theme: 'bootstrap-5',
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    // 🚀 Suggested Teachers Logic
    const $teacherSelect = $('select[name="teacher_id[]"]');
    const originalTeachers = $teacherSelect.html(); // Save original list

    $('#subject_id').on('change', function() {
        const subjectId = $(this).val();
        const currentSelected = $teacherSelect.val(); // Capture current selection

        if (!subjectId) {
            $teacherSelect.html(originalTeachers).val(currentSelected).trigger('change');
            return;
        }

        $.get('<?= base_url('admin/academic/timetable/get-suggested-teachers') ?>', { subject_id: subjectId }, function(suggested) {
            if (suggested && suggested.length > 0) {
                const suggestedIds = suggested.map(s => s.pers_id);
                const $options = $(originalTeachers);
                
                // Separate suggested and non-suggested
                const suggestedOpts = [];
                const otherOpts = [];

                $options.each(function() {
                    if ($(this).val()) {
                        let text = $(this).text().replace('[แนะนำ] ', ''); // Clean existing tags
                        if (suggestedIds.includes($(this).val())) {
                            $(this).text(text); // Keep normal text but we'll move it up
                            suggestedOpts.push($(this));
                        } else {
                            $(this).text(text);
                            otherOpts.push($(this));
                        }
                    }
                });

                // Clear and Rebuild
                $teacherSelect.empty().append('<option value=""></option>');
                
                // Add suggested first
                if (suggestedOpts.length > 0) {
                    const $group = $('<optgroup label="ครูที่สอนวิชานี้ (ตามแผนการสอน)"></optgroup>');
                    suggestedOpts.forEach(opt => $group.append(opt));
                    $teacherSelect.append($group);
                }

                // Add others
                const $otherGroup = $('<optgroup label="ครูท่านอื่นๆ"></optgroup>');
                otherOpts.forEach(opt => $otherGroup.append(opt));
                $teacherSelect.append($otherGroup);

                // Restore selection and refresh
                $teacherSelect.val(suggestedIds).trigger('change');

                // Visual Feedback
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'เลือกครูผู้สอนให้โดยอัตโนมัติ ' + suggested.length + ' ท่าน',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                $teacherSelect.html(originalTeachers).val(currentSelected).trigger('change');
            }
        });
    });

    // 🚀 Subject Details Fetch & Auto Hours Calculation
    function fetchSubjectInfo(subjectId, autoSetHours = true) {
        if (!subjectId) {
            $('#subject-detail-badge').remove();
            return;
        }

        $.get('<?= base_url('admin/academic/timetable/get-subject-info') ?>', { subject_id: subjectId }, function(info) {
            if (info && info.status === 'success') {
                if (info.SubjectUnit !== null || info.SubjectHour !== null) {
                    if (autoSetHours) {
                        $('#hours_per_week').val(info.suggested_hours).trigger('change');
                    }
                    
                    let detailHtml = '<div class="alert alert-light-success d-flex align-items-center p-2 mb-0" style="border: 1px dashed #15a362; border-radius: 0.5rem; background-color: #f4fbf7;">' +
                        '<i class="bx bx-info-circle text-success me-2 fs-5"></i>' +
                        '<div>' +
                        '<span class="badge bg-label-success me-2">ข้อมูลวิชา</span>' +
                        '<small class="text-dark fw-semibold">' +
                        'หน่วยกิต: <strong class="text-success">' + (info.SubjectUnit || '-') + '</strong> | ' +
                        'จำนวนชั่วโมง: <strong class="text-success">' + (info.SubjectHour || '-') + ' ชม.</strong> | ' +
                        'คำนวณคาบต่อสัปดาห์อัตโนมัติ: <strong class="text-success">' + info.suggested_hours + ' คาบ</strong>' +
                        '</small>' +
                        '</div>' +
                        '</div>';
                    
                    $('#subject-detail-badge').remove();
                    $('<div id="subject-detail-badge" class="mt-2"></div>').html(detailHtml).insertAfter($('#subject_id').next('.select2-container'));
                } else {
                    $('#subject-detail-badge').remove();
                }
            }
        });
    }

    // Trigger on change
    $('#subject_id').on('change', function() {
        const subjectId = $(this).val();
        fetchSubjectInfo(subjectId, true);
    });

    // Trigger on load (for edit mode)
    const initialSubjectId = $('#subject_id').val();
    if (initialSubjectId) {
        fetchSubjectInfo(initialSubjectId, false); // don't overwrite user selection on load
    }

    // 🚀 Dynamic Period Split Logic
    function updateSplitOptions() {
        const hours = parseInt($('#hours_per_week').val());
        const $split = $('#period_split');
        $split.empty();

        let options = [];
        if (hours === 1) {
            options = [{ val: '1', text: '1 คาบ (1 วัน)' }];
        } else if (hours === 2) {
            options = [
                { val: '2', text: '2 คาบ (รวดเดียว)' },
                { val: '1,1', text: '1 + 1 คาบ (แยก 2 วัน)' }
            ];
        } else if (hours === 3) {
            options = [
                { val: '2,1', text: '2 + 1 คาบ (แยก 2 วัน)' },
                { val: '3', text: '3 คาบ (รวดเดียว)' },
                { val: '1,1,1', text: '1 + 1 + 1 คาบ (แยก 3 วัน)' }
            ];
        } else if (hours === 4) {
            options = [
                { val: '2,2', text: '2 + 2 คาบ (แยก 2 วัน)' },
                { val: '4', text: '4 คาบ (รวดเดียว)' },
                { val: '2,1,1', text: '2 + 1 + 1 คาบ (แยก 3 วัน)' },
                { val: '1,1,1,1', text: '1 + 1 + 1 + 1 คาบ (แยก 4 วัน)' }
            ];
        } else if (hours === 5) {
            options = [
                { val: '2,2,1', text: '2 + 2 + 1 คาบ (แยก 3 วัน)' },
                { val: '3,2', text: '3 + 2 คาบ (แยก 2 วัน)' },
                { val: '2,1,1,1', text: '2 + 1 + 1 + 1 คาบ (แยก 4 วัน)' },
                { val: '1,1,1,1,1', text: '1 + 1 + 1 + 1 + 1 คาบ (แยก 5 วัน)' }
            ];
        } else if (hours === 6) {
            options = [
                { val: '2,2,2', text: '2 + 2 + 2 คาบ (แยก 3 วัน)' },
                { val: '3,3', text: '3 + 3 คาบ (แยก 2 วัน)' },
                { val: '2,2,1,1', text: '2 + 2 + 1 + 1 คาบ (แยก 4 วัน)' },
                { val: '6', text: '6 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 7) {
            options = [
                { val: '2,2,2,1', text: '2 + 2 + 2 + 1 คาบ (แยก 4 วัน)' },
                { val: '3,2,2', text: '3 + 2 + 2 คาบ (แยก 3 วัน)' },
                { val: '7', text: '7 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 8) {
            options = [
                { val: '2,2,2,2', text: '2 + 2 + 2 + 2 คาบ (แยก 4 วัน)' },
                { val: '3,3,2', text: '3 + 3 + 2 คาบ (แยก 3 วัน)' },
                { val: '8', text: '8 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 9) {
            options = [
                { val: '3,3,3', text: '3 + 3 + 3 คาบ (แยก 3 วัน)' },
                { val: '2,2,2,2,1', text: '2 + 2 + 2 + 2 + 1 คาบ (แยก 5 วัน)' },
                { val: '9', text: '9 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 10) {
            options = [
                { val: '2,2,2,2,2', text: '2 + 2 + 2 + 2 + 2 คาบ (แยก 5 วัน)' },
                { val: '3,3,2,2', text: '3 + 3 + 2 + 2 คาบ (แยก 4 วัน)' },
                { val: '10', text: '10 คาบ (รวดเดียว)' }
            ];
        } else {
            options = [{ val: hours.toString(), text: hours + ' คาบ (รวดเดียว)' }];
        }

        options.forEach(opt => {
            $split.append(new Option(opt.text, opt.val));
        });
        $split.trigger('change');
    }

    $('#hours_per_week').on('input change', updateSplitOptions);
    updateSplitOptions();

    // Form Submit
    $('#formAddAssignment').on('submit', function(e) {
        e.preventDefault();
        const assignId = $(this).data('id');
        const url = assignId ? '<?= base_url('admin/academic/timetable/update-assignment/') ?>' + assignId : '<?= base_url('admin/academic/timetable/save-assignment') ?>';
        
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'center'
                    }).then(() => {
                        window.location.href = '<?= base_url('admin/academic/timetable') ?>';
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', res.message, 'error');
                    $btn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> ' + (assignId ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูลการมอบหมาย'));
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
