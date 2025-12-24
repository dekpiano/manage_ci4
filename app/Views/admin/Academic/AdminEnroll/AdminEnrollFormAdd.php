<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Green Theme #15a362 ===== */
:root {
    --primary-green: #15a362;
    --primary-green-dark: #128a52;
    --primary-green-light: #1bc676;
    --gradient-green: linear-gradient(135deg, #15a362 0%, #1bc676 50%, #20c997 100%);
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: var(--gradient-green);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(21, 163, 98, 0.25);
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}
.welcome-banner .content { position: relative; z-index: 1; }
.welcome-banner h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
.welcome-banner p { color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin: 0; }
.welcome-banner .icon-wrapper {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.12);
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}
.btn-back {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
}

/* ===== Form Card ===== */
.form-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.form-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.25rem;
}
.form-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.form-card .card-header h5 i { color: var(--primary-green); }

/* ===== Section Header ===== */
.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid rgba(21, 163, 98, 0.2);
}
.section-header .number-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: var(--gradient-green);
    color: #fff;
    font-weight: 700;
    font-size: 0.85rem;
    margin-right: 0.75rem;
}
.section-header h6 { font-weight: 600; margin: 0; color: #212529; }

/* ===== Info Card ===== */
.info-card {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.05) 0%, rgba(21, 163, 98, 0.1) 100%);
    border: 1px solid rgba(21, 163, 98, 0.2);
    border-radius: 10px;
    padding: 1rem;
}

/* ===== Transfer List ===== */
.transfer-list-container {
    display: flex;
    align-items: stretch;
    gap: 1rem;
}
.transfer-box {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.transfer-box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}
.transfer-box-header .title {
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}
.transfer-box-header .title i { margin-right: 0.5rem; }
.transfer-box-header .title.left-title { color: #495057; }
.transfer-box-header .title.right-title { color: var(--primary-green); }

.transfer-controls {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    justify-content: center;
    padding: 0 0.5rem;
}

.transfer-select {
    height: 320px !important;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}
.transfer-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}
.transfer-select.border-success {
    border-color: var(--primary-green);
}
.transfer-select option {
    padding: 0.5rem 0.75rem;
}
.transfer-select option:checked {
    background: linear-gradient(135deg, #15a362 0%, #1bc676 100%);
    color: #fff;
}

/* ===== Transfer Buttons ===== */
.btn-transfer-control {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}
.btn-transfer-right {
    background: var(--gradient-green);
    border: none;
    color: #fff;
}
.btn-transfer-right:hover {
    transform: translateX(3px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.4);
    color: #fff;
}
.btn-transfer-left {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    border: none;
    color: #495057;
}
.btn-transfer-left:hover {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
    transform: translateX(-3px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

/* ===== Bulk Buttons ===== */
.btn-select-all {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.2) 100%);
    border: 1px solid rgba(21, 163, 98, 0.3);
    color: var(--primary-green);
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-select-all:hover {
    background: var(--gradient-green);
    color: #fff;
    border-color: transparent;
}
.btn-remove-all {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.2) 100%);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #dc3545;
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-remove-all:hover {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
    border-color: transparent;
}

/* ===== Order Buttons ===== */
.btn-order {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    border: none;
    color: #495057;
    transition: all 0.3s ease;
}
.btn-order:hover {
    background: var(--gradient-green);
    color: #fff;
}

/* ===== Submit Button ===== */
.btn-save {
    background: var(--gradient-green);
    border: none;
    color: #fff;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}
.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(21, 163, 98, 0.4);
    color: #fff;
}
.btn-save i { margin-right: 0.5rem; }

/* ===== Form Controls ===== */
.form-control:focus, .form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}

