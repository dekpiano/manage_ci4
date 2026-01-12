<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Danger Theme ===== */
:root {
    --primary-red: #dc3545;
    --primary-red-dark: #c82333;
    --primary-red-light: #ff6b6b;
    --gradient-red: linear-gradient(135deg, #dc3545 0%, #ff6b6b 50%, #ff8787 100%);
}

/* ===== Warning Banner ===== */
.warning-banner {
    background: var(--gradient-red);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(220, 53, 69, 0.25);
}
.warning-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}
.warning-banner .content { position: relative; z-index: 1; }
.warning-banner h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
.warning-banner .subject-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.75rem;
}
.warning-banner .subject-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.8rem;
    border-radius: 25px;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
}
.warning-banner .teacher-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}
.warning-banner .icon-wrapper {
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
    border: 2px solid rgba(220, 53, 69, 0.3);
    overflow: hidden;
}
.form-card .card-header {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.1) 100%);
    border-bottom: 1px solid rgba(220, 53, 69, 0.2);
    padding: 1rem 1.25rem;
}
.form-card .card-header h5 { font-weight: 600; color: var(--primary-red); margin: 0; }

/* ===== Info Card ===== */
.info-card {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.1) 100%);
    border: 1px solid rgba(220, 53, 69, 0.2);
    border-radius: 10px;
    padding: 1rem;
}

