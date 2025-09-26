<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}

.ss-main .ss-single-selected {
    height: 40px;
}
</style>
<div class="container-xl">
    <div class="content pt-3 p-md-3 p-lg-4">


        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="<?= site_url('Admin/Acade/Registration/Enroll') ?>">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?= isset($title) ? esc($title) : '' ?></li>
                        </ol>
                    </nav>
                </div>
                <!--//table-utilities-->
            </div>
        </div>
        <!--//row-->

        </section>
        <hr class="mb-4">
        <section class="we-offer-area">
            <form id="FormEnrollDelete" class="needs-validation" method="post" novalidate>
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">ปีการศึกษา</h3>
                        <div class="section-intro">ปีการศึกษาที่วิชานี้ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">
                                <?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>
                            </div>
                            <input type="hidden" name="SubjectYearregisupdate" id="SubjectYearregisupdate"
                                    value="<?= isset($CheckYearSubject[0]->SubjectYear) ? esc($CheckYearSubject[0]->SubjectYear) : '' ?>">
                            <!--//card-body-->

                        </div>
                        <!--//card-->
                    </div>
                </div>
                <hr class="mb-4">

                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">วิชาเรียน</h3>
                        <div class="section-intro">ให้เลือกวิชาเรียนที่ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">
                                <?= (isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '').' '.(isset($Register[0]->SubjectName) ? esc($Register[0]->SubjectName) : '') ?>
                                <input type="hidden" name="subjectregisupdate" id="subjectregisupdate"
                                    value="<?= isset($Register[0]->SubjectID) ? esc($Register[0]->SubjectID) : '' ?>">
                                    <input type="hidden" name="SubjectCode" id="SubjectCode"
                                    value="<?= isset($Register[0]->SubjectCode) ? esc($Register[0]->SubjectCode) : '' ?>">
                                <div class="invalid-feedback">
                                    กรุณาเลือกวิชาเรียน
                                </div>
                            </div>
                            <!--//card-body-->

                        </div>
                        <!--//card-->
                    </div>
                </div>
                <hr class="mb-4">
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">ครูผู้สอน</h3>
                        <div class="section-intro">ให้เลือกครูผู้สอนในวิชาที่ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">
                                
                                <select name="teacherregis" id="teacherregis" class="teacherregis" required>
                                    <option value="">เลือกครูผู้สอน</option>
                                    <?php foreach ($teacher as $key => $v_teacher): ?>
                                    <option <?= (isset($v_teacher->pers_id) && isset($Register[0]->TeacherID) && $v_teacher->pers_id == $Register[0]->TeacherID) ? "selected" : ""?>
                                        value="<?= isset($v_teacher->pers_id) ? esc($v_teacher->pers_id) : '' ?>">
                                        <?= (isset($v_teacher->pers_prefix) ? esc($v_teacher->pers_prefix) : '').(isset($v_teacher->pers_firstname) ? esc($v_teacher->pers_firstname) : '').' '.(isset($v_teacher->pers_lastname) ? esc($v_teacher->pers_lastname) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกคุณครู
                                </div>
                            </div>
                            <!--//card-body-->

                        </div>
                        <!--//card-->
                    </div>
                </div>

                <hr class="mb-4">
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">นักเรียน</h3>
                        <div class="section-intro">
                            ให้เลือกนักเรียนที่จะเรียนในวิชาที่ลงทะเบียน
                            <p>
                                - ให้เลือกห้องเรียนก่อน <br>
                                - เลือกนักเรียนจากด้านซ้าย เลือกไปด้านขวา <br>
                                - ** สามารถเลือกนักเรียนกี่ห้องก็ได้ ให้เลือกห้องเรียนใหม่เท่านั้นเอง
                            </p>

                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">
                                <div class="invalid-feedback">
                                    กรุณาเลือห้องเรียน
                                </div>


                                <div class="row mt-3">

                                    <div class="col-lg-5">
                                        <p>รายชื่อนักเรียน</p>
                                        <select name="from[]" id="multiselect" class="form-control" size="20"
                                            multiple="multiple" style="height:20rem">
                                            <?php foreach ($Register as $key => $v_Register) : ?>
                                            <option value="<?= isset($v_Register->StudentID) ? esc($v_Register->StudentID) : '' ?>">
                                                <?= (isset($v_Register->StudentClass) ? esc($v_Register->StudentClass) : '') ?>
                                                <?= (isset($v_Register->StudentNumber) ? sprintf("%02d",$v_Register->StudentNumber) : '') ?>
                                                <?= (isset($v_Register->StudentPrefix) ? esc($v_Register->StudentPrefix) : '').(isset($v_Register->StudentFirstName) ? esc($v_Register->StudentFirstName) : '').' '.(isset($v_Register->StudentLastName) ? esc($v_Register->StudentLastName) : '') ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-2 align-self-center">

                                        <button type="button" id="multiselect_rightAll"
                                            class="btn btn-primary w-100 mb-1" title="เลือกทั้งหมด"><i class="bx bx-chevrons-right"></i> เลือกทั้งหมด</button>
                                        <button type="button" id="multiselect_rightSelected"
                                            class="btn btn-primary w-100 mb-1" title="เลือก"><i class="bx bx-chevron-right"></i> เลือก</button>
                                        <button type="button" id="multiselect_leftSelected"
                                            class="btn btn-primary w-100 mb-1" title="ลบ"><i class="bx bx-chevron-left"></i> ลบ</button>
                                        <button type="button" id="multiselect_leftAll"
                                            class="btn btn-primary w-100 mb-1" title="ยกเลิกทั้งหมด"><i class="bx bx-chevrons-left"></i> ยกเลิกทั้งหมด</button>
                                    </div>

                                    <div class="col-lg-5">
                                        <p>รายชื่อนักเรียนที่จะถอนออกรายวิชานี้</p>
                                        <select name="to[]" id="multiselect_to" class="form-control" size="8"
                                            required multiple="multiple" style="height:20rem">

                                        </select>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="button" id="multiselect_move_up"
                                                    class="btn btn-block" title="เลื่อนขึ้น"><i class="bx bx-up-arrow-alt"></i> ขึ้น</button>
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="button" id="multiselect_move_down"
                                                    class="btn btn-block col-sm-6" title="เลื่อนลง"><i class="bx bx-down-arrow-alt"></i> ลง</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//card-body-->
                        </div>
                        <!--//card-->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100" title="บันทึก"><i class="bx bx-save"></i> บันทึก</button>
                        </div>

                    </div>
                </div>

    </div>
    </form>
    <!--//container-->
    </section>

</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
       $('#multiselect').multiselect();
$(document).ready(function() {
    $('#teacherregis').select2({
        theme: 'bootstrap-5',
        width: 300
    });
});

$(document).on("submit", "#FormEnrollDelete", function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'ต้องการถอนรายชื่อในการลงทะเบียนหรือไม่?',
        text: 'เมื่อถอนรายชื่อการลงทะเบียนวิชานี้แล้ว คะแนนและรายชื่อนักเรียนในวิชานี้ จะถูกลบทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollDel') ?>',
                type: 'post',
                data: $(this).serialize(),
                error: function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'นักเรียนในรายชื่อนี้ได้ลงทะเบียนวิชานี้ และปีนี้ไปแล้ว กรุณาเลือกและตรวจสอบใหม่',
                        showConfirmButton: false,
                        timer: 3000
                    })
                },
                success: function(data) {
                    // console.log(data);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'ถอนการลงทะเบียนรายวิชาสำเร็จ',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            });
        }
    })
});
</script>
<?= $this->endSection() ?>