/* ===== Select2 Styling ===== */
.select2-container--bootstrap-5 .select2-selection {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    min-height: 42px;
}
.select2-container--bootstrap-5 .select2-selection--single:focus,
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-plus-circle me-2"></i>เพิ่มรายชื่อลงทะเบียน</h1>
                    <p>ลงทะเบียนนักเรียนเข้าเรียนในรายวิชาต่างๆ ตามปีการศึกษาที่เลือก</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <a class="btn-back" href="<?= site_url('Admin/Acade/Registration/Enroll') ?>">
                        <i class="bx bx-arrow-back me-1"></i>ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-user-plus"></i>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card shadow-sm">
        <div class="card-header">
            <h5><i class="bx bx-file me-2"></i>แบบฟอร์มลงทะเบียนเรียน</h5>
        </div>
        <div class="card-body pt-4">
            <form id="FormEnroll" method="post" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <!-- Step 1: Subject Info -->
                <div class="section-header">
                    <span class="number-badge">1</span>
                    <h6>กำหนดข้อมูลรายวิชา</h6>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="SelectYearRegister" class="form-label fw-semibold"><i class="bx bx-calendar text-success me-1"></i>ปีการศึกษา</label>
                        <select name="SelectYearRegister" id="SelectYearRegister" class="form-select" required>
                            <option value="">เลือกปีการศึกษา</option>
                            <?php $d = date('Y')+543; 
                                for ($i=$d-2; $i<=$d; $i++):
                                    for($j=1; $j<=4; $j++):
                                ?>
                            <?php 
                            $currentSegment = (service('request')->uri->getSegment(6) ?? '').'/'.(service('request')->uri->getSegment(7) ?? '');
                            ?>
                            <option <?= $currentSegment == $j.'/'.$i ? "selected" : ""?> value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                            <?php endfor; endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subjectregis" class="form-label fw-semibold"><i class="bx bx-book text-success me-1"></i>วิชาเรียน</label>
                        <select name="subjectregis" id="subjectregis" class="form-select" required>
                            <option value="">เลือกวิชาเรียน</option>
                            <?php foreach ($subject as $key => $v_subject): ?>
                            <option value="<?= isset($v_subject->SubjectID) ? esc($v_subject->SubjectID) : '' ?>">
                                <?= (isset($v_subject->SubjectCode) ? esc($v_subject->SubjectCode) : '').' '.(isset($v_subject->SubjectName) ? esc($v_subject->SubjectName) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="teacherregis" class="form-label fw-semibold"><i class="bx bx-user text-success me-1"></i>ครูผู้สอน</label>
                        <select name="teacherregis" id="teacherregis" class="form-select" required>
                            <option value="">เลือกครูผู้สอน</option>
                            <?php foreach ($teacher as $key => $v_teacher): ?>
                            <option value="<?= isset($v_teacher->pers_id) ? esc($v_teacher->pers_id) : '' ?>">
                                <?= (isset($v_teacher->pers_prefix) ? esc($v_teacher->pers_prefix) : '').(isset($v_teacher->pers_firstname) ? esc($v_teacher->pers_firstname) : '').' '.(isset($v_teacher->pers_lastname) ? esc($v_teacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Step 2: Students -->
                <div class="section-header">
                    <span class="number-badge">2</span>
                    <h6>เลือกนักเรียน</h6>
                </div>
                <div class="row g-3 mb-4">
                     <div class="col-md-4">
                        <label for="Room" class="form-label fw-semibold"><i class="bx bx-door-open text-success me-1"></i>กรองตามห้องเรียน</label>
                        <select name="Room" id="Room" class="form-select select2-bs5">
                            <option value="">-- เลือกห้องเรียน --</option>
                            <?php 
                            if (!isset($classroom)) { $classroom = new App\Libraries\Classroom(); }
                            $ListRoom = $classroom->ListRoom();
                            foreach ($ListRoom as $key => $v_ListRoom): ?>
                            <option value="<?= esc($v_ListRoom) ?>">ม.<?= esc($v_ListRoom) ?></option>
                            <?php endforeach; ?>
                        </select>
                     </div>
                     <div class="col-md-8">
                        <div class="info-card h-100 d-flex align-items-center">
                            <i class="bx bx-info-circle bx-sm text-success me-3"></i>
                            <div>
                                <strong class="text-success">วิธีใช้งาน:</strong> เลือกรายชื่อจากกล่องด้านซ้าย แล้วกดปุ่ม <i class="bx bx-chevron-right"></i> เพื่อเพิ่มนักเรียนเข้าเรียน
                            </div>
                        </div>
                     </div>
                </div>

                <div class="transfer-list-container">
                    <!-- Left Box -->
                    <div class="transfer-box">
                        <div class="transfer-box-header">
                            <span class="title left-title"><i class="bx bx-list-ul"></i>รายชื่อนักเรียนในห้อง</span>
                            <button type="button" id="multiselect_rightAll" class="btn-select-all">
                                <i class="bx bx-chevrons-right me-1"></i>เลือกทั้งหมด
                            </button>
                        </div>
                        <input type="text" id="search_left" class="form-control mb-2" placeholder="🔍 ค้นหานักเรียน...">
                        <select name="from[]" id="multiselect" class="form-control transfer-select bg-white" multiple="multiple">
                            <!-- Options populated via AJAX -->
                        </select>
                    </div>

                    <!-- Controls -->
                    <div class="transfer-controls">
                        <button type="button" id="multiselect_rightSelected" class="btn-transfer-control btn-transfer-right" title="เลือก">
                            <i class="bx bx-chevron-right"></i>
                        </button>
                        <button type="button" id="multiselect_leftSelected" class="btn-transfer-control btn-transfer-left" title="เอาออก">
                            <i class="bx bx-chevron-left"></i>
                        </button>
                    </div>

                    <!-- Right Box -->
                    <div class="transfer-box">
                        <div class="transfer-box-header">
                            <span class="title right-title"><i class="bx bx-user-check"></i>นักเรียนที่จะลงทะเบียน</span>
                            <button type="button" id="multiselect_leftAll" class="btn-remove-all">
                                <i class="bx bx-chevrons-left me-1"></i>เอาออกทั้งหมด
                            </button>
                        </div>
                        <input type="text" id="search_right" class="form-control mb-2" placeholder="🔍 ค้นหานักเรียน...">
                        <select name="to[]" id="multiselect_to" class="form-control transfer-select border-success bg-white" required multiple="multiple">
                            <!-- Selected Items -->
                        </select>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" id="multiselect_move_up" class="btn btn-sm btn-order flex-grow-1"><i class="bx bx-up-arrow-alt me-1"></i>เลื่อนขึ้น</button>
                            <button type="button" id="multiselect_move_down" class="btn btn-sm btn-order flex-grow-1"><i class="bx bx-down-arrow-alt me-1"></i>เลื่อนลง</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn-save">
                        <i class="bx bx-save"></i>บันทึกข้อมูล
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
    $('#multiselect').multiselect({
        search: {
            left: '#search_left',
            right: '#search_right',
        },
        fireSearch: function(value) {
            return value.length > 1;
        }
    });

    $('#SelectYearRegister, #subjectregis, #teacherregis, #Room').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('body')
    });
});

