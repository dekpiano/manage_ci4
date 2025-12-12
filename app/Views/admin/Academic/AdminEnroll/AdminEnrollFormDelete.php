<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
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
            <span class="text-muted fw-light">จัดการข้อมูล /</span> ถอนรายชื่อการลงทะเบียน
        </h4>
        <a href="<?= site_url('Admin/Acade/Registration/Enroll') ?>" class="btn btn-label-secondary">
            <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-danger">
                <h5 class="card-header border-bottom text-danger"><i class="bx bx-trash me-2"></i>ถอนนักเรียนออกจากรายวิชา</h5>
                <div class="card-body pt-4">
                    <form id="FormEnrollDelete" class="needs-validation" method="post" novalidate>
                        
                        <!-- Step 1: Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">ปีการศึกษา</label>
                                <input type="text" class="form-control" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>" readonly>
                                <input type="hidden" name="SubjectYearregisupdate" value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">วิชาเรียน</label>
                                <input type="text" class="form-control" value="<?= (isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '').' '.(isset($Register[0]->SubjectName) ? esc($Register[0]->SubjectName) : '') ?>" readonly>
                                <input type="hidden" name="subjectregisupdate" value="<?= isset($Register[0]->SubjectID) ? esc($Register[0]->SubjectID) : '' ?>">
                                <input type="hidden" name="SubjectCode" value="<?= isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ครูผู้สอน</label>
                                <input type="text" class="form-control" value="<?php foreach($teacher as $t) { echo ($t->pers_id == $Register[0]->TeacherID) ? $t->pers_firstname.' '.$t->pers_lastname : ''; } ?>" readonly>
                                <input type="hidden" name="teacherregis" value="<?= isset($Register[0]->TeacherID) ? esc($Register[0]->TeacherID) : '' ?>">
                            </div>
                        </div>

                        <div class="alert alert-danger py-2 mb-4">
                            <i class="bx bx-error me-1"></i> <strong>คำเตือน:</strong> การถอนรายชื่อนักเรียน จะทำให้คะแนนและข้อมูลที่เกี่ยวข้องหายไปทั้งหมด
                        </div>

                        <!-- Step 2: Transfer -->
                        <div class="transfer-list-container align-items-stretch">
                            <!-- Left Box: Enrolled Students -->
                            <div class="transfer-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0 fw-bold">นักเรียนที่ลงทะเบียนเรียนอยู่</label>
                                    <button type="button" id="multiselect_rightAll" class="btn btn-xs btn-outline-danger">
                                        <i class="bx bx-chevrons-right"></i> ถอนทั้งหมด
                                    </button>
                                </div>
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
                            <div class="transfer-controls justify-content-center">
                                <button type="button" id="multiselect_rightSelected" class="btn btn-danger btn-icon" title="ถอนรายชื่อ">
                                    <i class="bx bx-chevron-right"></i>
                                </button>
                                <button type="button" id="multiselect_leftSelected" class="btn btn-label-secondary btn-icon" title="ยกเลิก">
                                    <i class="bx bx-chevron-left"></i>
                                </button>
                            </div>

                            <!-- Right Box: To Delete -->
                            <div class="transfer-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0 fw-bold text-danger">นักเรียนที่จะถูกถอนชื่อออก</label>
                                    <button type="button" id="multiselect_leftAll" class="btn btn-xs btn-outline-secondary">
                                        <i class="bx bx-chevrons-left"></i> ยกเลิกทั้งหมด
                                    </button>
                                </div>
                                <select name="to[]" id="multiselect_to" class="form-control transfer-select border-danger bg-white" required multiple="multiple">
                                    <!-- Selected Items to Delete -->
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger btn-lg px-5">
                                <i class="bx bx-trash me-2"></i> ยืนยันการถอนรายชื่อ
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
    $('#multiselect').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control mb-2" placeholder="ค้นหานักเรียน..." />',
            right: '<input type="text" name="q" class="form-control mb-2" placeholder="ค้นหา..." />',
        },
        fireSearch: function(value) {
            return value.length > 1; 
        }
    });

    $(document).on("submit", "#FormEnrollDelete", function(e) {
        e.preventDefault();
        var form = $(this);
        
        // Count selected
        var count = $('#multiselect_to option').length;
        if(count === 0) {
            Swal.fire('แจ้งเตือน', 'กรุณาเลือกนักเรียนที่ต้องการถอนรายชื่ออย่างน้อย 1 คน', 'warning');
            return;
        }

        Swal.fire({
            title: 'ยืนยันการถอนรายชื่อ?',
            html: `คุณกำลังจะถอนรายชื่อนักเรียนจำนวน <strong>${count} คน</strong><br>ข้อมูลคะแนนและการเรียนจะถูกลบถาวร`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ถอนรายชื่อทันที!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollDel') ?>',
                    type: 'post',
                    data: form.serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังถอนรายชื่อ...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถดำเนินการได้'
                        });
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ถอนการลงทะเบียนสำเร็จ',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll') ?>';
                        });
                    }
                });
            }
        })
    });
</script>
<?= $this->endSection() ?>