/* ===== Warning Alert ===== */
.warning-alert {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.2) 100%);
    border: 1px solid rgba(255, 193, 7, 0.4);
    border-radius: 10px;
    padding: 1rem;
}
.warning-alert i { color: #ffc107; }

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
.transfer-box-header .title.right-title { color: var(--primary-red); }

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
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
}
.transfer-select.border-danger {
    border-color: var(--primary-red);
}
.transfer-select option {
    padding: 0.5rem 0.75rem;
}
.transfer-select option:checked {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
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
    background: var(--gradient-red);
    border: none;
    color: #fff;
}
.btn-transfer-right:hover {
    transform: translateX(3px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    color: #fff;
}
.btn-transfer-left {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    border: none;
    color: #495057;
}
.btn-transfer-left:hover {
    background: linear-gradient(135deg, #15a362 0%, #1bc676 100%);
    color: #fff;
    transform: translateX(-3px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.4);
}

/* ===== Bulk Buttons ===== */
.btn-remove-all {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.2) 100%);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: var(--primary-red);
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-remove-all:hover {
    background: var(--gradient-red);
    color: #fff;
    border-color: transparent;
}
.btn-cancel-all {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.2) 100%);
    border: 1px solid rgba(108, 117, 125, 0.3);
    color: #6c757d;
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-cancel-all:hover {
    background: linear-gradient(135deg, #6c757d 0%, #8e9aab 100%);
    color: #fff;
    border-color: transparent;
}

/* ===== Submit Button ===== */
.btn-delete {
    background: var(--gradient-red);
    border: none;
    color: #fff;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}
.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    color: #fff;
}
.btn-delete i { margin-right: 0.5rem; }

/* ===== Form Controls ===== */
.form-control:focus, .form-select:focus {
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
}

/* ===== Room Selection Premium Design ===== */
.room-selection-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px; /* Increased gap */
    padding-top: 10px;
}
.room-item {
    position: relative;
    cursor: pointer;
}
.room-item input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0; width: 0;
}
.room-label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px; /* Increased padding */
    background-color: #fff;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    color: #495057;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 90px;
    user-select: none;
    margin-bottom: 0;
}
.room-item:hover .room-label {
    border-color: rgba(23, 162, 184, 0.5);
    background-color: rgba(23, 162, 184, 0.05);
    transform: translateY(-3px);
}
.room-item input:checked + .room-label {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    border-color: #17a2b8;
    color: #fff;
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
}
.room-item input:checked + .room-label::before {
    content: '\eb31'; /* bx-check icon code for boxicons */
    font-family: 'boxicons' !important;
    margin-right: 6px;
    font-size: 1.2rem;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Warning Banner -->
    <div class="warning-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-user-minus me-2"></i>ถอนรายชื่อการลงทะเบียน</h1>
                    <div class="subject-info">
                        <span class="subject-badge">
                            <i class="bx bx-book-alt me-1"></i><?= (isset($SubjectInfo->SubjectCode) ? esc($SubjectInfo->SubjectCode) : '') ?>
                        </span>
                        <span class="teacher-text"><?= (isset($SubjectInfo->SubjectName) ? esc($SubjectInfo->SubjectName) : '') ?></span>
                        <span class="subject-badge">
                            <i class="bx bx-calendar me-1"></i><?= isset($SubjectInfo->SubjectYear) ? esc($SubjectInfo->SubjectYear) : '' ?>
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
            <i class="bx bxs-user-x"></i>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card shadow-sm">
        <div class="card-header">
            <h5><i class="bx bx-trash me-2"></i>ถอนนักเรียนออกจากรายวิชา</h5>
        </div>
        <div class="card-body pt-4">
            <form id="FormEnrollDelete" class="needs-validation" method="post" novalidate>
                <?= csrf_field() ?>
                
                <!-- Subject Info -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-calendar text-danger me-1"></i>ปีการศึกษา</label>
                        <input type="text" class="form-control" value="<?= isset($SubjectInfo->SubjectYear) ? esc($SubjectInfo->SubjectYear) : '' ?>" readonly>
                        <input type="hidden" name="SubjectYearregisupdate" value="<?= isset($SubjectInfo->SubjectYear) ? esc($SubjectInfo->SubjectYear) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-book text-danger me-1"></i>วิชาเรียน</label>
                        <input type="text" class="form-control" value="<?= (isset($SubjectInfo->SubjectCode) ? esc($SubjectInfo->SubjectCode) : '').' '.(isset($SubjectInfo->SubjectName) ? esc($SubjectInfo->SubjectName) : '') ?>" readonly>
                        <input type="hidden" name="subjectregisupdate" value="<?= isset($SubjectInfo->SubjectID) ? esc($SubjectInfo->SubjectID) : '' ?>">
                        <input type="hidden" name="SubjectCode" value="<?= isset($SubjectInfo->SubjectCode) ? esc($SubjectInfo->SubjectCode) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="bx bx-user text-danger me-1"></i>ครูผู้สอน</label>
                        <input type="text" class="form-control" value="<?= isset($CurrentTeacher) ? esc($CurrentTeacher->pers_prefix.$CurrentTeacher->pers_firstname.' '.$CurrentTeacher->pers_lastname) : '' ?>" readonly>
                        <input type="hidden" name="teacherregis" value="<?= isset($CurrentTeacher->pers_id) ? esc($CurrentTeacher->pers_id) : '' ?>">
                    </div>
                </div>

                <!-- Warning Alert -->
                <div class="warning-alert mb-4 d-flex align-items-center">
                    <i class="bx bx-error-circle bx-sm me-3"></i>
                    <div>
                        <strong class="text-warning">คำเตือน:</strong> การถอนรายชื่อนักเรียน จะทำให้คะแนนและข้อมูลที่เกี่ยวข้องหายไปทั้งหมด ไม่สามารถกู้คืนได้
                    </div>
                </div>

                <!-- NEW: Change Teacher by Room Section -->
                <?php
                $roomList = [];
                foreach ($Register as $r) {
                    if (!empty($r->StudentClass) && !in_array($r->StudentClass, $roomList)) {
                        $roomList[] = $r->StudentClass;
                    }
                }
                sort($roomList);
                ?>
                <div class="card border border-info shadow-none mb-4" style="background: rgba(23, 162, 184, 0.03);">
                    <div class="card-header d-flex align-items-center py-2 bg-info bg-opacity-10 border-info border-opacity-20">
                        <h6 class="mb-0 text-info fw-bold"><i class="bx bx-transfer me-2"></i>เปลี่ยนครูผู้สอนแยกตามห้องเรียน (คะแนนยังคงอยู่)</h6>
                    </div>
                    <div class="card-body py-3">
                        <?php if (empty($roomList)) : ?>
                            <div class="text-center py-3">
                                <i class="bx bx-info-circle bx-lg text-warning mb-2"></i>
                                <h5 class="text-warning fw-bold">ไม่พบรายชื่อนักเรียนในรายวิชานี้</h5>
                                <p class="text-muted mb-0">คุณครูท่านนี้ไม่มีรายชื่อนักเรียนที่ลงทะเบียนในรายวิชานี้แล้ว หรือนักเรียนถูกถอนชื่อออกทั้งหมดแล้ว</p>
                            </div>
                        <?php else : ?>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold"><i class="bx bx-user-plus text-info me-1"></i>เลือกครูผู้สอนใหม่</label>
                                    <select name="NewTeacherID" id="NewTeacherID" class="form-select select2-bs5">
                                        <option value="">-- เลือกครูผู้สอนใหม่ --</option>
                                        <?php foreach ($teacher as $t) : ?>
                                            <?php if ($t->pers_id != (isset($CurrentTeacher->pers_id) ? $CurrentTeacher->pers_id : '')) : ?>
                                                <option value="<?= esc($t->pers_id) ?>">
                                                    <?= esc($t->pers_prefix . $t->pers_firstname . ' ' . $t->pers_lastname) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold"><i class="bx bx-door-open text-info me-1"></i>เลือกห้องเรียนที่ต้องการเปลี่ยน</label>
                                    <div class="room-selection-container">
                                        <?php foreach ($roomList as $room) : ?>
                                            <label class="room-item">
                                                <input class="room-checkbox" type="checkbox" name="Rooms[]" value="<?= esc($room) ?>">
                                                <span class="room-label">ม.<?= esc($room) ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" id="btnChangeTeacherByRoom" class="btn btn-info w-100 text-white fw-bold">
                                        <i class="bx bx-check-double me-1"></i>ยืนยันเปลี่ยน
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mt-2 small text-muted">
                            <i class="bx bx-info-circle me-1"></i>ฟีเจอร์นี้จะย้ายนักเรียนทั้งห้องไปยังครูคนใหม่ โดยที่คะแนนเก็บและผลการเรียนเดิมจะไม่ถูกลบ
                        </div>
                    </div>
                </div>

                <!-- Transfer List -->
                <div class="transfer-list-container">
                    <!-- Left Box: Enrolled Students -->
                    <div class="transfer-box">
                        <div class="transfer-box-header">
                            <span class="title left-title"><i class="bx bx-user-check"></i>นักเรียนที่ลงทะเบียนเรียนอยู่</span>
                            <button type="button" id="multiselect_rightAll" class="btn-remove-all">
                                <i class="bx bx-chevrons-right me-1"></i>ถอนทั้งหมด
                            </button>
                        </div>
                        <input type="text" id="search_left" class="form-control mb-2" placeholder="🔍 ค้นหานักเรียน...">
                        <select name="from[]" id="multiselect" class="form-control transfer-select bg-white" multiple="multiple">
                            <?php foreach ($Register as $key => $v_Register) : ?>
                            <option value="<?= isset($v_Register->StudentID) ? esc($v_Register->StudentID) : '' ?>">
                                <?= (isset($v_Register->StudentStudyLine) && $v_Register->StudentStudyLine != '' ? '['.esc($v_Register->StudentStudyLine).'] ' : '') ?>
                                <?= (isset($v_Register->StudentClass) ? esc($v_Register->StudentClass) : '') ?>
                                <?= (isset($v_Register->StudentNumber) ? sprintf("%02d",$v_Register->StudentNumber) : '') ?>
                                <?= (isset($v_Register->StudentPrefix) ? esc($v_Register->StudentPrefix) : '').(isset($v_Register->StudentFirstName) ? esc($v_Register->StudentFirstName) : '').' '.(isset($v_Register->StudentLastName) ? esc($v_Register->StudentLastName) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Controls -->
                    <div class="transfer-controls">
                        <button type="button" id="multiselect_rightSelected" class="btn-transfer-control btn-transfer-right" title="ถอนรายชื่อ">
                            <i class="bx bx-chevron-right"></i>
                        </button>
                        <button type="button" id="multiselect_leftSelected" class="btn-transfer-control btn-transfer-left" title="ยกเลิก">
                            <i class="bx bx-chevron-left"></i>
                        </button>
                    </div>

                    <!-- Right Box: To Delete -->
                    <div class="transfer-box">
                        <div class="transfer-box-header">
                            <span class="title right-title"><i class="bx bx-user-x"></i>นักเรียนที่จะถูกถอนชื่อออก</span>
                            <button type="button" id="multiselect_leftAll" class="btn-cancel-all">
                                <i class="bx bx-chevrons-left me-1"></i>ยกเลิกทั้งหมด
                            </button>
                        </div>
                        <input type="text" id="search_right" class="form-control mb-2" placeholder="🔍 ค้นหานักเรียน...">
                        <select name="to[]" id="multiselect_to" class="form-control transfer-select border-danger bg-white" required multiple="multiple">
                            <!-- Selected Items to Delete -->
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn-delete">
                        <i class="bx bx-trash"></i>ยืนยันการถอนรายชื่อ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$('#multiselect').multiselect({
    search: {
        left: '#search_left',
        right: '#search_right',
    },
    fireSearch: function(value) {
        return value.length > 1; 
    }
});

$('#NewTeacherID').select2({
    theme: 'bootstrap-5',
    width: '100%',
    dropdownParent: $('body')
});

$(document).on("submit", "#FormEnrollDelete", function(e) {
    e.preventDefault();
    var form = $(this);
    
    // Count selected
    var count = $('#multiselect_to option').length;
    if(count === 0) {
        Swal.fire({
            title: 'แจ้งเตือน',
            text: 'กรุณาเลือกนักเรียนที่ต้องการถอนรายชื่ออย่างน้อย 1 คน',
            icon: 'warning',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    Swal.fire({
        title: '<i class="bx bx-error-circle text-danger me-2"></i>ยืนยันการถอนรายชื่อ?',
        html: `
            <div class="text-start">
                <p>คุณกำลังจะถอนรายชื่อนักเรียนจำนวน <strong class="text-danger">${count} คน</strong></p>
                <div class="alert alert-danger py-2 mb-0">
                    <i class="bx bx-error me-1"></i>ข้อมูลคะแนนและการเรียนจะถูกลบถาวร ไม่สามารถกู้คืนได้!
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bx bx-trash me-1"></i>ใช่, ถอนรายชื่อทันที!',
        cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก',
        width: '500px'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollDel') ?>',
                type: 'post',
                data: form.serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังถอนรายชื่อ...',
                        html: '<div class="py-3"><div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง',
                        confirmButtonColor: '#dc3545'
                    });
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ถอนการลงทะเบียนสำเร็จ',
                        text: 'ข้อมูลถูกลบเรียบร้อยแล้ว',
                        confirmButtonColor: '#15a362',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll') ?>';
                    });
                }
            });
        }
    });
});

$(document).on("click", "#btnChangeTeacherByRoom", function() {
    const newTeacherID = $('#NewTeacherID').val();
    const rooms = $('.room-checkbox:checked').map(function() { return $(this).val(); }).get();
    const subjectID = $('input[name="subjectregisupdate"]').val();
    const registerYear = $('input[name="SubjectYearregisupdate"]').val();
    const oldTeacherID = $('input[name="teacherregis"]').val();
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = $('input[name="' + csrfName + '"]').val();

    if (!newTeacherID) {
        Swal.fire('แจ้งเตือน', 'กรุณาเลือกครูผู้สอนใหม่', 'warning');
        return;
    }
    if (rooms.length === 0) {
        Swal.fire('แจ้งเตือน', 'กรุณาเลือกห้องเรียนอย่างน้อย 1 ห้อง', 'warning');
        return;
    }

    Swal.fire({
        title: 'ยืนยันการเปลี่ยนครูผู้สอน?',
        html: `คุณกำลังจะเปลี่ยนครูผู้สอนสำหรับห้อง <strong>${rooms.join(', ')}</strong><br>เป็นครูท่านใหม่ โดยที่ข้อมูลคะแนนเดิมจะยังคงอยู่`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยันการเปลี่ยน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            let postData = {
                SubjectID: subjectID,
                RegisterYear: registerYear,
                OldTeacherID: oldTeacherID,
                NewTeacherID: newTeacherID,
                Rooms: rooms
            };
            postData[csrfName] = csrfHash;

            $.ajax({
                url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollChangeTeacherByRoom') ?>',
                type: 'POST',
                data: postData,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังบันทึกข้อมูล...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'เปลี่ยนครูผู้สอนเรียบร้อย!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
