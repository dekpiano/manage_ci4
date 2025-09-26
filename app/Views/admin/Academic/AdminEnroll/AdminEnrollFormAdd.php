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
                <h1 class="page-title mb-0"><?= isset($title) ? esc($title) : '' ?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="<?= site_url('Admin/Acade/Registration/Enroll') ?>">หน้าหลัก</a></li>
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
            <form id="FormEnroll" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">ปีการศึกษา</h3>
                        <div class="section-intro">ให้เลือกปีการศึกษาที่จะลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">

                                <select name="SelectYearRegister" id="SelectYearRegister" class="" required
                                    autocomplete="off">
                                    <option value="">เลือกปีการศึกษา</option>
                                    <?php $d = date('Y')+543; 
                                        for ($i=$d-2; $i<=$d; $i++):
                                            for($j=1; $j<=4; $j++):
                                        ?>
                                    <?php // NOTE: This logic should be in the controller
                                    $currentSegment = (service('request')->uri->getSegment(6) ?? '').'/'.(service('request')->uri->getSegment(7) ?? '');
                                    ?>
                                    <option
                                        <?= $currentSegment == $j.'/'.$i ? "selected" : ""?>
                                        value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                    <?php endfor; endfor; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกปีการศึกษา
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
                        <h3 class="section-title">วิชาเรียน</h3>
                        <div class="section-intro">ให้เลือกวิชาเรียนที่ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card card-settings shadow-sm p-4">
                            <div class="card-body">
                                <select name="subjectregis" id="subjectregis" class="subjectregis" required
                                    autocomplete="off">
                                    <option value="">เลือกวิชาเรียน</option>
                                    <?php foreach ($subject as $key => $v_subject): ?>
                                    <option value="<?= isset($v_subject->SubjectID) ? esc($v_subject->SubjectID) : '' ?>">
                                        <?= (isset($v_subject->SubjectCode) ? esc($v_subject->SubjectCode) : '').' '.(isset($v_subject->SubjectName) ? esc($v_subject->SubjectName) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
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
                                <select name="teacherregis" id="teacherregis" class="teacherregis1" required>
                                    <option value="">เลือกครูผู้สอน</option>
                                    <?php foreach ($teacher as $key => $v_teacher): ?>
                                    <option value="<?= isset($v_teacher->pers_id) ? esc($v_teacher->pers_id) : '' ?>">
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
                                <div class="d-flex">
                                    <div class="me-3">
                                        <select name="Room" id="Room" class="mb-3 Room" required>
                                            <option value="">เลือกห้องเรียน</option>
                                            <?php 
                                            if (!isset($classroom)) {
                                                $classroom = new App\Libraries\Classroom();
                                            }
                                            $ListRoom = $classroom->ListRoom();
                                            foreach ($ListRoom as $key => $v_ListRoom): ?>
                                            <option value="<?= esc($v_ListRoom) ?>">
                                                ม.<?= esc($v_ListRoom) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือห้องเรียน
                                        </div>
                                    </div>

                                    <div id="StudyLines"></div>
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
                                        <select name="from[]" id="multiselect" class="form-control" size="20"
                                            multiple="multiple" style="height:20rem">
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
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
                                        <select name="to[]" id="multiselect_to" class="form-control" size="8"
                                            required multiple="multiple" style="height:20rem"></select>

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
$(document).on("change", "#subjectregis", function() {
    var IDsubjectregis = $(this).val();
    var IDSelectYearRegister = $('#SelectYearRegister').val();
    
    $.post('<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollChangeSubjectToTeacher') ?>',{
        Keysubjectregis:IDsubjectregis,
        KeySelectYearRegister:IDSelectYearRegister
    },function(data, status){
        //console.log(data);
        $('#teacherregis').val(data.teacherId); // Access the property from the JSON object
        $('#teacherregis').trigger('change');
    }, 'json') // Added dataType: 'json'
    .fail(function(jqXHR, textStatus, errorThrown) {
    // จัดการกับข้อผิดพลาดที่เกิดขึ้น
    console.error("เกิดข้อผิดพลาด:", textStatus, errorThrown);
    console.error("สถานะ HTTP:", jqXHR.status);
    console.error("ข้อความ:", jqXHR.responseText);
  });;
  
});


$(document).ready(function() {
    $('#SelectYearRegister').select2({
        theme: 'bootstrap-5',
        width: 300
    });

    $('#teacherregis').select2({
        theme: 'bootstrap-5',
        width: 300
    });
    $('#subjectregis').select2({
        theme: 'bootstrap-5',
        width: 300
    });
    $('#Room').select2({
        theme: 'bootstrap-5',
        width: 300
    });
    $('#RoomEdit').select2({
        theme: 'bootstrap-5',
        width: 300
    });
});



$(document).on("change", "#SelectYearRegister", function() {
    window.location.href = '<?= site_url('Admin/Acade/Registration/Enroll/Add/') ?>' + $(this).val();
});


$(document).on("change", "#Room", function() {

    $('#multiselect option').remove();

    $.post("<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSelect') ?>", { KeyRoom: $(this).val() }, function(data, status) {
        //console.log(data);
        $.each(data, function(index, value) {
            //console.log(index);
            trHTML = '<tr><td></td><td>' + value.StudentCode + '</td><td>' + value.StudentPrefix+value.StudentFirstName+' '+value.StudentLastName + '</td></tr>';
            trHTML = '<option value="' + value.StudentID + '">' + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            $('#multiselect').append(trHTML);
        });
    }, 'json');

});

$(document).on("submit", "#FormEnroll", function(e) {
    e.preventDefault();
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollInsert') ?>',
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
      
              Swal.fire({
                title: "แจ้งเตือน?",
                text: "บันทึกข้อมูลสำเร็จ!",
                icon: "success",
                showCancelButton: true,
              }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
              });

        }
    });
});
</script>
<?= $this->endSection() ?>
