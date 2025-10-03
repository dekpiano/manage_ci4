<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">

                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>

            </div>
        </section>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="row justify-content-lg">
                <div class="col-12">
                    <div class="card card-settings shadow mb-4 ">

                        <div class="card-body p-4">
                            <form action="<?= site_url('admin/academic/ConAdminClassSchedule/'.(isset($action) ? esc($action, 'url') : ''));?>"
                                class="FormAddClassSchedule">
                                <input type="hidden" name="schestu_id"
                                    value="<?= isset($action) && $action == 'insert_class_schedule' ? (isset($class_schedule) ? esc($class_schedule) : '') : (isset($class_schedule[0]->schestu_id) ? esc($class_schedule[0]->schestu_id) : '') ?>">

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ข้อมูลภาคการศึกษา</legend>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_term" class="form-label">ภาคเรียน</label>
                                            <select name="schestu_term" id="schestu_term" class="form-select">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_year" class="form-label">ปีการศึกษา</label>
                                            <?php $toYear = date("Y",strtotime(date('Y')))+543;?>
                                            <select name="schestu_year" id="schestu_year" class="form-select">
                                                <?php for ($i = $toYear-2; $i <= $toYear+2; $i++): ?>
                                                <option <?=$toYear==$i?'selected':''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ข้อมูลห้องเรียน</legend>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_classname" class="form-label">ชั้น ม.</label>
                                            <select name="schestu_classname" id="schestu_classname" class="form-select">
                                                <?php $room = array('1/1'=>'1.1','1/2'=>'1.2', '1/3'=>'1.3', '1/4'=>'1.4','1/5'=>'1.5','1/6'=>'1.6', '2/1'=>'2.1', '2/2'=>'2.2', '2/3'=>'2.3', '2/4'=>'2.4','2/5'=>'2.5','2/6'=>'2.6', '3/1'=>'3.1', '3/2'=>'3.2', '3/3'=>'3.3', '3/4'=>'3.4', '4/1'=>'4.1', '4/2'=>'4.2', '4/3'=>'4.3', '4/4'=>'4.4','4/5'=>'4.5','4/6'=>'4.6', '5/1'=>'5.1', '5/2'=>'5.2', '5/3'=>'5.3', '5/4'=>'5.4','5/5'=>'5.5','5/6'=>'5.6', '6/1'=>'6.1', '6/2'=>'6.2','6/3'=>'6.3','6/4'=>'6.4');
                                                foreach ($room as $key => $v_ClassRoom): ?>
                                                <option value="<?= esc($key) ?>"><?= esc($key) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_name" class="form-label">ชื่อห้องเรียน (แผนการเรียน)</label>
                                            <?php $NameRoom = array('วิทย์-คณิต','วิทย์-เทคโน','ภาษา','การงานอาชีพ','ดนตรี-นาฏศิลป์-ศิลปะ','กีฬา'); ?>
                                            <select id="schestu_name" class="form-select" name="schestu_name">
                                                <option value="">เลือกแผนการเรียน</option>
                                                <?php foreach ($NameRoom as $key => $v_NameRoom) :?>
                                                <option value="<?= esc($v_NameRoom) ?>"><?= esc($v_NameRoom) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ไฟล์ตารางเรียน</legend>
                                    <label for="schestu_filename" class="form-label">รูป<?= isset($title) ? esc($title) : '' ?></label>
                                    <input type="file" class="form-control" name="schestu_filename" id="schestu_filename" />
                                    <div class="form-text">PNG / JPG ขนาดไฟล์ไม่เกิน 2 MB</div>
                                    <img id="previewImage" src="#" alt="Image Preview" class="img-fluid rounded mt-2" style="display:none;" />
                                </fieldset>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary"><i class="bx bx-check-circle"></i> บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>




        </div>
        <!-- /.container-fluid -->

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // แสดงภาพตัวอย่างเมื่อเลือกไฟล์
    $('#schestu_filename').on('change', function (event) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    $(document).on('submit','.FormAddClassSchedule', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var action = $(this).attr('action');

        $.ajax({
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Expect a JSON response
            success: function (response) {
                if(response && response.success){
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: "บันทึกข้อมูลตารางเรียนเรียบร้อยแล้ว",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= site_url('Admin/Acade/Course/ClassSchedule') ?>';
                        }
                    });
                } else {
                    let errorMessage = response.error || "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        text: errorMessage,
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด!",
                    text: "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง",
                    icon: "error"
                });
                console.log(("Error: " + xhr.responseText));
            }
        });
    });
</script>
<?= $this->endSection() ?>
