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
            <span class="text-muted fw-light">จัดการข้อมูล /</span> แก้ไขรายชื่อการลงทะเบียน
        </h4>
        <a href="<?= site_url('Admin/Acade/Registration/Enroll') ?>" class="btn btn-label-secondary">
            <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <h5 class="card-header border-bottom">เพิ่ม/แก้ไข นักเรียนในรายวิชา</h5>
                <div class="card-body pt-4">
                    <form id="FormEnrollUpdate" class="needs-validation" method="post" novalidate>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <!-- Step 1: Config -->
                        <h6 class="fw-normal">1. ข้อมูลรายวิชา</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">ปีการศึกษา</label>
                                <input type="text" class="form-control" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>" readonly>
                                <input type="hidden" name="SubjectYearregisupdate" id="SubjectYearregisupdate" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">วิชาเรียน</label>
                                <input type="text" class="form-control" value="<?= (isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '').' '.(isset($Register[0]->SubjectName) ? esc($Register[0]->SubjectName) : '') ?>" readonly>
                                <input type="hidden" name="subjectregisupdate" id="subjectregisupdate" value="<?= isset($Register[0]->SubjectID) ? esc($Register[0]->SubjectID) : '' ?>">
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating-custom"> 
                                    <label class="form-label">ครูผู้สอน</label>
                                    <select name="teacherregis" id="teacherregis" class="form-select" required>
                                        <option value="">เลือกครูผู้สอน</option>
                                        <?php foreach ($teacher as $key => $v_teacher): ?>
                                        <option <?= (isset($v_teacher->pers_id) && isset($Register[0]->TeacherID) && $v_teacher->pers_id == $Register[0]->TeacherID) ? "selected" : ""?>
                                            value="<?= isset($v_teacher->pers_id) ? esc($v_teacher->pers_id) : '' ?>">
                                            <?= (isset($v_teacher->pers_prefix) ? esc($v_teacher->pers_prefix) : '').(isset($v_teacher->pers_firstname) ? esc($v_teacher->pers_firstname) : '').' '.(isset($v_teacher->pers_lastname) ? esc($v_teacher->pers_lastname) : '') ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Step 2: Students -->
                        <h6 class="fw-normal">2. เลือกนักเรียนเพิ่มเติม</h6>
                        <div class="row g-3 mb-4">
                             <div class="col-md-4">
                                <label for="Room" class="form-label">กรองตามห้องเรียน</label>
                                <select name="RoomEdit" id="Room" class="form-select select2-bs5" required>
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
                                <div class="alert alert-info py-2 mb-0 mt-3 mt-md-0">
                                    <i class="bx bx-info-circle me-1"></i> เลือกรายชื่อจากด้านซ้าย เพื่อเพิ่มเข้าเรียน (ด้านขวา)
                                </div>
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
                                    <label class="form-label mb-0 fw-bold text-success">นักเรียนที่เพิ่มเข้าใหม่</label>
                                    <button type="button" id="multiselect_leftAll" class="btn btn-xs btn-outline-danger">
                                        <i class="bx bx-chevrons-left"></i> เอาออกทั้งหมด
                                    </button>
                                </div>
                                <select name="to[]" id="multiselect_to" class="form-control transfer-select border-success bg-white" required multiple="multiple">
                                    <!-- Selected Items -->
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bx bx-save me-2"></i> บันทึกการเพิ่มรายชื่อ
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
            return value.length > 1; 
        }
    });

    $('#teacherregis, #Room').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('body')
    });
});

$(document).on("change", "#teacherregis", function() {
    let teacherregis = $(this).val();
    let subjectregisupdate = $('#subjectregisupdate').val();
    let SubjectYear = $('#SubjectYearregisupdate').val();
    let csrfName = '<?= csrf_token() ?>';
    let csrfInput = $('input[name="' + csrfName + '"]');

    Swal.fire({
        title: "ยืนยันการเปลี่ยนแปลง",
        text: "คุณต้องการเปลี่ยนครูผู้สอนสำหรับวิชานี้ใช่หรือไม่?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ใช่, เปลี่ยนเลย!",
        cancelButtonText: "ยกเลิก"
    }).then((result) => {
        if (result.isConfirmed) {
            let postData = {
                KeyTeacher: teacherregis,
                KeySubjectYear: SubjectYear,
                KeySubjectID: subjectregisupdate
            };
            postData[csrfName] = csrfInput.val();

            $.ajax({
                url: "<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollChangeTeacher') ?>",
                type: 'POST',
                data: postData,
                dataType: 'json',
                success: function(response) {
                    csrfInput.val(response.csrf_hash);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'เปลี่ยนครูผู้สอนใหม่แล้ว!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                     // Reload to reflect changes if URL depends on teacher
                    setTimeout(function() {
                        window.location.reload(); 
                    }, 2000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเปลี่ยนครูผู้สอนได้'
                    });
                }
            });
        }
    });
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

$(document).on("submit", "#FormEnrollUpdate", function(e) {
    e.preventDefault();
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollUpdate') ?>',
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังบันทึกข้อมูล...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        },
        success: function(data) {
            let tableHtml = '<div class="table-responsive" style="max-height: 250px; text-align: left; font-size: 0.9rem;">';
            tableHtml += '<table class="table table-sm table-bordered">';

            if (data.inserted && data.inserted.length > 0) {
                tableHtml += '<thead class="table-success"><tr><th>เพิ่มรายชื่อสำเร็จ</th></tr></thead><tbody>';
                data.inserted.forEach(function(name) {
                    tableHtml += '<tr><td>' + name + '</td></tr>';
                });
                tableHtml += '</tbody>';
            }

            if (data.duplicates && data.duplicates.length > 0) {
                tableHtml += '<thead class="table-warning"><tr><th class="pt-3">รายชื่อที่ลงทะเบียนแล้ว (ซ้ำ)</th></tr></thead><tbody>';
                data.duplicates.forEach(function(name) {
                    tableHtml += '<tr><td>' + name + '</td></tr>';
                });
                tableHtml += '</tbody>';
            }

            tableHtml += '</table></div>';
            
            if (!data.inserted && !data.duplicates) tableHtml = '';

            Swal.fire({
                icon: data.status,
                title: data.title,
                html: tableHtml,
                showConfirmButton: true
            }).then(() => {
                window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll') ?>';
            });
        },
        error: function(jqXHR) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถส่งข้อมูลไปยังเซิร์ฟเวอร์ได้'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
