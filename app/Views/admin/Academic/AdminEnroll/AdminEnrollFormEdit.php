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
            <form id="FormEnrollUpdate" class="needs-validation" method="post" novalidate>
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

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
                                <select name="RoomEdit" id="Room" class="mb-3 w-auto" required>
                                    <option value="">เลือกห้องเรียน</option>
                                    <?php $ListRoom = $classroom->ListRoom();
                                    foreach ($ListRoom as $key => $v_ListRoom): ?>
                                    <option value="<?= esc($v_ListRoom) ?>">
                                        ม.<?= esc($v_ListRoom) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือห้องเรียน
                                </div>
                                <!-- <div class="table-responsive">
                                <table class="table mb-0 text-left" id="TB_showStudent">
                                    <thead>
                                        <tr>
                                            <th class="cell">เลือก</th>
                                            <th class="cell">เลขนักเรียน</th>
                                            <th class="cell">ชื่อ - สกุล</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div> -->

                                <div class="row mt-3">

                                    <div class="col-lg-5">
                                        <p>รายชื่อนักเรียน</p>
                                        <select name="from[]" id="multiselect" class="form-control" size="20"
                                            multiple="multiple" style="height:20rem">
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
                                        <p>รายชื่อนักเรียนที่เพิ่งเข้ามาใหม่</p>
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
$(document).ready(function() {
    // Initialize the multiselect plugin
    // เรียกใช้ plugin สำหรับย้ายรายชื่อนักเรียน
    $('#multiselect').multiselect();
});

$(document).ready(function() {
    $('#teacherregis').select2({
        theme: 'bootstrap-5',
        width: 300
    });
    $('#Room').select2({
        theme: 'bootstrap-5',
        width: 300
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
                        // Update CSRF hash for next AJAX call
                        csrfInput.val(response.csrf_hash);

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'เปลี่ยนครูผู้สอนใหม่แล้ว!',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(function() {
                            window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll/Edit/') ?>' + subjectregisupdate + '/' + teacherregis;
                        }, 2000);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเปลี่ยนครูผู้สอนได้ (' + jqXHR.status + ' ' + errorThrown + ')'
                        });
                    }
                });
            }
        });
    });
$(document).on("change", "#Room", function() {
    
    $('#multiselect option').remove();

    $.post("<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSelect') ?>", { KeyRoom: $(this).val() }, function(data, status) {

        $.each(data, function(index, value) {
            //console.log(value);
            trHTML = '<tr><td></td><td>' + value.StudentCode + '</td><td>' + value.StudentPrefix+value.StudentFirstName+' '+value.StudentLastName + '</td></tr>';
            trHTML = '<option value="' + value.StudentID + '">' + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            $('#multiselect').append(trHTML);
        });

    }, 'json') 
    .fail(function(jqXHR, textStatus, errorThrown) {
    // เกิดข้อผิดพลาด
    console.error("เกิดข้อผิดพลาด:", textStatus, errorThrown);
    console.error("สถานะ HTTP:", jqXHR.status); // รหัสสถานะ HTTP (เช่น 404, 500)
    console.error("สถานะข้อความ:", jqXHR.statusText); // ข้อความสถานะ (เช่น "Not Found")
    console.error("รายละเอียดข้อผิดพลาด:", jqXHR.responseText); // เนื้อหาข้อผิดพลาดจากเซิร์ฟเวอร์
  });
    

});

    $(document).on("submit", "#FormEnrollUpdate", function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollUpdate') ?>',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
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

                if ((!data.inserted || data.inserted.length === 0) && (!data.duplicates || data.duplicates.length === 0)) {
                    tableHtml = ''; // Clear html if no data to show
                }

                Swal.fire({
                    position: 'center',
                    icon: data.status,
                    title: data.title,
                    html: tableHtml,
                    showConfirmButton: true,
                    width: '500px'
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle network or server errors
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถส่งข้อมูลไปยังเซิร์ฟเวอร์ได้',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });</script>
<?= $this->endSection() ?>
