<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">
                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>
            </div>
            <!--//container-->
        </section>
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <button class="btn app-btn-primary btn-sm text-right mb-3" id="ModalAddExtraSubject"> <i
                            class="far fa-plus-square"></i> เพิ่ม<?= isset($title) ? esc($title) : '' ?></button>
                            <a href="<?= site_url('Admin/Acade/SettingSystem') ?>" class="btn btn-secondary btn-sm text-right mb-3" id="ModalAddExtraSubject"> <i class="fa fa-cog" aria-hidden="true"></i> ตั้งค่าระบบ</a>
                            <a href="<?= site_url('Admin/Acade/Report') ?>" class="btn btn-info btn-sm text-right mb-3" id="ModalAddExtraSubject"> <i class="fa fa-print" aria-hidden="true"></i> รายงาน</a>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan=2>ภาคเรียน</th>
                                    <th rowspan=2>ชื่อวิชา</th>
                                    <th rowspan=2>ครูที่ปรึกษา</th>
                                    <th rowspan=2>ระดับชั้นที่ลงทะเบียนได้</th>
                                    <th colspan="2">สมาชิก</th>
                                    <th rowspan=2>คำสั่ง</th>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="1">รับทั้งหมด</th>
                                    <th colspan="1">ปัจจุบัน</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($ExtraSubject as $key => $v_ExtraSubject) : ?>
                                <tr>
                                    <td><?= (isset($v_ExtraSubject->extra_year) ? esc($v_ExtraSubject->extra_year) : '').'/'.(isset($v_ExtraSubject->extra_term) ? esc($v_ExtraSubject->extra_term) : '') ?></td>
                                    <td><?= isset($v_ExtraSubject->extra_course_name) ? esc($v_ExtraSubject->extra_course_name) : '' ?></td>
                                    <td><?= isset($v_ExtraSubject->extra_course_teacher) ? esc($v_ExtraSubject->extra_course_teacher) : '' ?></td>
                                    <td>
                                        <?php 
                            $level =  isset($v_ExtraSubject->extra_grade_level) ? explode("|",$v_ExtraSubject->extra_grade_level) : [];
                            foreach ($level as $key => $v_level) {
                               echo "ม.".esc($v_level)." ";
                            }
                            ?>
                                    </td>
                                    <td><?= isset($v_ExtraSubject->extra_number_students) ? esc($v_ExtraSubject->extra_number_students) : '' ?></td>
                                    <td>
                                    <?php foreach ($CountStudentRegister as $key => $v_conutstu) {
                                       if(isset($v_conutstu->fk_extra_id) && isset($v_ExtraSubject->extra_id) && $v_conutstu->fk_extra_id == $v_ExtraSubject->extra_id){
                                            echo isset($v_conutstu->CountAll) ? esc($v_conutstu->CountAll) : '';
                                       }
                                    }?>
                                    </td>
                                    <td><a class="ModalExtraSubject" Extraid="<?= isset($v_ExtraSubject->extra_id) ? esc($v_ExtraSubject->extra_id) : '' ?>"
                                            href="#">แก้ไข</a>|<a href="http://">ลบ</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มวิชาเพิ่มเติม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddExtraSubject" class="needs-validation" novalidate>
                    <input type="hidden" name="extra_id" id="extra_id" value="">
                    <div class="mb-2">
                        <label for="email">ปีการศึกษา <?php $d= (date('Y')+543)-1;?></label>
                        <select name="extra_year" id="extra_year" class="form-select" required>
                            <?php for($i=$d; $i<=$d+2; $i++) : ?>
                            <option <?=$i==date('Y')+543 ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                            <?php endfor; ?>
                        </select>
               
                        <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                    </div>
                    <div class="mb-2">
                        <label for="email">ภาคเรียน </label>
                        <select name="extra_term" id="extra_term" class="form-select" required>
                            <option value="">เลือกภาคเรียน</option>
                            <?php for($i=1; $i<=3; $i++) : ?>
                            <option value="<?= esc($i) ?>"><?= esc($i) ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกภาคเรียน</div>
                    </div>
                    <div class="mb-2">
                        <label for="classroom">รหัสวิชา <small>(Ex. ว20125)</small></label>
                        <input type="text" class="form-control" placeholder=""
                            name="extra_course_code" id="extra_course_code" required>
                            <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                    </div>
                    <div class="mb-2">
                        <label for="classroom">ชื่อวิชา</label>
                        <input type="text" class="form-control" placeholder=""
                            name="extra_course_name" id="extra_course_name" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                    </div>
                    <div class="mb-2">
                        <label for="classroom">คีย์ระดับชั้น <small>(ใส่ข้อมูลในกรณี ให้นักเรียนต้องเลือก มากกว่า 1 วิชา Ex. 6-1, 3-2)</small></label>
                        <input type="text" class="form-control" placeholder=""
                            name="extra_key_room" id="extra_key_room">
                            <div class="invalid-feedback">กรุณาคีย์ระดับชั้น</div>
                    </div>
                    <div class="mb-2">
                        <label for="email">ระดับชั้นที่สอน <small>(เลือกได้มากกว่า 1 ห้องเรียน)</small> </label><br>
                        <select class="multiple extra_grade_level " id="extra_grade_level" multiple name="extra_grade_level[]" required>
                        <?php 
                        $room = array('1/1','1/2','1/3','1/4','2/1','2/2','2/3','2/4','3/1','3/2','3/3','3/4','4/1','4/2','4/3','4/4','5/1','5/2','5/3','5/4','6/1','6/2','6/3','6/4');
                           foreach ($room as $key => $v_room) : ?>
                            <option value="<?= esc($v_room) ?>">ม.<?= esc($v_room) ?></option>
                            <?php endforeach;   ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกระดับชั้นที่สอน</div>
                    </div>
                    <div class="mb-2">
                        <label for="classroom">จำนวนที่รับ</label>
                        <input type="text" class="form-control" placeholder=""
                            name="extra_number_students" id="extra_number_students" required>
                            <div class="invalid-feedback">กรุณากรอกจำนวนที่รับนักเรียน</div>
                    </div>
                    <div class="mb-2">
                        <label for="teacher">ครูผู้สอน:</label>
                        <select name="extra_course_teacher" id="extra_course_teacher" class="single"  required>
                            <option value=''>เลือกครูผู้สอน</option>
                            <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                value="<?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกครูผู้สอน</div>
                    </div>
                    <div class="mb-2">
                        <label for="classroom">หมายเหตุ</label>
                        <input type="text" class="form-control" placeholder="Ex. รับเฉพาะ ม.2"
                            name="extra_comment" id="extra_comment">
                    </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" id="sub_ExtraSubject" class="btn app-btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    var ta = $('#example').DataTable({
        "order": [
            [3, "asc"],
            [4, "asc"]
        ]
    });

    $('#ModalAddExtraSubject').on('click', function () {
        $('#myModal').modal('show');
        $("#UpdateExtraSubject").attr('id', "AddExtraSubject");
        $("#AddExtraSubject")[0].reset();
    });

    const slim = new SlimSelect({
        select: '.multiple'
    })
    const slimTeacher = new SlimSelect({
        select: '.single'
    })

    $('.ModalExtraSubject').on('click', function (e) {
        e.preventDefault();
        $('#myModal').modal('show');
        $('.extra_grade_level').prop('checked', false);
        $.ajax({
            type: 'POST',
            url: "<?= site_url('admin/ConAdminExtraSubject/EditExtraSubject') ?>",
            data: { Extraid: $(this).attr('Extraid') },
            dataType: "json",
            beforeSend: function () {

            },
            success: function (data) {
                //console.log(data[0].extra_year);
                $('#extr-id').val(data[0].extr-id);
                $('#extra_year').val(data[0].extra_year);
                $('#extra_term').val(data[0].extra_term);
                $('#extra_key_room').val(data[0].extra_key_room);
                ''
                $('#extra_course_code').val(data[0].extra_course_code);
                $('#extra_course_name').val(data[0].extra_course_name);
                $('#extra_course_teacher').val(data[0].extra_course_teacher);
                $('#extra_number_students').val(data[0].extra_number_students);
                $('#extra_comment').val(data[0].extra_comment);
                var n = data[0].extra_grade_level.split('|');
                slim.set(n);
                slimTeacher.set(data[0].extra_course_teacher);

                $("#AddExtraSubject").attr('id', "UpdateExtraSubject");
            },
            error: function (xhr) {
                alert("Error occured.please try again");
                console.log(xhr.statusText + xhr.responseText);
            }
        });
    });

    $(document).on("submit", "#AddExtraSubject", function (e) {
        e.preventDefault();
        var formadd = $('#AddExtraSubject').serialize();
        $.ajax({
            type: 'POST',
            url: "<?= site_url('admin/ConAdminExtraSubject/AddExtraSubject') ?>",
            data: formadd,
            beforeSend: function () {

            },
            success: function (data) {
                if (data == 1) {
                    Swal.fire(
                        'แจ้งเตือน',
                        'คุณเพิ่มวิชาเพิ่มเติมเรียบร้อย',
                        'success'
                    )
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: "คุณเพิ่มวิชาเพิ่มเติมเรียบร้อย",
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            },
            error: function (xhr) {
                alert("Error occured.please try again");
                console.log(xhr.statusText + xhr.responseText);
            }
        });
    });

    $(document).on("submit", "#UpdateExtraSubject", function (e) {
        e.preventDefault();
        var formadd = $('#UpdateExtraSubject').serialize();

        $.ajax({
            type: 'POST',
            url: "<?= site_url('admin/ConAdminExtraSubject/UpdateExtraSubject') ?>",
            data: formadd,
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                if (data == 1) {

                    Swal.fire(
                        'แจ้งเตือน',
                        'คุณเพิ่มวิชาเพิ่มเติมเรียบร้อย',
                        'success'
                    )
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: "คุณแก้ไขวิชาเพิ่มเติมเรียบร้อย",
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            },
            error: function (xhr) {
                alert("Error occured.please try again");
                console.log(xhr.statusText + xhr.responseText);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
