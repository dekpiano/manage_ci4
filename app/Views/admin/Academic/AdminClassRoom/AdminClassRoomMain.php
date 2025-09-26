<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    .ss-main .ss-single-selected {
        height: 40px;
    }
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">

                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>
            </div>
            <!--//container-->
        </section>

        <div class="container-xl">
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <label for="yearFilter" class="col-form-label me-2">ปีการศึกษา:</label>
                            <select class="form-select" id="yearFilter" style="width: auto;">
                                <?php if (!empty($years)): ?>
                                    <?php foreach ($years as $year): ?>
                                        <option value="<?= $year->Reg_Year ?>" <?= ($year->Reg_Year == $selectedYear) ? 'selected' : '' ?>>
                                            <?= $year->Reg_Year ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php elseif(isset($selectedYear)): ?>
                                    <option value="<?= $selectedYear ?>" selected><?= $selectedYear ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-sm" id="ModalAddClassRoom" data-bs-toggle="modal" data-bs-target="#myModal"> 
                                <i class="far fa-plus-square"></i> เพิ่ม<?= isset($title) ? esc($title) : '' ?>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" class="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <table class="table table-bordered" id="tb-classroom">
                            <thead>
                                <tr>
                                    <th>ปีการศึกษา</th>
                                    <th>ห้องเรียน</th>
                                    <th>ครูที่ปรึกษา / ครูหัวหน้าระดับ</th>
                                    <th>คำสั่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tea = []; foreach ($classRoom as $key => $v_classRoom) : 
                    $tea[] = isset($v_classRoom->class_teacher) ? $v_classRoom->class_teacher : '';
                        ?>
                            <tr id="row-<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id) : '' ?>">
                                <td><?= isset($v_classRoom->Reg_Year) ? esc($v_classRoom->Reg_Year) : '' ?></td>
                                <td>
                                   
                                    <?php if(isset($v_classRoom->Reg_Class) && strlen($v_classRoom->Reg_Class) == 1) : ?>
                                        หัวหน้าระดับ ม. <?= esc($v_classRoom->Reg_Class) ?>
                                    <?php else : ?>
                                        ห้อง ม.<?= isset($v_classRoom->Reg_Class) ? esc($v_classRoom->Reg_Class) : '' ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= (isset($v_classRoom->pers_prefix) ? esc($v_classRoom->pers_prefix) : '').(isset($v_classRoom->pers_firstname) ? esc($v_classRoom->pers_firstname) : '').' '.(isset($v_classRoom->pers_lastname) ? esc($v_classRoom->pers_lastname) : '') ?>
                                </td>
                                <td><button class="btn btn-danger btn-sm btn-delete" data-id="<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id, 'url') : '' ?>">ลบ</button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่ม<?= isset($title) ? esc($title) : '' ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="AddClassRoom" action="#" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">ปีการศึกษา <?php $d= (date('Y')+543)-1;?></label>
                                <select name="year" id="year" class="form-control">
                                    <?php for($i=$d; $i<=$d+2; $i++) : ?>
                                    <option <?=$i==date('Y')+543 ? 'selected' : ''?>><?= esc($i) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="classroom">ห้องเรียน / ระดับชั้น</label>
                               
                                <select name="classroom" id="classroom" class="" required>
                                    <option value="1">หัวหน้าระดับชั้น ม.1</option>
                                    <option value="2">หัวหน้าระดับชั้น ม.2</option>
                                    <option value="3">หัวหน้าระดับชั้น ม.3</option>
                                    <option value="4">หัวหน้าระดับชั้น ม.4</option>
                                    <option value="5">หัวหน้าระดับชั้น ม.5</option>
                                    <option value="6">หัวหน้าระดับชั้น ม.6</option>
                                <?php 
                                if (!isset($classroom)) {
                                    $classroom = new App\Libraries\Classroom();
                                }
                                foreach ($classroom->ListRoom() as $key => $ListRoom) : ?>                                    
                                <option value="<?= esc($ListRoom) ?>">ที่ปรึกษาห้อง <?= esc($ListRoom) ?></option>
                                <?php endforeach; ?>
                                </select>
                              
                            </div>
                            <div class="mb-3">
                                <label for="teacher">ครูที่ปรึกษา / ครูหัวหน้าระดับ</label>
                                <select name="teacher" id="teacher" class="" required >

                                    <option value=''>เลือกครูที่ปรึกษา</option>
                                    <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                               
                                    <option value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                        <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">                       
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on('submit', '#AddClassRoom', function (e) {
    e.preventDefault();
    var formadd = $('#AddClassRoom').serialize();
    $.ajax({
        type: 'post',
        url: "<?= site_url('admin/academic/ConAdminClassRoom/AddClassRoom') ?>",
        data: formadd,
        beforeSend: function () {
            console.log("กำลังโหลด");
        },
        complete: function () {
            //console.log("คือไรว่ะ");
        },
        success: function (result) {
            $('#myModal').modal('hide');
            console.log(result);
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.reload();
                }
            })

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });

});

$(document).ready(function () {

    var ta = $('#tb-classroom').DataTable({
        "order": [
            [0, "desc"],
            [1, "asc"]
        ]
    });

    $('#year').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#classroom').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#teacher').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    
});

$('#yearFilter').on('change', function() {
    var year = $(this).val();
    if(year) {
        window.location.href = '<?= site_url('Admin/Acade/Registration/ClassRoom/') ?>' + year;
    }
});

$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= site_url('admin/academic/ConAdminClassRoom/DeleteClassRoom/') ?>' + id;
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลนี้ใช่ไหม!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST', // Change to POST for delete operations with CSRF
                data: {
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(response) {
                    $('.csrf_token').val(response.csrf_hash);
                    if (response.status === 'success') {
                        Swal.fire(
                            'ลบแล้ว!',
                            response.message,
                            'success'
                        );
                        $('#row-' + id).remove();
                    } else {
                        Swal.fire(
                            'ผิดพลาด!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'เกิดข้อผิดพลาด!',
                        'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
