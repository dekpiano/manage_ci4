<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Custom Styles for Transfer List */
    .transfer-list-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .transfer-box {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .transfer-controls {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .transfer-select {
        height: 300px !important;
        border-radius: 0.375rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">งานทะเบียน /</span> เพิ่มรายชื่อลงทะเบียน
        </h4>
        <a href="<?= site_url('Admin/Acade/Registration/Enroll') ?>" class="btn btn-label-secondary">
            <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <h5 class="card-header border-bottom">แบบฟอร์มลงทะเบียนเรียน</h5>
                <div class="card-body pt-4">
                    <form id="FormEnroll" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <!-- Step 1: Config -->
                        <h6 class="fw-normal">1. กำหนดข้อมูลรายวิชา</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="SelectYearRegister" class="form-label">ปีการศึกษา</label>
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
                                <label for="subjectregis" class="form-label">วิชาเรียน</label>
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
                                <label for="teacherregis" class="form-label">ครูผู้สอน</label>
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
                        <h6 class="fw-normal">2. เลือกนักเรียน</h6>
                        <div class="row g-3 mb-4">
                             <div class="col-md-4">
                                <label for="Room" class="form-label">กรองตามห้องเรียน</label>
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
                        </div>

                        <div class="transfer-list-container align-items-stretch">
                            <!-- Left Box -->
                            <div class="transfer-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0 fw-bold">รายชื่อนักเรียนในห้อง</label>
                                    <button type="button" id="multiselect_rightAll" class="btn btn-xs btn-outline-primary">
                                        <i class="bx bx-chevrons-right"></i> เลือกทั้งหมด
                                    </button>
                                </div>
                                <select name="from[]" id="multiselect" class="form-control transfer-select bg-white" multiple="multiple">
                                    <!-- Options populated via AJAX -->
                                </select>
                            </div>

                            <!-- Controls -->
                            <div class="transfer-controls justify-content-center">
                                <button type="button" id="multiselect_rightSelected" class="btn btn-primary btn-icon" title="เลือก">
                                    <i class="bx bx-chevron-right"></i>
                                </button>
                                <button type="button" id="multiselect_leftSelected" class="btn btn-label-secondary btn-icon" title="เอาออก">
                                    <i class="bx bx-chevron-left"></i>
                                </button>
                            </div>

                            <!-- Right Box -->
                            <div class="transfer-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0 fw-bold text-success">นักเรียนที่จะลงทะเบียน</label>
                                    <button type="button" id="multiselect_leftAll" class="btn btn-xs btn-outline-danger">
                                        <i class="bx bx-chevrons-left"></i> เอาออกทั้งหมด
                                    </button>
                                </div>
                                <select name="to[]" id="multiselect_to" class="form-control transfer-select border-success bg-white" required multiple="multiple">
                                    <!-- Selected Items -->
                                </select>
                                <div class="d-flex gap-2 mt-2">
                                    <button type="button" id="multiselect_move_up" class="btn btn-sm btn-label-secondary flex-grow-1"><i class="bx bx-up-arrow-alt"></i></button>
                                    <button type="button" id="multiselect_move_down" class="btn btn-sm btn-label-secondary flex-grow-1"><i class="bx bx-down-arrow-alt"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bx bx-save me-2"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#multiselect').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control mb-2" placeholder="ค้นหา..." />',
            right: '<input type="text" name="q" class="form-control mb-2" placeholder="ค้นหา..." />',
        },
        fireSearch: function(value) {
            return value.length > 1; // Start searching after 2 chars
        }
    });

    // Initial Select2 (Standard, not floating label compatible perfectly without custom CSS, but using form-floating on container mostly works or just standard select2)
    // Note: form-floating with Select2 requires specific CSS hacks. 
    // To be safe and simple: I used standard form-floating for Select Year/Subject/Teacher if they were standard selects.
    // BUT user uses Select2. Select2 hides original select.
    // So I will initialize Select2. Floating Label effect might be lost or look weird unless I use the 'select2-bootstrap-5-theme' properly.
    // Let's stick to standard Select2 with visual labels on top if Floating fails. 
    // The code below uses .select2-bs5 class which I assume is mapped to the theme.
    
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
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.post("<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSelect') ?>", { KeyRoom: val }, function(data, status) {
        Swal.close();
        $.each(data, function(index, value) {
            var studyLine = value.StudentStudyLine ? '[' + value.StudentStudyLine + '] ' : '';
            var trHTML = '<option value="' + value.StudentID + '">' + studyLine + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            $('#multiselect').append(trHTML);
        });
    }, 'json');
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
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการบันทึก กรุณาลองใหม่',
                showConfirmButton: false,
                timer: 3000
            })
        },
        success: function(data) {
              if(data.status === 'success'){
                   Swal.fire({
                    title: "บันทึกสำเร็จ!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: 'ตกลง'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll') ?>';
                    }
                  });
              } else if (data.status === 'info') {
                   Swal.fire({
                    title: "ไม่ได้บันทึก",
                    text: data.message,
                    icon: "info",
                  });
              } else {
                  Swal.fire({
                    title: "ไม่สามารถบันทึกได้",
                    text: data.message,
                    icon: "error",
                  });
              }
        }
    });
}

$(document).on("submit", "#FormEnroll", function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    // 1. Check for Repeat History (นักเรียนซ้ำชั้น)
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminEnroll/checkRepeatHistory') ?>',
        type: 'post',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังตรวจสอบรายชื่อ...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        },
        success: function(response) {
            Swal.close();
            
            if (response.status === 'found') {
                // Format List
                let listHtml = '<ul class="text-start mt-2 border p-2 rounded bg-light" style="max-height: 150px; overflow-y: auto; list-style-type: none;">';
                let count = 0;
                for (const [name, year] of Object.entries(response.repeats)) {
                     listHtml += `<li class="text-danger py-1 border-bottom border-light"><i class="bx bx-user me-2"></i>${name} <small class="text-muted">(เคยเรียนปี ${year})</small></li>`;
                     count++;
                }
                listHtml += '</ul>';

                Swal.fire({
                    title: '⚠️ พบนักเรียนซ้ำชั้น!',
                    html: `
                        <div class="text-start">
                            <p class="mb-2">มีนักเรียน <strong>${count} คน</strong> เคยลงทะเบียนเรียนรายวิชานี้มาแล้ว:</p>
                            ${listHtml}
                            <div class="alert alert-warning mt-3 mb-0" role="alert">
                                <i class='bx bx-info-circle me-1'></i> ต้องการให้นักเรียนกลุ่มนี้ <strong>เรียนซ้ำอยู่ชั้นเดิม</strong> (ลงทะเบียนใหม่) ใช่หรือไม่?
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107', 
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'ใช่, ยืนยันให้เรียนซ้ำชั้นเดิม',
                    cancelButtonText: 'ไม่ใช่, ยกเลิก',
                    customClass: {
                        confirmButton: 'btn btn-warning text-white me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false,
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
                text: 'ไม่สามารถตรวจสอบข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
