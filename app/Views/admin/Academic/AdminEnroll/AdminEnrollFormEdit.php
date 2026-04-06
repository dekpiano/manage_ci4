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
.welcome-banner .subject-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.75rem;
}
.welcome-banner .subject-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.8rem;
    border-radius: 25px;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
}
.welcome-banner .teacher-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}
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

/* ===== Info Card ===== */
.info-card {
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.05) 0%, rgba(21, 163, 98, 0.1) 100%);
    border: 1px solid rgba(21, 163, 98, 0.2);
    border-radius: 10px;
    padding: 1rem;
}
.info-item { display: flex; align-items: center; margin-bottom: 0.5rem; }
.info-item:last-child { margin-bottom: 0; }
.info-item i { color: var(--primary-green); margin-right: 0.5rem; }
.info-item strong { margin-right: 0.5rem; color: #495057; }

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
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-edit-alt me-2"></i>แก้ไขรายชื่อการลงทะเบียน</h1>
                    <div class="subject-info">
                        <span class="subject-badge">
                            <i class="bx bx-book-alt me-1"></i><?= (isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '') ?>
                        </span>
                        <span class="teacher-text"><?= (isset($Register[0]->SubjectName) ? esc($Register[0]->SubjectName) : '') ?></span>
                        <span class="subject-badge">
                            <i class="bx bx-calendar me-1"></i><?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>
                        </span>
                    </div>
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
            <h5><i class="bx bx-user-plus me-2"></i>เพิ่ม/แก้ไข นักเรียนในรายวิชา</h5>
        </div>
        <div class="card-body pt-4">
            <form id="FormEnrollUpdate" class="needs-validation" method="post" novalidate>
                <?= csrf_field() ?>

                <!-- Step 1: Subject Info -->
                <div class="section-header">
                    <span class="number-badge">1</span>
                    <h6>ข้อมูลรายวิชา</h6>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-calendar text-success me-1"></i>ปีการศึกษา</label>
                        <input type="text" class="form-control" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>" readonly>
                        <input type="hidden" name="SubjectYearregisupdate" id="SubjectYearregisupdate" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-book text-success me-1"></i>วิชาเรียน</label>
                        <input type="text" class="form-control" value="<?= (isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '').' '.(isset($Register[0]->SubjectName) ? esc($Register[0]->SubjectName) : '') ?>" readonly>
                        <input type="hidden" name="subjectregisupdate" id="subjectregisupdate" value="<?= isset($Register[0]->SubjectID) ? esc($Register[0]->SubjectID) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-user text-success me-1"></i>ครูผู้สอน</label>
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

                <hr class="my-4">

                <!-- Step 2: Students -->
                <div class="section-header">
                    <span class="number-badge">2</span>
                    <h6>เลือกนักเรียนเพิ่มเติม</h6>
                </div>
                <div class="row g-3 mb-4">
                     <div class="col-md-4">
                        <label for="Room" class="form-label fw-semibold"><i class="bx bx-door-open text-success me-1"></i>กรองตามห้องเรียน</label>
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
                            <span class="title right-title"><i class="bx bx-user-check"></i>นักเรียนที่เพิ่มเข้าใหม่</span>
                            <button type="button" id="multiselect_leftAll" class="btn-remove-all">
                                <i class="bx bx-chevrons-left me-1"></i>เอาออกทั้งหมด
                            </button>
                        </div>
                        <input type="text" id="search_right" class="form-control mb-2" placeholder="🔍 ค้นหานักเรียน...">
                        <select name="to[]" id="multiselect_to" class="form-control transfer-select border-success bg-white" required multiple="multiple">
                            <!-- Selected Items -->
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn-save">
                        <i class="bx bx-save"></i>บันทึกการเพิ่มรายชื่อ
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
        confirmButtonColor: "#15a362",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "<i class='bx bx-check me-1'></i>ใช่, เปลี่ยนเลย!",
        cancelButtonText: "<i class='bx bx-x me-1'></i>ยกเลิก"
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
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังเปลี่ยนครูผู้สอน...',
                        html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                success: function(response) {
                    csrfInput.val(response.csrf_hash);
                    Swal.fire({
                        icon: 'success',
                        title: 'เปลี่ยนครูผู้สอนใหม่แล้ว!',
                        confirmButtonColor: '#15a362',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.reload(); 
                    }, 2000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเปลี่ยนครูผู้สอนได้',
                        confirmButtonColor: '#dc3545'
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
        html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false
    });

    $.post("<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSelect') ?>", { 
        KeyRoom: val,
        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
    }, function(data, status) {
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
                html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        },
        success: function(data) {
            let tableHtml = '<div class="table-responsive" style="max-height: 250px; text-align: left; font-size: 0.9rem;">';
            tableHtml += '<table class="table table-sm table-bordered mb-0">';

            if (data.inserted && data.inserted.length > 0) {
                tableHtml += '<thead class="table-success"><tr><th><i class="bx bx-check-circle me-1"></i>เพิ่มรายชื่อสำเร็จ (' + data.inserted.length + ' คน)</th></tr></thead><tbody>';
                data.inserted.forEach(function(name) {
                    tableHtml += '<tr><td>' + name + '</td></tr>';
                });
                tableHtml += '</tbody>';
            }

            if (data.duplicates && data.duplicates.length > 0) {
                tableHtml += '<thead class="table-warning"><tr><th class="pt-3"><i class="bx bx-error me-1"></i>รายชื่อที่ลงทะเบียนแล้ว (' + data.duplicates.length + ' คน)</th></tr></thead><tbody>';
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
                showConfirmButton: true,
                confirmButtonColor: '#15a362'
            }).then(() => {
                window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll') ?>';
            });
        },
        error: function(jqXHR) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถส่งข้อมูลไปยังเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#dc3545'
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