$(document).on("change", "#subjectregis", function() {
    var IDsubjectregis = $(this).val();
    var IDSelectYearRegister = $('#SelectYearRegister').val();
    
    if(!IDsubjectregis) return;

    $.post('<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollChangeSubjectToTeacher') ?>',{
        Keysubjectregis:IDsubjectregis,
        KeySelectYearRegister:IDSelectYearRegister
    },function(data, status){
        if(data && data.teacherId) {
            $('#teacherregis').val(data.teacherId).trigger('change');
        }
    }, 'json');
});

$(document).on("change", "#SelectYearRegister", function() {
    if($(this).val()) {
        window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll/Add/') ?>' + $(this).val();
    }
});

$(document).on("change", "#Room", function() {
    $('#multiselect option').remove();
    var val = $(this).val();
    if(!val) return;

    Swal.fire({
        title: 'กำลังโหลดรายชื่อ...',
        html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false
    });

    $.post("<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSelect') ?>", { KeyRoom: val }, function(data, status) {
        Swal.close();
        $.each(data, function(index, value) {
            var studyLine = value.StudentStudyLine ? '[' + value.StudentStudyLine + '] ' : '';
            var trHTML = '<option value="' + value.StudentID + '">' + studyLine + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            $('#multiselect').append(trHTML);
        });
    }, 'json').fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถโหลดรายชื่อนักเรียนได้',
            confirmButtonColor: '#dc3545'
        });
    });
});

// Function to submit enrollment data
function submitEnrollment(formData) {
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollInsert') ?>',
        type: 'post',
        data: formData,
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังบันทึก...',
                html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการบันทึก',
                text: 'กรุณาลองใหม่อีกครั้ง',
                confirmButtonColor: '#dc3545',
                timer: 3000,
                showConfirmButton: false
            });
        },
        success: function(data) {
            if(data.status === 'success'){
                 Swal.fire({
                    title: "บันทึกสำเร็จ!",
                    text: data.message,
                    icon: "success",
                    confirmButtonColor: '#15a362',
                    confirmButtonText: 'ตกลง'
                 }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                 });
            } else if (data.status === 'info') {
                 Swal.fire({
                    title: "ไม่ได้บันทึก",
                    text: data.message,
                    icon: "info",
                    confirmButtonColor: '#17a2b8'
                 });
            } else {
                Swal.fire({
                    title: "ไม่สามารถบันทึกได้",
                    text: data.message,
                    icon: "error",
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    });
}

$(document).on("submit", "#FormEnroll", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    // 1. Check for Repeat History
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminEnroll/checkRepeatHistory') ?>',
        type: 'post',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังตรวจสอบรายชื่อ...',
                html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        },
        success: function(response) {
            Swal.close();
            
            if (response.status === 'found') {
                // Format List
                let listHtml = '<ul class="text-start mt-2 border p-2 rounded" style="max-height: 150px; overflow-y: auto; list-style-type: none; background: rgba(255, 193, 7, 0.1);">';
                let count = 0;
                for (const [name, year] of Object.entries(response.repeats)) {
                     listHtml += `<li class="text-danger py-1 border-bottom border-light"><i class="bx bx-user me-2"></i>${name} <small class="text-muted">(เคยเรียนปี ${year})</small></li>`;
                     count++;
                }
                listHtml += '</ul>';

                Swal.fire({
                    title: '<i class="bx bx-error-circle text-warning me-2"></i>พบนักเรียนซ้ำชั้น!',
                    html: `
                        <div class="text-start">
                            <p class="mb-2">มีนักเรียน <strong class="text-danger">${count} คน</strong> เคยลงทะเบียนเรียนรายวิชานี้มาแล้ว:</p>
                            ${listHtml}
                            <div class="alert alert-warning mt-3 mb-0" role="alert">
                                <i class='bx bx-info-circle me-1'></i> ต้องการให้นักเรียนกลุ่มนี้ <strong>เรียนซ้ำอยู่ชั้นเดิม</strong> (ลงทะเบียนใหม่) ใช่หรือไม่?
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107', 
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bx bx-check me-1"></i>ใช่, ยืนยันให้เรียนซ้ำ',
                    cancelButtonText: '<i class="bx bx-x me-1"></i>ไม่ใช่, ยกเลิก',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitEnrollment(formData);
                    }
                });
            } else {
                // No repeats found, proceed directly
                submitEnrollment(formData);
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถตรวจสอบข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                confirmButtonColor: '#dc3545'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
